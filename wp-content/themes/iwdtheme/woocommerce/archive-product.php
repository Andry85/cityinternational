<?php
namespace IllicitWeb;

if (!defined('ABSPATH')) die;

get_header();

echo new TopBannerPrinter();

?>

<div class="shop-main">
	<?= new MainDisplayProductCatsPrinter() ?>
</div>

<div class="featured-products">
	<?= new FeaturedProductsPrinter() ?>
</div>

<?php product_cat_content() ?>

<?php

get_footer();
