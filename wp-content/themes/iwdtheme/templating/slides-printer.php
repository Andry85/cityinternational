<?php

// Note: for a usage example, see Photographic Angle
// http://pangle.illicitwebdesign.co.uk/gallery/wildlife-of-the-world/

namespace IllicitWeb;

use Exception;
use WP_Post;

class SlidesPrinter extends Printer
{
	public function __construct()
	{
		if (!get_field('display_slides'))
		{
			return;
		}

		$this->slides = get_field('slides');
	}

	private $slides = null;

	public function printHtml()
	{
		if (!$this->slides)
		{
			return;
		}

		$width = (count($this->slides) * 100).'%';

		?>
		<section class="content-block slides">
			<div class="content-block-inner">
				<div class="slides-wrap">
					<div style="width: <?= $width ?>; ">
						<?php 

						foreach ($this->slides as $slide)
						{
							$this->printSlide($slide);
						}

						?>
					</div>
				</div>
				<div data-slide-nav="prev"></div>
				<div data-slide-nav="next"></div>
			</div>
		</section>
		<?php
	}

	private function printSlide(array $slide)
	{
		$wp_post = $slide['slide_post'];

		if (!($wp_post instanceof WP_Post))
		{
			return;
		}

		$post = new Post($wp_post);

		$image = $post->acf('slide_bgd_image');

		?>
		<div class="slide"<?php 
			if ($image): 
				?> style="background-image: url('<?= $image['url'] ?>'); "<?php 
			endif ?>>
			<div class="slide-overlay"></div>
			<div class="slide-content">
				<header class="slide-header">
					<h2><?= $post->title() ?></h2>
				</header>
				<div class="slide-content">
					<div><?= $post->content() ?></div>
				</div>
			</div>
		</div>
		<?php
	}
}
