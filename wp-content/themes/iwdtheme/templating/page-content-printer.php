<?php
namespace IllicitWeb;

class PageContentPrinter extends SectionPrinter
{
	public function __construct($section_id=null)
	{
		global $post;

		if (empty($post))
		{
			return;
		}

		$this->post = new Post($post);
		$this->sectionId = $section_id;
		$this->headerHtml = $this->buildHeaderHtml();
		$this->bodyHtml = $this->buildBodyHtml();

		$this->classes = ['content-block', 'page-content'];

		if (!$this->headerHtml)
		{
			$this->classes[] = 'no-header';
		}

		if (!$this->bodyHtml)
		{
			$this->classes[] = 'no-body';
		}

		if (get_field('wide_main_post'))
		{
			$this->classes[] = 'wide-page-content';
		}
	}

	private $post = null;
	private $sectionId;
	private $headerHtml;
	private $bodyHtml;

	protected $classes;

	public function printHtml()
	{
		if (!$this->post || (!$this->bodyHtml && !$this->headerHtml))
		{
			return;
		}

		$class = implode(' ', $this->classes);

		?>
		<section class="<?= $class ?>"<?php 
			if ($this->sectionId): ?> id="<?= $this->sectionId ?>"<?php endif ?>>
			<?= $this->headerHtml ?>
			<?= $this->bodyHtml ?>
		</section>
		<?php
	}

	private function buildHeaderHtml()
	{
		if ($this->post->acf('hide_main_post_title'))
		{
			return '';
		}

		ob_start();

		?>
		<header class="content-block-inner page-content-header">
			<h1><?= $this->post->title() ?></h1>
		</header>
		<?php

		return ob_get_clean();
	}

	private function buildBodyHtml()
	{
		if ($this->post->acf('hide_main_post_content'))
		{
			return '';
		}

		$content = trim($this->post->content());

		if (!$content)
		{
			return '';
		}

		ob_start();

		?>
		<div class="content-block-inner page-content-main">
			<?= $content ?>
		</div>
		<?php

		return ob_get_clean();
	}
}
