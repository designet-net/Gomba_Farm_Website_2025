<?php

namespace SuperbAddons\Data\Utils\Wizard;

use SuperbAddons\Admin\Controllers\Wizard\WizardController;

defined('ABSPATH') || exit();

class WizardStageUtil
{
    private $type;
    private $stages;
    private $hasPatterns;
    private $hasPages;
    private $isRestore;

    private $stageUtil;

    public function __construct($type = false)
    {
        $this->type = $type ? $type : $_GET[WizardController::ACTION_QUERY_PARAM];
        $this->Init();
    }

    private function Init()
    {
        // Set stages
        switch ($this->type) {
            case WizardActionParameter::THEME_DESIGNER:
                $this->hasPages = true;
                $this->hasPatterns = true;
                $this->isRestore = false;
                $this->stages = array_merge(WizardStageTypes::ALL_STAGES, array(WizardStageTypes::COMPLETION_STAGE));
                break;
            case WizardActionParameter::HEADER_FOOTER:
                $this->hasPages = false;
                $this->hasPatterns = true;
                $this->isRestore = false;
                $this->stages = [
                    WizardStageTypes::HEADER_STAGE,
                    WizardStageTypes::FOOTER_STAGE,
                    WizardStageTypes::COMPLETION_STAGE
                ];
                break;
            case WizardActionParameter::WOOCOMMERCE_HEADER:
                $this->hasPages = false;
                $this->hasPatterns = true;
                $this->isRestore = false;
                $this->stages = [
                    WizardStageTypes::HEADER_STAGE,
                    WizardStageTypes::COMPLETION_STAGE
                ];
                break;
            case WizardActionParameter::ADD_NEW_PAGES:
                $this->hasPages = true;
                $this->hasPatterns = false;
                $this->isRestore = false;
                $this->stages = [
                    WizardStageTypes::TEMPLATE_PAGE_STAGE,
                    WizardStageTypes::NAVIGATION_MENU_STAGE,
                    WizardStageTypes::COMPLETION_STAGE
                ];
                break;
            case WizardActionParameter::RESTORE:
                $this->hasPages = false;
                $this->hasPatterns = false;
                $this->isRestore = true;
                $this->stages = [
                    WizardStageTypes::HEADER_STAGE,
                    WizardStageTypes::FOOTER_STAGE,
                    WizardStageTypes::FRONT_PAGE_STAGE,
                    WizardStageTypes::BLOG_PAGE_STAGE,
                    WizardStageTypes::COMPLETION_STAGE
                ];
                break;
        }
    }

    public function InitializeTemplates()
    {
        $this->stageUtil = new WizardTemplateProvider();

        if ($this->HasPatterns()) {
            if ($this->GetType() === WizardActionParameter::WOOCOMMERCE_HEADER) {
                $this->stageUtil->InitializePatterns("woocommerce/woocommerce.php");
            } else {
                $this->stageUtil->InitializePatterns();
            }
        }

        if ($this->HasPages()) {
            $this->stageUtil->InitalizePageTemplates();
        }

        if ($this->IsRestore()) {
            $this->stageUtil->InitializeRestorationTemplates();
        }
    }

    public function GetStageUtil()
    {
        return $this->stageUtil;
    }

    /**
     * Get the value of type
     */
    public function GetType()
    {
        return $this->type;
    }

    /**
     * Get the value of stages
     */
    public function GetStages()
    {
        return $this->stages;
    }

    /**
     * Get the value of hasPatterns
     */
    public function HasPatterns()
    {
        return $this->hasPatterns;
    }

    /**
     * Get the value of hasPages
     */
    public function HasPages()
    {
        return $this->hasPages;
    }

    /**
     * Get the value of isRestore
     */
    public function IsRestore()
    {
        return $this->isRestore;
    }

    public function HasPageStages()
    {
        return !empty(array_intersect($this->stages, WizardStageTypes::PAGE_STAGES));
    }

    public function GetAvailableConfiguredStages()
    {
        $available_stages = [];
        $stage_configs = $this->GetStageConfigs();
        foreach ($this->stages as $stage_type) {
            if (!array_key_exists($stage_type, $stage_configs)) {
                continue;
            }

            if (!$stage_configs[$stage_type]['enabled']) {
                continue;
            }

            $available_stages[$stage_type] = $stage_configs[$stage_type];
        }

        return $available_stages;
    }

    private function GetStageConfigs()
    {
        $displayReplaceMenu = $this->GetType() === WizardActionParameter::THEME_DESIGNER;
        $displayAppendMenu = WizardCreationUtil::GetNavigationTemplatePartMenuId('header') !== false;

        return [
            WizardStageTypes::HEADER_STAGE => [
                'enabled' => !empty($this->stageUtil->GetHeaderTemplates()),
                'templates' => $this->stageUtil->GetHeaderTemplates(),
                'type' => 'single-selection',
                'required' => true,
                'has-title-input' => false,
                'icon' => 'wizard-menu-layout.svg',
                'lockable' => false,
                'label' => __("Menu Layout", "superb-blocks"),
            ],
            WizardStageTypes::FOOTER_STAGE => [
                'enabled' => !empty($this->stageUtil->GetFooterTemplates()),
                'templates' => $this->stageUtil->GetFooterTemplates(),
                'type' => 'single-selection',
                'required' => true,
                'has-title-input' => false,
                'icon' => 'wizard-footer-layout.svg',
                'lockable' => false,
            ],
            WizardStageTypes::FRONT_PAGE_STAGE => [
                'enabled' => !empty($this->stageUtil->GetFrontPageTemplates()),
                'templates' => $this->stageUtil->GetFrontPageTemplates(),
                'type' => 'single-selection',
                'required' => true,
                'has-title-input' => $this->GetType() !== WizardActionParameter::RESTORE,
                'icon' => 'wizard-front-page-design.svg',
                'input-suggestion' => __('Home', "superb-blocks"),
                'lockable' => false,
            ],
            WizardStageTypes::BLOG_PAGE_STAGE => [
                'enabled' => !empty($this->stageUtil->GetBlogTemplates()),
                'templates' => $this->stageUtil->GetBlogTemplates(),
                'type' => 'single-selection',
                'required' => true,
                'has-title-input' => $this->GetType() !== WizardActionParameter::RESTORE,
                'icon' => 'wizard-blog-setup.svg',
                'input-suggestion' => __('Blog', "superb-blocks"),
                'lockable' => true,
            ],
            WizardStageTypes::TEMPLATE_PAGE_STAGE => [
                'enabled' => !empty($this->stageUtil->GetTemplatePages()),
                'templates' => $this->stageUtil->GetTemplatePages(),
                'type' => 'multi-selection',
                'required' => $this->GetType() === WizardActionParameter::ADD_NEW_PAGES,
                'has-title-input' => $this->GetType() !== WizardActionParameter::RESTORE,
                'icon' => 'wizard-additional-pages.svg',
                'lockable' => false,
            ],
            WizardStageTypes::NAVIGATION_MENU_STAGE => [
                'enabled' => $displayReplaceMenu || $displayAppendMenu,
                'templates' => [],
                'type' => 'radio-checkbox',
                'required' => true,
                'has-title-input' => false,
                'icon' => 'wizard-menu-layout.svg',
                'unique_render' => true,
                'args' => [$displayReplaceMenu, $displayAppendMenu]
            ],
            WizardStageTypes::COMPLETION_STAGE => [
                'enabled' => true,
                'templates' => [],
                'type' => 'completion',
                'required' => false,
                'has-title-input' => false,
                'icon' => 'superbthemes-wizard-checklist.svg',
                'unique_render' => true
            ]
        ];
    }

    public function GetStageTitle($stageType)
    {
        $titles = [
            WizardStageTypes::HEADER_STAGE => [
                'default' => __("Select Menu Layout", "superb-blocks"),
                WizardActionParameter::RESTORE => __("Restore Header", "superb-blocks")
            ],
            WizardStageTypes::FOOTER_STAGE => [
                'default' => __("Select Footer Layout", "superb-blocks"),
                WizardActionParameter::RESTORE => __("Restore Footer", "superb-blocks")
            ],
            WizardStageTypes::FRONT_PAGE_STAGE => [
                'default' => __("Select Front Page", "superb-blocks"),
                WizardActionParameter::RESTORE => __("Restore Front Page", "superb-blocks")
            ],
            WizardStageTypes::BLOG_PAGE_STAGE => [
                'default' => __("Select Blog", "superb-blocks"),
                WizardActionParameter::RESTORE => __("Restore Blog", "superb-blocks")
            ],
            WizardStageTypes::TEMPLATE_PAGE_STAGE => [
                'default' => __("Select Additional Pages", "superb-blocks"),
                WizardActionParameter::ADD_NEW_PAGES => __("Select Pages", "superb-blocks"),
            ],
            WizardStageTypes::NAVIGATION_MENU_STAGE => [
                'default' => __("Update Navigation Menu", "superb-blocks")
            ],
            WizardStageTypes::COMPLETION_STAGE => [
                'default' => __("Summary", "superb-blocks")
            ]
        ];

        if (!isset($titles[$stageType][$this->GetType()])) {
            return $titles[$stageType]['default'];
        }

        return $titles[$stageType][$this->GetType()];
    }

    public function GetStageDescription($stageType)
    {
        $descriptions = [
            WizardStageTypes::HEADER_STAGE => [
                'default' => __("Select the menu layout you want to use as your header template. Colors will match your theme style after the setup is complete.", "superb-blocks"),
                WizardActionParameter::RESTORE => __("Restore the header template to a previous state, or keep the current template.", "superb-blocks"),
            ],
            WizardStageTypes::FOOTER_STAGE => [
                'default' => __("Select the footer layout you want to use as your footer template. Colors will match your theme style after the setup is complete.", "superb-blocks"),
                WizardActionParameter::RESTORE => __("Restore the footer template to a previous state, or keep the current template.", "superb-blocks"),
            ],
            WizardStageTypes::FRONT_PAGE_STAGE => [
                'default' => __("Select the page template you want to use as your front page. The front page template has been automatically chosen, if available.", "superb-blocks"),
                WizardActionParameter::RESTORE => __("Restore the front page template to a previous state, or keep the current template.", "superb-blocks"),
            ],
            WizardStageTypes::BLOG_PAGE_STAGE => [
                'default' => __("Select the blog template you want to use as your blog page. The blog page template has been automatically chosen, if available. If you've selected a blog template as your front page, a separate blog page cannot be selected.", "superb-blocks"),
                WizardActionParameter::RESTORE => __("Restore the home or index template to a previous state, or keep the current template.", "superb-blocks"),
            ],
            WizardStageTypes::TEMPLATE_PAGE_STAGE => [
                'default' => __("Select the additional pages you'd like to have added to your website, if any.", "superb-blocks"),
                WizardActionParameter::ADD_NEW_PAGES => __("Select the pages you'd like to have added to your website.", "superb-blocks"),
            ],
            WizardStageTypes::NAVIGATION_MENU_STAGE => [
                'default' => __("Choose how you'd like to handle the theme navigation menu items, if a navigation block is available in the theme header template.", "superb-blocks"),
            ],
            WizardStageTypes::COMPLETION_STAGE => [
                'default' => __("Here’s a summary of your selections. If everything looks good, simply complete the Theme Designer to finalize your choices.", "superb-blocks"),
                WizardActionParameter::RESTORE => __("Here’s a summary of your selections. If everything looks good, simply complete the restoration to finalize your choices.", "superb-blocks"),
                WizardActionParameter::THEME_DESIGNER => __("Here’s a summary of your selections, where you can also update the page titles. If everything looks good, simply complete the Theme Designer to finalize your choices.", "superb-blocks"),
                WizardActionParameter::ADD_NEW_PAGES => __("Here’s a summary of your selected pages, where you can also update the page titles. If everything looks good, simply complete the Theme Designer to finalize your choices.", "superb-blocks"),
            ]
        ];

        if (!isset($descriptions[$stageType][$this->GetType()])) {
            return $descriptions[$stageType]['default'];
        }

        return $descriptions[$stageType][$this->GetType()];
    }

    public function GetStageLabel($stageType)
    {
        $labels = [
            WizardStageTypes::HEADER_STAGE => [
                'default' => __("Header", "superb-blocks"),
            ],
            WizardStageTypes::FOOTER_STAGE => [
                'default' => __("Footer", "superb-blocks"),
            ],
            WizardStageTypes::FRONT_PAGE_STAGE => [
                'default' => __("Front Page", "superb-blocks"),
            ],
            WizardStageTypes::BLOG_PAGE_STAGE => [
                'default' => __("Blog Page", "superb-blocks"),
            ],
            WizardStageTypes::TEMPLATE_PAGE_STAGE => [
                'default' => __("Additional Pages", "superb-blocks"),
                WizardActionParameter::ADD_NEW_PAGES => __("Pages", "superb-blocks"),
            ],
            WizardStageTypes::NAVIGATION_MENU_STAGE => [
                'default' => __("Navigation Menu", "superb-blocks"),
            ],
            WizardStageTypes::COMPLETION_STAGE => [
                'default' => __("Summary", "superb-blocks"),
            ]
        ];

        if (!isset($labels[$stageType][$this->GetType()])) {
            return $labels[$stageType]['default'];
        }

        return $labels[$stageType][$this->GetType()];
    }
}
