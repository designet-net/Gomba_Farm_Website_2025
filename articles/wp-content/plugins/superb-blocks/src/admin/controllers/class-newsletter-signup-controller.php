<?php

namespace SuperbAddons\Admin\Controllers;

use SuperbAddons\Config\Capabilities;
use SuperbAddons\Data\Controllers\DomainShiftController;

defined('ABSPATH') || exit();

class NewsletterSignupController
{
    const ID = 'superbaddons-newsletter-form';
    const ACTION = 'superbaddons_newsletter_form';
    const META_KEY = 'superbaddons_newsletter_subscribed';

    const NEWSLETTER_ENDPOINT = 'addons-status/newsletter/signup';

    public static function Initialize()
    {
        if (!is_admin()) {
            return;
        }
        add_action('wp_ajax_superbaddons_newsletter_form', array(__CLASS__, 'AjaxNewsletterSignupForm'));
    }

    public static function AjaxNewsletterSignupForm()
    {
        check_ajax_referer(NewsletterSignupController::ID, 'nonce');

        if (!current_user_can(Capabilities::CONTRIBUTOR)) {
            wp_send_json_error(array('message' => __("You do not have permission to perform this action.", "superb-blocks")));
        }

        $email = sanitize_email($_POST['email']);
        if (!is_email($email)) {
            wp_send_json_error(array('message' => __("Invalid email address.", "superb-blocks")));
        }

        $response = false;
        $response = DomainShiftController::RemotePost(
            self::NEWSLETTER_ENDPOINT,
            array(
                'headers' => array('Content-Type' => 'application/json'),
                'method' => 'POST',
                'body' => json_encode(
                    array(
                        'action' => 'signup_newsletter',
                        'email' => $email
                    )
                )
            )
        );

        if (!$response || is_wp_error($response)) {
            wp_send_json_error(array('message' => __("A connection error occurred. Please try again later.", "superb-blocks")));
        }

        $status_code = wp_remote_retrieve_response_code($response);

        if ($status_code !== 200) {
            wp_send_json_error(array('message' => __("Something went wrong during the signup process. Please try again later or contact support for assistance.", "superb-blocks")));
        }

        update_user_meta(get_current_user_id(), self::META_KEY, true);

        wp_send_json_success();
    }

    public static function Cleanup()
    {
        delete_metadata('user', 0, self::META_KEY, false, true);
    }
}
