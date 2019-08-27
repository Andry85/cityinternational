<?php
namespace IllicitWeb;

if (!defined('IW_WOOCOMMERCE') || !IW_WOOCOMMERCE)
{
    return;
}

// Helpers
include THEME_DIR.'helpers/woocommerce.php';

// Classes
include THEME_DIR.'models/wc/product.php';
include THEME_DIR.'models/wc/product-cat.php';
include THEME_DIR.'models/wc/main-display-product-cats.php';
include THEME_DIR.'models/wc/main-display-products.php';

// Setup
include THEME_DIR.'setup/acf/group-registrations/wc/product-cat.php';
include THEME_DIR.'setup/acf/group-registrations/wc/product-order-item-meta.php';
include THEME_DIR.'setup/wc/hooks.php';

// Templating
include THEME_DIR.'templating/wc/main-display-product-cats.php';
include THEME_DIR.'templating/wc/main-display-products.php';
include THEME_DIR.'templating/wc/featured-products.php';
include THEME_DIR.'templating/wc/product-single.php';
include THEME_DIR.'templating/wc/product-cat-content.php';
include THEME_DIR.'templating/wc/related-products.php';
include THEME_DIR.'templating/wc/cross-sells.php';
