<?php

namespace IllicitWeb;

class AreasOfLawPrinter extends SectionPrinter
{
	public function __construct($fields)
	{
		parent::__construct($fields);
	}

	public function printHtml()
	{
		$rows = $this->get_field('areas_of_law');
	?>

		<section class="content-block areas-of-law">
			<div class="content-block-inner content-anim">
				<h4>Areas of law</h4>
				<?php foreach ($rows as $row): ?>
					<div>
						<div class="title">
							<h2><?= $row['areas_of_law_title'] ?></h2>
						</div>
						<div class="description">
							<?= $row['areas_of_law_description'] ?>
						</div>
					</div>
				<?php endforeach ?>
			</div>
		</section>

	<?php
	}
}