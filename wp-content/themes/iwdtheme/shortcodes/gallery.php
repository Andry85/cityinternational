<?php

namespace IllicitWeb;

add_shortcode('iw_gallery', function ($attr=null) {
	if (empty($attr['id']))
	{
		return '';
	}

	$id = (int)$attr['id'];

    $gallery = Gallery::fromId($id);
    
    if (!$gallery)
    {
        return '';
    }

    $style = empty($attr['style']) ? null : strtolower(trim($attr['style']));

    switch ($style)
    {
        case 'slidey':
            $printer = new SlideyGalleryPrinter($gallery);
            break;

        default:
            $printer = new GalleryPrinter($gallery);
            break;
    }

    return $printer->getHtml();
});
