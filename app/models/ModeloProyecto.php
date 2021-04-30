<?php


class ModeloProyecto
{

    private $db;

    public function __construct()
    {
        $this->db = new Base;
    }


    public function obtenerClientes()
    {
        $this->db->query('SELECT codEmpresa, NOMBREJURIDICO  FROM empresasclientes');

        $resultado = $this->db->registros();

        return $resultado;
    }

    public function obtenerProfesores()
    {
        $this->db->query('SELECT idProfesor, nombrecomercial FROM profesores');

        $resultado = $this->db->registros();

        return $resultado;
    }

    public function obtenerColaboradores()
    {
        $this->db->query('SELECT codColaborador, NombreComercial FROM colaboradores');
        $resultado = $this->db->registros();
        return $resultado;
    }

    public function obtenerColaboradorAgentePorCliente($datos)
    {

        $this->db->query('SELECT col.RazonSocial AS colaborador, CONCAT(ag.Nombre," ", ag.Apellidos) AS agente
                        FROM colaboradoresN con
                        LEFT JOIN colaboradores col ON con.idColaborador=col.codColaborador
                        LEFT JOIN agentesclientes agcli ON agcli.idEmpresa=con.idEMPRESA
                        LEFT JOIN agentes ag ON agcli.idAgente=ag.codagente               
                        WHERE con.idEMPRESA =:idCliente');

        $this->db->bind(':idCliente', $datos['idCliente']);
        $resultado = $this->db->registro();
        $colaborador = $resultado->colaborador;
        $agente = $resultado->agente;

        //obtener tipología de la acción:        
        $tipologia = $this->obtenerTipologiaPorClienteyProyecto($datos);
        $tipologiasLista = $this->tipologias();
        $salida = "<option selected disabled>Seleccionar.....</option>";
        foreach ($tipologiasLista as $row) {
            $salida .= "<option value='" . $row->codtipologia . "' " . (($row->codtipologia == $tipologia) ? 'selected' : '') . ">" . $row->descripcion . "</option>";
        }

        //obtener nivel de curso:
        /*$nivel = $this->nivelDeCursoPorProyectoyCliente($datos);
        $nivelesDeCursos = $this->nivelesDeCursos();
        $salida2 = "<option selected disabled>Seleccionar.....</option>";
        foreach ($nivelesDeCursos as $row) {
            $salida2 .= "<option value='" . $row->CODNIVELCURSO . "' ".(($row->CODNIVELCURSO == $nivel)? 'selected':'').">" . $row->DESCNIVELCURSO . "</option>";
        }*/

        //obtener modalidad:
        /*$modalidad = $this->modalidadProyectoyCliente($datos);
        $modalidadesLista = $this->obtenerModalidades();
        $salida3 = "<option selected disabled>Seleccionar.....</option>";
        foreach ($modalidadesLista as $row) {
            $salida3 .= "<option value='" . $row->CODMODALIDAD . "' ".(($row->CODMODALIDAD == $modalidad)? 'selected':'').">" . $row->DESMODALIDAD . "</option>";
        }*/

        //obtener participantes:
        $this->db->query('SELECT apre.participantes, apre.importe, apre.horas
                        FROM proyectos pro 
                        LEFT JOIN acciones_proyecto apro ON pro.idProyecto=apro.idProyecto
                        LEFT JOIN acciones_presupuesto apre ON apro.idAccionPres=apre.idAccionPres
                        WHERE pro.idProyecto=:idProyecto AND apro.idEMPRESA=:idCliente ');

        $this->db->bind(':idCliente', $datos['idCliente']);
        $this->db->bind(':idProyecto', $datos['idProyecto']);
        $row = $this->db->registro();
        $participantes = $row->participantes;
        $importe = $row->importe;
        //$horas = $row->horas;

        $array = [
            'colaborador' => $colaborador, 'agente' => $agente, 'tipologia' => $salida, /*'nivel'=>$salida2, 'modalidad'=> $salida3,*/
            'participantes' => $participantes, 'importe' => $importe/*, 'horas'=> $horas*/
        ];
        return $array;
    }

    public function obtenerNumeroTotalDeParticipantes($datos)
    {
        $this->db->query('SELECT SUM(apre.participantes) AS participantes
                        FROM acciones_presupuesto  apre
                        LEFT JOIN acciones_proyecto apro ON apre.idAccionPres=apro.idAccionPres
                        WHERE apro.idProyecto= :idProyecto');
        $this->db->bind(':idProyecto', $datos['idProyecto']);
        $row = $this->db->registro();
        $participantes = $row->participantes;
        return $participantes;
    }

    public function obtenerTodosLosClientesDeUnProyecto($idProyecto)
    {

        $this->db->query('SELECT acc.*, cli.NOMBREJURIDICO AS nomCliente
                        FROM proyectos pro 
                        LEFT JOIN acciones_proyecto acc ON pro.idProyecto=acc.idProyecto
                        LEFT JOIN empresasclientes cli ON acc.idEMPRESA=cli.idEMPRESA
                        WHERE pro.idProyecto=:idProyecto');

        $this->db->bind(':idProyecto', $idProyecto);
        $resultado = $this->db->registros();
        return $resultado;
    }

    public function buscarDatosDeTodosLosClientes($datos)
    {

        $this->db->query('SELECT acc.*, cli.NOMBREJURIDICO AS nomCliente, col.RazonSocial AS nomColaborador
                        FROM proyectos pro 
                        LEFT JOIN acciones_proyecto acc ON pro.idProyecto=acc.idProyecto
                        LEFT JOIN empresasclientes cli ON acc.idEMPRESA=cli.idEMPRESA
                        LEFT JOIN colaboradoresN col ON cli.idEMPRESA=col.idEMPRESA
                        WHERE pro.idProyecto=:idProyecto');

        $this->db->bind(':idProyecto', $datos['idProyecto']);
        $resultado = $this->db->registros();

        $salida = "<div class='form-group row mx-0'>";
        foreach ($resultado as $key) {

            $salida .= "            
                <div class='col-md-4 pl-0'>
                    <div class='input-group'>
                        <div class='input-group-prepend'>
                            <span class='input-group-text inputResaltadoFichaProyecto form-control-sm'>Cliente</span>
                        </div>
                        <input class='clienteSel form-control form-control-sm' readonly value='" . $key->nomCliente . "'>                    
                    </div>
                </div>
                <div class='col-md-3 pl-0'>
                    <div class='input-group'>
                        <div class='input-group-prepend'>
                            <span class='input-group-text inputResaltadoFichaProyecto form-control-sm'>Colaborador</span>
                        </div>                        
                        <input class='clienteSel form-control  form-control-sm' readonly value='" . $key->nomColaborador . "'>
                    </div>
                </div>
                <div class='col-md-3 pl-0'>
                    <div class='input-group'>
                        <div class='input-group-prepend'>
                            <span class='input-group-text inputResaltadoFichaProyecto form-control-sm'>Agente</span>
                        </div>";

            $this->db->query('SELECT age.idAgente, CONCAT(ag.Nombre," ",ag.Apellidos) AS nomAgente
                                    FROM agentesclientes age 
                                    LEFT JOIN agentes ag ON age.idAgente=ag.codagente
                                    WHERE age.idEmpresa=' . $key->idEMPRESA);
            $this->db->bind(':idProyecto', $datos['idProyecto']);
            $res = $this->db->registros();

            $agentes = '';
            $nomAgentes = '';
            foreach ($res as $k) {
                $partes = explode(" ", $k->nomAgente);
                $siglas = '';
                foreach ($partes as $p) {
                    $siglas .= $p[0];
                }
                $nomAgentes .= $k->nomAgente . " / ";
                $agentes .= $siglas . " / ";
            }


            $salida .= "
                        <input class='clienteSel form-control  form-control-sm' value='" . $agentes . "' title='" . $nomAgentes . "' readonly>
                    </div>
                </div>                    
                <div class='col-md-2'>
                    <div class='input-group'>
                        <div class='input-group-prepend'>
                            <span class='input-group-text inputResaltadoFichaProyecto form-control-sm'>Importe</span>
                        </div>                        
                        <input class='clienteSel form-control form-control-sm' readonly value='" . $key->importe . "'>
                    </div>                      
                </div>";
        }

        $salida .= "</div>";
        return $salida;
    }


    public function modalidadProyectoyCliente($datos)
    {
        $this->db->query('SELECT modalidad FROM proyectos pro 
                        LEFT JOIN acciones_proyecto acc ON pro.idProyecto=acc.idProyecto
                        LEFT JOIN acciones_presupuesto pres ON acc.idAccionPres=pres.idAccionPres
                        WHERE pro.idProyecto= :idProyecto AND acc.idEMPRESA= :idCliente');

        $this->db->bind(':idProyecto', $datos['idProyecto']);
        $this->db->bind(':idCliente', $datos['idCliente']);
        $resultado = $this->db->registro();
        return $resultado->modalidad;
    }

    public function nivelesDeCursos()
    {
        $this->db->query('SELECT * FROM nivelesdecursos');
        $resultado = $this->db->registros();
        return $resultado;
    }

    public function nivelDeCursoPorProyectoyCliente($datos)
    {
        $this->db->query('SELECT nivel FROM proyectos pro 
                        LEFT JOIN acciones_proyecto acc ON pro.idProyecto=acc.idProyecto
                        LEFT JOIN acciones_presupuesto pres ON acc.idAccionPres=pres.idAccionPres
                        WHERE pro.idProyecto= :idProyecto AND acc.idEMPRESA= :idCliente');

        $this->db->bind(':idProyecto', $datos['idProyecto']);
        $this->db->bind(':idCliente', $datos['idCliente']);
        $resultado = $this->db->registro();
        return $resultado->nivel;
    }

    public function tipologias()
    {
        $this->db->query('SELECT * FROM tipologia');
        $resultado = $this->db->registros();
        return $resultado;
    }

    public function obtenerTipologiaPorClienteyProyecto($datos)
    {
        $this->db->query('SELECT acc.idTipo FROM proyectos pro 
                        LEFT JOIN acciones_proyecto acc ON pro.idProyecto=acc.idProyecto
                        WHERE pro.idProyecto= :idProyecto AND acc.idEMPRESA = :idCliente');

        $this->db->bind(':idProyecto', $datos['idProyecto']);
        $this->db->bind(':idCliente', $datos['idCliente']);
        $resultado = $this->db->registro();
        return $resultado->idTipo;
    }

    public function obtenerDatosProfesor($datos)
    {

        $this->db->query('SELECT * FROM profesores pro WHERE pro.idPROFESOR=:idProfesor');

        $this->db->bind('idProfesor', $datos['profesor']);
        $resultado = $this->db->registro();
        return $resultado;
    }

    public function obtenerNumeroParticipantes($datos)
    {

        $this->db->query('SELECT participantes FROM acciones_proyecto acc                        
                        LEFT JOIN acciones_presupuesto apre ON acc.idAccionPres=apre.idAccionPres
                        WHERE acc.idAccionProy= :idAccionProy');
        $this->db->bind('idAccionProy', $datos['idAccionProy']);
        $resultado = $this->db->registro();

        return $resultado->participantes;
    }

    public function obtenerAgentes()
    {
        $this->db->query('SELECT * FROM agentes');

        $resultado = $this->db->registros();

        return $resultado;
    }

    public function obtenerAcciones()
    {
        $this->db->query('SELECT idACCION, NOMBREACCION FROM accionesformativas');
        $resultado = $this->db->registros();
        return $resultado;
    }

    public function obtenerTipos()
    {
        $this->db->query('SELECT codtipoformacion, destipoformacion FROM tipodeaccion;');

        $resultado = $this->db->registros();

        return $resultado;
    }

    public function obtenerAreas()
    {
        $this->db->query('SELECT codarea, desarea FROM areadeformacion;');

        $resultado = $this->db->registros();

        return $resultado;
    }

    public function obtenerModalidades()
    {
        $this->db->query('select CODMODALIDAD , DESMODALIDAD from modalidadesdeacciones WHERE ACTIVO=1');

        $resultado = $this->db->registros();

        return $resultado;
    }

    public function agregarProyecto($datos)
    {

        $this->db->query("INSERT INTO proyectos (nombreProyecto,tipoProyecto,descripcion,estadoProyecto,clienteProyecto,profesor,colaborador,observacionesGenerales,accionformativa,tipoAccionFormativa,
        areaFormativa,modalidadFormativa,objetivo,contenido,metodologia,observacionesAccion) VALUES (:nombreProyecto,:tipoProyecto,:descripcion,:estadoProyecto,:clienteProyecto,:profesor,:colaborador,:observacionesGenerales,
        :accionformativa,:tipoAccionFormativa,:areaFormativa,:modalidadFormativa,:objetivo,:contenido,:metodologia,:observacionesAccion)");

        // vincular valores
        $this->db->bind('nombreProyecto', $datos['nombreProyecto']);
        $this->db->bind(':tipoProyecto', $datos['tipoProyecto']);
        $this->db->bind(':descripcion', $datos['descripcion']);
        $this->db->bind(':estadoProyecto', $datos['estadoProyecto']);
        $this->db->bind(':clienteProyecto', $datos['clienteProyecto']);
        $this->db->bind(':profesor', $datos['profesor']);
        $this->db->bind(':colaborador', $datos['colaborador']);
        $this->db->bind(':observacionesGenerales', $datos['observacionesGenerales']);
        $this->db->bind(':accionformativa', $datos['accionFormativa']);
        $this->db->bind(':tipoAccionFormativa', $datos['tipoAccionFormativa']);
        $this->db->bind(':areaFormativa', $datos['areaFormativa']);
        $this->db->bind(':modalidadFormativa', $datos['modalidadFormativa']);
        $this->db->bind(':objetivo', $datos['objetivo']);
        $this->db->bind(':contenido', $datos['contenido']);
        $this->db->bind(':metodologia', $datos['metodologia']);
        $this->db->bind(':observacionesAccion', $datos['observacionesAccion']);


        //Ejecutar
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /*public function listaProyectos(){ //la he cambiado por la función listaProyectosPorGrupo, ver si se elimina
        $this->db->query('SELECT pro.idProyecto as numero,pro.nombreProyecto as proyecto, tipo.tipoProyecto as tipo ,
                            cli.NOMBREJURIDICO as cliente, est.estado as estado, fechaCreacion FROM proyectos pro
                            LEFT JOIN tipoproyecto tipo ON pro.tipoProyecto=tipo.idtipo
                            LEFT JOIN estadoproyecto est ON pro.estadoProyecto=est.idEstado
                            LEFT JOIN empresasclientes cli ON pro.clienteProyecto=cli.idGrupo
                            ORDER BY fechaCreacion DESC');

        $resultado = $this->db->registros();

        return $resultado;
    }*/

    public function listaProyectosPorAccionPresupuestoFecha()
    {
        /*$this->db->query('SELECT CONCAT(acc.idPresupuesto,"_",acc.idACCION ,"_",acc.fechaInicio) AS pkProyecto, pre.idServicios as idServicio, ser.nombreS AS nombreServicio, 
                        acc.*, COUNT(*) contador, pre.nombrePres, af.NOMBREACCION, pro.indice 
                        FROM acciones_proyecto acc
                        LEFT JOIN presupuesto pre ON acc.idPresupuesto=pre.idPresupuesto
                        LEFT JOIN accionesformativas af ON acc.idACCION=af.idACCION
                        LEFT JOIN servicio ser ON pre.idServicios=ser.idServicio
                        LEFT JOIN proyectos pro ON acc.idProyecto=pro.idProyecto
                        WHERE acc.idPresupuesto IS NOT NULL AND acc.fechaInicio IS NOT NULL
                        GROUP BY acc.idACCION, acc.fechaInicio, acc.idPresupuesto
                        HAVING COUNT(*) >= 1
                        ORDER BY acc.fechaInicio DESC');*/
        $this->db->query('SELECT pro.*, pre.nombrePres, af.NOMBREACCION, pre.idServicios as idServicio, ser.nombreS AS nombreServicio 
                        FROM proyectos pro
                        LEFT JOIN presupuesto pre ON pro.idPresupuesto=pre.idPresupuesto
                        LEFT JOIN accionesformativas af ON pro.accionformativa=af.idACCION
                        LEFT JOIN servicio ser ON pre.idServicios=ser.idServicio
                        ORDER BY pro.idProyecto DESC');
        $resultado = $this->db->registros();
        return $resultado;
    }



    public function fichaProyecto($id)
    {

        //consulta que trae la cabecera de la ficha del proyecto        
        $this->db->query('SELECT pro.*, pre.nombrePres, af.NOMBREACCION, pre.idServicios as idServicio, ser.nombreS AS nombreServicio,
                        af.MetodologiaPrevista, af.ContenidoPrevisto, af.ObjetivoPrevisto 
                        FROM proyectos pro
                        LEFT JOIN presupuesto pre ON pro.idPresupuesto=pre.idPresupuesto
                        LEFT JOIN accionesformativas af ON pro.accionformativa=af.idACCION
                        LEFT JOIN servicio ser ON pre.idServicios=ser.idServicio
                        WHERE pro.idProyecto= :id
                        ORDER BY pro.idProyecto DESC');
        $this->db->bind(':id', $id);
        $fila = $this->db->registro();

        //traigo la modalidad y nivel (todo: revisar el limit 1)
        $this->db->query('SELECT moda.DESMODALIDAD AS modalidad, niv.DESCNIVELCURSO AS nivel, 
                        tip.DESTIPOFORMACION AS tipoFormacion, tipol.descripcion as tipologia, pre.fecha,
                        are.DESAREA AS areaFormativa
                        FROM acciones_proyecto acc
                        LEFT JOIN acciones_presupuesto apre ON acc.idAccionPres=apre.idAccionPres
                        LEFT JOIN accionesformativas afo ON afo.idACCION=apre.idACCION
                        LEFT JOIN modalidadesdeacciones moda ON apre.modalidad=moda.CODMODALIDAD
                        LEFT JOIN nivelesdecursos niv ON apre.nivel=niv.CODNIVELCURSO
                        LEFT JOIN tipodeaccion tip ON afo.CODTIPO=tip.CODTIPOFORMACION
                        LEFT JOIN areadeformacion are ON afo.CODAREA=are.CODAREA
                        LEFT JOIN tipologia tipol ON apre.idServicio=tipol.codtipologia
                        LEFT JOIN presupuesto pre ON apre.idPresupuesto=pre.idPresupuesto
                        WHERE acc.idProyecto= :id
                        LIMIT 1');
        $this->db->bind(':id', $id);
        $detalles = $this->db->registro();

        //consulta que trae todos los clientes involucrados en el proyecto
        $this->db->query('SELECT cli.idEMPRESA, cli.NOMBREJURIDICO, acc.idAccionPres, apre.estatus 
                        FROM acciones_proyecto acc
                        LEFT JOIN empresasclientes cli ON acc.idEMPRESA=cli.idEMPRESA
                        LEFT JOIN acciones_presupuesto apre ON acc.idAccionPres=apre.idAccionPres 
                        WHERE acc.idProyecto= :id AND apre.estatus=1');
        $this->db->bind(':id', $id);
        /*$this->db->bind(':fechaInicio', $datos['fechaInicio']);
        $this->db->bind(':idAccionPres', $datos['idAccionPres']); */
        $clientes = $this->db->registros();

        //consulta que trae todos los profesores
        $this->db->query('SELECT * FROM profesores');
        $profesores = $this->db->registros();

        //consulta que trae el profesor asignado al proyecto
        $this->db->query('SELECT pro.idProfesor, pro.profesorInterno, pro.obsProfesor, prof.nifdniprofesor, prof.RAZONSOCIAL, prof.NOMBRECOMERCIAL 
                        FROM proyectos pro 
                        LEFT JOIN profesores prof ON pro.idProfesor=prof.idPROFESOR
                        WHERE pro.idProyecto= :id');
        $this->db->bind(':id', $id);
        $profesoresProy = $this->db->registros();

        //consulta que trae participantes asignado al proyecto
        $this->db->query('SELECT par.*, emp.DocIdentidad, emp.Nombre, emp.Apellido1, emp.Apellido2, par.OBSEMPLEADO, emp.Telefono 
                        FROM participantes par
                        LEFT JOIN empleados emp ON par.IDEMPLEADO=emp.IdEmpleado
                        WHERE par.IDPROYECTO= :id');
        $this->db->bind(':id', $id);
        $participantes = $this->db->registros();

        //consulta que trae todos los empleados
        $this->db->query('SELECT emp.IdEmpleado, emp.DocIdentidad as dni, emp.Nombre, emp.Apellido1, emp.Apellido2, emp.idEmpresa AS idEmpresa, cli.NOMBREJURIDICO
                        FROM empleados emp
                        LEFT JOIN empresasclientes cli ON emp.idEmpresa=cli.idEMPRESA');
        $empleados = $this->db->registros();


        $final = [
            'generales' => $fila, 'detalles' => $detalles, 'clientes' => $clientes,
            'profesores' => $profesores, 'profesoresProy' => $profesoresProy,
            'participantes' => $participantes, 'empleados' => $empleados
        ];

        return $final;
    }

    public function buscarAccionesProyectoPorClientes($datos)
    {
        $this->db->query('SELECT * FROM acciones_proyecto acc
                        LEFT JOIN empresasclientes cli ON acc.idEMPRESA=cli.idEMPRESA
                        WHERE idProyecto= :idProyecto AND cli.idEMPRESA= :idCliente	');
        $this->db->bind(':idProyecto', $datos['idProyecto']);
        $this->db->bind(':idCliente', $datos['idCliente']);
        /*$this->db->bind(':idAccion', $datos['idAccion']);
        $this->db->bind(':fechaInicio', $datos['fechaInicio']);*/
        $filas = $this->db->registro();
        return $filas;
    }

    public function obtenerTipoCostes()
    {
        //consulta que trae todos los tipos de coste
        $this->db->query('SELECT * FROM tiposdecostes');
        $tipoCostes = $this->db->registros();
        return $tipoCostes;
    }

    public function obtenerCuentasBancarias()
    {
        //consulta que trae todos los tipos de coste
        $this->db->query('SELECT * FROM cuentasbancarias');
        $ctasBancarias = $this->db->registros();
        return $ctasBancarias;
    }

    public function obtenerTipoGastos()
    {
        //consulta que trae todos los tipos de coste
        $this->db->query('SELECT * FROM tiposdegastos');
        $tipoCostes = $this->db->registros();
        return $tipoCostes;
    }

    public function obtenerTipoGastosGenerales()
    {
        //consulta que trae todos los tipos de coste
        $this->db->query('SELECT * FROM tipogastosgenerales');
        $tipoGastos = $this->db->registros();
        return $tipoGastos;
    }

    public function obtenerTipoProveedores()
    {
        //consulta que trae todos los tipos de coste
        $this->db->query('SELECT * FROM tipogastosgenerales');
        $tipoGastos = $this->db->registros();
        return $tipoGastos;
    }

    public function obtenerGastosClientesComun($idgasto)
    {
        $this->db->query('SELECT * FROM clientesgastosaccionproy gc  LEFT join gastosaccionproy gas ON gc.idGasto = gas.idgasto where gc.idGasto='.$idgasto);
        $lineasClientes = $this->db->registros();
        return $lineasClientes;
    }


    public function obtenerCostesAccionProyecto($datos)
    {
        /*$res = $this->buscarAccionesProyectoPorClientes($datos);
       $idAccionProy = $res->idAccionProy;*/

        $this->db->query('SELECT coste.*, tip.codcoste AS codigocoste, tip.nomcoste, tip.tipocoste, apro.idProyecto, apro.idEMPRESA  
                        FROM costesaccionproy coste 
                        LEFT JOIN tiposdecostes tip ON coste.tipocoste=tip.codcoste
                        LEFT JOIN acciones_proyecto apro ON coste.idaccionproy=apro.idAccionProy
                        WHERE apro.idProyecto= :idProyecto AND apro.idEMPRESA= :idCliente ');
        $this->db->bind(':idProyecto', $datos['idProyecto']);
        $this->db->bind(':idCliente', $datos['idCliente']);
        //$this->db->bind(':idAccionProy', $idAccionProy);
        $costesProy = $this->db->registros();
        return $costesProy;
    }

    public function obtenerGastosAccionProyecto($datos)
    {
        $res = $this->buscarAccionesProyectoPorClientes($datos);
        $idAccionProy = $res->idAccionProy;

        $this->db->query('SELECT gas.*, pro.RAZONSOCIAL AS nombreProveedor, tip.nomcoste, tip.tipocoste FROM gastosaccionproy gas
                        LEFT JOIN profesores pro ON gas.razonSocial=pro.idPROFESOR
                        LEFT JOIN tiposdegastos tip ON gas.tipoGasto=tip.codcoste
                        WHERE gas.idaccionproy= :idAccionProy AND gas.tipoProveedor="profesor"');
        $this->db->bind(':idAccionProy', $idAccionProy);
        $tipProf = $this->db->registros();

        $this->db->query('SELECT gas.*, col.RazonSocial AS nombreProveedor, tip.nomcoste, tip.tipocoste FROM gastosaccionproy gas
                        LEFT JOIN colaboradores col ON gas.razonSocial=col.codColaborador
                        LEFT JOIN tiposdegastos tip ON gas.tipoGasto=tip.codcoste
                        WHERE gas.idaccionproy= :idAccionProy AND gas.tipoProveedor="colaborador"');
        $this->db->bind(':idAccionProy', $idAccionProy);
        $tipCol = $this->db->registros();

        $this->db->query('SELECT gas.*, pro.PERSONAJURIDICA AS nombreProveedor, tip.nomcoste, tip.tipocoste FROM gastosaccionproy gas
                        LEFT JOIN proveedores pro ON gas.razonSocial=pro.idPROVEEDOR
                        LEFT JOIN tiposdegastos tip ON gas.tipoGasto=tip.codcoste
                        WHERE gas.idaccionproy= :idAccionProy AND gas.tipoProveedor="proveedor"');
        $this->db->bind(':idAccionProy', $idAccionProy);
        $tipProv = $this->db->registros();

        $array = array_merge($tipProf, $tipCol, $tipProv);
        return $array;
    }

    public function obtenerFacturasAccionProyecto($datos)
    {
        $this->db->query('SELECT fac.*, cta.iban AS numiban, apro.idProyecto from facturascabecera fac
                        LEFT JOIN cuentasbancarias cta ON fac.iban=cta.idcuenta
                        LEFT JOIN acciones_proyecto apro ON fac.idaccionproy=apro.idAccionProy
                        WHERE fac.idempresa= :idCliente AND apro.idProyecto= :idProyecto');
        $this->db->bind(':idProyecto', $datos['idProyecto']);
        $this->db->bind(':idCliente', $datos['idCliente']);
        $facturasProy = $this->db->registros();

        return $facturasProy;
    }


    public function obtenerEmailsCliente($datos)
    {
        //consulta que trae los datos de los contactos de la tabla contactos
        $this->db->query('SELECT con.nombreC as nombre, con.areaDpto as area, con.mail as mail 
                        FROM contactos con 
                        WHERE con.idEMPRESA=' . $datos['idCliente']);
        $emailContactos = $this->db->registros();

        //verificar si el cliente tiene asesor interno o externo
        $this->db->query('SELECT cli.asesorTipo FROM empresasclientes cli WHERE cli.idEMPRESA=' . $datos['idCliente']);
        $resultado = $this->db->registro();
        $asesorTipo = $resultado->asesorTipo;

        if ($asesorTipo == 'interno') {
            $this->db->query('SELECT cli.personacontacto as nombre, cli.mailcontacto as mail, "" AS area
                            FROM empresasclientes cli WHERE cli.idEMPRESA=' . $datos['idCliente']);
            $datosAsesor = $this->db->registros();
        } else if ($asesorTipo == 'externo') {
            $this->db->query('SELECT asecli.*, ase.nomasesor as nombre, ase.mail as mail, "" AS area
                            FROM asesoresclientes asecli 
                            LEFT JOIN asesores ase ON asecli.idAsesor=ase.idAsesor
                            WHERE asecli.idEmpresa=' . $datos['idCliente']);
            $datosAsesor = $this->db->registros();
        } else {
            $datosAsesor = [];
        }

        //formo el array para el select de email
        $selectEmails = array_merge($emailContactos, $datosAsesor);
        return $selectEmails;
    }

    public function obtenerParticipantesPorCliente($datos)
    {
        $this->db->query('SELECT pro.idProyecto, apro.idAccionProy, apro.idEMPRESA, cli.NOMBREJURIDICO, cli.CIFCLIENTE, pro.accionformativa, 
                        afo.NOMBREACCION, pro.fechaInicio, pro.fechaFin, apre.horas, apre.modalidad, 
                        moda.DESMODALIDAD AS nombreModalidad
                        FROM proyectos pro
                        LEFT JOIN acciones_proyecto apro ON pro.idProyecto=apro.idProyecto
                        LEFT JOIN empresasclientes cli ON apro.idEMPRESA=cli.idEMPRESA
                        LEFT JOIN accionesformativas afo ON pro.accionformativa=afo.idACCION
                        LEFT JOIN acciones_presupuesto apre ON apro.idAccionPres=apre.idAccionPres
                        LEFT JOIN modalidadesdeacciones moda ON apre.modalidad=moda.CODMODALIDAD
                        WHERE pro.idProyecto= :idProyecto AND apro.idEMPRESA= :idCliente');

        $this->db->bind(':idProyecto', $datos['idProyecto']);
        $this->db->bind(':idCliente', $datos['idCliente']);
        $generales = $this->db->registro();


        $this->db->query('SELECT par.*, emp.Nombre, emp.Apellido1, emp.Apellido2, emp.DocIdentidad,
                        emp.idEmpresa, cli.NOMBREJURIDICO, cli.CIFCLIENTE, pro.accionformativa, 
                        afo.NOMBREACCION, pro.fechaInicio, pro.fechaFin, apre.horas, apre.modalidad, 
                        moda.DESMODALIDAD AS nombreModalidad
                        FROM participantes par 
                        LEFT JOIN empleados emp ON par.IDEMPLEADO=emp.IdEmpleado
                        LEFT JOIN empresasclientes cli ON emp.idEmpresa=cli.idEMPRESA
                        LEFT JOIN proyectos pro ON par.IDPROYECTO=pro.idProyecto
                        LEFT JOIN accionesformativas afo ON pro.accionformativa=afo.idACCION
                        LEFT JOIN acciones_proyecto apro ON pro.idProyecto=apro.idProyecto
                        LEFT JOIN acciones_presupuesto apre ON apro.idAccionPres=apre.idAccionPres
                        LEFT JOIN modalidadesdeacciones moda ON apre.modalidad=moda.CODMODALIDAD
                        WHERE par.IDPROYECTO= :idProyecto AND emp.idEmpresa= :idCliente');

        $this->db->bind(':idProyecto', $datos['idProyecto']);
        $this->db->bind(':idCliente', $datos['idCliente']);
        $asistentes = $this->db->registros();

        $datosDiplomas = ['generales' => $generales, 'asistentes' => $asistentes];
        return $datosDiplomas;
    }



    public function validarSaldoPorFacturarParaAccion($datos) //revisar tiene problemas
    {
        //sumo todos los importes de facturas relacionadas al mismo idaccionproy
        $this->db->query('SELECT SUM(importe) AS suma FROM facturascabecera
                        WHERE idAccionProy=' . $datos['idAccionProy']);
        $resultado = $this->db->registro();
        $sumaImportes = $resultado->suma;

        //Hallo el importe de la idaccionproy:
        $this->db->query('SELECT importeactual FROM acciones_proyecto
                        WHERE idAccionProy=' . $datos['idAccionProy']);
        $resultado = $this->db->registro();
        $totalAccion = $resultado->importeactual;

        $saldoFactura = $totalAccion - $sumaImportes;

        if ($datos['importeFactura'] <= $saldoFactura) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function creaCabeceraFactura($datos)
    {
        //buscar último numfactura de facturascabecera
        $this->db->query('SELECT codfactura FROM facturascabecera  
                        WHERE codfactura = (SELECT max(codfactura) FROM facturascabecera)');
        $ultNumFact = $this->db->registro();
        $codFactura = $ultNumFact->codfactura + 1;
        //construyendo el numfacura
        $fechaFactura = explode("-", $datos['fechaFactura']);
        $mes = $fechaFactura[1];
        $anio = $fechaFactura[0];
        $numFactura = $codFactura . "/" . $mes . "/" . $anio;

        //calculo importe total factura:
        $baseImp = $datos['importeFactura'];
        $iva = $datos['iva'];
        $cantidad = $datos['cantidad'];

        if ($iva && $iva > 0) {
            $valorIVA = $baseImp * $cantidad * $iva / 100;
        } else {
            $valorIVA = 0;
        }
        $total = ($baseImp * $cantidad) + $valorIVA;

        //INSERT 1 línea en facturascabecera
        $this->db->query("INSERT INTO facturascabecera (numfactura,codfactura,idempresa,fechafactura,idPresupuesto,idaccionproy,importe,cantidad,iva,total,fechacobro,iban,concepto, predefinido,tipoconcepto,tipofolio) 
                        VALUES (:numfactura,:codfactura,:idempresa,:fechafactura,:idPresupuesto,:idaccionproy,:importe,:cantidad,:iva,:total,:fechacobro, :iban, :concepto, :predefinido, :tipoConcepto, :tipofolio)");

        $this->db->bind(':numfactura', $numFactura);
        $this->db->bind(':codfactura', $codFactura);
        $this->db->bind(':idempresa', $datos['idEmpresa']);
        $this->db->bind(':fechafactura', $datos['fechaFactura']);
        $this->db->bind(':idPresupuesto', $datos['idPresupuesto']);
        $this->db->bind(':idaccionproy', $datos['idAccionProy']);
        $this->db->bind(':importe', $datos['importeFactura']);
        $this->db->bind(':cantidad', $datos['cantidad']);
        $this->db->bind(':iva', $datos['iva']);
        $this->db->bind(':total', $total);
        $this->db->bind(':fechacobro', $datos['fechaCobro']);
        $this->db->bind(':iban', $datos['iban']);
        $this->db->bind(':concepto', $datos['concepto']);
        $this->db->bind(':predefinido', $datos['predefinido']);
        $this->db->bind(':tipoConcepto', $datos['tipoConcepto']);
        $this->db->bind(':tipofolio', $datos['tipoFolio']);


        if ($this->db->execute()) {
            return $numFactura;
        } else {
            return 0;
        }
    }

    public function obtenerConcepto()
    {
        $this->db->query('SELECT concepto FROM facturascabecera WHERE idfactura=' . $_POST['idFact']);
        $resultado = $this->db->registro();
        $res = $resultado->concepto;
        return $res;
    }

    public function actualizarFactura($datos)
    {
        //calculo importe total factura:
        $baseImp = $datos['importeFactura'];
        $iva = $datos['iva'];
        $cantidad = $datos['cantidad'];

        if ($iva && $iva > 0) {
            $valorIVA = $baseImp * $cantidad * $iva / 100;
        } else {
            $valorIVA = 0;
        }
        $total = ($baseImp * $cantidad) + $valorIVA;

        //INSERT 1 línea en facturascabecera
        $this->db->query("UPDATE facturascabecera
                        SET importe= :importe, cantidad= :cantidad, iva= :iva, total= :total, fechacobro= :fechacobro, iban= :iban,
                        fechafactura=:fechafactura, concepto=:concepto
                        WHERE idfactura = :idfactura");

        $this->db->bind(':fechafactura', $datos['fechaFactura']);
        $this->db->bind(':importe', $datos['importeFactura']);
        $this->db->bind(':cantidad', $datos['cantidad']);
        $this->db->bind(':iva', $datos['iva']);
        $this->db->bind(':total', $total);
        $this->db->bind(':fechacobro', $datos['fechaCobro']);
        $this->db->bind(':iban', $datos['iban']);
        $this->db->bind(':idfactura', $datos['idFactura']);
        $this->db->bind(':concepto', $datos['concepto']);

        if ($this->db->execute()) {
            $this->db->query('SELECT fac.*, cta.iban AS numiban FROM facturascabecera fac
                            LEFT JOIN cuentasbancarias cta ON fac.iban=cta.idcuenta
                            WHERE fac.idfactura =' . $datos['idFactura']);
            $resultado = $this->db->registro();
            return ['true' => $resultado];
        } else {
            return 'false';
        }
    }


    /*public function cambiarEstadoAccionProyecto($datos)
    {
        //que haga un UPDATE en la tabla acciones_proyecto
        //se cambia el estatus de acciones_proyecto de 0(en ejecución) a 2(facturado)
        //importe actualizado (Precio final 2)
        $this->db->query('UPDATE acciones_proyecto
                        SET  estatus = :estatus, importeactual = :importeactual
                        WHERE idAccionProy = :idaccionproy');

        $this->db->bind(':estatus', 2);
        $this->db->bind(':idaccionproy', $datos['idaccproy']);
        $this->db->bind(':importeactual', $datos['importe']);

        if($this->db->execute()){
            return true;
        }else{     
            return false;
        }

    }*/

    public function obtenerDatosFactura($datos)
    {

        $this->db->query('SELECT fca.*, cli.NOMBREJURIDICO, cli.CIFCLIENTE, cli.DIRECCION, cli.LOCALIDAD, 
                        cli.PROVINCIA, cli.CODPOSTAL, af.idACCION,af.NOMBREACCION,
                        acp.idAccionPres, acp.horas, acc.fechaInicio, acc.fechaFin,
                        acp.participantes, cli.EMAIL, cli.mailcontacto, acc.idPresupuesto, ctas.iban AS numCuenta
                        FROM facturascabecera fca
                        LEFT JOIN acciones_proyecto acc ON fca.idaccionproy=acc.idAccionProy
                        LEFT JOIN acciones_presupuesto acp ON acc.idAccionPres=acp.idAccionPres
                        LEFT JOIN accionesformativas af ON acc.idACCION=af.idACCION                                     
                        LEFT JOIN empresasclientes cli ON fca.idempresa=cli.idEMPRESA
                        LEFT JOIN cuentasbancarias ctas ON fca.iban=ctas.idcuenta
                        WHERE fca.idfactura=' . $datos['idFactura']);
        $resultado = $this->db->registro();
        return $resultado;
    }

    public function obtenerDatosFacturaSegunNumFactura($numFactura)
    {

        $this->db->query('SELECT fca.*, cli.NOMBREJURIDICO, cli.CIFCLIENTE, cli.DIRECCION, cli.LOCALIDAD,acc.idProyecto, 
                        cli.PROVINCIA, cli.CODPOSTAL, af.idACCION,af.NOMBREACCION,
                        acp.idAccionPres, acp.horas, acc.fechaInicio, acc.fechaFin,
                        acp.participantes, cli.EMAIL, cli.mailcontacto, acc.idPresupuesto, ctas.iban AS numCuenta
                        FROM facturascabecera fca
                        LEFT JOIN acciones_proyecto acc ON fca.idaccionproy=acc.idAccionProy
                        LEFT JOIN acciones_presupuesto acp ON acc.idAccionPres=acp.idAccionPres
                        LEFT JOIN accionesformativas af ON acc.idACCION=af.idACCION                                     
                        LEFT JOIN empresasclientes cli ON fca.idempresa=cli.idEMPRESA
                        LEFT JOIN cuentasbancarias ctas ON fca.iban=ctas.idcuenta
                        WHERE fca.numfactura=:numfactura');
        
        $this->db->bind(':numfactura', $numFactura);
        $resultado = $this->db->registro();
        return $resultado;
    }



    public function actualizarPrecioFinal($datos)
    {
        $this->db->query('UPDATE acciones_proyecto
                        SET importeactual = :importeactual
                        WHERE idAccionProy = :idAccionProy ');

        $this->db->bind(':importeactual', $datos['precioFinal']);
        $this->db->bind(':idAccionProy', $datos['idAccionProy']);

        if ($this->db->execute()) {
            return $datos['precioFinal'];
        } else {
            return false;
        }
    }


    public function agregarCosteAcccionProyecto($datos)
    {
        $baseImp = $datos['importeFactura'];
        $iva = $datos['iva'];
        $cantidad = $datos['cantidad'];
        $irpf = $datos['irpf'];

        if ($iva && $iva > 0) {
            $valorIVA = $baseImp * $cantidad * $iva / 100;
        } else {
            $valorIVA = 0;
        }
        if ($irpf && $irpf > 0) {
            $valorIRPF = $baseImp * $cantidad * $irpf / 100;
        } else {
            $valorIRPF = 0;
        }
        $total = ($baseImp * $cantidad) + $valorIVA - $valorIRPF;

        $this->db->query(" INSERT INTO costesaccionproy (idaccionproy,fechacoste,importe,cantidad,iva,total,tipocoste,irpf,fechacobro,numfaccoste) 
        VALUES (:idAccionProy, :fecha, :importeFactura, :cantidad, :iva, :total, :tipoCoste, :irpf, :fechacobro, :numFacCoste)");

        $this->db->bind(':idAccionProy', $datos['idAccionProy']);
        $this->db->bind(':tipoCoste', $datos['tipoCoste']);
        $this->db->bind(':importeFactura', $datos['importeFactura']);
        $this->db->bind(':cantidad', $datos['cantidad']);
        $this->db->bind(':iva', $datos['iva']);
        $this->db->bind(':total', $total);
        $this->db->bind(':fecha', $datos['fecha']);
        $this->db->bind(':irpf', $datos['irpf']);
        $this->db->bind(':fechacobro', $datos['fechaCobro']); //se guarda, pero no es seguro que sea necesaria
        $this->db->bind(':numFacCoste', $datos['numFacCoste']);

        if ($this->db->execute()) {
            return $total;
        } else {
            return false;
        }
    }

    public function agregarGastoAcccionProyecto($datos)
    {

        $baseImp = $datos['importeGasto'];
        $iva = $datos['ivaGasto'];
        $irpf = $datos['irpf'];
        $cantidad = $datos['cantidadGasto'];

        if ($iva && $iva > 0) {
            $valorIVA = $baseImp * $cantidad * $iva / 100;
        } else {
            $valorIVA = 0;
        }
        if ($irpf && $irpf > 0) {
            $valorirpf = $baseImp * $cantidad * $irpf / 100;
        } else {
            $valorirpf = 0;
        }
        $total = round(($baseImp * $cantidad) + $valorIVA - $valorirpf, 2);

        $this->db->query(" INSERT INTO gastosaccionproy (idaccionproy,tipoGasto,tipoProveedor,razonSocial,importe,cantidad,iva,irpf,total,fecha,numfacgasto,descripcion,fechapago,iban, gastocomun) 
                        VALUES (:idAccionProy,:tipoGasto,:tipoProveedor,:razonSocial,:importeGasto,:cantidadGasto,:ivaGasto,:irpf,:totalGasto,:fechaGasto,:numfacgasto,:descripcion,:fechapago,:iban,:gastocomun)");

        $this->db->bind(':idAccionProy', $datos['idAccionProy']);
        $this->db->bind(':tipoGasto', $datos['tipoGasto']);
        $this->db->bind(':tipoProveedor', $datos['tipoProveedor']);
        $this->db->bind(':razonSocial', $datos['razonSocial']);
        $this->db->bind(':importeGasto', $datos['importeGasto']);
        $this->db->bind(':cantidadGasto', $datos['cantidadGasto']);
        $this->db->bind(':ivaGasto', $datos['ivaGasto']);
        $this->db->bind(':irpf', $datos['irpf']);
        $this->db->bind(':totalGasto', $total);
        $this->db->bind(':fechaGasto', $datos['fechaGasto']);
        $this->db->bind(':numfacgasto', $datos['numFacGasto']);
        $this->db->bind(':descripcion', $datos['descripcion']);
        $this->db->bind(':fechapago', $datos['fechaPago']);
        $this->db->bind(':iban', $datos['iban']);
        $this->db->bind(':gastocomun', $datos['comun']);

        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    public function insertarClientesGastosComun($datos)
    {
        $sql = 'INSERT INTO clientesgastosaccionproy ('.$datos['campos'].') VALUES ('.$datos['valores'].')';
        $this->db->query($sql);
        $this->db->execute();
    }

    public function obtenerProveedoresSelect()
    {
        $this->db->query("SELECT idPROVEEDOR AS id, PERSONAJURIDICA AS nombre  FROM proveedores");
        $resultado = $this->db->registros();
        return $resultado;
    }
    public function obtenerProfesoresSelect()
    {
        $this->db->query("SELECT idPROFESOR AS id, RAZONSOCIAL AS nombre  FROM profesores");
        $resultado = $this->db->registros();
        return $resultado;
    }
    public function obtenerColaboradoresSelect()
    {
        $this->db->query("SELECT codColaborador AS id, RazonSocial AS nombre FROM colaboradores");
        $resultado = $this->db->registros();
        return $resultado;
    }


    public function updateFichaProyecto($datos)
    {
        //obtengo el PK de la acciones que se van a actualizar
        /*$this->db->query("SELECT idAccionProy FROM acciones_proyecto
                        WHERE idPresupuesto = :idPresupuesto AND idACCION = :idAccion AND fechaInicio = :fechaIniOriginal");
        $this->db->bind(':idPresupuesto', $datos['idPresupuesto']);
        $this->db->bind(':idAccion', $datos['idAccion']);
        $this->db->bind(':fechaIniOriginal', $datos['fechaIniOriginal']);
        //$this->db->bind(':fechaInicio', $datos['fechaInicio']);
        $resultado = $this->db->registros();*/

        /*foreach ($resultado as $key) {         
            //Actualiza la tabla presupuesto
            $this->db->query('UPDATE acciones_proyecto
                            SET participantes = :participantes
                            WHERE idAccionProy ='.$key->idAccionProy);
            
            
            $this->db->execute();
           
        }*/

        //obtengo el idProyeto para actualizar la fecha en tabla proyectos:
        /*$this->db->query("SELECT idProyecto FROM proyectos
                        WHERE idPresupuesto = :idPresupuesto AND accionformativa = :idAccion AND fechaInicio = :fechaIniOriginal");
        $this->db->bind(':idPresupuesto', $datos['idPresupuesto']);
        $this->db->bind(':idAccion', $datos['idAccion']);
        $this->db->bind(':fechaIniOriginal', $datos['fechaIniOriginal']);
        $resultado = $this->db->registro();
        $idProyecto = $resultado->idProyecto;*/

        $this->db->query('UPDATE proyectos
                        SET  fechaInicio = :fechaInicio, fechaFin = :fechaFin, fechaIniFun = :fechaIniFun, fechaFinFun = :fechaFinFun,
                            mesBonificacion = :mesBonif, mananaIni = :mananaIni, mananaFin = :mananaFin, tardeIni = :tardeIni, 
                            tardeFin = :tardeFin, obsHorario = :obsHorario, hTeleformacion = :hTeleformacion, hPresencial = :hPresencial, 
                            obsFichaProy = :obsFichaProy, dias = :dias
                        WHERE idProyecto = :idProyecto');

        $this->db->bind(':idProyecto', $datos['idProyecto']);
        $this->db->bind(':fechaInicio', $datos['fechaInicio']);
        $this->db->bind(':fechaFin', $datos['fechaFin']);
        $this->db->bind(':fechaIniFun', $datos['fechaIniFun']);
        $this->db->bind(':fechaFinFun', $datos['fechaFinFun']);
        $this->db->bind(':mesBonif', $datos['mesBonif']);
        $this->db->bind(':mananaIni', $datos['mananaIni']);
        $this->db->bind(':mananaFin', $datos['mananaFin']);
        $this->db->bind(':tardeIni', $datos['tardeIni']);
        $this->db->bind(':tardeFin', $datos['tardeFin']);
        $this->db->bind(':obsHorario', $datos['obsHorario']);
        $this->db->bind(':hTeleformacion', $datos['hTeleformacion']);
        $this->db->bind(':hPresencial', $datos['hPresencial']);
        //$this->db->bind(':participantes', $datos['participantes']);
        $this->db->bind(':obsFichaProy', $datos['obsFichaProy']);
        $this->db->bind(':dias', $datos['dias']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //public function pruebaClientePdf($id){
    public function obtenerDatosPdfDiploma($id)
    {
        $this->db->query('SELECT par.*, emp.Nombre, emp.Apellido1, emp.Apellido2, emp.DocIdentidad,
                        emp.idEmpresa, cli.NOMBREJURIDICO, cli.CIFCLIENTE, pro.accionformativa, 
                        afo.NOMBREACCION, pro.fechaInicio, pro.fechaFin, apre.horas, apre.modalidad, 
                        moda.DESMODALIDAD AS nombreModalidad
                        FROM participantes par 
                        LEFT JOIN empleados emp ON par.IDEMPLEADO=emp.IdEmpleado
                        LEFT JOIN empresasclientes cli ON emp.idEmpresa=cli.idEMPRESA
                        LEFT JOIN proyectos pro ON par.IDPROYECTO=pro.idProyecto
                        LEFT JOIN accionesformativas afo ON pro.accionformativa=afo.idACCION
                        LEFT JOIN acciones_proyecto apro ON pro.idProyecto=apro.idProyecto
                        LEFT JOIN acciones_presupuesto apre ON apro.idAccionPres=apre.idAccionPres
                        LEFT JOIN modalidadesdeacciones moda ON apre.modalidad=moda.CODMODALIDAD
                        WHERE par.IDPARTICIPANTE=' . $id);
        $info = $this->db->registro();

        return $info;
    }

    public function exportarPdfDocProyecto($id, $cli)
    {

        $this->db->query('SELECT pro.idProyecto, par.*, emp.*
                        FROM proyectos pro
                        LEFT JOIN acciones_proyecto apr ON pro.idProyecto=apr.idProyecto
                        LEFT JOIN participantes par ON pro.idProyecto=par.IDPROYECTO
                        LEFT JOIN empleados emp ON par.IDEMPLEADO=emp.IdEmpleado
                        WHERE pro.idProyecto=' . $id . ' AND apr.idEMPRESA=' . $cli);
        $resultado = $this->db->registros();

        $this->db->query('SELECT pro.*, par.*, apr.idAccionProy, apr.idProyecto, apr.idPresupuesto, apr.idEMPRESA, 
        apr.idAccionPres, cli.NOMBREJURIDICO, afo.NOMBREACCION, prof.NOMBRECOMERCIAL AS profesor 
        FROM proyectos pro 
        LEFT JOIN participantes par ON pro.idProyecto=par.IDPROYECTO
        LEFT JOIN acciones_proyecto apr ON pro.idProyecto=apr.idProyecto
        LEFT JOIN empresasclientes cli ON apr.idEMPRESA=cli.idEMPRESA
        LEFT JOIN accionesformativas afo ON pro.accionformativa=afo.idACCION
        LEFT JOIN profesores prof ON pro.idProfesor=prof.idPROFESOR
                        WHERE pro.idProyecto=' . $id . ' AND apr.idEMPRESA=' . $cli . ' LIMIT 1');
        $resultado2 = $this->db->registro();


        $final = ['detalles' => $resultado, 'cabecera' => $resultado2];
        return $final;
    }

    public function asignarProfesorProyecto($datos)
    {

        $this->db->query("UPDATE proyectos 
                        SET idProfesor=:idProfesor, profesorInterno= :profInterno, obsProfesor= :obsProfesor 
                        WHERE idProyecto = :idProyecto ");

        $this->db->bind(':idProfesor', $datos['idProfesor']);
        $this->db->bind(':idProyecto', $datos['idProyecto']);
        $this->db->bind(':profInterno', $datos['profInterno']);
        $this->db->bind(':obsProfesor', $datos['obsProfesor']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function insertarRegistroFichero($nombre, $id, $tipo, $descripcion)
    {

        $this->db->query("INSERT INTO importarParticipantes (idProyecto,tipo,nombre,descripcion) 
                        VALUES (:idProyecto,:tipo,:nombre,:descripcion)");

        $this->db->bind(':idProyecto', $id);
        $this->db->bind(':tipo', $tipo);
        $this->db->bind(':nombre', $nombre);
        $this->db->bind(':descripcion', $descripcion);

        if ($this->db->execute()) {
            return $nombre;
        } else {
            return false;
        }
    }

    public function insertarParticipantesBDDesdeExcel($datos)
    {

        /*//valida si los datos existen:
        $this->db->query('SELECT * FROM productos');
        $resultado = $this->db->registros();

        $nuevos = 0;
        $antiguos = 0;
        $arrayNuevos=[];
        $arrayAntiguos=[];

        foreach ($resultado as $row) {
            $this->db->query('SELECT COUNT(*) AS contador FROM productos WHERE codigo='.$row->codigo);
            $resultado = $this->db->registro();
            //si el codigo no existe insertar el código
            if ($resultado->contador == 0) {
                $tmp=['codigo'=>$row->codigo];
                $arrayNuevos[]=$tmp;
                $nuevos++;
            }else if ($resultado->contador >0) { //si existe entonces solo actualizar
                $tmp=['codigo'=>$row->codigo];
                $arrayAntiguos[]=$tmp;
                $antiguos++;
            }
        }
        echo"arrayNuevos:";
        print_r($arrayNuevos);
        echo"<br>contador nuevos:";
        print_r($nuevos);
        echo"<br>arrayAntiguos:";
        print_r($arrayAntiguos);
        echo"<br>contador antiguos:";
        print_r($antiguos);
        */


        //inserta los datos
        $participantesImpor = 0;
        foreach ($datos as $key) {

            $this->db->query('INSERT INTO empleados (DocIdentidad, Nombre, Apellido1, Apellido2,FechaNacimiento,Correo,Telefono,NumSegSocial,Sexo,NivelEstudios,categoria,
            grupoCotizacion,Discapacidad,terrorismo,violenciaGenero,fechaAlta,numPatronal,idProyecto)
                            VALUES (:DocIdentidad,:Nombre,:Apellido1,:Apellido2,:FechaNacimiento,:Correo,:Telefono,:NumSegSocial,:Sexo,:NivelEstudios,:categoria,
            :grupoCotizacion,:Discapacidad,:terrorismo,:violenciaGenero,:fechaAlta,:numPatronal,:idProyecto)');

            $this->db->bind(':DocIdentidad', $key['dni']);
            $this->db->bind(':Nombre', $key['nombre']);
            $this->db->bind(':Apellido1', $key['apellido1']);
            $this->db->bind(':Apellido2', $key['apellido2']);
            $this->db->bind(':FechaNacimiento', $key['fechaNacimiento']);
            $this->db->bind(':Correo', $key['email']);
            $this->db->bind(':Telefono', $key['Telefono']);
            $this->db->bind(':NumSegSocial', $key['numSocial']);
            $this->db->bind(':Sexo', $key['sexo']);
            $this->db->bind(':NivelEstudios', $key['nivelEstudio']);
            $this->db->bind(':categoria', $key['catProfesional']);
            $this->db->bind(':grupoCotizacion', $key['grupoCotizacion']);
            $this->db->bind(':Discapacidad', $key['discapacidad']);
            $this->db->bind(':terrorismo', $key['terrorismo']);
            $this->db->bind(':violenciaGenero', $key['violenciaGenero']);
            $this->db->bind(':fechaAlta', $key['fechaAlta']);
            $this->db->bind(':numPatronal', $key['numPatronal']);
            $this->db->bind(':idProyecto', $key['idProyecto']);

            $this->db->execute();


            //buscar último insert
            $this->db->query('SELECT idEmpleado FROM empleados  
                            WHERE idEmpleado = (SELECT max(idEmpleado) FROM empleados)');
            $ult = $this->db->registro();
            $ultEmp = $ult->idEmpleado;


            $this->db->query('INSERT INTO participantes (IDPROYECTO, IDEMPLEADO)
                            VALUES (:IDPROYECTO,:IDEMPLEADO)');
            $this->db->bind(':IDPROYECTO', $key['idProyecto']);
            $this->db->bind(':IDEMPLEADO', $ultEmp);
            $this->db->execute();


            $participantesImpor++;
        }

        return $participantesImpor++;
    }


    public function adicionarParticipanteNuevo($datos, $idProyecto)
    {

        //inserto enempleados
        $this->db->query('INSERT INTO empleados (DocIdentidad, Nombre, Apellido1, Apellido2,FechaNacimiento,Correo,Telefono,NumSegSocial,Sexo,NivelEstudios,categoria,
        grupoCotizacion,Discapacidad,terrorismo,violenciaGenero,fechaAlta,numPatronal,idProyecto)
                        VALUES (:DocIdentidad,:Nombre,:Apellido1,:Apellido2,:FechaNacimiento,:Correo,:Telefono,:NumSegSocial,:Sexo,:NivelEstudios,:categoria,
        :grupoCotizacion,:Discapacidad,:terrorismo,:violenciaGenero,:fechaAlta,:numPatronal,:idProyecto)');

        $this->db->bind(':DocIdentidad', $datos['dni']);
        $this->db->bind(':Nombre', $datos['nombre']);
        $this->db->bind(':Apellido1', $datos['apellido1']);
        $this->db->bind(':Apellido2', $datos['apellido2']);
        $this->db->bind(':FechaNacimiento', $datos['fechaNacimiento']);
        $this->db->bind(':Correo', $datos['email']);
        $this->db->bind(':Telefono', $datos['telefono']);
        $this->db->bind(':NumSegSocial', $datos['numSocial']);
        $this->db->bind(':Sexo', $datos['sexo']);
        $this->db->bind(':NivelEstudios', $datos['nivelEstudios']);
        $this->db->bind(':categoria', $datos['catProfesional']);
        $this->db->bind(':grupoCotizacion', $datos['grupoCotizacion']);
        $this->db->bind(':Discapacidad', $datos['discapacidad']);
        $this->db->bind(':terrorismo', $datos['terrorismo']);
        $this->db->bind(':violenciaGenero', $datos['violenciaGenero']);
        $this->db->bind(':fechaAlta', $datos['fechaAlta']);
        $this->db->bind(':numPatronal', $datos['numPatronal']);
        $this->db->bind(':idProyecto', $idProyecto);

        $this->db->execute();



        //buscar último insert
        $this->db->query('SELECT idEmpleado FROM empleados  
                WHERE idEmpleado = (SELECT max(idEmpleado) FROM empleados)');
        $ult = $this->db->registro();
        $ultEmp = $ult->idEmpleado;

        //inserto en los participantes proyecto
        $this->db->query('INSERT INTO participantes (IDPROYECTO, IDEMPLEADO)
                VALUES (:IDPROYECTO,:IDEMPLEADO)');
        $this->db->bind(':IDPROYECTO', $idProyecto);
        $this->db->bind(':IDEMPLEADO', $ultEmp);
        $this->db->execute();

        //busco los datos del participante creado        
        $this->db->query('SELECT par.*, emp.DocIdentidad, emp.Nombre, emp.Apellido1, emp.Apellido2, par.OBSEMPLEADO, emp.Telefono, emp.idEmpresa, cli.NOMBREJURIDICO 
                        FROM participantes par
                        LEFT JOIN empleados emp ON par.IDEMPLEADO=emp.IdEmpleado
                        LEFT JOIN empresasclientes cli ON emp.idEmpresa = cli.idEMPRESA
                        WHERE par.IDEMPLEADO= :id');
        $this->db->bind(':id', $ultEmp);
        $participante = $this->db->registro();
        return $participante;
        //print json_encode($participante, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
    }

    public function listarParticipantes($idProyecto)
    {
        //busco los datos del participante creado        
        $this->db->query('SELECT par.*, emp.DocIdentidad, emp.Nombre, emp.Apellido1, emp.Apellido2, par.OBSEMPLEADO, emp.Telefono, emp.idEmpresa, cli.NOMBREJURIDICO 
                        FROM participantes par
                        LEFT JOIN empleados emp ON par.IDEMPLEADO=emp.IdEmpleado
                        LEFT JOIN empresasclientes cli ON emp.idEmpresa = cli.idEMPRESA 
                        WHERE par.IDPROYECTO= :idProyecto');
        $this->db->bind(':idProyecto', $idProyecto);
        $participantes = $this->db->registros();
        return $participantes;

        //print json_encode($participantes, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
    }

    public function actualizarParticipante($datos,$idParticipante)
    {

      
        //busco el idEmpleado
        $this->db->query('SELECT IDEMPLEADO from participantes WHERE IDPARTICIPANTE= :id ');
        $this->db->bind(':id', $idParticipante);
        $row = $this->db->registro();
        $idEmpleado = $row->IDEMPLEADO;

        //actualizamos los empleados
        $this->db->query("UPDATE empleados 
                        SET DocIdentidad = :docIdentidad, Nombre = :nombre, Apellido1 = :apellido1, Apellido2 = :apellido2, Telefono = :telefono, Correo = :correo,
                        FechaNacimiento = :fechaNacimiento, Discapacidad = :discapacidad,Sexo = :sexo ,NumSegSocial = :numSocial, Categoria = :categoria, NivelEstudios = :nivelEstudios,
                        terrorismo = :terrorismo, violenciaGenero = :violenciaGenero, fechaAlta = :fechaAlta, numPatronal = :numPatronal, grupoCotizacion = :grupoCotizacion 
                        WHERE idEmpleado = :id ");

        $this->db->bind(':docIdentidad', $datos['dni']);
        $this->db->bind(':nombre', $datos['nombre']);
        $this->db->bind(':apellido1', $datos['apellido1']);
        $this->db->bind(':apellido2', $datos['apellido2']);
        $this->db->bind(':telefono', $datos['telefono']);
        $this->db->bind(':correo', $datos['email']);
        $this->db->bind(':fechaNacimiento', $datos['fechaNacimiento']);
        $this->db->bind(':discapacidad', $datos['discapacidad']);
        $this->db->bind(':numSocial', $datos['numSocial']);
        $this->db->bind(':sexo', $datos['sexo']);
        $this->db->bind(':categoria', $datos['catProfesional']);
        $this->db->bind(':nivelEstudios', $datos['nivelEstudios']);
        $this->db->bind(':terrorismo', $datos['terrorismo']);
        $this->db->bind(':violenciaGenero', $datos['violenciaGenero']);
        $this->db->bind(':fechaAlta', $datos['fechaAlta']);
        $this->db->bind(':grupoCotizacion', $datos['grupoCotizacion']);
        $this->db->bind(':numPatronal', $datos['numPatronal']);
        $this->db->bind(':id', $idEmpleado);
        $this->db->execute();

        //busco los datos del participante creado        
        $this->db->query('SELECT par.*, emp.*
                        FROM participantes par
                        LEFT JOIN empleados emp ON par.IDEMPLEADO=emp.IdEmpleado
                        LEFT JOIN empresasclientes cli ON emp.idEmpresa = cli.idEMPRESA
                        WHERE par.IDEMPLEADO= :id');
        $this->db->bind(':id', $idEmpleado);
        $participante = $this->db->registro();
        return $participante;
    }

    public function eliminarParticipante($datos)
    {

        $this->db->query("DELETE FROM participantes where IDPARTICIPANTE = :id");
        $this->db->bind(':id', $datos['alumno_id']);
        $this->db->execute();
        return true;
    }

    public function cargarEmpleados()
    {

        $this->db->query('SELECT idEmpleado as Id, concat(idEmpleado,"-",DocIdentidad,"-",Nombre," ",Apellido1," ",Apellido2) as informacion from empleados');
        $participante = $this->db->registros();
        return $participante;
    }

    public function agregarParticipantesDeBD($datos)
    {

        //inserto en los participantes proyecto
        $this->db->query('INSERT INTO participantes (IDPROYECTO, IDEMPLEADO)
                VALUES (:IDPROYECTO,:IDEMPLEADO)');
        $this->db->bind(':IDPROYECTO', $datos['idProyecto']);
        $this->db->bind(':IDEMPLEADO',$datos['idEmpleado']);
        $this->db->execute();

        //buscar último insert
        $this->db->query('SELECT IDPARTICIPANTE FROM participantes  
                WHERE IDPARTICIPANTE = (SELECT max(IDPARTICIPANTE) FROM participantes)');
        $ult = $this->db->registro();
        $ultimo = $ult->IDPARTICIPANTE;


        //busco los datos del participante creado        
        $this->db->query('SELECT par.*, emp.DocIdentidad, emp.Nombre, emp.Apellido1, emp.Apellido2, par.OBSEMPLEADO, emp.Telefono, emp.idEmpresa, cli.NOMBREJURIDICO 
                        FROM participantes par
                        LEFT JOIN empleados emp ON par.IDEMPLEADO=emp.IdEmpleado
                        LEFT JOIN empresasclientes cli ON emp.idEmpresa = cli.idEMPRESA
                        WHERE par.IDPARTICIPANTE = :id');
        $this->db->bind(':id', $ultimo);
        $participante = $this->db->registro();
        return $participante;
    }


    //-------------------


    public function listarDocsProyecto($datos)
    {
        //busco los datos del participante creado        
        $this->db->query('SELECT * FROM proyectoDocs
                        WHERE idProyecto= :idProyecto');
        $this->db->bind(':idProyecto', $datos['idProyecto']);
        $ficheros = $this->db->registros();
        return $ficheros;
    }

    public function insertarRegistroFicheroProyecto($nombre, $id, $tipo, $descripcion)
    {
        $this->db->query("INSERT INTO proyectoDocs (idProyecto ,tipo,nombre,descripcion) 
                        VALUES (:idProyecto,:tipo,:nombre,:descripcion)");

        $this->db->bind(':idProyecto', $id);
        $this->db->bind(':tipo', $tipo);
        $this->db->bind(':nombre', $nombre);
        $this->db->bind(':descripcion', $descripcion);

        if ($this->db->execute()) {
            return $nombre;
        } else {
            return false;
        }
    }

    public function obtenerUltimoIdDocProyecto()
    {
        //buscar último insert
        $this->db->query('SELECT idDocumento FROM proyectoDocs  
        WHERE idDocumento = (SELECT max(idDocumento) FROM proyectoDocs)');
        $ult = $this->db->registro();
        $ultimo = $ult->idDocumento + 1;
        return $ultimo;
    }

    public function eliminarDocsProyecto($datos)
    {
        //busco documento de la BBDD
        $this->db->query("DELETE FROM proyectoDocs where idDocumento = :idDocumento");

        $this->db->bind(':idDocumento', $datos['idDocumento']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }



    public function actualizarHorasEnPresupuestoYProyecto($idProyecto, $horas, $presenciales, $teleformacion, $aulaVirtual)
    {
        //1- actualizo en la tabla proyectos
        $q = "UPDATE proyectos 
                SET horas = :horas, hPresenciales = :hPresenciales, hTeleformacion = :hTeleformacion, 
                    hAulaVirtual = :hAulaVirtual
                WHERE idProyecto = :idProyecto";
        $this->db->query($q);
        $this->db->bind(':horas', $horas);
        $this->db->bind(':hPresenciales', $presenciales);
        $this->db->bind(':hTeleformacion', $teleformacion);
        $this->db->bind(':hAulaVirtual', $aulaVirtual);
        $this->db->bind(':idProyecto', $idProyecto);
        $this->db->execute();

        //2- traigo los idAccionPres vinculadas al proyecto para actualizar las horas en la tabla acciones_presupuesto
        $this->db->query("SELECT apro.idAccionPres FROM acciones_proyecto apro WHERE apro.idProyecto=" . $idProyecto);
        $resultado = $this->db->registros();

        //3- actualizo la tabla acciones_presupuesto
        foreach ($resultado as $key) {
            $q = "UPDATE acciones_presupuesto 
                    SET horas = :horas, hPresenciales = :hPresenciales, hTeleformacion = :hTeleformacion, 
                        hAulaVirtual = :hAulaVirtual
                    WHERE idAccionPres = :idAccionPres";
            $this->db->query($q);
            $this->db->bind(':horas', $horas);
            $this->db->bind(':hPresenciales', $presenciales);
            $this->db->bind(':hTeleformacion', $teleformacion);
            $this->db->bind(':hAulaVirtual', $aulaVirtual);
            $this->db->bind(':idAccionPres', $key->idAccionPres);
            $this->db->execute();
        }
        return true;
    }


    public function actualizarParticipantesEnPresupuesto($idAccionPres, $participantes)
    {
        $q = "UPDATE acciones_presupuesto 
            SET participantes = :participantes
            WHERE idAccionPres = :idAccionPres";

        $this->db->query($q);
        $this->db->bind(':idAccionPres', $idAccionPres);
        $this->db->bind(':participantes', $participantes);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function actualizarDatosFactura($datos)
    {

        $tabla = $datos['tabla'];
        $campo = $datos['campo'];
        $pk = $datos['pk'];
        $sql = "UPDATE $tabla SET  $campo =  '" . $datos['valor'] . "'  WHERE  $pk = '" . $datos['idfactura'] . "' ";

        $this->db->query($sql);
        //Ejecutar
        if ($this->db->execute()) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function actualizarConceptoFactura($datos)
    {
        $q = "UPDATE facturascabecera 
            SET concepto = :concepto
            WHERE idfactura = :idfactura";

        $this->db->query($q);
        $this->db->bind(':idfactura', $datos['idFactura']);
        $this->db->bind(':concepto', $datos['concepto']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function datosDeAccionProyectoPorId($idAccionProy)
    {
        $this->db->query("SELECT apro.*, apre.*, acc.NOMBREACCION,
                        DATE_FORMAT(pro.fechaInicio, '%d/%m/%Y') AS fechaInicio , 
                        DATE_FORMAT(pro.fechaFin , '%d/%m/%Y') AS fechaFin 
                        FROM acciones_proyecto apro 
                        LEFT JOIN acciones_presupuesto apre ON apro.idAccionPres=apre.idAccionPres
                        LEFT JOIN accionesformativas acc ON apre.idACCION=acc.idACCION
                        LEFT JOIN proyectos pro ON apro.idProyecto=pro.idProyecto
                        WHERE apro.idAccionProy=" . $idAccionProy);
        $resultado = $this->db->registro();
        return $resultado;
    }

    public function obtenerDatosTodosIngresosProyecto($idProyecto)
    {


        $this->db->query("SELECT pro.idProyecto, apro.idAccionProy, fac.*, cli.NOMBREJURIDICO
                        FROM proyectos pro
                        LEFT JOIN acciones_proyecto apro ON pro.idProyecto=apro.idProyecto
                        LEFT JOIN facturascabecera fac ON apro.idAccionProy=fac.idaccionproy
                        LEFT JOIN empresasclientes cli ON apro.idEMPRESA=cli.idEMPRESA
                        WHERE pro.idProyecto=" . $idProyecto);

        $resultado = $this->db->registros();

        return $resultado;
    }

    public function listadoCompletoIngresosYGastosProyecto($idProyecto)
    {
        
        $this->db->query("SELECT * FROM (
            SELECT pro.idProyecto, apro.idAccionProy, cli.NOMBREJURIDICO, fac.idfactura AS id, 'ingreso' AS tipo,
            fac.numfactura,fac.importe, fac.cantidad, fac.iva, 'irpf' AS irpf,  fac.total, fac.idempresa
                                FROM proyectos pro
                                LEFT JOIN acciones_proyecto apro ON pro.idProyecto=apro.idProyecto
                                LEFT JOIN facturascabecera fac ON apro.idAccionProy=fac.idaccionproy
                                LEFT JOIN empresasclientes cli ON apro.idEMPRESA=cli.idEMPRESA
                                WHERE pro.idProyecto=".$idProyecto."
                                
            
            UNION ALL
        
            SELECT pro.idProyecto, apro.idAccionProy, cli.NOMBREJURIDICO, gas.idgasto AS id, 'gasto' AS tipo,
            gas.numfacgasto, gas.importe, gas.cantidad, gas.iva, gas.irpf, gas.total, cli.idEMPRESA
                FROM proyectos pro
                LEFT JOIN acciones_proyecto apro ON pro.idProyecto=apro.idProyecto
                LEFT JOIN gastosaccionproy gas ON apro.idAccionProy=gas.idaccionproy
                LEFT JOIN empresasclientes cli ON apro.idEMPRESA=cli.idEMPRESA
                WHERE pro.idProyecto=".$idProyecto." AND gas.importe >0
                
                ) as unido
                WHERE unido.id IS NOT null
                ORDER BY unido.NOMBREJURIDICO ASC, tipo DESC  ");

        $resultado = $this->db->registros();

        return $resultado;
    }

    public function obtenerDatosTodosGastosProyecto($idProyecto)
    {
        $this->db->query("SELECT pro.idProyecto, apro.idAccionProy, gas.*, cli.NOMBREJURIDICO
        FROM proyectos pro
        LEFT JOIN acciones_proyecto apro ON pro.idProyecto=apro.idProyecto
        LEFT JOIN gastosaccionproy gas ON apro.idAccionProy=gas.idaccionproy
        LEFT JOIN empresasclientes cli ON apro.idEMPRESA=cli.idEMPRESA
        WHERE pro.idProyecto=" . $idProyecto);


        $resultado = $this->db->registros();

        return $resultado;
    }

    public function insertarDatosEmail($datosFactura,$asunto,$mensaje,$emailsJSON)
    {


        $this->db->query("INSERT INTO emailCliente (idEMPRESA,email,subject,contenido,fecha,desde,proceso,numeroproceso,procedimiento,numeroProcedimiento) VALUES (:idEmpresa,:emails,:asunto,:contenido,:fecha,:correo,'proyecto',:idProyecto,'facturaingreso',:idFactura)");
        $this->db->bind(":idEmpresa",$datosFactura->idempresa);
        $this->db->bind(":emails",$emailsJSON);
        $this->db->bind(":asunto",$asunto);
        $this->db->bind(":contenido",$mensaje);
        $this->db->bind(":fecha",date("Y/m/d"));
        $this->db->bind(":correo",$_SESSION['mail']);
        $this->db->bind(":idProyecto",$datosFactura->idProyecto);
        $this->db->bind(":idFactura",$datosFactura->idfactura);

        $this->db->execute();
    }

    public function obtenerEmailsByIdProyecto($idProyecto)
    {

        $this->db->query("SELECT ag.Nombre,emc.NOMBREJURIDICO, ec.* FROM emailCliente ec left JOIN agentes ag on ec.desde=ag.mail   
        LEFT JOIN empresasclientes emc ON ec.idEMPRESA = emc.idEMPRESA  where numeroproceso=".$idProyecto);


        $resultado = $this->db->registros();

        return $resultado; 

    }

    public function obtenerEmailsByIdCliente($salida)
    {

        $this->db->query("SELECT ag.Nombre,emc.NOMBREJURIDICO, ec.* FROM emailCliente ec left JOIN agentes ag on ec.desde=ag.mail   
        LEFT JOIN empresasclientes emc ON ec.idEMPRESA = emc.idEMPRESA  where numeroproceso=".$salida['idProyecto']." AND ec.idEMPRESA = ".$salida['idCliente']);


        $resultado = $this->db->registros();

        return $resultado; 

    }

    public function obtenerDatosEmailFactura($idEmail)
    {
        $this->db->query("SELECT * FROM emailCliente ec where idEmail =".$idEmail);


        $resultado = $this->db->registro();

        return $resultado; 
    }

   public function generarDatosBalance($idProyecto)
   {

    $datos=[

        "importeIngresos" => $this->baseImponible($idProyecto,false),
        "importeGastos" => $this->baseImponible($idProyecto,true),
        "ivaIngresos" => $this->iva($idProyecto,false),
        "ivaGastos" => $this->iva($idProyecto,true),
        "irpf" => $this->irpf($idProyecto),
        "totalIngresos" => $this->total($idProyecto,false),
        "totalGastos" =>  $this->total($idProyecto,true),
        "importeNegativa" =>  $this->baseImponibleNegativa($idProyecto),
        "ivaNegativa" =>  $this->ivaNegativa($idProyecto),
        "totalNegativa"=> $this->totalNegativa($idProyecto),

    ];

    return $datos;
       
   }

   public function baseImponible($idProyecto,$gastos=false){

    if(!$gastos){

        $this->db->query("SELECT SUM(fas.importe*fas.cantidad) as baseImponibleIngresos 
        FROM proyectos pro
        LEFT JOIN acciones_proyecto apro ON pro.idProyecto=apro.idProyecto
        LEFT JOIN facturascabecera fas ON apro.idAccionProy=fas.idaccionproy
        LEFT JOIN empresasclientes cli ON apro.idEMPRESA=cli.idEMPRESA
        WHERE fas.importe>0 and pro.idProyecto=" . $idProyecto);


        $resultado = $this->db->registro();

        return $resultado->baseImponibleIngresos;
    }else{

        $this->db->query("SELECT SUM(gas.importe*gas.cantidad) as baseImponibleGastos
        FROM proyectos pro
        LEFT JOIN acciones_proyecto apro ON pro.idProyecto=apro.idProyecto
        LEFT JOIN gastosaccionproy gas ON apro.idAccionProy=gas.idaccionproy
        LEFT JOIN empresasclientes cli ON apro.idEMPRESA=cli.idEMPRESA
        WHERE gas.importe>0 and pro.idProyecto=" . $idProyecto);


        $resultado = $this->db->registro();

        return $resultado->baseImponibleGastos;

    }

   }

   public function baseImponibleNegativa($idProyecto)
   {

    $this->db->query("SELECT SUM(fas.importe*fas.cantidad) as baseImponibleIngresosNegativo 
        FROM proyectos pro
        LEFT JOIN acciones_proyecto apro ON pro.idProyecto=apro.idProyecto
        LEFT JOIN facturascabecera fas ON apro.idAccionProy=fas.idaccionproy
        LEFT JOIN empresasclientes cli ON apro.idEMPRESA=cli.idEMPRESA
        WHERE fas.importe<0 and pro.idProyecto=" . $idProyecto);


        $resultado = $this->db->registro();

        return $resultado->baseImponibleIngresosNegativo;

   }

   public function iva($idProyecto,$gastos=false)
   {

    if(!$gastos){

        $this->db->query("SELECT SUM((fas.importe*fas.cantidad*fas.iva)/100) as ivaIngresos 
        FROM proyectos pro
        LEFT JOIN acciones_proyecto apro ON pro.idProyecto=apro.idProyecto
        LEFT JOIN facturascabecera fas ON apro.idAccionProy=fas.idaccionproy
        LEFT JOIN empresasclientes cli ON apro.idEMPRESA=cli.idEMPRESA
        WHERE fas.importe>0 and pro.idProyecto=" . $idProyecto);


        $resultado = $this->db->registro();

        return $resultado->ivaIngresos;
    }else{

        $this->db->query("SELECT SUM((gas.importe*gas.cantidad*gas.iva)/100) as ivaGastos
        FROM proyectos pro
        LEFT JOIN acciones_proyecto apro ON pro.idProyecto=apro.idProyecto
        LEFT JOIN gastosaccionproy gas ON apro.idAccionProy=gas.idaccionproy
        LEFT JOIN empresasclientes cli ON apro.idEMPRESA=cli.idEMPRESA
        WHERE gas.importe>0 and pro.idProyecto=" . $idProyecto);


        $resultado = $this->db->registro();

        return $resultado->ivaGastos;

    }



   }

   public function ivaNegativa($idProyecto)
   {

    $this->db->query("SELECT SUM((fas.importe*fas.cantidad*fas.iva)/100) as ivaIngresos 
    FROM proyectos pro
    LEFT JOIN acciones_proyecto apro ON pro.idProyecto=apro.idProyecto
    LEFT JOIN facturascabecera fas ON apro.idAccionProy=fas.idaccionproy
    LEFT JOIN empresasclientes cli ON apro.idEMPRESA=cli.idEMPRESA
    WHERE fas.importe<0 and pro.idProyecto=" . $idProyecto);


    $resultado = $this->db->registro();

    return $resultado->ivaIngresos;

   }

   public function irpf($idProyecto)
   {

    $this->db->query("SELECT SUM((gas.importe*gas.cantidad*gas.irpf)/100) as irpf
        FROM proyectos pro
        LEFT JOIN acciones_proyecto apro ON pro.idProyecto=apro.idProyecto
        LEFT JOIN gastosaccionproy gas ON apro.idAccionProy=gas.idaccionproy
        LEFT JOIN empresasclientes cli ON apro.idEMPRESA=cli.idEMPRESA
        WHERE gas.importe>0 and pro.idProyecto=" . $idProyecto);


        $resultado = $this->db->registro();

        return $resultado->irpf;

   }

   public function total($idProyecto,$gastos=false){


    if(!$gastos){

        $this->db->query("SELECT SUM(fas.total) as totalIngresos 
        FROM proyectos pro
        LEFT JOIN acciones_proyecto apro ON pro.idProyecto=apro.idProyecto
        LEFT JOIN facturascabecera fas ON apro.idAccionProy=fas.idaccionproy
        LEFT JOIN empresasclientes cli ON apro.idEMPRESA=cli.idEMPRESA
        WHERE fas.importe>0 and pro.idProyecto=" . $idProyecto);


        $resultado = $this->db->registro();

        return $resultado->totalIngresos;
    }else{

        $this->db->query("SELECT SUM(gas.total) as totalGastos
        FROM proyectos pro
        LEFT JOIN acciones_proyecto apro ON pro.idProyecto=apro.idProyecto
        LEFT JOIN gastosaccionproy gas ON apro.idAccionProy=gas.idaccionproy
        LEFT JOIN empresasclientes cli ON apro.idEMPRESA=cli.idEMPRESA
        WHERE gas.importe>0 and pro.idProyecto=" . $idProyecto);


        $resultado = $this->db->registro();

        return $resultado->totalGastos;

    }

   }

   public function totalNegativa($idProyecto)
   {
    $this->db->query("SELECT SUM(fas.total) as totalIngresos 
    FROM proyectos pro
    LEFT JOIN acciones_proyecto apro ON pro.idProyecto=apro.idProyecto
    LEFT JOIN facturascabecera fas ON apro.idAccionProy=fas.idaccionproy
    LEFT JOIN empresasclientes cli ON apro.idEMPRESA=cli.idEMPRESA
    WHERE fas.importe<0 and pro.idProyecto=" . $idProyecto);


    $resultado = $this->db->registro();

    return $resultado->totalIngresos;
   }

   public function cargarContactos($idfactura)
   {
       
    $this->db->query("SELECT idContacto, mail as datos
    FROM contactos co
    left join facturascabecera fac on co.idEMPRESA = fac.idempresa
    WHERE  fac.idfactura=" . $idfactura);

    $resultado = $this->db->registros();

    return $resultado;
       

   }

   public function eliminarGasto($idgasto)
   {
    $this->db->query("DELETE from gastosaccionproy where idgasto=".$idgasto);
    $this->db->execute();
   }

   public function eliminarGastoCliente($idgasto)
   {
    $this->db->query("DELETE from clientesgastosaccionproy where idGasto=".$idgasto);
    $this->db->execute();
   }

   public function obtenerNivelEstudios()
   {
    $this->db->query("SELECT * from nivelestudios");

    $resultado = $this->db->registros();

    return $resultado;
   }

   public function obtenerCategoriaProfesional()
   {
    $this->db->query("SELECT * from categoriasseguridadsocial");

    $resultado = $this->db->registros();

    return $resultado;
   }

   public function obtenerGruposCotizacion()
   {
    $this->db->query("SELECT * from cotizacion");

    $resultado = $this->db->registros();

    return $resultado;
   }

   public function obtenerDatosParticipante($idParticipante)
   {
    $this->db->query('SELECT IDEMPLEADO from participantes WHERE IDPARTICIPANTE= :id ');
    $this->db->bind(':id', $idParticipante);
    $row = $this->db->registro();
    $idEmpleado = $row->IDEMPLEADO;


    $this->db->query('SELECT * from empleados WHERE idEmpleado= :id ');
    $this->db->bind(':id', $idEmpleado);
    $datos = $this->db->registro();

    return $datos;

   }

}
