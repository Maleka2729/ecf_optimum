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
 * @package Fitness_Park
 */

get_header();

$sidebar = get_theme_mod('fitness_park_sidebar_options','right');

if ($sidebar == 'no') {
	$col = 12;
}
else{
	$col = 8;
}
?>
<div class="container blog-post">
    <div class="row">
    	<?php if ($sidebar == 'left') { get_sidebar(); } ?>

		<div id="primary" class="content-area col-lg-<?php echo intval( $col ); ?> col-md-<?php echo intval( $col ); ?> col-sm-12 col-xs-12 ">
			<main id="main" class="site-main">
				<?php
				if ( have_posts() ) :

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

					the_posts_pagination( 
                        array(
                            'prev_text' => esc_html__( 'Prev', 'fitness-park' ),
                            'next_text' => esc_html__( 'Next', 'fitness-park' ),
                        )
                    );

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>
			</main><!-- #main -->
		</div><!-- #primary -->
		<?php if ($sidebar == 'right') { get_sidebar(); } ?>
	</div>
</div>

<?php get_footer();
