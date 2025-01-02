<?php

namespace SuperbAddons\Data\Utils\Wizard;

use SuperbAddons\Admin\Controllers\Wizard\WizardRestorationPointController;
use SuperbAddons\Gutenberg\Controllers\GutenbergController;
use SuperbAddons\Library\Controllers\LibraryRequestController;
use WP_Error;

defined('ABSPATH') || exit();

class WizardPageCreator
{
    public static function CreateTemplatePages($selection_data, $wizardData)
    {
        $theme_templates = get_block_templates();
        if (empty($theme_templates) || empty(array_column($theme_templates, 'slug'))) {
            return rest_ensure_response(['success' => false, 'text' => esc_html__("Theme templates could not be loaded.", "superb-blocks")]);
        }
        $theme_template_slugs = array_column($theme_templates, 'slug');

        $page_stages = self::GetPageStages($wizardData);

        if (empty($page_stages)) {
            throw new WizardException(__('Something went wrong. No page stages found in selections.', 'superb-blocks'));
        }

        $menu_items = self::CreateAndGetPageMenuItems(
            $page_stages,
            $selection_data,
            $theme_template_slugs
        );

        return $menu_items;
    }

    private static function GetPageStages($wizardData)
    {
        $page_stages = [];

        foreach ($wizardData->GetStages() as $stage_type) {
            if (in_array($stage_type, WizardStageTypes::PAGE_STAGES)) {
                $page_stages[] = $stage_type;
            }
        }

        return $page_stages;
    }

    private static function CreateAndGetPageMenuItems($stage_types, $selections, $available_templates)
    {
        $menu_items = array();
        foreach ($stage_types as $stage_type) {
            if (!isset($selections[$stage_type]) || empty($selections[$stage_type])) {
                continue;
            }
            $created_menu_items = self::HandlePageCreation($stage_type, $selections[$stage_type], $available_templates);
            $menu_items = array_merge($menu_items, $created_menu_items);
        }

        return $menu_items;
    }

    private static function HandlePageCreation($type, $selections, $available_templates)
    {
        switch ($type) {
            case WizardStageTypes::FRONT_PAGE_STAGE:
                return self::HandleFrontPageCreation($selections[0], $available_templates);
            case WizardStageTypes::BLOG_PAGE_STAGE:
                return self::HandleBlogPageCreation($selections[0], $available_templates);
            case WizardStageTypes::TEMPLATE_PAGE_STAGE:
                return self::HandleTemplatePageCreation($selections, $available_templates);
            default:
                return [];
        }
    }

    private static function HandleFrontPageCreation($selection, $available_templates)
    {
        $datatype = $selection['type'];
        // Set basic page type for creation.
        $selection['type'] = $datatype === WizardItemTypes::PAGE ? WizardItemTypes::PAGE : WizardItemTypes::WP_TEMPLATE;

        if (!boolval($selection['isChanged'])) {
            return [self::GetMenuItemArr(0, $selection)];
        }

        if ($datatype === 'front-page' && self::HasStaticFrontPage()) {
            return [self::GetMenuItemArr(0, $selection)];
        }

        if ($datatype === 'static') {
            return [self::GetMenuItemArr(0, $selection)];
        }

        if ($datatype === 'blog') {
            update_option('show_on_front', 'posts');
            return [self::GetMenuItemArr(0, $selection)];
        }

        $created_page_id = self::CreateTemplatePage($selection, $available_templates, 'front-page');
        if (!$created_page_id) return [];

        update_option('show_on_front', 'page');
        update_option('page_on_front', $created_page_id);
        return [self::GetMenuItemArr(0, $selection)];
    }

    private static function HasStaticFrontPage()
    {
        return get_option('show_on_front') === 'page' && get_option('page_on_front');
    }

    private static function HandleBlogPageCreation($selection, $available_templates)
    {
        $datatype = $selection['type'];
        // Set basic page type for creation.
        $selection['type'] = $selection['type'] === WizardItemTypes::PAGE ? WizardItemTypes::PAGE : WizardItemTypes::WP_TEMPLATE;

        if (!boolval($selection['isChanged']) || $datatype === 'static') {
            $blog_page_id = get_option('page_for_posts');
            if ($blog_page_id) {
                return [self::GetMenuItemArr($blog_page_id, $selection)];
            }
        }

        $created_page_id = self::CreateTemplatePage($selection, $available_templates, 'blog');
        if (!$created_page_id) return [];

        update_option('page_for_posts', $created_page_id);
        return [self::GetMenuItemArr($created_page_id, $selection)];
    }

    private static function HandleTemplatePageCreation($selections, $available_templates)
    {
        $menu_items = array();
        foreach ($selections as $selection) {
            $created_page_id = self::CreateTemplatePage($selection, $available_templates, 'page');
            if (!$created_page_id) {
                continue;
            }
            $menu_items[] = self::GetMenuItemArr($created_page_id, $selection);
        }
        return $menu_items;
    }

    private static function CreateTemplatePage($selection, $available_templates, $page_type)
    {
        $template_content = false;
        $template_slug = false;

        if ($selection['type'] === WizardItemTypes::WP_TEMPLATE) {
            list($template_content, $template_slug) = self::GetWPTemplateDataAndSlug($selection, $available_templates);
        } elseif ($selection['type'] === WizardItemTypes::PAGE) {
            list($template_content, $template_slug) = self::GetAddonsTemplateDataAndSlug($selection);
        }

        if (empty($template_content) || empty($template_slug)) {
            return false;
        }
        if ($page_type === 'front-page') {
            return self::HandleFrontPageTemplate($selection, $template_content, $template_slug, $selection['type'] === WizardItemTypes::PAGE);
        }
        if ($page_type === 'blog') {
            return self::HandleBlogPageTemplate($selection, $template_content, $template_slug, $selection['type'] === WizardItemTypes::PAGE);
        }

        return self::InsertPage($selection, $template_content, $template_slug);
    }


    private static function GetWPTemplateDataAndSlug($selection, $available_templates)
    {
        $template_content = false;
        $template_slug = false;

        $is_restoration_point = WizardCreationUtil::IsRestorationPoint($selection['slug'], $selection['type'], WizardItemTypes::WP_TEMPLATE);
        $is_file_template = WizardCreationUtil::IsFileTemplate($selection['slug'], $selection['type'], WizardItemTypes::WP_TEMPLATE);
        $is_theme_template_page = $selection['slug'] !== "front-page" && $selection['slug'] !== "home" && $selection['slug'] !== "index";
        if ($is_theme_template_page) {
            if (!in_array($selection['slug'], $available_templates)) {
                return [false, false];
            }

            $template_slug = $selection['slug'];
            $template_content = '<!-- wp:paragraph -->
            <p>' . esc_html__("This is a theme template page created by Superb Addons. You can edit this page's content and its template. If the blocks you want to edit can't be found in the page content, please edit the selected template.", "superb-blocks") . '</p>
            <!-- /wp:paragraph -->';
        } else if ($is_file_template) {
            $template_slug = $selection['slug'];
            $file_template = get_block_file_template(get_stylesheet() . '//' . $template_slug, WizardItemTypes::WP_TEMPLATE);
            if (!$file_template) {
                return [false, false];
            }
            $template_content = $file_template->content;
        } else if ($is_restoration_point) {
            $template_slug = $selection['slug'];
            $restoration_point = WizardRestorationPointController::GetTemplateRestorationPoint($template_slug, WizardItemTypes::WP_TEMPLATE);
            if (!$restoration_point) {
                return [false, false];
            }
            $template_content = $restoration_point['content'];
        } else {
            $template_slug = $selection['slug'];
            $block_template = get_block_template(get_stylesheet() . '//' . $template_slug, WizardItemTypes::WP_TEMPLATE);
            if (!$block_template) {
                return [false, false];
            }
            $template_content = $block_template->content;
        }

        return [$template_content, $template_slug];
    }

    private static function GetAddonsTemplateDataAndSlug($selection)
    {
        $data = LibraryRequestController::GetInsertData(
            [
                'id' => $selection['slug'],
                'package' => $selection['package'],
            ],
            LibraryRequestController::GUTENBERG_ENDPOINT_BASE,
            LibraryRequestController::GUTENBERG_ROUTE_TYPE_PAGES
        );
        if (!$data || !isset($data['content']) || isset($data['access_failed'])) {
            return [false, false];
        }

        $data = GutenbergController::GutenbergDataImportAction($data);

        $template_slug = AddonsPageTemplateUtil::TEMPLATE_ID;
        $template_content = $data['content'];

        return [$template_content, $template_slug];
    }

    private static function HandleTemplatePostRevisionCreationOrUpdate($template_post_slug, $template_object, $template_content, $include_addons_template_content)
    {
        $restoration_point = WizardRestorationPointController::CreateTemplateRestorationPoint($template_object->slug, WizardItemTypes::WP_TEMPLATE);
        if (!$restoration_point) {
            throw new WizardException(__('Template restoration point could not be created. If the issue persists, please contact support.', 'superb-blocks'));
        }

        $template_content = $include_addons_template_content ? AddonsPageTemplateUtil::GetAddonsPageTemplateContent($template_content) : $template_content;
        $current_template_post_id = WizardCreationUtil::GetTemplatePostID($template_post_slug, WizardItemTypes::WP_TEMPLATE);
        if ($current_template_post_id) {
            wp_update_post(
                array(
                    'ID' => $current_template_post_id,
                    'post_content' => $template_content
                )
            );
        } else {
            wp_insert_post(
                array(
                    'post_title' => $template_object->title,
                    'post_excerpt' => $template_object->description,
                    'post_name' => $template_post_slug,
                    'post_content' => $template_content,
                    'post_status' => 'publish',
                    'post_type' => WizardItemTypes::WP_TEMPLATE,
                    'comment_status' => 'closed',
                    'ping_status' => 'closed',
                    'tax_input' => array(
                        'wp_theme' => get_stylesheet()
                    )
                )
            );
        }
    }

    private static function HandleFrontPageTemplate($selection, $template_content, $template_slug, $include_addons_template_content)
    {
        $front_page_template = get_block_template(get_stylesheet() . "//front-page");
        $is_front_page_and_has_front_page_template = $front_page_template && isset($front_page_template->id);

        if ($is_front_page_and_has_front_page_template) {
            $template_content = WizardCreationUtil::MaybeUpdateQueryLoopBlockInherit($template_content);
            self::HandleTemplatePostRevisionCreationOrUpdate('front-page', $front_page_template, $template_content, $include_addons_template_content);

            if (get_option('show_on_front') === 'page' && get_option('page_on_front')) {
                return get_option('page_on_front');
            }

            $template_slug = false;

            $template_content = '<!-- wp:paragraph -->
            <p>' . esc_html__("This is a front page template page created by Superb Addons. You can edit this page's content and its template. If the blocks you want to edit can't be found in the page content, please edit the front page template.", "superb-blocks") . '</p>
            <!-- /wp:paragraph -->';
        }

        return self::InsertPage($selection, $template_content, $template_slug);
    }

    private static function HandleBlogPageTemplate($selection, $template_content, $template_slug, $include_addons_template_content)
    {
        $template_post_slug = 'home';
        $blog_page_template = get_block_template(get_stylesheet() . "//home");
        if (!$blog_page_template || !isset($blog_page_template->id)) {
            $blog_page_template = get_block_template(get_stylesheet() . "//index");
            $template_post_slug = 'index';
        }
        $is_blog_page_and_has_blog_page_template = $blog_page_template && isset($blog_page_template->id);

        if ($is_blog_page_and_has_blog_page_template) {
            $template_content = WizardCreationUtil::MaybeUpdateQueryLoopBlockInherit($template_content);
            self::HandleTemplatePostRevisionCreationOrUpdate($template_post_slug, $blog_page_template, $template_content, $include_addons_template_content);

            if (get_option('show_on_front') === 'page' && get_option('page_for_posts')) {
                return get_option('page_for_posts');
            }

            $template_slug = false;

            $template_content = '<!-- wp:paragraph -->
            <p>' . esc_html__("This is a blog page template page created by Superb Addons. You can edit this page's content and its template. If the blocks you want to edit can't be found in the page content, please edit the blog template (home or index).", "superb-blocks") . '</p>
            <!-- /wp:paragraph -->';
        }

        return self::InsertPage($selection, $template_content, $template_slug);
    }

    private static function InsertPage($selection, $template_content, $template_slug)
    {
        $post_data = array(
            'post_title' => esc_html($selection['customTitle'] ?? $selection['title']),
            'post_content' => $template_content,
            'post_status' => 'publish',
            'post_type' => 'page'
        );
        if ($template_slug) {
            $post_data['page_template'] = $template_slug;
        }

        $created_page_id = wp_insert_post($post_data);

        if ($created_page_id instanceof WP_Error) {
            return false;
        }

        return $created_page_id;
    }

    private static function GetMenuItemArr($id, $selection)
    {
        $url = $id === 0 ? get_home_url() : get_permalink($id);
        return [
            'id' => absint($id),
            'title' => esc_attr($selection['customTitle'] ?? $selection['title']),
            'url' => esc_url($url)
        ];
    }
}
