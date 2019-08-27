<?php
namespace IllicitWeb;

use Exception;

use WP_Post;
use WP_Query;
use WP_Term;

class Menu extends Term
{
	// @return {static|null}
	final static public function fromMenuIdentifier($menu_str)
	{
		$menu_term = wp_get_nav_menu_object($menu_str);

		if ($menu_term instanceof WP_Term)
		{
			return new static($menu_term);
		}

		return null;
	}

	public function getTopLevelItems()
	{
		$wp_posts = wp_get_nav_menu_items($this->id, [
			'posts_per_page' => -1,
			'post_type' => 'nav_menu_item',
			'post_status' => 'publish',
			'order' => 'ASC',
			'orderby' => 'menu_order',
			'meta_query' => [
				[
					'key' => '_menu_item_menu_item_parent',
					'value' => '0',
				],
			],
		]);

		return $this->itemPostsToMenuItems($wp_posts);
	}

	private function itemPostsToMenuItems($wp_posts)
	{
		return array_map(function (WP_Post $wp_post) {
			return new MenuItem($this, $wp_post);
		}, $wp_posts);
	}
}
