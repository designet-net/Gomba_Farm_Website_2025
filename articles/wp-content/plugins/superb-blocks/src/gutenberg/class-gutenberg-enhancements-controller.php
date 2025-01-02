<?php

namespace SuperbAddons\Gutenberg\Controllers;

defined('ABSPATH') || exit();

use Exception;
use SuperbAddons\Config\Capabilities;
use SuperbAddons\Data\Controllers\LogController;
use SuperbAddons\Data\Controllers\RestController;

use WP_Block_Type_Registry;
use WP_Error;
use WP_REST_Server;
use WP_HTML_Tag_Processor;

class GutenbergEnhancementsController
{
    const ENHANCEMENTS_OPTION = 'superb-blocks-enhancements';

    const HIGHLIGHTS_KEY = 'superb-blocks-highlights';
    const HIGHLIGHTS_QUICKOPTIONS_KEY = 'superb-blocks-highlights-qo';
    const HIGHLIGHTS_QUICKOPTIONS_BOTTOM_KEY = 'superb-blocks-highlights-qo-b';
    const HIDERS_KEY = 'superb-blocks-hiders';
    const ANIMATIONS_KEY = 'superb-blocks-animations';

    public static function Initialize()
    {
        self::InitializeEnhancementEndpoints();
        self::InitializeEditorEnhancements();
        GutenbergBlockStyles::Initialize();
    }

    private static function InitializeEnhancementEndpoints()
    {
        RestController::AddRoute('/options/enhancements', array(
            'methods' => WP_REST_Server::READABLE,
            'permission_callback' => array(self::class, 'OptionsCallbackPermissionCheck'),
            'callback' => array(self::class, 'OptionsCallback'),
        ));
        RestController::AddRoute('/options/enhancements', array(
            'methods' => WP_REST_Server::EDITABLE,
            'permission_callback' => array(self::class, 'OptionsCallbackPermissionCheck'),
            'callback' => array(self::class, 'OptionsSaveCallback'),
        ));
    }

    private static function InitializeEditorEnhancements()
    {
        add_filter('render_block', [__CLASS__, 'FilterEnhancementsRender'], 10, 2);
        add_filter('wp_enqueue_scripts', [__CLASS__, 'EnhancementsEnqueue']);

        add_filter('rest_pre_dispatch', array(__CLASS__, 'rest_pre_dispatch'), 10, 3);
    }

    /*
        * This function is used to remove the attributes that are not allowed for the block during the server side rendering.
        * Solves the issue of editor server side rendering not working if blocks have custom attributes registered during runtime.
    */
    public static function rest_pre_dispatch($result, $server, $request)
    {
        if (strpos($request->get_route(), '/wp/v2/block-renderer') === false || !isset($request['context']) || $request['context'] !== 'edit') {
            return $result;
        }

        if (!isset($request['attributes']) || !class_exists('WP_Block_Type_Registry')) {
            return $result;
        }

        $block_type = str_replace('/wp/v2/block-renderer/', '', $request->get_route());
        $registry = WP_Block_Type_Registry::get_instance();
        $block = $registry->get_registered($block_type);
        if (!$block) {
            return $result;
        }

        $allowed_attributes = $block->get_attributes();
        $attributes = $request['attributes'];

        foreach ($attributes as $key => $value) {
            if (!isset($allowed_attributes[$key])) {
                unset($attributes[$key]);
            }
        }

        $request['attributes'] = $attributes;

        return $result;
    }

    public static function FilterEnhancementsRender($block_content, $block)
    {
        $block_content = self::MaybeAddBlockTagModifications($block_content, $block, array(
            'spbaddHideOnMobile' => array(
                'class' => 'superb-addons-hide-on-mobile',
            ),
            'spbaddHideOnTablet' => array(
                'class' => 'superb-addons-hide-on-tablet',
            )
        ));

        if (isset($block['attrs']['spbaddAnimationsEnabled']) && $block['attrs']['spbaddAnimationsEnabled']) {
            wp_enqueue_script('superb-addons-animations', SUPERBADDONS_ASSETS_PATH . '/js/dynamic-blocks/block-animations.js', array(), SUPERBADDONS_VERSION, true);
            $block_content = self::MaybeAddBlockTagModifications($block_content, $block, array(
                'spbaddAnimationId' => array(
                    'superb-addons-animation' => array("attribute" => "spbaddAnimationId"),
                    'style' => 'opacity: 0;'
                )
            ));
        }

        return $block_content;
    }

    public static function EnhancementsEnqueue()
    {
        wp_enqueue_style('superb-addons-enhancements', SUPERBADDONS_ASSETS_PATH . '/css/enhancements.min.css', array(), SUPERBADDONS_VERSION);
    }

    public static function MaybeAddBlockTagModifications($block_content, $block, $classes)
    {
        if (!is_array($classes) || empty($classes)) {
            return $block_content;
        }

        $added_html_classes = array();
        $added_html_styles = array();
        $added_html_attributes = array();
        foreach ($classes as $required_attribute => $modification) {
            if (!isset($block['attrs'][$required_attribute]) || !$block['attrs'][$required_attribute]) {
                continue;
            }
            foreach ($modification as $modification_key => $value) {
                if ($modification_key === 'required-values') {
                    foreach ($value as $required_value => $conditional_modifications) {
                        if ($block['attrs'][$required_attribute] != $required_value) {
                            continue;
                        }
                        foreach ($conditional_modifications as $conditional_modification_key => $conditional_value) {
                            self::AppendModificationArrays($block, $conditional_modification_key, $conditional_value, $added_html_classes, $added_html_styles, $added_html_attributes);
                        }
                    }
                    continue;
                }

                self::AppendModificationArrays($block, $modification_key, $value, $added_html_classes, $added_html_styles, $added_html_attributes);
            }
        }

        if (empty($added_html_classes) && empty($added_html_styles) && empty($added_html_attributes)) {
            return $block_content;
        }

        $block_content = new WP_HTML_Tag_Processor($block_content);
        $block_content->next_tag();
        if (!empty($added_html_attributes)) {
            foreach ($added_html_attributes as $attribute => $value) {
                $block_content->set_attribute($attribute, $value);
            }
        }
        if (!empty($added_html_styles)) {
            $styles = $block_content->get_attribute("style") ?? "";
            $block_content->set_attribute("style", $styles . join(" ", $added_html_styles));
        }
        if (!empty($added_html_classes)) {
            $block_content->add_class(join(" ", $added_html_classes));
        }
        return $block_content->get_updated_html();
    }

    private static function AppendModificationArrays($block, $modification_key, $value, &$added_html_classes, &$added_html_styles, &$added_html_attributes)
    {
        if (is_array($value)) {
            $key = key($value);
            $dynamic_value = $value[$key];
            switch ($key) {
                case 'attribute':
                    $value = isset($block['attrs'][$dynamic_value]) ? $block['attrs'][$dynamic_value] : (isset($value['default']) ? $value['default'] : '');
                    break;
                default:
                    $value = "";
                    break;
            }
        }
        switch ($modification_key) {
            case 'class':
                $added_html_classes[] = $value;
                break;
            case 'style':
                $added_html_styles[] = $value;
                break;
            default:
                $added_html_attributes[$modification_key] = $value;
                break;
        }
    }

    public static function OptionsCallbackPermissionCheck()
    {
        // Restrict endpoint to only users who have the proper capability.
        if (!current_user_can(Capabilities::CONTRIBUTOR)) {
            return new WP_Error('rest_forbidden', esc_html__('Unauthorized. Please check user permissions.', "superb-blocks"), array('status' => 401));
        }

        return true;
    }

    public static function OptionsCallback()
    {
        try {
            return rest_ensure_response(self::GetEnhancementsOptions(get_current_user_id()));
        } catch (Exception $ex) {
            LogController::HandleException($ex);
            return new \WP_Error('internal_error_plugin', 'Internal Plugin Error', array('status' => 500));
        }
    }

    public static function OptionsSaveCallback($request)
    {
        try {
            $key = sanitize_title($request['action']);
            switch ($key) {
                case self::HIGHLIGHTS_KEY:
                case self::HIGHLIGHTS_QUICKOPTIONS_KEY:
                case self::HIGHLIGHTS_QUICKOPTIONS_BOTTOM_KEY:
                case self::HIDERS_KEY:
                case self::ANIMATIONS_KEY:
                    // Allowed
                    break;
                default:
                    return new \WP_Error('invalid_request', 'Invalid Request', array('status' => 400));
            }

            $userOptions = self::GetEnhancementsOptions(get_current_user_id());
            $userOptions[$key] = !$userOptions[$key];
            if (update_user_meta(get_current_user_id(), self::ENHANCEMENTS_OPTION, $userOptions) !== true) {
                throw new Exception('Failed to update user meta');
            }

            return rest_ensure_response(['success' => true]);
        } catch (Exception $ex) {
            LogController::HandleException($ex);
            return new \WP_Error('internal_error_plugin', 'Internal Plugin Error', array('status' => 500));
        }
    }

    public static function GetEnhancementsOptions($user_id)
    {
        $defaults = array(
            self::HIGHLIGHTS_KEY => true,
            self::HIGHLIGHTS_QUICKOPTIONS_KEY => false,
            self::HIGHLIGHTS_QUICKOPTIONS_BOTTOM_KEY => false,
            self::HIDERS_KEY => true,
            self::ANIMATIONS_KEY => true,
        );
        $enhancements = get_user_meta($user_id, self::ENHANCEMENTS_OPTION, true);
        if (!$enhancements) {
            return $defaults;
        }

        return wp_parse_args($enhancements, $defaults);
    }
}
