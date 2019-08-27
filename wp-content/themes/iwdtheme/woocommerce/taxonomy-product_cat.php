<?php
namespace IllicitWeb;

if (!defined('ABSPATH')) 
{
	exit;
}

get_header('shop');

?>

<div class="shop-main">
	<?= new MainDisplayProductsPrinter() ?>
</div>

<div class="featured-products">
	<?= new FeaturedProductsPrinter() ?>
</div>

<?php product_cat_content() ?>

<?php

get_footer('shop');
