<?php

namespace SuperbAddons\Data\Controllers;

defined('ABSPATH') || exit();

use Exception;
use SuperbAddons\Data\Controllers\OptionController;
use SuperbAddons\Data\Utils\KeyException;
use SuperbAddons\Data\Utils\KeyType;
use SuperbAddons\Data\Utils\OptionException;

class KeyController
{
    const ENDPOINT_BASE = 'addons-status/';

    public static function RegisterKey($key, $is_registration = false)
    {
        try {
            $is_valid = strlen($key) === 23 && preg_match('/^[A-Z0-9]{5}(-[A-Z0-9]{5}){3}$/', $key);
            if (!$is_valid) {
                throw new KeyException(__("Invalid License Key. Please check that the license key was entered correctly.", "superb-blocks"));
            }

            $option_controller = new OptionController();
            $stamp = $option_controller->GetStamp();
            $response = DomainShiftController::RemoteGet(self::ENDPOINT_BASE . 'keys?' . ($is_registration ? "registration=true" : "revalidate=true") . '&key=' . $key . '&dm=' . urlencode(home_url()) . '&stamp=' . absint($stamp));
            $response_code = wp_remote_retrieve_response_code($response);
            if (!is_array($response) || is_wp_error($response) || $response_code !== 200) {
                if ($response_code === 404) {
                    throw new KeyException(__("License key could not be validated. Please check that the license key was entered correctly.", "superb-blocks"), true, $response_code);
                } else {
                    throw new KeyException(__("Unable to validate license key. Please contact support for assistance.", "superb-blocks"), false, $response_code);
                }
            }

            $data = json_decode($response['body']);
            if (!isset($data->level) || !isset($data->active) || !$data->active || !isset($data->expired) || !isset($data->verification) || !$data->verification || !isset($data->verification->exceeded) || !isset($data->verification->verified) || !isset($data->verification->stamp)) {
                throw new KeyException(__("License key not currently active. Please contact support for assistance.", "superb-blocks"));
            }

            if ($data->verification->exceeded) {
                throw new KeyException(__("You have already used up all your domain activations for this license key.", "superb-blocks"));
            }

            if ((!$data->verification->verified || !$data->verification->stamp) && $data->active && !$data->expired) {
                throw new KeyException(__("License key verification could not complete. Please contact support for assistance.", "superb-blocks"));
            }

            if ($data->expired && $data->level !== KeyType::STANDARD) {
                throw new KeyException(__("License key has expired. Please renew your subscription to re-activate your license.", "superb-blocks"));
            }

            try {
                $option_controller->UpdateKey($key, $data->verification->stamp);
                self::UpdateKeyType($data->level, $data->active, $data->expired, $data->exceeded);
                return array("type" => $data->level, "active" => $data->active, "expired" => $data->expired, "verified" => $data->verification->verified, "exceeded" => $data->exceeded);
            } catch (OptionException $o_ex) {
                self::RemoveKey($key, $data->verification->stamp);
                throw new KeyException(__("Unable to store license in WordPress. If the problem persists, please contact support.", "superb-blocks"));
            }
        } catch (KeyException $k_ex) {
            throw $k_ex;
        } catch (Exception $ex) {
            LogController::HandleException($ex);
            throw new KeyException(__("Internal Error Occurred During License Key Registration", "superb-blocks"));
        }
    }

    public static function RemoveKey($request_key = false, $request_stamp = false)
    {
        $option_controller = new OptionController();
        try {
            $stamp = $request_stamp ? $request_stamp : $option_controller->GetStamp();
            $key = $request_key ? $request_key : $option_controller->GetKey();
            $response = DomainShiftController::RemoteGet(self::ENDPOINT_BASE . 'keys/remove?key=' . $key . '&dm=' . urlencode(home_url()) . '&stamp=' . absint($stamp));
            $response_code = wp_remote_retrieve_response_code($response);
            if (!is_array($response) || is_wp_error($response) || $response_code !== 200) {
                throw new Exception(__("License key removal record not received.", "superb-blocks"), $response_code);
            }
        } catch (Exception $ex) {
            LogController::HandleException($ex);
        }
        return $option_controller->RemoveKey();
    }

    public static function GetUpdatedLicenseKeyInformation()
    {
        try {
            $option_controller = new OptionController();
            if ($option_controller->HasRegisteredKey()) {
                $key = $option_controller->GetKey();
                return KeyController::RegisterKey($key);
            }
            return array("type" => KeyType::FREE, "active" => true, "expired" => false, "verified" => true, "exceeded" => false);
        } catch (KeyException $k_ex) {
            throw $k_ex;
        } catch (Exception $ex) {
            LogController::HandleException($ex);
            return new \WP_Error('internal_error_plugin', 'Internal Plugin Error', array('status' => 500));
        }
    }

    public static function HasRegisteredKey()
    {
        $option_controller = new OptionController();
        return $option_controller->HasRegisteredKey();
    }

    public static function HasValidStandardKey()
    {
        $option_controller = new OptionController();
        $has_standard = $option_controller->HasStandardKey();
        $is_active = $option_controller->KeyIsActive();
        $is_verified = $option_controller->KeyIsVerified();
        $is_exceeded = $option_controller->KeyIsExceeded();
        return $has_standard && $is_active && $is_verified && !$is_exceeded;
    }

    public static function HasValidPremiumKey()
    {
        $option_controller = new OptionController();
        $has_premium = $option_controller->HasPremiumKey();
        $is_expired = $option_controller->KeyIsExpired();
        $is_active = $option_controller->KeyIsActive();
        $is_verified = $option_controller->KeyIsVerified();
        $is_exceeded = $option_controller->KeyIsExceeded();
        return $has_premium && !$is_expired && $is_active && $is_verified && !$is_exceeded;
    }

    public static function HasValidKey()
    {
        $option_controller = new OptionController();
        $has_key = $option_controller->HasRegisteredKey();
        if (!$has_key) {
            return false;
        }
        $is_expired = !$option_controller->HasStandardKey() && $option_controller->KeyIsExpired();
        $is_active = $option_controller->KeyIsActive();
        $is_verified = $option_controller->KeyIsVerified();
        $is_exceeded = $option_controller->KeyIsExceeded();
        return !$is_expired && $is_active && $is_verified && !$is_exceeded;
    }

    public static function GetKeyTypeLabel($keytype)
    {
        switch ($keytype) {
            case KeyType::PREMIUM:
                return __("Premium License", "superb-blocks");
            case KeyType::STANDARD:
                return __("Theme License", "superb-blocks");
            case KeyType::FREE_PLUS:
                return __("Free+ License", "superb-blocks");
            case KeyType::FREE:
            default:
                return __("Free License", "superb-blocks");
        }
    }

    public static function GetCurrentKeyTypeLabel()
    {
        $option_controller = new OptionController();

        if (!self::HasValidKey()) {
            return self::GetKeyTypeLabel(KeyType::FREE);
        }

        return self::GetKeyTypeLabel($option_controller->GetKeyType());
    }

    public static function VerificationFailed()
    {
        $option_controller = new OptionController();
        return $option_controller->SetKeyVerificationFailed();
    }

    public static function GetKeyStatus()
    {
        $option_controller = new OptionController();
        return array("type" => $option_controller->GetKeyType(), "active" => $option_controller->KeyIsActive(), "expired" => $option_controller->KeyIsExpired(), "verified" => $option_controller->KeyIsVerified(), "exceeded" => $option_controller->KeyIsExceeded());
    }

    public static function UpdateKeyType($keytype, $active, $expired, $exceeded)
    {
        $option_controller = new OptionController();
        switch ($keytype) {
            case KeyType::PREMIUM:
            case KeyType::STANDARD:
            case KeyType::FREE_PLUS:
                // Accepted key types
                break;
            default:
                $keytype = KeyType::FREE;
                break;
        }
        return $option_controller->UpdateKeyType($keytype, $active, $expired, $exceeded);
    }
}
