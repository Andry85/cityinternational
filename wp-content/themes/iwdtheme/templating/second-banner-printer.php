<?php

namespace IllicitWeb;

class SecondBannerPrinter extends SectionPrinter
{
	public function printHtml()
	{
		echo new PageBannerPrinter('second_banner', 'second-banner');
	}
}
