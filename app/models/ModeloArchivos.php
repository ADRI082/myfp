<?php


class ModeloArchivos
{

    private $db;

    public function __construct()
    {
        $this->db = new Base;
    }

    /**
     * Función que inserta guarda los datos de un fichero en la bbdd
     */

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
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    /**
     * Función que coge los documentos por la id de la asignatura
     */
    public function getDocumentosByIdAsignatura($idAsignatura)
    {

        $this->db->query('SELECT idArchivos, ar.nombre, bl.nombre as bloque, fechaSubida from archivos ar
        left join bloques bl on ar.bloques_idBloques = bl.idBloques 
        where idAsignatura ='.$idAsignatura);

        $archivos = $this->db->registros();

        return $archivos;
    }

    /**
     * Función que inserta los datos que un usuario ha subido en la bbdd
     */

    public function insertarSubida($idArchivo)
    {

        session_start();

        $this->db->query('INSERT INTO subidas (idUsuario,idArchivo,fechaSubida) 
        VALUES (:idUsuario,:idArchivo,:fecha)');

        // vincular valores
        $this->db->bind(':idUsuario',$_SESSION['idUsuario']);
        $this->db->bind(':idArchivo',$idArchivo);
        $this->db->bind(':fecha',date('Y-m-d'));
       
        $this->db->execute();
    
    }

    /**
     * Función que inserta los datos que un usuario ha descargado en la bbdd
     */

    public function insertarDescarga($idArchivo)
    {

        session_start();

        $this->db->query('INSERT INTO descargas (idUsuario,idArchivo,fechaDescarga) 
        VALUES (:idUsuario,:idArchivo,:fecha)');

        // vincular valores
        $this->db->bind(':idUsuario',$_SESSION['idUsuario']);
        $this->db->bind(':idArchivo',$idArchivo);
        $this->db->bind(':fecha',date('Y-m-d'));
       
        $this->db->execute();
    
    }
}
