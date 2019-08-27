<?php

namespace IllicitWeb;

abstract class HeaderPrinter extends SectionPrinter
{
	protected function printMainMenu()
	{
		wp_nav_menu(array('theme_location' => 'main-menu'));
	}

	protected function printOpenHeader($css_class=null)
	{
		?>
		<header id="header"<?php
			if ($css_class):
				?> class="<?= $css_class ?>"<?php
			endif ?>>
		<?php
	}

	protected function printCloseHeader()
	{
		?>
		</header>
		<?php
	}

	protected function printLogoLink()
	{
		?>
		<a href="/" id="header-logo"></a>
		<?php
	}

	protected function printOpenNav()
	{
		?>
		<nav class="illicit-nav" id="header-menu">
		<?php
	}

	protected function printCloseNav()
	{
		?>
		</nav>
		<?php
	}

	protected function printNav()
	{
		$this->printOpenNav();
		$this->printMainMenu();
		$this->printCloseNav();
	}

	protected function shouldPrintSearchPopout()
	{
		return definedtrue(__NAMESPACE__.'\\HEADER_SEARCH_POPOUT');
	}

	protected function printSearchPopout()
	{
		?>
		<div id="header-search-popout">
			<form method="get" action="/">
				<input type="search" placeholder="Search for..."
					value="<?= get_search_query() ?>" name="s" title="Search">
				<input type="submit" value="Search">
			</form>
			<span class="close-btn" data-search-close="">&times;</span>
		</div>
		<?php
	}

	protected function printSearchPopoutButton()
	{
		?>
		<span class="header-button-search" data-toggle-header-search=""></span>
		<?php
	}
}
