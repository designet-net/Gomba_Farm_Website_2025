<?php

namespace SuperbAddons\Components\Admin;

defined('ABSPATH') || exit();

class PremiumFeatureList
{
    private $Features;

    public function __construct()
    {
        $this->Features = array(
            __("100+ WordPress Patterns", "superb-blocks"),
            __("50+ WordPress Themes", "superb-blocks"),
            __("50+ Unique Pages", "superb-blocks"),
            __("7+ WordPress Blocks", "superb-blocks"),
            __("40+ Animations", "superb-blocks"),
            __("1-Click Designs", "superb-blocks"),
            __("300+ Elementor Sections", "superb-blocks"),
            __("WordPress Editor Enhancements", "superb-blocks"),
            __("Advanced Custom CSS", "superb-blocks"),
            __("Ever-expanding Library", "superb-blocks")
        );
        $this->Render();
    }

    private function Render()
    {
?>
        <ul class="superbaddons-admindashboard-feature-list">
            <?php foreach ($this->Features as $feature) : ?>
                <li class="superbaddons-element-text-xs superbaddons-element-text-gray"><img class="superbaddons-admindashboard-feature-list-checkmark" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/checkmark.svg'); ?>" /><?= esc_html($feature); ?></li>
            <?php endforeach; ?>
        </ul>
<?php
    }
}
