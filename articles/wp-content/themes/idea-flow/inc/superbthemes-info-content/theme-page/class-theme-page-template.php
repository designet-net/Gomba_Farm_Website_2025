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
        $this->ThemeName = is_child_theme() ? sprintf(__("%s and %s", 'idea-flow'), $this->Theme, $this->ParentName) : $this->Theme;
        $this->PremiumText = is_child_theme() ? sprintf(__("Unlock all features by upgrading to the premium edition of %s and its parent theme %s.", 'idea-flow'), $this->Theme, $this->ParentName) : sprintf(__("Unlock all features by upgrading to the premium edition of %s.", 'idea-flow'), $this->Theme);
        $this->ThemeLink = $data['theme_url'];
        $this->DemoLink = $data['demo_url'];
        $base_features = array(
            array(
                'title' => __("Fully Search Engine Optimized", "idea-flow"), 'base' => true, 'icon' => "img-icon-8.png", 'description' => __("Get free traffic by ranking #1 on Google with the lightning-fast & SEO-optimized premium version.", "idea-flow")
            ),
            array(
                'title' => __("Page Speed Optimized", "idea-flow"), 'base' => true, 'icon' => "img-icon-6.png", 'description' => __("Unlock maximum speed with the premium version. It loads in less than 0.3 seconds. ", "idea-flow")
            ),
            array(
                'title' => __("Customize Everything", "idea-flow"), 'base' => true, 'icon' => "img-icon-7.png", 'description' => __("Customize the design to fit your brand or style with our easy-to-use customization options.", "idea-flow")
            ),
            array(
                'title' => __("E-commerce Compatibility", "idea-flow"), 'base' => true, 'icon' => "img-icon-5.png", 'description' => __("Create your online store easily. The premium version is compatible with all popular e-commerce plugins.", "idea-flow")
            ),
            array(
                'title' => __("Customer Support & Documentation", "idea-flow"), 'base' => true, 'icon' => "img-icon-4.png", 'description' => __("Benefit from our comprehensive documentation and dedicated support team, always ready to help.", "idea-flow")
            ),
            array(
                'title' => __("Works With All Page Builders", "idea-flow"), 'base' => true, 'icon' => "img-icon-3.png", 'description' => __("Brizy, Elementor, Divi Builder, Beaver Builder - you name it. Every page builder plugin is compatible.", "idea-flow")
            ),
            array(
                'title' => __("1-Click Starter Content Import", "idea-flow"), 'base' => true, 'icon' => "img-icon-2.png", 'description' => __("Get started easily with our one-click demo content import feature. Get your website up and running in seconds.", "idea-flow")
            ),
            array(
                'title' => __("Premium Designs, Patterns & Layouts", "idea-flow"), 'base' => true, 'icon' => "img-icon-1.png", 'description' => __("Access all the premium layouts and designs perfect for any niche or industry.", "idea-flow")
            ),
            array(
                'title' => __("Works On All Devices And Browsers", "idea-flow"), 'base' => true, 'icon' => "devices-duotone.svg", 'description' => __("The premium version looks perfect everywhere, from desktop to mobile, and in every browser.", "idea-flow")
            ),
            array(
                'title' => __("AMP Compatible And Mobile Ready", "idea-flow"), 'base' => true, 'icon' => "fse_icon_mobile.svg", 'description' => __("Stay ahead with Accelerated Mobile Pages (AMP) compatibility.", "idea-flow")
            ),
            array(
                'title' => __("GDPR Compliant", "idea-flow"), 'base' => true, 'icon' => "shield-check-duotone.svg", 'description' => __("Our premium version comes fully compliant, giving you peace of mind about user data protection and privacy.", "idea-flow")
            ),
            array(
                'title' => __("Frequent Updates", "idea-flow"), 'base' => true, 'icon' => "arrows-clockwise-duotone.svg", 'description' => __("Our premium version provides frequent enhancements for security, performance, and features.", "idea-flow")
            ),
            array(
                'title' => __("Child Themes", "idea-flow"), 'base' => true, 'icon' => "img-2.png", 'description' => __("Use child themes to make modifications without affecting the parent theme's code, ensuring smooth updates.", "idea-flow")
            ),
            array(
                'title' => __("WordPress blocks", "idea-flow"), 'base' => true, 'icon' => "stack-duotone.png", 'description' => __("Use our many custom WordPress Gutenberg blocks for every purpose!", "idea-flow")
            ),
            array(
                'title' => __("WordPress patterns", "idea-flow"), 'base' => true, 'icon' => "grid-nine-duotone.png", 'description' => __("Take advantage of the 400+ beautiful patterns for every type of website.", "idea-flow")
            ),
            array(
                'title' => __("Elementor sections", "idea-flow"), 'base' => true, 'icon' => "img-1.png", 'description' => __("Access 300+ pre-built Elementor sections and build beautiful sites, fast.", "idea-flow")
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
                        <span class="spt-theme-settings-headline"><?php esc_html_e("Customize Settings", 'idea-flow'); ?></span>
                        <a class="spt-theme-settings-headline-link" href="<?php echo esc_url(admin_url('site-editor.php'))  ?>"><?php esc_html_e("Go To Site Editor", 'idea-flow'); ?></a>
                    </div>

                    <div class="spt-theme-settings-content">

                        <div class="spt-theme-settings-content-getting-started-wrapper">
                            <div class="spt-theme-settings-content-item">
                                <div class="spt-theme-settings-content-item-header">
                                    <img width="25" height="25" src="<?php echo esc_url(get_template_directory_uri() . '/inc/superbthemes-info-content/icons/list-bullets.svg'); ?>" />
                                    <div class="spt-theme-settings-content-item-headline">
                                        <?php esc_html_e("Add Menus", 'idea-flow'); ?>
                                    </div>
                                    <p><?php esc_html_e("Add a navigation to your website to improve the user experience.", 'idea-flow'); ?></p>
                                </div>
                                <div class="spt-theme-settings-content-item-content">
                                    <a class="spt-theme-settings-content-item-button" href="<?php echo esc_url(admin_url('site-editor.php'))  ?>"><?php esc_html_e("Go To Site Editor", 'idea-flow'); ?></a>
                                </div>
                            </div>

                            <div class="spt-theme-settings-content-item">
                                <div class="spt-theme-settings-content-item-header">
                                    <img width="25" height="25" src="<?php echo esc_url(get_template_directory_uri() . '/inc/superbthemes-info-content/icons/squares-four.svg'); ?>" />
                                    <div class="spt-theme-settings-content-item-headline">
                                        <?php esc_html_e("Edit Front Page", 'idea-flow'); ?>
                                    </div>
                                    <p><?php esc_html_e("Edit and customize your front page design through the site editor.", 'idea-flow'); ?></p>
                                </div>
                                <div class="spt-theme-settings-content-item-content">
                                    <a class="spt-theme-settings-content-item-button" href="<?php echo esc_url(admin_url('site-editor.php'))  ?>"><?php esc_html_e("Go To Site Editor", 'idea-flow'); ?></a>
                                </div>
                            </div>

                            <div class="spt-theme-settings-content-item">
                                <div class="spt-theme-settings-content-item-header">
                                    <img width="25" height="25" src="<?php echo esc_url(get_template_directory_uri() . '/inc/superbthemes-info-content/icons/paint-brush.svg'); ?>" />
                                    <div class="spt-theme-settings-content-item-headline">
                                        <?php esc_html_e("Customize Design", 'idea-flow'); ?>
                                    </div>
                                    <p><?php esc_html_e("Customize your website design to fit your personality or brand.", 'idea-flow'); ?></p>
                                </div>
                                <div class="spt-theme-settings-content-item-content">
                                    <a class="spt-theme-settings-content-item-button" href="<?php echo esc_url(admin_url('site-editor.php'))  ?>"><?php esc_html_e("Go To Site Editor", 'idea-flow'); ?></a>
                                </div>
                            </div>

                            <div class="spt-theme-settings-content-item">
                                <div class="spt-theme-settings-content-item-header">
                                    <img width="25" height="25" src="<?php echo esc_url(get_template_directory_uri() . '/inc/superbthemes-info-content/icons/text-a-underline.svg'); ?>" />
                                    <div class="spt-theme-settings-content-item-headline">
                                        <?php esc_html_e("Change Site Title", 'idea-flow'); ?>
                                    </div>
                                    <p><?php esc_html_e("Add your website name and tagline to improve the design and SEO.", 'idea-flow'); ?></p>
                                </div>
                                <div class="spt-theme-settings-content-item-content">
                                    <a class="spt-theme-settings-content-item-button" href="<?php echo esc_url(admin_url('site-editor.php'))  ?>"><?php esc_html_e("Go To Site Editor", 'idea-flow'); ?></a>
                                </div>
                            </div>

                            <div class="spt-theme-settings-content-item">
                                <div class="spt-theme-settings-content-item-header">
                                    <img width="25" height="25" src="<?php echo esc_url(get_template_directory_uri() . '/inc/superbthemes-info-content/icons/image.svg'); ?>" />
                                    <div class="spt-theme-settings-content-item-headline">
                                        <?php esc_html_e("Upload Logo", 'idea-flow'); ?>
                                    </div>
                                    <p><?php esc_html_e("Add a custom logo to make your website look more professional.", 'idea-flow'); ?></p>
                                </div>
                                <div class="spt-theme-settings-content-item-content">
                                    <a class="spt-theme-settings-content-item-button" href="<?php echo esc_url(admin_url('site-editor.php'))  ?>"><?php esc_html_e("Go To Site Editor", 'idea-flow'); ?></a>
                                </div>
                            </div>

                            <div class="spt-theme-settings-content-item">
                                <div class="spt-theme-settings-content-item-header">
                                    <img width="25" height="25" src="<?php echo esc_url(get_template_directory_uri() . '/inc/superbthemes-info-content/icons/file.svg'); ?>" />
                                    <div class="spt-theme-settings-content-item-headline">
                                        <?php esc_html_e("Create New Pages", 'idea-flow'); ?>
                                    </div>
                                    <p><?php esc_html_e("Start creating your website by adding pages to it.", 'idea-flow'); ?></p>
                                </div>
                                <div class="spt-theme-settings-content-item-content">
                                    <a class="spt-theme-settings-content-item-button" href="<?php echo esc_url(admin_url('edit.php?post_type=page')) ?>"><?php esc_html_e("Create a new page", 'idea-flow'); ?></a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="spt-theme-settings-wrapper-main-content-section">
                    <div class="spt-theme-settings-wrapper-main-content-section-top">
                        <span class="spt-theme-settings-headline"><?php esc_html_e("Premium Features", 'idea-flow'); ?></span>
                        <a class="spt-theme-settings-headline-link" href="<?php echo esc_url($this->ThemeLink); ?>"><?php esc_html_e("Unlock All Features", 'idea-flow'); ?></a>
                    </div>
                    <p class="spt-theme-settings-wrapper-main-content-section-top-description">
                        <?php esc_html_e("Create a beautiful website easily, without coding.", 'idea-flow'); ?>
                    </p>

                    <div class="spt-theme-settings-content spt-theme-settings-content-us">
                        <?php
                        foreach ($this->Features as $feature) :
                            ?>
                            <a target="_blank" href="<?php echo esc_url($this->ThemeLink); ?>" class="spt-theme-settings-content-item spt-theme-settings-content-item-unavailable">
                                <span class="spt-theme-settings-content-item-unavailable-premium"><?php echo esc_html__("Premium", 'idea-flow'); ?></span>
                                <div class="spt-theme-settings-content-item-header">
                                    <div>
                                        <img height="32" width="32" src="<?php echo esc_url(get_template_directory_uri() . (isset($feature['base']) ? '/inc/superbthemes-info-content/icons/' : '/inc/superbthemes-info-assets/') . $feature["icon"]); ?>" />
                                    </div>
                                    <span class="spt-theme-settings-content-us-title"><?php echo esc_html($feature["title"]); ?></span></span>
                                    <?php if (isset($feature['description'])) : ?>
                                        <p><?php echo esc_html($feature['description']); ?></p>
                                    <?php else : ?>
                                        <p><?php echo esc_html(sprintf(__("With %s Premium you'll have full access to this feature as well as all the other features listed.", 'idea-flow'), $this->ThemeName)); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="spt-theme-settings-content-item-content">
                                    <span class="spt-theme-settings-content-us-button-link"><?php esc_html_e("Get Premium Version", 'idea-flow'); ?></span>
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
                        <div class="spt-theme-settings-wrapper-sidebar-item-header"><?php esc_html_e("View Demo", 'idea-flow'); ?></div>
                        <p><?php echo esc_html__("Need inspiration? Take a moment to view our theme demo!", 'idea-flow') ?></p>
                        <a href="<?php echo esc_url($this->DemoLink); ?>" target="_blank" class="button"><?php esc_html_e("View Demo", 'idea-flow'); ?></a>
                    </div>
                </div>

                <div class="spt-theme-settings-wrapper-sidebar-item">
                    <img width="25" height="25" src="<?php echo esc_url(get_template_directory_uri() . '/inc/superbthemes-info-content/icons/color-crown.svg'); ?>" />
                    <div class="spt-theme-settings-wrapper-sidebar-item-header"><?php esc_html_e("Upgrade to premium", 'idea-flow'); ?></div>
                    <div class="spt-theme-settings-wrapper-sidebar-item-content">
                        <p><?php echo esc_html($this->PremiumText); ?></p>
                        <a href="<?php echo esc_url($this->ThemeLink); ?>" target="_blank" class="button button-primary"><?php esc_html_e("View Premium Version", 'idea-flow'); ?></a>
                    </div>
                </div>

                <div class="spt-theme-settings-wrapper-sidebar-item">
                    <img width="25" height="25" src="<?php echo esc_url(get_template_directory_uri() . '/inc/superbthemes-info-content/icons/chats.svg'); ?>" />
                    <div class="spt-theme-settings-wrapper-sidebar-item-header"><?php esc_html_e("Contact support", 'idea-flow'); ?></div>
                    <div class="spt-theme-settings-wrapper-sidebar-item-content">
                        <p><?php echo esc_html(sprintf(__("If you have issues with %s, please send us an email through our website!", 'idea-flow'), $this->Theme)); ?></p>
                        <a href="https://superbthemes.com/customer-support/" target="_blank" class="button"><?php esc_html_e("Contact Support", 'idea-flow'); ?></a>
                    </div>
                </div>

                <div class="spt-theme-settings-wrapper-sidebar-item">
                    <img width="25" height="25" src="<?php echo esc_url(get_template_directory_uri() . '/inc/superbthemes-info-content/icons/shooting-star.svg'); ?>" />
                    <div class="spt-theme-settings-wrapper-sidebar-item-header"><?php esc_html_e("Give us feedback", 'idea-flow'); ?></div>
                    <div class="spt-theme-settings-wrapper-sidebar-item-content">
                        <p><?php echo esc_html(sprintf(__("Do you enjoy using %s? Support us by reviewing us on WordPress.org!", 'idea-flow'), $this->Theme)); ?></p>
                        <a href="https://wordpress.org/support/theme/<?php echo esc_attr(get_stylesheet()); ?>/reviews/#new-post" target="_blank" class="button"><?php esc_html_e("Leave a Review", 'idea-flow'); ?></a>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <?php
}
}
