<?php

namespace SuperbAddons\Components\Admin;

defined('ABSPATH') || exit();

class SupportBox
{
    public function __construct()
    {
        $this->Render();
    }

    private function Render()
    {
?>
        <!-- Review Box -->
        <div class="superbaddons-admindashboard-content-box">
            <img class="superbaddons-admindashboard-content-image" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/asset-small-support.jpg'); ?>" />
            <div class="superbaddons-admindashboard-content-box-inner superbaddons-element-text-center">
                <span class="superbaddons-element-text-md superbaddons-element-text-800 superbaddons-element-text-dark"><?= esc_html__("Contact support", "superb-blocks") ?> </span>
                <p class="superbaddons-element-text-xxs superbaddons-element-text-gray">
                    <?= esc_html__("Experiencing difficulties with Superb Addons? Our team is here to assist you. If you have any questions or issues, please don't hesitate to reach out to us through our website. ", "superb-blocks"); ?>
                </p>
                <a class="superbaddons-element-button" target="_blank" href="https://superbthemes.com/customer-support"><?= esc_html__("Contact support", "superb-blocks"); ?></a>
            </div>
        </div>
<?php
    }
}
