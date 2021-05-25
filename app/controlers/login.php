<?php


class Login extends Controlador{

    

    public function __construct(){
       $this->loginModelo = $this->modelo('ModeloLogin');

    }

    public function index(){
       
               $this->vista('login/login');
 
    }

    public function comprobar(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
                $mail = trim($_POST['mail']);
                $password = trim($_POST['password']);
        }

       $usuario = $this->loginModelo->obtenerUsuarioMail($mail,$password);

        if($usuario->email && $usuario->password){
            session_start();
            $_SESSION['id_usuario'] = $usuario->idUsuario;
            $_SESSION['nombre'] = $usuario->nombre;
            $_SESSION['apellidos'] = $usuario->apellido;
            $_SESSION['mail'] = $usuario->email;
            $_SESSION['nickname'] = $usuario->nickname; 
            $_SESSION['rol'] = '1';            
            $_SESSION['autorizado'] = 1;
            $_SESSION["timeout"] = time();
            $_SESSION["duracion"] = 10; // duracion de la session en segundos
            //redireccionar('/paginas');
            // redireccionar('/datatable');
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }   
  
    }

    public function vaciar(){
        session_unset();
        session_destroy();
        redireccionar('/login');
    }

   

    
}