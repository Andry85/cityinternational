<?php

namespace IllicitWeb;

register_field_group(array (
	'id' => 'acf_slides',
	'title' => 'Slides',
	'fields' => array (
		array (
			'key' => 'field_iwslieedea436',
			'label' => 'Display slides',
			'name' => 'display_slides',
			'type' => 'true_false',
			'message' => '',
			'default_value' => 0,
		),
		array (
			'key' => 'field_iwslib7c40a38',
			'label' => 'Slides',
			'name' => 'slides',
			'type' => 'repeater',
			'conditional_logic' => array (
				'status' => 1,
				'rules' => array (
					array (
						'field' => 'field_iwslieedea436',
						'operator' => '==',
						'value' => '1',
					),
				),
				'allorany' => 'all',
			),
			'sub_fields' => array (
				array (
					'key' => 'field_iwslib9340a39',
					'label' => 'Slide post',
					'name' => 'slide_post',
					'type' => 'post_object',
					'required' => 1,
					'column_width' => '',
					'post_type' => array (
						0 => 'iw_slide',
					),
					'taxonomy' => array (
						0 => 'all',
					),
					'allow_null' => 0,
					'multiple' => 0,
				),
			),
			'row_min' => '',
			'row_limit' => '',
			'layout' => 'table',
			'button_label' => 'Add Slide',
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
