<?php


class ModeloAsignaturas
{

    private $db;

    public function __construct()
    {
        $this->db = new Base;
    }

    /**
     * Función que obtiene todas las asignaturas que tiene un curso
     */

    public function getAsignaturaByIdCurso($idCurso)
    {

        $this->db->query('SELECT * FROM asignatura where Grado_idGrado =' . $idCurso);

        $cursos = $this->db->registros();

        return $cursos;
    }

    /**
     * Función que obtiene los datos de una asignatura
     */

    public function obtenerDatosAsignatura($idAsignatura)
    {
        $this->db->query('SELECT idAsignatura,nombre FROM asignatura where idAsignatura =' . $idAsignatura);

        $asignatura = $this->db->registro();


        return $asignatura;
    }

    /**
     * Función que obtiene todos los bloques de una asignatura
     */
    public function obtenerBloquesAsignatura($idAsignatura)
    {
        $this->db->query('SELECT idBloques, nombre FROM bloques where Asignatura_idAsignatura =' . $idAsignatura);

        $bloques = $this->db->registros();

        return $bloques;
    }

    /**
     * Función que obtiene las asignaturas favoritas de un usuario
     */

    public function getAsignaturasFavoritas($idUsuario)
    {

        $this->db->query('SELECT asi.*  FROM favoritos fa
        left join asignatura asi on asi.idAsignatura = fa.idAsignatura
         where idUsuario =' . $idUsuario);

        $cursos = $this->db->registros();

        return $cursos;
    }

    /**
     * Función que añade una asignatura a favoritos en al bbdd
     */

    public function addFavorito($idAsignatura, $idUsuario)
    {

        $this->db->query("INSERT INTO favoritos(idAsignatura,idUsuario) values (:idAsignatura,:idUsuario)");

        $this->db->bind(':idAsignatura', $idAsignatura);
        $this->db->bind(':idUsuario', $idUsuario);

        $this->db->execute();
    }

    /**
     * Función que borra de la base de datos una asignatura que esté en favoritos en la bbdd
     */

    public function deleteFavorito($idAsignatura, $idUsuario)
    {

        $this->db->query("DELETE FROM favoritos where idUsuario=:idUsuario and idAsignatura=:idAsignatura");

        $this->db->bind(':idAsignatura', $idAsignatura);
        $this->db->bind(':idUsuario', $idUsuario);

        $this->db->execute();
    }

    /**
     * Función que comprueba si una asignatura está o no en la bbdd
     */

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
