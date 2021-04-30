<?php


class ModeloPdf{

    private $db;


    public function __construct(){
        $this->db = new Base;
    }

    public function verObservacionesFichaCliente($id){
        $this->db->query('SELECT titulo, concat(agentes.Nombre," ",Apellidos) AS agente, fecha,contenido,empresasclientes.NOMBREJURIDICO, observacionesfichacliente.idObservacion FROM `observacionesfichacliente`
         LEFT JOIN agentes ON agentes.codagente = observacionesfichacliente.idAgente
         LEFT JOIN empresasclientes on empresasclientes.idEMPRESA = observacionesfichacliente.idEMPRESA WHERE idObservacion = :id;');
        $this->db->bind(':id', $id);
        $resultado = $this->db->registros();
        return $resultado;
    }
 
}