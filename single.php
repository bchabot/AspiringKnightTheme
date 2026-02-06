<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Aspiring_Knight
 */

get_header();
?>

	<div class="site-content-wrapper">
		<div class="container mx-auto flex flex-col lg:flex-row gap-12 py-12 px-4" style="max-width: var(--ak-container-width);">
		<main id="primary" class="site-main flex-grow min-w-0">

			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', get_post_type() );

				the_post_navigation(
					array(
						'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'aspiring-knight' ) . '</span> <span class="nav-title">%title</span>',
						'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'aspiring-knight' ) . '</span> <span class="nav-title">%title</span>',
					)
				);

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #primary -->

		<?php get_sidebar(); ?>
	</div>
	</div>

<?php
get_footer();