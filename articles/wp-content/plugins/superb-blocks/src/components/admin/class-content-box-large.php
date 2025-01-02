<?php

namespace SuperbAddons\Components\Admin;

defined('ABSPATH') || exit();

class ContentBoxLarge
{
    private $title = false;
    private $description = false;
    private $link = false;
    private $cta = false;
    private $image = false;
    private $icon = false;
    private $class = false;

    private $connected_bottom = false;

    public function __construct($options)
    {
        $this->title = $options['title'] ?? false;
        $this->description = $options['description'] ?? false;
        $this->link = $options['link'] ?? false;
        $this->cta = $options['cta'] ?? false;
        $this->image = $options['image'] ?? false;
        $this->icon = $options['icon'] ?? false;
        $this->class = $options['class'] ?? false;

        $this->connected_bottom = $options['connected_bottom'] ?? false;

        $this->Render();
    }

    private function Render()
    {
?>
        <div class="superbaddons-admindashboard-content-box-large <?= esc_attr($this->class); ?> <?= $this->connected_bottom ? 'superbaddons-admindashboard-content-box-large-connected-bottom' : ''; ?>" <?= $this->image ? 'style="background-image:url(' . esc_url(SUPERBADDONS_ASSETS_PATH . '/img/' . $this->image) . ');"' : ''; ?>>
            <div class="superbaddons-admindashboard-content-box-large-inner">
                <?php if ($this->icon) : ?>
                    <img class="superbaddons-admindashboard-content-icon" src="<?= esc_url(SUPERBADDONS_ASSETS_PATH . '/img/' . $this->icon); ?>" />
                <?php endif; ?>
                <h3 class="superbaddons-element-text-md superbaddons-element-text-800 superbaddons-element-text-dark"><?= esc_html($this->title); ?></h3>
                <p class="superbaddons-element-text-xs superbaddons-element-text-gray">
                    <?= esc_html($this->description); ?>
                </p>
                <?php if ($this->link && $this->cta) : ?>
                    <a class="superbaddons-element-button" href="<?= esc_url($this->link); ?>"><?= esc_html($this->cta); ?></a>
                <?php endif; ?>
            </div>
        </div>
<?php
    }
}
