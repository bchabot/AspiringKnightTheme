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
			'description' => esc_html__( 'Global theme colors and typography.', 'aspiring-knight' ),
		)
	);

	/**
	 * Layout Settings Section
	 */
	$wp_customize->add_section(
		'layout_section',
		array(
			'title'    => esc_html__( 'Layout Settings', 'aspiring-knight' ),
			'panel'    => 'global_styles_panel',
			'priority' => 5,
		)
	);

	/**
	 * Header Settings Section
	 */
	$wp_customize->add_section(
		'header_section',
		array(
			'title'    => esc_html__( 'Header Settings', 'aspiring-knight' ),
			'panel'    => 'global_styles_panel',
			'priority' => 6,
		)
	);

	/**
	 * Footer Settings Section
	 */
	$wp_customize->add_section(
		'footer_section',
		array(
			'title'    => esc_html__( 'Footer Settings', 'aspiring-knight' ),
			'panel'    => 'global_styles_panel',
			'priority' => 7,
		)
	);

	// Footer Columns
	$wp_customize->add_setting(
		'footer_columns',
		array(
			'default'           => '3',
			'sanitize_callback' => 'absint',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'footer_columns',
		array(
			'label'    => esc_html__( 'Footer Columns', 'aspiring-knight' ),
			'section'  => 'footer_section',
			'type'     => 'select',
			'choices'  => array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
			),
		)
	);

	// Copyright Text
	$wp_customize->add_setting(
		'copyright_text',
		array(
			'default'           => esc_html__( 'Proudly powered by WordPress', 'aspiring-knight' ),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'copyright_text',
		array(
			'label'    => esc_html__( 'Copyright Text', 'aspiring-knight' ),
			'section'  => 'footer_section',
			'type'     => 'textarea',
		)
	);

	// Header Layout
	$wp_customize->add_setting(
		'header_layout',
		array(
			'default'           => 'logo-left',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'header_layout',
		array(
			'label'    => esc_html__( 'Header Layout', 'aspiring-knight' ),
			'section'  => 'header_section',
			'type'     => 'select',
			'choices'  => array(
				'logo-left'   => esc_html__( 'Logo Left / Menu Right', 'aspiring-knight' ),
				'logo-center' => esc_html__( 'Logo Center / Menu Below', 'aspiring-knight' ),
				'logo-right'  => esc_html__( 'Logo Right / Menu Left', 'aspiring-knight' ),
			),
		)
	);

	// Header Padding (Height)
	$wp_customize->add_setting(
		'header_padding',
		array(
			'default'           => '20px',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'header_padding',
		array(
			'label'    => esc_html__( 'Header Vertical Padding', 'aspiring-knight' ),
			'section'  => 'header_section',
			'type'     => 'text',
		)
	);

	// Header Background Image
	$wp_customize->add_setting(
		'header_bg_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'header_bg_image',
			array(
				'label'    => esc_html__( 'Header Background Image', 'aspiring-knight' ),
				'section'  => 'header_section',
			)
		)
	);

	// Menu Font Size
	$wp_customize->add_setting(
		'menu_font_size',
		array(
			'default'           => '16px',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'menu_font_size',
		array(
			'label'    => esc_html__( 'Menu Font Size', 'aspiring-knight' ),
			'section'  => 'header_section',
			'type'     => 'text',
		)
	);

	// Menu Spacing
	$wp_customize->add_setting(
		'menu_spacing',
		array(
			'default'           => '2rem',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'menu_spacing',
		array(
			'label'    => esc_html__( 'Menu Item Spacing', 'aspiring-knight' ),
			'section'  => 'header_section',
			'type'     => 'text',
		)
	);

	// Menu Text Color
	$wp_customize->add_setting(
		'menu_text_color',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_text_color',
			array(
				'label'   => esc_html__( 'Menu Text Color', 'aspiring-knight' ),
				'section' => 'header_section',
			)
		)
	);

	// Menu Hover Color
	$wp_customize->add_setting(
		'menu_hover_color',
		array(
			'default'           => '#d4af37',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_hover_color',
			array(
				'label'   => esc_html__( 'Menu Hover Color', 'aspiring-knight' ),
				'section' => 'header_section',
			)
		)
	);

	// Show Top Bar
	$wp_customize->add_setting(
		'show_top_bar',
		array(
			'default'           => false,
			'sanitize_callback' => 'rest_sanitize_boolean',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'show_top_bar',
		array(
			'label'    => esc_html__( 'Show Top Bar', 'aspiring-knight' ),
			'section'  => 'header_section',
			'type'     => 'checkbox',
		)
	);

	// Top Bar Text
	$wp_customize->add_setting(
		'top_bar_text',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'top_bar_text',
		array(
			'label'    => esc_html__( 'Top Bar Info', 'aspiring-knight' ),
			'section'  => 'header_section',
			'type'     => 'text',
		)
	);

	// Global Layout
	$wp_customize->add_setting(
		'global_layout',
		array(
			'default'           => 'sidebar-right',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh', // Layout changes usually benefit from a full refresh
		)
	);
	$wp_customize->add_control(
		'global_layout',
		array(
			'label'    => esc_html__( 'Global Layout', 'aspiring-knight' ),
			'section'  => 'layout_section',
			'type'     => 'select',
			'choices'  => array(
				'sidebar-right' => esc_html__( 'Content / Sidebar', 'aspiring-knight' ),
				'sidebar-left'  => esc_html__( 'Sidebar / Content', 'aspiring-knight' ),
				'full-width'    => esc_html__( 'Full Width', 'aspiring-knight' ),
			),
		)
	);

	// Archive Layout
	$wp_customize->add_setting(
		'archive_layout',
		array(
			'default'           => 'grid',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'archive_layout',
		array(
			'label'    => esc_html__( 'Archive Layout', 'aspiring-knight' ),
			'section'  => 'layout_section',
			'type'     => 'select',
			'choices'  => array(
				'grid' => esc_html__( 'Tiled Grid', 'aspiring-knight' ),
				'list' => esc_html__( 'Excerpt List', 'aspiring-knight' ),
			),
		)
	);

	// Container Width
	$wp_customize->add_setting(
		'container_width',
		array(
			'default'           => '1200px',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'container_width',
		array(
			'label'       => esc_html__( 'Container Max Width', 'aspiring-knight' ),
			'description' => esc_html__( 'e.g., 1200px, 90%, 1400px', 'aspiring-knight' ),
			'section'     => 'layout_section',
			'type'        => 'text',
		)
	);

	/**
	 * Colors Section
	 */
	$wp_customize->add_section(
		'colors_section',
		array(
			'title'    => esc_html__( 'Colors', 'aspiring-knight' ),
			'panel'    => 'global_styles_panel',
			'priority' => 10,
		)
	);

	// Primary Color
	$wp_customize->add_setting(
		'primary_color',
		array(
			'default'           => '#3a3a3a',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'primary_color',
			array(
				'label'    => esc_html__( 'Primary Color', 'aspiring-knight' ),
				'section'  => 'colors_section',
				'settings' => 'primary_color',
			)
		)
	);

	// Accent Gold
	$wp_customize->add_setting(
		'accent_gold',
		array(
			'default'           => '#d4af37',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'accent_gold',
			array(
				'label'    => esc_html__( 'Accent Gold', 'aspiring-knight' ),
				'section'  => 'colors_section',
				'settings' => 'accent_gold',
			)
		)
	);

	// Site Background
	$wp_customize->add_setting(
		'site_bg_color',
		array(
			'default'           => '#f4f4f4',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'site_bg_color',
			array(
				'label'    => esc_html__( 'Site Background', 'aspiring-knight' ),
				'section'  => 'colors_section',
				'settings' => 'site_bg_color',
			)
		)
	);

	// Header Background
	$wp_customize->add_setting(
		'header_bg_color',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_bg_color',
			array(
				'label'    => esc_html__( 'Header Background', 'aspiring-knight' ),
				'section'  => 'colors_section',
				'settings' => 'header_bg_color',
			)
		)
	);

	// Footer Background
	$wp_customize->add_setting(
		'footer_bg_color',
		array(
			'default'           => '#3a3a3a',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'footer_bg_color',
			array(
				'label'    => esc_html__( 'Footer Background', 'aspiring-knight' ),
				'section'  => 'colors_section',
				'settings' => 'footer_bg_color',
			)
		)
	);

	// Body Text Color
	$wp_customize->add_setting(
		'body_text_color',
		array(
			'default'           => '#333333',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'body_text_color',
			array(
				'label'    => esc_html__( 'Body Text Color', 'aspiring-knight' ),
				'section'  => 'colors_section',
				'settings' => 'body_text_color',
			)
		)
	);

	// Heading Text Color
	$wp_customize->add_setting(
		'heading_text_color',
		array(
			'default'           => '#1a1a1a',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'heading_text_color',
			array(
				'label'    => esc_html__( 'Heading Text Color', 'aspiring-knight' ),
				'section'  => 'colors_section',
				'settings' => 'heading_text_color',
			)
		)
	);

	// Link Color
	$wp_customize->add_setting(
		'link_color',
		array(
			'default'           => '#8b0000',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'link_color',
			array(
				'label'    => esc_html__( 'Link Color', 'aspiring-knight' ),
				'section'  => 'colors_section',
				'settings' => 'link_color',
			)
		)
	);

	// Link Hover Color
	$wp_customize->add_setting(
		'link_hover_color',
		array(
			'default'           => '#d4af37',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'link_hover_color',
			array(
				'label'    => esc_html__( 'Link Hover Color', 'aspiring-knight' ),
				'section'  => 'colors_section',
				'settings' => 'link_hover_color',
			)
		)
	);

	/**
	 * Typography Section
	 */
	$wp_customize->add_section(
		'typography_section',
		array(
			'title'    => esc_html__( 'Typography', 'aspiring-knight' ),
			'panel'    => 'global_styles_panel',
			'priority' => 20,
		)
	);

	// Body Font Family
	$wp_customize->add_setting(
		'body_font_family',
		array(
			'default'           => 'Lora',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'body_font_family',
		array(
			'label'   => esc_html__( 'Body Font Family', 'aspiring-knight' ),
			'section' => 'typography_section',
			'type'    => 'select',
			'choices' => aspiring_knight_get_font_choices(),
		)
	);

	// Body Font Size
	$wp_customize->add_setting(
		'body_font_size',
		array(
			'default'           => '18px',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'body_font_size',
		array(
			'label'   => esc_html__( 'Body Font Size', 'aspiring-knight' ),
			'section' => 'typography_section',
			'type'    => 'text',
		)
	);

	// Body Line Height
	$wp_customize->add_setting(
		'body_line_height',
		array(
			'default'           => '1.6',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'body_line_height',
		array(
			'label'   => esc_html__( 'Body Line Height', 'aspiring-knight' ),
			'section' => 'typography_section',
			'type'    => 'text',
		)
	);

	// Headings Font Family
	$wp_customize->add_setting(
		'headings_font_family',
		array(
			'default'           => 'Cinzel',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'headings_font_family',
		array(
			'label'   => esc_html__( 'Headings Font Family', 'aspiring-knight' ),
			'section' => 'typography_section',
			'type'    => 'select',
			'choices' => aspiring_knight_get_font_choices(),
		)
	);

	// Headings Font Weight
	$wp_customize->add_setting(
		'headings_font_weight',
		array(
			'default'           => '700',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'headings_font_weight',
		array(
			'label'   => esc_html__( 'Headings Font Weight', 'aspiring-knight' ),
			'section' => 'typography_section',
			'type'    => 'select',
			'choices' => array(
				'400' => 'Regular (400)',
				'500' => 'Medium (500)',
				'600' => 'Semi-Bold (600)',
				'700' => 'Bold (700)',
				'800' => 'Extra-Bold (800)',
				'900' => 'Black (900)',
			),
		)
	);

	// Custom Font Upload
	$wp_customize->add_setting(
		'custom_font_file',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Upload_Control(
			$wp_customize,
			'custom_font_file',
			array(
				'label'       => esc_html__( 'Custom Font File', 'aspiring-knight' ),
				'description' => esc_html__( 'Upload a .woff2, .woff, or .ttf file.', 'aspiring-knight' ),
				'section'     => 'typography_section',
			)
		)
	);

	// Custom Font Name
	$wp_customize->add_setting(
		'custom_font_name',
		array(
			'default'           => 'CustomFont',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'custom_font_name',
		array(
			'label'   => esc_html__( 'Custom Font Name', 'aspiring-knight' ),
			'section' => 'typography_section',
			'type'    => 'text',
		)
	);

	// Use Custom Font for Headings
	$wp_customize->add_setting(
		'use_custom_font_headings',
		array(
			'default'           => false,
			'sanitize_callback' => 'rest_sanitize_boolean',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'use_custom_font_headings',
		array(
			'label'   => esc_html__( 'Use Custom Font for Headings?', 'aspiring-knight' ),
			'section' => 'typography_section',
			'type'    => 'checkbox',
		)
	);
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
	$primary_color      = get_theme_mod( 'primary_color', '#3a3a3a' );
	$accent_gold        = get_theme_mod( 'accent_gold', '#d4af37' );
	$site_bg_color      = get_theme_mod( 'site_bg_color', '#f4f4f4' );
	$header_bg_color    = get_theme_mod( 'header_bg_color', '#ffffff' );
	$footer_bg_color    = get_theme_mod( 'footer_bg_color', '#3a3a3a' );
	$body_text_color    = get_theme_mod( 'body_text_color', '#333333' );
	$heading_text_color = get_theme_mod( 'heading_text_color', '#1a1a1a' );
	$link_color         = get_theme_mod( 'link_color', '#8b0000' );
	$link_hover_color   = get_theme_mod( 'link_hover_color', '#d4af37' );

	// Layout
	$global_layout      = get_theme_mod( 'global_layout', 'sidebar-right' );
	$container_width    = get_theme_mod( 'container_width', '1200px' );
	$header_padding     = get_theme_mod( 'header_padding', '20px' );
	$menu_font_size     = get_theme_mod( 'menu_font_size', '16px' );
	$menu_spacing       = get_theme_mod( 'menu_spacing', '2rem' );
	$menu_text_color    = get_theme_mod( 'menu_text_color', '#ffffff' );
	$menu_hover_color   = get_theme_mod( 'menu_hover_color', '#d4af37' );

	// Typography
	$body_font_family   = get_theme_mod( 'body_font_family', 'Lora' );
	$body_font_size     = get_theme_mod( 'body_font_size', '18px' );
	$body_line_height   = get_theme_mod( 'body_line_height', '1.6' );
	$headings_font_family = get_theme_mod( 'headings_font_family', 'Cinzel' );
	$headings_font_weight = get_theme_mod( 'headings_font_weight', '700' );

	$custom_font_file = get_theme_mod( 'custom_font_file' );
	$custom_font_name = get_theme_mod( 'custom_font_name', 'CustomFont' );
	$use_custom_headings = get_theme_mod( 'use_custom_font_headings', false );

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
			--ak-footer-bg: <?php echo esc_html( $footer_bg_color ); ?>;
			--ak-body-text: <?php echo esc_html( $body_text_color ); ?>;
			--ak-heading-text: <?php echo esc_html( $heading_text_color ); ?>;
			--ak-link-color: <?php echo esc_html( $link_color ); ?>;
			--ak-link-hover-color: <?php echo esc_html( $link_hover_color ); ?>;

			/* Layout */
			--ak-container-width: <?php echo esc_html( $container_width ); ?>;
			--ak-sidebar-order: <?php echo 'sidebar-left' === $global_layout ? '-1' : '1'; ?>;
			--ak-header-padding: <?php echo esc_html( $header_padding ); ?>;
			--ak-menu-font-size: <?php echo esc_html( $menu_font_size ); ?>;
			--ak-menu-spacing: <?php echo esc_html( $menu_spacing ); ?>;
			--ak-menu-text-color: <?php echo esc_html( $menu_text_color ); ?>;
			--ak-menu-hover-color: <?php echo esc_html( $menu_hover_color ); ?>;

			/* Body Typography */
			--ak-body-font-family: '<?php echo esc_html( $body_font_family ); ?>', serif;
			--ak-body-font-size: <?php echo esc_html( $body_font_size ); ?>;
			--ak-body-line-height: <?php echo esc_html( $body_line_height ); ?>;

			/* Headings Typography */
			--ak-headings-font-family: '<?php echo $use_custom_headings && $custom_font_file ? esc_html( $custom_font_name ) : esc_html( $headings_font_family ); ?>', serif;
			--ak-headings-font-weight: <?php echo esc_html( $headings_font_weight ); ?>;
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