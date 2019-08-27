<?php

namespace IllicitWeb;

class TeamPrinter extends SectionPrinter
{
	public function __construct($fields)
	{
		parent::__construct($fields);
	}

	public function printHtml()
	{
		$rows = $this->get_field('team_fields');
	?>

		<section class="content-block team">
			<div class="content-block-inner content-anim">
				<?php foreach ($rows as $row): ?>
					<div>
						<div class="title" style="background-image: url('<?= $row['team_fields_photo']['sizes']['large'] ?>')"></div>
						<div class="description">
							<h2><?= $row['team_fields_name'] ?></h2>
							<h3><?= $row['team_fields_role'] ?></h3>

							<?= $row['team_fields_bio'] ?>

							<?php if (!empty($row['team_fields_extra_bio'])): ?>
								<a href="#" class="open-extra-bio">Read more</a>
								<div style="display: none; margin-top: 20px;">
									<?= $row['team_fields_extra_bio'] ?>
								</div>								
							<?php endif ?>

						</div>
					</div>
				<?php endforeach ?>
			</div>
		</section>

	<?php
	}
}