<?php

namespace IllicitWeb;

use WP_Post;
use WP_Query;
use Exception;

class GalleryPrinter extends Printer
{
	const DEFAULT_SIZE = 'thumbnail';

	public function __construct(Gallery $gallery, $size=null)
	{
		$this->gallery = $gallery;
		$this->size = $size ? $size : static::DEFAULT_SIZE;
	}

	protected $gallery;
	protected $size;

	public function printHtml()
	{
		?>
		<div class="iw-gallery-thumbs iw-gallery-thumbs-<?= $this->gallery->id() ?>">
			<ul>
				<?php

				foreach ($this->gallery as $image)
				{
					$this->printItem($image);
				}

				?>
			</ul>
		</div>
		<?php
	}

	protected function printItem(array $image)
	{
		$caption = htmlspecialchars($image['caption']);
		$title = empty($image['title']) ? '' : htmlspecialchars($image['title']);
		$alt = htmlspecialchars($image['alt']);
		$url = $image['url'];
		$thumb_url = $image['sizes'][$this->size];
		
		?>
		<li>
			<a data-lightbox="iw-gallery-<?= $this->gallery->id()
				?>" data-caption="<?= $caption
				?>" data-title="<?= $title
				?>" data-url="<?= $url
				?>" href="<?= $url 
				?>">
				<img alt="<?= $alt ?>" src="<?= $thumb_url ?>">
			</a>
		</li>
		<?php
	}
}
