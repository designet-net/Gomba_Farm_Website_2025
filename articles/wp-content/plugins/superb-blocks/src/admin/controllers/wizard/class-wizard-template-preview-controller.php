<?php

namespace SuperbAddons\Admin\Controllers\Wizard;

use SuperbAddons\Config\Capabilities;
use SuperbAddons\Data\Controllers\CacheController;
use SuperbAddons\Data\Utils\CacheTypes;
use SuperbAddons\Data\Utils\GutenbergCache;
use SuperbAddons\Data\Utils\Wizard\AddonsPageTemplateUtil;
use SuperbAddons\Data\Utils\Wizard\WizardItemIdAffix;
use SuperbAddons\Data\Utils\Wizard\WizardItemTypes;
use WP_Query;

defined('ABSPATH') || exit();

class WizardTemplatePreviewController
{
    const TEMPLATE_PREVIEW_KEY = 'superbaddons-template-preview';
    const TEMPLATE_TYPE_KEY = 'superbaddons-template-type';
    const USE_PAGE_TEMPLATE_KEY = 'superbaddons-template-custom';
    const TEMPLATE_PART_PREVIEW_TRANSIENT = 'superbaddons_template_part_preview';

    public static function InitializeTemplatePreview()
    {
        if (is_admin()) {
            return;
        }

        add_action('wp_loaded', function () {
            if (isset($_GET[self::TEMPLATE_PREVIEW_KEY]) && isset($_GET[self::TEMPLATE_TYPE_KEY]) && isset($_GET[self::USE_PAGE_TEMPLATE_KEY])) {
                if (!current_user_can(Capabilities::ADMIN)) return;
                $template_id = $_GET[self::TEMPLATE_PREVIEW_KEY];
                $template_type = $_GET[self::TEMPLATE_TYPE_KEY];
                $template_custom = $_GET[self::USE_PAGE_TEMPLATE_KEY] == 1;
                show_admin_bar(false);
                switch ($template_type) {
                    case WizardItemTypes::WP_TEMPLATE:
                    case WizardItemTypes::WP_TEMPLATE_PART:
                        self::SetPlaceholderFilters($template_id, $template_type);
                        self::PreviewBlockTemplate($template_id, $template_type, $template_custom);
                        exit();
                        break;
                    case WizardItemTypes::PATTERN:
                    case WizardItemTypes::PAGE:
                        self::SetPlaceholderFilters($template_id, $template_type);
                        self::PreviewSuperbTemplate($template_id, $template_type, $template_custom);
                        exit();
                        break;
                    default:
                        // Static preview
                        break;
                }
            }
        });
    }

    private static function SetPlaceholderFilters($template_id, $template_type)
    {
        if ($template_type == WizardItemTypes::WP_TEMPLATE_PART || $template_type == WizardItemTypes::PATTERN) {
            // Enqueue part preview specific styles
            wp_enqueue_style('superbaddons-wizard-part-preview-styles', SUPERBADDONS_ASSETS_PATH . '/css/page-wizard-preview.min.css', array(), SUPERBADDONS_VERSION);
        }
        // Filter the header and footer parts to show a placeholder image instead of the actual content if a preview is requested instead of default theme header/footer.
        self::FilterHeaderFooterPreviewParts();

        // Set the post ID to 0 to prevent the preview from showing the actual content of the page and to prevent Undefined index: postId in /wp-includes/blocks/comments.php on line 31
        add_filter("render_block_context", function ($context) {
            if (isset($context['postId'])) {
                return $context;
            }
            $context['postId'] = 0;
            return $context;
        });

        add_filter('the_title', function ($title) use ($template_type, $template_id) {
            if (!empty($title)) {
                return $title;
            }
            if ($template_type === WizardItemTypes::WP_TEMPLATE) {
                $template = get_block_template($template_id, WizardItemTypes::WP_TEMPLATE);
                if ($template) {
                    return $template->title;
                }
            }

            return esc_html__("Placeholder Title", "superb-blocks");
        });

        // Replace the post content with a placeholder content for preview
        add_filter("the_content", function ($content) {
            return sprintf('<!-- wp:heading {"level":1,"style":{"spacing":{"padding":{"top":"50px","bottom":"50px","left":"50px","right":"50px"}}}} --> <h1 class="wp-block-heading" style="padding-top:50px;padding-right:50px;padding-bottom:50px;padding-left:50px">%s</h1> <!-- /wp:heading -->', esc_html__("This is a preview of the template. Any page content that you create will appear here.", "superb-blocks"));
        }, 10);

        // Replace the posts with a placeholder title and placeholder content for preview
        add_filter('the_posts', function ($posts, $query) {
            if (!isset($query->query)) {
                return $posts;
            }

            if (isset($query->query['post_type']) && $query->query['post_type'] !== 'post') {
                return $posts;
            }

            $amount = isset($query->query['posts_per_page']) ? $query->query['posts_per_page'] : 3;
            $amount = ($amount === -1) ? 3 : min($amount, 10);

            $placeholder_posts = array();
            for ($i = 0; $i < $amount; $i++) {
                // Create a placeholder post
                $placeholder_posts[] = (object)array(
                    'post_title' => esc_html__("Placeholder Post", "superb-blocks") . " " . ($i + 1),
                    'post_content' => '',
                    'post_status' => 'publish',
                    'post_type' => 'post',
                    'post_author' => 1,
                    'post_date' => date('Y-m-d H:i:s'),
                );
            }
            return $placeholder_posts;
        }, 10, 2);

        // Replace the post thumbnail with a placeholder for preview
        add_filter("post_thumbnail_html", function () {
            return self::GetPlaceholderPreviewImage();
        }, 0, 0);

        // Replace featured image in "Featured Image" blocks with a placeholder for preview
        add_filter("render_block", function ($block_content, $block) {
            if (isset($block['blockName']) && $block['blockName'] === 'core/post-featured-image' && empty($block_content)) {
                return '<figure class="alignwide wp-block-post-featured-image">' . self::GetPlaceholderPreviewImage() . '</figure>';
            }
            return $block_content;
        }, 10, 2);

        // Start global wp_query query to make sure placeholder posts are shown.
        global $wp_query;
        if (!$wp_query || !$wp_query instanceof WP_Query) {
            return;
        }
        $wp_query = new WP_Query([
            'post_type' => 'post',
        ]);
    }

    private static function GetPlaceholderPreviewImage()
    {
        return '<img width="1900" height="1267" src="' . esc_url(SUPERBADDONS_ASSETS_PATH . "/img/placeholder-image.svg") . '" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" style="height:100%;object-fit:cover;">';
    }

    private static function PreviewBlockTemplate($template_id, $template_type = WizardItemTypes::WP_TEMPLATE)
    {
        if (strpos($template_id, WizardItemIdAffix::FILE_TEMPLATE) !== false) {
            // If the template is a file template, get the file template preview.
            $template_id = str_replace(WizardItemIdAffix::FILE_TEMPLATE, '', $template_id);
            self::PreviewBlockFileTemplate($template_id, $template_type);
            return;
        }

        if (strpos($template_id, WizardItemIdAffix::RESTORATION_POINT) !== false) {
            // If the template is a restoration point, get the restoration point preview.
            $template_id = str_replace(WizardItemIdAffix::RESTORATION_POINT, '', $template_id);
            self::PreviewRestorationPoint($template_id);
            return;
        }

        $template = get_block_template($template_id, $template_type);
        if (!$template || $template->type !== $template_type || $template->status !== 'publish' || $template->theme !== get_stylesheet() || empty($template->content)) {
            return;
        }

        $template_html = self::GetTheTemplateHTML($template->content);

        self::RenderTemplateCanvas($template_html);
    }

    private static function PreviewBlockFileTemplate($template_id, $template_type)
    {
        $template = get_block_file_template($template_id, $template_type);
        if ($template->theme !== get_stylesheet() || empty($template->content)) {
            return;
        }

        $template_html = self::GetTheTemplateHTML($template->content);

        self::RenderTemplateCanvas($template_html);
    }

    private static function PreviewRestorationPoint($template_id)
    {
        $restoration_point = WizardRestorationPointController::GetTemplateRestorationPoint($template_id);
        if (!$restoration_point) return;

        $template_html = self::GetTheTemplateHTML($restoration_point['content']);

        self::RenderTemplateCanvas($template_html);
    }

    private static function PreviewSuperbTemplate($template_id, $template_type = WizardItemTypes::PAGE, $template_custom = false)
    {
        //// Get the preview URL from the cache by page id.
        switch ($template_type) {
            case WizardItemTypes::PAGE:
                $cache_type = GutenbergCache::PAGES;
                break;
            case WizardItemTypes::PATTERN:
                $cache_type = GutenbergCache::PATTERNS;
                break;
            default:
                return;
        }
        // The cache has already been set, otherwise the preview will not work and we shouldn't be here.
        $cache = CacheController::GetCache($cache_type, CacheTypes::GUTENBERG);
        if (!$cache || !isset($cache->items)) return;
        $preview_url = false;
        foreach ($cache->items as $template) {
            if ($template->id === $template_id) {
                $preview_url = $template->preview;
                break;
            }
        }

        if (!$preview_url) return;

        $preview_content = '<img src="' . esc_url($preview_url) . '" class="superbaddons-preview-image" width="100%" height="auto" style="user-select:none;">';

        if ($template_type === WizardItemTypes::PAGE) {
            // Override the content with a placeholder content for preview
            if ($template_custom) {
                add_filter("the_content", function () use ($preview_content) {
                    return $preview_content;
                }, PHP_INT_MAX);
                $template = get_block_template(get_stylesheet() . '//' . AddonsPageTemplateUtil::TEMPLATE_ID, WizardItemTypes::WP_TEMPLATE);
                $content = $template->content;
            } else {
                $content = AddonsPageTemplateUtil::GetAddonsPageTemplateContent($preview_content);
            }
        } else {
            // Preview pattern only
            $content = $preview_content;
        }

        $template_html = self::GetTheTemplateHTML($content);

        self::RenderTemplateCanvas($template_html);
    }

    private static function FilterHeaderFooterPreviewParts()
    {
        add_filter('render_block', function ($block_content, $block) {
            if (isset($block['blockName']) && $block['blockName'] === 'core/template-part') {
                if (isset($block['attrs']['slug']) && $block['attrs']['slug'] === 'header') {
                    $header_content = self::GetTemplatePartPreview('header');
                    if ($header_content) {
                        return $header_content;
                    }
                }
                if (isset($block['attrs']['slug']) && $block['attrs']['slug'] === 'footer') {
                    $footer_content = self::GetTemplatePartPreview('footer');
                    if ($footer_content) {
                        return $footer_content;
                    }
                }
            }
            return $block_content;
        }, 10, 2);
    }

    private static function GetTemplatePartPreview($slug)
    {
        $template_part_preview = WizardController::GetPartPreviewTransient();
        if (!$template_part_preview || !isset($template_part_preview[$slug])) {
            return false;
        }

        if (strpos($template_part_preview[$slug], WizardItemIdAffix::FILE_TEMPLATE) !== false) {
            $template_id = get_stylesheet() . '//' . str_replace(WizardItemIdAffix::FILE_TEMPLATE, '', $template_part_preview[$slug]);
            $template = get_block_file_template($template_id, WizardItemTypes::WP_TEMPLATE_PART);
            return self::GetTheTemplateHTML($template->content);
        }

        if (strpos($template_part_preview[$slug], WizardItemIdAffix::RESTORATION_POINT) !== false) {
            $restoration_id = str_replace(WizardItemIdAffix::RESTORATION_POINT, '', $template_part_preview[$slug]);
            $restoration_point = WizardRestorationPointController::GetTemplateRestorationPoint($restoration_id);
            if (!$restoration_point) return false;

            return self::GetTheTemplateHTML($restoration_point['content']);
        }


        if ($template_part_preview[$slug] === $slug || strpos($slug, get_stylesheet()) !== false) return false;

        $cache = CacheController::GetCache(GutenbergCache::PATTERNS, CacheTypes::GUTENBERG);
        if (!$cache || !isset($cache->items)) return false;

        $preview_url = false;
        foreach ($cache->items as $template) {
            if ($template->id === $template_part_preview[$slug]) {
                $preview_url = $template->preview;
                break;
            }
        }

        if (!$preview_url) return false;

        return '<img src="' . esc_url($preview_url) . '" class="superbaddons-preview-image" width="100%" height="auto" style="user-select:none;">';
    }

    private static function GetTheTemplateHTML($content)
    {
        global $_wp_current_template_content;
        $_wp_current_template_content = $content;
        return get_the_block_template_html();
    }

    private static function RenderTemplateCanvas($content)
    {
?>
        <!DOCTYPE html>
        <html <?php language_attributes(); ?>>

        <head>
            <meta charset="<?php bloginfo('charset'); ?>" />
            <?php wp_head(); ?>
        </head>

        <body <?php body_class(); ?>>
            <?php wp_body_open(); ?>

            <?php echo $content; ?>

            <?php wp_footer(); ?>
        </body>

        </html>
<?php
    }
}
