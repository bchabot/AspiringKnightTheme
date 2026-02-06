<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Aspiring_Knight
 */

get_header();
?>

<?php
$archive_layout = get_theme_mod( 'archive_layout', 'grid' );
$grid_class = 'grid grid-cols-1 md:grid-cols-2 gap-8';
if ( 'list' === $archive_layout ) {
	$grid_class = 'flex flex-col gap-8';
}
?>
	<div class="container mx-auto flex flex-col lg:flex-row gap-12 py-12 px-4" style="max-width: var(--ak-container-width);">
		<main id="primary" class="site-main flex-grow min-w-0">

			<?php if ( have_posts() ) : ?>

				<header class="page-header mb-10">
					<?php
					the_archive_title( '<h1 class="page-title text-4xl font-headings text-heading-text font-headings-bold">', '</h1>' );
					the_archive_description( '<div class="archive-description text-gray-600 italic mt-2">', '</div>' );
					?>
				</header><!-- .page-header -->

				<div class="<?php echo esc_attr( $grid_class ); ?>">
					<?php
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
					?>
				</div>

				<?php
				the_posts_navigation();

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>

		</main><!-- #primary -->

		<?php get_sidebar(); ?>
	</div>

<?php
get_footer();