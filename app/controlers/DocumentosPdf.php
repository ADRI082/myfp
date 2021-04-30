<?php


class DocumentosPdf extends Controlador {

    public function __construct() {
        $this->ModelProyecto = $this->modelo('ModeloProyecto');
    
    }

    public function index() {

        generarPdf::documentoPDF('P','A4','es',true,'UTF-8',array(10,20,8,10),true, 'documentos/facturaPrueba/','ejemplo.php');
    }

    public function exportarDiploma($id) {

        $datos = $this->ModelProyecto->obtenerDatosPdfDiploma($id);
        
        generarPdf::documentoPDF('L','A4','es',true,'UTF-8',array(10,20,8,10),true, 'documentos/diploma/','prueba.php',$datos);
    }

    public function exportarDocProyecto($id, $doc, $cli) {        
        
        $datos = $this->ModelProyecto->exportarPdfDocProyecto($id,$cli);
        if ($doc == '1') {
            $filename = 'parteFirmasSinLogo.php';
        }else if ($doc == '2') {
            $filename = 'parteFirmasConLogo.php';
        }else if ($doc == '3') {
            $filename = 'RecibiMaterialSinLogo.php';
        }else if ($doc == '4') {
            $filename = 'RecibiMaterialConLogo.php';
        }else if ($doc == '5') {
            $filename = 'RecibiDiplomaSinLogo.php';
        }else if ($doc == '6') {
            $filename = 'RecibiDiplomaConLogo.php';
        }
        generarPdf::documentoPDF('P','A4','es',true,'UTF-8',array(20,10,8,10),true, 'documentos/formulariosProyecto/',$filename,$datos);
    }

   
}