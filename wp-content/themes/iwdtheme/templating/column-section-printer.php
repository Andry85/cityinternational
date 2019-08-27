<?php

namespace IllicitWeb;

class ColumnSectionPrinter extends SectionPrinter
{
	public function __construct($fields)
	{
		parent::__construct($fields);
	}

	public function printHtml()
	{
		$bgd_image = $this->get_field('two_columns_background_image');
		$bgd_align = $this->get_field('two_columns_background_alignment');
		$title = $this->get_field('two_columns_title');
		$strapline = $this->get_field('two_columns_strapline');
		$content = $this->get_field('two_columns_content');
		$is_content_overlay = $this->get_field('two_columns_is_overlay');
	?>

		<section class="content-block column-section">
			<div class="content-block-inner align-<?= $bgd_align ?><?php if (!empty($is_content_overlay)) echo ' is-content-overlay'; ?> content-anim">
				<div class="column-content">
					<div>
						<?php if (!empty($title)): ?>
							<h4><?= $title ?></h4>
						<?php endif ?>
						
						<?php if (!empty($strapline)): ?>
							<h2><?= $strapline ?></h2>
						<?php endif ?>

						<?= $content ?>
					</div>
				</div>
				<div class="column-image">
					<?php if (!empty($bgd_image['sizes'])): ?>
						<div class="image" style="background-image: url('<?= $bgd_image['sizes']['large'] ?>')"></div>
					<?php endif ?>
				</div>
			</div>
		</section>

	<?php
	}
}