<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/invoiceV2/config.php';
require_once ROOT_PATH_CLASS . 'client/class.client.php';
//ajax-file for client adding
if (isset($_POST)) {
    $post_data = $_POST['form_data'];
    $client_name = $_POST['client_name'];
    $client_country_code = $_POST['client_country_code'];
    $client_phone_number = $_POST['client_phone_number'];
    $client_email = $_POST['client_email'];



    $client_arr = array();
    foreach ($post_data as $post) {
        $client_arr[$post['name']] = preg_replace("/[\r\n]+/", '<br>', $post['value']);
    }
    // print_r($client_arr);

    $client = new Client();
    $results = $client->get_all_clients();

    // print_r($results);

    $all_clients = array();
    $response_array = array();
    if (!empty($results)) {
        if ($results->num_rows > 0) {
            while ($row = $results->fetch_assoc()) {
                // echo "rrr2";

                $row__ = json_decode($row['InvoiceClient_Info'], true);

                array_push($all_clients, $row__);
            }
        }
    }



    if (!empty($all_clients)) {
        // print_r($all_clients);
        $same_data = false;
        foreach ($all_clients as $all) {
            if (strcasecmp($all['client-name'], $client_name) === 0 && strcasecmp($all['address-country-code'], $client_country_code) === 0 && strcasecmp($all['client-phone-number'], $client_phone_number) === 0 && strcasecmp($all['client-email'], $client_email) === 0) {
                $same_data = true;
                $response_array['response'] = false;
                $response_array['msg'] = "User alreday exists with the same name phonenumber and email";
            }
        }

        if ($same_data === false) {
            // echo "from all clients";
            if ($client->get_details($client_arr) === true) {
                $response_array['response'] = true;
                $response_array['msg'] = "Client Added Sucessfully";
            }
        } else {
            $response_array['response'] = false;
        }
    } else {
        if ($client->get_details($client_arr) === true) {
            $response_array['response'] = true;
            $response_array['msg'] = "Congratulations ! You have sucessfully added your first client";
        } else {
            $response_array['response'] = false;
            $response_array['msg'] = "Client Already Exists";
        }
    }


    echo json_encode($response_array);
}
