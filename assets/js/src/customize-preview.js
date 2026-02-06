/**
 * Customizer Live Preview scripts.
 * 
 * GUARANTEED RE-MAPPING FOR ALL BACKGROUNDS
 */

(function($) {
    const updateCSSVar = (name, value) => {
        document.documentElement.style.setProperty(name, value);
    };

    // 1. Precise Color Mapping (No more auto-guessing)
    const colorMap = {
        'top_bar_bg_color': '--ak-top-bar-bg',
        'top_bar_text_color': '--ak-top-bar-text',
        'accent_gold': '--ak-accent-gold',
        'site_bg_color': '--ak-site-bg',
        'article_bg_color': '--ak-article-bg',
        'header_bg_color': '--ak-header-bg',
        'menu_bg_color': '--ak-menu-bg',
        'submenu_bg_color': '--ak-submenu-bg',
        'footer_bg_color': '--ak-footer-bg',
        'sidebar_bg_color': '--ak-sidebar-bg',
        'sidebar_border_color': '--ak-sidebar-border'
    };

    Object.keys(colorMap).forEach(id => {
        wp.customize(id, value => {
            value.bind(to => {
                updateCSSVar(colorMap[id], to);
            });
        });
    });

    // 2. Images
    wp.customize('background_image', value => value.bind(to => updateCSSVar('--ak-site-bg-image', to ? `url(${to})` : 'none')));
    wp.customize('article_bg_image', value => value.bind(to => updateCSSVar('--ak-article-bg-image', to ? `url(${to})` : 'none')));

    // 3. Layout & Spacing
    wp.customize('container_width', value => value.bind(to => updateCSSVar('--ak-container-width', to)));
    wp.customize('header_padding', value => value.bind(to => updateCSSVar('--ak-header-padding', to)));
    wp.customize('menu_spacing', value => value.bind(to => updateCSSVar('--ak-menu-spacing', to)));
    wp.customize('sidebar_padding', value => value.bind(to => updateCSSVar('--ak-sidebar-padding', to)));

    // 4. Categorical Typography & Effects
    const categories = ['site_title', 'site_tagline', 'menus', 'submenus', 'blog_titles', 'headings', 'sidebars', 'footer', 'body'];
    
    categories.forEach(cat => {
        const varId = cat.replace(/_/g, '-');
        
        wp.customize(cat + '_font_family', value => value.bind(to => updateCSSVar('--ak-' + varId + '-font-family', `'${to}', serif`)));
        
        if (cat === 'headings') {
            for (let i = 1; i <= 6; i++) {
                wp.customize('h' + i + '_font_size', value => value.bind(to => updateCSSVar('--ak-h' + i + '-font-size', to)));
            }
        } else {
            wp.customize(cat + '_font_size', value => value.bind(to => updateCSSVar('--ak-' + varId + '-font-size', to)));
        }
        
        wp.customize(cat + '_color', value => value.bind(to => updateCSSVar('--ak-' + varId + '-color', to)));
        if (['body', 'menus', 'submenus', 'sidebars', 'footer', 'blog_titles', 'article_text'].includes(cat)) {
            wp.customize(cat + '_link_color', value => value.bind(to => updateCSSVar('--ak-' + varId + '-link-color', to)));
        }

        wp.customize(cat + '_underline', value => value.bind(to => updateCSSVar('--ak-underline-' + varId, to ? 'underline' : 'none')));

        const updateEffect = () => {
            const shadowEnabled = wp.customize(cat + '_shadow_enable').get();
            const glowEnabled = wp.customize(cat + '_glow_enable').get();
            const shadowColor = wp.customize(cat + '_shadow_color').get();
            const glowColor = wp.customize(cat + '_glow_color').get();
            let val = '';
            if (shadowEnabled) val += `2px 2px 4px ${shadowColor}`;
            if (glowEnabled) val += (val ? ', ' : '') + `0 0 10px ${glowColor}`;
            updateCSSVar('--ak-effect-' + varId, val || 'none');
        };

        wp.customize(cat + '_shadow_enable', value => value.bind(updateEffect));
        wp.customize(cat + '_glow_enable', value => value.bind(updateEffect));
        wp.customize(cat + '_shadow_color', value => value.bind(updateEffect));
        wp.customize(cat + '_glow_color', value => value.bind(updateEffect));
    });

    // Drop Cap
    wp.customize('dropcap_enable', value => value.bind(to => updateCSSVar('--ak-dropcap-display', to ? 'block' : 'none')));
    wp.customize('dropcap_font_family', value => value.bind(to => updateCSSVar('--ak-dropcap-font-family', `'${to}', serif`)));
    wp.customize('dropcap_font_size', value => value.bind(to => updateCSSVar('--ak-dropcap-font-size', to)));
    wp.customize('dropcap_color', value => value.bind(to => updateCSSVar('--ak-dropcap-color', to)));

    wp.customize('copyright_text', value => value.bind(to => $('.copyright-content').html(to.replace('[year]', new Date().getFullYear()))));
    wp.customize('top_bar_text', value => value.bind(to => $('.top-bar-info').html(to)));

})(jQuery);