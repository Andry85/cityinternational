<?php
namespace IllicitWeb;

add_shortcode('social_links', function ($attr=null) {
    ob_start();

    echo new SocialIconLinksPrinter();

    return ob_get_clean();
});
