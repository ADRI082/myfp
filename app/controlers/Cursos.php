<?php


class Cursos extends Controlador
{

    public function __construct()
    {
        // cargamos el modelo asociado a este controlador
         $this->modeloCursos = $this->modelo('ModeloCursos');
    } // fin del constructor


    /**
    * Función en la que el controlador entra por defecto para poder cargar las vistas y los datos necesarios para mostrar en la vista deseada.
    */
    public function index()
    {

        //Obtener los usuarios
        $this->iniciar();

        $cursos = $this->modeloCursos->buscadorCursos();

        $datos = [
            "cursos" => $cursos
        ];


        if (isset($_SESSION['autorizado']) || $_SESSION['autorizado'] == 1) {
            $this->vista('cursos/cursos', $datos);
        } else {
            redireccionar('/login');
        }
    } // fin de la fucnion index

    
    
} // fin de la clase
