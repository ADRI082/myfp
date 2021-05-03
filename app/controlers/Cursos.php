<?php


class Cursos extends Controlador
{

    public function __construct()
    {
        // cargamos el modelo asociado a este controlador
         $this->modeloCursos = $this->modelo('ModeloCursos');
    } // fin del constructor

    public function index()
    {

        //Obtener los usuarios
        $this->iniciar();

        $cursos = $this->modeloCursos->buscadorCursos();

        $datos = [
            "cursos" => $cursos
        ];


        if (isset($_SESSION['autorizado']) || $_SESSION['autorizado'] == 1) {
            $this->vista('cursos/cursos', $datos);
        } else {
            redireccionar('/login');
        }
    } // fin de la fucnion index

    public function buscadorCliente()
    {

       
        $this->iniciar();


        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $salida = [
                "id" => $_POST['id']
            ];
           
             if (isset($_POST['documento'])) {
                // insertamos el documento escrito
                $contenido = [
                    "id" => $_POST['id'],
                    "fecha" => $_POST['fecha'],
                    "agente" => $_POST['agente'],
                    "titulo" => $_POST['titulo'],
                    "documento" => $_POST['documento']
                ];
                
                $this->fichaClienteModelo->insertarObservaciones($contenido);
                
            } 

            $empresaCliente = $this->fichaClienteModelo->obtenerEmpresaCliente($salida['id']);
            $observaciones = $this->fichaClienteModelo->verObservacionesFichaCliente($salida['id']);
            $agentes = $this->fichaClienteModelo->veragenteInputObservaciones();
            $eventos = $this->fichaClienteModelo->verHistroricoEventos($salida['id']);
            $emailCliente = $this->fichaClienteModelo->verHistoricoEmailCliente($salida['id']);
            $representante = $this->fichaClienteModelo->obtenerRepresentante($salida['id']);
            $asesores = $this->fichaClienteModelo->obtenerAsesores($salida['id']);
            $contactos = $this->fichaClienteModelo->obtenerContactos($salida['id']);
            $colaboradores = $this->fichaClienteModelo->obtenerColaboradores($salida['id']);

            
    
            $datos = [
                "empresaCliente" => $empresaCliente,
                "observaciones" => $observaciones,
                "agentes" => $agentes,
                "eventos" => $eventos,
                "emailCliente" => $emailCliente,
                "representante" => $representante,
                "asesores" => $asesores,
                "contactos" => $contactos,
                "colaboradores" => $colaboradores
        
            ];

            if (isset($_SESSION['autorizado']) || $_SESSION['autorizado'] == 1) {
                $this->vista('fichaCliente/editarFicha', $datos);
            } else {
                redireccionar('/login');
            }
        }
    } // fin de la funcion buscadorCliente

    
   

} // fin de la clase
