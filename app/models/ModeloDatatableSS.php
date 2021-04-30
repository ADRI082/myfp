<?php


class ModeloDatatableSS{

    private $db;

    public function __construct(){
        $this->db = new Base;
    }

    public function obtenerAcciones(){

          $table = "(
            select acc.idACCION as id, tip.DESTIPOFORMACION as tipo , area.DESAREA as area ,moda.DESMODALIDAD as modalidad ,acc.NOMBREACCION as nombre ,
            acc.DESCRIBEACCION as descripcion, servicio.nombreS as servicio, acc.APRECIOPRESENCIALES as presencial, acc.APRECIOTELEFORMACION as teleformacion,
            acc.objetivoPrevisto as objetivoP, acc.LINKCONTENIDO as contenido, acc.ContenidoPrevisto as contenidoP, acc.MetodologiaPrevista as metodologiaP, 'btnEdit' as btnEdit
            from accionesformativas acc 
            LEFT JOIN  tipodeaccion tip on acc.CODTIPO = CODTIPOFORMACION
            LEFT JOIN areadeformacion area on acc.CODAREA = area.CODAREA
            LEFT JOIN servicio on servicio.idServicio = acc.idServicio
            LEFT JOIN modalidadesdeacciones moda on acc.CODMODALIDAD = moda.CODMODALIDAD
            ) temp";

        //  echo $table;
        // Table's primary key
        $primaryKey = 'id';

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes
        $columns = array(
            array( 'db' => 'id', 'dt' => 'DT_RowId' ),
            array( 'db' => 'id',  'dt' => 0 ),
            array( 'db' => 'tipo',  'dt' => 1 ),
            array( 'db' => 'area',  'dt' => 2 ),
            array( 'db' => 'modalidad',  'dt' => 3 ),
            array( 'db' => 'nombre',  'dt' => 4 ),
            array( 'db' => 'descripcion',  'dt' => 5),
            array( 'db' => 'servicio',  'dt' => 6 ),
            array( 'db' => 'presencial',  'dt' => 7 ),
            array( 'db' => 'teleformacion',  'dt' => 8 ),
            array( 'db' => 'objetivoP',  'dt' => 9 ),
            //array( 'db' => 'contenido',  'dt' => 9),
            array( 'db' => 'contenidoP',  'dt' => 10 ),
            array( 'db' => 'metodologiaP',  'dt' => 11),
            array( 'db' => 'btnEdit',  'dt' => 12)
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

    public function obtenerServicio()
    {
        $this->db->query('SELECT idServicio as id, nombreS as servicio FROM servicio WHERE idServicio>1 ');
        $resultado = $this->db->registros();
        return $resultado;        
    }

    public function obtenerTipoAccion()
    {
        $this->db->query('SELECT CODTIPOFORMACION as id, DESTIPOFORMACION as tipoAccion FROM tipodeaccion');
        $resultado = $this->db->registros();
        return $resultado;  
    }    
   
    public function obtenerModalidad()
    {
        $this->db->query('SELECT CODMODALIDAD as id, DESMODALIDAD as modalidad FROM modalidadesdeacciones WHERE ACTIVO ="1" ');
        $resultado = $this->db->registros();
        return $resultado;  
    }

    public function obtenerAreaFormativa()
    {
        $this->db->query('SELECT CODAREA as id, DESAREA as areaFormativa FROM areadeformacion');
        $resultado = $this->db->registros();
        return $resultado; 
    }

    public function agregarAccion($datos)
    {

        //inserto los datos en la tabla empresasclientes
        $this->db->query("INSERT INTO accionesformativas (NOMBREACCION, idServicio, CODMODALIDAD, CODAREA, CODTIPO,
                        ObjetivoPrevisto, ContenidoPrevisto, MetodologiaPrevista, observaciones)
                        VALUES (:nombreAccion,:servicio,:modalidad,:areaFormativa,:tipoAccion,:objetivoAccion,:contenido,:metodologia,:observacionesAccion)");  
        
        $this->db->bind(':nombreAccion', $datos['nombreAccion']);
        $this->db->bind(':servicio', $datos['servicio']);
        $this->db->bind(':modalidad', $datos['modalidad']);
        $this->db->bind(':areaFormativa', $datos['areaFormativa']);
        $this->db->bind(':tipoAccion', $datos['tipoAccion']);
        $this->db->bind(':objetivoAccion', $datos['objetivoAccion']);
        $this->db->bind(':metodologia', $datos['metodologia']);
        $this->db->bind(':contenido', $datos['contenido']);
        $this->db->bind(':observacionesAccion', $datos['observacionesAccion']); 

        if($this->db->execute()){

            $this->db->query('SELECT idACCION FROM accionesformativas  
                            WHERE idACCION = (SELECT max(idACCION) FROM accionesformativas)');
            $ultima = $this->db->registro();
            $idNuevaAccion = $ultima->idACCION;
            return $idNuevaAccion;
        }else{
            return false;
        }
                
    }

    public function insertarRegistroFichero($nombre,$idAccion,$tipo,$descripcion)
    {
        $this->db->query("INSERT INTO accionesDocs (idAccion,tipo,nombre,descripcion) 
                        VALUES (:idAccion,:tipo,:nombre,:descripcion)");
               
        $this->db->bind(':idAccion', $idAccion);
        $this->db->bind(':tipo', $tipo);
        $this->db->bind(':nombre', $nombre);
        $this->db->bind(':descripcion', $descripcion);
        
        if($this->db->execute()){
           return true;
        }else{
            return false;
        }
    }



    public function getAccionesUpdate($id)
    {
        $this->db->query('SELECT * from accionesformativas WHERE idACCION ='.$id);  
        $resultado1 = $this->db->registro();

        $this->db->query('SELECT * from accionesDocs WHERE idACCION ='.$id);
        $resultado2 = $this->db->registros();

        $final = ['datos'=> $resultado1, "ficheros"=>$resultado2];
        return $final;
    }


    public function editarAccion($datos)
    {
        
        $this->db->query("UPDATE accionesformativas 
                        SET  NOMBREACCION=:nombreAccion, idServicio=:servicio, CODMODALIDAD=:modalidad, CODAREA=:areaFormativa, CODTIPO=:tipoAccion,
                        ObjetivoPrevisto=:objetivoAccion, ContenidoPrevisto=:contenido, MetodologiaPrevista=:metodologia, observaciones=:observacionesAccion
                        WHERE idACCION = :id");
        
        $this->db->bind(':id', $datos['id']);
        $this->db->bind(':nombreAccion', $datos['nombreAccion']);
        $this->db->bind(':servicio', $datos['servicio']);
        $this->db->bind(':modalidad', $datos['modalidad']);
        $this->db->bind(':tipoAccion', $datos['tipoAccion']);
        $this->db->bind(':areaFormativa', $datos['areaFormativa']);
        $this->db->bind(':objetivoAccion', $datos['objetivoAccion']);
        $this->db->bind(':metodologia', $datos['metodologia']);
        $this->db->bind(':contenido', $datos['contenido']);
        $this->db->bind(':observacionesAccion', $datos['observacionesAccion']);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }

    }

    public function borrarAccion($datos)
    {
    
        $this->db->query("Delete from accionesformativas where idACCION =".$datos['id']);
    
        if($this->db->execute()){
            return true;
        } 
        else {
            echo "error";
            return false;
        }

    }

    public function obtenerDatosFichero($idDoc)
    {
        $this->db->query('SELECT * FROM accionesDocs WHERE idDocAccion='.$idDoc);
        $row = $this->db->registro();
        return $row;
    }


}
