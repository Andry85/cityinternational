<?php
namespace IllicitWeb;

use Exception;

class CategoryPrinter extends Printer
{
	public function printHtml()
	{
		get_header();

		?>
		<section class="content-block blog category" role="main">
			<?php 

			$this->printHeader();
			$this->printEntries();
			$this->printFooter();

			?>
		</section>
		<?php

		echo new MonthlyArchivePrinter();

		get_footer();
	}

	public function printHeader()
	{
		?>
		<header class="content-block-inner header">
			<h1>
				<?php single_cat_title() ?>
			</h1>
		</header>
		<?php
	}

	public function printEntries()
	{
		while (have_posts()):

			the_post();

			$post = Post::fromCurrent();

			if (!$post)
			{
				continue;
			}

			?>
			<div class="content-block-inner post-excerpt">
				<?= new PostExcerptPrinter($post) ?>
			</div>
			<?php

		endwhile;
	}

	public function printFooter()
	{
		?>
		<footer class="content-block-inner">
			<?php get_template_part('nav', 'below'); ?>
		</footer>
		<?php
	}
}
