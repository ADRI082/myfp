<?php


class ModeloReportesPersonal{

    private $db;


    public function __construct(){
        $this->db = new Base;
    }

    public function obtenerAgentes(){
        $this->db->query('SELECT codagente , lcase(concat(Nombre," ",Apellidos )) as agente FROM agentes;');
        $resultado = $this->db->registros();
        return $resultado;
    }

    public function resultadoBuscadorRegistro($consulta){
        
        $this->db->query('SELECT 
                        ag.codagente, CONCAT(ag.Nombre," ",ag.Apellidos) AS nombreAgente, per.*
                        FROM registropersonal per                        
                        LEFT JOIN agentes ag ON per.idAgente=ag.codagente                    
                        WHERE 1 = 1 ' .$consulta);
        $resultado = $this->db->registros();       
        return $resultado;
    }

    //--------------------------------------




    public function obtenerColaboradores(){
        $this->db->query('SELECT col.codColaborador AS id, col.RazonSocial AS nombreColaborador FROM colaboradores col');
        $resultado = $this->db->registros();
        return $resultado;
    }
    // PARA CAMBIAR CON AJAX
    public function obtenerClientesSelect($salida)
    {
        $this->db->query("SELECT idEMPRESA , NOMBREJURIDICO  FROM empresasclientes WHERE 1 = 2".$salida);

        $resultado = $this->db->registros();
        return $resultado;
    } 
    public function obtenerAccionSelect($salida)
    {
        $this->db->query("SELECT idACCION , NOMBREACCION  FROM accionesformativas WHERE 1 = 2".$salida);

        $resultado = $this->db->registros();
        return $resultado;
    } 
    // FIN

    public function obtenerAcciones()
    {
        $this->db->query("SELECT idACCION , NOMBREACCION  FROM accionesformativas");

        $resultado = $this->db->registros();
        return $resultado;
    }
    public function obtenerTipologia()
    {
        $this->db->query('SELECT codtipologia AS id, descripcion AS tipologia FROM tipologia');
        $resultado = $this->db->registros();
        return $resultado;
    } 
    public function obtenerServicio()
    {
        $this->db->query('SELECT idServicio as id, nombreS  FROM servicio WHERE idServicio>1');
        $resultado = $this->db->registros();
        return $resultado;
    } 
    public function obtenerGrupos()
    {
        $this->db->query('SELECT idGrupo as id, nombreG FROM grupos');
        $resultado = $this->db->registros();
        return $resultado;
    } 

    

    public function resultadoBuscadorFacturasGasto($consulta,$cond=''){
        
        $this->db->query('SELECT gas.*, apro.idProyecto, apre.idACCION, afo.NOMBREACCION,
                        cli.idEMPRESA, cli.NOMBREJURIDICO AS nombreCliente, col.idColaborador, cola.NombreComercial AS nombreColaborador,
                        pro.idProfesor, prof.RAZONSOCIAL AS nombreProfesor, apro.idTipo, tip.descripcion AS tipologia,
                        pres.idServicios, ser.nombreS AS nombreServicio, agcli.idAgente, CONCAT(ag.Nombre," ",ag.Apellidos) AS nombreAgente,
                        cli.idGrupo, gru.nombreG AS nombreGrupo
                        FROM gastosaccionproy gas
                        LEFT JOIN acciones_proyecto apro ON gas.idaccionproy=apro.idAccionProy
                        LEFT JOIN acciones_presupuesto apre ON apro.idAccionPres=apre.idAccionPres
                        LEFT JOIN accionesformativas afo ON apre.idACCION=afo.idACCION
                        LEFT JOIN empresasclientes cli ON apro.idEMPRESA=cli.idEMPRESA
                        LEFT JOIN colaboradoresN col ON apro.idEMPRESA=col.idEMPRESA                        
                        LEFT JOIN colaboradores cola ON col.idColaborador=cola.codColaborador                        
                        LEFT JOIN proyectos pro ON apro.idProyecto=pro.idProyecto                        
                        LEFT JOIN profesores prof ON pro.idProfesor=prof.idPROFESOR
                        LEFT JOIN presupuesto pres ON pro.idPresupuesto=pres.idPresupuesto
                        LEFT JOIN tipologia tip ON apro.idTipo=tip.codtipologia
                        LEFT JOIN servicio ser ON pres.idServicios=ser.idServicio
                        LEFT JOIN agentesclientes agcli ON apro.idEMPRESA=agcli.idEmpresa
                        LEFT JOIN agentes ag ON agcli.idAgente=ag.codagente
                        LEFT JOIN grupos gru ON cli.idGrupo=gru.idGrupo                                          
                        WHERE 1 = 1 '. $cond. ' ' .$consulta);
                       
        $resultado = $this->db->registros();

        $newResult = [];
        foreach ($resultado as $key) {            
            //busco el proveedor según el tipo
            if ($key->tipoProveedor == 'proveedor') {
                $this->db->query('SELECT PERSONAJURIDICA AS nomProv, CIFPROVEEDOR AS cif,  PROVINCIA, CODPOSTAL FROM proveedores  WHERE idPROVEEDOR='.$key->razonSocial);                
            }else if ($key->tipoProveedor == 'profesor') {
                $this->db->query('SELECT RAZONSOCIAL AS nomProv, prof.nifdniprofesor AS cif, prof.PROVINCIA, prof.CODPOSTAL FROM profesores prof WHERE prof.idPROFESOR='.$key->razonSocial);                
            }else if ($key->tipoProveedor == 'colaborador') {
                $this->db->query('SELECT col.RazonSocial AS nomProv, col.NifColaborador AS cif, col.provincia, col.codigopostal AS CODPOSTAL FROM colaboradores col WHERE col.codColaborador='.$key->razonSocial);
            }
            $row= $this->db->registro();
            $nomProv = $row->nomProv;
            $cif = $row->cif;
            $provincia = $row->PROVINCIA;
            $codPostal = $row->CODPOSTAL;
            $key->nombreProveedor = $nomProv;
            $key->cif = $cif;
            $key->provincia = $provincia;
            $key->codPostal = $codPostal;

            //traigo la factura del cliente de facturascabecera
            $this->db->query('SELECT fac.numfactura FROM facturascabecera fac WHERE fac.idaccionproy='.$key->idaccionproy);                
            $factura= $this->db->registro();
            $numFactura = $factura->numfactura;
            $key->numFactura = $numFactura; 

            $newResult[] = $key;

        }        
        return $newResult;
    }

    public function resultadoResumenFinanciero($consulta,$cond=''){
        
        $this->db->query('SELECT apro.idAccionProy,apro.idProyecto, apre.idACCION, afo.NOMBREACCION, 
                        cli.NOMBREJURIDICO, cli.CIFCLIENTE, cli.CODPOSTAL, cli.PROVINCIA, col.idColaborador, cola.RazonSocial AS nombreColaborador, 
                        pro.idProyecto, pro.idProfesor, prof.RAZONSOCIAL AS nombreProfesor,
                        apro.idTipo, tip.descripcion AS tipologia, pres.idServicios, ser.nombreS AS nombreServicio,
                        agcli.idAgente, CONCAT(ag.Nombre," ",ag.Apellidos) AS nombreAgente, cli.idGrupo,
                        gru.nombreG AS nombreGrupo, pro.fechaInicio, pro.fechaFin, pro.fechaIniFun, pro.fechaFinFun, apro.importeactual                       
                        FROM acciones_proyecto apro
                        LEFT JOIN acciones_presupuesto apre ON apro.idAccionPres=apre.idAccionPres
                        LEFT JOIN accionesformativas afo ON apre.idACCION=afo.idACCION
                        LEFT JOIN empresasclientes cli ON apro.idEMPRESA=cli.idEMPRESA
                        LEFT JOIN colaboradoresN col ON apro.idEMPRESA=col.idEMPRESA
                        LEFT JOIN colaboradores cola ON col.idColaborador=cola.codColaborador
                        LEFT JOIN proyectos pro ON apro.idProyecto=pro.idProyecto
                        LEFT JOIN profesores prof ON pro.idProfesor=prof.idPROFESOR
                        LEFT JOIN presupuesto pres ON pro.idPresupuesto=pres.idPresupuesto
                        LEFT JOIN tipologia tip ON apro.idTipo=tip.codtipologia
                        LEFT JOIN servicio ser ON pres.idServicios=ser.idServicio
                        LEFT JOIN agentesclientes agcli ON apro.idEMPRESA=agcli.idEmpresa
                        LEFT JOIN agentes ag ON agcli.idAgente=ag.codagente
                        LEFT JOIN grupos gru ON cli.idGrupo=gru.idGrupo
                        WHERE 1 = 1 '. $cond. ' ' .$consulta);
        $resultado = $this->db->registros();

        $newResult = [];
        foreach ($resultado as $key) {            
            
            //traigo los gastos
            $this->db->query('SELECT SUM(gpro.total) AS totalgastos FROM gastosaccionproy gpro
                            WHERE gpro.idaccionproy='.$key->idAccionProy);
            $sumaGasto= $this->db->registro();
            $valorGasto = $sumaGasto->totalgastos;
            $key->totalgastos = $valorGasto;

            //traigo los ingresos
            $this->db->query('SELECT SUM(fac.total) AS totalingresos FROM facturascabecera fac
            WHERE fac.idaccionproy='.$key->idAccionProy);
            $sumaIngresos= $this->db->registro();
            $valorIngreso = $sumaIngresos->totalingresos;
            $key->totalingresos = $valorIngreso;            

            $newResult[] = $key;

        }        
        return $newResult;
    }
    

}