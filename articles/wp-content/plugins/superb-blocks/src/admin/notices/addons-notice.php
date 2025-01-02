<?php
defined('ABSPATH') || exit;
?>
<div class="notice notice-info is-dismissible <?= esc_attr($notice['unique_id']); ?>">
    <h2 class="notice-title"><?= esc_html__("Unlock All Features with Superb Addons Premium – Limited Time Offer", "superb-blocks"); ?></h2>
    <p>
        <?= esc_html__("Take advantage of the up to", "superb-blocks"); ?> <span style='font-weight:bold;'><?= esc_html__("40% discount", "superb-blocks"); ?></span> <?= esc_html__("and unlock all features with Superb Addons Premium.", "superb-blocks"); ?>
        <?= esc_html__("The discount is only available for a limited time.", "superb-blocks"); ?>
    </p>
    <p>
        <a style='margin-bottom:15px;' class='button button-large button-secondary' target='_blank' href='https://superbthemes.com/superb-addons/'><?= esc_html__("Read More", "superb-blocks"); ?></a> <a style='margin-bottom:15px;' class='button button-large button-primary' target='_blank' href='https://superbthemes.com/pricing/superb-addons-pricing/'><?= esc_html__("Upgrade Now", "superb-blocks"); ?></a>
    </p>
</div>