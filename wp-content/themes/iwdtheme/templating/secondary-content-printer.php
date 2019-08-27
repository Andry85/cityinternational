<?php
namespace IllicitWeb;

class SecondaryContentPrinter extends SectionPrinter
{
	private $sections = null;

	public function __construct()
	{
		if (!get_field('display_secondary_content'))
		{
			return;
		}

		$sections = get_field('secondary_content');

		if ($sections)
		{
			$this->sections = $sections;
		}
	}

	public function printHtml()
	{
		if (!$this->sections)
		{
			return '';
		}

		?>
		<section class="content-block secondary-content">
			<?php

			foreach ($this->sections as $section)
			{
				$this->printSection($section);
			}

			?>
		</section>
		<?php
	}

	private function printSection($section)
	{

		$cols = $this->getSectionColumns($section);

		if (!$cols)
		{
			return;
		}

		$id = (empty($section['content_row_id'])) ? null : trim($section['content_row_id']);

		$class = $this->buildRowCssClass($section, $cols);

		?>
		<div class="<?= $class ?>"<?php

			if ($id): ?> id="<?= $id ?>"<?php endif;

			?>>
			<div>
				<?php

				foreach ($section['columns'] as $col)
				{
					$this->printColumn($col);
				}

				?>
			</div>
		</div>
		<?php
	}

	private function getSectionColumns($section)
	{
		return array_filter($section['columns'], function ($col) {
			return !empty($col['display_this_column']);
		});
	}

	private function buildRowCssClass($section, $cols)
	{
		$class = 'content-block-inner secondary-content-section ';

		if (count($cols) > 1)
		{
			$class .= 'double-col';
		}
		else
		{
			$class .= 'single-col';
		}

		if (!empty($section['content_row_bgd']))
		{
			$class .= ' '.$section['content_row_bgd'].'-bgd';
		}

		if (!empty($section['horiz_reverse']))
		{
			$class .= ' horiz-reverse';
		}

		return $class;
	}

	private function printColumn($col)
	{
		if ($col['text_or_image'] === 'text')
		{
			$this->printTextColumn($col);
		}
		else
		{
			$this->printImageColumn($col);
		}
	}

	private function printTextColumn($col)
	{
		$heading = empty($col['heading']) ? null : trim($col['heading']);
		$body_image = empty($col['body_image']) ? null : $col['body_image'];
		$body_text = empty($col['body_text']) ? null : trim(do_shortcode($col['body_text']));
		$animate = !empty($col['animate']);
		$center = !empty($col['center']);

		?>
		<div class="secondary-content-text-col<?php
			if ($animate) echo ' secondary-content-anim';
			if ($center) echo ' secondary-content-center';
			?>">

			<div>
				<?php if ($heading): ?>
				<h2><?= $heading ?></h2>
				<?php endif ?>

				<?php if ($body_image): ?>
				<div class="secondary-content-body-image">
					<div class="image" style="background-image:url('<?=
						$body_image['url'] ?>');"></div>
				</div>
				<?php endif ?>

				<?php if ($body_text): ?>
				<div class="secondary-content-body-text">
					<?= $body_text ?>
				</div>
				<?php endif ?>
			</div>
		</div>
		<?php
	}

	private function printImageColumn($col)
	{
		if (empty($col['image']))
		{
			return;
		}

		$image = $col['image'];

		$class = 'secondary-content-image-col';

		if (!empty($col['image_sizing']))
		{
			$class .= ' image-sizing-'.$col['image_sizing'];
		}

		?>
		<div class="<?= $class ?>">
			<div class="image" style="background-image:url('<?=
				$image['url'] ?>');"></div>
		</div>
		<?php
	}
}
