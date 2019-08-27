<?php

namespace IllicitWeb;

register_field_group(array (
	'id' => 'acf_gallery',
	'title' => 'Gallery',
	'fields' => array (
		array (
			'key' => 'field_iwgall4dbc7c5',
			'label' => 'Images',
			'name' => 'iw_gallery_images',
			'type' => 'repeater',
			'instructions' => 'Select images for the gallery',
			'sub_fields' => array (
				array (
					'key' => 'field_iwgall67bc7c6',
					'label' => 'Image',
					'name' => 'image',
					'type' => 'image',
					'instructions' => 'Select an image',
					'required' => 1,
					'column_width' => '',
					'save_format' => 'object',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_iwgall67bc7c7',
					'label' => 'Caption',
					'name' => 'caption',
					'type' => 'textarea',
					'instructions' => 'Enter optional caption text/HTML',
					'required' => 0,
					'default_value' => '',
					'placeholder' => 'Caption',
					'maxlength' => '4000',
					'rows' => '',
					'formatting' => 'html',
				),
			),
			'row_min' => '',
			'row_limit' => '',
			'layout' => 'table',
			'button_label' => 'Add Gallery Item',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => PTYPE_GALLERY, 
				'order_no' => -1000,
				'group_no' => 0,
			),
		),
	),
	'options' => array (
		'position' => 'normal',
		'layout' => 'no_box',
		'hide_on_screen' => array (
			0 => 'the_content',
			1 => 'excerpt',
			2 => 'custom_fields',
			3 => 'discussion',
			4 => 'comments',
			5 => 'revisions',
			6 => 'author',
			7 => 'format',
			8 => 'featured_image',
			9 => 'categories',
			10 => 'tags',
			11 => 'send-trackbacks',
		),
	),
	'menu_order' => 0,
));
