<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Aspiring_Knight
 */

if ( ! is_active_sidebar( 'sidebar-1' ) || 'full-width' === get_theme_mod( 'global_layout', 'sidebar-right' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area w-full lg:w-1/3 order-last lg:order-none" style="order: var(--ak-sidebar-order);">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->
