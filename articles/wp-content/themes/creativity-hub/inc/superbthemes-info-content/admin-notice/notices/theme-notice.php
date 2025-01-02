<?php
defined('ABSPATH') || exit;
$theme_url = $notice['data']['theme_url'];
$theme_name = wp_get_theme()->name;
?>
<div class="notice notice-info is-dismissible <?php echo esc_attr($notice['unique_id']); ?>">
    <h2 class="notice-title"><?php echo esc_html(sprintf(__("Unlock All Features with %s Premium – Limited Time Offer", 'creativity-hub'), $theme_name)); ?></h2>
    <p>
        <?php echo esc_html__("Take advantage of the up to", 'creativity-hub'); ?> <span style='font-weight:bold;'><?php echo esc_html__("40% discount", 'creativity-hub'); ?></span> <?php echo esc_html(sprintf(__("and unlock all features with %s Premium.", 'creativity-hub'), $theme_name)); ?>
        <?php echo esc_html__("The discount is only available for a limited time.", 'creativity-hub'); ?>
    </p>
    <p>
        <a style='margin-bottom:15px;' class='button button-large button-secondary' target='_blank' href='<?php echo esc_url($theme_url); ?>'><?php echo esc_html__("Read More", 'creativity-hub'); ?></a> <a style='margin-bottom:15px;' class='button button-large button-primary' target='_blank' href='<?php echo esc_url($theme_url); ?>'><?php echo esc_html__("Upgrade Now", 'creativity-hub'); ?></a>
    </p>
</div>