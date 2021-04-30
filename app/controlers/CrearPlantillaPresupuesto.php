<?php


class CrearPlantillaPresupuesto extends Controlador
{

    public function __construct()
    {
        // cargamos el modelo asociado a este controlador
        $this->Plantilla = $this->modelo('ModeloPlantilla');
    }
    public function index()
    {

        $this->iniciar();
       
             
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
            //$this->vista('plantillaPresupuesto/crearPlantillaPresupuesto');
            $this->vista('plantillaPresupuesto/crearPlantillaPresupuesto');
        }
        
    }
    public function agregarPlantilla()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST"){
               
            $datos = [
                "html" => $_POST['templatesPresupuesto'],
                "tipo" => $_POST['tipoPesupuesto']     
            ];
            

                try {
                    if ($this->Plantilla->agregarPlantilla($datos)) {
                        redireccionar('/crearPlantillaPresupuesto');
                    } else {
                        die('Algo salio mal');
                    }
                } catch (PDOException $exception) {
                    redireccionar('/crearPlantillaPresupuesto');
                    return $exception->getMessage();
                }

        } else {

        $datos = [
            "html" => '', 
            "tipo" => ''         
        ];

        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){

            redireccionar('/login');
        } else {
            print_r($datos);
            // $this->vista('/crearPlantillaPresupuesto',$datos);
        }

        }
    }

    public function getPlantillas()
    {
        $plantilla = $this->Plantilla->obtenerPlantillas();
        echo $plantilla;
    }

    public function deletePlantillas()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['idPlantilla']) && $_POST['idPlantilla'] != '') {
                $idPlantilla = $_POST['idPlantilla'];
                $plantilla = $this->Plantilla->borrarPlantillas($idPlantilla);
                //echo $plantilla;
            }
        }
    }

}