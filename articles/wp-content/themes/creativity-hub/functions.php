<?php

/**
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme creativity-hub for publication on WordPress.org
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

require_once get_template_directory() . '/inc/tgm/class-tgm-plugin-activation.php';

add_action('tgmpa_register', 'creativity_hub_register_required_plugins', 0);
function creativity_hub_register_required_plugins()
{
	$plugins = array(
		array(
			'name'      => 'Superb Addons',
			'slug'      => 'superb-blocks',
			'required'  => false,
		),
	);

	$config = array(
		'id'           => 'creativity-hub',
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


function creativity_hub_pattern_styles()
{
	wp_enqueue_style('creativity-hub-patterns', get_template_directory_uri() . '/assets/css/patterns.css', array(), filemtime(get_template_directory() . '/assets/css/patterns.css'));
	if (is_admin()) {
		global $pagenow;
		if ('site-editor.php' === $pagenow) {
			// Do not enqueue editor style in site editor
			return;
		}
		wp_enqueue_style('creativity-hub-editor', get_template_directory_uri() . '/assets/css/editor.css', array(), filemtime(get_template_directory() . '/assets/css/editor.css'));
	}
}
add_action('enqueue_block_assets', 'creativity_hub_pattern_styles');


add_theme_support('wp-block-styles');

// Removes the default wordpress patterns
add_action('init', function () {
	remove_theme_support('core-block-patterns');
});

// Register customer Creativity Hub pattern categories
function creativity_hub_register_block_pattern_categories()
{
	register_block_pattern_category(
		'heros',
		array(
			'label'       => __('Heros', 'creativity-hub'),
			'description' => __('Creativity Hub hero patterns', 'creativity-hub'),
		)
	);
	register_block_pattern_category(
		'navigation_headers',
		array(
			'label'       => __('Headers', 'creativity-hub'),
			'description' => __('Creativity Hub navigation header patterns', 'creativity-hub'),
		)
	);
	register_block_pattern_category(
		'content',
		array(
			'label'       => __('Content', 'creativity-hub'),
			'description' => __('Creativity Hub content patterns', 'creativity-hub'),
		)
	);
	register_block_pattern_category(
		'teams',
		array(
			'label'       => __('Teams', 'creativity-hub'),
			'description' => __('Creativity Hub team patterns', 'creativity-hub'),
		)
	);
	register_block_pattern_category(
		'testimonials',
		array(
			'label'       => __('Testimonials', 'creativity-hub'),
			'description' => __('Creativity Hub testimonial patterns', 'creativity-hub'),
		)
	);
	register_block_pattern_category(
		'contact',
		array(
			'label'       => __('Contact', 'creativity-hub'),
			'description' => __('Creativity Hub contact patterns', 'creativity-hub'),
		)
	);
}

add_action('init', 'creativity_hub_register_block_pattern_categories');



// Initialize information content
require_once trailingslashit(get_template_directory()) . 'inc/vendor/autoload.php';

use SuperbThemesThemeInformationContent\ThemeEntryPoint;

define('SUPERBTHEMES_INFO_CONTENT_TEXT_DOMAIN', "creativity-hub");

ThemeEntryPoint::init([
	"templates" => [
		array(
			'name' => __("Front Page", "creativity-hub"),
			'frontpage' => true,
			'required' => true,
			'image' => 'front-page.png',
		),
		array(
			'name' => __("About", "creativity-hub"),
			'required' => false,
			'slug' => 'about',
			'image' => 'about.png',
		),
		array(
			'name' => __("Contact", "creativity-hub"),
			'required' => false,
			'slug' => 'contact',
			'image' => 'contact.png',
		),
		array(
			'name' => __("Blog", "creativity-hub"),
			'template_only' => true,
			'required' => true,
			'image' => 'blog.png',
		),
		array(
			'name' => __("Services", "creativity-hub"),
			'template_only' => true,
			'required' => true,
			'image' => 'services.png',
		),
		array(
			'name' => __("Page", "creativity-hub"),
			'template_only' => true,
			'required' => true,
			'image' => 'pages.png',
		),
		array(
			'name' => __("Post", "creativity-hub"),
			'template_only' => true,
			'required' => true,
			'image' => 'posts.png',
		),
		array(
			'name' => __("Archives", "creativity-hub"),
			'template_only' => true,
			'required' => true,
			'image' => 'archives.png',
		),
		array(
			'name' => __("Search", "creativity-hub"),
			'template_only' => true,
			'required' => true,
			'image' => 'search.png',
		),
		array(
			'name' => __("404", "creativity-hub"),
			'template_only' => true,
			'required' => true,
			'image' => '404.png',
		),
	],
	'theme_url' => 'https://superbthemes.com/creativity-hub/',
	'demo_url' => 'https://superbthemes.com/demo/creativity-hub/'
]);
