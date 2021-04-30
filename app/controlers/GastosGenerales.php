<?php


class GastosGenerales extends Controlador
{
    public function __construct()
    {
        $this->ModelGastosGenerales = $this->modelo('ModeloGastosGenerales');        
    }

    public function index()
    {
        $this->iniciar();

        $tipoGastos = $this->ModelGastosGenerales->obtenerTipoGastos();
        $proveedores = $this->ModelGastosGenerales->obtenerTodosLosProveedores();
        $iban = $this->ModelGastosGenerales->obtenerCuentasBancarias();
        $tiposIva = $this->ModelGastosGenerales->obtenerTiposIva();
        $gastosGenerales = $this->ModelGastosGenerales->obtenerGastosGenerales();

        $datos = [
          'tipoGastos' => $tipoGastos,
          'proveedores' => $proveedores,
          'iban' => $iban,
          'gastosGenerales' => $gastosGenerales,
          'tiposIva' => $tiposIva
        ];
              
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
            $this->vista('gastosGenerales/gastosGenerales', $datos);
        }
    }

    public function obtenerAreasInforma()
    {                      
        $areas = $this->ModelGastosGenerales->obtenerAreasInforma();
        echo json_encode($areas);
    }

    public function obtenerProyectosPorServicio()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $idArea = $_POST['idArea'];            
        }
        $proyectos = $this->ModelGastosGenerales->obtenerProyectosPorServicio($idArea);
        echo json_encode($proyectos);
    }

    public function agregarGastosGenerales()
    {     
        session_start();
        if(isset($_POST['guardar'])){                   
       
                if($this->ModelGastosGenerales->agregarGastosGenerales($_POST)){
                    $_SESSION['message'] = 'Se ha guardado corréctamente la factura de gasto';                    
                } else {                        
                    $_SESSION['message'] = 'Ha ocurrido un error y no se ha guardado la factura';
                }
                redireccionar('/gastosGenerales');
        } else {              
            if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
                redireccionar('/login');
            } else {   
                $_SESSION['message'] = 'Ha ocurrido un error y no se ha guardado la factura';             
                redireccionar('/gastosGenerales');
            }
        }
        
    }

    public function obtenerFacturaGastoDetallada()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $idFactura = $_POST['idFactura'];            
        }
        $gastos = $this->ModelGastosGenerales->obtenerFacturaGastoDetallada($idFactura);
        echo json_encode($gastos);
    }

    public function eliminarAsignacionArea()
    {        
        if ($_POST['idArea'] && $_POST['idGasto']){
            $gastos = $this->ModelGastosGenerales->eliminarAsignacionArea($_POST);
            echo json_encode($gastos);
        }
    }

    public function eliminarAsignacionAreaYProyecto()
    {
        if ($_POST['idGasto'] && $_POST['idaccionproy']){
            $gastos = $this->ModelGastosGenerales->eliminarAsignacionAreaYProyecto($_POST);
            echo json_encode($gastos);
        }
    }

    public function updateDatosFacturaGasto()
    {                
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $tabla = $_POST['tabla'];
            $campo = $_POST['campo'];
            $contenido = $_POST['contenido'];
            $idtabla = $_POST['idtabla'];
            $id = $_POST['id'];
        }
        
        $resultado = $this->ModelGastosGenerales->updateDatosFacturaGasto($tabla,$campo,$contenido,$idtabla,$id);
        print $resultado;
        
    }

    public function eliminarGasto()
    {
        if ($_POST['idGasto']){
            $gastos = $this->ModelGastosGenerales->eliminarGasto($_POST);
            echo json_encode($gastos);
        }
    }

    public function cuentasContables()
    {
        $this->iniciar();
        $cuentasContables = $this->ModelGastosGenerales->obtenerCuentasContables();

        $datos = [
          'cuentasContables' => $cuentasContables         
        ];
              
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
            $this->vista('gastosGenerales/cuentasContables', $datos);
        }
    }    
    
    public function agregarCuentaContable()
    {     
        session_start();
        if(isset($_POST['guardar'])){                   
       
                if($this->ModelGastosGenerales->agregarCuentaContable($_POST)){
                    $_SESSION['message'] = 'Se ha guardado corréctamente la cuenta contable';                    
                } else {                        
                    $_SESSION['message'] = 'Ha ocurrido un error y no se ha guardado la cuenta contable';
                }
                redireccionar('/gastosGenerales/cuentasContables');
        } else {              
            if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
                redireccionar('/login');
            } else {   
                $_SESSION['message'] = 'Ha ocurrido un error y no se ha guardado la cuenta contable';             
                redireccionar('/gastosGenerales/cuentasContables');
            }
        }
        
    }

    
    public function obtenerCuentaContable()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $idCuenta = $_POST['idCuenta'];            
        }
        $cuenta = $this->ModelGastosGenerales->obtenerCuentaContable($idCuenta);
        echo json_encode($cuenta);
    }
    
    public function eliminarCuentaContable()
    {
        if ($_POST['idCuenta']){
            $del = $this->ModelGastosGenerales->eliminarCuentaContable($_POST);
            echo json_encode($del);
        }
    }

    public function tiposGastosGenerales()
    {
        $this->iniciar();
        $tiposGastosGenerales = $this->ModelGastosGenerales->obtenerTiposGastosGenerales();
        $ctasContables = $this->ModelGastosGenerales->obtenerCuentasContables();

        $datos = [
          'tiposGastosGenerales' => $tiposGastosGenerales,
          'ctasContables' => $ctasContables 
        ];
              
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
            $this->vista('gastosGenerales/tiposGastosGenerales', $datos);
        }
    }    
    
    public function agregarTipoGasto()
    {     
        session_start();
        if(isset($_POST['guardar'])){                   
       
                if($this->ModelGastosGenerales->agregarTipoGasto($_POST)){
                    $_SESSION['message'] = 'Se ha guardado corréctamente el tipo de gasto';                    
                } else {                        
                    $_SESSION['message'] = 'Ha ocurrido un error y no se ha guardado el tipo de gasto';
                }
                redireccionar('/gastosGenerales/tiposGastosGenerales');
        } else {              
            if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
                redireccionar('/login');
            } else {   
                $_SESSION['message'] = 'Ha ocurrido un error y no se ha guardado el tipo de gasto';             
                redireccionar('/gastosGenerales/tiposGastosGenerales');
            }
        }
        
    }

    
        
    public function obtenerTipoGasto()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $idTipo = $_POST['idTipo'];            
        }
        $tipo = $this->ModelGastosGenerales->obtenerTipoGasto($idTipo);
        echo json_encode($tipo);
    }
    
    public function eliminarTipoGasto()
    {
        if ($_POST['idTipo']){
            $del = $this->ModelGastosGenerales->eliminarTipoGasto($_POST);
            echo json_encode($del);
        }
    }


}
