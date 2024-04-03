<?php

class Connector {

    private $db_host;
    private $db_name;
    private $db_user;
    private $db_pass;
    private $db_table;
    public $kiki;

   // function __construct($kiki){ 
   //     $this->$kiki = $kiki;
   // 
   // }

    
    public function Create_conn_string(){
        $db_host = 'localhost';
        $db_name = 'api_test';
        $db_pass = '';

        $conn = '"localhost", "root", "", "api_test"';

            return $conn;
    }


   // function get_kiki(){
   //     return $this->kiki;
   // }

}



?>