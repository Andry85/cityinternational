<?php
namespace IllicitWeb;

use DateTime;
use DateInterval;
use Exception;

use WP_Post;
use WP_Query;
use WP_Term;

class ProductCategory extends Term
{
    public function displayOrder()
    {
        return (int)$this->acf('order_of_display_on_main');
    }

    public function shouldDisplay()
    {
        return (bool)$this->acf('product_cat_display_on_main');
    }

    public function thumbnail($fallback=null)
    {
        $thumbnail_id = $this->thumbnailId();

        if ($thumbnail_id)
        {
            return $this->getImageById($thumbnail_id, $fallback);
        }

        return null;
    }

    public function thumbnailId()
    {
        return get_woocommerce_term_meta($this->id, 'thumbnail_id', true);
    }

    static public function all($args=null)
    {
        return static::fromTaxonomies(WC_PRODUCT_CAT, $args);
    }
}
