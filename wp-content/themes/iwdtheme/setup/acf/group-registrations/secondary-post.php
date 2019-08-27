<?php
namespace IllicitWeb;

register_field_group(array (
	'id' => 'acf_secondary-post',
	'title' => 'Secondary post',
	'fields' => array (
		array (
			'key' => 'field_joea2f5ebb1cf',
			'label' => 'Display secondary post',
			'name' => 'display_secondary_post',
			'type' => 'true_false',
			'message' => '',
			'default_value' => 0,
		),
		array (
			'key' => 'field_553a2joebb1d0',
			'label' => 'Secondary post title',
			'name' => 'secondary_post_title',
			'type' => 'text',
			'conditional_logic' => array (
				'status' => 1,
				'rules' => array (
					array (
						'field' => 'field_joea2f5ebb1cf',
						'operator' => '==',
						'value' => '1',
					),
				),
				'allorany' => 'all',
			),
			'default_value' => '',
			'placeholder' => 'Title',
			'prepend' => '',
			'append' => '',
			'formatting' => 'html',
			'maxlength' => '',
		),
		array (
			'key' => 'field_553a2fjoey1d1',
			'label' => 'Secondary post content',
			'name' => 'secondary_post_content',
			'type' => 'wysiwyg',
			'conditional_logic' => array (
				'status' => 1,
				'rules' => array (
					array (
						'field' => 'field_joea2f5ebb1cf',
						'operator' => '==',
						'value' => '1',
					),
				),
				'allorany' => 'all',
			),
			'default_value' => '',
			'toolbar' => 'full',
			'media_upload' => 'yes',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'page',
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
