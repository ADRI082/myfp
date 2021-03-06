<?php


class Perfil extends Controlador
{

    public function __construct()
    {
        
        $this->modeloLogin = $this->modelo('ModeloLogin');
    } // fin del constructor
    
     /**
    * Función en la que el controlador entra por defecto para poder cargar las vistas y los datos necesarios para mostrar en la vista deseada.
    */
    public function index()
    {

        //Obtener los usuarios
        $this->iniciar();

        $datos = $this->modeloLogin->getDatosUsuario($_SESSION['id_usuario']);


        if (isset($_SESSION['autorizado']) || $_SESSION['autorizado'] == 1) {
            $this->vista('perfil/perfil', $datos);
        } else {
            redireccionar('/login');
        }
    } // fin de la fucnion index

    /**
     * Función en la que se cambian los datos del usuario.
     */

    public function editarUsuario()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $datos = [];
            foreach($_POST['form'] as $row){
                $datos[$row['name']]=$row['value'];
            }

            $resultado = $this->modeloLogin->updatearUsuario($datos);

            echo json_encode($resultado);

        }
    }



} // fin de la clase
