<?php

//require_once dirname(__FILE__).'/../../vendor/autoload.php';
require '../public/vendor/autoload.php';
         
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;


class Presupuesto extends Controlador
{
    public function __construct()
    {
        // cargamos el modelo asociado a este controlador
        $this->Presupuesto = $this->modelo('ModeloPresupuesto');
    }

    public function index()
    {
        $this->iniciar();
        $clientes = $this->Presupuesto->obtenerClientes();
        $servicio = $this->Presupuesto->obtenerServicio();
        $grupos = $this->Presupuesto->obtenerGrupos();
        $acciones = $this->Presupuesto->obtenerAcciones();
        $plantilla = $this->Presupuesto->obtenerPlantilla();
        $agentes = $this->Presupuesto->obtenerAgentes();

        $datos = [
            'clientes' => $clientes,
            'servicio' => $servicio,
            'grupos' => $grupos,
            'acciones' => $acciones,
            'plantilla' => $plantilla,
            'agentes' => $agentes
        ];

        if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
            redireccionar('/login');
        } else {
            $this->vista('presupuestos/presupuesto', $datos);
        }
    }
    public function getClienteSelect()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $idGrupo = $_POST['idGrupo'];
        }

        $clienteselect = $this->Presupuesto->obtenerClientesSelect($idGrupo);
        $salida = "<option selected disabled>Seleccionar.....</option>";

        foreach ($clienteselect as $row) {

            $salida .= "<option value='" . $row->idEMPRESA . "'>" . $row->NOMBREJURIDICO . "</option>";
        }
        echo $salida;
    }

    //probando select clientesPres:-----------------------
    public function getClienteSelect2()
    {
        
        $clienteselect = $this->Presupuesto->obtenerClientes();
        $salida = "<option selected disabled></option>";
        foreach ($clienteselect as $row) {
            $salida .= "<option value='" . $row->id . "'>" . $row->NOMBREJURIDICO . "</option>";
        }

        $tipoSelect = $this->Presupuesto->obtenerTipologia();
        $salida2 = "<option selected disabled></option>";
        foreach ($tipoSelect as $row) {
            $salida2 .= "<option value='" . $row->codtipologia . "'>" . $row->descripcion . "</option>";
        }

        if ($_POST['idServicio'] && $_POST['idServicio']!='') {
            $idServicio = $_POST['idServicio'];
        }
        $accionselect = $this->Presupuesto->obtenerAccionesSelect($idServicio);
        $salida3 = "<option selected disabled></option>";
        foreach ($accionselect as $row) {
            $salida3 .= "<option value='" . $row->idACCION . "'>" . $row->idACCION. " - " .$row->NOMBREACCION . "</option>";
        }

        $modalidades = $this->Presupuesto->obtenerModalidades();
        $salida4 = "<option selected disabled></option>";
        foreach ($modalidades as $row) {
            $salida4 .= "<option value='" . $row->id . "'>" . $row->descripcion . "</option>";
        }

        $final = ['clientes'=>$salida, 'tipologias'=>$salida2, 'acciones'=>$salida3, 'modalidades'=>$salida4];
        echo json_encode($final);
    }

    public function getAccionSelect()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $idServicio = $_POST['idServicio'];
        }

        $accionselect = $this->Presupuesto->obtenerAccionesSelect($idServicio);
        $salida = "<option selected disabled></option>";
        foreach ($accionselect as $row) {
            $salida .= "<option value='" . $row->idACCION . "'>" . $row->idACCION. " - " .$row->NOMBREACCION . "</option>";
        }

        echo $salida;
    }


    public function getTipologiaSelect()
    {        
        $tipoSelect = $this->Presupuesto->obtenerTipologia();
        $salida = "<option selected disabled></option>";

        foreach ($tipoSelect as $row) {

            $salida .= "<option value='" . $row->codtipologia . "'>" . $row->descripcion . "</option>";
        }
        echo $salida;
    }

    public function getServicioSelect()
    {
        
        $clienteselect = $this->Presupuesto->obtenerServicio();
        $salida = "<option selected disabled></option>";

        foreach ($clienteselect as $row) {

            $salida .= "<option value='" . $row->id . "'>" . $row->nombreS . "</option>";
        }
        echo $salida;
    }
   

    public function getModalidadAccionSelect()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $accion = $_POST['accion'];
        }

        $tipoSelect = $this->Presupuesto->obtenerModalidadAccion($accion);
        $opciones = $tipoSelect['opciones'];
        $selected = $tipoSelect['selected']->idModalidad;


        $salida = "<option selected disabled value=''></option>";
        
        foreach ($opciones as $opcion) {

            $salida .= "<option value='".$opcion->CODMODALIDAD."' ".(($opcion->CODMODALIDAD == $selected)? 'selected' :'')." >" . $opcion->DESMODALIDAD . "</option>";
        }
        echo $salida;
        
    }    


    //-----------------------------------------


    public function getPlantillaSelect()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $idPlantilla = $_POST['idPlantilla'];
        }
       $salida = "";
        $plantillaSelect = $this->Presupuesto->obtenerPlantillaSelect($idPlantilla);

        foreach ($plantillaSelect as $row) {

            $salida .= "<option>" . $row->html . "</option>";
        }
        echo $salida;
    }
    public function getSelectPlus()
    {
        //adicioné Edit a los name de los select múltiples
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $a = $_POST['loop'];
        }
      
        $accionselect = $this->Presupuesto->obtenerServicio();
        $salida =   '<div class="col-md-3 selPres">'
            . '<label for="clienteProyecto">Empresa</label>'
            . '<select class="form-control  select2 cliente variables" id="cliente'.$a.'" name="clienteEdit[]" required>'

            . '</select>'
            . '</div>'
            . '<div class="col-md-3 ">'
            . '<label for="clienteProyecto">Servicio</label>'
            . '<select  class="form-control servicioSelect variables" id="servicioEdit'.$a.'" name="servicioEdit[]"  required>'
            . '<option selected disabled>Seleccionar.....</option>';
        foreach ($accionselect as $servicio) {
            $salida .= '<option value=' . $servicio->id . '>' . $servicio->nombreS . '</option>';
        }
        $salida .= '</select>'
            . '</div>'

            . '<div class="col-md-3 selPres">'
            . '<label for="accion">Accion</label>'
            . '<select  class="form-control  select2 accionSelect variables" id="accionEdit'.$a.'" name="accionEdit[]" required>'

            . '</select>'
            . '</div>'
            . '<div class="col-md-1">'
            . '<label for="">Importe</label>'
            . '<input id="importeEdit'.$a.'" type="number" step="0.01" class="form-control"'
            . 'name="importeEdit[]" required></input>'
            . '</div>'
            . '<div class="col-md-1">'
            . '<label for="">Horas</label>'
            . '<input id="horasEdit'.$a.'" type="number" class="form-control"'
            . 'name="horasEdit[]" required></input>'
            . '</div>'            
            
            ;
        echo $salida;
    }

    
    public function getSelectPlusUpdate()
    {
        
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $id = $_POST['id'];
        }
        $accionselect = $this->Presupuesto->obtenerServicio();        

        $servicio = $this->Presupuesto->obtenerServicioUpdate($id);
        $salida = "";
        $a = 1;
        foreach ($servicio as $row) {
            //traigo las acciones relacionadas a cada servicio
            $codServ = $row->idServicio;
            $listServ = $this->Presupuesto->obtenerAccionesSelect($codServ);
            $tipologia = $this->Presupuesto->obtenerServicioTipologia($row->idAccionPres);
            //
            $salida .=   '<div class="col-md-2 selPres">'
                .           '<input class="form-control form-control-sm" type="hidden" name="idEdit[]"  value ="'.$row->idAccionPres.'">'
                .           '<input class="form-control cliente clienteEdit variables" id="cliente'.$a.'" name="clienteEdit[]" attr-id="Cliente'.$a.'" readonly value="'.$row->NOMBREJURIDICO.'">'
/*                .           '<select class="form-control select2 cliente clienteEdit variables" id="cliente'.$a.'" name="clienteEdit[]" attr-id="Cliente '.$a.'" readonly>';
            $salida .=          '<option  value=' . $row->idEMPRESA . '>' . $row->NOMBREJURIDICO. '</option>';
            $salida .=      '</select>'*/
                .       '</div>'
                .       '<div class="col-md-2 ">'
                .           '<input class="form-control servicioEdit variables" id="servicioEdit'.$a.'" name="servicioEdit[]" attr-id="Servicio'.$a.'" readonly value ="'.$tipologia->tipologia.'">'
/*                .           '<select class="form-control servicioEdit variables" id="servicioEdit'.$a.'"'
                .           'name="servicioEdit[]" attr-id="Servicio '.$a.'" readonly>';*/
            //$salida .=          '<option value=' . $row->idServicio . '>' . $row->nombreS . '</option>';
            /*foreach ($accionselect as $servicio1) {
                $salida .=      '<option value=' . $servicio1->id . '>' . $servicio1->nombreS . '</option>';
            }
            foreach ($accionselect as $servicio1) {
                $salida .=      '<option value=' . $servicio1->id . ' '.(($servicio1->id==$row->idServicio)? 'selected' : '').'>' . $servicio1->nombreS . '</option>';
            }
            $salida .=      '</select>'*/
                .       '</div>'
                .       '<div class="col-md-3 selPres">'
                .           '<input class="form-control accionEdit variables" id="accionEdit'.$a.'" name="accionEdit[]" attr-id="Acción'.$a.'" readonly value="'.$row->NOMBREACCION.'">'
/*                .           '<select class="form-control select2 accionEdit variables" id="accionEdit'.$a.'" name="accionEdit[]"'
                .           '  attr-id="Acción '.$a.'" readonly>';

            //$salida .=          '<option value=' . $row->idACCION . ' >' . $row->NOMBREACCION . '</option>';
            foreach ($listServ as $key ) {
                $salida .=          '<option value=' . $key->idACCION . ' '.(($key->idACCION==$row->idACCION)? 'selected' : '').' >' . $key->NOMBREACCION . '</option>';
            }
            $salida .=      '</select>'*/
                .       '</div>'
                .       '<div class="col-md-1">'
                .           '<input id="importeEdit'.$a.'" type="number" step="0.01" class="form-control variables" name="importeEdit[]" value=' . $row->importe . ' attr-id="Importe '.$a.'" readonly></input>'
                .       '</div>'
                .       '<div class="col-md-1">'
                .           '<input id="HorasEdit'.$a.'" type="number" class="form-control variables" name="horasEdit[]" value=' . $row->horas . ' attr-id="Horas '.$a.'" readonly></input>'                                
                .       '</div>'
                .       '<div class="col-md-1">'
                .           '<input id="participantesEdit'.$a.'" type="number" class="form-control variables" name="participantesEdit[]" value=' . $row->horas . ' attr-id="Horas '.$a.'" readonly></input>'                                
                .       '</div>'                
                .       '<div class="col-md-2 d-flex">'
                .           '<input class="form-check-input marcaraccion" type="checkbox" data-idaccion="'. $row->idAccionPres .'" id="checkAccion'. $row->idAccionPres .'" name="checkAccion'. $row->idAccionPres .'" value="1" readonly>';
/*                .       '</div>';
        $salida .=     '<div class="col-md-1">'*/
        if ($row->estatus == 0) {
            $salida .=      '<a id="btnAprobarFila'.$row->idAccionPres.'" class="btn btn-success mr-1 btnAprobarFila edit" name="btnAprobarFila" data-btnaccion="'.$row->idAccionPres.'" title="Aprobar"><i class="fas fa-thumbs-up" style="color:white;"></i></a>'
                .           '<a id="btnRechazarFila'.$row->idAccionPres.'" class="btn btn-danger mr-1 btnRechazarFila edit" name="btnRechazarFila" data-btnaccion="'.$row->idAccionPres.'" title="Rechazar"><i class="fas fa-thumbs-down" style="color:white;"></i></a>';
        }        
            $salida .=      '<input class="form-control" data-estatus="'. $row->idAccionPres .'" id="estatus'. $row->idAccionPres .'" name="estatus'. $row->idAccionPres .'" value="'.(($row->estatus == 1)? 'Aprobado':'Pendiente' ).'" readonly>';
        /*        
                .           '<a id="btnExportFila'. $row->idAccionPres .'" class="btn btn-danger btn-xs mr-1" name="btnExportFila" data-idaccion="'. $row->idAccionPres .'" title="Exportar"><span class="fas fa-file-pdf" style="color:white;"></span></a>'                
                .           '<a id="btnEnviarFila'. $row->idAccionPres .'" class="btn btn-primary btn-xs mr-1" name="btnEnviarFila" value="" data-idaccion="'. $row->idAccionPres .'" title="Enviar"><span class="fas fa-envelope-square" style="color:white;"></span></a>'                                
                .           '<a id="btnAprobarFila'. $row->idAccionPres .'" class="btn '.(($row->estatus == 1)? 'btn-success':'btn-warning').' btn-xs mr-1 btnAprobarFila" name="btnAprobarFila" data-idaccion="'. $row->idAccionPres .'" title="'.(($row->estatus == 1)? 'Aprobado':'Aprobar').'"><i id="'. $row->idAccionPres .'" class="fas '.(($row->estatus == 1)? 'fa-thumbs-up':'fa-question-circle').'" style="color:white;"></i></a>'
*/                
            $salida .=       '</div>';                
            $a++;
        }
            $salida .=   '<input id="contador" type="hidden" name="contador" value=' . $a . '></input>';

      
        echo $salida;
    }

    //   PARA MODAL DE EDITAR
    public function getPresupuestoUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $id = $_POST['id'];
        }
        $fila = $this->Presupuesto->obtenerPresupuestoUpdate($id);
        echo json_encode($fila);
    }
    //   PARA DATATABLE
    public function getPresupuesto()
    {

        $presupuesto = $this->Presupuesto->obtenerPresupuesto();

        echo $presupuesto;
    }

    public function verPresupuestoEditar($idPres)
    {
        $this->iniciar();
        
        //traer los datos de detalles y cabecera
        $info = $this->Presupuesto->obtenerPresupuestoUpdate($idPres);
        
        $agentes = $this->Presupuesto->obtenerAgentes();        
        $ficheros = $this->Presupuesto->obtenerFicherosPresupuesto($idPres);
        $plantillas = $this->Presupuesto->obtenerPlantilla();        

        $clientes = $this->Presupuesto->obtenerClientes();
        $servicio = $this->Presupuesto->obtenerServicio();
        $grupos = $this->Presupuesto->obtenerGrupos();
        $acciones = $this->Presupuesto->obtenerAcciones();
        $tipologias = $this->Presupuesto->obtenerTipologia();
        $modalidades = $this->Presupuesto->obtenerModalidades();
        $nivelesCursos = $this->Presupuesto->obtenerNivelesCursos();

        $datos = [
            'info' => $info,
            'agentes'=> $agentes,
            'insert'=> $ficheros,
            'plantillas'=> $plantillas,
            'clientes'=> $clientes,
            'servicio'=> $servicio,
            'grupos'=> $grupos,
            'acciones'=> $acciones,
            'tipologias'=> $tipologias,
            'modalidades'=>$modalidades,
            'nivelesCursos'=>$nivelesCursos
        ];    

        //retornar datos en la vista editarPresupuesto
        if (isset($_SESSION['autorizado']) || $_SESSION['autorizado'] == 1) {                
            $this->vista('presupuestos/editarPresupuesto',$datos);
        } else {            
            die('Algo salio mal');
        }
    }    

        public function anadirPresupuesto() //borrar el otro
    {             
        
        $this->iniciar();
        if ($_SERVER['REQUEST_METHOD'] == "POST" || isset($_FILES['ficheroPresupuesto']['name']) ) {
          
           

            $datos = [
                "estado" => "creado",                
                "plantilla" => $_POST['tipoPesupuesto'], 
                "nombrePres" => $_POST['nombrePres'],
                "servicios" => $_POST['servicios'],                
                "fecha" => $_POST['fecha'],                
                "observaciones" => $_POST['observaciones'],                
                "html" => $_POST['editor3'],                
                "asignaAgente" => $_POST['asignaAgente']
            ];
            
            $importe = $_POST['importe'];
            $servicio = $_POST['servicio'];
            $accion = $_POST['accion'];
            $cliente = $_POST['clienteNuevo'];
            
            for ($i = 0; $i < count($cliente); $i++) {
                $datos2 = [
                    "idEMPRESA" => $_POST['clienteNuevo'],
                    "idServicio" => $_POST['servicioNuevo'],
                    "idAccion" => $_POST['accionNuevo'],
                    "importe" => $_POST['importeNuevo'],
                    //nuevo
                    "hPresenciales" => $_POST['hPresencialesNuevo'],
                    "hTeleformacion" => $_POST['hTeleformacionNuevo'],
                    "hAulaVirtual" => $_POST['hAulaVirtualNuevo'],
                    //
                    "horas" => $_POST['horasNuevo'],
                    "participantes" => $_POST['participantesNuevo'],
                    "modalidad" => $_POST['modalidadNuevo'],
                    "nivel" => $_POST['nivelNuevo']
                ];
            }                       

            $info = $this->Presupuesto->agregarPresupuesto($datos, $datos2);

            //si llegan un fichero
            if (isset($_FILES['ficheroPresupuesto']['name']) && $_FILES['ficheroPresupuesto']['tmp_name'] !='' ){
                
                $nombre=$_FILES['ficheroPresupuesto']['name'];
                $guardado=$_FILES['ficheroPresupuesto']['tmp_name'];
                
                $this->uploadFile($nombre,$guardado,$info,$_FILES['ficheroPresupuesto']['type'],$_POST['descripcionFichero']);
                //$info ['insert'] = $insert;
                /*[error] => 0 
                [size] => 154600 )*/                
            }            

            if (isset($_SESSION['autorizado']) || $_SESSION['autorizado'] == 1) {  
                $_SESSION['message'] = 'Se ha guardado corréctamente el presupuesto';                
                //$this->vista('presupuestos/editarPresupuesto',$info);
                                                    
            } else {            
                $_SESSION['message'] = 'Ha ocurrido un error y no se ha guardado el presupuesto';
            }
            //redireccionar('/presupuesto');
            redireccionar('/presupuesto/verPresupuestoEditar/'.$info);  

        }else{

            $datos = [
                "tipo" => "",
                "nombrePres" => "",
                "servicios" => "",
                "fechaIni" => "",
                "fechaFin" => "",
                "fechaIniFun" => "",
                "fechaFinFun" => "",
                "mesBonif" => "",
                "fecha" => "",                
                "observaciones" => "",               
                "html" => "",
            ];

            if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
                redireccionar('/login');
            } else {
                $_SESSION['message'] = 'Ha ocurrido un error y no se ha guardado el presupuesto';
                $this->vista('/presupuesto', $datos);
            }
        }
    }

    public function uploadFile($nombre,$guardado,$idPres,$tipo,$descripcion)
    {
        if(!file_exists(DOCUMENTOS_PRIVADOS.'presupuestos')){
            mkdir(DOCUMENTOS_PRIVADOS.'presupuestos',0777,true);
                if(file_exists(DOCUMENTOS_PRIVADOS.'presupuestos')){
                    if(move_uploaded_file($guardado, DOCUMENTOS_PRIVADOS.'presupuestos/'.$nombre)){
                        //echo "Archivo guardado con exito";
                        $confirma = true;                        
                    }else{
                        $confirma = false;                        
                         //echo "Archivo no se pudo guardar";
                    }
                }
        }else{
            if(move_uploaded_file($guardado, DOCUMENTOS_PRIVADOS.'presupuestos/'.$nombre)){
                $confirma = true;                
                //echo "Archivo guardado con exito";
            }else{
                $confirma = false;                
                //echo "Archivo no se pudo guardar";
            }
        }
        if ($confirma == true) {            
            $insert = $this->Presupuesto->insertarRegistroFichero($nombre,$idPres,$tipo,$descripcion);
            return $insert;
        }else{
            return false;
        }
    
    }

    public function descargarFichero($idDoc)
    {
        $this->iniciar();
       
        //consulto el fichero en la BD
        $row = $this->Presupuesto->obtenerDatosFichero($idDoc);
        if ($row) {
            $filename = $row->nombre;            
            $file = DOCUMENTOS_PRIVADOS."presupuestos/".$filename;
            $mime = mime_content_type($file);
            header('Content-disposition: attachment; filename='.str_replace(" ",'_',$filename));
            header('Content-type: '.$mime);
            readfile($file);
        }else{
            echo"FICHERO NO ENCONTRADO";
        }

    }    
    

    public function editarPresupuesto()
    {      
        
        $this->iniciar();
        if ($_SERVER['REQUEST_METHOD'] == "POST" || isset($_FILES['ficheroPresupuesto']['name']) ) {
        
            
        
            //array de los datos generales
            $datos = [
                "id" => $_POST['id'],
                "observaciones" => $_POST['observacionesEdit'], 
                "html" => $_POST['editor4'],
                "nombreProyecto" => $_POST['nombrePresEdit'],
                "asignaAgenteEdit" => $_POST['asignaAgenteEdit'],
                "nombrePresEdit" => $_POST['nombrePresEdit'],
                "fechaEdit" => $_POST['fechaEdit'],
                "tipoPesupuesto" => $_POST['tipoPesupuesto'],
                "importe" => $_POST['importe'],
                "importesNuevos" => $_POST['importeNuevo']
            ];            
            
            //array para líneas de presupuesto guardadas anteriormente
            if ($_POST['cliente']) {
                $cliente = $_POST['cliente'];
                
                $datos2 = [];
                $tmp = [];
                for ($i = 0; $i < count($cliente); $i++) {

                    $tmp = [
                        "idAccionPres" => $_POST['idAccionPres'][$i],
                        "idEMPRESA" => $_POST['cliente'][$i],
                        "idServicio" => $_POST['servicio'][$i],
                        "idAccion" => $_POST['accion'][$i],
                        "importe" => $_POST['importe'][$i],
                        "horas" => $_POST['horas'][$i],
                        "hPresenciales" => $_POST['hPresenciales'][$i],
                        "hTeleformacion" => $_POST['hTeleformacion'][$i],
                        "hAulaVirtual" => $_POST['hAulaVirtual'][$i],
                        "participantes" => $_POST['participantes'][$i],
                        "modalidad" => $_POST['modalidad'][$i],
                        "nivel" => $_POST['nivel'][$i],
                        "situacion" => $_POST['situacion'][$i]                        
                    ];
                    $datos2[] = $tmp;
                }
            }

            
            if ($_POST['actualizarProyecto']==1) {
               
                if ($this->Presupuesto->updatePresupuesto($datos, $datos2)) {                    
                    //si llega fichero:
                    if (isset($_FILES['ficheroPresupuesto']['name']) && $_FILES['ficheroPresupuesto']['tmp_name'] !='' ){
                        $nombre=$_FILES['ficheroPresupuesto']['name'];
                        $guardado=$_FILES['ficheroPresupuesto']['tmp_name'];                        
                        $this->uploadFile($nombre,$guardado,$datos['id'],$_FILES['ficheroPresupuesto']['type'],$_POST['descripcionFichero']);    
                    }

                    //array para líneas de presupuesto nuevas que vienen de la edición de presupuesto            
                    if ($_POST['clienteNuevo']) {
                        
                        $nuevosClientes = $_POST['clienteNuevo'];
                        
                        $datos3 = [];
                        $tmp2 = [];
                        for ($j = 0; $j < count($nuevosClientes); $j++) {
                            $tmp2 = [
                                /*"id" => $_POST['id'],*/
                                "idEMPRESA" => $_POST['clienteNuevo'][$j],
                                "idServicio" => $_POST['servicioNuevo'][$j],
                                "idAccion" => $_POST['accionNuevo'][$j],
                                "importe" => $_POST['importeNuevo'][$j],
                                "horas" => $_POST['horasNuevo'][$j],
                                "hPresenciales" => $_POST['hPresencialesNuevo'][$j],
                                "hTeleformacion" => $_POST['hTeleformacionNuevo'][$j],
                                "hAulaVirtual" => $_POST['hAulaVirtualNuevo'][$j],
                                "participantes" => $_POST['participantesNuevo'][$j],
                                "modalidad" => $_POST['modalidadNuevo'][$j],
                                "nivel" => $_POST['nivelNuevo'][$j],
                                "fechaInicio" => $_POST['fechaInicioNuevo'][$j],
                                "estatusNuevo" => $_POST['estatusNuevo'][$j]         
                            ];
                            $datos3[] = $tmp2;
                        }
                        $this->Presupuesto->agregarNuevasLineasPresupuesto($datos,$datos3);
                    }                                   

                    $_SESSION['message'] = 'Los datos se han actualizado corréctamente';                    
                    
                } else {
                    $_SESSION['message'] = 'Ha ocurrido un error y no se han actualizado los datos.';
                }                
                       
                
            }else {                
                $_SESSION['message'] = 'Ha ocurrido un error y no se han actualizado los datos.';
            }
            redireccionar('/presupuesto/verPresupuestoEditar/'.$datos['id']);

        }else {
            
            if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
                redireccionar('/login');
            } else {
                $_SESSION['message'] = 'Ha ocurrido un error y no se han actualizado los datos correctamente';
                redireccionar('/presupuesto');
            }
        }
    }


    //APROBACIONES Y RECHAZOS PARCIALES DE PRESUPUESTO Y CREACION DE PROYECTO

    public function aprobarPresupuesto()
    {      
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $datosPres = [
                "idpres" => $_POST['idpres'],
                "idaccion" => $_POST['idaccion'],
                "idaccionPres" => $_POST['idaccionPres'],
                "fechaInicio" => $_POST['fechaInicio'],
                "modalidad" => $_POST['modalidad'],
                "nivel" => $_POST['nivel'],
                "horas" => $_POST['horas'],
                "hAulaVirtual"=> $_POST['hAulaVirtual'],
                "hTeleformacion"=> $_POST['hTeleformacion'],
                "hPresenciales"=> $_POST['hPresenciales'],            
                "nombrePres" => $_POST['nombrePres']
            ];
        }

        //primero verifica si el presupuesto tiene proyecto generado
        $validarProy = $this->Presupuesto->validarProyecto($datosPres);
        
        //si no se ha generado el proyecto, que lo genere, cree accion_proyecto y devuelva true
        if ( $validarProy == '') {            
            //crear proyecto y fila correspondiente en acciones_proyecto            
            if ($this->Presupuesto->crearProyectoyAccionProyecto($datosPres)) {
                //actualiza estatus de la fila acciones_presupuesto aprobada            
                $filaAprobada = $this->Presupuesto->aprobarPresupuesto($datosPres);
            }
        }else if ( $validarProy > 0 ){
            //proyecto existe que cree fila correspondiente en acciones_proyecto
            if ($this->Presupuesto->crearAccionProyectoDesdeAccionPresupuesto($datosPres, $validarProy)) {
                //actualiza estatus de la fila acciones_presupuesto aprobada
                $filaAprobada = $this->Presupuesto->aprobarPresupuesto($datosPres);
            }
        }
        echo json_encode($filaAprobada);
    }

    public function rechazarPresupuesto()
    {      
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datosPres = [
                "idpres" => $_POST['idpres'],
                "idaccion" => $_POST['idaccion'],
                "fechaRechazo" => $_POST['fechaRechazo'],
            ];
        }        
        //actualiza estatus de acciones_presupuestos
        $filaRechazada = $this->Presupuesto->rechazarPresupuesto($datosPres);                
        echo json_encode($filaRechazada);        
    }    

    // ELIMINAR
    public function borrarPresupuesto()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
                        
            if (isset($_POST['id']) && $_POST['id'] != '') {

                $datos = [
                    "id" => $_POST['id']
                ];
                //condiciones para la eliminación de un presupuesto y sus acciones relacionadas:
                $estado = $this->Presupuesto->estadoPresupuesto($datos['id']);
                
                // solo se puede eliminar un presupuesto pendiente, no se puede eliminar un presupuesto pues hay otras tablas involucradas
                if ($estado->estado=='aprobado' || $estado->estado=='rechazado') {                    
                    redireccionar('/presupuesto');
                }else if ($estado->estado=='pendiente') {                    
                    try {
                        if ($this->Presupuesto->borrarPresupuesto($datos)) {
                            redireccionar('/presupuesto');
                        } else {
                            die('Algo salio mal');
                        }
                    } catch (PDOException $exception) {
                        redireccionar('/presupuesto');
                        return $exception->getMessage();
                    }
                }
            } else {
                die('Elige el presupuesto para eliminar');
            }
        } else {
            $datos = [
                "id" => ''
            ];
            if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
                redireccionar('/login');
            } else {
                $this->vista('/presupuesto', $datos);
            }
        }
    }


    public function actualizarCampoPresupuesto()
    {                     
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $tabla = $_POST['tabla'];
            $campo = $_POST['campo'];
            $contenido = $_POST['contenido'];
            $idtabla = $_POST['idtabla'];
            $id = $_POST['id'];
        }
        
        $resultado = $this->Presupuesto->actualizarCampoPresupuesto($tabla,$campo,$contenido,$idtabla,$id);
        print $resultado;
        
        
    }

    
    public function actualizarTipologiasPresupuestoYProyecto()
    {                     
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $contenido = $_POST['contenido'];
            $idAccionPres = $_POST['idAccionPres'];
            $idAccionProy = $_POST['idAccionProy'];            
        }
        
        $resultado = $this->Presupuesto->actualizarTipologiasPresupuestoYProyecto($contenido,$idAccionPres,$idAccionProy);
        print $resultado;                
    }    

    public function actualizarAccionEnPresupuestoYProyecto()
    { 
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $contenido = $_POST['contenido'];
            $idProyecto = $_POST['idProyecto'];                      
        }
        
        $resultado = $this->Presupuesto->actualizarAccionEnPresupuestoYProyecto($contenido,$idProyecto);
        print $resultado;                
    }    
    
    public function actualizarDiferentesCamposEnPresupuestoYProyecto()
    { 
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $contenido = $_POST['contenido'];
            $idProyecto = $_POST['idProyecto'];
            $campo = $_POST['campo'];
        }
        
        $resultado = $this->Presupuesto->actualizarDiferentesCamposEnPresupuestoYProyecto($contenido,$idProyecto,$campo);
        print $resultado;                
    }        
    
    public function actualizarImporteEnPresupuestoYProyecto()
    { 
        if ($_SERVER['REQUEST_METHOD'] == "POST") {            
            $importe = $_POST['importe'];
            $idAccionProy = $_POST['idAccionProy'];
            $idAccionPres = $_POST['idAccionPres'];
            $idPresupuesto = $_POST['idPresupuesto'];            
        }
        
        $resultado = $this->Presupuesto->actualizarImporteEnPresupuestoYProyecto($importe,$idAccionProy,$idAccionPres,$idPresupuesto);
        print $resultado;                
    }        

   


}
?>