<?php
namespace IllicitWeb;

class FeaturedProductsPrinter extends SectionPrinter
{
    private $posts; // Post[]

    private $heading = 'Featured Products';

    private $maxItemsOnMobile = 3;

    public function __construct()
    {
        $this->posts = Post::fromQueryArgs([
            'post_type' => WC_PRODUCT,
			'post_status' => 'publish',
			'meta_key' => '_featured',
			'meta_value' => 'yes',
			'posts_per_page' => -1,
        ]);
    }

    public function printHtml()
    {
        if (!$this->posts)
        {
            return;
        }

        $count = 0;

        ?>
		<div class="content-block product-carousel">
			<?php if ($this->heading): ?>
			<header class="content-block-inner">
				<h2><?= $this->heading ?></h2>
			</header>
			<?php endif ?>

			<div class="content-block-inner" data-cbelt="ctx">
				<span class="product-carousel-prev" data-cbelt="prev"></span>
				<span class="product-carousel-next" data-cbelt="next"></span>
				<div class="product-carousel-outer">
					<div class="product-carousel-middle" data-cbelt="scroller">
						<ul class="product-thumbs product-carousel-inner"><?php

							foreach ($this->posts as $post):

								$this->printProductPost($post, $count);
								++$count;

							endforeach;

						 ?></ul>
					</div>
				</div>
			</div>
		</div>
		<?php
    }

    private function printProductPost(Post $post, $count)
	{
		$class= $this->getProductPostItemCssClass($count);
        $image = $post->image();
		$url = $post->link();

		?><li class="<?= $class ?>">
			<?php if ($image): ?>
			<div class="wc-thumb-item-bgd" style="background-image:url('<?=
				$image['url'] ?>');"></div>
			<?php endif ?>

            <a class="wc-thumb-item-link" href="<?= $url ?>">
                <div class="wc-thumb-item-link-text">
                    <div class="wc-thumb-item-link-name">
                        <?= $post->title() ?>
                    </div>
                </div>
            </a>
		</li><?php
	}

    private function getProductPostItemCssClass($count)
    {
        $class = 'product-carousel-item';

		if ($this->maxItemsOnMobile >= 0 &&
				$count >= $this->maxItemsOnMobile)
		{
			$class .= ' mobile-hide';
		}

        return $class;
    }
}
