<?php


class ModeloPresPdf{

    private $db;


    public function __construct()
    {
        $this->db = new Base;

    }

    public function verDatosPresupuesto($id){
        $this->db->query('SELECT * from presupuesto
        LEFT JOIN plantillasPres on plantillasPres.idPlantilla = presupuesto.idPlantilla  
        LEFT JOIN grupos on grupos.idGrupo = presupuesto.idGrupo   
        WHERE idPresupuesto = :id');
        $this->db->bind(':id', $id);
        $resultado = $this->db->registros();
        return $resultado;
    }

    //para extraer los datos por accion y presupuesto
    public function verDatosPresupuestoAccion($datos){
        $this->db->query('SELECT NOMBREACCION, NOMBREJURIDICO, acc.importe AS importeacc , presupuesto.*, acc.*, plantillasPres.*, grupos.* from presupuesto
                LEFT JOIN acciones_presupuesto acc ON acc.idPresupuesto = presupuesto.idPresupuesto
                LEFT JOIN accionesformativas af ON acc.idACCION=af.idACCION
                LEFT JOIN plantillasPres on plantillasPres.idPlantilla = presupuesto.idPlantilla  
                LEFT JOIN grupos on grupos.idGrupo = presupuesto.idGrupo
                LEFT JOIN empresasclientes emp ON acc.idEMPRESA=emp.idEMPRESA
                WHERE presupuesto.idPresupuesto = :id AND acc.idAccionPres = :idAcc');
        $this->db->bind(':id', $datos['id']);
        $this->db->bind(':idAcc', $datos['idacc']);
        $resultado = $this->db->registros();
        return $resultado;
    }    
 
}