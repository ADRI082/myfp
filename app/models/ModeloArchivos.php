<?php


class ModeloArchivos
{

    private $db;

    public function __construct()
    {
        $this->db = new Base;
    }

    public function guardarFichero($file, $post)
    {

        session_start();

        $this->db->query('INSERT INTO archivos (nombre,bloques_idBloques,fechaSubida,usuario_idUsuario,archivo,idAsignatura) 
        VALUES (:nombre,:bloques_idBloques,:fechaSubida,:usuario_idUsuario,:archivo,:idAsignatura)');

        // vincular valores
        $this->db->bind(':nombre',$file['fichero']['name'] );
        $this->db->bind(':bloques_idBloques',$post['idBloque'] );
        $this->db->bind(':fechaSubida',date('Y-m-d'));
        $this->db->bind(':usuario_idUsuario',$_SESSION['idUsuario'] );
        $this->db->bind(':archivo', $file['fichero']['type']);
        $this->db->bind(':idAsignatura', $post['idAsignatura'] );
       
        //Ejecutar
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getDocumentosByIdAsignatura($idAsignatura)
    {

        $this->db->query('SELECT idArchivos, ar.nombre, bl.nombre as bloque, fechaSubida from archivos ar
        left join bloques bl on ar.bloques_idBloques = bl.idBloques 
        where idAsignatura ='.$idAsignatura);

        $archivos = $this->db->registros();

        return $archivos;
    }
}
