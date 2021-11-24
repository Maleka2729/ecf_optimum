<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Fitness_Park
 */

$post_sidebar = esc_attr( get_post_meta($post->ID, 'fitness_park_page_layouts', true) );

if(!$post_sidebar){
	$post_sidebar = 'right';
}

if ( $post_sidebar ==  'no' ) {
	return;
}


if( $post_sidebar == 'right' && is_active_sidebar('sidebar-1')){
	?>
		<aside id="secondary" class="sidebar widget-area col-lg-4 col-md-4 col-sm-12">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</aside><!-- #secondary -->
	<?php
}

if( $post_sidebar == 'left' && is_active_sidebar('sidebar-2')){
	?>
		<aside id="secondary" class="sidebar widget-area col-lg-4 col-md-4 col-sm-12">
			<?php dynamic_sidebar( 'sidebar-2' ); ?>
		</aside><!-- #secondary -->
	<?php
}