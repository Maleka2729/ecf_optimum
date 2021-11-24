<?php
/**
 * Fitness Park Theme Customizer
 *
 * @package Fitness_Park
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function fitness_park_customize_register($wp_customize)
{
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial('blogname', array(
            'selector' => '.site-title a',
            'render_callback' => 'fitness_park_customize_partial_blogname',
        ));
        $wp_customize->selective_refresh->add_partial('blogdescription', array(
            'selector' => '.site-description',
            'render_callback' => 'fitness_park_customize_partial_blogdescription',
        ));
    }


    // List All Pages
    $slider_pages = array();
    $slider_pages_obj = get_pages();
    $slider_pages[''] = esc_html__('Select Page', 'fitness-park');
    foreach ($slider_pages_obj as $page) {
        $slider_pages[$page->ID] = $page->post_title;
    }

    // List All Category
    $categories = get_categories();
    $blog_cat = array();

    foreach ($categories as $category) {
        $blog_cat[$category->term_id] = $category->name;
    }

/**
 * Option to get the frontpage settings to the old default template if a static frontpage is selected
 */
$wp_customize->get_section('static_front_page')->priority = 2;

$wp_customize->add_section('fitness_park_enable_frontpage', array(
    'title' => esc_html__('Enable Front Page', 'fitness-park'),
    'priority' => 1
));

    $wp_customize->add_setting('fitness_park_front_page', array(
        'sanitize_callback' => 'fitness_park_sanitize_checkbox',
        'default' => false
    ));

    $wp_customize->add_control('fitness_park_front_page', array(
        'type' => 'checkbox',
        'label' => esc_html__('Enable Fitness Style frontpage?', 'fitness-park'),
        'section' => 'fitness_park_enable_frontpage'
    ));


/**
 * Add General Settings Panel
 *
 * @since 1.0.0
*/
$wp_customize->add_panel(
    'fitness_park_general_settings_panel',
    array(
        'priority'       => 2,
        'title'          => esc_html__( 'General Settings', 'fitness-park' ),
    )
);

    $wp_customize->get_section( 'title_tagline' )->panel = 'fitness_park_general_settings_panel';
    $wp_customize->get_section( 'title_tagline' )->priority = 5;

    $wp_customize->get_section( 'colors' )->panel = 'fitness_park_general_settings_panel';
    $wp_customize->get_section('colors' )->title = esc_html__('Colors Settings', 'fitness-park');
    $wp_customize->get_section( 'colors' )->priority = 6;

    $wp_customize->get_section( 'header_image' )->panel = 'fitness_park_general_settings_panel';
    $wp_customize->get_section('header_image' )->title = esc_html__('Header Background Image', 'fitness-park');
    $wp_customize->get_section( 'header_image' )->priority = 8;

    $wp_customize->get_section( 'background_image' )->panel = 'fitness_park_general_settings_panel';
    $wp_customize->get_section( 'background_image' )->priority = 15;

    $wp_customize->get_section( 'static_front_page' )->panel = 'fitness_park_general_settings_panel';
    $wp_customize->get_section( 'static_front_page' )->priority = 20;

    $wp_customize->register_section_type('Fitness_Park_Upgrade_Section');

    $wp_customize->add_setting('colors_upgrade_text', array(
        'sanitize_callback' => 'fitness_park_sanitize_text'
    ));

    $wp_customize->add_control(new Fitness_Park_Upgrade_Text($wp_customize, 'colors_upgrade_text', array(
        'section' => 'colors',
        'label' => esc_html__('For more styling,', 'fitness-park'),
        'choices' => array(
            esc_html__('Change Primary Color of the Theme', 'fitness-park'),
            esc_html__('Change Top Header Font Hover Color', 'fitness-park'),
            esc_html__('Change Main Header Background Color', 'fitness-park'),
            esc_html__('Change Main Header Font and Hover Color', 'fitness-park'),
            esc_html__('Change Footer Background Color', 'fitness-park'),
            esc_html__('Change Footer Font and Hover Color', 'fitness-park'),
            esc_html__('Change Sub Footer Background Color', 'fitness-park'),
        ),
        'priority' => 100
    )));

    /**
     * Banner Slider
     */
    $wp_customize->add_section('fitness_park_banner_slider', array(
        'title' => esc_html__('Banner Slider', 'fitness-park'),
        'priority' => 2,
    ));

    $wp_customize->add_setting('fitness_park_banner_sliders', array(
        'sanitize_callback' => 'fitness_park_sanitize_repeater',
        'default' => json_encode(array(
            array(
                'top_title' => '',
                'slider_page' => '',
                'subtitile' => '',
                'button_text' => '',
                'button_url' => ''
            )
        ))
    ));

    $wp_customize->add_control(new Fitness_Park_Repeater_Controler($wp_customize, 'fitness_park_banner_sliders', array(
        'label' => esc_html__('Slider Settings Area', 'fitness-park'),
        'section' => 'fitness_park_banner_slider',
        'settings' => 'fitness_park_banner_sliders',
        'fp_box_label' => esc_html__('Slider Settings Options', 'fitness-park'),
        'fp_box_add_control' => esc_html__('Add New Slider', 'fitness-park'),
    ),
        array(

            'slider_page' => array(
                'type' => 'select',
                'label' => esc_html__('Select Slider Page', 'fitness-park'),
                'options' => $slider_pages
            ),

            'subtitile' => array(
                'type' => 'text',
                'label' => esc_html__('Enter Subtitle', 'fitness-park'),
                'default' => ''
            ),
            'button_text' => array(
                'type' => 'text',
                'label' => esc_html__('Enter Button Text', 'fitness-park'),
                'default' => ''
            ),
            'button_url' => array(
                'type' => 'text',
                'label' => esc_html__('Enter Button Url', 'fitness-park'),
                'default' => ''
            )
        )));

    $wp_customize->add_setting('fitness_park_banner_slider_upgrade_text', array(
        'sanitize_callback' => 'fitness_park_sanitize_text'
    ));

    $wp_customize->add_control(new Fitness_Park_Upgrade_Text($wp_customize, 'fitness_park_banner_slider_upgrade_text', array(
        'section' => 'fitness_park_banner_slider',
        'label' => esc_html__('For more settings,', 'fitness-park'),
        'choices' => array(
            esc_html__('Enable/Disable Main Slider', 'fitness-park'),
            esc_html__('Three Different Types of Slider', 'fitness-park'),
            esc_html__('Includes Advanced Slider Settings', 'fitness-park'),
            esc_html__('Supports Revolution Slider', 'fitness-park'),
            esc_html__('Repeatable Slider Items with Custom Image Upload and Short Description', 'fitness-park'),
            esc_html__('Two Buttons with Custom Links', 'fitness-park'),
        ),
        'priority' => 100
    )));

    /**
     *  frontpage Setting Panel.
     */
    $wp_customize->add_panel('fitness_park_homepage', array(
        'title' => esc_html__('Front Page Setting', 'fitness-park'),
        'priority' => 10,
    ));

    /**
     *  About Us.
     */
    $wp_customize->add_section('fitness_park_about_us', array(
        'title' => esc_html__('About Us Section', 'fitness-park'),
        'panel' => 'fitness_park_homepage',
        'priority' => 5
    ));

// About Us image.
    $wp_customize->add_setting('fitness_park_about_image', array(
        'sanitize_callback' => 'absint',      //done
    ));

    $wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'fitness_park_about_image', array(
        'label' => esc_html__('Cropped the selected Image', 'fitness-park'),
        'section' => 'fitness_park_about_us',
        'width' => 700,
        'height' => 700,
    )));

// About Us Page Select.
    $wp_customize->add_setting('fitness_park_about', array(
        'sanitize_callback' => 'absint',     //done
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'fitness_park_about', array(
        'label' => esc_html__('Select About Us Page', 'fitness-park'),
        'settings' => 'fitness_park_about',
        'section' => 'fitness_park_about_us',
        'type' => 'dropdown-pages',
    )));

    $wp_customize->selective_refresh->add_partial( 'fitness_park_about', array(
        'selector'        => '.introduction .box .description h2',
    ) );

// About Us Subtitle.
    $wp_customize->add_setting('fitness_park_about_subtitle', array(
        'sanitize_callback' => 'sanitize_text_field',     //done	', 	 //done
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'fitness_park_about_subtitle', array(
        'label' => esc_html__('Enter Subtitle', 'fitness-park'),
        'settings' => 'fitness_park_about_subtitle',
        'section' => 'fitness_park_about_us',
        'type' => 'text',
    )));
    $wp_customize->selective_refresh->add_partial( 'fitness_park_about_subtitle', array(
        'selector'        => '.introduction .box .description h2 + span',
    ) );

// About Us Buton.
    $wp_customize->add_setting('fitness_park_about_button', array(
        'sanitize_callback' => 'sanitize_text_field',     //done	', 	 //done
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'fitness_park_about_button', array(
        'label' => esc_html__('Enter Button Text', 'fitness-park'),
        'settings' => 'fitness_park_about_button',
        'section' => 'fitness_park_about_us',
        'type' => 'text',
    )));
    $wp_customize->selective_refresh->add_partial( 'fitness_park_about_button', array(
        'selector'        => '.introduction .box .description a.link',
    ) );

// About Us Buton URL.
    $wp_customize->add_setting('fitness_park_about_url', array(
        'sanitize_callback' => 'esc_url_raw',     //done	', 	 //done
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'fitness_park_about_url', array(
        'label' => esc_html__('Enter Button URL', 'fitness-park'),
        'settings' => 'fitness_park_about_url',
        'section' => 'fitness_park_about_us',
        'type' => 'url',
    )));

    $wp_customize->add_setting('fitness_park_about_us_upgrade_text', array(
        'sanitize_callback' => 'fitness_park_sanitize_text'
    ));

    $wp_customize->add_control(new Fitness_Park_Upgrade_Text($wp_customize, 'fitness_park_about_us_upgrade_text', array(
        'section' => 'fitness_park_about_us',
        'label' => esc_html__('For more settings,', 'fitness-park'),
        'choices' => array(
            esc_html__('Enable/Disable About Us Section', 'fitness-park'),
            esc_html__('Select Content to Display', 'fitness-park'),
        ),
        'priority' => 100
    )));


    /**
     *  Call To Action.
     */

    $wp_customize->add_section('fitness_park_call_to_action', array(
        'title' => esc_html__('Call To Action Section', 'fitness-park'),
        'panel' => 'fitness_park_homepage',
        'priority' => 5
    ));

    $wp_customize->add_setting('fitness_park_call_to_action_image', array(
        'sanitize_callback' => 'absint',      //done
    ));

    $wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'fitness_park_call_to_action_image', array(
        'label' => esc_html__('Cropped the selected Image', 'fitness-park'),
        'section' => 'fitness_park_call_to_action',
        'width' => 1260,
        'height' => 552,
    )));

// Call To Action Title.
    $wp_customize->add_setting('fitness_park_call_to_action_title', array(
        'sanitize_callback' => 'sanitize_text_field',      //done
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'fitness_park_call_to_action_title', array(
        'label' => esc_html__('Enter Section Title', 'fitness-park'),
        'settings' => 'fitness_park_call_to_action_title',
        'section' => 'fitness_park_call_to_action',
        'type' => 'text',
    )));

    $wp_customize->selective_refresh->add_partial( 'fitness_park_call_to_action_title', array(
        'selector'        => '.offer h2',
    ) );

// Call To Action Subtitle.
    $wp_customize->add_setting('fitness_park_call_to_action_subtitle', array(
        'sanitize_callback' => 'sanitize_text_field',         //done
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'fitness_park_call_to_action_subtitle', array(
        'label' => esc_html__('Enter Section Subtitle', 'fitness-park'),
        'settings' => 'fitness_park_call_to_action_subtitle',
        'section' => 'fitness_park_call_to_action',
        'type' => 'text',
    )));

    $wp_customize->selective_refresh->add_partial( 'fitness_park_call_to_action_subtitle', array(
        'selector'        => '.offer h2 + span',
    ) );

// Call To Action Button Text.
    $wp_customize->add_setting('fitness_park_call_to_action_button', array(
        'sanitize_callback' => 'sanitize_text_field',     //done
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'fitness_park_call_to_action_button', array(
        'label' => esc_html__('Enter Button Text', 'fitness-park'),
        'settings' => 'fitness_park_call_to_action_button',
        'section' => 'fitness_park_call_to_action',
        'type' => 'text',
    )));

// Call To Action Button URl.
    $wp_customize->add_setting('fitness_park_call_to_action_link', array(
        'sanitize_callback' => 'esc_url_raw',         //done
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'fitness_park_call_to_action_link', array(
        'label' => esc_html__('Enter Button URL', 'fitness-park'),
        'settings' => 'fitness_park_call_to_action_link',
        'section' => 'fitness_park_call_to_action',
        'type' => 'url',
    )));

    $wp_customize->add_setting('fitness_park_call_to_action_upgrade_text', array(
        'sanitize_callback' => 'fitness_park_sanitize_text'
    ));

    $wp_customize->add_control(new Fitness_Park_Upgrade_Text($wp_customize, 'fitness_park_call_to_action_upgrade_text', array(
        'section' => 'fitness_park_call_to_action',
        'label' => esc_html__('For more settings,', 'fitness-park'),
        'choices' => array(
            esc_html__('Enable/Disable the Section', 'fitness-park'),
        ),
        'priority' => 100
    )));

    /**
     *  Our Service Section.
     */
    $wp_customize->add_section('fitness_park_service_section', array(
        'title' => esc_html__('Service Section', 'fitness-park'),
        'panel' => 'fitness_park_homepage',
        'priority' => 10,
    ));

//Service Title.
    $wp_customize->add_setting('fitness_park_service_title', array(
        'sanitize_callback' => 'sanitize_text_field',         //done
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'fitness_park_service_title', array(
        'label' => esc_html__('Enter Section Title', 'fitness-park'),
        'settings' => 'fitness_park_service_title',
        'section' => 'fitness_park_service_section',
        'type' => 'text',
    )));
    $wp_customize->selective_refresh->add_partial( 'fitness_park_service_title', array(
        'selector'        => '.courses h2',
    ) );

//Service Subtitle.
    $wp_customize->add_setting('fitness_park_service_subtitle', array(
        'sanitize_callback' => 'sanitize_text_field',         //done
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'fitness_park_service_subtitle', array(
        'label' => esc_html__('Enter Section Subtitle', 'fitness-park'),
        'settings' => 'fitness_park_service_subtitle',
        'section' => 'fitness_park_service_section',
        'type' => 'text',
    )));

    $wp_customize->selective_refresh->add_partial( 'fitness_park_service_subtitle', array(
        'selector'        => '.courses h2 + span',
    ) );

    $wp_customize->add_setting('fitness_park_service', array(
        'sanitize_callback' => 'fitness_park_sanitize_repeater',
        'default' => json_encode(array(
            array(
                'service_page' => '',
                'service_icon' => 'icon-1.png',
            )
        ))
    ));

    $wp_customize->add_control(new Fitness_Park_Repeater_Controler($wp_customize, 'fitness_park_service', array(
        'label' => esc_html__('Service Page Settings Area', 'fitness-park'),
        'section' => 'fitness_park_service_section',
        'settings' => 'fitness_park_service',
        'fp_box_label' => esc_html__('Service Page Settings Options', 'fitness-park'),
        'fp_box_add_control' => esc_html__('Add New Service Page', 'fitness-park'),
    ),
        array(

            'service_page' => array(
                'type' => 'select',
                'label' => esc_html__('Select Service Page', 'fitness-park'),
                'options' => $slider_pages
            ),
            'service_icon' => array(
                'type' => 'icon',
                'label' => esc_html__('Select Icon', 'fitness-park'),
                'default' => 'icon-1.png'
            ),
        )));

    $wp_customize->add_setting('fitness_park_service_section_upgrade_text', array(
        'sanitize_callback' => 'fitness_park_sanitize_text'
    ));

    $wp_customize->add_control(new Fitness_Park_Upgrade_Text($wp_customize, 'fitness_park_service_section_upgrade_text', array(
        'section' => 'fitness_park_service_section',
        'label' => esc_html__('For more settings and controls,', 'fitness-park'),
        'choices' => array(
            esc_html__('Enable/Disable Service Section', 'fitness-park'),
            esc_html__('Option to Upload Icon for Service Items', 'fitness-park'),
            esc_html__('Two Different Layouts', 'fitness-park'),
            esc_html__('Increase/Decrease Icon Size', 'fitness-park'),
            esc_html__('Control Box Shadow Effect', 'fitness-park'),
        ),
        'priority' => 100
    )));

    /**
     *  Appointment.
     */
    $wp_customize->add_section('fitness_park_appointment', array(
        'title' => esc_html__('Appointment Section', 'fitness-park'),
        'panel' => 'fitness_park_homepage',
        'priority' => 20,
    ));

//Appointment Image.
    $wp_customize->add_setting('fitness_park_appointment_image', array(
        'sanitize_callback' => 'esc_url_raw',      //done
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'fitness_park_appointment_image', array(
        'label' => esc_html__('Cropped the selected Image', 'fitness-park'),
        'setting' => 'fitness_park_appointment_image',
        'section' => 'fitness_park_appointment',
        'type' => 'image',
    )));

//Appointment Title.
    $wp_customize->add_setting('fitness_park_appointment_title', array(
        'sanitize_callback' => 'sanitize_text_field',         //done
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'fitness_park_appointment_title', array(
        'label' => esc_html__('Enter Section Title', 'fitness-park'),
        'settings' => 'fitness_park_appointment_title',
        'section' => 'fitness_park_appointment',
        'type' => 'text',
    )));
    $wp_customize->selective_refresh->add_partial( 'fitness_park_appointment_title', array(
        'selector'        => '.video .sectiontitle h2',
    ) );

//Appointment Subtitle.
    $wp_customize->add_setting('fitness_park_appointment_subtitle', array(
        'sanitize_callback' => 'sanitize_text_field',         //done
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'fitness_park_appointment_subtitle', array(
        'label' => esc_html__('Enter Section Subtitle', 'fitness-park'),
        'settings' => 'fitness_park_appointment_subtitle',
        'section' => 'fitness_park_appointment',
        'type' => 'text',
    )));

    $wp_customize->selective_refresh->add_partial( 'fitness_park_appointment_subtitle', array(
        'selector'        => '.video .sectiontitle span',
    ) );

    //Appointment Shortcode.
    $wp_customize->add_setting('fitness_park_appointment_shortcode', array(
        'sanitize_callback' => 'sanitize_text_field',         //done
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'fitness_park_appointment_shortcode', array(
        'label' => esc_html__('Enter Shortcode', 'fitness-park'),
        'settings' => 'fitness_park_appointment_shortcode',
        'section' => 'fitness_park_appointment',
        'type' => 'text',
        'description' => esc_html__('Note: First you can install Contact Form 7 plugins and create your form per as you want and enter generated shortcode exmaple : [contact-form-7 id="111" title="Contact form 1"]', 'fitness-park'),
    )));

    $wp_customize->add_setting('fitness_park_appointment_upgrade_text', array(
        'sanitize_callback' => 'fitness_park_sanitize_text'
    ));

    $wp_customize->add_control(new Fitness_Park_Upgrade_Text($wp_customize, 'fitness_park_appointment_upgrade_text', array(
        'section' => 'fitness_park_appointment',
        'label' => esc_html__('For more settings,', 'fitness-park'),
        'choices' => array(
            esc_html__('Enable/Disable Section', 'fitness-park'),
            esc_html__('Two Types of Section Background', 'fitness-park'),
        ),
        'priority' => 100
    )));

    /**
     * Blog Posts.
     */
    $wp_customize->add_section('fitness_park_blog_posts', array(
        'title' => esc_html__('Blog Posts Section', 'fitness-park'),
        'panel' => 'fitness_park_homepage',
        'priority' => 23,
    ));

// Blog Posts title.
    $wp_customize->add_setting('fitness_park_blog_title', array(
        'sanitize_callback' => 'sanitize_text_field',     //done
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'fitness_park_blog_title', array(
        'label' => esc_html__('Enter Section Title', 'fitness-park'),
        'settings' => 'fitness_park_blog_title',
        'section' => 'fitness_park_blog_posts',
        'type' => 'text'
    )));

    $wp_customize->selective_refresh->add_partial( 'fitness_park_blog_title', array(
        'selector'        => '.fitness-park-blog-post-front .sectiontitle h2',
    ) );
// Blog Posts subtitle.
    $wp_customize->add_setting('fitness_park_blog_subtitle', array(
        'sanitize_callback' => 'sanitize_text_field',     //done
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'fitness_park_blog_subtitle', array(
        'label' => esc_html__('Enter Section Subtitle', 'fitness-park'),
        'settings' => 'fitness_park_blog_subtitle',
        'section' => 'fitness_park_blog_posts',
        'type' => 'text'
    )));
    $wp_customize->selective_refresh->add_partial( 'fitness_park_blog_subtitle', array(
        'selector'        => '.fitness-park-blog-post-front .sectiontitle span',
    ) );

    $wp_customize->add_setting('fitness_park_blog_categories', array(
        'sanitize_callback' => 'sanitize_text_field',     //done
    ));

    $wp_customize->add_control(new fitness_park_multiple_check_control($wp_customize, 'fitness_park_blog_categories', array(
        'label' => esc_html__('Select Category', 'fitness-park'),
        'settings' => 'fitness_park_blog_categories',
        'section' => 'fitness_park_blog_posts',
        'choices' => $blog_cat
    )));

    $wp_customize->add_setting('fitness_park_blog_posts_upgrade_text', array(
        'sanitize_callback' => 'fitness_park_sanitize_text'
    ));

    $wp_customize->add_control(new Fitness_Park_Upgrade_Text($wp_customize, 'fitness_park_blog_posts_upgrade_text', array(
        'section' => 'fitness_park_blog_posts',
        'label' => esc_html__('For more settings,', 'fitness-park'),
        'choices' => array(
            esc_html__('Enable/Disable Section', 'fitness-park'),
            esc_html__('Enter Number of Posts to Display', 'fitness-park'),
        ),
        'priority' => 100
    )));

    /**
     *  Gallery.
     */
    $wp_customize->add_section('fitness_park_gallery', array(
        'title' => esc_html__('Gallery Section', 'fitness-park'),
        'panel' => 'fitness_park_homepage',
        'priority' => 25,
    ));

//Gallery Title.
    $wp_customize->add_setting('fitness_park_gallery_title', array(
        'sanitize_callback' => 'sanitize_text_field',         //done
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'fitness_park_gallery_title', array(
        'label' => esc_html__('Enter Section Title', 'fitness-park'),
        'settings' => 'fitness_park_gallery_title',
        'section' => 'fitness_park_gallery',
        'type' => 'text',
    )));
    $wp_customize->selective_refresh->add_partial( 'fitness_park_gallery_title', array(
        'selector'        => '.front-gallery .sectiontitle h2',
    ) );

//Gallery Subtitle.
    $wp_customize->add_setting('fitness_park_gallery_subtitle', array(
        'sanitize_callback' => 'sanitize_text_field',         //done
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'fitness_park_gallery_subtitle', array(
        'label' => esc_html__('Enter Section Subtitle', 'fitness-park'),
        'settings' => 'fitness_park_gallery_subtitle',
        'section' => 'fitness_park_gallery',
        'type' => 'text',
    )));

// Image Gallery.
    $wp_customize->add_setting('fitness_park_image_gallery', array(
        'sanitize_callback' => 'sanitize_text_field',         //done
    ));

    $wp_customize->add_control(new Fitness_Park_Gallery_Control($wp_customize, 'fitness_park_image_gallery', array(
        'label' => esc_html__('Upload Gallery Images', 'fitness-park'),
        'settings' => 'fitness_park_image_gallery',
        'section' => 'fitness_park_gallery',
    )));

    $wp_customize->selective_refresh->add_partial( 'fitness_park_image_gallery', array(
        'selector'        => '.front-gallery .box',
    ) );

    $wp_customize->add_setting('fitness_park_gallery_upgrade_text', array(
        'sanitize_callback' => 'fitness_park_sanitize_text'
    ));

    $wp_customize->add_control(new Fitness_Park_Upgrade_Text($wp_customize, 'fitness_park_gallery_upgrade_text', array(
        'section' => 'fitness_park_gallery',
        'label' => esc_html__('For more settings,', 'fitness-park'),
        'choices' => array(
            esc_html__('Show/Hide Gallery Section', 'fitness-park'),
        ),
        'priority' => 100
    )));

    /**
     *  Trainers.
     */
    $wp_customize->add_section('fitness_park_testimonials', array(
        'title' => esc_html__('Trainers Section', 'fitness-park'),
        'panel' => 'fitness_park_homepage',
        'priority' => 25,
    ));

//Testimonials Title.
    $wp_customize->add_setting('fitness_park_testimonials_title', array(
        'sanitize_callback' => 'sanitize_text_field',         //done
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'fitness_park_testimonials_title', array(
        'label' => esc_html__('Enter Section Title', 'fitness-park'),
        'settings' => 'fitness_park_testimonials_title',
        'section' => 'fitness_park_testimonials',
        'type' => 'text',
    )));

    $wp_customize->selective_refresh->add_partial( 'fitness_park_testimonials_title', array(
        'selector'        => '.trainers h2',
    ) );
//Trainers Subtitle.
    $wp_customize->add_setting('fitness_park_testimonials_subtitle', array(
        'sanitize_callback' => 'sanitize_text_field',         //done
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'fitness_park_testimonials_subtitle', array(
        'label' => esc_html__('Enter Section Subtitle', 'fitness-park'),
        'settings' => 'fitness_park_testimonials_subtitle',
        'section' => 'fitness_park_testimonials',
        'type' => 'text',
    )));

    $wp_customize->selective_refresh->add_partial( 'fitness_park_testimonials_subtitle', array(
        'selector'        => '.trainers span',
    ) );

//Trainers Pages.
    $wp_customize->add_setting('fitness_park_testimonials_page', array(
        'sanitize_callback' => 'fitness_park_sanitize_repeater',
        'default' => json_encode(array(
            array(
                'testimonial_page' => '',
                'designation' => '',
                'facebook_url' => '',
                'twitter_url' => '',
                'youtube_url' => '',
                'instagram_url' => '',
            )
        ))
    ));

    $wp_customize->add_control(new Fitness_Park_Repeater_Controler($wp_customize, 'fitness_park_testimonials_page', array(
        'label' => esc_html__('Trainers Settings Area', 'fitness-park'),
        'section' => 'fitness_park_testimonials',
        'settings' => 'fitness_park_testimonials_page',
        'fp_box_label' => esc_html__('Trainers Settings Options', 'fitness-park'),
        'fp_box_add_control' => esc_html__('Add New Trainers', 'fitness-park'),
    ),
        array(

            'testimonial_page' => array(
                'type' => 'select',
                'label' => esc_html__('Select Trainers Page', 'fitness-park'),
                'options' => $slider_pages
            ),
            'designation' => array(
                'type' => 'text',
                'label' => esc_html__('Enter Designation', 'fitness-park'),
                'default' => ''
            ),

            'facebook_url' => array(
                'type' => 'text',
                'label' => esc_html__('Enter Facebook URL', 'fitness-park'),
                'default' => ''
            ),
            'twitter_url' => array(
                'type' => 'text',
                'label' => esc_html__('Enter Twitter URL', 'fitness-park'),
                'default' => ''
            ),
            'youtube_url' => array(
                'type' => 'text',
                'label' => esc_html__('Enter Youtube Url', 'fitness-park'),
                'default' => ''
            ),
            'instagram_url' => array(
                'type' => 'text',
                'label' => esc_html__('Enter Instagram Url', 'fitness-park'),
                'default' => ''
            ),
        )));

    $wp_customize->add_setting('fitness_park_testimonials_upgrade_text', array(
        'sanitize_callback' => 'fitness_park_sanitize_text'
    ));

    $wp_customize->add_control(new Fitness_Park_Upgrade_Text($wp_customize, 'fitness_park_testimonials_upgrade_text', array(
        'section' => 'fitness_park_testimonials',
        'label' => esc_html__('For more settings,', 'fitness-park'),
        'choices' => array(
            esc_html__('Enable/Disable Section', 'fitness-park'),
            esc_html__('Three Different Layouts', 'fitness-park'),
            esc_html__('Grid View and Slider View', 'fitness-park'),
            esc_html__('Choose Number of Columns to Display', 'fitness-park'),
        ),
        'priority' => 100
    )));

    $wp_customize->add_section(new Fitness_Park_Upgrade_Section($wp_customize, 'fitness_park_homepage_upgrade_section', array(
        'title' => esc_html__('More Sections on Premium', 'fitness-park'),
        'panel' => 'fitness_park_homepage',
        'priority' => 1000,
        'options' => array(
            esc_html__('- Re-Order Section', 'fitness-park'),
            esc_html__('- Featured Course Section', 'fitness-park'),
            esc_html__('- Course Package Fee Section', 'fitness-park'),
            esc_html__('------------------------', 'fitness-park'),
            esc_html__('- Elementor Pagebuilder Compatible. All the above sections can be created with Elementor Page Builder or Customizer whichever you like.', 'fitness-park'),
        )
    )));

    /**
     *  Sidebar.
     */
    $wp_customize->add_section('fitness_park_sidebar_section', array(
        'title' => esc_html__('Page Layout Settings', 'fitness-park'),
        'priority' => 15,
    ));

// Select Sidebar Options.
    $wp_customize->add_setting('fitness_park_sidebar_options', array(
        'default' => 'right',
        'sanitize_callback' => 'fitness_park_sanitize_select'        //done
    ));

    $wp_customize->add_control(new WP_Customize_Control ($wp_customize, 'fitness_park_sidebar_options', array(
        'label' => esc_html__('Post, Page & Category Sidebar Options', 'fitness-park'),
        'section' => 'fitness_park_sidebar_section',
        'setting' => 'fitness_park_sidebar_options',
        'type' => 'select',
        'choices' => array(
            'no' => esc_html__('Full Width', 'fitness-park'),
            'right' => esc_html__('Right Sidebar', 'fitness-park'),
            'left' => esc_html__('Left Sidebar', 'fitness-park'),
        )
    )));

    /**
     *  Footer Content Panel.
     */
    $wp_customize->add_panel('fitness_park_footer', array(
        'title' => esc_html__('Footer Settings', 'fitness-park'),
        'priority' => 25,
    ));

    /**
     *  Footer Logo.
     */
    $wp_customize->add_section('fitness_park_footer_logo', array(
        'title' => esc_html__('Footer Logo', 'fitness-park'),
        'panel' => 'fitness_park_footer',
    ));


    $wp_customize->add_setting('fitness_park_footer_logo', array(
        'sanitize_callback' => 'absint',      //done
    ));
    $wp_customize->selective_refresh->add_partial( 'fitness_park_footer_logo', array(
        'selector'        => '.footer_logo',
    ) );

    $wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'fitness_park_footer_logo', array(
        'label' => esc_html__('Upload Logo', 'fitness-park'),
        'section' => 'fitness_park_footer_logo',
        'width' => 214,
        'height' => 69,
    )));
    /**
     *  Footer Social Links.
     */
    $wp_customize->add_section('fitness_park_footer_social', array(
        'title' => esc_html__('Social Links', 'fitness-park'),
        'panel' => 'fitness_park_footer',
    ));

// Enable or Disable Footer Social Icon.
    $wp_customize->add_setting('fitness_park_enable_icon', array(
        'default' => 'enable',
        'sanitize_callback' => 'fitness_park_sanitize_switch',     //done
    ));

    $wp_customize->add_control(new fitness_park_switch_control($wp_customize, 'fitness_park_enable_icon', array(
        'label' => esc_html__('Enable Social Icons', 'fitness-park'),
        'settings' => 'fitness_park_enable_icon',
        'section' => 'fitness_park_footer_social',
        'switch_label' => array(
            'enable' => esc_html__('Enable', 'fitness-park'),
            'disable' => esc_html__('Disable', 'fitness-park'),
        ),
    )));

    $wp_customize->add_setting('fitness_Park_footer_icons', array(
        'sanitize_callback' => 'fitness_park_sanitize_repeater',        //done
        'default' => json_encode(array(
                array(
                    'icons' => 'fab fa-facebook',
                    'icon_url' => '',
                )
            )
        )));

    $wp_customize->add_control(new Fitness_Park_Repeater_Controler ($wp_customize, 'fitness_Park_footer_icons',
        array(
            'label' => esc_html__('Social Icons Setting', 'fitness-park'),
            'section' => 'fitness_park_footer_social',
            'setting' => 'fitness_Park_footer_icons',
            'fp_box_label' => esc_html__('Social Icons Options', 'fitness-park'),
            'fp_box_add_control' => esc_html__('Add New ', 'fitness-park'),
        ),
        array(
            'icons' => array(
                'type' => 'icons',
                'default' => 'fab fa-facebook',
                'label' => esc_html__('Select Icon', 'fitness-park'),
            ),

            'icon_url' => array(
                'type' => 'url',
                'label' => esc_html__('Social Icon Link', 'fitness-park'),
            ),
        )));

        $wp_customize->selective_refresh->add_partial( 'fitness_Park_footer_icons', array(
            'selector'        => '.bottom_footer .col-sm-3:first-child ',
        ) );


    /**
     *  Footer Content section.
     */
    $wp_customize->add_section('fitness_park_copyright', array(
        'title' => esc_html__('Footer Copyright', 'fitness-park'),
        'panel' => 'fitness_park_footer',
    ));

    //Footer Content.
    $wp_customize->add_setting('fitness_park_footer_copyright', array(
        'sanitize_callback' => 'sanitize_text_field',         //done
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'fitness_park_footer_copyright', array(
        'label' => esc_html__('Enter Footer Content', 'fitness-park'),
        'settings' => 'fitness_park_footer_copyright',
        'section' => 'fitness_park_copyright',
        'type' => 'text',
    )));
    $wp_customize->selective_refresh->add_partial( 'fitness_park_footer_copyright', array(
        'selector'        => '.bottom_footer .copyright',
    ) );

    /**
     *  Footer Button Section.
     */
    $wp_customize->add_section('fitness_park_footer_button', array(
        'title' => esc_html__('Footer Join Button', 'fitness-park'),
        'panel' => 'fitness_park_footer',
    ));

    //Footer Button Text.
    $wp_customize->add_setting('fitness_park_footer_button_text', array(
        'sanitize_callback' => 'sanitize_text_field',         //done
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'fitness_park_footer_button_text', array(
        'label' => esc_html__('Enter Button Text', 'fitness-park'),
        'settings' => 'fitness_park_footer_button_text',
        'section' => 'fitness_park_footer_button',
        'type' => 'text',
    )));

    //Footer Button URL.
    $wp_customize->add_setting('fitness_park_footer_button_url', array(
        'sanitize_callback' => 'esc_url_raw',         //done
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'fitness_park_footer_button_url', array(
        'label' => esc_html__('Enter Button URL', 'fitness-park'),
        'settings' => 'fitness_park_footer_button_url',
        'section' => 'fitness_park_footer_button',
        'type' => 'url',
    )));

}

add_action('customize_register', 'fitness_park_customize_register');

//SANITIZATION FUNCTIONS
function fitness_park_sanitize_text($input) {
    return wp_kses_post(force_balance_tags($input));
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function fitness_park_customize_partial_blogname()
{
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function fitness_park_customize_partial_blogdescription()
{
    bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * Enqueue required scripts/styles for customizer panel
 *
 * @since 1.0.0
 *
 */
function fitness_park_customize_scripts()
{

    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/library/font-awesome/css/fontawsome.css', array(), '5.5.0');

    wp_enqueue_style('fitness-park-style', get_template_directory_uri() . '/assets/css/customizer.css');

    wp_enqueue_script('fitness-park-customizer', get_template_directory_uri() . '/assets/js/fitness-park.js', array('jquery', 'customize-controls'), '20180910', true);

    // Localize the script with new data
    $translation_array = array(
        'url_to_icon' => esc_url(get_template_directory_uri()) . '/assets/images/',
    );
    wp_localize_script('fitness-park-customizer', 'fitness_park_script', $translation_array);

}

add_action('customize_controls_enqueue_scripts', 'fitness_park_customize_scripts');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function fitness_park_customize_preview_js()
{
    wp_enqueue_script('fitness-park-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array('customize-preview'), '20151215', true);
}

add_action('customize_preview_init', 'fitness_park_customize_preview_js');
