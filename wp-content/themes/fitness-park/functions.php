<?php
/**
 * Fitness Park functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Fitness_Park
 */

if ( ! function_exists( 'fitness_park_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function fitness_park_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Fitness Park, use a find and replace
		 * to change 'fitness-park' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'fitness-park', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		add_image_size('fitness-park-image', 800, 510, true);
		add_image_size('fitness-park-slider', 1350, 520, true);
		add_image_size('fitness-park-gallery', 500, 400, true);

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'fitness-park' ),
			'footer-menu' => esc_html__( 'Footer Menu', 'fitness-park' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'fitness_park_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'fitness_park_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function fitness_park_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'fitness_park_content_width', 640 );
}
add_action( 'after_setup_theme', 'fitness_park_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function fitness_park_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Right Sidebar Widget Area', 'fitness-park' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'fitness-park' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Left Sidebar Widget Area', 'fitness-park' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here.', 'fitness-park' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'fitness_park_widgets_init' );

if ( ! function_exists( 'fitness_park_fonts_url' ) ) :

	/**
	 * Register Google fonts for Fitness Park
	 *
	 * Create your own fitness_park_fonts_url() function to override in a child theme.
	 *
	 * @since Fitness Prak 1.0.0
	 *
	 * @return string Google fonts URL for the theme.
	 */

    function fitness_park_fonts_url() {

        $fonts_url = '';

        $font_families = array();


        if ( 'off' !== _x( 'on', 'Raleway: on or off', 'fitness-park' ) ) {
            $font_families[] = 'Raleway:300,300i,400,400i,500,500i,600,600i,700,700i,800';
        }


        if( $font_families ) {

            $query_args = array(

                'family' => urlencode( implode( '|', $font_families ) ),
                'subset' => urlencode( 'latin,latin-ext' ),
            );

            $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
        }

        return esc_url ( $fonts_url );
    }

endif;

/**
 * Enqueue scripts and styles.
 */
function fitness_park_scripts() {

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_style( 'fitness-park-fonts', fitness_park_fonts_url(), array(), null );

	// Load Font Awsome CSS Library File
	wp_enqueue_style( 'fontawsome', get_template_directory_uri(). '/assets/library/font-awesome/css/fontawsome.css' );

	// Load Bootstrap CSS Library File
	wp_enqueue_style( 'bootstrap', trailingslashit( esc_url ( get_template_directory_uri() ) ) . '/assets/library/bootstrap/css/bootstrap' . esc_attr ( $min ) . '.css' );

	// Load prettyPhoto CSS Library File
	wp_enqueue_style( 'prettyPhoto', trailingslashit( esc_url ( get_template_directory_uri() ) ) . '/assets/library/prettyPhoto/css/prettyPhoto.css' );

	// Load owlcarousel CSS Library File
	wp_enqueue_style( 'owlcarousel', trailingslashit( esc_url ( get_template_directory_uri() ) ) . '/assets/library/owlcarousel/css/owl.carousel' . esc_attr ( $min ) . '.css' );

	// Load animate CSS File
	wp_enqueue_style( 'fitness-park-animate',  get_template_directory_uri(). '/assets/css/animate.css' );

	wp_enqueue_style( 'fitness-park-style', get_stylesheet_uri() );

	if ( has_header_image() ) {
		$custom_css = '.site-header .navbar{ background-image: url("' . esc_url( get_header_image() ) . '"); background-repeat: no-repeat; background-position: center center; background-size: cover; }';
		wp_add_inline_style( 'fitness-park-style', $custom_css );
	}

    // Load Bootstrap Library File
    wp_enqueue_script('bootstrap', trailingslashit( esc_url ( get_template_directory_uri() ) ) . '/assets/library/bootstrap/js/bootstrap' . esc_attr ( $min ) . '.js', array('jquery'),'3.3.7', true );

    // Load jquery-prettyPhoto Library File
    wp_enqueue_script('jquery-prettyPhoto', trailingslashit( esc_url ( get_template_directory_uri() ) ) . '/assets/library/prettyPhoto/js/jquery.prettyPhoto.js', array('jquery'), '3.1.6', true );

    // Load parallex  File
    wp_enqueue_script('parallex', trailingslashit( esc_url ( get_template_directory_uri() ) ) . '/assets/library/parallex/parallex' . esc_attr ( $min ) . '.js', array('jquery'),'1.5.0', true );

    // Load owlcarousel Library File
    wp_enqueue_script('owl-carousel', trailingslashit( esc_url ( get_template_directory_uri() ) ) . '/assets/library/owlcarousel/js/owl.carousel' . esc_attr ( $min ) . '.js', array('jquery'),'2.3.4', true );

	wp_enqueue_script( 'fitness-park-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'fitness-park-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );

	// Main
    wp_enqueue_script('fitness-park-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'fitness_park_scripts' );

/**
 * Sets the Fitness Prak Template Instead of front-page.
 */
function fitness_park_front_page_set( $template ) {

  $fitness_park_front_page = get_theme_mod( 'fitness_park_front_page' ,false);

  if( true != $fitness_park_front_page ){

    if ( 'posts' == get_option( 'show_on_front' ) ) {

      include( get_home_template() );

    } else {

      include( get_page_template() );
      
    }
  }
}
add_filter( 'fitness_park_enable_front_page', 'fitness_park_front_page_set' );

/**
 * Load Files.
 */
require get_template_directory() . '/inc/init.php';

// remove version wp 
remove_action('wp_head', 'wp_generator');