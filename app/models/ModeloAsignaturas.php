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

    $this->db->query('SELECT * FROM asignatura where Grado_idGrado ='.$idCurso);
    
        $cursos = $this->db->registros();

        return $cursos;

   }

   public function obtenerDatosAsignatura($idAsignatura)
   {
    $this->db->query('SELECT idAsignatura,nombre FROM asignatura where idAsignatura ='.$idAsignatura);
    
    $asignatura = $this->db->registro();


    return $asignatura;
   }


}