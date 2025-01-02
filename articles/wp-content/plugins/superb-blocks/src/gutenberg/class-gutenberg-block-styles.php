<?php

namespace SuperbAddons\Gutenberg\Controllers;

defined('ABSPATH') || exit();

class GutenbergBlockStyles
{
    public static function Initialize()
    {
        add_action('init', [__CLASS__, 'RegisterBlockStyles']);
    }

    public static function RegisterBlockStyles()
    {
        if (!function_exists('register_block_style')) {
            return;
        }

        register_block_style(
            'core/group',
            [
                'name'       => 'superbaddons-card',
                'label'      => __('Card', 'superb-blocks'),
                'inline_style' => '.wp-block-group.is-style-superbaddons-card{background-color:var(--wp--preset--color--contrast-light);border-color:var(--wp--preset--color--mono-3);border-radius:10px;border-style:solid;border-width:1px;box-shadow:0 1px 2px 0 rgba(0,0,0,.05);color:var(--wp--preset--color--contrast-dark);padding:var(--wp--preset--spacing--superbspacing-small)}'
            ]
        );
    }
}
