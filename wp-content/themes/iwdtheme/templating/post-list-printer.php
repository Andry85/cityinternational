<?php
/**
 * PostListPrinter is a SectionPrinter for printing out a list of posts.
 * It's pretty-bare bones, so it is likely you will want to subclass 
 * PostListPrinter and override some of its protected templating methods.
 */

namespace IllicitWeb;

use Exception;

class PostListPrinter extends SectionPrinter
{
	protected $postList;
	protected $defaultPostImage;
	
	public function __construct(PostList $postlist)
	{
		$this->postList = $postlist;

		$postlist->populate();

		$this->defaultPostImage = get_field('default_post_image', 'option');
	}

	public function printHtml()
	{
		$this->printOpen();
		$this->printHeader();
		$this->printResults();
		$this->printPagination();
		$this->printClose();
	}

	protected function printOpen()
	{
		?>
		<section class="content-block post-list-section">
			<div class="content-block-inner">
			<?php
	}

	protected function printHeader()
	{
		?>
		<header>
			<h1>Posts</h1>
		</header>
		<?php
	}

	protected function printResults()
	{
		if ($this->postList->isEmpty())
		{
			$this->printEmptyMessage();
			return;
		}

		?>
		<div class="post-list-body">
			<ul class="post-list-ul">
				<?php

				$this->postList->forEachPost(function (Post $post) {
					$this->printPost($post);
				});

				?>
			</ul>
		</div>
		<?php
	}

	protected function printPost(Post $post)
	{
		echo new PostExcerptPrinter($post);
	}

	protected function printPagination()
	{
		$links = $this->postList->getPaginationLinks();

		if (count($links) < 2)
		{
			return;
		}

		?>
		<ul class="pagination">
			<?php foreach ($links as $link): ?>
			<li><?= $link ?></li>
			<?php endforeach ?>
		</ul>
		<?php
	}

	protected function getPostThumbnailUrl(Post $post)
	{
		$image = $post->image();

		if (!$image)
		{
			$image = $this->defaultPostImage;
		}

		return $image ? $image['url'] : null;
	}

	protected function printClose()
	{
			?>
			</div>
		</section>
		<?php
	}

	protected function printEmptyMessage()
	{
		?>
		<p class="post-list-empty">
			There are no results to display.
		</p>
		<?php
	}
}
