<?php

namespace IllicitWeb;

register_field_group(array (
	'id' => 'acf_iw-secondary-content',
	'title' => 'Secondary Content',
	'fields' => array (
		array (
			'key' => 'field_iwsce71bdf2e7',
			'label' => 'Display Secondary Content',
			'name' => 'display_secondary_content',
			'type' => 'true_false',
			'message' => '',
			'default_value' => 0,
		),
		array (
			'key' => 'field_iwsce752df2e8',
			'label' => 'Secondary Content',
			'name' => 'secondary_content',
			'type' => 'repeater',
			'conditional_logic' => array (
				'status' => 1,
				'rules' => array (
					array (
						'field' => 'field_iwsce71bdf2e7',
						'operator' => '==',
						'value' => '1',
					),
				),
				'allorany' => 'all',
			),
			'sub_fields' => array (
				array (
					'key' => 'field_iwsc2473bdb3z',
					'label' => 'Content row background',
					'name' => 'content_row_bgd',
					'type' => 'select',
					'required' => 1,
					'column_width' => '',
					'choices' => array (
						'white' => 'White',
						'grey' => 'Grey',
						'blue' => 'Blue',
					),
					'default_value' => 'white',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_iwscf0cd778fy',
					'label' => 'Content row ID',
					'name' => 'content_row_id',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_iwsce71bdf2zx',
								'operator' => '==',
								'value' => '1',
							),
						),
						'allorany' => 'all',
					),
					'column_width' => '',
					'default_value' => '',
					'placeholder' => 'ID',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_iwsce7ccdf2eb',
					'label' => 'Columns',
					'name' => 'columns',
					'type' => 'repeater',
					'column_width' => '',
					'sub_fields' => array (
						array (
							'key' => 'field_iwsc2707ec91w',
							'label' => 'Display this column',
							'name' => 'display_this_column',
							'type' => 'true_false',
							'column_width' => '',
							'message' => '',
							'default_value' => 1,
						),
						array (
							'key' => 'field_iwsce7f0df2ec',
							'label' => 'Text or image',
							'name' => 'text_or_image',
							'type' => 'radio',
							'required' => 1,
							'conditional_logic' => array (
								'status' => 1,
								'rules' => array (
									array (
										'field' => 'field_iwsc2707ec91w',
										'operator' => '==',
										'value' => '1',
									),
								),
								'allorany' => 'all',
							),
							'column_width' => '',
							'choices' => array (
								'text' => 'Text',
								'image' => 'Image',
							),
							'other_choice' => 0,
							'save_other_choice' => 0,
							'default_value' => 'text',
							'layout' => 'vertical',
						),
						array (
							'key' => 'field_iwsce809df2ed',
							'label' => 'Heading',
							'name' => 'heading',
							'type' => 'text',
							'conditional_logic' => array (
								'status' => 1,
								'rules' => array (
									array (
										'field' => 'field_iwsce7f0df2ec',
										'operator' => '==',
										'value' => 'text',
									),
									array (
										'field' => 'field_iwsc2707ec91w',
										'operator' => '==',
										'value' => '1',
									),
								),
								'allorany' => 'all',
							),
							'column_width' => '',
							'default_value' => '',
							'placeholder' => 'Heading',
							'prepend' => '',
							'append' => '',
							'formatting' => 'none',
							'maxlength' => '',
						),
						array (
							'key' => 'field_iwscee9ad4446',
							'label' => 'Body image',
							'name' => 'body_image',
							'type' => 'image',
							'conditional_logic' => array (
								'status' => 1,
								'rules' => array (
									array (
										'field' => 'field_iwsce7f0df2ec',
										'operator' => '==',
										'value' => 'text',
									),
									array (
										'field' => 'field_iwsc2707ec91w',
										'operator' => '==',
										'value' => '1',
									),
								),
								'allorany' => 'all',
							),
							'column_width' => '',
							'save_format' => 'object',
							'preview_size' => 'thumbnail',
							'library' => 'all',
						),
						array (
							'key' => 'field_iwsce862df2ee',
							'label' => 'Body text',
							'name' => 'body_text',
							'type' => 'textarea',
							'conditional_logic' => array (
								'status' => 1,
								'rules' => array (
									array (
										'field' => 'field_iwsce7f0df2ec',
										'operator' => '==',
										'value' => 'text',
									),
									array (
										'field' => 'field_iwsc2707ec91w',
										'operator' => '==',
										'value' => '1',
									),
								),
								'allorany' => 'all',
							),
							'column_width' => '',
							'default_value' => '',
							'placeholder' => 'Text/HTML',
							'maxlength' => '',
							'rows' => '',
							'formatting' => 'html',
						),
						array (
							'key' => 'field_iwsceeb4d4447',
							'label' => 'Animate',
							'name' => 'animate',
							'type' => 'true_false',
							'conditional_logic' => array (
								'status' => 1,
								'rules' => array (
									array (
										'field' => 'field_iwsce7f0df2ec',
										'operator' => '==',
										'value' => 'text',
									),
									array (
										'field' => 'field_iwsc2707ec91w',
										'operator' => '==',
										'value' => '1',
									),
								),
								'allorany' => 'all',
							),
							'column_width' => '',
							'message' => '',
							'default_value' => 0,
						),
						array (
							'key' => 'field_iwsc44a053fsz',
							'label' => 'Centre content',
							'name' => 'center',
							'type' => 'true_false',
							'conditional_logic' => array (
								'status' => 1,
								'rules' => array (
									array (
										'field' => 'field_iwsce7f0df2ec',
										'operator' => '==',
										'value' => 'text',
									),
									array (
										'field' => 'field_iwsc2707ec91w',
										'operator' => '==',
										'value' => '1',
									),
								),
								'allorany' => 'all',
							),
							'column_width' => '',
							'message' => '',
							'default_value' => 0,
						),
						array (
							'key' => 'field_iwsce892df2f0',
							'label' => 'Image',
							'name' => 'image',
							'type' => 'image',
							'conditional_logic' => array (
								'status' => 1,
								'rules' => array (
									array (
										'field' => 'field_iwsce7f0df2ec',
										'operator' => '==',
										'value' => 'image',
									),
									array (
										'field' => 'field_iwsc2707ec91w',
										'operator' => '==',
										'value' => '1',
									),
								),
								'allorany' => 'all',
							),
							'column_width' => '',
							'save_format' => 'object',
							'preview_size' => 'thumbnail',
							'library' => 'all',
						),
						array (
							'key' => 'field_iwsc2473bdyyq',
							'label' => 'Image sizing',
							'name' => 'image_sizing',
							'type' => 'select',
							'conditional_logic' => array (
								'status' => 1,
								'rules' => array (
									array (
										'field' => 'field_iwsce7f0df2ec',
										'operator' => '==',
										'value' => 'image',
									),
									array (
										'field' => 'field_iwsc2707ec91w',
										'operator' => '==',
										'value' => '1',
									),
								),
								'allorany' => 'all',
							),
							'required' => 1,
							'column_width' => '',
							'choices' => array (
								'cover' => 'Cover',
								'contain' => 'Scaled',
								'circle' => 'Circle',
							),
							'default_value' => 'cover',
							'allow_null' => 0,
							'multiple' => 0,
						),
					),
					'row_min' => 2,
					'row_limit' => 2,
					'layout' => 'row',
					'button_label' => 'Add Column',
				),
				array (
					'key' => 'field_iwsc2d92370ww',
					'label' => 'Horizontal reverse',
					'name' => 'horiz_reverse',
					'type' => 'true_false',
					'instructions' => 'You can reverse the horizontal order of columns with this option.',
					'column_width' => '',
					'message' => '',
					'default_value' => 0,
				),
			),
			'row_min' => '',
			'row_limit' => '',
			'layout' => 'row',
			'button_label' => 'Add Content Row',
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