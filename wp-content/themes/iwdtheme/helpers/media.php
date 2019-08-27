<?php

namespace IllicitWeb;

use WP_Post;
use WP_Query;

// Get image URL from image ID, or null on fail
function get_img_url_by_id($image_id, $size='full') 
{
	$img_data = wp_get_attachment_image_src($image_id, $size, false);

	if (!empty($img_data[0])) 
	{
		return $img_data[0];
	}
	
	return null;
}

// @param {int} Media item attachment ID
// @return {assoc/null} Image array or null if not found
function get_img($id)
{
	$src = wp_get_attachment_image_src($id, 'full');

	if ($src)
	{
		$data = array();
		$data['url'] = $src[0];
		$data['width'] = $src[1];
		$data['height'] = $src[2];
		$data['alt'] = get_post_meta($id, '_wp_attachment_image_alt', true);
		$data['caption'] = get_post_field('post_excerpt', $id);
		$data['description'] = get_post_field('post_content', $id);
		$data['sizes'] = array();

		foreach (get_intermediate_image_sizes() as $size) {
			$src = wp_get_attachment_image_src($id, $size);
			$data['sizes'][$size] = $src[0];
		}

		return $data;
	} 
	else 
	{
		return null;
	}
}

// If on mobile, returns 'large' size'.
// Else, return url for original image file.
function extract_large_image_url($image)
{
	if (on_mobile())
	{
		return $image['sizes']['large'];
	}

	return $image['url'];
}
