<?php

namespace IllicitWeb;

add_action('init', function () {
	register_taxonomy(TAX_GALLERY_CAT, PTYPE_GALLERY, array(
		'labels' => array(
			'name' => 'Gallery Categories',
			'singular_name' => 'Gallery Category',
		),
		'hierarchical' => true,
		'public' => false,
		'show_ui' => true,
	));

	register_post_type(PTYPE_GALLERY, array(
		'labels' => array(
			'name' => 'Galleries',
			'singular_name' => 'Gallery',
		),
		'public' => false,
		'show_ui' => true,
		'has_archive' => false,
		'exclude_from_search' => true,
		'publicly_queryable' => false,
		'menu_icon' => 'dashicons-format-image',
		'hierarchical' => false,
		'supports' => ['title'],
	));

	register_taxonomy_for_object_type(TAX_GALLERY_CAT, PTYPE_GALLERY);
});
