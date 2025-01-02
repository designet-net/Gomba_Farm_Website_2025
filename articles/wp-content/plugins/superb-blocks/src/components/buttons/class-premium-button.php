<?php

namespace SuperbAddons\Components\Buttons;

defined('ABSPATH') || exit();

use SuperbAddons\Components\Buttons\Button;
use SuperbAddons\Components\Buttons\ButtonIcon;
use SuperbAddons\Components\Buttons\ButtonType;

class PremiumButton
{
    public function __construct($url = "https://superbthemes.com/superb-addons/", $target = "_blank")
    {
        new Button(
            ButtonType::Primary,
            ButtonIcon::ExternalLink,
            array(
                'text' => __('Get Premium', "superb-blocks"),
                'url' => esc_url($url),
                'class' => 'superb-addons-template-library-template-item-premium-btn superbaddons-element-button-pro superbaddons-element-flex1 superbaddons-item-premium-element',
                'target' => $target
            )
        );
    }
}
