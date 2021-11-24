<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Fitness_Park
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-image">
	 	<?php fitness_park_post_thumbnail(); ?>
	</div>

	<div class="entry-content box " >
		<div class="post-the-content">
			<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'fitness-park' ),
				'after'  => '</div>',
			) );
			?>
		</div>
		
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
