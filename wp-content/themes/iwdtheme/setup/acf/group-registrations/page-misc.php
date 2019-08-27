<?php
namespace IllicitWeb;

register_field_group(array (
	'id' => 'acf_iw_df_page_misc',
	'title' => 'Misc Settings',
	'fields' => array (
		array (
			'key' => 'field_iwpage1d32611',
			'label' => 'Hide main post content',
			'name' => 'hide_main_post_content',
			'type' => 'true_false',
			'message' => '',
			'default_value' => 0,
		),
		array (
			'key' => 'field_iwpage1d32612',
			'label' => 'Hide main post title',
			'name' => 'hide_main_post_title',
			'type' => 'true_false',
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
