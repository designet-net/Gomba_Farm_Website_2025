<?php

namespace SuperbAddons\Data\Utils\Wizard;

use SuperbAddons\Admin\Controllers\Wizard\WizardTemplatePreviewController;

defined('ABSPATH') || exit();

class WizardItem
{
    public $id;
    private $slug;
    public $type;
    public $datatype;
    public $title;
    public $permalink;
    public $no_reload;
    public $is_premium;
    public $is_file_template;
    public $is_restoration_point;
    public $use_custom_page_template_preview;
    public $plugin_update_required;
    public $external_plugin_required;
    public $required_plugin_names;

    public function __construct($template)
    {
        $this->id = isset($template->id) ? $template->id : false;
        $this->slug = isset($template->slug) ? $template->slug : $this->id;
        $this->type = isset($template->type) ? $template->type : false;
        $this->datatype = isset($template->datatype) ? $template->datatype : $this->type;
        if ($this->slug === 'front-page') {
            $this->datatype = 'front-page';
        }
        $this->title = isset($template->title) ? $template->title : false;
        $this->permalink = isset($template->permalink) ? $template->permalink : get_home_url();
        $this->no_reload = isset($template->no_reload) ? $template->no_reload : false;
        $this->is_premium = isset($template->is_premium) ? $template->is_premium : false;
        $this->plugin_update_required = isset($template->plugin_update_required) && $template->plugin_update_required;
        $this->external_plugin_required = isset($template->external_plugin_required) && $template->external_plugin_required;
        $this->required_plugin_names = isset($template->required_plugin_names) ? $template->required_plugin_names : array();
        $this->is_file_template = false;
        $this->is_restoration_point = false;
        $this->use_custom_page_template_preview = isset($template->use_custom_page_template_preview) ? $template->use_custom_page_template_preview : 0;
    }

    public function GetId()
    {
        if ($this->is_file_template) {
            return $this->id . WizardItemIdAffix::FILE_TEMPLATE;
        }
        if ($this->is_restoration_point) {
            return $this->id . WizardItemIdAffix::RESTORATION_POINT;
        }
        return $this->id;
    }

    public function GetSlug()
    {
        if ($this->is_file_template) {
            return $this->slug . WizardItemIdAffix::FILE_TEMPLATE;
        }
        if ($this->is_restoration_point) {
            return $this->GetId();
        }
        return $this->slug;
    }

    public function GetBaseSlug()
    {
        return $this->slug;
    }

    public function SetSlug($slug)
    {
        $this->slug = $slug;
    }

    public function IsPattern()
    {
        return $this->type === WizardItemTypes::PATTERN || $this->type === WizardItemTypes::WP_TEMPLATE_PART;
    }

    public function GetPreviewURL()
    {
        return add_query_arg(array(WizardTemplatePreviewController::TEMPLATE_PREVIEW_KEY => $this->GetId(), WizardTemplatePreviewController::TEMPLATE_TYPE_KEY => $this->type, WizardTemplatePreviewController::USE_PAGE_TEMPLATE_KEY => $this->use_custom_page_template_preview, 'superb-preview-time' => time()), $this->permalink);
    }
}
