/**
 * Customizer Controls scripts.
 * 
 * Handles logic for Theme Presets, including Saving and Deleting custom presets,
 * forcing the visual update of standard color picker inputs when presets are applied,
 * and performing nested customizer sections reflowing.
 */

// Global nonces and AJAX URL from wp_localize_script
var akRestoreFontsNonce = (typeof akCustomizer !== 'undefined') ? akCustomizer.restoreFontsNonce : '';
var akRestoreSectionNonce = (typeof akCustomizer !== 'undefined') ? akCustomizer.restoreSectionNonce : '';
var akAjaxUrl = (typeof akCustomizer !== 'undefined') ? akCustomizer.ajaxurl : '/wp-admin/admin-ajax.php';

(function($) {
    if (typeof wp === 'undefined' || !wp.customize) return;

    // Helper: get the <li> headContainer for a section ID, or null
    function getSectionHead(sectionId) {
        var section = wp.customize.section(sectionId);
        return section && section.headContainer ? section.headContainer : null;
    }

    // 1. Nested Sections Reflow Logic
    var isReflowing = false;

    function doReflow() {
        if (isReflowing) return;
        isReflowing = true;

        var nestedSections = [];
        wp.customize.section.each(function(section) {
            if (section.params.type === 'aspiring_knight_nested_section' && section.params.section) {
                nestedSections.push(section);
            }
        });

        nestedSections.sort(wp.customize.utils.prioritySort).reverse();

        $.each(nestedSections, function(i, section) {
            var $parentHead = getSectionHead(section.params.section);
            if ($parentHead && $parentHead.length && !$parentHead[0].contains(section.headContainer[0])) {
                var $content = $parentHead.children('.accordion-section-content');
                if ($content.length) {
                    $content.prepend(section.headContainer);
                }
            }
        });

        isReflowing = false;
    }

    wp.customize.bind('pane-contents-reflowed', doReflow);

    wp.customize.bind('ready', function() {

        // Run reflow immediately and with retry to catch DOM readiness
        doReflow();
        setTimeout(doReflow, 200);
        setTimeout(doReflow, 500);

        // 1b. Initialize all color pickers with their current saved values
        wp.customize.control.each(function(control) {
            if (control.setting && control.setting.id && control.container) {
                var $input = control.container.find('.wp-color-picker');
                if ($input.length) {
                    var currentVal = control.setting.get();
                    if (currentVal) {
                        $input.val(currentVal).trigger('change');
                        if ($.fn.wpColorPicker) {
                            $input.wpColorPicker('color', currentVal);
                        }
                    }
                }
            }
        });

        // 1c. Default/Custom Mode Toggle Logic
        var typoModeSections = [
            'ds_header_section',
            'ds_blog_title_section',
            'ds_page_title_section',
            'ds_headings_section',
            'ds_body_text_section',
            'ds_body_links_section',
            'ds_sidebar_typo_section',
            'ds_footer_typo_section'
        ];

        // Map parent sections to their child/grandchild sections
        var sectionHierarchy = {
            'ds_header_section': ['ds_site_title_section', 'ds_site_tagline_section'],
            'ds_headings_section': ['ds_h1_section', 'ds_h2_section', 'ds_h3_section', 'ds_h4_section', 'ds_h5_section', 'ds_h6_section'],
            'ds_custom_fonts_section': [],
            'ds_sidebar_typo_section': [],
            'ds_footer_typo_section': []
        };

        function toggleTypoSectionControls(sectionId) {
            var modeSetting = sectionId + '_mode';
            if (!wp.customize(modeSetting)) return;

            var mode = wp.customize(modeSetting).get();
            var $sectionHead = getSectionHead(sectionId);
            if (!$sectionHead) return;

            // Find all controls in this section (excluding the mode radio itself)
            $sectionHead.find('.customize-control').each(function() {
                var $control = $(this);
                var controlSetting = $control.find('[data-customize-setting-link]').attr('data-customize-setting-link');

                if (controlSetting === modeSetting) return;

                if (mode === 'default') {
                    $control.hide();
                } else {
                    $control.show();
                }
            });

            if (sectionHierarchy[sectionId]) {
                sectionHierarchy[sectionId].forEach(function(childSectionId) {
                    var $childHead = getSectionHead(childSectionId);
                    if ($childHead && $childHead.length) {
                        if (mode === 'default') {
                            $childHead.hide();
                        } else {
                            $childHead.show();
                        }
                    }
                });
            }
        }

        // Initialize toggle after reflow has had time to nest DOM
        setTimeout(function() {
            typoModeSections.forEach(function(sectionId) {
                toggleTypoSectionControls(sectionId);

                var modeSetting = sectionId + '_mode';
                if (wp.customize(modeSetting)) {
                    wp.customize(modeSetting, function(value) {
                        value.bind(function() {
                            toggleTypoSectionControls(sectionId);
                        });
                    });
                }
            });
        }, 600);

        // 1d. Back Navigation Buttons for Nested Sections
        function addBackButtons() {
            wp.customize.section.each(function(section) {
                if (section.params && section.params.section && section.headContainer && !section.headContainer.find('.ak-back-btn').length) {
                    var $sectionTitle = section.headContainer.find('.accordion-section-title');
                    if ($sectionTitle.length) {
                        var $backBtn = $('<button type="button" class="customize-section-back ak-back-btn" title="Back"><span class="dashicons dashicons-arrow-left-alt2"></span></button>');
                        $backBtn.css({ 'position': 'absolute', 'left': '0', 'top': '0', 'padding': '10px 12px', 'z-index': '10', 'background': 'none', 'border': 'none', 'cursor': 'pointer', 'line-height': '1', 'color': '#1d2327' });
                        $sectionTitle.prepend($backBtn);
                        $backBtn.on('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            wp.customize.section(section.params.section).expand();
                        });
                    }
                }
            });
        }
        setTimeout(addBackButtons, 600);
        wp.customize.bind('pane-contents-reflowed', function() {
            setTimeout(addBackButtons, 100);
        });

        // 2. Preset Application Logic
        wp.customize('theme_preset', function(value) {
            value.bind(function(newval) {
                if (newval === 'default') return;

                // Built-in Presets
                var presets = {
                    medieval: {
                        'top_bar_bg_color': '#1a1a1a', 'top_bar_text_color': '#d4af37', 'accent_gold': '#d4af37', 
                        'site_bg_color': '#0a0a0a', 'article_bg_color': '#2a2a2a',
                        'header_bg_color': '#1a1a1a', 'footer_bg_color': '#0a0a0a',
                        
                        'site_title_font_family': 'Cinzel', 'site_title_font_size': '4rem', 'site_title_color': '#ffffff', 'site_title_glow_enable': true, 'site_title_glow_color': '#d4af37',
                        'site_tagline_font_family': 'Almendra', 'site_tagline_font_size': '18px', 'site_tagline_color': '#d4af37',
                        'headings_font_family': 'Cinzel', 'headings_color': '#ffffff',
                        'body_text_font_family': 'Lora', 'body_text_color': '#cccccc',
                        'menus_font_family': 'Cinzel', 'menus_color': '#ffffff',
                        'submenus_font_family': 'Lora', 'submenus_color': '#ffffff',
                        'footer_font_family': 'Lora', 'footer_color': '#ffffff'
                    },
                    modern: {
                        'top_bar_bg_color': '#007aff', 'top_bar_text_color': '#ffffff', 'accent_gold': '#007aff', 
                        'site_bg_color': '#f5f5f7', 'article_bg_color': '#ffffff',
                        'header_bg_color': '#ffffff', 'footer_bg_color': '#f5f5f7',
                        
                        'site_title_font_family': 'Montserrat', 'site_title_font_size': '2rem', 'site_title_color': '#000000',
                        'site_tagline_font_family': 'Open Sans', 'site_tagline_font_size': '14px', 'site_tagline_color': '#666666',
                        'headings_font_family': 'Montserrat', 'headings_color': '#000000',
                        'body_text_font_family': 'Open Sans', 'body_text_color': '#333333',
                        'menus_font_family': 'Montserrat', 'menus_color': '#000000',
                        'submenus_font_family': 'Open Sans', 'submenus_color': '#333333'
                    },
                    dark: {
                        'top_bar_bg_color': '#000000', 'top_bar_text_color': '#d4af37', 'accent_gold': '#d4af37', 
                        'site_bg_color': '#000000', 'header_bg_color': '#000000', 'footer_bg_color': '#000000', 'article_bg_color': '#111111',
                        
                        'site_title_font_family': 'Cinzel', 'site_title_font_size': '3rem', 'site_title_color': '#d4af37',
                        'headings_font_family': 'Cinzel', 'headings_color': '#ffffff',
                        'body_text_font_family': 'Lora', 'body_text_color': '#aaaaaa'
                    },
                    monochrome: {
                        'top_bar_bg_color': '#333333', 'top_bar_text_color': '#ffffff', 'accent_gold': '#666666', 
                        'site_bg_color': '#ffffff', 'article_bg_color': '#f9f9f9',
                        
                        'site_title_font_family': 'Cinzel', 'site_title_color': '#000000',
                        'headings_font_family': 'Cinzel', 'headings_color': '#000000',
                        'body_text_font_family': 'Lora', 'body_text_color': '#333333'
                    },
                    high_contrast: {
                        'top_bar_bg_color': '#ffff00', 'top_bar_text_color': '#000000', 'accent_gold': '#ffff00', 
                        'site_bg_color': '#000000', 'header_bg_color': '#000000', 'footer_bg_color': '#000000', 'article_bg_color': '#000000',
                        
                        'site_title_font_family': 'Montserrat', 'site_title_color': '#ffffff', 'site_title_font_size': '3.5rem',
                        'headings_font_family': 'Montserrat', 'headings_color': '#ffffff',
                        'body_text_font_family': 'Open Sans', 'body_text_color': '#ffffff', 'body_text_font_size': '22px'
                    }
                };

                var customData = {};
                try { customData = JSON.parse(wp.customize('custom_presets_data').get() || '{}'); } catch(e) { customData = {}; }
                var allPresets = $.extend({}, presets, customData);
                var data = allPresets[newval];
                if (!data) return;

                Object.keys(data).forEach(function(key) {
                    if (key !== 'name' && wp.customize(key)) {
                        wp.customize(key).set(data[key]);

                        var control = wp.customize.control(key);
                        if (control && control.container) {
                            var $picker = control.container.find('.wp-color-picker');
                            if ($picker.length && $.fn.wpColorPicker) {
                                $picker.wpColorPicker('color', data[key]);
                            }
                        }
                    }
                });

                wp.customize('theme_preset').set('default');
            });
        });

        // 3. Inject Save/Delete Buttons
        var $container = $('#customize-control-new_preset_name');
        if ($container.length) {
            $container.append(
                '<div style="margin-top: 10px; display: flex; gap: 10px;">' +
                    '<button type="button" class="button button-primary" id="ak-save-preset">Save Current</button>' +
                    '<button type="button" class="button" id="ak-delete-preset" style="color: #d63638; border-color: #d63638;">Delete Selected</button>' +
                '</div>'
            );
        }

        // 4. Save Logic
        $(document).on('click', '#ak-save-preset', function() {
            if (typeof wp === 'undefined' || !wp.customize) return;
            var name = wp.customize('new_preset_name').get();
            if (!name) { alert('Please enter a name.'); return; }
            var id = 'custom_' + Date.now();
            var currentData = {};
            var settingsToCapture = [
                'top_bar_bg_color', 'top_bar_text_color', 'accent_gold', 'site_bg_color', 'article_bg_color', 'header_bg_color', 'menu_bg_color', 'submenu_bg_color', 'footer_bg_color', 'sidebar_bg_color', 'sidebar_border_color',
                'container_width', 'header_padding', 'menu_spacing', 'sidebar_padding',
                'custom_google_font', 'custom_font_name', 'custom_font_file', 'use_custom_font_headings'
            ];
            var categories = [
                'site_title', 'site_tagline', 'blog_title', 'page_title', 'headings',
                'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'body_text', 'body_links',
                'menus', 'submenus', 'sidebars', 'footer'
            ];

            var typoSections = [
                'ds_header_section', 'ds_blog_title_section', 'ds_page_title_section',
                'ds_headings_section', 'ds_body_text_section', 'ds_body_links_section',
                'ds_sidebar_typo_section', 'ds_footer_typo_section'
            ];
            typoSections.forEach(function(section) {
                settingsToCapture.push(section + '_mode');
            });
            categories.forEach(function(cat) {
                settingsToCapture.push(
                    cat + '_font_family', cat + '_font_size', cat + '_font_weight', cat + '_italic', cat + '_underline', cat + '_color', cat + '_link_color',
                    cat + '_shadow_enable', cat + '_shadow_color', cat + '_shadow_size',
                    cat + '_glow_enable', cat + '_glow_color', cat + '_glow_size',
                    cat + '_dropcaps_enable', cat + '_dropcaps_color', cat + '_dropcaps_size'
                );
            });
            settingsToCapture.forEach(function(key) { if (wp.customize(key)) currentData[key] = wp.customize(key).get(); });
            currentData.name = name;
            var customPresets = {};
            try { customPresets = JSON.parse(wp.customize('custom_presets_data').get() || '{}'); } catch(e) { customPresets = {}; }
            customPresets[id] = currentData;
            wp.customize('custom_presets_data').set(JSON.stringify(customPresets));
            location.reload(); 
        });

        // 5. Delete Logic
        $(document).on('click', '#ak-delete-preset', function() {
            if (typeof wp === 'undefined' || !wp.customize) return;
            var selected = wp.customize('theme_preset').get();
            if (!selected.startsWith('custom_')) { alert('Select a custom preset to delete.'); return; }
            if (!confirm('Delete this preset?')) return;
            var customPresets = {};
            try { customPresets = JSON.parse(wp.customize('custom_presets_data').get() || '{}'); } catch(e) { customPresets = {}; }
            delete customPresets[selected];
            wp.customize('custom_presets_data').set(JSON.stringify(customPresets));
            wp.customize('theme_preset').set('default');
            location.reload();
        });

        // 6. Restore Default Fonts Logic
        $(document).on('change', '#customize-control-restore_default_fonts input[type="checkbox"]', function() {
            if ($(this).is(':checked')) {
                if (confirm('This will reset ALL font settings to defaults. Are you sure?')) {
                    $.ajax({
                        url: akAjaxUrl,
                        type: 'POST',
                        data: {
                            action: 'ak_restore_fonts',
                            ak_restore_fonts_nonce: akRestoreFontsNonce
                        },
                        success: function(response) {
                            if (response.success) {
                                location.reload();
                            }
                        }
                    });
                } else {
                    $(this).prop('checked', false);
                }
            }
        });

        // 7. Per-Section Restore Defaults Logic
        $(document).on('click', '.ak-restore-section-btn', function(e) {
            e.preventDefault();
            var sectionId = $(this).data('section-id');
            if (!sectionId) return;
            if (!confirm('Reset all typography settings in this section to defaults?')) return;

            $.ajax({
                url: akAjaxUrl,
                type: 'POST',
                data: {
                    action: 'ak_restore_section_defaults',
                    section_id: sectionId,
                    ak_restore_section_nonce: akRestoreSectionNonce
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + (response.data ? response.data.message : 'Unknown error'));
                    }
                }
            });
        });
    });
})(jQuery);
