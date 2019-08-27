<?php
namespace IllicitWeb;

register_field_group(array (
	'id' => 'acf_latest-news-strip',
	'title' => 'Latest News Strip',
	'fields' => array (
		array (
			'key' => 'field_iwlns4eb163c6',
			'label' => 'Display Latest News Strip',
			'name' => 'display_latest_news_strip',
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
