<div class="welcome-getting-started">
    <div class="welcome-demo-import">
        <h3><?php echo esc_html__('Manual Setup', 'fitness-park'); ?></h3>

        <p><?php echo esc_html__('You can setup the home page sections either from Customizer Panel or from Elementor Pagebuilder', 'fitness-park'); ?></p>
        <p><strong><?php echo esc_html__('FROM CUSTOMIZER', 'fitness-park'); ?></strong></p>
        <ol>
            <li><?php echo esc_html__('Go to customizer >> Enable Front page and check and publish the changes.', 'fitness-park'); ?></li>
            <li><?php echo esc_html__('Go to Appearance &gt; Customize', 'fitness-park'); ?></li>
            <li><?php echo esc_html__('Click on ', 'fitness-park'); ?><strong>"<a href="<?php echo esc_url(admin_url('customize.php?autofocus[section]=fitness_park_enable_frontpage')); ?>" target="_blank"><?php echo esc_html__('Homepage Settings', 'fitness-park'); ?></a>"</strong> <?php echo esc_html__('and choose "A static page" for "Your latest posts" and select the created page for "Home Page" option.', 'fitness-park'); ?></li>
            <li><?php echo sprintf('Now go back and click on <strong>Appearance > Widget</strong> or Manage <strong>Customizer Section</strong> Options', 'fitness-park'); ?></li>
        </ol>
        <p><strong><?php echo esc_html__('FROM ELEMENTOR', 'fitness-park'); ?></strong></p>
        <ol>
            <li><?php echo esc_html__('Firstly install and activate "Elementor Website Builder" plugin from', 'fitness-park'); ?> <a href="<?php echo esc_url(admin_url('post-new.php?page=fitnesspark-welcome&section=recommended_plugins')); ?>" target="_blank"><?php echo esc_html__('Recommended Plugin page.', 'fitness-park'); ?></a></li>
            <li><?php echo esc_html__('Create a new page and edit with Elementor. Drag and drop the elements in the Elementor to create your own design.', 'fitness-park'); ?></li>
            <li><?php echo esc_html__('Now go to Appearance &gt; Customize &gt; Homepage Settings and choose "A static page" for "Your latest posts" and select the created page for "Home Page" option.', 'fitness-park'); ?></li>
        </ol>
        
        <p>
            <?php echo sprintf(esc_html__('For more detail visit our theme %s.', 'fitness-park'), '<a href="'.esc_url('https://docs.sparklewpthemes.com/fitnesspark/').'" target="_blank">' . esc_html__('Documentation Page', 'fitness-park') . '</a>'); ?>
        </p>
    </div>

    <div class="welcome-demo-import">
        <h3><?php echo esc_html__('Demo Importer', 'fitness-park'); ?></h3>
        <div class="welcome-theme-thumb">
            <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/screenshot.png'); ?>" alt="<?php printf(esc_attr__('%s Demo', 'fitness-park'), $this->theme_name); ?>">
        </div>

        <div class="welcome-demo-import-text">
            <p><?php esc_html_e('Or you can get started by importing the demo with just one click.', 'fitness-park'); ?></p>
            <p><?php echo sprintf(esc_html__('Click on the button below to install and activate the One Click Demo Importer Plugin. For more detailed documentation on how the demo importer works, click %s.', 'fitness-park'), '<a href="'.esc_url('https://docs.sparklewpthemes.com/fitnesspark/').'" target="_blank">' . esc_html__('here', 'fitness-park') . '</a>'); ?></p>
            <?php echo $this->generate_demo_installer_button(); ?>
        </div>
    </div>
</div>