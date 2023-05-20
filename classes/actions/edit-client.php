<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/invoiceV2/config.php';
require_once ROOT_PATH_CLASS . 'client/class.client.php';
//ajax-file for client adding
if (isset($_POST)) {
    $post_data = $_POST['form_data'];
    $update_id = $_POST['update_id'];
    // print_r($post_data);
    // print_r($update_id);

    $client_arr = array();
    foreach ($post_data as $post) {
        $client_arr[$post['name']] = $post['value'];
    }
    $json_update_data = json_encode($client_arr);
    $client = new Client();
    $response_array = array();
    $results = $client->update_client_details($json_update_data, $update_id);
    if ($results === true) {
        $response_array['response'] = true;
    } else {
        $response_array['response'] = false;
    }
    echo json_encode($response_array);
}
