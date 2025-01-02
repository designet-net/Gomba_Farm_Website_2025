<?php

namespace SuperbAddons\Components\Admin;

defined('ABSPATH') || exit();

class Modal
{
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
                    <span class="superbaddons-admindashboard-modal-title superbaddons-element-text-lg superbaddons-element-text-800">Modal Title</span>
                    <img class="superbaddons-admindashboard-modal-header-spinner" src="<?= SUPERBADDONS_ASSETS_PATH . "/img/blocks-spinner.svg"; ?>" />
                    <div class="superbaddons-admindashboard-modal-close-button" class="superb-addons-template-library-button superb-addons-template-library-button-secondary"><img src="<?= SUPERBADDONS_ASSETS_PATH . "/img/x.svg"; ?>" alt="<?= esc_attr__("Close", "superb-blocks"); ?>" /></div>
                </div>
                <div class="superbaddons-element-separator"></div>
                <div class="superbaddons-admindashboard-modal-content superbaddons-element-text-md">
                    Modal Content
                </div>
                <div class="superbaddons-element-separator"></div>
                <div class=" superbaddons-admindashboard-modal-footer">
                    <button type="button" class="superbaddons-element-button spbaddons-admin-btn-danger superbaddons-element-m0 superbaddons-admindashboard-modal-confirm-btn"><?= esc_html__("Confirm", "superb-blocks"); ?></button>
                    <button type="button" class="superbaddons-element-button superbaddons-element-m0 superbaddons-admindashboard-modal-cancel-btn"><?= esc_html__("Cancel", "superb-blocks"); ?></button>
                    <button type="button" class="superbaddons-element-button superbaddons-element-m0 superbaddons-admindashboard-modal-ok-btn"><?= esc_html__("OK", "superb-blocks"); ?></button>
                </div>
            </div>
        </div>


<?php
    }
}
