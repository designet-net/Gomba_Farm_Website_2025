<?php

namespace SuperbAddons\Components\Badges;

defined('ABSPATH') || exit();

class AvailableBadge
{
    public function __construct()
    {
?>
        <div class="superbaddons-library-item-available-badge superbaddons-element-button superbaddons-element-flex1"><?= esc_html__("Available", "superb-blocks"); ?></div>
<?php
    }
}
