<?php

namespace SuperbAddons\Components\Admin;

defined('ABSPATH') || exit();

use SuperbAddons\Components\Admin\LinkBox;
use SuperbAddons\Data\Controllers\KeyController;

class SupportLinkBoxes
{
    public function __construct()
    {
        new LinkBox(
            array(
                "icon" => "purple-help.svg",
                "title" => __("Customer support", "superb-blocks"),
                "description" => __("We prioritize top-notch support to our customers. If you have any questions or need assistance with our plugin, don't hesitate to reach out. ", "superb-blocks"),
                "cta" => __("Contact support", "superb-blocks"),
                "link" => "https://superbthemes.com/customer-support/",
            )
        );
        if (KeyController::HasValidPremiumKey()) {
            new LinkBox(
                array(
                    "icon" => "purple-crown.svg",
                    "title" => __("Thank you!", "superb-blocks"),
                    "description" => __("We want to extend a heartfelt thank you for choosing to support Superb Addons. Your decision plays a significant role in helping us grow and improve. We're committed to providing you with the best experience possible and are excited to have you on board. If you ever have any questions or suggestions, feel free to reach out!", "superb-blocks"),
                    "pro" => true
                )
            );
        } else {
            new LinkBox(
                array(
                    "icon" => "purple-chat.svg",
                    "title" => __("Premium support", "superb-blocks"),
                    "description" => __("Unlock expert assistance for any question through our premium support package. Enjoy one-on-one help from the creators of Superb Addons.", "superb-blocks"),
                    "cta" => __("Get Premium Support", "superb-blocks"),
                    "link" => "https://superbthemes.com/extended-premium-support/",
                    "pro" => true,
                )
            );
        }
    }
}
