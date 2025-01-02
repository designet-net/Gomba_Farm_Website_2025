<?php

namespace SuperbAddons\Components\Buttons;

defined('ABSPATH') || exit();

use SuperbAddons\Components\Buttons\Button;
use SuperbAddons\Components\Buttons\ButtonIcon;
use SuperbAddons\Components\Buttons\ButtonType;

class InsertButton
{
    public function __construct()
    {
        new Button(
            ButtonType::Primary,
            ButtonIcon::Insert,
            array(
                'text' => __('Insert', "superb-blocks"),
                'class' => 'superb-addons-template-library-template-item-insert-btn superbaddons-element-button superbaddons-element-flex1 superbaddons-item-free-element',
            )
        );
    }
}
