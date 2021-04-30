<?php


class Representante extends Controlador
{

    public function __construct()
    {
        $this->Representante = $this->modelo('ModeloRepresentante');

    }
    public function index()
    {

        $this->iniciar();
        $clientes = $this->Representante->obtenerClientes();
        $datos = [
            'clientes' => $clientes,       
        ]; 
        
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
          redireccionar('/login');
        } else {
          $this->vista('representante/representante', $datos);
        }
    }
    public function getRepresentante()
    {

        $representante = $this->Representante->obtenerRepresentante();

        echo $representante;
    }
    // AÑADIR
    public function agregarRepresentante()
    {

        if($_SERVER['REQUEST_METHOD'] == "POST"){
               
            $datos = [
                "idEMPRESA" => $_POST['empresa'],
                "nombre" => $_POST['nombre'],
                "nif" => $_POST['nif'],
                "telefono" => $_POST['telefono'],
                "movil" => $_POST['movil'],
                "email" => $_POST['email'],

            ];
             try{

            if($this->Representante->agregarRepresentante($datos)){
             
                redireccionar('/representante');

            } else {
                
                die('Algo salio mal');
            }
        }  

        catch(PDOException $exception){  
   
        redireccionar('/representante');

        return $exception->getMessage();                        
     
       }

        } else {

        $datos = [
            "idEMPRESA" => "",
                "nif" => "",
                "telefono" => "",
                "movil" => "",
                "email" => "",
                "nombre" => ""
           
        ];

        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){

            redireccionar('/login');
        } else {
            $this->vista('/representante',$datos);
        }

        }
    }
        // Editar
        public function editarRepresentante()
        {
    
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                   
                $datos = [
                    "id" => $_POST['id'],
                    "idEMPRESA" => $_POST['empresaEdit'],
                    "nombre" => $_POST['nombreEdit'],
                    "nif" => $_POST['nifEdit'],
                    "telefono" => $_POST['telefonoEdit'],
                    "movil" => $_POST['movilEdit'],
                    "email" => $_POST['emailEdit'],
    
                ];
                 try{
    
                if($this->Representante->editarRepresentante($datos)){
               
                redireccionar('/representante');
    
                } else {
                    
                    die('Algo salio mal');
                }
            }  
    
            catch(PDOException $exception){  
       
            redireccionar('/representante');
    
            return $exception->getMessage();                        
         
           }
    
            } else {
    
            $datos = [
                   "idEMPRESA" => "",
                    "nif" => "",
                    "telefono" => "",
                    "movil" => "",
                    "email" => "",
                    "nombre" =>""
               
            ];
    
            if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
    
                redireccionar('/login');
            } else {
                $this->vista('/representante',$datos);
            }
    
            }
        }
    //   PARA MODAL DE EDITAR
  public function getRepresentanteUpdate()
  {
      if($_SERVER['REQUEST_METHOD'] == "POST"){
          $id = $_POST['id'];
      }
      $fila = $this->Representante->getRepresentanteUpdate($id);
      echo json_encode($fila);

  }
  public function borrarRepresentante()
  {

      if ($_SERVER['REQUEST_METHOD'] == "POST") {

          if (isset($_POST['id']) && $_POST['id'] != '') {

              $datos = [
                  "id" => $_POST['id']
              ];
              try {
                  if ($this->Representante->borrarRepresentante($datos)) {
                      redireccionar('/representante');
                  } else {
                      die('Algo salio mal');
                  }
              } catch (PDOException $exception) {
                  redireccionar('/representante');
                  return $exception->getMessage();
              }
          } else {
              die('Elige el representante para eliminar');
          }
      } else {
          $datos = [
              "id" => ''
          ];
          if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
              redireccionar('/login');
          } else {
              $this->vista('/representante', $datos);
          }
      }
  }
    
  
}