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



    private function get_invoiceInvoices_Info_byID($id)
    {
        $sql = "SELECT `invoiceInvoices_Info` FROM " . INVOICE_INVOICES . " WHERE invoiceInvoices_ID ='".$id."'";
        $res = $this->db->connect()->query($sql);
        if ($res->num_rows > 0) {
            while($row = $res->fetch_assoc()){
                return $row['invoiceInvoices_Info'];
            }
        } else {
            return false;
        }
    }

    public function generate_Performa_number( $id )
    {
        $perfoma_string = "PI/#";
        date_default_timezone_set(TIMEZONE_IN);
        $date = new DateTime();
        if ($date->format('m') <= 6) {
            $financial_year = ($date->format('Y')-1) . '-' . $date->format('y');
        } else {
            $financial_year = $date->format('Y') . '-' . ($date->format('y') + 1);
        }
        if (empty($this->get_invoiceInvoices_Info_byID($id))) {
            $perfoma_number = 1;
            $perfoma_string .= sprintf('%03d', $perfoma_number);
        } else {
            $old_json = $this->get_invoiceInvoices_Info_byID($id);
            $old_array = json_decode($old_json, true);
            $perfoma_number = count($old_array) +1;
            $perfoma_string .= sprintf('%03d', $perfoma_number);
        }
        $perfoma_string .='/'. $financial_year;
        echo $perfoma_string ;
    }

    private function Update_Db($what_to_update,$column_to_update,){
        $sql = "UPDATE " . INVOICE_INVOICES ." SET invoiceInvoices_Info ='".$what_to_update."' WHERE invoiceInvoices_ID='".$column_to_update."'";
        $res = $this->db->connect()->query($sql);
    }

    function update_invoiceInvoices_Info($invoice_data,$id)
    { 
        if(empty($this->get_invoiceInvoices_Info_byID($id))){
            $this->Update_Db($invoice_data,$id);
        }
        else{
            $old_json = $this->get_invoiceInvoices_Info_byID($id);
            $old_array = json_decode($old_json, true) ;
            $new_array = json_decode($invoice_data, true) ;
            $empty_arr = array();
            // print_r($old_array);
            // print_r($new_array);
            array_push($empty_arr,$old_array);
            array_push($empty_arr,$new_array);
            $more_than_one_json = json_encode($empty_arr);
            $this->Update_Db($more_than_one_json,$id);
        }
    }
}
