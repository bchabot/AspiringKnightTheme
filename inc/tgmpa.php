<?php
/**
 * TGM Plugin Activation configuration
 *
 * @package Aspiring_Knight
 */

require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'aspiring_knight_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 */
function aspiring_knight_register_required_plugins() {
	$plugins = array();

	$config = array(
		'id'           => 'aspiring-knight',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $plugins, $config );
}
