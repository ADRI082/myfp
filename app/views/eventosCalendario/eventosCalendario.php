<?php require(RUTA_APP . '/views/includes/header2.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Eventos Calendario</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Eventos Calendario</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
      <div class="container">
<div class="content">
<div class="row">
<div class="col-xs-12">

<!-- ///////////////////////////////////////////////////// -->
  <!-- /// Referencias para visibilidad/ocultar columnas/// -->
  <!-- /////////////////////////////////////////////////// -->
  <div class="box">
				<div class="box-header">
					<div class="col-sm-12" style="margin-bottom:10px; border:solid 0.5px lightgrey;">
						<i class="fa fa-eye-slash fa-1x"></i> / <i class="fa fa-eye fa-1x"></i>
						<a class="toggle-vis btn" data-column="0">Empresa</a> -
						<a class="toggle-vis btn" data-column="1">Agente</a> -
						<a class="toggle-vis btn" data-column="2">Estado</a> -
						<a class="toggle-vis btn" data-column="3">Contenido</a> -
						<a class="toggle-vis btn" data-column="4">Actividad</a>-
            <a class="toggle-vis btn" data-column="5">Canal Comunicacion</a> -
						<a class="toggle-vis btn" data-column="6">Inicio</a> -
						<a class="toggle-vis btn" data-column="7">Fin</a> 
					</div>
				</div>
	</div>
</div>
<div class="col-lg-12">
<a href="#createEventModal" class="btn modalAddBtn" data-toggle="modal"
                            style="margin-bottom:20px;background-color:#001f3f;color:#fff;"><span
                                class="fa fa-plus"></span></a>
<div class="table-responsive">
<table id="table_eventos" class="table table-striped table-bordered" style="width:100%">
  <thead style="background-color:#001f3f; color:#fff;">
            <tr>
            <th style="font-size:0.8em !important;">Empresa</th>
                <th style="font-size:0.8em !important;">Agente</th>
                <th style="font-size:0.8em !important;">Estado</th>
                <th style="font-size:0.8em !important;">Contenido</th>
                <th style="font-size:0.8em !important;">Actividad</th>
                <th style="font-size:0.8em !important;">C.Comunicacion</th>
                <th style="font-size:0.8em !important;">Inicio</th>
                <th style="font-size:0.8em !important;">Fin</th>
                <th style="font-size:0.8em !important;">Acciones</th>
            </tr>
  </thead>
</table>

</div>

</div>

</div>

</div>

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
                <form method="POST" action="EventosCalendario/agregarEvento">
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
                    <form method="POST" action="EventosCalendario/actualizarEvento">
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
                    <form method="POST" action="eventosCalendario/borrarEvento">
                        <input type="hidden" class="form-control" name="idDelete" id="idDelete" >
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


<?php require(RUTA_APP . '/views/includes/footer2.php'); ?>
