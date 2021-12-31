<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Fitness_Park
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.0/mdb.min.css" rel="stylesheet" />

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php
    if ( function_exists( 'wp_body_open' ) ) {
        wp_body_open();
    } else {
        do_action( 'wp_body_open' );
    }
?>

    <div id="page" class="site">

        <a class="skip-link screen-reader-text"
            href="#content"><?php esc_html_e('Skip to content', 'fitness-park'); ?></a>

        <header id="masthead" class="site-header">
            <nav class="navbar navbar-default main-navigation">
                <div class="container" style="display: block;">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header ">
                        <button type="button" class="menu-nav-toggle" data-toggle-target=".header-mobile-menu"
                            data-toggle-body-class="showing-menu-modal" aria-expanded="false"
                            data-set-focus=".close-nav-toggle">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <div class="header-logo site-branding">
                            <?php the_custom_logo(); ?>
                            <h1 class="site-title">
                                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                    <?php bloginfo('name'); ?>
                                </a>
                            </h1>
                            <?php
                        $fitness_park_description = get_bloginfo('description', 'display');
                        if ($fitness_park_description || is_customize_preview()) :
                            ?>
                            <p class="site-description"><?php echo $fitness_park_description; /* WPCS: xss ok. */ ?></p>
                            <?php endif; ?>

                        </div>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse">
                        <?php
                    wp_nav_menu(array(
                        'theme_location' => 'menu-1',
                        'menu_id' => 'primary-menu',
                        'menu_class' => 'nav navbar-nav float-navbar'
                    ));
                    ?>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>


        </header><!-- #masthead -->

        <!-- breadcrumbs -->


        <div class="mt-3 mb-3" id="content" class="site-content">