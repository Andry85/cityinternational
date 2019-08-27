<?php

namespace IllicitWeb;

add_shortcode('img', function ($attr=null) {
    if (empty($attr['id']))
    {
        return '';
    }

    $img = get_img($attr['id']);

    if (!$img)
    {
        return '';
    }

    $classes = [];

    if (!empty($attr['fullwidth']) && (strtolower($attr['fullwidth']) === 'true'))
    {
        $classes[] = 'img-full-width';
    }

    $class = implode(' ', $classes);

    $href = empty($attr['href']) ? null : htmlspecialchars(trim($attr['href']));

    ob_start();

    if ($href):

    ?>
    <a class="img-link" href="<?= $href ?>" target="_blank">
    <?php

    endif;

    ?>
    <img alt="<?= $img['alt'] ?>" <?php
        if ($class): 
            ?>class="<?= $class ?>" <?php 
        endif ?>src="<?= $img['url'] ?>" />
    <?php

    if ($href):

    ?>
    </a>
    <?php

    endif;

    return ob_get_clean();
});
