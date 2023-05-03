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




}