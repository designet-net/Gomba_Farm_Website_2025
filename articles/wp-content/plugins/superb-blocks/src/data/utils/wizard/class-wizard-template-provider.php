<?php

namespace SuperbAddons\Data\Utils\Wizard;

use SuperbAddons\Admin\Controllers\Wizard\WizardRestorationPointController;
use SuperbAddons\Data\Controllers\KeyController;
use SuperbAddons\Data\Controllers\RestController;
use SuperbAddons\Library\Controllers\LibraryRequestController;

use WP_REST_Request;

defined('ABSPATH') || exit();

class WizardTemplateProvider
{
    private $headerTemplates;
    private $footerTemplates;
    private $blogTemplates;
    private $homeTemplates;
    private $indexTemplates;
    private $frontPageTemplates;
    private $templatePages;

    private $hasFrontPageTemplate;
    private $hasHomeTemplate;
    private $hasIndexTemplate;

    private $userIsPremium;

    public function __construct()
    {
        $this->headerTemplates = array();
        $this->footerTemplates = array();
        $this->blogTemplates = array();
        $this->homeTemplates = array();
        $this->indexTemplates = array();
        $this->frontPageTemplates = array();
        $this->templatePages = array();

        $this->hasFrontPageTemplate = false;
        $this->hasHomeTemplate = false;
        $this->hasIndexTemplate = false;
        $this->userIsPremium = KeyController::HasValidPremiumKey();
    }

    private function HasModifiedTemplate($slug, $template_type)
    {
        $modifiedTemplatePost = get_posts(
            array(
                'post_type' => $template_type,
                'name' => $slug,
                'posts_per_page' => 1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'wp_theme',
                        'field' => 'slug',
                        'terms' => get_stylesheet()
                    )
                )
            )
        );

        return $modifiedTemplatePost && !empty($modifiedTemplatePost) && $modifiedTemplatePost[0]->post_name === $slug;
    }

    private function InitializePart($slugOrWizardItem, $type, $regularTitle, $modifiedTitle)
    {

        if ($slugOrWizardItem instanceof WizarditemRestorationPoint) {
            $this->AddToAppropriateArray($slugOrWizardItem, $slugOrWizardItem->GetBaseSlug());
            return;
        }

        $datatype = false;
        if ($slugOrWizardItem instanceof WizardItem) {
            $datatype = $slugOrWizardItem->datatype;
            $slug = $slugOrWizardItem->GetBaseSlug();
        } else {
            $slug = $slugOrWizardItem;
        }

        $partTemplate = get_block_template(get_stylesheet() . '//' . $slug, $type);

        $hasModifiedPart = $this->HasModifiedTemplate($slug, $type);
        if ($partTemplate) {
            $partItem = new WizardItemTemplate($partTemplate, $regularTitle, $modifiedTitle, $hasModifiedPart);
            if ($datatype) {
                $partItem->datatype = $datatype;
            }

            $this->AddToAppropriateArray($partItem, $slug);
        }
        if ($hasModifiedPart) {
            // Get the original part template from the theme file
            $themePartItem = new WizardItemFile($slug, $type, $regularTitle);
            if ($datatype) {
                $partItem->datatype = $datatype;
            }
            $this->AddToAppropriateArray($themePartItem, $slug);
        }
    }

    public function InitializePatterns($required_plugin = false)
    {
        // Check if the theme has a modified header template part post
        $this->InitializePart('header', WizardItemTypes::WP_TEMPLATE_PART, __("Header (Theme)", "superb-blocks"), __("Header (Current)", "superb-blocks"));
        $this->InitializePart('footer', WizardItemTypes::WP_TEMPLATE_PART, __("Footer (Theme)", "superb-blocks"), __("Footer (Current)", "superb-blocks"));

        try {
            $request = new WP_REST_Request('GET', '/' . RestController::NAMESPACE . LibraryRequestController::GUTENBERG_LIST_ROUTE . 'patterns');
            $patterns_response = rest_do_request($request);
            if (!$patterns_response || is_wp_error($patterns_response) || $patterns_response->is_error() || !isset($patterns_response->data) || !isset($patterns_response->data->items)) {
                throw new WizardException(__("An error occurred while fetching available patterns.", "superb-blocks"));
            }

            // Order free to the top of list array if the user is not premium
            if (!$this->userIsPremium) {
                $freePatterns = array();
                $premiumPatterns = array();
                foreach ($patterns_response->data->items as $pattern) {
                    if (isset($pattern->package) && $pattern->package === 'premium') {
                        $premiumPatterns[] = $pattern;
                    } else {
                        $freePatterns[] = $pattern;
                    }
                }
                $patterns_response->data->items = array_merge($freePatterns, $premiumPatterns);
            }
            // Get header and footer templates from patterns
            foreach ($patterns_response->data->items as $pattern) {
                if ($required_plugin && !isset($pattern->required_plugins) || $required_plugin && !in_array($required_plugin, $pattern->required_plugins)) {
                    continue;
                }
                $patternItem = new WizardItemPattern($pattern);
                foreach ($pattern->categories as $category) {
                    if ($category->id === WizardDataCategory::NAVIGATION) {
                        $this->headerTemplates[] = $patternItem;
                    } else if ($category->id === WizardDataCategory::FOOTER) {
                        $this->footerTemplates[] = $patternItem;
                    }
                }
            }
        } catch (WizardException $e) {
            // Exception is automatically logged. Catch it so that the wizard can continue with the available theme templates.
        }
    }

    public function InitalizePageTemplates()
    {
        $acceptedTemplates = $this->GetAcceptedTemplates();

        // Initial sort templates by slug
        $this->SortTemplatesIntoArraysBySlug($acceptedTemplates);

        // Additional template logic
        $this->HandleTemplateLogic();

        // Add addons service templates
        try {
            $request = new WP_REST_Request('GET', '/' . RestController::NAMESPACE . LibraryRequestController::GUTENBERG_LIST_ROUTE . 'pages');
            $pages_response = rest_do_request($request);
            if (!$pages_response || is_wp_error($pages_response) || $pages_response->is_error() || !isset($pages_response->data) || !isset($pages_response->data->items)) {
                throw new WizardException(__("An error occurred while fetching available pages.", "superb-blocks"));
            }

            // Order free to the top of list array if the user is not premium
            if (!$this->userIsPremium) {
                $freePages = array();
                $premiumPages = array();
                foreach ($pages_response->data->items as $page) {
                    if (isset($page->package) && $page->package === 'premium') {
                        $premiumPages[] = $page;
                    } else {
                        $freePages[] = $page;
                    }
                }
                $pages_response->data->items = array_merge($freePages, $premiumPages);
            }

            foreach ($pages_response->data->items as $page) {
                $pageItem = new WizardItemPage($page);
                $pageItem->use_custom_page_template_preview = 1;
                $this->templatePages[] = $pageItem;

                // Add landing page templates to the front page templates
                foreach ($page->categories as $category) {
                    if ($category->id === WizardDataCategory::LANDING_PAGE) {
                        $landingPageItem = new WizardItemPage($page);
                        $this->frontPageTemplates[] = $landingPageItem;
                    }
                    if ($category->id === WizardDataCategory::BLOG) {
                        $this->blogTemplates[] = $pageItem;
                    }
                }
            }
        } catch (WizardException $e) {
            // Exception is automatically logged. Catch it so that the wizard can continue with the available theme templates.
        }
    }

    private function HandleTemplateLogic($logicType = 'default')
    {
        // Check for static pages
        $has_static_pages = get_option('show_on_front') === 'page';
        $staticFrontPageID = get_option('page_on_front');
        $hasStaticFrontPage = $has_static_pages && $staticFrontPageID && $staticFrontPageID !== 0;
        $staticBlogPageID = get_option('page_for_posts');
        $hasStaticBlogPage = $has_static_pages && $staticBlogPageID && $staticBlogPageID !== 0;

        if ($logicType === "default") {
            // Front page templates additional logic
            if (!$this->hasFrontPageTemplate) {
                // If no front page template exists, set regular theme templates
                $this->frontPageTemplates = $this->templatePages;

                if ($hasStaticFrontPage) {
                    $static_page = new WizardItemStatic(__("Static Homepage (Current)", "superb-blocks"), $staticFrontPageID);
                    $this->frontPageTemplates = array_merge(array($static_page), $this->frontPageTemplates);
                }
            }

            // Add "No blog page" selection
            $noBlogPage = array(new WizardItemIgnore(__("No Blog Page", "superb-blocks")));
            // Blog templates logic
            if ($this->hasHomeTemplate || $this->hasIndexTemplate) {
                $this->blogTemplates = array_merge($noBlogPage, $this->homeTemplates, $this->indexTemplates, $this->blogTemplates);
            } else {
                if ($hasStaticBlogPage) {
                    $static_page = array(new WizardItemStatic(__("Static Blog Page (Current)", "superb-blocks"), $staticBlogPageID));
                    $this->blogTemplates = array_merge($noBlogPage, $static_page);
                } else {
                    $this->blogTemplates = $noBlogPage;
                }
            }

            // If home templates exist and no front page template exists, add the home templates to the front page templates
            if (!empty($this->homeTemplates) && !$this->hasFrontPageTemplate) {
                if ($hasStaticFrontPage) {
                    // Add the home templates after the first item
                    array_splice($this->frontPageTemplates, 1, 0, $this->homeTemplates);
                } else {
                    // Add the home templates to the front of the front page templates
                    $this->frontPageTemplates = array_merge($this->homeTemplates, $this->frontPageTemplates);
                }
            }
        }

        if ($logicType === "restoration") {
            if (!empty($this->headerTemplates)) {
                $currentHeader = get_block_template(get_stylesheet() . '//' . 'header', WizardItemTypes::WP_TEMPLATE_PART);
                $currentHeader->title = $currentHeader->title . __(" (Current)", "superb-blocks");
                $currentHeader = new WizardItem($currentHeader);
                $this->headerTemplates = array_merge(array($currentHeader), $this->headerTemplates);
            }

            if (!empty($this->footerTemplates)) {
                $currentFooter = get_block_template(get_stylesheet() . '//' . 'footer', WizardItemTypes::WP_TEMPLATE_PART);
                $currentFooter->title = $currentFooter->title . __(" (Current)", "superb-blocks");
                $currentFooter = new WizardItem($currentFooter);
                $this->footerTemplates = array_merge(array($currentFooter), $this->footerTemplates);
            }


            if (!empty($this->frontPageTemplates)) {
                if ($this->hasFrontPageTemplate) {
                    $currentFrontPage = get_block_template(get_stylesheet() . '//' . 'front-page', WizardItemTypes::WP_TEMPLATE);
                    $currentFrontPage->title = $currentFrontPage->title . __(" (Current)", "superb-blocks");
                    $currentFrontPage = new WizardItem($currentFrontPage);
                    $this->frontPageTemplates = array_merge(array($currentFrontPage), $this->frontPageTemplates);
                }
            }

            $this->blogTemplates = array_merge($this->homeTemplates, $this->indexTemplates, $this->blogTemplates);
            if (!empty($this->blogTemplates)) {
                if ($this->hasHomeTemplate) {
                    $currentBlogPage = get_block_template(get_stylesheet() . '//' . 'home', WizardItemTypes::WP_TEMPLATE);
                } elseif ($this->hasIndexTemplate) {
                    $currentBlogPage = get_block_template(get_stylesheet() . '//' . 'index', WizardItemTypes::WP_TEMPLATE);
                }

                if ($currentBlogPage) {
                    $currentBlogPage->datatype = 'blog';
                    $currentBlogPage->title = $currentBlogPage->title . __(" (Current)", "superb-blocks");
                    $currentBlogPage = new WizardItem($currentBlogPage);
                    $this->blogTemplates = array_merge(array($currentBlogPage), $this->blogTemplates);
                }
            }
        }
    }

    private function GetAcceptedTemplates()
    {
        $templates = get_block_templates();
        $acceptedTemplates = array();
        // Filter out templates that are not accepted for the current theme
        foreach ($templates as $template) {
            if ($template->status !== 'publish') continue;
            if ($template->type !== WizardItemTypes::WP_TEMPLATE) continue;
            if ($template->theme !== get_stylesheet()) continue;
            if ($template->slug === AddonsPageTemplateUtil::TEMPLATE_ID) continue; // Do not include the wizard page creation template
            if ($template->slug !== 'front-page' && $template->slug !== 'home' && $template->slug !== 'index') {
                if (!$template->is_custom) continue;
                if (!$template->post_types || !in_array('page', $template->post_types)) continue;
            }
            $acceptedTemplates[] = new WizardItem($template);
        }
        return $acceptedTemplates;
    }

    public function InitializeRestorationTemplates()
    {
        $theme_restoration = WizardRestorationPointController::GetThemeRestorationPoints();
        if (!$theme_restoration) {
            return;
        }

        $restoration_templates = [];
        foreach ($theme_restoration as $restorationId => $restorationPointArray) {
            $restoration_templates[] = new WizarditemRestorationPoint($restorationId, $restorationPointArray);
        }

        // Sort restoration templates by timestamp
        usort($restoration_templates, function ($a, $b) {
            return $a->timestamp <=> $b->timestamp;
        });

        $this->SortTemplatesIntoArraysBySlug($restoration_templates, "restoration");
        $this->HandleTemplateLogic('restoration');
    }

    private function SortTemplatesIntoArraysBySlug($acceptedTemplates, $logicType = "default")
    {
        foreach ($acceptedTemplates as $template) {
            $slug = $template->GetBaseSlug();

            if ($slug === 'front-page' || $slug === 'home' || $slug === 'index') {
                switch ($slug) {
                    case "front-page":
                        $base_label = __("Front Page", "superb-blocks");
                        break;
                    case "home":
                        $template->datatype = 'blog';
                        $base_label = __("Blog Home", "superb-blocks");
                        break;
                    case "index":
                        $template->datatype = 'blog';
                        $base_label = __("Index", "superb-blocks");
                        break;
                }
                $this->InitializePart($template, WizardItemTypes::WP_TEMPLATE, $base_label . __(" (Theme)", "superb-blocks"), $base_label . __(" (Current)", "superb-blocks"));
            } else {
                if ($logicType === "default") {
                    $template->title = $template->title . ' (' . __('Theme', 'superb-blocks') . ')';
                }
                $this->AddToAppropriateArray($template, $slug);
            }
        }
    }

    private function AddToAppropriateArray($item, $slug)
    {
        switch ($slug) {
            case 'header':
                $this->headerTemplates[] = $item;
                break;
            case 'footer':
                $this->footerTemplates[] = $item;
                break;
            case 'front-page':
                $this->hasFrontPageTemplate = true;
                $this->frontPageTemplates[] = $item;
                break;
            case 'home':
                $this->hasHomeTemplate = true;
                $this->homeTemplates[] = $item;
                break;
            case 'index':
                $this->hasIndexTemplate = true;
                $this->indexTemplates[] = $item;
                break;
            default:
                if (strpos($slug, 'blog') !== false) {
                    $this->blogTemplates[] = $item;
                }
                $this->templatePages[] = $item;
                break;
        }
    }

    public function GetHeaderTemplates()
    {
        return $this->headerTemplates;
    }

    public function GetFooterTemplates()
    {
        return $this->footerTemplates;
    }

    public function GetBlogTemplates()
    {
        return $this->blogTemplates;
    }

    public function GetFrontPageTemplates()
    {
        return $this->frontPageTemplates;
    }

    public function GetTemplatePages()
    {
        return $this->templatePages;
    }
}
