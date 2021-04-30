<?php


class ModeloCalendario{

    private $db;

    public function __construct(){
        $this->db = new Base;
    }
    public function obtenerClientes()
    {
    $this->db->query('SELECT idEMPRESA as id, NOMBREJURIDICO  FROM empresasclientes');
    $resultado = $this->db->registros();
    return $resultado;
    }    
    public function obtenerAgentes()
    {
        $this->db->query("SELECT codAgente, concat(Nombre, ' ', Apellidos) as nombre FROM agentes");    
        $resultado = $this->db->registros();   
        return $resultado;
        }
        public function getmail($id){
        
            $this->db->query('SELECT * FROM agentes WHERE codagente = :id');
            $this->db->bind(':id', $id);
    
            $fila = $this->db->registro();
            return $fila;
           
        }
// OBTENER EVENTOS PARA MOSTRAR EN EL CALENDARIO
        public function obtenerAcciones($salida){
            $this->db->query("SELECT idEvento as id, actividad, Nombre, Apellidos, concat(actividad,'-', Nombre, ' ', Apellidos) as title, start, end, color as backgroundColor from evento 
            LEFT JOIN agentes on agentes.codAgente = evento.codAgente WHERE  1=1 ".$salida);   
            $resultado = $this->db->registros();
            return $resultado;           
        }
// SELECT PARA EL MODAL DE EDITAR
        public function obtenerAccionUpdate($id){
            $this->db->query('SELECT * FROM evento WHERE idEvento='.$id);  
            $resultado = $this->db->registros();  
            return $resultado;
        }
// CONTAR LOS NUMEROS DE LOS EVENTOS SEGUN SU ESTADO
    public function obtenereventosTerminado(){
        $this->db->query('SELECT count(*) as terminado  FROM evento WHERE estado = "Terminado"');  
        $resultado = $this->db->registros();   
        return $resultado;
        }
        public function obtenerEventosPendiente(){
            $this->db->query('SELECT count(*) as pendiente  FROM evento WHERE estado = "Pendiente"');       
            $resultado = $this->db->registros();      
            return $resultado;
            }
     public function obtenerEventosEnproceso(){
        $this->db->query('SELECT count(*) as enproceso  FROM evento WHERE estado = "En Proceso"');           
         $resultado = $this->db->registros();            
        return $resultado;
    }
    public function obtenerEventosTodo(){
        $this->db->query('SELECT count(*) as todo  FROM evento');           
         $resultado = $this->db->registros();          
        return $resultado;
    }
    public function obtenerEventosHoy(){
        $this->db->query('SELECT count(*) as hoy  FROM evento WHERE DATE_FORMAT(start, "%Y-%m-%d")=CURDATE()');           
         $resultado = $this->db->registros();           
        return $resultado;
    }      
        public function agregarEvento($datos){
          $this->db->query("INSERT INTO evento (idEMPRESA,actividad,codagente,canalComunicacion, estado,start,
          end,contenido, color) values (:idEMPRESA,:actividad,:codagente, :canalComunicacion, :estado,:start,
          :end, :contenido, :color)");
        // vincular valores
        $this->db->bind(':idEMPRESA', $datos['idCliente']);
        $this->db->bind(':actividad', $datos['actividad']);
        $this->db->bind(':codagente', $datos['agente']);
        $this->db->bind(':canalComunicacion', $datos['canalComunicacion']);
        $this->db->bind(':estado', $datos['estado']);
        $this->db->bind(':start', $datos['inicio']);
        $this->db->bind(':end', $datos['fin']);
        $this->db->bind(':contenido', $datos['contenido']);
        $this->db->bind(':color', $datos['color']);          
            //Ejecutar
            if($this->db->execute()){
                $this->db->query('SELECT ec.NOMBRE as cliente, concat(ag.NOMBRE, " ", ag.APELLIDOS) as usuario  FROM evento ev 
                left join empresasclientes ec on ec.idEMPRESA = ev.idEMPRESA
                left join agentes ag on ag.codagente = ev.codagente 
                where ev.idEvento=(SELECT max(e.idEVENTO) as id FROM evento e)');
    
                $ultimaAccion = $this->db->registros();
                //$ultimaAccion=$ultimaAccion[0];
                $log="Cliente: ".$ultimaAccion[0]->cliente."  Tarea:".$datos['actividad']." Estado:".$datos['estado']." Inicio:".$datos['inicio']." Fin:".$datos['fin']." Usuario:".$ultimaAccion[0]->usuario;
    
                $this->db->query(" INSERT INTO log_cliente (idEMPRESA,actividad,cabeceraLog,log,codagente,fechaLog) VALUES (:idEMPRESA,:actividad,:cabeceraLog,:log,:codagente,:fechaLog)");   
                $this->db->bind(':idEMPRESA', $datos['idCliente']);
                $this->db->bind(':actividad', $datos['actividad']);
                $this->db->bind(':cabeceraLog', $datos['log']);
                $this->db->bind(':log', $log);
                $this->db->bind(':codagente', $datos['agente']);
                $this->db->bind(':fechaLog', $datos['date']);
    
                $this->db->execute();
                return true;
            } else {
                return false;
            }   
        }
    //  ACTUALIZAR EVENTO   
    public function actualizarEvento($datos){
        $this->db->query('UPDATE evento SET idEMPRESA = :idEMPRESA, actividad = :actividad, codagente = :codagente, canalComunicacion = :canalComunicacion, estado = :estado,
        start = :start, end = :end, contenido = :contenido, color = :color WHERE idEvento = :id');
        $this->db->bind(':id', $datos['id']);
        $this->db->bind(':idEMPRESA', $datos['idCliente']);
        $this->db->bind(':actividad', $datos['actividad']);
        $this->db->bind(':codagente', $datos['codagente']);
        $this->db->bind(':canalComunicacion', $datos['canalComunicacion']);
        $this->db->bind(':estado', $datos['estado']);
        $this->db->bind(':start', $datos['start']);
        $this->db->bind(':end', $datos['end']);
        $this->db->bind(':contenido', $datos['contenido']);
        $this->db->bind(':color', $datos['color']);     
        //Ejecutar
        if($this->db->execute()){
       
            $this->db->query('SELECT ec.NOMBRE as cliente, concat(ag.NOMBRE, " ", ag.APELLIDOS) as usuario  FROM evento ev 
            left join empresasclientes ec on ec.idEMPRESA = ev.idEMPRESA
            left join agentes ag on ag.codagente = ev.codagente 
            where ev.idEvento='.$datos['id']);

            $ultimaAccion = $this->db->registros();
            //$ultimaAccion=$ultimaAccion[0];
            $log="Cliente: ".$ultimaAccion[0]->cliente."  Tarea:".$datos['actividad']." Estado:".$datos['estado']." Inicio:".$datos['start']." Fin:".$datos['end']." Usuario:".$ultimaAccion[0]->usuario;

            $this->db->query(" INSERT INTO log_cliente (idEMPRESA,actividad,cabeceraLog,log,fechaLog, codagente) VALUES (:idEMPRESA,:actividad,:cabeceraLog,:log,:fechaLog,:codagente)");   
            $this->db->bind(':idEMPRESA', $datos['idCliente']);
            $this->db->bind(':actividad', $datos['actividad']);
            $this->db->bind(':cabeceraLog', $datos['log']);
            $this->db->bind(':fechaLog', $datos['date'] );
            $this->db->bind(':log', $log);
            $this->db->bind(':codagente', $datos['codagente']);

            $this->db->execute();
            return true;
        }else {
            return false;
        }
    }
    public function borrarEvento($datos){
        $this->db->query('SELECT ec.NOMBRE as cliente, ec.idEMPRESA as id, concat(ag.NOMBRE, " ", ag.APELLIDOS) as usuario, ev.actividad as actividad,
        ev.start as start, ev.end as end, ev.estado as estado, ag.codagente as codagente FROM evento ev
        left join empresasclientes ec on ec.idEMPRESA = ev.idEMPRESA
        left join agentes ag on ag.codagente = ev.codagente where ev.idEvento ='.$datos['id']);

      $datosAccion = $this->db->registros();

      $log="Cliente: ".$datosAccion[0]->cliente." Tarea:".$datosAccion[0]->actividad." Estado:".$datosAccion[0]->estado." Inicio:".$datosAccion[0]->start." Fin:".$datosAccion[0]->end;

      $this->db->query("INSERT INTO log_cliente (idEMPRESA,actividad,cabeceraLog,log,codagente,fechaLog) VALUES (:idEMPRESA,:actividad,:cabeceraLog,:log,:codagente,:fechaLog)");

          $this->db->bind(':idEMPRESA', $datosAccion[0]->id);
          $this->db->bind(':actividad',$datosAccion[0]->actividad);
          $this->db->bind(':cabeceraLog',"Tarea Eliminada:");
          $this->db->bind(':log', $log);
          $this->db->bind(':fechaLog', $datos['date']);
          $this->db->bind(':codagente', $datosAccion[0]->codagente);
    
      
        //Ejecutar
        if($this->db->execute()){
        $this->db->query("Delete from evento where idEvento =".$datos['id']);
              
            //Ejecutar
            if($this->db->execute()){
                return true;

            }else {
                return false;
            }
        }else{
            return false;
        }

    }
    public function getHistorico(){

        $sql = "SELECT * FROM log_cliente";
        $this->db->query($sql);

        $resultado = $this->db->registros();


        return $resultado;
    }

}