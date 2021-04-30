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
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-lg-12 newPres" style="margin:0 auto">
                <p>
                <!--
                <a class="btn b presp" style="background-color:#001f3f;color:#fff;" data-toggle="collapse"
                        href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-plus" aria-hidden="true"></i>
                        Nuevo
                </a>
                -->
                <a class="btn b presp ml-5" style="background-color:#001f3f;color:#fff;" id='botonEjemplo'><i class="fa fa-plus" aria-hidden="true"></i>
                    Nuevo Presupuesto
                </a>


                </p>
                <div class="card card-warning">
                    <div class="collapse" id="collapseExample">
                        <div class="card card-warning card-outline ">
                            <form action="<?php echo RUTA_URL;?>/presupuesto/anadirPresupuesto" method="POST" enctype="multipart/form-data">
                                <div class="card-header">
                                    <h3 class="card-title tituloEditarPresup flex-grow-1 align-self-center mr-3">Nuevo Presupuesto</h3>
                                    <a href="<?php echo RUTA_URL."/presupuesto" ;?>" class="btn btn-default" style="float:right">Volver</a>
                                    <input type="submit" id="btnCrearPres" value="Guardar" class="btn btn-success mr-2"style="float:right">                                    
                                </div>
                                <div class="card-body">                                
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label for="nombrePres">Nombre Presupuesto</label>
                                                <input id="inputNomPres" type="text" class="form-control obligatorio" name="nombrePres" required></input>                                           
                                            </div>
                                            <div class="col-md-2">
                                                <label for="tipoPresServ">Servicio</label>
                                                <select class="form-control obligatorio" id="servicios" name="servicios" required>
                                                    <option selected disabled></option>
                                                    <?php foreach ($datos['servicio'] as $servicio) : ?>
                                                    <option value="<?php echo $servicio->id; ?>">
                                                    <?php echo $servicio->nombreS; ?></option>
                                                    <?php endforeach; ?>
                                                </select>                                                
                                            </div>
                                            <div class="col-md-2">
                                                <label for="tipoProyecto">F. Presupuesto</label>
                                                <input class="form-control  obligatorio" type="date" name="fecha" required>
                                            </div>                                            
                                            <div class="col-md-2">
                                                <label for="asignaAgente">Agente</label>
                                                <div class="asignaAgente">
                                                    <select class="form-control" id="asignaAgente" name="asignaAgente">
                                                        <option>&nbsp;</option>
                                                        <?php foreach ($datos['agentes'] as $agente) : ?>
                                                        <option value="<?php echo $agente->id; ?>">
                                                        <?php echo $agente->nombreAgente; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>                                                
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="nombreProyecto">Tipo Plantilla</label>
                                                <select id="tipoPresupuesto" class="form-control" name="tipoPesupuesto">
                                                    <option>&nbsp;</option>
                                                    <?php foreach ($datos['plantilla'] as $plantilla) : ?>
                                                    <option value="<?php echo $plantilla->id; ?>">
                                                    <?php echo $plantilla->tipoPlantilla; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-start">                                            
                                            <a  class="add_fila" title="Agregar Empresas/Acciones"><i class="fas fa-plus-square"></i></a>                                          
                                            <div id="msgValidacion" class="ml-2" style="color:red;"></div>
                                        </div>

                                        <div id="lineasPresupuesto">
                                        </div>
                                        
                                        <!--
                                        <div class="table-responsive mb-2" style="border-bottom:1px solid #ced4da">
                                            <table class="table" id="tablaAcciones">
                                                <thead>
                                                    <tr>
                                                        <th width='3%' scope="col">#</th>
                                                        <th width='18%' scope="col">Empresa</th>                                                    
                                                        <th width='17%' scope="col">Tipología</th>
                                                        <th width='20%' scope="col">Acción</th>
                                                        <th width='12%' scope="col">Modalidad</th|>
                                                        <th width='13%' scope="col">Nivel</th>
                                                        <th width='7%' scope="col">Importe</th>
                                                        <th width='7%' scope="col">Horas</th>
                                                        <th width='7%' scope="col">Particip.</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>-->

                                        <div class="form-group">
                                            <label for="observacionesGenerales">Observaciones </label>
                                            <textarea id="inputDescription3" class="form-control  form-control-sm"
                                                name="observaciones" rows="4"></textarea>
                                        </div>
                                        <div class="form-group" style="padding-bottom:15px; padding-top:15px">
                                            <a id="anadirFichero" class="btn btn-primary text-white">Añadir fichero</a>
                                            <div class='col-sm-4 my-1' id='formularioSubirFichero' style='display:none;'>
                                                <input type="text" class="form-control" name="descripcionFichero" id="descripcionFichero" placeholder="Descripción fichero">
                                                <input type="file" class="form-control-file my-1" name="ficheroPresupuesto" id="ficheroPresupuesto" placeholder="Adjunte fichero">
                                            </div>                                            
                                        </div>
                                        <!--no mostrar hasta que el documento esté creado
                                        <div class="form-group">
                                            <label for="nombreProyecto">Variables</label>
                                            <select onchange=InsertHTML() id="variables"
                                                class="form-control  form-control-sm variablesSelect " name="tipoPesupuesto" required>
                                                <option selected disabled>Seleccionar.....</option>
                                                <option value="[tipo]">Tipo Presupuesto</option>
                                                <option value="[grupo empresas]">Grupo Empresas</option>
                                                <option value="[concepto]">Concepto</option>
                                                <option value="[importe]">Importe</option>
                                                <option value="[iva]">Iva</option>
                                                <option value="[fecha]">Fecha</option>
                                            </select>
                                        </div>
                                        -->
                                        <textarea class= "plantilla" id="editor3" name="editor3" rows="10" cols="10">                                   
                                        </textarea><br>
                                        <input type="submit" value="Guardar" class="btn btn-success"style="float:right">
                                </div>
                            <!-- /.card-body -->
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>      

        </div>
    </section>


    <!-- /.content -->
    <div class="row">
        <div class="col-lg-11" style="margin: 0 auto">
        
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


            <div class="table-responsive">
                <table id="table_presupuesto" class="table table-striped table-bordered" style="width:100%">
                    <thead style="background-color:#001f3f; color:#fff;">
                        <tr>
                            <th>Nº</th>
                            <th>Nombre Presupuesto</th>
                            <!--<th>T. Plantilla</th>-->
                            <th>Fecha</th>
                            <th>Servicio</th>
                            <th>Importe</th>
                            <!--<th>iva</th>
                            <th>Observaciones</th>-->
                            <!--<th>Estado</th>-->
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

</div>
<!-- /.content-wrapper -->
<!-- GENERAR PDF-->
<div class="modal fade" id="emit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <center>
                    <h4 class="modal-title" id="myModalLabel">Crear presupuesto</h4>
                </center>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp</button>
            </div>
            <form method="POST" action="<?php echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto">
                <input type="hidden" id="idPresupuesto" name="idpresupuesto">
                <input type="hidden" id="idAccionPres" name="idAccionPres">
                <div class="modal-body" id="emitAllBills">
                    <p class="text-center">¿Quieres crear presupuesto o crear y enviar el presupuesto?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">X</button>
                    <button onClick='$("#emit").modal("hide")' type="submit" name="crear" class="btn btn-danger btn-sm" title="Crear Presupuesto"
                        formtarget="_blank"><i class="fas fa-file-pdf"></i></span></button>
                    <button onClick='$("#emit").modal("hide")' type="submit" name="crearyenviar" class="btn btn-primary btn-sm" title="Crear y Enviar"  formtarget="_blank"><i
                            class="far fa-paper-plane" ></i></button>
                </div>
            </form>
        </div>
    </div>
</div>




<!-- ==================== Empieza la ventana modal para eliminar un registro =========================== -->
<div class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <center>
                    <h4 class="modal-title" id="myModalLabel">Borrar Presupuesto</h4>
                </center>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form method="POST" action="<?php echo RUTA_URL;  ?>/Presupuesto/borrarPresupuesto">
                <input type="hidden" id="id" name="id">
                <div class="modal-body">
                    <p class="text-center">¿Estas seguro en borrar el presupuesto?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="delete" class="btn btn-danger"><span class="fa fa-trash"></span>
                        Si</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ==================== Termina la ventana modal para eliminar un registro =========================== -->




<!-- Modal -->
<div class="modal fade" id="modalAccion" tabindex="-1" aria-labelledby="modalAccionLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAccionLabel">Información Acción</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Modalidad: Presencial</p>
        <p>Área formativa: </p>
        <p>Tipo Acción: General </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>        
      </div>
    </div>
  </div>
</div>



<script>

function InsertHTML() {
    // Get the editor instance that we want to interact with.
    var editor = CKEDITOR.instances.editor3;
    var value = document.getElementById('variables').value;

    // Check the active editing mode.
    if (editor.mode == 'wysiwyg') {
        // Insert HTML code.
        // https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_editor.html#method-insertHtml
        editor.insertHtml(value);
    } else
        alert('You must be in WYSIWYG mode!');
}
function InsertHTML2() {
    // Get the editor instance that we want to interact with.
    var editor = CKEDITOR.instances.editor4;
    var value = document.getElementById('variables2').value;

    // Check the active editing mode.
    if (editor.mode == 'wysiwyg') {
        // Insert HTML code.
        // https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_editor.html#method-insertHtml
        editor.insertHtml(value);
    } else
        alert('You must be in WYSIWYG mode!');
}
</script>
<?php require(RUTA_APP . '/views/includes/footer2.php'); ?>