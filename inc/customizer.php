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
		'submenu_bg_color'   => array( 'label' => __( 'Sub-menu Background', 'aspiring-knight' ), 'default' => '#3a3a3a' ),
		'submenu_text_color' => array( 'label' => __( 'Sub-menu Link Color', 'aspiring-knight' ), 'default' => '#ffffff' ),
		'submenu_hover_color'=> array( 'label' => __( 'Sub-menu Link Hover', 'aspiring-knight' ), 'default' => '#d4af37' ),
		'footer_bg_color'    => array( 'label' => __( 'Footer Background', 'aspiring-knight' ), 'default' => '#3a3a3a' ),
		'shadow_color'       => array( 'label' => __( 'Text Shadow Color', 'aspiring-knight' ), 'default' => '#000000' ),
		'glow_color'         => array( 'label' => __( 'Text Glow Color', 'aspiring-knight' ), 'default' => '#d4af37' ),
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

	// Granular Typography Groups
	$typo_groups = array(
		'site_title' => __( 'Site Title', 'aspiring-knight' ),
		'post_title' => __( 'Page/Post Titles', 'aspiring-knight' ),
		'headings'   => __( 'General Headings (H1-H6)', 'aspiring-knight' ),
		'body'       => __( 'Body Text', 'aspiring-knight' ),
		'menu'       => __( 'Navigation Menu', 'aspiring-knight' ),
	);

	foreach ( $typo_groups as $id => $label ) {
		$wp_customize->add_setting( "{$id}_font_family", array(
			'default'           => in_array($id, ['body', 'menu']) ? 'Lora' : 'Cinzel',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( "{$id}_font_family", array(
			'label'   => sprintf( __( '%s Font Family', 'aspiring-knight' ), $label ),
			'section' => 'typography_section',
			'type'    => 'select',
			'choices' => aspiring_knight_get_font_choices(),
		) );

		$wp_customize->add_setting( "{$id}_font_size", array(
			'default'           => '18px',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( "{$id}_font_size", array(
			'label'   => sprintf( __( '%s Font Size', 'aspiring-knight' ), $label ),
			'section' => 'typography_section',
			'type'    => 'text',
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
			'label'    => sprintf( __( 'Enable Drop Shadow for %s?', 'aspiring-knight' ), $label ),
			'section'  => 'typography_section',
			'type'     => 'checkbox',
		) );

		$wp_customize->add_setting( "glow_{$id}", array(
			'default'           => false,
			'sanitize_callback' => 'rest_sanitize_boolean',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( "glow_{$id}", array(
			'label'    => sprintf( __( 'Enable Glow for %s?', 'aspiring-knight' ), $label ),
			'section'  => 'typography_section',
			'type'     => 'checkbox',
		) );
	}

	// Custom Font Upload
	$wp_customize->add_setting( 'custom_font_file', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 'custom_font_file', array(
		'label'       => esc_html__( 'Custom Font File', 'aspiring-knight' ),
		'description' => esc_html__( 'Upload a .woff2, .woff, or .ttf file.', 'aspiring-knight' ),
		'section'     => 'typography_section',
	) ) );

	$wp_customize->add_setting( 'custom_font_name', array(
		'default'           => 'CustomFont',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'custom_font_name', array(
		'label'   => esc_html__( 'Custom Font Name', 'aspiring-knight' ),
		'section' => 'typography_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'use_custom_font_headings', array(
		'default'           => false,
		'sanitize_callback' => 'rest_sanitize_boolean',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'use_custom_font_headings', array(
		'label'   => esc_html__( 'Use Custom Font for Headings?', 'aspiring-knight' ),
		'section' => 'typography_section',
		'type'    => 'checkbox',
	) );

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
	$get_mod = function( $name, $default ) use ( $mods ) {
		return isset($mods[ $name ]) ? $mods[ $name ] : $default;
	};

	$custom_font_file = $get_mod( 'custom_font_file', '' );
	$custom_font_name = $get_mod( 'custom_font_name', 'CustomFont' );
	$use_custom_headings = $get_mod( 'use_custom_font_headings', false );

	// Effects Settings
	$shadow_color = $get_mod( 'shadow_color', '#000000' );
	$glow_color   = $get_mod( 'glow_color', '#d4af37' );
	$shadow_def   = "2px 2px 4px {$shadow_color}";
	$glow_def     = "0 0 10px {$glow_color}";

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
			--ak-primary-color: <?php echo esc_html( $get_mod( 'primary_color', '#3a3a3a' ) ); ?>;
			--ak-accent-gold: <?php echo esc_html( $get_mod( 'accent_gold', '#d4af37' ) ); ?>;
			--ak-site-bg: <?php echo esc_html( $get_mod( 'site_bg_color', '#f4f4f4' ) ); ?>;
			--ak-header-bg: <?php echo esc_html( $get_mod( 'header_bg_color', '#3a3a3a' ) ); ?>;
			--ak-menu-bg: <?php echo esc_html( $get_mod( 'menu_bg_color', 'transparent' ) ); ?>;
			--ak-menu-text-color: <?php echo esc_html( $get_mod( 'menu_text_color', '#ffffff' ) ); ?>;
			--ak-menu-hover-color: <?php echo esc_html( $get_mod( 'menu_hover_color', '#d4af37' ) ); ?>;
			--ak-submenu-bg: <?php echo esc_html( $get_mod( 'submenu_bg_color', '#3a3a3a' ) ); ?>;
			--ak-submenu-text-color: <?php echo esc_html( $get_mod( 'submenu_text_color', '#ffffff' ) ); ?>;
			--ak-submenu-hover-color: <?php echo esc_html( $get_mod( 'submenu_hover_color', '#d4af37' ) ); ?>;
			--ak-footer-bg: <?php echo esc_html( $get_mod( 'footer_bg_color', '#3a3a3a' ) ); ?>;
			--ak-body-text: <?php echo esc_html( $get_mod( 'body_text_color', '#333333' ) ); ?>;
			--ak-heading-text: <?php echo esc_html( $get_mod( 'heading_text_color', '#1a1a1a' ) ); ?>;
			--ak-link-color: <?php echo esc_html( $get_mod( 'link_color', '#8b0000' ) ); ?>;
			--ak-link-hover-color: <?php echo esc_html( $get_mod( 'link_hover_color', '#d4af37' ) ); ?>;
			--ak-link-underline: <?php echo $get_mod( 'link_underline', true ) ? 'underline' : 'none'; ?>;

			--ak-container-width: <?php echo esc_html( $get_mod( 'container_width', '1200px' ) ); ?>;
			--ak-header-padding: <?php echo esc_html( $get_mod( 'header_padding', '20px' ) ); ?>;

			/* Typography */
			<?php
			$typos = ['site_title', 'post_title', 'headings', 'body', 'menu'];
			foreach ($typos as $t) {
				$font = $get_mod("{$t}_font_family", in_array($t, ['body', 'menu']) ? 'Lora' : 'Cinzel');
				if ($use_custom_headings && $custom_font_file && in_array($t, ['site_title', 'post_title', 'headings'])) {
					$font = $custom_font_name;
				}
				echo "--ak-{$t}-font-family: '" . esc_html($font) . "', serif;\n";
				echo "--ak-{$t}-font-size: " . esc_html($get_mod("{$t}_font_size", '18px')) . ";\n";
			}
			?>

			/* Advanced Effects */
			<?php
			$effects = ['menu_items', 'submenu_items', 'headers', 'post_titles', 'site_title'];
			foreach ($effects as $e) {
				$val = '';
				if ($get_mod("shadow_{$e}", false)) $val .= $shadow_def;
				if ($get_mod("glow_{$e}", false)) $val .= ($val ? ', ' : '') . $glow_def;
				if (!$val) $val = 'none';
				$var_name = str_replace('_', '-', $e);
				echo "--ak-effect-{$var_name}: {$val};\n";
			}
			?>
		}
	</style>
	<?php
}
add_action( 'wp_head', 'aspiring_knight_output_css_variables' );

/**
 * Enqueue Google Fonts based on Customizer settings.
 */
function aspiring_knight_enqueue_customizer_fonts() {
	$typos = ['site_title', 'post_title', 'headings', 'body', 'menu'];
	$fonts = array();
	foreach ($typos as $t) {
		$font = get_theme_mod("{$t}_font_family", in_array($t, ['body', 'menu']) ? 'Lora' : 'Cinzel');
		$fonts[] = $font . ':400,400i,700,700i,900';
	}
	$fonts = array_unique($fonts);

	$fonts_url = add_query_arg( array(
		'family' => implode( '|', $fonts ),
		'display' => 'swap',
	), 'https://fonts.googleapis.com/css' );

	wp_enqueue_style( 'aspiring-knight-customizer-fonts', $fonts_url, array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'aspiring_knight_enqueue_customizer_fonts' );