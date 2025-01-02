<?php

namespace SuperbAddons\Components\Admin;

defined('ABSPATH') || exit();

class FeedbackModal
{
    const FEEDBACK_REASONS = [
        "I no longer need this plugin",
        "I found a better plugin",
        "I'm temporarily deactivating this plugin",
        "I couldn't get the plugin to work",
    ];

    private $Reasons;

    public function __construct()
    {
        $this->Render();
    }

    private function Render()
    {
?>
        <div class="superbaddons-admindashboard-modal-wrapper" style="display:none;">
            <div class="superbaddons-admindashboard-modal-overlay"></div>
            <div class="superbaddons-admindashboard-modal">
                <div class="superbaddons-admindashboard-modal-header">
                    <span class="superbaddons-admindashboard-modal-title superbaddons-element-text-lg superbaddons-element-text-800 superbaddons-element-flex-center superbaddons-element-flexwrap"><img class="superbaddons-element-mr1" src="<?= SUPERBADDONS_ASSETS_PATH . "/img/icon-superb.svg"; ?>" /><?= esc_html__("Feedback", "superb-blocks"); ?><span class="superbaddons-element-text-xs superbaddons-element-ml1"><?= esc_html__("We are sorry to see you go", "superb-blocks"); ?></span></span>
                    <div class="superbaddons-admindashboard-modal-close-button" class="superb-addons-template-library-button superb-addons-template-library-button-secondary"><img src="<?= SUPERBADDONS_ASSETS_PATH . "/img/x.svg"; ?>" alt="<?= esc_attr__("Close", "superb-blocks"); ?>" /></div>
                </div>
                <div class="superbaddons-element-separator"></div>
                <div class="superbaddons-admindashboard-modal-content superbaddons-element-text-xs">
                    <div class="superbaddons-feedback-input">
                        <span class="superbaddons-element-text-800"><?= esc_html__("If you have a moment, please help us improve and let us know why you're deactivating Superb Addons:", "superb-blocks"); ?></span>
                        <div class="superbaddons-feedback-input-radio">
                            <input type="radio" id="superbaddons-feedback-reason-1" name="superbaddons-feedback-reason" value="<?= esc_attr__("I no longer need this plugin", "superb-blocks"); ?>" />
                            <label for="superbaddons-feedback-reason-1"><?= esc_html__("I no longer need this plugin", "superb-blocks"); ?></label>
                        </div>
                        <div class="superbaddons-feedback-input-radio">
                            <input type="radio" id="superbaddons-feedback-reason-2" name="superbaddons-feedback-reason" value="<?= esc_attr__("I found a better plugin", "superb-blocks"); ?>" />
                            <label for="superbaddons-feedback-reason-2"><?= esc_html__("I found a better plugin", "superb-blocks"); ?></label>
                        </div>
                        <div class="superbaddons-feedback-input-radio">
                            <input type="radio" id="superbaddons-feedback-reason-3" name="superbaddons-feedback-reason" value="<?= esc_attr__("I couldn't get the plugin to work", "superb-blocks"); ?>" />
                            <label for="superbaddons-feedback-reason-3"><?= esc_html__("I couldn't get the plugin to work", "superb-blocks"); ?></label>
                        </div>
                        <div class="superbaddons-feedback-input-radio">
                            <input type="radio" id="superbaddons-feedback-reason-4" name="superbaddons-feedback-reason" value="<?= esc_attr__("I'm temporarily deactivating this plugin", "superb-blocks"); ?>" data-temp="true" />
                            <label for="superbaddons-feedback-reason-4"><?= esc_html__("I'm temporarily deactivating this plugin", "superb-blocks"); ?></label>
                        </div>
                        <div class="superbaddons-feedback-input-radio">
                            <input type="radio" id="superbaddons-feedback-reason-other" name="superbaddons-feedback-reason" value="other" />
                            <label for="superbaddons-feedback-reason-other"><?= esc_html__("Other", "superb-blocks"); ?></label>
                            <input id="superbaddons-feedback-text" class="superbaddons-element-w100 superbaddons-element-mt1" type="text" name="superbaddons-feedback-reason-other" placeholder="<?= esc_attr__("Please let us know your feedback", "superb-blocks"); ?>" style="display:none;">
                        </div>
                    </div>
                </div>
                <div class="superbaddons-element-separator"></div>
                <div class="superbaddons-admindashboard-modal-footer">
                    <div class="superbaddons-spinner-wrapper" style="display:none;">
                        <img class="spbaddons-spinner" src="<?= SUPERBADDONS_ASSETS_PATH ?>/img/blocks-spinner.svg" />
                    </div>
                    <button type="button" class="superbaddons-element-button spbaddons-admin-btn-success superbaddons-element-m0 superbaddons-admindashboard-modal-confirm-btn"><?= esc_html__("Submit & Deactivate", "superb-blocks"); ?></button>
                    <button type="button" class="superbaddons-element-button superbaddons-element-m0 superbaddons-admindashboard-modal-cancel-btn"><?= esc_html__("Deactivate", "superb-blocks"); ?></button>
                </div>
            </div>
    <?php
    }
}
