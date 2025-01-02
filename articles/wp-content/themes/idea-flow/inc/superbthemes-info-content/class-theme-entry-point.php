<?php

namespace SuperbThemesThemeInformationContent;

use SuperbThemesThemeInformationContent\AdminNotices\AdminNoticeController;
use SuperbThemesThemeInformationContent\Templates\TemplateInformationController;
use SuperbThemesThemeInformationContent\ThemePage\ThemePageController;

defined('ABSPATH') || exit();

class ThemeEntryPoint
{
    const Version = '1.1';

    public static function init($options)
    {
        ThemePageController::init($options);
        AdminNoticeController::init($options);
        TemplateInformationController::init($options);
        add_action('switch_theme', array(__CLASS__, 'ThemeCleanup'));
    }

    public static function ThemeCleanup()
    {
        AdminNoticeController::Cleanup();
        ThemePageController::Cleanup();
    }
}
