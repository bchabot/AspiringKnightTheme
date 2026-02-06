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

                const presets = {
                    medieval: {
                        'primary_accent': '#3a3a3a', 'accent_gold': '#d4af37', 'site_bg_color': '#1a1a1a', 
                        'content_bg_color': '#2a2a2a', 'header_bg_color': '#3a3a3a', 'footer_bg_color': '#1a1a1a',
                        'site_title_font_family': 'Cinzel', 'site_tagline_font_family': 'Almendra', 'headings_font_family': 'Cinzel',
                        'body_font_family': 'Lora', 'menus_font_family': 'Cinzel', 'blog_titles_font_family': 'Almendra',
                        'site_title_font_size': '4rem', 'h1_font_size': '72px', 'h2_font_size': '54px',
                        'site_title_glow_enable': true, 'site_title_glow_color': '#d4af37', 'site_title_color': '#ffffff',
                        'blog_titles_color': '#d4af37', 'headings_color': '#ffffff', 'body_color': '#cccccc',
                        'link_underline': false
                    },
                    modern: {
                        'primary_accent': '#007aff', 'accent_gold': '#007aff', 'site_bg_color': '#f5f5f7', 
                        'content_bg_color': '#ffffff', 'header_bg_color': '#ffffff', 'footer_bg_color': '#f5f5f7',
                        'site_title_font_family': 'Montserrat', 'site_tagline_font_family': 'Open Sans', 'headings_font_family': 'Montserrat',
                        'body_font_family': 'Open Sans', 'menus_font_family': 'Montserrat',
                        'site_title_font_size': '2rem', 'site_title_color': '#000000', 'body_color': '#333333',
                        'site_title_shadow_enable': false, 'site_title_glow_enable': false,
                        'link_underline': true
                    },
                    dark: {
                        'primary_accent': '#d4af37', 'accent_gold': '#d4af37', 'site_bg_color': '#000000', 
                        'content_bg_color': '#111111', 'header_bg_color': '#000000', 'footer_bg_color': '#000000',
                        'body_color': '#aaaaaa', 'headings_color': '#ffffff', 'site_title_color': '#d4af37',
                        'blog_titles_color': '#ffffff', 'menus_color': '#ffffff', 'sidebar_bg_color': '#111111'
                    },
                    monochrome: {
                        'primary_accent': '#333333', 'accent_gold': '#666666', 'site_bg_color': '#ffffff', 
                        'content_bg_color': '#f9f9f9', 'header_bg_color': '#333333', 'footer_bg_color': '#333333',
                        'site_title_color': '#ffffff', 'body_color': '#333333', 'headings_color': '#000000',
                        'site_title_font_family': 'Lora', 'headings_font_family': 'Lora'
                    },
                    high_contrast: {
                        'primary_accent': '#ffff00', 'accent_gold': '#ffff00', 'site_bg_color': '#000000', 
                        'content_bg_color': '#000000', 'header_bg_color': '#000000', 'footer_bg_color': '#000000',
                        'body_color': '#ffffff', 'headings_color': '#ffffff', 'link_color': '#ffff00', 
                        'site_title_color': '#ffffff', 'body_font_size': '22px'
                    }
                };

                const customData = JSON.parse(wp.customize('custom_presets_data').get() || '{}');
                const allPresets = { ...presets, ...customData };
                const data = allPresets[newval];
                if (!data) return;

                Object.keys(data).forEach(key => {
                    if (key !== 'name' && wp.customize(key)) {
                        wp.customize(key).set(data[key]);
                    }
                });
            });
        });

        // 2. Save/Delete UI
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
            if (!name) { alert('Please enter a name.'); return; }
            const id = 'custom_' + Date.now();
            const currentData = {};
            const settingsToCapture = [
                'primary_accent', 'accent_gold', 'site_bg_color', 'content_bg_color', 'header_bg_color', 'menu_bg_color', 'submenu_bg_color', 'footer_bg_color', 'sidebar_bg_color', 'sidebar_border_color',
                'container_width', 'header_padding', 'menu_spacing', 'sidebar_padding'
            ];
            ['site_title', 'site_tagline', 'menus', 'submenus', 'blog_titles', 'headings', 'sidebars', 'footer', 'body'].forEach(cat => {
                settingsToCapture.push(`${cat}_font_family`, `${cat}_font_size`, `${cat}_color`, `${cat}_link_color`, `${cat}_underline`, `${cat}_shadow_enable`, `${cat}_shadow_color`, `${cat}_glow_enable`, `${cat}_glow_color`);
            });
            for(let i=1; i<=6; i++) settingsToCapture.push(`h${i}_font_size`);
            settingsToCapture.forEach(key => { if (wp.customize(key)) currentData[key] = wp.customize(key).get(); });
            currentData.name = name;
            const customPresets = JSON.parse(wp.customize('custom_presets_data').get() || '{}');
            customPresets[id] = currentData;
            wp.customize('custom_presets_data').set(JSON.stringify(customPresets));
            location.reload(); 
        });

        // 4. Delete Logic
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
