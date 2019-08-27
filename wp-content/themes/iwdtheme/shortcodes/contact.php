<?php

namespace IllicitWeb;

// @return {string} Value of field, or empty string if undefined.
function _shortcode_get_contact_detail($field)
{
	$value = get_contact_field($field);
	
	if ($value)
	{
		return $value;
	}
	else
	{
		return '';
	}
}

// Email: Obfuscated mailto link
function _shortcode_email($attr, $field)
{
	if (isset($attr['text']))
	{
		$text = $attr['text'];
	}
	else
	{
		$text = null;
	}
	
	return get_safe_email_link(null, $text, null, $field);
}

// Postal address
function _shortcode_postal_address($attr=[])
{
	$value = get_contact_field('postal');

	if (!$value)
	{
		return '';
	}
	
	if (empty($attr['nobreak']))
	{
		$value = nl2br($value);
	}
	
	return $value;
}

add_shortcode('contact_email', function ($attr=[]) {
	return _shortcode_email($attr, 'email');
});

add_shortcode('contact_email_2', function ($attr=[]) {
	return _shortcode_email($attr, 'email_2');
});

add_shortcode('contact_phone', function ($attr=[]) {
	return get_tel_link($attr, 'phone');
});

add_shortcode('contact_phone_1', function ($attr=[]) {
	return get_tel_link($attr, 'phone');
});

add_shortcode('contact_phone_2', function ($attr=[]) {
	return get_tel_link($attr, 'phone_2');
});

add_shortcode('contact_phone_3', function ($attr=[]) {
	return get_tel_link($attr, 'phone_3');
});

add_shortcode('contact_phone_4', function ($attr=[]) {
	return get_tel_link($attr, 'phone_4');
});

add_shortcode('contact_postal_address', function ($attr=[]) {
	return _shortcode_postal_address($attr);
});

add_shortcode('contact_address', function ($attr=[]) {
	return _shortcode_postal_address($attr);
});
