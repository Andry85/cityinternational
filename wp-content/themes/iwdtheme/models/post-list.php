<?php

// For customised lists of posts. Takes care of pagination, reads offset from
// URL via 'pindex' query param.

// Don't forget to call populate().

// Example usage:
// -------------------------------------------

// $postlist = new PostList();
// $postlist->setPostType('my_custom_postype');
// $postlist->setSearchQuery('foobar');
// $postlist->setTermBySlug('my_custom_tax', 'some-term-slug');
// $postlist->populate();
// $postlist->forEachPost(function (Post $post) { ... });

namespace IllicitWeb;

use WP_Post;
use WP_Query;
use WP_Term;

use DateTime;
use DateInterval;

class PostList
{
    const OFFSET_URL_PARAM = 'pindex';
    const DEFAULT_PER_PAGE = 20;

    private $queryArgs = []; // Args for WP_Query
    private $posts = null;
    private $populated = false;
    private $totalPostCount = null;

    protected $postClass = 'IllicitWeb\\Post';

    public function __construct()
    {
        $this->resetQuery();
    }

    public function getTotalPostCount()
    {
        return $this->totalPostCount;
    }

    public function getOffset()
    {
        if (isset($this->queryArgs['offset']))
        {
            return $this->queryArgs['offset'];
        }

        return 0;
    }

    public function getNextOffset()
    {
        $pag_data = $this->getPaginationData();
        return $pag_data['next_offset'];
    }

    public function thereAreFurtherPages()
    {
        $pag_data = $this->getPaginationData();
        return ($pag_data['number_of_pages'] > 1) && !$pag_data['is_last_page'];
    }

    private $paginationDataCache = null;

    // Returns array of data. Should be everything you need to implement
    // pagination on the front-end. See also getPaginationLinks(), which might
    // provide a shortcut for the most common use cases.
    public function getPaginationData()
    {
        if ($this->paginationDataCache)
        {
            return $this->paginationDataCache;
        }

        if (!$this->populated)
        {
            $this->populate();
        }

        $total_num_posts = $this->totalPostCount;

        if ($total_num_posts === null)
        {
            return null;
        }

        $curr_offset = $this->getOffset();

        assert($curr_offset !== null);
        assert(is_int($curr_offset));

        $num_pages = $this->calcNumResultPages($total_num_posts, $curr_offset);

        $length = $this->getLength();

        if ($total_num_posts <= 0)
        {
            $page_numbers = [];
        }
        else
        {
            $page_numbers = [];
            $offset_key = static::OFFSET_URL_PARAM;
            $offset = $curr_offset;

            while (true)
            {
                if ($offset < 0)
                {
                    $offset = 0;
                }

                $page_numbers[] = [
                    'page' => 1 + ceil($offset / $length),
                    'offset' => $offset,
                    'url_query' => $offset_key.'='.$offset,
                    'is_current' => ($offset == $curr_offset),
                ];

                if ($offset == 0)
                {
                    break;
                }

                $offset -= $length;
            }

            $offset = $curr_offset + $length;

            while (true)
            {
                if ($offset >= $total_num_posts)
                {
                    break;
                }

                $page_numbers[] = [
                    'page' => 1 + ceil($offset / $length),
                    'offset' => $offset,
                    'url_query' => $offset_key.'='.$offset,
                    'is_current' => ($offset == $curr_offset),
                ];

                $offset += $length;
            }

            usort($page_numbers, function (array $a, array $b) {
                return $a['page'] - $b['page'];
            });
        }

        $is_first_page = ($curr_offset <= 0);
        $is_last_page = ($curr_offset >= ($total_num_posts - $length));

        $prev_offset = $is_first_page ? null : max(0, $curr_offset - $length);
        $next_offset = $is_last_page ? null : ($curr_offset + $length);
        
        $pagination_data = [
            'current_offset' => $curr_offset,
            'prev_offset' => $prev_offset,
            'next_offset' => $next_offset,
            'number_of_pages' => count($page_numbers),
            'posts_per_page' => $length,
            'total_posts' => $total_num_posts,
            'page_numbers' => $page_numbers,
            'is_first_page' => $is_first_page,
            'is_last_page' => $is_last_page,
        ];

        $this->paginationDataCache = $pagination_data;

        return $pagination_data;
    }

    // Returns array of HTML strings for <a> elements, for pagination.
    public function getPaginationLinks($base_url = null)
    {
        $pagination_data = $this->getPaginationData();

        if ($pagination_data === null)
        {
            return [];
        }

        $url_builder = $this->createUrlBuilder($base_url);

        $query_key = self::OFFSET_URL_PARAM;

        return array_map(function (array $page_number_data) use ($url_builder, $query_key) {
            $offset = $page_number_data['offset'];

            $url_builder->addQueryArg($query_key, $offset);

            $html = '<a href="'.$url_builder.'"';

            if ($page_number_data['is_current'])
            {
                $html .= ' class="current"';
            }

            $html .= '>'.$page_number_data['page'].'</a>';

            return $html;

        }, $pagination_data['page_numbers']);
    }

    private function createUrlBuilder($base_url)
    {
        $url_builder = new UrlBuilder();

        if ($base_url)
        {
            $url_builder->setFromString($base_url);
        }
        else
        {
            $url_builder->setFromCurrent();
        }

        return $url_builder;
    }

    public function getPreviousPageUrl($base_url = null)
    {
        return $this->getAdjacentPageUrl('prev_offset', $base_url);
    }

    public function getNextPageUrl($base_url = null)
    {
        return $this->getAdjacentPageUrl('next_offset', $base_url);
    }

    private function getAdjacentPageUrl($pag_data_offset_key, $base_url)
    {
        $pagination_data = $this->getPaginationData();
        if ($pagination_data === null)
        {
            return null;
        }

        $offset = $pagination_data[$pag_data_offset_key];

        if ($offset === null)
        {
            return null;
        }

        $url_builder = $this->createUrlBuilder($base_url);

        $url_builder->addQueryArg(self::OFFSET_URL_PARAM, $offset);
        
        return $url_builder->buildUrl();
    }

    private function calcNumResultPages()
    {
        if (!$this->populated)
        {
            return 0;
        }

        $per_page = $this->getLength();

        if ($per_page <= 0)
        {
            return 1;
        }

        return ceil($this->getTotalPostCount() / $per_page);
    }

    public function getLength()
    {
        return $this->queryArgs['posts_per_page'];
    }

    public function resetQuery()
    {
        $this->queryArgs = [];
        
        $this->updateQueryArgs([
            'posts_per_page' => $this->getDefaultLength(),
            'post_status' => 'publish',
            'offset' => $this->getRequestedOffset(),
        ]);
    }

    private function getRequestedOffset()
    {
        $key = static::OFFSET_URL_PARAM;

        if (!empty($_GET[$key]))
        {
            return (int)$_GET[$key];
        }

        return 0;
    }

    protected function updateQueryArgs($partial_query_args)
    {
        $this->queryArgs = array_merge($this->queryArgs, $partial_query_args);
        $this->clearPopulationData();
    }

    private function deleteQueryArg($key)
    {
        unset($this->queryArgs[$key]);
        $this->clearPopulationData();
    }

    private function clearPopulationData()
    {
        $this->populated = false;
        $this->totalPostCount = null;
        $this->paginationDataCache = null;
    }

    public function setPostType($post_type)
    {
        assert(is_string($post_type) || is_array($post_type));

        $this->updateQueryArgs(['post_type' => $post_type]);
    }

    public function setSearchPhrase($phrase)
    {
        $this->updateQueryArgs(['s' => $phrase]);
    }

    public function getPostType()
    {
        if (isset($this->queryArgs['post_type']))
        {
            return $this->queryArgs['post_type'];
        }

        return null;
    }

    public function getSearchPhrase()
    {
        if (isset($this->queryArgs['s']))
        {
            return $this->queryArgs['s'];
        }

        return null;
    }

    public function setTermBySlug($tax, $slug)
    {
        $this->setTermBy($tax, 'slug', $slug);
    }

    // @todo integrate meta query

    public function setTermBy($tax, $field, $value)
    {
        $tax_query = isset($this->queryArgs['tax_query']) ? 
            $this->queryArgs['tax_query'] :
            ['relation' => 'AND'];

        $tax_query[] = [
            'taxonomy' => $tax,
            'field' => $field,
            'terms' => $value,
        ];

        $this->updateQueryArgs(['tax_query' => $tax_query]);
    }

    public function setOffset($offset)
    {
        $offset = (int)$offset;

        if ($offset < 0)
        {
            $offset = 0;
        }

        $this->updateQueryArgs(['offset' => $offset]);
    }

    // Pass null to use default. Pass -1 for no limit.
    public function setLength($length)
    {
        if ($length === null)
        {
            $length = $this->getDefaultLength();
        }
        else
        {
            $length = (int)$length;

            if ($length < 0)
            {
                $length = -1;
            }
        }
        
        $this->updateQueryArgs(['posts_per_page' => $length]);
    }

    // Alias for setLength().
    public function setPostsPerPage($length)
    {
        $this->setLimit($length);
    }

    private function getDefaultLength()
    {
        $length = (int)get_option('posts_per_page');

        if ($length <= 0)
        {
            return self::DEFAULT_PER_PAGE;
        }

        return $length;
    }

    public function setOrderBy($orderby)
    {
        if (is_string($orderby))
        {
            $this->updateQueryArgs(['orderby' => $orderby]);
        }
        else
        {
            $this->deleteQueryArg('orderby');
        }
    }

    public function setOrder($order)
    {
        if (is_string($order))
        {
            $this->updateQueryArgs(['order' => $order]);
        }
        else
        {
            $this->deleteQueryArg('order');
        }
    }

    private function populate()
    {
        if ($this->populated)
        {
            return;
        }

        $wp_query = new WP_Query($this->queryArgs);
        $wp_posts = $wp_query->get_posts();
        $post_class = $this->postClass;
        $this->posts = $post_class::fromWpPosts($wp_posts);
        $this->totalPostCount = (int)$wp_query->found_posts;
        $this->populated = true;
    }

    public function getPosts()
    {
        if (!$this->populated)
        {
            $this->populate();
        }

        return $this->posts;
    }

    public function isPopulated()
    {
        return $this->populated;
    }

    public function isEmpty()
    {
        return empty($this->posts);
    }

    public function count()
    {
        $posts = $this->getPosts();
        return count($posts);
    }

    public function forEachPost($fn)
    {
        foreach ($this->getPosts() as $post)
        {
            $fn($post);
        }
    }   
}
