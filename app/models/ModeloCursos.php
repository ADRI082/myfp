<?php


class ModeloCursos
{

    private $db;

    public function __construct()
    {
        $this->db = new Base;
    }

    public function buscadorCursos()
    {
        $this->db->query('SELECT * FROM grado');
    
        $cursos = $this->db->registros();

        return $cursos;
    }


}