<?php

namespace SuperbAddons\Admin\Controllers;

defined('ABSPATH') || exit();

use SuperbAddons\Config\Capabilities;
use SuperbAddons\Data\Controllers\CacheController;
use SuperbAddons\Data\Controllers\KeyController;
use SuperbAddons\Data\Controllers\OptionController;
use SuperbAddons\Data\Controllers\RestController;
use SuperbAddons\Data\Controllers\SettingsOptionKey;
use Exception;
use SuperbAddons\Admin\Controllers\Wizard\WizardRestorationPointController;
use SuperbAddons\Data\Controllers\CompatibilitySettingsOptionKey;
use SuperbAddons\Data\Controllers\LogController;
use SuperbAddons\Data\Utils\KeyException;
use SuperbAddons\Data\Utils\SettingsException;
use SuperbAddons\Gutenberg\Controllers\GutenbergEnhancementsController;

class SettingsController
{
    const SETTINGS_ROUTE = '/settings';

    public function __construct()
    {
        RestController::AddRoute(self::SETTINGS_ROUTE, array(
            'methods' => 'POST',
            'permission_callback' => array($this, 'SettingsCallbackPermissionCheck'),
            'callback' => array($this, 'SettingsRouteCallback'),
        ));
    }

    public function SettingsCallbackPermissionCheck()
    {
        // Restrict endpoint to only users who have the proper capability.
        if (!current_user_can(Capabilities::ADMIN)) {
            return new WP_Error('rest_forbidden', esc_html__('Unauthorized. Please check user permissions.', "superb-blocks"), array('status' => 401));
        }

        return true;
    }

    public function SettingsRouteCallback($request)
    {
        if (!isset($request['action'])) {
            return new \WP_Error('bad_request_plugin', 'Bad Plugin Request', array('status' => 400));
        }
        switch ($request['action']) {
            case 'submit_feedback':
                return $this->SubmitFeedbackCallback();
            case 'addkey':
                return $this->RegisterKeyCallback($request);
            case 'removekey':
                return $this->RemoveKeyCallback();
            case SettingsOptionKey::LOGS_ENABLED:
            case SettingsOptionKey::LOG_SHARE_ENABLED:
            case 'clear_cache':
            case 'clear_logs':
            case 'view_logs':
            case 'clear_restoration_points':
                return $this->SaveSettingsCallback($request['action']);
            case GutenbergEnhancementsController::HIGHLIGHTS_KEY:
            case GutenbergEnhancementsController::HIGHLIGHTS_QUICKOPTIONS_KEY:
            case GutenbergEnhancementsController::HIGHLIGHTS_QUICKOPTIONS_BOTTOM_KEY:
            case GutenbergEnhancementsController::HIDERS_KEY:
            case GutenbergEnhancementsController::ANIMATIONS_KEY:
                return GutenbergEnhancementsController::OptionsSaveCallback($request);
            case CompatibilitySettingsOptionKey::SPECTRA_BLOCK_SPACING:
                return $this->SaveCompatibilitySettingsCallback($request['action']);
            default:
                return new \WP_Error('bad_request_plugin', 'Bad Plugin Request', array('status' => 400));
        }
    }

    private function SubmitFeedbackCallback()
    {
        try {
            if (!isset($_POST['spbaddons_reason']) || empty($_POST['spbaddons_reason'])) throw new SettingsException(__('Unable to send feedback. No feedback provided.', "superb-blocks"));

            $message = $_POST['spbaddons_reason'] === 'other' ? $_POST['spbaddons_other'] : $_POST['spbaddons_reason'];
            LogController::SendFeedback($message);

            return rest_ensure_response(['success' => true]);
        } catch (SettingsException $s_ex) {
            return rest_ensure_response(['success' => false, "text" => esc_html($s_ex->getMessage())]);
        } catch (Exception $ex) {
            LogController::HandleException($ex);
            return new \WP_Error('internal_error_plugin', 'Internal Plugin Error', array('status' => 500));
        }
    }

    private function RegisterKeyCallback($request)
    {
        try {
            KeyController::RegisterKey($request['key'], true);
            return rest_ensure_response(['success' => true]);
        } catch (KeyException $k_ex) {
            return rest_ensure_response(['success' => false, "text" => esc_html($k_ex->getMessage())]);
        } catch (Exception $ex) {
            LogController::HandleException($ex);
            return new \WP_Error('internal_error_plugin', 'Internal Plugin Error', array('status' => 500));
        }
    }

    private function RemoveKeyCallback()
    {
        try {
            $removed = KeyController::RemoveKey();
            return rest_ensure_response(['success' => $removed]);
        } catch (KeyException $k_ex) {
            return rest_ensure_response(['success' => false, "text" => esc_html($k_ex->getMessage())]);
        } catch (Exception $ex) {
            LogController::HandleException($ex);
            return new \WP_Error('internal_error_plugin', 'Internal Plugin Error', array('status' => 500));
        }
    }

    public static function GetSettings()
    {
        return OptionController::GetSettings();
    }

    public static function GetCompatibilitySettings()
    {
        return OptionController::GetCompatibilitySettings();
    }

    private function SaveSettingsCallback($action)
    {
        try {
            $option_controller = new OptionController();
            $current_settings = OptionController::GetSettings();

            switch ($action) {
                case SettingsOptionKey::LOGS_ENABLED:
                    $current_settings[SettingsOptionKey::LOGS_ENABLED] = !$current_settings[SettingsOptionKey::LOGS_ENABLED];
                    $option_controller->SaveSettings($current_settings);
                    break;
                case SettingsOptionKey::LOG_SHARE_ENABLED:
                    $current_settings[SettingsOptionKey::LOG_SHARE_ENABLED] = !$current_settings[SettingsOptionKey::LOG_SHARE_ENABLED];
                    $saved = $option_controller->SaveSettings($current_settings);
                    if ($saved) {
                        $current_settings[SettingsOptionKey::LOG_SHARE_ENABLED] ? LogController::MaybeSubscribeCron() : LogController::MaybeUnsubscribeCron();
                    }
                    break;
                case 'clear_cache':
                    $cleared = CacheController::ClearCacheAll();
                    if (!$cleared) throw new SettingsException(__('Cache could not be cleared.', "superb-blocks"));
                    break;
                case 'clear_logs':
                    $cleared = LogController::ClearLogs();
                    if (!$cleared) throw new SettingsException(__('Logs could not be cleared.', "superb-blocks"));
                    break;
                case 'view_logs':
                    return rest_ensure_response(['success' => true, 'content' => LogController::GetLogs()]);
                case 'clear_restoration_points':
                    $cleared = WizardRestorationPointController::FullRestorationCleanup();
                    if (!$cleared) throw new SettingsException(__('Restoration points could not be cleared.', "superb-blocks"));
                    break;
            }

            return rest_ensure_response(['success' => true]);
        } catch (SettingsException $s_ex) {
            return rest_ensure_response(['success' => false, "text" => esc_html($s_ex->getMessage())]);
        } catch (Exception $ex) {
            LogController::HandleException($ex);
            return new \WP_Error('internal_error_plugin', 'Internal Plugin Error', array('status' => 500));
        }
    }

    private function SaveCompatibilitySettingsCallback($action)
    {
        try {
            $option_controller = new OptionController();
            $current_settings = OptionController::GetCompatibilitySettings();

            switch ($action) {
                case CompatibilitySettingsOptionKey::SPECTRA_BLOCK_SPACING:
                    $current_settings[CompatibilitySettingsOptionKey::SPECTRA_BLOCK_SPACING] = !$current_settings[CompatibilitySettingsOptionKey::SPECTRA_BLOCK_SPACING];
                    $option_controller->SaveCompatibilitySettings($current_settings);
                    break;
            }

            return rest_ensure_response(['success' => true]);
        } catch (SettingsException $s_ex) {
            return rest_ensure_response(['success' => false, "text" => esc_html($s_ex->getMessage())]);
        } catch (Exception $ex) {
            LogController::HandleException($ex);
            return new \WP_Error('internal_error_plugin', 'Internal Plugin Error', array('status' => 500));
        }
    }

    public static function GetRelevantCompatibilitySettings()
    {
        $relevant_settings = array();
        // Check if Spectra is active
        if (class_exists('UAGB_Loader')) {
            $relevant_settings[CompatibilitySettingsOptionKey::SPECTRA_BLOCK_SPACING] = true;
        }

        return $relevant_settings;
    }

    public static function IsCompatibilitySettingRelevantAndEnabled($compatibility_setting)
    {
        $relevant_settings = self::GetRelevantCompatibilitySettings();
        if (!isset($relevant_settings[$compatibility_setting])) return false;

        $compatibility_settings = self::GetCompatibilitySettings();
        return $compatibility_settings[$compatibility_setting];
    }
}
