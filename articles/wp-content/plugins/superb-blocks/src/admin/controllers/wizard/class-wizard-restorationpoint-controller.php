<?php

namespace SuperbAddons\Admin\Controllers\Wizard;

use WP_Block_Template;

defined('ABSPATH') || exit();

class WizardRestorationPointController
{
    const RESTORATION_TRANSIENT = 'superb_blocks_template_restoration';
    const RESTORATION_CLEANUP_HOOK = 'superb_blocks_template_restoration_cleanup';

    public static function Initialize()
    {
        add_action(self::RESTORATION_CLEANUP_HOOK, array(__CLASS__, 'RestorationPointCleanup'));
    }

    private static function GetRestorationPointsTransient()
    {
        return get_transient(self::RESTORATION_TRANSIENT, []);
    }

    private static function SetRestorationPointsTransient($value)
    {
        return set_transient(self::RESTORATION_TRANSIENT, $value, MONTH_IN_SECONDS * 2);
    }

    public static function GetThemeRestorationPoints()
    {
        $restoration_transient = self::GetRestorationPointsTransient();
        if (empty($restoration_transient)) {
            return false;
        }
        if (!isset($restoration_transient[get_stylesheet()])) {
            return false;
        }

        return $restoration_transient[get_stylesheet()];
    }

    public static function GetTemplateRestorationPoint($template_id)
    {
        $restoration_points = self::GetThemeRestorationPoints();
        if (!$restoration_points || empty($restoration_points)) {
            return false;
        }
        if (!isset($restoration_points[$template_id])) {
            return false;
        }
        return $restoration_points[$template_id];
    }

    public static function CreateTemplateRestorationPoint($template_slug, $template_type)
    {
        $current_template = get_block_template(get_stylesheet() . '//' . $template_slug, $template_type);
        if (!$current_template || !$current_template instanceof WP_Block_Template) {
            return false;
        }

        $restoration_transient = self::GetRestorationPointsTransient();
        $restoration_transient[get_stylesheet()] ??= array();
        $restoration_transient[get_stylesheet()][$current_template->slug . "//" . $template_type . "//" . time()] = array(
            "timestamp" => time(),
            "type" => $template_type,
            "slug" => $current_template->slug,
            "content" => $current_template->content
        );

        self::MaybeScheduleRestorationCleanup();

        return self::SetRestorationPointsTransient($restoration_transient);
    }

    public static function RestorationPointCleanup()
    {
        $restoration_transient = self::GetRestorationPointsTransient();
        if (empty($restoration_transient)) {
            self::MaybeUnsubscribeCron();
            return delete_transient(self::RESTORATION_TRANSIENT);
        }

        foreach ($restoration_transient as $stylesheet => $templates) {
            foreach ($templates as $template_key => $template) {
                if ($template['timestamp'] < strtotime('-2 month')) {
                    unset($restoration_transient[$stylesheet][$template_key]);
                }
            }

            if (empty($restoration_transient[$stylesheet])) {
                unset($restoration_transient[$stylesheet]);
            }
        }

        if (empty($restoration_transient)) {
            self::MaybeUnsubscribeCron();
            return delete_transient(self::RESTORATION_TRANSIENT);
        }

        return self::SetRestorationPointsTransient($restoration_transient);
    }

    public static function FullRestorationCleanup()
    {
        self::MaybeUnsubscribeCron();
        return delete_transient(self::RESTORATION_TRANSIENT);
    }

    private static function MaybeScheduleRestorationCleanup()
    {
        if (!wp_next_scheduled(self::RESTORATION_CLEANUP_HOOK)) {
            wp_schedule_event(time(), 'weekly', self::RESTORATION_CLEANUP_HOOK);
        }
    }

    public static function MaybeUnsubscribeCron()
    {
        $timestamp = wp_next_scheduled(self::RESTORATION_CLEANUP_HOOK);
        if ($timestamp) {
            wp_unschedule_event($timestamp, self::RESTORATION_CLEANUP_HOOK);
        }
    }
}
