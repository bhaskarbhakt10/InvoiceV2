<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'/invoiceV2/config.php';
require_once ROOT_PATH_DB;
require_once ROOT_PATH_DBTABLES;

class Client{

    private $db;
    private $client_info;
    function __construct()
    {
        $this->db = new Database();
    }

    public function get_details($client_info){
        $this->client_info = $client_info;
    }

    public function gen_client_ID(){
        $sql = "SELECT * FROM ". INVOICE_CLIENT ;
        echo $sql;
        $res = $this->db->connect()->query($sql);
        print_r($res);
    }

}