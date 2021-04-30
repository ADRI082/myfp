<?php


class Roles extends Controlador
{



    public function __construct()
    {
        $this->DatatableRoles = $this->modelo('ModeloRoles');

    }
    
    public function index()
    {

        $this->iniciar();
        
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {

        $this->vista('datatable/roles');

        }
      
    }

    public function getRoles()
    {

        $roles = $this->DatatableRoles->obtenerRoles();

        echo $roles;
    }
    public function getRolesSelect()
    {

        $roles = $this->DatatableRoles->obtenerRolesSelect();

        echo json_encode($roles);
    }


    public function agregarRol(){

        if($_SERVER['REQUEST_METHOD'] == "POST"){
               
            $datos = [
                "rol" => $_POST['rol']      
            ];
             try{

            if($this->DatatableRoles->agregarRol($datos)){

                redireccionar('/roles');

            } else {
                
                die('Algo salio mal');
            }
        }  

        catch(PDOException $exception){  

        redireccionar('/roles');

        return $exception->getMessage();                        
     
       }

        } else {

        $datos = [
            "rol" => ''
           
        ];

        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){

            redireccionar('/login');
        } else {
            $this->vista('/roles',$datos);
        }

        }
    }

    public function actualizarRol(){

        if($_SERVER['REQUEST_METHOD'] == "POST"){

            $datos = [
                "id" => $_POST['id'],
                "rol" => $_POST['rol'],         
            ];
            try
            {  
            if($this->DatatableRoles->actualizarRol($datos)){

                redireccionar('/roles');
            } else {
                die('Algo salio mal');
            }
           }     
           catch(PDOException $exception){  

           redireccionar('/roles');

           return $exception->getMessage();                          
     
       }

        } else {

        $datos = [
            "id" => '',
            "rol" => '',
            
        ];
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){

            redireccionar('/login');
        } else {

           $this->vista('/roles',$datos);
        }

        }
    }
    
    public function borrarRol(){

        if($_SERVER['REQUEST_METHOD'] == "POST"){

            if( isset($_POST['id']) && $_POST['id'] != ''){

              $datos = [
                "id" => $_POST['id']
              ];
              try
              {         
                if($this->DatatableRoles->borrarRol($datos)){
                    redireccionar('/roles');
                  } else {
                    die('Algo salio mal');
                  }  
               }     
               catch(PDOException $exception){  
               redireccionar('/roles');
               return $exception->getMessage();  
                }                    
            
              } else {
              die('Elige el rol para eliminar');
              }

        } else {
        $datos = [
            "id" => '',
            "rol" => '',           
        ];
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
            $this->vista('/roles',$datos);
        }
        }
    }


}