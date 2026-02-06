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
			'description' => esc_html__( 'Comprehensive design controls for the Aspiring Knight theme.', 'aspiring-knight' ),
		)
	);

	/**
	 * 1. Global Colors Section (Backgrounds & Accents)
	 */
	$wp_customize->add_section(
		'colors_section',
		array(
			'title'    => esc_html__( 'Colors (BGs & Accents)', 'aspiring-knight' ),
			'panel'    => 'global_styles_panel',
			'priority' => 10,
		)
	);

	$bg_colors = array(
		'primary_accent'     => array( 'label' => __( 'Primary Accent (Knight Iron)', 'aspiring-knight' ), 'default' => '#3a3a3a' ),
		'accent_gold'        => array( 'label' => __( 'Gold Highlight', 'aspiring-knight' ), 'default' => '#d4af37' ),
		'site_bg_color'      => array( 'label' => __( 'Site Background', 'aspiring-knight' ), 'default' => '#f4f4f4' ),
		'header_bg_color'    => array( 'label' => __( 'Header Background', 'aspiring-knight' ), 'default' => '#3a3a3a' ),
		'menu_bg_color'      => array( 'label' => __( 'Menu Background', 'aspiring-knight' ), 'default' => 'transparent' ),
		'submenu_bg_color'   => array( 'label' => __( 'Sub-menu Background', 'aspiring-knight' ), 'default' => '#3a3a3a' ),
		'footer_bg_color'    => array( 'label' => __( 'Footer Background', 'aspiring-knight' ), 'default' => '#3a3a3a' ),
	);

	foreach ( $bg_colors as $id => $data ) {
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

	/**
	 * 2. Categorical Typography & Effects
	 */
	$wp_customize->add_section(
		'typography_section',
		array(
			'title'    => esc_html__( 'Typography & Categorical Effects', 'aspiring-knight' ),
			'panel'    => 'global_styles_panel',
			'priority' => 20,
		)
	);

	$categories = array(
		'site_title'   => __( 'Site Title', 'aspiring-knight' ),
		'site_tagline' => __( 'Site Tagline', 'aspiring-knight' ),
		'menus'        => __( 'Navigation Menus', 'aspiring-knight' ),
		'submenus'     => __( 'Sub-Menus', 'aspiring-knight' ),
		'page_titles'  => __( 'Page/Post Titles', 'aspiring-knight' ),
		'headings'     => __( 'General Headings (H1-H6)', 'aspiring-knight' ),
		'sidebars'     => __( 'Sidebar Content', 'aspiring-knight' ),
		'body'         => __( 'Body Text', 'aspiring-knight' ),
	);

	foreach ( $categories as $id => $cat_label ) {
		// Spacer Setting (Visual Only)
		$wp_customize->add_setting( "spacer_{$id}", array( 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "spacer_{$id}", array(
			'label'    => "--- {$cat_label} ---",
			'section'  => 'typography_section',
			'type'     => 'hidden',
		) ) );

		// Font Family
		$wp_customize->add_setting( "{$id}_font_family", array(
			'default'           => in_array($id, ['body', 'menus', 'submenus', 'sidebars']) ? 'Lora' : 'Cinzel',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( "{$id}_font_family", array(
			'label'   => sprintf( __( '%s Font Family', 'aspiring-knight' ), $cat_label ),
			'section' => 'typography_section',
			'type'    => 'select',
			'choices' => aspiring_knight_get_font_choices(),
		) );

		// Font Size (Special for headings)
		if ($id === 'headings') {
			$h_defaults = array('1' => '48px', '2' => '36px', '3' => '30px', '4' => '24px', '5' => '20px', '6' => '18px');
			foreach ($h_defaults as $lvl => $def) {
				$wp_customize->add_setting( "h{$lvl}_font_size", array( 'default' => $def, 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
				$wp_customize->add_control( "h{$lvl}_font_size", array( 'label' => "H{$lvl} Font Size", 'section' => 'typography_section', 'type' => 'text' ) );
			}
		} else {
			$wp_customize->add_setting( "{$id}_font_size", array( 'default' => '18px', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
			$wp_customize->add_control( "{$id}_font_size", array( 'label' => __( 'Font Size', 'aspiring-knight' ), 'section' => 'typography_section', 'type' => 'text' ) );
		}

		// Text Color
		$wp_customize->add_setting( "{$id}_color", array(
			'default'           => in_array($id, ['site_title', 'menus', 'submenus']) ? '#ffffff' : '#333333',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "{$id}_color", array(
			'label'   => __( 'Text Color', 'aspiring-knight' ),
			'section' => 'typography_section',
		) ) );

		// Link Color (Optional)
		if ( in_array($id, ['body', 'menus', 'submenus', 'sidebars']) ) {
			$wp_customize->add_setting( "{$id}_link_color", array( 'default' => '#d4af37', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "{$id}_link_color", array( 'label' => __( 'Link Color', 'aspiring-knight' ), 'section' => 'typography_section' ) ) );
		}

		// Underline Toggle
		$wp_customize->add_setting( "{$id}_underline", array( 'default' => ($id === 'body'), 'sanitize_callback' => 'rest_sanitize_boolean', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_underline", array( 'label' => __( 'Enable Underlining?', 'aspiring-knight' ), 'section' => 'typography_section', 'type' => 'checkbox' ) );

		// Shadow & Glow
		$wp_customize->add_setting( "{$id}_shadow_enable", array( 'default' => false, 'sanitize_callback' => 'rest_sanitize_boolean', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_shadow_enable", array( 'label' => __( 'Enable Shadow?', 'aspiring-knight' ), 'section' => 'typography_section', 'type' => 'checkbox' ) );
		$wp_customize->add_setting( "{$id}_shadow_color", array( 'default' => '#000000', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "{$id}_shadow_color", array( 'label' => __( 'Shadow Color', 'aspiring-knight' ), 'section' => 'typography_section' ) ) );

		$wp_customize->add_setting( "{$id}_glow_enable", array( 'default' => false, 'sanitize_callback' => 'rest_sanitize_boolean', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_glow_enable", array( 'label' => __( 'Enable Glow?', 'aspiring-knight' ), 'section' => 'typography_section', 'type' => 'checkbox' ) );
		$wp_customize->add_setting( "{$id}_glow_color", array( 'default' => '#d4af37', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "{$id}_glow_color", array( 'label' => __( 'Glow Color', 'aspiring-knight' ), 'section' => 'typography_section' ) ) );
	}

	// Custom Font Upload Group
	$wp_customize->add_setting( 'custom_font_header', array( 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'custom_font_header', array( 'label' => '--- CUSTOM FONT UPLOAD ---', 'section' => 'typography_section', 'type' => 'hidden' ) ) );
	$wp_customize->add_setting( 'custom_font_file', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', 'transport' => 'refresh' ) );
	$wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 'custom_font_file', array( 'label' => __( 'Upload Font File (.woff2)', 'aspiring-knight' ), 'section' => 'typography_section' ) ) );
	$wp_customize->add_setting( 'custom_font_name', array( 'default' => 'CustomFont', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'custom_font_name', array( 'label' => __( 'Custom Font Name', 'aspiring-knight' ), 'section' => 'typography_section', 'type' => 'text' ) );
	$wp_customize->add_setting( 'use_custom_font_headings', array( 'default' => false, 'sanitize_callback' => 'rest_sanitize_boolean', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'use_custom_font_headings', array( 'label' => __( 'Force Custom Font for Titles/Headings?', 'aspiring-knight' ), 'section' => 'typography_section', 'type' => 'checkbox' ) );

	/**
	 * 3. Branding Assets Section
	 */
	$wp_customize->add_section(
		'branding_section',
		array(
			'title'    => esc_html__( 'Branding Assets', 'aspiring-knight' ),
			'panel'    => 'global_styles_panel',
			'priority' => 30,
		)
	);

	$wp_customize->add_setting( 'site_title_banner', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', 'transport' => 'refresh' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'site_title_banner', array( 'label' => __( 'Banner Image', 'aspiring-knight' ), 'section' => 'branding_section' ) ) );
	$wp_customize->add_setting( 'header_bg_image', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', 'transport' => 'refresh' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_bg_image', array( 'label' => __( 'Header Background Image', 'aspiring-knight' ), 'section' => 'branding_section' ) ) );

	$branding_toggles = array(
		'show_site_title'   => __( 'Show Site Title', 'aspiring-knight' ),
		'show_site_tagline' => __( 'Show Site Tagline', 'aspiring-knight' ),
		'show_banner_image' => __( 'Show Banner Image', 'aspiring-knight' ),
		'show_top_bar'      => __( 'Show Top Bar', 'aspiring-knight' ),
	);

	foreach ( $branding_toggles as $id => $label ) {
		$wp_customize->add_setting( $id, array( 'default' => true, 'sanitize_callback' => 'rest_sanitize_boolean', 'transport' => 'refresh' ) );
		$wp_customize->add_control( $id, array( 'label' => $label, 'section' => 'branding_section', 'type' => 'checkbox' ) );
	}

	/**
	 * 4. Layout & Spacing Section
	 */
	$wp_customize->add_section(
		'layout_section',
		array(
			'title'    => esc_html__( 'Layout & Spacing', 'aspiring-knight' ),
			'panel'    => 'global_styles_panel',
			'priority' => 40,
		)
	);

	$wp_customize->add_setting( 'global_layout', array( 'default' => 'sidebar-right', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'global_layout', array( 'label' => __( 'Sidebar Position', 'aspiring-knight' ), 'section' => 'layout_section', 'type' => 'select', 'choices' => array( 'sidebar-right' => 'Right Sidebar', 'sidebar-left' => 'Left Sidebar', 'full-width' => 'Full Width' ) ) );
	$wp_customize->add_setting( 'container_width', array( 'default' => '1200px', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'container_width', array( 'label' => __( 'Max Site Width', 'aspiring-knight' ), 'section' => 'layout_section', 'type' => 'text' ) );
	$wp_customize->add_setting( 'header_padding', array( 'default' => '20px', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'header_padding', array( 'label' => __( 'Header Vertical Padding', 'aspiring-knight' ), 'section' => 'layout_section', 'type' => 'text' ) );
	$wp_customize->add_setting( 'menu_spacing', array( 'default' => '2rem', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'menu_spacing', array( 'label' => __( 'Menu Item Spacing', 'aspiring-knight' ), 'section' => 'layout_section', 'type' => 'text' ) );

	/**
	 * 5. Footer Layout Section
	 */
	$wp_customize->add_section(
		'footer_section',
		array(
			'title'    => esc_html__( 'Footer Layout', 'aspiring-knight' ),
			'panel'    => 'global_styles_panel',
			'priority' => 50,
		)
	);

	$wp_customize->add_setting( 'footer_bg_image', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', 'transport' => 'refresh' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'footer_bg_image', array( 'label' => __( 'Footer Background Image', 'aspiring-knight' ), 'section' => 'footer_section' ) ) );
	$wp_customize->add_setting( 'footer_columns', array( 'default' => '3', 'sanitize_callback' => 'absint', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'footer_columns', array( 'label' => __( 'Footer Columns', 'aspiring-knight' ), 'section' => 'footer_section', 'type' => 'select', 'choices' => array( '1'=>'1','2'=>'2','3'=>'3','4'=>'4' ) ) );
	$wp_customize->add_setting( 'copyright_text', array( 'default' => __( 'Proudly powered by WordPress', 'aspiring-knight' ), 'sanitize_callback' => 'wp_kses_post', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'copyright_text', array( 'label' => __( 'Copyright Text', 'aspiring-knight' ), 'section' => 'footer_section', 'type' => 'textarea' ) );
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
			/* 1. Global Colors (BGs & Accents) */
			--ak-primary-accent: <?php echo esc_html( $get_mod( 'primary_accent', '#3a3a3a' ) ); ?>;
			--ak-accent-gold: <?php echo esc_html( $get_mod( 'accent_gold', '#d4af37' ) ); ?>;
			--ak-site-bg: <?php echo esc_html( $get_mod( 'site_bg_color', '#f4f4f4' ) ); ?>;
			--ak-header-bg: <?php echo esc_html( $get_mod( 'header_bg_color', '#3a3a3a' ) ); ?>;
			--ak-menu-bg: <?php echo esc_html( $get_mod( 'menu_bg_color', 'transparent' ) ); ?>;
			--ak-submenu-bg: <?php echo esc_html( $get_mod( 'submenu_bg_color', '#3a3a3a' ) ); ?>;
			--ak-footer-bg: <?php echo esc_html( $get_mod( 'footer_bg_color', '#3a3a3a' ) ); ?>;

			/* 2. Layout/Header Padding */
			--ak-container-width: <?php echo esc_html( $get_mod( 'container_width', '1200px' ) ); ?>;
			--ak-header-padding: <?php echo esc_html( $get_mod( 'header_padding', '20px' ) ); ?>;
			--ak-menu-spacing: <?php echo esc_html( $get_mod( 'menu_spacing', '2rem' ) ); ?>;

			/* 3. Categorical Typography & Effects */
			<?php
			$categories = ['site_title', 'site_tagline', 'menus', 'submenus', 'page_titles', 'headings', 'sidebars', 'body'];
			foreach ($categories as $cat) {
				$var_id = str_replace('_', '-', $cat);
				
				// Typography
				$font = $get_mod("{$cat}_font_family", in_array($cat, ['body', 'menus', 'submenus', 'sidebars']) ? 'Lora' : 'Cinzel');
				if ($use_custom_headings && $custom_font_file && in_array($cat, ['site_title', 'site_tagline', 'page_titles', 'headings'])) {
					$font = $custom_font_name;
				}
				echo "--ak-{$var_id}-font-family: '" . esc_html($font) . "', serif;\n";
				
				// Font Size
				if ($cat === 'headings') {
					for ($i=1;$i<=6;$i++) {
						echo "--ak-h{$i}-font-size: " . esc_html($get_mod("h{$i}_font_size", (array('1'=>'48px','2'=>'36px','3'=>'30px','4'=>'24px','5'=>'20px','6'=>'18px'))[$i])) . ";\n";
					}
				} else {
					echo "--ak-{$var_id}-font-size: " . esc_html($get_mod("{$cat}_font_size", '18px')) . ";\n";
				}

				// Colors
				echo "--ak-{$var_id}-color: " . esc_html($get_mod("{$cat}_color", in_array($cat, ['site_title', 'menus', 'submenus']) ? '#ffffff' : '#333333')) . ";\n";
				if ( in_array($cat, ['body', 'menus', 'submenus', 'sidebars']) ) {
					echo "--ak-{$var_id}-link-color: " . esc_html($get_mod("{$cat}_link_color", '#d4af37')) . ";\n";
				}

				// Underline
				echo "--ak-underline-{$var_id}: " . ($get_mod("{$cat}_underline", ($cat === 'body')) ? 'underline' : 'none') . ";\n";

				// Effects mapping
				$effect_map = array(
					'menus'       => 'menu-items',
					'submenus'    => 'submenu-items',
					'headings'    => 'headers',
					'page_titles' => 'post-titles',
					'site_title'  => 'site-title',
					'site_tagline'=> 'site-tagline',
					'body'        => 'body',
					'sidebars'    => 'sidebars'
				);

				if (isset($effect_map[$cat])) {
					$eff_var = $effect_map[$cat];
					$val = '';
					if ($get_mod("{$cat}_shadow_enable", false)) {
						$s_color = $get_mod("{$cat}_shadow_color", '#000000');
						$val .= "2px 2px 4px {$s_color}";
					}
					if ($get_mod("{$cat}_glow_enable", false)) {
						$g_color = $get_mod("{$cat}_glow_color", '#d4af37');
						$val .= ($val ? ', ' : '') . "0 0 10px {$g_color}";
					}
					if (!$val) $val = 'none';
					echo "--ak-effect-{$eff_var}: {$val};\n";
				}
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
	$typos = ['site_title', 'site_tagline', 'menus', 'submenus', 'page_titles', 'headings', 'sidebars', 'body'];
	$fonts = array();
	foreach ($typos as $t) {
		$font = get_theme_mod("{$t}_font_family", in_array($t, ['body', 'menus', 'submenus', 'sidebars']) ? 'Lora' : 'Cinzel');
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
