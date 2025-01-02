<?php

namespace SuperbAddons\Library\Controllers;

defined('ABSPATH') || exit();

use Exception;
use WP_Error;
use WP_REST_Server;
use SuperbAddons\Config\Capabilities;
use SuperbAddons\Data\Controllers\CacheController;
use SuperbAddons\Data\Controllers\DomainShiftController;
use SuperbAddons\Data\Controllers\KeyController;
use SuperbAddons\Data\Controllers\OptionController;
use SuperbAddons\Data\Controllers\RestController;
use SuperbAddons\Data\Utils\CacheException;
use SuperbAddons\Data\Utils\CacheTypes;
use SuperbAddons\Data\Utils\ElementorCache;
use SuperbAddons\Data\Utils\GutenbergCache;
use SuperbAddons\Data\Utils\RequestException;
use SuperbAddons\Elementor\Controllers\ElementorController;
use SuperbAddons\Gutenberg\Controllers\GutenbergController;


class LibraryRequestController
{
    const ELEMENTOR_LIST_ROUTE = '/elementor-list';
    const ELEMENTOR_INSERT_ROUTE = '/elementor-insert';
    const GUTENBERG_LIST_ROUTE = '/gutenberg-list/';
    const GUTENBERG_INSERT_ROUTE = '/gutenberg-insert/';

    const GUTENBERG_ROUTE_TYPE_PATTERNS = 'patterns';
    const GUTENBERG_ROUTE_TYPE_PAGES = 'pages';

    const ELEMENTOR_ENDPOINT_BASE = 'elementor-library/';
    const GUTENBERG_ENDPOINT_BASE = 'gutenberg-library/';

    const PLUGIN_NAMES = array(
        'woocommerce/woocommerce.php' => 'WooCommerce',
    );

    public function __construct()
    {
        RestController::AddRoute(self::ELEMENTOR_LIST_ROUTE, array(
            'methods' => WP_REST_Server::READABLE,
            'permission_callback' => array($this, 'LibraryCallbackPermissionCheck'),
            'callback' => array($this, 'ElementorListCallback'),
        ));
        RestController::AddRoute(self::ELEMENTOR_INSERT_ROUTE, array(
            'methods' => WP_REST_Server::READABLE,
            'permission_callback' => array($this, 'LibraryCallbackPermissionCheck'),
            'callback' => array($this, 'ElementorInsertCallback'),
        ));
        RestController::AddRoute(self::GUTENBERG_LIST_ROUTE . '(?P<route_type>[\w]+)', array(
            'methods' => WP_REST_Server::READABLE,
            'permission_callback' => array($this, 'LibraryCallbackPermissionCheck'),
            'callback' => array($this, 'GutenbergListCallback'),
        ));
        RestController::AddRoute(self::GUTENBERG_INSERT_ROUTE . '(?P<route_type>[\w]+)', array(
            'methods' => WP_REST_Server::READABLE,
            'permission_callback' => array($this, 'LibraryCallbackPermissionCheck'),
            'callback' => array($this, 'GutenbergInsertCallback'),
        ));
    }

    public function LibraryCallbackPermissionCheck()
    {
        // Restrict endpoint to only users who have the proper capability.
        if (!current_user_can(Capabilities::CONTRIBUTOR)) {
            return new WP_Error('rest_forbidden', esc_html__('Unauthorized. Please check user permissions.', "superb-blocks"), array('status' => 401));
        }

        return true;
    }

    public function ElementorListCallback()
    {
        try {
            $section_cache = CacheController::GetCache(ElementorCache::SECTIONS, CacheTypes::ELEMENTOR);
            if (!!$section_cache) {
                // Local cache accepted
                $section_cache->premium = KeyController::HasValidPremiumKey();
                return rest_ensure_response($section_cache);
            }

            return $this->ListHandler(self::ELEMENTOR_ENDPOINT_BASE, 'sections', ElementorCache::SECTIONS);
        } catch (CacheException $cex) {
            return new \WP_Error('internal_error_cache', 'Internal Cache Error: ' .  esc_html($cex->getMessage()), array('status' => 500));
        } catch (Exception $ex) {
            LogController::HandleException($ex);
            return new \WP_Error('internal_error_plugin', 'Internal Plugin Error', array('status' => 500));
        }
    }

    public function GutenbergListCallback($request)
    {
        try {
            if (!isset($request['route_type'])) {
                return new \WP_Error('invalid_route_type', 'Invalid route type', array('status' => 400));
            }
            $route_type = $request['route_type'];
            $gutenberg_cache_option = self::GetGutenbergCacheOptionByRouteType($route_type);
            if (!$gutenberg_cache_option) {
                return new \WP_Error('invalid_route_type', 'Invalid route type', array('status' => 400));
            }

            $pattern_cache = CacheController::GetCache($gutenberg_cache_option, CacheTypes::GUTENBERG);
            if (!!$pattern_cache) {
                // Local cache accepted
                $pattern_cache->premium = KeyController::HasValidPremiumKey();
                $this->UpdatePatternRequirementStatus($pattern_cache);
                return rest_ensure_response($pattern_cache);
            }

            return $this->ListHandler(self::GUTENBERG_ENDPOINT_BASE, $route_type, $gutenberg_cache_option);
        } catch (CacheException $cex) {
            return new \WP_Error('internal_error_cache', 'Internal Cache Error: ' .  esc_html($cex->getMessage()), array('status' => 500));
        } catch (Exception $ex) {
            LogController::HandleException($ex);
            return new \WP_Error('internal_error_plugin', 'Internal Plugin Error', array('status' => 500));
        }
    }

    private function GetGutenbergCacheOptionByRouteType($route_type)
    {
        // Sanitize route type
        switch ($route_type) {
            case self::GUTENBERG_ROUTE_TYPE_PATTERNS:
                return GutenbergCache::PATTERNS;
            case self::GUTENBERG_ROUTE_TYPE_PAGES:
                return GutenbergCache::PAGES;
            default:
                return false;
        }
    }

    private function ListHandler($endpoint, $item_type, $cache_option)
    {
        // Fetch data cache from service
        $options_controller = new OptionController();
        $license_key = $options_controller->GetKey();

        $response = DomainShiftController::RemoteGet($endpoint . $item_type . '?action=list&key=' . $license_key);
        ///
        if (!is_array($response) || is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
            return new \WP_Error('service_unavailable', 'Plugin Service Unavailable', array('status' => 503));
        }
        ///
        $data = json_decode($response['body']);
        if (isset($data->code) && isset($data->data) && isset($data->message)) {
            $status = isset($data->data->status) ? $data->data->status : 500;
            return new \WP_Error($data->code, $data->message, array('status' => $status));
        }
        if (isset($data->level)) {
            KeyController::UpdateKeyType($data->level, $data->active, $data->expired, $data->exceeded);
        }

        // Sort items
        if (isset($data->items) && is_array($data->items) && !empty($data->items)) {
            usort($data->items, function ($a, $b) {
                if (!isset($a->title) || !isset($b->title)) {
                    return 0;
                }
                return strnatcmp($a->title, $b->title);
            });
        }

        // Cache data
        CacheController::SetCache($cache_option, $data);

        $this->UpdatePatternRequirementStatus($data);

        $data->premium = KeyController::HasValidPremiumKey();
        //
        return rest_ensure_response($data);
    }

    private function UpdatePatternRequirementStatus(&$data)
    {
        if (!function_exists('is_plugin_active')) {
            require_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }
        // Check plugin and library version requirements
        foreach ($data->items as $item) {
            $item->external_plugin_required = false;
            $item->plugin_update_required = false;
            if (isset($item->required_plugins)) {
                foreach ($item->required_plugins as $required_plugin) {
                    if (!is_plugin_active($required_plugin)) {
                        $item->external_plugin_required = true;
                        $item->required_plugin_names ??= array();
                        if (isset(self::PLUGIN_NAMES[$required_plugin])) {
                            $item->required_plugin_names[] = self::PLUGIN_NAMES[$required_plugin];
                        } else {
                            $item->required_plugin_names[] = esc_attr(explode('/', $required_plugin)[0]);
                        }
                    }
                }
            }
            if (isset($item->required_library_version) && version_compare($item->required_library_version, SUPERBADDONS_LIBRARY_VERSION, '>')) {
                $item->plugin_update_required = true;
            }
        }
    }

    public function ElementorInsertCallback($request)
    {
        return $this->InsertHandler($request, self::ELEMENTOR_ENDPOINT_BASE, 'sections');
    }

    public function GutenbergInsertCallback($request)
    {
        if (!isset($request['route_type'])) {
            return new \WP_Error('invalid_route_type', 'Invalid route type', array('status' => 400));
        }
        $route_type = $request['route_type'];
        $gutenberg_cache_option = self::GetGutenbergCacheOptionByRouteType($route_type);
        if (!$gutenberg_cache_option) {
            return new \WP_Error('invalid_route_type', 'Invalid route type', array('status' => 400));
        }

        return $this->InsertHandler($request, self::GUTENBERG_ENDPOINT_BASE, $route_type);
    }

    private function InsertHandler($request, $endpoint, $item_type)
    {
        try {
            //
            $data = self::GetInsertData($request, $endpoint, $item_type);

            if (isset($data['access_failed'])) {
                return rest_ensure_response($data);
            }

            switch ($endpoint) {
                case self::ELEMENTOR_ENDPOINT_BASE:
                    $data = ElementorController::ElementorDataImportAction($data);
                    return rest_ensure_response($data['content']);
                case self::GUTENBERG_ENDPOINT_BASE:
                    $data = GutenbergController::GutenbergDataImportAction($data);
                    return rest_ensure_response(["content" => $data['content'], "name" => esc_html(isset($data['title']) ? $data['title'] : '')]);
                default:
                    throw new Exception(__("Invalid endpoint specifier. Unable to import data.", "superb-blocks"));
            }

            return new \WP_Error('internal_error_plugin', 'Unexpected Internal Plugin Error', array('status' => 500));
        } catch (RequestException $rex) {
            return new \WP_Error('internal_error_request', 'Internal Request Error: ' .  esc_html($rex->getMessage()), array('status' => $rex->getCode()));
        } catch (Exception $ex) {
            LogController::HandleException($ex);
            return new \WP_Error('internal_error_plugin', 'Internal Plugin Error', array('status' => 500));
        }
    }

    public static function GetInsertData($request, $endpoint, $item_type)
    {
        $options_controller = new OptionController();
        $license_key = $options_controller->GetKey();
        if (!isset($request['id']) || !isset($request['package']) || $request['package'] === "premium" && !$license_key) {
            throw new RequestException("Forbidden", 403);
        }

        $stamp = $options_controller->GetStamp();
        $collection = $request['package'] === 'premium' ? "premium" : "free";
        $response = DomainShiftController::RemoteGet($endpoint . $item_type . '?action=insert&id=' . $request['id'] . '&collection=' . $collection . '&key=' . urlencode($license_key) . '&stamp=' . absint($stamp));
        ///
        if (!is_array($response) || is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
            throw new RequestException('Plugin Service Unavailable', 503);
        }
        ///
        $data = json_decode($response['body'], true);
        if (isset($data['code']) && isset($data['data']) && isset($data['message'])) {
            $status = isset($data['data']['status']) ? $data['data']['status'] : 500;
            throw new RequestException($data['message'], $status);
        }
        if (isset($data['level'])) {
            KeyController::UpdateKeyType($data['level'], $data['active'], $data['expired'], $data['exceeded']);
        }
        if (!isset($data['verified']) || !$data['verified']) {
            KeyController::VerificationFailed();
        }

        $data['premium'] = KeyController::HasValidPremiumKey();

        return $data;
    }
}
