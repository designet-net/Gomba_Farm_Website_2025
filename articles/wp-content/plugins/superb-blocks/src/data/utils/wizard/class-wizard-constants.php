<?php

namespace SuperbAddons\Data\Utils\Wizard;

defined('ABSPATH') || exit();

class WizardStageTypes
{
    const HEADER_STAGE = 'header-stage';
    const FOOTER_STAGE = 'footer-stage';
    const FRONT_PAGE_STAGE = 'front-page-stage';
    const BLOG_PAGE_STAGE = 'blog-page-stage';
    const TEMPLATE_PAGE_STAGE = 'template-page-stage';
    const NAVIGATION_MENU_STAGE = 'navigation-menu-stage';
    const COMPLETION_STAGE = 'completion-stage';

    const ALL_STAGES = [
        self::HEADER_STAGE,
        self::FOOTER_STAGE,
        self::FRONT_PAGE_STAGE,
        self::BLOG_PAGE_STAGE,
        self::TEMPLATE_PAGE_STAGE,
        self::NAVIGATION_MENU_STAGE
    ];

    const PAGE_STAGES = [
        self::FRONT_PAGE_STAGE,
        self::BLOG_PAGE_STAGE,
        self::TEMPLATE_PAGE_STAGE
    ];
}

class WizardSpecialBlockClassName
{
    const INHERIT_TEMPLATE_QUERY = 'superbaddons-inherit-query';
}

class WizardNavigationMenuOptions
{
    const CREATE_NEW_MENU = 'superbaddons-create-new-menu';
    const APPEND_EXISTING_MENU = 'superbaddons-append-existing-menu';
    const SKIP_MENU = 'superbaddons-skip-menu';
}

class WizardItemTypes
{
    const WP_TEMPLATE = 'wp_template';
    const WP_TEMPLATE_PART = 'wp_template_part';
    const WP_NAVIGATION = 'wp_navigation';
    const PATTERN = 'superb_pattern';
    const PAGE = 'superb_page';
}

class WizardItemIdAffix
{
    const FILE_TEMPLATE = ':::superbaddons_file_template';
    const RESTORATION_POINT = ':::superbaddons_restoration_point';
}

class WizardDataCategory
{
    const NAVIGATION = '5jwnf0qnzth4y3p';
    const FOOTER = '0lsr16aihp96ado';
    const LANDING_PAGE = '2lc1j8j7l7v1dkj';
    const BLOG = 'orngta8z79g7j37';
}

class WizardActionParameter
{
    const INTRO = 'intro';
    const ADD_NEW_PAGES = 'add-new-pages';
    const HEADER_FOOTER = 'header-footer';
    const WOOCOMMERCE_HEADER = 'woocommerce-header';
    const THEME_DESIGNER = 'theme-designer';
    const COMPLETE = 'complete';
    const CANCEL = 'cancel';
    const RESTORE = 'restore';
}
