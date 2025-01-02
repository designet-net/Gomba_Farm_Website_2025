<?php

namespace SuperbAddons\Data\Utils\Wizard;

use SuperbAddons\Admin\Controllers\Wizard\WizardRestorationPointController;
use SuperbAddons\Gutenberg\Controllers\GutenbergController;
use SuperbAddons\Library\Controllers\LibraryRequestController;

defined('ABSPATH') || exit();

class WizardPartCreator
{
    public static function CreateTemplateParts($selection_data, $wizardData)
    {
        foreach ($wizardData->GetStages() as $stage_type) {
            if ($stage_type !== WizardStageTypes::HEADER_STAGE && $stage_type !== WizardStageTypes::FOOTER_STAGE) {
                continue;
            }

            if (!isset($selection_data[$stage_type])) {
                throw new WizardException(__('Couldn\'t process template part selections. If the issue persists, please contact support.', 'superb-blocks'));
            }

            $template_part_data = isset($selection_data[$stage_type][0]) ? $selection_data[$stage_type][0] : [];
            if (!boolval($template_part_data['isChanged'])) {
                continue;
            }

            self::ValidateTemplatePartDataOrThrow($template_part_data);
            $template_part_slug = $stage_type === WizardStageTypes::HEADER_STAGE ? 'header' : 'footer';
            $restoration_point = WizardRestorationPointController::CreateTemplateRestorationPoint($template_part_slug, WizardItemTypes::WP_TEMPLATE_PART);
            if (!$restoration_point) {
                throw new WizardException(__('Template part restoration point could not be created. If the issue persists, please contact support.', 'superb-blocks'));
            }
            $part_created = self::CreateTemplatePart($template_part_slug, $template_part_data['slug'], $template_part_data['package'], $template_part_data['type']);
            if (!$part_created) {
                throw new WizardException(__('Template part could not be created. If the issue persists, please contact support.', 'superb-blocks'));
            }
        }

        return true;
    }

    private static function ValidateTemplatePartDataOrThrow($data)
    {
        if (
            !isset($data['slug'])
            || !isset($data['package'])
            || !isset($data['type'])
            || empty($data['slug'])
            || empty($data['package'])
            || empty($data['type'])
        ) {
            throw new WizardException(__('Missing template part selection data. If the issue persists, please contact support.', 'superb-blocks'));
        }
    }

    private static function CreateTemplatePart($slug, $template_id, $package, $template_type)
    {
        // Slug is the same as the template id, no need to create a new template part.
        if ($template_type === WizardItemTypes::WP_TEMPLATE_PART && $slug === $template_id) {
            return true;
        }

        // Do not create if template part does not exist in theme.
        if (!get_block_template(get_stylesheet() . "//" . $slug, WizardItemTypes::WP_TEMPLATE_PART)) {
            return false;
        }

        $current_template_part_post_id = WizardCreationUtil::GetTemplatePostID($slug, WizardItemTypes::WP_TEMPLATE_PART);

        $template_content = false;
        if ($template_type === WizardItemTypes::WP_TEMPLATE_PART) {
            $is_file_template = WizardCreationUtil::IsFileTemplate($template_id, $template_type, WizardItemTypes::WP_TEMPLATE_PART);
            $is_restoration_point = WizardCreationUtil::IsRestorationPoint($template_id, $template_type, WizardItemTypes::WP_TEMPLATE_PART);
            if ($is_file_template) {
                $template_content = self::GetFileTemplateContent($template_id);
            } elseif ($is_restoration_point) {
                $template_content = self::GetRestorationPointContent($template_id);
            } else {
                $template_content = self::GetTemplateContent($template_id);
            }
        } else {
            $template_content = self::GetSelectedAddonsTemplateContent($template_id, $package);
        }

        if (!$template_content) {
            return false;
        }

        if ($slug === 'header') {
            $template_content = self::InjectCurrentHeaderNavigationId($template_content);
        }

        return $current_template_part_post_id
            ? WizardCreationUtil::UpdateTemplatePost($current_template_part_post_id, $template_content)
            : WizardCreationUtil::CreateNewTemplatePartPost($slug, $template_content);
    }

    private static function GetFileTemplateContent($template_id)
    {
        $template = get_block_file_template(get_stylesheet() . '//' . $template_id, WizardItemTypes::WP_TEMPLATE_PART);
        if ($template->theme !== get_stylesheet() || empty($template->content)) {
            return false;
        }
        return $template->content;
    }

    private static function GetTemplateContent($template_id)
    {
        $template = get_block_template(get_stylesheet() . '//' . $template_id, WizardItemTypes::WP_TEMPLATE_PART);
        if ($template->theme !== get_stylesheet() || empty($template->content)) {
            return false;
        }
        return $template->content;
    }

    private static function GetRestorationPointContent($template_id)
    {
        $restoration_point = WizardRestorationPointController::GetTemplateRestorationPoint($template_id);
        if (!$restoration_point) {
            return false;
        }
        return $restoration_point['content'];
    }

    private static function GetSelectedAddonsTemplateContent($template_id, $package)
    {
        $data = LibraryRequestController::GetInsertData(
            [
                'id' => $template_id,
                'package' => $package,
            ],
            LibraryRequestController::GUTENBERG_ENDPOINT_BASE,
            LibraryRequestController::GUTENBERG_ROUTE_TYPE_PATTERNS
        );

        if (!$data || !isset($data['content']) || isset($data['access_failed'])) {
            return false;
        }

        $data = GutenbergController::GutenbergDataImportAction($data);

        return $data['content'];
    }

    private static function InjectCurrentHeaderNavigationId($template_content)
    {
        if (!has_block('core/navigation', $template_content)) {
            return $template_content;
        }

        $navigation_id = WizardCreationUtil::GetNavigationTemplatePartMenuId();
        if (!$navigation_id) {
            return $template_content;
        }

        return WizardCreationUtil::UpdateNavigationBlockContentRefAndRemoveInnerLinks($template_content, $navigation_id);
    }
}
