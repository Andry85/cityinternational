<?php
namespace IllicitWeb;

use DateTime;
use DateInterval;
use Exception;

use WP_Post;
use WP_Query;
use WP_Term;

class Term extends AcfObject
{
    protected $term;
    protected $taxonomy;
	protected $id;

	// params same as for get_terms()
	final static public function fromTaxonomies($tax, $args=null)
	{
		$terms = get_terms($tax, $args);

		if (is_array($terms))
		{
			return static::fromWpTerms($terms);
		}

		return [];
	}

	// @return {static|null}
	final static public function fromCurrent()
	{
		$wp_term = get_queried_object();

		if ($wp_term instanceof WP_Term)
		{
			return new static($wp_term);
		}

		return null;
	}

	// @param {array} $wp_terms Array of WP_Term
	// @return {array} Array of static
	final static public function fromWpTerms($wp_terms)
	{
		$terms = [];

		foreach ($wp_terms as $wp_term)
		{
			$terms[] = new static($wp_term);
		}

		return $terms;
	}

	final static public function fromSlug($slug, $taxonomy)
	{
		$term = get_term_by('slug', $slug, $taxonomy);

		if ($term instanceof WP_Term)
		{
			return new static($term);
		}
	}

	final static public function fromName($name, $taxonomy)
	{
		$term = get_term_by('name', $name, $taxonomy);

		if ($term instanceof WP_Term)
		{
			return new static($term);
		}
	}

	final static public function fromId($id, $taxonomy)
	{
		$term = get_term_by('id', (int)$id, $taxonomy);

		if ($term instanceof WP_Term)
		{
			return new static($term);
		}
	}

	final static public function fromIds($term_ids, $taxonomy)
	{
		$terms = [];
		
		foreach ($term_ids as $term_id)
		{
			$term = static::fromId($term_id, $taxonomy);
			if ($term)
			{
				$terms[] = $term;
			}
		}
		
		return $terms;
	}

    public function __construct(WP_Term $wp_term)
    {
        $this->term = $wp_term;
		$this->id = $wp_term->term_id;
		$this->taxonomy = $wp_term->taxonomy;
    }

	public function id()
	{
		return $this->id;
	}

    public function acfId()
	{
		return $this->term;
	}

    public function taxonomy()
    {
        return $this->taxonomy;
    }

	public function link()
	{
		return get_term_link($this->term, $this->taxonomy);
	}

	public function name()
	{
		return $this->term->name;
	}

	public function slug()
	{
		return $this->term->slug;
	}

	public function description()
	{
		return term_description($this->id, $this->taxonomy);
	}

	public function parentId()
	{
		return $this->term->parent;
	}

	public function parent()
	{
		$parent_id = $this->parentId();

		if (!$parent_id)
		{
			return null;
		}

		$term = get_term($parent_id, $this->taxonomy);

		if ($term instanceof WP_Term)
		{
			return new static($term);
		}

		return null;
	}

	public function descendents($hide_empty=true)
	{
		$term_ids = get_term_children($this->id, $this->taxonomy);

		if (!is_array($term_ids))
		{
			return [];
		}

		$tax = $this->taxonomy;

		$terms = [];

		foreach ($term_ids as $term_id) 
		{	
			$wp_term = get_term_by('id', $term_id, $tax);

			if ($wp_term instanceof WP_Term)
			{
				$terms[] = new Term($wp_term);
			}
		}

		return $terms;
	}

	public function immediateChildren($hide_empty=true)
	{
		$terms = get_terms($this->taxonomy, [
    		'parent' => $this->id,
    		'hide_empty' => $hide_empty,
    	]);

    	if (is_array($terms))
    	{
    		return static::fromWpTerms($terms);
    	}

    	return [];
	}

	public function posts($user_wp_query_args=null)
	{
		$wp_query_args = [
			'posts_per_page' => -1,
			'post_type' => 'any',
			'post_status' => 'publish',
			'tax_query' => [
				[
					'taxonomy' => $this->taxonomy,
					'terms' => $this->id,
				],
			],
		];

		if ($user_wp_query_args)
		{
			$wp_query_args = array_merge($wp_query_args, $user_wp_query_args);
		}

		return Post::fromQueryArgs($wp_query_args);
	}

	public function ancestors()
	{
		$ids = get_ancestors($this->id, $this->taxonomy);

		if (is_array($ids))
		{
			return static::fromIds($ids, $this->taxonomy);
		}

		return [];
	}

	public function topLevelAncestor()
	{
		$instances = $this->ancestors();

		return array_pop($instances);
	}
}
