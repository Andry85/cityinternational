<?php

namespace IllicitWeb;

use DateTime;
use DateInterval;
use Exception;

use WP_Post;
use WP_Query;
use WP_Term;

class Post extends AcfObject
{
	static public function fromTitle($post_title, array $additional_query_args=null)
	{
		$args = ['title' => $post_title];

		if ($additional_query_args)
		{
			$args = array_merge($args, $additional_query_args);
		}

		return static::oneFromQueryArgs($args);
	}

	static public function fromName($post_name, array $additional_query_args=null)
	{
		$args = ['name' => $post_name];
		
		if ($additional_query_args)
		{
			$args = array_merge($args, $additional_query_args);
		}

		return static::oneFromQueryArgs($args);
	}

	static public function oneFromQueryArgs(array $additional_query_args=null)
	{
		$args = [
			'post_status' => 'publish',
			'posts_per_page' => 1,
		];

		if ($additional_query_args)
		{
			$args = array_merge($args, $additional_query_args);
		}

		$posts = static::fromQueryArgs($args);

		return $posts ? $posts[0] : null;
	}
	
	static public function fromId($post_id)
	{
		$post = get_post($post_id);
		
		if ($post instanceof WP_Post)
		{
			return new static($post);
		}
		
		return null;
	}

	static public function fromCurrent()
	{
		global $post;

		return !empty($post) ? new static($post) : null;
	}

	static public function fromLatestOne($post_type=null)
	{
		$post_array = static::fromLatest(1, $post_type);

		return $post_array ? $post_array[0] : null;
	}
	
	static public function fromLatest($num_posts=null, $post_type=null)
	{
		if (!$num_posts)
		{
			$num_posts = (int)get_option('posts_per_page');
		}

		$args = [
			'posts_per_page' => $num_posts,
			'post_status' => 'publish',
		];

		if ($post_type)
		{
			$args['post_type'] = $post_type;
		}

		$wp_posts = get_posts($args);

		if (is_array($wp_posts))
		{
			return array_map(function (WP_Post $wp_post) {
				return new static($wp_post);
			}, $wp_posts);
		}
		else
		{
			return [];
		}
	}

	// @param {array} $wp_posts Array of WP_Post
	static public function fromWpPosts(array $wp_posts)
	{
		$posts = array();
		
		foreach ($wp_posts as $wp_post)
		{
			$posts[] = new static($wp_post);
		}
		
		return $posts;
	}

	static public function fromQueryArgs(array $args)
	{
		$posts = get_posts($args);
		
		if (is_array($posts))
		{
			return static::fromWpPosts($posts);
		}
		
		return [];
	}

	static public function fromIds(array $post_ids)
	{
		$posts = array();
		
		foreach ($post_ids as $post_id)
		{
			$post = static::fromId($post_id);
			if ($post)
			{
				$posts[] = $post;
			}
		}
		
		return $posts;
	}

	// @todo needs more testing
	static public function fromCurrentTerm(array $query_args=null)
	{
		$term = Term::fromCurrent();

		if ($term)
		{
			return $term->posts($query_args);
		}

		return [];
	}

	static public function fromCurrentQuery()
	{
		global $wp_query;

		if (!empty($wp_query))
		{
			return static::fromWpPosts($wp_query->get_posts());
		}

		return [];
	}
	
	protected $post;

	protected $id;

	public function __construct(WP_Post $post)
	{
		$this->post = $post;
		$this->id = $post->ID;
	}

	
	public function id()
	{
		return $this->id;
	}
	
	public function acfId()
	{
		return $this->id;
	}

	public function title()
	{
		return $this->post->post_title;
	}

	public function type()
	{
		return $this->post->post_type;
	}

	public function isPage()
	{
		return $this->post->post_type === 'page';
	}

	public function name()
	{
		return $this->post->post_name;
	}

	public function content()
	{
		return apply_filters('the_content', do_shortcode($this->post->post_content));
	}

	public function typeLabel()
	{
		$type = $this->typeObject();
		return $type->labels->singular_name;
	}

	public function typeObject()
	{
		return get_post_type_object($this->post->post_type);
	}

	public function post($prop=null)
	{
		if ($prop === null)
		{
			return $this->post;
		}
		else
		{
			return $this->post->$prop;
		}
	}

	public function date($format=null)
	{
		if (!$format)
		{
			$format = TERSE_DATE_FORMAT;
		}
		
		return get_post_time($format, false, $this->id, false);
	}

	public function authorId()
	{
		$author_id = $this->post->post_author;
		if (!$author_id)
		{
			return null;
		}
		return (int)$author_id;
	}

	// Returns WP_User or null
	public function authorUserData()
	{
		$author_id = $this->authorId();
		if (!$author_id)
		{
			return null;
		}
		$wp_user = get_userdata($author_id);
		return $wp_user ? $wp_user : null;
	}

	public function authorDisplayName()
	{
		$data = $this->authorUserData();
		if (empty($data->display_name))
		{
			return null;
		}
		return $data->display_name;
	}

	public function time()
	{
		return get_post_time('U', false, $this->id, false);
	}

	public function link()
	{
		return get_permalink($this->post->ID);
	}

	public function editLink()
	{
		return get_edit_post_link($this->post->ID);
	}

	public function excerpt($word_count=0)
	{
		if ($word_count < 1)
		{
			$word_count = 35;
		}

		$excerpt = trim($this->post->post_excerpt);

		if (!$excerpt)
		{
			// Strip tags and images from post content
			$excerpt = strip_tags(strip_shortcodes($this->post->post_content));
		}

		$words = explode(' ', trim($excerpt), $word_count + 1);

		if (count($words) > $word_count)
		{
			array_pop($words);
			$excerpt = trim(implode(' ', $words)).'…';			
		}

		return $excerpt;
	}

	// @param {int|array|null} Image data array or ID for fallback image
	// @return {assoc|true|null} Assoc for featured image, if there is one.
	// If boolean true is passed, the standard default post thumbnail is used
	// as a fallback.
	public function image($fallback=null)
	{
		$id = get_post_thumbnail_id($this->id);

		if ($fallback === true)
		{
			$fallback = get_field('default_post_image', 'option');
		}
		
		return $this->getImageById($id, $fallback);
	}
	
	public function imageUrl($size=null)
	{
		$image = $this->image();

		if ($image === null)
		{
			return null;
		}

		elseif ($size === null || $size === 'full')
		{
			return $image['url'];
		}

		elseif (!empty($image['sizes'][$size]))
		{
			return $image['sizes'][$size];
		}

		else
		{
			trigger_error('Size not recognised: '.$size);
			return null;
		}
	}

	public function imageAlt()
	{
		$image = $this->image();
		if ($image !== null)
		{
			return $image['alt'];
		}
		else
		{
			return '';
		}
	}

	public function toArray()
	{
		$meta = $this->getPublicMeta();
		
		$post = (array)$this->post;
		
		return [
			'meta' => $meta,
			'post' => $post,
		];
	}

	private function getPublicMeta()
	{
		$meta = get_post_meta($this->post->ID);
		
		$pubmeta = [];
		
		foreach ($meta as $key => $value)
		{
			if (substr($key, 0, 1) !== '_')
			{
				$pubmeta[$key] = $value;
			}
		}
		
		return $pubmeta;
	}

	// @return {array} Array of Term objects, or empty array on fail.
	public function terms($taxonomy, array $args=null)
	{
		return Term::fromWpTerms($this->wpTerms($taxonomy, $args));
	}

	// @return {array} Array of WP_Term objects, or empty array on fail.
	public function wpTerms($taxonomy, array $args=null)
	{
		$terms = wp_get_post_terms($this->post->ID, $taxonomy, $args);
		
		if (is_array($terms))
		{
			return $terms;
		}
		else
		{
			return [];
		}
	}

	public function parentId()
	{
		return $this->post->post_parent;
	}

	public function parent()
	{
		if ($this->post->post_parent)
		{
			return static::fromId($this->post->post_parent);
		}

		return null;
	}

	public function ancestors()
	{
		$ids = get_ancestors($this->id, $this->type());

		if (is_array($ids))
		{
			return static::fromIds($ids);
		}

		return [];
	}

	public function topLevelAncestor()
	{
		$instances = $this->ancestors();

		$post = array_pop($instances);

		if ($post)
		{
			return $post;
		}

		return $this;
	}
}
