<?php


class ModeloLogin{

    private $db;


    public function __construct(){
        $this->db = new Base;
    }




    public function obtenerUsuarioMail($mail,$pass){
        $this->db->query('SELECT * FROM usuario  WHERE email = :mail AND password = :pass');
        $this->db->bind(':mail', $mail);
        $this->db->bind(':pass', $pass);

        $fila = $this->db->registro();

        return $fila;
    }

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




}