<?php

namespace SuperbAddons\Admin\Pages\Wizard;

use SuperbAddons\Admin\Controllers\Wizard\WizardController;
use SuperbAddons\Components\Admin\InputCheckbox;
use SuperbAddons\Components\Admin\Modal;
use SuperbAddons\Components\Admin\OutdatedBrowserWarning;
use SuperbAddons\Components\Slots\PremiumOptionWrapper;
use SuperbAddons\Data\Controllers\KeyController;
use SuperbAddons\Data\Utils\Wizard\WizardActionParameter;
use SuperbAddons\Data\Utils\Wizard\WizardNavigationMenuOptions;
use SuperbAddons\Data\Utils\Wizard\WizardStageTypes;
use SuperbAddons\Data\Utils\Wizard\WizardStageUtil;

defined('ABSPATH') || exit();

class PageWizardStagesPage
{
    private $stageUtil;

    private $cancel_url;
    private $complete_url;

    private $userIsPremium;

    public function __construct()
    {
        $this->stageUtil = new WizardStageUtil();
        $this->stageUtil->InitializeTemplates();

        $this->cancel_url = WizardController::GetWizardURL(WizardActionParameter::CANCEL);
        $this->complete_url = WizardController::GetWizardCompleteURL($this->stageUtil->GetType());

        $this->userIsPremium = KeyController::HasValidPremiumKey();

        $this->Render();
    }

    private function Render()
    {
        $stages = $this->stageUtil->GetAvailableConfiguredStages();

        foreach ($stages as $stage_type => $stage_config) {
            $this->RenderStage(
                $stage_type,
                $stage_config,
                $stage_config['args'] ?? []
            );
        }
?>
        <div class="superbaddons-theme-template-menu" data-wizard="<?= esc_attr($this->stageUtil->GetType()); ?>">
            <div class="superbaddons-theme-template-menu-inner">
                <div class="superbaddons-template-menu-buttons superbaddons-template-menu-buttons-left">
                    <a href="<?= esc_url($this->cancel_url); ?>" id="superbaddons-template-cancel-button" class="superbthemes-module-cta"><?= esc_html__("Cancel", "superb-blocks"); ?></a>
                </div>
                <div class="superbaddons-theme-template-steps">
                </div>
                <div class="superbaddons-template-menu-buttons superbaddons-template-menu-buttons-right">
                    <button id="superbaddons-template-next-button" data-complete-url="<?= esc_url($this->complete_url); ?>" class="superbthemes-module-cta superbthemes-module-cta-green"><?= esc_html__("Continue", "superb-blocks"); ?></button>
                </div>
            </div>
        </div>
        <script type="text/template" id="superbaddons-theme-template-step">
            <div class="superbaddons-theme-template-step"><div class="superbaddons-theme-template-step-inner"></div></div>
        </script>
        <script type="text/template" id="superbaddons-stage-overview-item">
            <div class="superbaddons-stage-overview-item superbaddons-stage-selection-item">
                <h2 class="superbaddons-element-m0"></h2>
                <div class="superbaddons-stage-selection-list superbaddons-element-m0"></div>
            </div>
        </script>
    <?php
        new OutdatedBrowserWarning();
        new Modal();
    }

    private function RenderStage($stage_id, $properties, $args)
    {
        $index = 0;
        $total = count($properties['templates']);
        $firstSelectionIndex = 0;
        if ($total > 1 && $properties['templates'][0]->datatype === "ignore") {
            $firstSelectionIndex = 1;
        }
    ?>
        <div class="superbaddons-template-stage" data-stageid="<?= esc_attr($stage_id); ?>" data-type="<?= esc_attr($properties['type']); ?>" data-required="<?= boolval($properties['required']); ?>" data-hastitleinput="<?= esc_attr($properties['has-title-input'] ?? ""); ?>" style="display:none;">
            <div class="superbaddons-wizard-wrapper-small" data-stage-label="<?= esc_attr($this->stageUtil->GetStageLabel($stage_id)); ?>" data-title-input-suggestion="<?= esc_attr($properties['input-suggestion'] ?? ''); ?>">
                <div class="superbaddons-wizard-heading">
                    <img src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/' . $properties['icon']); ?>" width="60" height="60" aria-hidden="true">
                    <h1><span class="superbaddons-wizard-heading-number"></span> <?= esc_html($this->stageUtil->GetStageTitle($stage_id)); ?></h1>
                </div>
                <p class="superbaddons-element-text-sm superbaddons-wizard-tagline"><?= esc_html($this->stageUtil->GetStageDescription($stage_id)); ?></p>

                <?php if (isset($properties['unique_render']) && $properties['unique_render']):
                    if ($stage_id === WizardStageTypes::NAVIGATION_MENU_STAGE):
                        $this->RenderNavigationUpdateStage(...$args);
                    elseif ($stage_id === WizardStageTypes::COMPLETION_STAGE) :
                        $this->RenderCompletionStage();
                    endif;
                endif; ?>
            </div>

            <?php if (!isset($properties['unique_render']) || !$properties['unique_render']) : ?>
                <div class="superbaddons-theme-template-container superbaddons-wizard-list-grid">
                    <?php
                    foreach ($properties['templates'] as $template) :
                        $is_locked = $properties['lockable'] && $total === 1;
                        $is_selected = $properties['type'] === 'single-selection' && $firstSelectionIndex === $index++;
                        $this->RenderTemplate($template, $is_locked, $is_selected);
                    endforeach;
                    ?>
                </div>
            <?php endif; ?>
        </div>
    <?php
    }

    private function RenderTemplate($template, $is_locked = false, $is_selected = false, $rendering_with_premium_wrapper = false)
    {
        $premium = isset($template->is_premium) && $template->is_premium;
        $premium_available = $premium && $this->userIsPremium;
        $update_required = isset($template->plugin_update_required) && $template->plugin_update_required;
        $external_plugin_required = isset($template->external_plugin_required) && $template->external_plugin_required;
        $external_plugin_required_text = __("Additional Plugin Required", "superb-blocks");
        $external_plugin_tooltip_text = $external_plugin_required_text;
        if ($external_plugin_required) {
            if (isset($template->required_plugin_names) && !empty($template->required_plugin_names)) {
                $external_plugin_required_text = $template->required_plugin_names[0] . (count($template->required_plugin_names) > 1 ? " (+" . (count($template->required_plugin_names) - 1) . ")" : '') . " " . __(" Required", "superb-blocks");
                if (count($template->required_plugin_names) > 1) {
                    $external_plugin_tooltip_text = implode(", ", $template->required_plugin_names);
                }
            }
        }

        if (!$rendering_with_premium_wrapper && $premium && !$premium_available) {
            new PremiumOptionWrapper(function () use ($template, $is_locked, $is_selected) {
                $this->RenderTemplate($template, $is_locked, $is_selected, true);
            }, array(), true);
            return;
        }
    ?>
        <div class="superbaddons-theme-page-template superbaddons-element-text-dark <?= $update_required ? "superbaddons-theme-page-template-update-required" : ""; ?> <?= $external_plugin_required ? "superbaddons-theme-page-template-external-plugin-required" : ""; ?> <?= $premium_available ? "superbaddons-premium-element-option" : ($premium ? "superbaddons-theme-page-template-unavailable-premium" : ""); ?> <?= $template->IsPattern() ? "superbaddons-theme-page-template-part" : ""; ?> <?= $is_locked ? 'superbaddons-theme-page-template-locked' : ''; ?> <?= $is_selected ? 'superbaddons-theme-page-template-selected' : ''; ?>" data-slug="<?= esc_attr($template->GetSlug()); ?>" data-title="<?= esc_attr($template->title); ?>" data-type="<?= esc_attr($template->datatype); ?>" data-package="<?= $premium ? 'premium' : 'free'; ?>">
            <div class="superbaddons-template-content-wrapper">
                <?php if ($template->id) : ?>
                    <div class="superbaddons-template-preview-container">
                        <iframe data-id="<?= esc_attr($template->id . "//" . $template->GetSlug()); ?>" aria-hidden="true" class="superbaddons-template-preview-content" data-status="loading" data-noreload="<?= $template->no_reload ? "noreload" : ""; ?>" loading="lazy" src="" data-src="<?= esc_url($template->GetPreviewURL()); ?>" style="display:none;"></iframe>
                    </div>
                    <div class=" superbaddons-preview-spinner-container">
                        <img class="superbaddons-preview-spinner" src="<?= SUPERBADDONS_ASSETS_PATH ?>/img/blocks-spinner.svg" width="30px" height="auto" style="user-select:none;margin:auto;" />
                    </div>
                <?php endif; ?>
            </div>
            <div class="superbaddons-template-information">
                <div class="superbaddons-template-information-inner superbaddons-element-flex-center">
                    <div class="superbaddons-template-information-title superbaddons-element-text-sm">
                        <?= esc_html($template->title); ?>
                        <img class="superbaddons-template-locked" src="<?= SUPERBADDONS_ASSETS_PATH ?>/img/lock.svg" width="24px" height="auto" />
                    </div>
                    <div class="superbaddons-template-information-package superbaddons-element-text-xs superbaddons-element-text-gray">
                        <?php if ($update_required): ?>
                            <span class="superbaddons-template-update-required"><?= esc_html__("Plugin Update Required", "superb-blocks"); ?></span>
                        <?php elseif ($external_plugin_required): ?>
                            <span class="superbaddons-template-external-plugin-required" title="<?= esc_attr($external_plugin_tooltip_text); ?>"><?= esc_html($external_plugin_required_text); ?></span>
                        <?php else: ?>
                            <?= $premium ? ($premium_available ? esc_html__("Premium", "superb-blocks") : esc_html__("Unlock With Premium", "superb-blocks")) : esc_html__("Free", "superb-blocks"); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }

    /* Unique renders */
    private function RenderNavigationUpdateStage($displayReplaceMenu, $displayAppendMenu)
    {
    ?>
        <div class="superbaddons-checkbox-large-wrapper <?= $displayReplaceMenu && $displayAppendMenu ? 'superbaddons-checkbox-large-wrapper-three' : ''; ?>">
            <?php if ($displayReplaceMenu) : ?>
                <div class="superbaddons-checkbox-large-item">
                    <?php new InputCheckbox(WizardNavigationMenuOptions::CREATE_NEW_MENU, __('Replace Menu Items', 'superb-blocks'), __('Replace Menu Items', 'superb-blocks'), __('Updates the navigation block with menu items for the front page, blog page and the selected pages.', 'superb-blocks'), true); ?>
                </div>
            <?php endif; ?>
            <?php if ($displayAppendMenu): ?>
                <div class="superbaddons-checkbox-large-item">
                    <?php new InputCheckbox(WizardNavigationMenuOptions::APPEND_EXISTING_MENU, __('Append Menu Items', 'superb-blocks'), __('Append Menu Items', 'superb-blocks'), __('The navigation block menu items will be updated to include all your selected pages. Any menu items already present in the navigation block will remain in addition to the newly created menu items.', 'superb-blocks'), $this->stageUtil->GetType() === WizardActionParameter::ADD_NEW_PAGES); ?>
                </div>
            <?php endif; ?>
            <div class="superbaddons-checkbox-large-item">
                <?php new InputCheckbox(WizardNavigationMenuOptions::SKIP_MENU, __('Don\'t Update Menu Items', 'superb-blocks'), __('Don\'t Update Menu Items', 'superb-blocks'), __('If you do not want the navigation menu items to be changed, select this option.', 'superb-blocks')); ?>
            </div>
        </div>
    <?php
    }

    private function RenderCompletionStage()
    {
    ?>
        <div class="superbaddons-stage-selection-overview superbaddons-element-mb2 superbaddons-theme-template-container superbaddons-wizard-list-grid">
        </div>
<?php
    }
    /* */
}
