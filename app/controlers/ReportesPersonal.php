<?php
    //require_once dirname(__FILE__).'/../../vendor/autoload.php';
    require '../public/vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class ReportesPersonal extends Controlador
{

    public function __construct()
    {       
        $this->ReportesPersonal = $this->modelo('ModeloReportesPersonal');
    } 

    public function cargarDatosFiltros(){
        $this->iniciar();
        $agentes = $this->ReportesPersonal->obtenerAgentes();
        $datos = [       
          'agentes' => $agentes          
        ];   
        return $datos;
  
    }

    public function reporteRegistroPersonalBuscador(){
        $this->iniciar();        
        $datos = $this->cargarDatosFiltros();
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
            $this->vista('reportesPersonal/reportesPersonal', $datos);
        }  
    }

    public function recibeFiltros()
    {
        //$this->iniciar();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

                $salida = "";                   

                    //  AGENTE
                    $salidaAgente = "";
                    if (!empty($_POST['agente'])) {
                        $agente = $_POST['agente'];
                        $salidaAgente = " AND ag.codagente IN (";
                        for ($i=0; $i <count($agente) ; $i++) {
                            if ($i != (count($agente)-1)) {
                                $salidaAgente .=  $agente[$i] . ",";
                            } else {
                                $salidaAgente .=  $agente[$i] . ")";
                            }
                        }
                    }


                    //  FECHA
                    $salidaTiempo = "";
                    
                    $fecha = "per.fecharegistro";

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
                    

                    //$consulta = $salida.$salidaTipo.$salidaGrupo;
                    $consulta = $salida.$salidaTiempo.$salidaAgente;
                                       
                    $datosLista = $this->ReportesPersonal->resultadoBuscadorRegistro($consulta);
                    
                    $datos = [
                        "salida" => $datosLista                      
                    ];

                    if(isset($_POST['export']) && $_POST['export']=='Export' ){                      
                        $this->exportarResgistropersonalExcel($datos);
                    }
                                                            
                    $this->vista('reportesPersonal/reporteRegistroPersonal', $datos);                    
                  
        }
    }


    public function exportarResgistropersonalExcel($datos)
    {

        $file = new Spreadsheet();

        $active_sheet = $file->getActiveSheet();

        //$resultado = $this->resultadoBuscadorFacturasIngreso($_POST);
        $sentencia = $datos['salida'];

        $active_sheet = $file->getActiveSheet();

        $active_sheet->setCellValue('A1', 'Agente');
        $active_sheet->setCellValue('B1', 'Fecha');
        $active_sheet->setCellValue('C1', 'Registro');        
      
        $count = 2;

        foreach($sentencia   as $row)
        {          
          $active_sheet->setCellValue('A' . $count, $row->nombreAgente);
          $active_sheet->setCellValue('B' . $count, (($row->fecharegistro)? date('d/m/Y H:i:s',strtotime($row->fecharegistro)): ''));
          $active_sheet->setCellValue('C' . $count, $row->tipo);
          $count = $count + 1;
        }
      
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, 'Xlsx');
        date_default_timezone_set("Europe/Madrid");
        $file_name = date('Y-m-d_H_i_s') . 'ReporteRegistroPersonal' . '.' . strtolower('Xlsx');
      
        $writer->save($file_name);
      
        header('Content-Type: application/x-www-form-urlencoded');
      
        header('Content-Transfer-Encoding: Binary');
      
        header("Content-disposition: attachment; filename=\"".$file_name."\"");
      
        readfile($file_name);
      
        unlink($file_name);
      
        exit;
    }

}