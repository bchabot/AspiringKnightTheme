<?php
/**
 * Aspiring Knight Customizer configuration
 *
 * @package Aspiring_Knight
 */

// Custom Section class to support nested sections inside other sections
if ( class_exists( 'WP_Customize_Section' ) ) {
	class Aspiring_Knight_Nested_Section extends WP_Customize_Section {
		public $type = 'aspiring_knight_nested_section';
		public $section = '';

		public function json() {
			$array = parent::json();
			$array['section'] = $this->section;
			return $array;
		}
	}
}

// Custom Control for Restore Default Fonts button
if ( class_exists( 'WP_Customize_Control' ) ) {
	class Aspiring_Knight_Restore_Fonts_Control extends WP_Customize_Control {
		public $type = 'ak_restore_fonts';

		public function render_content() {
			?>
			<label>
				<input type="checkbox" value="" <?php checked( $this->value(), '' ); ?> />
				<?php echo esc_html( $this->label ); ?>
			</label>
			<?php if ( $this->description ) : ?>
				<span class="description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>
			<?php
		}
	}
}

/**
 * Sanitize JSON data for custom presets.
 */
function aspiring_knight_sanitize_json( $value ) {
	$decoded = json_decode( $value, true );
	if ( is_array( $decoded ) || $value === '{}' ) {
		return wp_json_encode( $decoded ? $decoded : array() );
	}
	return '{}';
}

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
			'title'       => esc_html__( '✨ Theme Presets', 'aspiring-knight' ),
			'panel'       => 'design_system_panel',
			'priority'    => 5,
			'description' => esc_html__( 'Apply a complete design preset to instantly change your site\'s appearance. You can also save your current settings as a custom preset.', 'aspiring-knight' ),
		)
	);

	$wp_customize->add_setting( 'custom_presets_data', array( 'default' => '{}', 'sanitize_callback' => 'aspiring_knight_sanitize_json', 'transport' => 'postMessage' ) );
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
			'title'       => esc_html__( 'Site Colors & Backgrounds', 'aspiring-knight' ),
			'panel'       => 'design_system_panel',
			'priority'    => 10,
			'description' => esc_html__( 'Control the color scheme and background images for different areas of your site.', 'aspiring-knight' ),
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
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array(
			'label'    => $data['label'],
			'section'  => 'site_colors_section',
			'settings' => $id,
		) ) );
	}

	$wp_customize->add_setting( 'background_image', array( 'transport' => 'refresh', 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'background_image', array(
		'label'    => __( 'Global Background Image', 'aspiring-knight' ),
		'section'  => 'site_colors_section',
		'settings' => 'background_image',
	) ) );

	$wp_customize->add_setting( 'article_bg_image', array( 'transport' => 'refresh', 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'article_bg_image', array(
		'label'    => __( 'Article Box Background Image', 'aspiring-knight' ),
		'section'  => 'site_colors_section',
		'settings' => 'article_bg_image',
	) ) );

	/**
	 * CATEGORICAL SECTIONS CONFIGURATION (with nested Section Hierarchy)
	 */
	$wp_customize->register_section_type( 'Aspiring_Knight_Nested_Section' );

	// Typography Main Section (Parent Category inside Design System)
	$wp_customize->add_section( 'ds_typography_section', array(
		'title'       => esc_html__( 'Typography', 'aspiring-knight' ),
		'panel'       => 'design_system_panel',
		'priority'    => 20,
		'description' => esc_html__( 'Control the typography for all elements on your site. Each section below allows you to override default styles with custom typography settings.', 'aspiring-knight' ),
	) );

	// Typography Sub-Sections (First Nesting Level under ds_typography_section)
	$wp_customize->add_section( new Aspiring_Knight_Nested_Section( $wp_customize, 'ds_header_section', array(
		'title'       => esc_html__( 'Header', 'aspiring-knight' ),
		'section'     => 'ds_typography_section',
		'priority'    => 10,
		'description' => esc_html__( 'Configure typography for your site header, including the title and tagline.', 'aspiring-knight' ),
	) ) );

	$wp_customize->add_section( new Aspiring_Knight_Nested_Section( $wp_customize, 'ds_blog_title_section', array(
		'title'       => esc_html__( 'Blog Post Titles (Single)', 'aspiring-knight' ),
		'section'     => 'ds_typography_section',
		'priority'    => 20,
		'description' => esc_html__( 'Configure typography for individual blog post titles.', 'aspiring-knight' ),
	) ) );

	$wp_customize->add_section( new Aspiring_Knight_Nested_Section( $wp_customize, 'ds_page_title_section', array(
		'title'       => esc_html__( 'Page Titles (Single)', 'aspiring-knight' ),
		'section'     => 'ds_typography_section',
		'priority'    => 30,
		'description' => esc_html__( 'Configure typography for individual page titles.', 'aspiring-knight' ),
	) ) );

	$wp_customize->add_section( new Aspiring_Knight_Nested_Section( $wp_customize, 'ds_headings_section', array(
		'title'       => esc_html__( 'Content Headers (H1-H6)', 'aspiring-knight' ),
		'section'     => 'ds_typography_section',
		'priority'    => 40,
		'description' => esc_html__( 'Configure typography for content headings (H1-H6). You can set individual styles for each heading level, or use the fallback settings for all.', 'aspiring-knight' ),
	) ) );

	$wp_customize->add_section( new Aspiring_Knight_Nested_Section( $wp_customize, 'ds_body_text_section', array(
		'title'       => esc_html__( 'Body Text', 'aspiring-knight' ),
		'section'     => 'ds_typography_section',
		'priority'    => 50,
		'description' => esc_html__( 'Configure typography for the main body text content.', 'aspiring-knight' ),
	) ) );

	$wp_customize->add_section( new Aspiring_Knight_Nested_Section( $wp_customize, 'ds_body_links_section', array(
		'title'       => esc_html__( 'Body Text Links', 'aspiring-knight' ),
		'section'     => 'ds_typography_section',
		'priority'    => 60,
		'description' => esc_html__( 'Configure typography for links within body text content.', 'aspiring-knight' ),
	) ) );

	// Default/Custom Radio Buttons for each typography section
	$typo_sections = array(
		'ds_header_section'     => array( 'label' => __( 'Header', 'aspiring-knight' ), 'desc' => __( 'Choose "Custom" to override default header typography.', 'aspiring-knight' ) ),
		'ds_blog_title_section' => array( 'label' => __( 'Blog Post Titles', 'aspiring-knight' ), 'desc' => __( 'Choose "Custom" to override default blog post title typography.', 'aspiring-knight' ) ),
		'ds_page_title_section' => array( 'label' => __( 'Page Titles', 'aspiring-knight' ), 'desc' => __( 'Choose "Custom" to override default page title typography.', 'aspiring-knight' ) ),
		'ds_headings_section'   => array( 'label' => __( 'Content Headers', 'aspiring-knight' ), 'desc' => __( 'Choose "Custom" to override default content header typography.', 'aspiring-knight' ) ),
		'ds_body_text_section'  => array( 'label' => __( 'Body Text', 'aspiring-knight' ), 'desc' => __( 'Choose "Custom" to override default body text typography.', 'aspiring-knight' ) ),
		'ds_body_links_section' => array( 'label' => __( 'Body Text Links', 'aspiring-knight' ), 'desc' => __( 'Choose "Custom" to override default body link typography.', 'aspiring-knight' ) ),
	);

	foreach ( $typo_sections as $section_id => $config ) {
		$setting_id = $section_id . '_mode';
		$wp_customize->add_setting( $setting_id, array(
			'default'           => 'default',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( $setting_id, array(
			'label'       => $config['label'] . ' ' . __( 'Mode', 'aspiring-knight' ),
			'section'     => $section_id,
			'type'        => 'radio',
			'description' => $config['desc'],
			'choices'     => array(
				'default' => __( 'Default (Inherit)', 'aspiring-knight' ),
				'custom'  => __( 'Custom', 'aspiring-knight' ),
			),
		) );
	}

	// Grandchild Sections (Second Nesting Level under ds_header_section)
	$wp_customize->add_section( new Aspiring_Knight_Nested_Section( $wp_customize, 'ds_site_title_section', array(
		'title'       => esc_html__( 'Title', 'aspiring-knight' ),
		'section'     => 'ds_header_section',
		'priority'    => 10,
		'description' => esc_html__( 'Configure the typography for your site title (e.g., "My Website").', 'aspiring-knight' ),
	) ) );

	$wp_customize->add_section( new Aspiring_Knight_Nested_Section( $wp_customize, 'ds_site_tagline_section', array(
		'title'       => esc_html__( 'Tagline', 'aspiring-knight' ),
		'section'     => 'ds_header_section',
		'priority'    => 20,
		'description' => esc_html__( 'Configure the typography for your site tagline (e.g., "A medieval adventure").', 'aspiring-knight' ),
	) ) );

	// Grandchild Sections (Second Nesting Level under ds_headings_section)
	for ( $i = 1; $i <= 6; $i++ ) {
		$wp_customize->add_section( new Aspiring_Knight_Nested_Section( $wp_customize, "ds_h{$i}_section", array(
			'title'       => sprintf( esc_html__( 'H%d', 'aspiring-knight' ), $i ),
			'section'     => 'ds_headings_section',
			'priority'    => $i * 10,
			'description' => sprintf( esc_html__( 'Configure typography for H%d content headers.', 'aspiring-knight' ), $i ),
		) ) );
	}

	// Other sections (Standard direct sections under panel)
	$wp_customize->add_section( 'ds_navigation_menus_section', array(
		'title'       => esc_html__( 'Navigation Menus', 'aspiring-knight' ),
		'panel'       => 'design_system_panel',
		'priority'    => 30,
		'description' => esc_html__( 'Configure typography and styling for your navigation menus and sub-menus.', 'aspiring-knight' ),
	) );
	$wp_customize->add_section( 'ds_sidebars_section', array(
		'title'       => esc_html__( 'Sidebars', 'aspiring-knight' ),
		'panel'       => 'design_system_panel',
		'priority'    => 50,
		'description' => esc_html__( 'Configure typography and styling for sidebar widgets.', 'aspiring-knight' ),
	) );
	$wp_customize->add_section( 'ds_footer_section', array(
		'title'       => esc_html__( 'Footer Area', 'aspiring-knight' ),
		'panel'       => 'design_system_panel',
		'priority'    => 55,
		'description' => esc_html__( 'Configure typography and styling for the footer area.', 'aspiring-knight' ),
	) );

	// Navigation menu structural settings inside ds_navigation_menus_section
	$wp_customize->add_setting( 'menu_spacing', array( 'default' => '2rem', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'menu_spacing', array( 'label' => __( 'Menu Item Spacing', 'aspiring-knight' ), 'section' => 'ds_navigation_menus_section', 'type' => 'text', 'description' => __( 'Horizontal space between menu items (e.g. 2rem or 24px).', 'aspiring-knight' ) ) );

	$wp_customize->add_setting( 'menu_bg_color', array( 'default' => 'transparent', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu_bg_color', array(
		'label'    => __( 'Menu Background Color', 'aspiring-knight' ),
		'section'  => 'ds_navigation_menus_section',
		'settings' => 'menu_bg_color',
	) ) );

	$wp_customize->add_setting( 'submenu_bg_color', array( 'default' => '#3a3a3a', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'submenu_bg_color', array(
		'label'    => __( 'Sub-Menu Background Color', 'aspiring-knight' ),
		'section'  => 'ds_navigation_menus_section',
		'settings' => 'submenu_bg_color',
	) ) );

	$categories_config = array(
		'site_title'   => array( 'label' => __( 'Title', 'aspiring-knight' ), 'section' => 'ds_site_title_section', 'default_font' => 'Cinzel', 'default_size' => '2.5rem', 'default_color' => '#ffffff', 'has_dropcaps' => false, 'has_link_color' => false ),
		'site_tagline' => array( 'label' => __( 'Tagline', 'aspiring-knight' ), 'section' => 'ds_site_tagline_section', 'default_font' => 'Cinzel', 'default_size' => '18px', 'default_color' => '#ffffff', 'has_dropcaps' => false, 'has_link_color' => false ),
		'blog_title'   => array( 'label' => __( 'Blog Post Titles (Single)', 'aspiring-knight' ), 'section' => 'ds_blog_title_section', 'default_font' => 'Cinzel', 'default_size' => '32px', 'default_color' => '#333333', 'has_dropcaps' => false, 'has_link_color' => false ),
		'page_title'   => array( 'label' => __( 'Page Titles (Single)', 'aspiring-knight' ), 'section' => 'ds_page_title_section', 'default_font' => 'Cinzel', 'default_size' => '32px', 'default_color' => '#333333', 'has_dropcaps' => false, 'has_link_color' => false ),
		'headings'     => array( 'label' => __( 'Content Headers Fallback', 'aspiring-knight' ), 'section' => 'ds_headings_section', 'default_font' => 'Cinzel', 'default_size' => '30px', 'default_color' => '#333333', 'has_dropcaps' => false, 'has_link_color' => false ),
		'h1'           => array( 'label' => __( 'H1', 'aspiring-knight' ), 'section' => 'ds_h1_section', 'default_font' => 'Cinzel', 'default_size' => '48px', 'default_color' => '#333333', 'has_dropcaps' => false, 'has_link_color' => false ),
		'h2'           => array( 'label' => __( 'H2', 'aspiring-knight' ), 'section' => 'ds_h2_section', 'default_font' => 'Cinzel', 'default_size' => '36px', 'default_color' => '#333333', 'has_dropcaps' => false, 'has_link_color' => false ),
		'h3'           => array( 'label' => __( 'H3', 'aspiring-knight' ), 'section' => 'ds_h3_section', 'default_font' => 'Cinzel', 'default_size' => '30px', 'default_color' => '#333333', 'has_dropcaps' => false, 'has_link_color' => false ),
		'h4'           => array( 'label' => __( 'H4', 'aspiring-knight' ), 'section' => 'ds_h4_section', 'default_font' => 'Cinzel', 'default_size' => '24px', 'default_color' => '#333333', 'has_dropcaps' => false, 'has_link_color' => false ),
		'h5'           => array( 'label' => __( 'H5', 'aspiring-knight' ), 'section' => 'ds_h5_section', 'default_font' => 'Cinzel', 'default_size' => '20px', 'default_color' => '#333333', 'has_dropcaps' => false, 'has_link_color' => false ),
		'h6'           => array( 'label' => __( 'H6', 'aspiring-knight' ), 'section' => 'ds_h6_section', 'default_font' => 'Cinzel', 'default_size' => '18px', 'default_color' => '#333333', 'has_dropcaps' => false, 'has_link_color' => false ),
		'body_text'    => array( 'label' => __( 'Body Text', 'aspiring-knight' ), 'section' => 'ds_body_text_section', 'default_font' => 'Lora', 'default_size' => '16px', 'default_color' => '#333333', 'has_dropcaps' => true, 'has_link_color' => false ),
		'body_links'   => array( 'label' => __( 'Body Text Links', 'aspiring-knight' ), 'section' => 'ds_body_links_section', 'default_font' => 'Lora', 'default_size' => '16px', 'default_color' => '#d4af37', 'has_dropcaps' => false, 'has_link_color' => false ),
		
		'menus'        => array( 'label' => __( 'Main Menu Links', 'aspiring-knight' ), 'section' => 'ds_navigation_menus_section', 'default_font' => 'Cinzel', 'default_size' => '18px', 'default_color' => '#ffffff', 'has_dropcaps' => false, 'has_link_color' => true ),
		'submenus'     => array( 'label' => __( 'Sub-Menu Links', 'aspiring-knight' ), 'section' => 'ds_navigation_menus_section', 'default_font' => 'Lora', 'default_size' => '16px', 'default_color' => '#ffffff', 'has_dropcaps' => false, 'has_link_color' => true ),
		
		'sidebars'     => array( 'label' => __( 'Sidebar Text', 'aspiring-knight' ), 'section' => 'ds_sidebars_section', 'default_font' => 'Lora', 'default_size' => '16px', 'default_color' => '#333333', 'has_dropcaps' => false, 'has_link_color' => true ),
		'footer'       => array( 'label' => __( 'Footer Text', 'aspiring-knight' ), 'section' => 'ds_footer_section', 'default_font' => 'Lora', 'default_size' => '16px', 'default_color' => '#ffffff', 'has_dropcaps' => false, 'has_link_color' => true ),
	);

	foreach ( $categories_config as $id => $cat ) {
		$section_id = $cat['section'];

		// Font Family
		$wp_customize->add_setting( "{$id}_font_family", array( 'default' => $cat['default_font'], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_font_family", array(
			'label'           => sprintf( __( '%s Font Family', 'aspiring-knight' ), $cat['label'] ),
			'section'         => $section_id,
			'type'            => 'select',
			'choices'         => aspiring_knight_get_font_choices(),
		) );

		// Font Size
		$wp_customize->add_setting( "{$id}_font_size", array( 'default' => $cat['default_size'], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_font_size", array(
			'label'           => sprintf( __( '%s Font Size', 'aspiring-knight' ), $cat['label'] ),
			'section'         => $section_id,
			'type'            => 'text',
			'description'     => __( 'Example: 16px, 1.5rem, or 2vw.', 'aspiring-knight' ),
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
		) );

		// Em/Italic
		$wp_customize->add_setting( "{$id}_italic", array( 'default' => false, 'sanitize_callback' => 'rest_sanitize_boolean', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_italic", array(
			'label'           => __( 'Make text Em/Italic?', 'aspiring-knight' ),
			'section'         => $section_id,
			'type'            => 'checkbox',
		) );

		// Underline
		$wp_customize->add_setting( "{$id}_underline", array( 'default' => ( $id === 'body_links' ), 'sanitize_callback' => 'rest_sanitize_boolean', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_underline", array(
			'label'           => __( 'Enable Underlining?', 'aspiring-knight' ),
			'section'         => $section_id,
			'type'            => 'checkbox',
		) );

		// Text Color
		$wp_customize->add_setting( "{$id}_color", array( 'default' => $cat['default_color'], 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "{$id}_color", array(
			'label'           => sprintf( __( '%s Text Color', 'aspiring-knight' ), $cat['label'] ),
			'section'         => $section_id,
			'settings'        => "{$id}_color",
		) ) );

		// Link Color
		if ( ! empty( $cat['has_link_color'] ) ) {
			$wp_customize->add_setting( "{$id}_link_color", array( 'default' => '#d4af37', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "{$id}_link_color", array(
				'label'           => sprintf( __( '%s Link Color', 'aspiring-knight' ), $cat['label'] ),
				'section'         => $section_id,
				'settings'        => "{$id}_link_color",
			) ) );
		}

		// Glow Control
		$wp_customize->add_setting( "{$id}_glow_enable", array( 'default' => false, 'sanitize_callback' => 'rest_sanitize_boolean', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_glow_enable", array(
			'label'           => __( 'Enable Glow Effect?', 'aspiring-knight' ),
			'section'         => $section_id,
			'type'            => 'checkbox',
		) );

		$wp_customize->add_setting( "{$id}_glow_color", array( 'default' => '#d4af37', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "{$id}_glow_color", array(
			'label'           => __( 'Glow Color', 'aspiring-knight' ),
			'section'         => $section_id,
			'settings'        => "{$id}_glow_color",
		) ) );

		$wp_customize->add_setting( "{$id}_glow_size", array( 'default' => '10px', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_glow_size", array(
			'label'           => __( 'Glow Blur Radius', 'aspiring-knight' ),
			'section'         => $section_id,
			'type'            => 'text',
			'description'     => __( 'Example: 8px, 15px, or 1.2rem.', 'aspiring-knight' ),
		) );

		// Dropshadow Control
		$wp_customize->add_setting( "{$id}_shadow_enable", array( 'default' => false, 'sanitize_callback' => 'rest_sanitize_boolean', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_shadow_enable", array(
			'label'           => __( 'Enable Dropshadow?', 'aspiring-knight' ),
			'section'         => $section_id,
			'type'            => 'checkbox',
		) );

		$wp_customize->add_setting( "{$id}_shadow_color", array( 'default' => '#000000', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "{$id}_shadow_color", array(
			'label'           => __( 'Shadow Color', 'aspiring-knight' ),
			'section'         => $section_id,
			'settings'        => "{$id}_shadow_color",
		) ) );

		$wp_customize->add_setting( "{$id}_shadow_size", array( 'default' => '2px 2px 4px', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( "{$id}_shadow_size", array(
			'label'           => __( 'Shadow Offset & Blur', 'aspiring-knight' ),
			'section'         => $section_id,
			'type'            => 'text',
			'description'     => __( 'Format: h-offset v-offset blur-radius (e.g. 2px 2px 4px).', 'aspiring-knight' ),
		) );

		// Drop Caps (Only for categories that make sense)
		if ( ! empty( $cat['has_dropcaps'] ) ) {
			$wp_customize->add_setting( "{$id}_dropcaps_enable", array( 'default' => false, 'sanitize_callback' => 'rest_sanitize_boolean', 'transport' => 'postMessage' ) );
			$wp_customize->add_control( "{$id}_dropcaps_enable", array(
				'label'           => __( 'Enable Drop Caps?', 'aspiring-knight' ),
				'section'         => $section_id,
				'type'            => 'checkbox',
				'description'     => __( 'Display a large decorative first letter at the start of paragraphs.', 'aspiring-knight' ),
			) );

			$wp_customize->add_setting( "{$id}_dropcaps_color", array( 'default' => '#d4af37', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "{$id}_dropcaps_color", array(
				'label'           => __( 'Drop Caps Color', 'aspiring-knight' ),
				'section'         => $section_id,
				'settings'        => "{$id}_dropcaps_color",
			) ) );

			$wp_customize->add_setting( "{$id}_dropcaps_size", array( 'default' => '4rem', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
			$wp_customize->add_control( "{$id}_dropcaps_size", array(
				'label'           => __( 'Drop Caps Size', 'aspiring-knight' ),
				'section'         => $section_id,
				'type'            => 'text',
				'description'     => __( 'Example: 4rem, 64px, or 5em.', 'aspiring-knight' ),
			) );
		}
	}

	// Legacy global dropcap controls override body_text if present (for backward compatibility)
	$wp_customize->add_setting( 'dropcap_enable', array( 'default' => true, 'sanitize_callback' => 'rest_sanitize_boolean', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'dropcap_enable', array( 'label' => __( 'Legacy Global Drop Cap?', 'aspiring-knight' ), 'section' => 'ds_typography_section', 'type' => 'checkbox', 'description' => __( 'Legacy toggle for global body first-letter styling.', 'aspiring-knight' ) ) );
	$wp_customize->add_setting( 'dropcap_font_family', array( 'default' => 'Cinzel', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'dropcap_font_family', array( 'label' => __( 'Legacy Drop Cap Font', 'aspiring-knight' ), 'section' => 'ds_typography_section', 'type' => 'select', 'choices' => aspiring_knight_get_font_choices() ) );
	$wp_customize->add_setting( 'dropcap_font_size', array( 'default' => '4rem', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'dropcap_font_size', array( 'label' => __( 'Legacy Drop Cap Size', 'aspiring-knight' ), 'section' => 'ds_typography_section', 'type' => 'text' ) );
	$wp_customize->add_setting( 'dropcap_color', array( 'default' => '#d4af37', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dropcap_color', array(
		'label'    => __( 'Legacy Drop Cap Color', 'aspiring-knight' ),
		'section'  => 'ds_typography_section',
		'settings' => 'dropcap_color',
	) ) );

	// Custom Fonts Section
	$wp_customize->add_section( 'ds_custom_fonts_section', array(
		'title'       => esc_html__( 'Custom Fonts', 'aspiring-knight' ),
		'panel'       => 'design_system_panel',
		'priority'    => 25,
		'description' => esc_html__( 'Specify which fonts are available for use throughout the theme. Choose from Google Fonts or upload your own font files.', 'aspiring-knight' ),
	) );

	// Custom Font Selection (Google Fonts)
	$wp_customize->add_setting( 'custom_google_font', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'custom_google_font', array(
		'label'       => __( 'Google Font', 'aspiring-knight' ),
		'section'     => 'ds_custom_fonts_section',
		'type'        => 'select',
		'description' => __( 'Select a Google Font to use across your site. This will be available in all font family dropdowns.', 'aspiring-knight' ),
		'choices'     => array_merge( array( '' => __( '-- None --', 'aspiring-knight' ) ), aspiring_knight_get_google_font_choices() ),
	) );

	// Custom Font Name (for uploaded fonts)
	$wp_customize->add_setting( 'custom_font_name', array(
		'default'           => 'CustomFont',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'custom_font_name', array(
		'label'       => __( 'Custom Font Name', 'aspiring-knight' ),
		'section'     => 'ds_custom_fonts_section',
		'type'        => 'text',
		'description' => __( 'Enter a name for your custom font (e.g., "MyFont"). This name will appear in font family dropdowns.', 'aspiring-knight' ),
	) );

	// Custom Font File Upload
	$wp_customize->add_setting( 'custom_font_file', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 'custom_font_file', array(
		'label'       => __( 'Upload Custom Font', 'aspiring-knight' ),
		'section'     => 'ds_custom_fonts_section',
		'description' => __( 'Upload a TTF, OTF, WOFF, or WOFF2 font file. This font will be added to all font family dropdowns.', 'aspiring-knight' ),
		'mime_type'   => array(
			'font/ttf',
			'font/otf',
			'font/woff',
			'font/woff2',
			'application/x-font-ttf',
			'application/x-font-otf',
			'application/font-woff',
			'application/font-woff2',
		),
	) ) );

	// Use custom font for headings toggle
	$wp_customize->add_setting( 'use_custom_font_headings', array(
		'default'           => false,
		'sanitize_callback' => 'rest_sanitize_boolean',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'use_custom_font_headings', array(
		'label'       => __( 'Use Custom Font for Headings', 'aspiring-knight' ),
		'section'     => 'ds_custom_fonts_section',
		'type'        => 'checkbox',
		'description' => __( 'When enabled, your custom font will be automatically applied to all heading elements (site title, tagline, content headers).', 'aspiring-knight' ),
	) );

	// Restore Default Fonts button (using a custom control for button behavior)
	$wp_customize->add_setting( 'restore_default_fonts', array(
		'default'           => false,
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new Aspiring_Knight_Restore_Fonts_Control( $wp_customize, 'restore_default_fonts', array(
		'label'       => __( 'Restore Default Fonts', 'aspiring-knight' ),
		'section'     => 'ds_custom_fonts_section',
		'description' => __( 'Click to reset all font selections to their default values.', 'aspiring-knight' ),
	) ) );

	$wp_customize->add_section( 'branding_assets_section', array( 'title' => esc_html__( 'Header & Branding Assets', 'aspiring-knight' ), 'panel' => 'design_system_panel', 'priority' => 100 ) );
	$wp_customize->add_setting( 'site_title_banner', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', 'transport' => 'refresh' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'site_title_banner', array(
		'label'    => __( 'Banner Image', 'aspiring-knight' ),
		'section'  => 'branding_assets_section',
		'settings' => 'site_title_banner',
	) ) );
	$wp_customize->add_setting( 'header_bg_image', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', 'transport' => 'refresh' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_bg_image', array(
		'label'    => __( 'Header Background Image', 'aspiring-knight' ),
		'section'  => 'branding_assets_section',
		'settings' => 'header_bg_image',
	) ) );

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
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'footer_bg_image', array(
		'label'    => __( 'Footer Background Image', 'aspiring-knight' ),
		'section'  => 'ds_footer_layout_section',
		'settings' => 'footer_bg_image',
	) ) );
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
	$fonts = array(
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

	// Add custom Google Font if selected
	$custom_google_font = get_theme_mod( 'custom_google_font', '' );
	if ( ! empty( $custom_google_font ) && ! isset( $fonts[ $custom_google_font ] ) ) {
		$fonts[ $custom_google_font ] = $custom_google_font . ' (Google Font)';
	}

	// Add custom uploaded font if present
	$custom_font_name = get_theme_mod( 'custom_font_name', 'CustomFont' );
	$custom_font_file = get_theme_mod( 'custom_font_file', '' );
	if ( ! empty( $custom_font_file ) && ! empty( $custom_font_name ) && ! isset( $fonts[ $custom_font_name ] ) ) {
		$fonts[ $custom_font_name ] = $custom_font_name . ' (Custom Upload)';
	}

	return $fonts;
}

/**
 * Get Google Font choices for the font selection dropdown.
 */
function aspiring_knight_get_google_font_choices() {
	return array(
		'Lora'              => 'Lora',
		'Cinzel'            => 'Cinzel',
		'MedievalSharp'     => 'MedievalSharp',
		'EB Garamond'       => 'EB Garamond',
		'Playfair Display'  => 'Playfair Display',
		'Libre Baskerville' => 'Libre Baskerville',
		'Almendra'          => 'Almendra',
		'Crimson Text'      => 'Crimson Text',
		'Montserrat'        => 'Montserrat',
		'Open Sans'         => 'Open Sans',
		'Roboto'            => 'Roboto',
		'Lato'              => 'Lato',
		'Raleway'           => 'Raleway',
		'Poppins'           => 'Poppins',
		'Nunito'            => 'Nunito',
		'Source Sans Pro'   => 'Source Sans Pro',
		'Ubuntu'            => 'Ubuntu',
		'Merriweather'      => 'Merriweather',
		'PT Serif'          => 'PT Serif',
		'Oswald'            => 'Oswald',
		'Muli'              => 'Muli',
		'Noto Sans'         => 'Noto Sans',
		'Noto Serif'        => 'Noto Serif',
		'Rubik'             => 'Rubik',
		'Work Sans'         => 'Work Sans',
		'Josefin Sans'      => 'Josefin Sans',
		'Quicksand'         => 'Quicksand',
		'Pathway Gothic One'=> 'Pathway Gothic One',
		'IM Fell English'   => 'IM Fell English',
		'Cardo'             => 'Cardo',
		'Old Standard TT'   => 'Old Standard TT',
		'Spectral'          => 'Spectral',
		'Cormorant Garamond'=> 'Cormorant Garamond',
		'Libre Caslon Text' => 'Libre Caslon Text',
		'Bitter'            => 'Bitter',
		'Arvo'              => 'Arvo',
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
	$custom_google_font = $get_mod( 'custom_google_font', '' );
	$use_custom_headings = $get_mod( 'use_custom_font_headings', false );
	$article_bg_image = $get_mod( 'article_bg_image', '' );
	$restore_default_fonts = $get_mod( 'restore_default_fonts', false );

	// If restore default fonts is checked, clear custom font settings
	if ( $restore_default_fonts ) {
		$custom_font_file = '';
		$custom_font_name = 'CustomFont';
		$custom_google_font = '';
	}
	?>
	<style id="aspiring-knight-customizer-variables">
		<?php if ( $custom_font_file ) :
			// Detect font format from file extension
			$font_ext = pathinfo( $custom_font_file, PATHINFO_EXTENSION );
			$font_format = 'truetype';
			if ( in_array( strtolower( $font_ext ), array( 'woff2' ) ) ) {
				$font_format = 'woff2';
			} elseif ( in_array( strtolower( $font_ext ), array( 'woff' ) ) ) {
				$font_format = 'woff';
			} elseif ( in_array( strtolower( $font_ext ), array( 'otf', 'otc' ) ) ) {
				$font_format = 'opentype';
			} elseif ( in_array( strtolower( $font_ext ), array( 'ttf', 'ttc' ) ) ) {
				$font_format = 'truetype';
			}
		?>
		@font-face {
			font-family: '<?php echo esc_html( $custom_font_name ); ?>';
			src: url('<?php echo esc_url( $custom_font_file ); ?>') format('<?php echo esc_html( $font_format ); ?>');
			font-display: swap;
		}
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
		$font = get_theme_mod("{$t}_font_family", in_array($t, array('body_text', 'body_links', 'menus', 'submenus', 'sidebars', 'footer')) ? 'Lora' : 'Cinzel');
		$fonts[] = $font . ':300,400,400i,500,600,700,700i,800,900';
	}

	// Add custom Google Font if selected
	$custom_google_font = get_theme_mod( 'custom_google_font', '' );
	if ( ! empty( $custom_google_font ) ) {
		$fonts[] = $custom_google_font . ':300,400,400i,500,600,700,700i,800,900';
	}

	// Fallback/Default core theme fonts are always loaded
	$fonts[] = 'Cinzel:400,700,900';
	$fonts[] = 'Lora:400,400i,700,700i';

	$fonts = array_unique($fonts);
	$fonts_url = add_query_arg( array( 'family' => implode( '|', $fonts ), 'display' => 'swap' ), 'https://fonts.googleapis.com/css' );
	wp_enqueue_style( 'aspiring-knight-customizer-fonts', $fonts_url, array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'aspiring_knight_enqueue_customizer_fonts' );

/**
 * Handle Restore Default Fonts AJAX request.
 */
function aspiring_knight_restore_default_fonts() {
	if ( ! isset( $_POST['ak_restore_fonts_nonce'] ) || ! wp_verify_nonce( $_POST['ak_restore_fonts_nonce'], 'ak_restore_fonts' ) ) {
		return;
	}

	// Reset all font-related theme_mods to defaults
	$font_settings = array(
		'custom_google_font'   => '',
		'custom_font_name'     => 'CustomFont',
		'custom_font_file'     => '',
		'use_custom_font_headings' => false,
	);

	// Reset typography section modes
	$typo_sections = array(
		'ds_header_section_mode',
		'ds_blog_title_section_mode',
		'ds_page_title_section_mode',
		'ds_headings_section_mode',
		'ds_body_text_section_mode',
		'ds_body_links_section_mode',
	);

	// Reset font family settings for all categories
	$categories = array(
		'site_title', 'site_tagline', 'blog_title', 'page_title', 'headings',
		'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'body_text', 'body_links',
		'menus', 'submenus', 'sidebars', 'footer'
	);

	$default_fonts = array(
		'body_text' => 'Lora',
		'body_links' => 'Lora',
		'menus' => 'Cinzel',
		'submenus' => 'Lora',
		'sidebars' => 'Lora',
		'footer' => 'Lora',
	);

	foreach ( $categories as $cat ) {
		$font_settings["{$cat}_font_family"] = isset( $default_fonts[ $cat ] ) ? $default_fonts[ $cat ] : 'Cinzel';
	}

	// Apply all resets
	foreach ( array_merge( $font_settings, array_fill_keys( $typo_sections, 'default' ) ) as $key => $value ) {
		set_theme_mod( $key, $value );
	}

	wp_send_json_success( array( 'message' => __( 'Font settings have been reset to defaults.', 'aspiring-knight' ) ) );
}
add_action( 'wp_ajax_ak_restore_fonts', 'aspiring_knight_restore_default_fonts' );

/**
 * Enqueue Customizer admin controls styles for nested sections animation.
 */
function aspiring_knight_customize_controls_styles() {
	?>
	<style>
		/* Customizer Nested Sections Animations & Fixes */
		#customize-theme-controls .customize-pane-child.current-section-parent {
			transform: translateX(-100%) !important;
			display: block !important;
		}
		.in-sub-section #customize-controls .wp-full-overlay-sidebar-content {
			overflow: visible !important;
		}
		/* Ensure color pickers display current values */
		.wp-color-picker {
			width: 100% !important;
			max-width: 200px;
		}
		.wp-picker-container .wp-color-result {
			width: 30px;
			height: 30px;
			margin: 0;
		}
	</style>
	<?php
}
add_action( 'customize_controls_print_styles', 'aspiring_knight_customize_controls_styles' );
