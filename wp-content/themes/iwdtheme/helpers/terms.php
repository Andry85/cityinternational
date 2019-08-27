<?php

namespace IllicitWeb;

// @return {string} Term name
function get_curr_term_name()
{
	static $name;

	if (!isset($name)) {
		$term = get_queried_object();

		if (!empty($term->name)) 
		{
			$name = $term->name;
		} 
		else 
		{
			$name = '';
		}
	}

	return $name;
}
