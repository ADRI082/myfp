<?php


class ModeloLogin{

    private $db;


    public function __construct(){
        $this->db = new Base;
    }



    /**
     * Función que obtiene los datos de un usuario según su email y su contraseña
     */
    public function obtenerUsuarioMail($mail,$pass){
        $this->db->query('SELECT * FROM usuario  WHERE email = :mail AND password = :pass');
        $this->db->bind(':mail', $mail);
        $this->db->bind(':pass', $pass);

        $fila = $this->db->registro();

        return $fila;
    }

    /**
     * Función que comprueba si un email existe o no en la bbdd
     */
    public function comprobarEmail($email) 
    {

        $this->db->query('SELECT * FROM usuario  WHERE email = :mail');
        $this->db->bind(':mail', $email);

        $fila = $this->db->registro();

        $resultado = false;

        if(empty($fila)){
            $resultado = true;
        }

        return $resultado;

    }

    /**
     * Función que comprueba si un nickname existe o no en la bbdd
     */

    public function comprobarNick($nick) 
    {

        $this->db->query('SELECT * FROM usuario  WHERE nickname = :nick');
        $this->db->bind(':nick', $nick);

        $fila = $this->db->registro();

        $resultado = false;

        if(empty($fila)){
            $resultado = true;
        }

        return $resultado;

    }

    /**
     * Función que inserta a un usuario en la bbdd
     */

    public function insertarUsuario($datos)
    {
        $this->db->query("INSERT INTO usuario (nombre,apellido,password,email,nickname) VALUES (:nombre,:apellido,:pass,:email,:nickname) ");
        $this->db->bind(':nombre', $datos['first_name']);
        $this->db->bind(':apellido', $datos['last_name']);
        $this->db->bind(':pass', $datos['password']);
        $this->db->bind(':email', $datos['email']);
        $this->db->bind(':nickname', $datos['nickname']);

        $this->db->execute();
    }

    /**
     * Función que obtiene los datos de un usuario por su id
     */

    public function getDatosUsuario($idUsuario)
    {
        $this->db->query('SELECT * FROM usuario  WHERE idUsuario = :id');
        $this->db->bind(':id', $idUsuario);

        $fila = $this->db->registro();


        return $fila;

    }

    /**
     * Función que actualiza los datos de un usuario
     */

    public function updatearUsuario($datos)
    {

        session_start();

        $this->db->query('UPDATE usuario set nombre = :nombre , apellido=:apellido,nickname=:nickname,email=:email,password=:password where idUsuario = :idUsuario' );
        $this->db->bind(':nombre', $datos['NombreEdit']);
        $this->db->bind(':apellido', $datos['ApellidosEdit']);
        $this->db->bind(':nickname', $datos['nickNameEdit']);
        $this->db->bind(':email', $datos['emailEdit']);
        $this->db->bind(':password', $datos['passwordEdit']);
        $this->db->bind(':idUsuario', $_SESSION['id_usuario']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }

    }

    /**
     * Función que actualiza la contraseña de un usuario
     */

    public function resetearPassword($newPass,$email)
    {
        $this->db->query('UPDATE usuario set password=:password where email = :email' );
        $this->db->bind(':password', $newPass);
        $this->db->bind(':email', $email);
        $this->db->execute();
    }



}