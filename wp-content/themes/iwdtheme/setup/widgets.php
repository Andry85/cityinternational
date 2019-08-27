<?php

add_action('widgets_init', function () {
    
    // Widget IDs mapped to names.
    // (Comment in/out as desired.)
    $widgets = [
        // 'ga' => 'Google Analytics',
        // 'footer_left' => 'Footer Left',
        'footer_mid' => 'Footer Middle',
        // 'footer_right' => 'Footer Right',
    ];
    
    foreach ($widgets as $id => $name)
    {
        register_sidebar(array(
            'name' => $name,
            'id' => $id,
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '',
            'after_title' => '',
        ));
    }
});
