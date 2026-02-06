/**
 * Customizer Controls scripts.
 * 
 * Handles the logic for Theme Presets.
 */

(function($) {
    $(function() {
        wp.customize('theme_preset', function(value) {
            value.bind(function(newval) {
                if (newval === 'default') return;

                const presets = {
                    medieval: {
                        // Colors
                        'primary_accent': '#3a3a3a',
                        'accent_gold': '#d4af37',
                        'site_bg_color': '#1a1a1a',
                        'header_bg_color': '#2a2a2a',
                        'menu_bg_color': 'transparent',
                        'submenu_bg_color': '#2a2a2a',
                        'footer_bg_color': '#1a1a1a',
                        'sidebar_bg_color': '#2a2a2a',
                        'sidebar_border_color': '#d4af37',
                        // Fonts
                        'site_title_font_family': 'Cinzel',
                        'site_tagline_font_family': 'Almendra',
                        'headings_font_family': 'Cinzel',
                        'body_font_family': 'Lora',
                        'menus_font_family': 'Cinzel',
                        // Sizes
                        'site_title_font_size': '3.5rem',
                        'h1_font_size': '64px',
                        // Effects
                        'site_title_glow_enable': true,
                        'site_title_glow_color': '#d4af37',
                        'site_title_color': '#ffffff'
                    },
                    modern: {
                        'primary_accent': '#000000',
                        'accent_gold': '#007aff',
                        'site_bg_color': '#ffffff',
                        'header_bg_color': '#f5f5f7',
                        'menu_bg_color': 'transparent',
                        'footer_bg_color': '#f5f5f7',
                        'site_title_font_family': 'Montserrat',
                        'site_tagline_font_family': 'Open Sans',
                        'headings_font_family': 'Montserrat',
                        'body_font_family': 'Open Sans',
                        'menus_font_family': 'Montserrat',
                        'site_title_font_size': '2rem',
                        'site_title_color': '#000000',
                        'site_title_shadow_enable': false,
                        'site_title_glow_enable': false
                    },
                    dark: {
                        'primary_accent': '#d4af37',
                        'accent_gold': '#d4af37',
                        'site_bg_color': '#000000',
                        'header_bg_color': '#111111',
                        'footer_bg_color': '#111111',
                        'sidebar_bg_color': '#111111',
                        'body_color': '#cccccc',
                        'headings_color': '#ffffff',
                        'site_title_color': '#d4af37'
                    },
                    monochrome: {
                        'primary_accent': '#333333',
                        'accent_gold': '#666666',
                        'site_bg_color': '#ffffff',
                        'header_bg_color': '#eeeeee',
                        'footer_bg_color': '#333333',
                        'link_color': '#000000',
                        'link_hover_color': '#666666',
                        'site_title_color': '#000000',
                        'accent_gold': '#333333'
                    },
                    high_contrast: {
                        'primary_accent': '#ffff00',
                        'accent_gold': '#ffff00',
                        'site_bg_color': '#000000',
                        'body_color': '#ffffff',
                        'headings_color': '#ffffff',
                        'link_color': '#ffff00',
                        'site_title_color': '#ffffff',
                        'body_font_size': '20px'
                    }
                };

                const data = presets[newval];
                if (!data) return;

                // Apply all settings in the preset
                Object.keys(data).forEach(key => {
                    if (wp.customize(key)) {
                        wp.customize(key).set(data[key]);
                    }
                });
            });
        });
    });
})(jQuery);
