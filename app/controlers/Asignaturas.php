<?php


class Asignaturas extends Controlador
{

    public function __construct()
    {
        // cargamos el modelo asociado a este controlador
         $this->modeloAsignatura = $this->modelo('ModeloAsignaturas');
    } // fin del constructor

    public function index()
    {

        //Obtener los usuarios
        $this->iniciar();

        $datos = $this->modeloAsignatura->obtenerDatosAsignatura($_GET['id']);


        if (isset($_SESSION['autorizado']) || $_SESSION['autorizado'] == 1) {
            $this->vista('asignatura/asignatura', $datos);
        } else {
            redireccionar('/login');
        }
    } // fin de la fucnion index

    public function getAsignaturaByIdCurso()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

    
           $resultado = $this->modeloAsignatura->getAsignaturaByIdCurso($_POST['idCurso']);

            echo json_encode($resultado);

        }
       
    }



    
   

} // fin de la clase
