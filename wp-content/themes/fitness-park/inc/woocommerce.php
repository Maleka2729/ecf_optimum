<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Medical_Heed_Pro
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function fitness_park_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'fitness_park_woocommerce_setup' );


/**
 * Load Education Web Woocommerce Action and Filter.
*/
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20 );
add_filter( 'woocommerce_show_page_title', '__return_false' );

remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

/**
 * WooCommerce add content primary div function
*/
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
if (!function_exists('fitness_park_woocommerce_output_content_wrapper')) {
    function fitness_park_woocommerce_output_content_wrapper(){ ?>
			<div id="content" class="blog-post">
        <div class="container">
            <div class="row">
    					<div id="primary" class="col-md-8 col-sm-12 col-xs-12 content-area">
    						<main id="main" class="site-main box" role="main">
    <?php }
}
add_action( 'woocommerce_before_main_content', 'fitness_park_woocommerce_output_content_wrapper', 10 );

remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
if (!function_exists('fitness_park_woocommerce_output_content_wrapper_end')) {
    function fitness_park_woocommerce_output_content_wrapper_end(){ ?>
            		</main>
            	</div>

        		<?php get_sidebar('woocommerce'); ?>
        
          </div>
        </div>
      </div>
    <?php }
}
add_action( 'woocommerce_after_main_content', 'fitness_park_woocommerce_output_content_wrapper_end', 10 );
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );


/**
 * Woo Commerce Number of row filter Function
*/
add_filter('loop_shop_columns', 'fitness_park_loop_columns');
if (!function_exists('fitness_park_loop_columns')) {
    function fitness_park_loop_columns() {
        return 3;
    }
}

add_action( 'body_class', 'fitness_park_woo_body_class');
if (!function_exists('fitness_park_woo_body_class')) {
    function fitness_park_woo_body_class( $class ) {
           $class[] = 'columns-'.intval(fitness_park_loop_columns());
           return $class;
    }
}

/**
 * WooCommerce display related product.
*/
if (!function_exists('fitness_park_related_products_args')) {
  function fitness_park_related_products_args( $args ) {
      $args['posts_per_page']   = 6;
      $args['columns']          = 3;
      return $args;
  }
}
add_filter( 'woocommerce_output_related_products_args', 'fitness_park_related_products_args' );

/**
 * WooCommerce display upsell product.
*/
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
if ( ! function_exists( 'fitness_park_woocommerce_upsell_display' ) ) {
  function fitness_park_woocommerce_upsell_display() {
      woocommerce_upsell_display( 6, 3 ); 
  }
}
add_action( 'woocommerce_after_single_product_summary', 'fitness_park_woocommerce_upsell_display', 15 );
