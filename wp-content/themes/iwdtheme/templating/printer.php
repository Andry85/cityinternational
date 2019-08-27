<?php
namespace IllicitWeb;

use Exception;

abstract class Printer
{
	abstract public function printHtml();

	final public function getHtml()
	{
		ob_start();

		$this->printHtml();
		
		return ob_get_clean();
	}

	final public function __toString()
	{
		try
		{
			return $this->getHtml();
		}
		catch (Exception $exc)
		{
			print_out_error($exc->getCode(),
							'Caught exception: '.$exc->getMessage(),
							'Warning');
			return '';
		}
	}
}
