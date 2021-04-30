<?php


class Asesores extends Controlador
{

    public function __construct()
    {
        $this->Asesores = $this->modelo('ModeloAsesores');

    }
    public function index()
    {

        $this->iniciar();
        $clientes = $this->Asesores->obtenerClientes();
        $datos = [
            'clientes' => $clientes,       
        ]; 
        
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
          redireccionar('/login');
        } else {
          $this->vista('asesores/asesores', $datos);
        }
    }
    public function getAsesor()
    {

        $asesor = $this->Asesores->obtenerAsesor();

        echo $asesor;
    }
      // AÑADIR
      public function agregarAsesor()
      {
  
          if($_SERVER['REQUEST_METHOD'] == "POST"){
                 
              $datos = [
                  "idEMPRESA" => $_POST['empresa'],
                  "nombre" => $_POST['nombre'],
                  "contacto" => $_POST['contacto'],
                  "direccion" => $_POST['direccion'],
                  "telefono" => $_POST['telefono'],
                  "movil" => $_POST['movil'],
                  "email" => $_POST['email'],
  
              ];
               try{
  
              if($this->Asesores->agregarAsesor($datos)){
               
                  redireccionar('/asesores');
  
              } else {
                  
                  die('Algo salio mal');
              }
          }  
  
          catch(PDOException $exception){  
     
          redireccionar('/asesores');
  
          return $exception->getMessage();                        
       
         }
  
          } else {
  
          $datos = [
                  "idEMPRESA" => "",
                  "direccion" => "",
                  "telefono" => "",
                  "movil" => "",
                  "email" => "",
                  "nombre" => "",
                  "contacto" => ""
             
          ];
  
          if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
  
              redireccionar('/login');
          } else {
              $this->vista('/asesores',$datos);
          }
  
          }
      }
      
        // Editar
        public function editarAsesor()
        {
    
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                   
                $datos = [
                    "id" => $_POST['id'],
                    "idEMPRESA" => $_POST['empresaEdit'],
                    "nombre" => $_POST['nombreEdit'],
                    "contacto" => $_POST['contactoEdit'],
                    "direccion" => $_POST['direccionEdit'],
                    "telefono" => $_POST['telefonoEdit'],
                    "movil" => $_POST['movilEdit'],
                    "email" => $_POST['emailEdit'],
    
                ];
                 try{
    
                if($this->Asesores->editarAsesor($datos)){
               
                redireccionar('/asesores');
    
                } else {
                    
                    die('Algo salio mal');
                }
            }  
    
            catch(PDOException $exception){  
       
            redireccionar('/asesores');
    
            return $exception->getMessage();                        
         
           }
    
            } else {
    
            $datos = [
                   "idEMPRESA" => "",
                    "direccion" => "",
                    "telefono" => "",
                    "movil" => "",
                    "email" => "",
                    "nombre" =>"",
                    "contacto" => ""
               
            ];
    
            if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
    
                redireccionar('/login');
            } else {
                $this->vista('/asesores',$datos);
            }
    
            }
        }

        public function borrarAsesor()
        {
      
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
      
                if (isset($_POST['id']) && $_POST['id'] != '') {
      
                    $datos = [
                        "id" => $_POST['id']
                    ];
                    try {
                        if ($this->Asesores->borrarAsesor($datos)) {
                            redireccionar('/asesores');
                        } else {
                            die('Algo salio mal');
                        }
                    } catch (PDOException $exception) {
                        redireccionar('/asesores');
                        return $exception->getMessage();
                    }
                } else {
                    die('Elige el asesor para eliminar');
                }
            } else {
                $datos = [
                    "id" => ''
                ];
                if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
                    redireccionar('/login');
                } else {
                    $this->vista('/asesores', $datos);
                }
            }
        }
 //   PARA MODAL DE EDITAR
  public function getAsesorUpdate()
  {
      if($_SERVER['REQUEST_METHOD'] == "POST"){
          $id = $_POST['id'];
      }
      $fila = $this->Asesores->getAsesorUpdate($id);
      echo json_encode($fila);

  }
}