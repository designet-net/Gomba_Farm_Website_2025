<?php

namespace SuperbAddons\Admin\Pages;

defined('ABSPATH') || exit();

use SuperbAddons\Admin\Controllers\DashboardController;
use SuperbAddons\Admin\Controllers\SettingsController;
use SuperbAddons\Admin\Controllers\Wizard\WizardRestorationPointController;
use SuperbAddons\Components\Admin\EnhancementSettingsComponent;
use SuperbAddons\Components\Admin\InputCheckbox;
use SuperbAddons\Components\Admin\Modal;
use SuperbAddons\Components\Admin\PremiumBoxLarge;
use SuperbAddons\Data\Controllers\KeyController;

use SuperbAddons\Components\Admin\ReviewBox;
use SuperbAddons\Components\Admin\SupportLinkBoxes;
use SuperbAddons\Data\Controllers\CompatibilitySettingsOptionKey;
use SuperbAddons\Data\Controllers\SettingsOptionKey;
use SuperbAddons\Data\Utils\KeyType;

class SettingsPage
{
    private $HasRegisteredKey = false;
    private $KeyTypeLabel = false;
    private $KeyStatus = false;
    private $Settings = false;
    private $Incompatibilities = false;
    private $CompatibilitySettings = false;

    public function __construct()
    {
        $this->HasRegisteredKey = KeyController::HasRegisteredKey();
        if ($this->HasRegisteredKey) {
            $this->KeyTypeLabel = KeyController::GetCurrentKeyTypeLabel();
            $this->KeyStatus = KeyController::GetKeyStatus();
        }

        $this->Settings = SettingsController::GetSettings();

        $this->Incompatibilities = SettingsController::GetRelevantCompatibilitySettings();
        if (count($this->Incompatibilities) > 0) {
            $this->CompatibilitySettings = SettingsController::GetCompatibilitySettings();
        }

        $this->Render();
    }

    private function Render()
    {
?>
        <div class="superbaddons-admindashboard-sidebarlayout">
            <div class="superbaddons-admindashboard-sidebarlayout-left">
                <?php
                new PremiumBoxLarge();
                ?>
                <div class="superbaddons-license-key-wrapper">
                    <?php if ($this->HasRegisteredKey) : ?>
                        <div class="superbaddons-license-key-body">
                            <?php $this->MaybeDisplayKeyIssue(); ?>
                            <p class="superbaddons-element-text-sm"><?= esc_html__('Current License: ', "superb-blocks"); ?><span class="superbaddons-element-text-md"><?= esc_html($this->KeyTypeLabel); ?></span></p>
                            <button id="spbaddons-license-remove-btn" class="superbaddons-element-button spbaddons-admin-btn-danger" type="button"><!-- JS Overwrites --><?= esc_html__('Remove License Key', "superb-blocks"); ?></button>
                        </div>
                    <?php else : ?>
                        <div class="superbaddons-license-key-body superbaddons-license-key-body-flex">
                            <div class="superbaddons-license-key-input-wrapper">
                                <img class="spbaddons-license-result-icon spbaddons-license-error" src="<?= SUPERBADDONS_ASSETS_PATH ?>/img/color-warning-octagon.svg" style="display:none;" />
                                <input id="superbaddons-license-key-input" type="text" placeholder="XXXXX-XXXXX-XXXXX-XXXXX" maxlength="23" />
                            </div>
                            <button id="spbaddons-license-submit-btn" class="superbaddons-element-button" type="button" disabled><?= esc_html__('Add License Key', "superb-blocks"); ?></button>
                        </div>
                    <?php endif; ?>
                    <div class="superbaddons-spinner-wrapper" style="display:none;">
                        <img class="spbaddons-spinner" src="<?= SUPERBADDONS_ASSETS_PATH ?>/img/blocks-spinner.svg" />
                    </div>
                </div>
                <div class="superbaddons-editor-settings-wrapper">
                    <?php new EnhancementSettingsComponent(); ?>
                </div>
                <div class="superbaddons-additional-content-wrapper">
                    <h4 class="superbaddons-element-text-sm superbaddons-element-text-dark superbaddons-element-text-800 superbaddons-element-m0"><?= esc_html__("Advanced Settings", "superb-blocks"); ?></h4>
                    <p class="superbaddons-element-text-xs superbaddons-element-text-gray "><?= esc_html__("Manage your advanced settings for Superb Addons.", "superb-blocks"); ?></p>

                    <div class="superbaddons-cache-settings-wrapper">
                        <!-- Cache Settings -->
                        <h5 class="superbaddons-element-flex-center superbaddons-element-text-xs superbaddons-element-text-dark superbaddons-element-text-800 superbaddons-element-m0"><img class="superbaddons-admindashboard-content-icon superbaddons-element-mr1" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/purple-database.svg'); ?>" /><?= esc_html__("Cache", "superb-blocks"); ?></h5>
                        <p class="superbaddons-element-text-xxs superbaddons-element-text-gray superbaddons-element-mb1"><?= esc_html__("Superb Addons caches data for faster loading and processing. Clearing the cache will force data and images to be refreshed and reloaded. If you are not experiencing any problems with the plugin, the cache should not be cleared.", "superb-blocks"); ?></p>
                        <button type="button" class="superbaddons-element-button spbaddons-admin-btn-danger superbaddons-element-m0 superbaddons-element-mb1" id="superbaddons-clear-cache-btn"><img class="superbaddons-element-button-icon" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/trash-light.svg'); ?>" /><?= esc_html__("Clear Cache", "superb-blocks"); ?></button>
                    </div>

                    <div class="superbaddons-restoration-points-settings-wrapper">
                        <!-- Restoration Points Settings -->
                        <h5 class="superbaddons-element-flex-center superbaddons-element-text-xs superbaddons-element-text-dark superbaddons-element-text-800 superbaddons-element-m0"><img class="superbaddons-admindashboard-content-icon superbaddons-element-mr1" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/purple-database.svg'); ?>" /><?= esc_html__("Template Restoration Points", "superb-blocks"); ?></h5>
                        <p class="superbaddons-element-text-xxs superbaddons-element-text-gray superbaddons-element-mb1"><?= esc_html__("Superb Addons creates restoration points for your templates when you use the theme designer feature. All restoration points are automatically removed 2 months after creation. You should only manually clear the restoration points if you no longer need them and want to remove them immediately.", "superb-blocks"); ?></p>
                        <button type="button" class="superbaddons-element-button spbaddons-admin-btn-danger superbaddons-element-m0 superbaddons-element-mb1" id="superbaddons-clear-restoration-points-btn"><img class="superbaddons-element-button-icon" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/trash-light.svg'); ?>" /><?= esc_html__("Clear Restoration Points", "superb-blocks"); ?></button>
                    </div>

                    <div class="superbaddons-element-separator"></div>

                    <div class="superbaddons-error-logs-settings-wrapper">
                        <!-- Error Logs Settings -->
                        <h5 class="superbaddons-element-flex-center superbaddons-element-text-xs superbaddons-element-text-dark superbaddons-element-text-800 superbaddons-element-mb1"><img class="superbaddons-admindashboard-content-icon superbaddons-element-mr1" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/purple-bug.svg'); ?>" /><?= esc_html__("Error Logs", "superb-blocks"); ?></h5>
                        <?php new InputCheckbox('superbaddons-enable-logs-input', SettingsOptionKey::LOGS_ENABLED, __("Enable Error Logs", "superb-blocks"), __("If issues or errors occur in the plugin when this setting is enabled, the error messages will be logged and can be viewed and shared with our support team and developers.", "superb-blocks"), $this->Settings[SettingsOptionKey::LOGS_ENABLED]); ?>
                        <div class="superbaddons-maybe-hide-element" <?= $this->Settings[SettingsOptionKey::LOGS_ENABLED] ? '' : 'style="display:none;"'; ?>>
                            <?php new InputCheckbox('superbaddons-share-logs-input', SettingsOptionKey::LOG_SHARE_ENABLED, __("Share Error Logs", "superb-blocks"), __("When this setting is enabled, error logs will be shared anonymously with our support team and developers to help improve the plugin. Only the error messages shown in the error logs will be shared.", "superb-blocks"), $this->Settings[SettingsOptionKey::LOG_SHARE_ENABLED], '/img/cloud-arrow-up.svg'); ?>
                        </div>
                        <button type="button" class="superbaddons-element-button superbaddons-element-mr1" id="superbaddons-view-logs-btn"><img class="superbaddons-element-button-icon" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/list-magnifying-glass.svg'); ?>" /><?= esc_html__("View Logs", "superb-blocks"); ?></button>
                        <button type="button" class="superbaddons-element-button spbaddons-admin-btn-danger" id="superbaddons-clear-logs-btn"><img class="superbaddons-element-button-icon" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/trash-light.svg'); ?>" /><?= esc_html__("Clear Logs", "superb-blocks"); ?></button>
                    </div>
                    <div class="superbaddons-compatibility-settings-wrapper">
                        <!-- Compatibility Settings -->
                        <?php if (count($this->Incompatibilities) > 0) : ?>
                            <div class="superbaddons-element-separator"></div>
                            <h5 class="superbaddons-element-flex-center superbaddons-element-text-xs superbaddons-element-text-dark superbaddons-element-text-800 superbaddons-element-mb1"><img class="superbaddons-admindashboard-content-icon superbaddons-element-mr1" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/purple-plugs.svg'); ?>" /><?= esc_html__("Compatibility", "superb-blocks"); ?></h5>
                            <?php if (isset($this->Incompatibilities[CompatibilitySettingsOptionKey::SPECTRA_BLOCK_SPACING])) :
                                new InputCheckbox('superbaddons-spectra-compat', CompatibilitySettingsOptionKey::SPECTRA_BLOCK_SPACING, __("Fix Block Spacing", "superb-blocks"), __("The Spectra plugin features an option to apply a fixed block spacing between all blocks while in the editor. Unfortunately this option overrides custom block spacing and can result in blocks and patterns appearing strange in the editor. When this setting is enabled, custom block spacing will appear correctly in the editor.", "superb-blocks"), $this->CompatibilitySettings[CompatibilitySettingsOptionKey::SPECTRA_BLOCK_SPACING]);
                            endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="superbaddons-admindashboard-linkbox-wrapper">
                    <?php new SupportLinkBoxes(); ?>
                </div>
            </div>
            <div class="superbaddons-admindashboard-sidebarlayout-right">
                <?php new ReviewBox(); ?>
            </div>
        </div>
        <?php new Modal(); ?>
    <?php
    }

    private function MaybeDisplayKeyIssue()
    {
        if (!$this->KeyStatus['expired'] && $this->KeyStatus['active'] && $this->KeyStatus['verified'] && !$this->KeyStatus['exceeded']) {
            return;
        }
    ?>
        <div class="spbaddons-license-issue-wrapper">
            <?php printf('<img src="%s" alt="%s"/>', esc_url(SUPERBADDONS_ASSETS_PATH . '/img/color-warning-octagon.svg'), esc_attr__("Issue Detected", "superb-blocks")); ?>
            <p>
                <?php
                if ($this->KeyStatus['expired'] && $this->KeyStatus['exceeded'] && $this->KeyStatus['type'] === KeyType::STANDARD) {
                    esc_html_e('It looks like your subscription has expired and your license key is active on too many domains. Please renew your subscription, deactivate your license key on some of your domains, or contact support for assistance.', "superb-blocks");
                } elseif (
                    $this->KeyStatus['expired']
                ) {
                    esc_html_e('It looks like your subscription has expired. Please renew your subscription or contact support for assistance.', "superb-blocks");
                } elseif (
                    !$this->KeyStatus['active']
                ) {
                    esc_html_e('It looks like your license key has been disabled. Please contact support for assistance.', "superb-blocks");
                } elseif (
                    !$this->KeyStatus['verified']
                ) {
                    esc_html_e('It seems that your license key verification for this website is no longer valid. Please click the button below to head to the support section and get started with the troubleshooting process.', "superb-blocks");
                } elseif (
                    $this->KeyStatus['exceeded']
                ) {
                    esc_html_e('It looks like your license key has been activated on too many domains. Please renew your subscription, deactivate your license key on some of your domains, or contact support for assistance.', "superb-blocks");
                }
                ?>
            </p>
            <?php
            if (!$this->KeyStatus['verified']) : ?>
                <a href="<?= esc_url(admin_url('admin.php?page=' . DashboardController::SUPPORT)); ?>" class="superbaddons-element-button">
                    <?= esc_html__("Go to Troubleshooting page"); ?>
                </a>
            <?php endif; ?>
        </div>
<?php
    }
}
