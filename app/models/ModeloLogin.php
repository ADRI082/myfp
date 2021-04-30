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






}