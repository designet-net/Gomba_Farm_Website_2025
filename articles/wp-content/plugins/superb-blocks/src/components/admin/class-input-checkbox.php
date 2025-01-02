<?php

namespace SuperbAddons\Components\Admin;

defined('ABSPATH') || exit();

class InputCheckbox
{
    private $Id;
    private $Action;
    private $Title;
    private $Description;
    private $Checked;
    private $Icon;

    public function __construct($id, $action, $title, $description = false, $checked = false, $icon = false)
    {
        $this->Id = $id;
        $this->Action = $action;
        $this->Title = $title;
        $this->Description = $description;
        $this->Checked = $checked;
        $this->Icon = $icon;
        $this->Render();
    }

    private function Render()
    {
?>
        <div class="superb-addons-checkbox-input-wrapper">
            <label class="superbaddons-element-text-xs superbaddons-element-text-gray superbaddons-element-inlineflex-center superbaddons-element-relative">
                <input id="<?= esc_attr($this->Id); ?>" name="<?= esc_attr($this->Id); ?>" class="superbaddons-inputcheckbox-input" data-action="<?= esc_attr($this->Action); ?>" type="checkbox" <?= $this->Checked ? 'checked="checked"' : '' ?>>
                <span class="superb-addons-checkbox-checkmark"><img class="superbaddons-admindashboard-content-icon" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/checkmark.svg'); ?>" /></span>
                <span><?= esc_html($this->Title); ?></span>
                <?php if ($this->Icon) : ?>
                    <img class="superbaddons-admindashboard-checkbox-icon" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . $this->Icon); ?>" />
                <?php endif; ?>
            </label>
            <?php if ($this->Description) : ?>
                <p class="superbaddons-element-text-xxs superbaddons-element-text-gray"><?= esc_html($this->Description); ?></p>
            <?php endif; ?>
        </div>
<?php
    }
}
