<?php

namespace SuperbAddons\Admin\Pages;

defined('ABSPATH') || exit();

use SuperbAddons\Admin\Controllers\DashboardController;
use SuperbAddons\Admin\Controllers\Wizard\WizardController;
use SuperbAddons\Components\Admin\EditorPreviewsModal;
use SuperbAddons\Components\Admin\NewsletterForm;
use SuperbAddons\Data\Utils\Wizard\WizardActionParameter;

class DashboardPage
{
    private $theme_designer_url;
    private $add_new_pages_url;
    private $custom_css_url;
    private $woocommerce_header_url;
    private $header_footer_url;

    public function __construct()
    {
        $this->theme_designer_url = WizardController::GetWizardURL(WizardActionParameter::INTRO);
        $this->add_new_pages_url = WizardController::GetWizardURL(WizardActionParameter::ADD_NEW_PAGES);
        $this->woocommerce_header_url = WizardController::GetWizardURL(WizardActionParameter::WOOCOMMERCE_HEADER);
        $this->header_footer_url = WizardController::GetWizardURL(WizardActionParameter::HEADER_FOOTER);
        $this->custom_css_url = add_query_arg(
            array(
                'page' => DashboardController::ADDITIONAL_CSS,
            ),
            admin_url("admin.php")
        );
        $this->Render();
    }

    private function Render()
    {
?>
        <div class="superbthemes-module-introduction-box">
            <div class="superbthemes-module-introduction-box-content" style="background-image:url(<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/superb-addons-preview.png'); ?>);">
                <h1><?= esc_html__("An introduction to Superb Addons", "superb-blocks"); ?></h1>
                <p><?= esc_html__("Supercharge the WordPress Editor and unlock new pre-built websites, features, patterns, blocks and sections.", "superb-blocks"); ?></p>
            </div>
            <div class="superbthemes-module-introduction-box-footer">
                <?php new NewsletterForm(__("Sign up for our newsletter to get updates, freebies, and more.", "superb-blocks"), true); ?>
            </div>
        </div>

        <div class="superbthemes-module-feature-grid-large">

            <div class="superbthemes-module-feature-grid-large-item" style="background-image:url(<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/theme-designer-bg.svg'); ?>)">
                <img src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/theme-designer-icon.svg'); ?>" aria-hidden="true" width="54" height="54">
                <h3><?= esc_html__("Theme Designer", "superb-blocks"); ?></h3>
                <p><?= esc_html__("Customize your website's layout and design with a few clicks.", "superb-blocks"); ?></p>
                <a class="superbthemes-module-cta superbthemes-module-cta-green" href="<?= esc_url($this->theme_designer_url); ?>"><?= esc_html__("Launch Theme Designer", "superb-blocks"); ?></a>
            </div>

            <div class="superbthemes-module-feature-grid-large-item" style="background-image:url(<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/template-page-bg.svg'); ?>)">
                <img src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/template-page-icon.svg'); ?>" aria-hidden="true" width="54" height="54">
                <h3><?= esc_html__("Template Pages", "superb-blocks"); ?></h3>
                <p><?= esc_html__("Add pre-built page designs to your site and insert your own content.", "superb-blocks"); ?></p>
                <a class="superbthemes-module-cta" href="<?= esc_url($this->add_new_pages_url); ?>"><?= esc_html__("Add Template Pages", "superb-blocks"); ?></a>
            </div>

            <div class="superbthemes-module-feature-grid-large-item" style="background-image:url(<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/gutenberg-patterns-bg.svg'); ?>)">
                <img src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/gutenberg-patterns-icon.svg'); ?>" aria-hidden="true" width="54" height="54">
                <h3><?= esc_html__("WordPress Editor Patterns", "superb-blocks"); ?></h3>
                <p><?= esc_html__("Explore hundreds of pre-built patterns that you can insert with one click.", "superb-blocks"); ?></p>
                <button type="button" class="superbthemes-module-cta" id="gutenberg-lib-modal-btn"><?= esc_html__("Explore Patterns", "superb-blocks"); ?></button>
            </div>

        </div>

        <div class="superbthemes-module-feature-grid-small">
            <div class="superbthemes-module-feature-grid-small-item" style="background-image:url(<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/superb-blocks.svg'); ?>)">
                <h3><?= esc_html__("Blocks & WordPress Editor Enhancements", "superb-blocks"); ?></h3>
                <p><?= esc_html__("Access must-have blocks, Enhanced editor, grid systems, improved block control and much more", "superb-blocks"); ?>.</p>
                <button type="button" id="superb-addons-dashboard-preview-modal-btn" class="superbthemes-module-cta-link"><?= esc_html__("Explore blocks and enhancements", "superb-blocks"); ?></button>
            </div>

            <div class="superbthemes-module-feature-grid-small-item" style="background-image:url(<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/custom-css.svg'); ?>)">
                <h3><?= esc_html__("Custom CSS", "superb-blocks"); ?></h3>
                <p><?= esc_html__("Add custom CSS with syntax highlight, custom display settings, and minified output.", "superb-blocks"); ?></p>
                <a href="<?= esc_url($this->custom_css_url); ?>" class="superbthemes-module-cta-link"><?= esc_html__("Add custom CSS", "superb-blocks"); ?></a>
            </div>

            <div class="superbthemes-module-feature-grid-small-item" style="background-image:url(<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/dashboard-header-footer.svg'); ?>)">
                <h3><?= esc_html__("Header & Footer Templates", "superb-blocks"); ?></h3>
                <p><?= esc_html__("Select your website's new header and footer layout with a few clicks.", "superb-blocks"); ?></p>
                <a href="<?= esc_url($this->header_footer_url); ?>" class="superbthemes-module-cta-link"><?= esc_html__("Select header and footer", "superb-blocks"); ?></a>
            </div>

            <div class="superbthemes-module-feature-grid-small-item" style="background-image:url(<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/dashboard-wc-icon.svg'); ?>)">
                <h3><?= esc_html__("WooCommerce Header Templates", "superb-blocks"); ?></h3>
                <p><?= esc_html__("Select a premade WooCommerce compatible header template and navigation menu.", "superb-blocks"); ?></p>
                <?php if (is_plugin_active('woocommerce/woocommerce.php')): ?>
                    <a href="<?= esc_url($this->woocommerce_header_url); ?>" class="superbthemes-module-cta-link"><?= esc_html__("Select WooCommerce header", "superb-blocks"); ?></a>
                <?php else: ?>
                    <span class="superbthemes-module-cta-link-disabled superbaddons-element-text-gray"><?= esc_html__("Requires WooCommerce", "superb-blocks"); ?></span>
                <?php endif; ?>
            </div>

            <div class="superbthemes-module-feature-grid-small-item" style="background-image:url(<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/elementor-sections.svg'); ?>)">
                <h3><?= esc_html__("Elementor Sections", "superb-blocks"); ?></h3>
                <p><?= esc_html__("Access 300+ pre-built elementor sections and build beautiful sites, fast.", "superb-blocks"); ?></p>
                <button type="button" id="elementor-lib-modal-btn" class="superbthemes-module-cta-link"><?= esc_html__("Explore sections", "superb-blocks"); ?></button>
            </div>

            <div class="superbthemes-module-feature-grid-small-item" style="background-image:url(<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/get-help.svg'); ?>)">
                <h3><?= esc_html__("Get Help", "superb-blocks"); ?></h3>
                <p><?= esc_html__("Our team is here to assist you. If you have any questions or issues, please don't hesitate to reach out.", "superb-blocks"); ?></p>
                <a href="https://superbthemes.com/contact/" target="_blank" class="superbthemes-module-cta-link"><?= esc_html__("Contact support", "superb-blocks"); ?></a>
            </div>
        </div>

<?php
        new EditorPreviewsModal();
    }
}
