<?php

require_once $_SERVER['DOCUMENT_ROOT'] .'/invoiceV2/config.php';
require_once ROOT_PATH_CLASS .'client/class.client.php';

if(isset($_POST)){
    $delete_id = $_POST['delete_id'];
    
    $client = new Client();
    $response_array = array();
    if($client->delClient_by_id($delete_id) === true){
        $response_array['response'] = true;
    }
    else{
        $response_array['response'] = false;
    }

    echo json_encode($response_array);

}