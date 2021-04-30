<?php

use function GuzzleHttp\json_decode;

class Datatable extends Controlador
{
    public function __construct()
    {
        $this->DatatableModelo = $this->modelo('ModeloDatatable');        
    }

    public function index()
    {
        $this->iniciar();
              
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
            $this->vista('datatable/dashboard');
        }
    }

    //Métodos para AGENTES: tabla y CRUD
    public function agentes()
    {        
        $this->iniciar();
      
        $agentes = $this->DatatableModelo->obtenerAgentes();
        $roles = $this->DatatableModelo->obtenerRoles();
        $clientes = $this->DatatableModelo->obtenerClientesTodos();
        $puestos = $this->DatatableModelo->obtenerPuestos();
        $departamentos = $this->DatatableModelo->obtenerDepartamentos();

        $datos = [
            'agentes' => $agentes,
            'roles' => $roles,
            'clientes' => $clientes,
            'puestos' => $puestos,
            'departamentos' => $departamentos
        ];

        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {            
            $this->vista('datatable/datatable', $datos);
        }
    }

    public function agregarAgente()
    {       
        session_start();
        if($_SERVER['REQUEST_METHOD'] == "POST"){            
            $datos = [
                "DNIAgente" => $_POST['DNIAgente'],
                "Nombre" => $_POST['Nombre'], 
                "Apellidos" => $_POST['Apellidos'],
                "numcuenta" => $_POST['numcuenta'],
                "Direccion" => $_POST['Direccion'],
                "Localidad" => $_POST['Localidad'],
                "provincia" => $_POST['provincia'],
                "codigopostal" => $_POST['codigopostal'],
                "telefono" => $_POST['telefono'],
                "movil" => $_POST['movil'],
                "puesto" => $_POST['puesto'], 
                "regimen" => $_POST['regimen'],
                "fechaInicio" => $_POST['fechaInicio'],
                "fechaFin" => $_POST['fechaFin'],              
                "idRol" => $_POST['idRol'], 
                "password" => $_POST['password'],
                "email" => $_POST['email'],
                "observaciones" => $_POST['observaciones']
            ];
               
                if($this->DatatableModelo->agregarAgente($datos)){
                    $_SESSION['message'] = 'Se ha guardado corréctamente el registro';                           
                } else {                        
                    $_SESSION['message'] = 'Ha ocurrido un error y no se ha guardado el registro';
                }
                    
                redireccionar('/datatable/agentes');
                
              
        } else {
            $datos = [
                "DNIAgente" => "",
                "Nombre" => "",
                "Apellidos" => "",
                "numcuenta" => "",
                "Direccion" =>"",
                "Localidad" =>"",
                "provincia" => "",
                "codigopostal" => "",
                "telefono" => "",
                "movil" => "",
                "puesto" => "",
                "departamento" => "",
                "idRol" =>"",
                "password" => "",
                "email" => "",
                "observaciones" => ""
            ];
  
            if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
                redireccionar('/login');
            } else {
                $this->vista('datatable/datatable', $datos);
            }
        }
    }

    public function borrarAgente()
    {     
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['id']) && $_POST['id'] != '') {
                $datos = [
                    "id" => $_POST['id']
                ];
                try {
                    if ($this->DatatableModelo->borrarAgente($datos)) {
                        redireccionar('/datatable/agentes');
                    } else {
                        die('Algo salio mal');
                    }
                } catch (PDOException $exception) {
                    redireccionar('/datatable/agentes');
                    return $exception->getMessage();
                }
            } else {
                die('Elige el agente para eliminar');
            }
        } else {
            $datos = [
                "id" => ''
            ];
            if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
                redireccionar('/login');
            } else {
                $this->vista('datatable/datatable', $datos);
            }
        }
    }

    public function getAgenteUpdate()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $id = $_POST['id'];
            
        }
        $fila = $this->DatatableModelo->getAgenteUpdate($id);
        echo json_encode($fila);
    }

    public function actualizarAgente()
    {
        session_start();
        if($_SERVER['REQUEST_METHOD'] == "POST"){                  
            $datos = [
                "codagente" => $_POST['codagente'],
                "DNIAgente" => $_POST['DNIAgenteEdit'],
                "Nombre" => $_POST['NombreEdit'], 
                "Apellidos" => $_POST['ApellidosEdit'],
                "numcuenta" => $_POST['numcuentadEdit'],
                "Direccion" => $_POST['DireccionEdit'],            
                "Localidad" => $_POST['LocalidadEdit'],
                "provincia" => $_POST['provinciaEdit'],
                "codigopostal" => $_POST['codigopostalEdit'],
                "telefono" => $_POST['telefonoEdit'],
                "movil" => $_POST['movilEdit'],
                "puesto" => $_POST['puestoEdit'],
                "departamento" => $_POST['departamentoEdit'],
                "idRol" => $_POST['rolEdit'],
                "mail" => $_POST['emaildEdit'],
                "password" => $_POST['passwordEdit'],
                "observaciones" => $_POST['observacionesEdit'],
                "regimen" => $_POST['regimenEdit'],
                "fechaInicio" => $_POST['fechaInicioEdit'],
                "fechaFin" => $_POST['fechaFinEdit'],
            ];
                    
                if($this->DatatableModelo->actualizarAgente($datos)){     
                    $_SESSION['message'] = 'Se ha actualizado corréctamente el registro';                             
                } else {                    
                    $_SESSION['message'] = 'Ha ocurrido un error y no se ha guardado el registro';
                }
              
                redireccionar('/datatable/agentes');
             
        } else {
            $datos = [
                "codagente" => "",
                "DNIAgente" => "",
                "Nombre" => "",
                "Apellidos" => "",
                "numcuenta" => "",
                "Direccion" => "",
                "Localidad" => "",
                "provincia" => "",
                "codigopostal" => "",
                "telefono" => "",
                "movil" => "",
                "puesto" => "",
                "departamento" => "",
                "idRol" => "",
                "mail" => "",
                "password" => "",
                "observaciones" => "",
            ];
            if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
                redireccionar('/login');
            } else {
                $this->vista('datatable/datatable', $datos);
            }
        }        

    }


    public function acciones()
    {
        $this->iniciar();
        $acciones = $this->DatatableModelo->obtenerAcciones();

        $datos = [
            'acciones' => $acciones
        ];
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
        $this->vista('datatable/acciones', $datos);
        }
    }

    public function tipos()
    {
        $this->iniciar();
        $tipos = $this->DatatableModelo->obtenerTipos();

        $datos = [
            'tipos' => $tipos
        ];
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
        $this->vista('datatable/tipos', $datos);
        }
    }

    public function areas()
    {

        $this->iniciar();

        $areas = $this->DatatableModelo->obtenerAreas();

        $datos = [
            'areas' => $areas
        ];
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
        $this->vista('datatable/areas', $datos);
        }
    }

    public function modalidades()
    {

        $this->iniciar();

        $modalidades = $this->DatatableModelo->obtenerModalidades();

        $datos = [
            'modalidades' => $modalidades
        ];
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
        
        $this->vista('datatable/modalidades', $datos);
        }
    }

    //Métodos para COLABORADORES: tabla y CRUD
    public function colaboradores()
    {
        $this->iniciar();
        $colaboradores = $this->DatatableModelo->obtenerColaboradores();
        $colabSelect = $this->DatatableModelo->obtenerColaboradoresSelect();
        $clientes = $this->DatatableModelo->obtenerClientesTodos();
        $datos = [
            'colaboradores' => $colaboradores,
            'clientes' => $clientes,
            'colabSelect' => $colabSelect
        ];
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
        $this->vista('datatable/colaboradores', $datos);
        }
    }

    public function getDatosSelect() //quitar
    {
        $tipo = $_POST['tipo'];
        $metodoSelect = 'get'.$tipo.'Select';

        $fila = $this->DatatableModelo->$metodoSelect();
        //$fila = $this->DatatableModelo->getAgentesSelect();
        echo json_encode($fila);
    }

    public function agregarColaborador()
    {        
        session_start();
        if($_SERVER['REQUEST_METHOD'] == "POST"){            
            $datos = [
                "codTipoCol" => $_POST['codTipoCol'],
                "NifColaborador" => $_POST['NifColaborador'], 
                //"idEmpresa" => $_POST['idEmpresa'],
                "margencomercial" => $_POST['margencomercial'],
                "NombreComercial" => $_POST['NombreComercial'],
                "RazonSocial" => $_POST['RazonSocial'],
                "Direccion" => $_POST['Direccion'],
                "codigopostal" => $_POST['codigopostal'],
                "Localidad" => $_POST['Localidad'],
                "provincia" => $_POST['provincia'],
                "numcuenta" => $_POST['numcuenta'],
                "Contactocolaborador" => $_POST['Contactocolaborador'],
                "telefonocolaborador" => $_POST['telefonocolaborador'],
                "movilcolaborador" => $_POST['movilcolaborador'],
                "emailcolaborador" => $_POST['emailcolaborador'],
                "webcolaborador" => $_POST['webcolaborador'],
                "observaciones" => $_POST['observaciones'],                
            ];
               
                if($this->DatatableModelo->agregarColaborador($datos)){
                    $_SESSION['message'] = 'Se ha guardado corréctamente el registro';   
                } else {                        
                    $_SESSION['message'] = 'Ha ocurrido un error y no se ha guardado el registro';
                }
               
                redireccionar('/datatable/colaboradores');        
               
        } else {
            $datos = [
                "codTipoCol" => "",
                "NifColaborador" => "", 
                //"idEmpresa" => "",
                "margencomercial" => "",
                "NombreComercial" => "",
                "RazonSocial" => "",
                "Direccion" => "",
                "codigopostal" => "",
                "Localidad" => "",
                "provincia" => "",
                "numcuenta" => "",
                "Contactocolaborador" => "",
                "telefonocolaborador" => "",
                "movilcolaborador" => "",
                "emailcolaborador" => "",
                "webcolaborador" => "",
                "observaciones" => "",

            ];
  
            if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
                redireccionar('/login');
            } else {
                $this->vista('datatable/colaboradores', $datos);
            }
        }
    }

    public function getColaboradorUpdate()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $id = $_POST['id'];            
        }
        $fila = $this->DatatableModelo->getColaboradorUpdate($id);        
        echo json_encode($fila);
    }

    public function actualizarColaborador()
    {

        session_start();
        if($_SERVER['REQUEST_METHOD'] == "POST"){                  
            $datos = [
                "idColaborador" => $_POST['idColaborador'], //primary key de la tabla colaboradores
                "codColaborador" => $_POST['codColaborador'], //primary key de la tabla colaboradoresN
                "codTipoCol" => $_POST['codTipoColEdit'],
                "NifColaborador" => $_POST['NifColaboradorEdit'], 
                //"idEmpresa" => $_POST['idEmpresaEdit'], //para la tabla colaboradoresN
                "margencomercial" => $_POST['margencomercialEdit'],
                "NombreComercial" => $_POST['NombreComercialEdit'],
                "RazonSocial" => $_POST['RazonSocialEdit'],
                "Direccion" => $_POST['DireccionEdit'],
                "codigopostal" => $_POST['codigopostalEdit'],
                "Localidad" => $_POST['LocalidadEdit'],
                "provincia" => $_POST['provinciaEdit'],
                "numcuenta" => $_POST['numcuentaEdit'],
                "Contactocolaborador" => $_POST['ContactocolaboradorEdit'],
                "telefonocolaborador" => $_POST['telefonocolaboradorEdit'],
                "movilcolaborador" => $_POST['movilcolaboradorEdit'],
                "emailcolaborador" => $_POST['emailcolaboradorEdit'],
                "webcolaborador" => $_POST['webcolaboradorEdit'],
                "observaciones" => $_POST['observacionesEdit'],                
            ];
                        
                if($this->DatatableModelo->actualizarColaborador($datos)){   
                    $_SESSION['message'] = 'Se ha guardado corréctamente el registro';           
                    
                } else {                    
                    $_SESSION['message'] = 'Ha ocurrido un error y no se ha guardado el registro';
                }            
                redireccionar('/datatable/colaboradores');
        } else {
            $datos = [
                "idColaborador" => "",
                "codColaborador" => "",
                "codTipoCol" => "",
                "NifColaborador" => "", 
                //"idEmpresa" => "",
                "margencomercial" => "",
                "NombreComercial" => "",
                "RazonSocial" => "",
                "Direccion" => "",
                "codigopostal" => "",
                "Localidad" => "",
                "provincia" => "",
                "numcuenta" => "",
                "Contactocolaborador" => "",
                "telefonocolaborador" => "",
                "movilcolaborador" => "",
                "emailcolaborador" => "",
                "webcolaborador" => "",
                "observaciones" => "",

            ];
            if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
                redireccionar('/login');
            } else {
                $this->vista('datatable/colaboradores', $datos);
            }
        }        

    }

    public function borrarColaborador()
    {     
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['id']) && $_POST['id'] != '') {
                $datos = [
                    "id" => $_POST['id']
                ];
                try {
                    if ($this->DatatableModelo->borrarColaborador($datos)) {
                        redireccionar('/datatable/colaboradores');
                    } else {
                        die('Algo salio mal');
                    }
                } catch (PDOException $exception) {
                    redireccionar('/datatable/colaboradores');
                    return $exception->getMessage();
                }
            } else {
                die('Elige el agente para eliminar');
            }
        } else {
            $datos = [
                "id" => ''
            ];
            if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
                redireccionar('/login');
            } else {
                $this->vista('datatable/colaboradores', $datos);
            }
        }
    }

    public function vincularColaboradorEmpresa()
    {
        
        if($_SERVER['REQUEST_METHOD'] == "POST"){            
            $datos = [
                "idColaborador" => $_POST['idColaboradorVin'],
                "idEmpresa" => $_POST['idEmpresa'],                   
            ];
            try{          
                if($this->DatatableModelo->vincularColaboradorEmpresa($datos)){
                    redireccionar('/datatable/colaboradores');
                } else {                        
                    die('Algo salio mal');
                }
            }        
            catch(PDOException $exception){              
                redireccionar('/datatable/colaboradores');        
               return $exception->getMessage();
            }  
        } else {
            $datos = [               
                "idColaborador" => "",
                "idEmpresa" => "",
            ];
  
            if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
                redireccionar('/login');
            } else {
                $this->vista('datatable/colaboradores', $datos);
            }
        }
    }

    //FIN Métodos para COLABORADORES
    

    //Métodos para ACTIVIDADES EMPRESARIALES: tabla y CRUD
    public function actEmpresariales()
    {
        $this->iniciar();
        $actEmpresariales = $this->DatatableModelo->obtenerActEmpresariales();
        
        $datos = [
            'actEmpresariales' => $actEmpresariales        
        ];
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
        $this->vista('datatable/actEmpresariales', $datos);
        }
    }

    public function agregarActEmpresarial()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST"){            
            $datos = [
                "codCnae" => $_POST['codCnae'],
                "desActividad" => $_POST['desActividad'], 
                "observacionesAct" => $_POST['observacionesAct'],
                "enlaceAct" => $_POST['enlaceAct']        
            ];
            try{          
                if($this->DatatableModelo->agregarActEmpresarial($datos)){
                    redireccionar('/datatable/actEmpresariales');
                } else {                        
                    die('Algo salio mal');
                }
            }        
            catch(PDOException $exception){              
                redireccionar('/datatable/actEmpresariales');        
                return $exception->getMessage();
            }  
        } else {
            $datos = [
                "codCnae" => "",
                "desActividad" => "",
                "observacionesAct" => "",
                "enlaceAct" => ""
            ];
  
            if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
                redireccionar('/login');
            } else {
                $this->vista('datatable/actEmpresariales', $datos);
            }
        }
    }

    public function getActEmpresarialUpdate()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $id = $_POST['id'];            
        }
        $fila = $this->DatatableModelo->getActEmpresarialUpdate($id);        
        echo json_encode($fila);
    }


    public function actualizarActEmpresarial()
    {       

        if($_SERVER['REQUEST_METHOD'] == "POST"){                  
            $datos = [
                "idActividad" => $_POST['idActividad'],
                "codCnaeEdit" => $_POST['codCnaeEdit'],
                "desActividadEdit" => $_POST['desActividadEdit'],
                "observacionesActEdit" => $_POST['observacionesActEdit'],
                "enlaceActEdit" => $_POST['enlaceActEdit']
            ];
            
            try{
                if($this->DatatableModelo->actualizarActEmpresarial($datos)){            
                    redireccionar('/datatable/actEmpresariales');
                } else {                    
                    die('Algo salio mal');
                }
            }
            catch(PDOException $exception){  
                redireccionar('/datatable/actEmpresariales');
                return $exception->getMessage();                             
            }
        } else {
            $datos = [
                "idActividad" => "",
                "codCnaeEdit" => "",
                "desActividadEdit" => "",
                "observacionesActEdit" => "",
                "editActEmpresarial" => ""
            ];
            if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
                redireccionar('/login');
            } else {
                $this->vista('datatable/actEmpresariales', $datos);
            }
        }        

    }

    public function borrarActividadEmpresarial()
    {     
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['id']) && $_POST['id'] != '') {
                $datos = [
                    "id" => $_POST['id']
                ];
                try {
                    if ($this->DatatableModelo->borrarActividadEmpresarial($datos)) {
                        redireccionar('/datatable/actEmpresariales');
                    } else {
                        die('Algo salio mal');
                    }
                } catch (PDOException $exception) {
                    redireccionar('/datatable/actEmpresariales');
                    return $exception->getMessage();
                }
            } else {
                die('Elige el agente para eliminar');
            }
        } else {
            $datos = [
                "id" => ''
            ];
            if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
                redireccionar('/login');
            } else {
                $this->vista('datatable/actEmpresariales', $datos);
            }
        }
    }    

    //FIN Métodos para ACTIVIDADES EMPRESARIALES
    

    //Métodos para SECTORES EMPRESARIALES: tabla y CRUD
    public function sectoresEmpresariales()
    {
        $this->iniciar();
        $sectoresEmpresariales = $this->DatatableModelo->obtenerSectoresEmpresariales();
        
        $datos = [
            'sectores' => $sectoresEmpresariales        
        ];
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
        $this->vista('datatable/sectoresEmpresariales', $datos);
        }
    }

    //FIN Métodos para SECTORES EMPRESARIALES 

    public function profesores($a = false, $b = false)
    {
        session_start();
        $profesores = $this->DatatableModelo->obtenerProfesores();

        if($a == false && $b == false) {        
            $datos = [
                'profesores' => $profesores
            ];
            if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
                redireccionar('/login');
            } else {
            $this->vista('datatable/profesores', $datos);
            }
        }else{
            if ($a == "C") {
                $accion = "Crear";
            } elseif ($a == "E" && $b) {
                $accion = "Editar";                
                $profesor = $this->DatatableModelo->obtenerProfesorPorId($b);                
            } elseif ($a == "D") {
                $accion = "Borrar";
            }            
            $datos = [
                'accion' => $accion,
                'id' => $b,
                'profesores' => $profesores,
                'profesor' => $profesor
            ];
            $this->vista('datatable/crearNuevoProfesor', $datos);
            
        }

    }
    
    public function agregarProfesor()
    {        
        /*echo"entra al controlador";
        print_r($_POST);
        print_r($_FILES);*/
        session_start();
        
        if ($_FILES['ficheroCurriculum']['size'] > 0) {
            $fichero = 1;
            $descripcionFichero = $_POST['descripcionFichero'];
            echo"trae fichero";
            
        }else{
            $fichero = 0;
            $descripcionFichero = '';
            echo"no trae fichero";
            
        }
        
        if(isset($_POST['agregar'])){   

            $datos = [
                'nifProfesor' => $_POST['nifProfesor'], 
                'nombreComercial' => $_POST['nombreComercial'], 
                'razonSocial' => $_POST['razonSocial'],
                'margencomercial' => $_POST['margencomercial'], 
                'direccion' => $_POST['direccion'], 
                'poblacion' => $_POST['poblacion'],
                'provincia' => $_POST['provincia'],
                'codigopostal' => $_POST['codigopostal'],
                'TELEFONOFIJO' => $_POST['TELEFONOFIJO'],
                'TELEFONOMOVIL' => $_POST['TELEFONOMOVIL'],
                'email' => $_POST['email'],
                'webprofesor' => $_POST['webprofesor'],
                'ccc' => $_POST['ccc'],
                'numSegSocial' => $_POST['numSegSocial'],
                'formacionReglada' => $_POST['formacionReglada'],
                'formacionNoReglada' => $_POST['formacionNoReglada'], 
                'contrato' => $_POST['contrato'],
                'evaluacionGlobal' => $_POST['evaluacionGlobal'],
                'experienciaLaboral' => $_POST['experienciaLaboral'],
                'experienciaFormador' => $_POST['experienciaFormador'],
                'perfilFormador' => $_POST['perfilFormador'], 
                'permisoConducir' => $_POST['permisoConducir'],
                'vehiculoPropio' => $_POST['vehiculoPropio'], 
                'disponibilidad' => $_POST['disponibilidad'],         
                'precioHora' => $_POST['precioHora'], 
                'idiomas' => $_POST['idiomas'], 
                'informatica' => $_POST['informatica'],                
                'observaciones' => $_POST['observaciones'],
                'contacto' => $_POST['contacto'],
                //'descripcionFichero' => $descripcionFichero
            ];
            
            try{
                $ins = $this->DatatableModelo->agregarProfesor($datos);
                if($ins > 0){
                    if ($fichero == 1) {
                        $this->uploadFichero($_FILES, $ins, $descripcionFichero);
                    }
                    $_SESSION['message'] = 'Se ha guardado corréctamente el registro'; 
                    
                } else {                        
                    $_SESSION['message'] = 'Ha ocurrido un error y no se ha guardado registro';
                }
                redireccionar('/datatable/profesores');
            }        
            catch(PDOException $exception){  
                $_SESSION['message'] = 'Ha ocurrido un error y no se ha guardado registro';            
                redireccionar('/datatable/profesores');              
            }  
        } else {
            $datos = [
                
            ];
  
            if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
                redireccionar('/login');
            } else {
                $_SESSION['message'] = 'Ha ocurrido un error y no se ha guardado el registro';
                $this->vista('datatable/profesores', $datos);
            }
        }
    }
    


    public function uploadFichero($files, $idProfesor, $descripcionFichero)
    {
        $guardado = $files['ficheroCurriculum']['tmp_name'];
        $tipo =  $files['ficheroCurriculum']['type'];
        $nombre = 'profesor_'.$idProfesor.".".$tipo;    

        $arr = [
            'nombre' => $nombre,
            'idProfesor' => $idProfesor,
            'tipo' => $tipo,
            'descripcionFichero' => $descripcionFichero            
        ];

        if(!file_exists(DOCUMENTOS_PRIVADOS.'profesores/curriculum')){
            mkdir(DOCUMENTOS_PRIVADOS.'profesores/curriculum',0777,true);
                if(file_exists(DOCUMENTOS_PRIVADOS.'profesores/curriculum')){
                    if(move_uploaded_file($guardado, DOCUMENTOS_PRIVADOS.'profesores/curriculum/'.$nombre)){
                        //echo "Archivo guardado con exito";
                        $confirma = true;                        
                    }else{
                        $confirma = false;                        
                         //echo "Archivo no se pudo guardar";
                    }
                }
        }else{
            if(move_uploaded_file($guardado, DOCUMENTOS_PRIVADOS.'profesores/curriculum/'.$nombre)){
                $confirma = true;                
                //echo "Archivo guardado con exito";
            }else{
                $confirma = false;                
                //echo "Archivo no se pudo guardar";
            }
        }
        if ($confirma == true) {            
            $this->DatatableModelo->insertarFicheroCurriculum($arr);
            return true;
        }else{
            return false;
        }
    
    }

    public function descargarFichero($idProfesor)
    {
        $this->iniciar();       
        
        $row = $this->DatatableModelo->obtenerDatosFichero($idProfesor);
        if ($row) {
            $filename = $row;
            $file = DOCUMENTOS_PRIVADOS."profesores/curriculum/".$filename;
            $mime = mime_content_type($file);
            header('Content-disposition: attachment; filename='.str_replace(" ",'_',$filename));
            header('Content-type: '.$mime);
            readfile($file);
        }else{
            echo"FICHERO NO ENCONTRADO";
        }

    }    

    public function actualizarProfesor()
    {        
      
        session_start();
        if(isset($_POST['agregar']) &&  $_POST['idProfesor']){   

            $datos = [
                'idProfesor' => $_POST['idProfesor'],
                'nifProfesor' => $_POST['nifProfesor'], 
                'nifProfesor' => $_POST['nifProfesor'], 
                'nombreComercial' => $_POST['nombreComercial'], 
                'razonSocial' => $_POST['razonSocial'],
                'margencomercial' => $_POST['margencomercial'], 
                'direccion' => $_POST['direccion'], 
                'poblacion' => $_POST['poblacion'],
                'provincia' => $_POST['provincia'],
                'codigopostal' => $_POST['codigopostal'],
                'TELEFONOFIJO' => $_POST['TELEFONOFIJO'],
                'TELEFONOMOVIL' => $_POST['TELEFONOMOVIL'],
                'email' => $_POST['email'],
                'webprofesor' => $_POST['webprofesor'],
                'ccc' => $_POST['ccc'],
                'numSegSocial' => $_POST['numSegSocial'],
                'formacionReglada' => $_POST['formacionReglada'],
                'formacionNoReglada' => $_POST['formacionNoReglada'], 
                'contrato' => $_POST['contrato'],
                'evaluacionGlobal' => $_POST['evaluacionGlobal'],
                'experienciaLaboral' => $_POST['experienciaLaboral'],
                'experienciaFormador' => $_POST['experienciaFormador'],
                'perfilFormador' => $_POST['perfilFormador'],                
                'vehiculoPropio' => $_POST['vehiculoPropio'],          
                'precioHora' => $_POST['precioHora'],                 
                'observaciones' => $_POST['observaciones'],
                'contacto' => $_POST['contacto']    
            ];
            
            try{          
                if($this->DatatableModelo->actualizarProfesor($datos)){
                    $_SESSION['message'] = 'Se ha actualizado corréctamente el registro'; 
                    
                } else {                        
                    $_SESSION['message'] = 'Ha ocurrido un error y no se ha actualizado el registro';
                }
                redireccionar('/datatable/profesores');
            }        
            catch(PDOException $exception){  
                $_SESSION['message'] = 'Ha ocurrido un error y no se ha actualizado el registro';            
                redireccionar('/datatable/profesores');              
            }  
        } else {
            $datos = [
                
            ];
  
            if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
                redireccionar('/login');
            } else {
                $_SESSION['message'] = 'Ha ocurrido un error y no se ha actualizado el registro';
                $this->vista('datatable/profesores', $datos);
            }
        }
    }

    public function borrarProfesor() //no borra, solo inactiva
    {
        session_start();
        if(isset($_POST['borrar']) && $_POST['id']){
            if($this->DatatableModelo->borrarProfesor($_POST['id'])){
                $_SESSION['message'] = 'Se ha eliminado corréctamente el registro'; 
                
            } else {                        
                $_SESSION['message'] = 'Ha ocurrido un error y no se ha eliminado el registro';
            }
            redireccionar('/datatable/profesores');
        }

    }

    public function removeAjaxProfesores()
    {
        if ($_POST['idProfesor'] && $_POST['permiso'] && $_POST['campoUpd'] ) {
            $upd = $this->DatatableModelo->removeCamposAjaxProfesores($_POST);            
            echo json_encode($upd);
        }                
    }

    public function addAjaxProfesores()
    {
        if ($_POST['idProfesor'] && $_POST['opcion'] && $_POST['campoadd'] ) {
            $upd = $this->DatatableModelo->addCamposAjaxProfesores($_POST);
            echo json_encode($upd);
        }        
    }

    public function clientes()
    {

        $this->iniciar();

        $clientes = $this->DatatableModelo->obtenerClientes();

        $datos = [
            'clientes' => $clientes
        ];
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
        $this->vista('datatable/clientes', $datos);
        }
    }



    //Métodos para CUENTAS BANCARIAS: tabla y CRUD
    public function cuentasBancarias()
    {        
        $this->iniciar();
        $cuentasBancarias = $this->DatatableModelo->obtenerCuentasBancarias();
        
        $datos = [
            'cuentasBancarias' => $cuentasBancarias        
        ];
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
        $this->vista('datatable/cuentasBancarias', $datos);
        }
    }

    public function agregarCuentasBancarias()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST"){            
            $datos = [
                "codCnae" => $_POST['codCnae'],
                "desActividad" => $_POST['desActividad'], 
                "observacionesAct" => $_POST['observacionesAct'],
                "enlaceAct" => $_POST['enlaceAct']        
            ];
            try{          
                if($this->DatatableModelo->agregarActEmpresarial($datos)){
                    redireccionar('/datatable/actEmpresariales');
                } else {                        
                    die('Algo salio mal');
                }
            }        
            catch(PDOException $exception){              
                redireccionar('/datatable/actEmpresariales');        
                return $exception->getMessage();
            }  
        } else {
            $datos = [
                "codCnae" => "",
                "desActividad" => "",
                "observacionesAct" => "",
                "enlaceAct" => ""
            ];
  
            if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
                redireccionar('/login');
            } else {
                $this->vista('datatable/actEmpresariales', $datos);
            }
        }
    }

    public function getCuentasBancariasUpdate()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $id = $_POST['id'];            
        }
        $fila = $this->DatatableModelo->getActEmpresarialUpdate($id);        
        echo json_encode($fila);
    }


    public function actualizarCuentasBancarias()
    {       

        if($_SERVER['REQUEST_METHOD'] == "POST"){                  
            $datos = [
                "idActividad" => $_POST['idActividad'],
                "codCnaeEdit" => $_POST['codCnaeEdit'],
                "desActividadEdit" => $_POST['desActividadEdit'],
                "observacionesActEdit" => $_POST['observacionesActEdit'],
                "enlaceActEdit" => $_POST['enlaceActEdit']
            ];
            
            try{
                if($this->DatatableModelo->actualizarActEmpresarial($datos)){            
                    redireccionar('/datatable/actEmpresariales');
                } else {                    
                    die('Algo salio mal');
                }
            }
            catch(PDOException $exception){  
                redireccionar('/datatable/actEmpresariales');
                return $exception->getMessage();                             
            }
        } else {
            $datos = [
                "idActividad" => "",
                "codCnaeEdit" => "",
                "desActividadEdit" => "",
                "observacionesActEdit" => "",
                "editActEmpresarial" => ""
            ];
            if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
                redireccionar('/login');
            } else {
                $this->vista('datatable/actEmpresariales', $datos);
            }
        }        

    }

    public function borrarCuentasBancarias()
    {     
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['id']) && $_POST['id'] != '') {
                $datos = [
                    "id" => $_POST['id']
                ];
                try {
                    if ($this->DatatableModelo->borrarActividadEmpresarial($datos)) {
                        redireccionar('/datatable/actEmpresariales');
                    } else {
                        die('Algo salio mal');
                    }
                } catch (PDOException $exception) {
                    redireccionar('/datatable/actEmpresariales');
                    return $exception->getMessage();
                }
            } else {
                die('Elige el agente para eliminar');
            }
        } else {
            $datos = [
                "id" => ''
            ];
            if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
                redireccionar('/login');
            } else {
                $this->vista('datatable/actEmpresariales', $datos);
            }
        }
    }    

    //FIN Métodos para CUENTAS BANCARIAS
    



}
