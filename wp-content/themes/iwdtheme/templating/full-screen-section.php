<?php

namespace IllicitWeb;

class FullScreenSection extends SectionPrinter
{
	public function __construct($fields)
	{
		parent::__construct($fields);
	}

	public function printHtml()
	{
		$title = $this->get_field('full_screen_section_title');
		$animate = !empty($this->get_field('full_screen_section_animate'));
	?>

		<section class="content-block full-screen-section">
			<div class="content-block-inner<?php if ($animate) echo ' section-content-anim'; ?>">
				<div class="section-content">

					<?php if (!empty($title)): ?>
						<h2><?= $title ?></h2>
						<hr>
					<?php endif ?>
					
					<?= $this->get_field('full_screen_section_content') ?>
				</div>
			</div>
		</section>

	<?php
	}
}