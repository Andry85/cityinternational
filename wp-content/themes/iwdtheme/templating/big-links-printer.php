<?php

namespace IllicitWeb;

class BigLinksPrinter extends SectionPrinter
{
	public function __construct($fields)
	{
		parent::__construct($fields);
	}

	public function printHtml()
	{
		$biglinks = $this->get_field('big_links');

		if (!$biglinks) 
		{
			return;
		}

		$title = $this->get_field('big_links_title');
		$heading = $this->get_field('big_links_heading');

		?>
		<div class="content-block big-links">
			<div class="content-block-inner">

				<header>
					<div>
						<?php if ($title): ?>
							<h4><?= $title ?></h4>
						<?php endif ?>

						<?php if ($heading): ?>
							<h2><?= $heading ?></h2>
						<?php endif ?>
					</div>
				</header>

				<ul>
					<?php 
					$img_pos = 'right';
					foreach ($biglinks as $biglink)
					{
						$img_pos = ($img_pos == 'left') ? 'right' : 'left';
						$this->printBigLink($biglink, $img_pos);
					}

					?>
				</ul>
			</div>
		</div>
		<?php
	}

	private function printBigLink(array $biglink, $img_pos)
	{
		if (empty($biglink['page']))
		{
			return;
		}

		$post = new Post($biglink['page']);
		$url = $post->link();
		$image = $post->image();
		$image_url = $image ? $image['sizes']['large'] : null;
		$title = $post->title();
		$text = $biglink['text'];

		?>
		<li class="big-link<?php if ($img_pos == 'right') echo ' is-right'; ?>">
			<div class="big-link-bgd"<?php if ($image_url) echo ' style="background-image:url(\'' . $image_url . '\');"' ?>></div>
			<div>
				<div class="big-link-text">
					<h4><?= $title ?></h4>
					<h3><?= $text ?></h3>
					<a class="button outline" href="<?= $url ?>">Read More</a>
				</div>
			</div>
		</li>
		<?php
	}
}
