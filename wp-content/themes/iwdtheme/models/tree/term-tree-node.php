<?php

namespace IllicitWeb;

use Exception;

use WP_Query;
use WP_Post;
use WP_Term;

class TermTreeNode extends TreeNode
{
    protected $hideEmpty;

    public function __construct(Term $term, $hide_empty=false)
    {
        $this->hideEmpty = $hide_empty;

    	parent::__construct($term);
    }

    protected function getParentNode()
    {
        $parent_term = $this->object->parent();

        if ($parent_term)
        {
            return new static($parent_term);
        }

        return null;
    }

    protected function getChildNodes()
    {
        $terms = $this->object->immediateChildren($this->hideEmpty);

        if ($terms)
        {
            return array_map(function (Term $term) {
                return new TermTreeNode($term, $this->hideEmpty);
            }, $terms);
        }

        return null;
    }
}
