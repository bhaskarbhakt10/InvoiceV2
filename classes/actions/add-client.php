<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/invoiceV2/config.php';
require_once ROOT_PATH_CLASS . 'client/class.client.php';
//ajax-file for client adding
if (isset($_POST)) {
    $post_data = $_POST['form_data'];
    $client_arr = array();
    foreach ($post_data as $post) {
        $client_arr[$post['name']] = $post['value'];
    }
    // print_r($client_arr);

    $client = new Client();
    $response_array = array();
    if ($client->get_details($client_arr) === true) {
        $response_array['response'] = true;
    } else {
        $response_array['response'] = false;
    }
    echo json_encode($response_array);
}
