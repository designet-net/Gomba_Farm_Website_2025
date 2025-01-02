<?php

namespace SuperbAddons\Admin\Controllers;

use SuperbAddons\Admin\Controllers\Wizard\WizardController;

defined('ABSPATH') || exit();

// 1.0

class AdminNoticeController
{
    const PREFIX = 'spbaddons_notice_';
    const PREFIX_DELAY = 'spbaddons_notice_delay_';

    const ALLOWED_HTML = [
        'div'     => [
            'class' => [],
            'style' => [],
        ],
        'p'      => [
            'class' => [],
        ],
        'h2'      => [
            'class' => [],
        ],
        'ul'      => [
            'class' => [],
        ],
        'li'      => [
            'class' => [],
        ],
        'span' => [
            'class' => [],
        ],
        'a'      => [
            'class' => [],
            'href' => [],
            'rel'  => [],
            'target' => [],
        ],
        'em'     => [
            'class' => [],
        ],
        'strong' => [
            'class' => [],
        ],
        'img' => [
            'class' => [],
            'alt' => [],
            'src' => [],
            'width' => [],
            'height' => [],
        ],
        'br'     => [],
        'style' => [],
    ];

    private static $notices = [];

    public static function init($options)
    {
        $notices = [];
        if (isset($options['notices']) && is_array($options['notices'])) {
            foreach ($options['notices'] as $notice) {
                if (!isset($notice['unique_id']) || !isset($notice['content'])) {
                    continue;
                }

                $notices[] = $notice;
            }
        }

        self::$notices = $notices;

        add_action('admin_notices', array(__CLASS__, 'AdminNotices'));
        add_action('wp_ajax_spbtic_dismiss_notice', array(__CLASS__, 'MaybeDismissNotice'));
    }

    public static function AdminNotices()
    {
        foreach (self::$notices as $notice) {
            $notice_path = trailingslashit(SUPERBADDONS_PLUGIN_DIR) . 'src/admin/notices/' . $notice['content'];
            if (!file_exists($notice_path)) {
                continue;
            }

            // Check if the notice has been dismissed.
            if (get_user_meta(get_current_user_id(), self::PREFIX . $notice['unique_id'], true)) {
                continue;
            }

            // Check if the notice is delayed
            if (isset($notice['delay'])) {
                $delay_init = get_user_meta(get_current_user_id(), self::PREFIX_DELAY . $notice['unique_id'], true);
                if (!$delay_init) {
                    update_user_meta(get_current_user_id(), self::PREFIX_DELAY . $notice['unique_id'], time());
                    continue;
                }

                $delay = strtotime($notice['delay'], $delay_init);
                if ($delay > time()) {
                    continue;
                }
            }

            ob_start();
            include_once $notice_path;
            $content = ob_get_clean();
            echo wp_kses($content, self::ALLOWED_HTML);
        }

        self::PrintScripts();
    }

    public static function PrintScripts()
    {
?>
        <script>
            window.addEventListener("load", function() {
                setTimeout(function() {
                    var notice_ids = <?php echo json_encode(array_column(self::$notices, 'unique_id')); ?>;
                    var nonce = "<?php echo esc_attr(wp_create_nonce('spbtic_dismiss_notice')); ?>";
                    var ajaxurl = "<?php echo esc_url(admin_url('admin-ajax.php')); ?>";

                    notice_ids.forEach(function(notice) {
                        var dismissBtn = document.querySelector(
                            "." + notice + " .notice-dismiss"
                        );

                        if (!dismissBtn) return;

                        // Add an event listener to the dismiss button.
                        dismissBtn.addEventListener("click", function(event) {
                            var httpRequest = new XMLHttpRequest(),
                                postData = "";

                            // Build the data to send in our request.
                            // Data has to be formatted as a string here.
                            postData += "id=" + notice;
                            postData += "&action=spbtic_dismiss_notice";
                            postData += "&nonce=" + nonce;

                            httpRequest.open("POST", ajaxurl);
                            httpRequest.setRequestHeader(
                                "Content-Type",
                                "application/x-www-form-urlencoded"
                            );
                            httpRequest.send(postData);
                        });
                    });
                }, 0);
            });
        </script>
<?php
    }

    public static function MaybeDismissNotice()
    {
        // Sanity check: Early exit if we're not on a spbtic_dismiss_notice action.
        if (!isset($_POST['action']) || 'spbtic_dismiss_notice' !== $_POST['action']) {
            return;
        }

        // Sanity check: Early exit if the ID of the notice does not exist.
        if (!isset($_POST['id']) || !in_array($_POST['id'], array_column(self::$notices, 'unique_id'))) {
            return;
        }

        // Notice ID exists in array, so we can safely use it.
        $notice_id = sanitize_text_field($_POST['id']);

        // Security check: Make sure nonce is OK. check_ajax_referer exits if it fails.
        check_ajax_referer('spbtic_dismiss_notice', 'nonce', true);

        // Dismiss the notice.
        self::DismissNotice($notice_id);
    }

    public static function DismissNotice($notice_id)
    {
        if ($notice_id == 'wizard_recommender') {
            WizardController::RemoveWizardRecommenderTransient();
        } elseif ($notice_id == 'wizard_woocommerce') {
            WizardController::RemoveWizardWooCommerceTransient();
        } else {
            update_user_meta(get_current_user_id(), self::PREFIX . $notice_id, true);
        }
    }

    public static function Cleanup()
    {
        foreach (self::$notices as $notice) {
            delete_metadata('user', 0, self::PREFIX . $notice['unique_id'], false, true);
            if (isset($notice['delay'])) {
                delete_metadata('user', 0, self::PREFIX_DELAY . $notice['unique_id'], false, true);
            }
        }
        WizardController::RemoveWizardRecommenderTransient();
        WizardController::RemoveWizardWooCommerceTransient();
    }
}
