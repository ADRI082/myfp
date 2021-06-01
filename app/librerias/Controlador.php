<?php
// clase controlador principal
// se encarga de poder cargra los modelos y las vistas
class Controlador
{
   
   
    // cargar el modelo
    public function modelo($modelo)
    {
        // carga modelo
        require_once('../app/models/' . $modelo . '.php');
        // instanciamos el modelo
        return new $modelo();
    }


    // cargar vista
    public function vista($vista, $datos = [])
    {

        // chequear si el archivo vista existe
        if (file_exists('../app/views/' . $vista . '.php')) {
            require_once('../app/views/' . $vista . '.php');
        } else {
            // si no existe el archivo nos da un mensaje
            die("la vista no existe");
        }
    }

    /**
     * Función que inicia la sesión del usuario
     */
    public function iniciar()
    {
        session_start();
    }
    

    /**
     * Función que destruye la sesión del usuario
     */
    public function salir()
    {
        
        session_destroy();
    }
}
