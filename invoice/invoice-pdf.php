<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'/invoiceV2/config.php';
require_once ROOT_PATH_CLASS . '/client/class.client.php';
require_once ROOT_PATH_CLASS . '/invoices/class.invoice.php';
require_once ROOT_PATH_CLASS . '/tcpdf/tcpdf.php';

if(array_key_exists('id', $_GET) && array_key_exists('client-id', $_GET)){
    $perfoma_id = $_GET['id']; 
    $client_id = $_GET['client-id']; 
}
else{
    exit();
}




// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        $header_image = PDF_IMAGES .'header.png';
        $html = '';
        $html .='<style>.header-image{width:950px;}</style>';
        $html .='<table class="blue"><tr><td ><img src="'.$header_image.'" class="header-image"></td></tr></table>';
        $this->writeHTML($html, false, false, false, false, 'L');
    }

    // Page footer
    public function Footer() {
        $footer_image = PDF_IMAGES .'footer.png';
        $html = '';
        $html .='<style>.footer-image{width:950px; height:210px;}</style>';
        $html .='<table class="red"><tr><td ><img src="'.$footer_image.'" class="footer-image"></td></tr></table>';
        $this->writeHTML($html, false, false, false, false, 'L');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 003');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(0, 35, 0);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(45);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 12);

// add a page
$pdf->AddPage();

// set some text to print
$main_body = '';
$main_body .= '<style>.red{background-color:red;}.blue{background-color:blue;}.text-right{text-align:right}.w-10{width:10%;}.w-20{width:20%;}.w-30{width:30%;}.w-40{width:40%;}.w-50{width:50%;}.w-60{width:60%;}.w-70{width:70%;}.w-80{width:80%;}.w-100{width:100%;}</style>';
$main_body .= '<table class="body-table">';
$main_body .= '<tbody>';
$main_body .= '<tr>';
$main_body .= '<td class="w-10"></td>';
$main_body .= '<td class="w-80"><table><tr><td class="w-70">';

$main_body .= '<table class="w-100 blue"><tbody><tr><td><b>Proforma</b> PI/#008/2022-23</td></tr><tr><td><b>Invoice Date: </b>24.03.2023<br></td></tr><tr><td><b>Invoiced To</b><br>12321</td></tr></tbody></table>';
$main_body .= '</td>';
$main_body .= '<td class="w-30">';
$main_body .= '<table class="w-100"><tbody><tr><td class="text-right"><b>NUIT SOLUTIONS</b><br>Sanghamitra, Anmol Nagar<br>Naigaon West<br>District Palghar 401207<br>GSTIN 27APXPJ2589P2ZM</td></tr></tbody></table>';

$main_body .= '</td></tr></table></td>';
$main_body .= '<td class="w-10"></td>';
$main_body .= '</tr>';
$main_body .= '</tbody>';
$main_body .= '</table>';


// print a block of text using Write()
// $pdf->Write(0, $main_body, '', 0, 'C', true, 0, false, false, 0);
$pdf->writeHTML($main_body, true, false, true, false,'');
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_003.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
