<?php
namespace IllicitWeb;

add_shortcode('button', function ($attr=null, $text=null) {
    $text = empty($attr['text']) ? $text : $attr['text'];
    
    if (empty($attr['url']) || !$text)
    {
        return '';
    }

    $url = trim($attr['url']);
    $text = trim($text);

    if (!$url || !$text)
    {
        return;
    }

    $style = !empty($attr['class']) ? ' ' . $attr['class'] : '';

    $target = empty($attr['target']) ? null : trim($attr['target']);

    ob_start();

    $is_block = isset($attr['block']);

    if ($is_block): ?><span class="button-block-wrap"><?php endif;

    ?>
    <a class="button<?= $style ?>" <?php 
        if ($target): ?>target="<?= $target ?>" <?php 
        endif ?>href="<?= htmlspecialchars($url) ?>"><?=
        htmlspecialchars($text) ?></a>
    <?php

    if ($is_block): ?></span><?php endif;

    return ob_get_clean();
});
