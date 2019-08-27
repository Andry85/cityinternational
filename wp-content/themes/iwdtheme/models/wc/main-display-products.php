<?php
namespace IllicitWeb;

class MainDisplayProducts
{
    private $productCat; // ProductCategory|null
    private $products; // Array of Product

    // $fallback is a product category (or id, or slug) which is used in the
    // case where $product_cat is set to null AND there is no current product
    // cat. Both args can be null, slug, id or ProductCategory instance.
    public function __construct($product_cat=null, $fallback=null)
    {
        $this->setCurrentProductCategory($product_cat, $fallback);
        
        $this->populateProductsArray();
    }

    // $fn must accept 1 Product instance
    public function forEachProduct($fn)
    {
        foreach ($this->products as $product)
        {
            $fn($product);
        }
    }

    public function isEmpty()
    {
        return count($this->products) === 0;
    }

    public function getProductCategoryName()
    {
        if ($this->productCat)
        {
            return $this->productCat->name();
        }
        
        return '';
    }

    private function setCurrentProductCategory($product_cat, $fallback)
    {
        if ($product_cat)
        {
            $this->productCat = resolve_product_cat_arg($product_cat);
        }
        else
        {
            $this->productCat = ProductCategory::fromCurrent();
           
            if (!$this->productCat)
            {
                $this->productCat = resolve_product_cat_arg($fallback);
            }
        }
    }

    private function populateProductsArray()
    {
        $query_args = [
            'posts_per_page' => -1,
            'post_type' => WC_PRODUCT,
            'post_status' => 'publish',
        ];

        if ($this->productCat)
        {
            $query_args['tax_query'] = [
                [
                    'taxonomy' => WC_PRODUCT_CAT,
                    'field' => 'slug',
                    'terms' => [$this->productCat->slug()],
                ],
            ];
        }

        $this->products = Product::fromQueryArgs($query_args);
    }
}
