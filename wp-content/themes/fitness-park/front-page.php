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
 * @package fitness park
 */
get_header();

/**
 * Enable Front Page
*/
do_action( 'fitness_park_enable_front_page' );

$enable_front_page = get_theme_mod( 'fitness_park_front_page' ,false);

if ($enable_front_page == 1):

/**
 * Hook -  fitness_park_action_banner_slider 
 *
 * @hooked fitness_park_banner_slider - 10
*/

do_action('fitness_park_action_banner_slider');

/**
 * Hook -  fitness_park_action_about_us 
 *
 * @hooked fitness_park_about_us - 20
*/

do_action('fitness_park_action_about_us');

 /**
 * Hook -  fitness_park_action_call_to_action 
 *
 * @hooked fitness_park_call_to_action - 30
*/

do_action('fitness_park_action_call_to_action');

/**
 * Hook -  fitness_park_action_services 
 *
 * @hooked fitness_park_services - 40
*/

do_action('fitness_park_action_services');

/**
 * Hook -  fitness_park_action_appointment 
 *
 * @hooked fitness_park_appointment - 50
*/

do_action('fitness_park_action_appointment');

/**
 * Hook -  fitness_park_action_blog_posts 
 *
 * @hooked fitness_park_blog_posts - 55
*/

do_action('fitness_park_action_blog_posts');

/**
 * Hook -  fitness_park_action_gallery 
 *
 * @hooked fitness_park_gallery - 60
*/

do_action('fitness_park_action_gallery');

/**
 * Hook -  fitness_park_action_testimonials 
 *
 * @hooked fitness_park_testimonials - 70
*/

do_action('fitness_park_action_testimonials');

endif;

get_footer();
