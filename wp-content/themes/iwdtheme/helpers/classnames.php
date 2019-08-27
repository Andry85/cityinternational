<?php

namespace IllicitWeb;

// @param {string|string[]|string[][]...} Each string may be a single classname
// or space-separated string of classnames. Arrays may be deeply nested.
// @return {string} Class name value
function classnames(...$class_data)
{
	$strings = array_unique(_class_array_to_string_array($class_data));
	return implode(' ', $strings);
}

function _class_string_to_string_array($class)
{
	$class = trim($class);

	if ($class === '')
	{
		return [];
	}

	return preg_split('/\s+/', $class);
}

function _class_array_to_string_array(array $class_array)
{
	$strings = [];

	foreach ($class_array as $class)
	{
		if (is_string($class))
		{
			$strings = array_merge($strings, _class_string_to_string_array($class));
		}
		elseif (is_array($class))
		{
			$strings = array_merge($strings, _class_array_to_string_array($class));
		}
	}

	return $strings;
}
