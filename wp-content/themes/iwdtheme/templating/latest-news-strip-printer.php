<?php

namespace IllicitWeb;

class LatestNewsStripPrinter extends Printer
{
	private $posts;

	public function __construct(LatestNewsStrip $model)
	{
		if (!get_field('display_latest_news_strip'))
		{
			return;
		}

		$model->populate();
		$this->posts = $model->toArray();
	}

	public function printHtml()
	{
		if ($this->noPosts())
		{
			return;
		}

		?>
		<div class="latest-news-strip content-block">
			<div class="content-block-inner">
				<?php 

				$is_first = true;

				foreach ($this->posts as $post)
				{
					if ($post)
					{
						$this->printPost($post, $is_first);
						$is_first = false;
					}
				}

				?>
			</div>
		</div>
		<?php
	}

	private function noPosts()
	{
		if (empty($this->posts))
		{
			return true;
		}

		foreach ($this->posts as $post)
		{
			if ($post)
			{
				return false;
			}
		}

		return true;
	}

	private function printPost(array $post, $is_first)
	{
		$classname = 'latest-news-strip-post type-'.$post['type'];

		?>
		<div class="<?= $classname ?>"<?php 
			if ($is_first): ?> style="z-index: 1; opacity: 1; "<?php endif ?>>
			<div>
				<h2>Latest News</h2>
				<div class="content">
					<?= $post['truncated'] ?>
					<?php if ($post['url']): ?>
					<a href="<?= $post['url'] ?>"<?php 
						if ($post['new_tab']): ?> target="_blank"<?php 
						endif ?>>Read More</a>
					<?php endif ?>
				</div>
			</div>
		</div>
		<?php
	}
}
