<?php 

class ModeloClaves{

    private $db;


    public function __construct(){
        $this->db = new Base;
    }

    public function obtenerClavesPlataforma(){
        $this->db->query('SELECT * FROM claves_plataforma');

        $resultado = $this->db->registros();

        return $resultado;
    }

    public function obtenerClavesGeneral(){
        $this->db->query('SELECT * FROM claves_general');

        $resultado = $this->db->registros();

        return $resultado;
    }

    public function obtenerClavesCdev(){
        $this->db->query('SELECT * FROM claves_cdev');

        $resultado = $this->db->registros();

        return $resultado;
    }

    public function obtenerClavesRedesSociales(){
        $this->db->query('SELECT * FROM claves_redes');

        $resultado = $this->db->registros();

        return $resultado;
    }

    public function obtenerClavesPortalesEmpleo(){
        $this->db->query('SELECT * FROM claves_portalesempleo');

        $resultado = $this->db->registros();

        return $resultado;
    }

    public function obtenerClavesUsuariosPc(){
        $this->db->query('SELECT * FROM claves_pc');

        $resultado = $this->db->registros();

        return $resultado;
    }

    public function agregarUsuarioPlataforma($datos){

        $this->db->query("INSERT INTO claves_plataforma (nombre,usuario,clave,observaciones,fecha_actualizacion,pagina_web) VALUES (:nombre, :usuario, :clave,:observaciones,:fecha_actualizacion,:pagina_web)");

        // vincular valores

        $this->db->bind(':nombre', $datos['nombre']);
        $this->db->bind(':usuario', $datos['usuario']);
        $this->db->bind(':clave', $datos['clave']);
        $this->db->bind(':observaciones', $datos['observaciones']);
        $this->db->bind(':fecha_actualizacion', $datos['fecha_actualizacion']);
        $this->db->bind(':pagina_web', $datos['pagina_web']);

        //Ejecutar
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }

    }

    public function agregarUsuarioGeneral($datos){

        $this->db->query("INSERT INTO claves_general (nombre,usuario,clave,observaciones,fecha_actualizacion,pagina_web) VALUES (:nombre, :usuario, :clave,:observaciones,:fecha_actualizacion,:pagina_web)");

        // vincular valores

        $this->db->bind(':nombre', $datos['nombre']);
        $this->db->bind(':usuario', $datos['usuario']);
        $this->db->bind(':clave', $datos['clave']);
        $this->db->bind(':observaciones', $datos['observaciones']);
        $this->db->bind(':fecha_actualizacion', $datos['fecha_actualizacion']);
        $this->db->bind(':pagina_web', $datos['pagina_web']);

        //Ejecutar
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }

    }

    public function agregarUsuarioCdev($datos){

        $this->db->query("INSERT INTO claves_cdev (nombre,usuario,clave,observaciones,fecha_actualizacion,pagina_web) VALUES (:nombre, :usuario, :clave,:observaciones,:fecha_actualizacion,:pagina_web)");

        // vincular valores

        $this->db->bind(':nombre', $datos['nombre']);
        $this->db->bind(':usuario', $datos['usuario']);
        $this->db->bind(':clave', $datos['clave']);
        $this->db->bind(':observaciones', $datos['observaciones']);
        $this->db->bind(':fecha_actualizacion', $datos['fecha_actualizacion']);
        $this->db->bind(':pagina_web', $datos['pagina_web']);

        //Ejecutar
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }

    }

    public function agregarUsuarioRedessociales($datos){

        $this->db->query("INSERT INTO claves_redes (nombre,usuario,clave,observaciones,fecha_actualizacion,pagina_web) VALUES (:nombre, :usuario, :clave,:observaciones,:fecha_actualizacion,:pagina_web)");

        // vincular valores

        $this->db->bind(':nombre', $datos['nombre']);
        $this->db->bind(':usuario', $datos['usuario']);
        $this->db->bind(':clave', $datos['clave']);
        $this->db->bind(':observaciones', $datos['observaciones']);
        $this->db->bind(':fecha_actualizacion', $datos['fecha_actualizacion']);
        $this->db->bind(':pagina_web', $datos['pagina_web']);

        //Ejecutar
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }

    }

    public function agregarUsuarioPortalesEmpleo($datos){

        $this->db->query("INSERT INTO claves_portalesempleo (nombre,usuario,clave,observaciones,fecha_actualizacion,pagina_web) VALUES (:nombre, :usuario, :clave,:observaciones,:fecha_actualizacion,:pagina_web)");

        // vincular valores

        $this->db->bind(':nombre', $datos['nombre']);
        $this->db->bind(':usuario', $datos['usuario']);
        $this->db->bind(':clave', $datos['clave']);
        $this->db->bind(':observaciones', $datos['observaciones']);
        $this->db->bind(':fecha_actualizacion', $datos['fecha_actualizacion']);
        $this->db->bind(':pagina_web', $datos['pagina_web']);

        //Ejecutar
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }

    }

    public function agregarUsuarioUsuariosPc($datos){

        $this->db->query("INSERT INTO claves_pc (nombre,usuario,clave,observaciones,fecha_actualizacion,pagina_web) VALUES (:nombre, :usuario, :clave,:observaciones,:fecha_actualizacion,:pagina_web)");

        // vincular valores

        $this->db->bind(':nombre', $datos['nombre']);
        $this->db->bind(':usuario', $datos['usuario']);
        $this->db->bind(':clave', $datos['clave']);
        $this->db->bind(':observaciones', $datos['observaciones']);
        $this->db->bind(':fecha_actualizacion', $datos['fecha_actualizacion']);
        $this->db->bind(':pagina_web', $datos['pagina_web']);

        //Ejecutar
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }

    }

    public function obtenerUsuarioIdPlataforma($id){
        $this->db->query('SELECT * FROM claves_plataforma WHERE idClave = :id');
        $this->db->bind(':id', $id);

        $fila = $this->db->registro();

        return $fila;
    }

    public function obtenerUsuarioIdGeneral($id){
        $this->db->query('SELECT * FROM claves_general WHERE idClave = :id');
        $this->db->bind(':id', $id);

        $fila = $this->db->registro();

        return $fila;
    }

    public function obtenerUsuarioIdCdev($id){
        $this->db->query('SELECT * FROM claves_cdev WHERE idClave = :id');
        $this->db->bind(':id', $id);

        $fila = $this->db->registro();

        return $fila;
    }

    public function obtenerUsuarioIdRedesSociales($id){
        $this->db->query('SELECT * FROM claves_redes WHERE idClave = :id');
        $this->db->bind(':id', $id);

        $fila = $this->db->registro();

        return $fila;
    }

    public function obtenerUsuarioIdPortalesEmpleo($id){
        $this->db->query('SELECT * FROM claves_portalesempleo WHERE idClave = :id');
        $this->db->bind(':id', $id);

        $fila = $this->db->registro();

        return $fila;
    }

    public function obtenerUsuarioIdUsuariosPc($id){
        $this->db->query('SELECT * FROM claves_pc WHERE idClave = :id');
        $this->db->bind(':id', $id);

        $fila = $this->db->registro();

        return $fila;
    }

    public function actualizarUsuarioPlataforma($datos){
        $this->db->query('UPDATE claves_plataforma SET nombre = :nombre, usuario = :usuario, clave = :clave, observaciones = :observaciones, fecha_actualizacion = :fecha_actualizacion, pagina_web = :pagina_web WHERE idClave = :idClave');
        $this->db->bind(':idClave', $datos['idClave']);
        $this->db->bind(':nombre', $datos['nombre']);
        $this->db->bind(':usuario', $datos['usuario']);
        $this->db->bind(':clave', $datos['clave']);
        $this->db->bind(':observaciones', $datos['observaciones']);
        $this->db->bind(':fecha_actualizacion', $datos['fecha_actualizacion']);
        $this->db->bind(':pagina_web', $datos['pagina_web']);

        //Ejecutar
        if($this->db->execute()){
            return true;

        }else {
            return false;
        }
    }

    public function actualizarUsuarioGeneral($datos){
        $this->db->query('UPDATE claves_general SET nombre = :nombre, usuario = :usuario, clave = :clave, observaciones = :observaciones, fecha_actualizacion = :fecha_actualizacion, pagina_web = :pagina_web WHERE idClave = :idClave');
        $this->db->bind(':idClave', $datos['idClave']);
        $this->db->bind(':nombre', $datos['nombre']);
        $this->db->bind(':usuario', $datos['usuario']);
        $this->db->bind(':clave', $datos['clave']);
        $this->db->bind(':observaciones', $datos['observaciones']);
        $this->db->bind(':fecha_actualizacion', $datos['fecha_actualizacion']);
        $this->db->bind(':pagina_web', $datos['pagina_web']);

        //Ejecutar
        if($this->db->execute()){
            return true;

        }else {
            return false;
        }
    }

    public function actualizarUsuarioCdev($datos){
        $this->db->query('UPDATE claves_cdev SET nombre = :nombre, usuario = :usuario, clave = :clave, observaciones = :observaciones, fecha_actualizacion = :fecha_actualizacion, pagina_web = :pagina_web WHERE idClave = :idClave');
        $this->db->bind(':idClave', $datos['idClave']);
        $this->db->bind(':nombre', $datos['nombre']);
        $this->db->bind(':usuario', $datos['usuario']);
        $this->db->bind(':clave', $datos['clave']);
        $this->db->bind(':observaciones', $datos['observaciones']);
        $this->db->bind(':fecha_actualizacion', $datos['fecha_actualizacion']);
        $this->db->bind(':pagina_web', $datos['pagina_web']);

        //Ejecutar
        if($this->db->execute()){
            return true;

        }else {
            return false;
        }
    }
    public function actualizarUsuarioRedesSociales($datos){
        $this->db->query('UPDATE claves_redes SET nombre = :nombre, usuario = :usuario, clave = :clave, observaciones = :observaciones, fecha_actualizacion = :fecha_actualizacion, pagina_web = :pagina_web WHERE idClave = :idClave');
        $this->db->bind(':idClave', $datos['idClave']);
        $this->db->bind(':nombre', $datos['nombre']);
        $this->db->bind(':usuario', $datos['usuario']);
        $this->db->bind(':clave', $datos['clave']);
        $this->db->bind(':observaciones', $datos['observaciones']);
        $this->db->bind(':fecha_actualizacion', $datos['fecha_actualizacion']);
        $this->db->bind(':pagina_web', $datos['pagina_web']);

        //Ejecutar
        if($this->db->execute()){
            return true;

        }else {
            return false;
        }
    }

    public function actualizarUsuarioPortalesEmpleo($datos){
        $this->db->query('UPDATE claves_portalesempleo SET nombre = :nombre, usuario = :usuario, clave = :clave, observaciones = :observaciones, fecha_actualizacion = :fecha_actualizacion, pagina_web = :pagina_web WHERE idClave = :idClave');
        $this->db->bind(':idClave', $datos['idClave']);
        $this->db->bind(':nombre', $datos['nombre']);
        $this->db->bind(':usuario', $datos['usuario']);
        $this->db->bind(':clave', $datos['clave']);
        $this->db->bind(':observaciones', $datos['observaciones']);
        $this->db->bind(':fecha_actualizacion', $datos['fecha_actualizacion']);
        $this->db->bind(':pagina_web', $datos['pagina_web']);

        //Ejecutar
        if($this->db->execute()){
            return true;

        }else {
            return false;
        }
    }

    public function actualizarUsuarioUsuariosPc($datos){
        $this->db->query('UPDATE claves_pc SET nombre = :nombre, usuario = :usuario, clave = :clave, observaciones = :observaciones, fecha_actualizacion = :fecha_actualizacion, pagina_web = :pagina_web WHERE idClave = :idClave');
        $this->db->bind(':idClave', $datos['idClave']);
        $this->db->bind(':nombre', $datos['nombre']);
        $this->db->bind(':usuario', $datos['usuario']);
        $this->db->bind(':clave', $datos['clave']);
        $this->db->bind(':observaciones', $datos['observaciones']);
        $this->db->bind(':fecha_actualizacion', $datos['fecha_actualizacion']);
        $this->db->bind(':pagina_web', $datos['pagina_web']);

        //Ejecutar
        if($this->db->execute()){
            return true;

        }else {
            return false;
        }
    }

    public function borrarUsuarioPlataforma($datos){
        $this->db->query('DELETE FROM claves_plataforma WHERE idClave = :idClave');
        $this->db->bind(':idClave', $datos['idClave']);


        //Ejecutar
        if($this->db->execute()){
            return true;

        }else {
            return false;
        }
    }

    public function borrarUsuarioGeneral($datos){
        $this->db->query('DELETE FROM claves_general WHERE idClave = :idClave');
        $this->db->bind(':idClave', $datos['idClave']);


        //Ejecutar
        if($this->db->execute()){
            return true;

        }else {
            return false;
        }
    }

    public function borrarUsuarioCdev($datos){
        $this->db->query('DELETE FROM claves_cdev WHERE idClave = :idClave');
        $this->db->bind(':idClave', $datos['idClave']);


        //Ejecutar
        if($this->db->execute()){
            return true;

        }else {
            return false;
        }
    }

    public function borrarUsuarioRedesSociales($datos){
        $this->db->query('DELETE FROM claves_redes WHERE idClave = :idClave');
        $this->db->bind(':idClave', $datos['idClave']);


        //Ejecutar
        if($this->db->execute()){
            return true;

        }else {
            return false;
        }
    }

    public function borrarUsuarioPortalesEmpleo($datos){
        $this->db->query('DELETE FROM claves_portalesempleo WHERE idClave = :idClave');
        $this->db->bind(':idClave', $datos['idClave']);


        //Ejecutar
        if($this->db->execute()){
            return true;

        }else {
            return false;
        }
    }

    public function borrarUsuarioUsuariosPc($datos){
        $this->db->query('DELETE FROM claves_pc WHERE idClave = :idClave');
        $this->db->bind(':idClave', $datos['idClave']);


        //Ejecutar
        if($this->db->execute()){
            return true;

        }else {
            return false;
        }
    }

}

