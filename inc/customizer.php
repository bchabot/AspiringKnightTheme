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
			'priority' => 5,
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
	 * SECTION: Site Colors & Backgrounds
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
		'top_bar_bg_color'     => array( 'label' => __( 'Top Bar Background', 'aspiring-knight' ), 'default' => '#3a3a3a' ),
		'top_bar_text_color'   => array( 'label' => __( 'Top Bar Text Color', 'aspiring-knight' ), 'default' => '#ffffff' ),
		'accent_gold'          => array( 'label' => __( 'Gold Accent / Highlights', 'aspiring-knight' ), 'default' => '#d4af37' ),
		'site_bg_color'        => array( 'label' => __( 'Global Site Background', 'aspiring-knight' ), 'default' => '#f4f4f4' ),
		'article_bg_color'     => array( 'label' => __( 'Article Box Background', 'aspiring-knight' ), 'default' => '#ffffff' ),
		'header_bg_color'      => array( 'label' => __( 'Header Background', 'aspiring-knight' ), 'default' => '#3a3a3a' ),
		'footer_bg_color'      => array( 'label' => __( 'Footer Background', 'aspiring-knight' ), 'default' => '#3a3a3a' ),
		'sidebar_bg_color'     => array( 'label' => __( 'Sidebar Background', 'aspiring-knight' ), 'default' => '#ffffff' ),
		'sidebar_border_color' => array( 'label' => __( 'Sidebar Border', 'aspiring-knight' ), 'default' => '#eeeeee' ),
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
	 * CATEGORICAL SECTIONS CONFIGURATION
	 */
	$wp_customize->add_section( 'ds_typography_section', array( 'title' => esc_html__( 'Typography', 'aspiring-knight' ), 'panel' => 'design_system_panel', 'priority' => 20 ) );
	$wp_customize->add_section( 'ds_navigation_menus_section', array( 'title' => esc_html__( 'Navigation Menus', 'aspiring-knight' ), 'panel' => 'design_system_panel', 'priority' => 30 ) );
	$wp_customize->add_section( 'ds_sidebars_section', array( 'title' => esc_html__( 'Sidebars', 'aspiring-knight' ), 'panel' => 'design_system_panel', 'priority' => 50 ) );
	$wp_customize->add_section( 'ds_footer_section', array( 'title' => esc_html__( 'Footer Area', 'aspiring-knight' ), 'panel' => 'design_system_panel', 'priority' => 55 ) );

	// Navigation menu structural settings inside ds_navigation_menus_section
	$wp_customize->add_setting( 'menu_spacing', array( 'default' => '2rem', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'menu_spacing', array( 'label' => __( 'Menu Item Spacing', 'aspiring-knight' ), 'section' => 'ds_navigation_menus_section', 'type' => 'text', 'description' => __( 'Horizontal space between menu items (e.g. 2rem or 24px).', 'aspiring-knight' ) ) );

	$wp_customize->add_setting( 'menu_bg_color', array( 'default' => 'transparent', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu_bg_color', array( 'label' => __( 'Menu Background Color', 'aspiring-knight' ), 'section' => 'ds_navigation_menus_section' ) ) );

	$wp_customize->add_setting( 'submenu_bg_color', array( 'default' => '#3a3a3a', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'submenu_bg_color', array( 'label' => __( 'Sub-Menu Background Color', 'aspiring-knight' ), 'section' => 'ds_navigation_menus_section' ) ) );

	$categories_config = array(
		'site_title'   => array( 'label' => __( 'Header - Title', 'aspiring-knight' ), 'section' => 'ds_typography_section', 'default_font' => 'Cinzel', 'default_size' => '2.5rem', 'default_color' => '#ffffff' ),
		'site_tagline' => array( 'label' => __( 'Header - Tagline', 'aspiring-knight' ), 'section' => 'ds_typography_section', 'default_font' => 'Cinzel', 'default_size' => '18px', 'default_color' => '#ffffff' ),
		'blog_title'   => array( 'label' => __( 'Blog Post Titles (Single)', 'aspiring-knight' ), 'section' => 'ds_typography_section', 'default_font' => 'Cinzel', 'default_size' => '32px', 'default_color' => '#333333' ),
		'page_title'   => array( 'label' => __( 'Page Titles (Single)', 'aspiring-knight' ), 'section' => 'ds_typography_section', 'default_font' => 'Cinzel', 'default_size' => '32px', 'default_color' => '#333333' ),
		'headings'     => array( 'label' => __( 'Content Headers (H1-H6) Fallback', 'aspiring-knight' ), 'section' => 'ds_typography_section', 'default_font' => 'Cinzel', 'default_size' => '30px', 'default_color' => '#333333' ),
		'h1'           => array( 'label' => __( 'H1 Header', 'aspiring-knight' ), 'section' => 'ds_typography_section', 'default_font' => 'Cinzel', 'default_size' => '48px', 'default_color' => '#333333' ),
		'h2'           => array( 'label' => __( 'H2 Header', 'aspiring-knight' ), 'section' => 'ds_typography_section', 'default_font' => 'Cinzel', 'default_size' => '36px', 'default_color' => '#333333' ),
		'h3'           => array( 'label' => __( 'H3 Header', 'aspiring-knight' ), 'section' => 'ds_typography_section', 'default_font' => 'Cinzel', 'default_size' => '30px', 'default_color' => '#333333' ),
		'h4'           => array( 'label' => __( 'H4 Header', 'aspiring-knight' ), 'section' => 'ds_typography_section', 'default_font' => 'Cinzel', 'default_size' => '24px', 'default_color' => '#333333' ),
		'h5'           => array( 'label' => __( 'H5 Header', 'aspiring-knight' ), 'section' => 'ds_typography_section', 'default_font' => 'Cinzel', 'default_size' => '20px', 'default_color' => '#333333' ),
		'h6'           => array( 'label' => __( 'H6 Header', 'aspiring-knight' ), 'section' => 'ds_typography_section', 'default_font' => 'Cinzel', 'default_size' => '18px', 'default_color' => '#333333' ),
		'body_text'    => array( 'label' => __( 'Body Text', 'aspiring-knight' ), 'section' => 'ds_typography_section', 'default_font' => 'Lora', 'default_size' => '16px', 'default_color' => '#333333' ),
		'body_links'   => array( 'label' => __( 'Body Text Links', 'aspiring-knight' ), 'section' => 'ds_typography_section', 'default_font' => 'Lora', 'default_size' => '16px', 'default_color' => '#d4af37' ),
		
		'menus'        => array( 'label' => __( 'Main Menu Links', 'aspiring-knight' ), 'section' => 'ds_navigation_menus_section', 'default_font' => 'Cinzel', 'default_size' => '18px', 'default_color' => '#ffffff' ),
		'submenus'     => array( 'label' => __( 'Sub-Menu Links', 'aspiring-knight' ), 'section' => 'ds_navigation_menus_section', 'default_font' => 'Lora', 'default_size' => '16px', 'default_color' => '#ffffff' ),
		
		'sidebars'     => array( 'label' => __( 'Sidebar Text', 'aspiring-knight' ), 'section' => 'ds_sidebars_section', 'default_font' => 'Lora', 'default_size' => '16px', 'default_color' => '#333333' ),
		'footer'       => array( 'label' => __( 'Footer Text', 'aspiring-knight' ), 'section' => 'ds_footer_section', 'default_font' => 'Lora', 'default_size' => '16px', 'default_color' => '#ffffff' ),
	);

	foreach ( $categories_config as $id => $cat ) {
		$section_id = $cat['section'];

		// Customize Mode (Default vs Custom)
		$wp_customize->add_setting( "{$id}_custom_type", array( 'default' => 'default', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_custom_type", array(
			'label'       => sprintf( __( '%s Customizer Mode', 'aspiring-knight' ), $cat['label'] ),
			'section'     => $section_id,
			'type'        => 'radio',
			'choices'     => array(
				'default' => __( 'Default (Undefined / Inherit)', 'aspiring-knight' ),
				'custom'  => __( 'Custom Design', 'aspiring-knight' ),
			),
			'description' => sprintf( __( 'Select "Custom Design" to style %s, or "Default" to inherit layouts.', 'aspiring-knight' ), $cat['label'] ),
		) );

		// Customizer active callback for settings of this category
		$is_custom_callback = function( $control ) use ( $id ) {
			return $control->manager->get_setting( "{$id}_custom_type" )->value() === 'custom';
		};

		// Font Family
		$wp_customize->add_setting( "{$id}_font_family", array( 'default' => $cat['default_font'], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_font_family", array(
			'label'           => sprintf( __( '%s Font Family', 'aspiring-knight' ), $cat['label'] ),
			'section'         => $section_id,
			'type'            => 'select',
			'choices'         => aspiring_knight_get_font_choices(),
			'active_callback' => $is_custom_callback,
		) );

		// Font Size
		$wp_customize->add_setting( "{$id}_font_size", array( 'default' => $cat['default_size'], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_font_size", array(
			'label'           => sprintf( __( '%s Font Size', 'aspiring-knight' ), $cat['label'] ),
			'section'         => $section_id,
			'type'            => 'text',
			'description'     => __( 'Example: 16px, 1.5rem, or 2vw.', 'aspiring-knight' ),
			'active_callback' => $is_custom_callback,
		) );

		// Font Weight
		$wp_customize->add_setting( "{$id}_font_weight", array( 'default' => 'inherit', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_font_weight", array(
			'label'           => sprintf( __( '%s Font Weight', 'aspiring-knight' ), $cat['label'] ),
			'section'         => $section_id,
			'type'            => 'select',
			'choices'         => array(
				'inherit' => __( 'Inherit', 'aspiring-knight' ),
				'normal'  => __( 'Normal (400)', 'aspiring-knight' ),
				'bold'    => __( 'Bold (700)', 'aspiring-knight' ),
				'300'     => __( 'Light (300)', 'aspiring-knight' ),
				'500'     => __( 'Medium (500)', 'aspiring-knight' ),
				'600'     => __( 'Semi-Bold (600)', 'aspiring-knight' ),
				'800'     => __( 'Extra-Bold (800)', 'aspiring-knight' ),
				'900'     => __( 'Black (900)', 'aspiring-knight' ),
			),
			'active_callback' => $is_custom_callback,
		) );

		// Em/Italic
		$wp_customize->add_setting( "{$id}_italic", array( 'default' => false, 'sanitize_callback' => 'rest_sanitize_boolean', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_italic", array(
			'label'           => __( 'Make text Em/Italic?', 'aspiring-knight' ),
			'section'         => $section_id,
			'type'            => 'checkbox',
			'active_callback' => $is_custom_callback,
		) );

		// Underline
		$wp_customize->add_setting( "{$id}_underline", array( 'default' => ( $id === 'body_links' ), 'sanitize_callback' => 'rest_sanitize_boolean', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_underline", array(
			'label'           => __( 'Enable Underlining?', 'aspiring-knight' ),
			'section'         => $section_id,
			'type'            => 'checkbox',
			'active_callback' => $is_custom_callback,
		) );

		// Text Color
		$wp_customize->add_setting( "{$id}_color", array( 'default' => $cat['default_color'], 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "{$id}_color", array(
			'label'           => sprintf( __( '%s Text Color', 'aspiring-knight' ), $cat['label'] ),
			'section'         => $section_id,
			'active_callback' => $is_custom_callback,
		) ) );

		// Link Color
		if ( in_array( $id, array( 'body_text', 'menus', 'submenus', 'sidebars', 'footer', 'blog_title', 'page_title' ) ) ) {
			$wp_customize->add_setting( "{$id}_link_color", array( 'default' => '#d4af37', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "{$id}_link_color", array(
				'label'           => sprintf( __( '%s Link Color', 'aspiring-knight' ), $cat['label'] ),
				'section'         => $section_id,
				'active_callback' => $is_custom_callback,
			) ) );
		}

		// Glow Control
		$wp_customize->add_setting( "{$id}_glow_enable", array( 'default' => false, 'sanitize_callback' => 'rest_sanitize_boolean', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_glow_enable", array(
			'label'           => __( 'Enable Glow Effect?', 'aspiring-knight' ),
			'section'         => $section_id,
			'type'            => 'checkbox',
			'active_callback' => $is_custom_callback,
		) );

		$is_glow_callback = function( $control ) use ( $id ) {
			$mgr = $control->manager;
			return $mgr->get_setting( "{$id}_custom_type" )->value() === 'custom' && $mgr->get_setting( "{$id}_glow_enable" )->value();
		};

		$wp_customize->add_setting( "{$id}_glow_color", array( 'default' => '#d4af37', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "{$id}_glow_color", array(
			'label'           => __( 'Glow Color', 'aspiring-knight' ),
			'section'         => $section_id,
			'active_callback' => $is_glow_callback,
		) ) );

		$wp_customize->add_setting( "{$id}_glow_size", array( 'default' => '10px', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_glow_size", array(
			'label'           => __( 'Glow Blur Radius', 'aspiring-knight' ),
			'section'         => $section_id,
			'type'            => 'text',
			'description'     => __( 'Example: 8px, 15px, or 1.2rem.', 'aspiring-knight' ),
			'active_callback' => $is_glow_callback,
		) );

		// Dropshadow Control
		$wp_customize->add_setting( "{$id}_shadow_enable", array( 'default' => false, 'sanitize_callback' => 'rest_sanitize_boolean', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_shadow_enable", array(
			'label'           => __( 'Enable Dropshadow?', 'aspiring-knight' ),
			'section'         => $section_id,
			'type'            => 'checkbox',
			'active_callback' => $is_custom_callback,
		) );

		$is_shadow_callback = function( $control ) use ( $id ) {
			$mgr = $control->manager;
			return $mgr->get_setting( "{$id}_custom_type" )->value() === 'custom' && $mgr->get_setting( "{$id}_shadow_enable" )->value();
		};

		$wp_customize->add_setting( "{$id}_shadow_color", array( 'default' => '#000000', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "{$id}_shadow_color", array(
			'label'           => __( 'Shadow Color', 'aspiring-knight' ),
			'section'         => $section_id,
			'active_callback' => $is_shadow_callback,
		) ) );

		$wp_customize->add_setting( "{$id}_shadow_size", array( 'default' => '2px 2px 4px', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_shadow_size", array(
			'label'           => __( 'Shadow Offset & Blur', 'aspiring-knight' ),
			'section'         => $section_id,
			'type'            => 'text',
			'description'     => __( 'Format: h-offset v-offset blur-radius (e.g. 2px 2px 4px).', 'aspiring-knight' ),
			'active_callback' => $is_shadow_callback,
		) );

		// Drop Caps (Nested decoration settings per category)
		$wp_customize->add_setting( "{$id}_dropcaps_enable", array( 'default' => false, 'sanitize_callback' => 'rest_sanitize_boolean', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_dropcaps_enable", array(
			'label'           => __( 'Enable Drop Caps?', 'aspiring-knight' ),
			'section'         => $section_id,
			'type'            => 'checkbox',
			'active_callback' => $is_custom_callback,
		) );

		$is_dropcaps_callback = function( $control ) use ( $id ) {
			$mgr = $control->manager;
			return $mgr->get_setting( "{$id}_custom_type" )->value() === 'custom' && $mgr->get_setting( "{$id}_dropcaps_enable" )->value();
		};

		$wp_customize->add_setting( "{$id}_dropcaps_color", array( 'default' => '#d4af37', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "{$id}_dropcaps_color", array(
			'label'           => __( 'Drop Caps Color', 'aspiring-knight' ),
			'section'         => $section_id,
			'active_callback' => $is_dropcaps_callback,
		) ) );

		$wp_customize->add_setting( "{$id}_dropcaps_size", array( 'default' => '4rem', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_dropcaps_size", array(
			'label'           => __( 'Drop Caps Size', 'aspiring-knight' ),
			'section'         => $section_id,
			'type'            => 'text',
			'description'     => __( 'Example: 4rem, 64px, or 5em.', 'aspiring-knight' ),
			'active_callback' => $is_dropcaps_callback,
		) );
	}

	// Legacy global dropcap controls override body_text if present (for backward compatibility)
	$wp_customize->add_setting( 'dropcap_enable', array( 'default' => true, 'sanitize_callback' => 'rest_sanitize_boolean', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'dropcap_enable', array( 'label' => __( 'Legacy Global Drop Cap?', 'aspiring-knight' ), 'section' => 'ds_typography_section', 'type' => 'checkbox', 'description' => __( 'Legacy toggle for global body first-letter styling.', 'aspiring-knight' ) ) );
	$wp_customize->add_setting( 'dropcap_font_family', array( 'default' => 'Cinzel', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'dropcap_font_family', array( 'label' => __( 'Legacy Drop Cap Font', 'aspiring-knight' ), 'section' => 'ds_typography_section', 'type' => 'select', 'choices' => aspiring_knight_get_font_choices() ) );
	$wp_customize->add_setting( 'dropcap_font_size', array( 'default' => '4rem', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'dropcap_font_size', array( 'label' => __( 'Legacy Drop Cap Size', 'aspiring-knight' ), 'section' => 'ds_typography_section', 'type' => 'text' ) );
	$wp_customize->add_setting( 'dropcap_color', array( 'default' => '#d4af37', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dropcap_color', array( 'label' => __( 'Legacy Drop Cap Color', 'aspiring-knight' ), 'section' => 'ds_typography_section' ) ) );

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
	$choices = array(
		'default'       => __( 'Select Preset...', 'aspiring-knight' ),
		'medieval'      => '🏰 ' . __( 'Medieval Influence (Serif / Gold)', 'aspiring-knight' ),
		'modern'        => '📱 ' . __( 'Modern Minimalist (Sans / Blue)', 'aspiring-knight' ),
		'dark'          => '🌙 ' . __( 'Knight of the Night (Dark Mode)', 'aspiring-knight' ),
		'monochrome'    => '🪨 ' . __( 'Iron & Stone (Monochrome)', 'aspiring-knight' ),
		'high_contrast' => '⚡ ' . __( 'High Contrast (Accessibility)', 'aspiring-knight' ),
	);
	$custom_presets = json_decode( get_theme_mod( 'custom_presets_data', '{}' ), true );
	if ( ! empty( $custom_presets ) ) {
		foreach ( $custom_presets as $id => $data ) {
			$choices[ $id ] = '👤 ' . $data['name'];
		}
	}
	return $choices;
}

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
		'Open Sans'        => 'Open Sans (Clean Sans)'
	);
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
			$categories_config = array(
				'site_title'   => array( 'default_font' => 'Cinzel', 'default_size' => '2.5rem', 'default_color' => '#ffffff' ),
				'site_tagline' => array( 'default_font' => 'Cinzel', 'default_size' => '18px', 'default_color' => '#ffffff' ),
				'blog_title'   => array( 'default_font' => 'Cinzel', 'default_size' => '32px', 'default_color' => '#333333' ),
				'page_title'   => array( 'default_font' => 'Cinzel', 'default_size' => '32px', 'default_color' => '#333333' ),
				'headings'     => array( 'default_font' => 'Cinzel', 'default_size' => '30px', 'default_color' => '#333333' ),
				'h1'           => array( 'default_font' => 'Cinzel', 'default_size' => '48px', 'default_color' => '#333333' ),
				'h2'           => array( 'default_font' => 'Cinzel', 'default_size' => '36px', 'default_color' => '#333333' ),
				'h3'           => array( 'default_font' => 'Cinzel', 'default_size' => '30px', 'default_color' => '#333333' ),
				'h4'           => array( 'default_font' => 'Cinzel', 'default_size' => '24px', 'default_color' => '#333333' ),
				'h5'           => array( 'default_font' => 'Cinzel', 'default_size' => '20px', 'default_color' => '#333333' ),
				'h6'           => array( 'default_font' => 'Cinzel', 'default_size' => '18px', 'default_color' => '#333333' ),
				'body_text'    => array( 'default_font' => 'Lora', 'default_size' => '16px', 'default_color' => '#333333' ),
				'body_links'   => array( 'default_font' => 'Lora', 'default_size' => '16px', 'default_color' => '#d4af37' ),
				'menus'        => array( 'default_font' => 'Cinzel', 'default_size' => '18px', 'default_color' => '#ffffff' ),
				'submenus'     => array( 'default_font' => 'Lora', 'default_size' => '16px', 'default_color' => '#ffffff' ),
				'sidebars'     => array( 'default_font' => 'Lora', 'default_size' => '16px', 'default_color' => '#333333' ),
				'footer'       => array( 'default_font' => 'Lora', 'default_size' => '16px', 'default_color' => '#ffffff' ),
			);

			foreach ($categories_config as $id => $cat) {
				$var_id = str_replace('_', '-', $id);
				$custom_type = $get_mod("{$id}_custom_type", 'default');

				if ($custom_type === 'custom') {
					$font = $get_mod("{$id}_font_family", $cat['default_font']);
					if ($use_custom_headings && $custom_font_file && in_array($id, array('site_title', 'site_tagline', 'blog_title', 'page_title', 'headings', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'))) {
						$font = $custom_font_name;
					}
					$size = $get_mod("{$id}_font_size", $cat['default_size']);
					$weight = $get_mod("{$id}_font_weight", 'inherit');
					$style = $get_mod("{$id}_italic", false) ? 'italic' : 'normal';
					$color = $get_mod("{$id}_color", $cat['default_color']);
					$link_color = isset($cat['default_color']) ? $get_mod("{$id}_link_color", '#d4af37') : 'inherit';
					$underline = $get_mod("{$id}_underline", false) ? 'underline' : 'none';

					// Effects
					$val = '';
					if ($get_mod("{$id}_shadow_enable", false)) {
						$val .= $get_mod("{$id}_shadow_size", '2px 2px 4px') . ' ' . $get_mod("{$id}_shadow_color", '#000000');
					}
					if ($get_mod("{$id}_glow_enable", false)) {
						$val .= ($val ? ', ' : '') . '0 0 ' . $get_mod("{$id}_glow_size", '10px') . ' ' . $get_mod("{$id}_glow_color", '#d4af37');
					}
					$effect = $val ?: 'none';

					// Drop Caps
					$drop_display = $get_mod("{$id}_dropcaps_enable", false) ? 'block' : 'none';
					$drop_color = $get_mod("{$id}_dropcaps_color", '#d4af37');
					$drop_size = $get_mod("{$id}_dropcaps_size", '4rem');
				} else {
					// Fallbacks when leaving on Default (Inherit)
					$font = 'inherit';
					$size = 'inherit';
					$weight = 'inherit';
					$style = 'inherit';
					$color = 'inherit';
					$link_color = 'inherit';
					$underline = 'inherit';
					$effect = 'none';
					$drop_display = 'none';
					$drop_color = 'inherit';
					$drop_size = 'inherit';
				}

				echo "--ak-{$var_id}-font-family: '" . esc_html($font) . "', serif;\n";
				echo "--ak-{$var_id}-font-size: " . esc_html($size) . ";\n";
				echo "--ak-{$var_id}-font-weight: " . esc_html($weight) . ";\n";
				echo "--ak-{$var_id}-font-style: " . esc_html($style) . ";\n";
				echo "--ak-{$var_id}-color: " . esc_html($color) . ";\n";
				echo "--ak-{$var_id}-link-color: " . esc_html($link_color) . ";\n";
				echo "--ak-underline-{$var_id}: " . esc_html($underline) . ";\n";
				echo "--ak-effect-{$var_id}: " . esc_html($effect) . ";\n";
				echo "--ak-dropcap-display-{$var_id}: " . esc_html($drop_display) . ";\n";
				echo "--ak-dropcap-color-{$var_id}: " . esc_html($drop_color) . ";\n";
				echo "--ak-dropcap-font-size-{$var_id}: " . esc_html($drop_size) . ";\n";
			}
			?>

			/* Legacy global dropcap setting output for backward compatibility */
			<?php if ( $get_mod( 'dropcap_enable', true ) ) : ?>
			--ak-dropcap-display: block;
			--ak-dropcap-float: left;
			--ak-dropcap-font-family: '<?php echo esc_html( $get_mod( 'dropcap_font_family', 'Cinzel' ) ); ?>', serif;
			--ak-dropcap-font-size: <?php echo esc_html( $get_mod( 'dropcap_font_size', '4rem' ) ); ?>;
			--ak-dropcap-line-height: 1;
			--ak-dropcap-margin: 0.1em 0.1em 0 0;
			--ak-dropcap-color: <?php echo esc_html( $get_mod( 'dropcap_color', '#d4af37' ) ); ?>;
			--ak-dropcap-font-weight: bold;
			<?php else : ?>
			--ak-dropcap-display: inline;
			--ak-dropcap-float: none;
			--ak-dropcap-font-family: inherit;
			--ak-dropcap-font-size: inherit;
			--ak-dropcap-line-height: inherit;
			--ak-dropcap-margin: 0;
			--ak-dropcap-color: inherit;
			--ak-dropcap-font-weight: inherit;
			<?php endif; ?>
		}
	</style>
	<?php
}
add_action( 'wp_head', 'aspiring_knight_output_css_variables' );

/**
 * Enqueue Google Fonts based on Customizer settings.
 */
function aspiring_knight_enqueue_customizer_fonts() {
	$typos = array('site_title', 'site_tagline', 'blog_title', 'page_title', 'headings', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'body_text', 'body_links', 'menus', 'submenus', 'sidebars', 'footer');
	$fonts = array();
	foreach ($typos as $t) {
		$custom_type = get_theme_mod("{$t}_custom_type", 'default');
		if ($custom_type === 'custom') {
			$font = get_theme_mod("{$t}_font_family", in_array($t, array('body_text', 'body_links', 'menus', 'submenus', 'sidebars', 'footer')) ? 'Lora' : 'Cinzel');
			$fonts[] = $font . ':300,400,400i,500,600,700,700i,800,900';
		}
	}
	// Fallback/Default core theme fonts are always loaded
	$fonts[] = 'Cinzel:400,700,900';
	$fonts[] = 'Lora:400,400i,700,700i';

	$fonts = array_unique($fonts);
	$fonts_url = add_query_arg( array( 'family' => implode( '|', $fonts ), 'display' => 'swap' ), 'https://fonts.googleapis.com/css' );
	wp_enqueue_style( 'aspiring-knight-customizer-fonts', $fonts_url, array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'aspiring_knight_enqueue_customizer_fonts' );
