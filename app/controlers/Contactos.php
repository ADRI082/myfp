<?php


class Contactos extends Controlador
{

    public function __construct()
    {
        $this->Contactos = $this->modelo('ModeloContacto');

    }
    public function index()
    {

        $this->iniciar();
        $clientes = $this->Contactos->obtenerClientes();
        $datos = [
            'clientes' => $clientes,       
        ]; 
        
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
          redireccionar('/login');
        } else {
          $this->vista('contactos/contactos', $datos);
        }
    }
    public function getContacto()
    {
        $contacto = $this->Contactos->obtenerContacto();
        echo $contacto;
    }
 // PARA MODAL DE EDITAR
  public function getContactoUpdate()
  {
      if($_SERVER['REQUEST_METHOD'] == "POST"){
          $id = $_POST['id'];
      }
      $fila = $this->Contactos->getContactoUpdate($id);
      echo json_encode($fila);

  }
     // AÑADIR
     public function agregarContacto()
     {
 
         if($_SERVER['REQUEST_METHOD'] == "POST"){
                
             $datos = [
                 "idEMPRESA" => $_POST['empresa'],
                 "nombre" => $_POST['nombre'],
                 "areaDpto" => $_POST['areaDpto'],
                 "direccion" => $_POST['direccion'],
                 "telefono" => $_POST['telefono'],
                 "movil" => $_POST['movil'],
                 "email" => $_POST['email'],
 
             ];
                          
              try{
 
             if($this->Contactos->agregarContacto($datos)){
                 redireccionar('/contactos');
 
             } else {
                 
                 die('Algo salio mal');
             }
         }  
 
         catch(PDOException $exception){  
    
         redireccionar('/contactos');
 
         return $exception->getMessage();                        
      
        }
 
         } else {
 
         $datos = [
                 "idEMPRESA" => "",
                 "direccion" => "",
                 "telefono" => "",
                 "movil" => "",
                 "email" => "",
                 "nombre" => ""
            
         ];
 
         if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
 
             redireccionar('/login');
         } else {
             $this->vista('/contactos',$datos);
         }
 
         }
     }
     
       // Editar
       public function editarContacto()
       {
   
           if($_SERVER['REQUEST_METHOD'] == "POST"){
                  
               $datos = [
                   "id" => $_POST['id'],
                   "idEMPRESA" => $_POST['empresaEdit'],
                   "nombre" => $_POST['nombreEdit'],
                   "areaDpto" => $_POST['areaDptoEdit'],
                   "direccion" => $_POST['direccionEdit'],
                   "telefono" => $_POST['telefonoEdit'],
                   "movil" => $_POST['movilEdit'],
                   "email" => $_POST['emailEdit'],
   
               ];
               
                try{
   
               if($this->Contactos->editarContacto($datos)){
              
               redireccionar('/contactos');
   
               } else {
                   
                   die('Algo salio mal');
               }
           }  
   
           catch(PDOException $exception){  
      
           redireccionar('/contactos');
   
           return $exception->getMessage();                        
        
          }
   
           } else {
   
           $datos = [
                  "idEMPRESA" => "",
                   "direccion" => "",
                   "telefono" => "",
                   "movil" => "",
                   "email" => "",
                   "nombre" =>""
              
           ];
   
           if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
   
               redireccionar('/login');
           } else {
               $this->vista('/contactos',$datos);
           }
   
           }
       }

       public function borrarContacto()
       {
     
           if ($_SERVER['REQUEST_METHOD'] == "POST") {
     
               if (isset($_POST['id']) && $_POST['id'] != '') {
     
                   $datos = [
                       "id" => $_POST['id']
                   ];
                   try {
                       if ($this->Contactos->borrarContacto($datos)) {
                           redireccionar('/contactos');
                       } else {
                           die('Algo salio mal');
                       }
                   } catch (PDOException $exception) {
                       redireccionar('/contactos');
                       return $exception->getMessage();
                   }
               } else {
                   die('Elige el contacto para eliminar');
               }
           } else {
               $datos = [
                   "id" => ''
               ];
               if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
                   redireccionar('/login');
               } else {
                   $this->vista('/contactos', $datos);
               }
           }
       }
}