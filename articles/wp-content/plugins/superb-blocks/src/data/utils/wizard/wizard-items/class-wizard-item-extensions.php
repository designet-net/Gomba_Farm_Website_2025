<?php

namespace SuperbAddons\Data\Utils\Wizard;

defined('ABSPATH') || exit();

class WizardItemFile extends WizardItem
{
    public function __construct($slug, $type, $title)
    {
        $file_template = get_block_file_template(get_stylesheet() . '//' . $slug, $type);

        parent::__construct($file_template);
        $this->title = $title;
        $this->type = $type;
        $this->is_file_template = true;

        if ($type === WizardItemTypes::WP_TEMPLATE_PART) {
            $this->no_reload = true;
        }
    }
}

class WizardItemPage extends WizardItem
{
    public function __construct($page)
    {
        parent::__construct($page);
        $this->type = WizardItemTypes::PAGE;
        $this->datatype = WizardItemTypes::PAGE;
        $this->is_premium = isset($page->package) && $page->package === 'premium';
    }
}

class WizardItemPattern extends WizardItem
{
    public function __construct($pattern)
    {
        parent::__construct($pattern);
        $this->type = WizardItemTypes::PATTERN;
        $this->datatype = WizardItemTypes::PATTERN;
        $this->is_premium = isset($pattern->package) && $pattern->package === 'premium';
        $this->no_reload = true;
    }
}


class WizardItemTemplate extends WizardItem
{
    public function __construct($part, $regularTitle, $modifiedTitle, $hasModifiedTemplate)
    {
        parent::__construct($part);
        $this->title = $hasModifiedTemplate ? $modifiedTitle : $regularTitle;
        $this->no_reload = $this->type === WizardItemTypes::WP_TEMPLATE_PART;
    }
}

class WizardItemStatic extends WizardItem
{
    public function __construct($title, $pageId)
    {
        parent::__construct(false);
        $this->id = 'spb-static-page';
        $this->SetSlug('spb-static-page');
        $this->title = $title;
        $this->type = 'static';
        $this->datatype = 'static';
        $this->permalink = get_permalink($pageId);
    }
}

class WizardItemIgnore extends WizardItem
{
    public function __construct($title)
    {
        parent::__construct(false);
        $this->id = false;
        $this->SetSlug('spb-ignore-selection');
        $this->title = $title;
        $this->type = 'ignore';
        $this->datatype = 'ignore';
    }
}

class WizarditemRestorationPoint extends WizardItem
{
    public $timestamp;

    public function __construct($restorationPointId, $restorationPointArray)
    {
        $time_format = get_option('time_format');
        $date_format = get_option('date_format');
        $datetime_format = $time_format && $date_format ? $time_format . ', ' . $date_format : 'H:i, F j, Y';

        parent::__construct(false);
        $this->timestamp = $restorationPointArray['timestamp'];
        $this->id = $restorationPointId;
        $this->SetSlug($restorationPointArray['slug']);
        $this->title = date($datetime_format, $restorationPointArray['timestamp']);
        $this->type = $restorationPointArray['type'];
        $this->datatype = $this->type;
        $this->is_restoration_point = true;
    }
}
