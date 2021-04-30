<?php require(RUTA_APP . '/views/includes/header2.php');

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Presupuesto</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Presupuesto</li>
                    </ol>
                </div>

        
                <?php                    
                //control de mensajes de error o éxito:
                if(isset($_SESSION['message'])){
                    if( strpos( $_SESSION['message'], 'corréctamente' ) != false ){
                ?>
                        <div class="alert alert-dismissible alert-success" style="margin-top:20px;">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <?php echo $_SESSION['message']; ?>
                        </div>
                <?php
                        } else {
                ?>
                        <div class="alert alert-dismissible alert-danger" style="margin-top:20px;">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $_SESSION['message']; ?>
                        </div>
                        <?php
                        }
                        unset($_SESSION['message']);
                    }
                ?>



            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="row">    

            <!-- EDITAR PRESUPUESTO -->
            <div class="col-lg-12" style="margin:0 auto">
                <div class="card card-primary edPres">
                    <div class="" id="">
                        <div class="card card-warning card-outline ">
                            <form action="<?php echo RUTA_URL;?>/presupuesto/editarPresupuesto" id="formularioEdicionPresupuesto" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="actualizarProyecto" id="actualizarProyecto" value="">
                                <input type="hidden" name="crearProyecto" id="crearProyecto" value="">
                                <input type="hidden" name="visualizarProyecto" id="visualizarProyecto" value="">
                                <input type="hidden" name="ruta" id="ruta" value="<?php echo RUTA_URL;?>">
                                <div class="card-header">
                                    <h3 class="card-title tituloEditarPresup flex-grow-1 align-self-center mr-3">Editar Presupuesto</h3>
                                    <a href="<?php echo RUTA_URL."/presupuesto" ;?>" class="btn btn-default" style="float:right">Volver</a>
                                    <input type="submit" id="Guardar" value="Guardar" class="btn btn-success mr-2" style="float:right">                                                    
                                </div>                            
                                <div class="card-body">
                                    <div class="form-group row">
                                        <?php
                                            $cabecera = $datos['info']['cabecera'][0];                                                                                                                              
                                            echo"                                        
                                            <div class='col-md-1'>
                                                <label for='idEdit'>Nº</label>
                                                <input id='idEdit' type='text' name='id' class='form-control' value='".$cabecera->idPresupuesto."' readonly>
                                            </div>
                                            <div class='col-md-3'>
                                                <label for='nombrePres'>Nombre Presupuesto</label>
                                                <input id='nombrePresEdit' type='text' class='form-control' name='nombrePresEdit' value='".$cabecera->nombrePres."'>
                                            </div>                                                                                     
                                            <div class='col-md-2'>
                                                <label for='tipoPresServEdit'>Servicio</label>
                                                <input id='servicios' type='text' name='tipoPresServEdit' class='form-control' value='".$cabecera->nombreS."' data-idServicio='".$cabecera->idServicios."' readonly>
                                            </div>
                                            <div class='col-md-2'>
                                                <label>Fecha Presup.</label>
                                                <input class='form-control' type='date' name='fechaEdit' id='fechaEdit' value='".$cabecera->fecha."' readonly>                                                                                             
                                            </div>
                                            <div class='col-md-2'>
                                                <label for='tipoPresupuesto'>Tipo Plantilla</label>
                                                <select id='tipoPresupuesto' class='form-control' name='tipoPesupuesto'>
                                                    <option>&nbsp;</option>";
                                                    foreach ($datos['plantillas'] as $plantilla) {
                                                        echo"
                                                        <option value='".$plantilla->id."'  ".(($plantilla->id == $cabecera->idPlantilla )? 'selected':'' ).">".$plantilla->tipoPlantilla."</option>";
                                                    }
                                                    echo"
                                                </select>
                                            </div>
                                            <div class='col-md-2'>
                                                <label for='asignaAgente'>Agente</label>
                                                <div class='asignaAgente'>
                                                    <select class='form-control select2' id='asignaAgenteEdit' name='asignaAgenteEdit'>
                                                        <option>&nbsp;</option>";
                                                        foreach ($datos['agentes'] as $agente) {
                                                        echo"
                                                        <option value='".$agente->id."' ".(($agente->id == $cabecera->codagente )? 'selected':'' )." >".$agente->nombreAgente."</option>";
                                                        }
                                                    echo"
                                                    </select>                                                
                                                </div>
                                            </div>                             
                                    </div>";
                                    ?>
                                    <div class="form-group row pl-2">
                                        <!--<a class="add_button flex-grow-1" title="Add field"><i class="fa fa-plus" aria-hidden="true"></i></a>-->
                                        <div class="d-flex justify-content-start flex-grow-1">
                                            <a  class="add_fila" title="Agregar Empresas/Acciones"><i class="fas fa-plus-square"></i></a>                                           
                                        </div>
                                        <button id="btnExportFila" type="submit" class="btn btn-danger mr-1" style="color:white;float:right;" title="Exportar pdf"><i class="fas fa-file-pdf"></i></button>
                                        <button id="btnEnviarFila" type="submit" class="btn btn-primary mr-1" name="btnEnviarFila" title="Enviar email"><span class="fas fa-envelope-square" style="color:white;float:right;"></span></button>                                        
                                    </div>




                                    <?php //pinto todas las líneas de presupuesto guardadas y se añaden nuevas líneas ?>
                                    <div id="lineasPresupuesto"> 

                                        <?php
                                                $detalles = $datos['info']['detalle'];
                                                $clientes = $datos['clientes']; 
                                                $tipologias = $datos['tipologias'];                                                                                   
                                                $acciones = $datos['acciones'];                                                
                                                $modalidades = $datos['modalidades'];
                                                $nivelesCursos = $datos['nivelesCursos'];

                                                $numLinea = 0;
                                                foreach ($detalles as $detalle) {
                                                    $numLinea++;
                                                    if ($numLinea%2==0) {
                                                        $claseLinea = 'estiloFilaPar';
                                                    }else{
                                                        $claseLinea = 'estiloFilaImpar';
                                                    }
                                                    echo"

                                                        <div class='row ".$claseLinea." contenedorLineaPres' id='lineaPresupuesto_".$detalle->idAccionPres."'>
                                                            <div class='form-group row col-md-12 mb-0'>
                                                                <div class='col-md-3' col-sm-8>
                                                                    <label class='labelCampoPres'>Cliente</label>
                                                                    <input type='hidden' name='idAccionPres[]' value='".$detalle->idAccionPres."' >
                                                                    <select class='clientesPres".$detalle->idAccionPres." form-control inputTipoModalidad cliente clienteS todosUnique' 
                                                                        data-linea='".$detalle->idAccionPres."' id='cliente".$detalle->idAccionPres."' name='cliente[]'>";
                                                                        foreach ($clientes as $key) {
                                                                            echo"
                                                                            <option value='".$key->id."' ".(($key->id == $detalle->idEMPRESA)? 'selected': '').">".$key->NOMBREJURIDICO."</option>
                                                                            ";
                                                                        }
                                                                        echo"
                                                                    </select>
                                                                </div>
                                                                <div class='col-md-2 col-sm-4'>
                                                                    <label class='labelCampoPres'>Tipología</label>
                                                                    <select data-fila='".$detalle->idAccionPres."' class='serviciosPres".$detalle->idAccionPres." form-control inputTipoModalidad servicioS accionesT todosUnique' 
                                                                        id='servicio".$detalle->idAccionPres."' name='servicio[]'>";
                                                                        foreach ($tipologias as $key) {
                                                                            echo"
                                                                            <option value='".$key->codtipologia."' ".(($key->codtipologia==$detalle->idServicio)? 'selected':'').">".$key->descripcion."</option>
                                                                            ";
                                                                        }
                                                                        echo"
                                                                    </select>
                                                                </div>
                                                                <div class='col-md-3 col-sm-8'>
                                                                    <label class='labelCampoPres'>Acción</label>
                                                                    <select class='accionesPres".$detalle->idAccionPres." form-control inputTipoModalidad accionClase todosUnique' 
                                                                        id='accion".$detalle->idAccionPres."' name='accion[]' data-indice='".$detalle->idAccionPres."'>";

                                                                        if ($detalle->estatus == 1) {
                                                                            echo"
                                                                            <option value='".$detalle->idACCION."' 'selected'>".$detalle->idACCION." - ".$detalle->NOMBREACCION."</option>
                                                                            ";
                                                                        }else if ($detalle->estatus == 0){
                                                                            foreach ($acciones as $key) {
                                                                                echo"
                                                                                <option value='".$key->idACCION."' ".(($key->idACCION==$detalle->idACCION)? 'selected':'').">".$key->idACCION." - ".$key->NOMBREACCION."</option>
                                                                                ";
                                                                            }
                                                                        }
                                                                        echo"
                                                                    </select>
                                                                    <a data-toggle='modal' data-target='#modalAccion'></a>
                                                                </div>
                                                                <div class='col-md-2 col-sm-4'>
                                                                    <label class='labelCampoPres'>Modalidad</label>
                                                                    <select data-fila='".$detalle->idAccionPres."' class='modalidad".$detalle->idAccionPres." form-control inputTipoModalidad select2' 
                                                                        id='modalidad".$detalle->idAccionPres."' name='modalidad[]'>";

                                                                        if ($detalle->estatus == 1) {
                                                                            echo"
                                                                            <option value='".$detalle->modalidad."' 'selected'>".$detalle->modalidad." - ".$detalle->nombreModalidad."</option>
                                                                            ";
                                                                        }else if ($detalle->estatus == 0){
                                                                            foreach ($modalidades as $key) {
                                                                                echo"
                                                                                <option value='".$key->id."' ".(($key->id==$detalle->modalidad)? 'selected':'').">".$key->descripcion."</option>
                                                                                ";
                                                                            }
                                                                        }

                                                                        echo"
                                                                    </select>
                                                                </div>
                                                                <div class='col-md-2 col-sm-3'>
                                                                    <label class='labelCampoPres'>Nivel</label>
                                                                    <select data-fila='".$detalle->idAccionPres."' class='nivel".$detalle->idAccionPres." form-control inputTipoModalidad todosUnique' 
                                                                        id='nivel".$detalle->idAccionPres."' name='nivel[]'>";

                                                                        if ($detalle->estatus == 1) {
                                                                            echo"
                                                                            <option value='".$detalle->nivel."' 'selected'>".$detalle->nivel." - ".$detalle->nombreNivel."</option>
                                                                            ";
                                                                        }else if ($detalle->estatus == 0){
                                                                            foreach ($nivelesCursos as $key) {
                                                                                echo"
                                                                                <option value='".$key->id."' ".(($key->id==$detalle->nivel)? 'selected':'').">".$key->descripcion."</option>
                                                                                ";
                                                                            }
                                                                        }                                                                        

                                                                        echo"
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class='form-group row col-md-12 mb-2 d-flex'>  
                                                                <div class='col-md-1 col-sm-2'>
                                                                    <label class='labelCampoPres'>Importe</label>
                                                                    <input type='number' step='0.01' class='importePres".$detalle->idAccionPres." form-control inputTipoModalidad'  
                                                                        name='importe[]' id='importe".$detalle->idAccionPres."' value='".$detalle->importe."'>
                                                                </div>";

                                                                if ($detalle->estatus == 1) {
                                                                    $editar ='readonly';
                                                                }else{
                                                                    $editar ='';
                                                                }

                                                                echo"
                                                                <div class='col-md-1 col-sm-2'>
                                                                    <label class='labelCampoPres'>H. Presen.</label>
                                                                    <input type='number' step='0.01' class='horasPres".$detalle->idAccionPres." form-control inputTipoModalidad sumarHorasGuardadas'  
                                                                        name='hPresenciales[]' id='hPresenciales".$detalle->idAccionPres."' value='".(($detalle->hPresenciales)? $detalle->hPresenciales:'0')."'
                                                                        data-indice='".$detalle->idAccionPres."' ".$editar.">
                                                                </div>              
                                                                <div class='col-md-1 col-sm-2'>
                                                                    <label class='labelCampoPres'>H. Teleform.</label>
                                                                    <input type='number' step='0.01' class='horasPres".$detalle->idAccionPres." form-control inputTipoModalidad sumarHorasGuardadas'  
                                                                        name='hTeleformacion[]' id='hTeleformacion".$detalle->idAccionPres."' value='".(($detalle->hTeleformacion)? $detalle->hTeleformacion:'0')."'
                                                                        data-indice='".$detalle->idAccionPres."' ".$editar.">
                                                                </div>                                                                
                                                                <div class='col-md-1 col-sm-2'>
                                                                    <label class='labelCampoPres'>H. Aula Virtual</label>
                                                                    <input type='number' step='0.01' class='horasPres".$detalle->idAccionPres." form-control inputTipoModalidad sumarHorasGuardadas'  
                                                                        name='hAulaVirtual[]' id='hAulaVirtual".$detalle->idAccionPres."' value='".(($detalle->hAulaVirtual)? $detalle->hAulaVirtual:'0')."'
                                                                        data-indice='".$detalle->idAccionPres."' ".$editar.">
                                                                </div>                                                               
                                                                <div class='col-md-1 col-sm-2'>
                                                                    <label class='labelCampoPres'>H. Totales</label>
                                                                    <input type='number' step='0.01' class='horasPres".$detalle->idAccionPres." form-control inputTipoModalidad'  
                                                                        name='horas[]' id='horas".$detalle->idAccionPres."' value='".(($detalle->horas)? $detalle->horas : '0')."' readonly>
                                                                </div>

                                                                <div class='col-md-1 col-sm-2'>
                                                                    <label class='labelCampoPres'>Participantes</label>
                                                                    <input type='number' class='numParticip".$detalle->idAccionPres." form-control inputTipoModalidad'  
                                                                        name='participantes[]' id='participantes".$detalle->idAccionPres."' value='".$detalle->participantes."'>
                                                                </div>
                                                                <div class='col-md-2 col-sm-2'>                                                                        
                                                                    <label class='labelCampoPres'>F. Inicio</label>";
                                                                if ($detalle->estatus == 0) {
                                                                    echo"                                                                                         
                                                                        <input type='date' name='fechaInicio[]' id='fechaInicio".$detalle->idAccionPres."' 
                                                                            class='form-control mr-1'>";
                                                                }else{          
                                                                    echo"
                                                                        <input type='date' name='fechaInicio[]' class='form-control mr-1' 
                                                                            value='".(($detalle->estatus == 1)? $detalle->fechaInicio : (($detalle->estatus == 2)? $detalle->fechaRechazo:'') )."' readonly>                                                                    
                                                                    ";
                                                                }                                                                                                                           
                                                                echo"
                                                                </div>
                                                                <div class='col-md-1 col-sm-2'>                                                                        
                                                                    <label class='labelCampoPres'>Situación</label>
                                                                    <input id='estatus".$detalle->idAccionPres."' class='form-control' name='situacion[]'
                                                                        value='".(($detalle->estatus == 0)? 'Pendiente':(($detalle->estatus == 1)?'Aprobado':(($detalle->estatus == 2)?'Rechazado':'')  )  )."' readonly>
                                                                </div>
                                                                <div class='col-md-2 col-sm-2'>                                                                        
                                                                    <label class='labelCampoPres'>Acciones</label>";
                                                                if ($detalle->estatus == 0) {
                                                                    echo"                                                                    
                                                                    <div class='d-lg-flex mb-1'>
                                                                        <input class='form-check-input marcaraccion' type='checkbox' data-idaccion='".$detalle->idAccionPres."' 
                                                                            id='checkAccion".$detalle->idAccionPres."' name='checkAccion[]' value='".$detalle->idAccionPres."'>
                                                                        <a id='btnAprobarFila".$detalle->idAccionPres."' class='btn btn-success mr-1 btnAprobarFila' 
                                                                            data-btnaccion='".$detalle->idAccionPres."' data-idaccion='".$detalle->idACCION."' name='btnAprobarFila' title='Aprobar' style='float:right'>
                                                                                <i class='fas fa-thumbs-up' style='color:white;float:right;'></i>
                                                                        </a>
                                                                        <a id='btnRechazarFila".$detalle->idAccionPres."' class='btn btn-danger mr-1 btnRechazarFila' 
                                                                            data-btnaccion='".$detalle->idAccionPres."' name='btnRechazarFila' title='Rechazar' style='float:right'>
                                                                                <i class='fas fa-thumbs-down' style='color:white;float:right;'></i>
                                                                        </a>";
                                                                        /*                                                                                               
                                                                        <a class='btn btn-danger btn-sm btnEliminarLinea' data-indice='".$detalle->idAccionPres."'>
                                                                            <i class='fa fa-trash' style='color:white'></i>
                                                                        </a>*/
                                                                        echo"
                                                                    </div>";
                                                                }else{
                                                                    echo"
                                                                    <div class='d-lg-flex mb-1'>
                                                                        <input class='form-check-input marcaraccion' type='checkbox' data-idaccion='".$detalle->idAccionPres."' 
                                                                                id='checkAccion".$detalle->idAccionPres."' name='checkAccion[]' value='".$detalle->idAccionPres."'>
                                                                        <a id='btnRechazarFila".$detalle->idAccionPres."' class='btn btn-danger mr-1 btnRechazarFila' 
                                                                            data-btnaccion='".$detalle->idAccionPres."' name='btnRechazarFila' title='Rechazar' style='float:right'>
                                                                                <i class='fas fa-thumbs-down' style='color:white;float:right;'></i>
                                                                        </a>
                                                                    </div>";
                                                                }
                                                                echo"
                                                                </div>
                                                            </div>
                                                        </div>";
                                                }
                                        ?>

                                    </div>                                    
                                                                                                        
                                    <div class="form-group mt-3" style="padding-bottom:15px;">
                                            <a id="anadirFichero" class="btn btn-primary text-white">Añadir fichero</a>
                                            <div class='col-sm-4 my-1' id='formularioSubirFichero' style='display:none;'>
                                                <input type="text" class="form-control" name="descripcionFichero" id="descripcionFichero" placeholder="Descripción fichero">
                                                <input type="file" class="form-control-file my-1" name="ficheroPresupuesto" id="ficheroPresupuesto" placeholder="Adjunte fichero">
                                            </div>
                                            <div>
                                                <?php
                                                    if ($datos['insert'][0]) {
                                                        echo"
                                                        <table class='table mt-3'>
                                                            <thead>
                                                                <tr>
                                                                    <th scope='col'>Descripción</th>
                                                                    <th scope='col'>Fichero</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>";                                                                                                                        
                                                                $ficheros = $datos['insert'];
                                                                foreach ($ficheros as $key) {
                                                                    echo"
                                                                    <tr>
                                                                        <td scope='row'>".$key->descripcion."</td>                                                                
                                                                        <td><div><a href='".RUTA_URL."/presupuesto/descargarFichero/".$key->idDocumento."' target='_BLANK'>".$key->nombre."</a></div></td>
                                                                    </tr>";
                                                                }
                                                            
                                                            echo"
                                                            </tbody>
                                                        </table>";
                                                    }
                                                ?>
                                            
                                            </div>
                                    </div>

                                    <div class="form-group">
                                            <label for="observacionesGenerales">Observaciones </label>
                                            <textarea id="observacionesEdit" class="form-control  form-control-sm"
                                                name="observacionesEdit" rows="4"><?php echo $cabecera->observaciones; ?></textarea>
                                    </div>
                                    <!--<div class="form-group">
                                            <label for="nombreProyecto">Variables</label>
                                            <select onchange=InsertHTML2() id="variables2"
                                                class="form-control  form-control-sm variablesSelect" name="tipoPesupuesto" required>
                                                <option selected disabled>Seleccionar.....</option>
                                                <option value="[tipo]">Tipo Presupuesto</option>
                                                <option value="[grupo empresas]">Grupo Empresas</option>
                                                <option value="[concepto]">Concepto</option>
                                                <option value="[importe]">Importe</option>
                                                <option value="[iva]">Iva</option>
                                                <option value="[fecha]">Fecha</option>
                                            </select>
                                    </div>-->
                                    <textarea class= "plantilla" id="editor4" name="editor4" rows="10" cols="10">
                                    <?php echo $cabecera->htmlPresupuesto; ?>
                                    </textarea><br>                                                                                                        
                                </div><!-- /.card-body -->
                            </form>
                        </div><!-- /.card -->
                    </div>
                </div>
            </div>


        </div>
    </section>

</div>


<?php require(RUTA_APP . '/views/includes/footer2.php'); ?>