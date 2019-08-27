<?php
/**
 * Attrs:
 * =============================================================================
 *  - url
 *  - path (relative to iwdtheme/images dir)
 *  - id (media attachment id)
 *
 *  - width
 *  - height
 *
 * If no height value specified, img-div will be given a default value (which 
 * will probably be useless but at least make the img div visible).
 * 
 */

namespace IllicitWeb;

add_shortcode('img_div', function ($attr=null) {
    $url = null;

    if (isset($attr['url']))
    {
        $url = trim($attr['url']);
    }
    elseif (isset($attr['path']))
    {
        $url = IMAGES_URL.trim($attr['path']);
    }
    elseif (isset($attr['id']))
    {
        $img = get_img($attr['id']);

        if ($img)
        {
            $url = $img['url'];
        }
    }

    if (!$url)
    {
        return '';
    }

    $default_height = 100; // px

    $width = empty($attr['width']) ? null : (int)$attr['width'];
    $height = empty($attr['height']) ? $default_height : (int)$attr['height'];

    ob_start();

    ?>
    <div class="img-div<?php
        
        if ($width !== null) echo ' img-div-custom-width'; 

        ?>" style="background-image: url('<?= $url ?>'); <?php

        if ($width !== null)
        {
            echo 'width: '.$width.'px; ';
        }

        echo 'height: '.$height.'px; ';

    ?>"></div>
    <?php

    return ob_get_clean();
});
