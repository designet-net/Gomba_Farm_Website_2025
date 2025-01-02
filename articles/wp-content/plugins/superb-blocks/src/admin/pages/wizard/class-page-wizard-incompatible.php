<?php

namespace SuperbAddons\Admin\Pages\Wizard;

use SuperbAddons\Admin\Controllers\Wizard\WizardController;
use SuperbAddons\Components\Admin\Modal;

defined('ABSPATH') || exit();

class PageWizardIncompatiblePage
{
    private $themes;
    private $current_theme;
    private $theme_name;

    public function __construct()
    {
        $this->current_theme = wp_get_theme();
        $this->theme_name = $this->current_theme->get('Name');
        $this->themes = WizardController::GetRecommendedBlockThemes();
        $this->Render();
    }

    private function Render()
    {
?>
        <div class="superbaddons-template-stage" data-stageid="theme-stage" data-type="single-selection">
            <div class="superbaddons-wizard-wrapper-small">
                <div class="superbaddons-admindashboard-content-box-large">
                    <div class="superbaddons-wizard-heading">
                        <h1><?= esc_html__("Incompatible Theme", "superb-blocks"); ?> </h1>
                    </div>
                    <p class="superbaddons-element-text-sm superbaddons-wizard-tagline"><?= esc_html(sprintf(__("Unfortunately, this feature is currently exclusive to block themes. The theme you're using, \"%s\", is not a block theme or does not support block theme templates.", "superb-blocks"), $this->theme_name)); ?></p>
                    <br>
                    <p class="superbaddons-element-text-sm superbaddons-wizard-tagline"><strong><?= esc_html__("Choose a Block theme to use the theme designer:", "superb-blocks"); ?> </strong></p>
                </div>
            </div>
            <div class="superbaddons-theme-template-container superbaddons-element-mt1">
                <?php foreach ($this->themes->themes as $theme) :
                    if ($theme->slug == $this->current_theme->stylesheet) continue; // skip current theme
                ?>
                    <div class="superbaddons-theme-page-template superbaddons-element-text-dark" style="height:auto !important;" data-title="<?= esc_attr($theme->name); ?>" data-slug="<?= esc_attr($theme->slug); ?>" data-package="free">
                        <div class="superbaddons-template-content-wrapper">
                            <img class="superbaddons-preview-image" src="<?= esc_url($theme->screenshot_url); ?>" width="100%" height="auto" style="user-select:none;" />
                        </div>
                        <div class="superbaddons-template-information">
                            <div class="superbaddons-template-information-inner superbaddons-element-flex-center">
                                <div class="superbaddons-template-information-title superbaddons-element-text-sm">
                                    <?= esc_html($theme->name); ?>
                                </div>
                                <div class="superbaddons-template-information-package superbaddons-element-text-xs superbaddons-element-text-gray">
                                    <?= esc_html__("Free", "superb-blocks"); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="superbaddons-theme-template-menu superbadd superbaddons-element-flex-center superbaddons-element-flex-gap1" style="display:none;">
            <p class="superbaddons-element-text-sm superbaddons-element-m0 superbaddons-wizard-tagline"><?= esc_html__("Install", "superb-blocks"); ?> <strong id="superbaddons-selected-theme-name"></strong> <?= esc_html__("and get started?", "superb-blocks"); ?></p>
            <button id="superbaddons-theme-install-button" class="superbthemes-module-cta superbthemes-module-cta-green" style="display:block;"><?= esc_html__("Install", "superb-blocks"); ?></button>
        </div>
<?php
        new Modal();
    }
}
