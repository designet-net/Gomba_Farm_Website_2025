<?php

namespace SuperbAddons\Components\Admin;

defined('ABSPATH') || exit();

class ReviewBox
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
            <img class="superbaddons-admindashboard-content-image" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/asset-small-review.jpg'); ?>" />
            <div class="superbaddons-admindashboard-content-box-inner superbaddons-element-text-center">
                <span class="superbaddons-element-text-md superbaddons-element-text-800 superbaddons-element-text-dark"><?= esc_html__("Spread the Love with a Plugin Review", "superb-blocks") ?> </span>
                <p class="superbaddons-element-text-xxs superbaddons-element-text-gray">
                    <?= esc_html__("If we've managed to bring a smile to your face, we would greatly appreciate it if you could take a moment to write a review.", "superb-blocks"); ?>
                </p>
                <a class="superbaddons-element-button" target="_blank" href="https://wordpress.org/support/plugin/superb-blocks/reviews/"><?= esc_html__("Leave a review", "superb-blocks"); ?></a>
            </div>
        </div>
<?php
    }
}
