<?php

namespace IllicitWeb;

require THEME_DIR.'classes/pdf/vendor/autoload.php'; 

use HTML2PDF;

class PdfGenerator
{
	public function __construct($html, $filename, $orientation='P', $size='A4')
	{
		$this->filename = $filename;
		$html2pdf = new HTML2PDF($orientation, $size, 'en');
	    $html2pdf->WriteHTML($html);
	    $this->html2pdf = $html2pdf;
	}
	
	private $filename;
	private $html2pdf;
	
	public function output()
	{
		ob_start();
		$this->html2pdf->Output($this->filename);
		$rendered = ob_get_clean();
		$this->setHeaders($rendered);
		echo $rendered;
		die;
	}

	private function setHeaders($rendered)
	{
		header('Content-Type: application/pdf');
		header('Content-Length: '.mb_strlen($rendered));
		header('Content-Disposition: inline; filename="'.$this->filename.'"');
		header('Cache-Control: public, must-revalidate, max-age=0');
		header('Pragma: public');
		header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
		header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	}
}
