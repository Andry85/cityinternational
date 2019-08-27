<?php

namespace IllicitWeb;

register_field_group(array (
	'id' => 'acf_illicit-banner',
	'title' => 'Illicit Banner',
	'fields' => array (
		array (
			'key' => 'field_iwbnr477e7ae2',
			'label' => 'Banner Items',
			'name' => 'iw_banner_items',
			'type' => 'repeater',
			'instructions' => 'Enter items for the banner',
			'sub_fields' => array (
				array (
					'key' => 'field_iwbnr4c6e7ae3',
					'label' => 'Main image',
					'name' => 'main_image',
					'type' => 'image',
					'instructions' => 'Select the main image for the banner item',
					'column_width' => '',
					'save_format' => 'object',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_iwbnr4fbe7ae4',
					'label' => 'Text content',
					'name' => 'text_content',
					'type' => 'textarea',
					'instructions' => 'Enter some textual content for the banner item',
					'column_width' => '',
					'default_value' => '',
					'placeholder' => 'Banner item text/HTML',
					'maxlength' => '',
					'rows' => '',
					'formatting' => 'html',
				),
				array (
					'key' => 'field_iwbnr17adfd3e',
					'label' => 'Dark background',
					'name' => 'dark_bgd',
					'type' => 'true_false',
					'instructions' => 'Adds a dark background to the item image, potentially making text more readable',
					'message' => '',
					'default_value' => 0,
				),
				array (
					'key' => 'field_iwbnrpop8c68z',
					'label' => 'Wait duration override',
					'name' => 'iw_banner_wait_duration_override',
					'type' => 'number',
					'instructions' => 'Msec. Optional.',
					'required' => 0,
					'default_value' => '',
					'placeholder' => 'Wait duration override (optional)',
					'prepend' => '',
					'append' => '',
					'min' => 1,
					'max' => 30000,
					'step' => 1,
				),
				array (
					'key' => 'field_iwbnr6ffb74bd',
					'label' => 'Image Position',
					'name' => 'image_position',
					'type' => 'radio',
					'choices' => array (
						'center' => 'Center',
						'top' => 'Top',
						'bottom' => 'Bottom',
					),
					'other_choice' => 0,
					'save_other_choice' => 0,
					'default_value' => 'center',
					'layout' => 'vertical',
				),
			),
			'row_min' => 0,
			'row_limit' => 20,
			'layout' => 'table',
			'button_label' => 'Add Banner Item',
		),
		array (
			'key' => 'field_iwbnre228c68f',
			'label' => 'Wait duration',
			'name' => 'iw_banner_wait_duration',
			'type' => 'number',
			'instructions' => 'Specify in the wait duration for each banner item in milliseconds',
			'required' => 1,
			'default_value' => 4000,
			'placeholder' => 'Wait duration',
			'prepend' => '',
			'append' => '',
			'min' => 500,
			'max' => 30000,
			'step' => 1,
		),
		array (
			'key' => 'field_iwbnre7f8c690',
			'label' => 'Transition duration',
			'name' => 'iw_banner_transition_duration',
			'type' => 'number',
			'instructions' => 'Specify in the transition duration for each banner item in milliseconds',
			'required' => 1,
			'default_value' => 2000,
			'placeholder' => 'Transition duration',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 15000,
			'step' => '',
		),
		array (
			'key' => 'field_iwbnr17adfd3z',
			'label' => 'Display controls',
			'name' => 'iw_banner_ctrls',
			'type' => 'true_false',
			'instructions' => 'Choose whether to display user controls on the banner',
			'message' => '',
			'default_value' => 0,
		),
		array (
			'key' => 'field_iwbnr4fbe7zzx',
			'label' => 'Overlay HTML',
			'name' => 'iw_banner_overlay_html',
			'type' => 'textarea',
			'instructions' => 'Optionally, enter some HTML to lay over the entire banner',
			'column_width' => '',
			'default_value' => '',
			'placeholder' => 'HTML',
			'maxlength' => '',
			'rows' => '',
			'formatting' => 'html',
		),
		array (
			'key' => 'field_iwbnr4c6e7zqr',
			'label' => 'Banner overlay background image',
			'name' => 'iw_banner_overlay_bgd_image',
			'type' => 'image',
			'instructions' => 'Optionally select a background image for the banner overlay',
			'column_width' => '',
			'save_format' => 'object',
			'preview_size' => 'thumbnail',
			'library' => 'all',
		),
		array (
			'key' => 'field_iwbnr17adfd3d',
			'label' => 'Overlay dark background',
			'name' => 'iw_banner_overlay_dark_bgd',
			'type' => 'true_false',
			'instructions' => 'Adds a dark background to the overlay, potentially making text more readable',
			'message' => '',
			'default_value' => 0,
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'iw_banner',
				'order_no' => 0,
				'group_no' => 0,
			),
		),
	),
	'options' => array (
		'position' => 'acf_after_title',
		'layout' => 'default',
		'hide_on_screen' => array (
			0 => 'permalink',
			1 => 'the_content',
			2 => 'excerpt',
			3 => 'custom_fields',
			4 => 'discussion',
			5 => 'comments',
			6 => 'revisions',
			7 => 'slug',
			8 => 'author',
			9 => 'format',
			10 => 'featured_image',
			11 => 'categories',
			12 => 'tags',
			13 => 'send-trackbacks',
		),
	),
	'menu_order' => 0,
));

register_field_group(array (
	'id' => 'acf_illicit-banner-size',
	'title' => 'Size',
	'fields' => array (
		array (
			'key' => 'field_iwbnrc4c7b2aa',
			'label' => 'Banner Size',
			'name' => 'iw_banner_size',
			'type' => 'radio',
			'required' => 1,
			'choices' => array (
				'normal-height' => 'Normal',
				'full-screen' => 'Full Screen',
				'short' => 'Short',
			),
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => 'normal-height',
			'layout' => 'vertical',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'iw_banner',
				'order_no' => 0,
				'group_no' => 0,
			),
		),
	),
	'options' => array (
		'position' => 'side',
		'layout' => 'default',
		'hide_on_screen' => array (
		),
	),
	'menu_order' => 0,
));

register_field_group(array (
	'id' => 'acf_illicit-banner-misc',
	'title' => 'Misc settings',
	'fields' => array (
		array (
			'key' => 'field_iwbnrqwbe7zzx',
			'label' => 'Disable parallax',
			'name' => 'iw_banner_disable_parallax',
			'type' => 'true_false',
			'instructions' => 'If parallax scrolling is available, checking this disables it.',
			'message' => '',
			'default_value' => 0,
		),
		array (
			'key' => 'field_iwbnrqwbe7zzy',
			'label' => 'Show scroll down button',
			'name' => 'iw_banner_scroll_button',
			'type' => 'true_false',
			'instructions' => '',
			'message' => '',
			'default_value' => 0,
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'iw_banner',
				'order_no' => 0,
				'group_no' => 0,
			),
		),
	),
	'options' => array (
		'position' => 'side',
		'layout' => 'default',
		'hide_on_screen' => array (
		),
	),
	'menu_order' => 0,
));

register_field_group(array (
	'id' => 'acf_banner-extras',
	'title' => 'Banner Extras',
	'fields' => array (
		array (
			'key' => 'field_iwbnr48518213',
			'label' => 'Banner video URLs',
			'name' => 'iw_banner_video_urls',
			'type' => 'repeater',
			'instructions' => 'Optionally enter alternative URLs to a video which will replace the first item\'s background image',
			'sub_fields' => array (
				array (
					'key' => 'field_iwbnr4fd18214',
					'label' => 'URL',
					'name' => 'url',
					'type' => 'text',
					'column_width' => '',
					'default_value' => '',
					'placeholder' => 'URL',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
			),
			'row_min' => '',
			'row_limit' => '',
			'layout' => 'table',
			'button_label' => 'Add Video URL',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'iw_banner',
				'order_no' => 0,
				'group_no' => 0,
			),
		),
	),
	'options' => array (
		'position' => 'normal',
		'layout' => 'default',
		'hide_on_screen' => array (
		),
	),
	'menu_order' => 0,
));
