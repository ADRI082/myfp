<?php


class EventosCalendario extends Controlador
{



    public function __construct()
    {
        $this->EventosCalendario = $this->modelo('ModeloEventoCalendario');

    }
 

    public function index(){
        $this->iniciar();
        $clientes = $this->EventosCalendario->obtenerClientes();
        $agente = $this->EventosCalendario->obtenerAgentes();

        $datos = [
            'clientes' => $clientes,
            'agente' => $agente
       
        ];    
        
             
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
            $this->vista('eventosCalendario/eventosCalendario', $datos);
        }
    
      }
   
    public function getAcciones()
    {

        $acciones = $this->EventosCalendario->obtenerAcciones();

        echo $acciones;
    }
    
    public function getAccionUpdate()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $id = $_POST['id'];
        }
        $acciones = $this->EventosCalendario->obtenerAccionUpdate($id);
        echo json_encode($acciones);
    }
    // AGREGAR
    public function agregarEvento()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $inicio = $_POST['inicio'];
            $iniciotime = $_POST['iniciotime'];
            $fin = $_POST['fin'];
            $fintime = $_POST['fintime'];
            if ($_POST['estado'] == "Pendiente"){
                $color = "red";
            }else if($_POST['estado'] == "En Proceso"){
                $color = "orange"; 
            } else{
                $color = "green";
            }
            $fecha_actual = date("Y-m-d");
            $start = $inicio.' '.$iniciotime.':00';
            $end = $fin.' '.$fintime.':00'; 
            $datos = [
                "idCliente" => $_POST['idCliente'],
                "actividad" => $_POST['actividad'],
                "agente" => $_POST['agente'],
                "canalComunicacion" => $_POST['canal'],
                "estado" => $_POST['estado'],
                "inicio" => $start,  
                "fin" => $end,
                "color" => $color,
                "contenido" => $_POST['contenido'],
                "log" =>"Nueva Tarea:",
                "date" =>$fecha_actual
            ];
             try{
            if($this->EventosCalendario->agregarEvento($datos)){
                $datosAgente = $this->EventosCalendario->getmail($_POST['agente']);
                require '../app/views/Emails/Email.php';
                redireccionar('/eventosCalendario');
            } else {
                echo $datos;
                die('Algo salio mal');
            }
        }     
        catch(PDOException $exception){  
        redireccionar('/eventosCalendario');
        return $exception->getMessage();                            
       }
        } else {
        $datos = [
            "idCliente" => "",
            "actividad" => "",
            "agente" => "",
            "estado" => "",
            "inicio" => "",  
            "fin" => "",
            "contenido" => ""          
        ];
         if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
            $this->vista('/eventosCalendario',$datos);
        }
        }
    }
    // ACTUALIZAR
    public function actualizarEvento()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $fecha_actual = date("Y-m-d");
            $inicio = $_POST['inicioEdit'];
            $iniciotime = $_POST['iniciotimeEdit'];
            $fin = $_POST['finEdit'];
            $fintime = $_POST['fintimeEdit'];
            if ($_POST['estadoEdit'] == "Pendiente"){
                $color = "red";
            }else if($_POST['estadoEdit'] == "En Proceso"){
                $color = "orange"; 
            } else{
                $color = "green";
            }
            $start = $inicio.' '.$iniciotime.':00';
            $end = $fin.' '.$fintime.':00'; 
            $datos = [
                "id" => $_POST['id'],
                "idCliente" => $_POST['idClienteEdit'],
                "actividad" => $_POST['actividadEdit'],
                "codagente" => $_POST['agenteEdit'] ,
                "estado" => $_POST['estadoEdit'],
                "canalComunicacion" => $_POST['canalEdit'],
                "start" => $start ,
                "end" => $end,
                "color" => $color,
                "contenido" => $_POST['contenidoEdit'],
                "date" =>$fecha_actual,
                "log" =>"Modificacion De Tarea:"       
            ];
        try{          
            if($this->EventosCalendario->actualizarEvento($datos)){             
                redireccionar('/eventosCalendario');
            } else {
                die('Algo salio mal');
            }
        }     
        catch(PDOException $exception){  
        redireccionar('/eventosCalendario');
        return $exception->getMessage();                         
       } 
        } else {
          $datos = [
            "id" => "",
            "idCliente" => "",
            "actividad" => "",
            "codagente" => "",
            "estado" => "",
            "start" => "" ,
            "end" => "",
            "contenido" => "",
            
          ];
          if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
            $this->vista('/eventosCalendario',$datos);
        }
        }
    }
    // ELIMINAR
    public function borrarEvento()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            if( isset($_POST['idDelete']) && $_POST['idDelete'] != ''){
              $fecha_actual = date("Y-m-d");
              $datos = [
                "id" => $_POST['idDelete'],
                "date" =>$fecha_actual
              ];
              try
              {         
                if($this->EventosCalendario->borrarEvento($datos)){
                    redireccionar('/eventosCalendario');
                  } else {

                    die('Algo salio mal');
                  }  
               }     
               catch(PDOException $exception){  
               redireccionar('/eventosCalendario');
               return $exception->getMessage();      }                    
            
              } else {
              die('Elige el evento para eliminar');
              }
        } else {
        $datos = [
            "id" => '', 
        ];
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
            $this->vista('/eventosCalendario',$datos);
        }
        }
    }

 


}
