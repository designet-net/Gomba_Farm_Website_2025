<?php

namespace SuperbAddons\Components\Buttons;

defined('ABSPATH') || exit();

use SuperbAddons\Components\Buttons\Button;
use SuperbAddons\Components\Buttons\ButtonIcon;
use SuperbAddons\Components\Buttons\ButtonType;

class PreviewButton
{
    public function __construct($preview_text = false, $target = false)
    {
        new Button(
            ButtonType::Secondary,
            ButtonIcon::Preview,
            array(
                'class' => 'superb-addons-template-library-template-item-preview-btn superbaddons-element-button',
                'text' => $preview_text,
                'target' => $target
            )
        );
    }
}
