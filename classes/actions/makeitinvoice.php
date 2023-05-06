<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'/invoiceV2/config.php';
require_once ROOT_PATH_CLASS .'invoices/class.invoice.php';

if(isset($_POST)){
    $client_id = $_POST['client_id'];
    $unique_id = $_POST['unique_profoma_id'];
    $invoice = new Invoice();
    
    $response_array = array();
    if($invoice->makeitInvoice($client_id, $unique_id) === true){
        $response_array['response'] = true;
    }
    else{
        $response_array['response'] = false;
    }

    echo json_encode($response_array);

}