<?php
/**
 * Aspiring Knight Customizer configuration
 *
 * @package Aspiring_Knight
 */

/**
 * Register Customizer settings.
 */
function aspiring_knight_customize_register( $wp_customize ) {

	/**
	 * Global Styles Panel
	 */
	$wp_customize->add_panel(
		'global_styles_panel',
		array(
			'priority'    => 10,
			'title'       => esc_html__( 'Global Styles', 'aspiring-knight' ),
			'description' => esc_html__( 'Global theme colors, typography, and layout.', 'aspiring-knight' ),
		)
	);

	/**
	 * 1. Colors Section (Consolidated)
	 */
	$wp_customize->add_section(
		'colors_section',
		array(
			'title'    => esc_html__( 'Colors', 'aspiring-knight' ),
			'panel'    => 'global_styles_panel',
			'priority' => 10,
		)
	);

	$colors = array(
		'primary_color'      => array( 'label' => __( 'Primary Brand Color', 'aspiring-knight' ), 'default' => '#3a3a3a' ),
		'accent_gold'        => array( 'label' => __( 'Accent Gold', 'aspiring-knight' ), 'default' => '#d4af37' ),
		'site_bg_color'      => array( 'label' => __( 'Site Background', 'aspiring-knight' ), 'default' => '#f4f4f4' ),
		'header_bg_color'    => array( 'label' => __( 'Header Background', 'aspiring-knight' ), 'default' => '#3a3a3a' ),
		'menu_bg_color'      => array( 'label' => __( 'Menu Background', 'aspiring-knight' ), 'default' => 'transparent' ),
		'menu_text_color'    => array( 'label' => __( 'Menu Link Color', 'aspiring-knight' ), 'default' => '#ffffff' ),
		'menu_hover_color'   => array( 'label' => __( 'Menu Link Hover', 'aspiring-knight' ), 'default' => '#d4af37' ),
		'footer_bg_color'    => array( 'label' => __( 'Footer Background', 'aspiring-knight' ), 'default' => '#3a3a3a' ),
		'body_text_color'    => array( 'label' => __( 'Body Text Color', 'aspiring-knight' ), 'default' => '#333333' ),
		'heading_text_color' => array( 'label' => __( 'Heading Text Color', 'aspiring-knight' ), 'default' => '#1a1a1a' ),
		'link_color'         => array( 'label' => __( 'General Link Color', 'aspiring-knight' ), 'default' => '#8b0000' ),
		'link_hover_color'   => array( 'label' => __( 'General Link Hover', 'aspiring-knight' ), 'default' => '#d4af37' ),
	);

	foreach ( $colors as $id => $data ) {
		$wp_customize->add_setting( $id, array(
			'default'           => $data['default'],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array(
			'label'   => $data['label'],
			'section' => 'colors_section',
		) ) );
	}

	// Link Underline Toggle
	$wp_customize->add_setting( 'link_underline', array(
		'default'           => true,
		'sanitize_callback' => 'rest_sanitize_boolean',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'link_underline', array(
		'label'    => esc_html__( 'Enable Link Underlining?', 'aspiring-knight' ),
		'section'  => 'colors_section',
		'type'     => 'checkbox',
	) );

	/**
	 * 2. Layout Settings Section
	 */
	$wp_customize->add_section(
		'layout_section',
		array(
			'title'    => esc_html__( 'Layout Settings', 'aspiring-knight' ),
			'panel'    => 'global_styles_panel',
			'priority' => 20,
		)
	);

	$wp_customize->add_setting( 'global_layout', array(
		'default'           => 'sidebar-right',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'global_layout', array(
		'label'    => esc_html__( 'Global Layout', 'aspiring-knight' ),
		'section'  => 'layout_section',
		'type'     => 'select',
		'choices'  => array(
			'sidebar-right' => __( 'Content / Sidebar', 'aspiring-knight' ),
			'sidebar-left'  => __( 'Sidebar / Content', 'aspiring-knight' ),
			'full-width'    => __( 'Full Width', 'aspiring-knight' ),
		),
	) );

	$wp_customize->add_setting( 'archive_layout', array(
		'default'           => 'grid',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'archive_layout', array(
		'label'    => esc_html__( 'Archive Layout', 'aspiring-knight' ),
		'section'  => 'layout_section',
		'type'     => 'select',
		'choices'  => array(
			'grid' => __( 'Tiled Grid', 'aspiring-knight' ),
			'list' => __( 'Excerpt List', 'aspiring-knight' ),
		),
	) );

	$wp_customize->add_setting( 'container_width', array(
		'default'           => '1200px',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'container_width', array(
		'label'   => esc_html__( 'Container Max Width', 'aspiring-knight' ),
		'section' => 'layout_section',
		'type'    => 'text',
	) );

	/**
	 * 3. Branding & Media Section
	 */
	$wp_customize->add_section(
		'branding_section',
		array(
			'title'    => esc_html__( 'Branding & Header', 'aspiring-knight' ),
			'panel'    => 'global_styles_panel',
			'priority' => 30,
		)
	);

	// Site Title Banner
	$wp_customize->add_setting( 'site_title_banner', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'site_title_banner', array(
		'label'    => esc_html__( 'Site Title Banner Image', 'aspiring-knight' ),
		'section'  => 'branding_section',
	) ) );

	// Header BG Image
	$wp_customize->add_setting( 'header_bg_image', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_bg_image', array(
		'label'    => esc_html__( 'Header Background Image', 'aspiring-knight' ),
		'section'  => 'branding_section',
	) ) );

	// Toggles
	$toggles = array(
		'show_site_title'   => __( 'Show Site Title', 'aspiring-knight' ),
		'show_site_tagline' => __( 'Show Site Tagline', 'aspiring-knight' ),
		'show_banner_image' => __( 'Show Banner Image', 'aspiring-knight' ),
		'show_top_bar'      => __( 'Show Top Bar', 'aspiring-knight' ),
	);

	foreach ( $toggles as $id => $label ) {
		$wp_customize->add_setting( $id, array(
			'default'           => true,
			'sanitize_callback' => 'rest_sanitize_boolean',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $id, array(
			'label'    => $label,
			'section'  => 'branding_section',
			'type'     => 'checkbox',
		) );
	}

	$wp_customize->add_setting( 'header_layout', array(
		'default'           => 'logo-left',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'header_layout', array(
		'label'    => esc_html__( 'Header Layout', 'aspiring-knight' ),
		'section'  => 'branding_section',
		'type'     => 'select',
		'choices'  => array(
			'logo-left'   => __( 'Logo Left / Menu Right', 'aspiring-knight' ),
			'logo-center' => __( 'Logo Center / Menu Below', 'aspiring-knight' ),
			'logo-right'  => __( 'Logo Right / Menu Left', 'aspiring-knight' ),
		),
	) );

	$wp_customize->add_setting( 'header_padding', array(
		'default'           => '20px',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'header_padding', array(
		'label'   => esc_html__( 'Header Vertical Padding', 'aspiring-knight' ),
		'section' => 'branding_section',
		'type'    => 'text',
	) );

	/**
	 * 4. Typography Section
	 */
	$wp_customize->add_section(
		'typography_section',
		array(
			'title'    => esc_html__( 'Typography & Effects', 'aspiring-knight' ),
			'panel'    => 'global_styles_panel',
			'priority' => 40,
		)
	);

	// Font families
	$fonts = array(
		'body_font_family'     => __( 'Body Font Family', 'aspiring-knight' ),
		'headings_font_family' => __( 'Headings Font Family', 'aspiring-knight' ),
	);

	foreach ( $fonts as $id => $label ) {
		$wp_customize->add_setting( $id, array(
			'default'           => 'body_font_family' === $id ? 'Lora' : 'Cinzel',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( $id, array(
			'label'   => $label,
			'section' => 'typography_section',
			'type'    => 'select',
			'choices' => aspiring_knight_get_font_choices(),
		) );
	}

	// Effects (Shadows/Glows)
	$effect_elements = array(
		'menu_items'    => __( 'Menu Items', 'aspiring-knight' ),
		'submenu_items' => __( 'Submenu Items', 'aspiring-knight' ),
		'headers'       => __( 'Headers (H1-H6)', 'aspiring-knight' ),
		'post_titles'   => __( 'Page/Post Titles', 'aspiring-knight' ),
		'site_title'    => __( 'Site Title', 'aspiring-knight' ),
	);

	foreach ( $effect_elements as $id => $label ) {
		$wp_customize->add_setting( "shadow_{$id}", array(
			'default'           => false,
			'sanitize_callback' => 'rest_sanitize_boolean',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( "shadow_{$id}", array(
			'label'    => sprintf( __( 'Enable Shadow/Glow for %s?', 'aspiring-knight' ), $label ),
			'section'  => 'typography_section',
			'type'     => 'checkbox',
		) );
	}

	/**
	 * 5. Footer Section
	 */
	$wp_customize->add_section(
		'footer_section',
		array(
			'title'    => esc_html__( 'Footer Settings', 'aspiring-knight' ),
			'panel'    => 'global_styles_panel',
			'priority' => 50,
		)
	);

	$wp_customize->add_setting( 'footer_bg_image', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'footer_bg_image', array(
		'label'    => esc_html__( 'Footer Background Image', 'aspiring-knight' ),
		'section'  => 'footer_section',
	) ) );

	$wp_customize->add_setting( 'footer_columns', array(
		'default'           => '3',
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'footer_columns', array(
		'label'    => esc_html__( 'Footer Columns', 'aspiring-knight' ),
		'section'  => 'footer_section',
		'type'     => 'select',
		'choices'  => array( '1'=>'1','2'=>'2','3'=>'3','4'=>'4' ),
	) );

	$wp_customize->add_setting( 'copyright_text', array(
		'default'           => __( 'Proudly powered by WordPress', 'aspiring-knight' ),
		'sanitize_callback' => 'wp_kses_post',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'copyright_text', array(
		'label'    => esc_html__( 'Copyright Text', 'aspiring-knight' ),
		'section'  => 'footer_section',
		'type'     => 'textarea',
	) );
}
add_action( 'customize_register', 'aspiring_knight_customize_register' );

/**
 * Get font choices for Customizer.
 */
function aspiring_knight_get_font_choices() {
	return array(
		'Lora'             => 'Lora (Classic Serif)',
		'Cinzel'           => 'Cinzel (Medieval Decorative)',
		'MedievalSharp'    => 'MedievalSharp (Medieval Angular)',
		'EB Garamond'      => 'EB Garamond (Elegant Serif)',
		'Playfair Display' => 'Playfair Display (High-Contrast Serif)',
		'Libre Baskerville' => 'Libre Baskerville (Traditional Serif)',
		'Almendra'         => 'Almendra (Calligraphic Medieval)',
		'Crimson Text'     => 'Crimson Text (Book Serif)',
		'Montserrat'       => 'Montserrat (Modern Sans)',
		'Open Sans'        => 'Open Sans (Clean Sans)',
	);
}

/**
 * Output CSS variables based on Customizer settings.
 */
function aspiring_knight_output_css_variables() {
	$mods = get_theme_mods();
	
	// Helper to get mod with default
	$get_mod = function( $name, $default ) use ( $mods ) {
		return $mods[ $name ] ?? $default;
	};

	$primary_color      = $get_mod( 'primary_color', '#3a3a3a' );
	$accent_gold        = $get_mod( 'accent_gold', '#d4af37' );
	$site_bg_color      = $get_mod( 'site_bg_color', '#f4f4f4' );
	$header_bg_color    = $get_mod( 'header_bg_color', '#3a3a3a' );
	$menu_bg_color      = $get_mod( 'menu_bg_color', 'transparent' );
	$menu_text_color    = $get_mod( 'menu_text_color', '#ffffff' );
	$menu_hover_color   = $get_mod( 'menu_hover_color', '#d4af37' );
	$footer_bg_color    = $get_mod( 'footer_bg_color', '#3a3a3a' );
	$body_text_color    = $get_mod( 'body_text_color', '#333333' );
	$heading_text_color = $get_mod( 'heading_text_color', '#1a1a1a' );
	$link_color         = $get_mod( 'link_color', '#8b0000' );
	$link_hover_color   = $get_mod( 'link_hover_color', '#d4af37' );
	$link_underline     = $get_mod( 'link_underline', true );

	$container_width    = $get_mod( 'container_width', '1200px' );
	$header_padding     = $get_mod( 'header_padding', '20px' );
	$menu_font_size     = $get_mod( 'menu_font_size', '16px' );
	$menu_spacing       = $get_mod( 'menu_spacing', '2rem' );

	$body_font_family   = $get_mod( 'body_font_family', 'Lora' );
	$headings_font_family = $get_mod( 'headings_font_family', 'Cinzel' );
	$headings_font_weight = $get_mod( 'headings_font_weight', '700' );

	$custom_font_file = $get_mod( 'custom_font_file', '' );
	$custom_font_name = $get_mod( 'custom_font_name', 'CustomFont' );
	$use_custom_headings = $get_mod( 'use_custom_font_headings', false );

	// Effects
	$shadow_css = '2px 2px 4px rgba(0,0,0,0.3)';
	$glow_css   = '0 0 8px var(--ak-accent-gold)';

	?>
	<style id="aspiring-knight-customizer-variables">
		<?php if ( $custom_font_file ) : ?>
		@font-face {
			font-family: '<?php echo esc_html( $custom_font_name ); ?>';
			src: url('<?php echo esc_url( $custom_font_file ); ?>');
			font-display: swap;
		}
		<?php endif; ?>

		:root {
			--ak-primary-color: <?php echo esc_html( $primary_color ); ?>;
			--ak-accent-gold: <?php echo esc_html( $accent_gold ); ?>;
			--ak-site-bg: <?php echo esc_html( $site_bg_color ); ?>;
			--ak-header-bg: <?php echo esc_html( $header_bg_color ); ?>;
			--ak-menu-bg: <?php echo esc_html( $menu_bg_color ); ?>;
			--ak-menu-text-color: <?php echo esc_html( $menu_text_color ); ?>;
			--ak-menu-hover-color: <?php echo esc_html( $menu_hover_color ); ?>;
			--ak-footer-bg: <?php echo esc_html( $footer_bg_color ); ?>;
			--ak-body-text: <?php echo esc_html( $body_text_color ); ?>;
			--ak-heading-text: <?php echo esc_html( $heading_text_color ); ?>;
			--ak-link-color: <?php echo esc_html( $link_color ); ?>;
			--ak-link-hover-color: <?php echo esc_html( $link_hover_color ); ?>;
			--ak-link-underline: <?php echo $link_underline ? 'underline' : 'none'; ?>;

			--ak-container-width: <?php echo esc_html( $container_width ); ?>;
			--ak-header-padding: <?php echo esc_html( $header_padding ); ?>;
			--ak-menu-font-size: <?php echo esc_html( $menu_font_size ); ?>;
			--ak-menu-spacing: <?php echo esc_html( $menu_spacing ); ?>;

			--ak-body-font-family: '<?php echo esc_html( $body_font_family ); ?>', serif;
			--ak-headings-font-family: '<?php echo $use_custom_headings && $custom_font_file ? esc_html( $custom_font_name ) : esc_html( $headings_font_family ); ?>', serif;
			--ak-headings-font-weight: <?php echo esc_html( $headings_font_weight ); ?>;

			/* Effects */
			--ak-shadow-menu: <?php echo $get_mod( 'shadow_menu_items', false ) ? $shadow_css : 'none'; ?>;
			--ak-shadow-submenu: <?php echo $get_mod( 'shadow_submenu_items', false ) ? $shadow_css : 'none'; ?>;
			--ak-shadow-headers: <?php echo $get_mod( 'shadow_headers', false ) ? $shadow_css : 'none'; ?>;
			--ak-shadow-post-titles: <?php echo $get_mod( 'shadow_post_titles', false ) ? $shadow_css : 'none'; ?>;
			--ak-shadow-site-title: <?php echo $get_mod( 'shadow_site_title', false ) ? $glow_css : 'none'; ?>;
		}
	</style>
	<?php
}
add_action( 'wp_head', 'aspiring_knight_output_css_variables' );

/**
 * Enqueue Google Fonts based on Customizer settings.
 */
function aspiring_knight_enqueue_customizer_fonts() {
	$body_font = get_theme_mod( 'body_font_family', 'Lora' );
	$heading_font = get_theme_mod( 'headings_font_family', 'Cinzel' );

	$fonts = array();
	$fonts[] = $body_font . ':400,400i,700,700i';
	if ( $heading_font !== $body_font ) {
		$fonts[] = $heading_font . ':400,700,900';
	}

	$fonts_url = add_query_arg( array(
		'family' => implode( '|', $fonts ),
		'display' => 'swap',
	), 'https://fonts.googleapis.com/css' );

	wp_enqueue_style( 'aspiring-knight-customizer-fonts', $fonts_url, array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'aspiring_knight_enqueue_customizer_fonts' );
