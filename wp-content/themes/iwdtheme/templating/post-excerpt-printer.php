<?php

namespace IllicitWeb;

use WP_Post;

class PostExcerptPrinter extends SectionPrinter
{
	private $post;
	private $url;
	private $title;
	private $date;
	private $excerpt;
	private $image;
	
	public function __construct(Post $post)
	{
		$this->post = $post;
		$this->url = $post->link();
		$this->title = $post->title();
		$this->date = $post->date(PRETTY_DATE_FORMAT);
		$this->excerpt = $post->excerpt();
		$this->image = $post->image(true);
	}
	
	public function printHtml()
	{
		$image_url = $this->image ? $this->image['sizes']['medium'] : null;

		?>
		<div class="post-excerpt-item">
			<div class="post-excerpt-image-col">
				<a class="post-excerpt-image"<?php
					if ($image_url): ?> style="background-image: url('<?= 
						$image_url ?>'); "<?php 
					endif ?> href="<?= $this->url ?>"></a>
			</div>
			
			<div class="post-excerpt-text-col">
				<h2><a href="<?= $this->url ?>"><?= $this->title ?></a></h2>

				<?php $this->printPostCategories() ?>
				
				<div class="post-excerpt-date"><?= $this->date ?></div>

				<div class="post-excerpt">
					<?= $this->excerpt ?>
					<a href="<?= $this->url ?>">Read More</a>
				</div>
			</div>
		</div>
		<?php
	}

	private function printPostCategories()
	{
		$cats = $this->getPostCategories();

		if (!$cats) 
		{
			return;
		}

		?>
		<ul class="post-categories">
			<?php foreach ($cats as $cat): ?>
			<li>
				<a href="<?= $cat->link() ?>"><?= $cat->name() ?></a>
			</li>
			<?php endforeach ?>
		</ul>
		<?php
	}

	// @return array of Term objects
	private function getPostCategories()
	{
		return $this->post->terms('category');
	}
}
