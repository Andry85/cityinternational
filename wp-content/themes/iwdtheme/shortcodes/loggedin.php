<?php

namespace IllicitWeb;

add_shortcode('loggedin', function ($attr=null, $content=null) {
    return (is_user_logged_in()) ? $content : '';
});

add_shortcode('notloggedin', function ($attr=null, $content=null) {
    return (!is_user_logged_in()) ? $content : '';
});
