<?php require(RUTA_APP . '/views/includes/header2.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Acciones</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Acciones</li>
            </ol>
          </div><!-- /.col -->

          
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
						<a class="toggle-vis btn" data-column="0">Id Acción</a> -
            <a class="toggle-vis btn" data-column="1">Tipo</a> -
						<a class="toggle-vis btn" data-column="2">Area</a> -
						<a class="toggle-vis btn" data-column="3">Modalidad</a> -
						<a class="toggle-vis btn" data-column="4">Acci&oacute;n</a> -
						<a class="toggle-vis btn" data-column="5">Descripci&oacute;n</a>-
            <a class="toggle-vis btn" data-column="6">Servicio</a> -
						<a class="toggle-viss roj btn" style="color:red"  data-column="7">P.Presencial</a> -
						<a class="toggle-viss roj btn" style="color:red"  data-column="8">P.TFormacion</a> -
						<a class="toggle-viss roj btn" style="color:red" data-column="9">objetivo Previsto</a> -						
            <a class="toggle-viss roj btn" style="color:red" data-column="10">Contenido Previsto</a> -
            <a class="toggle-viss roj btn" style="color:red" data-column="11">Metodología Prevista</a> -
            <a class="toggle-viss roj btn" data-column="12">Acciones</a>
					</div>
				</div>
	</div>
</div>
<div class="col-lg-12">
  <a href="#modalAdd" class="btn modalAddBtn" data-toggle="modal"
    style="margin-bottom:20px;background-color:#001f3f;color:#fff;"><span
    class="fa fa-plus"></span>
  </a>
  <div class="table-responsive">
    <table id="table_acciones" class="table table-striped table-bordered" style="width:100%">
      <thead style="background-color:#001f3f; color:#fff;">
                <tr>
                    <th style="font-size:0.8em !important;">Id Acción</th>
                    <th style="font-size:0.8em !important;">Tipo</th>
                    <th style="font-size:0.8em !important;">Area</th>
                    <th style="font-size:0.8em !important;">Modalidad</th>
                    <th style="font-size:0.8em !important;">Acci&oacute;n</th>
                    <th style="font-size:0.8em !important;">Descripci&oacute;n</th>
                    <th style="font-size:0.8em !important;">Servicio</th>
                    <th style="font-size:0.8em !important;">P.Presencial</th>
                    <th style="font-size:0.8em !important;">P.TFormacion</th>
                    <th style="font-size:0.8em !important;">objetivo Previsto</th>                    
                    <th style="font-size:0.8em !important;">Contenido Previsto</th>
                    <th style="font-size:0.8em !important;">Metodología Prevista</th>
                    <th style="font-size:0.8em !important;">Acciones</th>
                    
                </tr>
      </thead>
    </table>

  </div>

</div>

</div>

</div>

<!-- Modal -->
<div class="modal fade" id="vermas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
   aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info" role="document">
     <!--Content-->
     <div class="modal-content">
       <!--Header-->
       <div class="modal-header bg-info">
         <p class="heading lead">Detalle</p>

         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true" class="white-text">&times;</span>
         </button>
       </div>

       <!--Body-->
       <div class="modal-body">
         <div class="text-center">
           <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
           <p class="leer"></p>
         </div>
       </div>

       <!--Footer-->
       <div class="modal-footer justify-content-center">
         <a type="button" class="btn btn-outline-info waves-effect btn-xl" data-dismiss="modal">CERRAR</a>
       </div>
     </div>
     <!--/.Content-->
   </div>
</div>

<!-- ==================== Empieza la ventana modal para añadir un registro nuevo =========================== -->
<div class="modal fade bd-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <center>
                                <h4 class="modal-title" id="myModalLabel">Crear nueva acción</h4>
                            </center>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="<?php echo RUTA_URL; ?>/datatabless/agregarAccion" id="formAgregarAccion" enctype="multipart/form-data">                            
                            <div class="modal-body modalCliente">
                                <h5 class="titleClienteDatos" >Datos de identificación de la acción</h5>
                                <div class="form-row">
                                    <div class="form-group col-md-8">
                                        <label class="control-label" style="position:relative;">Nombre de la acción</label>
                                        <input type="text" class="form-control form-control-sm obligatorio" name="nombreAccion" required>
                                    </div>
                                    <div class="form-group col-md-4 colaborador">
                                        <label>Servicio</label>
                                        <select type="text" class="form-control form-control-sm" name="servicio">
                                            <option selected disabled>Seleccionar...</option>
                                            <?php foreach ($datos['servicio'] as $servicio) : ?>
                                            <option value="<?php echo $servicio->id; ?>">
                                                <?php echo $servicio->servicio; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label class="control-label" style="position:relative;">Tipo de Acción</label>
                                        <select type="text" class="form-control form-control-sm" name="tipoAccion">
                                            <option selected disabled>Seleccionar...</option>
                                            <?php foreach ($datos['tipoAccion'] as $tipoAccion) : ?>
                                            <option value="<?php echo $tipoAccion->id; ?>">
                                                <?php echo $tipoAccion->tipoAccion; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Modalidad de Acción</label>
                                        <select type="text" class="form-control form-control-sm" name="modalidad">
                                            <option selected disabled>Seleccionar...</option>
                                            <?php foreach ($datos['modalidad'] as $modalidad) : ?>
                                            <option value="<?php echo $modalidad->id; ?>">
                                                <?php echo $modalidad->modalidad; ?></option>
                                            <?php endforeach; ?>
                                        </select>                                        
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Área formativa</label>
                                        <select type="text" class="form-control form-control-sm" name="areaFormativa">
                                            <option selected disabled>Seleccionar...</option>
                                            <?php foreach ($datos['areaFormativa'] as $areaFormativa) : ?>
                                            <option value="<?php echo $areaFormativa->id; ?>">
                                                <?php echo $areaFormativa->areaFormativa; ?></option>
                                            <?php endforeach; ?>
                                        </select> 
                                    </div>                                  
                                </div>
                            </div>

                            <div class="modal-body modalCliente">
                                <h5 class="titleClienteDatos" >Descripción de la acción</h5>
                                <div class="form-group row mb-0">
                                  <div class='col-md-6 form-group'>
                                    <div>
                                      <label for='observacionesFichaProy'>Objetivo de la Acción</label>
                                      <textarea class="form-control  form-control-sm" name="objetivoAccion" id="objetivoAccion" rows="4"></textarea>
                                    </div>
                                    <div>
                                      <label for='observacionesFichaProy'>Metodología Prevista</label>
                                      <textarea class="form-control  form-control-sm" name="metodologia" id="metodologia" rows="4"></textarea>
                                    </div>
                                  </div>
                                  <div class='col-md-6 form-group'>
                                    <div>
                                      <label for='observacionesFichaProy'>Contenido de la Acción</label>
                                      <textarea class="form-control  form-control-sm" name="contenido" id="contenido" rows="4"></textarea>
                                    </div>
                                    <div>
                                      <label for='observacionesFichaProy'>Observaciones</label>
                                      <textarea class="form-control  form-control-sm" name="observacionesAccion" id="observacionesAccion" rows="4"></textarea>
                                    </div>
                                  </div>
                                </div>                                
                            </div>

                            <div class="modal-body modalCliente">
                              <p class="titleClienteDatos" >Documentos relacionados</p>
                              
                                    <div class="form-group" style="padding-bottom:15px;">                                            
                                            <a id="anadirFicheroAcc" class="btn btn-primary text-white">Añadir fichero</a>
                                            <div class='col-sm-4 my-1' id='formularioSubirFicheroAccion' style='display:none;'>
                                                <input type="text" class="form-control" name="descripcionFichero" id="descripcionFichero" placeholder="Descripción fichero">
                                                <input type="file" class="form-control-file my-1" name="ficheroAcciones" id="ficheroAcciones" placeholder="Adjunte fichero">
                                            </div>
                                            <div>                                                                                            
                                                <table class="table mt-3">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Descripción</th>
                                                            <th scope="col">Fichero</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    
                                                    </tbody>
                                                </table>                                                                                          
                                            </div>
                                    </div>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-warning" data-dismiss="modal" title="Cerrar Modal"><i
                                        class="far fa-window-close"></i></button>
                                <button class="btn btn-primary" id="btnaAddaccion"
                                    title="Añadir Acción"><i class="fa fa-plus"></i></button>

                            </div>
                        </form>
                    </div>
                </div>
</div>





<!-- ==================== Empieza la ventana modal para editar un registro nuevo =========================== -->
<div class="modal fade" id="ModalEdit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <center>
                                <h4 class="modal-title" id="myModalLabel">Editar Acción</h4>
                            </center>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="<?php echo RUTA_URL; ?>/datatabless/editarAccion" enctype="multipart/form-data">
                          <input type="hidden" name="idEdit" id="idEdit">
                          <div class="modal-body modalCliente">
                                <h5 class="titleClienteDatos" >Datos de identificación de la acción</h5>
                                <div class="form-row">
                                    <div class="form-group col-md-2">                                    
                                        <label class="control-label" style="position:relative;">Id Acción</label>
                                        <input type="text" class="form-control form-control-sm" name="idAccionEdit" id="idAccionEdit" readonly>
                                    </div>
                                    <div class="form-group col-md-7">
                                        <label class="control-label" style="position:relative;">Nombre de la acción</label>
                                        <input type="text" class="form-control form-control-sm obligatorio" name="nombreAccionEdit" id="nombreAccionEdit" required>
                                    </div>
                                    <div class="form-group col-md-3 colaborador">
                                        <label>Servicio</label>
                                        <select type="text" class="form-control form-control-sm" name="servicioEdit" id="servicioEdit" >
                                            <option selected disabled>Seleccionar...</option>
                                            <?php foreach ($datos['servicio'] as $servicio) : ?>
                                            <option value="<?php echo $servicio->id; ?>">
                                                <?php echo $servicio->servicio; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label class="control-label" style="position:relative;">Tipo de Acción</label>
                                        <select type="text" class="form-control form-control-sm" name="tipoAccionEdit" id="tipoAccionEdit">
                                            <option selected disabled>Seleccionar...</option>
                                            <?php foreach ($datos['tipoAccion'] as $tipoAccion) : ?>
                                            <option value="<?php echo $tipoAccion->id; ?>">
                                                <?php echo $tipoAccion->tipoAccion; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Modalidad de Acción</label>
                                        <select type="text" class="form-control form-control-sm" name="modalidadEdit" id="modalidadEdit">
                                            <option selected disabled>Seleccionar...</option>
                                            <?php foreach ($datos['modalidad'] as $modalidad) : ?>
                                            <option value="<?php echo $modalidad->id; ?>">
                                                <?php echo $modalidad->modalidad; ?></option>
                                            <?php endforeach; ?>
                                        </select>                                        
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Área formativa</label>
                                        <select type="text" class="form-control form-control-sm" name="areaFormativaEdit" id="areaFormativaEdit">
                                            <option selected disabled>Seleccionar...</option>
                                            <?php foreach ($datos['areaFormativa'] as $areaFormativa) : ?>
                                            <option value="<?php echo $areaFormativa->id; ?>">
                                                <?php echo $areaFormativa->areaFormativa; ?></option>
                                            <?php endforeach; ?>
                                        </select> 
                                    </div>                                  
                                </div>
                            </div>

                            <div class="modal-body modalCliente">
                                <h5 class="titleClienteDatos" >Descripción de la acción</h5>
                                <div class="form-group row mb-0">
                                  <div class='col-md-6 form-group'>
                                    <div>
                                      <label for='observacionesFichaProy'>Objetivo de la Acción</label>
                                      <textarea class="form-control  form-control-sm" name="objetivoAccionEdit" id="objetivoAccionEdit" rows="4"></textarea>
                                    </div>
                                    <div>
                                      <label for='observacionesFichaProy'>Metodología Prevista</label>
                                      <textarea class="form-control  form-control-sm" name="metodologiaEdit" id="metodologiaEdit" rows="4"></textarea>
                                    </div>
                                  </div>
                                  <div class='col-md-6 form-group'>
                                    <div>
                                      <label for='observacionesFichaProy'>Contenido de la Acción</label>
                                      <textarea class="form-control  form-control-sm" name="contenidoEdit" id="contenidoEdit" rows="4"></textarea>
                                    </div>
                                    <div>
                                      <label for='observacionesFichaProy'>Observaciones</label>
                                      <textarea class="form-control  form-control-sm" name="observacionesAccionEdit" id="observacionesAccionEdit" rows="4"></textarea>
                                    </div>
                                  </div>
                                </div>                                
                            </div>

                            <div class="modal-body modalCliente">
                              <p class="titleClienteDatos" >Documentos relacionados</p>
                              
                                    <div class="form-group" style="padding-bottom:15px;">
                                            <a id="anadirFicheroAccEdit" class="btn btn-primary text-white">Añadir fichero</a>
                                            <div class='col-sm-4 my-1' id='formularioSubirFicheroAccionEdit' style='display:none;'>
                                                <input type="text" class="form-control" name="descripcionFicheroEdit" id="descripcionFicheroEdit" placeholder="Descripción fichero">
                                                <input type="file" class="form-control-file my-1" name="ficheroAccionesEdit" id="ficheroAccionesEdit" placeholder="Adjunte fichero">
                                            </div>                                            
                                            <div class="table-responsive">                                                                                            
                                                <table class="table mt-3" id="tabla_ficherosEdit">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Descripción</th>
                                                            <th scope="col">Fichero</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    
                                                    </tbody>
                                                </table>                                                                                          
                                            </div>
                                    </div>

                          </div>


                          <div class="modal-footer">
                                <button class="btn btn-warning" data-dismiss="modal" title="Cerrar Modal"><i class="far fa-window-close"></i></button>
                                <button type="submit" class="btn btn-success" id="updateButtonEdit" title="Modificar"><i class="far fa-edit"></i></button>
                          </div>
                        </form>
                    </div>
                </div>
</div>




<!-- ==================== Empieza la ventana modal para eliminar un registro =========================== -->
<div class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <center>
                                <h4 class="modal-title" id="myModalLabel">Borrar Acción</h4>
                            </center>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <form method="POST" action="<?php echo RUTA_URL; ?>/datatabless/borrarAccion">
                            <input type="hidden" id="id" name="id">
                            <div class="modal-body">
                                <p class="text-center">¿Estas seguro en borrar los datos de?</p>
                                <div id="" style="text-align: center;">
                                    <h2 class="text-center"><input type="text" class="form-control" name="nombre"
                                            style="width:auto; margin: 0 auto; text-align:center" disabled></h2>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-warning" data-dismiss="modal" title="Cerrar Modal"><i
                                        class="far fa-window-close"></i></button>
                                <button type="submit" class="btn btn-danger" id="submitButton"
                                    title="Eliminar acción"><i class="fa fa-trash"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
</div>

<?php require(RUTA_APP . '/views/includes/footer2.php'); ?>
