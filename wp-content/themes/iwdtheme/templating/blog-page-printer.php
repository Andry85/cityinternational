<?php

namespace IllicitWeb;

use Exception;

class BlogPagePrinter extends Printer
{
	protected $posts;
	protected $post = null;
	protected $hasPostContent = false;
	protected $olderPostsUrl;
	protected $newerPostsUrl;
	
	public function __construct()
	{
		global $post;

		$list = $this->createPostList();
		$this->posts = $list->getPosts();
		$pag_data = $list->getPaginationData();
		$this->olderPostsUrl = $list->getNextPageUrl();
		$this->newerPostsUrl = $list->getPreviousPageUrl();

		if (!empty($post))
		{
			$this->post = new Post($post);
			$this->hasPostContent = !empty($post->post_content);
		}
	}

	private function createPostList()
	{
		$list = new PostList();
		$list->setOrderBy('date');
		$list->setOrder('DESC');
		$list->setPostType('post');
		$list->populate();

		assert($list->isPopulated(), "Expected populated list");
		return $list;
	}

	private function forEachPost($fn)
	{
		foreach ($this->posts as $post)
		{
			$fn($post);
		}
	}

	public function printHtml()
	{
		get_header();

		echo new TopBannerPrinter();

		echo new NormalPageContentPrinter();

		?>
		<section class="content-block blog" role="main">
			<?php $this->forEachPost(function (Post $post) { ?>
			<div class="content-block-inner post-excerpt">
				<?= new PostExcerptPrinter($post) ?>
			</div>
			<?php }) ?>
		</section>
		<?php

		$this->printFooter();

		echo new MonthlyArchivePrinter();

		$this->printExtraSection();

		get_footer();
	}

	private function printExtraSection()
	{
		$html = $this->post->acfTrim('news_archive_page_extra_content');

		if (!$html)
		{
			return;
		}

		?>
		<section class="content-block news-extra-section">
			<div class="content-block-inner">
				<?= $html ?>
			</div>
		</section>
		<?php
	}

	private function printFooter()
	{
		$prev_url = $this->newerPostsUrl;
		$next_url = $this->olderPostsUrl;

		?>
		<footer class="content-block blog-page-footer">
			<nav id="nav-below" class="content-block-inner navigation" role="navigation">
				<?php if ($next_url): ?>
				<div class="nav-next">
					<a href="<?= $next_url ?>"><span class="meta-nav">&larr;</span> older</a>
				</div>
				<?php endif ?>
				<?php if ($prev_url): ?>
				<div class="nav-previous">
					<a href="<?= $prev_url ?>">newer <span class="meta-nav">&rarr;</span></a>
				</div>
				<?php endif ?>
			</nav>
		</footer>
		<?php
	}
}
