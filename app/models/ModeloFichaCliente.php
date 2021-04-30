<?php


class ModeloFichaCliente{

    private $db;


    public function __construct(){
        $this->db = new Base;
    }

    public function buscadorClientes(){
        $this->db->query('SELECT idEMPRESA as idEmpresa , NOMBREJURIDICO as nombre FROM empresasclientes;');
        $resultado = $this->db->registros();
        return $resultado;
    }
    public function obtenerAsesores($id){
        $this->db->query('SELECT * FROM asesores 
        WHERE idEMPRESA = :id;');
        $this->db->bind(':id', $id);
        $resultado = $this->db->registros();
        return $resultado;
    }
    public function obtenerContactos($id){
        $this->db->query('SELECT * FROM contactos
        WHERE idEMPRESA = :id;');
        $this->db->bind(':id', $id);
        $resultado = $this->db->registros();
        return $resultado;
    }
    public function obtenerRepresentante($id){
        $this->db->query('SELECT * FROM representante
        WHERE idEMPRESA = :id;');
        $this->db->bind(':id', $id);
        $resultado = $this->db->registros();
        return $resultado;
    }
   
    public function obtenerEmpresaCliente($id){
        $this->db->query('SELECT *, IF(RLT=0,"No","Si") as RLTT,  IF(Convenio=0,"No","Si") as CONVENIO  from empresasclientes e
        LEFT JOIN actividadesempresariales act ON e.CODACTIVIDAD = act.CODCNAE 
        LEFT JOIN sectores s ON e.CODSECTOR = s.CODSECTOR 
        LEFT JOIN grupos g on g.idGrupo = e.idGrupo
        WHERE e.idEMPRESA = :id');
        $this->db->bind(':id', $id);
        $fila = $this->db->registro();
        return $fila;
    }

    public function obtenerColaboradores($id){

        $this->db->query('SELECT cli.idEMPRESA, cli.NOMBREJURIDICO, col.* FROM colaboradores col
                        LEFT JOIN colaboradoresN con ON col.codColaborador=con.idColaborador
                        LEFT JOIN empresasclientes cli ON con.idEMPRESA=cli.idEMPRESA
                        WHERE cli.idEMPRESA='.$id);  
        $resultado = $this->db->registros();
        return $resultado;
    }

    public function verObservacionesFichaCliente($id){
        $this->db->query('SELECT o.contenido ,o.fecha ,o.idEMPRESA ,o.idObservacion ,o.titulo ,
        concat(a.Nombre," ",a.Apellidos) AS agente FROM observacionesfichacliente o
        LEFT JOIN agentes a ON o.idAgente = a.codagente WHERE o.idEMPRESA = :id order by o.fecha DESC;');
        $this->db->bind(':id', $id);
        $resultado = $this->db->registros();
        return $resultado;
    }
    public function verHistoricoEmailCliente($id){
        $this->db->query('SELECT * FROM emailCliente LEFT JOIN empresasclientes 
        ON empresasclientes.idEMPRESA = emailCliente.idEMPRESA 
        WHERE empresasclientes.idEMPRESA = :id;');
        $this->db->bind(':id', $id);
        $resultado = $this->db->registros();
        return $resultado;
    }

    public function verHistroricoEventos($id){
        $this->db->query('SELECT e.idEvento ,e.idEMPRESA ,e.estado ,e.contenido,e.actividad ,e.start,e.end,
         concat(a.Nombre ," ", a.Apellidos ) AS codagente
        from evento e LEFT JOIN agentes a ON e.codagente = a.codagente WHERE e.idEMPRESA = :id order by e.start asc;');
        $this->db->bind(':id', $id);
        $resultado = $this->db->registros();
        return $resultado;
    }

    public function veragenteInputObservaciones(){
        $this->db->query('SELECT codagente, Nombre, Apellidos FROM agentes;');
        $resultado = $this->db->registros();
        return $resultado;
    }

    public function insertarObservaciones($datos){
        $this->db->query("INSERT INTO observacionesfichacliente (idEMPRESA ,fecha ,idAgente ,titulo,contenido ) VALUES
        (:idEMPRESA,:fecha,:idAgente,:titulo,:contenido);");
        // vincular valores
        $this->db->bind(':idEMPRESA', $datos['id']);
        $this->db->bind(':fecha', $datos['fecha']);
        $this->db->bind(':idAgente', $datos['agente']);
        $this->db->bind(':titulo', $datos['titulo']);
        $this->db->bind(':contenido', $datos['documento']);
        //Ejecutar
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }

    }
    public function getEmail($datos){
        $this->db->query("INSERT INTO emailCliente (idEMPRESA ,subject ,contenido,email,fecha,desde,fail ) VALUES
        (:idEMPRESA,:subject,:contenido, :email, :fecha, :desde, :fail);");
        // vincular valores
        $this->db->bind(':idEMPRESA', $datos['id']);
        $this->db->bind(':subject', $datos['subject']);
        $this->db->bind(':contenido', $datos['contenido']);
        $this->db->bind(':email', $datos['email']);
        $this->db->bind(':fecha', $datos['fecha']);
        $this->db->bind(':desde', $datos['desde']);
        $this->db->bind(':fail', $datos['fail']);
       
     
    
        //Ejecutar
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
      }
      public function obtenerDetalleEmail($id){
        $this->db->query('SELECT *, DATE_FORMAT(fecha, "%d %M %Y") as fechaa FROM emailCliente WHERE idEmail='.$id);  
        $resultado = $this->db->registro();
        
        $emails = json_decode($resultado->email);
        $resultado->emails = $emails;
        return $resultado;
    }

}