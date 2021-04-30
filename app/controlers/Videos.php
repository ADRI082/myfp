<?php

class Videos extends Controlador{

    public function __construct(){
        $this->Videos = $this->modelo('ModeloVideo');
    }

    public function index(){
        $this->iniciar();
        $info = $this->Videos->obtenerObservaciones();
        $datos = [
            'info' => $info
        ];

        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
            $this->vista('/videos/videos', $datos);
        }
    }

    public function guardarObservaciones()
    {
        //echo"entra a guardarObservaciones";
        $datos = [
            'oportunidad' => $_POST['oportunidad'],
            'clientes' => $_POST['clientes'],
            'acciones' => $_POST['acciones'],
            'agentes' => $_POST['agentes'],
        ];
        //print_r($datos);
        $this->Videos->guardarObservaciones($datos);
        redireccionar('/Videos');
    }
}