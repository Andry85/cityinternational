<?php
namespace IllicitWeb;

use Exception;

use WP_Post;
use WP_Query;
use WP_Term;

class MenuItem extends Post
{
	private $menu; // Menu

	static public function fromMenu(Menu $menu)
	{
		$wp_posts = wp_get_nav_menu_items($menu->id());

		$item_posts = array();
		
		foreach ($wp_posts as $wp_post)
		{
			$item_posts[] = new static($menu, $wp_post);
		}
		
		return $item_posts;
	}

	public function __construct(Menu $menu, WP_Post $item_post)
	{
		parent::__construct($item_post);

		$this->menu = $menu;
	}

	public function menu()
	{
		return $this->menu;
	}

	public function itemParent()
	{
		$parent_id = $this->itemParentId();

		if ($parent_id)
		{
			return static::fromId($parent_id);
		}

		return null;
	}

	public function menuOrder()
	{
		return $this->post->menu_order;
	}

	public function itemType()
	{
		return $this->post->type;
	}

	public function objectId()
	{
		return (int)$this->post->object_id;
	}

	public function objectPost()
	{
		if ($this->itemType() !== 'post_type')
		{
			return null;
		}

		return Post::fromId($this->objectId());
	}

	// @todo objectTerm(), object(), objectLink()??

	public function objectType()
	{
		return $this->post->object;
	}

	public function objectUrl()
	{
		return $this->post->url;
	}

	public function itemParentId()
	{
		return (int)$this->post->menu_item_parent;
	}

	public function itemTitle()
	{
		return $this->post->title;
	}

	public function itemTarget()
	{
		return $this->post->target;
	}

	public function immediateChildItems()
	{
		$wp_posts = wp_get_nav_menu_items($this->menu->id(), [
			'posts_per_page' => -1,
			'post_type' => 'nav_menu_item',
			'post_status' => 'publish',
			'order' => 'ASC',
			'orderby' => 'menu_order',
			'meta_query' => [
				[
					'key' => '_menu_item_menu_item_parent',
					'value' => $this->id,
				],
			],
		]);

		return $this->itemPostsToMenuItems($wp_posts);
	}

	private function itemPostsToMenuItems($wp_posts)
	{
		return array_map(function (WP_Post $wp_post) {
			return new self($this->menu, $wp_post);
		}, $wp_posts);
	}
}
