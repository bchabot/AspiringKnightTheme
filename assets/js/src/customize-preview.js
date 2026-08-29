/**
 * Customizer Live Preview scripts.
 */

(function($) {
    const updateCSSVar = (name, value) => {
        document.documentElement.style.setProperty(name, value);
    };

    // 1. Global Colors
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
        wp.customize(id, value => value.bind(to => updateCSSVar(colorMap[id], to)));
    });

    // Images
    wp.customize('background_image', value => value.bind(to => updateCSSVar('--ak-site-bg-image', to ? `url(${to})` : 'none')));
    wp.customize('article_bg_image', value => value.bind(to => updateCSSVar('--ak-article-bg-image', to ? `url(${to})` : 'none')));

    // Layout & Spacing
    wp.customize('container_width', value => value.bind(to => updateCSSVar('--ak-container-width', to)));
    wp.customize('header_padding', value => value.bind(to => updateCSSVar('--ak-header-padding', to)));
    wp.customize('menu_spacing', value => value.bind(to => updateCSSVar('--ak-menu-spacing', to)));
    wp.customize('sidebar_padding', value => value.bind(to => updateCSSVar('--ak-sidebar-padding', to)));

    // 2. Categorical Typography & Effects
    const categories = [
        'site_title', 'site_tagline', 'blog_title', 'page_title', 'headings',
        'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'body_text', 'body_links',
        'menus', 'submenus', 'sidebars', 'footer'
    ];

    categories.forEach(cat => {
        const varId = cat.replace(/_/g, '-');

        const updateAllVars = () => {
            const font = wp.customize(cat + '_font_family').get();
            const size = wp.customize(cat + '_font_size').get();
            const weight = wp.customize(cat + '_font_weight').get();
            const italic = wp.customize(cat + '_italic').get();
            const color = wp.customize(cat + '_color').get();
            const underline = wp.customize(cat + '_underline').get() ? 'underline' : 'none';

            updateCSSVar('--ak-' + varId + '-font-family', `'${font}', serif`);
            updateCSSVar('--ak-' + varId + '-font-size', size);
            updateCSSVar('--ak-' + varId + '-font-weight', weight);
            updateCSSVar('--ak-' + varId + '-font-style', italic ? 'italic' : 'normal');
            updateCSSVar('--ak-' + varId + '-color', color);

            if (wp.customize(cat + '_link_color')) {
                updateCSSVar('--ak-' + varId + '-link-color', wp.customize(cat + '_link_color').get());
            }

            updateCSSVar('--ak-underline-' + varId, underline);

            // Effects
            const shadowEnabled = wp.customize(cat + '_shadow_enable').get();
            const shadowColor = wp.customize(cat + '_shadow_color').get();
            const shadowSize = wp.customize(cat + '_shadow_size').get();
            const glowEnabled = wp.customize(cat + '_glow_enable').get();
            const glowColor = wp.customize(cat + '_glow_color').get();
            const glowSize = wp.customize(cat + '_glow_size').get();

            let val = '';
            if (shadowEnabled) val += `${shadowSize} ${shadowColor}`;
            if (glowEnabled) val += (val ? ', ' : '') + `0 0 ${glowSize} ${glowColor}`;
            updateCSSVar('--ak-effect-' + varId, val || 'none');

            // Drop Caps
            const dropEnabled = wp.customize(cat + '_dropcaps_enable').get();
            const dropColor = wp.customize(cat + '_dropcaps_color').get();
            const dropSize = wp.customize(cat + '_dropcaps_size').get();
            updateCSSVar('--ak-dropcap-display-' + varId, dropEnabled ? 'block' : 'none');
            updateCSSVar('--ak-dropcap-color-' + varId, dropColor);
            updateCSSVar('--ak-dropcap-font-size-' + varId, dropSize);
        };

        // Bind all settings to updateAllVars
        const settingsToBind = [
            '_font_family', '_font_size', '_font_weight', '_italic', '_underline', '_color',
            '_shadow_enable', '_shadow_color', '_shadow_size', '_glow_enable', '_glow_color', '_glow_size',
            '_dropcaps_enable', '_dropcaps_color', '_dropcaps_size'
        ];
        settingsToBind.forEach(suffix => {
            if (wp.customize(cat + suffix)) {
                wp.customize(cat + suffix, value => value.bind(updateAllVars));
            }
        });
        if (wp.customize(cat + '_link_color')) {
            wp.customize(cat + '_link_color', value => value.bind(updateAllVars));
        }
    });

    // Legacy Drop Cap Preview
    wp.customize('dropcap_enable', value => value.bind(to => updateCSSVar('--ak-dropcap-display', to ? 'block' : 'none')));
    wp.customize('dropcap_font_family', value => value.bind(to => updateCSSVar('--ak-dropcap-font-family', `'${to}', serif`)));
    wp.customize('dropcap_font_size', value => value.bind(to => updateCSSVar('--ak-dropcap-font-size', to)));
    wp.customize('dropcap_color', value => value.bind(to => updateCSSVar('--ak-dropcap-color', to)));

    // Branding text
    wp.customize('copyright_text', value => value.bind(to => $('.copyright-content').html(to.replace('[year]', new Date().getFullYear()))));
    wp.customize('top_bar_text', value => value.bind(to => $('.top-bar-info').html(to)));

})(jQuery);
