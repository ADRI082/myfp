<?php require(RUTA_APP . '/views/includes/header2.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Asesores </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Asesores </li>
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
                                    <a class="toggle-vis btn" data-column="0">Id Asesor</a> -
                                    <a class="toggle-vis btn" data-column="1">Asesoría</a> -
                                    <a class="toggle-vis btn" data-column="2">Contacto</a> -                                    
                                    <a class="toggle-vis btn" data-column="3">Acciones</a> 

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <a href="#modalAdd" class="btn modalAddBtn" data-toggle="modal"
                            style="margin-bottom:20px;background-color:#001f3f;color:#fff;"><span
                                class="fa fa-plus"></span></a>
                        <div class="table-responsive">
                            <table id="table_asesor" class="table table-striped table-bordered" style="width:100%">
                                <thead style="background-color:#001f3f; color:#fff;">
                                    <tr>
                                        <th style="font-size:0.8em !important;">Id Asesor</th>
                                        <th style="font-size:0.8em !important;">Asesoría</th>
                                        <th style="font-size:0.8em !important;">Contacto</th>                                        
                                        <th style="font-size:0.8em !important;">Accion</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ==================== Empieza la ventana modal para añadir un registro nuevo =========================== -->
            <div class="modal fade bd-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <center>
                                <h4 class="modal-title" id="myModalLabel">Agregar Asesor</h4>
                            </center>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" id="formAgregarAsesor" action="Asesores/agregarAsesor">
                            <div class="modal-body">
                                <div class="row form-group">
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative; top:7px;">Id Asesor:
                                        </label>
                                    </div>
                                    <div class="col-lg-1 selPres">    
                                        <input type="text" id="" class="form-control form-control-sm"
                                            name="idAsesor" readonly>                                    
                                    </div>

                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative; top:7px;">Asesoría:
                                        </label>
                                    </div>
                                    <div class="col-lg-7 text-center">
                                        <input type="text" id="nombreAsesor" class="form-control form-control-sm"
                                            name="nombre">
                                    </div> 
                                   
                                </div>
                                <div class="row form-group">
                                    <!--
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative; top:7px;">Cliente:
                                        </label>
                                    </div>
                                    <div class="col-lg-5 selPres">
                                        <select type="text" id="codigo" class="form-control select2"
                                            name="empresa">
                                            <option disabled selected>Seleccionar...</option>
                                            <?php foreach ($datos['clientes'] as $clientes) : ?>
                                            <option value="<?php echo $clientes->id; ?>">
                                                <?php echo $clientes->NOMBREJURIDICO; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>-->

                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative; top:7px;">Contacto:
                                        </label>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="text" id="" class="form-control form-control-sm"
                                            name="contacto">
                                    </div>
                                    <div class="col-lg-2 text-center">
                                        <label class="control-label" style="position:relative; top:7px;">Dirección:
                                        </label>
                                    </div>
                                    <div class="col-lg-5">
                                        <input type="text" id="" class="form-control form-control-sm"
                                            name="direccion">
                                    </div> 
                                </div>
                                <div class="row form-group">
                                   
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative; top:7px;">Móvil:
                                        </label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type='text' regexp="[0-9]{0,9}" id="" class="form-control form-control-sm"
                                            name="movil">
                                    </div>                                    
                                    <div class="col-lg-2 text-center">
                                        <label class="control-label" style="position:relative; top:7px;">Email:
                                        </label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="mail" id="" class="form-control form-control-sm"
                                            name="email">
                                    </div>
                                </div>
                                <div class="row form-group">

                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative; top:7px;">Teléfono:
                                        </label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type='text' regexp="[0-9]{0,9}" id="" class="form-control form-control-sm"
                                            name="telefono">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-warning" data-dismiss="modal" title="Cerrar Modal"><i
                                        class="far fa-window-close"></i></button>
                                <button type="submit" class="btn btn-primary" id="submitButton"
                                    title="Añadir Asesor"><i class="fa fa-plus"></i></button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ==================== Termina la ventana modal para añadir un registro nuevo =========================== -->
            <!-- ==================== Empieza la ventana modal para editar un registro nuevo =========================== -->
            <div class="modal fade" id="ModalEdit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <center>
                                <h4 class="modal-title" id="myModalLabel">Editar Asesor</h4>
                            </center>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="formEditarAsesor" method="POST" action="Asesores/editarAsesor">
                            <div class="modal-body">
                                <div class="row form-group">
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative; top:7px;">Id Asesor:
                                        </label>
                                    </div>
                                    <div class="col-lg-1 selPres">
                                        <input type="text" name = "id" id="id" class="form-control form-control-sm"
                                           readonly>
                                    </div>
                                    <div class="col-lg-2 text-center">
                                        <label class="control-label" style="position:relative; top:7px;">Asesoría:
                                        </label>
                                    </div>
                                    <div class="col-lg-7">
                                        <input type="text" id="nombreEdit" class="form-control form-control-sm"
                                            name="nombreEdit">
                                    </div>                                  
                                </div>
                                <div class="row form-group">
                                    <!--
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative; top:7px;">Cliente:
                                        </label>
                                    </div>
                                    <div class="col-lg-5 selPres">
                                        
                                        <select type="text" id="empresaEdit" class="form-control select2"
                                            name="empresaEdit">
                                            <?php foreach ($datos['clientes'] as $clientes) : ?>
                                            <option value="<?php echo $clientes->id; ?>">
                                                <?php echo $clientes->NOMBREJURIDICO; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                            -->
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative; top:7px;">Contacto:
                                        </label>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="text" id="contactoEdit" class="form-control form-control-sm"
                                            name="contactoEdit">
                                    </div>                                    
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative; top:7px;">Dirección:
                                        </label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="text" id="direccionEdit" class="form-control form-control-sm"
                                            name="direccionEdit">
                                    </div>
                                </div>
                                <div class="row form-group">
  
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative; top:7px;">Teléfono:
                                        </label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type='text' regexp="[0-9]{0,9}" id="telefonoEdit" class="form-control form-control-sm"
                                            name="telefonoEdit">
                                    </div>                                         
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative; top:7px;">Email:
                                        </label>
                                    </div>
                                    <div class="col-lg-7">
                                        <input type="mail" id="emailEdit" class="form-control form-control-sm"
                                            name="emailEdit">
                                    </div>
                                </div>
                                <div class="row form-group">

                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative; top:7px;">Móvil:
                                        </label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type='text' regexp="[0-9]{0,9}" id="movilEdit" class="form-control form-control-sm"
                                            name="movilEdit">
                                    </div>                                
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-warning" data-dismiss="modal" title="Cerrar Modal"><i
                                        class="far fa-window-close"></i></button>
                                <button type="submit" class="btn btn-success" id="updateButtonEdit" title="Modificar"><i
                                        class="far fa-edit"></i></button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ==================== Termina la ventana modal para editar un registro nuevo =========================== -->
            <!-- ==================== Empieza la ventana modal para eliminar un registro =========================== -->
            <div class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <center>
                                <h4 class="modal-title" id="myModalLabel">Borrar Asesor</h4>
                            </center>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <form method="POST" action="Asesores/borrarAsesor">
                            <input type="hidden" id="id" name="id">
                            <div class="modal-body">
                                <p class="text-center">¿Estas seguro en borrar al asesor?</p>
                                <div id="" style="text-align: center;">
                                  
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-warning" data-dismiss="modal" title="Cerrar Modal"><i
                                        class="far fa-window-close"></i></button>
                                <button type="submit" class="btn btn-danger" id="submitButton"
                                    title="Eliminar cliente"><i class="fa fa-trash"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php require(RUTA_APP . '/views/includes/footer2.php'); ?>