<?php


class AsignaturasUsuario extends Controlador
{

    public function __construct()
    {
        // cargamos el modelo asociado a este controlador
        $this->modeloAsignatura = $this->modelo('ModeloAsignaturas');
    } // fin del constructor


    /**
    * Función en la que el controlador entra por defecto para poder cargar las vistas y los datos necesarios para mostrar en la vista deseada.
    */
    public function index()
    {

        //Obtener los usuarios
        $this->iniciar();

        $datos = [
            "id" => $_SESSION['id_usuario']
        ];

        if (isset($_SESSION['autorizado']) || $_SESSION['autorizado'] == 1) {
            $this->vista('asignatura/asignaturasUsuario',$datos);
        } else {
            redireccionar('/login');
        }
    } // fin de la fucnion index

    /**
     * Función en la que se obtiene las asignaturas favoritas de un usuario
     */
    public function getAsignaturasFavoritas()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

           $asignaturas = $this->modeloAsignatura->getAsignaturasFavoritas($_POST['idUsuario']);

           echo json_encode($asignaturas);
        }
    }


} // fin de la clase
