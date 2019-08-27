<?php
namespace IllicitWeb;

function cart_url()
{
    return get_permalink(woocommerce_get_page_id('cart'));
}

function shop_url()
{
    return get_permalink(woocommerce_get_page_id('shop'));
}

function get_product_cat_image($term_id, $default_image=null)
{
	$image_id = get_woocommerce_term_meta($term_id, 'thumbnail_id', true);

	if (!$image_id)
	{
		return $default_image;
	}

	$image = get_img($image_id);

	return $image ? $image : $default_image;
}

function resolve_product_cat_arg($product_cat)
{
	if (!$product_cat)
	{
		return null;
	}

	if ($product_cat instanceof ProductCategory)
	{
		return $product_cat;
	}

	if (is_string($product_cat))
	{
		return ProductCategory::fromSlug($product_cat, WC_PRODUCT_CAT);
	}

	if (is_int($product_cat))
	{
		return ProductCategory::fromId($product_cat, WC_PRODUCT_CAT);
	}

	return null;
}
