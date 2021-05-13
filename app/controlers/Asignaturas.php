<?php


class Asignaturas extends Controlador
{

    public function __construct()
    {
        // cargamos el modelo asociado a este controlador
         $this->modeloAsignatura = $this->modelo('ModeloAsignaturas');
         $this->modeloArchivo = $this->modelo('ModeloArchivos');

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

    public function obtenerBloquesAsignatura()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $idAsignatura = $_POST['idAsignatura'];

            $resultado = $this->modeloAsignatura->obtenerBloquesAsignatura($idAsignatura);

            echo json_encode($resultado);

        }

    }

    public function guardarFichero()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

           //insetar el fichero en la base de datos

           $this->modeloArchivo->guardarFichero($_FILES,$_POST);

           
           $nombre = $_POST['idAsignatura']."_".$_FILES['fichero']['name'];
           //$carpeta = "ficherosFactura";
           $carpeta = "ficheros";
           
           $guardado = $_FILES['fichero']['tmp_name'];

           

           if (!file_exists(DOCUMENTOS_PRIVADOS . $carpeta)) {
               mkdir(DOCUMENTOS_PRIVADOS . $carpeta, 0777, true);
               if (file_exists(DOCUMENTOS_PRIVADOS . $carpeta)) {
                   if (move_uploaded_file($guardado, DOCUMENTOS_PRIVADOS . $carpeta . '/' . $nombre)) {
                       $confirma = true;
                   } else {
                       $confirma = false;
                   }
               }
           } else {
               if (move_uploaded_file($guardado, DOCUMENTOS_PRIVADOS . $carpeta . '/' . $nombre)) {
                   $confirma = true;
               } else {
                   $confirma = false;
               }
           }

        }


    }

    public function getDocumentosByIdAsignatura()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {


            $idAsignatura = $_POST['idAsignatura'];

            $resultado = $this->modeloArchivo->getDocumentosByIdAsignatura($idAsignatura);

            echo json_encode($resultado);

        }

    }

    public function addFavorito()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            session_start();

            $idAsignatura = $_POST['idAsignatura'];
            $favorito = $_POST['favorito'];
            $idUsuario = $_SESSION['id_usuario'];

            if($favorito == 1){
                $this->modeloAsignatura->addFavorito($idAsignatura,$idUsuario);
            }else{
                $this->modeloAsignatura->deleteFavorito($idAsignatura,$idUsuario);
            }

        }

        echo true;

    }

    public function comprobarFavorito()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            session_start();

            $idAsignatura = $_POST['idAsignatura'];
            $idUsuario = $_SESSION['id_usuario'];

            $resultado = $this->modeloAsignatura->comprobarFavorito( $idAsignatura, $idUsuario);

            echo json_encode($resultado);

        }

    }



    
   

} // fin de la clase
