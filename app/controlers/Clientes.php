<?php

//require_once dirname(__FILE__).'/FichaClientes.php';

class Clientes extends Controlador
{

    public function __construct()
    {
        $this->DatatableClientes = $this->modelo('ModeloClientes');        
    }
    
    public function index()
    {

        $this->iniciar();
        
        $grupos = $this->DatatableClientes->obtenerGrupos();
        $actividad = $this->DatatableClientes-> obtenerActividad();
        $sector = $this->DatatableClientes-> obtenerSector();
        $colaborador = $this->DatatableClientes->obtenerColaborador();
        $agente = $this->DatatableClientes->obtenerAgente();
        $asesor = $this->DatatableClientes->obtenerAsesor();
        $formasdepago = $this->DatatableClientes->obtenerFormasDePago();

        $datos = [
          'grupos' => $grupos,
          'actividad' => $actividad,
          'sector' => $sector,
          'colaborador' => $colaborador,
          'agente' => $agente,
          'asesor' => $asesor,
          'formasdepago' => $formasdepago
        ]; 
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
          redireccionar('/login');
        } else {
          $this->vista('clientes/clientes', $datos);
        }
    }

 

    public function getClientes()
    {
        $clientes = $this->DatatableClientes->obtenerClientes();

        echo $clientes;
    }

    public function obtenerColaboradorPorCliente()
    {     
        if ($_POST['idCliente'] && $_POST['idCliente']!='') {
            $idCliente = $_POST['idCliente'];
        }
        $colaborador = $this->DatatableClientes->obtenerColaboradorPorCliente($idCliente);    
        echo $colaborador;
    }
    
    // AGREGAR EMPRESA
    public function agregarEmpresa()
    {               
        session_start();
        if($_SERVER['REQUEST_METHOD'] == "POST"){            
          
           
            
            $array = ['cif','grupo','grupoId','razonSocial','actividad','sector','nifRepresentante','representante','contactoPrincipal','colaborador',
                    'agente','direccion','poblacion','provincia','codigoPostal','telefonofijo1','telefonofijo2','movil','email','web','nss','convenio',
                    'fechaConvenio','rlt','trabajadores','activo','asesorTipo','selAsesorExt','nomAsesorInt','telefAsesorInt','movfAsesorInt','dirAsesorInt',
                    'locAsesorInt','provAsesorInt','codPosAsesorInt','mailAsesorInt','nomAsesorExt','contAsesorExt','telefAsesorExt','movfAsesorExt',
                    'dirAsesorExt','locAsesorExt','provAsesorExt','codPosAsesorExt','mailAsesorExt','selNomAsesorExt',
                    'identificadorOp','nombreComercial','estadoOp','fecha','creditoFormativo', 'observaciones', 'ctacte','formadepago'
                    ];

            $datos = [];
            foreach ($array as $key) {
                $datos[$key] = $_POST[$key];
            }
         
            if (($_POST['nombreContacto']) ) {
                $nombreContacto = $_POST['nombreContacto'];
            
                for ($i = 0; $i < count($nombreContacto); $i++) {
                    $datos2 = [
                        "nombreContacto" => $_POST['nombreContacto'],
                        "areaContacto" => $_POST['areaContacto'],
                        "telFijoContacto" => $_POST['telFijoContacto'],
                        "movilContacto" => $_POST['movilContacto'],
                        "emailContacto" => $_POST['emailContacto']                    
                    ];
                }    
            }else{
                $datos2 = [];
            }

            if ($_POST['identificadorOp']=='agregarOportunidad') {
                if($this->DatatableClientes->agregarOportunidad($datos)){
                    $_SESSION['message'] = 'Se ha creado corréctamente el registro';                    
                } else {                    
                    $_SESSION['message'] = 'Ha ocurrido un error y no se ha guardado el registro';
                }
                redireccionar('/clientes/oportunidades');
            }else{              
                if($this->DatatableClientes->agregarEmpresa($datos,$datos2)){
                    $_SESSION['message'] = 'Se ha creado corréctamente el registro';                    
                } else {                    
                    $_SESSION['message'] = 'Ha ocurrido un error y no se ha guardado el registro';
                }
                redireccionar('/clientes');
            }            
  
        } else {
            $array2 = ['cif','grupo','grupoId','razonSocial','actividad','sector','nifRepresentante','representante','contactoPrincipal','colaborador',
                'agente','direccion','poblacion','provincia','codigoPostal','telefonofijo1','telefonofijo2','movil','email','web','nss','convenio',
                'fechaConvenio','rlt','trabajadores','activo','asesorTipo','selAsesorExt','nomAsesorInt','telefAsesorInt','movfAsesorInt','dirAsesorInt',
                'locAsesorInt','provAsesorInt','codPosAsesorInt','mailAsesorInt','nomAsesorExt','contAsesorExt','telefAsesorExt','movfAsesorExt',
                'dirAsesorExt','locAsesorExt','provAsesorExt','codPosAsesorExt','mailAsesorExt','selNomAsesorExt',
                'identificadorOp','nombreComercial','estadoOp','fecha','creditoFormativo', 'observaciones', 'ctacte','formadepago'];

            $datos = [];
            foreach ($array2 as $key) {
                $datos[$key] = "";
            }
              
            if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
                redireccionar('/login');
            } else {
                $_SESSION['message'] = 'Ha ocurrido un error y no se ha guardado el registro';
                if ($_POST['identificadorOp']=='agregarOportunidad') {
                    $this->vista('/clientes/oportunidades', $datos);
                }else{
                    $this->vista('/clientes', $datos);
                }                
            }
        }

    }
    
    
    // Editar EMPRESA
    public function editarEmpresa(){
        
        session_start();

        if($_SERVER['REQUEST_METHOD'] == "POST"){
               
            $datos = [
                "id" => $_POST['idEdit'],
                "codigo" => $_POST['codigoEdit'],
                "cif" => $_POST['cifEdit'],                
                "nombre" => $_POST['nombreEdit'], 
                "nombreComercial" => $_POST['nombreComercialEdit'], 
                "grupo" => $_POST['grupoEdit'], 
                "sector" => $_POST['sectorEdit'],
                "representante" => $_POST['representanteEdit'],
                "nifRepresentante" => $_POST['nifRepresentanteEdit'],
                "contactoPrincipal" => $_POST['contactoPrincipalEdit'],
                "colaborador" => $_POST['colaboradorEdit'],
                "agente" => $_POST['agenteEdit'],
                "direccion" => $_POST['direccionEdit'], 
                "poblacion" => $_POST['poblacionEdit'], 
                "provincia" => $_POST['provinciaEdit'],                 
                "codigoPostal" => $_POST['codigoPostalEdit'],                 
                "telefonofijo1" => $_POST['telefonofijo1Edit'], 
                "telefonofijo2" => $_POST['telefonofijo2Edit'],                 
                "movil" => $_POST['movilEdit'], 
                "email" => $_POST['emailEdit'], 
                "web" => $_POST['webEdit'], 
                "nss" => $_POST['nssEdit'],                  
                "actividad" => $_POST['actividadEdit'],
                "ctacte" => $_POST['ctacteEdit'],
                "formadepago" => $_POST['formadepagoEdit'],
                "convenio" => $_POST['convenioEdit'], 
                "fechaConvenio" => $_POST['fechaConvenioEdit'], 
                "rlt" => $_POST['rltEdit'],
                "trabajadores" => $_POST['trabajadoresEdit'],
                "activo" => $_POST['activoEdit'],
                "credito" => $_POST['creditoFormativoEdit'],
                "observaciones" => $_POST['observacionesEdit'],
                "asesorTipo" => $_POST['asesorTipoEdit'],                
                "selAsesorExt" => $_POST['selAsesorExtEdit'], 
                "contactoAsesorInt" => $_POST['contactoAsesorIntEdit'], 
                "telefAsesorInt" => $_POST['telefAsesorIntEdit'], 
                "movfAsesorInt" => $_POST['movfAsesorIntEdit'], 
                "dirAsesorInt" => $_POST['dirAsesorIntEdit'], 
                "locAsesorInt" => $_POST['locAsesorIntEdit'], 
                "provAsesorInt" => $_POST['provAsesorIntEdit'], 
                "codPosAsesorInt" => $_POST['codPosAsesorIntEdit'], 
                "mailAsesorInt" => $_POST['mailAsesorIntEdit'], 
                "nomAsesorExt" => $_POST['nomAsesorExtEdit'], 
                "contAsesorExt" => $_POST['contAsesorExtEdit'], 
                "telefAsesorExt" => $_POST['telefAsesorExtEdit'], 
                "movfAsesorExt" => $_POST['movfAsesorExtEdit'], 
                "dirAsesorExt" => $_POST['dirAsesorExtEdit'], 
                "locAsesorExt" => $_POST['locAsesorExtEdit'], 
                "provAsesorExt" => $_POST['provAsesorExtEdit'], 
                "codPosAsesorExt" => $_POST['codPosAsesorExtEdit'], 
                "mailAsesorExt" => $_POST['mailAsesorExtEdit'], 
                "selNomAsesorExt" => $_POST['selNomAsesorExtEdit']

            ];

            if (($_POST['nombreContactoEdit']) ) {
                $nombreContacto = $_POST['nombreContactoEdit'];
            
                for ($i = 0; $i < count($nombreContacto); $i++) {
                    $datos2 = [
                        "nombreContacto" => $_POST['nombreContactoEdit'],
                        "areaContacto" => $_POST['areaContactoEdit'],
                        "telFijoContacto" => $_POST['telFijoContactoEdit'],
                        "movilContacto" => $_POST['movilContactoEdit'],
                        "emailContacto" => $_POST['emailContactoEdit']                    
                    ];
                }    
            }else{
                $datos2 = [];
            }
  
            if($this->DatatableClientes->editarEmpresa($datos, $datos2)){
                $_SESSION['message'] = 'Se ha actualizado corréctamente el registro';                 
            } else {
                $_SESSION['message'] = 'Ha ocurrido un error y no se ha guardado el registro';
            }            
          
        } else {
  
            $datos = [
                "codigo" => "",
                "cif" => "",
                "grupo" => "",
                "nombre" => "",
                "nombreComercial" => "",
                "provincia" => "", 
                "poblacion" => "", 
                "codigoPostal" => "", 
                "direccion" => "", 
                "telefonofijo1" => "", 
                "telefonofijo2" => "", 
                "movil" => "", 
                "email" => "", 
                "web" => "", 
                "nss" => "" ,
                "actividad" => "",
                "sector" =>"",
                "convenio" => "", 
                "fechaConvenio" =>"", 
                "rlt" => "",
                "trabajadores" => "",
                "activo" =>"", 
                "credito" => "",
                "observaciones" => ""
            
            ];
        }
  
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
            //$this->vista('/clientes',$datos);
            redireccionar('/clientes');
        }        
    }

//   ELIMINAR EMPRESA
    public function borrarEmpresa(){

        if($_SERVER['REQUEST_METHOD'] == "POST"){

            if( isset($_POST['id']) && $_POST['id'] != ''){

              $datos = [
                "id" => $_POST['id']
              ];
              try
              {         
                if($this->DatatableClientes->borrarEmpresa($datos)){
                    redireccionar('/clientes');
                  } else {
                    die('Algo salio mal');
                  }  
               }     
               catch(PDOException $exception){  
               redireccionar('/clientes');
               return $exception->getMessage();  
                }                    
            
              } else {
              die('Elige la empresa para eliminar');
              }

        } else {
        $datos = [
            "id" => ''           
        ];
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
            $this->vista('/clientes',$datos);
        }
        }
    }

    
//   PARA MODAL DE EDITAR
    public function getClientesUpdate()
    {
      if($_SERVER['REQUEST_METHOD'] == "POST"){
          $id = $_POST['id'];
      }
      $fila = $this->DatatableClientes->getClientesUpdate($id);
      echo json_encode($fila);

    }

    public function buscarContactosPorClientes()
    {

        $this->iniciar();
        
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $salida = [
                "idCliente" => $_POST['id'],
            ];

            $registros = $this->DatatableClientes->buscarContactosPorClientes($salida);

            $datos = [
                "registros" => $registros,                
            ];            
           
            
            if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
                redireccionar('/login');
            } else {        
                $this->vista('clientes/listadoContactosEdit', $datos);
            }
        }
    }    

    public function getGrupos()
    {      
      $fila = $this->DatatableClientes->getGrupos();
      echo json_encode($fila);

    }
    
    public function oportunidades()
    {

      $this->iniciar();
   
      $sector = $this->DatatableClientes-> obtenerSector();
      $colaborador = $this->DatatableClientes->obtenerColaborador();
      $agente = $this->DatatableClientes->obtenerAgente();
      
      $datos = [
          'sector' => $sector,
          'colaborador' => $colaborador,
          'agente' => $agente,
        ]; 

      if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
        redireccionar('/login');
      } else {
        $this->vista('clientes/oportunidades', $datos);
      }
    }

    public function getOportunidades()
    {
      $oportunidades = $this->DatatableClientes->obtenerOportunidades();
      echo $oportunidades;
    }    

    public function getOportunidadesUpdate()
    {
      if($_SERVER['REQUEST_METHOD'] == "POST"){
          $id = $_POST['id'];
      }
      $fila = $this->DatatableClientes->getOportunidadesUpdate($id);
      echo json_encode($fila);

    }

    public function editarOportunidad(){

        if($_SERVER['REQUEST_METHOD'] == "POST"){
               
            $datos = [
                "id" => $_POST['idEdit'],                
                "nombre" => $_POST['nombreComercialEdit'], 
                "provincia" => $_POST['provinciaEdit'], 
                "poblacion" => $_POST['poblacionEdit'], 
                "codigoPostal" => $_POST['codigoPostalEdit'], 
                "direccion" => $_POST['direccionEdit'], 
                "telefonofijo1" => $_POST['telefonofijo1Edit'], 
                "movil" => $_POST['movilEdit'], 
                "email" => $_POST['emailEdit'],                  
                "sector" => $_POST['sectorEdit'],                
                "trabajadores" => $_POST['trabajadoresEdit'],        
                "colaborador" => $_POST['colaboradorEdit'],      
                "contactoPrincipal"  => $_POST['contactoPrincipalEdit'],
                "estadoOp"  => $_POST['estadoOpEdit'],
                "fecha"  => $_POST['fechaEdit'],
                "convertir" => $_POST['oportunidadCliEdit']
            ];

            if($this->DatatableClientes->editarOportunidad($datos)){
                redireccionar('/clientes/oportunidades');
            } else {
                die('Algo salio mal');
            }            
  
        } else {
  
        $datos = [
            "id" => "",
            "codigo" => "",
            "nombre" => "",
            "provincia" => "",
            "poblacion" => "",
            "codigoPostal" => "",
            "direccion" => "",
            "telefonofijo1" => "",
            "movil" => "",
            "email" => "",
            "sector" => "",
            "trabajadores" => "",
            "colaboradorEdit" => "",
            "contactoPrincipalEdit"  => "",
            "estadoOpEdit"  => "",
            "fechaEdit"  => "",
            "convertir"  => ""
        ];
  
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
  
            redireccionar('/login');
        } else {
            $this->vista('/clientes/oportunidades',$datos);
        }
  
        }
    }
    
    public function borrarOportunidad(){

        if($_SERVER['REQUEST_METHOD'] == "POST"){

            if( isset($_POST['id']) && $_POST['id'] != ''){

              $datos = [
                "id" => $_POST['id']
              ];
              try
              {         
                if($this->DatatableClientes->borrarOportunidad($datos)){
                    redireccionar('/clientes/oportunidades');
                  } else {
                    die('Algo salio mal');
                  }  
               }     
               catch(PDOException $exception){  
               redireccionar('/clientes');
               return $exception->getMessage();  
                }                    
            
              } else {
              die('Elige la empresa para eliminar');
              }

        } else {
            $datos = [
                "id" => ''           
            ];
            if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
                redireccionar('/login');
            } else {
                $this->vista('/clientes/oportunidades',$datos);
            }
        }
    }


    public function auxiliarAgenteCliente() //función interna para asociar masivamente un agente a varios 
    {
        $this->DatatableClientes->auxiliarAgenteCliente();
    }

}