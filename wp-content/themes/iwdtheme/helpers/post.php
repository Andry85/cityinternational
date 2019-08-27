<?php

namespace IllicitWeb;

use WP_Query;
use WP_Post;
use WP_Term;

// @return {bool} Whether the page with post id $post_id is the front page
function post_is_front_page($post_id)
{
	$post_id = (int)$post_id;

	$front_page_id = get_front_page_id();

	return ($post_id === $front_page_id);
}

function get_front_page_id()
{
	return (int)get_option('page_on_front');
}
