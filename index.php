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

	<div class="container mx-auto flex flex-col lg:flex-row gap-12 py-12 px-4" style="max-width: var(--ak-container-width);">
		<main id="primary" class="site-main flex-grow min-w-0">

			<?php
			if ( have_posts() ) :

				if ( is_home() && ! is_front_page() ) :
					?>
					<header class="mb-10">
						<h1 class="page-title text-4xl font-headings text-heading-text font-headings-bold"><?php single_post_title(); ?></h1>
					</header>
					<?php
				endif;

				echo '<div class="grid grid-cols-1 md:grid-cols-2 gap-8">';

				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					/*
					 * Include the Post-Type-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', get_post_type() );

				endwhile;

				echo '</div>';

				echo '<div class="mt-12">';
				the_posts_navigation();
				echo '</div>';

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>

		</main><!-- #primary -->

		<?php get_sidebar(); ?>
	</div>

<?php
get_footer();
