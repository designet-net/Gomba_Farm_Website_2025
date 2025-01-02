<?php

/**
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Idea Flow for publication on WordPress.org
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

require_once get_template_directory() . '/inc/tgm/class-tgm-plugin-activation.php';

add_action('tgmpa_register', 'idea_flow_register_required_plugins', 0);
function idea_flow_register_required_plugins()
{
	$plugins = array(
		array(
			'name'      => 'Superb Addons',
			'slug'      => 'superb-blocks',
			'required'  => false,
		),
		array(
			'name'      => 'Booking for Appointments and Events Calendar',
			'slug'      => 'ameliabooking',
			'required'  => false,
		),
	);

	$config = array(
		'id'           => 'idea-flow',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => true,
		'message'      => '',
	);

	tgmpa($plugins, $config);
}


function idea_flow_pattern_styles()
{
	wp_enqueue_style('idea-flow-patterns', get_template_directory_uri() . '/assets/css/patterns.css', array(), filemtime(get_template_directory() . '/assets/css/patterns.css'));
	if (is_admin()) {
		global $pagenow;
		if ('site-editor.php' === $pagenow) {
			// Do not enqueue editor style in site editor
			return;
		}
		wp_enqueue_style('idea-flow-editor', get_template_directory_uri() . '/assets/css/editor.css', array(), filemtime(get_template_directory() . '/assets/css/editor.css'));
	}
}
add_action('enqueue_block_assets', 'idea_flow_pattern_styles');


add_theme_support('wp-block-styles');

// Removes the default wordpress patterns
add_action('init', function () {
	remove_theme_support('core-block-patterns');
});

// Register customer Idea Flow pattern categories
function idea_flow_register_block_pattern_categories()
{
	register_block_pattern_category(
		'header',
		array(
			'label'       => __('Header', 'idea-flow'),
			'description' => __('Header patterns', 'idea-flow'),
		)
	);
	register_block_pattern_category(
		'call_to_action',
		array(
			'label'       => __('Call To Action', 'idea-flow'),
			'description' => __('Call to action patterns', 'idea-flow'),
		)
	);
	register_block_pattern_category(
		'content',
		array(
			'label'       => __('Content', 'idea-flow'),
			'description' => __('Idea Flow content patterns', 'idea-flow'),
		)
	);
	register_block_pattern_category(
		'teams',
		array(
			'label'       => __('Teams', 'idea-flow'),
			'description' => __('Team patterns', 'idea-flow'),
		)
	);
	register_block_pattern_category(
		'banners',
		array(
			'label'       => __('Banners', 'idea-flow'),
			'description' => __('Banner patterns', 'idea-flow'),
		)
	);
	register_block_pattern_category(
		'layouts',
		array(
			'label'       => __('Layouts', 'idea-flow'),
			'description' => __('layout patterns', 'idea-flow'),
		)
	);
	register_block_pattern_category(
		'testimonials',
		array(
			'label'       => __('Testimonial', 'idea-flow'),
			'description' => __('Testimonial and review patterns', 'idea-flow'),
		)
	);

}

add_action('init', 'idea_flow_register_block_pattern_categories');

// Initialize information content
require_once trailingslashit(get_template_directory()) . 'inc/vendor/autoload.php';

use SuperbThemesThemeInformationContent\ThemeEntryPoint;

ThemeEntryPoint::init([
	'theme_url' => 'https://superbthemes.com/idea-flow/',
	'demo_url' => 'https://superbthemes.com/demo/idea-flow/'
]);
