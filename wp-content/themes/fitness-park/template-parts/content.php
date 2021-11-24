<?php
/**
 * Template part for displaying posts
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
	
	<div class="box">
		<div class="entry-header">
			<?php
				if ( is_singular() ) :
					the_title( '<div class="post-title"><h3 class="entry-title">', '</h3></div>' );
				else :
					the_title( '<div class="post-title"><h3><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3></div>' );
				endif;

				if ( 'post' === get_post_type() ) :
			?>
				<div class=" entry-meta postmeta">
		        	<ul>
		        		<li>
		        			<span class="author vcard">
		        				<?php fitness_park_posted_by(); ?>
		        			</span>
		        		</li>
		        		<li>
		        			<span class="author vcard">
		        				<?php fitness_park_posted_on(); ?>
		        			</span>
		        		</li>
		                <li>
		                	<span class="author vcard"><?php fitness_park_category(); ?></span>
		                </li>
		        	</ul>
				</div>

			<?php endif; ?>

		</div><!-- .entry-header -->

		<?php if (is_singular()) : ?>
		
			<div class="entry-content post-the-content">
				<?php
					the_content( sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'fitness-park' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					) );

					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'fitness-park' ),
						'after'  => '</div>',
					) );
				?>
			</div><!-- .entry-content -->
		<?php else : ?>

			<div class="post-the-content archive">

				<?php the_excerpt(); ?>

                <a href="<?php the_permalink(); ?>">
                    <?php echo esc_html_e('Learn More','fitness-park'); ?>
                </a>

			</div>

		<?php endif; ?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
