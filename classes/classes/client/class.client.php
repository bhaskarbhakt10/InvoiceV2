<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/invoiceV2/config.php';
require_once ROOT_PATH_DB;
require_once ROOT_PATH_DBTABLES;

class Client
{

    private $db;
    private $client_info;
    function __construct()
    {
        $this->db = new Database();
    }

    public function get_details($client_info)
    {
        $this->client_info = $client_info;
        $client_id = $this->client_insert();
        if ($client_id !== false) {
            $sql = "INSERT INTO " . INVOICE_INVOICES . " (invoiceInvoices_ID) VALUES ('" . $client_id . "')";
            // echo $sql;
            $res = $this->db->connect()->query($sql);
            if ($res === true) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function gen_client_ID()
    {
        $sql = "SELECT * FROM " . INVOICE_CLIENT;
        $res = $this->db->connect()->query($sql);
        $id__ = $res->num_rows + 1;
        return "NUIT_CLI_" . $id__;
    }
    public function add_payload()
    {
        $client_arr = $this->client_info;
        date_default_timezone_set(TIMEZONE_IN);
        $date_time = new DateTime();
        $date = $date_time->format('d-m-Y');
        $time = $date_time->format('H:m:s');
        $client_arr['date'] = $date;
        $client_arr['time'] = $time;
        $client_info_json = json_encode($client_arr);
        return $client_info_json;
    }

    public function get_all_clients()
    {
        $sql = "SELECT * FROM " . INVOICE_CLIENT . " WHERE InvoiceClient_IsActive	= '1' ";
        $res = $this->db->connect()->query($sql);
        if ($res->num_rows > 0) {
            return $res;
        } else {
            return false;
        }
    }

    private function client_insert()
    {
        $client_id = $this->gen_client_ID();
        $sql = "INSERT INTO " . INVOICE_CLIENT . "(InvoiceClient_ID, InvoiceClient_Info) VALUES('" . $client_id . "','" . $this->add_payload() . "')";
        $res = $this->db->connect()->query($sql);
        if ($res === true) {
            return $client_id;
        } else {
            return false;
        }
    }

    function get_client_details_by_id($id)
    {
        $sql = "SELECT * FROM " . INVOICE_CLIENT . " WHERE InvoiceClient_IsActive = '1' AND InvoiceClient_ID='" . $id . "'";
        $res = $this->db->connect()->query($sql);
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                return $row;
            }
        } else {
            return false;
        }
    }

    function delClient_by_id($client_id){
        $sql = "UPDATE " . INVOICE_CLIENT . " SET InvoiceClient_IsActive = 0 WHERE InvoiceClient_ID='".$client_id."'";
        $res = $this->db->connect()->query($sql);
        if($res){
            return true;
        }
        else{
            return false;
        }
    }

    function get_client_name_by_id($client_id){
        $sql = "SELECT InvoiceClient_Info FROM ". INVOICE_CLIENT. " WHERE InvoiceClient_ID='$client_id'";
        // echo $sql ;
        $res = $this->db->connect()->query($sql);
        if($res->num_rows > 0){
            while($row = $res->fetch_all()){
                
                foreach( $row as $Row ){
                    foreach($Row as $R);{
                        $this_row = json_decode($R, true);
                        return ($this_row['client-name']);
                    }
                }
            }
        }
    }
}
