/**
 * Customizer Controls scripts.
 * 
 * Handles logic for Theme Presets, including Saving and Deleting custom presets,
 * and forcing the visual update of standard color picker inputs when presets are applied.
 */

(function($) {
    wp.customize.bind('ready', function() {
        
        // 1. Instant Dynamic Show/Hide for Typography Sections
        const categories = [
            'site_title', 'site_tagline', 'blog_title', 'page_title', 'headings',
            'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'body_text', 'body_links',
            'menus', 'submenus', 'sidebars', 'footer'
        ];

        categories.forEach(cat => {
            const settingName = cat + '_custom_type';
            
            // Function to toggle sub-settings based on custom_type selection
            const toggleControls = function(value) {
                const isCustom = value === 'custom';
                const suffixList = [
                    '_font_family', '_font_size', '_font_weight', '_italic', '_underline', '_color', '_link_color',
                    '_shadow_enable', '_shadow_color', '_shadow_size',
                    '_glow_enable', '_glow_color', '_glow_size',
                    '_dropcaps_enable', '_dropcaps_color', '_dropcaps_size'
                ];

                suffixList.forEach(suffix => {
                    const control = wp.customize.control(cat + suffix);
                    if (control) {
                        if (isCustom) {
                            // Sub-level visibility check for nested items
                            if (suffix === '_glow_color' || suffix === '_glow_size') {
                                const glowEnableSetting = wp.customize(cat + '_glow_enable');
                                if (glowEnableSetting && glowEnableSetting.get()) {
                                    control.show();
                                } else {
                                    control.hide();
                                }
                            } else if (suffix === '_shadow_color' || suffix === '_shadow_size') {
                                const shadowEnableSetting = wp.customize(cat + '_shadow_enable');
                                if (shadowEnableSetting && shadowEnableSetting.get()) {
                                    control.show();
                                } else {
                                    control.hide();
                                }
                            } else if (suffix === '_dropcaps_color' || suffix === '_dropcaps_size') {
                                const dropcapsEnableSetting = wp.customize(cat + '_dropcaps_enable');
                                if (dropcapsEnableSetting && dropcapsEnableSetting.get()) {
                                    control.show();
                                } else {
                                    control.hide();
                                }
                            } else {
                                control.show();
                            }
                        } else {
                            control.hide();
                        }
                    }
                });
            };

            // Run on load and bind to changes
            const setting = wp.customize(settingName);
            if (setting) {
                toggleControls(setting.get());
                setting.bind(toggleControls);
            }

            // Real-time listener for Glow, Shadow, and Dropcaps checkboxes
            ['_glow_enable', '_shadow_enable', '_dropcaps_enable'].forEach(toggleSuffix => {
                const toggleSetting = wp.customize(cat + toggleSuffix);
                if (toggleSetting) {
                    toggleSetting.bind(function(enabled) {
                        const customType = wp.customize(cat + '_custom_type').get();
                        if (customType !== 'custom') return; // let parent handle it

                        let subSuffixes = [];
                        if (toggleSuffix === '_glow_enable') subSuffixes = ['_glow_color', '_glow_size'];
                        if (toggleSuffix === '_shadow_enable') subSuffixes = ['_shadow_color', '_shadow_size'];
                        if (toggleSuffix === '_dropcaps_enable') subSuffixes = ['_dropcaps_color', '_dropcaps_size'];

                        subSuffixes.forEach(sub => {
                            const ctrl = wp.customize.control(cat + sub);
                            if (ctrl) {
                                if (enabled) ctrl.show(); else ctrl.hide();
                            }
                        });
                    });
                }
            });
        });

        // 2. Preset Application Logic
        wp.customize('theme_preset', function(value) {
            value.bind(function(newval) {
                if (newval === 'default') return;

                // Built-in Presets
                const presets = {
                    medieval: {
                        'top_bar_bg_color': '#1a1a1a', 'top_bar_text_color': '#d4af37', 'accent_gold': '#d4af37', 
                        'site_bg_color': '#0a0a0a', 'article_bg_color': '#2a2a2a',
                        'header_bg_color': '#1a1a1a', 'footer_bg_color': '#0a0a0a',
                        
                        'site_title_custom_type': 'custom', 'site_title_font_family': 'Cinzel', 'site_title_font_size': '4rem', 'site_title_color': '#ffffff', 'site_title_glow_enable': true, 'site_title_glow_color': '#d4af37',
                        'site_tagline_custom_type': 'custom', 'site_tagline_font_family': 'Almendra', 'site_tagline_font_size': '18px', 'site_tagline_color': '#d4af37',
                        'headings_custom_type': 'custom', 'headings_font_family': 'Cinzel', 'headings_color': '#ffffff',
                        'body_text_custom_type': 'custom', 'body_text_font_family': 'Lora', 'body_text_color': '#cccccc',
                        'menus_custom_type': 'custom', 'menus_font_family': 'Cinzel', 'menus_color': '#ffffff',
                        'submenus_custom_type': 'custom', 'submenus_font_family': 'Lora', 'submenus_color': '#ffffff',
                        'footer_custom_type': 'custom', 'footer_font_family': 'Lora', 'footer_color': '#ffffff'
                    },
                    modern: {
                        'top_bar_bg_color': '#007aff', 'top_bar_text_color': '#ffffff', 'accent_gold': '#007aff', 
                        'site_bg_color': '#f5f5f7', 'article_bg_color': '#ffffff',
                        'header_bg_color': '#ffffff', 'footer_bg_color': '#f5f5f7',
                        
                        'site_title_custom_type': 'custom', 'site_title_font_family': 'Montserrat', 'site_title_font_size': '2rem', 'site_title_color': '#000000',
                        'site_tagline_custom_type': 'custom', 'site_tagline_font_family': 'Open Sans', 'site_tagline_font_size': '14px', 'site_tagline_color': '#666666',
                        'headings_custom_type': 'custom', 'headings_font_family': 'Montserrat', 'headings_color': '#000000',
                        'body_text_custom_type': 'custom', 'body_text_font_family': 'Open Sans', 'body_text_color': '#333333',
                        'menus_custom_type': 'custom', 'menus_font_family': 'Montserrat', 'menus_color': '#000000',
                        'submenus_custom_type': 'custom', 'submenus_font_family': 'Open Sans', 'submenus_color': '#333333'
                    },
                    dark: {
                        'top_bar_bg_color': '#000000', 'top_bar_text_color': '#d4af37', 'accent_gold': '#d4af37', 
                        'site_bg_color': '#000000', 'header_bg_color': '#000000', 'footer_bg_color': '#000000', 'article_bg_color': '#111111',
                        
                        'site_title_custom_type': 'custom', 'site_title_font_family': 'Cinzel', 'site_title_font_size': '3rem', 'site_title_color': '#d4af37',
                        'headings_custom_type': 'custom', 'headings_font_family': 'Cinzel', 'headings_color': '#ffffff',
                        'body_text_custom_type': 'custom', 'body_text_font_family': 'Lora', 'body_text_color': '#aaaaaa'
                    },
                    monochrome: {
                        'top_bar_bg_color': '#333333', 'top_bar_text_color': '#ffffff', 'accent_gold': '#666666', 
                        'site_bg_color': '#ffffff', 'article_bg_color': '#f9f9f9',
                        
                        'site_title_custom_type': 'custom', 'site_title_font_family': 'Cinzel', 'site_title_color': '#000000',
                        'headings_custom_type': 'custom', 'headings_font_family': 'Cinzel', 'headings_color': '#000000',
                        'body_text_custom_type': 'custom', 'body_text_font_family': 'Lora', 'body_text_color': '#333333'
                    },
                    high_contrast: {
                        'top_bar_bg_color': '#ffff00', 'top_bar_text_color': '#000000', 'accent_gold': '#ffff00', 
                        'site_bg_color': '#000000', 'header_bg_color': '#000000', 'footer_bg_color': '#000000', 'article_bg_color': '#000000',
                        
                        'site_title_custom_type': 'custom', 'site_title_font_family': 'Montserrat', 'site_title_color': '#ffffff', 'site_title_font_size': '3.5rem',
                        'headings_custom_type': 'custom', 'headings_font_family': 'Montserrat', 'headings_color': '#ffffff',
                        'body_text_custom_type': 'custom', 'body_text_font_family': 'Open Sans', 'body_text_color': '#ffffff', 'body_text_font_size': '22px'
                    }
                };

                const customData = JSON.parse(wp.customize('custom_presets_data').get() || '{}');
                const allPresets = { ...presets, ...customData };
                const data = allPresets[newval];
                if (!data) return;

                Object.keys(data).forEach(key => {
                    if (key !== 'name' && wp.customize(key)) {
                        wp.customize(key).set(data[key]);

                        // Force update the UI for color picker controls to show the current/new preset colors
                        const control = wp.customize.control(key);
                        if (control && control.container) {
                            const $picker = control.container.find('.wp-color-picker');
                            if ($picker.length && $.fn.wpColorPicker) {
                                $picker.wpColorPicker('color', data[key]);
                            }
                        }
                    }
                });
            });
        });

        // 3. Inject Save/Delete Buttons
        const $container = $('#customize-control-new_preset_name');
        if ($container.length) {
            $container.append(`
                <div style="margin-top: 10px; display: flex; gap: 10px;">
                    <button type="button" class="button button-primary" id="ak-save-preset">💾 Save Current</button>
                    <button type="button" class="button" id="ak-delete-preset" style="color: #d63638; border-color: #d63638;">🗑️ Delete Selected</button>
                </div>
            `);
        }

        // 4. Save Logic
        $(document).on('click', '#ak-save-preset', function() {
            const name = wp.customize('new_preset_name').get();
            if (!name) { alert('Please enter a name.'); return; }
            const id = 'custom_' + Date.now();
            const currentData = {};
            const settingsToCapture = [
                'top_bar_bg_color', 'top_bar_text_color', 'accent_gold', 'site_bg_color', 'article_bg_color', 'header_bg_color', 'menu_bg_color', 'submenu_bg_color', 'footer_bg_color', 'sidebar_bg_color', 'sidebar_border_color',
                'container_width', 'header_padding', 'menu_spacing', 'sidebar_padding'
            ];
            categories.forEach(cat => {
                settingsToCapture.push(
                    `${cat}_custom_type`, `${cat}_font_family`, `${cat}_font_size`, `${cat}_font_weight`, `${cat}_italic`, `${cat}_underline`, `${cat}_color`, `${cat}_link_color`,
                    `${cat}_shadow_enable`, `${cat}_shadow_color`, `${cat}_shadow_size`,
                    `${cat}_glow_enable`, `${cat}_glow_color`, `${cat}_glow_size`,
                    `${cat}_dropcaps_enable`, `${cat}_dropcaps_color`, `${cat}_dropcaps_size`
                );
            });
            settingsToCapture.forEach(key => { if (wp.customize(key)) currentData[key] = wp.customize(key).get(); });
            currentData.name = name;
            const customPresets = JSON.parse(wp.customize('custom_presets_data').get() || '{}');
            customPresets[id] = currentData;
            wp.customize('custom_presets_data').set(JSON.stringify(customPresets));
            location.reload(); 
        });

        // 5. Delete Logic
        $(document).on('click', '#ak-delete-preset', function() {
            const selected = wp.customize('theme_preset').get();
            if (!selected.startsWith('custom_')) { alert('Select a custom preset to delete.'); return; }
            if (!confirm('Delete this preset?')) return;
            const customPresets = JSON.parse(wp.customize('custom_presets_data').get() || '{}');
            delete customPresets[selected];
            wp.customize('custom_presets_data').set(JSON.stringify(customPresets));
            wp.customize('theme_preset').set('default');
            location.reload();
        });
    });
})(jQuery);
