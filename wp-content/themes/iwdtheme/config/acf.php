<?php

namespace IllicitWeb;

return [

	// Specify which ACF field groups should be loaded.
	// Comment in/out as desired.
	'includes' => [
		'banner',
		'gallery',
		'page-banners',
		'page-misc',

		'big-links',
		//'file-downloads',
		//'latest-news-strip',
		//'mail-signup',
		//'map-embed',
		//'multipage',
		//'page-gallery',
		//'secondary-content',
		//'secondary-post',
		//'slides',
	],

	// These ACF field definitions will be used for site-wide options.
	'site_wide_fields' => [
		[
			// Default post image
			'return_format' => 'array',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
			'key' => 'group_iwsiteopt0000',
			'label' => 'Default Post Image',
			'name' => 'default_post_image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
		],
	],
];
