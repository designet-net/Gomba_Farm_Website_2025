<?php

namespace SuperbAddons\Data\Utils;

defined('ABSPATH') || exit();

require_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
class QuietSkin extends \WP_Upgrader_Skin
{
    public function feedback($string, ...$args)
    {
        // no feedback
    }

    public function header()
    {
        // nothing
    }

    public function footer()
    {
        // nothing
    }

    public function error($errors)
    {
        // nothing
    }
}
