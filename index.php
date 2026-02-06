<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Aspiring_Knight
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
?>

	<main id="primary" class="site-main container mx-auto py-12 px-4">

		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) :
				?>
				<header class="mb-10">
					<h1 class="page-title text-4xl font-bold text-primary"><?php single_post_title(); ?></h1>
				</header>
				<?php
			endif;

			echo '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">';

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'bg-white p-6 rounded-lg shadow-md border-t-4 border-accent flex flex-col' ); ?>>
					<header class="entry-header mb-4">
						<?php the_title( '<h2 class="entry-title text-xl font-bold text-primary hover:text-knight-crimson transition-colors"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
					</header>
					<div class="entry-content text-gray-700 flex-grow medieval-dropcap">
						<?php the_excerpt(); ?>
					</div>
					<footer class="mt-4 pt-4 border-t border-gray-100">
						<a href="<?php echo esc_url( get_permalink() ); ?>" class="text-knight-crimson font-bold hover:text-knight-gold transition-colors"><?php esc_html_e( 'Read More &raquo;', 'aspiring-knight' ); ?></a>
					</footer>
				</article>
				<?php

			endwhile;

			echo '</div>';

			echo '<div class="mt-12">';
			the_posts_navigation();
			echo '</div>';

		else :

			?>
			<section class="no-results not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'aspiring-knight' ); ?></h1>
				</header>
				<div class="page-content">
					<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'aspiring-knight' ); ?></p>
					<?php get_search_form(); ?>
				</div>
			</section>
			<?php

		endif;
		?>

	</main><!-- #primary -->

<?php
get_footer();
