<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Fitness_Park
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function fitness_park_body_classes($classes){
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no';
    }

    return $classes;
}
add_filter('body_class', 'fitness_park_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function fitness_park_pingback_header(){

    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'fitness_park_pingback_header');

/**
 * Breadcrumbs.
*/
function fitness_park_breadcrumbs(){ ?>
    <section class="breadcrumb">
        <div class="container">
            <?php
                if (is_single() || is_page()) {

                    the_title('<h2 class="entry-title">', '</h2>');

                } elseif (is_archive()) {

                    the_archive_title('<h2 class="page-title">', '</h2>');
                    the_archive_description('<div class="taxonomy-description">', '</div>');

                } elseif (is_search()) { ?>

                    <h2 class="page-title">
                        <?php printf(esc_html__('Search Results for: %s', 'fitness-park'), '<span>' . get_search_query() . '</span>'); ?>
                    </h2>

                <?php } elseif (is_404()) {

                    echo '<h2 class="entry-title">' . esc_html('404 Error', 'fitness-park') . '</h2>';

                } elseif (is_home()) {

                $page_for_posts_id = get_option('page_for_posts');
                $page_title = get_the_title($page_for_posts_id);
            ?>
                <h2 class="entry-title"><?php echo esc_html($page_title); ?></h2>

            <?php } ?>

            <nav id="breadcrumb" class="fitness-park-breadcrumb">
                <?php
                    breadcrumb_trail(array(
                        'container' => 'div',
                        'show_browse' => false,
                    ));
                ?>
            </nav>
        </div>
    </section>
    <?php 
}
add_action('fitness_park_breadcrumbs', 'fitness_park_breadcrumbs', 100);

/**
 * Banner Slider.
 */
function fitness_park_banner_slider(){ ?>
    <section class="slider">
        <div id="main-slider" class="owl-carousel owl-theme">
            <?php
            $all_slider = get_theme_mod('fitness_park_banner_sliders');

            if ($all_slider) {

                $banner_slider = json_decode($all_slider);

                foreach ($banner_slider as $slider) {

                    $page_id = $slider->slider_page;

                    if (!empty($page_id)) {

                        $slider_page = new WP_Query('page_id=' . $page_id);

                        if ($slider_page->have_posts()) {
                            while ($slider_page->have_posts()) {
                                $slider_page->the_post();

                                if (has_post_thumbnail()) {

                                    ?>
                                    <div class="item">
                                        <?php the_post_thumbnail('fitness-park-slider'); ?>

                                        <div class="slider-caption" data-animation-in="fadeInUp"
                                             data-animation-out="animate-out fadeOutDown">

                                            <h2><?php the_title(); ?></h2>

                                            <span><?php echo esc_html($slider->subtitile); ?></span>

                                            <p><?php echo esc_html( wp_trim_words( get_the_content(), 20 ) ); ?></p>

                                            <?php

                                            if (!empty($slider->button_text)) {
                                                ?>
                                                    <a href="<?php echo esc_url($slider->button_url); ?>"><?php echo esc_html($slider->button_text); ?></a>
                                            <?php } ?>
                                        </div>
                                    </div>

                                <?php }
                            }
                        }
                        wp_reset_postdata();
                    }
                }
            } ?>
        </div>
    </section>
    <?php 
}
add_action('fitness_park_action_banner_slider', 'fitness_park_banner_slider', 10);

/**
 * About Us Section.
 */
function fitness_park_about_us(){
    $page = get_theme_mod('fitness_park_about');
    $image = get_theme_mod('fitness_park_about_image');
    $subtitle = get_theme_mod('fitness_park_about_subtitle');
    $about_button = get_theme_mod('fitness_park_about_button');
    $about_url = get_theme_mod('fitness_park_about_url');

    if (!empty ($page)) { ?>

        <section class="introduction">
            <div class="container">
                <div class="row">
                    <?php
                        $args = array(
                            'posts_per_page' => 1,
                            'post_type' => 'page',
                            'page_id' => absint($page),
                            'post_status' => 'publish',
                        );

                        $query = new WP_Query($args);

                        if ($query->have_posts()) :

                        while ($query->have_posts()) : $query->the_post();
                    ?>
                            <div class="box">
                                <?php if (!empty($image)) { ?>
                                        <figure>
                                            <img src="<?php echo esc_url(wp_get_attachment_url($image)); ?>">
                                        </figure>

                                <?php } else { ?>
                                        <figure>
                                            <?php the_post_thumbnail('fitness-park-image'); ?>
                                        </figure>
                                <?php } ?>
                                <div class="description">

                                    <h2><?php the_title(); ?></h2>

                                    <span><?php echo esc_html($subtitle); ?></span>

                                    <?php the_content(); ?>

                                    <?php if (!empty($about_button)) : ?>
                                        <a href="<?php echo esc_url( $about_url ); ?>" class="link"><?php echo esc_html( $about_button ); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                    <?php endwhile; endif; ?>
                </div>
            </div>
        </section>

    <?php } 
}
add_action('fitness_park_action_about_us', 'fitness_park_about_us', 20);

/**
 * Call to Action Section.
 */
function fitness_park_call_to_action(){

    $call_action_image = get_theme_mod('fitness_park_call_to_action_image');
    $call_action_title = get_theme_mod('fitness_park_call_to_action_title');
    $call_action_subtitle = get_theme_mod('fitness_park_call_to_action_subtitle');
    $call_action_button = get_theme_mod('fitness_park_call_to_action_button');
    $call_action_link = get_theme_mod('fitness_park_call_to_action_link');

    if (!empty($call_action_image)) : ?>
        <div class="offer">
            <div class="offer-parallax-window" data-parallax="scroll"
                 data-image-src="<?php echo esc_url(wp_get_attachment_url($call_action_image)); ?>">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">

                            <?php if (!empty($call_action_title)): ?>

                                <h2><?php echo esc_html($call_action_title); ?></h2>

                            <?php endif; ?>

                            <?php if (!empty($call_action_subtitle)): ?>
                                <span><?php echo esc_html($call_action_subtitle); ?></span>
                            <?php endif; ?>

                            <?php if (!empty($call_action_button)): ?>

                                <a href="<?php echo esc_url( $call_action_link ); ?>"><?php echo esc_html( $call_action_button ); ?></a>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;
}
add_action('fitness_park_action_call_to_action', 'fitness_park_call_to_action', 30);

/**
 * Service Section.
 */
function fitness_park_services(){

    $service_title = get_theme_mod('fitness_park_service_title');
    $service_subtitle = get_theme_mod('fitness_park_service_subtitle');
    $service_page = get_theme_mod('fitness_park_service'); ?>

        <section class="courses">
            <div class="container">
                <?php if (!empty($service_title) || !empty($service_subtitle)) : ?>
                    <div class="row">
                        <?php if (!empty($service_title)): ?>
                            <h2><?php echo esc_html($service_title); ?></h2>
                        <?php endif; ?>

                        <?php if (!empty($service_subtitle)): ?>
                            <span><?php echo esc_html($service_subtitle); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="container">
                <div class="row">
                    <div class="fp-block-wrapper">
                        <?php

                        if ($service_page) {

                            $service_pages = json_decode($service_page);

                            foreach ($service_pages as $service) {

                                $page_id = $service->service_page;

                                if (!empty($page_id)) {

                                    $service_query = new WP_Query('page_id=' . $page_id);

                                    if ($service_query->have_posts()) {
                                        while ($service_query->have_posts()) {
                                            $service_query->the_post();
                                            ?>
                                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 courseList">
                                                <a href="<?php the_permalink(); ?>">
                                                    <div class="box">
                                                        <figure>
                                                            <img src="<?php echo esc_url(get_template_directory_uri()) . '/assets/images/' . esc_html( $service->service_icon ); ?>">
                                                        </figure>
                                                        <h3><?php the_title(); ?></h3>
                                                        <p><?php echo esc_html( wp_trim_words( get_the_content(), 20 ) ); ?></p>
                                                    </div>
                                                </a>
                                            </div>

                                        <?php }
                                    }
                                    wp_reset_postdata();
                                }
                            }
                        } ?>
                    </div>
                </div>
            </div>
        </section>

    <?php 
}
add_action('fitness_park_action_services', 'fitness_park_services', 40);

/**
 * Appointment Section.
 */
function fitness_park_appointment(){

    $appointment_title = get_theme_mod('fitness_park_appointment_title');
    $appointment_subtitle = get_theme_mod('fitness_park_appointment_subtitle');
    $appointment_shortcode = get_theme_mod('fitness_park_appointment_shortcode');
    $appointment_image = get_theme_mod('fitness_park_appointment_image');

    if (!empty ($appointment_image) || !empty ($appointment_title) || !empty ($appointment_subtitle) || !empty ($appointment_shortcode)) : ?>
    <section class="video" style="background-image: url(<?php echo esc_url($appointment_image); ?>);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 sectiontitle">
                    <?php if (!empty($appointment_title)) : ?>
                        <h2><?php echo esc_html( $appointment_title ); ?></h2>
                    <?php endif; ?>

                    <?php if (!empty($appointment_subtitle)) : ?>
                        <span><?php echo esc_html( $appointment_subtitle ); ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row registration-form">
                <div class="col-lg-12">
                    <?php 
                        if (!empty($appointment_shortcode)) :
                            
                            echo do_shortcode($appointment_shortcode);
                        endif; 
                    ?>
                </div>
            </div>
        </div>
    </section>

    <?php endif;
}
add_action('fitness_park_action_appointment', 'fitness_park_appointment', 50);

/**
 * Blog Posts Section.
 */
function fitness_park_blog_posts(){
    $blog_title = get_theme_mod('fitness_park_blog_title');
    $blog_subtitle = get_theme_mod('fitness_park_blog_subtitle');
    $blog_posts = get_theme_mod('fitness_park_blog_categories');
    $cat_id = explode(',', $blog_posts); ?>

    <section class="fitness-park-blog-post-front">
        <div class="container">
            <?php if (!empty($blog_title) || !empty($blog_subtitle)): ?>
                <div class="row">
                    <div class="col-lg-12 sectiontitle">
                        <?php if (!empty($blog_title)) : ?>
                            <h2><?php echo esc_html($blog_title); ?></h2>
                        <?php endif; ?>

                        <?php if (!empty($blog_subtitle)) : ?>
                            <span><?php echo esc_html($blog_subtitle); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif;

            $args = array(
                'post_type' => 'post',
                'tax_query' => array(

                    array(
                        'taxonomy' => 'category',
                        'field' => 'term_id',
                        'terms' => $cat_id
                    ),
                ),
            );
            $blog_query = new WP_Query ($args);

            if ($blog_query->have_posts()):

                ?>
                <div class="row"><?php

                    while ($blog_query->have_posts()) : $blog_query->the_post(); ?>

                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">

                            <figure>

                                <?php the_post_thumbnail('fitness-park-gallery'); ?>

                                <?php fitness_park_category(); ?>

                            </figure>

                            <div class="fp-blog-description">

                                <h3 class="post-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>

                                <div class="post-content">
                                    <p><?php echo esc_html( wp_trim_words( get_the_content(), 20 ) ); ?></p>
                                </div>

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
                                    </ul>
                                </div>
                            </div>

                        </div>

                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php
}
add_action('fitness_park_action_blog_posts', 'fitness_park_blog_posts', 55);

/**
 * Gallery Section.
 */
function fitness_park_gallery(){

    $gallery_title = get_theme_mod('fitness_park_gallery_title');
    $gallery_subtitle = get_theme_mod('fitness_park_gallery_subtitle');
    $gallery_image = get_theme_mod('fitness_park_image_gallery');  ?>

    <section class="front-gallery">
        <?php if (!empty($gallery_title) || !empty( $gallery_subtitle ) ): ?>
            <div class="gallery-title">
                <div class="gallery-text-wrapper">
                    <?php if (!empty($gallery_title)): ?>
                        <h2>
                            <?php echo esc_html($gallery_title); ?>

                            <?php if (!empty($gallery_subtitle)): ?>
                                <span><?php echo esc_html($gallery_subtitle); ?></span>
                            <?php endif; ?>
                        </h2>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php
        $allgallery = explode(',', $gallery_image);

        foreach ($allgallery as $gallery) {

            $image = wp_get_attachment_image_src($gallery, 'fitness-park-gallery');
            $image_full = wp_get_attachment_image_src($gallery, 'medium_large');
            ?>
            <div class="box">
                <a href="<?php echo esc_url($image_full[0]); ?>" rel="prettyPhoto">
                    <div class="overlay-gallery">+</div>
                    <img src="<?php echo esc_url($image[0]); ?>">
                </a>
            </div>
        <?php } ?>
    </section>
    <?php
}
add_action('fitness_park_action_gallery', 'fitness_park_gallery', 60);

/**
 * Trainers Section.
*/
function fitness_park_testimonials(){

    $trainers_title = get_theme_mod('fitness_park_testimonials_title');
    $trainers_subtitle = get_theme_mod('fitness_park_testimonials_subtitle');
    $trainers_pages = get_theme_mod('fitness_park_testimonials_page'); ?>

        <section class="trainers">
            <div class="container">
                <?php if (!empty($trainers_title) || !empty($trainers_subtitle)) : ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <?php if (!empty($trainers_title)): ?>
                                <h2><?php echo esc_html($trainers_title); ?></h2>
                            <?php endif; ?>

                            <?php if (!empty($trainers_subtitle)): ?>
                                <span><?php echo esc_html($trainers_subtitle); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div id="trainers-slider" class="owl-carousel owl-theme">
                    <?php
                        if ($trainers_pages) {

                        $pages = json_decode($trainers_pages);

                        foreach ($pages as $testimonial_page) {

                            $page_id = $testimonial_page->testimonial_page;

                            if (!empty($page_id)) {

                                $testimonial_query = new WP_Query('page_id=' . $page_id);

                                if ($testimonial_query->have_posts()) { while ($testimonial_query->have_posts()) {
                                        $testimonial_query->the_post();

                    ?>
                        <div class="item">
                            <div class="box">
                                <figure>
                                    <?php the_post_thumbnail('fitness-park-image'); ?>
                                </figure>

                                <div class="description">
                                    <h3>
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?> </a>
                                    </h3>

                                    <?php if (!empty($testimonial_page->designation)): ?>
                                        <span class="designation">
                                            <?php echo esc_html($testimonial_page->designation) ?>
                                        </span>
                                    <?php endif; ?>

                                    <p><?php echo esc_html( wp_trim_words( get_the_content(), 20 ) ); ?></p>

                                    <ul class="social-icon">
                                        <?php if (!empty ($testimonial_page->facebook_url)) : ?>
                                            <li class="social-facebook">
                                                <a href="<?php echo esc_attr($testimonial_page->facebook_url) ?>"><i
                                                            class="fab fab fa-facebook"></i>
                                                </a>
                                            </li>
                                        <?php endif; if (!empty ($testimonial_page->twitter_url)) : ?>
                                            <li class="social-twitter">
                                                <a href="<?php echo esc_attr($testimonial_page->twitter_url) ?>"><i
                                                            class="fab fab fa-twitter"></i>
                                                </a>
                                            </li>
                                        <?php endif; if (!empty ($testimonial_page->instagram_url ) ) : ?>
                                            <li class="social-instagram">
                                                <a href="<?php echo esc_attr($testimonial_page->instagram_url) ?>">
                                                    <i class="fab fab fa-instagram"></i>
                                                </a>
                                            </li>
                                        <?php endif; if (!empty ( $testimonial_page->youtube_url ) ) :?>
                                            <li class="social-youtube">
                                                <a href="<?php echo esc_attr($testimonial_page->youtube_url) ?>">
                                                    <i class="fab fab fa-youtube"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    <?php } } wp_reset_postdata(); } } } ?>
                </div>
            </div>
        </section>
    <?php
}
add_action('fitness_park_action_testimonials', 'fitness_park_testimonials', 70);