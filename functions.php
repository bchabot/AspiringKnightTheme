<?php
/**
 * Aspiring Knight theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Aspiring_Knight
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function aspiring_knight_setup() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'aspiring-knight' ),
		)
	);

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for custom background.
	 */
	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'f4f4f4',
			'default-image' => '',
		)
	);

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'aspiring_knight_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function aspiring_knight_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'aspiring-knight' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'aspiring-knight' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s bg-white p-6 rounded-lg shadow-sm mb-8">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title text-lg font-headings font-headings-bold mb-4 pb-2 border-b border-gray-100">',
			'after_title'   => '</h2>',
		)
	);

	for ( $i = 1; $i <= 4; $i++ ) {
		register_sidebar(
			array(
				'name'          => sprintf( esc_html__( 'Footer %d', 'aspiring-knight' ), $i ),
				'id'            => 'footer-' . $i,
				'description'   => sprintf( esc_html__( 'Add widgets here for footer column %d.', 'aspiring-knight' ), $i ),
				'before_widget' => '<section id="%1$s" class="widget %2$s mb-8">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title text-lg font-headings font-headings-bold mb-4">',
				'after_title'   => '</h2>',
			)
		);
	}
}
add_action( 'widgets_init', 'aspiring_knight_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function aspiring_knight_scripts() {
	wp_enqueue_style( 'aspiring-knight-style', get_stylesheet_uri(), array(), '0.2.0b' );

	// Enqueue Compiled Tailwind CSS.
	wp_enqueue_style( 'aspiring-knight-tailwind', get_template_directory_uri() . '/assets/css/dist/main.css', array(), '0.2.0b' );

	// Navigation script.
	wp_enqueue_script( 'aspiring-knight-navigation', get_template_directory_uri() . '/assets/js/src/navigation.js', array(), '0.2.0b', true );
}
add_action( 'wp_enqueue_scripts', 'aspiring_knight_scripts' );

/**
 * Add layout classes to the body.
 */
function aspiring_knight_body_classes( $classes ) {
	$layout = get_theme_mod( 'global_layout', 'sidebar-right' );
	$classes[] = 'layout-' . $layout;

	if ( 'full-width' === $layout || ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'aspiring_knight_body_classes' );

/**
 * Enqueue JS for Customizer live preview.
 */
function aspiring_knight_customize_preview_js() {
	wp_enqueue_script( 'aspiring-knight-customize-preview', get_template_directory_uri() . '/assets/js/src/customize-preview.js', array( 'customize-preview', 'jquery' ), '0.2.0b', true );
}
add_action( 'customize_preview_init', 'aspiring_knight_customize_preview_js' );

/**
 * Enqueue JS for Customizer controls (Presets).
 */
function aspiring_knight_customize_controls_js() {
	wp_enqueue_script( 'aspiring-knight-customize-controls', get_template_directory_uri() . '/assets/js/src/customize-controls.js', array( 'customize-controls', 'jquery' ), '0.2.0b', true );
	wp_localize_script( 'aspiring-knight-customize-controls', 'akRestoreFontsNonce', wp_create_nonce( 'ak_restore_fonts' ) );
}
add_action( 'customize_controls_enqueue_scripts', 'aspiring_knight_customize_controls_js' );

/**
 * TGM Plugin Activation.
 */
require get_template_directory() . '/inc/tgmpa.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Allow font file uploads in WordPress.
 */
function aspiring_knight_mime_types( $mimes ) {
	$mimes['ttf']   = 'application/x-font-ttf';
	$mimes['otf']   = 'application/x-font-opentype';
	$mimes['woff']  = 'application/font-woff';
	$mimes['woff2'] = 'font/woff2';
	error_log( 'AK DEBUG ttf in mimes: ' . ( isset( $mimes['ttf'] ) ? 'YES (' . $mimes['ttf'] . ')' : 'NO' ) );
	error_log( 'AK DEBUG otf in mimes: ' . ( isset( $mimes['otf'] ) ? 'YES (' . $mimes['otf'] . ')' : 'NO' ) );
	return $mimes;
}
add_filter( 'upload_mimes', 'aspiring_knight_mime_types' );

/**
 * Add font extensions to Multisite allowed file types.
 */
function aspiring_knight_enable_font_uploads() {
	if ( is_multisite() ) {
		$raw = get_site_option( 'upload_filetypes', '' );
		$site_types = is_array( $raw ) ? $raw : explode( ' ', $raw );
		error_log( 'AK DEBUG multisite upload_filetypes: ' . print_r( $site_types, true ) );
		$font_exts = array( 'ttf', 'otf', 'woff', 'woff2' );
		$missing = array_diff( $font_exts, $site_types );
		if ( ! empty( $missing ) ) {
			$site_types = array_unique( array_merge( $site_types, $font_exts ) );
			update_site_option( 'upload_filetypes', $site_types );
			error_log( 'AK DEBUG added missing font exts to upload_filetypes: ' . print_r( $missing, true ) );
		}
	}
}
add_action( 'init', 'aspiring_knight_enable_font_uploads' );
add_action( 'after_switch_theme', 'aspiring_knight_enable_font_uploads' );

/**
 * Debug: Log wp_handle_upload_prefilter to find what's blocking font uploads.
 */
function aspiring_knight_debug_prefilter( $file ) {
	$ext = isset( $file['name'] ) ? pathinfo( $file['name'], PATHINFO_EXTENSION ) : '';
	$font_exts = array( 'ttf', 'otf', 'woff', 'woff2' );
	if ( in_array( strtolower( $ext ), $font_exts, true ) ) {
		error_log( 'AK DEBUG prefilter for font (ext=' . $ext . '): name=' . $file['name'] . ' type=' . ( $file['type'] ?? 'none' ) . ' error=' . ( $file['error'] ?? 'none' ) );
	}
	if ( ! empty( $file['error'] ) && in_array( strtolower( $ext ), $font_exts, true ) ) {
		error_log( 'AK DEBUG prefilter BLOCKED font: ' . $file['error'] );
	}
	return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'aspiring_knight_debug_prefilter', 1 );
