<?php

namespace SuperbAddons\Elementor\Utils;

defined('ABSPATH') || exit();

use Elementor\TemplateLibrary\Source_Base;

class ElementorSourceExtension extends Source_Base // Extend Source_Base to gain access to Elementor functions such as process_export_import_content
{
    /////////////////////////////// 
    // Required functions because of Source_Base extension abstractions
    public function get_id()
    {
        return 'superbaddons-layout-manager';
    }

    public function get_title()
    {
        return __('Superb Layout Manager', "superb-blocks");
    }

    public function register_data()
    {
    }

    public function save_item($template_data)
    {
        return new \WP_Error('invalid_request', 'Cannot save template.');
    }

    public function update_item($new_data)
    {
        return new \WP_Error('invalid_request', 'Cannot update template.');
    }

    public function delete_template($template_id)
    {
        return new \WP_Error('invalid_request', 'Cannot delete template.');
    }

    public function export_template($template_id)
    {
        return new \WP_Error('invalid_request', 'Cannot export template.');
    }

    public function get_items($args = array())
    {
        return new \WP_Error('invalid_request', 'Cannot get items.');
    }

    public function get_item($template_id)
    {
        return new \WP_Error('invalid_request', 'Cannot get item.');
    }

    public function request_template_data($template_id)
    {
        return new \WP_Error('invalid_request', 'Cannot request template data.');
    }

    public function get_data(array $args, $context = 'display')
    {
        return new \WP_Error('invalid_request', 'Cannot get data.');
    }
    /////

    public function HandleImport(&$data)
    {
        $data['content'] = $this->replace_elements_ids($data['content']);
        $data['content'] = $this->process_export_import_content($data['content'], 'on_import');
    }
}
