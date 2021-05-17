<?php


class Perfil extends Controlador
{

    public function __construct()
    {
        
        $this->modeloLogin = $this->modelo('ModeloLogin');
    } // fin del constructor

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
