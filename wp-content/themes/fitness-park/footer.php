<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Fitness_Park
 */

?>
</div><!-- #content -->

<footer id="colophon" class="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12 footer_logo">
                <?php
                    
                $footer_log = get_theme_mod('fitness_park_footer_logo');

                if (!empty($footer_log)) { ?>

                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                        <img src="<?php echo esc_url( wp_get_attachment_url( $footer_log ) ); ?>">
                    </a>

                <?php }else{  ?>

                    <h2 class="site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <?php bloginfo('name'); ?>
                        </a>
                    </h2>
                    <?php
                        $fitness_park_description = get_bloginfo('description', 'display');
                        if ($fitness_park_description || is_customize_preview()) :
                    ?>
                        <p class="site-description"><?php echo $fitness_park_description; /* WPCS: xss ok. */ ?></p>
                <?php endif; } ?>
            </div>

            <div class="col-lg-12 col-sm-12 col-sm-12">
                <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-menu',
                        'menu_class' => 'footer-menu',
                        'container_class' => 'footer-menu',
                        'depth' => 1
                    ));
                ?>
            </div>
        </div>

        <div class="row bottom_footer">
            <div class="col-lg-3 col-sm-3 col-sm-12">
                <?php
                    $enable_icon = get_theme_mod('fitness_park_enable_icon', 'enable');
                    $footer_icon = get_theme_mod('fitness_Park_footer_icons');

                    if ($enable_icon == 'enable') :
                ?>
                    <ul class="social-icon">
                        <?php if (!empty ($footer_icon)) :

                            $icons = json_decode($footer_icon);

                            foreach ($icons as $icon) {
                        ?>
                            <li>
                                <a href="<?php echo esc_url($icon->icon_url); ?>">
                                    <i class="fab <?php echo esc_html($icon->icons); ?>"></i>
                                </a>
                            </li>
                        <?php } endif; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="col-lg-6 col-sm-6 col-sm-12 copyright">
                <p>
                    <?php
                        $copyright = get_theme_mod('fitness_park_footer_copyright');

                        if (!empty($copyright)) {

                            echo esc_html( apply_filters('fitness_park_copyright_text', $copyright ) );

                        } else {

                            echo esc_html(apply_filters('fitness_park_copyright_text', $content = esc_html__('Copyright  &copy; ', 'fitness-park') . date('Y') . ' ' . get_bloginfo('name') . ' - '));
                        }

                        /* translators: %s: CMS name, i.e. WordPress. */
                        printf(' WordPress Theme : By %1$s', '<a href=" ' . esc_url('https://sparklewpthemes.com/') . ' " rel="designer" target="_blank">' . esc_html__('Sparkle Themes', 'fitness-park') . '</a>'); 
                    ?> <?php the_privacy_policy_link(); ?>
                </p>
            </div>
            <?php
                $button = get_theme_mod('fitness_park_footer_button_text');
                $button_url = get_theme_mod('fitness_park_footer_button_url');

                if (!empty ( $button ) ): ?>

                    <div class="col-lg-3 col-sm-3 col-sm-12 join_now">
                        <a href="<?php echo esc_attr($button_url); ?>">
                            <?php echo esc_html( $button ); ?>
                        </a>
                    </div>

            <?php endif; ?>
        </div>
    </div>
</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>
<!-- MDB -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.0/mdb.min.js"></script>
</body>
</html>
