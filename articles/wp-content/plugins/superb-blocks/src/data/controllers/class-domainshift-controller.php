<?php

namespace SuperbAddons\Data\Controllers;

defined('ABSPATH') || exit();

use Exception;
use SuperbAddons\Config\Config;
use SuperbAddons\Data\Controllers\OptionController;
use SuperbAddons\Data\Utils\CacheTypes;

class DomainShiftController
{
    const STATUS_ENDPOINT = 'addons-status/status';

    public static function FindPreferredAPIDomain()
    {
        try {
            $options_controller = new OptionController();
            $idx = 0;
            $success = false;
            foreach (Config::API_DOMAINS as $available_domain) {
                $response = wp_remote_get($available_domain, array('method' => 'HEAD'));
                if (RestController::IsAcceptableConnection($response)) {
                    $success = $options_controller->UpdateAPIDomain($idx);
                    break;
                }
                $idx++;
            }

            return $success;
        } catch (Exception $ex) {
            LogController::HandleException($ex);
            return false;
        }
    }

    public static function GetCurrentConnectionSuccess()
    {
        $options_controller = new OptionController();
        $preferred_domain = $options_controller->GetPreferredDomain();
        $response = wp_remote_get($preferred_domain, array('method' => 'HEAD'));
        return RestController::IsAcceptableConnection($response);
    }

    public static function GetServiceStatus()
    {
        $response = self::RemoteGet(self::STATUS_ENDPOINT);
        ///
        $status_code = wp_remote_retrieve_response_code($response);

        if (!is_array($response) || is_wp_error($response) || $status_code !== 200) {
            if ($status_code === 401) {
                return array("online" => false, "message" => __("Unauthorized. Please make sure that you are using the latest version of this plugin.", "superb-blocks"));
            }
            return array("online" => false, "message" => __("Service Unavailable. Please contact our support team.", "superb-blocks"));
        }

        $data = json_decode($response['body']);
        if (!isset($data->elementor) || !isset($data->gutenberg)) {
            return array("online" => false, "message" => __("Service Data Unavailable. Please contact our support team.", "superb-blocks"));
        }


        return array("online" => true, CacheTypes::ELEMENTOR => $data->elementor, CacheTypes::GUTENBERG => $data->gutenberg);
    }

    public static function RemoteGet($path, $args = array())
    {
        return self::RemoteRequest('wp_remote_get', $path, $args);
    }

    public static function RemotePost($path, $args = array())
    {
        return self::RemoteRequest('wp_remote_get', $path, $args);
    }

    private static function RemoteRequest($method, $path, $args = array())
    {
        $options_controller = new OptionController();
        $preferred_domain = $options_controller->GetPreferredDomain();
        $response = $method($preferred_domain . $path, RestController::GetArgsHeadersArray($args));
        if (!RestController::IsAcceptableConnection($response)) {
            // Connection failed or blocked -> Find new preferred domain and send the request again. No recursion to avoid loop.
            if (self::FindPreferredAPIDomain()) {
                $preferred_domain = $options_controller->GetPreferredDomain(true);
                $response = $method($preferred_domain . $path, RestController::GetArgsHeadersArray($args));
            }
        }

        return $response;
    }

    public static function RemoteArgs($path)
    {
        $options_controller = new OptionController();
        $preferred_domain = $options_controller->GetPreferredDomain();
        return
            array(
                'url' => $preferred_domain . $path,
                'headers' => RestController::GetArgsHeadersArray()['headers'],
            );
    }
}
