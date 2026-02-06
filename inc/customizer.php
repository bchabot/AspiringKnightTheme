<?php
/**
 * Aspiring Knight Customizer configuration
 *
 * @package Aspiring_Knight
 */

if ( class_exists( 'Kirki' ) ) {
	Kirki::add_config(
		'aspiring_knight',
		array(
			'capability'    => 'edit_theme_options',
			'option_type'   => 'theme_mod',
		)
	);

	/**
	 * Global Styles Panel
	 */
	Kirki::add_panel(
		'global_styles_panel',
		array(
			'priority'    => 10,
			'title'       => esc_html__( 'Global Styles', 'aspiring-knight' ),
			'description' => esc_html__( 'Global theme colors and typography.', 'aspiring-knight' ),
		)
	);

	/**
	 * Colors Section
	 */
	Kirki::add_section(
		'colors_section',
		array(
			'title'    => esc_html__( 'Colors', 'aspiring-knight' ),
			'panel'    => 'global_styles_panel',
			'priority' => 10,
		)
	);

	/**
	 * Primary Color Field
	 */
	Kirki::add_field(
		'aspiring_knight',
		array(
			'type'        => 'color',
			'settings'    => 'primary_color',
			'label'       => esc_html__( 'Primary Color', 'aspiring-knight' ),
			'description' => esc_html__( 'Select the primary brand color.', 'aspiring-knight' ),
			'section'     => 'colors_section',
			'default'     => '#3a3a3a',
			'transport'   => 'postMessage',
		)
	);

	/**
	 * Accent Color Field (Gold)
	 */
	Kirki::add_field(
		'aspiring_knight',
		array(
			'type'        => 'color',
			'settings'    => 'accent_gold',
			'label'       => esc_html__( 'Accent Gold', 'aspiring-knight' ),
			'description' => esc_html__( 'Used for buttons, highlights, and icons.', 'aspiring-knight' ),
			'section'     => 'colors_section',
			'default'     => '#d4af37',
			'transport'   => 'postMessage',
		)
	);

	/**
	 * Site Background Color
	 */
	Kirki::add_field(
		'aspiring_knight',
		array(
			'type'        => 'color',
			'settings'    => 'site_bg_color',
			'label'       => esc_html__( 'Site Background', 'aspiring-knight' ),
			'section'     => 'colors_section',
			'default'     => '#f4f4f4',
			'transport'   => 'postMessage',
		)
	);

	/**
	 * Header Background Color
	 */
	Kirki::add_field(
		'aspiring_knight',
		array(
			'type'        => 'color',
			'settings'    => 'header_bg_color',
			'label'       => esc_html__( 'Header Background', 'aspiring-knight' ),
			'section'     => 'colors_section',
			'default'     => '#ffffff',
			'transport'   => 'postMessage',
		)
	);

	/**
	 * Footer Background Color
	 */
	Kirki::add_field(
		'aspiring_knight',
		array(
			'type'        => 'color',
			'settings'    => 'footer_bg_color',
			'label'       => esc_html__( 'Footer Background', 'aspiring-knight' ),
			'section'     => 'colors_section',
			'default'     => '#3a3a3a',
			'transport'   => 'postMessage',
		)
	);

	/**
	 * Body Text Color
	 */
	Kirki::add_field(
		'aspiring_knight',
		array(
			'type'        => 'color',
			'settings'    => 'body_text_color',
			'label'       => esc_html__( 'Body Text Color', 'aspiring-knight' ),
			'section'     => 'colors_section',
			'default'     => '#333333',
			'transport'   => 'postMessage',
		)
	);

	/**
	 * Heading Text Color
	 */
	Kirki::add_field(
		'aspiring_knight',
		array(
			'type'        => 'color',
			'settings'    => 'heading_text_color',
			'label'       => esc_html__( 'Heading Text Color', 'aspiring-knight' ),
			'section'     => 'colors_section',
			'default'     => '#1a1a1a',
			'transport'   => 'postMessage',
		)
	);

	/**
	 * Link Color
	 */
	Kirki::add_field(
		'aspiring_knight',
		array(
			'type'        => 'color',
			'settings'    => 'link_color',
			'label'       => esc_html__( 'Link Color', 'aspiring-knight' ),
			'section'     => 'colors_section',
			'default'     => '#8b0000',
			'transport'   => 'postMessage',
		)
	);

	/**
	 * Link Hover Color
	 */
	Kirki::add_field(
		'aspiring_knight',
		array(
			'type'        => 'color',
			'settings'    => 'link_hover_color',
			'label'       => esc_html__( 'Link Hover Color', 'aspiring-knight' ),
			'section'     => 'colors_section',
			'default'     => '#d4af37',
			'transport'   => 'postMessage',
		)
	);
}

/**
 * Output CSS variables based on Customizer settings.
 */
function aspiring_knight_output_css_variables() {
	$primary_color     = get_theme_mod( 'primary_color', '#3a3a3a' );
	$accent_gold       = get_theme_mod( 'accent_gold', '#d4af37' );
	$site_bg_color     = get_theme_mod( 'site_bg_color', '#f4f4f4' );
	$header_bg_color   = get_theme_mod( 'header_bg_color', '#ffffff' );
	$footer_bg_color   = get_theme_mod( 'footer_bg_color', '#3a3a3a' );
	$body_text_color   = get_theme_mod( 'body_text_color', '#333333' );
	$heading_text_color = get_theme_mod( 'heading_text_color', '#1a1a1a' );
	$link_color        = get_theme_mod( 'link_color', '#8b0000' );
	$link_hover_color  = get_theme_mod( 'link_hover_color', '#d4af37' );
	?>
	<style id="aspiring-knight-customizer-variables">
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
		}
	</style>
	<?php
}
add_action( 'wp_head', 'aspiring_knight_output_css_variables' );
