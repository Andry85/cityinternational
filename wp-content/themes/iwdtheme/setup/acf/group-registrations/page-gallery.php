<?php

/**
 * Page gallery ACF setup
 * =========================================
 *
 * Requires IllicitGallery plugin.
 *
 */

namespace IllicitWeb;

register_field_group(array (
	'id' => 'acf_page-gallery',
	'title' => 'Page gallery',
	'fields' => array (
		array (
			'key' => 'field_54bd13f441f2d',
			'label' => 'Display gallery',
			'name' => 'display_page_gallery',
			'type' => 'true_false',
			'message' => '',
			'default_value' => 0,
		),
		array (
			'key' => 'field_54bd13d641f2c',
			'label' => 'Page gallery',
			'name' => 'page_gallery',
			'type' => 'post_object',
			'instructions' => 'Select a gallery to display on this page',
			'conditional_logic' => array (
				'status' => 1,
				'rules' => array (
					array (
						'field' => 'field_54bd13f441f2d',
						'operator' => '==',
						'value' => '1',
					),
				),
				'allorany' => 'all',
			),
			'post_type' => array (
				0 => 'iw_gallery',
			),
			'taxonomy' => array (
				0 => 'all',
			),
			'allow_null' => 1,
			'multiple' => 0,
		),
		array (
			'key' => 'field_54bd142841f2e',
			'label' => 'Gallery heading',
			'name' => 'page_gallery_heading',
			'type' => 'text',
			'conditional_logic' => array (
				'status' => 1,
				'rules' => array (
					array (
						'field' => 'field_54bd13f441f2d',
						'operator' => '==',
						'value' => '1',
					),
				),
				'allorany' => 'all',
			),
			'default_value' => '',
			'placeholder' => 'Gallery heading',
			'prepend' => '',
			'append' => '',
			'formatting' => 'html',
			'maxlength' => '',
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
