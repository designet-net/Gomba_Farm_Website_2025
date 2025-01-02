<?php

namespace SuperbAddons\Admin\Controllers;

defined('ABSPATH') || exit();

use SuperbAddons\Admin\Controllers\Wizard\WizardController;
use SuperbAddons\Admin\Pages\AdditionalCSSPage;
use SuperbAddons\Admin\Pages\DashboardPage;
use SuperbAddons\Admin\Pages\SettingsPage;
use SuperbAddons\Admin\Pages\SupportPage;
use SuperbAddons\Admin\Pages\Wizard\PageWizardMainPage;
use SuperbAddons\Components\Admin\FeedbackModal;
use SuperbAddons\Config\Capabilities;
use SuperbAddons\Data\Controllers\RestController;

use SuperbAddons\Components\Admin\Navigation;
use SuperbAddons\Data\Controllers\CSSController;
use SuperbAddons\Data\Controllers\KeyController;
use SuperbAddons\Data\Utils\ScriptTranslations;
use SuperbAddons\Data\Utils\Wizard\WizardActionParameter;
use SuperbAddons\Elementor\Controllers\ElementorController;
use SuperbAddons\Gutenberg\Controllers\GutenbergController;

class DashboardController
{
    const MENU_SLUG = 'superbaddons';
    const DASHBOARD = 'dashboard';
    const ADDITIONAL_CSS = 'superbaddons-additional-css';
    const SETTINGS = 'superbaddons-settings';
    const SUPPORT = 'superbaddons-support';

    const PAGE_WIZARD = 'superbaddons-page-wizard';

    const PREMIUM_CLASS = 'superbaddons-get-premium';

    private $hooks;

    public function __construct()
    {
        new SettingsController();
        new TroubleshootingController();
        NewsletterSignupController::Initialize();
        $this->hooks = array();
        add_action("admin_menu", array($this, 'SuperbAddonsAdminMenu'));
        add_action("admin_menu", array($this, 'AdminMenuAdditions'));
        add_filter('plugin_action_links_' . SUPERBADDONS_BASE, array($this, 'PluginActions'));
        add_action('admin_enqueue_scripts', array($this, 'AdminMenuEnqueues'), 1000);
        if (!KeyController::HasValidPremiumKey()) {
            add_action("admin_head", array($this, 'AdminMenuHighlightScripts'));
        }
        $this->HandleNotices();
    }


    public function PluginActions($actions)
    {
        $added_actions = array(
            "<a href='" . esc_url(admin_url("admin.php?page=" . self::MENU_SLUG)) . "'>" . esc_html__('Dashboard', "superb-blocks") . "</a>",
            "<a href='" . esc_url(admin_url("admin.php?page=" . self::SETTINGS)) . "'>" . esc_html__('Settings', "superb-blocks") . "</a>",
            "<a href='" . esc_url(admin_url("admin.php?page=" . self::SUPPORT)) . "'>" . esc_html__('Support', "superb-blocks") . "</a>"
        );
        $actions = array_merge($added_actions, $actions);
        if (!KeyController::HasValidPremiumKey()) {
            $actions[] = "<a href='" . esc_url("https://superbthemes.com/superb-addons/") . "' class='" . self::PREMIUM_CLASS . "' target='_blank'>" . esc_html__('Get Premium', "superb-blocks") . "</a>";
        }
        return $actions;
    }

    public function SuperbAddonsAdminMenu()
    {
        add_menu_page(__('Superb Addons', "superb-blocks"), __('Superb Addons', "superb-blocks") . $this->GetAdminMenuNotification(), Capabilities::CONTRIBUTOR, self::MENU_SLUG, array($this, 'SuperbDashboard'), SUPERBADDONS_ASSETS_PATH . '/img/icon-superb-dashboard-menu.png', '58.6');
        $this->hooks[self::DASHBOARD] = add_submenu_page(self::MENU_SLUG, __('Superb Addons - Dashboard', "superb-blocks"), __('Dashboard', "superb-blocks"), Capabilities::CONTRIBUTOR, self::MENU_SLUG);
        $this->hooks[self::PAGE_WIZARD] = add_submenu_page(self::MENU_SLUG, __('Superb Addons - Theme Designer', "superb-blocks"), __('Theme Designer', "superb-blocks"), Capabilities::ADMIN, self::PAGE_WIZARD, array($this, 'PageWizard'));
        $this->hooks[self::ADDITIONAL_CSS] = add_submenu_page(self::MENU_SLUG, __('Superb Addons - Custom CSS', "superb-blocks"), __('Custom CSS', "superb-blocks"), Capabilities::ADMIN, self::ADDITIONAL_CSS, array($this, 'AdditionalCSS'));
        $this->hooks[self::SETTINGS] = add_submenu_page(self::MENU_SLUG, __('Superb Addons - Settings', "superb-blocks"), __('Settings', "superb-blocks") . $this->GetAdminMenuNotification(), Capabilities::ADMIN, self::SETTINGS, array($this, 'Settings'));
        $this->hooks[self::SUPPORT] = add_submenu_page(self::MENU_SLUG, __('Superb Addons - Get Help', "superb-blocks"), __('Get Help', "superb-blocks"), Capabilities::CONTRIBUTOR, self::SUPPORT, array($this, 'Support'));
    }

    public function AdminMenuAdditions()
    {
        // Block theme related admin menu additions
        if (!function_exists('wp_is_block_theme') || !wp_is_block_theme()) return;

        $front_page_template = get_block_template(get_stylesheet() . "//front-page");
        if ($front_page_template && isset($front_page_template->id)) {
            add_pages_page(
                __('Edit Front Page', "superb-blocks"),
                __('Edit Front Page', "superb-blocks"),
                Capabilities::ADMIN,
                add_query_arg(
                    array(
                        'postType' => 'wp_template',
                        'postId'   => urlencode($front_page_template->id),
                        'canvas'   => 'edit',
                    ),
                    admin_url('site-editor.php')
                )
            );
        }

        add_pages_page(
            __('Add Template Page', "superb-blocks"),
            __('Add Template Page', "superb-blocks"),
            Capabilities::ADMIN,
            WizardController::GetWizardURL(WizardActionParameter::ADD_NEW_PAGES)
        );

        add_theme_page(
            __('Theme Designer', "superb-blocks"),
            __('Theme Designer', "superb-blocks"),
            Capabilities::ADMIN,
            WizardController::GetWizardURL(WizardActionParameter::INTRO)
        );
    }

    private function GetAdminMenuNotification()
    {
        $HasRegisteredKey = KeyController::HasRegisteredKey();
        if ($HasRegisteredKey) {
            $KeyStatus = KeyController::GetKeyStatus();
            if (!$KeyStatus['active'] || $KeyStatus['expired'] || !$KeyStatus['verified'] || $KeyStatus['exceeded']) {
                return sprintf('<span class="update-plugins count-1"><span class="plugin-count" aria-hidden="true">1</span><span class="screen-reader-text">%s</span></span>', esc_html__("Issue Detected", "superb-blocks"));
            }
        }

        return;
    }

    public function AdminMenuHighlightScripts()
    {
?>
        <style>
            tbody#the-list .<?= self::PREMIUM_CLASS ?> {
                color: #4312E2;
                font-weight: 900;
            }
        </style>
    <?php
    }

    public function HandleNotices()
    {
        add_action('wp_loaded', function () {
            $options = array("notices" => array());
            if (!KeyController::HasValidPremiumKey()) {
                $options["notices"][] = array(
                    'unique_id' => 'addons_delayed',
                    'content' => "addons-notice.php",
                    'delay' => '+6 days'
                );
            }
            if (WizardController::GetWizardRecommenderTransient()) {
                $options["notices"][] = array(
                    'unique_id' => 'wizard_recommender',
                    'content' => "wizard-recommender-notice.php"
                );
            } elseif (WizardController::GetWizardWoocommerceTransient()) {
                $options["notices"][] = array(
                    'unique_id' => 'wizard_woocommerce',
                    'content' => "wizard-woocommerce-notice.php"
                );
            }
            AdminNoticeController::init($options);
        });
    }

    public function AdminMenuEnqueues($page_hook)
    {
        if ($page_hook === 'plugins.php') {
            $this->enqueueCommonStyles();
            $this->enqueueFeedback();
            return;
        }

        if (!in_array($page_hook, array_values($this->hooks))) {
            return;
        }

        $this->enqueueCommonStyles();
        wp_enqueue_style(
            'superb-addons-admin-dashboard',
            SUPERBADDONS_ASSETS_PATH . '/css/admin-dashboard.min.css',
            array(),
            SUPERBADDONS_VERSION
        );

        switch ($page_hook) {
            case $this->hooks[self::DASHBOARD]:
                $this->enqueuePatternLibraryBase();
                $this->enqueueDashboard();
                break;

            case $this->hooks[self::SUPPORT]:
                $this->enqueueSupport();
                break;

            case $this->hooks[self::SETTINGS]:
                $this->enqueueSettings();
                break;

            case $this->hooks[self::ADDITIONAL_CSS]:
                $this->enqueueAdditionalCSS();
                break;

            case $this->hooks[self::PAGE_WIZARD]:
                $this->enqueuePageWizard();
                break;
        }
    }

    private function enqueueCommonStyles()
    {
        wp_enqueue_style(
            'superb-addons-elements',
            SUPERBADDONS_ASSETS_PATH . '/css/framework.min.css',
            array(),
            SUPERBADDONS_VERSION
        );
        wp_enqueue_style(
            'superb-addons-font-manrope',
            SUPERBADDONS_ASSETS_PATH . '/fonts/manrope/manrope.css',
            array(),
            SUPERBADDONS_VERSION
        );
        wp_enqueue_style(
            'superb-addons-admin-modal',
            SUPERBADDONS_ASSETS_PATH . '/css/admin-modal.min.css',
            array(),
            SUPERBADDONS_VERSION
        );
        wp_enqueue_style(
            'superbaddons-js-snackbar',
            SUPERBADDONS_ASSETS_PATH . '/lib/js-snackbar.min.css',
            array(),
            SUPERBADDONS_VERSION
        );
    }

    private function enqueueFeedback()
    {
        wp_enqueue_script('superb-addons-feedback', SUPERBADDONS_ASSETS_PATH . '/js/admin/deactivate-feedback.js', array('jquery'), SUPERBADDONS_VERSION, true);
        wp_localize_script('superb-addons-feedback', 'superbaddonssettings_g', array(
            "plugin" => plugin_basename(SUPERBADDONS_BASE),
            "rest" => array(
                "base" => \get_rest_url(),
                "namespace" => RestController::NAMESPACE,
                "nonce" => wp_create_nonce("wp_rest"),
                "routes" => array(
                    "settings" => SettingsController::SETTINGS_ROUTE,
                )
            )
        ));
        add_action('admin_footer', function () {
            new FeedbackModal();
        });
    }

    private function enqueuePatternLibraryBase()
    {
        GutenbergController::AddonsLibrary();
        wp_enqueue_script('superb-addons-select2', SUPERBADDONS_ASSETS_PATH . '/lib/select2.min.js', array('jquery'), SUPERBADDONS_VERSION, true);
        wp_enqueue_style(
            'superb-dashboard-layout-library',
            SUPERBADDONS_ASSETS_PATH . '/css/layout-library-editor.min.css',
            array(),
            SUPERBADDONS_VERSION
        );
        wp_enqueue_style(
            'superbaddons-select2',
            SUPERBADDONS_ASSETS_PATH . '/lib/select2.min.css',
            array(),
            SUPERBADDONS_VERSION
        );
    }

    private function enqueueDashboard()
    {
        wp_enqueue_script('superb-addons-library-dashboard', SUPERBADDONS_ASSETS_PATH . '/js/admin/dashboard.js', array('jquery', "wp-i18n"), SUPERBADDONS_VERSION, true);
        ScriptTranslations::Set('superb-addons-library-dashboard');
        wp_localize_script('superb-addons-library-dashboard', 'superblayoutlibrary_g', array(
            "style_placeholder" => esc_html__('All themes', "superb-blocks"),
            "category_placeholder" => esc_html__('All categories', "superb-blocks"),
            "snacks" => array(
                "list_error" => esc_html__('Something went wrong while attempting to list elements. Please try again or contact support if the problem persists.', "superb-blocks")
            ),
            "gutenberg_menu_items" => GutenbergController::GetGutenbergLibraryMenuItems(),
            "elementor_menu_items" => ElementorController::GetElementorLibraryMenuItems(),
            "rest" => array(
                "base" => \get_rest_url(),
                "namespace" => RestController::NAMESPACE,
                "nonce" => wp_create_nonce("wp_rest"),
                "routes" => array(
                    "settings" => SettingsController::SETTINGS_ROUTE,
                )
            )
        ));
    }

    private function enqueueSupport()
    {
        wp_enqueue_script('superb-addons-troubleshooting', SUPERBADDONS_ASSETS_PATH . '/js/admin/troubleshooting.js', array('jquery', 'wp-i18n'), SUPERBADDONS_VERSION, true);
        ScriptTranslations::Set('superb-addons-troubleshooting');
        wp_localize_script('superb-addons-troubleshooting', 'superbaddonstroubleshooting_g', array(
            "rest" => array(
                "base" => \get_rest_url(),
                "namespace" => RestController::NAMESPACE,
                "nonce" => wp_create_nonce("wp_rest"),
                "routes" => array(
                    "troubleshooting" => TroubleshootingController::TROUBLESHOOTING_ROUTE,
                    "tutorial" => TroubleshootingController::TUTORIAL_ROUTE,
                )
            ),
            "steps" => array(
                "wordpressversion" => array(
                    "title" => esc_html__("WordPress Version", "superb-blocks"),
                    "text" => esc_html__("Checking Compatibility", "superb-blocks"),
                    "errorText" => esc_html__("Incompatible. Please update WordPress.", "superb-blocks"),
                    "successText" => esc_html__("Compatible", "superb-blocks"),
                ),
                "elementorversion" => array(
                    "active" => is_plugin_active('elementor/elementor.php'),
                    "title" => esc_html__("Elementor Version", "superb-blocks"),
                    "text" => esc_html__("Checking Compatibility", "superb-blocks"),
                    "errorText" => esc_html__("Incompatible. Please update Elementor.", "superb-blocks"),
                    "successText" => esc_html__("Compatible", "superb-blocks"),
                ),
                "connection" => array(
                    "title" => esc_html__("Connection Status", "superb-blocks"),
                    "text" => esc_html__("Checking Connection", "superb-blocks"),
                    "errorText" => esc_html__("No Connection", "superb-blocks"),
                    "successText" => esc_html__("Connected", "superb-blocks"),
                ),
                "domainshift" => array(
                    "title" => esc_html__("Connection Update", "superb-blocks"),
                    "text" => esc_html__("Trying New Connection", "superb-blocks"),
                    "errorText" => esc_html__("Connection Blocked", "superb-blocks"),
                    "successText" => esc_html__("Connected", "superb-blocks"),
                ),
                "service" => array(
                    "title" => esc_html__("Service Status", "superb-blocks"),
                    "text" => esc_html__("Checking Service", "superb-blocks"),
                    "errorText" => esc_html__("Service Unavailable", "superb-blocks"),
                    "successText" => esc_html__("Service Online", "superb-blocks"),
                ),
                "keycheck" => array(
                    "title" => esc_html__("License Key Status", "superb-blocks"),
                    "text" => esc_html__("Checking License Key", "superb-blocks"),
                    "errorText" => esc_html__("Invalid License Key", "superb-blocks"),
                    "successText" => esc_html__("Valid License Key", "superb-blocks"),
                ),
                "keyverify" => array(
                    "title" => esc_html__("License Key Verification", "superb-blocks"),
                    "text" => esc_html__("Re-verifying License Key", "superb-blocks"),
                    "errorText" => esc_html__("License could not be verified", "superb-blocks"),
                    "successText" => esc_html__("License Key Verified", "superb-blocks"),
                ),
                "cacheclear" => array(
                    "title" => esc_html__("Cache Status", "superb-blocks"),
                    "text" => esc_html__("Clearing Cache", "superb-blocks"),
                    "errorText" => esc_html__("Cache could not be cleared", "superb-blocks"),
                    "successText" => esc_html__("Cache Cleared", "superb-blocks"),
                )
            )
        ));
        add_action("admin_footer", array($this, 'TroubleshootingTemplates'));
    }

    private function enqueueSettings()
    {
        wp_enqueue_script('superb-addons-settings', SUPERBADDONS_ASSETS_PATH . '/js/admin/settings.js', array('jquery'), SUPERBADDONS_VERSION, true);
        wp_localize_script('superb-addons-settings', 'superbaddonssettings_g', array(
            "save_message" => esc_html__("Settings saved successfully.", "superb-blocks"),
            "modal" => array(
                "cache" => array(
                    "title" => esc_html__("Clear Cache", "superb-blocks"),
                    "content" => esc_html__("All element- data and images will need to be loaded again if the cache is removed. This should only be done if you are experiencing issues or planning to delete the plugin. Are you sure you want to clear the cache?", "superb-blocks"),
                    "success" => esc_html__("Cache cleared successfully.", "superb-blocks")
                ),
                "view_logs" => array(
                    "title" => esc_html__("Error Log", "superb-blocks"),
                    "no_logs" => esc_html__("No errors have been logged.", "superb-blocks"),
                    "icon_unshared" => esc_url(SUPERBADDONS_ASSETS_PATH . "/img/cloud-slash.svg"),
                    "unshared_title" => esc_html__("Error Log Not Shared", "superb-blocks"),
                    "icon_shared" => esc_url(SUPERBADDONS_ASSETS_PATH . "/img/cloud-check.svg"),
                    "shared_title" => esc_html__("Error Log Shared", "superb-blocks"),
                ),
                "clear_logs" => array(
                    "title" => esc_html__("Clear Logs", "superb-blocks"),
                    "content" => esc_html__("Error Logs are used for debugging purposes and help improve the plugin when shared with our support team and developers. Are you sure you want to clear the error logs?", "superb-blocks"),
                    "success" => esc_html__("Error logs cleared successfully.", "superb-blocks")
                ),
                "remove_key" => array(
                    "title" => esc_html__("Remove License Key", "superb-blocks"),
                    "content" => esc_html__("Are you sure you want to remove your license key from this website?", "superb-blocks"),
                ),
                "clear_restoration_points" => array(
                    "title" => esc_html__("Clear Restoration Points", "superb-blocks"),
                    "content" => esc_html__("Restoration points can not be recovered after being cleared. Are you sure you want to clear all restoration points?", "superb-blocks"),
                    "success" => esc_html__("Restoration points cleared successfully.", "superb-blocks")
                )
            ),
            "rest" => array(
                "base" => \get_rest_url(),
                "namespace" => RestController::NAMESPACE,
                "nonce" => wp_create_nonce("wp_rest"),
                "routes" => array(
                    "settings" => SettingsController::SETTINGS_ROUTE,
                )
            )
        ));
    }

    private function enqueueAdditionalCSS()
    {
        wp_enqueue_style(
            'superbaddons-select2',
            SUPERBADDONS_ASSETS_PATH . '/lib/select2.min.css',
            array(),
            SUPERBADDONS_VERSION
        );

        do_action('superbaddons/admin/css-blocks/enqueue');

        wp_enqueue_script('superb-addons-select2', SUPERBADDONS_ASSETS_PATH . '/lib/select2.min.js', array('jquery'), SUPERBADDONS_VERSION, true);
        $code_editor_settings = wp_enqueue_code_editor(array('type' => 'text/css', 'codemirror' => array('lint' => true)));
        wp_enqueue_script('superb-addons-css-blocks', SUPERBADDONS_ASSETS_PATH . '/js/admin/cssblocks.js', array('jquery', 'wp-i18n'), SUPERBADDONS_VERSION, true);
        ScriptTranslations::Set('superb-addons-css-blocks');
        wp_localize_script('superb-addons-css-blocks', 'superbaddonscssblocks_g', array(
            "codeEditorSettings" => $code_editor_settings,
            "rest" => array(
                "base" => \get_rest_url(),
                "namespace" => RestController::NAMESPACE,
                "nonce" => wp_create_nonce("wp_rest"),
                "routes" => array(
                    "css" => CSSController::CSS_ROUTE,
                ),
                "error_message" => esc_html__("An error occurred while updating the CSS block. Please try again.", "superb-blocks"),
            ),
        ));
    }

    private function enqueuePageWizard()
    {
        wp_enqueue_style(
            'superb-addons-page-wizard',
            SUPERBADDONS_ASSETS_PATH . '/css/page-wizard.min.css',
            array(),
            SUPERBADDONS_VERSION
        );
        wp_enqueue_script('superb-addons-page-wizard', SUPERBADDONS_ASSETS_PATH . '/js/admin/page-wizard.js', array('jquery', 'wp-i18n'), SUPERBADDONS_VERSION, true);
        ScriptTranslations::Set('superb-addons-page-wizard');
        wp_localize_script('superb-addons-page-wizard', 'superbaddonswizard_g', array(
            "rest" => array(
                "base" => \get_rest_url(),
                "namespace" => RestController::NAMESPACE,
                "nonce" => wp_create_nonce("wp_rest"),
                "routes" => array(
                    "wizard" => WizardController::WIZARD_ROUTE,
                )
            )
        ));
    }

    public function TroubleshootingTemplates()
    {
        ob_start();
        include(SUPERBADDONS_PLUGIN_DIR . 'src/admin/templates/troubleshooting-step.php');
        $template = ob_get_clean();
        echo '<script type="text/template" id="tmpl-superb-addons-troubleshooting-step">' . $template . '</script>';
    }

    public function SuperbDashboard()
    {
        $this->DashboardPageSetup(DashboardPage::class);
    }

    public function AdditionalCSS()
    {
        $this->DashboardPageSetup(AdditionalCSSPage::class);
    }

    public function Support()
    {
        $this->DashboardPageSetup(SupportPage::class);
    }

    public function Settings()
    {
        $this->DashboardPageSetup(SettingsPage::class);
    }

    public function PageWizard()
    {
        $this->DashboardPageSetup(PageWizardMainPage::class, true, __("Theme Designer", "superb-blocks"));
    }

    private function DashboardPageSetup($page_class, $hide_navigation_items = false, $subtitle = false)
    {
    ?>
        <div class="superbaddons-wrap">
            <?php new Navigation($hide_navigation_items, $subtitle); ?>
            <div class="superbaddons-wrap-inner">
                <?php new $page_class(); ?>
            </div>
        </div>
<?php
    }
}
