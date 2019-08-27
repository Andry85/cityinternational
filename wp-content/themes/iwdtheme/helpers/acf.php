<?php

namespace IllicitWeb;

// If returned value is a string, it is trimmed before being returned.
// Else, returned unchanged.
function get_field_trimmed($field_name, $post_id=false, $format_value=true)
{
	$value = get_field($field_name, $post_id, $format_value);
	
	if (is_string($value))
	{
		return trim($value);
	}
	else
	{
		return $value;
	}
}

// Passed value for ACF field to $fn, if the value exists; else, does nothing
// @param {string} $field Name of ACF field
// @param {fn} $fn Function to be passed field's value, if it is nonempty
// @return {void}
function for_field($field, $fn)
{
	$value = get_field($field);
	if ($value)
	{
		$fn($value);
	}
}

// @param {string} $field Name of ACF repeater field
// @param {fn} $fn Function to be passed each row in ACF repeater field
// @return {void}
function foreach_field_row($field, $fn)
{
	$rows = get_field($field);
	if ($rows === false)
	{
		// no data
		return;
	}
	if (is_array($rows))
	{
		foreach ($rows as $row)
		{
			$fn($row);
		}
	}
	else
	{
		trigger_error("get_field( $field ) did not return an array, returned "
					  .gettype($rows));
	}
}
