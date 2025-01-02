<?php

namespace SuperbAddons\Components\Admin;

use SuperbAddons\Admin\Controllers\DashboardController;
use SuperbAddons\Data\Controllers\KeyController;

defined('ABSPATH') || exit();

class Navigation
{
    private $pages;
    private $active_page;
    private $issue_detected = false;
    private $has_premium = false;
    private $hide_navigation_items = false;
    private $subtitle = false;

    public function __construct($hide_navigation_items = false, $subtitle = false)
    {
        $HasRegisteredKey = KeyController::HasRegisteredKey();
        if ($HasRegisteredKey) {
            $this->has_premium = KeyController::HasValidPremiumKey();
            $KeyStatus = KeyController::GetKeyStatus();
            if (!$KeyStatus['active'] || $KeyStatus['expired'] || !$KeyStatus['verified'] || $KeyStatus['exceeded']) {
                $this->issue_detected = true;
            }
        }

        $this->subtitle = $subtitle;

        if ($hide_navigation_items) {
            $this->hide_navigation_items = true;
            $this->pages = array();
            $this->Render();
            return;
        }

        $this->active_page = isset($_GET['page']) ? $_GET['page'] : DashboardController::DASHBOARD;
        $pages = array_merge(array(DashboardController::MENU_SLUG => __("Dashboard", "superb-blocks")), apply_filters('superbaddons/admin/navigation/pages', array()));
        $this->pages = array_merge($pages, array(
            DashboardController::PAGE_WIZARD => __("Theme Designer", "superb-blocks"),
            DashboardController::ADDITIONAL_CSS => __("Custom CSS", "superb-blocks"),
            DashboardController::SETTINGS => __("Settings", "superb-blocks"),
            DashboardController::SUPPORT => __("Support", "superb-blocks"),
        ));
        $this->Render();
    }

    private function Render()
    {
?>
        <div class="superbaddons-admindashboard-navigation <?= $this->hide_navigation_items ? 'superbaddons-admindashboard-navigation-items-hidden' : ''; ?>">
            <div class="superbaddons-admindashboard-navigation-toplevel">
                <a href="<?= esc_url(admin_url('admin.php?page=' . DashboardController::MENU_SLUG)); ?>" class="superbaddons-admindashboard-navigation-logo-wrapper">
                    <img src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/icon-superb.svg'); ?>" />
                    <span class="superbaddons-element-text-md superbaddons-element-text-800 superbaddons-element-text-dark">Superb Addons</span>
                </a>
                <?php if ($this->subtitle) : ?>
                    <span class="superbthemes-module-purple-badge"><?= $this->subtitle; ?></span>
                <?php endif; ?>
                <div class="superbaddons-admindashboard-navigation-shortcuts">
                    <?php if (!$this->has_premium) : ?>
                        <a class="superbaddons-admindashboard-navigation-shortcuts-item" target="_blank" href="https://superbthemes.com/superb-addons/" title="<?= esc_attr__("Get Premium", "superb-blocks"); ?>"><img src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/color-crown.svg'); ?>" alt="<?= esc_attr__("Get Premium", "superb-blocks"); ?>" /></a>
                    <?php endif; ?>
                    <a class="superbaddons-admindashboard-navigation-shortcuts-item" target="_blank" href="https://superbthemes.com/customer-support/" title="<?= esc_attr__("Contact Support", "superb-blocks"); ?>"><img src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/help.svg'); ?>" alt="<?= esc_attr__("Contact Support", "superb-blocks"); ?>" /></a>
                    <a class="superbaddons-admindashboard-navigation-shortcuts-item" target="_blank" href="https://superbthemes.com/documentation/" title="<?= esc_attr__("View Documentation", "superb-blocks"); ?>"><img src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/file.svg'); ?>" alt="<?= esc_attr__("View Documentation", "superb-blocks"); ?>" /></a>
                    <span class="superbaddons-admindashboard-navigation-shortcuts-item">
                        <?= esc_html(SUPERBADDONS_VERSION); ?>
                        <?php if ($this->has_premium) : ?>
                            <img class="superbaddons-element-ml1" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/purple-crown.svg'); ?>" alt="<?= esc_attr__("Premium License", "superb-blocks"); ?>" />
                        <?php endif; ?>
                    </span>
                </div>
            </div>
            <?php if (!$this->hide_navigation_items) : ?>
                <div class="superbaddons-admindashboard-navigation-bottomlevel">
                    <?php foreach ($this->pages as $pagekey => $pagetitle) : ?>
                        <a href="<?= esc_url(admin_url('admin.php?page=' . $pagekey)); ?>" class="superbaddons-admindashboard-navigation-bottomlevel-item <?= $pagekey == $this->active_page ? 'superbaddons-admindashboard-active' : ''; ?>">
                            <?= esc_html($pagetitle); ?>
                            <?php if ($pagekey == DashboardController::SETTINGS && $this->issue_detected) : ?>
                                <img class="superbaddons-admindashboard-navigation-bottomlevel-item-issue-img" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/color-warning-octagon.svg'); ?>" alt="<?= esc_attr__("Issue Detected", "superb-blocks"); ?>" />
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
<?php
    }
}
