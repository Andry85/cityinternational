<?php

namespace IllicitWeb;

use Exception;

use WP_Query;
use WP_Post;
use WP_Term;

abstract class TreeNode
{
    protected $object;

    public function __construct(AcfObject $object)
    {
    	$this->object = $object;
    }

    // Must return TreeNode
    abstract protected function getParentNode();

    // Must return array of TreeNodes
    abstract protected function getChildNodes();

    public function getObject()
    {
        return $this->object;
    }

    // $fn called recursively for each child node, including $max_level_index.
    // $fn not called for this node.
    // $fn is passed (1) TreeNode (2) level index (3) sibling index.
    public function walk($fn, $max_level_index=-1)
    {
    	$this->walkNode($fn, $this, $max_level_index, 0);
    }

    private function walkNode($fn, TreeNode $node, $max_level_index, $level_index)
    {
        if ($max_level_index >= 0 && $level_index > $max_level_index)
        {
            return;
        }

        $child_nodes = $node->getChildNodes();

        if (!$child_nodes)
        {
            return;
        }

        ++$level_index;

        $sibling_index = 0;

        foreach ($child_nodes as $child_node)
        {
            $fn($child_node, $level_index, $sibling_index);

            $this->walkNode($fn, $child_node, $max_level_index, $level_index);

            ++$sibling_index;
        }
    }
}
