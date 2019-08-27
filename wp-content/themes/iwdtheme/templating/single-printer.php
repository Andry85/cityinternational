<?php

namespace IllicitWeb;

class SinglePrinter extends Printer
{
	public function __construct()
	{
		global $post;
		if (empty($post))
		{
			return;
		}

		$this->post = new Post($post);

		$this->image = $this->getImage();
	}

	private $post = null;
	private $image = null;

	private function getImage()
	{
		return $this->post->image();
	}

	public function printHtml()
	{
		if (!$this->post)
		{
			return;
		}

		get_header();

		$this->printOpen();
		$this->printInner();
		$this->printClose();

		get_footer();
	}

	private function printOpen()
	{
		?>
		<section class="content-block blog-single">
			<?php $this->printHeader() ?>
			<div class="content-block-inner">
		<?php
	}

	private function printInner()
	{
		$this->printImage();

		echo $this->post->content();

		$this->printFooter();

		echo new MonthlyArchivePrinter();
	}

	private function printHeader()
	{
		?>
		<header class="content-block-inner">
			<?php 
				$this->printTitle();
				$this->printDate();
			?>
		</header>
		<?php
	}

	private function printDate()
	{
		$date = $this->post->date(PRETTY_DATE_FORMAT);

		?>
		<h2 class="post-date"><?= $date ?></h2>
		<?php
	}

	private function printImage()
	{
		if (!$this->image)
		{
			return;
		}

		$alt = $this->image['alt'];
		$url = $this->image['url'];

		?>
		<div class="blog-single-image-wrap">
			<img alt="<?= $alt ?>" class="blog-single-image" src="<?= $url ?>" />
		</div>
		<?php
	}

	private function printClose()
	{
			?>
			</div>
		</section>
		<?php
	}

	private function printTitle()
	{
		?>
		<h1 class="post-title"><?= $this->post->title() ?></h1>
		<?php
	}

	private function printFooter()
	{
		?>
		<footer class="footer">
			<?php get_template_part('nav', 'below-single') ?>
		</footer>
		<?php
	}
}
