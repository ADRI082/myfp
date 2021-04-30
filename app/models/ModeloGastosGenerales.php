<?php


class ModeloGastosGenerales{

    private $db;

    public function __construct(){
        $this->db = new Base;
    }

    public function obtenerGastosGenerales()
    {
        $this->db->query('SELECT gas.*, tip.idgasto AS idtipogasto, tip.descripcion AS descTipGasto
                        FROM gastosaccionproy gas
                        LEFT JOIN tipogastosgenerales tip ON gas.tipoGasto=tip.idgasto
                        ORDER BY gas.fechacreacion DESC');
        $resultado = $this->db->registros();
        $arr = [];
        $tmp = [];
        foreach ($resultado as $key) {
            //si es colaborador:
            if ($key->tipoProveedor== 'colaborador') {
                $datosProvedor = $this->obtenerNombreColaborador($key->razonSocial);
            }else 
             //si es profesor
            if ($key->tipoProveedor== 'profesor') {
                $datosProvedor = $this->obtenerNombreProfesor($key->razonSocial);
            }else 
            //si es proveedor
            if ($key->tipoProveedor== 'proveedor') {
                $datosProvedor = $this->obtenerNombreProveedor($key->razonSocial);
            }
            $tmp['datosProveedor'] = $datosProvedor;
            $tmp['todos'] = $key;
            $arr[] = $tmp;           
        }
        return $arr;
    }

    public function obtenerNombreColaborador($idColaborador)
    {
        $this->db->query('SELECT col.codColaborador AS idProveedor, col.NombreComercial AS nomComercial, col.RazonSocial AS razonSocial
                        FROM colaboradores col
                        WHERE col.codColaborador='.$idColaborador);
        $resultado = $this->db->registro();
        return $resultado;        
    }

    public function obtenerNombreProfesor($idProfesor)
    {
        $this->db->query('SELECT prof.idPROFESOR AS idProveedor, prof.NOMBRECOMERCIAL as nomComercial, prof.RAZONSOCIAL AS razonSocial
                        FROM profesores prof
                        WHERE prof.idPROFESOR='.$idProfesor);
        $resultado = $this->db->registro();
        return $resultado;        
    }

    public function obtenerNombreProveedor($idProveedor)
    {
        $this->db->query('SELECT prov.idPROVEEDOR AS idProveedor, prov.NOMBRECOMERCIAL as nomComercial, prov.PERSONAJURIDICA AS razonSocial
                        FROM proveedores prov
                        WHERE prov.idPROVEEDOR ='.$idProveedor);
        $resultado = $this->db->registro();
        return $resultado;        
    }

    public function obtenerTipoGastos(){
        $this->db->query('SELECT * FROM tipogastosgenerales');
        $resultado = $this->db->registros();
        return $resultado;
    }
    
    public function obtenerTodosLosProveedores(){

        //colaboradores
        $this->db->query('SELECT col.codColaborador AS id, col.NifColaborador AS cif, col.NombreComercial AS nomComercial,
                        col.RazonSocial AS denominacion, "colaborador" AS "tipo" 
                        FROM colaboradores col');
        $colaboradores = $this->db->registros();
        
        //profesores
        $this->db->query('SELECT prof.idPROFESOR AS id, prof.nifdniprofesor AS cif, prof.NOMBRECOMERCIAL AS nomComercial,
                        prof.RAZONSOCIAL AS denominacion, "profesor" AS "tipo" 
                        FROM profesores prof');
        $profesores = $this->db->registros();
        
        //proveedores
        $this->db->query('SELECT prov.idPROVEEDOR AS id, prov.CIFPROVEEDOR AS cif, prov.NOMBRECOMERCIAL AS nomComercial,
                        prov.PERSONAJURIDICA AS denominacion, "proveedor" AS "tipo" 
                        FROM proveedores prov');
        $proveedores = $this->db->registros();

        $todos = array_merge($colaboradores,$profesores,$proveedores);
        return $todos;

    }

    public function obtenerTiposIva(){
        $this->db->query('SELECT * FROM tiposiva');
        $resultado = $this->db->registros();
        return $resultado;
    }
    
    public function obtenerAreasInforma()
    {
        $this->db->query("SELECT * FROM areasinforma");
        $resultado = $this->db->registros();
        return $resultado;
    }

    public function obtenerProyectosPorServicio($idArea)
    {
        $this->db->query("SELECT apro.idAccionProy AS idAccion, apre.idServicio,ser.nombreS AS area,
                        apro.idProyecto AS grupo, cli.idEMPRESA AS idEmpresa, 
                        cli.NOMBREJURIDICO AS denominacion, if(cli.NOMBRECOMERCIAL IS NULL,'',cli.NOMBRECOMERCIAL) AS nomComercial,
                        proy.accionformativa AS idAccionFormativa, af.NOMBREACCION AS nombreAccion
                        FROM proyectos proy 
                        LEFT JOIN acciones_proyecto apro ON proy.idProyecto=apro.idProyecto
                        LEFT JOIN acciones_presupuesto apre ON apro.idAccionPres=apre.idAccionPres
                        LEFT JOIN servicio ser ON apre.idServicio=ser.idServicio
                        LEFT JOIN accionesformativas af ON proy.accionformativa =af.idACCION
                        LEFT JOIN empresasclientes cli ON apro.idEMPRESA=cli.idEMPRESA
                        WHERE apre.idServicio= ".$idArea);
        $resultado = $this->db->registros();
        return $resultado;
    }
    
    public function obtenerCuentasBancarias()
    {
        $this->db->query("SELECT * FROM cuentasbancarias");
        $resultado = $this->db->registros();
        return $resultado;
    }
    
    public function calcularTotalAPagar($baseImponible,$cantidad,$iva,$irpf)
    {  
        $resultadoPrevio = $baseImponible * $cantidad;
        if ($iva > 0) {
          $importeIva= $resultadoPrevio * ($iva/100);
        }else{
          $importeIva = 0;
        }
        if ($irpf > 0) {
          $importeirpf= $resultadoPrevio * ($irpf/100);
        }else{
          $importeirpf = 0;
        }
  
        $resultado = round($resultadoPrevio + $importeIva - $importeirpf, 2);
        return $resultado;
    }
    
    public function agregarGastosGenerales($post)
    {
        //obteniendo el tipo de proveedor y código
        if ($post['proveedor']) {
            $partes = explode('-',$post['proveedor']);
            $tipoProv = $partes[0];
            $codigoProv = $partes[1];    
        }

        //cálculo de totalGasto
        $total = $this->calcularTotalAPagar($post['baseImponible'],$post['cantidad'],$post['iva'],$post['irpf']);

        //si viene con asignación por áreas, obtengo las áreas y los montos asignados
        if ($post['asignacion'] == 'area') {
            if (count($post['idArea']) >0) {
                
                $montos = $post['montoAsignado'];
                $areas = $post['idArea'];
                $arr = [];                
                foreach ($areas as $key => $value) {
                    foreach ($montos as $k => $v) {
                        if ($key == $k) {
                            $arr[$value] = $v;                          
                        }
                    }
                }
            }
            $json = json_encode($arr); //el json formado es {"area":"monto asignado"}
        }else if ($post['asignacion'] == 'areaProyecto') {

            if (count($post['idAreaProyecto']) >0) {
                $montos = $post['asignacionProy'];
                $idsAccionProy = $post['idAreaProyecto'];
                $array = [];                
                foreach ($idsAccionProy as $key => $value) {
                    foreach ($montos as $k => $v) {
                        if ($key == $k) {
                            $array[$value] = $v;                            
                        }
                    }
                }
            }
            $json = json_encode($array); //el json formado es {"idaccionproy":"monto asignado"}

        }else{
            $json = '{}'; 
        }

        $this->db->query('INSERT INTO gastosaccionproy 
                        (tipoGasto,tipoProveedor,razonSocial,importe,iva,irpf,cantidad,total,
                        fecha,numfacgasto,descripcion,fechapago,iban,asignacion,areaMonto) 
                        VALUES (:tipoGasto,:tipoProveedor,:razonSocial,:importe,:iva,:irpf,:cantidad,:total,
                        :fecha,:numfacgasto,:descripcion,:fechapago,:iban,:asignacion,:areaMonto)');

        // vincular valores
        $this->db->bind(':tipoGasto', $post['tipoGasto']);
        $this->db->bind(':tipoProveedor', $tipoProv);
        $this->db->bind(':razonSocial', $codigoProv);
        $this->db->bind(':importe', $post['baseImponible']);
        $this->db->bind(':iva', $post['iva']);
        $this->db->bind(':irpf', $post['irpf']);
        $this->db->bind(':cantidad', $post['cantidad']);
        $this->db->bind(':total', $total);
        $this->db->bind(':fecha', $post['fechaFactura']);
        $this->db->bind(':numfacgasto', $post['numFactura']);
        $this->db->bind(':descripcion', $post['descripcion']);      
        $this->db->bind(':fechapago', $post['fechaPago']);
        $this->db->bind(':iban', $post['iban']);
        $this->db->bind(':asignacion', $post['asignacion']);
        $this->db->bind(':areaMonto', $json);
            
        //Ejecutar
        if($this->db->execute()){            
            return true;
        } else {
            return false;
        }
    }    

    public function obtenerFacturaGastoDetallada($idFact)
    {
        $this->db->query('SELECT gas.*, tip.idgasto AS idtipogasto, tip.descripcion AS descTipGasto
                        FROM gastosaccionproy gas
                        LEFT JOIN tipogastosgenerales tip ON gas.tipoGasto=tip.idgasto
                        WHERE gas.idgasto='.$idFact);

        $resultado = $this->db->registro();
    
        //CONSTRUYO LOS DATOS DE LOS PROVEEDOR SEGÚN TIPO
        //si es colaborador:
        if ($resultado->tipoProveedor== 'colaborador') {
            $datosProvedor = $this->obtenerNombreColaborador($resultado->razonSocial);
        }else 
         //si es profesor
        if ($resultado->tipoProveedor== 'profesor') {
            $datosProvedor = $this->obtenerNombreProfesor($resultado->razonSocial);
        }else 
        //si es proveedor
        if ($resultado->tipoProveedor== 'proveedor') {
            $datosProvedor = $this->obtenerNombreProveedor($resultado->razonSocial);
        }        
        $resultado->datosProveedor = $datosProvedor; 
        
        //CONSTRUYO LOS DATOS DE LAS ASIGNACIÓN POR ÁREAS Y/O PROYECTOS:
        $asignacion = json_decode($resultado->areaMonto);

        if ($asignacion != '') {           

            if ($resultado->asignacion == 'area') {
                //traer áreas asignadas
                $tmp = [];
                $arr = [];          
                foreach ($asignacion as $key => $value) {
                    $tmp['idArea'] = $key;
                    $tmp['area'] = $this->nombreDeArea($key);
                    $tmp['monto'] = number_format($value,2,',','.');
                    $arr[] = $tmp;
                }
                $resultado->montosAsignados= $arr;
            }else if ($resultado->asignacion == 'areaProyecto') {
                //traer áreas y proyectos asignadas
                $tmp = [];
                $arr = [];          
                foreach ($asignacion as $key => $value) { //$key es el idAccionProy
                    $accionProy = $this->obtenerDatosAccionProy($key);
                    if ($accionProy->idServicio==2) {
                        $area = 'Consultoría';
                        $idArea = 2;
                    }else if ($accionProy->idServicio==3) {
                        $area = 'Formación';
                        $idArea = 3;
                    }else if ($accionProy->idServicio == 4) {
                        $area = 'Selección';
                        $idArea = 4;
                    }
                    
                    $tmp['idAccionProy'] = $key;
                    $tmp['idArea'] = $idArea;
                    $tmp['area'] = $area;
                    $tmp['idAccion'] = $accionProy->idAccionFormativa;
                    $tmp['grupo'] = $accionProy->grupo ;
                    $tmp['nomAccion'] = $accionProy->nombreAccion;
                    $tmp['idCliente'] = $accionProy->idEmpresa;
                    $tmp['nomComercial'] = $accionProy->nomComercial;
                    $tmp['razonSocial'] = $accionProy->denominacion;

                    $tmp['monto'] = number_format($value,2,',','.');
                    $arr[] = $tmp;
                }
                $resultado->montosAsignados= $arr;
            }
        }
        
        return $resultado;
    }

    public function obtenerDatosAccionProy($idAccionProy)
    {
        $this->db->query("SELECT apro.idAccionProy AS idAccion, apre.idServicio,ser.nombreS AS area,
                        apro.idProyecto AS grupo, cli.idEMPRESA AS idEmpresa, 
                        cli.NOMBREJURIDICO AS denominacion, if(cli.NOMBRECOMERCIAL IS NULL,'',cli.NOMBRECOMERCIAL) AS nomComercial,
                        proy.accionformativa AS idAccionFormativa, af.NOMBREACCION AS nombreAccion
                        FROM proyectos proy 
                        LEFT JOIN acciones_proyecto apro ON proy.idProyecto=apro.idProyecto
                        LEFT JOIN acciones_presupuesto apre ON apro.idAccionPres=apre.idAccionPres
                        LEFT JOIN servicio ser ON apre.idServicio=ser.idServicio
                        LEFT JOIN accionesformativas af ON proy.accionformativa =af.idACCION
                        LEFT JOIN empresasclientes cli ON apro.idEMPRESA=cli.idEMPRESA        
                        WHERE apro.idAccionProy=".$idAccionProy);
        $resultado = $this->db->registro();
        return $resultado;
    }

    public function nombreDeArea($id)
    {
        $this->db->query("SELECT * FROM areasinforma WHERE id=".$id);
        $resultado = $this->db->registro();
        return $resultado->area;
    }

    public function eliminarAsignacionArea($post)
    {
        $idArea = $post['idArea'];
        $idGasto = $post['idGasto'];

        $this->db->query("UPDATE gastosaccionproy gas 
                        SET gas.areaMonto = JSON_REMOVE(gas.areaMonto, '$.".$idArea."')
                        WHERE gas.idgasto=".$idGasto);

        if ($this->db->execute()) {            
            return true;
        } else {
            return false;
        }        
    }

    public function eliminarAsignacionAreaYProyecto($post)
    {
        $idaccionproy = $post['idaccionproy'];
        $idGasto = $post['idGasto'];

        $this->db->query("UPDATE gastosaccionproy gas 
                        SET gas.areaMonto = JSON_REMOVE(gas.areaMonto, '$.".$idaccionproy."')
                        WHERE gas.idgasto=".$idGasto);

        if ($this->db->execute()) {            
            return true;
        } else {
            return false;
        } 
    }

    public function updateDatosFacturaGasto($tabla,$campo,$contenido,$idtabla,$id)
    {
        $q = "UPDATE " . $tabla . " SET " . $campo . " =  :contenido WHERE " .  $idtabla . " = :id";
        
        $this->db->query($q);
        $this->db->bind(':contenido', $contenido);
        $this->db->bind(':id', $id);

        if($this->db->execute()){
            return true;

        }else {
            return false;
        }
    }


    public function eliminarGasto($post)
    {
        $this->db->query("DELETE FROM gastosaccionproy WHERE idgasto =".$post['idGasto']);
            
        if($this->db->execute()){
            return true;
        } 
        else {            
            return false;
        }
    }

    public function obtenerCuentasContables()
    {
        $this->db->query('SELECT * FROM cuentascontables');
        $resultado = $this->db->registros();
        return $resultado;
    }

    public function agregarCuentaContable($post)
    {       

        $this->db->query('INSERT INTO cuentascontables 
                        (descripcion, cuentacontable) 
                        VALUES (:descripcion,:cuentacontable)');

        $this->db->bind(':descripcion', $post['descripcion']);
        $this->db->bind(':cuentacontable', $post['cuentacontable']);
       
        if($this->db->execute()){            
            return true;
        } else {
            return false;
        }
    }    
    
    public function obtenerCuentaContable($idCuenta)
    {
        $this->db->query('SELECT *
                        FROM cuentascontables                    
                        WHERE id='.$idCuenta);

        $resultado = $this->db->registro();        
        return $resultado;
    }
    
    public function eliminarCuentaContable($post)
    {
        $this->db->query("DELETE FROM cuentascontables WHERE id =".$post['idCuenta']);
            
        if($this->db->execute()){
            return true;
        } 
        else {            
            return false;
        }
    }
 
    public function obtenerTiposGastosGenerales()
    {
        $this->db->query('SELECT tip.*, cue.descripcion AS nomCuentaContable, cue.cuentacontable AS idCuentaContable 
                        FROM tipogastosgenerales tip
                        LEFT JOIN cuentascontables cue ON tip.cuentacontable=cue.id');
        $resultado = $this->db->registros();
        return $resultado;
    }
    
    public function agregarTipoGasto($post)
    {
        $this->db->query('INSERT INTO tipogastosgenerales
                        (descripcion, cuentacontable) 
                        VALUES (:descripcion,:cuentacontable)');

        $this->db->bind(':descripcion', $post['descripcion']);
        $this->db->bind(':cuentacontable', $post['cuentacontable']);
       
        if($this->db->execute()){       
            return true;
        } else {
            return false;
        }
    }   

    
    public function obtenerTipoGasto($idTipo)
    {
        $this->db->query('SELECT tip.*, cue.descripcion AS nomCuentaContable, cue.cuentacontable AS idCuentaContable 
                        FROM tipogastosgenerales tip
                        LEFT JOIN cuentascontables cue ON tip.cuentacontable=cue.id
                        WHERE idgasto='.$idTipo);

        $resultado = $this->db->registro();        
        return $resultado;
    }
    
    public function eliminarTipoGasto($post)
    {
        $this->db->query("DELETE FROM tipogastosgenerales WHERE idgasto =".$post['idTipo']);
            
        if($this->db->execute()){
            return true;
        } 
        else {            
            return false;
        }
    }

}


