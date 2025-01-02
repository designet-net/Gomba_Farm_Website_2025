<?php

namespace SuperbAddons\Library\Controllers;

defined('ABSPATH') || exit();


class LibraryController
{
    public static function InsertTemplates()
    {
        self::OutputTemplates(false);
    }

    public static function InsertTemplatesWithWrapper()
    {
        self::OutputTemplates();
    }

    private static function OutputTemplates($with_wrapper = true)
    {
        ob_start();
        if ($with_wrapper) {
            echo '<div class="superb-addons-template-library-page-wrapper" style="display:none;">';
        }
        include(SUPERBADDONS_PLUGIN_DIR . 'src/library/templates/library-page.php');
        if ($with_wrapper) {
            echo '</div>';
        }
        $template = ob_get_clean();
        echo '<script type="text/template" id="tmpl-superbaddons-superb-library-page">' . $template . '</script>';
        ob_start();
        include(SUPERBADDONS_PLUGIN_DIR . 'src/library/templates/library-item.php');
        $template = ob_get_clean();
        echo '<script type="text/template" id="tmpl-superbaddons-superb-library-item">' . $template . '</script>';
        ob_start();
        include(SUPERBADDONS_PLUGIN_DIR . 'src/library/templates/library-menu-item.php');
        $template = ob_get_clean();
        echo '<script type="text/template" id="tmpl-superbaddons-superb-library-menu-item">' . $template . '</script>';
    }
}
