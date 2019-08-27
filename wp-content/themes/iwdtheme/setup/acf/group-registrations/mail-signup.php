<?php
namespace IllicitWeb;

register_field_group(array (
	'id' => 'acf_iw_mail-signup',
	'title' => 'Mail signup',
	'fields' => array (
		array (
			'key' => 'field_iwmsup29dc191',
			'label' => 'Display mail signup',
			'name' => 'display_mail_signup',
			'type' => 'true_false',
			'message' => '',
			'default_value' => 0,
		),
		array (
			'key' => 'field_iwmsup3fdc192',
			'label' => 'Mail signup heading',
			'name' => 'mail_signup_heading',
			'type' => 'text',
			'conditional_logic' => array (
				'status' => 1,
				'rules' => array (
					array (
						'field' => 'field_iwmsup29dc191',
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
			'key' => 'field_iwmsup55dc193',
			'label' => 'Mail signup background image',
			'name' => 'mail_signup_background_image',
			'type' => 'image',
			'conditional_logic' => array (
				'status' => 1,
				'rules' => array (
					array (
						'field' => 'field_iwmsup29dc191',
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
