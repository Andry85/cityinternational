<?php

namespace IllicitWeb;

class TopBannerPrinter extends SectionPrinter
{
	public function printHtml()
	{
		echo new PageBannerPrinter('top_banner', 'top-banner');
	}
}
