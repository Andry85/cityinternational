<?php
namespace IllicitWeb;

if (!defined('ABSPATH')) die;

get_header('shop');

/**
 * woocommerce_before_single_product hook
 *
 * @hooked wc_print_notices - 10
 */
do_action('woocommerce_before_single_product');

?>

<div class="product-single" role="main">
	<?= new ProductSinglePrinter() ?>
</div>

<div class="featured-products">
	<?= new FeaturedProductsPrinter() ?>
</div>

<?php

do_action('woocommerce_after_single_product');

get_footer('shop');
