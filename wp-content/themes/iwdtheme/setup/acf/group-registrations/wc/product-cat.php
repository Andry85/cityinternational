<?php
namespace IllicitWeb;

register_field_group(array (
	'id' => 'acf_product-category-content',
	'title' => 'Product category content',
	'fields' => array (
		array (
			'key' => 'field_iwwcpccdbf992',
			'label' => 'Display product category content',
			'name' => 'display_product_cat_ct',
			'type' => 'true_false',
			'message' => '',
			'default_value' => 0,
		),
		array (
			'key' => 'field_iwwcpccabf99z',
			'label' => 'Content Heading',
			'name' => 'product_cat_ct_heading',
			'type' => 'text',
			'conditional_logic' => array (
				'status' => 1,
				'rules' => array (
					array (
						'field' => 'field_iwwcpccdbf992',
						'operator' => '==',
						'value' => '1',
					),
				),
				'allorany' => 'all',
			),
			'default_value' => '',
			'placeholder' => 'Heading',
			'prepend' => '',
			'append' => '',
			'formatting' => 'none',
			'maxlength' => '',
		),
		array (
			'key' => 'field_iwwcpcc8bf99y',
			'label' => 'Content Body',
			'name' => 'product_cat_ct_body',
			'type' => 'wysiwyg',
			'conditional_logic' => array (
				'status' => 1,
				'rules' => array (
					array (
						'field' => 'field_iwwcpccdbf992',
						'operator' => '==',
						'value' => '1',
					),
				),
				'allorany' => 'all',
			),
			'default_value' => '',
			'toolbar' => 'full',
			'media_upload' => 'no',
		),
		array (
			'key' => 'field_iwwcpcc9bf99w',
			'label' => 'Content button link',
			'name' => 'product_cat_ct_btn_link',
			'type' => 'text',
			'instructions' => 'Enter full URL, inc. protocol (e.g. http://)',
			'conditional_logic' => array (
				'status' => 1,
				'rules' => array (
					array (
						'field' => 'field_iwwcpccdbf992',
						'operator' => '==',
						'value' => '1',
					),
				),
				'allorany' => 'all',
			),
			'default_value' => '',
			'placeholder' => 'URL',
			'prepend' => '',
			'append' => '',
			'formatting' => 'none',
			'maxlength' => '',
		),
		array (
			'key' => 'field_iwwcpccfbf99x',
			'label' => 'Content button text',
			'name' => 'product_cat_ct_btn_text',
			'type' => 'text',
			'conditional_logic' => array (
				'status' => 1,
				'rules' => array (
					array (
						'field' => 'field_iwwcpccdbf992',
						'operator' => '==',
						'value' => '1',
					),
				),
				'allorany' => 'all',
			),
			'default_value' => '',
			'placeholder' => 'Text',
			'prepend' => '',
			'append' => '',
			'formatting' => 'none',
			'maxlength' => '',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'ef_taxonomy',
				'operator' => '==',
				'value' => WC_PRODUCT_CAT,
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

register_field_group(array (
		'id' => 'acf_iw_wc_product_cat',
		'title' => 'Product Category Extras',
		'fields' => array (
			array (
				'key' => 'field_iwwcpc217b959',
				'label' => 'Display on main',
				'name' => 'product_cat_display_on_main',
				'type' => 'true_false',
				'message' => '',
				'default_value' => 1,
			),
			array (
				'key' => 'field_iwwcpc467b95a',
				'label' => 'Order of display on main',
				'name' => 'order_of_display_on_main',
				'type' => 'number',
				'instructions' => 'Lower number means the product category will appear earlier.',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_iwwcpc217b959',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => 0,
				'placeholder' => 'Order',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => 1,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'ef_taxonomy',
					'operator' => '==',
					'value' => WC_PRODUCT_CAT,
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