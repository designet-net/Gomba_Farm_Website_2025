<?php

namespace SuperbThemesThemeInformationContent\ThemePage;

defined("ABSPATH") || exit();

class ThemePageTemplate
{
    private $Theme;
    private $ParentName;
    private $ThemeName;
    private $PremiumText;

    private $Features;
    private $ThemeLink;
    private $DemoLink;

    public function __construct($data)
    {
        $this->Theme = wp_get_theme();
        $this->ParentName = is_child_theme() ? wp_get_theme($this->Theme->Template) : '';
        $this->ThemeName = is_child_theme() ? sprintf(__("%s and %s", 'creativity-hub'), $this->Theme, $this->ParentName) : $this->Theme;
        $this->PremiumText = is_child_theme() ? sprintf(__("Unlock all features by upgrading to the premium edition of %s and its parent theme %s.", 'creativity-hub'), $this->Theme, $this->ParentName) : sprintf(__("Unlock all features by upgrading to the premium edition of %s.", 'creativity-hub'), $this->Theme);
        $this->ThemeLink = $data['theme_url'];
        $this->DemoLink = $data['demo_url'];
        $base_features = array(
            array(
                'title' => __("Fully Search Engine Optimized", "creativity-hub"), 'base' => true, 'icon' => "img-icon-8.png", 'description' => __("Get free traffic by ranking #1 on Google with the lightning-fast & SEO-optimized premium version.", "creativity-hub")
            ),
            array(
                'title' => __("Page Speed Optimized", "creativity-hub"), 'base' => true, 'icon' => "img-icon-6.png", 'description' => __("Unlock maximum speed with the premium version. It loads in less than 0.3 seconds. ", "creativity-hub")
            ),
            array(
                'title' => __("Customize Everything", "creativity-hub"), 'base' => true, 'icon' => "img-icon-7.png", 'description' => __("Customize the design to fit your brand or style with our easy-to-use customization options.", "creativity-hub")
            ),
            array(
                'title' => __("E-commerce Compatibility", "creativity-hub"), 'base' => true, 'icon' => "img-icon-5.png", 'description' => __("Create your online store easily. The premium version is compatible with all popular e-commerce plugins.", "creativity-hub")
            ),
            array(
                'title' => __("Customer Support & Documentation", "creativity-hub"), 'base' => true, 'icon' => "img-icon-4.png", 'description' => __("Benefit from our comprehensive documentation and dedicated support team, always ready to help.", "creativity-hub")
            ),
            array(
                'title' => __("Works With All Page Builders", "creativity-hub"), 'base' => true, 'icon' => "img-icon-3.png", 'description' => __("Brizy, Elementor, Divi Builder, Beaver Builder - you name it. Every page builder plugin is compatible.", "creativity-hub")
            ),
            array(
                'title' => __("1-Click Starter Content Import", "creativity-hub"), 'base' => true, 'icon' => "img-icon-2.png", 'description' => __("Get started easily with our one-click demo content import feature. Get your website up and running in seconds.", "creativity-hub")
            ),
            array(
                'title' => __("Premium Designs, Patterns & Layouts", "creativity-hub"), 'base' => true, 'icon' => "img-icon-1.png", 'description' => __("Access all the premium layouts and designs perfect for any niche or industry.", "creativity-hub")
            ),
            array(
                'title' => __("Works On All Devices And Browsers", "creativity-hub"), 'base' => true, 'icon' => "devices-duotone.svg", 'description' => __("The premium version looks perfect everywhere, from desktop to mobile, and in every browser.", "creativity-hub")
            ),
            array(
                'title' => __("AMP Compatible And Mobile Ready", "creativity-hub"), 'base' => true, 'icon' => "fse_icon_mobile.svg", 'description' => __("Stay ahead with Accelerated Mobile Pages (AMP) compatibility.", "creativity-hub")
            ),
            array(
                'title' => __("GDPR Compliant", "creativity-hub"), 'base' => true, 'icon' => "shield-check-duotone.svg", 'description' => __("Our premium version comes fully compliant, giving you peace of mind about user data protection and privacy.", "creativity-hub")
            ),
            array(
                'title' => __("Frequent Updates", "creativity-hub"), 'base' => true, 'icon' => "arrows-clockwise-duotone.svg", 'description' => __("Our premium version provides frequent enhancements for security, performance, and features.", "creativity-hub")
            ),
            array(
                'title' => __("Child Themes", "creativity-hub"), 'base' => true, 'icon' => "img-2.png", 'description' => __("Use child themes to make modifications without affecting the parent theme's code, ensuring smooth updates.", "creativity-hub")
            ),
            array(
                'title' => __("WordPress blocks", "creativity-hub"), 'base' => true, 'icon' => "stack-duotone.png", 'description' => __("Use our many custom WordPress Gutenberg blocks for every purpose!", "creativity-hub")
            ),
            array(
                'title' => __("WordPress patterns", "creativity-hub"), 'base' => true, 'icon' => "grid-nine-duotone.png", 'description' => __("Take advantage of the 400+ beautiful patterns for every type of website.", "creativity-hub")
            ),
            array(
                'title' => __("Elementor sections", "creativity-hub"), 'base' => true, 'icon' => "img-1.png", 'description' => __("Access 300+ pre-built Elementor sections and build beautiful sites, fast.", "creativity-hub")
            )
        );
        $this->Features = $data['features'] ? array_merge($base_features, $data['features']) : $base_features;

        $this->Render();
    }

    private function Render()
    {
?>
        <div class="wrap">
            <div class="spt-theme-settings-wrapper">
                <div class="spt-theme-settings-wrapper-main-content">

                    <div class="spt-theme-settings-wrapper-main-content-section">
                        <div class="spt-theme-settings-wrapper-main-content-section-top">
                            <span class="spt-theme-settings-headline"><?php esc_html_e("Customize Settings", 'creativity-hub'); ?></span>
                            <a class="spt-theme-settings-headline-link" href="<?php echo esc_url(admin_url('site-editor.php'))  ?>"><?php esc_html_e("Go To Site Editor", 'creativity-hub'); ?></a>
                        </div>

                        <div class="spt-theme-settings-content">

                            <div class="spt-theme-settings-content-getting-started-wrapper">
                                <div class="spt-theme-settings-content-item">
                                    <div class="spt-theme-settings-content-item-header">
                                        <img width="25" height="25" src="<?php echo esc_url(get_template_directory_uri() . '/inc/superbthemes-info-content/icons/list-bullets.svg'); ?>" />
                                        <div class="spt-theme-settings-content-item-headline">
                                            <?php esc_html_e("Add Menus", 'creativity-hub'); ?>
                                        </div>
                                        <p><?php esc_html_e("Add a navigation to your website to improve the user experience.", 'creativity-hub'); ?></p>
                                    </div>
                                    <div class="spt-theme-settings-content-item-content">
                                        <a class="spt-theme-settings-content-item-button" href="<?php echo esc_url(admin_url('site-editor.php'))  ?>"><?php esc_html_e("Go To Site Editor", 'creativity-hub'); ?></a>
                                    </div>
                                </div>

                                <div class="spt-theme-settings-content-item">
                                    <div class="spt-theme-settings-content-item-header">
                                        <img width="25" height="25" src="<?php echo esc_url(get_template_directory_uri() . '/inc/superbthemes-info-content/icons/squares-four.svg'); ?>" />
                                        <div class="spt-theme-settings-content-item-headline">
                                            <?php esc_html_e("Edit Front Page", 'creativity-hub'); ?>
                                        </div>
                                        <p><?php esc_html_e("Edit and customize your front page design through the site editor.", 'creativity-hub'); ?></p>
                                    </div>
                                    <div class="spt-theme-settings-content-item-content">
                                        <a class="spt-theme-settings-content-item-button" href="<?php echo esc_url(admin_url('site-editor.php'))  ?>"><?php esc_html_e("Go To Site Editor", 'creativity-hub'); ?></a>
                                    </div>
                                </div>

                                <div class="spt-theme-settings-content-item">
                                    <div class="spt-theme-settings-content-item-header">
                                        <img width="25" height="25" src="<?php echo esc_url(get_template_directory_uri() . '/inc/superbthemes-info-content/icons/paint-brush.svg'); ?>" />
                                        <div class="spt-theme-settings-content-item-headline">
                                            <?php esc_html_e("Customize Design", 'creativity-hub'); ?>
                                        </div>
                                        <p><?php esc_html_e("Customize your website design to fit your personality or brand.", 'creativity-hub'); ?></p>
                                    </div>
                                    <div class="spt-theme-settings-content-item-content">
                                        <a class="spt-theme-settings-content-item-button" href="<?php echo esc_url(admin_url('site-editor.php'))  ?>"><?php esc_html_e("Go To Site Editor", 'creativity-hub'); ?></a>
                                    </div>
                                </div>

                                <div class="spt-theme-settings-content-item">
                                    <div class="spt-theme-settings-content-item-header">
                                        <img width="25" height="25" src="<?php echo esc_url(get_template_directory_uri() . '/inc/superbthemes-info-content/icons/text-a-underline.svg'); ?>" />
                                        <div class="spt-theme-settings-content-item-headline">
                                            <?php esc_html_e("Change Site Title", 'creativity-hub'); ?>
                                        </div>
                                        <p><?php esc_html_e("Add your website name and tagline to improve the design and SEO.", 'creativity-hub'); ?></p>
                                    </div>
                                    <div class="spt-theme-settings-content-item-content">
                                        <a class="spt-theme-settings-content-item-button" href="<?php echo esc_url(admin_url('site-editor.php'))  ?>"><?php esc_html_e("Go To Site Editor", 'creativity-hub'); ?></a>
                                    </div>
                                </div>

                                <div class="spt-theme-settings-content-item">
                                    <div class="spt-theme-settings-content-item-header">
                                        <img width="25" height="25" src="<?php echo esc_url(get_template_directory_uri() . '/inc/superbthemes-info-content/icons/image.svg'); ?>" />
                                        <div class="spt-theme-settings-content-item-headline">
                                            <?php esc_html_e("Upload Logo", 'creativity-hub'); ?>
                                        </div>
                                        <p><?php esc_html_e("Add a custom logo to make your website look more professional.", 'creativity-hub'); ?></p>
                                    </div>
                                    <div class="spt-theme-settings-content-item-content">
                                        <a class="spt-theme-settings-content-item-button" href="<?php echo esc_url(admin_url('site-editor.php'))  ?>"><?php esc_html_e("Go To Site Editor", 'creativity-hub'); ?></a>
                                    </div>
                                </div>

                                <div class="spt-theme-settings-content-item">
                                    <div class="spt-theme-settings-content-item-header">
                                        <img width="25" height="25" src="<?php echo esc_url(get_template_directory_uri() . '/inc/superbthemes-info-content/icons/file.svg'); ?>" />
                                        <div class="spt-theme-settings-content-item-headline">
                                            <?php esc_html_e("Create New Pages", 'creativity-hub'); ?>
                                        </div>
                                        <p><?php esc_html_e("Start creating your website by adding pages to it.", 'creativity-hub'); ?></p>
                                    </div>
                                    <div class="spt-theme-settings-content-item-content">
                                        <a class="spt-theme-settings-content-item-button" href="<?php echo esc_url(admin_url('edit.php?post_type=page')) ?>"><?php esc_html_e("Create a new page", 'creativity-hub'); ?></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="spt-theme-settings-wrapper-main-content-section">
                        <div class="spt-theme-settings-wrapper-main-content-section-top">
                            <span class="spt-theme-settings-headline"><?php esc_html_e("Premium Features", 'creativity-hub'); ?></span>
                            <a class="spt-theme-settings-headline-link" href="<?php echo esc_url($this->ThemeLink); ?>"><?php esc_html_e("Unlock All Features", 'creativity-hub'); ?></a>
                        </div>
                        <p class="spt-theme-settings-wrapper-main-content-section-top-description">
                            <?php esc_html_e("Create a beautiful website easily, without coding.", 'creativity-hub'); ?>
                        </p>

                        <div class="spt-theme-settings-content spt-theme-settings-content-us">
                            <?php
                            foreach ($this->Features as $feature) :
                            ?>
                                <a target="_blank" href="<?php echo esc_url($this->ThemeLink); ?>" class="spt-theme-settings-content-item spt-theme-settings-content-item-unavailable">
                                    <span class="spt-theme-settings-content-item-unavailable-premium"><?php echo esc_html__("Premium", 'creativity-hub'); ?></span>
                                    <div class="spt-theme-settings-content-item-header">
                                        <div>
                                            <img height="32" width="32" src="<?php echo esc_url(get_template_directory_uri() . (isset($feature['base']) ? '/inc/superbthemes-info-content/icons/' : '/inc/superbthemes-info-assets/') . $feature["icon"]); ?>" />
                                        </div>
                                        <span class="spt-theme-settings-content-us-title"><?php echo esc_html($feature["title"]); ?></span></span>
                                        <?php if (isset($feature['description'])) : ?>
                                            <p><?php echo esc_html($feature['description']); ?></p>
                                        <?php else : ?>
                                            <p><?php echo esc_html(sprintf(__("With %s Premium you'll have full access to this feature as well as all the other features listed.", 'creativity-hub'), $this->ThemeName)); ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="spt-theme-settings-content-item-content">
                                        <span class="spt-theme-settings-content-us-button-link"><?php esc_html_e("Get Premium Version", 'creativity-hub'); ?></span>
                                    </div>
                                </a>
                            <?php
                            endforeach;
                            ?>
                        </div>
                    </div>
                </div>

                <div class="spt-theme-settings-wrapper-sidebar">
                    <div class="spt-theme-settings-wrapper-sidebar-item">
                        <div class="spt-theme-settings-wrapper-sidebar-item-content">
                            <img class="spt-theme-settings-wrapper-sidebar-item-content-demo-image" src="<?php echo esc_url(get_template_directory_uri() . '/screenshot.png'); ?>" alt="<?php echo esc_attr($this->ThemeName); ?> Preview" />
                            <div class="spt-theme-settings-wrapper-sidebar-item-header"><?php esc_html_e("View Demo", 'creativity-hub'); ?></div>
                            <p><?php echo esc_html__("Need inspiration? Take a moment to view our theme demo!", 'creativity-hub') ?></p>
                            <a href="<?php echo esc_url($this->DemoLink); ?>" target="_blank" class="button"><?php esc_html_e("View Demo", 'creativity-hub'); ?></a>
                        </div>
                    </div>

                    <div class="spt-theme-settings-wrapper-sidebar-item">
                        <img width="25" height="25" src="<?php echo esc_url(get_template_directory_uri() . '/inc/superbthemes-info-content/icons/color-crown.svg'); ?>" />
                        <div class="spt-theme-settings-wrapper-sidebar-item-header"><?php esc_html_e("Upgrade to premium", 'creativity-hub'); ?></div>
                        <div class="spt-theme-settings-wrapper-sidebar-item-content">
                            <p><?php echo esc_html($this->PremiumText); ?></p>
                            <a href="<?php echo esc_url($this->ThemeLink); ?>" target="_blank" class="button button-primary"><?php esc_html_e("View Premium Version", 'creativity-hub'); ?></a>
                        </div>
                    </div>

                    <div class="spt-theme-settings-wrapper-sidebar-item">
                        <img width="25" height="25" src="<?php echo esc_url(get_template_directory_uri() . '/inc/superbthemes-info-content/icons/chats.svg'); ?>" />
                        <div class="spt-theme-settings-wrapper-sidebar-item-header"><?php esc_html_e("Contact support", 'creativity-hub'); ?></div>
                        <div class="spt-theme-settings-wrapper-sidebar-item-content">
                            <p><?php echo esc_html(sprintf(__("If you have issues with %s, please send us an email through our website!", 'creativity-hub'), $this->Theme)); ?></p>
                            <a href="https://superbthemes.com/customer-support/" target="_blank" class="button"><?php esc_html_e("Contact Support", 'creativity-hub'); ?></a>
                        </div>
                    </div>

                    <div class="spt-theme-settings-wrapper-sidebar-item">
                        <img width="25" height="25" src="<?php echo esc_url(get_template_directory_uri() . '/inc/superbthemes-info-content/icons/shooting-star.svg'); ?>" />
                        <div class="spt-theme-settings-wrapper-sidebar-item-header"><?php esc_html_e("Give us feedback", 'creativity-hub'); ?></div>
                        <div class="spt-theme-settings-wrapper-sidebar-item-content">
                            <p><?php echo esc_html(sprintf(__("Do you enjoy using %s? Support us by reviewing us on WordPress.org!", 'creativity-hub'), $this->Theme)); ?></p>
                            <a href="https://wordpress.org/support/theme/<?php echo esc_attr(get_stylesheet()); ?>/reviews/#new-post" target="_blank" class="button"><?php esc_html_e("Leave a Review", 'creativity-hub'); ?></a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
<?php
    }
}
