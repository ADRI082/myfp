<?php

class ModeloConfiguracion
{
    private $db;

    public function __construct()
    {
        $this->db = new Base;
    }

    public function obtenerRGPD()
    {
        $this->db->query("SELECT descripcion from config where nombre = 'rgpd'");
        $resultado = $this->db->registro();
        return $resultado;
    }


    public function actualizarDatosRGPD($datos)
    {
        $tabla = $datos['tabla'];
        $campo = $datos['campo'];
        $pk = $datos['pk'];
        $sql = "UPDATE $tabla SET  $campo =  '" . $datos['valor'] . "'  WHERE  $pk = '" . $datos['id'] . "' ";

        $this->db->query($sql);
        //Ejecutar
        if ($this->db->execute()) {
            return 'true';
        } else {
            return 'false';
        }
    }



}