
<?php


class ModeloClientes{
 private $db;

    public function __construct(){
        $this->db = new Base;
    }


    public function obtenerClientes(){

       
        $table = "(
            select idEMPRESA, codEmpresa, CIFCLIENTE, nombreG, NOMBREJURIDICO, NOMBRECOMERCIAL, NOMBREREPRESENTANTE,
            DIRECCION, LOCALIDAD, PROVINCIA, CODPOSTAL, TELEFONOFIJO1,
            TELEFONOFIJO2, TELEFONOMOVIL, EMAIL, WEB, NSSEMPRESA, oportunidad  from empresasclientes 
              left join grupos on grupos.idGrupo = empresasclientes.idGrupo
              WHERE empresasclientes.oportunidad IS NULL OR empresasclientes.oportunidad = 'cliente'
              ORDER BY empresasclientes.idEMPRESA DESC
            ) temp";

            // $table = "empresasclientes";

            //  echo $table;
        // Table's primary key
        $primaryKey = 'idEMPRESA';

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes
        $columns = array(
            array( 'db' => 'idEMPRESA', 'dt' => 'DT_RowId' ),
            array( 'db' => 'codEmpresa',  'dt' => 0 ),
            array( 'db' => 'CIFCLIENTE',  'dt' => 1 ),
            array( 'db' => 'nombreG',  'dt' => 2 ),
            array( 'db' => 'NOMBREJURIDICO',  'dt' => 3 ),
            array( 'db' => 'NOMBRECOMERCIAL',  'dt' => 4 ), 
            array( 'db' => 'NOMBREREPRESENTANTE',  'dt' => 5 ) 
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

// PARA EL SELECT DE GRUPOS
    public function obtenerGrupos(){
            $this->db->query('SELECT idGrupo as id, nombreG FROM grupos');
            $resultado = $this->db->registros();
            return $resultado;
    } 
        // PARA EL SELECT DE ACTIVIDAD
    public function obtenerActividad()
    {
        $this->db->query('SELECT CODCNAE as id, DESACTIVIDAD FROM actividadesempresariales');
        $resultado = $this->db->registros();
        return $resultado;
    } 
    // PARA EL SELECT DE SECTOR
    public function obtenerSector()
    {
        $this->db->query('SELECT CODSECTOR as id, SECTOR FROM sectores');
        $resultado = $this->db->registros();
        return $resultado;
    } 
    // PARA EL SELECT DE COLABORADOR
     public function obtenerColaborador()
     {
         $this->db->query('SELECT codColaborador as id, RazonSocial FROM colaboradores');
         $resultado = $this->db->registros();
         return $resultado;
     }
    // PARA EL SELECT DE AGENTES
    public function obtenerAgente()
    {
        $this->db->query('SELECT codagente as id, CONCAT(Nombre, " ", Apellidos) AS agente FROM agentes');
        $resultado = $this->db->registros();
        return $resultado;
    }
    // PARA EL SELECT DE ASESORES
    public function obtenerAsesor()
    {
        $this->db->query('SELECT idAsesor, nomasesor FROM asesores');
        $resultado = $this->db->registros();
        return $resultado;
    }
    
    public function obtenerFormasDePago()
    {
        $this->db->query('SELECT CODFORMAPAGO AS id, DESFORMAPAGO AS formadepago FROM formasdepago');
        $resultado = $this->db->registros();
        return $resultado;
    }
    

    public function agregarEmpresa($datos,$datos2=''){

        //buscando el último
        $this->db->query("SELECT MAX(codEmpresa) AS codEmpresa FROM empresasclientes");
        $ultimoCod = $this->db->registro();
        $nuevoCod = $ultimoCod->codEmpresa + 1;

        //sino llega grupoId

        
        $grupoId = $datos['grupoId'];
        $grupo = $datos['grupo'];

        if ($grupoId == null || $grupoId == '' ) { // si llega vacío el grupoId            
            //no llega grupo
            if ($grupo == null || $grupo == '') {
                $this->db->query('INSERT INTO grupos (nombreG) VALUES (:grupoNom)');
                $this->db->bind(':grupoNom', $datos['razonSocial']); //inserta la razón social
                $this->db->execute();
               
                $this->db->query("SELECT MAX(idGrupo) AS idGrupo FROM grupos");
                $lastId = $this->db->registro();
                $idGrupo = $lastId->idGrupo;            
                $nomGrupo = $datos['razonSocial'];
            }else { //llega grupo
                $this->db->query('INSERT INTO grupos (nombreG) VALUES (:grupoNom)');
                $this->db->bind(':grupoNom', $grupo);
                $this->db->execute();
               
                $this->db->query("SELECT MAX(idGrupo) AS idGrupo FROM grupos");
                $lastId = $this->db->registro();
                $idGrupo = $lastId->idGrupo;            
                $nomGrupo = $grupo;
            }

        }else{           
            $this->db->query('SELECT * FROM grupos WHERE idGrupo="'.$grupoId.'" ');
            $datGrupo = $this->db->registro();
            $idGrupo = $grupoId;
            $nomGrupo = $datGrupo->nombreG;
        }

        //inserto los datos en la tabla empresasclientes
        $this->db->query("INSERT INTO empresasclientes (
                        codEmpresa,CIFCLIENTE,idGrupo,NOMBRE, NOMBRECOMERCIAL, NOMBREJURIDICO,CODACTIVIDAD,CODSECTOR,NIFREPRESENTANTE,NOMBREREPRESENTANTE,
                        CONTACTO,codcolaborador,codagente,DIRECCION,LOCALIDAD,PROVINCIA,CODPOSTAL,TELEFONOFIJO1,TELEFONOFIJO2,
                        TELEFONOMOVIL,EMAIL,WEB,NSSEMPRESA,Convenio,FechaConvenio,RLT,numtrabajadores,escliente,asesorTipo,credito, observaciones, oportunidad,numcuenta,formadepago)
                        VALUES (:codEmpresa, :cif, :idGrupo, :grupo, :nombreComercial,:razonSocial,:actividad,:sector,:nifRepresentante,:representante,
                        :contactoPrincipal,:colaborador,:agente,:direccion,:poblacion,:provincia,:codigoPostal,:telefonofijo1,
                        :telefonofijo2,:movil,:email,:web,:nss,:convenio,:fechaConvenio,:rlt,:trabajadores,:activo,:asesorTipo,:credito, :observaciones, :oportunidad, :numcuenta,:formadepago)");
      
        //-------------
        $this->db->bind(':codEmpresa', $nuevoCod);
        $this->db->bind(':nombreComercial', $datos['nombreComercial']);
        $this->db->bind(':grupo', $nomGrupo);
        $this->db->bind(':idGrupo', $idGrupo);              
        //--------------        
        $this->db->bind(':cif', $datos['cif']);        
        $this->db->bind(':razonSocial', $datos['razonSocial']);
        $this->db->bind(':actividad', $datos['actividad']);
        $this->db->bind(':sector', $datos['sector']);
        $this->db->bind(':nifRepresentante', $datos['nifRepresentante']);
        $this->db->bind(':representante', $datos['representante']);
        $this->db->bind(':contactoPrincipal', $datos['contactoPrincipal']);
        $this->db->bind(':colaborador', $datos['colaborador']);
        $this->db->bind(':agente', $datos['agente']);
        $this->db->bind(':direccion', $datos['direccion']);
        $this->db->bind(':poblacion', $datos['poblacion']);
        $this->db->bind(':provincia', $datos['provincia']);
        $this->db->bind(':codigoPostal', $datos['codigoPostal']);
        $this->db->bind(':telefonofijo1', $datos['telefonofijo1']);
        $this->db->bind(':telefonofijo2', $datos['telefonofijo2']);
        $this->db->bind(':movil', $datos['movil']);
        $this->db->bind(':email', $datos['email']);
        $this->db->bind(':web', $datos['web']);
        $this->db->bind(':nss', $datos['nss']);
        $this->db->bind(':convenio', $datos['convenio']);
        $this->db->bind(':fechaConvenio', $datos['fechaConvenio']);
        $this->db->bind(':rlt', $datos['rlt']);
        $this->db->bind(':trabajadores', $datos['trabajadores']);
        $this->db->bind(':activo', $datos['activo']);
        $this->db->bind(':asesorTipo', $datos['asesorTipo']);
        $this->db->bind(':credito', $datos['creditoFormativo']);
        $this->db->bind(':observaciones', $datos['observaciones']);
        $this->db->bind(':oportunidad', 'cliente');
        $this->db->bind(':numcuenta', $datos['ctacte']); 
        $this->db->bind(':formadepago', $datos['formadepago']);        
         
        if($this->db->execute()){
                        
            $this->db->query("SELECT MAX(idEMPRESA) AS idEMPRESA FROM empresasclientes");
            $inserto = $this->db->registro();
            $insertado= $inserto->idEMPRESA;
             
            //vinculo empresa con agente
            if ($datos['agente'] != '' ) {
                
                $this->db->query("INSERT INTO agentesclientes (idEmpresa,idAgente) VALUES (:idEmpresa,:idAgente)");
                $this->db->bind(':idEmpresa', $insertado);
                $this->db->bind(':idAgente', $datos['agente']);
                $this->db->execute();            
            }    
            //vinculo empresa con colaborador          
            if ($datos['colaborador'] != '') {
                
                $this->db->query("INSERT INTO colaboradoresN (idEMPRESA,idColaborador) VALUES (:idEMPRESA,:idColaborador)");
                $this->db->bind(':idEMPRESA', $insertado);
                $this->db->bind(':idColaborador', $datos['colaborador']);
                $this->db->execute();            
            }    
            //Creo asesor y/o vinculo con cliente

            //si asesorTipo = interno que inserte los datos del asesor en empresas clientes
            if ($datos['asesorTipo'] == 'interno') {
                //nombre de asesor igual a contacto de asesor
                $this->db->query("UPDATE empresasclientes SET nomasesor = :nomAsesorInt, telefonocontacto1 = :telefAsesorInt, movilcontacto = :movfAsesorInt,
                                mailcontacto = :mailAsesorInt, direccioncontacto = :dirAsesorInt, codpostalcontacto = :codPosAsesorInt, localidadcontacto = :locAsesorInt, provinciacontacto = :provAsesorInt
                                WHERE idEMPRESA = :id");

                $this->db->bind(':id', $insertado);
                $this->db->bind(':nomAsesorInt', $datos['nomAsesorInt']);
                $this->db->bind(':telefAsesorInt', $datos['telefAsesorInt']);
                $this->db->bind(':movfAsesorInt', $datos['movfAsesorInt']);
                $this->db->bind(':mailAsesorInt', $datos['mailAsesorInt']);
                $this->db->bind(':dirAsesorInt', $datos['dirAsesorInt']);
                $this->db->bind(':codPosAsesorInt', $datos['codPosAsesorInt']);
                $this->db->bind(':locAsesorInt', $datos['locAsesorInt']);
                $this->db->bind(':provAsesorInt', $datos['provAsesorInt']);
                $this->db->execute();
                
            //si asesorTipo = externo y es nuevo que cree los datos del asesor nuevo en la tabla asesores            
            }else if ($datos['asesorTipo'] == 'externo' && $datos['selAsesorExt'] == 'nuevo') {
                $this->db->query("INSERT INTO asesores (nomasesor,mail,telefonoFijo,movil,direccion,contacto,localidad,
                                provincia,codigopostal)
                                VALUES (:nomAsesorExt,:mailAsesorExt,:telefAsesorExt,:movfAsesorExt,:dirAsesorExt,
                                :contAsesorExt,:locAsesorExt,:provAsesorExt,:codPosAsesorExt)");
                
                $this->db->bind(':nomAsesorExt',$datos['nomAsesorExt']);
                $this->db->bind(':mailAsesorExt',$datos['mailAsesorExt']);
                $this->db->bind(':telefAsesorExt',$datos['telefAsesorExt']);
                $this->db->bind(':movfAsesorExt',$datos['movfAsesorExt']);
                $this->db->bind(':dirAsesorExt',$datos['dirAsesorExt']);
                $this->db->bind(':contAsesorExt',$datos['contAsesorExt']);
                $this->db->bind(':locAsesorExt',$datos['locAsesorExt']);
                $this->db->bind(':provAsesorExt',$datos['provAsesorExt']);
                $this->db->bind(':codPosAsesorExt',$datos['codPosAsesorExt']);

               if ($this->db->execute()) {
                    //debería capturar el primarykey insertado, corregir esto
                    $this->db->query("SELECT MAX(idAsesor) AS idAsesor FROM asesores");
                    $insAsesor = $this->db->registro();
                    $idInsertAse= $insAsesor->idAsesor;
                    //y cree el vínculo de la empresa con el asesor
                    $this->db->query("INSERT INTO asesoresclientes (idAsesor,idEmpresa) VALUES (:idAsesor,:idEmpresa)");
                    $this->db->bind(':idEmpresa', $insertado);
                    $this->db->bind(':idAsesor', $idInsertAse);
                    $this->db->execute();
                }                        
            //si asesorTipo = externo y ya existe que cree vínculo de la empresa con el asesor
            }elseif ($datos['asesorTipo'] == 'externo' && $datos['selAsesorExt'] == 'existe') {
                $this->db->query("INSERT INTO asesoresclientes (idAsesor,idEmpresa) VALUES (:idAsesor,:idEmpresa)");
                $this->db->bind(':idEmpresa', $insertado);
                $this->db->bind(':idAsesor', $datos['selNomAsesorExt']);
                $this->db->execute();
            }

            if ($datos2 !='') {
                $this->agregarContactos($datos2,$insertado);
            }
            return true;
        }else{
            return false;
        }
        
    }

    //------------
    public function agregarContactos($array,$idEmpresa)
    {

        for($i = 0; $i < sizeof($array['nombreContacto']); $i++){
            $this->db->query(" INSERT INTO contactos (idEMPRESA, nombreC, areaDpto, telefonoFijo, movil, mail) 
                            VALUES (:idEMPRESA, :nombreC, :areaDpto, :telefonoFijo, :movil, :mail)");

            $this->db->bind(':idEMPRESA', $idEmpresa);
            $this->db->bind(':nombreC', $array['nombreContacto'][$i]);
            $this->db->bind(':areaDpto', $array['areaContacto'][$i]);
            $this->db->bind(':telefonoFijo', $array['telFijoContacto'][$i]);
            $this->db->bind(':movil', $array['movilContacto'][$i]);
            $this->db->bind(':mail', $array['emailContacto'][$i]);
            $this->db->execute();
        }               
    }
    public function borrarContactos($idEmpresa)
    {        
        $this->db->query("DELETE FROM contactos WHERE idEMPRESA =".$idEmpresa);
        
        $this->db->execute();  
        
    }   

    // EDITAR
    public function editarEmpresa($datos, $datos2=''){

        // primero se actualizan los datos generales
        $this->db->query("UPDATE empresasclientes 
                        SET CIFCLIENTE = :cif, NOMBREJURIDICO=:nombreJuridico, NOMBRECOMERCIAL=:nombreComercial, idGrupo = :idGrupo,
                        CODSECTOR=:sector, CODACTIVIDAD=:actividad, NIFREPRESENTANTE=:nifRepresentante,NOMBREREPRESENTANTE=:representante,
                        CONTACTO=:contactoPrincipal,DIRECCION=:direccion,LOCALIDAD=:poblacion,PROVINCIA=:provincia,CODPOSTAL=:codigoPostal,
                        TELEFONOFIJO1=:telefonofijo1,TELEFONOFIJO2=:telefonofijo2,TELEFONOMOVIL=:movil,EMAIL=:email,WEB=:web,
                        NSSEMPRESA=:nss, Convenio=:convenio,FechaConvenio=:fechaConvenio,RLT=:rlt,numtrabajadores=:trabajadores,
                        escliente=:activo,asesorTipo=:asesorTipo,credito=:credito, observaciones=:observaciones,
                        numcuenta=:numcuenta,formadepago=:formadepago, nomasesor = :contactoAsesorInt, telefonocontacto1 = :telefAsesorInt, 
                        movilcontacto = :movfAsesorInt,direccioncontacto = :dirAsesorInt, localidadcontacto = :locAsesorInt, 
                        provinciacontacto = :provAsesorInt, codpostalcontacto = :codPosAsesorInt, mailcontacto = :mailAsesorInt                        
                        WHERE idEMPRESA = :id");                        
            
        $this->db->bind(":id", $datos['id']);
        $this->db->bind(":cif", $datos['cif']);                
        $this->db->bind(":nombreJuridico", $datos['nombre']); 
        $this->db->bind(":nombreComercial", $datos['nombreComercial']); 
        $this->db->bind(":idGrupo", $datos['grupo']);
        $this->db->bind(":sector", $datos['sector']);
        $this->db->bind(":actividad", $datos['actividad']);        
        $this->db->bind(":nifRepresentante", $datos['nifRepresentante']);
        $this->db->bind(":representante", $datos['representante']);
        $this->db->bind(":contactoPrincipal", $datos['contactoPrincipal']);
        $this->db->bind(":direccion", $datos['direccion']); 
        $this->db->bind(":poblacion", $datos['poblacion']); 
        $this->db->bind(":provincia", $datos['provincia']);                 
        $this->db->bind(":codigoPostal", $datos['codigoPostal']);                 
        $this->db->bind(":telefonofijo1", $datos['telefonofijo1']); 
        $this->db->bind(":telefonofijo2", $datos['telefonofijo2']);                 
        $this->db->bind(":movil", $datos['movil']); 
        $this->db->bind(":email", $datos['email']); 
        $this->db->bind(":web", $datos['web']); 
        $this->db->bind(":nss", $datos['nss']);                  
        $this->db->bind(":convenio", $datos['convenio']); 
        $this->db->bind(":fechaConvenio", $datos['fechaConvenio']); 
        $this->db->bind(":rlt", $datos['rlt']);
        $this->db->bind(":trabajadores", $datos['trabajadores']);
        $this->db->bind(":activo", $datos['activo']);
        $this->db->bind(":asesorTipo", $datos['asesorTipo']);
        $this->db->bind(":credito", $datos['creditoFormativo']);
        $this->db->bind(":observaciones", $datos['observaciones']);
        $this->db->bind(":numcuenta", $datos['ctacte']);
        $this->db->bind(":formadepago", $datos['formadepago']);
        $this->db->bind(":contactoAsesorInt", $datos['contactoAsesorInt']); 
        $this->db->bind(":telefAsesorInt", $datos['telefAsesorInt']); 
        $this->db->bind(":movfAsesorInt", $datos['movfAsesorInt']); 
        $this->db->bind(":dirAsesorInt", $datos['dirAsesorInt']); 
        $this->db->bind(":locAsesorInt", $datos['locAsesorInt']); 
        $this->db->bind(":provAsesorInt", $datos['provAsesorInt']); 
        $this->db->bind(":codPosAsesorInt", $datos['codPosAsesorInt']); 
        $this->db->bind(":mailAsesorInt", $datos['mailAsesorInt']); 
        
        if ($this->db->execute()) {
        
            //actualizo los datos referentes a agente
      
            //vinculo empresa con agente
            
                //borro todas las filas según idEmpresa
                $this->db->query("DELETE FROM agentesclientes where idEmpresa = :id");
                $this->db->bind(":id", $datos['id']);
                $this->db->execute();  

                $this->db->query("INSERT INTO agentesclientes (idEmpresa,idAgente) VALUES (:idEmpresa,:idAgente)");
                $this->db->bind(':idEmpresa', $datos['id']);
                $this->db->bind(':idAgente', $datos['agente']);
                $this->db->execute();  
             
            
            //actualizo los datos referentes a colaborador
            
                //borro
                $this->db->query("DELETE FROM colaboradoresN where idEMPRESA = :id");
                $this->db->bind(":id", $datos['id']);
                $this->db->execute();
                //vinculo
                $this->db->query("INSERT INTO colaboradoresN (idEMPRESA,idColaborador) VALUES (:idEMPRESA,:idColaborador)");
                $this->db->bind(':idEMPRESA', $datos['id']);
                $this->db->bind(':idColaborador', $datos['colaborador']);
                $this->db->execute();                     
            
            //buscar contactos asociados al cliente y eliminarlos e insertar los nuevos
            //borro y agrego
            
            if ($datos == []) {
                
                $this->borrarContactos($datos['id']);
            }else{
                $this->borrarContactos($datos['id']);
                
                $this->agregarContactos($datos2,$datos['id']);
            }
            
            //actualizo los asesores externos
            if ($datos['asesorTipo'] == 'interno') {
                $this->db->query("DELETE FROM asesoresclientes where idEmpresa = :id");
                $this->db->bind(":id", $datos['id']);
                $this->db->execute();
            }else if ($datos['asesorTipo'] == 'externo' && $datos['selAsesorExt'] == 'existe') {
                //borro el asesor externo
                $this->db->query("DELETE FROM asesoresclientes where idEmpresa = :id");
                $this->db->bind(":id", $datos['id']);
                $this->db->execute();

                //inserto el asesor externo que viene
                $this->db->query("INSERT INTO asesoresclientes (idAsesor,idEmpresa) VALUES (:idAsesor,:idEmpresa)");
                $this->db->bind(':idEmpresa', $datos['id']);
                $this->db->bind(':idAsesor', $datos['selNomAsesorExt']);
                $this->db->execute();
            
            }else if ($datos['asesorTipo'] == 'externo' && $datos['selAsesorExt'] == 'nuevo') {
                
                //borro el asesor externo
                $this->db->query("DELETE FROM asesoresclientes where idEmpresa = :id");
                $this->db->bind(":id", $datos['id']);
                $this->db->execute();
                //creo el nuevo
                $this->db->query("INSERT INTO asesores (nomasesor,mail,telefonoFijo,movil,direccion,contacto,localidad,
                                provincia,codigopostal)
                                VALUES (:nomAsesorExt,:mailAsesorExt,:telefAsesorExt,:movfAsesorExt,:dirAsesorExt,
                                :contAsesorExt,:locAsesorExt,:provAsesorExt,:codPosAsesorExt)");

                //actuales            
                $this->db->bind(":nomAsesorExt", $datos['nomAsesorExt']);
                $this->db->bind(":contAsesorExt", $datos['contAsesorExt']); 
                $this->db->bind(":telefAsesorExt", $datos['telefAsesorExt']); 
                $this->db->bind(":movfAsesorExt", $datos['movfAsesorExt']); 
                $this->db->bind(":dirAsesorExt", $datos['dirAsesorExt']); 
                $this->db->bind(":locAsesorExt", $datos['locAsesorExt']); 
                $this->db->bind(":provAsesorExt", $datos['provAsesorExt']); 
                $this->db->bind(":codPosAsesorExt", $datos['codPosAsesorExt']); 
                $this->db->bind(":mailAsesorExt", $datos['mailAsesorExt']);             

                if ($this->db->execute()) {
                    $this->db->query("SELECT MAX(idAsesor) AS idAsesor FROM asesores");
                    $insAsesor = $this->db->registro();
                    $idInsertAse= $insAsesor->idAsesor;
                    //y cree el vínculo de la empresa con el asesor
                    $this->db->query("INSERT INTO asesoresclientes (idAsesor,idEmpresa) VALUES (:idAsesor,:idEmpresa)");
                    $this->db->bind(':idEmpresa', $datos['id']);
                    $this->db->bind(':idAsesor', $idInsertAse);
                    $this->db->execute();
                }
            }
            return true;
        }else{
            return false;
        }
    }



    // ELIMINAR
    public function borrarEmpresa($datos){
    
        $this->db->query("Delete from empresasclientes where idEMPRESA =".$datos['id']);
        
        //Ejecutar
        if($this->db->execute()){
            return true;
        } 
        else {
            echo "error";
            return false;
        }

    }

    public function obtenerColaboradorPorCliente($idCliente)
    {
        $this->db->query('SELECT col.RazonSocial FROM colaboradoresN con
                        LEFT JOIN colaboradores col ON con.idColaborador=col.codColaborador
                        WHERE idEMPRESA ='.$idCliente);
        $resultado = $this->db->registro();
        $colaborador = $resultado->RazonSocial;
        return $colaborador;
    }

    // SELECT PARA EL MODAL DE EDITAR
    public function getClientesUpdate($id)
    {
        $this->db->query('SELECT * FROM empresasclientes WHERE idEMPRESA ='.$id);  
        $resultado1 = $this->db->registro();

        $this->db->query('SELECT * FROM agentesclientes agcli
                        LEFT JOIN agentes ag ON agcli.idAgente=ag.codagente
                        WHERE idEmpresa='.$id);  
        $resultado2 = $this->db->registro();

        $this->db->query('SELECT * FROM colaboradoresN con
                        LEFT JOIN colaboradores col ON con.idColaborador=col.codColaborador
                        WHERE idEMPRESA ='.$id);  
        $resultado3 = $this->db->registro();

        $this->db->query('SELECT * FROM asesoresclientes ascli WHERE ascli.idEmpresa='.$id);  
        $resultado4 = $this->db->registro();
     
        $final = ['clientes' => $resultado1, 'agentes' => $resultado2,'colaboradores' => $resultado3,'asesores' => $resultado4 ];
        return $final;
    }
    

    public function getGrupos()
    {
        $like = "'"."%".$_GET['query']."%"."'" ;
        $this->db->query('SELECT * FROM grupos WHERE nombreG LIKE'. $like);        
        $resultado = $this->db->registros();        
        return $resultado;
    }    

    public function buscarContactosPorClientes($datos)
    {        
        $this->db->query('SELECT * FROM contactos
                        WHERE idEMPRESA= :idCliente	');        
        $this->db->bind(':idCliente', $datos['idCliente']);        
        $filas = $this->db->registros();
        return $filas;
    }
    
    public function obtenerOportunidades(){

       
        $table = "(
            SELECT cli.idEMPRESA, cli.codEmpresa, cli.CIFCLIENTE, gru.nombreG, cli.NOMBREJURIDICO, 
            con.idColaborador, col.NombreComercial AS colaborador, col.RazonSocial, cli.CODSECTOR, 
            sec.SECTOR as sector, cli.fechaOportunidad, cli.estadooportunidad
            FROM empresasclientes cli
            LEFT JOIN grupos gru on gru.idGrupo = cli.idGrupo
            LEFT JOIN colaboradoresN con ON cli.idEMPRESA=con.idEMPRESA
            LEFT JOIN colaboradores col ON con.idColaborador=col.codColaborador
            LEFT JOIN sectores sec ON cli.CODSECTOR=sec.CODSECTOR
            WHERE cli.oportunidad = 'oportunidad'
            ) temp";

            // $table = "empresasclientes";

            //  echo $table;
        // Table's primary key
        $primaryKey = 'idEMPRESA';

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes
        $columns = array(
            array( 'db' => 'idEMPRESA', 'dt' => 'DT_RowId' ),
            array( 'db' => 'codEmpresa',  'dt' => 0 ),
            array( 'db' => 'NOMBREJURIDICO',  'dt' => 1 ),
            array( 'db' => 'colaborador',  'dt' => 2 ), 
            array( 'db' => 'sector',  'dt' => 3 ),
            array( 'db' => 'fechaOportunidad',  'dt' => 4 ),
            array( 'db' => 'estadooportunidad',  'dt' => 5 ), 
           
           
                 
        
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


    // AÑADIR OPORTUNIDAD
    public function agregarOportunidad($datos){
        

        //buscando el último
        $this->db->query("SELECT MAX(codEmpresa) AS codEmpresa FROM empresasclientes");
        $ultimoCod = $this->db->registro();
        $nuevoCod = $ultimoCod->codEmpresa + 1;        

        //inserto los datos en la tabla empresasclientes
        $this->db->query("INSERT INTO empresasclientes (codEmpresa,NOMBREJURIDICO,CODSECTOR,CONTACTO,DIRECCION,LOCALIDAD,PROVINCIA,CODPOSTAL,TELEFONOFIJO1,
                        TELEFONOMOVIL,EMAIL,numtrabajadores,oportunidad,estadooportunidad,fechaOportunidad)
                        VALUES (:codEmpresa,:nombreComercial,:sector,:contactoPrincipal,:direccion,:poblacion,:provincia,:codigoPostal,
                        :telefonofijo1,:movil,:email,:trabajadores,:oportunidad,:estadooportunidad,:fechaOportunidad)");
    
        //-------------
        $this->db->bind(':codEmpresa', $nuevoCod);
        $this->db->bind(':nombreComercial', $datos['nombreComercial']);
        $this->db->bind(':sector', $datos['sector']);
        $this->db->bind(':contactoPrincipal', $datos['contactoPrincipal']);        
        $this->db->bind(':direccion', $datos['direccion']);
        $this->db->bind(':poblacion', $datos['poblacion']);
        $this->db->bind(':provincia', $datos['provincia']);
        $this->db->bind(':codigoPostal', $datos['codigoPostal']);
        $this->db->bind(':telefonofijo1', $datos['telefonofijo1']);
        $this->db->bind(':movil', $datos['movil']);
        $this->db->bind(':email', $datos['email']);
        $this->db->bind(':trabajadores', $datos['trabajadores']);
        $this->db->bind(':estadooportunidad', $datos['estadoOp']);
        $this->db->bind(':oportunidad', 'oportunidad');
        $this->db->bind(':fechaOportunidad', $datos['fecha']);
        
        if($this->db->execute()){
            
            //debería capturar el primarykey insertado, corregir esto
            $this->db->query("SELECT MAX(idEMPRESA) AS idEMPRESA FROM empresasclientes");
            $inserto = $this->db->registro();
            $insertado= $inserto->idEMPRESA;          
            
            //vinculo empresa con colaborador            
            $this->db->query("INSERT INTO colaboradoresN (idEMPRESA,idColaborador) VALUES (:idEMPRESA,:idColaborador)");
            $this->db->bind(':idEMPRESA', $insertado);
            $this->db->bind(':idColaborador', $datos['colaborador']);
            $this->db->execute();
                    
            return true;
        }else{
            return false;
        }
        
    }

    //TRAE DATOS AL MODAL EDITAR
    public function getOportunidadesUpdate($id)
    {
        $this->db->query('SELECT cli.*, con.codColaborador, con.idColaborador FROM empresasclientes cli
                        LEFT JOIN colaboradoresN con ON cli.idEMPRESA = con.idEMPRESA
                        LEFT JOIN colaboradores col ON con.idColaborador=col.codColaborador
                        WHERE cli.idEMPRESA='.$id);  
        $resultado1 = $this->db->registros();
 
        $final = ['clientes' => $resultado1];
        return $final;
    }

    public function editarOportunidad($datos){
        
        
        $this->db->query("UPDATE empresasclientes SET  NOMBREJURIDICO = :NOMBREJURIDICO,
                        CODSECTOR = :CODSECTOR, numtrabajadores = :numtrabajadores, 
                        DIRECCION = :DIRECCION, LOCALIDAD = :LOCALIDAD, PROVINCIA= :PROVINCIA, CODPOSTAL = :CODPOSTAL, 
                        TELEFONOFIJO1 = :TELEFONOFIJO1, TELEFONOMOVIL = :TELEFONOMOVIL, EMAIL = :EMAIL, CONTACTO = :contactoPrincipal,
                        estadooportunidad = :estadoOp
                        WHERE idEMPRESA = :id");

        // vincular valores
        $this->db->bind(':id', $datos['id']);    
        $this->db->bind(':NOMBREJURIDICO', $datos['nombre']);
        $this->db->bind(':DIRECCION', $datos['direccion']);
        $this->db->bind(':LOCALIDAD', $datos['poblacion']);
        $this->db->bind(':PROVINCIA', $datos['provincia']);
        $this->db->bind(':CODPOSTAL', $datos['codigoPostal']);
        $this->db->bind(':TELEFONOFIJO1', $datos['telefonofijo1']);
        $this->db->bind(':TELEFONOMOVIL', $datos['movil']);
        $this->db->bind(':EMAIL', $datos['email']);
        $this->db->bind(':CODSECTOR', $datos['sector']);      
        $this->db->bind(':numtrabajadores', $datos['trabajadores']);
        $this->db->bind(':contactoPrincipal', $datos['contactoPrincipal']);
        $this->db->bind(':estadoOp', $datos['estadoOp']);
        //$this->db->bind(':fecha', $datos['fecha']); 
       
        //Ejecutar
        if($this->db->execute()){
            //que actualice el colaborador también
            $this->db->query("UPDATE colaboradoresN 
                            SET idColaborador = :idColaborador
                            WHERE idEMPRESA = :id");

            $this->db->bind(':id', $datos['id']);    
            $this->db->bind(':idColaborador', $datos['colaborador']);
            $this->db->execute();

            //convertir en cliente ó colaborador:
            if ($datos['convertir']!='' && $datos['convertir']==1) {
                if ($datos['estadoOp']=='empresaPot') {
                    $this->convertirOportunidadACliente($datos);
                }else if ($datos['estadoOp']=='colPotencial') {
                    $this->convertirOportunidadAColaborador($datos);
                }                
            }
            return true;
        } else {
            return false;
        }

    }

    public function convertirOportunidadACliente($datos)
    {
        
        $this->db->query("UPDATE empresasclientes
                        SET oportunidad = :oportunidad
                        WHERE idEMPRESA = :id");
        
        $this->db->bind(':oportunidad', 'cliente');
        $this->db->bind(':id', $datos['id']);
        $this->db->execute();
        
    }

    public function convertirOportunidadAColaborador($datos)
    {       
        
        $this->db->query("INSERT INTO colaboradores (NombreComercial, Direccion, Localidad, provincia, codigopostal, Contactocolaborador, telefonocolaborador, movilcolaborador, emailcolaborador)
                        VALUES (:NombreComercial, :Direccion, :Localidad, :provincia, :codigopostal, :Contactocolaborador, :telefonocolaborador, :movilcolaborador, :emailcolaborador )");

        $this->db->bind(':NombreComercial', $datos['nombre']);
        $this->db->bind(':Direccion', $datos['direccion']);
        $this->db->bind(':Localidad', $datos['poblacion']);
        $this->db->bind(':provincia', $datos['provincia']);
        $this->db->bind(':codigopostal', $datos['codigoPostal']);
        $this->db->bind(':Contactocolaborador', $datos['contactoPrincipal']);
        $this->db->bind(':telefonocolaborador', $datos['telefonofijo1']);
        $this->db->bind(':movilcolaborador', $datos['movil']);
        $this->db->bind(':emailcolaborador', $datos['email']);

        if ($this->db->execute()) {

            $this->db->query("UPDATE empresasclientes
            SET oportunidad = :oportunidad
            WHERE idEMPRESA = :id");

            $this->db->bind(':oportunidad', 'colaborador');
            $this->db->bind(':id', $datos['id']);
            $this->db->execute();

        }
        
    }

    public function borrarOportunidad($datos){
    
        $this->db->query("Delete from empresasclientes where idEMPRESA =".$datos['id']);
        
        //Ejecutar
        if($this->db->execute()){
            $this->db->query("Delete from colaboradoresN where idEMPRESA =".$datos['id']);
            return true;
        } 
        else {
            echo "error";
            return false;
        }
    
    }


    public function auxiliarAgenteCliente() //función para vincular un agente a varios clientes
    {

        $arra1 = ["2324","2325","2327","2333","2337","2344","2345","2348","2365","2380","2381","2395","2405","2421","2422","2423","2424","2442","2443","2444","2445","2446","2447","2458","2461","2469","2470","2475","2476","2483","2485","2492","2496","2497","2502","2504","2526","2564","2569","2574","2593","2597","2623","2643","2650","2670","2688","2803","2835","2836","2838","2839","2882","2901","2914","2925","2977","3016","3095","3161","3241","3330","3636","3637","3638","3701","3723","3762","3779","3907","3908","3925","3928","3939","4002","4038","4040","4092","4163","4201","4241","4251","4287","4288","4289","4294","4303","4314","4365","4395","4396","4421","4439","4442","4443","4444","4445","4446","4480","4483","4484","4485","4486","4487","4488","4491","4492","4493","4509","4510","4525","4526","4527","4528","4529","4579","4584","4586","4626","4631","4639","4660","4692","4703","4704","4705","4736","4737","4747","4802","4807","4811","4837","4851","4869","4904","4935","5000","5001","5006","5045","5052","5060","5131","5168","5176","5193","5199","5210","5219","5259","5260","5261","5307","5349","5351","5377","5411","5419","5441","5464","5487","5500","5502","5503","5504","5505","5506","5523","5524","5525","5526","5579","5583","5585","5601","5602","5603","5604","5605","5606","5607","5608","5609","5614","5626","5641","5644","5661","5666","5667","5668","5669","5670","5671","5672","5674","5675","5676","5677","5683","5693","5694","5695","5696","5697","5698","5721","5736","5744","5770","5771","5830","5879","5891","5892","5899","5932","5943","5950","5952","5953","5955","5957","5961","5962","5963","5966","5973","6032","6124","6155","6158","6172","6178","6194","6195","6196","6198","6201","6206","6208","6211","6212","6220","6232"];
        $arra2 = ["2316","2317","2318","2319","2320","2321","2328","2329","2330","2331","2332","2570","2579","2606","2615","2625","2637","2638","2639","2640","2641","2642","2644","2659","2660","2661","2662","2663","2664","2665","2689","2693","2726","2727","2728","2730","2731","2732","2733","2734","2735","2736","2737","2738","2739","2740","2741","2742","2743","2744","2745","2746","2747","2748","2749","2750","2751","2752","2753","2754","2755","2758","2759","2764","2765","2766","2795","2800","2801","2816","2825","2829","2830","2831","2832","2833","2834","2840","2841","2842","2843","2844","2845","2846","2848","2850","2851","2856","2859","2864","2865","2866","2868","2869","2870","2871","2878","2879","2881","2900","2920","2921","2922","2923","2932","2934","2958","2959","2963","2964","2966","2971","2978","2979","2980","2981","2982","2984","2990","2991","2995","2997","2998","2999","3001","3004","3012","3025","3038","3039","3040","3044","3045","3048","3063","3065","3068","3076","3077","3078","3082","3083","3088","3089","3093","3101","3103","3104","3105","3107","3108","3109","3110","3127","3131","3132","3133","3134","3135","3136","3137","3153","3156","3160","3162","3167","3168","3176","3177","3178","3179","3180","3181","3182","3183","3185","3186","3192","3194","3195","3196","3197","3198","3199","3200","3202","3207","3220","3224","3246","3247","3264","3278","3279","3316","3341","3342","3343","3344","3345","3346","3347","3348","3351","3352","3353","3354","3359","3360","3361","3362","3363","3364","3365","3366","3367","3368","3369","3370","3371","3372","3373","3380","3381","3385","3392","3393","3398","3408","3409","3410","3411","3412","3413","3414","3415","3416","3417","3418","3419","3420","3421","3422","3423","3424","3425","3431","3432","3433","3434","3437","3441","3442","3443","3444","3453","3454","3460","3461","3464","3465","3466","3467","3468","3469","3470","3471","3472","3473","3475","3476","3477","3478","3479","3480","3481","3485","3486","3487","3488","3489","3490","3493","3494","3495","3496","3526","3527","3531","3540","3541","3542","3543","3562","3564","3565","3566","3567","3568","3570","3571","3579","3580","3581","3587","3588","3589","3590","3600","3601","3602","3605","3609","3610","3612","3616","3617","3618","3619","3620","3623","3624","3629","3631","3632","3633","3634","3639","3641","3643","3649","3657","3659","3660","3679","3688","3697","3698","3705","3711","3712","3736","3737","3738","3739","3740","3741","3742","3743","3747","3748","3757","3758","3759","3760","3761","3764","3769","3771","3772","3773","3774","3775","3776","3777","3778","3780","3781","3784","3785","3786","3790","3793","3794","3795","3796","3797","3798","3799","3801","3802","3803","3806","3812","3813","3815","3816","3817","3818","3820","3822","3823","3824","3825","3826","3827","3828","3829","3830","3831","3832","3833","3834","3835","3836","3837","3838","3840","3841","3842","3843","3844","3845","3846","3847","3848","3849","3850","3852","3853","3854","3855","3856","3857","3858","3859","3860","3861","3862","3863","3864","3865","3866","3867","3868","3869","3870","3871","3872","3873","3874","3875","3876","3877","3878","3879","3880","3882","3883","3884","3885","3886","3888","3889","3890","3891","3892","3893","3894","3895","3896","3897","3898","3899","3900","3902","3903","3904","3905","3906","3910","3911","3912","3913","3915","3916","3917","3918","3919","3920","3921","3922","3923","3926","3927","3929","3930","3932","3933","3934","3935","3937","3940","3941","3942","3943","3946","3947","3948","3951","3952","3953","3954","3955","3956","3957","3958","3960","3961","3962","3963","3964","3965","3966","3968","3969","3970","3971","3972","3973","3975","3976","3978","3979","3980","3981","3982","3983","3985","3987","3988","3989","3990","3991","3992","3993","3994","3995","3997","3998","3999","4000","4001","4003","4008","4009","4010","4011","4012","4013","4016","4017","4019","4020","4021","4022","4023","4024","4025","4026","4027","4032","4033","4034","4037","4041","4042","4046","4047","4048","4049","4050","4051","4052","4053","4054","4055","4056","4057","4058","4059","4060","4061","4064","4067","4069","4070","4071","4100","4109","4110","4112","4113","4114","4115","4116","4117","4118","4119","4120","4121","4123","4126","4127","4128","4129","4130","4131","4132","4133","4134","4136","4137","4139","4140","4141","4142","4143","4144","4145","4146","4147","4148","4149","4151","4153","4154","4157","4161","4162","4164","4165","4166","4167","4168","4169","4170","4172","4176","4178","4181","4182","4183","4185","4186","4187","4188","4189","4190","4191","4192","4193","4194","4195","4196","4197","4198","4199","4202","4203","4204","4205","4206","4207","4208","4209","4217","4218","4219","4220","4221","4222","4223","4224","4225","4226","4227","4228","4230","4231","4232","4233","4234","4235","4236","4239","4240","4245","4248","4250","4252","4253","4254","4255","4258","4259","4260","4263","4264","4265","4270","4271","4274","4277","4279","4280","4281","4282","4285","4298","4299","4305","4307","4308","4310","4311","4312","4313","4315","4316","4326","4330","4331","4333","4337","4339","4349","4355","4356","4367","4368","4369","4370","4372","4373","4374","4375","4378","4380","4381","4383","4385","4386","4387","4388","4389","4391","4392","4393","4398","4399","4400","4401","4402","4403","4404","4405","4407","4408","4415","4417","4418","4424","4425","4426","4430","4432","4433","4434","4437","4438","4440","4448","4449","4450","4455","4458","4461","4462","4474","4475","4481","4482","4489","4490","4496","4497","4498","4501","4502","4503","4504","4506","4507","4508","4512","4513","4514","4515","4516","4517","4518","4519","4522","4524","4533","4535","4536","4537","4538","4540","4541","4542","4543","4544","4547","4548","4549","4554","4556","4558","4559","4560","4561","4562","4563","4564","4565","4566","4567","4568","4569","4570","4571","4574","4575","4576","4578","4580","4581","4583","4587","4588","4589","4591","4593","4595","4596","4597","4598","4599","4600","4602","4603","4605","4607","4608","4611","4613","4615","4616","4617","4618","4619","4620","4621","4628","4630","4632","4633","4634","4635","4637","4638","4640","4645","4646","4648","4650","4651","4652","4654","4655","4656","4657","4659","4665","4668","4669","4671","4672","4673","4676","4681","4682","4683","4684","4685","4686","4687","4689","4690","4691","4693","4694","4695","4696","4697","4699","4700","4708","4711","4713","4714","4715","4716","4717","4719","4723","4724","4725","4726","4727","4728","4729","4730","4731","4732","4733","4735","4738","4739","4740","4741","4745","4748","4750","4751","4752","4755","4756","4758","4761","4762","4763","4764","4765","4766","4767","4768","4769","4772","4773","4774","4775","4776","4777","4779","4780","4781","4782","4783","4784","4785","4789","4790","4792","4795","4796","4800","4801","4803","4804","4813","4814","4816","4817","4818","4821","4824","4825","4827","4829","4830","4836","4838","4840","4842","4843","4844","4846","4847","4848","4849","4850","4852","4853","4854","4855","4856","4857","4860","4861","4866","4867","4868","4870","4874","4875","4878","4882","4886","4887","4888","4889","4890","4891","4896","4897","4899","4911","4912","4913","4914","4915","4917","4919","4929","4930","4931","4932","4933","4934","4940","4944","4945","4947","4950","4952","4961","4962","4963","4978","4980","4985","4987","4995","4996","4997","4998","4999","5008","5021","5022","5023","5024","5025","5026","5027","5028","5029","5030","5031","5034","5035","5036","5037","5038","5039","5040","5041","5042","5043","5046","5047","5048","5049","5053","5054","5057","5064","5065","5066","5067","5068","5070","5071","5072","5073","5074","5077","5078","5079","5080","5081","5082","5085","5086","5087","5088","5089","5092","5093","5096","5097","5098","5099","5100","5101","5102","5103","5104","5106","5107","5108","5110","5111","5112","5116","5117","5118","5119","5120","5122","5126","5127","5128","5129","5130","5137","5138","5140","5155","5158","5159","5161","5163","5164","5165","5166","5167","5170","5171","5172","5173","5174","5175","5177","5178","5181","5182","5183","5184","5185","5186","5187","5188","5189","5190","5191","5194","5195","5196","5197","5201","5203","5204","5205","5206","5207","5208","5209","5211","5212","5213","5214","5216","5217","5218","5220","5223","5224","5226","5227","5228","5229","5230","5231","5232","5233","5235","5236","5237","5238","5239","5240","5241","5242","5243","5244","5247","5248","5249","5250","5251","5252","5253","5254","5255","5256","5257","5258","5263","5264","5265","5266","5267","5268","5269","5270","5271","5272","5273","5274","5275","5276","5277","5278","5279","5280","5281","5282","5284","5285","5286","5288","5291","5292","5293","5296","5297","5298","5299","5300","5301","5302","5303","5304","5305","5306","5308","5309","5310","5311","5312","5313","5314","5315","5316","5318","5321","5322","5323","5324","5325","5326","5327","5328","5329","5330","5331","5332","5333","5334","5335","5336","5337","5338","5339","5340","5341","5342","5343","5344","5345","5346","5347","5348","5350","5353","5354","5355","5358","5359","5360","5361","5362","5366","5367","5368","5369","5370","5371","5372","5373","5374","5375","5376","5378","5379","5380","5381","5382","5383","5384","5386","5387","5388","5389","5390","5391","5393","5394","5395","5396","5399","5400","5401","5402","5403","5413","5414","5415","5416","5417","5418","5420","5421","5422","5423","5425","5426","5427","5428","5429","5430","5432","5433","5434","5436","5437","5438","5439","5440","5442","5443","5444","5445","5447","5448","5449","5450","5451","5457","5458","5459","5461","5463","5465","5466","5467","5468","5469","5470","5471","5472","5473","5474","5475","5476","5477","5478","5479","5480","5482","5483","5484","5485","5486","5489","5490","5491","5492","5493","5494","5495","5496","5497","5498","5499","5508","5509","5510","5511","5512","5513","5514","5516","5517","5518","5519","5520","5521","5522","5528","5529","5530","5531","5532","5533","5534","5535","5536","5537","5538","5539","5541","5542","5543","5544","5545","5546","5547","5548","5549","5550","5551","5552","5553","5554","5557","5558","5560","5561","5564","5565","5566","5567","5568","5570","5571","5572","5575","5581","5582","5586","5587","5588","5589","5590","5591","5592","5593","5594","5595","5597","5598","5599","5600","5610","5611","5612","5613","5616","5617","5618","5619","5620","5621","5622","5623","5624","5625","5627","5629","5630","5631","5632","5635","5636","5637","5638","5639","5643","5645","5646","5647","5648","5651","5652","5653","5654","5656","5657","5658","5659","5660","5663","5664","5665","5678","5679","5680","5681","5684","5685","5686","5687","5688","5689","5690","5691","5699","5700","5701","5713","5714","5715","5716","5717","5718","5719","5720","5731","5733","5739","5741","5742","5743","5745","5747","5748","5749","5750","5751","5753","5754","5756","5757","5758","5759","5760","5762","5763","5764","5765","5766","5767","5769","5772","5773","5774","5776","5777","5778","5780","5781","5782","5783","5784","5785","5786","5787","5791","5792","5794","5795","5796","5797","5798","5800","5801","5802","5803","5805","5806","5807","5808","5809","5810","5811","5812","5814","5816","5817","5819","5820","5821","5823","5824","5827","5828","5829","5831","5832","5833","5834","5835","5836","5837","5838","5839","5840","5841","5842","5844","5845","5846","5847","5850","5851","5853","5854","5858","5861","5862","5864","5865","5866","5867","5868","5869","5870","5871","5872","5873","5874","5875","5878","5880","5881","5882","5884","5885","5886","5887","5888","5889","5890","5896","5897","5898","5900","5901","5902","5903","5904","5905","5906","5907","5909","5910","5911","5912","5913","5914","5915","5917","5918","5919","5920","5921","5922","5923","5924","5925","5926","5927","5928","5929","5930","5931","5933","5934","5935","5936","5937","5938","5939","5940","5941","5942","5944","5945","5946","5947","5948","5949","5951","5954","5956","5958","5959","5960","5964","5965","5967","5968","5970","5972","5974","5975","5976","5977","5978","5979","5980","5982","5983","5984","5986","5987","5988","5989","5990","5991","5992","5993","5994","5995","5996","5997","5998","5999","6000","6002","6003","6005","6007","6008","6009","6010","6011","6012","6013","6014","6015","6016","6017","6018","6019","6020","6021","6022","6023","6024","6025","6026","6027","6028","6029","6030","6031","6033","6034","6035","6036","6037","6038","6039","6041","6042","6044","6045","6046","6048","6049","6050","6051","6053","6054","6055","6056","6057","6058","6059","6060","6061","6062","6063","6064","6065","6066","6067","6068","6069","6070","6071","6072","6073","6074","6075","6077","6078","6079","6080","6081","6082","6083","6084","6085","6086","6087","6088","6090","6091","6092","6095","6097","6098","6099","6101","6109","6110","6111","6112","6113","6114","6116","6117","6118","6119","6120","6121","6122","6123","6125","6127","6128","6130","6131","6132","6133","6137","6141","6142","6143","6144","6145","6147","6148","6150","6153","6156","6157","6160","6161","6162","6163","6164","6166","6167","6170","6173","6174","6175","6176","6177","6181","6182","6183","6186","6187","6188","6189","6190","6191","6192","6197","6202","6204","6205","6207","6209","6213","6214","6216","6217","6218","6219","6221","6222","6223","6224","6225","6226","6227","6228","6229","6230","6234","6235","6236","6237","6238","6239","6240","6241","6242","6246","6248"];


        $idAgente = '20';

        foreach ($arra2 as $key) {
            
            $this->db->query("INSERT INTO agentesclientes (idEmpresa,idAgente)
            VALUES (:idEmpresa,:idAgente)");
               
            $this->db->bind(':idEmpresa', $key);
            $this->db->bind(':idAgente', $idAgente);
            $this->db->execute();
        }
        
    }
       

}


