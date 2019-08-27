<?php
/**
 * CachePostMeta abstract class
 * ============================================================================
 *
 * Each Cache subclass represents a type of cache, with its own internal
 * behaviour for storing/fetching cache data.
 *
 * The purpose of this Cache is to expire time-limited data which may be
 * expensive to obtain.
 *
 * This abstract Cache class takes care of storing/fetching a timestamp for
 * stored data items.
 *
 * Cached data must be divided into items with ids which are unique for the
 * particular Cache subclass.
 *
 * Given an id for a data item, you can obtain a *globally* unique identifier
 * for the item using the createGuid() helper method. ('Globally' unique
 * meaning unique among all Cache subclasses, given the uniqueness of the item
 * id within the given Cache subclass.)
 *
 * get() implementations must call deleteIfExpired() before fetching/returning
 * data from the cache.
 *
 * get() implementations must return null if no valid cached data is available.
 *
 * set() implementations must call timestampItem() once item data has been
 * stored.
 * 
 */

namespace IllicitWeb;

use Exception;

abstract class Cache
{
	const OPTION_NAME_PREFIX = '_iwc_';

	abstract public function get($item_id);

	abstract public function set($item_id, $data);

	abstract public function delete($item_id);

	protected function createGuid($item_id)
	{
		$class = preg_replace('/\\\/', '-', static::class);
		return 'iwc-'.$class.'-'.$item_id;
	}

	final protected function deleteIfExpired($item_id, $lifetime_secs)
	{
		if ($this->itemHasExpired($item_id, $lifetime_secs))
		{
			$this->delete($item_id);
		}
	}

	final protected function timestampItem($item_id)
	{
		$option_name = $this->buildOptionName($item_id);
		$option_value = time();
		update_option($option_name, $option_value, false);
	}

	final protected function itemHasExpired($item_id, $lifetime_secs)
	{
		$option_name = $this->buildOptionName($item_id);
		$timestamp = (int)get_option($option_name);
		if ($timestamp <= 1)
		{
			return false;
		}
		$oldest_allowed = time() - $lifetime_secs;
		return $timestamp < $oldest_allowed;
	}

	final protected function buildOptionName($item_id)
	{
		return self::OPTION_NAME_PREFIX.$this->createGuid($item_id);
	}
}
