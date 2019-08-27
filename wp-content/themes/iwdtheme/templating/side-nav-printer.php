<?php
/**
 * Note: to turn an element into a toggle-open button for the side nav, give it
 * the data attr 'data-open-side-nav'.
 * 
 */
namespace IllicitWeb;

use WP_Post;

class SideNavPrinter extends SectionPrinter
{
	public function printHtml()
	{
		?>
		<div id="side-nav">
			<?php $this->printCloseButton() ?>
			<?php $this->printMenu() ?>
		</div>
		<?php
	}

	private function printCloseButton()
	{
		?>
		<div id="side-nav-close-wrap">
			<div id="side-nav-close" data-close-side-nav="">
				Close
			</div>
		</div>
		<?php
	}

	private function printMenu()
	{
		?>
		<div id="side-nav-menu-wrap">
			<?php wp_nav_menu(['theme_location' => 'main-menu']) ?>
		</div>
		<?php
	}
}
