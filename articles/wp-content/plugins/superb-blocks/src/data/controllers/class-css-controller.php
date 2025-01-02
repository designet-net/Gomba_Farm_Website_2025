<?php

namespace SuperbAddons\Data\Controllers;

defined('ABSPATH') || exit();

use Exception;
use SuperbAddons\Config\Capabilities;
use WP_Error;
use stdClass;

class CSSController
{
    const CSS_PATH = '/superb-addons/custom-css/';
    const CSS_ROUTE = '/css-blocks';

    const BLOCK_NAME_MAX_LENGTH = 145;

    public function __construct()
    {
        $this->EnqueueCustomCSSAction();
        RestController::AddRoute(self::CSS_ROUTE, array(
            'methods' => 'POST',
            'permission_callback' => array($this, 'CSSCallbackPermissionCheck'),
            'callback' => array($this, 'CSSRouteCallback'),
        ));
    }

    public function CSSCallbackPermissionCheck()
    {
        // Restrict endpoint to only users who have the proper capability.
        if (!current_user_can(Capabilities::ADMIN)) {
            return new WP_Error('rest_forbidden', esc_html__('Unauthorized. Please check user permissions.', "superb-blocks"), array('status' => 401));
        }

        return true;
    }

    public function CSSRouteCallback($request)
    {
        if (!isset($request['action'])) {
            return new WP_Error('bad_request', 'Bad Request', array('status' => 400));
        }
        try {
            switch ($request['action']) {
                case 'save-block':
                    return $this->SaveBlock($request);
                case 'delete-blocks':
                    return $this->DeleteBlocks($request);
                case 'import-blocks':
                    return $this->ImportBlocks($request);
                case 'activate-blocks':
                    return $this->ToggleBlocks($request, true);
                case 'deactivate-blocks':
                    return $this->ToggleBlocks($request, false);
                default:
                    return new WP_Error('bad_request_plugin', 'Bad Request', array('status' => 400));
            }
        } catch (Exception $ex) {
            LogController::HandleException($ex);
            return new WP_Error('internal_error_plugin', 'Internal Plugin Error', array('status' => 500));
        }
    }

    private function SanitizeBlock($saved_block, $request_block)
    {
        $request_block = json_decode($request_block, true);
        $is_active = isset($request_block['active']) ? !!$request_block['active'] : ($saved_block && isset($saved_block->active) ? !!$saved_block->active : true);
        $block = new stdClass();
        $block->name = isset($request_block['name']) && !empty($request_block['name']) ? sanitize_text_field(mb_substr($request_block['name'], 0, self::BLOCK_NAME_MAX_LENGTH)) : 'CSS Block ' . time();
        $block->selectors = $this->SanitizeSelectors($request_block['selectors']);
        $block->css = sanitize_textarea_field($request_block['css']);
        $block->active = $is_active;
        return $block;
    }

    private function SanitizeSelectors($selectors_request)
    {
        $selectors = [];
        foreach ($selectors_request as $selector_request) {
            $selector = new stdClass();
            $selector->type = sanitize_text_field($selector_request['type']);
            $selector->value = isset($selector_request['value']) && is_array($selector_request['value']) ? array_map(function ($str) {
                return sanitize_text_field($str);
            }, $selector_request['value']) : false;
            $selectors[] = $selector;
        }
        return $selectors;
    }

    public static function GetBlocks()
    {
        return get_option('superb_addons_custom_css_blocks', []);
    }

    public static function UpdateBlocks($blocks)
    {
        $updated = update_option('superb_addons_custom_css_blocks', $blocks, false);
        if ($updated) {
            self::GenerateOptimizedCSS();
        }
        return $updated;
    }

    private function GetBlockIDArray($request)
    {
        if (!isset($request['block_ids']) || empty($request['block_ids'])) {
            return false;
        }

        $block_ids = sanitize_text_field($request['block_ids']);
        if (strpos($block_ids, ',') !== false) {
            $block_ids = explode(",", $block_ids);
        } else {
            $block_ids = array($block_ids);
        }

        if (!$block_ids || empty($block_ids)) {
            return false;
        }

        return $block_ids;
    }

    private function DeleteBlocks($request)
    {
        $block_ids = $this->GetBlockIDArray($request);
        if (!$block_ids) {
            return new WP_Error('bad_request_plugin', 'Bad Request', array('status' => 400));
        }

        $blocks = self::GetBlocks();
        foreach ($block_ids as $block_id) {
            if (!wp_is_uuid($block_id)) {
                return new WP_Error('bad_request_plugin', 'Bad Request', array('status' => 400));
            }
            if (isset($blocks[$block_id])) {
                unset($blocks[$block_id]);
            }
        }

        self::UpdateBlocks($blocks);

        return rest_ensure_response(['success' => true]);
    }

    private function ToggleBlocks($request, $active)
    {
        $block_ids = $this->GetBlockIDArray($request);
        if (!$block_ids) {
            return new WP_Error('bad_request_plugin', 'Bad Request', array('status' => 400));
        }

        $blocks = self::GetBlocks();
        foreach ($block_ids as $block_id) {
            if (!wp_is_uuid($block_id)) {
                return new WP_Error('bad_request_plugin', 'Bad Request', array('status' => 400));
            }
            if (isset($blocks[$block_id])) {
                $blocks[$block_id]->active = $active;
            }
        }

        self::UpdateBlocks($blocks);

        return rest_ensure_response(['success' => true]);
    }

    private function SaveBlock($request)
    {
        $blocks = self::GetBlocks();
        $block_id = isset($request['id']) && wp_is_uuid($request['id']) ? sanitize_text_field($request['id']) : wp_generate_uuid4();
        $saved_block = isset($blocks[$block_id]) ? $blocks[$block_id] : false;
        $new_block = $this->SanitizeBlock($saved_block, $request['block']);
        $blocks[$block_id] = $new_block;
        self::UpdateBlocks($blocks);

        return rest_ensure_response(['success' => true, 'id' => $block_id]);
    }

    private function ImportBlocks($request)
    {
        $files = $request->get_file_params();
        if (empty($files) || empty($files['files'])) {
            return new WP_Error('no_files', 'No files uploaded.', array('status' => 400));
        }
        $files = $files['files'];
        if (!isset($files['tmp_name']) || empty($files['tmp_name'])) {
            return new WP_Error('no_files', 'No files uploaded.', array('status' => 400));
        }

        global $wp_filesystem;
        if (!is_object($wp_filesystem)) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            WP_Filesystem();
        }

        $block_amount = 0;
        $imported_blocks = array();
        foreach ($files['tmp_name'] as $file) {
            $file_content = $wp_filesystem->get_contents($file);
            if (!$file_content) {
                return rest_ensure_response(['success' => false, "text" => esc_html__("File(s) could not be accessed.", "superb-blocks")]);
            }
            $file_blocks = json_decode(base64_decode($file_content));
            if (empty($file_blocks)) {
                continue;
            }

            foreach ($file_blocks as $file_block) {
                $block = $this->SanitizeBlock(false, json_encode($file_block));
                $block_id = wp_generate_uuid4();
                $imported_blocks[$block_id] = $block;
                $block_amount++;
            }
        }

        if (empty($imported_blocks)) {
            return rest_ensure_response(['success' => false, "text" => esc_html__("Blocks could not be imported. Please verify that the selected files are valid and try again.", "superb-blocks")]);
        }

        $blocks = self::GetBlocks();
        $blocks = array_merge($blocks, $imported_blocks);
        self::UpdateBlocks($blocks);

        return rest_ensure_response(['success' => true, "text" => esc_html(sprintf(__("%d CSS Block(s) imported successfully", "superb-blocks"), $block_amount))]);
    }

    private static function GenerateOptimizedCSS()
    {
        // Delete Previous Files
        self::RemovePreviousCSSFiles();

        $blocks = self::GetBlocks();
        if (empty($blocks)) {
            // No blocks to generate CSS from, remove the optimized CSS option
            delete_option('superb_addons_optimized_css');
            return;
        }

        $valid_types = apply_filters('superb_addons_custom_css_valid_types', array('full', 'front'));

        $css_generations = [];
        foreach ($blocks as $block) {
            if (!isset($block->selectors) || !isset($block->css) || !isset($block->active) || !$block->active) {
                continue;
            }
            foreach ($block->selectors as $selector) {
                if (!isset($selector->type) || !in_array($selector->type, $valid_types)) {
                    continue;
                }
                if (!isset($selector->value) || empty($selector->value) || !is_array($selector->value)) {
                    $css_generations[$selector->type]["css"][] = $block->css;
                    if ($selector->type === 'full') {
                        // Full CSS - No need to continue with the rest of the selectors in this block
                        // Continue 2 is used to continue to the next outer loop block
                        continue 2;
                    }
                    continue;
                }
                foreach ($selector->value as $selector_value) {
                    $css_generations[$selector->type][$selector_value]["css"][] = $block->css;
                }
            }
        }

        if (version_compare(PHP_VERSION, '7.1', '>=')) {
            // PHP 7.1 mininumum required for CSSTidy
            // Include the CSSTidy class if PHP version is 7.1 or greater
            include(SUPERBADDONS_PLUGIN_DIR . 'src/data/csstidy/class.csstidy.php');
            $csstidy = new \SuperbAddons\CSSTidy\csstidy();

            // Set some options :
            $csstidy->set_cfg('optimise_shorthands', 2);
            $csstidy->set_cfg('template', 'high');
        } else {
            $csstidy = false;
        }

        // Generate CSS Files 
        $optimized = array();
        foreach ($css_generations as $key => $css_generation) {
            if (isset($css_generation['css'])) {
                // No inner key selections
                $stylesheet = self::GenerateCSSFile($csstidy, $key, join("", $css_generation['css']));
                if (!$stylesheet) {
                    continue;
                }
                $optimized[] = self::GetOptimizedArrayItem($stylesheet, $key);
                unset($css_generation['css']);
            }

            if (empty($css_generation)) continue;
            // Inner key selections
            foreach ($css_generation as $inner_key => $inner_css_generation) {
                $stylesheet = self::GenerateCSSFile($csstidy, $key . "-" . $inner_key, join("", $inner_css_generation['css']));
                if (!$stylesheet) {
                    continue;
                }
                $optimized[] = self::GetOptimizedArrayItem($stylesheet, $key, $inner_key);
            }
        }

        // Save the optimized CSS to the database
        update_option('superb_addons_optimized_css', $optimized, true);
    }

    private static function GetOptimizedArrayItem($stylesheet, $type, $value = false)
    {
        return array(
            'stylesheet' => sanitize_file_name($stylesheet),
            'type' => sanitize_text_field($type),
            'value' => sanitize_text_field($value),
            'created' => time(),
        );
    }

    private static function GetCSSDirectory()
    {
        $upload_dir = wp_upload_dir();
        $upload_dir = $upload_dir['basedir'];
        return $upload_dir . self::CSS_PATH;
    }

    private static function GetCSSDirectoryURL()
    {
        $upload_dir = wp_upload_dir();
        $upload_dir = $upload_dir['baseurl'];
        return set_url_scheme($upload_dir . self::CSS_PATH);
    }

    private static function RemovePreviousCSSFiles()
    {
        $upload_dir = self::GetCSSDirectory();
        if (!is_dir($upload_dir) || strpos($upload_dir, self::CSS_PATH) === false) {
            return;
        }

        $files = glob($upload_dir . '*');
        foreach ($files as $file) {
            if (file_exists($file)) {
                wp_delete_file($file);
            }
        }
    }

    private static function GenerateCSSFile($csstidy, $filename, $content)
    {
        $filename = sanitize_file_name(sanitize_title($filename) . '.css');
        // Parse the CSS
        if ($csstidy) {
            $csstidy->parse($content);
            // Get back the optimized CSS Code
            $css_optimized = $csstidy->print->plain();
        } else {
            // Simple fallback with preg_replace
            $css_optimized = sanitize_text_field($content);
        }

        $css_optimized = wp_strip_all_tags($css_optimized);

        $upload_dir = self::GetCSSDirectory();
        if (!is_dir($upload_dir)) {
            wp_mkdir_p($upload_dir);
        }
        $created_bytes = file_put_contents($upload_dir . $filename, $css_optimized);
        if (!$created_bytes) {
            return false;
        }

        return $filename;
    }

    private function EnqueueCustomCSSAction()
    {
        add_action('wp_enqueue_scripts', array($this, 'EnqueueCustomCSS'));
    }

    public function EnqueueCustomCSS()
    {
        try {
            $optimized_css = get_option('superb_addons_optimized_css', false);
            if (!$optimized_css || empty($optimized_css)) return;

            $baseurl = self::GetCSSDirectoryURL();
            $enqueueChecks = apply_filters(
                'superb_addons_custom_css_enqueue_checks',
                array(
                    'full' => array("function" => false),
                    'front' => array("function" => 'is_front_page'),
                )
            );

            foreach ($optimized_css as $stylesheet) {

                if (!isset($stylesheet['type']) || !isset($enqueueChecks[$stylesheet['type']])) {
                    continue;
                }

                if (!isset($enqueueChecks[$stylesheet['type']]['function'])) {
                    return;
                }

                $should_enqueue =
                    (!$enqueueChecks[$stylesheet['type']]['function']
                        || isset($enqueueChecks[$stylesheet['type']]['params']) && call_user_func($enqueueChecks[$stylesheet['type']]['function'], $stylesheet['value']))
                    || (!isset($enqueueChecks[$stylesheet['type']]['params']) && call_user_func($enqueueChecks[$stylesheet['type']]['function']));

                if (!$should_enqueue) continue;




                $this->EnqueueStyle($baseurl, $stylesheet['stylesheet'], $stylesheet['created']);
            }
        } catch (Exception $ex) {
            LogController::HandleException($ex);
        }
    }

    private function EnqueueStyle($baseurl, $path, $created)
    {
        $path = sanitize_file_name($path);
        $title = sanitize_title('superb-addons-custom-' . $path);
        wp_register_style($title, $baseurl . $path, array(), $created);
        wp_enqueue_style($title);
    }
}
