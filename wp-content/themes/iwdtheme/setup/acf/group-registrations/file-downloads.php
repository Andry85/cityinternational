<?php

namespace IllicitWeb;

register_field_group(array (
	'id' => 'acf_file-downloads',
	'title' => 'File downloads',
	'fields' => array (
		array (
			'key' => 'field_58860656751zz',
			'label' => 'Files',
			'name' => 'page_file_downloads',
			'type' => 'repeater',
			'sub_fields' => array (
				array (
					'key' => 'field_58860665751yy',
					'label' => 'File',
					'name' => 'file',
					'type' => 'file',
					'required' => 1,
					'column_width' => '',
					'save_format' => 'object',
					'library' => 'all',
				),
				array (
					'key' => 'field_iwfiledl2o3ss',
					'label' => 'Text',
					'name' => 'text',
					'type' => 'text',
					'column_width' => '',
					'default_value' => 'Download',
					'placeholder' => 'Text',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
					'required' => 1,
				),
			),
			'row_min' => '',
			'row_limit' => '',
			'layout' => 'table',
			'button_label' => 'Add File',
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
