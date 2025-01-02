<?php

namespace SuperbAddons\Admin\Pages\Wizard;

use SuperbAddons\Admin\Controllers\Wizard\WizardController;
use SuperbAddons\Admin\Controllers\Wizard\WizardRestorationPointController;
use SuperbAddons\Data\Utils\Wizard\WizardActionParameter;

defined('ABSPATH') || exit();

class PageWizardIntroPage
{
    private $theme_designer_url;
    private $add_new_pages_url;
    private $restore_url;

    public function __construct()
    {
        $this->theme_designer_url = WizardController::GetWizardURL(WizardActionParameter::THEME_DESIGNER);
        $this->add_new_pages_url = WizardController::GetWizardURL(WizardActionParameter::ADD_NEW_PAGES);
        $this->restore_url = WizardController::GetWizardURL(WizardActionParameter::RESTORE);


        if (WizardController::ThemeHasCompletedWizard()) {
            $this->RenderQuickStartCompleted();
            return;
        }

        $this->Render();
    }

    private function Render()
    {
?>

        <div class="superbaddons-wizard-wrapper-small">
            <div class="superbaddons-admindashboard-content-box-large">
                <div class="superbaddons-wizard-heading">
                    <img src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/wizard-magic-wand.svg'); ?>" width="60" height="60">
                    <h1><?= esc_html__("Welcome to the Theme Designer", "superb-blocks"); ?></h1>
                </div>
                <p class="superbaddons-element-text-sm superbaddons-wizard-tagline"><?= esc_html__("With the Theme Designer, you’ll customize your site’s design step by step. Here’s what you can expect.", "superb-blocks"); ?></p>
                <ol class="superbaddons-wizard-icon-list">
                    <li>
                        <div class="superbaddons-wizard-icon-list-left">
                            <img aria-hidden="true" width="38" height="38" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/wizard-menu-layout.svg'); ?>">
                        </div>
                        <div class="superbaddons-wizard-icon-list-right">
                            <span><?= esc_html__("1. Select menu layout", "superb-blocks"); ?></span>
                        </div>
                    </li>
                    <li>
                        <div class="superbaddons-wizard-icon-list-left">
                            <img aria-hidden="true" width="38" height="38" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/wizard-footer-layout.svg'); ?>">
                        </div>
                        <div class="superbaddons-wizard-icon-list-right">
                            <span><?= esc_html__("2. Select footer layout", "superb-blocks"); ?></span>
                        </div>
                    </li>
                    <li>
                        <div class="superbaddons-wizard-icon-list-left">
                            <img aria-hidden="true" width="38" height="38" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/wizard-front-page-design.svg'); ?>">
                        </div>
                        <div class="superbaddons-wizard-icon-list-right">
                            <span><?= esc_html__("3. Select front page design", "superb-blocks"); ?></span>
                        </div>
                    </li>
                    <li>
                        <div class="superbaddons-wizard-icon-list-left">
                            <img aria-hidden="true" width="38" height="38" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/wizard-blog-setup.svg'); ?>">
                        </div>
                        <div class="superbaddons-wizard-icon-list-right">
                            <span><?= esc_html__("4. Select blog setup", "superb-blocks"); ?></span>
                        </div>
                    </li>
                    <li>
                        <div class="superbaddons-wizard-icon-list-left">
                            <img aria-hidden="true" width="38" height="38" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/wizard-additional-pages.svg'); ?>">
                        </div>
                        <div class="superbaddons-wizard-icon-list-right">
                            <span><?= esc_html__("5. Select additional pages (about, contact +more)", "superb-blocks"); ?></span>
                        </div>
                    </li>
                </ol>

                <a href="<?= esc_url($this->theme_designer_url); ?>" class="superbthemes-module-cta superbthemes-module-cta-green"><?= esc_html__("Start Theme Designer", "superb-blocks"); ?></a>

                <?php $this->RenderRestorationSection(); ?>
            </div>
        </div>
    <?php
    }

    private function RenderQuickStartCompleted()
    {
    ?>
        <div class="superbaddons-wizard-wrapper-small">
            <div class="superbaddons-admindashboard-content-box-large">
                <div class="superbaddons-wizard-heading">
                    <img aria-hidden="true" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/wizard-magic-wand.svg'); ?>" width="60" height="60">
                    <h1><?= esc_html__("Welcome back to the ", "superb-blocks"); ?> <br> <?= esc_html__("Theme Designer!", "superb-blocks"); ?></h1>
                </div>
                <p class="superbaddons-element-text-sm superbaddons-wizard-tagline"><?= esc_html__("It looks like you've already completed the Theme Designer setup. Here are some options to help you continue enhancing your website.", "superb-blocks"); ?></p>

                <h2 class="superbaddons-element-text-sm superbaddons-wizard-headline"><?= esc_html__("What would you like to do next?", "superb-blocks"); ?></h2>
                <div class="superbaddons-wizard-buttons-wrapper">
                    <a href="<?= esc_url($this->add_new_pages_url); ?>" class="superbthemes-module-cta superbthemes-module-cta-green"><?= esc_html__("Add New Template Pages", "superb-blocks"); ?></a>
                    <a href="<?= esc_url($this->theme_designer_url); ?>" class="superbthemes-module-cta"><?= esc_html__("Restart Theme Designer", "superb-blocks"); ?></a>
                </div>

                <?php $this->RenderRestorationSection(); ?>
            </div>
        </div>
    <?php
    }


    private function RenderRestorationSection()
    {
    ?>
        <div class="superbaddons-wizard-restoration-button-wrapper superbaddons-element-separator">
            <p><?= esc_html__("The theme designer creates a restoration point for each template whenever the theme designer is completed.", "superb-blocks"); ?></p>
            <?php if (WizardRestorationPointController::GetThemeRestorationPoints()): ?>
                <p><?= esc_html__("You can restore the templates to a restoration point, if you want one or more of your templates to return to an earlier version. When restoring templates, you'll need to first select which restoration point you want to use for each template.", "superb-blocks"); ?></p>
                <a href="<?= esc_url($this->restore_url); ?>" class="superbthemes-module-cta-link"><?= esc_html__("Restore Templates", "superb-blocks"); ?></a>
                <p><?= esc_html__("Restoration points are automatically removed 2 months after creation to prevent cluttering your database.", "superb-blocks"); ?></p>
            <?php endif; ?>
        </div>
<?php
    }
}
