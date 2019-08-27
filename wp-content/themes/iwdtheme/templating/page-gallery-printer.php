<?php

namespace IllicitWeb;

class PageGalleryPrinter extends SectionPrinter
{
	private $printer = null;
	private $heading;

	public function __construct()
	{
		if (!get_field('display_page_gallery'))
		{
			return;
		}

		$gallery_post = get_field('page_gallery');

		if (!$gallery_post) 
		{
			return;
		}
		
		$gallery = new Gallery($gallery_post);

		if ($gallery->isEmpty())
		{
			return;
		}

		$this->printer = new SlideyGalleryPrinter($gallery);

		$this->heading = get_field('page_gallery_heading');
	}

	public function printHtml()
	{
		if (!$this->printer)
		{
			return;
		}

		?>
		<div class="content-block page-gallery">
			<div class="content-block-inner">
				<?php if ($this->heading): ?>
				<h2><?= $this->heading ?></h2>
				<?php endif ?>

				<div><?= $this->printer ?></div>
			</div>
		</div>
		<?php
	}
}
