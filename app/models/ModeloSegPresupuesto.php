<?php


class ModeloSegPresupuesto{

    private $db;


    public function __construct(){
        $this->db = new Base;
    }
    
    public function obtenerClientes()
    {
        $this->db->query('SELECT idEMPRESA as id, NOMBREJURIDICO  FROM empresasclientes');
        $resultado = $this->db->registros();
        return $resultado;
    } 
    public function obtenerAgentes(){
        $this->db->query('SELECT codagente , lcase(concat(Nombre," ",Apellidos )) as agente FROM agentes;');
        $resultado = $this->db->registros();
        return $resultado;
    }
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

    /*public function resultadoBuscador($consulta){
        $this->db->query('SELECT * FROM presupuesto  
        LEFT JOIN grupos ON grupos.idGrupo = presupuesto.idGrupo
        LEFT JOIN acciones_presupuesto ON acciones_presupuesto.idPresupuesto = presupuesto.idPresupuesto
        LEFT JOIN accionesformativas ON acciones_presupuesto.idACCION = accionesformativas.idACCION
        LEFT JOIN servicio ON acciones_presupuesto.idServicio = servicio.idServicio
        LEFT JOIN plantillasPres ON plantillasPres.idPlantilla = presupuesto.idPlantilla
        LEFT JOIN empresasclientes ON acciones_presupuesto.idEMPRESA = empresasclientes.idEMPRESA
        WHERE 1 = 1 ' .$consulta);  
        $resultado = $this->db->registros();  
        return $resultado;
    }*/


    public function resultadoBuscador($consulta){
        
        $this->db->query('SELECT apre.idAccionPres, apre.idACCION, afo.NOMBREACCION, apre.idEMPRESA, cli.NOMBREJURIDICO, 
                        con.idColaborador, con.RazonSocial AS nombreColaborador, apre.idServicio AS idtipologia, tip.descripcion AS tipologia, apre.modalidad, moda.DESMODALIDAD AS modalidad,
                        pre.idPresupuesto, pre.idServicios AS idservicio, ser.nombreS AS nombreServicio, apre.participantes, pre.fecha ,apre.importe, pre.observaciones, apre.estatus,
                        apro.idAccionProy, apro.idProyecto, pro.fechaInicio, pro.fechaFin, pro.fechaIniFun, pro.fechaFinFun, apre.fechaRechazo, gru.idGrupo, gru.nombreG,
                        agcli.idAgente, CONCAT(ag.Nombre," ",ag.Apellidos) AS nombreAgente, col.idColaborador, cola.RazonSocial AS nombreColaborador
                        FROM acciones_presupuesto apre
                        LEFT JOIN accionesformativas afo ON apre.idACCION=afo.idACCION
                        LEFT JOIN empresasclientes cli ON apre.idEMPRESA=cli.idEMPRESA
                        LEFT JOIN colaboradoresN con ON apre.idEMPRESA=con.idEMPRESA
                        LEFT JOIN tipologia tip ON apre.idServicio=tip.codtipologia
                        LEFT JOIN modalidadesdeacciones moda ON apre.modalidad=moda.CODMODALIDAD
                        LEFT JOIN presupuesto pre ON apre.idPresupuesto=pre.idPresupuesto
                        LEFT JOIN servicio ser ON pre.idServicios=ser.idServicio
                        LEFT JOIN acciones_proyecto apro ON apre.idAccionPres=apro.idAccionPres
                        LEFT JOIN proyectos pro ON apro.idProyecto=pro.idProyecto
                        LEFT JOIN grupos gru ON cli.idGrupo=gru.idGrupo
                        LEFT JOIN agentesclientes agcli ON apre.idEMPRESA=agcli.idEmpresa
                        LEFT JOIN agentes ag ON agcli.idAgente=ag.codagente
                        LEFT JOIN colaboradoresN col ON apre.idEMPRESA=col.idEMPRESA
                        LEFT JOIN colaboradores cola ON col.idColaborador=cola.codColaborador
                        WHERE 1 = 1 ' .$consulta);  
        $resultado = $this->db->registros();
        
        return $resultado;
    }    

}