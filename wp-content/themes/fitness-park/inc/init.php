<?php 
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/** mobile menu */
require get_template_directory() . '/inc/mobile-menu/init.php';

/**
 * Customizer functions additions.
 */
require get_template_directory() . '/inc/customizer/customizer-functions.php';

/**
 * Breadcrumbs.
 */
require get_template_directory() . '/inc/breadcrumbs/breadcrumbs.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {

	require get_template_directory() . '/inc/jetpack.php';

}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {

	require get_theme_file_path('inc/woocommerce.php');

}

/**
 * Load About Craft Blog file
 */
require get_template_directory() .'/welcome/welcome.php';

/**
 * Load in customizer upgrade to pro
*/
require get_template_directory() .'/inc/customizer-pro/class-customize.php';

