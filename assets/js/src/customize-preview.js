/**
 * Customizer Live Preview scripts.
 */

(function($) {
    const updateCSSVar = (name, value) => {
        document.documentElement.style.setProperty(name, value);
    };

    // 1. Global Colors
    const bgColors = ['primary_accent', 'accent_gold', 'site_bg_color', 'header_bg_color', 'menu_bg_color', 'submenu_bg_color', 'footer_bg_color', 'sidebar_bg_color', 'sidebar_border_color'];
    bgColors.forEach(id => {
        wp.customize(id, value => value.bind(to => updateCSSVar('--ak-' + id.replace(/_/g, '-'), to)));
    });

    // 2. Layout & Spacing
    wp.customize('container_width', value => value.bind(to => updateCSSVar('--ak-container-width', to)));
    wp.customize('header_padding', value => value.bind(to => updateCSSVar('--ak-header-padding', to)));
    wp.customize('menu_spacing', value => value.bind(to => updateCSSVar('--ak-menu-spacing', to)));
    wp.customize('sidebar_padding', value => value.bind(to => updateCSSVar('--ak-sidebar-padding', to)));

    // 3. Categorical Typography & Effects
    const categories = ['site_title', 'site_tagline', 'menus', 'submenus', 'page_titles', 'headings', 'sidebars', 'footer', 'body'];
    
    categories.forEach(cat => {
        const varId = cat.replace(/_/g, '-');
        
        // Font Family
        wp.customize(cat + '_font_family', value => value.bind(to => updateCSSVar('--ak-' + varId + '-font-family', `'${to}', serif`)));
        
        // Font Size
        if (cat === 'headings') {
            for (let i = 1; i <= 6; i++) {
                wp.customize('h' + i + '_font_size', value => value.bind(to => updateCSSVar('--ak-h' + i + '-font-size', to)));
            }
        } else {
            wp.customize(cat + '_font_size', value => value.bind(to => updateCSSVar('--ak-' + varId + '-font-size', to)));
        }
        
        // Colors
        wp.customize(cat + '_color', value => value.bind(to => updateCSSVar('--ak-' + varId + '-color', to)));
        if (['body', 'menus', 'submenus', 'sidebars'].includes(cat)) {
            wp.customize(cat + '_link_color', value => value.bind(to => updateCSSVar('--ak-' + varId + '-link-color', to)));
        }

        // Underline
        wp.customize(cat + '_underline', value => value.bind(to => updateCSSVar('--ak-underline-' + varId, to ? 'underline' : 'none')));

        // Advanced Effects Logic
        const updateEffect = () => {
            const shadowEnabled = wp.customize(cat + '_shadow_enable').get();
            const glowEnabled = wp.customize(cat + '_glow_enable').get();
            const shadowColor = wp.customize(cat + '_shadow_color').get();
            const glowColor = wp.customize(cat + '_glow_color').get();
            
            let val = '';
            if (shadowEnabled) val += `2px 2px 4px ${shadowColor}`;
            if (glowEnabled) val += (val ? ', ' : '') + `0 0 10px ${glowColor}`;
            if (!val) val = 'none';
            
            updateCSSVar('--ak-effect-' + varId, val);
        };

        wp.customize(cat + '_shadow_enable', value => value.bind(updateEffect));
        wp.customize(cat + '_glow_enable', value => value.bind(updateEffect));
        wp.customize(cat + '_shadow_color', value => value.bind(updateEffect));
        wp.customize(cat + '_glow_color', value => value.bind(updateEffect));
    });

    // Branding text
    wp.customize('copyright_text', value => value.bind(to => $('.copyright-content').html(to.replace('[year]', new Date().getFullYear()))));
    wp.customize('top_bar_text', value => value.bind(to => $('.top-bar-info').html(to)));

})(jQuery);