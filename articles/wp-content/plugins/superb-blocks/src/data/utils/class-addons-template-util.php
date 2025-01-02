<?php

namespace SuperbAddons\Data\Utils\Wizard;

use WP_Block_Template;

defined('ABSPATH') || exit();

class AddonsPageTemplateUtil
{
    const TEMPLATE_ID = 'superbaddons-page-template';
    const PLUGIN_SLUG = 'superb-blocks/plugin';

    public static function GetAddonsPageBlockTemplateObject()
    {
        $template_content = false;
        $template_source  = "plugin";

        $template                 = new WP_Block_Template();
        $template->type           = WizardItemTypes::WP_TEMPLATE;
        $template->theme          = self::PLUGIN_SLUG;
        $template->slug           = self::TEMPLATE_ID;
        $template->id             = self::PLUGIN_SLUG . '//' . self::TEMPLATE_ID;
        $template->title          = __("Superb Addons Template Page", "superb-blocks");
        $template->description    = __("This is a basic full width page template that includes a header and footer. This template is used when creating template pages in Superb Addons.", "superb-blocks");
        $template->origin         = 'plugin';
        $template->status         = 'publish';
        $template->has_theme_file = true;
        $template->is_custom      = true;
        $template->post_types     = ['page'];

        // Get the saved custom template from the database if it exists.
        $custom_template_query_args = array(
            'post_type'      => WizardItemTypes::WP_TEMPLATE,
            'posts_per_page' => 1,
            'name'           => self::TEMPLATE_ID,
            'no_found_rows'  => true,
            'tax_query'      => array(
                array(
                    'taxonomy' => 'wp_theme',
                    'field'    => 'name',
                    'terms'    => array(self::PLUGIN_SLUG, get_stylesheet()),
                ),
            ),
        );

        $custom_template_query   = new \WP_Query($custom_template_query_args);
        $custom_superb_templates = $custom_template_query->posts;

        if ($custom_superb_templates && !empty($custom_superb_templates)) {
            $template_content = $custom_superb_templates[0]->post_content;
            $template_source = "custom";
        } else {
            $page_content = '<!-- wp:post-content {"align":"full","layout":{"type":"default"},"lock":{"move":true,"remove":true}} /-->';
            $template_content = self::GetAddonsPageTemplateContent($page_content);
        }

        $template->source         = $template_source;
        $template->content        = $template_content;

        return $template;
    }

    public static function GetAddonsPageTemplateContent($page_content)
    {
        ob_start();
?>
        <!-- wp:template-part {"slug":"header","lock":{"move":true,"remove":true}} /-->

        <!-- wp:group {"tagName":"main","lock":{"move":true,"remove":true},"style":{"spacing":{"margin":{"top":"0rem"},"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"blockGap":"var:preset|spacing|superbspacing-medium"}},"layout":{"type":"default"}} -->
        <main class="wp-block-group" style="margin-top:0rem;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0">
            <?= $page_content ?>
        </main>
        <!-- /wp:group -->

        <!-- wp:template-part {"slug":"footer","lock":{"move":true,"remove":true}} /-->
<?php
        return ob_get_clean();
    }
}
