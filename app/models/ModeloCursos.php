<?php


class ModeloCursos
{

    private $db;

    public function __construct()
    {
        $this->db = new Base;
    }

    /**
     * Función que obtiene todos los grados superiores que hay en la base de datos
     */
    public function buscadorCursos()
    {
        $this->db->query('SELECT * FROM grado');
    
        $cursos = $this->db->registros();

        return $cursos;
    }


}