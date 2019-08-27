<?php
/**
 * CachePostMeta class
 * ============================================================================
 *
 * Useful for storing finite-lifespan, expensive-to-obtain data which is
 * associated with particular posts.
 *
 * Example usage:
 * ----------------------------------------------------------------------------
 * $cache = new CachePostMeta($post_id);
 * $data = $cache->get('expensive_data');
 * if ($data === null) {
 *     $data = get_expensive_data($post_id);
 *     $cache->set('expensive_data', $data);
 * }
 * do_something($data);
 *
 * Notes:
 * ----------------------------------------------------------------------------
 * The cached data items for CachePostMeta instances are stored as postmeta.
 * Each item is associated with exactly one WP post.
 * 
 * Each CachePostMeta instance is associated with the WP post whose ID is
 * passed into the constructor.
 * 
 * The $item_id passed to get(), set() etc. is an id for the type of data stored
 * as post meta data (e.g. "product_rating" for a product post). It does not
 * have to include an id for the post; this is taken care of automatically by
 * CachePostMeta::createGuid().
 * 
 */

namespace IllicitWeb;

use Exception;

class CachePostMeta extends Cache
{
	const LIFETIME = 86400;

	protected $postId;

	public function __construct($post_id)
	{
		$this->postId = $post_id;
	}

	public function get($item_id)
	{
		$this->deleteIfExpired($item_id, static::LIFETIME);
		$key = $this->createGuid($item_id);
		if (metadata_exists('post', $this->postId, $key))
		{
			$json = get_post_meta($this->postId, $key, true);
			return json_decode($json, true);
		}
		return null;
	}

	public function set($item_id, $data)
	{
		$key = $this->createGuid($item_id);
		update_post_meta($this->postId, $key, json_encode($data));
		$this->timestampItem($item_id);
	}

	public function delete($item_id)
	{
		$key = $this->createGuid($item_id);
		delete_post_meta($this->postId, $key);
	}

	protected function createGuid($item_id)
	{
		return parent::createGuid($this->postId.'-'.$item_id);
	}
}
