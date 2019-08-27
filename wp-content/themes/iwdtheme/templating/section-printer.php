<?php
namespace IllicitWeb;

use Exception;

abstract class SectionPrinter extends Printer
{
	private $fields = [];

	public function __construct($fields = [])
	{
		$this->fields = $fields;
	}

	public function get_field($key)
	{
		return !empty($this->fields[$key]) ? $this->fields[$key] : '';
	}
}
