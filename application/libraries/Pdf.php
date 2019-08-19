<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  
require_once APPPATH."/third_party/tcpdf/tcpdf.php";
class Pdf extends TCPDF 
{
    public function __construct() {
        parent::__construct();
    }

    public function Header() {
        // Logo
        /*$image_file = K_PATH_IMAGES.'logo_example.jpg';
        $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);*/
        // Set font
        $this->SetFont('thsarabun', 'B', 20);
        // Title
        $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('thsarabun', 'I', 16);
        // Page number
        $this->Cell(0, 0, 'หน้าที่ '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'C', 'M');
    }
}