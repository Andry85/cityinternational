<?php

namespace IllicitWeb;

use Exception;

use WP_Post;

class PageBannerPrinter extends SectionPrinter
{
	protected $bannerPrinter = null;

	protected $containerId;

	public function __construct($acf_field, $container_id)
	{
		$page = Post::fromCurrent();

		if (!$page)
		{
			return;
		}

		$wp_post = $page->acf($acf_field);

		if (!($wp_post instanceof WP_Post))
		{
			return;
		}

		$banner = new Banner($wp_post);

		$this->bannerPrinter = new BannerPrinter($banner);

		$this->containerId = $container_id;
	}

	public function printHtml()
	{
		if (!$this->bannerPrinter)
		{
			return;
		}

		$this->printOpen();
			
		echo $this->bannerPrinter;

		$this->printClose();
	}

	protected function printOpen()
	{
		?>
		<div class="content-block banner" id="<?= $this->containerId ?>">
		<?php
	}

	protected function printClose()
	{
		?>
		</div>
		<?php
	}
}
