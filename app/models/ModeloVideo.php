<?php


class ModeloVideo{

    private $db;

    public function __construct(){
        $this->db = new Base;
    }


    public function obtenerObservaciones(){
        $this->db->query('SELECT *  FROM videos');
        $resultado = $this->db->registros();
        return $resultado;
    }


    public function guardarObservaciones($datos)
    {                   
        $this->db->query("UPDATE videos
                        SET oportunidad= :oportunidad, clientes= :clientes, acciones= :acciones, agentes= :agentes
                        WHERE id=1");
        
        $this->db->bind(':acciones', $datos['acciones']);
        $this->db->bind(':oportunidad', $datos['oportunidad']);
        $this->db->bind(':clientes', $datos['clientes']);
        $this->db->bind(':agentes', $datos['agentes']);

        $this->db->execute();
    }    


}