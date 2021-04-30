<?php


class Calendario extends Controlador
{

    public function __construct()
    {
        // cargamos el modelo asociado a este controlador
        $this->Calendario = $this->modelo('ModeloCalendario');
    }
    public function index()
    {

        $this->iniciar();
        $clientes = $this->Calendario->obtenerClientes();
        $agente = $this->Calendario->obtenerAgentes();
        $terminado = $this->Calendario->obtenerEventosTerminado();
        $pendiente = $this->Calendario->obtenerEventosPendiente();
        $enproceso = $this->Calendario->obtenerEventosEnproceso();
        $todo = $this->Calendario->obtenerEventosTodo();
        $hoy = $this->Calendario->obtenerEventosHoy();
        $datos = [
            'clientes' => $clientes,
            'agente' => $agente,
            'terminado' => $terminado,
            'pendiente' => $pendiente,
            'enproceso' => $enproceso,
            'todo' => $todo,
            'hoy' => $hoy
        ];    
             
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
            $this->vista('agenda/calendario', $datos);
        }
        
    }
    public function getAcciones()
    {
        
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            // empresa
            $salidaEmpresa = "";
            if(!empty($_POST['empresa'])){
                $empresa= $_POST['empresa'];
            $salidaEmpresa = " AND idEMPRESA IN (";
            for ($i=0; $i <count($empresa) ; $i++) { 
                if($i != (count($empresa)-1)){
                    $salidaEmpresa .=  $empresa[$i] . ",";
                } else {
                    $salidaEmpresa .=  $empresa[$i] . ")";
                }
            }
         } 
        //  agente
         $salidaAgente = "";
         if(!empty($_POST['agente'])){
             $agente= $_POST['agente'];
         $salidaAgente = " AND evento.codagente IN (";
         for ($i=0; $i <count($agente) ; $i++) { 
             if($i != (count($agente)-1)){
                 $salidaAgente .=  $agente[$i] . ",";
             } else {
                 $salidaAgente .=  $agente[$i] . ")";
             }
         }
      } 
          //   ESTADO   
          $salidaEstado = "";
          if(!empty($_POST['estado'])){
              $estado = $_POST['estado'];
              for ($i=0; $i < count($estado) ; $i++) {   

                  $salidaEstado = " AND estado IN (";
                  for ($i=0; $i <count($estado) ; $i++) { 
                      if($i != (count($estado)-1)){
                          $salidaEstado .=  "'" . $estado[$i] . "'" . ",";
                      } else {
                          $salidaEstado .=   "'" . $estado[$i] . "'". ")";
                      }
                  }
                                
             }
          }
        $salida = $salidaEmpresa.$salidaAgente.$salidaEstado;
       
         $acciones = $this->Calendario->obtenerAcciones($salida);       
         echo json_encode($acciones);
           
        }
        else {
        $salida = "";
        $acciones = $this->Calendario->obtenerAcciones($salida);       
        echo json_encode($acciones);
    }
      
    }
 
    public function getAccionUpdate()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $id = $_POST['id'];
        }
        $acciones = $this->Calendario->obtenerAccionUpdate($id);
        echo json_encode($acciones);
    }

    public function getHistorico()
    {
       

        $historico = $this->Calendario->getHistorico();

        $salida = '<div class="time-label">'
						.'<span class="bg-danger">'
							.'Hoy'
						.'</span>'
                    .'</div>';
        // $cont=0;
		  foreach($historico as $row) {
              $textoEstado="";
              $textoLog="";
              $estado="danger";
             $estadoEvento=$row->cabeceraLog;
             if($estadoEvento == "Nueva Tarea:"){
                 $estado='info';
                
             }else if($estadoEvento == "Modificacion De Tarea:"){
                 $estado='success';
              
             }else if($estadoEvento =="Tarea Eliminada:"){
                 $estado='danger';
              
             }
            $textoEstado=$row->cabeceraLog.'('.$row->actividad.')'.$textoEstado;
			      $salida.='<div>'
						.'<i class="fa fa-envelope bg-'.$estado.'"></i>'
						.'<div class="timeline-item">'
							.'<span class="time"><i class="far fa-clock"></i> '.date_format(date_create($row->fechaLog),"d-m-Y").'</span>'              
							.'<h3 class="timeline-header"><a href="#">'.$textoEstado.'</a></h3>'
                            .'<div class="timeline-body">'                           
              .$textoLog=str_replace("Tarea","Tarea ", str_replace("Fin","<br> Fin ", str_replace("Inicio","<br> Inicio ", str_replace("Estado","<br> Estado ", str_replace("Cliente","<br> Cliente ", str_replace("Tipo Tarea","<br> Tipo Tarea", $row->log))))))
                                .$textoLog

							.'</div>'
						.'</div>'
					.'</div>';
		}
        $salida.='<div>'
					.'<i class="far fa-clock bg-gray"></i>'
				 .'</div>';
        echo $salida;
    }

    public function agregarEvento(){
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
            if($this->Calendario->agregarEvento($datos)){
                $datosAgente = $this->Calendario->getmail($_POST['agente']);
                require '../app/views/Emails/Email.php';
                redireccionar('/calendario');
            } else {
                echo $datos;
                die('Algo salio mal');
            }
        }     
        catch(PDOException $exception){  
        redireccionar('/calendario');
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
            $this->vista('/calendario',$datos);
        }
        }
    }
    // MODIFICAR
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
            if($this->Calendario->actualizarEvento($datos)){             
                redireccionar('/calendario');
            } else {
                die('Algo salio mal');
            }
        }     
        catch(PDOException $exception){  
        redireccionar('/calendario');
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
            $this->vista('/calendario',$datos);
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
                if($this->Calendario->borrarEvento($datos)){
                    redireccionar('/calendario');
                  } else {

                    die('Algo salio mal');
                  }  
               }     
               catch(PDOException $exception){  
               redireccionar('/calendario');
               return $exception->getMessage(); 
             }                    
            
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
            $this->vista('/calendario',$datos);
        }
        }
    }
}
