<?php

namespace SuperbAddons\Data\Controllers;

defined('ABSPATH') || exit();

class RestController
{
    const NAMESPACE = 'superbaddons';
    const TOKEN = 'SPBAV1iZV7b674&p7%8#v#Z';

    private static $Routes = array();

    public static function AddRoute($route, $args)
    {
        self::$Routes[] = array(
            "route" => $route,
            "args" => $args
        );
    }

    public static function RegisterRoutes()
    {
        add_action('rest_api_init', function () {
            foreach (self::$Routes as $Route) {
                register_rest_route(self::NAMESPACE, $Route['route'], $Route['args']);
            }
        });
    }

    public static function GetArgsHeadersArray($args = array())
    {
        $headers = array(
            'X-Superb-Auth' => 'Token ' . self::TOKEN
        );
        if (isset($args['headers']) && is_array($args['headers'])) {
            foreach ($args['headers'] as $key => $value) {
                $headers[$key] = $value;
            }
        }
        return array_merge($args, array(
            'timeout' => 60,
            'headers' => $headers
        ));
    }

    public static function IsAcceptableConnection($response)
    {
        if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
            if (!isset($response['headers']) || (isset($response['headers']['server']) && strpos($response['headers']['server'], 'imunify360') !== false)) {
                return false;
            }
            return true;
        }

        return false;
    }
}
