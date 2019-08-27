<?php
namespace IllicitWeb;

add_shortcode('latest_blog_post', function ($attr=null) {
    
    $post = Post::fromLatestOne();

    if (!$post)
    {
        return '';
    }
    
    ob_start();
    
    ?>
    <div class="latest-blog-post">
        <h3 class="post-title"><?= $post->title() ?></h3>
        <h4 class="post-date"><?= $post->date(TERSE_DATE_FORMAT) ?></h4>
        <div class="post-excerpt">
            <?= $post->excerpt() ?>
            <a href="<?= $post->link() ?>">Read More...</a>
        </div>        
    </div>
    <?php
    return ob_get_clean();
});
