<?php

namespace SuperbAddons\Components\Slots;

defined('ABSPATH') || exit();

use SuperbAddons\Data\Controllers\KeyController;

class PremiumSlot
{
    protected static $RenderFill;

    public function __construct()
    {
        if (KeyController::HasValidPremiumKey() && static::$RenderFill) {
            SlotRenderUtility::Render(static::$RenderFill);
            return;
        }
        $this->RenderSlot();
    }

    protected function RenderSlot()
    {
        echo "<!-- Premium Slot -->";
    }

    public static function SetRenderFill($renderFill)
    {
        static::$RenderFill = $renderFill;
    }
}
