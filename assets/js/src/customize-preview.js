/**
 * Customizer Live Preview scripts.
 * 
 * Bridges WordPress Customizer settings with CSS variables in real-time.
 */

(function($) {
    // Helper to update CSS variables on :root
    const updateCSSVar = (name, value) => {
        document.documentElement.style.setProperty(name, value);
    };

    // Colors
    wp.customize('primary_color', value => {
        value.bind(to => updateCSSVar('--ak-primary-color', to));
    });
    wp.customize('accent_gold', value => {
        value.bind(to => updateCSSVar('--ak-accent-gold', to));
    });
    wp.customize('site_bg_color', value => {
        value.bind(to => updateCSSVar('--ak-site-bg', to));
    });
    wp.customize('header_bg_color', value => {
        value.bind(to => updateCSSVar('--ak-header-bg', to));
    });
    wp.customize('footer_bg_color', value => {
        value.bind(to => updateCSSVar('--ak-footer-bg', to));
    });
    wp.customize('body_text_color', value => {
        value.bind(to => updateCSSVar('--ak-body-text', to));
    });
    wp.customize('heading_text_color', value => {
        value.bind(to => updateCSSVar('--ak-heading-text', to));
    });
    wp.customize('link_color', value => {
        value.bind(to => updateCSSVar('--ak-link-color', to));
    });
    wp.customize('link_hover_color', value => {
        value.bind(to => updateCSSVar('--ak-link-hover-color', to));
    });

    // Layout
    wp.customize('container_width', value => {
        value.bind(to => updateCSSVar('--ak-container-width', to));
    });
    wp.customize('header_padding', value => {
        value.bind(to => updateCSSVar('--ak-header-padding', to));
    });
    wp.customize('menu_font_size', value => {
        value.bind(to => updateCSSVar('--ak-menu-font-size', to));
    });
    wp.customize('menu_spacing', value => {
        value.bind(to => updateCSSVar('--ak-menu-spacing', to));
    });
    wp.customize('menu_text_color', value => {
        value.bind(to => updateCSSVar('--ak-menu-text-color', to));
    });
    wp.customize('menu_hover_color', value => {
        value.bind(to => updateCSSVar('--ak-menu-hover-color', to));
    });
    wp.customize('copyright_text', value => {
        value.bind(to => {
            $('.copyright-content').html(to.replace('[year]', new Date().getFullYear()));
        });
    });
    wp.customize('top_bar_text', value => {
        value.bind(to => {
            $('.top-bar-info').html(to);
        });
    });

    // Typography - Body
    wp.customize('body_font_family', value => {
        value.bind(to => updateCSSVar('--ak-body-font-family', `'${to}', serif`));
    });
    wp.customize('body_font_size', value => {
        value.bind(to => updateCSSVar('--ak-body-font-size', to));
    });
    wp.customize('body_line_height', value => {
        value.bind(to => updateCSSVar('--ak-body-line-height', to));
    });

    // Typography - Headings
    wp.customize('headings_font_family', value => {
        value.bind(to => updateCSSVar('--ak-headings-font-family', `'${to}', serif`));
    });
    wp.customize('headings_font_weight', value => {
        value.bind(to => updateCSSVar('--ak-headings-font-weight', to));
    });

})(jQuery);
