<?php


class ModeloRecursosHumanos{

    private $db;

    public function __construct(){
        $this->db = new Base;
    }

    public function fichar($post)
    {
        
        date_default_timezone_set("Europe/Madrid");
        $fecha = date("Y-m-d H:i:s");

        $this->db->query('INSERT INTO registropersonal 
                        (idAgente, tipo, fecharegistro) 
                        VALUES (:idAgente, :tipo, :fecharegistro)');

        // vincular valores
        $this->db->bind(':idAgente', $post['idAgente']);
        $this->db->bind(':tipo', $post['tipo']);
        $this->db->bind(':fecharegistro', $fecha);
            
        //Ejecutar
        if($this->db->execute()){            
            return true;
        } else {
            return false;
        }
    }


    public function eliminarGasto($post)
    {
        $this->db->query("DELETE FROM gastosaccionproy WHERE idgasto =".$post['idGasto']);
            
        if($this->db->execute()){
            return true;
        } 
        else {            
            return false;
        }
    }

}