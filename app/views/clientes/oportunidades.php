<?php require(RUTA_APP . '/views/includes/header2.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Oportunidades</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Oportunidades</li>
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
                                    <a class="toggle-vis btn" data-column="0">Id Oportunidad</a> -
                                    <a class="toggle-vis btn" data-column="1">Raz&oacute;n Social</a> -
                                    <a class="toggle-vis btn" data-column="2">Colaborador</a> -
                                    <a class="toggle-vis btn" data-column="3">Sector</a> -
                                    <a class="toggle-vis btn" data-column="4">Fecha Creación</a> -
                                    <a class="toggle-vis btn" data-column="5">Tipo</a> -                                                                                                   
                                    <a class="toggle-vis btn" data-column="6">Accciones</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <a href="#modalAdd" class="btn modalAddBtn" data-toggle="modal"
                            style="margin-bottom:20px;background-color:#001f3f;color:#fff;" title="Agregar oportunidad"><span
                                class="fa fa-plus"></span></a>
                        <div class="table-responsive">
                            <table id="table_oportunidades" class="table table-striped table-bordered" style="width:100%">
                                <thead style="background-color:#001f3f; color:#fff;">
                                    <tr>
                                        <th style="font-size:0.8em !important;">Id Oportunidad</th>
                                        <th style="font-size:0.8em !important;">Raz&oacute;n Social</th>
                                        <th style="font-size:0.8em !important;">Colaborador</th>
                                        <th style="font-size:0.8em !important;">Sector</th>
                                        <th style="font-size:0.8em !important;">Fecha Creación</th>
                                        <th style="font-size:0.8em !important;">Tipo</th>                                                                                                                                                                                     
                                        <th style="font-size:0.8em !important;">Acciones</th>                                        
                                    </tr>
                                </thead>

                                <tfoot style="background-color:#001f3f; color:#fff;">
                                    <tr>
                                        <th style="font-size:0.8em !important;">Id Oportunidad</th>
                                        <th style="font-size:0.8em !important;">Raz&oacute;n Social</th>
                                        <th style="font-size:0.8em !important;">Colaborador</th>
                                        <th style="font-size:0.8em !important;">Sector</th>
                                        <th style="font-size:0.8em !important;">Fecha Creación</th>
                                        <th style="font-size:0.8em !important;">Tipo</th>                                                                                                                      
                                        <th style="font-size:0.8em !important;">Acciones</th>

                                    </tr>
                                </tfoot>
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
                                <h4 class="modal-title" id="myModalLabel">Agregar Oportunidad</h4>
                            </center>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="agregarEmpresa" id="formAgregarOportunidad">
                            <input type="hidden" name="identificadorOp" id="identificadorOp" value="">
                            <div class="modal-body modalCliente">
                                <h5 class="titleClienteDatos" >Datos de identificación de la oportunidad</h5>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="control-label" style="position:relative;">Nombre Comercial</label>
                                        <input type="text" class="form-control form-control-sm obligatorio" name="nombreComercial" required>
                                    </div>
                                    <div class="form-group col-md-3 colaborador">
                                        <label class="control-label">Colaborador</label>
                                        <select type="text" class="form-control form-control-sm select2" name="colaborador">
                                            <option selected disabled>Seleccionar...</option>
                                            <?php foreach ($datos['colaborador'] as $colaborador) : ?>
                                            <option value="<?php echo $colaborador->id; ?>">
                                                <?php echo $colaborador->RazonSocial; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3 colaborador">
                                        <label class="control-label">Agente</label>
                                        <select type="text" class="form-control form-control-sm select2 selectorAuto" name="agente">
                                            <option selected disabled>Seleccionar...</option>
                                            <?php foreach ($datos['agente'] as $agente) : ?>
                                            <option value="<?php echo $agente->id; ?>">
                                                <?php echo $agente->agente; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>                                                                   
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="control-label" style="position:relative;">Dirección</label>
                                        <input type="text" class="form-control form-control-sm" name="direccion">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="control-label">Localidad</label>
                                        <input type="text" class="form-control form-control-sm" name="poblacion">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="control-label">Provincia</label>
                                        <input type="text" class="form-control form-control-sm" name="provincia">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="control-label">Código postal</label>
                                        <input type='text' regexp="[0-9]{0,5}" class="form-control form-control-sm" name="codigoPostal">
                                    </div>                                    
                                </div>
                            </div>

                            <div class="modal-body modalCliente">
                                <h5 class="titleClienteDatos" >Otros datos de referencia</h5>
                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <label class="control-label" style="position:relative;">Contacto</label>
                                        <input type="text" class="form-control form-control-sm" name="contactoPrincipal">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="control-label">Telef. Fijo 1</label>
                                        <input type='text' regexp="[0-9]{0,9}" class="form-control form-control-sm obligatorio" name="telefonofijo1" required>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="control-label">Móvil</label>
                                        <input type='text' regexp="[0-9]{0,9}" class="form-control form-control-sm" name="movil">
                                    </div>
                                    <div class="form-group col-md-3 selPres sector">
                                        <label class="control-label">Estado Oportunidad</label>
                                        <select type="text" class="form-control form-control-sm obligatorio" name="estadoOp" required>
                                            <option selected disabled>Seleccionar...</option>  
                                            <?php
                                                $estados = ['Empresa potencial','Colaborador potencial', 'Empresa', 'Colaborador'];
                                                foreach ($estados as $estado) {
                                                    echo"
                                                    <option value='".$estado."'>".$estado."</option>
                                                    ";
                                                }
                                            ?>                                           
                                        </select>
                                    </div>  
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4 sector">
                                        <label class="control-label" style="position:relative;">Sector Empresa</label>
                                        <select type="text" class="form-control form-control-sm select2" name="sector">
                                            <option selected disabled>Seleccionar...</option>
                                            <?php foreach ($datos['sector'] as $sector) : ?>
                                            <option value="<?php echo $sector->id; ?>">
                                                <?php echo $sector->SECTOR; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label class="control-label">Email</label>
                                        <input type="email" class="form-control form-control-sm" name="email">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Fecha</label>
                                        <input type="date" class="form-control form-control-sm obligatorio" name="fecha" required>
                                    </div>                                    
                                </div>    
                                <div class="form-row"> 
                                    <div class="form-group col-md-2 selPres sector">
                                        <label class="control-label">Nº Trabaj.</label>
                                        <input type="number" class="form-control form-control-sm" name="trabajadores">
                                    </div>     
                                </div>                                     
                            </div>


                            <div class="modal-footer">
                                <button class="btn btn-warning" data-dismiss="modal" title="Cerrar Modal"><i
                                        class="far fa-window-close"></i></button>
                                <button class="btn btn-primary" id="btnaAddOportunidad"
                                    title="Añadir oportunidad"><i class="fa fa-plus"></i></button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ==================== Termina la ventana modal para añadir un registro nuevo =========================== -->
            <!-- ==================== Empieza la ventana modal para editar un registro nuevo =========================== -->
            <div class="modal fade" id="ModalEdit" role="dialog" aria-labelledby="modalEditOportunidad" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <center>
                                <h4 class="modal-title" id="modalEditOportunidad">Editar Oportunidad</h4>
                            </center>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="editarOportunidad" id="formEditarOportunidad">
                            <input type="hidden" name="idEdit" id="idEdit">                            
                            <div class="modal-body modalCliente">
                                <h5 class="titleClienteDatos" >Datos de identificación de la oportunidad</h5>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="control-label" style="position:relative;">Nombre Comercial</label>
                                        <input type="text" class="form-control form-control-sm obligatorio" name="nombreComercialEdit" id="nombreComercialEdit" required>
                                    </div>
                                    <div class="form-group col-md-3 colaborador selPres">
                                        <label class="control-label">Colaborador</label>
                                        <select type="text" class="form-control form-control-sm select2" name="colaboradorEdit" id="colaboradorEdit">
                                            <option value="" disabled selected>Seleccionar</option>
                                        <?php foreach ($datos['colaborador'] as $colaborador) : ?>
                                            <option value="<?php echo $colaborador->id; ?>">
                                            <?php echo $colaborador->RazonSocial; ?></option>
                                        <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3 colaborador selPres">
                                        <label class="control-label">Agente</label>
                                        <select type="text" class="form-control form-control-sm select2 selectorAuto" name="agenteEdit">   
                                            <option value="" disabled selected>Seleccionar</option>                                         
                                            <?php foreach ($datos['agente'] as $agente) : ?>
                                            <option value="<?php echo $agente->id; ?>">
                                                <?php echo $agente->agente; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>   
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="control-label" style="position:relative;">Dirección</label>
                                        <input type="text" class="form-control form-control-sm" name="direccionEdit" id="direccionEdit">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="control-label">Localidad</label>
                                        <input type="text" class="form-control form-control-sm" name="poblacionEdit" id="poblacionEdit">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="control-label">Provincia</label>
                                        <input type="text" class="form-control form-control-sm" name="provinciaEdit" id="provinciaEdit">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="control-label">Código postal</label>
                                        <input type='text' regexp="[0-9]{0,5}" class="form-control form-control-sm" name="codigoPostalEdit" id="codigoPostalEdit">
                                    </div>                                    
                                </div>
                            </div>

                            <div class="modal-body modalCliente">
                                <h5 class="titleClienteDatos" >Otros datos de referencia</h5>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label class="control-label" style="position:relative;">Contacto</label>
                                        <input type="text" class="form-control form-control-sm" name="contactoPrincipalEdit" id="contactoPrincipalEdit">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Telef. Fijo 1</label>
                                        <input type='text' regexp="[0-9]{0,9}" class="form-control form-control-sm obligatorio" name="telefonofijo1Edit" id="telefonofijo1Edit" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Móvil</label>
                                        <input type='text' regexp="[0-9]{0,9}" class="form-control form-control-sm" name="movilEdit" id="movilEdit">
                                    </div>
                                    <div class="form-group col-md-3 selPres sector">
                                        <label class="control-label">Estado Oportunidad</label>
                                        <select type="text" class="form-control form-control-sm obligatorio" name="estadoOpEdit" id="estadoOpEdit">
                                            <option selected disabled>Seleccionar...</option>                                            
                                            <option value="empresaPot">Empresa potencial</option>
                                            <option value="colPotencial">Colaborador potencial</option>

                                            <option selected disabled>Seleccionar...</option>  
                                            <?php
                                                $estados = ['Empresa potencial','Colaborador potencial', 'Empresa', 'Colaborador'];
                                                foreach ($estados as $estado) {
                                                    echo"
                                                    <option value='".$estado."'>".$estado."</option>
                                                    ";
                                                }
                                            ?> 


                                        </select>
                                        
                                    </div>  
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4 sector selPres">
                                        <label class="control-label" style="position:relative;">Sector Empresa</label>
                                        <select type="text" class="form-control form-control-sm select2" name="sectorEdit" id = "sectorEdit">
                                            <?php foreach ($datos['sector'] as $sector) : ?>
                                            <option value="<?php echo $sector->id; ?>">
                                                <?php echo $sector->SECTOR; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label class="control-label">Email</label>
                                        <input type="email" class="form-control form-control-sm" name="emailEdit" id="emailEdit">
                                    </div>
                                    <div class="form-group col-md-2 selPres sector">
                                        <label class="control-label">Nº Trabaj.</label>
                                        <input type="number" class="form-control form-control-sm" name="trabajadoresEdit" id="trabajadoresEdit">
                                    </div>
                                </div>                                                
                            </div>

                            <div class="modal-body modalCliente">
                                <h5 class="titleClienteDatos" >Convertir oportunidad en cliente</h5>
                                <div class="form-row">
                                    <div class="form-group col-md-10">
                                        <label class="control-label">Marque "sí" para crear un cliente o colaborador a partir de esta información:</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="oportunidadCliEdit" id="oportunidadCli1" value="1">
                                            <label class="form-check-label" for="oportunidadCli1">
                                            Sí
                                            </label>                                                                                                                                 
                                        </div>
                                    </div>
                                </div>
                            </div>                        

                            <div class="modal-footer">
                                <button class="btn btn-warning" data-dismiss="modal" title="Cerrar Modal"><i class="far fa-window-close"></i></button>
                                <button type="submit" class="btn btn-success" id="btnUpdateOportunidad" title="Modificar"><i class="far fa-edit"></i></button>
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
                                <h4 class="modal-title" id="myModalLabel">Borrar Oportunidad</h4>
                            </center>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <form method="POST" action="borrarOportunidad">
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
                                    title="Eliminar cliente"><i class="fa fa-trash"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ==================== Termina la ventana modal para eliminar un registro =========================== -->
            <?php require(RUTA_APP . '/views/includes/footer2.php'); ?>