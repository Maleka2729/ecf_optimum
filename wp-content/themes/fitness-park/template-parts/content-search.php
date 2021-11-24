<?php
/**
 * Template part for displaying results in search pages
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
				the_title( '<div class="post-title"><h3><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3></div>' );

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

			<div class="post-the-content archive">
				<?php the_excerpt(); ?>
                <a href="<?php the_permalink(); ?>">
                    <?php echo esc_html_e('Learn More','fitness-park'); ?>
                </a>
			</div>
	</div>

</article><!-- #post-<?php the_ID(); ?> -->
