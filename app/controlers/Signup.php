<?php


class SignUp extends Controlador
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

        $this->vista('signup/signup');
    }

    /**
     * Función que registra un usuario y lo inserta en la bbdd
     */

    public function insertarUsuario()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            
            $datos = [];
            foreach ($_POST['form'] as $row) {
                $datos[$row['name']] = $row['value'];
            }

            $salida = '';

            $boleeano = false;
           
            $resultado = $this->modeloLogin->comprobarEmail($datos['email']);

           

            if($resultado){

                $nick = $this->modeloLogin->comprobarNick($datos['nickname']);

                $boleeano = true;

                if($nick){
                    $this->modeloLogin->insertarUsuario($datos);
                    $salida = 'Usuario creado correctamente!';
                }else{
                    $salida = 'Este nickname ya ha sido cogido, prueba con otro ;)';
                    $boleeano = false;
                }


            }else{
                $salida = 'Este email ya existe! Si has olvidado la contraseña, mala suerte :)';
            }


            $salidas = [
                'salida' => $salida,
                'booleano' => $boleeano
            ];

            echo json_encode($salidas);

        }
    }
} // fin de la clase
