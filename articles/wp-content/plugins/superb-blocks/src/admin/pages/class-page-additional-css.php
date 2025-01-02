<?php

namespace SuperbAddons\Admin\Pages;

defined('ABSPATH') || exit();

use SuperbAddons\Components\Admin\LinkBox;
use SuperbAddons\Components\Admin\ReviewBox;
use SuperbAddons\Admin\Controllers\DashboardController;
use SuperbAddons\Components\Admin\InputCheckbox;
use SuperbAddons\Components\Admin\Modal;
use SuperbAddons\Components\Admin\PremiumBox;
use SuperbAddons\Components\Admin\SupportBox;
use SuperbAddons\Components\Slots\CssBlocksBaseSlot;
use SuperbAddons\Components\Slots\CssBlocksExportSelectedSlot;
use SuperbAddons\Components\Slots\CssBlocksExportSingleSlot;
use SuperbAddons\Components\Slots\CssBlocksTargetSlot;
use SuperbAddons\Data\Controllers\CSSController;

class AdditionalCSSPage
{
    private $Blocks = [];
    private $CurrentCssBlock = false;
    private $IsCreating = false;

    public function __construct()
    {
        $this->Blocks = CSSController::GetBlocks();
        if (isset($_GET['css-edit']) || isset($_GET['css-create'])) {
            if (isset($_GET['css-edit'])) {
                $css_block_id = $_GET['css-edit'];
                // Logic to get the CSS block from the database
                $this->CurrentCssBlock = isset($this->Blocks[$css_block_id]) ? $this->Blocks[$css_block_id] : false;
                if (!$this->CurrentCssBlock) {
                    $this->RenderMainPage();
                    return;
                }
                $this->CurrentCssBlock->id = $css_block_id;
            } else {
                $this->IsCreating = true;
            }

            add_action("admin_footer", array($this, 'RenderLivePreview'));

            $this->RenderEditPage();
        } else {
            $this->RenderMainPage();
        }
    }

    private function RenderEditPage()
    {
        $edit_or_create = $this->IsCreating ? __("Create", "superb-blocks") : __("Edit", "superb-blocks");
?>
        <div class="superbaddons-admindashboard-content-box-large superbaddons-admindashboard-css-blocks">
            <h3 class="superbaddons-element-text-md superbaddons-element-text-800 superbaddons-element-m0 superbaddons-element-mb1 superbaddons-element-text-dark"><?= esc_html(sprintf(__("%s CSS Block", "superb-blocks"), $edit_or_create)); ?><small class="superbaddons-element-ml1 superbaddons-element-text-xs superbaddons-element-text-gray"><?= esc_html__(($this->IsCreating || ($this->CurrentCssBlock && $this->CurrentCssBlock->active) ? "" : "This CSS block is currently deactivated."), "superb-blocks"); ?></small></h3>
            <hr class="superbaddons-element-mb1" />

            <div class="superbaddons-css-block-input-options superbaddons-element-mt1 superbaddons-element-mb2">
                <label for="superbaddons-css-block-name-input" class="superbaddons-element-text-xs superbaddons-element-text-800 superbaddons-element-m0 superbaddons-element-mb1 superbaddons-element-flex-center"><img width="15" class="superbaddons-element-ml1 superbaddons-element-mr1" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/purple-file.svg'); ?>" /><?= esc_html__("CSS Block Name", "superb-blocks"); ?></label>
                <input type="text" id="superbaddons-css-block-name-input" class="superbaddons-element-input superbaddons-element-mb2" placeholder="<?= esc_attr__("My CSS Block", "superb-blocks"); ?>" value="<?= $this->CurrentCssBlock ? esc_attr($this->CurrentCssBlock->name) : ""; ?>" maxlength="<?= esc_attr(CSSController::BLOCK_NAME_MAX_LENGTH); ?>" />

                <div class="superbaddons-css-block-target-inputs-wrapper superbaddons-element-mt1">
                    <label class="superbaddons-element-text-xs superbaddons-element-text-800 superbaddons-element-m0 superbaddons-element-mb1 superbaddons-element-flex-center"><img width="25" class="superbaddons-element-mr1" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/target-duotone.svg'); ?>" /><?= esc_html__("Target", "superb-blocks"); ?></label>
                    <?php new InputCheckbox("superbaddons-css-block-target-input-website", "full", __("Entire website", "superb-blocks"), __("When enabled, your CSS block will be applied to the entire frontend of your website.", "superb-blocks"), true); ?>
                    <div class="superbaddons-element-specific-select-wrapper superbaddons-css-block-specific-target-inputs superbaddons-element-mb1" style="display: none;">
                        <?php new InputCheckbox("superbaddons-css-block-target-input-frontpage", "front", __("Front page", "superb-blocks"), __("Applies CSS block to the front page.", "superb-blocks")); ?>
                        <?php new CssBlocksTargetSlot(); ?>
                    </div>
                </div>
            </div>
            <div class="superbaddons-css-block-css-input-wrapper-outer">
                <div class="superbaddons-css-block-css-input-wrapper superbaddons-element-mt1">
                    <label for="superbaddons-css-block-css-input" class="superbaddons-element-text-xs superbaddons-element-text-800 superbaddons-element-m0 superbaddons-element-mb1 superbaddons-element-flex-center"><img width="25" class="superbaddons-element-mr1" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/purple-paint-brush.svg'); ?>" /><?= esc_html__("CSS", "superb-blocks"); ?></label>
                    <textarea id="superbaddons-css-block-css-input" class="superbaddons-element-textarea superbaddons-element-mb1" rows="10"><?= $this->CurrentCssBlock ? esc_html($this->CurrentCssBlock->css) : ""; ?></textarea>
                    <div class="superbaddons-css-block-allow-unsafe-css-wrapper" style="display:none;">
                        <?php new InputCheckbox("superbaddons-css-block-allow-unsafe-css", "allow-unsafe-css-action", __("Allow Unsafe CSS", "superb-blocks"), __("Your CSS contains unsafe CSS rules. Please double check that the links and URLs used in imports etc. are trusted. In order to save your CSS block containing unsafe CSS, this setting must be enabled. ", "superb-blocks"), false, '/img/color-warning-octagon.svg'); ?>
                    </div>
                </div>
            </div>

            <hr class="superbaddons-element-mb1" />
            <div class="superbaddons-css-block-errors-wrapper superbaddons-element-text-xs spbaddons-admin-text-danger superbaddons-element-mt1 superbaddons-element-mb1" style="display:none;">
                <?= esc_html__("Your CSS Block cannot be saved while errors are present in your CSS."); ?>
            </div>
            <div class="superbaddons-css-block-save-options">
                <button type="button" class="superbaddons-css-block-save-btn superbaddons-element-button superbaddons-element-m0">
                    <img class="superbaddons-element-button-icon" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/floppy-disk-duotone.svg'); ?>" />
                    <?= esc_html__("Save", "superb-blocks"); ?>
                </button>
                <span class="superbaddons-vertical-separator"></span>
                <button type="button" class="superbaddons-css-block-preview-btn superbaddons-element-button superbaddons-element-m0">
                    <img width="20" class="superbaddons-element-button-icon" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/preview.svg'); ?>" />
                    <?= esc_html__("Preview", "superb-blocks"); ?>
                </button>
                <div class="superbaddons-element-mla superbaddons-element-flex-center">
                    <span class="superbaddons-vertical-separator"></span>
                    <div class="superbaddons-created-css-block-options" <?= $this->IsCreating ? 'style="display:none;"' : '' ?>>
                        <?php if ($this->CurrentCssBlock && !$this->CurrentCssBlock->active) : ?>
                            <!-- Activate Selected -->
                            <button class="superbaddons-activate-blocks-btn superbaddons-toggle-activate-blocks-btn superbaddons-element-button superbaddons-element-m0" disabled>
                                <img class="superbaddons-element-button-icon" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/check-circle.svg'); ?>" />
                                <?= esc_html__("Activate", "superb-blocks"); ?>
                            </button>
                        <?php else : ?>
                            <!-- Deactivate Selected -->
                            <button class="superbaddons-deactivate-blocks-btn superbaddons-toggle-activate-blocks-btn superbaddons-element-button superbaddons-element-m0" disabled>
                                <img class="superbaddons-element-button-icon" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/x-circle.svg'); ?>" />
                                <?= esc_html__("Deactivate", "superb-blocks"); ?>
                            </button>
                        <?php endif; ?>
                        <span class="superbaddons-vertical-separator"></span>
                        <?php new CssBlocksExportSingleSlot(); ?>
                        <span class="superbaddons-vertical-separator"></span>
                        <button class="superbaddons-css-block-delete-btn superbaddons-element-button spbaddons-admin-btn-danger superbaddons-element-m0">
                            <img class="superbaddons-element-button-icon" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/trash-light.svg'); ?>" />
                            <?= esc_html__("Delete", "superb-blocks"); ?>
                        </button>
                        <span class="superbaddons-vertical-separator"></span>
                    </div>
                    <a href="<?= esc_url(admin_url("admin.php?page=" . DashboardController::ADDITIONAL_CSS)); ?>" class="superbaddons-css-block-cancel-btn superbaddons-element-button superbaddons-element-m0">
                        <img class="superbaddons-element-button-icon" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/backspace.svg'); ?>" />
                        <?= esc_html__("Cancel", "superb-blocks"); ?>
                    </a>
                </div>

            </div>
        </div>
        <?php new Modal(); ?>
        <?php if ($this->CurrentCssBlock) : ?>
            <script>
                const superbaddons_init_css_block_selectors = <?= json_encode($this->CurrentCssBlock->selectors); ?>;
                const superbaddons_init_css_block_id = <?= json_encode($this->CurrentCssBlock->id); ?>;
            </script>
        <?php endif; ?>
    <?php
    }

    public function RenderLivePreview()
    {
    ?>
        <div id="superbaddons-css-block-live-preview" style="display:none;">
            <div class="superbaddons-css-block-live-preview-container">
                <div class="superbaddons-css-live-preview-menu">
                    <span class="superbaddons-element-text-sm superbaddons-element-text-800"><?= esc_html__("LIVE PREVIEW", "superb-blocks"); ?></span>
                    <button id="superbaddons-preview-reload-button" type="button" class="superbaddons-element-button superbaddons-element-button-small superbaddons-element-m0">
                        <img class="superbaddons-element-button-icon" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/arrow-clockwise-duotone.svg'); ?>" />
                        <?= esc_html__("Reload Preview", "superb-blocks"); ?>
                    </button>
                    <div class="superbaddons-live-preview-close-btn"><img src="<?= SUPERBADDONS_ASSETS_PATH . "/img/x.svg"; ?>" alt="<?= esc_attr__("Close", "superb-blocks"); ?>" /></div>
                </div>
                <div class="superbaddons-spinner-wrapper">
                    <img class="spbaddons-spinner" src="<?= SUPERBADDONS_ASSETS_PATH ?>/img/blocks-spinner.svg" />
                </div>
                <div class="superbaddons-css-block-live-preview-content">
                    <div class="superbaddons-css-block-preview-input">
                        <div style="padding: 0 20px;">
                            <p class="superbaddons-element-text-xxs superbaddons-element-text-gray"><?= esc_html__("While editing, your CSS changes are only visible inside this live preview.", "superb-blocks"); ?></p>
                            <p class="superbaddons-element-text-xxs superbaddons-element-text-gray"><?= esc_html__("Your selected CSS Block targets are not active inside the live preview and your CSS will be previewed on every page and post.", "superb-blocks"); ?></p>
                            <?php if (!$this->IsCreating) : ?>
                                <p class="superbaddons-element-text-gray" style="font-style:italic;font-size:12px;"><?= esc_html__("Do note that the currently saved CSS from this block will be applied during preview, even if the CSS is changed or removed in the preview editor.", "superb-blocks"); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <iframe frameborder="0" src="" data-src="<?= esc_url(wp_customize_url()); ?>" sandbox="allow-forms allow-modals allow-orientation-lock allow-pointer-lock allow-popups allow-popups-to-escape-sandbox allow-presentation allow-same-origin allow-scripts"></iframe>
                </div>
            </div>
        </div>
    <?php
    }

    private function RenderMainPage()
    {
    ?>
        <div class="superbaddons-admindashboard-sidebarlayout">
            <div class="superbaddons-admindashboard-sidebarlayout-left">
                <div class="superbaddons-additional-content-wrapper superbaddons-admindashboard-css-blocks">
                    <h3 class="superbaddons-element-text-md superbaddons-element-text-800 superbaddons-element-m0 superbaddons-element-mb1 superbaddons-element-text-dark"><?= esc_html__("Custom CSS Blocks", "superb-blocks"); ?></h3>
                    <p class="superbaddons-element-text-gray superbaddons-element-text-400 superbaddons-element-m0 superbaddons-element-mb1"><?= esc_html__("Optimize your design and website with CSS blocks by deciding exactly when and where on your website you wish the CSS to be loaded. CSS files will automatically be generated, optimized and loaded to match your settings.", "superb-blocks"); ?></p>
                    <p class="superbaddons-element-text-gray superbaddons-element-text-400 superbaddons-element-m0 superbaddons-element-mb1"><?= esc_html__("Create a new CSS block, import, export or select one you wish to edit.", "superb-blocks"); ?></p>
                    <div class="superbaddons-css-block-base-options">
                        <a href="<?= esc_url(admin_url("admin.php?page=" . DashboardController::ADDITIONAL_CSS . '&css-create')); ?>" class="superbaddons-element-button superbaddons-element-mt1">
                            <img class="superbaddons-element-button-icon" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/purple-files.svg'); ?>" />
                            <?= esc_html__("Create New CSS Block", "superb-blocks"); ?>
                        </a>
                        <span class="superbaddons-vertical-separator"></span>
                        <button class="superbaddons-import-blocks-btn superbaddons-element-button superbaddons-element-mt1">
                            <img class="superbaddons-element-button-icon" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/upload-simple-duotone.svg'); ?>" />
                            <?= esc_html__("Import CSS Blocks", "superb-blocks"); ?>
                        </button>
                        <input type="file" id="superbaddons-import-blocks-file" style="display:none;" accept=".superbaddons" multiple />
                        <?php new CssBlocksBaseSlot(); ?>
                    </div>

                    <h4 class="superbaddons-element-text-sm superbaddons-element-text-800 superbaddons-element-m0 superbaddons-element-mt1 superbaddons-element-text-dark"><?= esc_html__("CSS Blocks", "superb-blocks"); ?></h4>

                    <hr class="superbaddons-element-mb1" />

                    <div class="superbaddons-css-blocks-list">
                        <?php if (empty($this->Blocks)) : ?>
                            <p class="superbaddons-element-text-gray superbaddons-element-text-400 superbaddons-element-m0 superbaddons-element-mb1"><?= esc_html__("You do not have any CSS Blocks yet. Import or create a new CSS Block to get started.", "superb-blocks"); ?></p>
                        <?php endif; ?>
                        <?php foreach ($this->Blocks as $block_id => $block) : ?>
                            <a href="<?= esc_url(admin_url("admin.php?page=" . DashboardController::ADDITIONAL_CSS . '&css-edit=' . $block_id)); ?>" data-id="<?= esc_attr($block_id); ?>" class="superbaddons-element-button superbaddons-element-m0 superbaddons-element-mb1 superbaddons-css-block-item <?= $block->active ? "" : "superbaddons-css-block-item-deactivated"; ?>">
                                <?php new InputCheckbox("superbaddons-css-block-select-" . sanitize_title($block->name), "select-single", false, false, false); ?>
                                <div class="superbaddons-css-block-item-information">
                                    <div class="superbaddons-css-block-title-wrapper">
                                        <img class="superbaddons-element-button-icon" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . ($block->active ? '/img/purple-file.svg' : '/img/x.svg')); ?>" />
                                        <span><?= esc_html($block->name); ?></span>
                                        <span class="superbaddons-element-ml1 superbaddons-element-text-gray"><?= $block->active ? "" : esc_html__("Deactivated", "superb-blocks"); ?></span>
                                    </div>
                                    <span class="superbaddons-element-text-gray"><?= esc_html($this->GetTargetLabels($block)); ?></span>
                                </div>

                            </a>
                        <?php endforeach; ?>
                    </div>

                    <?php if (!empty($this->Blocks)) : ?>
                        <div class="superbaddons-css-blocks-list-options superbaddons-element-flex-center">

                            <img class="superbaddons-element-button-icon superbaddons-element-mr1" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/arrow-elbow-left-up.svg'); ?>" />
                            <?php new InputCheckbox("superbaddons-css-block-select-all", "select-all", __("Select All", "superb-blocks"), false, false); ?>
                            <span class="superbaddons-vertical-separator"></span>
                            <!-- Activate Selected -->
                            <button class="superbaddons-activate-blocks-btn superbaddons-element-button superbaddons-element-m0" disabled>
                                <img class="superbaddons-element-button-icon" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/check-circle.svg'); ?>" />
                                <?= esc_html__("Activate", "superb-blocks"); ?>
                            </button>
                            <span class="superbaddons-vertical-separator"></span>
                            <!-- Deactivate Selected -->
                            <button class="superbaddons-deactivate-blocks-btn superbaddons-element-button superbaddons-element-m0" disabled>
                                <img class="superbaddons-element-button-icon" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/x-circle.svg'); ?>" />
                                <?= esc_html__("Deactivate", "superb-blocks"); ?>
                            </button>
                            <span class="superbaddons-vertical-separator"></span>
                            <!-- Export Selected -->
                            <?php new CssBlocksExportSelectedSlot(); ?>
                            <span class="superbaddons-vertical-separator"></span>
                            <!-- Delete Selected -->
                            <button class="superbaddons-delete-blocks-btn superbaddons-element-button spbaddons-admin-btn-danger superbaddons-element-m0" disabled>
                                <img class="superbaddons-element-button-icon" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/trash-light.svg'); ?>" />
                                <?= esc_html__("Delete", "superb-blocks"); ?>
                            </button>

                        </div>
                        <div class="superbaddons-css-blocks-list-options superbaddons-element-flex-center">

                        </div>
                    <?php endif; ?>

                </div>
                <!-- Link Boxes -->
                <div class="superbaddons-admindashboard-linkbox-wrapper">
                    <?php
                    new LinkBox(
                        array(
                            "icon" => "question.svg",
                            "title" => __("Help & Tutorials", "superb-blocks"),
                            "description" => __("We have put together detailed documentation that walks you through every step of the process, from installation to customization.", "superb-blocks"),
                            "cta" => __("View tutorials", "superb-blocks"),
                            "link" => admin_url('admin.php?page=' . DashboardController::SUPPORT),
                            "same_window" => true,
                        )
                    );
                    new LinkBox(
                        array(
                            "icon" => "purple-bulb.svg",
                            "title" => __("Request a feature", "superb-blocks"),
                            "description" => __("We're always looking for ways to improve Superb Addons. If you have a feature request or suggestion, we'd love to hear from you.", "superb-blocks"),
                            "cta" => __("Request feature", "superb-blocks"),
                            "link" => "https://superbthemes.com/feature-request/",
                        )
                    );
                    ?>
                </div>
            </div>
            <div class="superbaddons-admindashboard-sidebarlayout-right">
                <?php
                new PremiumBox();
                new ReviewBox();
                new SupportBox();
                ?>
            </div>
        </div>
        <?php new Modal(); ?>
<?php
    }

    private function GetTargetLabels($block)
    {
        $valid_labels = apply_filters(
            'superbaddons_css_block_target_valid_labels',
            array(
                "front" => __("Front Page", "superb-blocks"),
                "full" => __("Entire Website", "superb-blocks")
            )
        );

        $labels = [];
        foreach ($block->selectors as $target) {
            if (!isset($valid_labels[$target->type]) || !$valid_labels[$target->type])
                continue;

            $labels[] = !empty($target->value) ? sprintf(__("Specific %s", "superb-blocks"), $valid_labels[$target->type])  : $valid_labels[$target->type];
        }

        if (empty($labels)) {
            return __("Not Applied", "superb-blocks");
        }

        return rtrim(join(", ", $labels), ", ");
    }
}
