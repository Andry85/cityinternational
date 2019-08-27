<?php

namespace IllicitWeb;

// Adds 'has-top-banner' or 'no-top-banner' to <body>,
// to enable CSS targeting where the presence or not of a
// top banner affects the elements above/below.
add_action('body_class', function ($classes) {
	if (curr_page_has_top_banner()) 
	{
		$classes[] = 'has-top-banner';
	} 
	else 
	{
		$classes[] = 'no-top-banner';
	}

	if (definedtrue(__NAMESPACE__.'\\HEADER_TRANSPARENT'))
	{
		$classes[] = 'header-transparent';
	}
	else
	{
		$classes[] = 'header-opaque';
	}
	
	return $classes;
});
