<?php

namespace SuperbAddons\Components\Buttons;

defined('ABSPATH') || exit();

class Button
{
    private $type;
    private $text;
    private $icon;
    private $url;
    private $class;
    private $target;
    private $id;

    public function __construct($type = ButtonType::Primary, $icon = ButtonIcon::ExternalLink, $options = array())
    {

        $this->text = isset($options['text']) ? $options['text'] : '';
        $this->url = isset($options['url']) ? $options['url'] : '';
        $this->id = isset($options['id']) ? $options['id'] : '';
        $this->class = isset($options['class']) ? $options['class'] : '';
        $this->target = isset($options['target']) ? $options['target'] : '';
        $this->type = $type;
        $this->icon = $icon;

        $this->Render();
    }

    private function Render()
    {
?>
        <a id="<?= esc_attr($this->id); ?>" <?= !empty($this->url) ? 'href="' . esc_url($this->url) . '"' : ''; ?> <?= !empty($this->target) ? 'target="' . esc_attr($this->target) . '"' : ''; ?>class="superb-addons-template-library-button superb-addons-template-library-button-<?= esc_attr($this->type); ?> <?= esc_attr($this->class); ?>">
            <?php if (!empty($this->text)) {
                echo esc_html($this->text);
            }

            if (!empty($this->icon)) : ?>
                <img src="<?= SUPERBADDONS_ASSETS_PATH . "/img/" . esc_attr($this->icon); ?>" />
            <?php endif; ?>
        </a>
<?php
    }
}

class ButtonType
{
    const Primary = 'primary';
    const Secondary = 'secondary';
    const Success = 'success';
    const Danger = 'danger';
}

class ButtonIcon
{
    const Insert = 'plus-circle.svg';
    const Preview = 'preview.svg';
    const ExternalLink = 'external-link.svg';
}
