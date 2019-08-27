<?php
namespace IllicitWeb;

use DateTime;
use DateInterval;
use Exception;

use WP_Post;
use WP_Query;

abstract class AcfObject
{
	abstract public function acfId();
	
	// @return {mixed} ACF value
	public function acf($field)
	{
		return $this->getAcfValue($field);
	}

	public function acfTrim($field)
	{
		$value = $this->getAcfValue($field);
		
		if (is_string($value))
		{
			return trim($value);
		}
		else
		{
			return $value;
		}
	}

	public function acfTruncate($field, $word_count = null)
	{
		$value = $this->acfTrim($field);

		if (!$value)
		{
			return $value;
		}

		return truncate($value, $word_count);
	}

	// @return {Post|null}
	public function acfPost($field)
	{
		$wp_post = $this->getAcfValue($field);
		
		if ($wp_post)
		{
			assert($wp_post instanceof WP_Post, 'Expected WP_Post, got '.gettype($wp_post));
			
			return new Post($wp_post);
		}
		
		return null;
	}

	// @return Post[]
	public function acfPosts($field)
	{
		$wp_posts = $this->getAcfValue($field);

		if ($wp_posts)
		{
			assert(is_array($wp_posts), 
				'Expected array of WP_Post, got '.gettype($wp_posts));

			return Post::fromWpPosts($wp_posts);
		}
		
		return [];
	}
	
	public function acfDateTime($field)
	{
		$value = $this->acf($field);
		
		if ($value)
		{
			$value = str_replace('/', '-', $value);
			return new DateTime($value);
		}
		else
		{
			return null;
		}
	}

	public function acfDateFormatted($field, $format=null)
	{
		$datetime = $this->acfDateTime($field);
		
		if ($datetime === null)
		{
			return '';
		}

		if ($format === null)
		{
			$format = TERSE_DATE_FORMAT;
		}

		return $datetime->format($format);
	}
	
	private $acfCache = []; // Field names mapped to values

	protected function getAcfValue($field)
	{
		if (array_key_exists($field, $this->acfCache))
		{
			return $this->acfCache[$field];
		}
		
		$value = get_field($field, $this->acfId());
		
		$this->acfCache[$field] = $value;
		
		return $value;
	}
	
	// @param {int} $id ID of image in WP media library
	// @param {int|array|null} $fallback Image data array or ID for fallback image
	protected function getImageById($id, $fallback=null)
	{
		$id = (int)$id;

		if ($id > 0)
		{
			$image = $this->buildImageArray($id);
			
			if ($image)
			{
				return $image;
			}
		}

		return $this->resolveFallbackImage($fallback);
	}
	
	// @param {int|array|null} $fallback Image data array or ID for fallback image
	protected function resolveFallbackImage($fallback)
	{
		if (is_array($fallback) || ($fallback === null))
		{
			return $fallback;
		}

		$fallback_id = (int)$fallback;
		
		if ($fallback_id <= 0)
		{
			return null;
		}

		return $this->buildImageArray($fallback_id);
	}

	// @return image array or null
	protected function buildImageArray($id)
	{
		$id = (int)$id;
		$src = wp_get_attachment_image_src($id, 'full');
		if (!$src)
		{
			return null;
		}

		$image = [];
		$image['id'] = $id;
		$image['url'] = $src[0];
		$image['width'] = $src[1];
		$image['height'] = $src[2];
		$image['alt'] = get_post_meta($id, '_wp_attachment_image_alt', true);
		$image['title'] = get_post_field('post_title', $id);
		$image['caption'] = get_post_field('post_excerpt', $id);
		$image['description'] = get_post_field('post_content', $id);
		$image['sizes'] = array();

		foreach (get_intermediate_image_sizes() as $size)
		{
			$src = wp_get_attachment_image_src($id, $size);
			$image['sizes'][$size] = $src[0];
		}

		return $image;
	}
}
