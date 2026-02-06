<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Aspiring_Knight
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'rounded-lg shadow-md border-t-4 border-accent flex flex-col overflow-hidden' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="post-thumbnail relative h-64 overflow-hidden">
			<?php if ( ! is_singular() ) : ?>
				<a href="<?php echo esc_url( get_permalink() ); ?>" class="block h-full">
					<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-full object-cover transition-transform duration-500 hover:scale-105' ) ); ?>
				</a>
			<?php else : ?>
				<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-full object-cover' ) ); ?>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<div class="p-6 flex flex-col flex-grow">
		<header class="entry-header mb-4">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title text-3xl font-headings text-heading-text font-headings-bold mb-4">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title text-xl font-headings text-heading-text font-headings-bold hover:text-link-hover transition-colors"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
		?>
	</header>

	<div class="entry-content text-gray-700 flex-grow medieval-dropcap">
		<?php
		if ( is_singular() ) :
			the_content();
		else :
			the_excerpt();
		endif;
		?>
	</div>

	<?php if ( ! is_singular() ) : ?>
		<footer class="mt-4 pt-4 border-t border-gray-100">
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="text-link font-bold hover:text-link-hover transition-colors"><?php esc_html_e( 'Read More &raquo;', 'aspiring-knight' ); ?></a>
		</footer>
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
