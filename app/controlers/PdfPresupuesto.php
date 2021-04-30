<?php
  require_once dirname(__FILE__).'/../../vendor/autoload.php';
         

  use Spipu\Html2Pdf\Html2Pdf;
  use Spipu\Html2Pdf\Exception\Html2PdfException;
  use Spipu\Html2Pdf\Exception\ExceptionFormatter;

  class PdfPresupuesto extends Controlador{
    
 
    public function __construct()
    {
        // cargamos el modelo asociado a este controlador
        $this->PrintPdfPresupuesto = $this->modelo('ModeloPresPdf');
    } 
  

    public function index(){
    

    }


    public function buscadorpresupuesto(){
      
      $this->iniciar();

      if($_SERVER['REQUEST_METHOD'] == "POST"){
                
          $datos = [
              "id" => $_POST['idpresupuesto'],
              "idacc" => $_POST['idAccionPres'],

          ];

          if ($_POST['idpresupuesto'] && $_POST['idAccionPres']) {
            $presupuesto2 = $this->PrintPdfPresupuesto->verDatosPresupuestoAccion($datos);
          }else{
            $presupuesto = $this->PrintPdfPresupuesto->verDatosPresupuesto($datos['id']);
          }
      
  
          if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
          }else{
            ob_start();          
            require_once('../app/views/Pdfs/pdf_presupuesto.php');
            require_once('../app/views/Pdfs/pdf_presupuesto2.php');
            $html = ob_get_clean();          
            $html2pdf = new Html2Pdf('P', 'A4', 'es', true, 'UTF-8');        
            $html2pdf->writeHTML($html);        
            if(isset($_POST['crearyenviar'])){
              $html2pdf->output('pdf_generated.pdf');
              $attachment = $html2pdf->output('pdf_generated.pdf', 'S');
              require '../app/views/Emails/EmailPresupuesto.php';
            }else{
              $html2pdf->output('pdf_generated.pdf');
            }
        
          } 
  

      }else  if($_SERVER['REQUEST_METHOD'] == "GET"){ // SACAR PDF DESDE LA PAGINA DE SEGUIMIENTO PRESUPUESTO
                
          $datos = [
              "id" => $_GET['id'],    
          ];
      
        $presupuesto = $this->PrintPdfPresupuesto->verDatosPresupuesto($datos['id']);

        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
          redireccionar('/login');
        }else{
          ob_start();
          require_once('../app/views/Pdfs/pdf_presupuesto.php');
          $html = ob_get_clean();
        
          $html2pdf = new Html2Pdf('P', 'A4', 'es', true, 'UTF-8');

          $html2pdf->writeHTML($html);

          if(isset($_POST['crearyenviar'])){
            $html2pdf->output('pdf_generated.pdf');
            $attachment = $html2pdf->output('pdf_generated.pdf', 'S');
            require '../app/views/Emails/EmailPresupuesto.php';
          }else{
            $html2pdf->output('pdf_generated.pdf');
          }

        } 

      }

    } 
  }

?>
