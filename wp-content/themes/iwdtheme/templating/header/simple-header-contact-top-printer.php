<?php
// Like SimpleHeader, but with a section above the main section containing
// contact links.

namespace IllicitWeb;

class SimpleHeaderContactTopPrinter extends SimpleHeaderPrinter
{
	public function printHtml()
	{
		$this->printOpenHeader();
		$this->printContactTop();
		$this->printMainSection();
		$this->printCloseHeader();
	}

	protected function printContactTop()
	{
		?>
		<div id="header-contact-top">
			@todo Contact info here (via widget?)
		</div>
		<?php
	}

	protected function printMainSection()
	{
		?>
		<div id="header-main">
			<?php

			$this->printColumnA();
			$this->printColumnB();

			?>
		</div>
		<?php
	}
}
