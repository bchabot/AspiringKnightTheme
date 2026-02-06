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
}

/**
 * Output CSS variables based on Customizer settings.
 */
function aspiring_knight_output_css_variables() {
	$primary_color = get_theme_mod( 'primary_color', '#3a3a3a' );
	$accent_gold   = get_theme_mod( 'accent_gold', '#d4af37' );
	?>
	<style id="aspiring-knight-customizer-variables">
		:root {
			--ak-primary-color: <?php echo esc_html( $primary_color ); ?>;
			--ak-accent-gold: <?php echo esc_html( $accent_gold ); ?>;
		}
	</style>
	<?php
}
add_action( 'wp_head', 'aspiring_knight_output_css_variables' );
