<?php

namespace IllicitWeb;

register_field_group(array (
	'id' => 'acf_multipage-sections',
	'title' => 'Multipage Sections',
	'fields' => array (
		array (
			'key' => 'field_iwmpa8024882a',
			'label' => 'Display Multipage Sections',
			'name' => 'display_multipage_sections',
			'type' => 'true_false',
			'message' => '',
			'default_value' => 0,
		),
		array (
			'key' => 'field_iwmpa8f94882b',
			'label' => 'Menu background image',
			'name' => 'multipage_menu_background_image',
			'type' => 'image',
			'conditional_logic' => array (
				'status' => 1,
				'rules' => array (
					array (
						'field' => 'field_iwmpa8024882a',
						'operator' => '==',
						'value' => '1',
					),
				),
				'allorany' => 'all',
			),
			'save_format' => 'object',
			'preview_size' => 'thumbnail',
			'library' => 'all',
		),
		array (
			'key' => 'field_iwmpa9154882c',
			'label' => 'Multipage Sections',
			'name' => 'multipage_sections',
			'type' => 'repeater',
			'conditional_logic' => array (
				'status' => 1,
				'rules' => array (
					array (
						'field' => 'field_iwmpa8024882a',
						'operator' => '==',
						'value' => '1',
					),
				),
				'allorany' => 'all',
			),
			'sub_fields' => array (
				array (
					'key' => 'field_iwmpa9344882d',
					'label' => 'Title',
					'name' => 'title',
					'type' => 'text',
					'column_width' => '',
					'default_value' => '',
					'placeholder' => 'Title',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_iwmpa9444882e',
					'label' => 'Introduction',
					'name' => 'introduction',
					'type' => 'textarea',
					'column_width' => '',
					'default_value' => '',
					'placeholder' => 'Text/HTML',
					'maxlength' => '',
					'rows' => '',
					'formatting' => 'html',
				),
				array (
					'key' => 'field_iwmpacfa4882f',
					'label' => 'Multipage Items',
					'name' => 'multipage_items',
					'type' => 'repeater',
					'column_width' => '',
					'sub_fields' => array (
						array (
							'key' => 'field_iwmpad5e48830',
							'label' => 'Image',
							'name' => 'image',
							'type' => 'image',
							'column_width' => '',
							'save_format' => 'object',
							'preview_size' => 'thumbnail',
							'library' => 'all',
						),
						array (
							'key' => 'field_iwmpba9e734fa',
							'label' => 'Title',
							'name' => 'title',
							'type' => 'text',
							'column_width' => '',
							'default_value' => '',
							'placeholder' => 'Title',
							'prepend' => '',
							'append' => '',
							'formatting' => 'none',
							'maxlength' => '',
						),
						array (
							'key' => 'field_iwmpad6b48831',
							'label' => 'Info',
							'name' => 'info',
							'type' => 'textarea',
							'column_width' => '',
							'default_value' => '',
							'placeholder' => 'Text/HTML',
							'maxlength' => '',
							'rows' => '',
							'formatting' => 'html',
						),
					),
					'row_min' => '',
					'row_limit' => '',
					'layout' => 'row',
					'button_label' => 'Add Item',
				),
			),
			'row_min' => '',
			'row_limit' => 4,
			'layout' => 'row',
			'button_label' => 'Add Multipage Section',
		),
		array (
			'key' => 'field_iwmp53be64422',
			'label' => 'Square tiles',
			'name' => 'multipage_square_tiles',
			'type' => 'true_false',
			'instructions' => 'Check this box to display square tiles instead of portrait tiles',
			'conditional_logic' => array (
				'status' => 1,
				'rules' => array (
					array (
						'field' => 'field_iwmpa8024882a',
						'operator' => '==',
						'value' => '1',
					),
				),
				'allorany' => 'all',
			),
			'message' => '',
			'default_value' => 0,
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
			),/*
			array (
				'param' => 'page_type',
				'operator' => '!=',
				'value' => 'front_page',
				'order_no' => 1,
				'group_no' => 0,
			),*/
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
