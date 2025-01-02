<?php

namespace SuperbAddons\Components\Slots;

defined('ABSPATH') || exit();

use SuperbAddons\Components\Admin\InputCheckbox;

class CssBlocksTargetSlot extends PremiumSlot
{
    protected static $RenderFill;
    protected function RenderSlot()
    {
        new PremiumOptionWrapper(function () {
            new InputCheckbox("superbaddons-css-block-target-input-blogpage", "blogpage-action", __("Blog page", "superb-blocks"), __("Applies CSS block to the blog page.", "superb-blocks"));
        });

        new PremiumOptionWrapper(function () {
            new InputCheckbox("superbaddons-css-block-target-input-pages", "specific-page-action", __("Pages", "superb-blocks"), __("Applies CSS block to one or more selected pages. Applies to all pages if none is selected.", "superb-blocks"));
        });

        new PremiumOptionWrapper(function () {
            new InputCheckbox("superbaddons-css-block-target-input-posts", "specific-post-action", __("Posts", "superb-blocks"), __("Applies CSS block to one or more selected posts. Applies to all posts if none is selected.", "superb-blocks"));
        });

        new PremiumOptionWrapper(function () {
            new InputCheckbox("superbaddons-css-block-target-input-blogpage", "archive-action", __("Archives", "superb-blocks"), __("Applies CSS block to archive pages including category, tag, author, date, custom post type, and custom taxonomy based archives.", "superb-blocks"));
        });

        new PremiumOptionWrapper(function () {
            new InputCheckbox("superbaddons-css-block-target-input-templates", "specific-template-action", __("Templates", "superb-blocks"), __("Applies CSS block to one or more selected page templates. Applies to all page templates if none is selected.", "superb-blocks"));
        });
    }
}
