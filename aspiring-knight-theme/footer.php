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

	<footer id="colophon" class="site-footer bg-knight-iron text-white py-8 mt-12">
		<div class="site-info container mx-auto text-center text-sm opacity-75">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'aspiring-knight' ) ); ?>" class="hover:text-knight-gold transition-colors">
				<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf( esc_html__( 'Proudly powered by %s', 'aspiring-knight' ), 'WordPress' );
				?>
			</a>
			<span class="sep"> | </span>
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( 'Theme: %1$s by %2$s.', 'aspiring-knight' ), 'Aspiring Knight', '<a href="https://aspiringknight.com" class="hover:text-knight-gold transition-colors">Brian Chabot</a>' );
				?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
