<?php
    //require_once dirname(__FILE__).'/../../vendor/autoload.php';
    require '../public/vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class ReportesProyecto extends Controlador
{

    public function __construct()
    { 
       
        // cargamos el modelo asociado a este controlador
        $this->ReportesProyecto = $this->modelo('ModeloReportesProyecto');
    } 

    public function cargarDatosFiltros(){
        $this->iniciar();
        $clientes = $this->ReportesProyecto->obtenerClientes();
        $servicio = $this->ReportesProyecto->obtenerServicio();
        $grupos = $this->ReportesProyecto->obtenerGrupos();
        $acciones = $this->ReportesProyecto->obtenerAcciones();
        $tipologia = $this->ReportesProyecto->obtenerTipologia();
        $agentes = $this->ReportesProyecto->obtenerAgentes();
        $colaboradores = $this->ReportesProyecto->obtenerColaboradores();
        $datos = [
          'clientes' => $clientes,
          'servicio' => $servicio,
          'grupos' => $grupos,
          'acciones' => $acciones,
          'tipologia' => $tipologia,
          'agentes' => $agentes,
          'colaboradores' => $colaboradores
        ];   
        return $datos;
  
    }

    public function reporteFacturacionBuscador(){
        $this->iniciar();        
        $datos = $this->cargarDatosFiltros();
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
            $this->vista('reportesProyecto/reportesProyecto', $datos);
        }  
    }

    // PARA CAMBIAR CON AJAX
    public function getClienteSelect()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $id = $_POST['id'];
        }
        $salida = "";
        $grupo = $_POST['id'];
        for ($i=0; $i <count($grupo) ; $i++) { 
         $salida.= " OR idGrupo = ".$grupo[$i] . " ";
        }
        $clienteselect = $this->ReportesProyecto->obtenerClientesSelect($salida);
        $resultado = "";
        foreach ($clienteselect as $row) {

            $resultado .= "<option value='" . $row->idEMPRESA . "'>" . $row->NOMBREJURIDICO . "</option>";
        }
        echo $resultado;
    }
    public function getAccionSelect()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $id = $_POST['id'];
        }
        $salida = "";
        $servicio = $_POST['id'];
        for ($i=0; $i <count($servicio) ; $i++) { 
         $salida.= " OR idServicio = ".$servicio[$i] . " ";
        }
        $accionselect = $this->ReportesProyecto->obtenerAccionSelect($salida);
        $resultado = "";
        foreach ($accionselect as $row) {

            $resultado .= "<option value='" . $row->idACCION . "'>" . $row->NOMBREACCION . "</option>";
        }
        echo $resultado;
    }
    // FIN

    //public function resultadoBuscadorFacturasIngreso($post)
    public function recibeFiltros()
    {
        //$this->iniciar();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
                if(isset($_POST['tipoReporte']) ){
                    $tipoReporte = $_POST['tipoReporte'];
                }

                $salida = "";
                   
                    //    TIPOLOGÍA
                    $salidaTipo = "";
                    if (!empty($post['tipo'])) {
                        $tipo = $post['tipo'];
                        for ($i=0; $i < count($tipo) ; $i++) {
                            $salidaTipo = " AND apre.idServicio IN (";
                            for ($i=0; $i <count($tipo) ; $i++) {
                                if ($i != (count($tipo)-1)) {
                                    $salidaTipo .= $tipo[$i]  . ",";
                                } else {
                                    $salidaTipo .=  $tipo[$i] . ")";
                                }
                            }
                        }
                    }
                        
                    //  GRUPO
                    $salidaGrupo = "";
                    if (!empty($_POST['grupo'])) {
                        $grupo = $_POST['grupo'];
                        $salidaGrupo = " AND gru.idGrupo IN (";
                        for ($i=0; $i <count($grupo) ; $i++) {
                            if ($i != (count($grupo)-1)) {
                                $salidaGrupo .=  $grupo[$i] . ",";
                            } else {
                                $salidaGrupo .=  $grupo[$i] . ")";
                            }
                        }
                    }
                    
                    //  EMPRESA
                    $salidaEmpresa = "";
                    if (!empty($_POST['empresa'])) {
                        $empresa = $_POST['empresa'];
                        if ($tipoReporte == 'ingresos' || $tipoReporte =='reporteIngAsesor' || $tipoReporte =='reporteCobradas' || $tipoReporte =='reporteSinCobrar') {
                            $salidaEmpresa = " AND fac.idempresa IN (";
                        }else if ($tipoReporte == 'gastos' || $tipoReporte =='reporteGastosAsesor' || $tipoReporte =='reportePagadas' || $tipoReporte =='reporteSinPagar') {
                            $salidaEmpresa = " AND cli.idEMPRESA IN (";
                        }
                        
                        for ($i=0; $i <count($empresa) ; $i++) {
                            if ($i != (count($empresa)-1)) {
                                $salidaEmpresa .=  $empresa[$i] . ",";
                            } else {
                                $salidaEmpresa .=  $empresa[$i] . ")";
                            }
                        }
                    }

                    //  AGENTE
                    $salidaAgente = "";
                    if (!empty($_POST['agente'])) {
                        $agente = $_POST['agente'];
                        $salidaAgente = " AND agcli.idAgente IN (";
                        for ($i=0; $i <count($agente) ; $i++) {
                            if ($i != (count($agente)-1)) {
                                $salidaAgente .=  $agente[$i] . ",";
                            } else {
                                $salidaAgente .=  $agente[$i] . ")";
                            }
                        }
                    }

                    //COLABORADOR
                    $salidaColaborador = "";
                    if (!empty($_POST['colaborador'])) {
                        $colaborador = $_POST['colaborador'];
                        $salidaColaborador = " AND col.idColaborador IN (";
                        for ($i=0; $i <count($colaborador) ; $i++) {
                            if ($i != (count($colaborador)-1)) {
                                $salidaColaborador .=  $colaborador[$i] . ",";
                            } else {
                                $salidaColaborador .=  $colaborador[$i] . ")";
                            }
                        }
                    }
                                       
                    

                    //  SERVICIO
                    $salidaServicio = "";
                    if (!empty($_POST['servicio'])) {
                        $servicio = $_POST['servicio'];
                        //$salidaServicio = " AND  apre.idServicio IN (";
                        $salidaServicio = " AND  pres.idServicios IN (";
                        
                        for ($i=0; $i <count($servicio) ; $i++) {
                            if ($i != (count($servicio)-1)) {
                                $salidaServicio .=  $servicio[$i] . ",";
                            } else {
                                $salidaServicio .=  $servicio[$i] . ")";
                            }
                        }
                    }
                    // ACCION
                    $salidaAccion = "";
                    if (!empty($_POST['accion'])) {
                        $accion = $_POST['accion'];
                        $salidaAccion = " AND apre.idACCION IN (";
                        for ($i=0; $i <count($accion) ; $i++) {
                            if ($i != (count($accion)-1)) {
                                $salidaAccion .=  $accion[$i] . ",";
                            } else {
                                $salidaAccion .=  $accion[$i] . ")";
                            }
                        }
                    }

                    //  FECHA
                    $salidaTiempo = "";
                    
                    if ($tipoReporte == 'ingresos' || $tipoReporte =='reporteIngAsesor' || $tipoReporte =='reporteCobradas' || $tipoReporte =='reporteSinCobrar') {
                        $fecha = "fac.fechafactura";
                    }else if ($tipoReporte == 'gastos' || $tipoReporte =='reporteGastosAsesor' || $tipoReporte =='reportePagadas' || $tipoReporte =='reporteSinPagar') {
                        $fecha = "gas.fecha ";
                    }
                    if (!empty($_POST['desde']) and !empty($_POST['hasta'])) {
                        $desde = $_POST['desde'];
                        $hasta = $_POST['hasta'];
                        $salidaTiempo = "AND ".$fecha." >= '$desde' AND ".$fecha." <= '$hasta'";
                    }
                    if (!empty($_POST['desde']) and empty($_POST['hasta'])) {
                        $desde = $_POST['desde'];
                        $salidaTiempo = "AND ".$fecha." >= '$desde'";                        
                    }
                    if (empty($_POST['desde']) and !empty($_POST['hasta'])) {
                        $hasta = $_POST['hasta'];
                        $salidaTiempo = " AND ".$fecha." <= '$hasta'";                                                
                    }
                    
               
                    //  IMPORTE
                    $salidaImporte = "";
                    if ($tipoReporte == 'ingresos' || $tipoReporte =='reporteIngAsesor' || $tipoReporte =='reporteCobradas' || $tipoReporte =='reporteSinCobrar') {
                        $fecha = " AND fechafactura IN (";
                    }else if ($tipoReporte == 'gastos' || $tipoReporte =='reporteGastosAsesor' || $tipoReporte =='reportePagadas' || $tipoReporte =='reporteSinPagar') {
                        $fecha = " AND gas.fecha IN (";
                    }
                    if (!empty($_POST['importeMin']) and empty($_POST['importeMax'])) {
                        $importeMin = $_POST['importeMin'];
                        $salidaImporte = "AND total >= '$importeMin'";
                    }
                    if (empty($_POST['importeMin']) and !empty($_POST['importeMax'])) {
                        $importeMax = $_POST['importeMax'];
                        $salidaImporte = "AND  total <= '$importeMax'";
                    }
                    if (!empty($_POST['importeMin']) and !empty($_POST['importeMax'])) {
                        $importeMin = $_POST['importeMin'];
                        $importeMax = $_POST['importeMax'];
                        $salidaImporte = "AND total >= '$importeMin' AND total <= '$importeMax'";
                    }

                    //$consulta = $salida.$salidaTipo.$salidaGrupo;
                    $consulta = $salida .$salidaTipo.$salidaGrupo.$salidaEmpresa.$salidaServicio.$salidaAccion.$salidaTiempo.$salidaImporte.$salidaAgente.$salidaColaborador;
                    
                    switch ($tipoReporte) {
                        case 'ingresos':
                            $metodo = 'resultadoBuscadorFacturasIngreso';
                            $vista = 'reporteFacturasProyecto';
                            break;
                        case 'gastos':
                                $metodo = 'resultadoBuscadorFacturasGasto';
                                $vista = 'reporteGastosProyecto';
                                break;
                        case 'reporteIngAsesor':
                            $metodo = 'resultadoBuscadorFacturasIngreso';
                            $vista = 'reporteFactIngresosParaAsesor';
                            break;
                        case 'reporteGastosAsesor':
                            $metodo = 'resultadoBuscadorFacturasGasto';
                            $vista = 'reporteFactGastosParaAsesor';
                            break;                            
                        case 'reporteCobradas':
                            $metodo = 'resultadoBuscadorFacturasIngreso';
                            $vista = 'reporteFacturasProyecto';
                            $cond = 'AND fac.fechacobro IS NOT null AND fac.fechacobro <>0 ';
                            break;
                        case 'reporteSinCobrar':
                            $metodo = 'resultadoBuscadorFacturasIngreso';
                            $vista = 'reporteFacturasProyecto';
                            $cond = 'AND (fac.fechacobro IS NULL OR fac.fechacobro=0)';
                            break;
                        case 'reportePagadas':
                            $metodo = 'resultadoBuscadorFacturasGasto';
                            $vista = 'reporteGastosProyecto';
                            $cond = 'AND gas.fechapago IS NOT null AND gas.fechapago<>0';
                            break;
                        case 'reporteSinPagar':
                            $metodo = 'resultadoBuscadorFacturasGasto';
                            $vista = 'reporteGastosProyecto';
                            $cond = 'AND (gas.fechapago IS NULL OR gas.fechapago=0)';
                            break;       
                        case 'resumenFinanciero':
                            $metodo = 'resultadoResumenFinanciero';
                            $vista = 'reporteResumenFinanciero';                            
                            break;                                                
                        
                        default:
                        $metodo = 'resultadoBuscadorFacturasIngreso';
                        $vista = 'reporteFacturasProyecto';
                        break;
            
                    }
                    $datosLista = $this->ReportesProyecto->$metodo($consulta,$cond);
                    
                    $datos = [
                        "salida" => $datosLista,
                        "tipoReporte" => $tipoReporte
                    ];

                                                
                    if(isset($_POST['export']) && $_POST['export']=='Export' ){
                        if ($tipoReporte == 'ingresos') {
                            $this->exportarListaFactIngresosParaAsesor($datos);
                        }else if ($tipoReporte == 'gastos') {
                            $this->exportarListaFactGastosParaAsesor($datos);
                        }else if ($tipoReporte == 'reporteIngAsesor') {
                            $this->exportarListaFactIngresosParaAsesor($datos);
                        }else if ($tipoReporte == 'reporteGastosAsesor') {
                            $this->exportarListaFactGastosParaAsesor($datos);
                        }
                        
                    }else{
                        $this->vista('/reportesProyecto/'.$vista, $datos);
                    }
                  
        }
    }

    
    public function exportarListaFactIngresosParaAsesor($datos)
    {

        $file = new Spreadsheet();

        $active_sheet = $file->getActiveSheet();

        //$resultado = $this->resultadoBuscadorFacturasIngreso($_POST);
        $sentencia = $datos['salida'];

        $active_sheet = $file->getActiveSheet();

        $active_sheet->setCellValue('A1', 'Fecha factura');
        $active_sheet->setCellValue('B1', 'CIF');
        $active_sheet->setCellValue('C1', 'Denominación');
        $active_sheet->setCellValue('D1', 'Código Postal');
        $active_sheet->setCellValue('E1', 'Provincia');
        $active_sheet->setCellValue('F1', 'Base Imponible');
        $active_sheet->setCellValue('G1', 'Tipo IVA');
        $active_sheet->setCellValue('H1', 'Cuota IVA');
        $active_sheet->setCellValue('I1', 'Importe Total');
        $active_sheet->setCellValue('J1', 'Num. Factura');
        $active_sheet->setCellValue('K1', 'Canal');
      
        $count = 2;

        foreach($sentencia   as $row)
        {
            $valorIva = ($row->iva * $row->importe) /100;
          $active_sheet->setCellValue('A' . $count, $row->fechafactura);
          $active_sheet->setCellValue('B' . $count, $row->CIFCLIENTE);
          $active_sheet->setCellValue('C' . $count, $row->NOMBREJURIDICO);
          $active_sheet->setCellValue('D' . $count, $row->CODPOSTAL);
          $active_sheet->setCellValue('E' . $count, $row->PROVINCIA);
          $active_sheet->setCellValue('F' . $count, $this->formatoPrecio($row->importe));
          $active_sheet->setCellValue('G' . $count, $this->formatoPrecio($row->iva));
          $active_sheet->setCellValue('H' . $count, $this->formatoPrecio($valorIva));
          $active_sheet->setCellValue('I' . $count, $this->formatoPrecio($row->total));
          $active_sheet->setCellValue('J' . $count, $row->numfactura);
          $active_sheet->setCellValue('K' . $count, $row->nombreServicio);
          $count = $count + 1;
        }
      
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, 'Xlsx');
        date_default_timezone_set("Europe/Madrid");
        $file_name = date('Y-m-d_H_i_s') . 'FacturasIngreso' . '.' . strtolower('Xlsx');
      
        $writer->save($file_name);
      
        header('Content-Type: application/x-www-form-urlencoded');
      
        header('Content-Transfer-Encoding: Binary');
      
        header("Content-disposition: attachment; filename=\"".$file_name."\"");
      
        readfile($file_name);
      
        unlink($file_name);
      
        exit;
    }

    public function exportarListaFactGastosParaAsesor($datos)
    {
        
        $file = new Spreadsheet();

        $active_sheet = $file->getActiveSheet();

        //$resultado = $this->resultadoBuscadorFacturasIngreso($_POST);
        $sentencia = $datos['salida'];
        
        $active_sheet = $file->getActiveSheet();

        $active_sheet->setCellValue('A1', 'Fecha factura');
        $active_sheet->setCellValue('B1', 'CIF');
        $active_sheet->setCellValue('C1', 'Denominación');
        $active_sheet->setCellValue('D1', 'Código Postal');
        $active_sheet->setCellValue('E1', 'Provincia');
        $active_sheet->setCellValue('F1', 'Base Imponible');
        $active_sheet->setCellValue('G1', 'Tipo IVA');
        $active_sheet->setCellValue('H1', 'Cuota IVA');
        $active_sheet->setCellValue('I1', 'Tipo IRPF');
        $active_sheet->setCellValue('J1', 'Cuota IRPF');
        $active_sheet->setCellValue('K1', 'Importe Total');
        $active_sheet->setCellValue('L1', 'Num. Factura');
        $active_sheet->setCellValue('M1', 'Canal');
      
        $count = 2;

        foreach($sentencia   as $row)
        {
            $valorIva = ($row->iva * $row->importe) /100;
            $valorIrpf = ($row->irpf * $row->importe) /100;
            
            $active_sheet->setCellValue('A' . $count, $row->fecha);
            $active_sheet->setCellValue('B' . $count, $row->cif);
            $active_sheet->setCellValue('C' . $count, $row->nombreProveedor);
            $active_sheet->setCellValue('D' . $count, $row->codPostal);
            $active_sheet->setCellValue('E' . $count, $row->provincia);
            $active_sheet->setCellValue('F' . $count, $this->formatoPrecio($row->importe));
            $active_sheet->setCellValue('G' . $count, $this->formatoPrecio($row->iva));
            $active_sheet->setCellValue('H' . $count, $this->formatoPrecio($valorIva));
            $active_sheet->setCellValue('I' . $count, $this->formatoPrecio($row->irpf));
            $active_sheet->setCellValue('J' . $count, $this->formatoPrecio($valorIrpf));
            $active_sheet->setCellValue('K' . $count, $this->formatoPrecio($row->total));
            $active_sheet->setCellValue('L' . $count, $row->numfacgasto);
            $active_sheet->setCellValue('M' . $count, $row->nombreServicio);
            $count = $count + 1;
        }
      
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, 'Xlsx');
        date_default_timezone_set("Europe/Madrid");
        $file_name = date('Y-m-d_H_i_s') . 'FacturasGasto' . '.' . strtolower('Xlsx');
      
        $writer->save($file_name);
      
        header('Content-Type: application/x-www-form-urlencoded');
      
        header('Content-Transfer-Encoding: Binary');
      
        header("Content-disposition: attachment; filename=\"".$file_name."\"");
      
        readfile($file_name);
      
        unlink($file_name);
      
        exit;
    }

    public function formatoPrecio($num,$dec=2){
        $ret = number_format($num,$dec,',','.');
        return $ret;
    }

}