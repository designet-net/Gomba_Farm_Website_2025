<?php

namespace SuperbAddons\Components\Admin;

defined('ABSPATH') || exit();

use SuperbAddons\Gutenberg\Controllers\GutenbergEnhancementsController;

class EnhancementSettingsComponent
{
    private $Settings;

    public function __construct()
    {
        $this->Settings = GutenbergEnhancementsController::GetEnhancementsOptions(get_current_user_id());
        $this->Render();
    }

    private function Render()
    {
?>
        <h4 class="superbaddons-element-text-sm superbaddons-element-text-dark superbaddons-element-text-800 superbaddons-element-m0"><?= esc_html__("WordPress Editor Settings", "superb-blocks"); ?></h4>
        <p class="superbaddons-element-text-xs superbaddons-element-text-gray"><?= esc_html__("Manage your Superb Addons settings for the WordPress editor.", "superb-blocks"); ?></p>

        <div class="superbaddons-editor-settings-highlights-wrapper">
            <h5 class="superbaddons-element-flex-center superbaddons-element-text-xs superbaddons-element-text-dark superbaddons-element-text-800 superbaddons-element-m0 superbaddons-element-mb1"><img class="superbaddons-admindashboard-content-icon superbaddons-element-mr1" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/purple-selection-plus.svg'); ?>" /><?= esc_html__("Editor Highlights", "superb-blocks"); ?></h5>
            <?php new InputCheckbox('superbaddons-enhancement-highlights-input', GutenbergEnhancementsController::HIGHLIGHTS_KEY, __("Enable Highlights", "superb-blocks"), __("When this setting is enabled, related block and editable text will be highlighted with an outline whenever you hover over a block with your mouse.", "superb-blocks"), $this->Settings[GutenbergEnhancementsController::HIGHLIGHTS_KEY], '/img/selection-plus.svg'); ?>
            <?php new InputCheckbox('superbaddons-enhancement-highlights-quickoptions-input', GutenbergEnhancementsController::HIGHLIGHTS_QUICKOPTIONS_KEY, __("Quick Options", "superb-blocks"), __("Enables a quick options panel at the top of the highlighted or selected block.", "superb-blocks"), $this->Settings[GutenbergEnhancementsController::HIGHLIGHTS_QUICKOPTIONS_KEY]); ?>
            <?php new InputCheckbox('superbaddons-enhancement-highlights-quickoptions-bottom-input', GutenbergEnhancementsController::HIGHLIGHTS_QUICKOPTIONS_BOTTOM_KEY, __("Position Quick Options at Bottom", "superb-blocks"), __("Moves the quick options panel to the bottom of the highlighted or selected block instead of the top.", "superb-blocks"), $this->Settings[GutenbergEnhancementsController::HIGHLIGHTS_QUICKOPTIONS_BOTTOM_KEY]); ?>
        </div>
        <div class="superbaddons-editor-settings-enhancements-wrapper">
            <h5 class="superbaddons-element-flex-center superbaddons-element-text-xs superbaddons-element-text-dark superbaddons-element-text-800 superbaddons-element-m0 superbaddons-element-mb1"><img class="superbaddons-admindashboard-content-icon superbaddons-element-mr1" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/purple-gauge.svg'); ?>" /><?= esc_html__("Enhancements", "superb-blocks"); ?></h5>
            <?php new InputCheckbox('superbaddons-enhancement-hiders-input', GutenbergEnhancementsController::HIDERS_KEY, __("\"Hide Block on Device\" Settings", "superb-blocks"), __("When this setting is enabled, all blocks will receive a \"hide block on device\" settings panel where you can decide whether or not certain blocks should be hidden on specific screens and devices.", "superb-blocks"), $this->Settings[GutenbergEnhancementsController::HIDERS_KEY]); ?>
            <?php new InputCheckbox('superbaddons-enhancement-animations-input', GutenbergEnhancementsController::ANIMATIONS_KEY, __("\"Animations\" Settings", "superb-blocks"), __("When this setting is enabled, all blocks will receive a \"animations\" settings panel where you can decide whether or not certain blocks should be animated.", "superb-blocks"), $this->Settings[GutenbergEnhancementsController::ANIMATIONS_KEY]); ?>
        </div>
<?php
    }
}
