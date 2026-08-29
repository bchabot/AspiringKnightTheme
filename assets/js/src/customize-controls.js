/**
 * Customizer Controls scripts.
 * 
 * Handles logic for Theme Presets, including Saving and Deleting custom presets,
 * and forcing the visual update of standard color picker inputs when presets are applied.
 */

(function($) {
    wp.customize.bind('ready', function() {
        
        // 1. Preset Application Logic
        wp.customize('theme_preset', function(value) {
            value.bind(function(newval) {
                if (newval === 'default') return;

                // Built-in Presets
                const presets = {
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

        // 2. Inject Save/Delete Buttons
        const $container = $('#customize-control-new_preset_name');
        if ($container.length) {
            $container.append(`
                <div style="margin-top: 10px; display: flex; gap: 10px;">
                    <button type="button" class="button button-primary" id="ak-save-preset">💾 Save Current</button>
                    <button type="button" class="button" id="ak-delete-preset" style="color: #d63638; border-color: #d63638;">🗑️ Delete Selected</button>
                </div>
            `);
        }

        // 3. Save Logic
        $(document).on('click', '#ak-save-preset', function() {
            if (typeof wp === 'undefined' || !wp.customize) return;
            const name = wp.customize('new_preset_name').get();
            if (!name) { alert('Please enter a name.'); return; }
            const id = 'custom_' + Date.now();
            const currentData = {};
            const settingsToCapture = [
                'top_bar_bg_color', 'top_bar_text_color', 'accent_gold', 'site_bg_color', 'article_bg_color', 'header_bg_color', 'menu_bg_color', 'submenu_bg_color', 'footer_bg_color', 'sidebar_bg_color', 'sidebar_border_color',
                'container_width', 'header_padding', 'menu_spacing', 'sidebar_padding'
            ];
            const categories = [
                'site_title', 'site_tagline', 'blog_title', 'page_title', 'headings',
                'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'body_text', 'body_links',
                'menus', 'submenus', 'sidebars', 'footer'
            ];
            categories.forEach(cat => {
                settingsToCapture.push(
                    `${cat}_font_family`, `${cat}_font_size`, `${cat}_font_weight`, `${cat}_italic`, `${cat}_underline`, `${cat}_color`, `${cat}_link_color`,
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

        // 4. Delete Logic
        $(document).on('click', '#ak-delete-preset', function() {
            if (typeof wp === 'undefined' || !wp.customize) return;
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