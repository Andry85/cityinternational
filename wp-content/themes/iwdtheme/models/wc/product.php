<?php
namespace IllicitWeb;

use DateTime;
use DateInterval;
use Exception;

use WP_Post;
use WP_Query;
use WP_Term;

use WC_Product;
use WC_Product_Factory;
use WC_Product_Simple;
use WC_Product_Variable;
use WC_Product_Variation;

class Product extends Post
{
    protected $product;
    
    public function __construct(WP_Post $post)
    {
        parent::__construct($post);
        $this->setProduct($post);
    }
    
    protected function setProduct(WP_Post $post)
    {
        $factory = new WC_Product_Factory();
        $product = $factory->get_product($post->ID);
        
        if (!$product)
        {
            throw new Exception('Could not create WC_Product');
        }
        
        $this->product = $product;
    }
    
    public function product()
    {
        return $this->product;
    }
    
    public function variations()
    {
        return $this->product->get_available_variations();
    }

    // @return {bool} whether product is variable product
    public function isVariable()
    {
        return $this->product->is_type('variable');
    }

    // @return {bool}
    public function isVisible()
    {
        return $this->product->is_visible();
    }
    
    // @return {string} Cart item ID for newly added item
    public function addToCart($qty, $variation_id=0)
    {
        global $woocommerce;
        
        $cart = $woocommerce->cart;

        $qty = (int)$qty;

        $variation_id = (int)$variation_id;
        
        return $cart->add_to_cart($this->id, $qty, $variation_id);
    }
    

    public function getCrossSells($limit=null)
    {
        $ids = $this->product->get_cross_sells();

        if ($limit !== null && $limit > 0)
        {
            $ids = array_slice($ids, 0, $limit);
        }

        return static::fromIds($ids);
    }

    public function getRelatedProducts($limit=5)
    {
        $ids = $this->product->get_related();

        return static::fromIds($ids);
    }
    
    public function galleryImages($fallback=null)
    {
        $ids = $this->product->get_gallery_attachment_ids();
        
        if (!$ids)
        {
            return [];
        }
    
        $images = [];
    
        foreach ($ids as $id)
        {
            $image = $this->getImageById($id, $fallback);
            if ($image)
            {
                $images[] = $image;
            }
        }

        return $images;
    }
    
    public function inCart()
    {
        global $woocommerce;
        if (empty($woocommerce))
        {
            trigger_error('No $woocommerce global', E_USER_WARNING);
            return false;
        }

        foreach ($woocommerce->cart->cart_contents as $cart_item)
        {
            if ($cart_item['product_id'] == $this->id)
            {
                return true;
            }
        }

        return false;
    }

    // @return {double} Unit price (in native currency)
    public function unitPrice()
    {
        return $this->product->get_price();
    }

    // @return {string} HTML fragment
    public function priceHtml()
    {
        return $this->product->get_price_html();
    }

    // @return {bool}
    public function featured()
    {
        return $this->product->is_featured();
    }

    public function type()
    {
        return $this->product->product_type;
    }

    // @return {string}
    public function sku()
    {
        return $this->product->get_sku();
    }
    
    // @return {int}
    public function displayOrder()
    {
        return (int)$this->acf('order_of_display_on_main');
    }
    
    // @return {bool}
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

    // Returns array of ProductCategory
    public function productCategories($args=null)
    {
        return ProductCategory::fromWpTerms(
            $this->wpTerms(WC_PRODUCT_CAT, $args)
        );
    }

    public function belongsToCategoryName($category_name)
    {
        $category = ProductCategory::fromName($category_name, WC_PRODUCT_CAT);

        if (!$category)
        {
            return false;
        }

        return $this->belongsToCategoryId($category->id());
    }

    public function belongsToCategorySlug($category_slug)
    {
        $category = ProductCategory::fromSlug($category_slug, WC_PRODUCT_CAT);

        if (!$category)
        {
            return false;
        }

        return $this->belongsToCategoryId($category->id());
    }

    public function belongsToCategoryId($category_id)
    {
        foreach ($this->productCategories() as $category)
        {
            if ($category->id() == $category_id)
            {
                return true;
            }
        }

        return false;
    }

    public function belongsToCategory(ProductCategory $category)
    {
        return $this->belongsToCategoryId($category->id());
    }

    // @return array of meta field arrays
    public function getOrderItemMetaFields()
    {
        $rows = $this->acf('product_order_item_meta_fields');

        if (!$rows)
        {
            return [];
        }

        $fields = [];

        foreach ($rows as $row)
        {
            $key = snake_case($row['meta_name']);
            
            $fields[$key] = $row;

            if (!$row['heading'])
            {
                $fields[$key]['heading'] = $row['meta_name'];
            }
        }

        return $fields;
    }
}
