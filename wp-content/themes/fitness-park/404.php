<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Fitness_Park
 */

get_header(); ?>
	<section class="error-page section">
		<div class="container">
			<div class="row">
				<div id="primary" class="content-area">
					<main id="main" class="site-main">

						<div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
							<div class="error-inner">
								<h1><?php esc_html_e( '404', 'fitness-park' ); ?><span><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'fitness-park' ); ?></span></h1>

								<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'fitness-park' ); ?></p>
								<a class="btn primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fa fa-long-arrow-left"></i><?php esc_html_e( 'Go to home', 'fitness-park' ); ?></a>
							</div>
						</div>

					</main><!-- #main -->
				</div><!-- #primary -->
			</div>
		</div>
	</section>
<?php get_footer();
