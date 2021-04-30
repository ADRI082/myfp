<?php require(RUTA_APP . '/views/includes/header2.php'); ?>

<!-- add calander in this div -->
<?php foreach ($datos['todo'] as $todo) : 
$total =  $todo->todo;
endforeach; 
foreach ($datos['pendiente'] as $pendiente) : 
$pen = $pendiente->pendiente;
endforeach;
foreach ($datos['enproceso'] as $enproceso) : 
$enpro =  $enproceso->enproceso;
endforeach;
foreach ($datos['terminado'] as $terminado) : 
$term = $terminado->terminado;
 endforeach;
 foreach ($datos['hoy'] as $hoy) : 
$hoyTotal =  $hoy->hoy;
endforeach; ?>

<div class="container">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12 mt-4">
            <div class="info-box bg-red">
                <span class="info-box-icon"><i class="fas fa-exclamation-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pendientes <?php echo $pen; ?></span>
                    <span class="info-box-number" id="tgPendientes"></span>
                    <div class="progress">
                        <div class="progress-bar" id="tgWpendientes"
                            style="width: <?php echo round(($pen*100)/$total); ?>%"></div>
                    </div>
                    <span class="progress-description"
                        id="tgPenPorcentaje"><?php if ($total!=0):echo round(($pen*100)/$total);endif; ?>% del
                        total</span>
                </div><!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12 mt-4">
            <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="fas fa-hourglass-half"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">En Proceso <?php echo $enpro; ?></span>
                    <span class="info-box-number" id="tgProceso"></span>
                    <div class="progress">
                        <div class="progress-bar" id="tgWproceso"
                            style="width:<?php echo round(($enpro*100)/$total); ?>%"></div>
                    </div>
                    <span class="progress-description"
                        id="tgProPorcentaje"><?php if ($total!=0): echo round(($enpro*100)/$total); endif; ?>%
                        del total</span>
                </div><!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12 mt-4">
            <div class="info-box bg-green">
                <span class="info-box-icon"><span class="fa fa-thumbs-up"></span></span>
                <div class="info-box-content">
                    <span class="info-box-text">Finalizadas <?php echo $term; ?></span>
                    <span class="info-box-number" id="tgFinalizadas"></span>
                    <div class="progress">
                        <div class="progress-bar" id="tgWfinalizadas"
                            style="width:<?php echo round(($term*100)/$total); ?>%"></div>
                    </div>
                    <span class="progress-description" id="tgFinPorcentaje">
                        <?php if ($total!=0): echo round(($term*100)/$total); endif; ?>% del total
                    </span>
                </div><!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12 mt-4">
            <div class="info-box bg-blue">
                <span class="info-box-icon"><span class="fa fa-bookmark"></span></span>
                <div class="info-box-content">
                    <span class="info-box-text">Hoy <?php echo $hoyTotal; ?></span>
                    <span class="info-box-number" id="tgHoy"></span>
                    <div class="progress">
                        <div class="progress-bar" id="tgWhoy"
                            style="width:<?php echo round(($hoyTotal*100)/$total); ?>%"></div>
                    </div>
                    <span class="progress-description" id="tgHoyPorcentaje">
                        <?php if ($total!=0): echo round(($hoyTotal*100)/$total); endif; ?>% del total
                    </span>
                </div><!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-xs-12 col-md-3">
                <label for="exampleFormControlSelect3">Empresa</label>
                <select class="form-control form-control-sm boxing empresa select_option" id="empresa" name="empresa[]"
                    multiple>
                    <?php foreach ($datos['clientes'] as $clientes) : ?>
                    <option value="<?php echo $clientes->id; ?>">
                        <?php echo $clientes->NOMBREJURIDICO; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-xs-12 col-md-3">
                <label for="exampleFormControlSelect3">Agentes</label>
                <select class="form-control form-control-sm boxing agente select_option" id="agente" multiple>
                    <?php foreach ($datos['agente'] as $agente) : ?>
                    <option value="<?php echo $agente->codAgente; ?>">
                        <?php echo $agente->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-xs-12 col-md-3">
                <label for="exampleFormControlSelect3">Estado</label>
                <select class="form-control form-control-sm boxing estado select_option" id="estado" multiple>
                    <option>Pendiente</option>
                    <option>En Proceso</option>
                    <option>Terminado</option>
                </select>
            </div>
        </div>
    </div>
    <div class="">
        <input type="hidden" id="cambioPersona" value="">
        <div id="calendar"></div>
    </div>
    <!-- </div> -->

    <!-- Modal  to Add Event -->
    <div class="modal fade" id="createEventModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="margin-top:5px !important;">
                    <h4 class="modal-title" style="margin-top:5px !important;">Añadir Evento</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="Calendario/agregarEvento">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="control-group">
                                    <label class="control-label" for="inputPatient">Cliente:</label>
                                    <div class="field desc">
                                        <select id="idCliente" class="form-control select2" name="idCliente"
                                            style="width:100%;" required>
                                            <option selected disabled>seleccionar</option>
                                            <?php foreach ($datos['clientes'] as $clientes) : ?>
                                            <option value="<?php echo $clientes->id; ?>">
                                                <?php echo $clientes->NOMBREJURIDICO; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label" for="inputPatient">Actividad:</label>
                                    <div class="field desc">
                                        <input id="actividad" class="form-control " name="actividad" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="control-group">
                                    <label class="control-label" for="inputPatient">Agente:</label>
                                    <div class="field desc">
                                        <select id="agente" class="form-control select2" name="agente"
                                            style="width:100%;" required>
                                            <option value="" selected disabled>seleccionar</option>
                                            <?php foreach ($datos['agente'] as $agente) : ?>
                                            <option value="<?php echo $agente->codAgente; ?>">
                                                <?php echo $agente->nombre; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label" for="inputPatient">Estado:</label>
                                    <div class="field desc">
                                        <select id="estado" class="form-control" name="estado" required>
                                            <option value="" selected disabled>seleccionar</option>
                                            <option>Pendiente</option>
                                            <option>En Proceso</option>
                                            <option>Terminado</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="control-group">
                                    <label class="control-label" for="canal">Canal De Comunicacion:</label>
                                    <div class="field desc">
                                        <select id="canal" class="form-control " name="canal" style="width:100%;"
                                            required>
                                            <option value="" selected disabled>seleccionar</option>
                                            <option>Email</option>
                                            <option>Telefono</option>
                                            <option>Referencia</option>
                                            <option>Asesor</option>
                                            <option>Colaborador</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="control-group">
                                    <label class="control-label" for="inputPatient">Fecha Inicio:</label>
                                    <div class="field desc">
                                        <input type="date" id="inicio" class="form-control " name="inicio" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label" for="inputPatient">Hora Inicio:</label>
                                    <div class="field desc">
                                        <input type="time" id="iniciotime" class="form-control " name="iniciotime"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="control-group">
                                    <label class="control-label" for="inputPatient">Fecha Fin:</label>
                                    <div class="field desc">
                                        <input type="date" id="fin" class="form-control " name="fin" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label" for="inputPatient">Hora Fin:</label>
                                    <div class="field desc">
                                        <input type="time" id="fintime" class="form-control " name="fintime" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="control-group">
                                    <label class="control-label" for="inputPatient">Contenido:</label>
                                    <div class="field desc">
                                        <textarea name="contenido" placeholder="" class="form-control"
                                            style="resize:none" rows="6"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <div class="row">

                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-primary" id="submitButton" title="Añadir evento"><i
                                        class="fa fa-plus"></i></button>
                            </div>
                            <div class="col-sm-6">
                                <button class="btn btn-danger" data-dismiss="modal" title="Cerrar Modal"><i
                                        class="far fa-window-close"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>

        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- Modal  to EDIT AND DELETE Event -->
    <div class="modal fade" id="calendarModalEdit">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="margin-top:5px !important;">
                    <h4 class="modal-title" style="margin-top:5px !important;">Detalle Evento</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="Calendario/actualizarEvento">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="control-group">
                                    <input type="hidden" name="id" id="idEdit">
                                    <label class="control-label" for="inputPatient">Cliente:</label>
                                    <div class="field desc">
                                        <select id="idClienteEdit" class="form-control select2" name="idClienteEdit"
                                            style="width:100%;" required>
                                            <?php foreach ($datos['clientes'] as $clientes) : ?>
                                            <option value="<?php echo $clientes->id; ?>">
                                                <?php echo $clientes->NOMBREJURIDICO; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label" for="">Actividad:</label>
                                    <div class="field desc">
                                        <input id="actividadEdit" class="form-control " name="actividadEdit" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="control-group">
                                    <label class="control-label" for="inputPatient">Agente:</label>
                                    <div class="field desc">
                                        <select id="agenteEdit" class="form-control select2" name="agenteEdit"
                                            style="width:100%;" required>
                                            <?php foreach ($datos['agente'] as $agente) : ?>
                                            <option value="<?php echo $agente->codAgente; ?>">
                                                <?php echo $agente->nombre; ?></option>
                                            <?php endforeach; ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label" for="inputPatient">Estado:</label>
                                    <div class="field desc">
                                        <select id="estadoEdit" class="form-control" name="estadoEdit" required>
                                            <option>Pendiente</option>
                                            <option>En Proceso</option>
                                            <option>Terminado</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="control-group">
                                    <label class="control-label" for="canal">Canal De Comunicacion:</label>
                                    <div class="field desc">
                                        <select id="canalEdit" class="form-control" name="canalEdit" style="width:100%;"
                                            required>
                                            <option>Email</option>
                                            <option>Telefono</option>
                                            <option>Referencia</option>
                                            <option>Asesor</option>
                                            <option>Colaborador</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="control-group">
                                    <label class="control-label" for="inputPatient">Fecha Inicio:</label>
                                    <div class="field desc">
                                        <input type="text" onfocus="(this.type = 'date')" id="inicioEdit"
                                            class="form-control " name="inicioEdit" required>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label" for="inputPatient">Hora Inicio:</label>
                                    <div class="field desc">
                                        <input type="text" onfocus="(this.type = 'time')" id="iniciotimeEdit"
                                            class="form-control " name="iniciotimeEdit" required>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="control-group">
                                    <label class="control-label" for="inputPatient">Fecha Fin:</label>
                                    <div class="field desc">
                                        <input type="text" onfocus="(this.type = 'date')" id="finEdit"
                                            class="form-control " name="finEdit" required>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label class="control-label" for="inputPatient">Hora Fin:</label>
                                    <div class="field desc">
                                        <input type="text" onfocus="(this.type = 'time')" id="fintimeEdit"
                                            class="form-control " name="fintimeEdit" required>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="control-group">
                                    <label class="control-label" for="inputPatient">Contenido:</label>
                                    <div class="field desc">
                                        <textarea name="contenidoEdit" id="contenidoEdit" placeholder=""
                                            class="form-control" style="resize:none" rows="6"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <div class="row text-center justify-content-between">
                        <div class="col-3 col-md-3 justify-center">
                            <a href="#timeLine" class="btn btn-info historico" type="button" id="historico"
                                data-toggle="modal" title="Histórico"><i class="fas fa-binoculars"></i></a>
                        </div>
                        <div class="col-3 col-md-3 justify-content-center">
                            <button type="submit" class="btn btn-success" id="updateButtonEdit" title="Modificar"><i
                                    class="far fa-edit"></i></button>
                        </div>
                        <div class="col-3 col-md-3 justify-content-center">

                            <a href="#delete" id="buttonDelete" type="button" title="Eliminar"
                                class="btn btn-danger btn" data-toggle="modal"><i class="far fa-calendar-minus"></i></a>
                        </div>
                        <div class="col-3 col-md-3 justify-content-center">
                            <button class="btn btn-danger" data-dismiss="modal" data-dismiss="modal"
                                title="Cerrar Modal"><i class="far fa-window-close"></i></button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- ============================ INICIO ELIMINAR =========================================================================== -->
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <center>
                        <h4 class="modal-title" id="myModalLabel">Eliminar Evento</h4>
                    </center>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="Calendario/borrarEvento">
                        <input type="number" class="form-control" name="idDelete" id="idDelete" style="display:none">
                        <p class="text-center">¿Seguro que desea borrar el evento?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span
                            class="fa fa-times"></span></button>
                    <button type="submit" name="delete" class="btn btn-danger"><span
                            class="fa fa-trash"></span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================ FIN MODAL ELIMINAR =========================================================================== -->
    <!----------------------------------- TIME LINE --------------------------------------------------->
    <div class="modal fade" id="timeLine" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="margin-top:5px !important;">
                    <h4 class="modal-title" style="margin-top:5px !important;">Historico de Eventos</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="modalBody" class="modal-body">
                    <!-- The timeline -->
                    <div class="timeline timeline-inverse" id="timeLineBody">

                    </div>
                </div>
                <div class="modal-footer justify-content-center" style="margin:2px !important;">
                    <button class="btn btn-danger" data-dismiss="modal" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
</div>
</div>
</div>


<?php require(RUTA_APP . '/views/includes/footer2.php'); ?>