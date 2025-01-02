<?php

namespace SuperbAddons\Components\Slots;

defined('ABSPATH') || exit();

class PremiumOptionWrapper
{
    public function __construct($contentCallback, $classes = array(), $allow_pointer_events = false)
    {
        $this->Render($contentCallback, $classes, $allow_pointer_events);
    }

    private function Render($contentCallback, $classes, $allow_pointer_events)
    {
?>
        <div class="superbaddons-element-inlineflex-center <?= esc_attr(join(" ", $classes)); ?>">
            <a href="https://superbthemes.com/superb-addons" target="_blank" class="superbaddons-premium-only-option-wrapper" title="<?= esc_attr__("Premium Feature", "superb-blocks"); ?>">
                <div class="superbaddons-premium-only-option">
                    <div class="superbaddons-premium-only-option-icon">
                        <img width="16" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/color-crown.svg'); ?>" />
                        <span><?= esc_html__("Premium", "superb-blocks"); ?></span>
                    </div>

                </div>
                <div style="<?= $allow_pointer_events ? '' : 'pointer-events: none;'; ?> opacity:0.5;">
                    <?php SlotRenderUtility::Render($contentCallback); ?>
                </div>
            </a>
        </div>
<?php
    }
}
