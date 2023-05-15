<?php

class Database{

    private $db_host = "localhost";
    ##local
    private $db_name = "invoicenuit";
    private $db_user = "root";
    private $db_pass = "";
    ##local
    ##live
    // private $db_name = "u595440997_invoice";
    // private $db_user = "u595440997_invoice";
    // private $db_pass = "|Ex9ChXk";

    ##live
    


    private $conn_string ;
    
    function __construct()
    {
        $this->conn_string = new mysqli($this->db_host, $this->db_user, $this->db_pass,$this->db_name);
    }

    function connect(){
        return $this->conn_string;
    }


}
