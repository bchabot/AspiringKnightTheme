/**
 * Customizer Live Preview scripts.
 * 
 * Bridges WordPress Customizer settings with CSS variables in real-time.
 */

(function($) {
    const updateCSSVar = (name, value) => {
        document.documentElement.style.setProperty(name, value);
    };

    // Colors
    const colorSettings = [
        'primary_color', 'accent_gold', 'site_bg_color', 'header_bg_color', 
        'menu_bg_color', 'menu_text_color', 'menu_hover_color',
        'submenu_bg_color', 'submenu_text_color', 'submenu_hover_color',
        'footer_bg_color', 'shadow_color', 'glow_color',
        'body_text_color', 'heading_text_color', 'link_color', 'link_hover_color'
    ];

    colorSettings.forEach(id => {
        wp.customize(id, value => {
            value.bind(to => updateCSSVar('--ak-' + id.replace(/_/g, '-'), to));
        });
    });

    // Link Underline
    wp.customize('link_underline', value => {
        value.bind(to => updateCSSVar('--ak-link-underline', to ? 'underline' : 'none'));
    });

    // Layout
    wp.customize('container_width', value => {
        value.bind(to => updateCSSVar('--ak-container-width', to));
    });
    wp.customize('header_padding', value => {
        value.bind(to => updateCSSVar('--ak-header-padding', to));
    });

    // Typography Groups
    const typoGroups = ['site_title', 'post_title', 'headings', 'body', 'menu'];
    typoGroups.forEach(group => {
        wp.customize(group + '_font_family', value => {
            value.bind(to => updateCSSVar('--ak-' + group.replace(/_/g, '-') + '-font-family', `'${to}', serif`));
        });
        wp.customize(group + '_font_size', value => {
            value.bind(to => updateCSSVar('--ak-' + group.replace(/_/g, '-') + '-font-size', to));
        });
    });

    // Effects logic (approximate preview)
    const updateEffect = (element) => {
        const shadowEnabled = wp.customize('shadow_' + element).get();
        const glowEnabled = wp.customize('glow_' + element).get();
        const shadowColor = wp.customize('shadow_color').get();
        const glowColor = wp.customize('glow_color').get();
        
        let val = '';
        if (shadowEnabled) val += `2px 2px 4px ${shadowColor}`;
        if (glowEnabled) val += (val ? ', ' : '') + `0 0 10px ${glowColor}`;
        if (!val) val = 'none';
        
        updateCSSVar('--ak-effect-' + element.replace(/_/g, '-'), val);
    };

    const effectElements = ['menu_items', 'submenu_items', 'headers', 'post_titles', 'site_title'];
    effectElements.forEach(el => {
        wp.customize('shadow_' + el, value => value.bind(() => updateEffect(el)));
        wp.customize('glow_' + el, value => value.bind(() => updateEffect(el)));
    });
    wp.customize('shadow_color', value => value.bind(() => effectElements.forEach(updateEffect)));
    wp.customize('glow_color', value => value.bind(() => effectElements.forEach(updateEffect)));

    // Other handlers
    wp.customize('copyright_text', value => {
        value.bind(to => $('.copyright-content').html(to.replace('[year]', new Date().getFullYear())));
    });
    wp.customize('top_bar_text', value => {
        value.bind(to => $('.top-bar-info').html(to));
    });

})(jQuery);