<?php

namespace IllicitWeb;

class MonthlyArchivePrinter extends SectionPrinter
{
	const LIMIT = 10;

	public function printHtml()
	{
		$limit = self::LIMIT;

		?>
		<div class="content-block monthly-archive">
			<div class="content-block-inner">
				<h2>Blog Archive</h2>
				<div class="archive-limited">
					<ul class="top-level-archive-list">
						<?php

						wp_get_archives(array(
							'type' => 'monthly',
							'limit' => $limit,
						));

						?>
					</ul>
					<p class="archive-show-all" style="display: none;">
						<span data-action="show">Show all</span>
					</p>
				</div>
				<div class="archive-all" style="display: none;">
					<p>
						<span data-action="hide">Show recent</span>
					</p>
					<ul class="top-level-archive-list">
						<?php

						wp_get_archives(array(
							'type' => 'monthly',
						));

						?>
					</ul>
					<p>
						<span data-action="hide">Show recent</span>
					</p>
				</div>
			</div>
		</div>
		<?php
	}
}
