<?php

namespace SuperbAddons\Admin\Pages\Wizard;

use SuperbAddons\Admin\Controllers\Wizard\WizardController;
use SuperbAddons\Components\Admin\NewsletterForm;
use SuperbAddons\Data\Utils\Wizard\WizardActionParameter;

defined('ABSPATH') || exit();

class PageWizardCompletePage
{
    public function __construct()
    {
        $completedType = WizardController::GetCompletedWizardType();
        if (!$completedType) {
            new PageWizardIntroPage();
            return;
        }

        if ($completedType == WizardActionParameter::THEME_DESIGNER) {
            if (!WizardController::ThemeHasCompletedWizard()) {
                new PageWizardIntroPage();
                return;
            }
            $this->RenderCompletionPage(
                __("You're All Set!", "superb-blocks"),
                __("Congratulations! Your new website design is ready. Now that you’ve customized the look and feel, here are some options for what you can do next:")
            );
            return;
        }

        if ($completedType == WizardActionParameter::ADD_NEW_PAGES) {
            $this->RenderCompletionPage(
                __("Your New Pages Have Been Added!", "superb-blocks"),
                __("Now that your new pages have been added, here are a few things you can do to make the most out of your new pages:")
            );
            return;
        }

        if ($completedType == WizardActionParameter::WOOCOMMERCE_HEADER) {
            $this->RenderCompletionPage(
                __("You're All Set!", "superb-blocks"),
                __("Now that your WooCommerce header has been added, here are some options for what you can do next:")
            );
            return;
        }

        if ($completedType == WizardActionParameter::HEADER_FOOTER) {
            $this->RenderCompletionPage(
                __("You're All Set!", "superb-blocks"),
                __("Now that your header and footer have been added, here are some options for what you can do next:")
            );
            return;
        }

        if ($completedType == WizardActionParameter::RESTORE) {
            $this->RenderCompletionPage(
                __("Your Templates Have Been Restored!", "superb-blocks"),
                __("Your templates have been restored to the restoration points you've selected. Here are some options for what you can do next:")
            );
            return;
        }

        new PageWizardIntroPage();
    }

    private function RenderCompletionPage($title, $description, $cta = true)
    {
?>
        <div class="superbaddons-wizard-wrapper-small">
            <div class="superbaddons-admindashboard-content-box-large">
                <div class="superbaddons-wizard-heading">
                    <img src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/superbthemes-wizard-checkmark.svg'); ?>" width="60" height="60">
                    <h1><?= esc_html($title); ?> </h1>
                </div>
                <p class="superbaddons-element-text-sm superbaddons-wizard-tagline"><?= esc_html($description); ?></p>
                <?php if ($cta) : ?>
                    <?php $this->RenderSuggestionsAndCTA(); ?>
                <?php endif; ?>
            </div>
        </div>
    <?php
    }

    private function RenderSuggestionsAndCTA()
    {
    ?>
        <div class="superbaddons-wizard-completed-cta-buttons-wrapper">
            <a target="_blank" href="<?= esc_url(home_url()); ?>" class="superbthemes-module-cta superbthemes-module-cta-green"><?= esc_html__("View Site", "superb-blocks"); ?></a>
            <a target="_blank" href="<?= esc_url(admin_url('site-editor.php?path=/wp_template')); ?>" class="superbthemes-module-cta"><?= esc_html__("Edit Templates", "superb-blocks"); ?></a>
            <a target="_blank" href="<?= esc_url(admin_url('edit.php?post_type=page')); ?>" class="superbthemes-module-cta"><?= esc_html__("Edit Pages", "superb-blocks"); ?></a>
        </div>
        <div class="superbaddons-wizard-completed-newsletter-wrapper">
            <?php new NewsletterForm(); ?>
        </div>

<?php
    }
}
