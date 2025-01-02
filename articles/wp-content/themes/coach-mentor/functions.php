<?php

/**
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Coach Mentor for publication on WordPress.org
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

require_once get_template_directory() . '/inc/tgm/class-tgm-plugin-activation.php';

add_action('tgmpa_register', 'coach_mentor_register_required_plugins', 0);
function coach_mentor_register_required_plugins()
{
	$plugins = array(
		array(
			'name'      => 'Superb Addons',
			'slug'      => 'superb-blocks',
			'required'  => false,
		),
	);

	$config = array(
		'id'           => 'coach-mentor',
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


function coach_mentor_pattern_styles()
{
	wp_enqueue_style('coach-mentor-patterns', get_stylesheet_directory_uri() . '/assets/css/patterns.css', array(), filemtime(get_template_directory() . '/assets/css/patterns.css'));
	if (is_admin()) {
		global $pagenow;
		if ('site-editor.php' === $pagenow) {
			// Do not enqueue editor style in site editor
			return;
		}
		wp_enqueue_style('coach-mentor-editor', get_stylesheet_directory_uri() . '/assets/css/editor.css', array(), filemtime(get_template_directory() . '/assets/css/editor.css'));
	}
}
add_action('enqueue_block_assets', 'coach_mentor_pattern_styles');


add_theme_support('wp-block-styles');

// Removes the default wordpress patterns
add_action('init', function () {
	remove_theme_support('core-block-patterns');
});

// Register customer Coach Mentor pattern categories
function coach_mentor_register_block_pattern_categories()
{
	register_block_pattern_category(
		'header',
		array(
			'label'       => __('Header', 'coach-mentor'),
			'description' => __('Header patterns', 'coach-mentor'),
		)
	);
	register_block_pattern_category(
		'call_to_action',
		array(
			'label'       => __('Call To Action', 'coach-mentor'),
			'description' => __('Call to action patterns', 'coach-mentor'),
		)
	);
	register_block_pattern_category(
		'content',
		array(
			'label'       => __('Content', 'coach-mentor'),
			'description' => __('Coach Mentor content patterns', 'coach-mentor'),
		)
	);
	register_block_pattern_category(
		'teams',
		array(
			'label'       => __('Teams', 'coach-mentor'),
			'description' => __('Team patterns', 'coach-mentor'),
		)
	);
	register_block_pattern_category(
		'banners',
		array(
			'label'       => __('Banners', 'coach-mentor'),
			'description' => __('Banner patterns', 'coach-mentor'),
		)
	);
	register_block_pattern_category(
		'layouts',
		array(
			'label'       => __('Layouts', 'coach-mentor'),
			'description' => __('layout patterns', 'coach-mentor'),
		)
	);
	register_block_pattern_category(
		'testimonials',
		array(
			'label'       => __('Testimonial', 'coach-mentor'),
			'description' => __('Testimonial and review patterns', 'coach-mentor'),
		)
	);

}

add_action('init', 'coach_mentor_register_block_pattern_categories');




function coach_mentor_remove_parent_tgmpa() {
    remove_action( 'tgmpa_register', 'idea_flow_register_required_plugins', 0 );
}
add_action( 'after_setup_theme', 'coach_mentor_remove_parent_tgmpa', 0 ); 