<?php

use SuperbAddons\Admin\Controllers\Wizard\WizardController;
use SuperbAddons\Data\Utils\Wizard\WizardActionParameter;

defined('ABSPATH') || exit;

$url = WizardController::GetWizardURL(WizardActionParameter::WOOCOMMERCE_HEADER);
?>
<div class="notice notice-info superb-addons-wizard-notification is-dismissible <?= esc_attr($notice['unique_id']); ?>">
    <div class="superbthemes-module-purple-badge"><?= esc_html__("Superb Addons", "superb-blocks"); ?></div>
    <br>
    <h2 class="notice-title"><?= esc_html__("Add a WooCommerce Header", "superb-blocks"); ?> </h2>
    <p><?= esc_html__("We've noticed that you're using WooCommerce! Improve your store by adding a WooCommerce header with a visible 'Cart' button and other helpful features for your customers.", "superb-blocks"); ?></p>

    <a class='button button-large button-secondary' href='<?= esc_url($url); ?>'><?= esc_html__("Add WooCommerce Header", "superb-blocks"); ?></a>

    <style>
        .superb-addons-wizard-notification {
            background-repeat: no-repeat !important;
            background-position: bottom right !important;
            background-size: 530px !important;
            padding: 30px !important;
        }

        .superb-addons-wizard-notification h2 {
            font-size: 36px !important;
            line-height: 125% !important;
            margin: 0 !important;
        }

        .superb-addons-wizard-notification p {
            color: #546E7A !important;
            font-size: 17px !important;
            margin: 15px 0 25px !important;
            max-width: 550px !important;
        }

        .superbthemes-module-purple-badge {
            color: #6448E7 !important;
            padding: 12px 15px !important;
            background: #EDE7F6 !important;
            border-radius: 30px !important;
            margin-bottom: 10px !important;
            font-weight: 500 !important;
            display: inline-block !important;
            font-size: 13px !important;
            line-height: 1 !important;
        }

        @media only screen and (max-width: 1280px) {
            .superb-addons-wizard-notification p {
                max-width: 430px !important;
            }
        }

        @media only screen and (max-width: 1160px) {
            .superb-addons-wizard-notification {
                background-position: bottom -10px right -210px !important;
            }
        }

        @media only screen and (max-width: 960px) {
            .superb-addons-wizard-notification {
                background-image: none !important;
            }

            .superb-addons-wizard-notification p {
                max-width: 100% !important;
            }

            .superb-addons-wizard-notification h2 br {
                display: none !important;
            }
        }

        @media only screen and (max-width: 800px) {
            .superb-addons-wizard-notification p {
                font-size: 15px !important;
            }

            .superb-addons-wizard-notification h2 {
                font-size: 28px !important;
            }
        }
    </style>
</div>