<?php

namespace IllicitWeb;

class SimpleHeader3ColPrinter extends SimpleHeaderPrinter
{
	public function printHtml()
	{
		$this->printOpenHeader('header-3-col');
		$this->printColumnA();
		$this->printColumnB();
		$this->printColumnC();

		if ($this->shouldPrintSearchPopout())
		{
			$this->printSearchPopout();
		}

		$this->printCloseHeader();
	}

	protected function printColumnC()
	{
		?>
		<div id="header-col-c">

			<?php 

			if ($this->shouldPrintSearchPopout())
			{
				$this->printSearchPopoutButton();
			}

			?>

		</div>
		<?php
	}
}
