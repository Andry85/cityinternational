<?php

namespace IllicitWeb;

add_action('init', function () {
	register_post_type(PTYPE_BANNER, array(
		'labels' => array(
			'name' => 'Banners',
			'singular_name' => 'Banner',
		),
		'public' => false,
		'show_ui' => true,
		'has_archive' => false,
		'exclude_from_search' => true,
		'publicly_queryable' => false,
		'menu_icon' => 'dashicons-format-image',
		'hierarchical' => false,
		'supports' => array('title'),
	));
});
