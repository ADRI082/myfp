<?php


class Configuracion extends Controlador
{
    public function __construct()
    {
        $this->ModeloConfiguracion = $this->modelo('ModeloConfiguracion');
    }


    public function rgpd()
    {
        $this->iniciar();

        $rgpd = $this->ModeloConfiguracion->obtenerRGPD();


        if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
            redireccionar('/login');
        } else {

            $this->vista('/rgpd/rgpd',$rgpd);
        }

    }


    public function editarRGPD()
    {
        
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datosPost = $_POST;
        }

        $datos = [
            "id" => $datosPost['id'],
            "tabla" => $datosPost['tabla'],
            "campo" => $datosPost['campo'],
            "valor" => $datosPost['valor'],
            "pk" => $datosPost['pk']
        ];

        $this->ModeloConfiguracion->actualizarDatosRGPD($datos);
    }



}