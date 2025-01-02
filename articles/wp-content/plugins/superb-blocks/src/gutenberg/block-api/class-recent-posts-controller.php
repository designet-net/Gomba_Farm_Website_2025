<?php

namespace SuperbAddons\Gutenberg\BlocksAPI\Controllers;

use SuperbAddons\Data\Controllers\LogController;
use Exception;

defined('ABSPATH') || exit();

class RecentPostsController
{
    public static function DynamicRender($attributes, $content)
    {
        try {
            if ((!$attributes['displayBlockOnFront'] && is_front_page()) ||
                (!$attributes['displayBlockOnBlog'] && is_home()) ||
                (!$attributes['displayBlockOnPagesPosts'] && !is_front_page() && !is_home())
            ) {
                return '<!-- Superb Recent Posts Block Hidden -->';
            }
            $excludecurrent = ($attributes['excludeCurrent'] && !is_front_page() && !is_home()) ? array(get_the_ID()) : array();
            $recent_posts_args = array("numberposts" => $attributes['numberOfPosts'], "post_status" => "publish", "exclude" => $excludecurrent);

            if (count($attributes['selectedCategories']) > 0) {
                $recent_posts_args['category__in'] = $attributes['selectedCategories'];
            }
            if (count($attributes['selectedTags']) > 0) {
                $recent_posts_args['tag__in'] = $attributes['selectedTags'];
            }
            $recent_posts_args = apply_filters('superbaddons_recent_posts_block_args', $recent_posts_args, $attributes);

            $recent_posts = wp_get_recent_posts($recent_posts_args);

            return self::Render($attributes, $recent_posts);
        } catch (Exception $ex) {
            LogController::HandleException($ex);
            return;
        }
    }

    private static function Render($attributes, $recent_posts)
    {
        ob_start();

        // If no posts found
        if (count($recent_posts) <= 0) : ?>
            <div class="superbaddons-recentposts-wrapper">
                <p style="font-weight:500;"><?= esc_html__("No posts found", "superbrecentposts"); ?></p>
            </div>
        <?php return ob_get_clean();
        endif;

        // If posts found
        ?>
        <div class="superbaddons-recentposts-wrapper superbaddons-recentposts-alignment-<?= esc_attr($attributes['toolbarAlignment']); ?>">
            <ul class="superbaddons-recentposts-list">
                <?php
                $wrapperTag = $attributes['IsInEditor'] ? 'span' : 'a';
                foreach ($recent_posts as $post) {
                    $permalink = $attributes['IsInEditor'] ? "#" : get_permalink($post['ID']);
                    $the_post_title = $post['post_title'] === '' ? $post['post_name'] : $post['post_title'];
                    $temp_thumbnail_url = get_the_post_thumbnail_url($post['ID'], array($attributes['thumbnailSize'], $attributes['thumbnailSize']));
                    $thumbnail_url = !$temp_thumbnail_url ? SUPERBADDONS_ASSETS_PATH . '/img/post-thumbnail-placeholder.png' : $temp_thumbnail_url;
                ?>
                    <li class="superbaddons-recentposts-item">
                        <<?= $wrapperTag ?> href="<?= esc_url($permalink) ?>" <?= $attributes['linksTargetBlank'] && !$attributes['IsInEditor'] ? 'target="_blank"' : '' ?>>
                            <div class="superbaddons-recentposts-item-inner">
                                <?php if ($attributes['displayThumbnails'] && ($attributes['displayPlaceholderThumbnails'] || $temp_thumbnail_url !== false)) : ?>
                                    <div class="superbaddons-recentposts-item-left">
                                        <img width="<?= esc_attr($attributes['thumbnailSize']) ?>" height="<?= esc_attr($attributes['thumbnailSize']) ?>" src="<?= esc_url($thumbnail_url) ?>" <?= $attributes['imgBorderRadiusEnabled'] ? 'style="border-radius:' . esc_attr($attributes['imgBorderRadius'] / 2) . '%;"' : ""; ?> />
                                    </div>
                                <?php endif; ?>
                                <div class="superbaddons-recentposts-item-right">
                                    <?php if ($attributes['displayDate'] || $attributes['displayAuthor']) : ?>
                                        <!-- Meta -->
                                        <span style="font-size:<?= esc_attr($attributes['fontSizeMeta']) ?>px; color:<?= esc_attr($attributes['colorMeta']) ?>;">
                                            <?php if ($attributes['displayDate']) : ?>
                                                <time class="superbaddons-recentposts-item-date">
                                                    <?= esc_html(get_the_date(get_option('date_format', 'F j, Y'), $post['ID'])); ?>
                                                </time>
                                            <?php endif; ?>
                                            <?php if ($attributes['displayAuthor']) : ?>
                                                <span class="superbaddons-recentposts-item-author">
                                                    <?= esc_html(__("by", "superbrecentposts") . " " . get_the_author_meta($attributes['useAuthorDisplayName'] ? 'display_name' : 'user_nicename', $post['post_author'])); ?>
                                                </span>
                                            <?php endif; ?>
                                        </span>
                                    <?php endif; ?>

                                    <!-- Title -->
                                    <span style="font-size:<?= esc_attr($attributes['fontSizeTitle']) ?>px; color:<?= esc_attr($attributes['colorTitle']) ?>;"><?= esc_html($the_post_title); ?></span>

                                    <?php if ($attributes['displayExcerpt']) : ?>
                                        <!-- Excerpt -->
                                        <span style="font-size:<?= esc_attr($attributes['fontSizeExcerpt']) ?>px; color:<?= esc_attr($attributes['colorExcerpt']) ?>;">
                                            <?= esc_html(wp_trim_words(excerpt_remove_blocks(strip_shortcodes($post['post_content'])), $attributes['excerptLength'], apply_filters('excerpt_more', ' ' . '[&hellip;]'))); ?>
                                        </span>
                                    <?php endif; ?>

                                    <?php if ($attributes['displayCommentCount']) : ?>
                                        <!-- Comment Count -->
                                        <span style="font-size:<?= esc_attr($attributes['fontSizeCommentCount']); ?>px; color:<?= esc_attr($attributes['colorCommentCount']); ?>;">
                                            <?= esc_html(get_comment_count($post['ID'])['approved'] . " " . __("comment(s)", "superbrecentposts")); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </<?= $wrapperTag ?>>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
<?php return ob_get_clean();
    }
}
