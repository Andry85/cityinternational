<?php
namespace IllicitWeb;

register_field_group(array (
	'id' => 'acf_big-links',
	'title' => 'Big links',
	'fields' => array (
		array (
			'key' => 'field_bigln12fsw1fzb',
			'label' => 'Title',
			'name' => 'big_links_title',
			'type' => 'text',
			'placeholder' => 'Text',
			'prepend' => '',
			'append' => '',
			'formatting' => 'html',
			'maxlength' => ''
		),
		array (
			'key' => 'field_biglnxssw21fzz',
			'label' => 'Strapline',
			'name' => 'big_links_heading',
			'type' => 'text',
			'placeholder' => 'Text',
			'prepend' => '',
			'append' => '',
			'formatting' => 'html',
			'maxlength' => ''
		),

		array (
			'key' => 'field_biglnxf1f21fb6',
			'label' => 'Big links',
			'name' => 'big_links',
			'type' => 'repeater',
			'instructions' => 'Enter data for big links',
			'sub_fields' => array (
				/*
				array (
					'key' => 'field_biglnxf6421fb7',
					'label' => 'URL',
					'name' => 'url',
					'type' => 'text',
					'instructions' => 'Enter URL for link (include protocol, e.g. "/" or "http://")',
					'required' => 0,
					'column_width' => '',
					'default_value' => '',
					'placeholder' => 'URL',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),

				array (
					'key' => 'field_biglnxfab21fb8',
					'label' => 'Background image',
					'name' => 'bgd_image',
					'type' => 'image',
					'instructions' => 'Select link background image',
					'column_width' => '',
					'save_format' => 'object',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),

				array (
					'key' => 'field_biglnxfazs1fb9',
					'label' => 'Foreground image',
					'name' => 'fgd_image',
					'type' => 'image',
					'instructions' => 'Select link foreground image',
					'column_width' => '',
					'save_format' => 'object',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),

				array (
					'key' => 'field_biglnxfc321fb9',
					'label' => 'Text',
					'name' => 'text',
					'type' => 'textarea',
					'instructions' => 'Enter link text',
					'column_width' => '',
					'default_value' => '',
					'placeholder' => 'Text',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
				*/
				array (
					'post_type' => array (
						0 => 'page',
					),
					'taxonomy' => array (
					),
					'allow_null' => 0,
					'multiple' => 0,
					'return_format' => 'object',
					'ui' => 1,
					'key' => 'field_iwdbiglnx5fc2f',
					'label' => 'Page',
					'name' => 'page',
					'type' => 'post_object',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
				),
				array (
					'key' => 'field_biglnxfc321fb9',
					'label' => 'Text',
					'name' => 'text',
					'type' => 'textarea',
					'instructions' => 'Short description',
					'column_width' => '',
					'default_value' => '',
					'placeholder' => 'Text',
					'prepend' => '',
					'append' => '',
					'formatting' => 'text',
					'maxlength' => '',
				),
			),
			'row_min' => '',
			'row_limit' => '',
			'layout' => 'row',
			'button_label' => 'Add Big Link',
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
