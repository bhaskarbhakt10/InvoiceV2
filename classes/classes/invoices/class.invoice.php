<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/invoiceV2/config.php';
require_once ROOT_PATH_DB;
require_once ROOT_PATH_DBTABLES;

class Invoice
{

    private $db;
    private $client_info;
    function __construct()
    {
        $this->db = new Database();
    }

    private function get_all_Details()
    {
        $sql = "SELECT * FROM " . INVOICE_INVOICES;
        $res = $this->db->connect()->query($sql);
        if ($res->num_rows > 0) {
            return $res;
        } else {
            return false;
        }
    }

    function get_all_Details_ByID($id)
    {
        $sql = "SELECT * FROM " . INVOICE_INVOICES . " WHERE invoiceInvoices_ID='" . $id . "'";
        $res = $this->db->connect()->query($sql);
        if ($res->num_rows > 0) {
            return $res;
        } else {
            return false;
        }
    }



    private function get_invoiceInvoices_Info_byID($id)
    {
        $sql = "SELECT `invoiceInvoices_Info` FROM " . INVOICE_INVOICES . " WHERE invoiceInvoices_ID ='" . $id . "'";
        $res = $this->db->connect()->query($sql);
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                return $row['invoiceInvoices_Info'];
            }
        } else {
            return false;
        }
    }

    public function generate_Performa_number($id)
    {
        $perfoma_string = "PI/#";
        date_default_timezone_set(TIMEZONE_IN);
        $date = new DateTime();
        if ($date->format('m') <= 6) {
            $financial_year = ($date->format('Y') - 1) . '-' . $date->format('y');
        } else {
            $financial_year = $date->format('Y') . '-' . ($date->format('y') + 1);
        }
        if (empty($this->get_invoiceInvoices_Info_byID($id))) {
            $perfoma_number = 1;
            $perfoma_string .= sprintf('%03d', $perfoma_number);
        } else {
            $old_json = $this->get_invoiceInvoices_Info_byID($id);
            $old_array = json_decode($old_json, true);
            $perfoma_number = count($old_array) + 1;
            $perfoma_string .= sprintf('%03d', $perfoma_number);
        }
        $perfoma_string .= '/' . $financial_year;
        return $perfoma_string;
    }

    public function newPerfoma()
    {
        $perfoma_string = "PI/#";
        date_default_timezone_set(TIMEZONE_IN);
        $date = new DateTime();
        if ($date->format('m') <= 6) {
            $financial_year = ($date->format('Y') - 1) . '-' . $date->format('y');
        } else {
            $financial_year = $date->format('Y') . '-' . ($date->format('y') + 1);
        }
        
        // DB VALUES //
        $sql = "SELECT invoiceInvoices_Info FROM ". INVOICE_INVOICES ;
        $res = $this->db->connect()->query($sql);
        $empty_array = array();
        if($res->num_rows > 0 ){
            while($row = $res->fetch_assoc()){
                $all_array = json_decode($row['invoiceInvoices_Info'], true);
                // print_r($all_array);
                if(is_countable($all_array)){
                    array_push($empty_array, count($all_array));
                }
            }
        }
        
        if( empty($empty_array)){
            $new_perfoma = 1;
        }
        else{
            $new_perfoma = array_sum($empty_array) +1;
            
        }
        $perfoma_string .= sprintf('%03d', $new_perfoma);
        $perfoma_string .= '/' . $financial_year;
    
        return $perfoma_string;
    }

    private function Update_Db($what_to_update, $column_to_update)
    {
        $sql = "UPDATE " . INVOICE_INVOICES . " SET invoiceInvoices_Info ='" . $what_to_update . "' WHERE invoiceInvoices_ID='" . $column_to_update . "'";
        $res = $this->db->connect()->query($sql);
    }

    function update_invoiceInvoices_Info($invoice_data, $id)
    {
        if (empty($this->get_invoiceInvoices_Info_byID($id))) {
            $this->Update_Db($invoice_data, $id);
            return true;
        } else {
            $old_json = $this->get_invoiceInvoices_Info_byID($id);
            $old_array = json_decode($old_json, true);
            $new_array = json_decode($invoice_data, true);
            // $empty_arr = array();
            // print_r($old_array);
            // print_r($new_array);
            // array_push($empty_arr,$old_array);
            // array_push($empty_arr,$new_array);
            $empty_arr = array_merge($old_array, $new_array);
            // print_r($empty_arr);
            $more_than_one_json = json_encode($empty_arr);
            $res = $this->Update_Db($more_than_one_json, $id);
            return true;
        }
    }


    function getInvoiceId($client_id)
    {
        $Invoice_string = "#";
        date_default_timezone_set(TIMEZONE_IN);
        $date = new DateTime();
        if ($date->format('m') <= 6) {
            $financial_year = ($date->format('Y') - 1) . '-' . $date->format('y');
        } else {
            $financial_year = $date->format('Y') . '-' . ($date->format('y') + 1);
        }
        $results_json = $this->get_invoiceInvoices_Info_byID($client_id);
        $InvoiceNumberArray = array();
        if (!empty($results_json)) {
            $results_arr = json_decode($results_json, true);
            foreach ($results_arr as $res) {
                // print_r($res['invoice_number']);
                if (!empty($res['invoice_number'])) {
                    array_push($InvoiceNumberArray, $res['invoice_number']);
                    // echo "not empty";
                }
                else{
                    // echo "empty";
                }
            }
        }
        // print_r($InvoiceNumberArray);
        if (!empty($InvoiceNumberArray)) {
            $last_invoice_number = end($InvoiceNumberArray);
            $exploded_last_number = explode('/', $last_invoice_number);
            $invoice_prev_number = ltrim($exploded_last_number[0], '#');
            $invoice_number = (int)$invoice_prev_number + 1;
        } else {
            $invoice_number = 1;
        }
        // echo $invoice_number;
        $Invoice_string .= sprintf('%03d', $invoice_number);
        return $Invoice_string . '/' . $financial_year;
    }




    function makeitInvoice($client_id, $unique_id)
    {
        $results = $this->get_all_Details_ByID($client_id);
        // print_r($results);
        if ($results->num_rows > 0) {
            while ($row = $results->fetch_assoc()) {
                $info_json = $row['invoiceInvoices_Info'];
            }
        }

        if (!empty($info_json)) {
            $info_arr = json_decode($info_json, true);
            foreach ($info_arr as $infoKey => $info) {
                if ($info['uniqueID'] === $unique_id) {
                    // print_r("========");
                    $key = $infoKey;
                    // print_r("========");
                }
            }
            // print_r("++++" . $key);
            // print_r($info_arr[$key]['is_perfoma']);
            if ($info_arr[$key]['is_perfoma'] === 1 && $info_arr[$key]['is_invoice'] === 0 && $info_arr[$key]['is_paid'] === 0) {
                $invoice_number__ = $this->getInvoiceId($client_id);
                // print_r(gettype($invoice_number__));
                $info_arr[$key]['is_perfoma'] = 0;
                $info_arr[$key]['is_invoice'] = 1;
                $info_arr[$key]['invoice_number'] = $invoice_number__;
                // print_r($this->getInvoiceId($client_id, $unique_id));
                $info_arr[$key]['is_paid'] = 1;
            }
            // print_r("oooooooooooooooo");
            $infoJson = json_encode($info_arr);
            $this->Update_Db($infoJson, $client_id);
            return true;
        }
    }


    /*
    function replaceArray($client_id, $unique_id){
        $newArray = $this->makeitInvoice($client_id, $unique_id);
        echo "--------------";
        print_r($newArray);
        echo "--------------";
        $oldJSON = $this->get_invoiceInvoices_Info_byID($client_id);
        $oldArray = json_decode($oldJSON, true);
        foreach($oldArray as $key => $old){
            // print_r($old);
            if($old['performa-number'] === $newArray['performa-number']){
                $needle = $key;
            }
        }
       
    }
    */
}
