<?php

namespace IllicitWeb;

class SimpleHeaderPrinter extends HeaderPrinter
{
	public function printHtml()
	{
		$this->printOpenHeader();
		$this->printColumnA();
		$this->printColumnB();

		if ($this->shouldPrintSearchPopout())
		{
			$this->printSearchPopout();
		}

		$this->printCloseHeader();
	}

	protected function printColumnA()
	{
		?>
		<div id="header-col-a">
			<?php $this->printLogoLink() ?>
		</div>
		<?php
	}

	protected function printColumnB()
	{
		?>
		<div id="header-col-b">
			<?php $this->printNav() ?>
		</div>
		<?php
	}
}
