<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Fitness_Park
 */

get_header();

$sidebar = esc_attr( get_post_meta($post->ID, 'fitness_park_page_layouts', true ) );

if(!$sidebar){
    $sidebar = get_theme_mod('fitness_park_sidebar_options','right');
}

if ($sidebar == 'no' ) { 

    $col = 12;

} elseif ($sidebar == 'right' || $sidebar == 'left'){

    $col = 8;

}
?>
<div class="blog-post">
    <div class="container">
        <div class="row">

        	<?php if ($sidebar == 'left') { get_sidebar(); } ?>

			<div id="primary" class="content-area col-lg-col-lg-<?php echo intval( $col ); ?> col-md-<?php echo intval( $col ); ?> col-sm-12 col-xs-12">
				<main id="main" class="site-main">
					<?php
						while ( have_posts() ) :
							the_post();

							get_template_part( 'template-parts/content', get_post_type() );

							the_post_navigation();

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

						endwhile; // End of the loop.
					?>

				</main><!-- #main -->
			</div><!-- #primary -->

			<?php if ($sidebar == 'right') { get_sidebar(); } ?>
		</div>
		
	</div>
</div>
<?php get_footer();