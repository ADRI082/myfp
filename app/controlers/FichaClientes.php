<?php


class FichaClientes extends Controlador
{

    public function __construct()
    {
        // cargamos el modelo asociado a este controlador
        $this->fichaClienteModelo = $this->modelo('ModeloFichaCliente');
    } // fin del constructor

    public function index()
    {

        //Obtener los usuarios
        $this->iniciar();

        $clientes = $this->fichaClienteModelo->buscadorClientes();

        $datos = [
            "clientes" => $clientes
        ];

        if (isset($_SESSION['autorizado']) || $_SESSION['autorizado'] == 1) {
            $this->vista('fichaCliente/fichaCliente', $datos);
        } else {
            redireccionar('/login');
        }
    } // fin de la fucnion index

    public function buscadorCliente()
    {

       
        $this->iniciar();


        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $salida = [
                "id" => $_POST['id']
            ];
           
             if (isset($_POST['documento'])) {
                // insertamos el documento escrito
                $contenido = [
                    "id" => $_POST['id'],
                    "fecha" => $_POST['fecha'],
                    "agente" => $_POST['agente'],
                    "titulo" => $_POST['titulo'],
                    "documento" => $_POST['documento']
                ];
                
                $this->fichaClienteModelo->insertarObservaciones($contenido);
                
            } 

            $empresaCliente = $this->fichaClienteModelo->obtenerEmpresaCliente($salida['id']);
            $observaciones = $this->fichaClienteModelo->verObservacionesFichaCliente($salida['id']);
            $agentes = $this->fichaClienteModelo->veragenteInputObservaciones();
            $eventos = $this->fichaClienteModelo->verHistroricoEventos($salida['id']);
            $emailCliente = $this->fichaClienteModelo->verHistoricoEmailCliente($salida['id']);
            $representante = $this->fichaClienteModelo->obtenerRepresentante($salida['id']);
            $asesores = $this->fichaClienteModelo->obtenerAsesores($salida['id']);
            $contactos = $this->fichaClienteModelo->obtenerContactos($salida['id']);
            $colaboradores = $this->fichaClienteModelo->obtenerColaboradores($salida['id']);

            
    
            $datos = [
                "empresaCliente" => $empresaCliente,
                "observaciones" => $observaciones,
                "agentes" => $agentes,
                "eventos" => $eventos,
                "emailCliente" => $emailCliente,
                "representante" => $representante,
                "asesores" => $asesores,
                "contactos" => $contactos,
                "colaboradores" => $colaboradores
        
            ];

            if (isset($_SESSION['autorizado']) || $_SESSION['autorizado'] == 1) {
                $this->vista('fichaCliente/editarFicha', $datos);
            } else {
                redireccionar('/login');
            }
        }
    } // fin de la funcion buscadorCliente

    
    // añadir email clientes
    public function agregarEmail(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $fecha_actual = date("Y-m-d");
            $imagen_name = addslashes($_FILES['fichero_usuario']['name']);
            $target="../public/files/".$_FILES['fichero_usuario']['name'];
            $datos = [
                "id" => $_POST['id'],
                "subject" => $_POST['subject'],
                "contenido" => $_POST['contenido'],
                "email" => $_POST['email'],
                "fecha" => $fecha_actual,
                "desde" => $_POST['remitente'],
                "fail" =>  $imagen_name,
                         
            ];
            //    GUARDAR EL ATTACHMENT EN LA CARPETA
            move_uploaded_file($_FILES['fichero_usuario']['tmp_name'], $target);  
             try{
            if($this->fichaClienteModelo->getEmail($datos)){
                require '../app/views/Emails/EnviarEmailClientes.php';
                redireccionar('/FichaClientes');
            } else {
                echo $datos;
                die('Algo salio mal');
            }
        }     
        catch(PDOException $exception){  
        redireccionar('/FichaClientes');
        return $exception->getMessage();                            
       }
        } else {
        $datos = [
            "id" => "",
            "subject" => "",
            "contenido" => "",
            "email" => "",
            "fecha" => "",
            "desde" =>"",       
        ];
        if (isset($_SESSION['autorizado']) || $_SESSION['autorizado'] == 1) {
            $this->vista('fichaCliente/editarFicha', $datos);
        } else {
            redireccionar('/login');
        }
        }
    }
    public function getDetalleEmail()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $id = $_POST['id'];
        }
        $emailDetalle = $this->fichaClienteModelo->obtenerDetalleEmail($id);
        
        echo json_encode($emailDetalle);
    }



} // fin de la clase
