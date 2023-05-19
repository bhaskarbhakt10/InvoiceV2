<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/invoiceV2/config.php';
require_once ROOT_PATH_CLASS . '/client/class.client.php';
require_once ROOT_PATH_CLASS . '/invoices/class.invoice.php';
require_once ROOT_PATH_CLASS . '/tcpdf/tcpdf.php';

if (array_key_exists('id', $_GET) && array_key_exists('client-id', $_GET)) {
    $perfoma_id = $_GET['id'];
    $client_id = $_GET['client-id'];
} else {
    exit();
}


$invoice = new Invoice();
$client = new Client();

$invoice_client_details = $client->get_client_details_by_id($client_id);
// print_r($invoice_client_details);
if(!empty($invoice_client_details)){
        $client_details_json= $invoice_client_details['InvoiceClient_Info'];
    
}
$invoice_info = $invoice->get_all_Details_ByID($client_id);
// print_r($invoice_info);
if ($invoice_info->num_rows > 0) {
    while ($row = $invoice_info->fetch_assoc()) {
        $invoice_info_json = $row['invoiceInvoices_Info'];
    }
}
if (!empty($invoice_info_json)) {
    $invoice_info_arr = json_decode($invoice_info_json, true);
    foreach ($invoice_info_arr as $info_arrkey => $info_arrvalue) {
        if ($info_arrvalue['uniqueID'] === $perfoma_id) {
            // print_r($info_arrvalue);
            // $perfoma_number = $info_arrvalue['performa-number'];
            $perfoma_number = $info_arrvalue['performa-new'];
            $dated_invoice = $info_arrvalue['performa-date'];
            $service = $info_arrvalue['performa-service'];    
            $description = $info_arrvalue['description'];
            $price = $info_arrvalue['price'];
            $discount = $info_arrvalue['discount'];
            $subtotal = $info_arrvalue['subtotal'];
            if(array_key_exists('IGST', $info_arrvalue) && array_key_exists('IGST-value', $info_arrvalue)){
                $IGST = $info_arrvalue['IGST'];
                $IGST_value = $info_arrvalue['IGST-value'];
            }
            if(array_key_exists('CGST', $info_arrvalue) && array_key_exists('CGST-value', $info_arrvalue)){
                $CGST = $info_arrvalue['CGST'];
                $CGST_value = $info_arrvalue['CGST-value'];
            }
            if(array_key_exists('SGST', $info_arrvalue) && array_key_exists('SGST-value', $info_arrvalue)){
                $SGST = $info_arrvalue['SGST'];
                $SGST_value = $info_arrvalue['SGST-value'];
            }
            $is_perfoma = $info_arrvalue['is_perfoma'];
            $is_invoice = $info_arrvalue['is_invoice'] ;
            // $invoice_number = $info_arrvalue['invoice_number'] ;
            $invoice_number = $info_arrvalue['invoice_universal_number'] ;
            $is_paid = $info_arrvalue['is_paid'] ;

            $proforma_text = "Proforma";
            $proforma_heading = "PROFORMA INVOICE";
            $proforma_footer = "Proforma";
            if($is_perfoma === 0 && $is_invoice === 1 && $is_paid === 1){
                $perfoma_number = $invoice_number;
                $proforma_text = "Tax Invoice";
                $proforma_heading = "INVOICE";
                $proforma_footer = "invoice";
            }

            $total = $info_arrvalue['total'];
        }

    }
}
// echo $proforma_text;
if(!empty($client_details_json)){
    $client_details_arr = json_decode($client_details_json, true);
    // print_r($client_details_arr);
    $client_name = $client_details_arr['client-name'];
    $textbox_useage = $client_details_arr['textbox-usage'];
    $client_address = '';
    if(array_key_exists('input-city-check', $client_details_arr) && strcasecmp($client_details_arr['input-city-check'], 'on')===0){
        
        $city = $client_details_arr['input-city']." ";
    }
    else{
        $city = $client_details_arr['address-country-city'];

    }
    if(strcasecmp($textbox_useage,'yes') === 0 ){
        // echo $textbox_useage;
        $client_address .= $client_details_arr['text-address-box'];
    }
    else{
        $client_address .= $client_details_arr['address-line-one'] . $client_details_arr['address-line-two'] .',<br>'.$city . $client_details_arr['postal-code'] . ', ' . $client_details_arr['address-country-state'] . ', ' .$client_details_arr['address-country'];
    }
}

//main table row
$description_row = '';
if(!empty($description) && !empty($price)){
    $exploded_description = explode(',', $description);
    $exploded_price = explode(',', $price);
    for ($i=0; $i < count($exploded_description); $i++) { 
        if(!empty($exploded_description[$i])){
            $sr_no = $i+1;
            $description_row .='<tr><td class="text-indent-left text-center">'.$sr_no.'</td><td class="text-indent-left">'.$exploded_description[$i].'</td><td class="text-indent-left text-center">998314</td><td class="text-indent-left text-center">'.$exploded_price[$i].'</td></tr>';
        }
    }
}

//sub total
$subtotal_data ='';
if(!empty($subtotal)){
    $subtotal_data .='<td class="text-center text-indent-left">'.$subtotal.'</td>';
}


//IGST CGST SGST
$igst_row = '';
if(!empty($IGST) && !empty($IGST_value)){
    $igst_row = '<tr><td></td><td></td><td class="text-center text-indent-left"><b>IGST ('.$IGST.')</b></td><td class="text-center text-indent-left">'.$IGST_value.'</td></tr>';
}
$sgst_row ='';
if(!empty($SGST) && (!empty($SGST_value))  && !empty($CGST) && !empty($CGST_value)){
    $sgst_row .='<tr><td></td><td></td><td class="text-center text-indent-left"><b>CGST ('.$CGST.')</b></td><td class="text-center text-indent-left">'.$CGST_value.'</td></tr>';
    $sgst_row .='<tr><td></td><td></td><td class="text-center text-indent-left"><b>SGST ('.$SGST.')</b></td><td class="text-center text-indent-left">'.$SGST_value.'</td></tr>';
    
}


$total_data = '';
if(!empty($total)){
    $total_data .='<td class="text-center text-indent-left">'.$total.'</td>';
}

$tnc = '';
 if(!empty($service)){
    switch ($service) {
        case 'SMO':
            $tnc= '<tr>
            <td class="font-10">
                <b class="">Payment Terms:</b>
                <ol class="">
                    <li>50% amount to be paid in advance for SMO services.</li>
                <li>Balance 50% to be paid at the end of the 2nd month of the 3 month package period.</li>
                <li>Cheque payment via courier/Online transfer accepted.</li>
            </ol>
                <b>General Terms:</b>
                <ol><li>Guarantee of security only if the administrative rights are held solely by NUIT Solutions.</li>
                <li>No features will be added once the bill is finalised. Any additional feature will hold extra charge.</li>
                <li>For designing specific posts, the minimum time to be given is 48 hrs. </li>
                <li>NUIT Solutions is not responsible for copyright of content/images.</li>
                <li>Response to customer queries on any social portals is to be handled by the client.</li>
            </ol>
            </td>
            </tr>';
            break;
        case 'SEO':
            $tnc='<tr>
            <td class="font-10">
                <b class="">Payment Terms:</b>
                <ol class="">
                    <li>100% upfront amount is payable monthly by the client for SEO services.</li>
                    <li>Minimum period for SEO package is 6 months.</li>
                    <li>Cheque payment /Online transfer/Cash payment accepted.</li>
                </ol>
                <b>General Terms:</b>
                <ol><li>Guarantee of security only if the administrative rights are held solely by NUIT Solutions.
                    </li>
                    <li>No features will be added once the bill is finalised. Any additional feature will hold extra charge.</li>
                    <li>For any updates to feature, the minimum time to be given is 24 hrs.</li>
                    <li>NUIT Solutions is not responsible for copyright of content/images.</li>
                </ol>
            </td>
            </tr>';
            break;
        case 'AMC':
            $tnc='<tr>
            <td class="font-10">
                <b class="">Payment Terms:</b>
                <ol class="">
                    <li>100% amount to be paid in advance for website maintenance.</li>
                <li>Cheque payment via courier/Online transfer accepted.</li>
            </ol>
                <b>General Terms:</b>
                <ol><li>Guarantee of security only if the administrative rights are held solely by NUIT Solutions.
            </li>
                <li>No features will be added once the bill is finalised. Any additional feature will hold extra charge.</li>
                <li>For any updates to feature, the minimum time to be given is 2 working days.</li>
                <li>NUIT Solutions is not responsible for copyright of content/images.</li>
            </ol>
            </td>
            </tr>';
        break;
        case 'WSD':
            $tnc='<tr>
            <td class="font-10">
                <b class="">Payment Terms:</b>
                <ol class="">
                    <li>50% upfront amount needs to be paid by the client for website development and 100% upfront payment for domain/hosting purchase.</li>
                <li>The client will be liable to pay the balance due, if a maximum timeline of 3 months is extended for website development from client end. Only post complete payment will the website be made live.</li>
                <li>Cheque payment /Online transfer/Cash payment accepted.</li>
            </ol>
                <b>General Terms:</b>
                <ol><li>Guarantee of security only if the administrative rights are held solely by NUIT Solutions.
            </li>
                <li>No features will be added once the bill is finalised. Any additional feature will hold extra charge.</li>
                <li>Free Maintenance of the website will be provided (*only for projects that fall in this category) which includes only image and content updates. During this period the admin rights will not be shared by NUIT Solutions. The client may decide whether to avail of Free Maintenance or not.</li>
                <li>For any updates to feature, the minimum time to be given is 24 hrs.</li>
                <li>NUIT Solutions is not responsible for copyright of content/images.</li>
            </ol>
            </td>
            </tr>';
            break;
        case 'MKT':
            $tnc='<tr>
            <td class="font-10">
                <b class="">Payment Terms:</b>
                <ol class="">
                    <li>100% amount to be paid in advance for Paid Ads services.</li>
                <li>Cheque payment /Online transfer/Cash payment accepted.</li>
            </ol>
                <b>General Terms:</b>
                <ol><li>Guarantee of security only if the administrative rights are held solely by NUIT Solutions.
            </li>
                <li>All leads generated have to be handled by the client. Only lead information will be provided by NUIT Solutions.</li>
                <li>For any updates to feature, the minimum time to be given is 24 hrs.</li>
                <li>NUIT Solutions is not responsible for copyright of content/images.</li>
            </ol>
            </td>
            </tr>';
            break;
        case 'DHS':
            $tnc='<tr>
            <td class="font-10">
                <b class="">Payment Terms:</b>
                <ol class="">
                    <li>100% upfront amount is payable by the client for domain, hosting, email & SSL services.</li>
                <li>Domain/Hosting/Email/SSL is renewed automatically once the payment is done.</li>
                <li>Cheque payment via courier/Online transfer accepted.</li>
            </ol>
                <b>General Terms:</b>
                <ol><li>Guarantee of security only if the administrative rights are held solely by NUIT Solutions.
            </li>
                <li>No features will be added once the bill is finalised. Any additional feature will hold extra charge.</li>
                <li>For any updates to feature, the minimum time to be given is 24 hrs.</li>
                <li>NUIT Solutions is not responsible for copyright of content/images.</li>
            </ol>
            </td>
            </tr>';
            break;
        case 'DES':
            $tnc='<tr>
            <td class="font-10">
                <b class="">Payment Terms:</b>
                <ol class="">
                    <li>100% upfront amount is payable for designing orders.</li>
                <li>All payments to be done via Online transfer.</li>
            </ol>
                <b>General Terms:</b>
                <ol><li>Guarantee of security only if the administrative rights are held solely by NUIT Solutions.
            </li>
                <li>No features will be added once the bill is finalised. Any additional feature will hold extra charge.</li>
                <li>All designs (for pamphlets/brochure/packaging/business stationery) will be provided in .psd or .ai format for print.</li>
                <li>For social media or festive designs no open file will be provided.</li>
                <li>NUIT Solutions is not responsible for copyright of content/images.</li>
            </ol>
            </td>
            </tr>';
            break;
        case 'ECOM':
            $tnc='<tr>
            <td class="font-10">
                <b class="">Payment Terms:</b>
                <ol class="">
                    <li>50% upfront amount needs to be paid by the client if the order value is between Rs. 10,000 and Rs. 40,000.</li>
                <li>30% upfront amount needs to be paid if the order value is above Rs. 40,000.</li>
                <li>Cheque payment via courier/Online transfer accepted.</li>
            </ol>
                <b>General Terms:</b>
                <ol><li>Guarantee of security only if the administrative rights are held solely by NUIT Solutions.
            </li>
                <li>No features will be added once the bill is finalised. Any additional feature will hold extra charge.</li>
                <li>For any updates to feature, the minimum time to be given is 24 hrs.</li>
                <li>NUIT Solutions is not responsible for copyright of content/images.</li>
            </ol>
            </td>
            </tr>';
            break;

        default:
            # code...
            break;
    }
}

class MYPDF extends TCPDF
{
    protected $invoice_or_profoma ;
    protected $watermark;
    protected $tnc;
    function invoiceORprofoma($proforma_footer){
        $this->invoice_or_profoma = $proforma_footer;
    }
    function tnc($tnc){
        $this->tnc = $tnc;
    }

    function watermark__($watermark){
        $this->watermark = $watermark;
    }

    public function Header()
    {   
        $header_image = PDF_IMAGES . 'header.png';
        $html = '';
        $html .= '<style>.header-image{width:950px;}</style>';
        $html .= '<table class="blue"><tr><td ><img src="' . $header_image . '" class="header-image"></td></tr></table>';
        
        if($this->watermark === 1){
            $bMargin = $this->getBreakMargin();
            $auto_page_break = $this->AutoPageBreak;
            $this->SetAutoPageBreak(false, 0);
            $img_file =  PDF_IMAGES . 'paid.png';
            $this->Image($img_file, 0, 0, 223, 280, '', '', '', false, 300, '', false, false, 0);
            $this->SetAutoPageBreak($auto_page_break, $bMargin);
            $this->setPageMark();
        }
        
        
        $this->writeHTML($html, false, false, false, false, 'L');
    }

    // Page footer
    public function Footer()
    {
        $footer_image = PDF_IMAGES . 'footer.png';
        $html = '';
        $html .= '<style>.text-right{text-align:right;}ol{padding:0; line-height:0; list-style:}li{line-height:12px;}.blue{background-color:blue;}.red{background-color:red;}.w-10{width:10%;}.W-80{width:80%;}.font-10{font-size:10px;}.footer-image{width:980px; height:233px;}</style>';
        $html .= '<table class=""><tr><td class="w-10"></td><td class="w-80"><table><tr><td><p class="text-right"><i>*This is an Electronic '.$this->invoice_or_profoma.' and hence needs no signature.</p></i><hr class="red"></td></tr><tr><td class="font-10"><b>NUIT Solutions proclaims 100% Non-Disclosure Agreement Guarantee to prevent unauthorized access of client-owned “Confidential Information”. We assert that it will never be used for any of our other clients</b></td></tr>'. $this->tnc .'</table></td><td class="w-10"></td></tr></table>';
        $html .= '<table class=""><tr><td><img src="' . $footer_image . '" class="footer-image"></td></tr></table>';
        $this->writeHTML($html, false, false, false, false, 'L');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NUIT SOLUTIONS');
$pdf->SetTitle($client_name);


// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(0, 35, 0);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(102);
$pdf->setListIndentWidth(4);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 11);

// add a page
$pdf->watermark__($is_paid);
$pdf->AddPage();

// set some text to print
$main_body = '';
$main_body .= '<style>.red{background-color:red;}.blue{background-color:blue;}.line-height{line-height:18px;}.border-1px{border:1px solid #333;}.font-14{font-size:14px;}.text-indent-left{ text-indent: 5px;}.text-left{text-align:left}.text-center{text-align:center}.text-right{text-align:right}.w-10{width:10%;}.w-20{width:20%;}.w-30{width:30%;}.w-40{width:40%;}.w-42{width:42%;}.w-50{width:50%;}.w-60{width:60%;}.w-70{width:70%;}.w-80{width:80%;}.w-100{width:100%;}</style>';
$main_body .= '<table class="body-table">';
$main_body .= '<tbody>';
$main_body .= '<tr>';
$main_body .= '<td class="w-10"></td>';
$main_body .= '<td class="w-80"><table><tr><td class="w-70">';

$main_body .= '<table class="w-100"><tbody><tr><td><b>'.$proforma_text.' </b>'.$perfoma_number.'</td></tr><tr><td><b>Invoice Date: </b>'.$dated_invoice.'<br></td></tr><tr><td><b>Invoiced To</b><br>' .$client_name .'<br>'. $client_address.'</td></tr></tbody></table>';
$main_body .= '</td>';
$main_body .= '<td class="w-30">';
$main_body .= '<table class="w-100"><tbody><tr><td class="text-right"><b>NUIT SOLUTIONS</b><br>Sanghamitra, Anmol Nagar<br>Naigaon West<br>District Palghar 401207<br>GSTIN 27APXPJ2589P2ZM</td></tr></tbody></table>';

$main_body .= '</td>';
$main_body .='</tr></table><div></div>';

$main_body .= '<table><tr><th class="text-center"><b>'.$proforma_heading.'</b></th></tr></table><div></div>';
$main_body .= '<table border="1" class="w-100 "><tr><th class="text-center w-10"><b>SR NO.</b></th><th class="text-center w-50"><b>PARTICULARS</b></th><th class="text-center w-20"><b>SAC CODE</b></th><th class="text-center w-20"><b>AMOUNT<br>(in INR)</b></th></tr>';
$main_body .= $description_row;
$main_body .= '<tr><td></td><td></td><td class="text-center text-indent-left"><b>Sub Total</b></td>'.$subtotal_data.'</tr>';
$main_body .= $igst_row;
$main_body .= $sgst_row;
$main_body .= '<tr><td></td><td></td><td class="text-center text-indent-left"><b>Total</b></td>'.$total_data.'</tr>';
$main_body .= '</table><div></div>';
$main_body .= '<table class="w-100"><tr><td><table class="w-40 border-1px"><tr><td class="" style="width:2%">&nbsp;</td><td class="font-14 w-100"><p class="line-height"><b>Bank account details for direct transfer</b><br>Name: NUIT SOLUTIONS<br>Account no: 104304180000533<br>CURRENT ACCOUNT<br>Shamrao Vitthal Coop Bank (Malad East)<br>IFSC Code: SVCB0000043<br>OR<br><b>Gpay to NUIT Solutions</b> at 7977475077</p></td><td class="" style="width:2%">&nbsp;</td></tr></table></td></tr></table>';

$main_body .= '</td><td class="w-10"></td>';
$main_body .= '</tr>';
$main_body .= '</tbody>';
$main_body .= '</table>';

$pdf->invoiceORprofoma($proforma_footer);
$pdf->tnc($tnc);

// print a block of text using Write()
// $pdf->Write(0, $main_body, '', 0, 'C', true, 0, false, false, 0);
$pdf->writeHTML($main_body, true, false, true, false, '');
// ---------------------------------------------------------

//Close and output PDF document

if(array_key_exists('trigger', $_GET)){
    $pdf->Output($client_name.'.pdf', 'D');
    $download = $_GET['trigger'];
}
else{
    $pdf->Output($client_name.'.pdf', 'I');
}
//============================================================+
// END OF FILE
//============================================================+
