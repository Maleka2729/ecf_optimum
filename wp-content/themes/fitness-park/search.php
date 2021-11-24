<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Fitness_Park
 */

get_header();

$sidebar = get_theme_mod( 'fitness_park_sidebar_options', 'right' );

if ($sidebar == 'no') {
	$col = 12;
}
else{
	$col = 8;
}
?>   
<section id="primary" class="content-area blog-post">
	<div class="container">
	    <div class="row">

	    	<?php if ($sidebar == 'left') { get_sidebar(); } ?>

	    	<div class="content-area content-area col-lg-<?php echo intval( $col ); ?> col-md-<?php echo intval($col ); ?> col-sm-12 col-xs-12 ">
				<main id="main" class="site-main">

					<?php if ( have_posts() ) : 

						/* Start the Loop */
						while ( have_posts() ) :
							the_post();

							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'template-parts/content', 'search' );

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
			</div>
			
			<?php if ($sidebar == 'right') { get_sidebar(); } ?>
		</div>
	</div>
</section><!-- #primary -->

<?php get_footer();