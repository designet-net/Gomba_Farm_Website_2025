<?php

namespace SuperbAddons\Components\Badges;

defined('ABSPATH') || exit();

class UpdateRequiredBadge
{
    public function __construct()
    {
?>
        <div class="superbaddons-library-item-update-required-badge superbaddons-element-button superbaddons-element-flex1"><?= esc_html__("Plugin Update Required", "superb-blocks"); ?></div>
<?php
    }
}
