<?php

// Requires Illicit CyclingContent plugin.

namespace IllicitWeb;

class CyclingContentPrinter extends SectionPrinter
{
	public function printHtml()
	{
		if (!function_exists('IllicitWeb\\CyclingContent\\cycling_content'))
		{
			return;
		}

		if (!get_field('display_cycling_content')) 
		{
			return;
		}

		$heading = get_field('cycling_content_heading');

		?>
		<section class="content-block cycling-content">
			<div class="content-block-inner">
				<?php if ($heading): ?>
					<h2><?= $heading ?></h2>
				<?php endif ?>
				<?php \IllicitWeb\CyclingContent\cycling_content() ?>
			</div>
		</section>
		<?php
	}
}
