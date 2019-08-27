<?php
namespace IllicitWeb;

use Exception;

use WP_Query;
use WP_Post;
use WP_Term;

class MenuItemTreeNode extends TreeNode
{
    public function __construct(MenuItem $item_post)
    {
    	parent::__construct($item_post);
    }

    protected function getParentNode()
    {
        $parent_item_post = $this->object->itemParent();

        if ($parent_item_post)
        {
            return new static($parent_item_post);
        }

        return new MenuTreeNode($this->object->menu());
    }

    protected function getChildNodes()
    {
        $item_posts = $this->object->immediateChildItems();

        if ($item_posts)
        {
            return array_map(function (MenuItem $item_post) {
                return new MenuItemTreeNode($item_post);
            }, $item_posts);
        }

        return null;
    }
}
