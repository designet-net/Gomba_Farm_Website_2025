<?php

namespace SuperbAddons\Components\Slots;

defined('ABSPATH') || exit();

class SlotRenderUtility
{
    private static $AllowedHTML = array(
        'div' => array(
            'data-type' => true,
            'class' => array(),
            'id' => array(),
            'style' => array(),
        ),
        'select' => array(
            'class' => array(),
            'id' => array(),
            'name' => array(),
            'placeholder' => array(),
            'multiple' => array(),
            'style' => array(),
        ),
        'option' => array(
            'value' => array(),
            'selected' => array(),
        ),
        'input' => array(
            'class' => array(),
            'id' => array(),
            'name' => array(),
            'type' => array(),
            'value' => array(),
            'checked' => array(),
            'style' => array(),
            'data-action' => true,
        ),
        'iframe' => array(
            'class' => array(),
            'src' => array(),
            'loading' => array(),
            'data-src' => true,
            'data-noreload' => true,
            'data-status' => true,
            'data-id' => true,
        )
    );

    public static function Render($contentCallback)
    {
        add_filter('safe_style_css', function ($styles) {
            if (!in_array('display', $styles)) {
                $styles[] = 'display';
            }

            return $styles;
        });
        ob_start();
        ($contentCallback)();
        $content = ob_get_clean();
        echo wp_kses(
            $content,
            array_merge(
                wp_kses_allowed_html('post'),
                self::$AllowedHTML
            )
        );
    }
}
