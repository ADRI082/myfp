<?php
define("DB_CHARSET", "utf8");

class ConectarDT {
    protected $user = DB_USUARIO;
    public $db;
    protected $pass = DB_PASSWORD;
   
    public function __construct() {

        $this->db = new PDO('mysql:host=dataleanmakers.com.es:3306;dbname='.DB_NOMBRE, $this->user, $this->pass);
        return $this->db;

    }


    /*protected $user = "root";
    public $db;
    protected $pass = "";

    public function __construct() {

    $this->db = new PDO('mysql:host=localhost;dbname=test_informa_local', $this->user, $this->pass);
    return $this->db;

    }*/

}
