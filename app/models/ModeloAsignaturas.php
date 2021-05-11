<?php


class ModeloAsignaturas
{

    private $db;

    public function __construct()
    {
        $this->db = new Base;
    }

    public function getAsignaturaByIdCurso($idCurso)
    {

        $this->db->query('SELECT * FROM asignatura where Grado_idGrado =' . $idCurso);

        $cursos = $this->db->registros();

        return $cursos;
    }

    public function obtenerDatosAsignatura($idAsignatura)
    {
        $this->db->query('SELECT idAsignatura,nombre FROM asignatura where idAsignatura =' . $idAsignatura);

        $asignatura = $this->db->registro();


        return $asignatura;
    }

    public function obtenerBloquesAsignatura($idAsignatura)
    {
        $this->db->query('SELECT idBloques, nombre FROM bloques where Asignatura_idAsignatura =' . $idAsignatura);

        $bloques = $this->db->registros();

        return $bloques;
    }

    public function getAsignaturasFavoritas($idUsuario)
    {

        $this->db->query('SELECT asi.*  FROM favoritos fa
        left join asignatura asi on asi.idAsignatura = fa.idAsignatura
         where idUsuario =' . $idUsuario);

        $cursos = $this->db->registros();

        return $cursos;
    }
}
