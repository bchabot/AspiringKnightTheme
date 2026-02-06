<?php
/**
 * The footer for our theme
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Aspiring_Knight
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<?php
$footer_columns = get_theme_mod( 'footer_columns', 3 );
$copyright_text = get_theme_mod( 'copyright_text', 'Proudly powered by WordPress' );
$footer_bg_image = get_theme_mod( 'footer_bg_image', '' );
$footer_style = '';

if ( $footer_bg_image ) {
	$footer_style = 'background-image: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url(' . esc_url( $footer_bg_image ) . '); background-size: cover; background-position: center;';
}

$grid_class = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-' . $footer_columns . ' gap-12';
?>

	<footer id="colophon" class="site-footer bg-footer-bg text-white py-12 mt-12" style="<?php echo esc_attr( $footer_style ); ?>">
		<div class="container mx-auto px-4" style="max-width: var(--ak-container-width);">
			
			<?php if ( $footer_columns > 0 ) : ?>
				<div class="<?php echo esc_attr( $grid_class ); ?> mb-12 border-b border-white/10 pb-12">
					<?php
					for ( $i = 1; $i <= $footer_columns; $i++ ) {
						if ( is_active_sidebar( 'footer-' . $i ) ) {
							echo '<div class="footer-column">';
							dynamic_sidebar( 'footer-' . $i );
							echo '</div>';
						}
					}
					?>
				</div>
			<?php endif; ?>

			<div class="site-info text-center text-sm opacity-75">
				<div class="copyright-content mb-2">
					<?php echo wp_kses_post( str_replace( '[year]', date( 'Y' ), $copyright_text ) ); ?>
				</div>
				<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'aspiring-knight' ) ); ?>" class="hover:text-accent transition-colors">
					<?php
					/* translators: %s: CMS name, i.e. WordPress. */
					printf( esc_html__( 'Proudly powered by %s', 'aspiring-knight' ), 'WordPress' );
					?>
				</a>
				<span class="sep"> | </span>
					<?php
					/* translators: 1: Theme name, 2: Theme author. */
					printf( esc_html__( 'Theme: %1$s by %2$s.', 'aspiring-knight' ), 'Aspiring Knight', '<a href="https://aspiringknight.com" class="hover:text-accent transition-colors">Brian Chabot</a>' );
					?>
			</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
