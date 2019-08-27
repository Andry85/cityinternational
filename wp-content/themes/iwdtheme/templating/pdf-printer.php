<?php

// Note on images - in the HTML for a PdfPrinter, <img> src attribute values
// should be absolute local file paths to image files, rather than URLs.

namespace IllicitWeb;

abstract class PdfPrinter extends Printer
{
	// Optionally override these properties in subclasses.
	protected $paperSize = 'A4';
	protected $paperOrientation = 'P'; // 'P' or 'L'

	public function output($filename)
	{
		$gen = new PdfGenerator($this->getHtml(), $filename, $this->paperOrientation, $this->paperSize);
		$gen->output();
	}
}
