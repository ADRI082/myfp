<?php


class Datatabless extends Controlador
{

    

    public function __construct()
    {
        $this->DatatableModeloSS = $this->modelo('ModeloDatatableSS');

    }

    //// ACCIONES SS ////

    public function acciones()
    {

      $servicio = $this->DatatableModeloSS->obtenerServicio();
      $tipoAccion = $this->DatatableModeloSS-> obtenerTipoAccion();
      $modalidad = $this->DatatableModeloSS-> obtenerModalidad();
      $areaFormativa = $this->DatatableModeloSS->obtenerAreaFormativa();

      $datos = [
        'servicio' => $servicio,
        'tipoAccion' => $tipoAccion,
        'modalidad' => $modalidad,
        'areaFormativa' => $areaFormativa,        
      ];

        $this->iniciar();

        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
          redireccionar('/login');
        } else {
          $this->vista('datatabless/acciones', $datos);
        }
    }

    public function getAcciones()
    {
        $acciones = $this->DatatableModeloSS->obtenerAcciones();
        echo $acciones;
    }

    public function agregarAccion()
    {
      $this->iniciar();

      if($_SERVER['REQUEST_METHOD'] == "POST" || isset($_FILES['ficheroAcciones']['name']) ){
        $datos = [
          'nombreAccion' => $_POST['nombreAccion'],
          'servicio' => $_POST['servicio'],
          'modalidad' => $_POST['modalidad'],
          'tipoAccion' => $_POST['tipoAccion'],
          'areaFormativa' => $_POST['areaFormativa'],
          'objetivoAccion' => $_POST['objetivoAccion'],
          'metodologia' => $_POST['metodologia'],
          'contenido' => $_POST['contenido'],
          'observacionesAccion' => $_POST['observacionesAccion'],          
        ];
        
        $idNuevaAccion = $this->DatatableModeloSS->agregarAccion($datos);
     

        //si llegan un fichero
        if (isset($_FILES['ficheroAcciones']['name']) && $_FILES['ficheroAcciones']['tmp_name'] !='' ){
          $nombre= $idNuevaAccion."_".$_FILES['ficheroAcciones']['name'];
          $guardado=$_FILES['ficheroAcciones']['tmp_name'];

          $this->uploadFile($nombre,$guardado,$idNuevaAccion,$_FILES['ficheroAcciones']['type'],$_POST['descripcionFichero']);
                 
        }           

          if ($idNuevaAccion >0 && $idNuevaAccion !='') {
            $_SESSION['message'] = 'Los datos se han actualizado corréctamente';
          }else{
            $_SESSION['message'] = 'Ha ocurrido un error y no se han actualizado los datos.';
          }
          
      }else{        
          $datos = [
            'nombreAccion' => '',
            'servicio' => '',
            'modalidad' => '',
            'areaFormativa' => '',
            'objetivoAccion' => '',
            'metodologia' => '',
            'contenido' => '',
            'observacionesAccion' => '',
          ];
          $_SESSION['message'] = 'Ha ocurrido un error y no se han actualizado los datos.';
      }

                    
      if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
        redireccionar('/login');
      } else {        
        redireccionar('/datatabless/acciones');                  
      }

    }

    public function uploadFile($nombre,$guardado,$idAccion,$tipo,$descripcion)
    {
        if(!file_exists(DOCUMENTOS_PRIVADOS.'acciones')){
            mkdir(DOCUMENTOS_PRIVADOS.'acciones',0777,true);
                if(file_exists(DOCUMENTOS_PRIVADOS.'acciones')){
                    if(move_uploaded_file($guardado, DOCUMENTOS_PRIVADOS.'acciones/'.$nombre)){
                        //echo "Archivo guardado con exito";
                        $confirma = true;                        
                    }else{
                        $confirma = false;                        
                         //echo "Archivo no se pudo guardar";
                    }
                }
        }else{
            if(move_uploaded_file($guardado, DOCUMENTOS_PRIVADOS.'acciones/'.$nombre)){
                $confirma = true;                
                //echo "Archivo guardado con exito";
            }else{
                $confirma = false;                
                //echo "Archivo no se pudo guardar";
            }
        }
        if ($confirma == true) {            
            $this->DatatableModeloSS->insertarRegistroFichero($nombre,$idAccion,$tipo,$descripcion);
            return true;
        }else{
            return false;
        }
    
    }

    public function descargarFichero($idDoc)
    {
        $this->iniciar();
       
        //consulto el fichero en la BD
        $row = $this->DatatableModeloSS->obtenerDatosFichero($idDoc);
        if ($row) {
            $filename = $row->nombre;
            $file = DOCUMENTOS_PRIVADOS."acciones/".$filename;
            $mime = mime_content_type($file);
            header('Content-disposition: attachment; filename='.str_replace(" ", '_', $filename));
            header('Content-type: '.$mime);
            readfile($file);
        } else {
            echo"FICHERO NO ENCONTRADO";
        }
    }

    public function getAccionesUpdate()
    {
      if($_SERVER['REQUEST_METHOD'] == "POST"){
          $id = $_POST['id'];
      }
      $fila = $this->DatatableModeloSS->getAccionesUpdate($id);
      echo json_encode($fila);

    }  

    public function editarAccion(){

      $this->iniciar();
      if($_SERVER['REQUEST_METHOD'] == "POST" || isset($_FILES['ficheroAccionesEdit']['name']) ){

          $datos = [
              'id' => $_POST['idEdit'],
              'nombreAccion' => $_POST['nombreAccionEdit'],
              'servicio' => $_POST['servicioEdit'],
              'modalidad' => $_POST['modalidadEdit'],
              'tipoAccion' => $_POST['tipoAccionEdit'],
              'areaFormativa' => $_POST['areaFormativaEdit'],
              'objetivoAccion' => $_POST['objetivoAccionEdit'],
              'metodologia' => $_POST['metodologiaEdit'],
              'contenido' => $_POST['contenidoEdit'],
              'observacionesAccion' => $_POST['observacionesAccionEdit']
          ];          

          if($this->DatatableModeloSS->editarAccion($datos)){    
            

            //si llegan un fichero
            if (isset($_FILES['ficheroAccionesEdit']['name']) && $_FILES['ficheroAccionesEdit']['tmp_name'] !='' ){
              $nombre= $_POST['idEdit']."_".$_FILES['ficheroAccionesEdit']['name'];
              $guardado=$_FILES['ficheroAccionesEdit']['tmp_name'];

              $this->uploadFile($nombre,$guardado,$_POST['idEdit'],$_FILES['ficheroAccionesEdit']['type'],$_POST['descripcionFicheroEdit']);
                    
            }              
            
            $_SESSION['message'] = 'Los datos se han actualizado corréctamente';
                        
          } else {              
            $_SESSION['message'] = 'Ha ocurrido un error y no se han actualizado los datos.';
          }
      }else {

        $datos = [
          'id' => '',
          'nombreAccion' => '',
          'servicio' => '',
          'modalidad' => '',
          'tipoAccion' => '',
          'areaFormativa' => '',
          'objetivoAccion' => '',
          'metodologia' => '',
          'contenido' => '',
          'observacionesAccion' => '',
        ];
        $_SESSION['message'] = 'Ha ocurrido un error y no se han actualizado los datos.';
      }

                          
      if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
        redireccionar('/login');
      } else {        
        redireccionar('/datatabless/acciones');                  
      }
  }

  public function borrarAccion(){

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        if( isset($_POST['id']) && $_POST['id'] != ''){
          $datos = [
            "id" => $_POST['id']
          ];
          try
          {         
            if($this->DatatableModeloSS->borrarAccion($datos)){
              redireccionar('/datatabless/acciones');
            } else {
                die('Algo salio mal');
            }  
          }     
          catch(PDOException $exception){  
            redireccionar('/datatabless/acciones');
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
        $this->vista('/datatabless/acciones', $datos);           
      }
    }
}


    /// END ACCIONES SS /////

 
}
