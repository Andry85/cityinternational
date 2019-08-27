<?php
/**
 * Usage
 * ====================================
 *
 * To have multiple columns, use the layout attribute on the content_block
 * shortcode.
 * 
 * If using multiple columns, there should be exactly 2 container
 * elements nested directly in the shortcode text value, since these will be
 * treated as the column containers.
 *
 * 
 * Layout
 * ====================================
 *
 * w => One full-width column (default)
 *
 * ww => Two equal-width columns
 *
 * nw => Narrow left col, wide right col
 *
 * wn => Wide left col, narrow right col
 * 
 */

namespace IllicitWeb;

add_shortcode('content_block', function ($attr=null, $text=null) {
	if (!$text)
	{
		return '';
	}

	$layout = empty($attr['layout']) ? 'w' : strtolower(trim($attr['layout']));

    ob_start();

    ?>
    <div class="content-block-shortcode layout-<?= $layout ?>">
    	<?= do_shortcode($text) ?>
    </div>
    <?php

    return ob_get_clean();
});
