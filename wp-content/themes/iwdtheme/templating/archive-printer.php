<?php
namespace IllicitWeb;

use Exception;

class ArchivePrinter extends Printer
{
	public function printHtml()
	{
		get_header();

		?>
		<section class="content-block blog archive" role="main">
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
				<?php
					if ( is_day() ) { printf( __( 'Daily Archives: %s', 'illicitwebdesign' ), get_the_time( get_option( 'date_format' ) ) ); }
					elseif ( is_month() ) { printf( __( 'Monthly Archives: %s', 'illicitwebdesign' ), get_the_time( 'F Y' ) ); }
					elseif ( is_year() ) { printf( __( 'Yearly Archives: %s', 'illicitwebdesign' ), get_the_time( 'Y' ) ); }
					else { _e( 'Archives', 'illicitwebdesign' ); }
				?>
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
