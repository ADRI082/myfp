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

    public function addFavorito($idAsignatura, $idUsuario)
    {

        $this->db->query("INSERT INTO favoritos(idAsignatura,idUsuario) values (:idAsignatura,:idUsuario)");

        $this->db->bind(':idAsignatura', $idAsignatura);
        $this->db->bind(':idUsuario', $idUsuario);

        $this->db->execute();
    }

    public function deleteFavorito($idAsignatura, $idUsuario)
    {

        $this->db->query("DELETE FROM favoritos where idUsuario=:idUsuario and idAsignatura=:idAsignatura");

        $this->db->bind(':idAsignatura', $idAsignatura);
        $this->db->bind(':idUsuario', $idUsuario);

        $this->db->execute();
    }

    public function comprobarFavorito($idAsignatura, $idUsuario)
    {
        $this->db->query('SELECT *  FROM favoritos 
         where idUsuario = :idUsuario and idAsignatura=:idAsignatura');

        $this->db->bind(':idAsignatura', $idAsignatura);
        $this->db->bind(':idUsuario', $idUsuario);

        $cursos = $this->db->registro();

        if(!empty($cursos)){
            return true;
        }else{
            return false;
        }
    }
}
