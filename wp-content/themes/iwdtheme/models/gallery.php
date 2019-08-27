<?php

namespace IllicitWeb;

use WP_Post;
use WP_Query;

use Exception;
use Iterator;
use Countable;

class Gallery extends Post implements Iterator, Countable
{
	public function __construct(WP_Post $post)
	{
		parent::__construct($post);
		$this->populate();
	}

	// @return {array} Array of image assocs, or empty array on fail
	public function images()
	{
		return $this->images;
	}

	private function populate()
	{
		$images_data = $this->acf('iw_gallery_images');
		
		if (!$images_data) 
		{
			return;
		}

		foreach ($images_data as $image_data_row) 
		{
			$image = $image_data_row['image'];
		
			if (!empty($image['url'])) 
			{
				if (!empty($image_data_row['caption'])) 
				{
					$image['caption'] = $image_data_row['caption'];
				}

				$this->images[] = $image;
			}
		}
	}

	private $position = 0;

	public function rewind()
	{
        $this->position = 0;
    }

    public function current()
	{
        return $this->images[$this->position];
    }

    public function key()
	{
        return $this->position;
    }

    public function next()
	{
        ++$this->position;
    }

    public function valid()
	{
        return isset($this->images[$this->position]);
    }

	public function count()
	{
		return count($this->images);
	}

	public function isEmpty()
	{
		return empty($this->images);
	}
}
