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

	// 1. Force Remove Core Sections
	$wp_customize->remove_section( 'colors' );
	$wp_customize->remove_section( 'header_image' );
	$wp_customize->remove_section( 'background_image' );

	/**
	 * Design System Panel
	 */
	$wp_customize->add_panel(
		'design_system_panel',
		array(
			'priority'    => 5,
			'title'       => esc_html__( 'Design System', 'aspiring-knight' ),
			'description' => esc_html__( 'Professional design controls for the Aspiring Knight theme.', 'aspiring-knight' ),
		)
	);

	/**
	 * SECTION: Presets
	 */
	$wp_customize->add_section(
		'ds_presets_section',
		array(
			'title'    => esc_html__( '✨ Theme Presets', 'aspiring-knight' ),
			'panel'    => 'design_system_panel',
			'priority' => 1,
		)
	);

	$wp_customize->add_setting( 'custom_presets_data', array( 'default' => '{}', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'custom_presets_data', array( 'type' => 'hidden', 'section' => 'ds_presets_section' ) );

	$wp_customize->add_setting( 'theme_preset', array( 'default' => 'default', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'theme_preset', array(
		'label'    => __( 'Choose a Design Preset', 'aspiring-knight' ),
		'section'  => 'ds_presets_section',
		'type'     => 'select',
		'choices'  => aspiring_knight_get_preset_choices(),
	) );

	$wp_customize->add_setting( 'new_preset_name', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'new_preset_name', array(
		'label'    => __( 'Save Current as Preset', 'aspiring-knight' ),
		'section'  => 'ds_presets_section',
		'type'     => 'text',
		'input_attrs' => array( 'placeholder' => __( 'Preset Name...', 'aspiring-knight' ) ),
	) );

	/**
	 * SECTION: Global Colors
	 */
	$wp_customize->add_section(
		'site_colors_section',
		array(
			'title'    => esc_html__( 'Site Colors & Backgrounds', 'aspiring-knight' ),
			'panel'    => 'design_system_panel',
			'priority' => 10,
		)
	);

	$bg_colors = array(
		'top_bar_bg_color'   => array( 'label' => __( 'Top Bar Background', 'aspiring-knight' ), 'default' => '#3a3a3a' ),
		'top_bar_text_color' => array( 'label' => __( 'Top Bar Text Color', 'aspiring-knight' ), 'default' => '#ffffff' ),
		'accent_gold'        => array( 'label' => __( 'Gold Accent / Highlights', 'aspiring-knight' ), 'default' => '#d4af37' ),
		'site_bg_color'      => array( 'label' => __( 'Global Site Background', 'aspiring-knight' ), 'default' => '#f4f4f4' ),
		'article_bg_color'   => array( 'label' => __( 'Article Box Background', 'aspiring-knight' ), 'default' => '#ffffff' ),
		'header_bg_color'    => array( 'label' => __( 'Header Background', 'aspiring-knight' ), 'default' => '#3a3a3a' ),
		'menu_bg_color'      => array( 'label' => __( 'Menu Background', 'aspiring-knight' ), 'default' => 'transparent' ),
		'submenu_bg_color'   => array( 'label' => __( 'Sub-menu Background', 'aspiring-knight' ), 'default' => '#3a3a3a' ),
		'footer_bg_color'    => array( 'label' => __( 'Footer Background', 'aspiring-knight' ), 'default' => '#3a3a3a' ),
		'sidebar_bg_color'   => array( 'label' => __( 'Sidebar Background', 'aspiring-knight' ), 'default' => '#ffffff' ),
		'sidebar_border_color'=> array( 'label' => __( 'Sidebar Border', 'aspiring-knight' ), 'default' => '#eeeeee' ),
	);

	foreach ( $bg_colors as $id => $data ) {
		$wp_customize->add_setting( $id, array( 'default' => $data['default'], 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array( 'label' => $data['label'], 'section' => 'site_colors_section' ) ) );
	}

	$wp_customize->add_setting( 'background_image', array( 'transport' => 'refresh', 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'background_image', array( 'label' => __( 'Global Background Image', 'aspiring-knight' ), 'section' => 'site_colors_section' ) ) );

	$wp_customize->add_setting( 'article_bg_image', array( 'transport' => 'refresh', 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'article_bg_image', array( 'label' => __( 'Article Box Background Image', 'aspiring-knight' ), 'section' => 'site_colors_section' ) ) );

	/**
	 * CATEGORICAL DESIGN SECTIONS
	 */
	$design_categories = array(
		'site_title'   => array( 'label' => __( 'Site Title', 'aspiring-knight' ), 'priority' => 20 ),
		'site_tagline' => array( 'label' => __( 'Site Tagline', 'aspiring-knight' ), 'priority' => 25 ),
		'menus'        => array( 'label' => __( 'Navigation Menus', 'aspiring-knight' ), 'priority' => 30 ),
		'submenus'     => array( 'label' => __( 'Sub-Menus', 'aspiring-knight' ), 'priority' => 35 ),
		'blog_titles'  => array( 'label' => __( 'Blog / Post Titles', 'aspiring-knight' ), 'priority' => 40 ),
		'headings'     => array( 'label' => __( 'Content Headers (H1-H6)', 'aspiring-knight' ), 'priority' => 45 ),
		'article_text' => array( 'label' => __( 'Main Article Text', 'aspiring-knight' ), 'priority' => 48 ),
		'sidebars'     => array( 'label' => __( 'Sidebars', 'aspiring-knight' ), 'priority' => 50 ),
		'footer'       => array( 'label' => __( 'Footer Area', 'aspiring-knight' ), 'priority' => 55 ),
		'body'         => array( 'label' => __( 'Global Body Typography', 'aspiring-knight' ), 'priority' => 60 ),
	);

	foreach ( $design_categories as $id => $cat ) {
		$section_id = "ds_{$id}_section";
		$wp_customize->add_section( $section_id, array( 'title' => $cat['label'], 'panel' => 'design_system_panel', 'priority' => $cat['priority'] ) );

		$wp_customize->add_setting( "{$id}_font_family", array( 'default' => in_array($id, ['body', 'menus', 'submenus', 'sidebars', 'footer', 'article_text']) ? 'Lora' : 'Cinzel', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_font_family", array( 'label' => __( 'Font Family', 'aspiring-knight' ), 'section' => $section_id, 'type' => 'select', 'choices' => aspiring_knight_get_font_choices() ) );

		if ($id === 'headings') {
			$h_defaults = array('1' => '48px', '2' => '36px', '3' => '30px', '4' => '24px', '5' => '20px', '6' => '18px');
			foreach ($h_defaults as $lvl => $def) {
				$wp_customize->add_setting( "h{$lvl}_font_size", array( 'default' => $def, 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
				$wp_customize->add_control( "h{$lvl}_font_size", array( 'label' => "H{$lvl} Size", 'section' => $section_id, 'type' => 'text' ) );
			}
		} else {
			$wp_customize->add_setting( "{$id}_font_size", array( 'default' => ($id === 'site_title' ? '2.5rem' : '18px'), 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
			$wp_customize->add_control( "{$id}_font_size", array( 'label' => __( 'Font Size', 'aspiring-knight' ), 'section' => $section_id, 'type' => 'text' ) );
		}

		$wp_customize->add_setting( "{$id}_color", array( 'default' => in_array($id, ['site_title', 'site_tagline', 'menus', 'submenus', 'footer']) ? '#ffffff' : '#333333', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "{$id}_color", array( 'label' => __( 'Text Color', 'aspiring-knight' ), 'section' => $section_id ) ) );

		if ( in_array($id, ['body', 'menus', 'submenus', 'sidebars', 'footer', 'blog_titles', 'article_text']) ) {
			$wp_customize->add_setting( "{$id}_link_color", array( 'default' => '#d4af37', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "{$id}_link_color", array( 'label' => __( 'Link Color', 'aspiring-knight' ), 'section' => $section_id ) ) );
		}

		$wp_customize->add_setting( "{$id}_underline", array( 'default' => in_array($id, ['body', 'article_text']), 'sanitize_callback' => 'rest_sanitize_boolean', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_underline", array( 'label' => __( 'Enable Underlining?', 'aspiring-knight' ), 'section' => $section_id, 'type' => 'checkbox' ) );

		$wp_customize->add_setting( "{$id}_shadow_enable", array( 'default' => false, 'sanitize_callback' => 'rest_sanitize_boolean', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_shadow_enable", array( 'label' => __( 'Enable Shadow?', 'aspiring-knight' ), 'section' => $section_id, 'type' => 'checkbox' ) );
		$wp_customize->add_setting( "{$id}_shadow_color", array( 'default' => '#000000', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "{$id}_shadow_color", array( 'label' => __( 'Shadow Color', 'aspiring-knight' ), 'section' => $section_id ) ) );

		$wp_customize->add_setting( "{$id}_glow_enable", array( 'default' => false, 'sanitize_callback' => 'rest_sanitize_boolean', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_glow_enable", array( 'label' => __( 'Enable Glow?', 'aspiring-knight' ), 'section' => $section_id, 'type' => 'checkbox' ) );
		$wp_customize->add_setting( "{$id}_glow_color", array( 'default' => '#d4af37', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "{$id}_glow_color", array( 'label' => __( 'Glow Color', 'aspiring-knight' ), 'section' => $section_id ) ) );

		if ( $id === 'body' ) {
			$wp_customize->add_setting( 'dropcap_enable', array( 'default' => true, 'sanitize_callback' => 'rest_sanitize_boolean', 'transport' => 'postMessage' ) );
			$wp_customize->add_control( 'dropcap_enable', array( 'label' => __( 'Enable Drop Cap?', 'aspiring-knight' ), 'section' => $section_id, 'type' => 'checkbox' ) );
			$wp_customize->add_setting( 'dropcap_font_family', array( 'default' => 'Cinzel', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
			$wp_customize->add_control( 'dropcap_font_family', array( 'label' => __( 'Drop Cap Font', 'aspiring-knight' ), 'section' => $section_id, 'type' => 'select', 'choices' => aspiring_knight_get_font_choices() ) );
			$wp_customize->add_setting( 'dropcap_font_size', array( 'default' => '4rem', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
			$wp_customize->add_control( 'dropcap_font_size', array( 'label' => __( 'Drop Cap Size', 'aspiring-knight' ), 'section' => $section_id, 'type' => 'text' ) );
			$wp_customize->add_setting( 'dropcap_color', array( 'default' => '#d4af37', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dropcap_color', array( 'label' => __( 'Drop Cap Color', 'aspiring-knight' ), 'section' => $section_id ) ) );
		}
	}

	$wp_customize->add_section( 'branding_assets_section', array( 'title' => esc_html__( 'Header & Branding Assets', 'aspiring-knight' ), 'panel' => 'design_system_panel', 'priority' => 100 ) );
	$wp_customize->add_setting( 'site_title_banner', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', 'transport' => 'refresh' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'site_title_banner', array( 'label' => __( 'Banner Image', 'aspiring-knight' ), 'section' => 'branding_assets_section' ) ) );
	$wp_customize->add_setting( 'header_bg_image', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', 'transport' => 'refresh' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_bg_image', array( 'label' => __( 'Header Background Image', 'aspiring-knight' ), 'section' => 'branding_assets_section' ) ) );

	$branding_toggles = array( 'show_site_title' => __( 'Show Site Title', 'aspiring-knight' ), 'show_site_tagline' => __( 'Show Site Tagline', 'aspiring-knight' ), 'show_banner_image' => __( 'Show Banner Image', 'aspiring-knight' ), 'show_top_bar' => __( 'Show Top Bar', 'aspiring-knight' ) );
	foreach ( $branding_toggles as $id => $label ) {
		$wp_customize->add_setting( $id, array( 'default' => true, 'sanitize_callback' => 'rest_sanitize_boolean', 'transport' => 'refresh' ) );
		$wp_customize->add_control( $id, array( 'label' => $label, 'section' => 'branding_assets_section', 'type' => 'checkbox' ) );
	}

	$wp_customize->add_setting( 'header_layout', array( 'default' => 'logo-left', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'header_layout', array( 'label' => __( 'Header Layout', 'aspiring-knight' ), 'section' => 'branding_assets_section', 'type' => 'select', 'choices' => array( 'logo-left' => 'Logo Left', 'logo-center' => 'Logo Center', 'logo-right' => 'Logo Right' ) ) );

	$wp_customize->add_section( 'ds_layout_section', array( 'title' => esc_html__( 'Layout & Spacing', 'aspiring-knight' ), 'panel' => 'design_system_panel', 'priority' => 110 ) );
	$wp_customize->add_setting( 'global_layout', array( 'default' => 'sidebar-right', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'global_layout', array( 'label' => __( 'Sidebar Position', 'aspiring-knight' ), 'section' => 'ds_layout_section', 'type' => 'select', 'choices' => array( 'sidebar-right' => 'Right Sidebar', 'sidebar-left' => 'Left Sidebar', 'full-width' => 'Full Width' ) ) );
	$wp_customize->add_setting( 'container_width', array( 'default' => '1200px', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'container_width', array( 'label' => __( 'Max Site Width', 'aspiring-knight' ), 'section' => 'ds_layout_section', 'type' => 'text' ) );
	$wp_customize->add_setting( 'header_padding', array( 'default' => '20px', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'header_padding', array( 'label' => __( 'Header Vertical Padding', 'aspiring-knight' ), 'section' => 'ds_layout_section', 'type' => 'text' ) );
	$wp_customize->add_setting( 'menu_spacing', array( 'default' => '2rem', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'menu_spacing', array( 'label' => __( 'Menu Item Spacing', 'aspiring-knight' ), 'section' => 'ds_layout_section', 'type' => 'text' ) );
	$wp_customize->add_setting( 'sidebar_padding', array( 'default' => '1.5rem', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'sidebar_padding', array( 'label' => __( 'Sidebar Widget Padding', 'aspiring-knight' ), 'section' => 'ds_layout_section', 'type' => 'text' ) );

	$wp_customize->add_section( 'ds_footer_layout_section', array( 'title' => esc_html__( 'Footer Layout', 'aspiring-knight' ), 'panel' => 'design_system_panel', 'priority' => 120 ) );
	$wp_customize->add_setting( 'footer_bg_image', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', 'transport' => 'refresh' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'footer_bg_image', array( 'label' => __( 'Footer Background Image', 'aspiring-knight' ), 'section' => 'ds_footer_layout_section' ) ) );
	$wp_customize->add_setting( 'footer_columns', array( 'default' => '3', 'sanitize_callback' => 'absint', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'footer_columns', array( 'label' => __( 'Footer Columns', 'aspiring-knight' ), 'section' => 'ds_footer_layout_section', 'type' => 'select', 'choices' => array( '1'=>'1','2'=>'2','3'=>'3','4'=>'4' ) ) );
	$wp_customize->add_setting( 'copyright_text', array( 'default' => __( 'Proudly powered by WordPress', 'aspiring-knight' ), 'sanitize_callback' => 'wp_kses_post', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'copyright_text', array( 'label' => __( 'Copyright Text', 'aspiring-knight' ), 'section' => 'ds_footer_layout_section', 'type' => 'textarea' ) );
}
add_action( 'customize_register', 'aspiring_knight_customize_register', 20 );

/**
 * Get preset choices including custom ones.
 */
function aspiring_knight_get_preset_choices() {
	$choices = array( 'default' => 'Aspiring Knight (Original)', 'medieval' => 'Medieval Influence (Bold & Dark)', 'modern' => 'Modern Minimalist (Clean)', 'dark' => 'Knight of the Night (Dark Mode)', 'monochrome' => 'Iron & Stone (Monochrome)', 'high_contrast' => 'High Contrast (Accessibility)' );
	$custom_presets = json_decode( get_theme_mod( 'custom_presets_data', '{}' ), true );
	if ( ! empty( $custom_presets ) ) foreach ( $custom_presets as $id => $data ) $choices[ $id ] = '👤 ' . $data['name'];
	return $choices;
}

/**
 * Get font choices for Customizer.
 */
function aspiring_knight_get_font_choices() {
	return array( 'Lora' => 'Lora (Classic Serif)', 'Cinzel' => 'Cinzel (Medieval Decorative)', 'MedievalSharp' => 'MedievalSharp (Medieval Angular)', 'EB Garamond' => 'EB Garamond (Elegant Serif)', 'Playfair Display' => 'Playfair Display (High-Contrast Serif)', 'Libre Baskerville' => 'Libre Baskerville (Traditional Serif)', 'Almendra' => 'Almendra (Calligraphic Medieval)', 'Crimson Text' => 'Crimson Text (Book Serif)', 'Montserrat' => 'Montserrat (Modern Sans)', 'Open Sans' => 'Open Sans (Clean Sans)' );
}

/**
 * Output CSS variables based on Customizer settings.
 */
function aspiring_knight_output_css_variables() {
	$mods = get_theme_mods();
	$get_mod = function( $name, $default ) use ( $mods ) { return isset($mods[ $name ]) ? $mods[ $name ] : $default; };
	$custom_font_file = $get_mod( 'custom_font_file', '' );
	$custom_font_name = $get_mod( 'custom_font_name', 'CustomFont' );
	$use_custom_headings = $get_mod( 'use_custom_font_headings', false );
	$article_bg_image = $get_mod( 'article_bg_image', '' );
	?>
	<style id="aspiring-knight-customizer-variables">
		<?php if ( $custom_font_file ) : ?>
		@font-face { font-family: '<?php echo esc_html( $custom_font_name ); ?>'; src: url('<?php echo esc_url( $custom_font_file ); ?>'); font-display: swap; }
		<?php endif; ?>

		:root {
			/* Global Colors */
			--ak-top-bar-bg: <?php echo esc_html( $get_mod( 'top_bar_bg_color', '#3a3a3a' ) ); ?>;
			--ak-top-bar-text: <?php echo esc_html( $get_mod( 'top_bar_text_color', '#ffffff' ) ); ?>;
			--ak-accent-gold: <?php echo esc_html( $get_mod( 'accent_gold', '#d4af37' ) ); ?>;
			--ak-site-bg: <?php echo esc_html( $get_mod( 'site_bg_color', '#f4f4f4' ) ); ?>;
			--ak-article-bg: <?php echo esc_html( $get_mod( 'article_bg_color', '#ffffff' ) ); ?>;
			--ak-article-bg-image: <?php echo $article_bg_image ? 'url(' . esc_url($article_bg_image) . ')' : 'none'; ?>;
			--ak-header-bg: <?php echo esc_html( $get_mod( 'header_bg_color', '#3a3a3a' ) ); ?>;
			--ak-menu-bg: <?php echo esc_html( $get_mod( 'menu_bg_color', 'transparent' ) ); ?>;
			--ak-submenu-bg: <?php echo esc_html( $get_mod( 'submenu_bg_color', '#3a3a3a' ) ); ?>;
			--ak-footer-bg: <?php echo esc_html( $get_mod( 'footer_bg_color', '#3a3a3a' ) ); ?>;
			--ak-sidebar-bg: <?php echo esc_html( $get_mod( 'sidebar_bg_color', '#ffffff' ) ); ?>;
			--ak-sidebar-border: <?php echo esc_html( $get_mod( 'sidebar_border_color', '#eeeeee' ) ); ?>;

			/* Layout */
			--ak-container-width: <?php echo esc_html( $get_mod( 'container_width', '1200px' ) ); ?>;
			--ak-header-padding: <?php echo esc_html( $get_mod( 'header_padding', '20px' ) ); ?>;
			--ak-menu-spacing: <?php echo esc_html( $get_mod( 'menu_spacing', '2rem' ) ); ?>;
			--ak-sidebar-padding: <?php echo esc_html( $get_mod( 'sidebar_padding', '1.5rem' ) ); ?>;

			/* Categorical Typography & Effects */
			<?php
			$categories = ['site_title', 'site_tagline', 'menus', 'submenus', 'blog_titles', 'headings', 'article_text', 'sidebars', 'footer', 'body'];
			foreach ($categories as $cat) {
				$var_id = str_replace('_', '-', $cat);
				$font = $get_mod("{$cat}_font_family", in_array($cat, ['body', 'menus', 'submenus', 'sidebars', 'footer', 'article_text']) ? 'Lora' : 'Cinzel');
				if ($use_custom_headings && $custom_font_file && in_array($cat, ['site_title', 'site_tagline', 'blog_titles', 'headings'])) $font = $custom_font_name;
				echo "--ak-{$var_id}-font-family: '" . esc_html($font) . "', serif;\n";
				if ($cat === 'headings') {
					for ($i=1;$i<=6;$i++) echo "--ak-h{$i}-font-size: " . esc_html($get_mod("h{$i}_font_size", (array('1'=>'48px','2'=>'36px','3'=>'30px','4'=>'24px','5'=>'20px','6'=>'18px'))[$i])) . ";\n";
				} else {
					echo "--ak-{$var_id}-font-size: " . esc_html($get_mod("{$cat}_font_size", ($cat === 'site_title' ? '2.5rem' : '18px'))) . ";\n";
				}
				echo "--ak-{$var_id}-color: " . esc_html($get_mod("{$cat}_color", in_array($cat, ['site_title', 'site_tagline', 'menus', 'submenus', 'footer']) ? '#ffffff' : '#333333')) . ";\n";
				if ( in_array($cat, ['body', 'menus', 'submenus', 'sidebars', 'footer', 'blog_titles', 'article_text']) ) echo "--ak-{$var_id}-link-color: " . esc_html($get_mod("{$cat}_link_color", '#d4af37')) . ";\n";
				echo "--ak-underline-{$var_id}: " . ($get_mod("{$cat}_underline", in_array($cat, ['body', 'article_text'])) ? 'underline' : 'none') . ";\n";
				$val = '';
				if ($get_mod("{$cat}_shadow_enable", false)) $val .= "2px 2px 4px " . $get_mod("{$cat}_shadow_color", '#000000');
				if ($get_mod("{$cat}_glow_enable", false)) $val .= ($val ? ', ' : '') . "0 0 10px " . $get_mod("{$cat}_glow_color", '#d4af37');
				echo "--ak-effect-{$var_id}: " . ($val ?: 'none') . ";\n";
			}
			?>
			--ak-dropcap-display: <?php echo $get_mod( 'dropcap_enable', true ) ? 'block' : 'none'; ?>;
			--ak-dropcap-font-family: '<?php echo esc_html( $get_mod( 'dropcap_font_family', 'Cinzel' ) ); ?>', serif;
			--ak-dropcap-font-size: <?php echo esc_html( $get_mod( 'dropcap_font_size', '4rem' ) ); ?>;
			--ak-dropcap-color: <?php echo esc_html( $get_mod( 'dropcap_color', '#d4af37' ) ); ?>;
		}
	</style>
	<?php
}
add_action( 'wp_head', 'aspiring_knight_output_css_variables' );

/**
 * Enqueue Google Fonts based on Customizer settings.
 */
function aspiring_knight_enqueue_customizer_fonts() {
	$typos = ['site_title', 'site_tagline', 'menus', 'submenus', 'blog_titles', 'headings', 'article_text', 'sidebars', 'footer', 'body'];
	$fonts = array();
	foreach ($typos as $t) {
		$font = get_theme_mod("{$t}_font_family", in_array($t, ['body', 'menus', 'submenus', 'sidebars', 'footer', 'article_text']) ? 'Lora' : 'Cinzel');
		$fonts[] = $font . ':400,400i,700,700i,900';
	}
	$fonts = array_unique($fonts);
	$fonts_url = add_query_arg( array( 'family' => implode( '|', $fonts ), 'display' => 'swap' ), 'https://fonts.googleapis.com/css' );
	wp_enqueue_style( 'aspiring-knight-customizer-fonts', $fonts_url, array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'aspiring_knight_enqueue_customizer_fonts' );
