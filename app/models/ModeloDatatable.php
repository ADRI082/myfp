<?php


class ModeloDatatable{

    private $db;

    public function __construct(){
        $this->db = new Base;
    }

    //MÉTODOS PARA DATATABLE AGENTES Y CRUD
    public function obtenerAgentes(){        
        $this->db->query('SELECT * FROM agentes 
                        LEFT JOIN roles on roles.idRol = agentes.idRol 
                        LEFT JOIN puestos on agentes.puesto = puestos.idpuesto
                        LEFT JOIN areafuncional ar ON agentes.departamento=ar.codfuncional');
        $resultado = $this->db->registros();
        return $resultado;
    }

    public function obtenerPuestos()
    {
        $this->db->query('SELECT * FROM puestos');
        $resultado = $this->db->registros();
        return $resultado;
    }

    public function obtenerDepartamentos()
    {
        $this->db->query('SELECT * FROM areafuncional');
        $resultado = $this->db->registros();
        return $resultado;
    }    


    public function agregarAgente($datos)
    {
       
        $this->db->query('INSERT INTO agentes (DNIAgente,Nombre,Apellidos,numcuenta,Direccion,Localidad,provincia,codigopostal,
                                    telefono,movil,puesto,idRol,password,mail,observaciones,regimen,fechaInicio,fechaFin) 
                        VALUES (:dniAgente,:nombre,:apellidos,:numcuenta,:direccion,:localidad,:provincia,:codigopostal,
                                :telefono,:movil,:puesto,:idRol,:password,:email,:observaciones,:regimen,:fechaInicio,:fechaFin)');

    // vincular valores
        $this->db->bind(':dniAgente', $datos['DNIAgente']);
        $this->db->bind(':nombre', $datos['Nombre']);
        $this->db->bind(':apellidos', $datos['Apellidos']);
        $this->db->bind(':numcuenta', $datos['numcuenta']);
        $this->db->bind(':direccion', $datos['Direccion']);
        $this->db->bind(':localidad', $datos['Localidad']);
        $this->db->bind(':provincia', $datos['provincia']);
        $this->db->bind(':codigopostal', $datos['codigopostal']);
        $this->db->bind(':telefono', $datos['telefono']);
        $this->db->bind(':movil', $datos['movil']);
        $this->db->bind(':puesto', $datos['puesto']);       
        $this->db->bind(':idRol', $datos['idRol']);
        $this->db->bind(':password', $datos['password']);
        $this->db->bind(':email', $datos['email']);
        $this->db->bind(':observaciones', $datos['observaciones']);
        $this->db->bind(':regimen', $datos['regimen']);
        $this->db->bind(':fechaInicio', $datos['fechaInicio']);
        $this->db->bind(':fechaFin', $datos['fechaFin']);

        //Ejecutar
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }

    }

    public function borrarAgente($datos)
    {
        $this->db->query("DELETE FROM agentes WHERE codagente =".$datos['id']);
        
        //Ejecutar
        if($this->db->execute()){
            $this->db->query("DELETE FROM agentesclientes WHERE idAgente =".$datos['id']);
            $this->db->execute();
            return true;
        } 
        else {
            echo "error";
            return false;
        }
    }

    public function getAgenteUpdate($id)
    {
        $this->db->query('SELECT * FROM agentes ag
                        LEFT JOIN roles AS ro ON ag.idRol=ro.idRol
                        LEFT JOIN areafuncional AS ar ON ag.departamento=ar.codfuncional
                        WHERE codagente ='.$id);
        $resultado = $this->db->registros();
        $this->db->query('SELECT em.idEMPRESA, em.NOMBREJURIDICO FROM agentesclientes ag
                        LEFT JOIN empresasclientes em ON ag.idEmpresa=em.idEMPRESA
                        WHERE idAgente='.$id);
        $resultado2 = $this->db->registros();
        $final = ['agente' => $resultado, 'clientes' => $resultado2];
        return array_merge($final);
    }    

    public function actualizarAgente($datos)
    {
        //falta colocar la actualiza de la tabla agentes clientes y que los datos vengas de la vista
        $this->db->query("UPDATE  agentes 
                        SET DNIAgente = :DNIAgente, Nombre = :Nombre, Apellidos = :Apellidos, numcuenta = :numcuenta, Direccion = :Direccion, 
                        Localidad = :Localidad, provincia = :provincia, codigopostal = :codigopostal, telefono = :telefono, movil = :movil, puesto = :puesto, 
                        departamento = :departamento, idRol = :idRol, mail = :mail, password = :password, observaciones = :observaciones,
                        regimen =:regimen, fechaInicio =:fechaInicio, fechaFin=:fechaFin
                        WHERE codagente = :codagente");
    
        // vincular valores
        $this->db->bind(':codagente', $datos['codagente']);
        $this->db->bind(':DNIAgente', $datos['DNIAgente']);
        $this->db->bind(':Nombre', $datos['Nombre']);
        $this->db->bind(':Apellidos', $datos['Apellidos']);
        $this->db->bind(':numcuenta', $datos['numcuenta']);
        $this->db->bind(':Direccion', $datos['Direccion']);
        $this->db->bind(':Localidad', $datos['Localidad']);
        $this->db->bind(':provincia', $datos['provincia']);
        $this->db->bind(':codigopostal', $datos['codigopostal']);
        $this->db->bind(':telefono', $datos['telefono']);
        $this->db->bind(':movil', $datos['movil']);
        $this->db->bind(':puesto', $datos['puesto']);
        $this->db->bind(':departamento', $datos['departamento']);
        $this->db->bind(':idRol', $datos['idRol']);
        $this->db->bind(':password', $datos['password']);
        $this->db->bind(':mail', $datos['mail']);
        $this->db->bind(':observaciones', $datos['observaciones']);
        $this->db->bind(':regimen', $datos['regimen']);
        $this->db->bind(':fechaInicio', $datos['fechaInicio']);
        $this->db->bind(':fechaFin', $datos['fechaFin']);
       
        //Ejecutar
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }    
    }    
    

    //obtener roles
    public function obtenerRoles(){        
        $this->db->query('SELECT * FROM roles');
        $resultado = $this->db->registros();
        return $resultado;
    }

    public function obtenerAcciones(){
        $this->db->query('select tip.DESTIPOFORMACION as tipo , area.DESAREA as area ,moda.DESMODALIDAD as modalidad ,acc.NOMBREACCION as nombre ,
        acc.DESCRIBEACCION as descripcion, servicio.nombreS as servicio, acc.APRECIOPRESENCIALES as presencial, acc.APRECIOTELEFORMACION as teleformacion,
        acc.objetivoPrevisto as objetivoP, acc.LINKCONTENIDO as contenido, acc.ContenidoPrevisto as contenidoP, acc.MetodologiaPrevista as metodologiaP
        from accionesformativas acc 
        LEFT JOIN  tipodeaccion tip on acc.CODTIPO = CODTIPOFORMACION
        LEFT JOIN areadeformacion area on acc.CODAREA = area.CODAREA
        LEFT JOIN servicio on servicio.idServicio = acc.idServicio
        LEFT JOIN modalidadesdeacciones moda on acc.CODMODALIDAD = moda.CODMODALIDAD');

        $resultado = $this->db->registros();

        return $resultado;
    }

    public function obtenerTipos(){
        $this->db->query('select CODTIPOFORMACION as codigo ,DESTIPOFORMACION as descripcion ,OBSTIPOFORMACION as objetivo from tipodeaccion');

        $resultado = $this->db->registros();

        return $resultado;
    }

    public function obtenerAreas(){
        $this->db->query('select CODAREA as codigo ,DESAREA as descripcion , OBSAREA as observaciones from areadeformacion');

        $resultado = $this->db->registros();

        return $resultado;
    }

    public function obtenerModalidades(){
        $this->db->query('select CODMODALIDAD as codigo , DESMODALIDAD as descripcion , OBSMODALIDAD as observaciones, ACTIVO from modalidadesdeacciones');

        $resultado = $this->db->registros();

        return $resultado;
    }

    //MÉTODOS PARA DATATABLE COLABORADORES Y CRUD
    public function obtenerColaboradores2(){ //he reemplezado este método por obtenerColaboradores()
        $this->db->query('SELECT con.codColaborador AS codColaborador, con.idColaborador AS idColaborador, col.margencomercial, col.observaciones, col.NombreComercial, col.RazonSocial, col.TipoColaborador, con.idEMPRESA AS idEmpresa, cli.NOMBREJURIDICO AS NOMBREJURIDICO
                        FROM colaboradoresN con 
                        LEFT JOIN colaboradores col ON col.codColaborador=con.idColaborador
                        LEFT JOIN empresasclientes cli ON con.idEMPRESA=cli.idEMPRESA
                        WHERE con.idColaborador  IS NOT NULL'); //ojo quitar cuando estén todos los colaboradores asociados

        $resultado = $this->db->registros();

        return $resultado;
    }

    public function obtenerColaboradores(){
        $this->db->query('SELECT * FROM colaboradores');

        $resultado = $this->db->registros();

        return $resultado;
    }


    public function obtenerColaboradoresSelect(){
        $this->db->query('SELECT * FROM colaboradores');
        $resultado = $this->db->registros();
        return $resultado;
    }
    /*
    public function getAgentesSelect()
    {
        $this->db->query('SELECT * FROM agentes');  
        $resultado = $this->db->registros();     
        $array = ['agentes', $resultado];
        return $array;
    }

    public function getProfesoresSelect()
    {
        $this->db->query('SELECT * FROM profesores');  
        $resultado = $this->db->registros();
        $array = ['profesores', $resultado];       
        return $array;
    }

    public function getAsesoresSelect()
    {
        $this->db->query('SELECT DISTINCT nomasesor, idAsesor FROM asesores WHERE nomasesor IS NOT NULL');  
        $resultado = $this->db->registros();
        $array = ['asesores', $resultado];     
        return $array;
    }

    public function getProveedoresSelect()
    {
        $this->db->query('SELECT * FROM proveedores');
        $resultado = $this->db->registros();
        $array = ['proveedores', $resultado];     
        return $array;
    }
    
    public function getClientesSelect()
    {
        $this->db->query('SELECT idEMPRESA, NOMBREJURIDICO FROM empresasclientes');
        $resultado = $this->db->registros();
        $array = ['clientes', $resultado];     
        return $array;
    }*/

    public function agregarColaborador($datos)
    {

        $dato = $datos['codTipoCol'];
        if ($dato == 0) {
            $tipoColaborador = 'Agente Informa';
        }else if ($dato == 1) {
            $tipoColaborador = 'Profesor';
        }else if ($dato == 2) {
            $tipoColaborador = 'Asesoría';
        }else if ($dato == 3) {
            $tipoColaborador = 'Proveeedor';
        }else if ($dato == 4) {
            $tipoColaborador = 'Cliente';
        }else if ($dato == 5) {
            $tipoColaborador = 'Centro de Formación';
        }else if ($dato == 6) {
            $tipoColaborador = 'Consultora';
        }


        $this->db->query('INSERT INTO colaboradores (codTipoCol, NifColaborador, TipoColaborador, margencomercial, NombreComercial, RazonSocial, Direccion, codigopostal, Localidad, provincia, numcuenta, Contactocolaborador, telefonocolaborador, movilcolaborador, emailcolaborador, webcolaborador, observaciones) 
                        VALUES (:codTipoCol, :NifColaborador, :TipoColaborador, :margencomercial, :NombreComercial, :RazonSocial, :Direccion, :codigopostal, :Localidad, :provincia, :numcuenta, :Contactocolaborador, :telefonocolaborador, :movilcolaborador, :emailcolaborador, :webcolaborador, :observaciones)');
        
        // vincular valores
        $this->db->bind(':codTipoCol', $datos['codTipoCol']);
        $this->db->bind(':NifColaborador', $datos['NifColaborador']);
        $this->db->bind(':TipoColaborador', $tipoColaborador);
        $this->db->bind(':margencomercial', $datos['margencomercial']);
        $this->db->bind(':NombreComercial', $datos['NombreComercial']);
        $this->db->bind(':RazonSocial', $datos['RazonSocial']);
        $this->db->bind(':Direccion', $datos['Direccion']);
        $this->db->bind(':codigopostal', $datos['codigopostal']);
        $this->db->bind(':Localidad', $datos['Localidad']);
        $this->db->bind(':provincia', $datos['provincia']);
        $this->db->bind(':numcuenta', $datos['numcuenta']);
        $this->db->bind(':Contactocolaborador', $datos['Contactocolaborador']);
        $this->db->bind(':telefonocolaborador', $datos['telefonocolaborador']);
        $this->db->bind(':movilcolaborador', $datos['movilcolaborador']);
        $this->db->bind(':emailcolaborador', $datos['emailcolaborador']);
        $this->db->bind(':webcolaborador', $datos['webcolaborador']);
        $this->db->bind(':observaciones', $datos['observaciones']);
        
        //Ejecutar
        if($this->db->execute()){
            /*$this->db->query('SELECT codColaborador FROM colaboradores  WHERE codColaborador = (SELECT max(codColaborador) FROM colaboradores)');
            $ultima = $this->db->registros();
            $lastId = $ultima[0]->codColaborador;
            
            //inserto la vinculación colaborador-cliente en la tabla colaboradoresN
                $this->db->query('INSERT INTO colaboradoresN (idEMPRESA, codTipoCol, idColaborador, TipoColaborador) VALUES (:idEmpresa, :codTipoCol, :idColaborador, :TipoColaborador)');
                $this->db->bind(':idEmpresa', $datos['idEmpresa']);
                $this->db->bind(':codTipoCol', $datos['codTipoCol']);
                $this->db->bind(':idColaborador', $lastId);
                $this->db->bind(':TipoColaborador', $tipoColaborador);

                $this->db->execute();*/
            return true;
        } else {
            return false;
        }


    }

    public function getColaboradorUpdate($id)
    {        
        /*$this->db->query('SELECT col.*, con.idColaborador AS idColaborador FROM colaboradoresN con
                        LEFT JOIN colaboradores col ON con.idColaborador=col.codColaborador
                        WHERE con.codColaborador ='.$id);  */
        $this->db->query('SELECT * FROM colaboradores col
                        WHERE col.codColaborador ='.$id);                        
        $resultado = $this->db->registros();
        
        $this->db->query('SELECT cli.idEMPRESA AS idEMPRESA, cli.NOMBREJURIDICO AS NOMBREJURIDICO
                        FROM colaboradoresN col                       
                        LEFT JOIN empresasclientes cli ON col.idEMPRESA=cli.idEMPRESA
                        WHERE col.codColaborador ='.$id);
        $resultado2 = $this->db->registros();
        $final = ['colaborador' => $resultado, 'clientes' => $resultado2];

        return array_merge($final);
    }

    public function actualizarColaborador($datos)
    {
        $dato = $datos['codTipoCol'];
        if ($dato == 0) {
            $tipoColaborador = 'Agente Informa';
        }else if ($dato == 1) {
            $tipoColaborador = 'Profesor';
        }else if ($dato == 2) {
            $tipoColaborador = 'Asesoría';
        }else if ($dato == 3) {
            $tipoColaborador = 'Proveeedor';
        }else if ($dato == 4) {
            $tipoColaborador = 'Cliente';
        }else if ($dato == 5) {
            $tipoColaborador = 'Centro de Formación';
        }else if ($dato == 6) {
            $tipoColaborador = 'Consultora';
        }
        
        $this->db->query("UPDATE  colaboradores 
                        SET codTipoCol = :codTipoCol, NifColaborador = :NifColaborador, TipoColaborador = :TipoColaborador,
                         margencomercial = :margencomercial, NombreComercial = :NombreComercial, RazonSocial = :RazonSocial,
                         Direccion = :Direccion, codigopostal = :codigopostal, Localidad = :Localidad, provincia = :provincia,
                         numcuenta = :numcuenta, Contactocolaborador = :Contactocolaborador, telefonocolaborador = :telefonocolaborador,
                         movilcolaborador = :movilcolaborador, emailcolaborador = :emailcolaborador, 
                         webcolaborador = :webcolaborador, observaciones = :observaciones                         
                        WHERE codColaborador = :codColaborador");
    
        // vincular valores
        $this->db->bind(':codColaborador', $datos['codColaborador']);
        $this->db->bind(':codTipoCol', $datos['codTipoCol']);
        $this->db->bind(':NifColaborador', $datos['NifColaborador']);
        $this->db->bind(':TipoColaborador', $tipoColaborador);
        $this->db->bind(':margencomercial', $datos['margencomercial']);
        $this->db->bind(':NombreComercial', $datos['NombreComercial']);
        $this->db->bind(':RazonSocial', $datos['RazonSocial']);
        $this->db->bind(':Direccion', $datos['Direccion']);
        $this->db->bind(':codigopostal', $datos['codigopostal']);
        $this->db->bind(':Localidad', $datos['Localidad']);
        $this->db->bind(':provincia', $datos['provincia']);
        $this->db->bind(':numcuenta', $datos['numcuenta']);
        $this->db->bind(':Contactocolaborador', $datos['Contactocolaborador']);
        $this->db->bind(':telefonocolaborador', $datos['telefonocolaborador']);
        $this->db->bind(':movilcolaborador', $datos['movilcolaborador']);
        $this->db->bind(':emailcolaborador', $datos['emailcolaborador']);
        $this->db->bind(':webcolaborador', $datos['webcolaborador']);
        $this->db->bind(':observaciones', $datos['observaciones']);
        
        if($this->db->execute()){            
            //actualizo la vinculación colaborador-cliente en la tabla colaboradoresN
                /*$this->db->query
                ('UPDATE  colaboradoresN 
                SET idEMPRESA = :idEmpresa, codTipoCol = :codTipoCol, idColaborador = :idColaborador, TipoColaborador = :TipoColaborador
                WHERE codColaborador = :codColaborador ');

                $this->db->bind(':codColaborador', $datos['codColaborador']);
                $this->db->bind(':idEmpresa', $datos['idEmpresa']);
                $this->db->bind(':codTipoCol', $datos['codTipoCol']);
                $this->db->bind(':idColaborador', $datos['idColaborador']);
                $this->db->bind(':TipoColaborador', $tipoColaborador);

                $this->db->execute();*/
            return true;
        } else {
            return false;
        }        
    }

    public function borrarColaborador($datos)
    {
        $this->db->query("DELETE FROM colaboradoresN WHERE codColaborador =".$datos['id']);
        
        //Ejecutar
        if($this->db->execute()){
            return true;
        } 
        else {
            echo "error";
            return false;
        }
    }    
    //FIN MÉTODOS COLABORADORES

    public function vincularColaboradorEmpresa($datos)
    {
        $this->db->query('SELECT codColaborador FROM colaboradores  WHERE codColaborador = (SELECT max(codColaborador) FROM colaboradores)');
        $ultima = $this->db->registros();
        $lastId = $ultima[0]->codColaborador;

        $this->db->query('SELECT codTipoCol FROM colaboradores  WHERE codColaborador =' .$datos['idColaborador']);
        $tipos = $this->db->registro();
        $idTipo = $tipos->codTipoCol;

        $dato = $datos['codTipoCol'];
        if ($dato == 0) {
            $tipoColaborador = 'Agente Informa';
        }else if ($dato == 1) {
            $tipoColaborador = 'Profesor';
        }else if ($dato == 2) {
            $tipoColaborador = 'Asesoría';
        }else if ($dato == 3) {
            $tipoColaborador = 'Proveeedor';
        }else if ($dato == 4) {
            $tipoColaborador = 'Cliente';
        }

        //inserto la vinculación colaborador-cliente en la tabla colaboradoresN
        $this->db->query('INSERT INTO colaboradoresN (idEMPRESA, codTipoCol, idColaborador, TipoColaborador) VALUES (:idEmpresa, :codTipoCol, :idColaborador, :TipoColaborador)');
        
        $this->db->bind(':idEmpresa', $datos['idEmpresa']);
        $this->db->bind(':codTipoCol', $idTipo);
        $this->db->bind(':idColaborador', $datos['idColaborador']);
        $this->db->bind(':TipoColaborador', $tipoColaborador);

        if ($this->db->execute()) {
            return true;
        }else{
            return false;
        }


    }

    //MÉTODOS PARA DATATABLE ACTIVIDADES EMPRESARIALES Y CRUD
    public function obtenerActEmpresariales(){
        $this->db->query('SELECT * FROM actividadesempresariales');
        $resultado = $this->db->registros();
        return $resultado;
    }

    public function agregarActEmpresarial($datos)
    {     
    
        $this->db->query('INSERT INTO actividadesempresariales (CODCNAE,DESACTIVIDAD,OBSACTIVIDAD,ENLACEWEB) 
                        VALUES (:codCnae,:desActividad,:observacionesAct,:enlaceAct)');                

        // vincular valores
        $this->db->bind(':codCnae', $datos['codCnae']);
        $this->db->bind(':desActividad', $datos['desActividad']);
        $this->db->bind(':observacionesAct', $datos['observacionesAct']);
        $this->db->bind(':enlaceAct', $datos['enlaceAct']);
        
        //Ejecutar
        if($this->db->execute()){            
            return true;
        } else {
            return false;
        }
    }    

    public function getActEmpresarialUpdate($id)
    {        
        $this->db->query('SELECT * FROM actividadesempresariales WHERE IDACTIVIDAD='.$id);
        $resultado = $this->db->registro();
        return $resultado;
    }

    public function actualizarActEmpresarial($datos)
    {              
        $this->db->query ('UPDATE  actividadesempresariales
                        SET CODCNAE = :codCnaeEdit, DESACTIVIDAD = :desActividadEdit, OBSACTIVIDAD = :observacionesActEdit, ENLACEWEB= :enlaceActEdit
                        WHERE IDACTIVIDAD = :idActividad');

        $this->db->bind(':idActividad', $datos['idActividad']);
        $this->db->bind(':codCnaeEdit', $datos['codCnaeEdit']);
        $this->db->bind(':desActividadEdit', $datos['desActividadEdit']);
        $this->db->bind(':observacionesActEdit', $datos['observacionesActEdit']);
        $this->db->bind(':enlaceActEdit', $datos['enlaceActEdit']);

        if ($this->db->execute()) {            
            return true;
        } else {
            return false;
        }        
    }    

    public function borrarActividadEmpresarial($datos)
    {
        $this->db->query("DELETE FROM actividadesempresariales WHERE IDACTIVIDAD =".$datos['id']);
            
        if($this->db->execute()){
            return true;
        } 
        else {            
            return false;
        }
    }



    //MÉTODOS PARA DATATABLE SECTORES Y CRUD
    public function obtenerSectoresEmpresariales(){
        $this->db->query('SELECT * FROM sectores');
        $resultado = $this->db->registros();
        return $resultado;
    }


    public function obtenerProfesores(){
        $this->db->query('select * from profesores WHERE activo=1');
        $resultado = $this->db->registros();
        return $resultado;
    }

    public function obtenerProfesorPorId($idProfesor)
    {
        $this->db->query('SELECT * FROM profesores WHERE idPROFESOR='.$idProfesor);
        $resultado = $this->db->registro();
        return $resultado;
    }
        
    public function agregarProfesor($datos)
    {                  
            //trato lo datos para pasarlos a json
            if ($datos['permisoConducir']) {         
                $permisos = $datos['permisoConducir'];
                if (count($permisos) >0) { 
                    $permisosJson = json_encode($permisos);                    
                }else{
                    $permisosJson = '[]';
                }
            }else{
                $permisosJson = '[]';
            }

            if ($datos['disponibilidad']) {            
                $dispon = $datos['disponibilidad'];
                if (count($dispon) >0) { 
                    $disponJson = json_encode($dispon);                      
                }else{
                    $disponJson = '[]';
                }        
            }else{
                $disponJson = '[]';
            }

            if ($datos['idiomas']) {                        
                $idiomas = $datos['idiomas'];
                if (count($idiomas) >0) { 
                    $idiomasJson = json_encode($idiomas);                    
                }else{
                    $idiomasJson = '[]';
                }
            }else{
                $idiomasJson = '[]';
            }

            if ($datos['informatica']) {                        
                $informatica = $datos['informatica'];
                if (count($informatica) >0) {  
                    $informaticaJson = json_encode($informatica);                     
                }else{
                    $informaticaJson = '[]';
                }     
            }else{
                $informaticaJson = '[]';
            }

            if ($datos['perfil']) {                        
                $perfil = $datos['perfil'];
                if (count($perfil) >0) {  
                    $perfilJson = json_encode($perfil);                     
                }else{
                    $perfilJson = '[]';
                }     
            }else{
                $perfilJson = '[]';
            }
           
            $this->db->query('INSERT INTO profesores (nifdniprofesor,RAZONSOCIAL,NOMBRECOMERCIAL,MARGEN,DIRECCION,POBLACION,
                                                    PROVINCIA,CODPOSTAL,TELEFONOFIJO,TELEFONOMOVIL,MAIL,
                                                    NSSPROFESOR,CCC,FORMACIONREGLADA,FORMACIONNOREGLADA,
                                                    EXLABORAL,EXFORMADOR,VEHICULOPROPIO,CONTRATO,OBSPROFESOR,
                                                    EVALUACIONGLOBAL,PRECIOHORA,contactoProfesor,webprofesor,perfil,                                              
                                                    IDIOMAS,INFORMATICA,DISPONIBILIDAD,PERMISODECONDUCIR) 
                                            VALUES (:nifProfesor,:razonSocial,:nombreComercial,:margencomercial,:direccion,:poblacion,
                                                    :provincia,:codigopostal,:TELEFONOFIJO,:TELEFONOMOVIL,:email,
                                                    :numSegSocial,:ccc,:formacionReglada,:formacionNoReglada,
                                                    :experienciaLaboral,:experienciaFormador,:vehiculoPropio,:contrato,:observaciones,
                                                    :evaluacionGlobal,:precioHora,:contacto,:webprofesor,:perfilFormador,
                                                    :idiomas,:informatica,:disponibilidad,:permisoConducir)');                      

            $this->db->bind(':nifProfesor', $datos['nifProfesor']); 
            $this->db->bind(':razonSocial', $datos['razonSocial']);
            $this->db->bind(':nombreComercial', $datos['nombreComercial']);             
            $this->db->bind(':margencomercial', $datos['margencomercial']); 
            $this->db->bind(':direccion', $datos['direccion']); 
            $this->db->bind(':poblacion', $datos['poblacion']);
            $this->db->bind(':provincia', $datos['provincia']);
            $this->db->bind(':codigopostal', $datos['codigopostal']);
            $this->db->bind(':TELEFONOFIJO', $datos['TELEFONOFIJO']);
            $this->db->bind(':TELEFONOMOVIL', $datos['TELEFONOMOVIL']);
            $this->db->bind(':email', $datos['email']);            
            $this->db->bind(':numSegSocial', $datos['numSegSocial']);
            $this->db->bind(':ccc', $datos['ccc']);            
            $this->db->bind(':formacionReglada', $datos['formacionReglada']);
            $this->db->bind(':formacionNoReglada', $datos['formacionNoReglada']); 
            $this->db->bind(':experienciaLaboral', $datos['experienciaLaboral']);
            $this->db->bind(':experienciaFormador', $datos['experienciaFormador']);
            $this->db->bind(':vehiculoPropio', $datos['vehiculoPropio']); 
            $this->db->bind(':contrato', $datos['contrato']);
            $this->db->bind(':observaciones', $datos['observaciones']);            
            $this->db->bind(':evaluacionGlobal', $datos['evaluacionGlobal']);
            $this->db->bind(':precioHora', $datos['precioHora']); 
            $this->db->bind(':contacto', $datos['contacto']);
            $this->db->bind(':webprofesor', $datos['webprofesor']);            
            $this->db->bind(':idiomas',$idiomasJson); 
            $this->db->bind(':informatica', $informaticaJson);
            $this->db->bind(':disponibilidad', $disponJson);  
            $this->db->bind(':permisoConducir', $permisosJson);
            $this->db->bind(':perfilFormador', $perfilJson); 
            //$this->db->bind(':descripcionFichero', $datos['descripcionFichero']);                  
                        
            if($this->db->execute()){                   
                $this->db->query('SELECT idPROFESOR FROM profesores WHERE idPROFESOR = (SELECT max(idPROFESOR) FROM profesores)');
                $ultima = $this->db->registro();
                $lastId = $ultima->idPROFESOR;                            
                return $lastId;
            } else {
                return false;
            }
             
    }
    

    
    public function insertarFicheroCurriculum($arr)
    {        
            if (count($arr) >0) {
                $final[] = $arr;
                $arrJson = json_encode($final);
            }else{
                $arrJson = '{}';
            }
            $idProfesor = $arr['idProfesor'];

        $this->db->query("UPDATE profesores SET CURRICULUM = :datosFichero WHERE idPROFESOR= :idProfesor");
        //SET art.codigoproveedor = JSON_INSERT(art.codigoproveedor,"$[1000]", '.$idProveedor.') 
               
        $this->db->bind(':datosFichero', $arrJson);
        $this->db->bind(':idProfesor', $idProfesor);
       
        
        if($this->db->execute()){           
            return true;
        }else{
            return false;
        }
    }
    
    public function obtenerDatosFichero($idProfesor)
    {
        $this->db->query('SELECT CURRICULUM FROM profesores WHERE idPROFESOR='.$idProfesor);
        $row = $this->db->registro();
        $json = $row->CURRICULUM;
        $res = json_decode($json);
        return $res->nombre;
    }


    public function actualizarProfesor($datos)
    {
            $this->db->query('UPDATE profesores SET  nifdniprofesor=:nifProfesor ,RAZONSOCIAL=:razonSocial,NOMBRECOMERCIAL=:nombreComercial,
                                                    MARGEN=:margencomercial,DIRECCION=:direccion,POBLACION=:poblacion,
                                                    PROVINCIA=:provincia,CODPOSTAL=:codigopostal,TELEFONOFIJO=:TELEFONOFIJO,TELEFONOMOVIL=:TELEFONOMOVIL,
                                                    MAIL=:email,NSSPROFESOR=:numSegSocial,CCC=:ccc,FORMACIONREGLADA=:formacionReglada,
                                                    FORMACIONNOREGLADA=:formacionNoReglada,
                                                    EXLABORAL=:experienciaLaboral,EXFORMADOR=:experienciaFormador,VEHICULOPROPIO=:vehiculoPropio,CONTRATO=:contrato,
                                                    OBSPROFESOR=:observaciones,EVALUACIONGLOBAL=:evaluacionGlobal,PRECIOHORA=:precioHora,
                                                    contactoProfesor=:contacto,webprofesor=:webprofesor,perfil=:perfilFormador                                                   
                            WHERE idPROFESOR= :idProfesor');                      

            $this->db->bind('idProfesor' , $_POST['idProfesor']);
            $this->db->bind(':nifProfesor', $datos['nifProfesor']); 
            $this->db->bind(':razonSocial', $datos['razonSocial']);
            $this->db->bind(':nombreComercial', $datos['nombreComercial']);             
            $this->db->bind(':margencomercial', $datos['margencomercial']); 
            $this->db->bind(':direccion', $datos['direccion']); 
            $this->db->bind(':poblacion', $datos['poblacion']);
            $this->db->bind(':provincia', $datos['provincia']);
            $this->db->bind(':codigopostal', $datos['codigopostal']);
            $this->db->bind(':TELEFONOFIJO', $datos['TELEFONOFIJO']);
            $this->db->bind(':TELEFONOMOVIL', $datos['TELEFONOMOVIL']);
            $this->db->bind(':email', $datos['email']);            
            $this->db->bind(':numSegSocial', $datos['numSegSocial']);
            $this->db->bind(':ccc', $datos['ccc']);            
            $this->db->bind(':formacionReglada', $datos['formacionReglada']);
            $this->db->bind(':formacionNoReglada', $datos['formacionNoReglada']); 
            $this->db->bind(':experienciaLaboral', $datos['experienciaLaboral']);
            $this->db->bind(':experienciaFormador', $datos['experienciaFormador']);
            $this->db->bind(':vehiculoPropio', $datos['vehiculoPropio']); 
            $this->db->bind(':contrato', $datos['contrato']);
            $this->db->bind(':observaciones', $datos['observaciones']);            
            $this->db->bind(':evaluacionGlobal', $datos['evaluacionGlobal']);
            $this->db->bind(':precioHora', $datos['precioHora']); 
            $this->db->bind(':contacto', $datos['contacto']);
            $this->db->bind(':webprofesor', $datos['webprofesor']);
            $this->db->bind(':perfilFormador', $datos['perfilFormador']);            
            
            if($this->db->execute()){            
                return true;
            } else {
                return false;
            }             
    }

    public function borrarProfesor($id)
    {
        $activo = -1; // (eliminado=-1, activo= 1, inactivo =0)

        $this->db->query ('UPDATE  profesores
                        SET activo = :activo
                        WHERE idPROFESOR = :idPROFESOR');

        $this->db->bind(':idPROFESOR', $id);
        $this->db->bind(':activo', $activo);        

        if ($this->db->execute()) {            
            return true;
        } else {
            return false;
        }
    }

    public function addCamposAjaxProfesores($post)
    {
        $idProfesor = $post['idProfesor'];
        $opcion = $post['opcion'];
        $campo = $post['campoadd'];        

        $this->db->query('UPDATE profesores
                        SET '.$campo.' = JSON_INSERT('.$campo.',"$[1000]", "'.$opcion.'") 
                        WHERE idPROFESOR ='.$idProfesor);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }                  
    }

    public function removeCamposAjaxProfesores($post)
    {
        $idProfesor = $post['idProfesor'];
        $permiso = $post['permiso'];
        $campo = $post['campoUpd'];

        $this->db->query('UPDATE profesores                         
                        SET '.$campo.' = JSON_REMOVE('.$campo.', JSON_UNQUOTE(JSON_SEARCH('.$campo.', "one", "'.$permiso.'")))
                        WHERE JSON_SEARCH('.$campo.', "one", "'.$permiso.'") IS NOT NULL
                        AND idPROFESOR = '.$idProfesor);

        if ($this->db->execute()) {            
            return true;
        } else {
            return false;
        }   
    }

    public function agregarUsuario($datos){

        $this->db->query("INSERT INTO usuarios (nombre,mail,telefono) VALUES (:nombre, :mail, :telefono)");

        // vincular valores

        $this->db->bind(':nombre', $datos['nombre']);
        $this->db->bind(':mail', $datos['mail']);
        $this->db->bind(':telefono', $datos['telefono']);

        //Ejecutar
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }

    }

    public function obtenerUsuarioId($id){
        $this->db->query('SELECT * FROM usuarios WHERE id_usuario = :id');
        $this->db->bind(':id', $id);

        $fila = $this->db->registro();

        return $fila;
    }

    public function actualizarUsuario($datos){
        $this->db->query('UPDATE usuarios SET nombre = :nombre, mail = :mail, telefono = :telefono WHERE id_usuario = :id');
        $this->db->bind(':id', $datos['id_usuario']);
        $this->db->bind(':nombre', $datos['nombre']);
        $this->db->bind(':mail', $datos['mail']);
        $this->db->bind(':telefono', $datos['telefono']);

        //Ejecutar
        if($this->db->execute()){
            return true;

        }else {
            return false;
        }
    }

    public function borrarUsuario($datos){
        $this->db->query('DELETE FROM usuarios WHERE id_usuario = :id');
        $this->db->bind(':id', $datos['id_usuario']);


        //Ejecutar
        if($this->db->execute()){
            return true;

        }else {
            return false;
        }
    }


    public function obtenerClientes(){
        $this->db->query('SELECT * FROM empresasclientes limit 0,500');

        $resultado = $this->db->registros();

        return $resultado;
    }

    //------

    public function obtenerClientesTodos()
    {
        $this->db->query('SELECT idEMPRESA, NOMBREJURIDICO FROM empresasclientes');
        $resultado = $this->db->registros();
        return $resultado;
    }

    //MÉTODOS PARA DATATABLE CUENTAS BANCARIAS Y CRUD
    public function obtenerCuentasBancarias(){
        $this->db->query('SELECT * FROM cuentasbancarias');
        $resultado = $this->db->registros();
        return $resultado;
    }    

}