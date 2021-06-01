<?php

use function GuzzleHttp\json_decode;

class Datatable extends Controlador
{
    public function __construct()
    {
        $this->DatatableModelo = $this->modelo('ModeloDatatable');        
    }

    public function index()
    {
        $this->iniciar();
              
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
            $this->vista('datatable/dashboard');
        }
    }

}
