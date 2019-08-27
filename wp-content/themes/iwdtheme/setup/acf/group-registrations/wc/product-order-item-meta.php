<?php
namespace IllicitWeb;

register_field_group(array (
	'id' => 'acf_product-order-item-meta',
	'title' => 'Product Order Item Meta',
	'fields' => array (
		array (
			'key' => 'field_iwwc089beac82',
			'label' => 'Product Order Item Meta Fields',
			'name' => 'product_order_item_meta_fields',
			'type' => 'repeater',
			'sub_fields' => array (
				array (
					'key' => 'field_iwwc08f5eac83',
					'label' => 'Meta Name',
					'name' => 'meta_name',
					'type' => 'text',
					'required' => 1,
					'column_width' => '',
					'default_value' => '',
					'placeholder' => 'Meta Name',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_iwwc0924eac84',
					'label' => 'Data Type',
					'name' => 'data_type',
					'type' => 'select',
					'required' => 1,
					'column_width' => '',
					'choices' => array (
						'text' => 'Text',
						'date' => 'Date',
					),
					'default_value' => 'text',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_iwwc0a2d17953',
					'label' => 'Heading',
					'name' => 'heading',
					'type' => 'text',
					'column_width' => '',
					'default_value' => '',
					'placeholder' => 'Heading',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_iwwc0c320f625',
					'label' => 'Required',
					'name' => 'required',
					'type' => 'true_false',
					'column_width' => '',
					'message' => '',
					'default_value' => 0,
				),
			),
			'row_min' => '',
			'row_limit' => '',
			'layout' => 'table',
			'button_label' => 'Add Meta Field',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'product',
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
