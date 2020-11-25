<?php
defined('BASEPATH') OR exit('No direct script access allowed');

define ('K_TCPDF_EXTERNAL_CONFIG', true);
define ('K_PATH_IMAGES', dirname(__FILE__).'/../images/');
define ('PDF_HEADER_LOGO', 'tcpdf_logo.jpg');
define ('PDF_HEADER_LOGO_WIDTH', 30);
define ('K_PATH_CACHE', sys_get_temp_dir().'/');
define ('K_BLANK_IMAGE', '_blank.png');
define ('PDF_PAGE_FORMAT', 'A4');
define ('PDF_PAGE_ORIENTATION', 'P');
define ('PDF_CREATOR', 'TCPDF');
define ('PDF_AUTHOR', 'TCPDF');
define ('PDF_HEADER_TITLE', 'TCPDF Example');
define ('PDF_HEADER_STRING', "by Nicola Asuni - Tecnick.com\nwww.tcpdf.org");
define ('PDF_UNIT', 'mm');
define ('PDF_MARGIN_HEADER', 5);
define ('PDF_MARGIN_FOOTER', 10);
define ('PDF_MARGIN_TOP', 27);
define ('PDF_MARGIN_BOTTOM', 25);
define ('PDF_MARGIN_LEFT', 15);
define ('PDF_MARGIN_RIGHT', 15);
define ('PDF_FONT_NAME_MAIN', 'helvetica');
define ('PDF_FONT_SIZE_MAIN', 10);
define ('PDF_FONT_NAME_DATA', 'helvetica');
define ('PDF_FONT_SIZE_DATA', 8);
define ('PDF_FONT_MONOSPACED', 'courier');
define ('PDF_IMAGE_SCALE_RATIO', 1.25);
define('HEAD_MAGNIFICATION', 1.1);
define('K_CELL_HEIGHT_RATIO', 1.25);
define('K_TITLE_MAGNIFICATION', 1.3);
define('K_SMALL_RATIO', 2/3);
define('K_THAI_TOPCHARS', true);
define('K_TCPDF_CALLS_IN_HTML', true);
define('K_TCPDF_THROW_EXCEPTION_ERROR', false);

if (!defined('PDFROOT')) {
    define('PDFROOT', dirname(__FILE__) . '/');
    require(PDFROOT . 'TCPDF/tcpdf.php');
}

class PHPPdf extends TCPDF{
	public function __construct($orientation='P', $unit='mm', $format='A4', $unicode=true, $encoding='UTF-8', $diskcache=false, $pdfa=false
    ){
		parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
    }
}