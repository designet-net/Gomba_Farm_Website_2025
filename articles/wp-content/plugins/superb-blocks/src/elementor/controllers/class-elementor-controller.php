<?php

namespace SuperbAddons\Elementor\Controllers;

defined('ABSPATH') || exit();

use SuperbAddons\Data\Controllers\RestController;
use SuperbAddons\Library\Controllers\LibraryController;
use SuperbAddons\Library\Controllers\LibraryRequestController;
use SuperbAddons\Elementor\Utils\ElementorSourceExtension;
use Exception;

class ElementorController
{
    const MINIMUM_ELEMENTOR_VERSION = '3.0';
    const MINIMUM_PHP_VERSION = '5.6';

    const IMPORT_COMPLETION_ACTION = 'superbaddons_elementorimport_completed_';

    public function __construct()
    {
        if (!self::is_compatible()) {
            return;
        }

        add_action('elementor/editor/before_enqueue_scripts', array($this, 'elementor_editor_scripts'));
        add_action('elementor/editor/footer', array($this, 'elementor_editor_footer_scripts'));
        add_action('elementor/editor/after_enqueue_styles', array($this, 'elementor_editor_enqueue_styles'));
        add_action('elementor/preview/enqueue_styles', array($this, 'elementor_preview_enqueue_styles'));
    }

    public static function is_compatible()
    {
        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {
            return false;
        }

        // Check for required Elementor version
        if (!defined("ELEMENTOR_VERSION") || version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '<')) {
            return false;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            return false;
        }

        return true;
    }

    public static function GetElementorLibraryMenuItems()
    {
        return array(
            array(
                "id" => "sections",
                "title" => esc_html__('Sections', "superb-blocks"),
                "routes" => array(
                    "list" => LibraryRequestController::ELEMENTOR_LIST_ROUTE,
                    "insert" => LibraryRequestController::ELEMENTOR_INSERT_ROUTE
                ),
                "hidden" => true
            )
        );
    }

    public function elementor_editor_scripts()
    {
        wp_enqueue_script('superb-elementor-layout-library', SUPERBADDONS_ASSETS_PATH . '/js/elementor/layout-library.js', array('jquery', 'wp-element'), SUPERBADDONS_VERSION, true);
        wp_localize_script('superb-elementor-layout-library', 'superblayoutlibrary_g', array(
            "title" => esc_html__('Add Superb Template', "superb-blocks"),
            "logoUrl" => esc_url(SUPERBADDONS_ASSETS_PATH . '/img/icon-superb.svg'),
            "style_placeholder" => esc_html__('All themes', "superb-blocks"),
            "category_placeholder" => esc_html__('All categories', "superb-blocks"),
            "snacks" => array(
                "insert_error" => esc_html__('Something went wrong while attempting to insert this element. Please try again or contact support if the problem persists.', "superb-blocks"),
                "list_error" => esc_html__('Something went wrong while attempting to list elements. Please try again or contact support if the problem persists.', "superb-blocks")
            ),
            "menu_items" => self::GetElementorLibraryMenuItems(),
            "rest" => array(
                "base" => \get_rest_url(),
                "namespace" => RestController::NAMESPACE,
                "nonce" => wp_create_nonce("wp_rest")
            )
        ));
    }

    public function elementor_editor_footer_scripts()
    {
        LibraryController::InsertTemplatesWithWrapper();
    }

    public function elementor_editor_enqueue_styles()
    {
        wp_enqueue_style(
            'superb-addons-elements',
            SUPERBADDONS_ASSETS_PATH . '/css/framework.min.css',
            array(),
            SUPERBADDONS_VERSION
        );
        wp_enqueue_style(
            'superb-elementor-editor-layout-library',
            SUPERBADDONS_ASSETS_PATH . '/css/layout-library-editor.min.css',
            array(),
            SUPERBADDONS_VERSION
        );
        wp_enqueue_style(
            'superbaddons-js-snackbar',
            SUPERBADDONS_ASSETS_PATH . '/lib/js-snackbar.min.css',
            array(),
            SUPERBADDONS_VERSION
        );
        wp_enqueue_style(
            'superb-addons-font-manrope',
            SUPERBADDONS_ASSETS_PATH . '/fonts/manrope/manrope.css',
            array(),
            SUPERBADDONS_VERSION
        );
    }

    public function elementor_preview_enqueue_styles()
    {
        wp_enqueue_style(
            'superb-elementor-layout-library',
            SUPERBADDONS_ASSETS_PATH . '/css/layout-library-preview.min.css',
            array(),
            SUPERBADDONS_VERSION
        );
    }

    public static function ElementorDataImportAction($data)
    {
        $dynamic_action = time();
        self::MaybeHandleBadFunctions($dynamic_action);
        $source = new ElementorSourceExtension();
        $source->HandleImport($data['content']);
        try {
            do_action(self::IMPORT_COMPLETION_ACTION . $dynamic_action);
            return $data;
        } catch (Exception $ex) {
            LogController::HandleException($ex);
            //Completion action failed
            //Catch exception to ensure content response
            return $data;
        }
    }

    private static function MaybeHandleBadFunctions($action_affix = "")
    {
        // This option from Royal Addons (royal-elementor-addons), when enabled, creates and uploads multiple identical placeholder images in the user's media library on every insert unless disabled.
        // They even disable it and re-enable it themselves during their own insert function.
        if (class_exists("WprAddons\\Plugin")) {
            $wpr_args = array(
                'wpr-parallax-background' => get_option('wpr-parallax-background'),
                'wpr-parallax-multi-layer' => get_option('wpr-parallax-multi-layer')
            );
            update_option('wpr-parallax-background', '');
            update_option('wpr-parallax-multi-layer', '');

            add_action(self::IMPORT_COMPLETION_ACTION . $action_affix, function () use ($wpr_args) {
                update_option('wpr-parallax-background', $wpr_args['wpr-parallax-background']);
                update_option('wpr-parallax-multi-layer', $wpr_args['wpr-parallax-multi-layer']);
            });
        }
    }
}
