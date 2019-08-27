<?php
namespace IllicitWeb;

use Exception;

class SearchPrinter extends Printer
{
	public function printHtml()
	{
		get_header();

		?>
		<section class="content-block blog search" role="main">
			<?php 

			if (have_posts())
			{
				$this->printResultsHeader();
				$this->printEntries();
				$this->printFooter();
			}
			else
			{
				$this->printEmptyHeader();
			}

			?>
		</section>
		<?php

		echo new MonthlyArchivePrinter();

		get_footer();
	}

	public function printResultsHeader()
	{
		?>
		<header class="content-block-inner header">
			<h1>
				<?php 
					printf('Search Results for: %s', get_search_query());
				?>
			</h1>
		</header>
		<?php
	}

	public function printEmptyHeader()
	{
		?>
		<header class="content-block-inner header">
			<h1>Sorry, nothing matched your search.</h1>
			<div>
				<?php get_search_form() ?>
			</div>
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
