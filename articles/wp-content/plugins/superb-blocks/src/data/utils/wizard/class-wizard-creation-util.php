<?php

namespace SuperbAddons\Data\Utils\Wizard;

use WP_Block_Template;

defined('ABSPATH') || exit();

class WizardCreationUtil
{
    public static function GetTemplatePostID($slug, $type = WizardItemTypes::WP_TEMPLATE_PART)
    {
        $current_template_part_post_id = false;

        $template_part_posts = get_posts(
            array(
                'post_type' => $type,
                'post_name' => $slug,
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'wp_theme',
                        'field' => 'slug',
                        'terms' => get_stylesheet()
                    )
                )
            )
        );

        if ($template_part_posts && !empty($template_part_posts)) {
            foreach ($template_part_posts as $template_part_post) {
                if ($template_part_post->post_name === $slug) {
                    $current_template_part_post_id = $template_part_post->ID;
                    break;
                }
            }
        }

        return $current_template_part_post_id;
    }

    public static function GetNavigationTemplateData($template_part_slug = 'header')
    {
        $navigation_template_part = get_block_template(get_stylesheet() . '//' . $template_part_slug, WizardItemTypes::WP_TEMPLATE_PART);
        if (!$navigation_template_part || !$navigation_template_part instanceof WP_Block_Template) {
            // Template part is not loaded correctly.
            return false;
        }

        $template_content = $navigation_template_part->content;
        if (!has_block('core/navigation', $template_content)) {
            // We cannot update the navigation if no navigation block is present in the template part.
            // Stop execution.
            return false;
        }

        return ['post_id' => $navigation_template_part->wp_id, 'title' => $navigation_template_part->title, 'content' => $template_content];
    }

    public static function GetNavigationTemplatePartMenuId($template_part_slug = 'header')
    {
        $template_data = self::GetNavigationTemplateData($template_part_slug);
        if (!$template_data) {
            return false;
        }

        $parsed_blocks = parse_blocks($template_data['content']);
        $flattened = _flatten_blocks($parsed_blocks);
        foreach ($flattened as &$block) {
            // Keep pointer reference to the navigation block.
            if ('core/navigation' !== $block['blockName'])
                continue;
            // Return the navigation menu id.
            if (!isset($block['attrs']['ref'])) {
                return false;
            }
            return $block['attrs']['ref'];
        }

        return false;
    }

    public static function UpdateNavigationBlockContentRefAndRemoveInnerLinks($template_content, $ref_id)
    {
        if (!$ref_id) {
            return $template_content;
        }

        $parsed_blocks = parse_blocks($template_content);
        $flattened = _flatten_blocks($parsed_blocks);
        foreach ($flattened as &$block) {
            // Keep pointer reference to the navigation block.
            if ('core/navigation' !== $block['blockName'])
                continue;

            // Update the navigation menu id.
            $block['attrs'] ??= [];
            $block['attrs']['ref'] = absint($ref_id);

            if (!isset($block['innerBlocks']) || !is_array($block['innerBlocks'])) {
                break;
            }

            // Remove inner navigation links.
            $block['innerBlocks'] = [];
            $block['innerContent'] = [];

            break;
        }

        // Serialize the blocks back to a string, keeping the updated navigation block pointer reference.
        $new_content = serialize_blocks($parsed_blocks);
        return $new_content;
    }

    public static function MaybeUpdateQueryLoopBlockInherit($template_content)
    {
        if (!has_block('core/query', $template_content)) {
            return $template_content;
        }

        $parsed_blocks = parse_blocks($template_content);
        $flattened = _flatten_blocks($parsed_blocks);
        foreach ($flattened as &$block) {
            // Keep pointer reference to the navigation block.
            if ('core/query' !== $block['blockName'])
                continue;

            // if the query block does not have the specified class name, skip it.
            if (!isset($block['attrs']['className']) || strpos($block['attrs']['className'], WizardSpecialBlockClassName::INHERIT_TEMPLATE_QUERY) === false) {
                continue;
            }

            // Update the query inherit bool.
            $block['attrs'] ??= [];
            $block['attrs']['query'] ??= [];
            $block['attrs']['query']['inherit'] = true;
        }

        // Serialize the blocks back to a string, keeping the updated navigation block pointer reference.
        $new_content = serialize_blocks($parsed_blocks);
        return $new_content;
    }

    public static function IsFileTemplate(&$template_id, $template_type, $required_type)
    {
        if ($template_type === $required_type) {
            if (strpos($template_id, WizardItemIdAffix::FILE_TEMPLATE) !== false) {
                // Remove the file template affix from the template id
                $template_id = str_replace(WizardItemIdAffix::FILE_TEMPLATE, '', $template_id);
                return true;
            }
        }
        return false;
    }

    public static function IsRestorationPoint(&$template_id, $template_type, $required_type)
    {
        if ($template_type === $required_type) {
            if (strpos($template_id, WizardItemIdAffix::RESTORATION_POINT) !== false) {
                // Remove the file template affix from the template id
                $template_id = str_replace(WizardItemIdAffix::RESTORATION_POINT, '', $template_id);
                return true;
            }
        }
        return false;
    }

    public static function CreateNewTemplatePartPost($slug, $content)
    {
        $block_template = get_block_template(get_stylesheet() . "//" . $slug, WizardItemTypes::WP_TEMPLATE_PART);
        return wp_insert_post(
            array(
                'post_title' => $block_template->title,
                'post_excerpt' => $block_template->description,
                'post_name' => $slug,
                'post_content' => $content,
                'post_status' => 'publish',
                'post_type' => WizardItemTypes::WP_TEMPLATE_PART,
                'comment_status' => 'closed',
                'ping_status' => 'closed',
                'tax_input' => array(
                    'wp_theme' => get_stylesheet(),
                    'wp_template_part_area' => $slug
                )
            )
        );
    }

    public static function UpdateTemplatePost($post_id, $content)
    {
        return wp_update_post(
            array(
                'ID' => $post_id,
                'post_content' => $content
            )
        );
    }
}
