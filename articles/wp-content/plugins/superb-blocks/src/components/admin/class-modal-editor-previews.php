<?php

namespace SuperbAddons\Components\Admin;

defined('ABSPATH') || exit();

class EditorPreviewsModal
{
    public function __construct()
    {
        $this->Render();
    }

    private function Render()
    {
?>
        <div id="superbaddons-dashboard-editor-previews-modal" class="superbaddons-admindashboard-modal-wrapper" style="display:none;">
            <div class="superbaddons-admindashboard-modal-overlay"></div>
            <div class="superbaddons-admindashboard-modal">
                <div class="superbaddons-admindashboard-modal-header">
                    <span class="superbaddons-admindashboard-modal-title superbaddons-element-text-md superbaddons-element-text-800 superbaddons-element-flex-center superbaddons-element-flexwrap"><img class="superbaddons-element-mr1" src="<?= SUPERBADDONS_ASSETS_PATH . "/img/icon-superb.svg"; ?>" /><?= esc_html__("Blocks & WordPress Editor Enhancements", "superb-blocks"); ?></span>
                    <div class="superbaddons-admindashboard-modal-close-button" class="superb-addons-template-library-button superb-addons-template-library-button-secondary"><img src="<?= SUPERBADDONS_ASSETS_PATH . "/img/x.svg"; ?>" alt="<?= esc_attr__("Close", "superb-blocks"); ?>" /></div>
                </div>
                <div class="superbaddons-admindashboard-modal-content superbaddons-element-text-xs">
                    <!-- Editor Highlights -->
                    <?php new ContentBoxLarge(
                        array(
                            "title" => __("Editor Highlights", "superb-blocks"),
                            "description" => __("Unlock the enhanced editor experience with grid systems, improved block control, and much more.", "superb-blocks"),
                            "image" => "editor-highlight.jpg",
                            "icon" => "purple-selection-plus.svg",
                            "class" => 'superbaddons-admindashboard-gutenberg-editor-highlights'
                        )
                    );
                    ?>
                    <!-- Block controls -->
                    <?php new ContentBoxLarge(
                        array(
                            "title" => __("Responsive Block Control", "superb-blocks"),
                            "description" => __("Our premium block control feature allows you to easily hide or show any blocks on desktop, tablet or mobile.", "superb-blocks"),
                            "image" => "block-control.jpg",
                            "icon" => "devices-duotone.svg",
                            "class" => 'superbaddons-admindashboard-gutenberg-block-control'
                        )
                    );
                    ?>
                    <!-- Block animations -->
                    <?php new ContentBoxLarge(
                        array(
                            "title" => __("Animations", "superb-blocks"),
                            "description" => __("Easily animate any WordPress block with over 40+ pre-made animations using our simple block animation settings.", "superb-blocks"),
                            "image" => "block-animations.jpg",
                            "icon" => "monitor-play-duotone.svg",
                            "class" => 'superbaddons-admindashboard-gutenberg-block-control'
                        )
                    );
                    ?>
                    <!-- Rating Block -->
                    <?php new ContentBoxLarge(
                        array(
                            "title" => __("Rating Block", "superb-blocks"),
                            "description" => __("With this easy-to-use block, you can easily add your own ratings with bars and stars to your posts and pages. Simple to customize and style to match your website's look and feel.", "superb-blocks"),
                            "image" => "asset-medium-review.jpg",
                            "icon" => "purple-star.svg",
                            "class" => 'superbaddons-admindashboard-gutenberg-block-box'
                        )
                    );
                    ?>
                    <!-- About the Author Block -->
                    <?php new ContentBoxLarge(
                        array(
                            "title" => __("About the Author Block", "superb-blocks"),
                            "description" => __("Whether you're a blogger, journalist, or content creator, the Superb About the Author block is an essential tool for establishing your online presence and building a connection with your audience. Try it out and make your author bio stand out today!", "superb-blocks"),
                            "image" => "asset-medium-authorbox.jpg",
                            "icon" => "purple-identification-badge.svg",
                            "class" => 'superbaddons-admindashboard-gutenberg-block-box'
                        )
                    );
                    ?>
                    <!-- Table of Contents Block -->
                    <?php new ContentBoxLarge(
                        array(
                            "title" => __("Table of Contents Block", "superb-blocks"),
                            "description" => __("Automatically generates a list of headings and subheadings and makes it easy for your readers to navigate your content. Try it out and make your long-form content more accessible!", "superb-blocks"),
                            "image" => "asset-medium-tableofcontent.jpg",
                            "icon" => "purple-list-bullets.svg",
                            "class" => 'superbaddons-admindashboard-gutenberg-block-box'
                        )
                    );
                    ?>
                    <!-- Recent Posts Block -->
                    <?php
                    new ContentBoxLarge(
                        array(
                            "title" => __("Recent Posts Block", "superb-blocks"),
                            "description" => __("Quickly add a customizable list of your latest posts to any page, post or widget space. The Superb Recent Posts block is a great tool for keeping your readers up-to-date with your latest content and driving traffic to your website.", "superb-blocks"),
                            "image" => "asset-medium-recentposts.jpg",
                            "icon" => "purple-note.svg",
                            "class" => 'superbaddons-admindashboard-gutenberg-block-box superbaddons-admindashboard-gutenberg-block-box-recent-posts'
                        )
                    );
                    ?>
                    <!-- Google Maps Block -->
                    <?php new ContentBoxLarge(
                        array(
                            "title" => __("Google Maps Block", "superb-blocks"),
                            "description" => __("Easily integrate interactive Google Maps into any page, post, or widget space. Showcase your business location and beyond with this powerful and user-friendly tool.", "superb-blocks"),
                            "image" => "asset-large-superbmaps.jpg",
                            "icon" => "purple-pin.svg",
                            "class" => 'superbaddons-admindashboard-gutenberg-block-box superbaddons-admindashboard-gutenberg-block-box-maps'
                        )
                    );
                    ?>
                    <!-- Animated Heading Block -->
                    <?php new ContentBoxLarge(
                        array(
                            "title" => __("Animated Heading Block", "superb-blocks"),
                            "description" => __("Whether you're a blogger, business owner, or designer, this block is the perfect tool to enhance the visual appeal of your site. Elevate your content, boost user engagement, and make a lasting impression.", "superb-blocks"),
                            "image" => "asset-medium-animatedheading.jpg",
                            "icon" => "purple-heading.svg",
                            "class" => 'superbaddons-admindashboard-gutenberg-block-box superbaddons-admindashboard-gutenberg-block-box-animatedheading'
                        )
                    );
                    ?>
                    <!-- Cover Image Block -->
                    <?php new ContentBoxLarge(
                        array(
                            "title" => __("Cover Image Block", "superb-blocks"),
                            "description" => __("Create striking headers and hero sections effortlessly with this user-friendly block. Add captivating cover images to your pages and posts, grabbing your audience's attention from the get-go.", "superb-blocks"),
                            "image" => "asset-large-superbcover.jpg",
                            "icon" => "purple-image.svg",
                            "class" => 'superbaddons-admindashboard-gutenberg-block-box superbaddons-admindashboard-gutenberg-block-box-cover'
                        )
                    );
                    ?>
                    <!-- Reveal Buttons Block -->
                    <?php new ContentBoxLarge(
                        array(
                            "title" => __("Reveal Buttons Block", "superb-blocks"),
                            "description" => __("Quickly and effortlessly create reveal buttons, whether you're a seasoned pro or just starting out. Simply enter your button text, reveal text, and link. Users can then click the button to reveal the hidden text.", "superb-blocks"),
                            "image" => "asset-large-superbrevealbuttons.jpg",
                            "icon" => "purple-pointing.svg",
                            "class" => 'superbaddons-admindashboard-gutenberg-block-box superbaddons-admindashboard-gutenberg-block-box-reveal-buttons'
                        )
                    );
                    ?>
                </div>
            </div>
    <?php
    }
}
