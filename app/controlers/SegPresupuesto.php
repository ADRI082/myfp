<?php

class SegPresupuesto extends Controlador
{

    public function __construct()
    { 
       
        // cargamos el modelo asociado a este controlador
        $this->Seguimiento = $this->modelo('ModeloSegPresupuesto');
    } 
  
    public function index(){
        $this->iniciar();
        $clientes = $this->Seguimiento->obtenerClientes();
        $servicio = $this->Seguimiento->obtenerServicio();
        $grupos = $this->Seguimiento->obtenerGrupos();
        $acciones = $this->Seguimiento->obtenerAcciones();
        $tipologia = $this->Seguimiento->obtenerTipologia();
        $agentes = $this->Seguimiento->obtenerAgentes();
        $colaboradores = $this->Seguimiento->obtenerColaboradores();
        $datos = [
          'clientes' => $clientes,
          'servicio' => $servicio,
          'grupos' => $grupos,
          'acciones' => $acciones,
          'tipologia' => $tipologia,
          'agentes' => $agentes,
          'colaboradores' => $colaboradores
        ];   

        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
            $this->vista('segPresupuesto/segPresupuesto', $datos);
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
        $clienteselect = $this->Seguimiento->obtenerClientesSelect($salida);
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
        $accionselect = $this->Seguimiento->obtenerAccionSelect($salida);
        $resultado = "";
        foreach ($accionselect as $row) {

            $resultado .= "<option value='" . $row->idACCION . "'>" . $row->NOMBREACCION . "</option>";
        }
        echo $resultado;
    }
    // FIN

    public function resultadoBuscador()
    {
        //$this->iniciar();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
                // $consulta ="Where 1 = 1";
                $salida = "";
                if(isset($_POST['periodo']) ){
                    $periodo = $_POST['periodo'];
                }            
                if($periodo == "presupuestados"){                    
                    $salida .= " AND apre.estatus = 0 ";
                }else if ($periodo == "desestimados"){                    
                    $salida .= " AND apre.estatus = 2 ";
                }else if ($periodo == "proyectados"){                    
                    $salida .= " AND apre.estatus = 1 AND pro.fechaInicio > CURDATE() ";
                }else if ($periodo == "ejecucion"){                    
                    $salida .= " AND apre.estatus = 1 AND pro.fechaInicio <= CURDATE() AND pro.fechaFin >= CURDATE() ";
                }else if ($periodo == "finalizados"){                    
                    $salida .= " AND apre.estatus = 1 AND pro.fechaInicio <= CURDATE() AND pro.fechaFin < CURDATE() ";
                }

        
                //    TIPOLOGÍA
                $salidaTipo = "";
                if(!empty($_POST['tipo'])){
                    $tipo = $_POST['tipo'];
                    for ($i=0; $i < count($tipo) ; $i++) {   
                        $salidaTipo = " AND apre.idServicio IN (";
                        for ($i=0; $i <count($tipo) ; $i++) { 
                            if($i != (count($tipo)-1)){
                                $salidaTipo .= $tipo[$i]  . ",";
                            } else {
                                $salidaTipo .=  $tipo[$i] . ")";
                            }
                        }                  
                    }
                }
                    
                //  GRUPO
                $salidaGrupo = "";
                if(!empty($_POST['grupo'])){
                    $grupo = $_POST['grupo'];
                    $salidaGrupo = " AND gru.idGrupo IN (";
                    for ($i=0; $i <count($grupo) ; $i++) { 
                        if($i != (count($grupo)-1)){
                            $salidaGrupo .=  $grupo[$i] . ",";
                        } else {
                            $salidaGrupo .=  $grupo[$i] . ")";
                        }
                    }
                } 
                
                //  EMPRESA
                $salidaEmpresa = "";
                if(!empty($_POST['empresa'])){
                    $empresa = $_POST['empresa'];
                    $salidaEmpresa = " AND acciones_presupuesto.idEMPRESA IN (";
                    for ($i=0; $i <count($empresa) ; $i++) { 
                        if($i != (count($empresa)-1)){
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
                if(!empty($_POST['servicio'])){
                    $servicio = $_POST['servicio'];
                    $salidaServicio = " AND pre.idServicios IN (";
                    for ($i=0; $i <count($servicio) ; $i++) { 
                        if($i != (count($servicio)-1)){
                            $salidaServicio .=  $servicio[$i] . ",";
                        } else {
                            $salidaServicio .=  $servicio[$i] . ")";
                        }
                    }
                }    
                // ACCION
                $salidaAccion = "";
                if(!empty($_POST['accion'])){
                    $accion = $_POST['accion'];
                    $salidaAccion = " AND acciones_presupuesto.idACCION IN (";
                    for ($i=0; $i <count($accion) ; $i++) { 
                        if($i != (count($accion)-1)){
                            $salidaAccion .=  $accion[$i] . ",";
                        } else {
                            $salidaAccion .=  $accion[$i] . ")";
                        }
                    }
                }        
                    // }`
                //  ESTADO     
                $salidaEstado = "";
                if(!empty($_POST['estado'])){
                        $estado = $_POST['estado'];              
                
                    $salidaEstado = "AND estado = '$estado'";
                }
           
                //  FECHA     
                $salidaTiempo = "";
                if(!empty($_POST['desde']) AND !empty($_POST['hasta'])){
                    $desde = $_POST['desde'];              
                    $hasta = $_POST['hasta'];
                $salidaTiempo = "AND fecha >= '$desde' AND fecha <= '$hasta'";
                }
                if(!empty($_POST['desde']) AND empty($_POST['hasta'])){
                    $desde = $_POST['desde'];              

                $salidaTiempo = "AND fecha >= '$desde'";
                }
                if(empty($_POST['desde']) AND !empty($_POST['hasta'])){
                                
                    $hasta = $_POST['hasta'];
                $salidaTiempo = " AND fecha <= '$hasta'";
                }

                //  IMPORTE     
                $salidaImporte = "";
                if(!empty($_POST['importeMin']) AND empty($_POST['importeMax'])){
                    $importeMin = $_POST['importeMin'];              
                $salidaImporte = "AND presupuesto.importe >= '$importeMin'";
                }
                if(empty($_POST['importeMin']) AND !empty($_POST['importeMax'])){             
                    $importeMax = $_POST['importeMax'];
                $salidaImporte = "AND  presupuesto.importe <= '$importeMax'";
                }
                if(!empty($_POST['importeMin']) AND !empty($_POST['importeMax'])){
                    $importeMin = $_POST['importeMin'];              
                    $importeMax = $_POST['importeMax'];
                $salidaImporte = "AND presupuesto.importe >= '$importeMin' AND presupuesto.importe <= '$importeMax'";
                }

                //  $consulta = $salida.$salidaTipo.$salidaGrupo;
                $consulta = $salida .$salidaTipo.$salidaEstado.$salidaGrupo.$salidaEmpresa.$salidaServicio.$salidaAccion.$salidaTiempo.$salidaImporte.$salidaColaborador.$salidaAgente;
                
                $datos2 = $this->Seguimiento->resultadoBuscador($consulta);
        
                $datos = [
                    "salida" => $datos2,
                    "tipoInforme" => $periodo
                ];
    
                $this->vista('/segPresupuesto/resultadoSeguimiento', $datos);
  
        } // fin funcion resultSearchCustomers
    }


}