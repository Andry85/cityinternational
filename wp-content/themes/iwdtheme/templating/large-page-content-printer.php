<?php

namespace IllicitWeb;

class LargePageContentPrinter extends PageContentPrinter
{
	public function __construct($section_id=null)
	{
		parent::__construct($section_id);

		$this->classes[] = 'large-page-content';
	}
}
