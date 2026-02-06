<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Aspiring_Knight
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<?php
$header_layout = get_theme_mod( 'header_layout', 'logo-left' );
$header_bg_image = get_theme_mod( 'header_bg_image', '' );
$header_style = 'padding-top: var(--ak-header-padding); padding-bottom: var(--ak-header-padding);';

if ( $header_bg_image ) {
	$header_style .= 'background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url(' . esc_url( $header_bg_image ) . '); background-size: cover; background-position: center;';
}

$header_class  = 'site-header bg-header-bg text-white';
$container_class = 'site-branding container mx-auto flex flex-col lg:flex-row justify-between items-center';

if ( 'logo-center' === $header_layout ) {
	$container_class = 'site-branding container mx-auto flex flex-col justify-center items-center text-center';
} elseif ( 'logo-right' === $header_layout ) {
	$container_class = 'site-branding container mx-auto flex flex-col lg:flex-row-reverse justify-between items-center';
}
?>
<body <?php body_class( 'bg-site-bg text-body-text font-body text-body leading-body' ); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'aspiring-knight' ); ?></a>

	<?php if ( get_theme_mod( 'show_top_bar', false ) ) : ?>
		<div class="top-bar bg-primary text-white py-2 text-sm">
			<div class="container mx-auto px-4 flex justify-between items-center" style="max-width: var(--ak-container-width);">
				<div class="top-bar-info">
					<?php echo wp_kses_post( get_theme_mod( 'top_bar_text', '' ) ); ?>
				</div>
				<div class="top-bar-social">
					<!-- Social Icons Placeholder -->
				</div>
			</div>
		</div>
	<?php endif; ?>

	<header id="masthead" class="<?php echo esc_attr( $header_class ); ?>" style="<?php echo esc_attr( $header_style ); ?>">
		<div class="<?php echo esc_attr( $container_class ); ?>" style="max-width: var(--ak-container-width);">
			<div class="logo-wrapper mb-4 lg:mb-0">
				<?php
				the_custom_logo();
				if ( is_front_page() && is_home() ) :
					?>
					<h1 class="site-title text-2xl font-headings-bold text-accent font-headings"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
				else :
					?>
					<p class="site-title text-2xl font-headings-bold text-accent font-headings"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
				endif;
				?>
			</div>
			<?php
			$aspiring_knight_description = get_bloginfo( 'description', 'display' );
			if ( $aspiring_knight_description || is_customize_preview() ) :
				?>
				<p class="site-description text-sm italic opacity-75 text-primary"><?php echo $aspiring_knight_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation container mx-auto mt-4 <?php echo 'logo-center' === $header_layout ? 'flex justify-center' : ''; ?>" style="max-width: var(--ak-container-width);">
			<button class="menu-toggle group lg:hidden flex flex-col justify-center items-center w-10 h-10 space-y-1.5 focus:outline-none" aria-controls="primary-menu" aria-expanded="false">
				<span class="block w-6 h-0.5 bg-white transform transition duration-300 ease-in-out group-[.toggled]:rotate-45 group-[.toggled]:translate-y-2"></span>
				<span class="block w-6 h-0.5 bg-white transition duration-300 ease-in-out group-[.toggled]:opacity-0"></span>
				<span class="block w-6 h-0.5 bg-white transform transition duration-300 ease-in-out group-[.toggled]:-rotate-45 group-[.toggled]:translate-y-[-0.5rem]"></span>
				<span class="screen-reader-text"><?php esc_html_e( 'Primary Menu', 'aspiring-knight' ); ?></span>
			</button>
			<div class="menu-container lg:block hidden">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
						'menu_class'     => 'flex flex-col lg:flex-row lg:space-x-8 space-y-4 lg:space-y-0',
					)
				);
				?>
			</div>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->
