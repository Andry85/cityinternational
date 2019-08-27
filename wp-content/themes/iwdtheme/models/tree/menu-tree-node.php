<?php

namespace IllicitWeb;

use Exception;

use WP_Query;
use WP_Post;
use WP_Term;

class MenuTreeNode extends TreeNode
{
    public function __construct(Menu $menu_term)
    {
    	parent::__construct($menu_term);
    }

    protected function getParentNode()
    {
        return null;
    }

    protected function getChildNodes()
    {
        $items = $this->object->getTopLevelItems();

        if ($items)
        {
            return array_map(function (MenuItem $item) {
                return new MenuItemTreeNode($item);
            }, $items);
        }

        return null;
    }
}
