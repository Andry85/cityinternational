<?php

namespace IllicitWeb;

class MoneyFormatter
{
	public function __construct($input, $currency_sym='', $thousands_sep='')
	{
		$this->input = $input;
		$this->currencySym = $currency_sym;
		$this->thousandsSep = $thousands_sep;
	}

	public function getOutput()
	{
		$input = $this->trimString($this->input);
		if ($this->isEmptyString($input)) {
			return '';
		}
		$num = (double)$input;
		$is_int = ($num == (int)$num);
		$decimals = $is_int ? 0 : 2;
		$output = number_format($num, $decimals, '.', $this->thousandsSep);
		$output = $this->currencySym.$output;
		return $output;
	}

	public function __toString()
	{
		return $this->getOutput();
	}

	public function setValue($input)
	{
		$this->input = $input;
		return $this;
	}

	private $input;
	private $currencySym;
	private $thousandsSep;

	private function trimString($value)
	{
		if (is_string($value)) {
			$value = trim($value);
		}
		return $value;
	}

	private function isEmptyString($value)
	{
		if (is_string($value)) {
			$value = trim($value);
			if ($value === '') {
				return true;
			}
		}
		return false;
	}
}
