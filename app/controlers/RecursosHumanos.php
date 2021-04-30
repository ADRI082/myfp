<?php


class RecursosHumanos extends Controlador
{
    public function __construct()
    {
        $this->ModelRecursosHumanos = $this->modelo('ModeloRecursosHumanos');        
    }

    public function fichar()
    {
        if ($_POST['idAgente'] && $_POST['tipo']) {
            $fichar = $this->ModelRecursosHumanos->fichar($_POST);
        }
        echo json_encode($fichar);
    }


}
