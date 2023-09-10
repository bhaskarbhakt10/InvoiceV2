<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'/invoiceV2/config.php';
require_once ROOT_PATH_CLASS .'invoices/class.invoice.php';
$invoice = new Invoice();

if(isset($_POST)){
    $form_data = $_POST['form_data'];

    $data_arr = array();
    foreach($form_data as $datakey => $datavalue){
        if(array_key_exists($datavalue['name'], $data_arr)){
            $data_arr[$datavalue['name']] .= ",".preg_replace("/[\r\n]+/", '<br>', $datavalue['value']);
        }
        else{
            $data_arr[$datavalue['name']] = preg_replace("/[\r\n]+/", '<br>', $datavalue['value']);   ;
        }
       
    }
    //adding payload

    date_default_timezone_set(TIMEZONE_IN);
    $date = new DateTime();
    $time_now = $date->format('h:m:s A');
    $date_today = $date->format('d-m-Y');
    $data_arr['uniqueID'] = uniqid(time());
    $data_arr['is_active'] = 1;
    $data_arr['is_perfoma'] = 1;
    $data_arr['is_invoice'] = 0;
    $data_arr['invoice_number'] = "";
    $data_arr['invoice_universal_number'] = "";
    $data_arr['is_paid'] = 0;
    $data_arr['genrated_at_time'] = $time_now;
    $data_arr['genrated_at_date'] = $date_today;

    $update_id = $data_arr['client_id'];
    // echo $update_id;
    $data_array_to_db = array();
    array_push($data_array_to_db,$data_arr);
    $invoice_data = json_encode($data_array_to_db);
    // print_r($invoice_data);

    
    $response_array = array();
    
    if($invoice->update_invoiceInvoices_Info($invoice_data, $update_id) === true){
        $response_array['response'] = true;
    }
    else{
        $response_array['response'] = false;
    }
    echo json_encode($response_array);

}