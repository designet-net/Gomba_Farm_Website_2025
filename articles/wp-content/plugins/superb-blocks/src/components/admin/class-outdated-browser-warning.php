<?php

namespace SuperbAddons\Components\Admin;

use SuperbAddons\Admin\Controllers\DashboardController;

defined('ABSPATH') || exit();

class OutdatedBrowserWarning
{
    private $exit_url;

    public function __construct()
    {
        $this->exit_url = add_query_arg(
            array(
                'page' => DashboardController::DASHBOARD,
            ),
            admin_url('admin.php')
        );
        $this->Render();
    }

    private function Render()
    {
?>
        <div id="superbaddons-browser-outdated-warning" class="superbaddons-admindashboard-content-box-large" style="display:none;">
            <div class="superbaddons-admindashboard-content-box-inner">
                <div class="superbaddons-element-inlineflex-center superbaddons-element-flex-gap1">
                    <img class="superbaddons-admindashboard-content-icon superbaddons-element-m0" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/color-warning-octagon.svg'); ?>" />
                    <h4 class="superbaddons-element-text-md superbaddons-element-text-800 superbaddons-element-text-dark superbaddons-element-m0"><?= esc_html__("Your browser is out of date!", "superb-blocks"); ?> </h4>
                </div>

                <p class="superbaddons-element-text-sm superbaddons-element-text-gray superbaddons-element-mb1"><?= esc_html__("It looks like you're using an outdated browser that does not support some of the modern web technologies required for the theme designer to function properly.", "superb-blocks"); ?></p>
                <p class="superbaddons-element-text-sm superbaddons-element-text-gray superbaddons-element-mb1"><?= esc_html__("Please update your browser to the latest version or switch to a different browser to use the theme designer.", "superb-blocks"); ?></p>

                <a href="<?= esc_url($this->exit_url); ?>" id="superbaddons-template-cancel-button" class="superbaddons-element-button superbaddons-element-m0"><?= esc_html__("Exit", "superb-blocks"); ?></a>
            </div>
        </div>
<?php
    }
}
