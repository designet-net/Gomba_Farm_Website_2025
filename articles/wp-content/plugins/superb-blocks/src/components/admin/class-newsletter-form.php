<?php

namespace SuperbAddons\Components\Admin;

use SuperbAddons\Admin\Controllers\NewsletterSignupController;

defined('ABSPATH') || exit();

class NewsletterForm
{
    public function __construct($title = false, $show_testominal_text = false)
    {
        $user_did_subcribe = get_user_meta(get_current_user_id(), 'superbaddons_newsletter_subscribed', true);
        if ($user_did_subcribe) {
            return;
        }

        wp_enqueue_script(NewsletterSignupController::ID, SUPERBADDONS_ASSETS_PATH . '/js/admin/newsletter-form.js', array('jquery'), SUPERBADDONS_VERSION, true);
        wp_localize_script(NewsletterSignupController::ID, NewsletterSignupController::ACTION, array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce(NewsletterSignupController::ID),
            'action' => NewsletterSignupController::ACTION,
            'default_error_message' => __("An unknown error occurred. Please try again later.", "superb-blocks"),
        ));

        if (!$title) {
            $title = __("Sign up for our newsletter!", "superb-blocks");
        }

        $this->Render($title, $show_testominal_text);
    }

    private function Render($title, $show_testominal_text)
    {
?>
        <div class="superbthemes-module-newsletter">
            <h3><?= esc_html($title); ?></h3>
            <form id="<?= esc_attr(NewsletterSignupController::ID); ?>">
                <input name="email" type="email" placeholder="<?= esc_attr__("Your email address...", "superb-blocks"); ?>" required>
                <button class="superbaddons-newsletter-submit-button" type="submit">
                    <span id="superbaddons-newsletter-submit-text"><?= esc_html__("Subscribe", "superb-blocks"); ?></span>
                    <img id="superbaddons-newsletter-submit-spinner" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . "/img/blocks-spinner.svg"); ?>" width="24" height="24" alt="Loading..." style="display:none;">
                </button>
            </form>
            <div id="superbaddons-newsletter-success" style="display:none;">
                <p class="superbaddons-element-text-xs"><?= esc_html__("Thank you for subscribing! Stay tuned for updates, freebies, and more.", "superb-blocks"); ?></p>
            </div>
            <div id="superbaddons-newsletter-error" style="display:none;"></div>
        </div>
        <div class="superbthemes-module-testimonials">
            <?php if ($show_testominal_text) : ?>
                <h3><?= esc_html__("Trusted by users worldwide", "superb-blocks"); ?></h3>
            <?php endif; ?>
            <img aria-hidden="true" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . "/img/testimonials.svg"); ?>" width="287" height="37" alt="Testimonials">
        </div>
<?php
    }
}
