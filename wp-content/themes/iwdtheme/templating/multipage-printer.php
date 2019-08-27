<?php
namespace IllicitWeb;

class MultipagePrinter extends SectionPrinter
{
	public function __construct()
	{
		if (get_field('display_multipage_sections'))
		{
			$this->sections = get_field('multipage_sections');
			$this->backgroundImage = get_field('multipage_menu_background_image');
			$this->squareTiles = get_field('multipage_square_tiles');
		}
	}

	private $sections = null;
	private $backgroundImage = null;
	private $squareTiles = false;

	public function printHtml()
	{
		if (!$this->sections)
		{
			return;
		}

		?>
		<section class="content-block multipage<?php
			if ($this->squareTiles) echo ' square-tiles' 
				?>" data-multipage="">
			<?php $this->printMenuSection() ?>
			<?php $this->printContentSections() ?>
		</section>
		<?php
	}

	private function printMenuSection()
	{
		$image_url = $this->backgroundImage ? $this->backgroundImage['url'] : null;

		?>
		<div class="content-block-inner multipage-menu"<?php 
			if ($image_url): 
				?> style="background-image:url('<?= $image_url ?>');"<?php 
			endif ?>>
			<div class="overlay"></div>
			<div>
				<?php

				foreach ($this->sections as $section_index => $section)
				{
					$this->printMenuItem($section_index, $section);
				}

				?>
			</div>
		</div>
		<?php
	}

	private function printMenuItem($section_index, array $section)
	{
		?>
		<div class="multipage-menu-item" data-multipage-for="<?= $section_index ?>">
			<div>
				<?= $section['title'] ?>
			</div>
		</div>
		<?php
	}

	private function printContentSections()
	{
		?>
		<div class="multipage-sections">
			<?php 

			foreach ($this->sections as $section_index => $section)
			{
				$this->printContentSection($section_index, $section);
			}

			?>
		</div>
		<?php
	}

	private function printContentSection($section_index, array $section)
	{
		?>
		<div class="multipage-section" data-multipage-id="<?= $section_index ?>">
			<?php $this->printSectionIntroduction($section) ?>
			<?php $this->printSectionItems($section) ?>
		</div>
		<?php
	}

	private function printSectionIntroduction(array $section)
	{
		$html = trim($section['introduction']);

		if (!$html)
		{
			return;
		}

		?>
		<div class="introduction">
			<?= $html ?>
		</div>
		<?php
	}

	private function printSectionItems(array $section)
	{
		$items = $section['multipage_items'];

		if (!$items)
		{
			return;
		}

		?>
		<div class="multipage-section-items">
			<?php

			foreach ($items as $item)
			{
				$this->printSectionItem($item);
			}

			?>
		</div>
		<?php
	}

	private function printSectionItem(array $item)
	{
		$image_url = $item['image'] ? $item['image']['url'] : null;
		$title = trim($item['title']);
		$info = nl2br(trim($item['info']));

		?>
		<div class="multipage-section-item"<?php 
			if ($image_url): 
				?> style="background-image:url('<?= $image_url ?>');"<?php 
			endif ?>>
			<div class="multipage-section-item-info-text">
				<div>
					<?php if ($title): ?>
					<div class="title"><?= $title ?></div>
					<?php endif ?>
					<?php if ($info): ?>
					<div><?= $info ?></div>
					<?php endif ?>
				</div>
			</div>
		</div>
		<?php
	}
}
