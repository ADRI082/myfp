<?php

require '../public/vendor/autoload.php';

class Login extends Controlador{

    

    public function __construct(){
       $this->loginModelo = $this->modelo('ModeloLogin');

    }

     /**
    * Función en la que el controlador entra por defecto para poder cargar las vistas y los datos necesarios para mostrar en la vista deseada.
    */

    public function index(){
       
               $this->vista('login/login');
 
    }

    /**
     * Función en la que se comprueba si existe un usuario en la bbdd
     */

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


    /**
     * Función que te lleva a la vista en la que se resetea la contraseña
     */
    public function resetPassword()
    {

        $this->vista('login/resetPassword');

    }

    /**
     * Función en la que se resetea la contraseña del usuario mandándole una contraseña autogenerada al correo especificado por el usuario
     */

    public function resetearPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $email = $_POST['email'];

            $nombreRemitente = $_SESSION['nombre'];
            $emailRemitente = 'adrian.beigveder@dataleanmakers.es';
            $asunto = "Reseteo de contraseña";
            $emailsDestino = $email;

            $newPass = $this->generateRandomString(9);

             //construyo cuerpo de mensaje
            $message = "Buenas, aquí le enviamos su contraseña nueva para que pueda volver a entrar a la plataforma. Su contraseña nueva es: $newPass";

            $envio = enviarEmail::enviarEmailDestinatario($nombreRemitente, $emailRemitente, $emailsDestino, $asunto, $message,'', '', '');

            $this->loginModelo->resetearPassword($newPass,$emailsDestino);

        }
    }

    /**
     * Función que hace el deslogueo del usuario
     */

    public function vaciar(){
        session_unset();
        session_destroy();
        redireccionar('/login');
    }

    /**
     * Función que genera Strings de forma aleatoria
     */

    function generateRandomString($length = 25) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

   

    
}