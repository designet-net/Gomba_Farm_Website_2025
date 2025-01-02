<?php

namespace SuperbAddons\Data\Utils;

defined('ABSPATH') || exit();

class ScriptTranslations
{
    public static function Set($script_tag)
    {
        if (function_exists('wp_set_script_translations')) {
            wp_set_script_translations($script_tag, 'superb-blocks');
        }
    }
}
