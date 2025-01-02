<?php

namespace SuperbAddons\Admin\Controllers\Wizard;

use Exception;
use SuperbAddons\Admin\Controllers\DashboardController;
use SuperbAddons\Config\Capabilities;
use SuperbAddons\Data\Controllers\LogController;
use SuperbAddons\Data\Controllers\RestController;
use SuperbAddons\Data\Utils\ThemeInstaller;
use SuperbAddons\Data\Utils\Wizard\AddonsPageTemplateUtil;
use SuperbAddons\Data\Utils\Wizard\WizardActionParameter;
use SuperbAddons\Data\Utils\Wizard\WizardException;
use SuperbAddons\Data\Utils\Wizard\WizardItemTypes;
use SuperbAddons\Data\Utils\Wizard\WizardMenuCreator;
use SuperbAddons\Data\Utils\Wizard\WizardPageCreator;
use SuperbAddons\Data\Utils\Wizard\WizardPartCreator;
use SuperbAddons\Data\Utils\Wizard\WizardStageUtil;
use SuperbAddons\Gutenberg\Controllers\GutenbergController;
use WP_Error;
use WP_REST_Server;

defined('ABSPATH') || exit();

class WizardController
{
    const WIZARD_ROUTE = '/wizard';
    const ACTION_QUERY_PARAM = 'superbaddons-wizard-action';
    const COMPLETED_QUERY_PARAM = 'superbaddons-wizard-completed';
    const RECOMMENDER_TRANSIENT = 'superbaddons_wizard_recommender_transient';
    const WOOCOMMERCE_TRANSIENT = 'superbaddons_wizard_woocommerce_transient';


    public static function Initialize()
    {
        self::InitializeWizardRecommenderSwitchAction();
        self::InitializeTemplateWizardEndpoints();
        if (!GutenbergController::is_block_theme()) {
            return;
        }

        self::InitializeWizardPageTemplates();
        WizardTemplatePreviewController::InitializeTemplatePreview();
    }

    private static function InitializeWizardPageTemplates()
    {
        add_filter('get_block_templates', function ($query_result, $query, $template_type) {
            if ($template_type !== WizardItemTypes::WP_TEMPLATE) {
                return $query_result;
            }

            if (
                !empty($query) &&
                (isset($query['slug__in']) && !in_array(AddonsPageTemplateUtil::TEMPLATE_ID, $query['slug__in'])) ||
                (isset($query['slug__not_in']) && in_array(AddonsPageTemplateUtil::TEMPLATE_ID, $query['slug__not_in']))
            ) {
                return $query_result;
            }

            $template = AddonsPageTemplateUtil::GetAddonsPageBlockTemplateObject();

            $query_result[] = $template;

            return $query_result;
        }, 10, 3);

        add_filter('get_block_file_template', function ($block_template, $id, $template_type) {
            if ($template_type !== WizardItemTypes::WP_TEMPLATE) {
                return $block_template;
            }

            if ($id === get_stylesheet() . "//" . AddonsPageTemplateUtil::TEMPLATE_ID || $id === AddonsPageTemplateUtil::PLUGIN_SLUG . '//' . AddonsPageTemplateUtil::TEMPLATE_ID) {
                return AddonsPageTemplateUtil::GetAddonsPageBlockTemplateObject();
            }

            return $block_template;
        }, 10, 3);
    }

    private static function InitializeWizardRecommenderSwitchAction()
    {
        // Add action to the switch theme hook
        add_action('switch_theme', function () {
            self::MaybeSetWizardRecommenderTransient();
        });

        // Check if WooCommerce is active
        add_action('activated_plugin', function ($plugin) {
            if ($plugin !== 'woocommerce/woocommerce.php') {
                return;
            }
            self::MaybeSetWizardWooCommerceTransient();
        });

        add_action('deactivated_plugin', function ($plugin) {
            if ($plugin !== 'woocommerce/woocommerce.php') {
                return;
            }
            self::RemoveWizardWooCommerceTransient();
        });
    }

    public static function MaybeSetWizardRecommenderTransient()
    {
        if (!GutenbergController::is_block_theme()) {
            self::RemoveWizardRecommenderTransient();
            self::RemoveWizardWooCommerceTransient();
            return;
        }
        $current_theme = get_stylesheet();
        $completed_themes = get_option('superbaddons_wizard_completed_themes', []);
        if (in_array($current_theme, $completed_themes)) {
            self::RemoveWizardRecommenderTransient();
            return;
        }
        set_transient(self::RECOMMENDER_TRANSIENT, true, MONTH_IN_SECONDS);
        self::MaybeSetWizardWooCommerceTransient();
    }

    public static function MaybeSetWizardWooCommerceTransient()
    {
        if (is_plugin_active('woocommerce/woocommerce.php')) {
            set_transient(self::WOOCOMMERCE_TRANSIENT, true, MONTH_IN_SECONDS);
        } else {
            self::RemoveWizardWooCommerceTransient();
        }
    }

    public static function RemoveWizardRecommenderTransient()
    {
        return delete_transient(self::RECOMMENDER_TRANSIENT);
    }

    public static function GetWizardRecommenderTransient()
    {
        return get_transient(self::RECOMMENDER_TRANSIENT);
    }

    public static function GetWizardWoocommerceTransient()
    {
        return get_transient(self::WOOCOMMERCE_TRANSIENT);
    }

    public static function RemoveWizardWooCommerceTransient()
    {
        return delete_transient(self::WOOCOMMERCE_TRANSIENT);
    }

    private static function SetWizardPartPreviewTransient($preview_data)
    {
        $user_id = get_current_user_id();
        $transient = get_transient(WizardTemplatePreviewController::TEMPLATE_PART_PREVIEW_TRANSIENT);
        $transient[$user_id] = $preview_data;
        return set_transient(WizardTemplatePreviewController::TEMPLATE_PART_PREVIEW_TRANSIENT, $transient, DAY_IN_SECONDS);
    }

    public static function GetPartPreviewTransient()
    {
        $user_id = get_current_user_id();
        $transient = get_transient(WizardTemplatePreviewController::TEMPLATE_PART_PREVIEW_TRANSIENT);
        return isset($transient[$user_id]) ? $transient[$user_id] : false;
    }

    public static function RemoveWizardPartPreviewTransient()
    {
        return delete_transient(self::RECOMMENDER_TRANSIENT);
    }

    public static function GetRecommendedBlockThemes()
    {
        if (!function_exists('themes_api')) {
            require_once(ABSPATH . 'wp-admin/includes/theme.php');
        }

        return themes_api(
            "query_themes",
            array(
                "author" => "superbaddons",
                "per_page" => 24,
                "browse" => "popular",
                "fields" => array("name" => true, "slug" => true, "screenshot_url" => true)
            )
        );
    }

    public static function GetWizardURL($action)
    {
        return add_query_arg(
            array(
                'page' => DashboardController::PAGE_WIZARD,
                self::ACTION_QUERY_PARAM => $action,
            ),
            admin_url("admin.php")
        );
    }

    public static function GetWizardCompleteURL($wizardType)
    {
        return add_query_arg(
            array(
                'page' => DashboardController::PAGE_WIZARD,
                self::ACTION_QUERY_PARAM => WizardActionParameter::COMPLETE,
                self::COMPLETED_QUERY_PARAM => $wizardType
            ),
            admin_url("admin.php")
        );
    }

    public static function GetCompletedWizardType()
    {
        return isset($_GET[self::COMPLETED_QUERY_PARAM]) ? $_GET[self::COMPLETED_QUERY_PARAM] : false;
    }

    private static function isAction($param, $action)
    {
        return isset($_GET[$param]) && $_GET[$param] === $action;
    }

    private static function isAllowedAction($action)
    {
        if (!isset($action)) {
            return false;
        }
        $allowed_actions = [WizardActionParameter::ADD_NEW_PAGES, WizardActionParameter::HEADER_FOOTER, WizardActionParameter::WOOCOMMERCE_HEADER, WizardActionParameter::THEME_DESIGNER, WizardActionParameter::RESTORE];
        return in_array($action, $allowed_actions);
    }

    public static function IsWizardStages()
    {
        if (!isset($_GET[self::ACTION_QUERY_PARAM]) || !self::isAllowedAction($_GET[self::ACTION_QUERY_PARAM])) {
            return false;
        }

        return true;
    }

    public static function IsCompleteScreen()
    {
        return self::isAction(self::ACTION_QUERY_PARAM, WizardActionParameter::COMPLETE);
    }

    public static function ThemeHasCompletedWizard()
    {
        $current_theme = get_stylesheet();
        $completed_themes = get_option('superbaddons_wizard_completed_themes', []);
        return in_array($current_theme, $completed_themes);
    }

    public static function CompleteWizard()
    {
        $current_theme = get_stylesheet();
        $completed_themes = get_option('superbaddons_wizard_completed_themes', []);
        if (!in_array($current_theme, $completed_themes)) {
            $completed_themes[] = $current_theme;
            update_option('superbaddons_wizard_completed_themes', $completed_themes, false);
        }
        self::RemoveWizardRecommenderTransient();
    }

    public static function CompleteWooCommerceWizard()
    {
        self::RemoveWizardWooCommerceTransient();
    }

    private static function InitializeTemplateWizardEndpoints()
    {
        RestController::AddRoute(self::WIZARD_ROUTE, array(
            'methods' => WP_REST_Server::EDITABLE,
            'permission_callback' => array(self::class, 'TemplateWizardCallbackPermissionCheck'),
            'callback' => array(self::class, 'TemplateWizardCallback'),
        ));
    }

    public static function TemplateWizardCallbackPermissionCheck()
    {
        // Restrict endpoint to only users who have the proper capability.
        if (!current_user_can(Capabilities::ADMIN)) {
            return new WP_Error('rest_forbidden', esc_html__('Unauthorized. Please check user permissions.', "superb-blocks"), array('status' => 401));
        }

        return true;
    }

    public static function TemplateWizardCallback($request)
    {
        if (!isset($request['action'])) {
            return new \WP_Error('bad_request_plugin', 'Bad Plugin Request', array('status' => 400));
        }
        switch ($request['action']) {
            case 'switchtheme':
                return self::SwitchThemeCallback($request);
            case 'create':
                if (!GutenbergController::is_block_theme()) {
                    return new \WP_Error('bad_request_plugin', 'Bad Plugin Request', array('status' => 400));
                }
                return self::TemplateWizardCreateCallback($request);
            case 'headerfooterpreview':
                if (!GutenbergController::is_block_theme()) {
                    return new \WP_Error('bad_request_plugin', 'Bad Plugin Request', array('status' => 400));
                }
                return self::HeaderFooterPreviewCallback($request);
            default:
                return new \WP_Error('bad_request_plugin', 'Bad Plugin Request', array('status' => 400));
        }
    }

    private static function SwitchThemeCallback($request)
    {
        try {
            $theme_slug = $request['theme'];
            if (empty($theme_slug)) {
                return rest_ensure_response(['success' => false, 'text' => esc_html__("Couldn't find selected theme.", "superb-blocks")]);
            }

            $themes_api = self::GetRecommendedBlockThemes();

            $accepted_theme = false;
            foreach ($themes_api->themes as $theme) {
                if ($theme->slug === $theme_slug) {
                    $accepted_theme = true;
                    break;
                }
            }

            if (!$accepted_theme) {
                return rest_ensure_response(['success' => false, 'text' => esc_html__("Selected theme is invalid. Please contact support for assistance.", "superb-blocks")]);
            }

            $installed = ThemeInstaller::Install($theme_slug);

            return rest_ensure_response(['success' => $installed]);
        } catch (Exception $ex) {
            LogController::HandleException($ex);
            return new \WP_Error('internal_error_plugin', 'Internal Plugin Error', array('status' => 500));
        }
    }

    private static function TemplateWizardCreateCallback($request)
    {
        try {
            if (!isset($request['selection_data'])) {
                return rest_ensure_response(['success' => false, 'text' => esc_html__("Something went wrong. The process could not start.", "superb-blocks")]);
            }

            $selection_data = json_decode($request['selection_data'], true);

            $stageUtil = new WizardStageUtil($request['wizardType']);
            if (!self::ValidateSelectionData($selection_data, $stageUtil)) {
                return rest_ensure_response(['success' => false, 'text' => esc_html__("Something went wrong. Please double-check that all steps have been correctly completed.", "superb-blocks")]);
            }

            WizardPartCreator::CreateTemplateParts($selection_data, $stageUtil);

            if ($stageUtil->HasPageStages()) {
                $menu_items = WizardPageCreator::CreateTemplatePages($selection_data, $stageUtil);

                if (empty($menu_items)) {
                    return rest_ensure_response(['success' => false, 'text' => esc_html__("Something went wrong. Templates and/or pages were not able to be properly processed.", "superb-blocks")]);
                }

                WizardMenuCreator::MaybeUpdateMenu($selection_data, $menu_items);
            }

            if ($stageUtil->GetType() === WizardActionParameter::THEME_DESIGNER) {
                WizardController::CompleteWizard();
            } elseif ($stageUtil->GetType() === WizardActionParameter::WOOCOMMERCE_HEADER) {
                WizardController::CompleteWooCommerceWizard();
            }

            return rest_ensure_response(['success' => true]);
        } catch (WizardException $wex) {
            return rest_ensure_response(['success' => false, 'text' => $wex->getMessage()]);
        } catch (Exception $ex) {
            LogController::HandleException($ex);
            return new WP_Error('internal_error_plugin', 'Internal Plugin Error', array('status' => 500));
        }
    }

    private static function ValidateSelectionData($selection_data, $stageUtil)
    {
        if (!self::isAllowedAction($stageUtil->GetType())) {
            return false;
        }

        foreach ($stageUtil->GetStages() as $stage_type) {
            if (!isset($selection_data[$stage_type])) {
                if ($stageUtil->GetType() === WizardActionParameter::RESTORE) {
                    continue;
                }
                return false;
            }

            $stage_selections = $selection_data[$stage_type];

            if (!is_array($stage_selections)) {
                return false;
            }

            if (empty($stage_selections)) {
                continue;
            }

            if (isset($stage_selections[0]['isChanged']) && !boolval($stage_selections[0]['isChanged'])) {
                continue;
            }

            foreach ($stage_selections as $selection) {
                if (!isset($selection['slug']) || !isset($selection['title'])) {
                    return false;
                }
            }
        }

        return true;
    }

    public static function HeaderFooterPreviewCallback($request)
    {
        $preview_transient = [];
        // Do not set if the header is the default header.
        if (isset($request['header']) && $request['header'] !== 'header') {
            $preview_transient['header'] = $request['header'];
        }
        // Do not set if the footer is the default footer.
        if (isset($request['footer']) && $request['footer'] !== 'footer') {
            $preview_transient['footer'] = $request['footer'];
        }

        self::SetWizardPartPreviewTransient($preview_transient);

        return rest_ensure_response(['success' => true]);
    }
}
