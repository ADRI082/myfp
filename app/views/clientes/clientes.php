<?php require(RUTA_APP . '/views/includes/header2.php'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Clientes</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Clientes</li>
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
                                    <a class="toggle-vis btn" data-column="0">Id Cliente</a> -
                                    <a class="toggle-vis btn" data-column="1">Cif</a> -
                                    <a class="toggle-vis btn" data-column="2">Grupo</a> -
                                    <a class="toggle-vis btn" data-column="3">Raz&oacute;n Social</a> -
                                    <a class="toggle-vis btn" data-column="4">Nom. Comercial</a> -   
                                    <a class="toggle-vis btn" data-column="5">Repr. Legal</a> -                                
                                    <a class="toggle-vis btn" data-column="6">Acciones</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <a href="#modalAdd" class="btn modalAddBtn" data-toggle="modal"
                            style="margin-bottom:20px;background-color:#001f3f;color:#fff;"><span
                                class="fa fa-plus"></span></a>


              
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
                            <table id="table_clientes" class="table table-striped table-bordered" style="width:100%">
                                <thead style="background-color:#001f3f; color:#fff;">
                                    <tr>
                                        <th style="font-size:0.8em !important;">Id Cliente</th>
                                        <th style="font-size:0.8em !important;">Cif</th>
                                        <th style="font-size:0.8em !important;">Grupo</th>
                                        <th style="font-size:0.8em !important;">Raz&oacute;n Social</th>
                                        <th style="font-size:0.8em !important;">Nom. Comercial</th>
                                        <th style="font-size:0.8em !important;">Repr. Legal</th>
                                        <th style="font-size:0.8em !important;">Acciones</th>
                                        
                                    </tr>
                                </thead>

                                <tfoot style="background-color:#001f3f; color:#fff;">
                                    <tr>
                                        <th style="font-size:0.8em !important;">Id Cliente</th>
                                        <th style="font-size:0.8em !important;">Cif</th>
                                        <th style="font-size:0.8em !important;">Grupo</th>
                                        <th style="font-size:0.8em !important;">Raz&oacute;n Social</th>
                                        <th style="font-size:0.8em !important;">Nom. Comercial</th>
                                        <th style="font-size:0.8em !important;">Repr. Legal</th>
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
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <center>
                                <h4 class="modal-title" id="myModalLabel">Agregar Empresa</h4>
                            </center>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="Clientes/agregarEmpresa" id="formAgregarCliente">
                            <div class="modal-body modalCliente">
                                <h5 class="titleClienteDatos" >Datos de identificación</h5>
                                <div class="row form-group align-items-center">
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">Cif</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type='text' regexp="[a-zA-Z0-9]{0,9}" class="form-control form-control-sm obligatorio" name="cif" required>
                                    </div>                    
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">Grupo</label>
                                    </div>
                                    <div class="col-lg-3  selPres">
                                        <!--<select type="text" class="form-control form-control-sm select2" name="grupo">
                                            <option selected disabled>Seleccionar...</option>
                                            <?php //foreach ($datos['grupos'] as $grupos) : ?>
                                            <option value="<?php //echo $grupos->id; ?>">
                                                <?php //echo $grupos->nombreG; ?></option>
                                            <?php //endforeach; ?>
                                        </select>-->
                                        <div id="the-basics">
                                            <input class="typeahead form-control form-control-sm" type="text" name="grupo">                                            
                                        </div>
                                        <input type="hidden" name="grupoId" id="grupoId" >
                                    </div>
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">Razón Social</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control form-control-sm obligatorio" name="razonSocial" required>
                                    </div>                                                                     
                                </div>
                                <div class="row form-group align-items-center">
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative;">Nombre Comercial</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control form-control-sm" name="nombreComercial">
                                    </div>                                    
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative;">Sector Empresa</label>
                                    </div>
                                    <div class="col-lg-4 selPres sector">
                                        <select type="text" class="form-control form-control-sm select2" name="sector">
                                            <option selected disabled>Seleccionar...</option>
                                            <?php foreach ($datos['sector'] as $sector) : ?>
                                            <option value="<?php echo $sector->id; ?>">
                                                <?php echo $sector->SECTOR; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>  

                                </div>
                                <div class="row form-group align-items-center">
                                    <div class="col-lg-2">
                                        <label class="control-label"
                                            style="position:relative;">Representante Legal</label>
                                    </div>
                                    <div class="col-lg-2  selPres">
                                        <input type="text" class="form-control form-control-sm" name="representante">
                                    </div>
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">NIF</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type='text' regexp="[a-zA-Z0-9]{0,9}" class="form-control form-control-sm" name="nifRepresentante">
                                    </div>                                     
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative;">Contacto Principal</label>
                                    </div>
                                    <div class="col-lg-3  selPres">
                                        <input type="text" class="form-control form-control-sm" name="contactoPrincipal">
                                    </div>
                                </div>
                                <div class="row form-group align-items-center">
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative;">Colaborador</label>
                                    </div>
                                    <div class="col-lg-4 selPres colaborador">
                                        <select type="text" class="form-control form-control-sm select2 "  name="colaborador">
                                            <option selected disabled>Seleccionar...</option>
                                            <?php foreach ($datos['colaborador'] as $colaborador) : ?>
                                            <option value="<?php echo $colaborador->id; ?>">
                                                <?php echo $colaborador->RazonSocial; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="control-label"
                                            style="position:relative;">Agente Informa</label>
                                    </div>
                                    <div class="col-lg-4 selPres agente">
                                        <select type="text" class="form-control form-control-sm select2 "  name="agente">
                                            <option selected disabled>Seleccionar...</option>
                                            <?php foreach ($datos['agente'] as $agente) : ?>
                                            <option value="<?php echo $agente->id; ?>">
                                                <?php echo $agente->agente; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body modalCliente">
                                <h5 class="titleClienteDatos" >Datos de localización</h5>
                                <div class="row form-group">
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">Dirección</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control form-control-sm" name="direccion">
                                    </div>                                    
                                    <div class="col-lg-1">
                                        <label class="control-label"
                                            style="position:relative;">Localidad</label>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control form-control-sm " name="poblacion" >
                                    </div>                                    
                                    <div class="col-lg-1">
                                        <label class="control-label"
                                            style="position:relative;">Provincia</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="text" class="form-control form-control-sm " name="provincia" >
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">Cód. Postal</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type='text' regexp="[0-9]{0,5}" class="form-control form-control-sm" id="codigoPostal" name="codigoPostal">
                                    </div>                                    
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">Telef. fijo 1</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type='text' regexp="[0-9]{0,9}" class="form-control form-control-sm " name="telefonofijo1" >
                                    </div>

                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">Telef. fijo 2</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type='text' regexp="[0-9]{0,9}" class="form-control form-control-sm" name="telefonofijo2">
                                    </div>
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">
                                            Móvil</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type='text' regexp="[0-9]{0,9}" class="form-control form-control-sm" name="movil">
                                    </div>                                    
                                </div>
                                <div class="row form-group">
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">Email</label>
                                    </div>
                                    <div class="col-lg-5">
                                        <input type="email" class="form-control form-control-sm " name="email" >
                                    </div>                                
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">WEB</label>
                                    </div>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control form-control-sm" name="web">
                                    </div>
                                </div>
                                <div class="form-group mt-2">
                                    <button id="mostrarContactos" class="btn btn-secondary">Contactos &nbsp;&nbsp;<i class="fas fa-chevron-down" style="color: white;"></i></button>
                                </div> 
                                <div class="row form-group" style="display: none;" id="listadoContactos">
                                    
                                        <div class="col-lg-2 mb-2">
                                            <button id="agregarContacto" class="btn btn-success">Agregar Contacto</button>
                                        </div>                                
                                        <div class="col-lg-12">
                                            <table class="table table-sm" id="tablaContactosCliente">
                                                <thead >
                                                <div>
                                                    <th>#</th>
                                                    <th>Nombre</th>
                                                    <th>Área</th>
                                                    <th>Tel. Fijo</th>
                                                    <th>Móvil</th>
                                                    <th>Email</th>                                                
                                                    <th>&nbsp;</th>                                   
                                                </div>
                                                </thead>
                                                <tbody>                    
                                                </tbody>                    
                                            </table>
                                        </div>                                    
                                </div>
                            </div>
                            <div class="modal-body modalCliente">
                                <h5 class="titleClienteDatos" >Datos burocráticos</h5>
                                <div class="row form-group">
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">NISS</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type='text' regexp="[0-9]{0,12}" class="form-control form-control-sm" name="nss">
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="control-label"
                                            style="position:relative;">Actividad Empresarial:
                                        </label>
                                    </div>
                                    <div class="col-lg-3 selPres actividad">
                                        <select type="text" class="form-control form-control-sm select2" name="actividad">
                                            <option selected disabled>Seleccionar...</option>
                                            <?php foreach ($datos['actividad'] as $actividad) : ?>
                                            <option value="<?php echo $actividad->id; ?>">
                                                <?php echo $actividad->id." - ".$actividad->DESACTIVIDAD; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative;">Nº Cuenta Corriente</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type='text' regexp="[0-9]{0,24}" class="form-control form-control-sm" name="ctacte">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-lg-1">
                                        <label class="control-label"
                                            style="position:relative;">Forma de Pago:
                                        </label>
                                    </div>
                                    <div class="col-lg-2 selPres actividad">
                                        <select type="text" class="form-control form-control-sm select2" name="formadepago">
                                            <option selected disabled>Seleccionar...</option>
                                            <?php foreach ($datos['formasdepago'] as $formadepago) : ?>
                                            <option value="<?php echo $formadepago->id; ?>">
                                                <?php echo $formadepago->formadepago; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-1">
                                        <label class="control-label"
                                            style="position:relative;">Convenio</label>
                                    </div>
                                    <div class="col-lg-1">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="convenio" id="convenio1" value="1">
                                            <label class="form-check-label" for="convenio1">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="convenio" id="convenio2" value="0">
                                            <label class="form-check-label" for="convenio2">No</label>
                                        </div>                                    
                                    </div>
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">Fecha Convenio</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="date" class="form-control form-control-sm" name="fechaConvenio">
                                    </div>
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">RLT</label>
                                    </div>
                                    <div class="col-lg-1">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rlt" id="rlt1" value="1">
                                            <label class="form-check-label" for="rlt1">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rlt" id="rlt2" value="0">
                                            <label class="form-check-label" for="rlt2">No</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <label class="control-label"
                                            style="position:relative;">Nº Trabaj.</label>
                                    </div>
                                    <div class="col-lg-1">
                                        <input type="number" class="form-control form-control-sm" name="trabajadores">
                                    </div>
                                </div>                                
                                <div class="row form-group">
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative;">Estado Cliente</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="activo" id="estado1" value="Sí">
                                            <label class="form-check-label" for="estado1">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="activo" id="estado2" value="No">
                                            <label class="form-check-label" for="estado2">No</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="activo" id="estado3" value="Inactivo">
                                            <label class="form-check-label" for="estado3">Inactivo</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative;">Crédito formativo(€)</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="number" step="0.01" class="form-control form-control-sm" name="creditoFormativo">
                                    </div>                                      
                                </div>
                                <div class="row form-group">
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative;">
                                            Observaciones</label>
                                    </div>
                                    <div class="col-lg-10">
                                        <textarea name="observaciones" rows="2" class="form-control form-control-sm"></textarea>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body modalCliente">
                                <h5 class="titleClienteDatos" >Datos del asesor</h5>
                                <div class="row form-group">
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative;">Tipo de asesor</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="asesorTipo" id="asesor1" value="interno">
                                            <label class="form-check-label" for="asesor1">Interno</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="asesorTipo" id="asesor2" value="externo">
                                            <label class="form-check-label" for="asesor2">Externo</label>
                                        </div>                                                                                
                                    </div>
                                </div>
                                <div class="asesorExterno my-3 ml-0" style="display: none;" >
                                    <label class="form-check-label mr-3" for="asesor2">Seleccione: </label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="selAsesorExt" id="selAsesor1" value="nuevo">
                                        <label class="form-check-label" for="selAsesor1">Nuevo</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="selAsesorExt" id="selAsesor2" value="existe">
                                        <label class="form-check-label" for="selAsesor2">Existente</label>
                                    </div>
                                </div>
                                <div class="asesorInterno" style="display: none;" >
                                    <div class="row form-group" >
                                        <div class="col-lg-2">
                                            <label class="control-label" style="position:relative;">Nombre contacto</label>
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control form-control-sm " name="nomAsesorInt"> 
                                        </div>
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Telef. Fijo</label>
                                        </div>
                                        <div class="col-lg-2">
                                            <input type='text' regexp="[0-9]{0,9}" class="form-control form-control-sm " name="telefAsesorInt">
                                        </div>
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Móvil</label>
                                        </div>
                                        <div class="col-lg-2">
                                            <input type='text' regexp="[0-9]{0,9}" class="form-control form-control-sm" name="movfAsesorInt">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Dirección</label>
                                        </div>
                                        <div class="col-lg-5">
                                            <input type="text" class="form-control form-control-sm" name="dirAsesorInt">
                                        </div>                                    
                                        <div class="col-lg-1">
                                            <label class="control-label"
                                                style="position:relative;">Localidad</label>
                                        </div>
                                        <div class="col-lg-2">
                                            <input type="text" class="form-control form-control-sm" name="locAsesorInt">
                                        </div>                                    
                                        <div class="col-lg-1">
                                            <label class="control-label"
                                                style="position:relative;">Provincia</label>
                                        </div>
                                        <div class="col-lg-2">
                                            <input type="text" class="form-control form-control-sm" name="provAsesorInt">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Cod. Postal</label>
                                        </div>
                                        <div class="col-lg-1">
                                            <input type='text' regexp="[0-9]{0,5}" class="form-control form-control-sm" name="codPosAsesorInt">
                                        </div>
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Email</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control form-control-sm " name="mailAsesorInt">
                                        </div>
                                    </div>
                                </div>
                                <div class="asesorExtNuevo" style="display:  none;">
                                    <div class="row form-group" >
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Asesor</label>
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control form-control-sm " name="nomAsesorExt">
                                        </div>
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Contacto</label>
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control form-control-sm" name="contAsesorExt">
                                        </div>
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Telef. Fijo</label>
                                        </div>
                                        <div class="col-lg-1">
                                            <input type='text' regexp="[0-9]{0,9}" class="form-control form-control-sm " name="telefAsesorExt" >
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Móvil</label>
                                        </div>
                                        <div class="col-lg-2">
                                            <input type='text' regexp="[0-9]{0,9}" class="form-control form-control-sm" name="movfAsesorExt">
                                        </div>                                        
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Dirección</label>
                                        </div>
                                        <div class="col-lg-5">
                                            <input type="text" class="form-control form-control-sm" name="dirAsesorExt">
                                        </div>                                    
                                        <div class="col-lg-1">
                                            <label class="control-label"
                                                style="position:relative;">Localidad</label>
                                        </div>
                                        <div class="col-lg-2">
                                            <input type="text" class="form-control form-control-sm" name="locAsesorExt">
                                        </div>                                    
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Provincia</label>
                                        </div>
                                        <div class="col-lg-2">
                                            <input type="text" class="form-control form-control-sm" name="provAsesorExt">
                                        </div>                                        
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Cod. Postal</label>
                                        </div>
                                        <div class="col-lg-1">
                                            <input type='text' regexp="[0-9]{0,5}" class="form-control form-control-sm" name="codPosAsesorExt">
                                        </div>
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Email</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control form-control-sm " name="mailAsesorExt">
                                        </div>
                                    </div>
                                </div>
                                <div class="asesorExtExiste" style="display: none;">
                                    <div class="row form-group" >
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Asesor</label>
                                        </div>





                                        <div class="col-sm-4 selPres">
                                            <select type="text" class="form-control form-control-sm select2" name="selNomAsesorExt">
                                                <option selected disabled>Seleccionar...</option>
                                                <?php foreach ($datos['asesor'] as $asesor) : ?>
                                                <option value="<?php echo $asesor->idAsesor; ?>">
                                                    <?php echo $asesor->nomasesor; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            
                            <div class="modal-footer">
                                <button class="btn btn-warning" data-dismiss="modal" title="Cerrar Modal"><i
                                        class="far fa-window-close"></i></button>
                                <button type="submit" class="btn btn-primary" id="submitButton"
                                    title="Añadir empresa"><i class="fa fa-plus"></i></button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ==================== Termina la ventana modal para añadir un registro nuevo =========================== -->
            <!-- ==================== Empieza la ventana modal para editar =========================== -->
            <div class="modal fade" id="ModalEdit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <center>
                                <h4 class="modal-title" id="myModalLabel">Editar Empresa</h4>
                            </center>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="Clientes/editarEmpresa" id="formEditarCliente">
                            <div class="modal-body modalCliente">
                                <h5 class="titleClienteDatos" >Datos de identificación</h5>
                                <div class="row form-group align-items-center">
                                    <input type="hidden" name="idEdit" id="idEdit">
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">Id Cliente
                                        </label>
                                    </div>
                                    <div class="col-lg-1 text-center">
                                        <input type="number" id="codigoEdit" class="form-control form-control-sm" name="codigoEdit" readonly>
                                    </div>
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">Cif</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type='text' regexp="[a-zA-Z0-9]{0,9}" class="form-control form-control-sm" id="cifEdit"
                                            name="cifEdit" maxlength='9'>
                                    </div>
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">Razón
                                            Social</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control form-control-sm" id="nombreEdit"
                                            name="nombreEdit">
                                    </div>
                                </div>
                                <div class="row form-group align-items-center">                                    

                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">Nombre Comercial</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control form-control-sm" name="nombreComercialEdit"  id="nombreComercialEdit">
                                    </div>     
                                    
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">Grupo</label>
                                    </div>
                                    <div class="col-lg-3 selPres">
                                        <select type="text" class="form-control form-control-sm select2" id="grupoEdit"
                                            name="grupoEdit">
                                            <?php foreach ($datos['grupos'] as $grupos) : ?>
                                            <option value="<?php echo $grupos->id; ?>">
                                                <?php echo $grupos->nombreG; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>                                    

                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">Sector
                                            Empresa</label>
                                    </div>
                                    <div class="col-lg-2  selPres">
                                        <select type="text" class="form-control form-control-sm select2"
                                            name="sectorEdit" id = "sectorEdit">
                                            <?php foreach ($datos['sector'] as $sector) : ?>
                                            <option value="<?php echo $sector->id; ?>">
                                                <?php echo $sector->SECTOR; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>                                    
                                </div>
                                <div class="row form-group align-items-center">
                                    <div class="col-lg-1">
                                        <label class="control-label"
                                            style="position:relative;">Representante Legal</label>
                                    </div>
                                    <div class="col-lg-4  selPres">
                                        <input type="text" class="form-control form-control-sm" name="representanteEdit" id="representanteEdit">
                                    </div>
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">NIF</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type='text' regexp="[a-zA-Z0-9]{0,9}" class="form-control form-control-sm" name="nifRepresentanteEdit" id="nifRepresentanteEdit">
                                    </div>          
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">Contacto Principal</label>
                                    </div>
                                    <div class="col-lg-3  selPres">
                                        <input type="text" class="form-control form-control-sm" name="contactoPrincipalEdit" id="contactoPrincipalEdit">
                                    </div>                             
                                </div>

                                <div class="row form-group align-items-center">
                              
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">Colaborador</label>
                                    </div>                                    
                                    <div class="col-lg-3 colaborador selPres">
                                        <select type="text" class="form-control form-control-sm select2" name="colaboradorEdit" id="colaboradorEdit">
                                            <option selected disabled>Seleccionar...</option>
                                            <?php foreach ($datos['colaborador'] as $colaborador) : ?>
                                            <option value="<?php echo $colaborador->id; ?>">
                                                <?php echo $colaborador->RazonSocial; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>                                                                  
                                    <div class="col-lg-1">
                                        <label class="control-label"
                                            style="position:relative;">Agente Informa</label>
                                    </div>                                    
                                    <div class="col-lg-3 selPres agente">
                                        <select type="text" class="form-control form-control-sm select2" name="agenteEdit" id="agenteEdit">
                                            <option selected disabled>Seleccionar...</option>
                                            <?php foreach ($datos['agente'] as $agente) : ?>
                                            <option value="<?php echo $agente->id; ?>">
                                                <?php echo $agente->agente; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-body modalCliente">
                                <h5 class="titleClienteDatos" >Datos de localización</h5>
                                <div class="row form-group">
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">
                                            Dirección</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control form-control-sm" id="direccionEdit"
                                            name="direccionEdit">
                                    </div>
                                    <div class="col-lg-1">
                                        <label class="control-label"
                                            style="position:relative;">Poblacion</label>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control form-control-sm" id="poblacionEdit"
                                            name="poblacionEdit">
                                    </div>
                                    <div class="col-lg-1">
                                        <label class="control-label"
                                            style="position:relative;">Provincia</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="text" class="form-control form-control-sm" id="provinciaEdit"
                                            name="provinciaEdit">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">Codigo
                                            postal</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type='text' regexp="[0-9]{0,5}" class="form-control form-control-sm" id="codigoPostalEdit"
                                            name="codigoPostalEdit">
                                    </div>                                
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">Telef. fijo 1</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type='text' regexp="[0-9]{0,9}" class="form-control form-control-sm" id="telefonofijo1Edit"
                                            name="telefonofijo1Edit">
                                    </div>
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">Telef. fijo 2</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type='text' regexp="[0-9]{0,9}" class="form-control form-control-sm" id="telefonofijo2Edit"
                                            name="telefonofijo2Edit">
                                    </div>                                                            
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">
                                            Móvil</label>
                                    </div>                                
                                    <div class="col-lg-2">
                                        <input type='text' regexp="[0-9]{0,9}" class="form-control form-control-sm" id="movilEdit"
                                            name="movilEdit">
                                    </div>
                                </div>
                                <div class="row form-group"> 
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">Email</label>
                                    </div>
                                    <div class="col-lg-5">
                                        <input type="email" class="form-control form-control-sm" id="emailEdit"
                                            name="emailEdit">
                                    </div>                                
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">WEB</label>
                                    </div>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control form-control-sm" id="webEdit"
                                            name="webEdit">
                                    </div>
                                </div>

                                <div class="form-group mt-2">
                                    <button id="mostrarContactosEdit" class="btn btn-secondary">Contactos &nbsp;&nbsp;<i class="fas fa-chevron-down" style="color: white;"></i></button>
                                </div> 
                                <div class="row form-group" style="display: none;" id="listadoContactosEdit">
                                                                   
                                </div>

                            </div>
                            <div class="modal-body modalCliente">
                                <h5 class="titleClienteDatos" >Datos burocráticos</h5>
                                <div class="row form-group">
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">NISS
                                            Empresa</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type='text' regexp="[0-9]{0,12}" class="form-control form-control-sm" id="nssEdit"
                                            name="nssEdit">
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="control-label"
                                            style="position:relative;">Actividad Empresarial</label>
                                    </div>
                                    <div class="col-lg-3  selPres">
                                        <select type="text" class="form-control form-control-sm select2"
                                            name="actividadEdit" id = "actividadEdit">
                                            <option selected disabled>Seleccionar...</option>
                                            <?php foreach ($datos['actividad'] as $actividad) : ?>
                                            <option value="<?php echo $actividad->id; ?>">
                                                <?php echo $actividad->id." - ".$actividad->DESACTIVIDAD; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative;">Nº Cuenta Corriente</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type='text' regexp="[0-9]{0,24}" class="form-control form-control-sm" id="ctacteEdit" name="ctacteEdit">
                                    </div>                                    
                                </div>                                    
                                <div class="row form-group">
                                    <div class="col-lg-1">
                                        <label class="control-label"
                                            style="position:relative;">Forma de Pago:
                                        </label>
                                    </div>
                                    <div class="col-lg-2 selPres actividad">
                                        <select type="text" class="form-control form-control-sm select2" name="formadepagoEdit" id="formadepagoEdit">
                                            <option selected disabled>Seleccionar...</option>
                                            <?php foreach ($datos['formasdepago'] as $formadepago) : ?>
                                            <option value="<?php echo $formadepago->id; ?>">
                                                <?php echo $formadepago->formadepago; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-1">
                                        <label class="control-label"
                                            style="position:relative;">Convenio</label>
                                    </div>

                                    <div class="col-lg-1">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="convenioEdit" id="convenio1Edit" value="1">
                                            <label class="form-check-label" for="convenio1Edit">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="convenioEdit" id="convenio2Edit" value="0">
                                            <label class="form-check-label" for="convenio2Edit">No</label>
                                        </div>                                    
                                    </div>

                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">Fecha Convenio</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="date" class="form-control form-control-sm" name="fechaConvenioEdit" id = "fechaConvenioEdit">
                                    </div>                                
                                
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">RLT</label>
                                    </div>
                                    <div class="col-lg-1">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rltEdit" id="rlt1Edit" value="1">
                                            <label class="form-check-label" for="rlt1Edit">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rltEdit" id="rlt2Edit" value="0">
                                            <label class="form-check-label" for="rlt2Edit">No</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <label class="control-label"
                                            style="position:relative;">Nº Trabaj.</label>
                                    </div>
                                    <div class="col-lg-1">
                                        <input type="number" class="form-control form-control-sm"
                                            name="trabajadoresEdit" id = "trabajadoresEdit">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative;">Estado Cliente</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="activoEdit" id="estado1Edit" value="Sí">
                                            <label class="form-check-label" for="estado1Edit">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="activoEdit" id="estado2Edit" value="No">
                                            <label class="form-check-label" for="estado2Edit">No</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="activoEdit" id="estado3Edit" value="Inactivo">
                                            <label class="form-check-label" for="estado3Edit">Inactivo</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative;">Crédito formativo(€)</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="number" step="0.01" class="form-control form-control-sm" name="creditoFormativoEdit" id="creditoFormativoEdit">
                                    </div>                                    
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative;">
                                            Observaciones</label>
                                    </div>
                                    <div class="col-lg-10">
                                        <textarea name="observacionesEdit" id="observacionesEdit" rows="2" class="form-control form-control-sm"></textarea>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body modalCliente">
                                <h5 class="titleClienteDatos" >Datos del asesor</h5>

                                <div class="row form-group">
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative;">Tipo de asesor</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="asesorTipoEdit" id="asesor1Edit" value="interno">
                                            <label class="form-check-label" for="asesor1Edit">Interno</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="asesorTipoEdit" id="asesor2Edit" value="externo">
                                            <label class="form-check-label" for="asesor2Edit">Externo</label>
                                        </div>                                                                                
                                    </div>
                                </div>
                                <div class="asesorExterno my-3 ml-0" style="display: none;" >
                                    <label class="form-check-label mr-3" for="asesor2">Seleccione: </label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="selAsesorExtEdit" id="selAsesor1Edit" value="nuevo">
                                        <label class="form-check-label" for="selAsesor1Edit">Nuevo</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="selAsesorExtEdit" id="selAsesor2Edit" value="existe">
                                        <label class="form-check-label" for="selAsesor2Edit">Existente</label>
                                    </div>
                                </div>
                                <div class="asesorInterno" style="display: none;" >
                                    <div class="row form-group" >
                                        <div class="col-lg-2">
                                            <label class="control-label" style="position:relative;">Nombre contacto</label>
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control form-control-sm " name="contactoAsesorIntEdit" id="contactoAsesorIntEdit">
                                        </div>
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Telef. Fijo</label>
                                        </div>
                                        <div class="col-lg-2">
                                            <input type='text' regexp="[0-9]{0,9}" class="form-control form-control-sm " name="telefAsesorIntEdit" id="telefAsesorIntEdit">
                                        </div>
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Móvil</label>
                                        </div>
                                        <div class="col-lg-2">
                                            <input type='text' regexp="[0-9]{0,9}" class="form-control form-control-sm" name="movfAsesorIntEdit" id="movfAsesorIntEdit">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Dirección</label>
                                        </div>
                                        <div class="col-lg-3">
                                            <input type="text" class="form-control form-control-sm" name="dirAsesorIntEdit" id="dirAsesorIntEdit">
                                        </div>                                    
                                        <div class="col-lg-1">
                                            <label class="control-label"
                                                style="position:relative;">Localidad</label>
                                        </div>
                                        <div class="col-lg-2">
                                            <input type="text" class="form-control form-control-sm" name="locAsesorIntEdit" id="locAsesorIntEdit">
                                        </div>                                    
                                        <div class="col-lg-1">
                                            <label class="control-label"
                                                style="position:relative;">Provincia</label>
                                        </div>
                                        <div class="col-lg-2">
                                            <input type="text" class="form-control form-control-sm" name="provAsesorIntEdit" id="provAsesorIntEdit">
                                        </div>
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Cod. Postal</label>
                                        </div>
                                        <div class="col-lg-1">
                                            <input type='text' regexp="[0-9]{0,5}" class="form-control form-control-sm" name="codPosAsesorIntEdit" id="codPosAsesorIntEdit">
                                        </div>
                                    </div>
                                    <div class="row form-group">

                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Email</label>
                                        </div>
                                        <div class="col-lg-3">
                                            <input type="text" class="form-control form-control-sm " name="mailAsesorIntEdit" id="mailAsesorIntEdit">
                                        </div>
                                    </div>
                                </div>
                                <div class="asesorExtNuevo" style="display:  none;">
                                    <div class="row form-group" >
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Asesor</label>
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control form-control-sm " name="nomAsesorExtEdit" id="nomAsesorExtEdit">
                                        </div>
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Contacto</label>
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control form-control-sm" name="contAsesorExtEdit" id="contAsesorExtEdit">
                                        </div>
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Telef. Fijo</label>
                                        </div>
                                        <div class="col-lg-1">
                                            <input type='text' regexp="[0-9]{0,9}" class="form-control form-control-sm " name="telefAsesorExtEdit" id="telefAsesorExtEdit" >
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Móvil</label>
                                        </div>
                                        <div class="col-lg-2">
                                            <input type='text' regexp="[0-9]{0,9}" class="form-control form-control-sm" name="movfAsesorExtEdit" id="movfAsesorExtEdit">
                                        </div>                                        
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Dirección</label>
                                        </div>
                                        <div class="col-lg-5">
                                            <input type="text" class="form-control form-control-sm" name="dirAsesorExtEdit" id="dirAsesorExtEdit">
                                        </div>                                    
                                        <div class="col-lg-1">
                                            <label class="control-label"
                                                style="position:relative;">Localidad</label>
                                        </div>
                                        <div class="col-lg-2">
                                            <input type="text" class="form-control form-control-sm" name="locAsesorExtEdit" id="locAsesorExtEdit">
                                        </div>                                    
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Provincia</label>
                                        </div>
                                        <div class="col-lg-2">
                                            <input type="text" class="form-control form-control-sm" name="provAsesorExtEdit" id="provAsesorExtEdit">
                                        </div>                                        
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Cod. Postal</label>
                                        </div>
                                        <div class="col-lg-1">
                                            <input type='text' regexp="[0-9]{0,5}" class="form-control form-control-sm" name="codPosAsesorExtEdit" id="codPosAsesorExtEdit">
                                        </div>
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Email</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control form-control-sm " name="mailAsesorExtEdit" id="mailAsesorExtEdit">
                                        </div>
                                    </div>
                                </div>
                                <div class="asesorExtExiste" style="display: none;">
                                    <div class="row form-group" >
                                        <div class="col-lg-1">
                                            <label class="control-label" style="position:relative;">Asesor</label>
                                        </div>                                        
                                        <div class="col-sm-4 selPres">
                                            <select type="text" class="form-control form-control-sm select2" name="selNomAsesorExtEdit" id="selNomAsesorExtEdit">
                                                <option selected disabled>Seleccionar...</option>
                                                <?php foreach ($datos['asesor'] as $asesor) : ?>
                                                <option value="<?php echo $asesor->idAsesor; ?>">
                                                    <?php echo $asesor->nomasesor; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
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
            <!-- ==================== Termina la ventana modal para editar un registro nuevo =========================== -->
            <!-- ==================== Empieza la ventana modal para eliminar un registro =========================== -->
            <div class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <center>
                                <h4 class="modal-title" id="myModalLabel">Borrar Empresa</h4>
                            </center>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <form method="POST" action="Clientes/borrarEmpresa">
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