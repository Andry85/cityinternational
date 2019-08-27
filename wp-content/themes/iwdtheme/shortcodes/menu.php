<?php
namespace IllicitWeb;

function get_nav_html($location)
{
    $location = strtolower(trim($location));
    
    if (!$location)
    {
        return;
    }
    
    ob_start();
    
    wp_nav_menu(array('theme_location' => $location));
    
    return ob_get_clean();
}

add_shortcode('nav', function ($attr=null) {
    if (empty($attr['location']))
    {
        return;
    }
    
    get_nav_html($attr['location']);
});


add_shortcode('footer_nav', function ($attr=null) {
    return '<div><nav id="footer-menu">'.
            get_nav_html('secondary-menu').
            '</nav></div>';
});
