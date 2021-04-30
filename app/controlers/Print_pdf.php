<?php
  require_once dirname(__FILE__).'/../../vendor/autoload.php';
         

  use Spipu\Html2Pdf\Html2Pdf;
  use Spipu\Html2Pdf\Exception\Html2PdfException;
  use Spipu\Html2Pdf\Exception\ExceptionFormatter;

  class Print_pdf extends Controlador{
    
  public function __construct()
  {
      // cargamos el modelo asociado a este controlador
      $this->PrintPdfModelo = $this->modelo('ModeloPdf');
  } 

  public function index(){
   

  }
  public function buscador($id){
  
 
    $this->iniciar();

    $observaciones = $this->PrintPdfModelo->verObservacionesFichaCliente($id);

    if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
      redireccionar('/login');
    }else{
      ob_start();
      require_once('../app/views/Pdfs/pdf_clientes.php');
      $html = ob_get_clean();
    
    $html2pdf = new Html2Pdf('P', 'A4', 'es', 'true', 'UTF-8');

    $html2pdf->writeHTML($html);
    $html2pdf->output('pdf_generated.pdf');

    } 
 

  }

}

?>
