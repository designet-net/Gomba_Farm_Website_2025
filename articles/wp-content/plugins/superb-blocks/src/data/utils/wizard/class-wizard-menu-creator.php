<?php

namespace SuperbAddons\Data\Utils\Wizard;

use WP_Post;

defined('ABSPATH') || exit();

class WizardMenuCreator
{
    public static function MaybeUpdateMenu($selection_data, $menu_items)
    {
        if (!isset($selection_data[WizardStageTypes::NAVIGATION_MENU_STAGE])) {
            return;
        }

        $navigation_selections = $selection_data[WizardStageTypes::NAVIGATION_MENU_STAGE];
        if (self::ShouldSkipMenu($navigation_selections)) {
            return;
        }

        // Create navigation menu content
        $menu_content = self::CreateMenuContent($menu_items);
        $navigation_process = $navigation_selections[0]['slug'];

        if ($navigation_process === WizardNavigationMenuOptions::CREATE_NEW_MENU) {
            $menu_post_id = self::CreateOrUpdateMenu($menu_content);
        } else if ($navigation_process === WizardNavigationMenuOptions::APPEND_EXISTING_MENU) {
            $menu_post_id = self::AppendToExistingMenu($menu_content);
        }

        // Update the known navigation template part with the new navigation menu id.
        self::UpdateNavigationTemplatePart($menu_post_id, 'header');
    }

    private static function ShouldSkipMenu($navigation_selections)
    {
        return empty($navigation_selections) || !isset($navigation_selections[0]['slug']) || $navigation_selections[0]['slug'] === WizardNavigationMenuOptions::SKIP_MENU;
    }

    private static function CreateMenuContent($menu_items)
    {
        $menu_content = '';
        foreach ($menu_items as $menu_item) {
            $menu_content .= self::CreateMenuItem($menu_item);
        }
        return $menu_content;
    }

    private static function CreateMenuItem($menu_item)
    {
        if ($menu_item['id'] === 0) {
            return "<!-- wp:home-link {\"label\":\"{$menu_item['title']}\"} /-->";
        }
        return "<!-- wp:navigation-link {\"label\":\"{$menu_item['title']}\",\"type\":\"page\",\"id\":{$menu_item['id']},\"url\":\"{$menu_item['url']}\",\"kind\":\"post-type\",\"isTopLevelLink\":true} /-->";
    }

    private static function CreateOrUpdateMenu($menu_content)
    {
        $menu_post_id = self::GetWizardNavigationPostID();
        if ($menu_post_id) {
            $menu_post_id = self::UpdateExistingMenuPost($menu_post_id, $menu_content);
        }

        if (!$menu_post_id) {
            $menu_post_id = self::CreateNewMenuPost($menu_content);
            self::SetWizardNavigationPostID($menu_post_id);
        }

        return $menu_post_id;
    }

    private static function UpdateExistingMenuPost($menu_post_id, $menu_content, $append = false)
    {
        $menu_post = get_post($menu_post_id);
        if (!$menu_post instanceof WP_Post || $menu_post->post_type !== WizardItemTypes::WP_NAVIGATION) {
            return false;
        }

        if ($append) {
            $menu_content = $menu_post->post_content . $menu_content;
        }
        WizardCreationUtil::UpdateTemplatePost($menu_post_id, $menu_content);

        return $menu_post_id;
    }

    private static function CreateNewMenuPost($menu_content)
    {
        return wp_insert_post(
            array(
                'post_title' => esc_html__("Navigation - Superb Addons - Theme Designer", "superb-blocks"),
                'post_content' => $menu_content,
                'post_status' => 'publish',
                'post_type' => WizardItemTypes::WP_NAVIGATION,
                'comment_status' => 'closed',
                'ping_status' => 'closed'
            )
        );
    }

    private static function AppendToExistingMenu($menu_content)
    {
        $menu_post_id = WizardCreationUtil::GetNavigationTemplatePartMenuId('header');
        if (!$menu_post_id) {
            return false;
        }

        self::UpdateExistingMenuPost($menu_post_id, $menu_content, true);
        return $menu_post_id;
    }

    private static function SetWizardNavigationPostID($post_id)
    {
        return update_option('superbaddons_wizard_navigation_post_id', $post_id, false);
    }

    private static function GetWizardNavigationPostID()
    {
        return get_option('superbaddons_wizard_navigation_post_id', false);
    }

    private static function UpdateNavigationTemplatePart($navigation_id, $template_part_slug = 'header')
    {
        $template_data = WizardCreationUtil::GetNavigationTemplateData($template_part_slug);
        if (!$template_data) {
            return;
        }

        $new_content = WizardCreationUtil::UpdateNavigationBlockContentRefAndRemoveInnerLinks($template_data['content'], $navigation_id);

        // If the template part has a post id, custom changes were made to the template part. 
        if (isset($template_data['post_id']) && $template_data['post_id'] > 0) {
            // Update the template part post.
            WizardCreationUtil::UpdateTemplatePost($template_data['post_id'], $new_content);
            return;
        }


        // No post id, create a new template part post with the change.
        WizardCreationUtil::CreateNewTemplatePartPost($template_part_slug, $new_content);
    }
}
