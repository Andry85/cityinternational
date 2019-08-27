<?php
namespace IllicitWeb;

register_field_group(array (
	'id' => 'acf_banners',
	'title' => 'Banners',
	'fields' => array (
		array (
			'key' => 'field_5444f7c230a0f',
			'label' => 'Top Banner',
			'name' => 'top_banner',
			'type' => 'post_object',
			'post_type' => array (
				0 => 'iw_banner',
			),
			'taxonomy' => array (
				0 => 'all',
			),
			'allow_null' => 1,
			'multiple' => 0,
		),
		/*
		array (
			'key' => 'field_5444f7e0901ba',
			'label' => 'Second Banner',
			'name' => 'second_banner',
			'type' => 'post_object',
			'post_type' => array (
				0 => 'iw_banner',
			),
			'taxonomy' => array (
				0 => 'all',
			),
			'allow_null' => 1,
			'multiple' => 0,
		),
		*/
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
