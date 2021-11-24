<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Fitness_Park
 */

if ( ! function_exists( 'fitness_park_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function fitness_park_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			/*esc_html_x( 'Posted on %s', 'post date', 'fitness-park' ),*/
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'fitness_park_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function fitness_park_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'fitness-park' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'fitness_park_comments' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function fitness_park_comments() {

		echo '<span class="comments-link"><i class="fa fa-comments"></i> ';
			
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'fitness-park' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);

		echo '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'fitness_park_category' ) ) :

	function fitness_park_category() {
	/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list(', ');
		if ( $categories_list ) {
			/* translators: 1: list of categories. */
			printf( '<span class="cat-links">%1$s</span>', $categories_list ); // WPCS: XSS OK.
		}
	}
endif;

if ( ! function_exists( 'fitness_park_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function fitness_park_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'fitness-park' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'fitness-park' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'fitness-park' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'fitness-park' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'fitness-park' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'fitness-park' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'fitness_park_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function fitness_park_post_thumbnail() {

		$sidebar = get_theme_mod('fitness_park_sidebar_options','right');

		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>
			<div class="post-thumbnail">
				<?php 
					if ($sidebar == 'no') {
						the_post_thumbnail('fitness-park-slider'); 
					}else{
						the_post_thumbnail('fitness-park-image'); 
					}
				?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
					if ($sidebar == 'no') {

							the_post_thumbnail('fitness-park-slider'); 
							
						}else{

							the_post_thumbnail('fitness-park-image'); 
					}
				?>
			</a>

		<?php endif; // End is_singular().
	}
endif;

/**
 * Filter the excerpt "read more" string.
 *
 * @param string $text "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function fitness_park_excerpt_more($text){

    if(is_admin()){

        return $text;
    }

    return '&hellip;';
}
add_filter( 'excerpt_more', 'fitness_park_excerpt_more' );



if( !function_exists( 'fitness_park_page_layout_metabox' ) ):

    function fitness_park_page_layout_metabox() {

        add_meta_box('fitness_park_display_layout', 
            esc_html__( 'Display Layout Options', 'fitness-park' ), 
            'fitness_park_display_layout_callback', 
            array('page','post'), 
            'normal', 
            'high'
        );
    }
endif;
add_action('add_meta_boxes', 'fitness_park_page_layout_metabox');


/**
 * Page and Post Page Display Layout Metabox function
*/
$fitness_park_page_layouts =array(
    'leftsidebar' => array(
        'value'     => 'left',
        'label'     => esc_html__( 'Left Sidebar', 'fitness-park' ),
        'thumbnail' => get_template_directory_uri() . '/assets/images/left-sidebar.png',
    ),
    'rightsidebar' => array(
        'value'     => 'right',
        'label'     => esc_html__( 'Right (Default)', 'fitness-park' ),
        'thumbnail' => get_template_directory_uri() . '/assets/images/right-sidebar.png',
    ),
     'nosidebar' => array(
        'value'     => 'no',
        'label'     => esc_html__( 'Full width', 'fitness-park' ),
        'thumbnail' => get_template_directory_uri() . '/assets/images/no-sidebar.png',
    )
);

/**
 * Function for Page layout meta box
*/
if ( ! function_exists( 'fitness_park_display_layout_callback' ) ) {
    function fitness_park_display_layout_callback(){
        global $post, $fitness_park_page_layouts;
        wp_nonce_field( basename( __FILE__ ), 'fitness_park_settings_nonce' ); ?>
        <table>
            <tr>
              <td>            
                <?php
                  $i = 0;  
                  foreach ($fitness_park_page_layouts as $field) {  
                  $fitness_park_page_metalayouts = esc_attr( get_post_meta( $post->ID, 'fitness_park_page_layouts', true ) ); 
                ?>            
                  <div class="radio-image-wrapper slidercat" id="slider-<?php echo intval( $i ); ?>" style="float: right; margin-right: 25px;">
                    <label class="description">
                        <span>
                          <img src="<?php echo esc_url( $field['thumbnail'] ); ?>" />
                        </span></br>
                        <input type="radio" name="fitness_park_page_layouts" value="<?php echo esc_attr( $field['value'] ); ?>" <?php checked( esc_html( $field['value'] ), 
                            $fitness_park_page_metalayouts ); if(empty($fitness_park_page_metalayouts) && esc_html( $field['value'] ) =='right'){ echo "checked='checked'";  } ?>/>
                         <?php echo esc_html( $field['label'] ); ?>
                    </label>
                  </div>
                <?php  $i++; }  ?>
              </td>
            </tr>            
        </table>
    <?php
    }
}

/**
 * Save the custom metabox data
*/
if ( ! function_exists( 'fitness_park_save_page_settings' ) ) {
    function fitness_park_save_page_settings( $post_id ) { 
        global $fitness_park_page_layouts, $post;
         if ( !isset( $_POST[ 'fitness_park_settings_nonce' ] ) || !wp_verify_nonce( sanitize_key( $_POST[ 'fitness_park_settings_nonce' ] ) , basename( __FILE__ ) ) ) 
            return;
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)  
            return;        
        if (isset( $_POST['post_type'] ) && 'page' == $_POST['post_type']) {  
            if (!current_user_can( 'edit_page', $post_id ) )  
                return $post_id;  
        } elseif (!current_user_can( 'edit_post', $post_id ) ) {  
                return $post_id;  
        }  

        foreach ($fitness_park_page_layouts as $field) {  
            $old = esc_attr( get_post_meta( $post_id, 'fitness_park_page_layouts', true) );
            if ( isset( $_POST['fitness_park_page_layouts']) ) { 
                $new = sanitize_text_field( wp_unslash( $_POST['fitness_park_page_layouts'] ) );
            }
            if ($new && $new != $old) {  
                update_post_meta($post_id, 'fitness_park_page_layouts', $new);  
            } elseif ('' == $new && $old) {  
                delete_post_meta($post_id,'fitness_park_page_layouts', $old);  
            } 
         } 
    }
}
add_action('save_post', 'fitness_park_save_page_settings');

function fitness_park_admin_scripts() {

	global $pagenow;
	
	if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
		wp_enqueue_style( 'fitnesspark-admin', get_theme_file_uri( '/assets/css/fitnesspark-admin.css' ) );
	}
}
add_action( 'admin_enqueue_scripts', 'fitness_park_admin_scripts' );
