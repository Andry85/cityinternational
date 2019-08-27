<?php

// Note: To do parallax scrolling on a banner image, you need to meet the 
// following conditions:
//  - Only 1 banner item
//  - No video
//  - PARALLAX_SPEED const defined (float between 0 and 1)

namespace IllicitWeb;

class BannerPrinter extends SectionPrinter
{
	protected $banner;
	protected $showScrollDownButton;
	protected $doParallax;
	protected $videoHtml;

	public function __construct(Banner $banner)
	{
		$this->banner = $banner;
		$this->showScrollDownButton = $banner->showScrollDownButton();
		$this->doParallax = $banner->shouldDoParallax();
		$this->videoHtml = $banner->getVideoHtml();
	}

	public function printHtml()
	{
		$this->printOpen();

		if ($this->videoHtml)
		{
			$this->printVideo();	
		}
		else
		{
			$this->printItems();
		}

		$this->printOverlay();

		$this->printControls();

		$this->printScrollDownButton();
		
		$this->printClose();
	}

	protected function printOpen()
	{
		$class = $this->getContainerClassString();
		$banner = $this->banner;
		$id = $banner->id();
		$wait = $banner->getWaitDuration();
		$transition = $banner->getTransitionDuration();

		?>
		<div class="<?= $class ?>" data-banner-id="<?= $id
			?>" data-wait="<?= $wait
			?>" data-transition="<?= $transition
			?>">
		<?php
	}

	protected function printClose()
	{
		$buttons = $this->banner->acf('banner_extra_buttons');

		?>

		<?php if (!empty($buttons)): ?>
			<div class="banner-extra-buttons">
				<?php foreach ($buttons as $button): ?>
					<a href="<?= $button['banner_extra_button_link'] ?>"><?= $button['banner_extra_button_title'] ?></a>
				<?php endforeach ?>
			</div>
		<?php endif ?>

		</div>
		<?php
	}

	protected function getContainerClassString()
	{
		return implode(' ', $this->getContainerClassesArray());
	}

	protected function getContainerClassesArray()
	{
		$classes = [
			'iw-banner',
			'iw-banner-'.$this->banner->getSize(),
		];

		if ($this->doParallax)
		{
			$classes[] = 'parallax';
		}
		else
		{
			$classes[] = 'no-parallax';
		}

		if ($this->showScrollDownButton)
		{
			$classes[] = 'scroll-button-container';
		}

		return apply_filters('iw_banner_classes', $classes);
	}

	protected function printItems()
	{
		$this->banner->forEachItem(function (array $item, $index) {
			$this->printItem($item, $index);
		});
	}

	protected function printItem(array $item, $index)
	{
		$wait = empty($item['iw_banner_wait_duration_override']) ?
			null :
			(int)$item['iw_banner_wait_duration_override'];
		
		$z_index = $opacity = ($index === 0) ? '1' : '0';

		$style = 'z-index:'.$z_index.';opacity:'.$opacity.';';

		$style .= 'background-image:url(\''.$item['main_image']['url'].'\');';
		
		$text_content = do_shortcode($item['text_content']);

		$do_dark_bgd = !empty($item['dark_bgd']);

		$class = 'iw-banner-item';

		if (!empty($item['image_position']))
		{
			$class .= ' image-pos-'.$item['image_position'];
		}

		?>

		<div class="<?= $class ?>" style="<?= $style ?>"<?php 

			if ($this->doParallax):
		
				?> data-parallax="scroll" data-speed="<?= PARALLAX_SPEED 
			
				?>" data-image-src="<?= $item['main_image']['url'] ?>"<?php

			endif;

			if ($wait !== null):

				?> data-wait="<?= $wait ?>"<?php
			
			endif;

			?>>

			<?php if ($do_dark_bgd): ?>
			<div class="iw-banner-dark-bgd"></div>
			<?php endif ?>

			<div class="iw-banner-overlay">
				<div class="iw-banner-overlay-inner">
					<div><?= $text_content ?></div>
				</div>
			</div>
		</div>
		<?php
	}

	protected function printVideo()
	{
		?>
		<div class="iw-banner-item">
			<div class="iw-banner-video">
				<?= $this->videoHtml ?>
			</div>
		</div>
		<?php
	}

	protected function printOverlay()
	{
		$this->banner->forOverlay(function ($html, $image) {
			?>
			<div class="iw-banner-overlay"<?php

			if ($image):

				?> style="background-image: url('<?= $image['url'] ?>'); "<?php

			endif;

				?>>
				
				<?php if ($this->banner->hasOverlayDarkBgd()): ?>
				<div class="iw-banner-dark-bgd"></div>
				<?php endif ?>

				<div class="iw-banner-overlay-inner">
					<div><?= $html ?></div>
				</div>
			</div>
			<?php
		});
	}

	protected function printControls()
	{
		if (!$this->banner->shouldDisplayControls())
		{
			return;
		}

		?>

		<div class="iw-banner-ctrls">
			<?php 

			$this->banner->forEachItem(function (array $item, $index) { 

				?>
				<span class="iw-banner-ctrl<?php

					if ($index === 0) echo ' iw-banner-ctrl-on';

					?>"></span>
				<?php 

			});

			?>
		</div>

		<?php
	}

	protected function printScrollDownButton()
	{
		if (!$this->showScrollDownButton)
		{
			return;
		}

		?>
		<div class="scroll-down-button"></div>
		<?php
	}
}
