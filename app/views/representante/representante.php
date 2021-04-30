<?php require(RUTA_APP . '/views/includes/header2.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Representantes</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Representantes</li>
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
                                    <a class="toggle-vis btn" data-column="1">Nombre</a> -
                                    <a class="toggle-vis btn" data-column="2">NIF</a> -
                                    <a class="toggle-vis btn" data-column="3">Telefono</a> -
                                    <a class="toggle-vis btn" data-column="4">Movil</a> -
                                    <a class="toggle-vis btn" data-column="5">Email</a> 

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <a href="#modalAdd" class="btn modalAddBtn" data-toggle="modal"
                            style="margin-bottom:20px;background-color:#001f3f;color:#fff;"><span
                                class="fa fa-plus"></span></a>
                        <div class="table-responsive">
                            <table id="table_representante" class="table table-striped table-bordered" style="width:100%">
                                <thead style="background-color:#001f3f; color:#fff;">
                                    <tr>
                                        <th style="font-size:0.8em !important;">Empresa</th>
                                        <th style="font-size:0.8em !important;">Nombre</th>
                                        <th style="font-size:0.8em !important;">NIF</th>
                                        <th style="font-size:0.8em !important;">Telefono</th>
                                        <th style="font-size:0.8em !important;">Movil</th>
                                        <th style="font-size:0.8em !important;">Email</th>
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
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <center>
                                <h4 class="modal-title" id="myModalLabel">Agregar Representante</h4>
                            </center>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="Representante/agregarRepresentante">
                            <div class="modal-body">
                                <div class="row form-group">
                                    <div class="col-sm-2">
                                        <label class="control-label" style="position:relative; top:7px;">Empresa:
                                        </label>
                                    </div>
                                    <div class="col-sm-4 selPres">
                                        <select type="text" id="codigo" class="form-control select2"
                                            name="empresa">
                                            <option disabled selected>Seleccionar...</option>
                                            <?php foreach ($datos['clientes'] as $clientes) : ?>
                                            <option value="<?php echo $clientes->id; ?>">
                                                <?php echo $clientes->NOMBREJURIDICO; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="control-label" style="position:relative; top:7px;">Nombre:
                                        </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" id="" class="form-control form-control-sm"
                                            name="nombre">
                                    </div>
                                   
                                </div>
                                <div class="row form-group">
                                   
                                    <div class="col-sm-2">
                                        <label class="control-label" style="position:relative; top:7px;">NIF:
                                        </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" id="" class="form-control form-control-sm"
                                            name="nif">
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="control-label" style="position:relative; top:7px;">Movil:
                                        </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" id="" class="form-control form-control-sm"
                                            name="movil">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-2">
                                        <label class="control-label" style="position:relative; top:7px;">Email:
                                        </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="mail" id="" class="form-control form-control-sm"
                                            name="email">
                                    </div>
                                   <div class="col-sm-2">
                                        <label class="control-label" style="position:relative; top:7px;">Telefono:
                                        </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" id="" class="form-control form-control-sm"
                                            name="telefono">

                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-warning" data-dismiss="modal" title="Cerrar Modal"><i
                                        class="far fa-window-close"></i></button>
                                <button type="submit" class="btn btn-primary" id="submitButton"
                                    title="Añadir Representante"><i class="fa fa-plus"></i></button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ==================== Termina la ventana modal para añadir un registro nuevo =========================== -->
            <!-- ==================== Empieza la ventana modal para editar un registro nuevo =========================== -->
            <div class="modal fade" id="ModalEdit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <center>
                                <h4 class="modal-title" id="myModalLabel">Editar Representante</h4>
                            </center>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="Representante/editarRepresentante">
                            <div class="modal-body">
                                <div class="row form-group">
                                    <div class="col-sm-2">
                                        <label class="control-label" style="position:relative; top:7px;">Empresa:
                                        </label>
                                    </div>
                                    <div class="col-sm-4 selPres">
                                        <input type = "hidden" name = "id" id="id">
                                        <select type="text" id="empresaEdit" class="form-control select2"
                                            name="empresaEdit">
                                            <?php foreach ($datos['clientes'] as $clientes) : ?>
                                            <option value="<?php echo $clientes->id; ?>">
                                                <?php echo $clientes->NOMBREJURIDICO; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="control-label" style="position:relative; top:7px;">Nombre:
                                        </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" id="nombreEdit" class="form-control form-control-sm"
                                            name="nombreEdit">
                                    </div>
                                  
                                </div>
                                <div class="row form-group">
                                <div class="col-sm-2">
                                        <label class="control-label" style="position:relative; top:7px;">NIF:
                                        </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" id="nifEdit" class="form-control form-control-sm"
                                            name="nifEdit">
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="control-label" style="position:relative; top:7px;">Telefono:
                                        </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" id="telefonoEdit" class="form-control form-control-sm"
                                            name="telefonoEdit">

                                    </div>
                                  
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-2">
                                        <label class="control-label" style="position:relative; top:7px;">Email:
                                        </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="mail" id="emailEdit" class="form-control form-control-sm"
                                            name="emailEdit">
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="control-label" style="position:relative; top:7px;">Movil:
                                        </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" id="movilEdit" class="form-control form-control-sm"
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
                                <h4 class="modal-title" id="myModalLabel">Borrar Representante</h4>
                            </center>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <form method="POST" action="Representante/borrarRepresentante">
                            <input type="hidden" id="id" name="id">
                            <div class="modal-body">
                                <p class="text-center">¿Estas seguro en borrar al representante?</p>
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