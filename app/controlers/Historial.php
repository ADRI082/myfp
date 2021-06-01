<?php

class Historial extends Controlador
{

    public function __construct()
    {
        $this->modeloHistorial = $this->modelo('ModeloHistorial');

    } // fin del constructor

     /**
    * Función en la que el controlador entra por defecto para poder cargar las vistas y los datos necesarios para mostrar en la vista deseada.
    */

    public function index()
    {

        //Obtener los usuarios
        $this->iniciar();

        

        if (isset($_SESSION['autorizado']) || $_SESSION['autorizado'] == 1) {
            $this->vista('historial/historial', $datos);
        } else {
            redireccionar('/login');
        }
    } // fin de la fucnion index


    /**
     * Función en la que se obtiene el historial de descargas de archivos de un usuario
     */

    public function getHistorialDescargas()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $resultado = $this->modeloHistorial->getHistorialDescargas();

            echo json_encode($resultado);
        }

    }


    /**
     * Función en la que se obtiene el historial de archivos subidos de un usuario
     */
    public function getHistorialSubidas()
    {

        $resultado = $this->modeloHistorial->getHistorialSubidas();

        echo json_encode($resultado);
        
    }


} // fin de la clase
