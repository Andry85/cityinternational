<?php

namespace IllicitWeb;

use WP_Post;
use WP_Query;
use Exception;

class SlideyGalleryPrinter extends GalleryPrinter
{
	const DEFAULT_SIZE = 'medium';

	public function printHtml()
	{
		$images = $this->gallery->images();

		if (!$images)
		{
			return;
		}

		?>
		<div class="iw-pretty-thumbs iw-pretty-thumbs-<?= $this->gallery->id() ?>">
			<div class="pg-outer">

				<?php $this->printNavBtns() ?>
			
				<div class="pg-middle">
					<ul class="pg-inner"><?php

						foreach ($images as $image)
						{
							$this->printItem($image);
						}

					?></ul>
					<div class="pg-big"></div>
				</div>
			</div>
		</div>
		<?php
	}

	private function printNavBtns()
	{
		?>
		<span class="pg-prev"></span>
		<span class="pg-next"></span>
		<?php
	}

	protected function printItem(array $image)
	{
		$image_url = $image['url'];
		
		if ($this->size === 'full')
		{
			$thumb_url = $image['url'];
		}
		else
		{
			$thumb_url = $image['sizes'][$this->size];
		}
		
		$alt = $image['alt'];
		$caption = $image['caption'];

		?><li class="pg-item"><img alt="<?=
			$alt ?>" src="<?=
			$thumb_url ?>" data-url="<?=
			$image_url ?>" data-caption="<?=
			$caption ?>"></li><?php
	}
}
