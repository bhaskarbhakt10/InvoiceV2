<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'/invoiceV2/config.php';
require_once ROOT_PATH_CLASS .'client/class.client.php';
//ajax-file for client adding
if (isset($_POST)) {
    $post_data = $_POST['form_data'];
    $client_arr = array();
    foreach ($post_data as $post) {
        $client_arr[$post['name']] = $post['value'];
    }
    print_r($client_arr);

$client = new Client();
$client->gen_client_ID();


}
