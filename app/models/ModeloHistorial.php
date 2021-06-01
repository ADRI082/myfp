<?php


class ModeloHistorial
{

    private $db;

    public function __construct()
    {
        $this->db = new Base;
    }

     /**
     * Función en la que se obtiene el historial de descargas de archivos de un usuario
     */
    public function getHistorialDescargas()
    {
        $this->db->query('SELECT DATE_FORMAT(des.fechaDescarga,"%d-%m-%Y") AS fecha, ar.nombre AS archivo, ar.idAsignatura, blo.nombre AS bloque, asi.nombre AS asignatura FROM descargas des
        LEFT JOIN archivos ar ON des.idArchivo = ar.idArchivos
        LEFT JOIN bloques blo ON blo.idBloques = ar.bloques_idBloques
        LEFT JOIN asignatura asi ON asi.idAsignatura = ar.idAsignatura
        GROUP BY id');

        $archivos = $this->db->registros();

        return $archivos;
    }

    /**
     * Función en la que se obtiene el historial de archivos subidos de un usuario
     */

    public function getHistorialSubidas()
    {
        $this->db->query('SELECT DATE_FORMAT(sub.fechaSubida,"%d-%m-%Y") AS fecha, ar.nombre AS archivo, ar.idAsignatura, blo.nombre AS bloque, asi.nombre AS asignatura FROM subidas sub
        LEFT JOIN archivos ar ON sub.idArchivo = ar.idArchivos
        LEFT JOIN bloques blo ON blo.idBloques = ar.bloques_idBloques
        LEFT JOIN asignatura asi ON asi.idAsignatura = ar.idAsignatura
        GROUP BY id');

        $archivos = $this->db->registros();

        return $archivos;
    }

   
}
