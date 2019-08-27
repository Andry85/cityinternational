<?php

namespace IllicitWeb;

register_field_group(array (
	'id' => 'acf_map-embed',
	'title' => 'Map Embed',
	'fields' => array (
		array (
			'key' => 'field_iwmapembd3d0x',
			'label' => 'Map embed',
			'name' => 'map_embed',
			'type' => 'textarea',
			'instructions' => 'Optionally, copy and paste your HTML embed code for a Google Map or similar in this area.',
			'default_value' => '',
			'placeholder' => 'HTML',
			'maxlength' => '',
			'rows' => '',
			'formatting' => 'html',
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
