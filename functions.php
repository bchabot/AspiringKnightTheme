<?php
/**
 * Aspiring Knight Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Aspiring Knight
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ASPIRING_KNIGHT_VERSION', '0.2b1' );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function aspiring_knight_setup() {
	load_theme_textdomain( 'aspiring-knight', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'custom-logo', array(
		'height'      => 250,
		'width'       => 250,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'custom-background', apply_filters( 'aspiring_knight_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'responsive-embeds' );

	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'aspiring-knight' ),
	) );
}
add_action( 'after_setup_theme', 'aspiring_knight_setup' );

/**
 * Set the content width in pixels.
 */
function aspiring_knight_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'aspiring_knight_content_width', 640 );
}
add_action( 'after_setup_theme', 'aspiring_knight_content_width', 0 );

/**
 * Register widget area.
 */
function aspiring_knight_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'aspiring-knight' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'aspiring-knight' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Area', 'aspiring-knight' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add footer widgets here.', 'aspiring-knight' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'aspiring_knight_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function aspiring_knight_scripts() {
	wp_enqueue_style( 'aspiring-knight-style', get_stylesheet_uri(), array(), ASPIRING_KNIGHT_VERSION );

	wp_enqueue_style( 'aspiring-knight-tailwind', get_template_directory_uri() . '/assets/css/dist/main.css', array(), ASPIRING_KNIGHT_VERSION );

	wp_enqueue_script( 'aspiring-knight-navigation', get_template_directory_uri() . '/assets/js/src/navigation.js', array(), ASPIRING_KNIGHT_VERSION, true );

	wp_localize_script( 'aspiring-knight-navigation', 'aspiringKnight', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
	) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'aspiring-knight-customize-preview', get_template_directory_uri() . '/assets/js/src/customize-preview.js', array( 'customize-preview', 'jquery' ), ASPIRING_KNIGHT_VERSION, true );

	wp_enqueue_script( 'aspiring-knight-customize-controls', get_template_directory_uri() . '/assets/js/src/customize-controls.js', array( 'customize-controls', 'jquery' ), ASPIRING_KNIGHT_VERSION, true );

	wp_localize_script( 'aspiring-knight-customize-controls', 'akCustomizer', array(
		'restoreFontsNonce' => wp_create_nonce( 'ak_restore_fonts' ),
		'restoreSectionNonce' => wp_create_nonce( 'ak_restore_section' ),
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'aspiring_knight_scripts' );

/**
 * Include Customizer functionality.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * TGM Plugin Activation.
 */
require get_template_directory() . '/inc/tgmpa.php';

/**
 * Allow font file uploads in WordPress.
 */
function aspiring_knight_mime_types( $mimes ) {
	$mimes['ttf']   = 'application/x-font-ttf';
	$mimes['otf']   = 'application/x-font-opentype';
	$mimes['woff']  = 'application/font-woff';
	$mimes['woff2'] = 'font/woff2';
	return $mimes;
}
add_filter( 'upload_mimes', 'aspiring_knight_mime_types' );

/**
 * Force font file type detection to succeed.
 *
 * PHP finfo detects TTF/OTF/WOFF files as 'application/octet-stream', which
 * doesn't match our declared MIME types. This filter overrides the detection
 * result for known font extensions so WordPress validation passes.
 */
function aspiring_knight_fix_font_filetype_check( $result, $ext, $filename, $tmpfname ) {
	$font_ext_map = array(
		'ttf'   => 'application/x-font-ttf',
		'otf'   => 'application/x-font-opentype',
		'woff'  => 'application/font-woff',
		'woff2' => 'font/woff2',
	);
	if ( isset( $font_ext_map[ $ext ] ) ) {
		return array(
			'ext'  => $ext,
			'type' => $font_ext_map[ $ext ],
		);
	}
	return $result;
}
add_filter( 'wp_check_filetype_and_ext', 'aspiring_knight_fix_font_filetype_check', 10, 4 );

/**
 * Explicitly allow font file uploads by clearing any error set during validation.
 */
function aspiring_knight_allow_font_uploads( $file ) {
	$ext = isset( $file['name'] ) ? strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) ) : '';
	$font_exts = array( 'ttf', 'otf', 'woff', 'woff2' );
	if ( in_array( $ext, $font_exts, true ) && ! empty( $file['error'] ) ) {
		$file['error'] = 0;
	}
	return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'aspiring_knight_allow_font_uploads' );