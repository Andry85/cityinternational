<?php
namespace IllicitWeb;

date_default_timezone_set('Europe/London');

add_action('after_setup_theme', function () {

	load_theme_textdomain('illicitwebdesign', get_template_directory().'/languages');

	add_theme_support('post-thumbnails');
	//add_theme_support('automatic-feed-links');
	//add_theme_support('woocommerce');

	// Nav menus
	register_nav_menus(
		array('main-menu' => __('Main Menu', 'illicitwebdesign'))
	);
	register_nav_menus(
		array('secondary-menu' => __('Secondary Menu', 'illicitwebdesign'))
	);

});

add_action('wp_enqueue_scripts', function () {
	wp_enqueue_script('jquery');
});

add_filter('the_title', function ($title) {
	if ($title == '') {
		return '&rarr;';
	} else {
		return $title;
	}
});

// @todo check this is working properly
add_filter('wp_title', function ($title) {
	$title = $title.esc_attr(get_bloginfo('name'));
	// Fix problems with page titles
	$title = preg_replace('/\s*\|\s*$/', '', $title); // remove trailing pipe
	$title = preg_replace('/\|(?!\s)/', '| ', $title); // add space after pipe if absent
	$title = preg_replace('/(?!\s)\|/', ' |', $title); // add space before pipe if absent
	return $title;
});

// Allow SVG uploads
// Note: Might need to add the following line to .htaccess:
// AddType image/svg+xml svg
add_filter('upload_mimes', function($existing_mimes = array()) {
	$existing_mimes['svg'] = 'image/svg+xml';
	$existing_mimes['svgz'] = 'image/svg+xml';
	return $existing_mimes;
});

add_filter('body_class', function ($classes) {
	if (empty($GLOBALS['post'])) {
		return $classes;
	}
	$post = $GLOBALS['post'];
	$classes[] = $post->post_type.'-'.$post->post_name;
	if (!empty($post->post_parent)) {
		$parent_post = get_post($post->post_parent);
		if ($parent_post) {
			$classes[] = 'parent-'.$parent_post->post_type.'-'.$parent_post->post_name;
		}
	}
	return $classes;
});

// Get rid of gallery default styles
// Note: use post_gallery filter to alter HTML for default WP post galleries.
add_filter('use_default_gallery_style', '__return_false');

// Hide front-end admin bar for everyone
add_filter('show_admin_bar', '__return_false');

// Prevent automatic <p></p> insertion
// remove_filter('the_content', 'wpautop');
// remove_filter('the_excerpt', 'wpautop');
// remove_filter ('acf_the_content', 'wpautop');
