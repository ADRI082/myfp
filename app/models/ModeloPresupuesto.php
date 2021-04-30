<?php

require_once "ModeloPresPdf.php";

class ModeloPresupuesto{

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

    public function obtenerPlantilla()
    {
        $this->db->query('SELECT idPlantilla as id, tipoPlantilla  FROM plantillasPres');
        $resultado = $this->db->registros();
        return $resultado;
    } 
    public function obtenerClientesSelect($idGrupo)
    {
        $this->db->query("SELECT idEMPRESA , NOMBREJURIDICO  FROM empresasclientes WHERE idGrupo = $idGrupo ORDER BY NOMBREJURIDICO ASC");

        $resultado = $this->db->registros();
        return $resultado;
    }
    public function getNombreGrupo($idGrupo)
    {
        $this->db->query("SELECT nombreG  FROM grupos WHERE idGrupo = $idGrupo");
        $resultado = $this->db->registros();
        return $resultado[0];
    }
    public function obtenerAccionesSelect($idServicio)
    {
        $this->db->query("SELECT idACCION , NOMBREACCION  FROM accionesformativas WHERE idServicio = $idServicio");

        $resultado = $this->db->registros();
        return $resultado;
    }
    public function obtenerPlantillaSelect($idPlantilla)
    {
        $this->db->query("SELECT * from plantillasPres WHERE idPlantilla = $idPlantilla");

        $resultado = $this->db->registros();
        return $resultado;
    }
    public function obtenerAcciones()
    {
        $this->db->query("SELECT idACCION , NOMBREACCION  FROM accionesformativas");

        $resultado = $this->db->registros();
        return $resultado;
    }
    
    public function obtenerServicio()
    {
        $this->db->query('SELECT idServicio as id, nombreS FROM servicio WHERE idServicio>1');
        $resultado = $this->db->registros();
        return $resultado;
    }

    public function obtenerTipologia()
    {
        $this->db->query('SELECT * FROM tipologia');
        $resultado = $this->db->registros();
        return $resultado;
    }

    public function obtenerModalidadAccion($accion)
    {
        $this->db->query('SELECT * FROM modalidadesdeacciones WHERE activo=1');
        $opciones = $this->db->registros();

        $this->db->query('SELECT acc.CODMODALIDAD AS idModalidad
                        FROM accionesformativas acc 
                        LEFT JOIN modalidadesdeacciones moda ON acc.CODMODALIDAD=moda.CODMODALIDAD
                        WHERE acc.idACCION="'.$accion.'" AND moda.ACTIVO=1');
        $selected = $this->db->registro();
        $resultado = ['opciones'=>$opciones, 'selected'=>$selected];
        return $resultado;
    }     
    
    public function obtenerModalidades()
    {
        $this->db->query('SELECT CODMODALIDAD AS id, DESMODALIDAD AS descripcion FROM modalidadesdeacciones WHERE activo=1');
        $resultado = $this->db->registros();        
        return $resultado;
    }
    
    public function obtenerNivelesCursos()
    {
        $this->db->query('SELECT CODNIVELCURSO AS id, DESCNIVELCURSO AS descripcion FROM nivelesdecursos');
        $resultado = $this->db->registros();        
        return $resultado;
    }

    public function obtenerGrupos()
    {
        $this->db->query('SELECT idGrupo as id, nombreG FROM grupos');
        $resultado = $this->db->registros();
        return $resultado;
    } 

    public function obtenerAgentes()
    {
        $this->db->query('SELECT codagente AS id, CONCAT(Nombre," ",Apellidos) AS nombreAgente  FROM agentes WHERE idRol IN (1,3) ORDER BY nombre');
        $resultado = $this->db->registros();
        return $resultado;
    }
    
    public function obtenerPresupuesto()
    {     
        $table = "(select pre.idPresupuesto, pre.nombrePres, pre.idServicios, tipoPlantilla,  
        ser.nombreS AS servicio, DATE_FORMAT(fecha, '%d-%m-%Y') as fecha, importe
        from presupuesto pre
        LEFT JOIN plantillasPres on plantillasPres.idPlantilla = pre.idPlantilla
        LEFT JOIN servicio ser ON pre.idServicios=ser.idServicio) temp";
      // Table's primary key
      $primaryKey = 'idPresupuesto';
      $columns = array(
          array( 'db' => 'idPresupuesto', 'dt' => 0 ),
          array( 'db' => 'nombrePres',  'dt' => 1 ),
          array( 'db' => 'fecha',  'dt' => 2 ),
          array( 'db' => 'servicio', 'dt' => 3 ),
          array( 'db' => 'importe',  'dt' => 4 ),
      );
         
      /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
       * If you just want to use the basic configuration for DataTables with PHP
       * server-side, there is no need to edit below this line.
       */

      require( 'ssp.class.php' );
      echo json_encode(
          SSP::simple( $_GET, $table, $primaryKey, $columns )
      );
  }
  // SELECT PARA EL MODAL DE EDITAR
  public function obtenerPresupuestoUpdate($id){
    
    $this->db->query('SELECT presupuesto.*, pla.*, ser.*, age.codagente, CONCAT(age.Nombre," ",age.Apellidos) AS nombreAgente
                    FROM presupuesto                     
                    LEFT JOIN plantillasPres pla ON pla.idPlantilla = presupuesto.idPlantilla
                    LEFT JOIN servicio ser ON presupuesto.idServicios=ser.idServicio
                    LEFT JOIN agentes age ON presupuesto.idAgente=age.codagente
                    WHERE idPresupuesto ='.$id);
    $resultado = $this->db->registros();

    $this->db->query('SELECT acc.*, cli.NOMBREJURIDICO, tip.descripcion, acf.NOMBREACCION, moda.DESMODALIDAD AS nombreModalidad, niv.DESCNIVELCURSO AS nombreNivel,
                    acp.idProyecto, pro.fechaInicio, pro.fechaFin
                    FROM acciones_presupuesto acc
                    LEFT JOIN empresasclientes cli ON acc.idEMPRESA=cli.idEMPRESA
                    LEFT JOIN tipologia tip ON acc.idServicio=tip.codtipologia
                    LEFT JOIN accionesformativas acf ON acc.idACCION=acf.idACCION
                    LEFT JOIN acciones_proyecto acp ON acc.idAccionPres=acp.idAccionPres
                    LEFT JOIN modalidadesdeacciones moda ON acc.modalidad=moda.CODMODALIDAD
                    LEFT JOIN nivelesdecursos niv ON acc.nivel=niv.CODNIVELCURSO
                    LEFT JOIN proyectos pro ON acp.idProyecto=pro.idProyecto
                    WHERE acc.idPresupuesto ='.$id);
    $resultado2 = $this->db->registros();

    $final = ['cabecera' => $resultado, 'detalle'=> $resultado2];
    return $final;
    
}


public function obtenerServicioUpdate($id)
{
    $sql = "SELECT * FROM acciones_presupuesto 
    LEFT JOIN empresasclientes ON empresasclientes.idEMPRESA = acciones_presupuesto.idEMPRESA
    LEFT JOIN servicio ON servicio.idServicio = acciones_presupuesto.idServicio
    LEFT JOIN accionesformativas ON accionesformativas.idACCION = acciones_presupuesto.idACCION
    WHERE idPresupuesto = $id";
    $this->db->query($sql);

    $resultado = $this->db->registros();

    return $resultado;
}

public function obtenerServicioTipologia($id)
{
    $sql = "SELECT descripcion AS tipologia FROM acciones_presupuesto acc
            LEFT JOIN tipologia tip ON acc.idServicio=tip.codtipologia
            WHERE acc.idAccionPres= $id";
    $this->db->query($sql);
    $resultado = $this->db->registro();
    return $resultado;
}

// AGREGAR PRESUPUESTO
    public function agregarPresupuesto($datos,$datos2)
    {

        $importe = 0;
        if ($datos2['importe']) {
            for($i = 0; $i < sizeof($datos2['importe']); $i++){    
                $importe = $importe + $datos2['importe'][$i];
            }
        }

        /*
        echo"entra al controlador";
        echo"<br>datos: <br>";
        print_r($datos);
        echo"<br>datos2: <br>";
        print_r($datos2);
        if (!$datos2) {
            echo"datos2 viene vacío";
        }
        echo"<br>importe: <br>";
        print_r($importe);
        die;
        */
        
        $this->db->query("INSERT INTO presupuesto ( importe, idPlantilla, nombrePres, idServicios ,fecha, 
                        observaciones, estado, htmlPresupuesto, idAgente) 
                        VALUES ( :importe, :idPlantilla, :nombrePres, :idServicios, :fecha, :observaciones, 
                        :estado, :htmlPresupuesto, :idAgente)");
       
        // vincular valores  
        $this->db->bind(':idPlantilla', $datos['plantilla']);
        $this->db->bind(':nombrePres', $datos['nombrePres']);
        $this->db->bind(':idServicios', $datos['servicios']);
        $this->db->bind(':importe', $importe);
        $this->db->bind(':fecha', $datos['fecha']);
        $this->db->bind(':observaciones', $datos['observaciones']);
        $this->db->bind(':estado', $datos['estado']);
        $this->db->bind(':htmlPresupuesto', $datos['html']);
        $this->db->bind(':idAgente', $datos['asignaAgente']);
     
        //Ejecutar
        if($this->db->execute()){

            $this->db->query('SELECT idPresupuesto FROM presupuesto  
            WHERE idPresupuesto = (SELECT max(idPresupuesto) FROM presupuesto)');

            $ultima = $this->db->registros();
            $lastId = $ultima[0]->idPresupuesto;


            if ($datos2){

                for($i = 0; $i < sizeof($datos2['idEMPRESA']); $i++){
                    $this->db->query(" INSERT INTO acciones_presupuesto (idEMPRESA, idPresupuesto, idServicio, idAccion, importe, 
                                        horas,hPresenciales,hTeleformacion,hAulaVirtual,participantes,modalidad,nivel,estatus) 
                                    VALUES (:idEMPRESA, :idPresupuesto, :idServicio, :idAccion, :importe,
                                        :horas,:hPresenciales,:hTeleformacion,:hAulaVirtual, :participantes, :modalidad, :nivel, :estatus)");

                    $this->db->bind(':idPresupuesto', $lastId);
                    $this->db->bind(':idServicio', $datos2['idServicio'][$i]);
                    $this->db->bind(':idEMPRESA', $datos2['idEMPRESA'][$i]);
                    $this->db->bind(':idAccion', $datos2['idAccion'][$i]);
                    $this->db->bind(':importe', $datos2['importe'][$i]);
                    $this->db->bind(':horas', $datos2['horas'][$i]);

                    $this->db->bind(':hPresenciales', $datos2['hPresenciales'][$i]);
                    $this->db->bind(':hTeleformacion', $datos2['hTeleformacion'][$i]);
                    $this->db->bind(':hAulaVirtual', $datos2['hAulaVirtual'][$i]);
                    
                    $this->db->bind(':participantes', $datos2['participantes'][$i]);
                    $this->db->bind(':modalidad', $datos2['modalidad'][$i]);
                    $this->db->bind(':nivel', $datos2['nivel'][$i]);
                    $this->db->bind(':estatus', 0 ); //creada
                    $this->db->execute();
                }
                
                //$datosPres = $this->obtenerPresupuestoUpdate($lastId);
                //return $datosPres;            
            }
            return $lastId;
        } else {
            return false;
        }

    }


    public function insertarRegistroFichero($nombre,$idPres,$tipo,$descripcion)
    {
        $this->db->query("INSERT INTO presupuestoDocs (idPresupuesto,tipo,nombre,descripcion) 
                        VALUES (:idPresupuesto,:tipo,:nombre,:descripcion)");
               
        $this->db->bind(':idPresupuesto', $idPres);
        $this->db->bind(':tipo', $tipo);
        $this->db->bind(':nombre', $nombre);
        $this->db->bind(':descripcion', $descripcion);
        
        if($this->db->execute()){
            //traer todos los ficheros del presupuesto
            $row = $this->obtenerFicherosPresupuesto($idPres);
            return $row;
        }else{
            return false;
        }
    }

    public function obtenerDatosFichero($idDoc)
    {
        $this->db->query('SELECT * FROM presupuestoDocs WHERE idDocumento='.$idDoc);
        $row = $this->db->registro();
        return $row;
    }

    public function obtenerFicherosPresupuesto($idPres)
    {
        $this->db->query('SELECT * FROM presupuestoDocs WHERE idPresupuesto='.$idPres);
        $row = $this->db->registros();
        return $row;
    }

    public function updatePresupuesto($datos,$datos2)
    {
        //1- obtengo presupuesto total guardado
        $importe = 0;
        if ($datos['importe']) {
            for($i = 0; $i < sizeof($datos['importe']); $i++){
                $importe = $importe + $datos['importe'][$i];
            }
        }
   
        //2- Actualiza la tabla presupuesto
        $this->db->query('UPDATE presupuesto 
                        SET  importe = :importe, observaciones = :observaciones, htmlPresupuesto = :htmlPresupuesto, 
                        idAgente = :asignaAgenteEdit, nombrePres= :nombrePresEdit
                        WHERE idPresupuesto = :id');        
        $this->db->bind(':id', $datos['id']);
        $this->db->bind(':importe', $importe);
        $this->db->bind(':observaciones', $datos['observaciones']);
        $this->db->bind(':htmlPresupuesto', $datos['html']);
        $this->db->bind(':asignaAgenteEdit', $datos['asignaAgenteEdit']);
        $this->db->bind(':nombrePresEdit', $datos['nombrePresEdit']);        
        
        if($this->db->execute()){
            
            //3- Actualiza las filas guardadas del presupuesto según criterio si viene aprobado o pendiente
            if ($datos2) {
                foreach ($datos2 as $key) {
                    if ($key['situacion'] == 'Aprobado') { //ya existe el proyecto,
                        //que actualice cliente, tipologia (servicio), importe, participantes en acciones_presupuesto y acciones_proyecto
                        $this->actualizarDatosAccionesProyecto($key);
                    }else if ($key['situacion'] == 'Pendiente'){ //no se ha creado proyecto ni acción de proyecto, que actualice solo en acciones_presupuesto                    
                        $this->actualizarDatosAccionesPresupuesto($key);                    
                    }
                }
            }

            return true;
        } else {
            return false;
        }
    }

    public function actualizarDatosAccionesProyecto($arr)
    { 
        //actualizo las líneas de proyecto
        $this->db->query('UPDATE acciones_proyecto
                        SET idEMPRESA=:idEMPRESA, idTipo = :tipologia,  importe = :importe
                        WHERE idAccionPres = :idAccionPres');

        $this->db->bind(':idAccionPres', $arr['idAccionPres']);
        $this->db->bind(':idEMPRESA', $arr['idEMPRESA']);
        $this->db->bind(':tipologia', $arr['idServicio']);
        $this->db->bind(':importe', $arr['importe']);
        $this->db->execute();

        //3- actualizo las líneas de presupuesto
        $this->db->query('UPDATE acciones_presupuesto
                        SET idEMPRESA=:idEMPRESA, idServicio = :tipologia, importe = :importe, 
                       participantes = :participantes
                        WHERE idAccionPres = :idAccionPres');

        $this->db->bind(':idAccionPres', $arr['idAccionPres']);
        $this->db->bind(':idEMPRESA', $arr['idEMPRESA']);
        $this->db->bind(':tipologia', $arr['idServicio']);
        $this->db->bind(':importe', $arr['importe']);        
        $this->db->bind(':participantes', $arr['participantes']);
        $this->db->execute();
    }

    public function actualizarDatosAccionesPresupuesto($arr)
    {    
        $this->db->query('UPDATE acciones_presupuesto
                        SET idEMPRESA=:idEMPRESA, idServicio = :tipologia, idACCION=:idACCION,  importe = :importe, 
                        horas=:horas, hPresenciales=:hPresenciales ,hTeleformacion =:hTeleformacion, hAulaVirtual=:hAulaVirtual,                        
                        participantes = :participantes, nivel=:nivel, modalidad =:modalidad
                        WHERE idAccionPres = :idAccionPres');

        $this->db->bind(':idAccionPres', $arr['idAccionPres']);
        $this->db->bind(':idEMPRESA', $arr['idEMPRESA']);
        $this->db->bind(':tipologia', $arr['idServicio']);
        $this->db->bind(':idACCION', $arr['idAccion']);
        $this->db->bind(':importe', $arr['importe']);
        $this->db->bind(':horas', $arr['horas']);
        $this->db->bind(':hPresenciales', $arr['hPresenciales']);
        $this->db->bind(':hTeleformacion', $arr['hTeleformacion']);
        $this->db->bind(':hAulaVirtual', $arr['hAulaVirtual']);
        $this->db->bind(':participantes', $arr['participantes']);
        $this->db->bind(':nivel', $arr['nivel']);
        $this->db->bind(':modalidad', $arr['modalidad']);
        
        $this->db->execute();
        
    }    
    
    public function agregarNuevasLineasPresupuesto($datos,$datos3) 
    {
        /*echo"entra al modelo";
        echo"imprime datos";
        var_dump($datos);
        echo"imprime datos3";
        var_dump($datos3);*/
        
        //1- obtengo importe presupuesto total guardado
        $this->db->query('SELECT importe FROM presupuesto pre WHERE pre.idPresupuesto='.$datos['id']);
        $row = $this->db->registro();
        $ultImporte = $row->importe;

        $importe = 0;        
        for($i = 0; $i < sizeof($datos['importesNuevos']); $i++){
            $importe = $importe + $datos['importesNuevos'][$i];
        }
        $importeFinal = $ultImporte + $importe;
        
        //2- Actualiza la tabla presupuesto
        $this->db->query('UPDATE presupuesto 
                        SET  importe = :importe
                        WHERE idPresupuesto = :id');   

        $this->db->bind(':id', $datos['id']);
        $this->db->bind(':importe', $importeFinal);             
        
        if($this->db->execute()){
            
            //3- Inserta las filas nuevas del presupuesto en acciones_presupuesto
            foreach ($datos3 as $key) {
                if ($key['estatusNuevo'] == 'Aprobado') {
                    $cond = 1;
                }else if ($key['estatusNuevo'] == 'Pendiente') {
                    $cond = 0;
                }
                
                $this->db->query("INSERT INTO acciones_presupuesto 
                                (idPresupuesto, idEMPRESA, idServicio, idAccion, importe, horas,hPresenciales,hTeleformacion,hAulaVirtual,
                                participantes, modalidad, nivel, estatus)                                 
                                VALUES (:idPresupuesto, :idEMPRESA, :idServicio, :idAccion, :importe, :horas, :hPresenciales, :hTeleformacion, :hAulaVirtual, 
                                :participantes, :modalidad, :nivel, :estatus)");

                $this->db->bind(':idPresupuesto', $datos['id']);
                $this->db->bind(':idEMPRESA', $key['idEMPRESA']);
                $this->db->bind(':idServicio', $key['idServicio']);      
                $this->db->bind(':idAccion', $key['idAccion']);          
                $this->db->bind(':importe', $key['importe']);
                $this->db->bind(':horas', $key['horas']);
                
                $this->db->bind(':hPresenciales', $key['hPresenciales']);
                $this->db->bind(':hTeleformacion', $key['hTeleformacion']);
                $this->db->bind(':hAulaVirtual', $key['hAulaVirtual']);

                $this->db->bind(':participantes', $key['participantes']);
                $this->db->bind(':modalidad', $key['modalidad']);
                $this->db->bind(':nivel', $key['nivel']);
                $this->db->bind(':estatus',$cond);
                $this->db->execute();

                //obtengo el idAccionPres creado
                $this->db->query('SELECT idAccionPres FROM acciones_presupuesto  
                                WHERE idAccionPres = (SELECT max(idAccionPres) FROM acciones_presupuesto)');
                $row = $this->db->registro();
                $ultima = $row->idAccionPres;

                //4- si viene aprobado, que valide si tiene proyecto creado
                if ($cond == 1) {
                    $datosPres=[
                        'idpres'=>$datos['id'],
                        'idaccion'=>$key['idAccion'],
                        'fechaInicio'=>$key['fechaInicio'],
                        'nivel'=>$key['nivel'],
                        'modalidad'=>$key['modalidad'],
                        'horas'=>$key['horas'],                        
                        'hPresenciales' => $key['hPresenciales'],
                        'hTeleformacion' => $key['hTeleformacion'],
                        'hAulaVirtual' => $key['hAulaVirtual'],
                        'idAccion' => $key['idAccion'],
                        'idaccionPres' => $ultima
                    ]; 
                                       
                    $validarProy = $this->validarProyecto($datosPres);
                    
                    if ( $validarProy == '') {                        
                        //5- proyecto no existe, crear proyecto y fila correspondiente en acciones_proyecto            
                        $ins = $this->crearProyectoyAccionProyecto($datosPres);                    
                    }else if ( $validarProy > 0 ){                        
                        //6- proyecto existe, que cree fila correspondiente en acciones_proyecto
                        $ins = $this->crearAccionProyectoDesdeAccionPresupuesto($datosPres, $validarProy);                    
                    }
                }

            }
            
            return true;
        } else {
            return false;
        }

    }

    public function borrarPresupuesto($datos){
    
        $this->db->query("Delete from presupuesto where idPresupuesto =".$datos['id']);
        
        //Ejecutar
        if($this->db->execute()){
            return true;
        } 
        else {
            echo "error";
            return false;
        }

    }

    /**
     * Función que valida si un proyecto existe o no con el id del presupuesto
     */
    public function validarProyecto($datosPres)
    {       
       
        $this->db->query('SELECT pro.idProyecto, pro.idPresupuesto
                        FROM proyectos pro
                        WHERE pro.idPresupuesto = :idpres AND pro.accionformativa=:idaccion AND pro.fechaInicio=:fechaInicio');
        
        $this->db->bind(':idpres', $datosPres['idpres']);
        $this->db->bind(':idaccion', $datosPres['idaccion']);
        $this->db->bind(':fechaInicio', $datosPres['fechaInicio']);
        $resultado = $this->db->registro();
        $res = $resultado->idProyecto;
        
        if ( $res == '') {                                    
            return '';
        }else{
            return $res;
        }

    }

    /**
     * Función que cambia el estado de un presupuesto de de pendiente a aprobado
     */
    public function aprobarPresupuesto($datos)
    {            
        $this->db->query('UPDATE acciones_presupuesto 
                        SET  estatus = :estatus
                        WHERE idAccionPres = :idAccionPres');

        $this->db->bind(':estatus', 1); //aprobada
        $this->db->bind(':idAccionPres', $datos['idaccionPres']);
        
        if($this->db->execute()){
            return true;
        }else{     
            return false;
        }

    }    

    /**
     * Función que cambia el estado de un presupuesto de de pendiente a rechazado
     */
    public function rechazarPresupuesto($datos)
    {    
        if ($datos['fechaRechazo'] == '' || $datos['fechaRechazo']==null) {
            $fechaRechazo = date('Y-m-d');
        }else{
            $fechaRechazo = $datos['fechaRechazo'];
        }
        $this->db->query('UPDATE acciones_presupuesto 
                        SET  estatus = :estatus, fechaRechazo = :fechaRechazo
                        WHERE idAccionPres = :idaccion');

        $this->db->bind(':estatus', 2); //rechazada
        $this->db->bind(':idaccion', $datos['idaccion']);
        $this->db->bind(':fechaRechazo', $fechaRechazo);
        
        if($this->db->execute()){
            return true;
        }else{     
            return false;
        }

    }


    /**
     * Función que crea un proyecto y acciones proyecto desde la aprobación de presupuesto
     */
    public function crearProyectoyAccionProyecto($datos) //
    {            
        //formando el correlativo presupuesto-proyecto
        $this->db->query('SELECT COUNT(*) AS contador
                        FROM proyectos pro
                        WHERE pro.idPresupuesto =:idpres');

        $this->db->bind(':idpres', $datos['idpres']);
        $resultado = $this->db->registro();
        $indice = $resultado->contador + 1;

        //buscar nombre de la acción para asignarla al nombre del proyecto
        $this->db->query('SELECT acc.NOMBREACCION FROM accionesformativas acc WHERE acc.idACCION='.$datos['idaccion']);
        $resultado = $this->db->registro();
        $nombreAccion = $resultado->NOMBREACCION;
      
        $this->db->query(" INSERT INTO proyectos (idPresupuesto,accionformativa,fechaInicio,fechaFin,indice,
                            modalidad, nivel, horas,hAulaVirtual,hTeleformacion,hPresenciales, nombreProyecto)                            
                            VALUES (:idPresupuesto, :accionformativa, :fechaInicio, :fechaFin ,:indice,
                            :modalidad, :nivel, :horas, :hAulaVirtual, :hTeleformacion, :hPresenciales, :nombreProyecto)");

        $this->db->bind(':idPresupuesto', $datos['idpres']);
        $this->db->bind(':accionformativa', $datos['idaccion']);
        $this->db->bind(':fechaInicio', $datos['fechaInicio']);
        $this->db->bind(':fechaFin', date('Y').'-12-31');
        $this->db->bind(':indice', $indice);
        $this->db->bind(':modalidad', $datos['modalidad']);
        $this->db->bind(':nivel', $datos['nivel']);
        $this->db->bind(':horas', $datos['horas']);
        
        $this->db->bind(':hAulaVirtual', $datos['hAulaVirtual']);
        $this->db->bind(':hTeleformacion', $datos['hTeleformacion']);
        $this->db->bind(':hPresenciales', $datos['hPresenciales']);

        $this->db->bind(':nombreProyecto', $nombreAccion);

        if($this->db->execute()){               
            $this->db->query('SELECT idProyecto FROM proyectos  
                            WHERE idProyecto = (SELECT max(idProyecto) FROM proyectos)');
            $ultima = $this->db->registros();
            $lastId = $ultima[0]->idProyecto;

            $this->crearAccionProyectoDesdeAccionPresupuesto($datos, $lastId);
            return true;
        } else {
            return false;
        }
    }

    
    /**
     * Función que crea acciones proyecto desde la aprobación de presupuesto
     */
    public function crearAccionProyectoDesdeAccionPresupuesto($datos, $lastId)
    {       
        //identifico el tipo de servicio para asignar un tipo al proyecto
            $this->db->query('SELECT acc.*, pre.idServicios, ser.nombreS, tip.descripcion
                            FROM acciones_presupuesto acc
                            LEFT JOIN presupuesto pre ON pre.idPresupuesto=acc.idPresupuesto
                            LEFT JOIN servicio ser ON pre.idServicios=ser.idServicio
                            LEFT JOIN tipologia tip ON acc.idServicio=tip.codtipologia
                            WHERE  acc.idAccionPres='.$datos['idaccionPres']);
            $accionPres = $this->db->registro();                          

            $this->db->query(" INSERT INTO acciones_proyecto (idPresupuesto,idAccionPres,idEMPRESA, idTipo, importe,estatus,idProyecto) 
                        VALUES (:idPresupuesto,:idAccionPres, :idEMPRESA, :idTipo, :importe, :estatus, :idProyecto)");

            $this->db->bind(':idPresupuesto', $datos['idpres']);
            $this->db->bind(':idAccionPres', $datos['idaccionPres']);
            $this->db->bind(':idEMPRESA', $accionPres->idEMPRESA);
            $this->db->bind(':idTipo', $accionPres->idServicio); //tipologia
            //$this->db->bind(':idACCION', $accionPres->idACCION);            
            $this->db->bind(':importe', $accionPres->importe);
            $this->db->bind(':estatus', 1); //accion proyecto creada con fecha de inicio
            //$this->db->bind(':fechaInicio', $datos['fechaInicio']);
            $this->db->bind(':idProyecto', $lastId);
            
            if($this->db->execute()){                            
                return true;
            } else {
                return false;
            }
    }

   
    public function verInformacionPresupuesto($id){
        $this->db->query('SELECT * from presupuesto
        LEFT JOIN plantillasPres on plantillasPres.idPlantilla = presupuesto.idPlantilla  
        LEFT JOIN grupos on grupos.idGrupo = presupuesto.idGrupo   
        WHERE idPresupuesto = :id');
        $this->db->bind(':id', $id);
        $resultado = $this->db->registros();
        return $resultado;
    }

    /**
     * Funcion que determina el estado de un presupuesto: pendiente, aprobado, rechazado
     */
    public function estadoPresupuesto($datos)
    {
        $this->db->query("SELECT * from presupuesto WHERE idPresupuesto = :id");
        $this->db->bind(':id', $datos['id']);
        $resultado = $this->db->registro();
        return $resultado;
    }

    public function verDatosPresupuestoAccion($id,$array){       
        $cond = "IN (";
        for ($i=0; $i <count($array) ; $i++) { 
            if($i != (count($array)-1)){
                $cond .=  $array[$i] . ",";
            } else {
                $cond .=  $array[$i] . ")";
            }            
        }

        $this->db->query('SELECT NOMBREACCION, NOMBREJURIDICO, acc.importe AS importeacc , presupuesto.*, acc.*, plantillasPres.*, grupos.* from presupuesto
                LEFT JOIN acciones_presupuesto acc ON acc.idPresupuesto = presupuesto.idPresupuesto
                LEFT JOIN accionesformativas af ON acc.idACCION=af.idACCION
                LEFT JOIN plantillasPres on plantillasPres.idPlantilla = presupuesto.idPlantilla  
                LEFT JOIN grupos on grupos.idGrupo = presupuesto.idGrupo
                LEFT JOIN empresasclientes emp ON acc.idEMPRESA=emp.idEMPRESA
                WHERE presupuesto.idPresupuesto ='.$id.' AND acc.idAccionPres '.$cond.'');
     
        $resultado = $this->db->registros();
        return $resultado;
        
    }


    
    public function actualizarCampoPresupuesto($tabla,$campo,$contenido,$idtabla,$id)
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
        
    public function actualizarTipologiasPresupuestoYProyecto($contenido,$idAccionPres,$idAccionProy)
    {
        $q = "UPDATE acciones_presupuesto SET idServicio =  :contenido WHERE idAccionPres = :idAccionPres";
    
        $this->db->query($q);
        $this->db->bind(':contenido', $contenido);
        $this->db->bind(':idAccionPres', $idAccionPres);

        if($this->db->execute()){
            $q = "UPDATE acciones_proyecto SET idTipo = :contenido WHERE idAccionProy = :idAccionProy";
    
            $this->db->query($q);
            $this->db->bind(':contenido', $contenido);
            $this->db->bind(':idAccionProy', $idAccionProy);
            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }else {
            return false;
        }
    }
 
    public function actualizarAccionEnPresupuestoYProyecto($contenido,$idProyecto)
    {
        //1- actualizo la nueva accion en la tabla proyectos
        $q = "UPDATE proyectos SET accionformativa = :contenido WHERE idProyecto = :idProyecto";    
        $this->db->query($q);
        $this->db->bind(':contenido', $contenido);
        $this->db->bind(':idProyecto', $idProyecto);

        if($this->db->execute()){

            //2- Traigo todas las idAccionPres que pertenezcan al proyecto y actualizo la accion
            $this->db->query('SELECT apro.idAccionPres FROM acciones_proyecto apro
                            LEFT JOIN acciones_presupuesto apre ON apro.idAccionPres=apre.idAccionPres
                            WHERE apro.idProyecto='.$idProyecto);
        
            $lineas = $this->db->registros();

            //3- Actualizo la nueva acción en acciones_presupuesto
            foreach ($lineas as $key) {
                $q = "UPDATE acciones_presupuesto SET idACCION = :contenido WHERE idAccionPres =".$key->idAccionPres;
                $this->db->query($q);
                $this->db->bind(':contenido', $contenido);                
                $this->db->execute();
            }
           
            return true;
        }else {
            return false;
        }
    }
    
    public function actualizarDiferentesCamposEnPresupuestoYProyecto($contenido,$idProyecto,$campo)
    {
        //1- actualizo la nueva accion en la tabla proyectos
        $q = "UPDATE proyectos SET " . $campo . " = :contenido WHERE idProyecto = :idProyecto";    
        $this->db->query($q);
        $this->db->bind(':contenido', $contenido);
        $this->db->bind(':idProyecto', $idProyecto);

        if($this->db->execute()){

            //2- Traigo todas las idAccionPres que pertenezcan al proyecto y actualizo la accion
            $this->db->query('SELECT apro.idAccionPres FROM acciones_proyecto apro
                            LEFT JOIN acciones_presupuesto apre ON apro.idAccionPres=apre.idAccionPres
                            WHERE apro.idProyecto='.$idProyecto);
        
            $lineas = $this->db->registros();

            //3- Actualizo la nueva acción en acciones_presupuesto
            foreach ($lineas as $key) {
                $q = "UPDATE acciones_presupuesto SET " . $campo . " = :contenido WHERE idAccionPres =".$key->idAccionPres;
                $this->db->query($q);
                $this->db->bind(':contenido', $contenido);                
                $this->db->execute();
            }
           
            return true;
        }else {
            return false;
        }
    }

    public function actualizarImporteEnPresupuestoYProyecto($importe,$idAccionProy,$idAccionPres,$idPresupuesto)
    {
        //1- actualizo en acciones_proyecto
        $q = "UPDATE acciones_proyecto SET importe = :importe WHERE idAccionProy = :idAccionProy";    
        $this->db->query($q);
        $this->db->bind(':importe', $importe);
        $this->db->bind(':idAccionProy', $idAccionProy);
        $this->db->execute();

        //2- actualizo en acciones_presupuesto
        $q = "UPDATE acciones_presupuesto SET importe = :importe WHERE idAccionPres = :idAccionPres";    
        $this->db->query($q);
        $this->db->bind(':importe', $importe);
        $this->db->bind(':idAccionPres', $idAccionPres);
        $this->db->execute();

        //3- actualizo el total del presupuesto
        //traigo la suma de acciones_presupuesto
        $this->db->query("SELECT SUM(importe) AS total 
                        FROM acciones_presupuesto apre 
                        WHERE apre.idPresupuesto=".$idPresupuesto);

        $resultado = $this->db->registro();
        $total = $resultado->total;

        $q = "UPDATE presupuesto SET importe = :importe WHERE idPresupuesto = :idPresupuesto";    
        $this->db->query($q);
        $this->db->bind(':importe', $total);
        $this->db->bind(':idPresupuesto', $idPresupuesto);
        $this->db->execute();

        return true;

    }
    

}