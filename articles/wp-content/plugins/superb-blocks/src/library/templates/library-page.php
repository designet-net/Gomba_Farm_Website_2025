<?php
defined('ABSPATH') || exit();

use SuperbAddons\Components\Admin\EnhancementSettingsComponent;
use SuperbAddons\Components\Badges\AvailableBadge;
use SuperbAddons\Components\Badges\ExternalPluginRequiredBadge;
use SuperbAddons\Components\Badges\PremiumBadge;
use SuperbAddons\Components\Badges\UpdateRequiredBadge;
use SuperbAddons\Components\Buttons\InsertButton;
use SuperbAddons\Components\Buttons\PremiumButton;
use SuperbAddons\Components\Buttons\PreviewButton;
?>

<div class="superb-addons-template-library-wrapper-overlay"></div>
<div class="superb-addons-template-library-page-frame">
    <div class="superb-addons-template-library-page-header">
        <div class="superb-addons-template-library-page-header-logo-area">
            <div class="superb-addons-template-library-page-header-logo">
                <img src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/icon-superb.svg'); ?>" />
                <span class="superbaddons-element-text-md superbaddons-element-text-800 superbaddons-element-text-dark">Superb Addons</span>
            </div>
        </div>
        <div class="superb-addons-template-library-page-header-items-area">
            <div class="superb-addons-template-library-header-btn superb-addons-template-library-settings-btn"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256">
                    <path d="M128,80a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160Zm88-29.84q.06-2.16,0-4.32l14.92-18.64a8,8,0,0,0,1.48-7.06,107.21,107.21,0,0,0-10.88-26.25,8,8,0,0,0-6-3.93l-23.72-2.64q-1.48-1.56-3-3L186,40.54a8,8,0,0,0-3.94-6,107.71,107.71,0,0,0-26.25-10.87,8,8,0,0,0-7.06,1.49L130.16,40Q128,40,125.84,40L107.2,25.11a8,8,0,0,0-7.06-1.48A107.6,107.6,0,0,0,73.89,34.51a8,8,0,0,0-3.93,6L67.32,64.27q-1.56,1.49-3,3L40.54,70a8,8,0,0,0-6,3.94,107.71,107.71,0,0,0-10.87,26.25,8,8,0,0,0,1.49,7.06L40,125.84Q40,128,40,130.16L25.11,148.8a8,8,0,0,0-1.48,7.06,107.21,107.21,0,0,0,10.88,26.25,8,8,0,0,0,6,3.93l23.72,2.64q1.49,1.56,3,3L70,215.46a8,8,0,0,0,3.94,6,107.71,107.71,0,0,0,26.25,10.87,8,8,0,0,0,7.06-1.49L125.84,216q2.16.06,4.32,0l18.64,14.92a8,8,0,0,0,7.06,1.48,107.21,107.21,0,0,0,26.25-10.88,8,8,0,0,0,3.93-6l2.64-23.72q1.56-1.48,3-3L215.46,186a8,8,0,0,0,6-3.94,107.71,107.71,0,0,0,10.87-26.25,8,8,0,0,0-1.49-7.06Zm-16.1-6.5a73.93,73.93,0,0,1,0,8.68,8,8,0,0,0,1.74,5.48l14.19,17.73a91.57,91.57,0,0,1-6.23,15L187,173.11a8,8,0,0,0-5.1,2.64,74.11,74.11,0,0,1-6.14,6.14,8,8,0,0,0-2.64,5.1l-2.51,22.58a91.32,91.32,0,0,1-15,6.23l-17.74-14.19a8,8,0,0,0-5-1.75h-.48a73.93,73.93,0,0,1-8.68,0,8,8,0,0,0-5.48,1.74L100.45,215.8a91.57,91.57,0,0,1-15-6.23L82.89,187a8,8,0,0,0-2.64-5.1,74.11,74.11,0,0,1-6.14-6.14,8,8,0,0,0-5.1-2.64L46.43,170.6a91.32,91.32,0,0,1-6.23-15l14.19-17.74a8,8,0,0,0,1.74-5.48,73.93,73.93,0,0,1,0-8.68,8,8,0,0,0-1.74-5.48L40.2,100.45a91.57,91.57,0,0,1,6.23-15L69,82.89a8,8,0,0,0,5.1-2.64,74.11,74.11,0,0,1,6.14-6.14A8,8,0,0,0,82.89,69L85.4,46.43a91.32,91.32,0,0,1,15-6.23l17.74,14.19a8,8,0,0,0,5.48,1.74,73.93,73.93,0,0,1,8.68,0,8,8,0,0,0,5.48-1.74L155.55,40.2a91.57,91.57,0,0,1,15,6.23L173.11,69a8,8,0,0,0,2.64,5.1,74.11,74.11,0,0,1,6.14,6.14,8,8,0,0,0,5.1,2.64l22.58,2.51a91.32,91.32,0,0,1,6.23,15l-14.19,17.74A8,8,0,0,0,199.87,123.66Z"></path>
                </svg></div>
            <div class="superb-addons-template-library-header-btn superb-addons-template-library-close-btn"><img src="<?= SUPERBADDONS_ASSETS_PATH . "/img/x.svg"; ?>" alt="<?= esc_attr__("Close", "superb-blocks"); ?>" /></div>
        </div>
    </div>
    <div class="superb-addons-template-library-page-content">
        <div class="superb-addons-template-library-page-content-inner" style="display:none;">
            <div id="superb-addons-template-library-header-menu">
            </div>
            <div class="superb-addons-template-library-page-content-inner-menu">
                <div class="superb-addons-template-library-page-content-inner-menu-left">
                    <div id="superb-addons-template-library-page-search-wrapper">
                        <label for="superb-addons-template-library-page-search-input"><img src="<?= SUPERBADDONS_ASSETS_PATH . "/img/magnifying-glass.svg"; ?>" /></label>
                        <input id="superb-addons-template-library-page-search-input" type="text" placeholder="<?= esc_attr__('Search', "superb-blocks"); ?>" />
                    </div>
                </div>
                <div class="superb-addons-template-library-page-content-inner-menu-right">
                    <div class="superb-addons-template-library-page-select-wrapper superb-addons-template-library-page-category-select-wrapper">
                        <select id="superb-addons-template-library-page-category-select">
                        </select>
                    </div>
                    <div class="superb-addons-template-library-page-select-wrapper superb-addons-template-library-page-style-select-wrapper">
                        <select id="superb-addons-template-library-page-style-select">
                        </select>
                    </div>
                </div>
            </div>
            <div class="superb-addons-template-library-page-content-list">
                <div class="superb-addons-template-library-page-content-inner-list">
                    <!-- JS -->
                </div>
                <div class="superb-addons-template-library-page-content-inner-list-footer">
                    <img src="<?= SUPERBADDONS_ASSETS_PATH . "/img/icon-superb.svg"; ?>" />
                    <div class="superb-addons-template-library-footer-excerpt">
                        <?= sprintf(esc_html__('Stay tuned! More awesome %s coming real soon ✌️', "superb-blocks"), '<span></span>'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="superb-addons-template-library-page-content-settings" style="display:none;">
            <div class="superbaddons-library-page-settings-content-wrapper">
                <?php new EnhancementSettingsComponent(); ?>
            </div>
        </div>
        <div class="superb-addons-loading">
            <div class="superb-addons-loader-wrapper">
                <div class="superbaddons-spinner-wrapper">
                    <img class="spbaddons-spinner" src="<?= SUPERBADDONS_ASSETS_PATH ?>/img/blocks-spinner.svg" />
                </div>
                <div class="superbaddons-loading-title superbaddons-element-text-dark superbaddons-element-text-800 superbaddons-element-text-md"><?= esc_html__("Loading", "superb-blocks"); ?></div>
            </div>
        </div>
    </div>
    <div class="superb-addons-template-library-preview-wrapper" style="display:none;">
        <div class="superb-addons-template-library-preview-overlay"></div>
        <div class="superb-addons-template-library-preview-modal">
            <div class="superb-addons-template-library-preview-header">
                <span class="superb-addons-template-library-preview-title superbaddons-element-text-lg superbaddons-element-text-dark superbaddons-element-text-800"></span>
                <?php new PremiumBadge(); ?>
                <div id="superb-addons-template-library-preview-close-button" class="superb-addons-template-library-button superb-addons-template-library-button-secondary"><img src="<?= SUPERBADDONS_ASSETS_PATH . "/img/x.svg"; ?>" alt="<?= esc_attr__("Close", "superb-blocks"); ?>" /></div>
            </div>
            <div class="superb-addons-template-library-preview-modal-content">
                <div class="superb-addons-template-library-preview-top">
                    <div class="superb-addons-template-library-preview-left">
                        <p><?= esc_html__('This preview is an image.', "superb-blocks"); ?> <span clsas="superb-addons-template-library-preview-left-livepreview-explain" style="display:none;"><?= esc_html__('To see the element live, click the "Live Preview" button.', "superb-blocks"); ?></span></p>
                        <span class="superbaddons-element-text-xxs superbaddons-element-text-gray"><?= esc_html__("Please note that colors and other aspects may vary slightly depending on your current theme.") ?></span>
                    </div>
                    <div class="superb-addons-template-library-preview-right">
                        <?php
                        new PreviewButton(__("Live Preview", "superb-blocks"), '_blank');
                        new AvailableBadge();
                        new UpdateRequiredBadge();
                        new ExternalPluginRequiredBadge();
                        new PremiumButton();
                        new InsertButton();
                        ?>
                    </div>
                </div>
            </div>
            <div class="superb-addons-template-library-preview-image-wrapper">
                <img id="superb-addons-template-library-preview" />
                <div class="superbaddons-spinner-wrapper" style="display:none;">
                    <img class="spbaddons-spinner" src="<?= SUPERBADDONS_ASSETS_PATH ?>/img/blocks-spinner.svg" />
                </div>
            </div>
        </div>
    </div>
</div>