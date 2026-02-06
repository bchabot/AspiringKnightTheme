/**
 * Customizer Controls scripts.
 * 
 * Handles logic for Theme Presets, including Saving and Deleting custom presets.
 */

(function($) {
    $(function() {
        // 1. Preset Application Logic
        wp.customize('theme_preset', function(value) {
            value.bind(function(newval) {
                if (newval === 'default') return;

                // Built-in Presets
                const presets = {
                    medieval: {
                        'primary_accent': '#3a3a3a', 'accent_gold': '#d4af37', 'site_bg_color': '#1a1a1a', 'header_bg_color': '#2a2a2a',
                        'site_title_font_family': 'Cinzel', 'site_tagline_font_family': 'Almendra', 'headings_font_family': 'Cinzel',
                        'site_title_font_size': '3.5rem', 'h1_font_size': '64px', 'site_title_glow_enable': true
                    },
                    modern: {
                        'primary_accent': '#000000', 'accent_gold': '#007aff', 'site_bg_color': '#ffffff', 'header_bg_color': '#f5f5f7',
                        'site_title_font_family': 'Montserrat', 'site_tagline_font_family': 'Open Sans', 'site_title_color': '#000000'
                    },
                    dark: {
                        'primary_accent': '#d4af37', 'site_bg_color': '#000000', 'header_bg_color': '#111111', 'body_color': '#cccccc'
                    },
                    monochrome: {
                        'primary_accent': '#333333', 'accent_gold': '#666666', 'site_bg_color': '#ffffff', 'site_title_color': '#000000'
                    },
                    high_contrast: {
                        'primary_accent': '#ffff00', 'site_bg_color': '#000000', 'body_color': '#ffffff', 'body_font_size': '20px'
                    }
                };

                // Load custom presets from data setting
                const customData = JSON.parse(wp.customize('custom_presets_data').get() || '{}');
                const allPresets = { ...presets, ...customData };

                const data = allPresets[newval];
                if (!data) return;

                // Apply settings
                Object.keys(data).forEach(key => {
                    if (key !== 'name' && wp.customize(key)) {
                        wp.customize(key).set(data[key]);
                    }
                });
            });
        });

        // 2. Inject Save/Delete Buttons into the UI
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
            const name = wp.customize('new_preset_name').get();
            if (!name) {
                alert('Please enter a name for your preset.');
                return;
            }

            const id = 'custom_' + Date.now();
            const currentData = {};
            
            // List of settings to capture (all our custom ones)
            const settingsToCapture = [
                'primary_accent', 'accent_gold', 'site_bg_color', 'header_bg_color', 'menu_bg_color', 'submenu_bg_color', 'footer_bg_color', 'sidebar_bg_color', 'sidebar_border_color',
                'container_width', 'header_padding', 'menu_spacing', 'sidebar_padding'
            ];
            
            // Add categorical settings
            ['site_title', 'site_tagline', 'menus', 'submenus', 'page_titles', 'headings', 'sidebars', 'footer', 'body'].forEach(cat => {
                settingsToCapture.push(`${cat}_font_family`, `${cat}_font_size`, `${cat}_color`, `${cat}_link_color`, `${cat}_underline`, `${cat}_shadow_enable`, `${cat}_shadow_color`, `${cat}_glow_enable`, `${cat}_glow_color`);
            });
            // Add heading specific sizes
            for(let i=1; i<=6; i++) settingsToCapture.push(`h${i}_font_size`);

            settingsToCapture.forEach(key => {
                if (wp.customize(key)) {
                    currentData[key] = wp.customize(key).get();
                }
            });

            currentData.name = name;

            // Update the hidden JSON setting
            const customPresets = JSON.parse(wp.customize('custom_presets_data').get() || '{}');
            customPresets[id] = currentData;
            
            wp.customize('custom_presets_data').set(JSON.stringify(customPresets));
            
            alert('Preset "' + name + '" saved! Please Publish to keep changes.');
            location.reload(); // Refresh Customizer to update dropdown choices
        });

        // 4. Delete Logic
        $(document).on('click', '#ak-delete-preset', function() {
            const selected = wp.customize('theme_preset').get();
            if (!selected.startsWith('custom_')) {
                alert('You can only delete custom presets.');
                return;
            }

            if (!confirm('Are you sure you want to delete this preset?')) return;

            const customPresets = JSON.parse(wp.customize('custom_presets_data').get() || '{}');
            delete customPresets[selected];
            
            wp.customize('custom_presets_data').set(JSON.stringify(customPresets));
            wp.customize('theme_preset').set('default');
            
            alert('Preset deleted. Please Publish to keep changes.');
            location.reload();
        });
    });
})(jQuery);