<?php

class Paginas extends Controlador
{

    public function __construct()
    {
        // echo  "Controlador paginas cargado";
        $this->usuarioModelo = $this->modelo('Usuario');
        
    }

    public function index()
    {
        
        //Obtener los usuarios
        $this->iniciar();

        $usuarios = $this->usuarioModelo->obtenerUsuarios();

        $datos = [
            'usuarios' => $usuarios,
        ];
      

        if(isset($_SESSION['autorizado']) || $_SESSION['autorizado'] == 1){
            $this->vista('paginas/inicio', $datos);
        } else {
            redireccionar('/login');
            
        }
        
       
    }


    public function agregar()
    {
        
        $this->iniciar();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                "nombre" => trim($_POST['nombre']),
                "mail" => trim($_POST['mail']),
                "telefono" => trim($_POST['telefono']),
                "password" => trim($_POST['password']),
                "rol" => trim($_POST['rol'])

            ];

            if ($this->usuarioModelo->agregarUsuario($datos)) {
                redireccionar('/paginas');
            } else {
                die('Algo salio mal');
            }
        } else {
            $datos = [
                "nombre" => '',
                "mail" => '',
                "telefono" => ''
            ];
            if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
                redireccionar('/login');
            } else {
              
                $this->vista('paginas/agregar', $datos);
            }
            
        }
    }


    public function editar($id)
    {
        $this->iniciar();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                "id_usuario" => $id,
                "nombre" => trim($_POST['nombre']),
                "mail" => trim($_POST['mail']),
                "telefono" => trim($_POST['telefono'])
            ];

            if ($this->usuarioModelo->actualizarUsuario($datos)) {
                redireccionar('/paginas');
            } else {
                die('Algo salio mal');
            }
        } else {

            //obtener informacion del usuario desde el modelo
            $usuario = $this->usuarioModelo->obtenerUsuarioId($id);


            $datos = [
                "id_usuario" => $usuario->id_usuario,
                "nombre" => $usuario->nombre,
                "mail" => $usuario->mail,
                "telefono" => $usuario->telefono
            ];
            

            if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
                redireccionar('/login');
            } else {
              
                $this->vista('paginas/editar', $datos);
            }
           
        }
    }


    public function borrar($id)
    {
        $this->iniciar();
        //obtener informacion del usuario desde el modelo
        $usuario = $this->usuarioModelo->obtenerUsuarioId($id);


        $datos = [
            "id_usuario" => $usuario->id_usuario,
            "nombre" => $usuario->nombre,
            "mail" => $usuario->mail,
            "telefono" => $usuario->telefono
        ];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                "id_usuario" => $id
            ];

            if ($this->usuarioModelo->borrarUsuario($datos)) {
                redireccionar('/paginas');
            } else {
                die('Algo salio mal');
            }
        }
    
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
          
            $this->vista('paginas/borrar', $datos);
        }
     
    }
}
