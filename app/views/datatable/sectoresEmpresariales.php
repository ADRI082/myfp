<?php require(RUTA_APP . '/views/includes/header2.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Sectores Empresariales</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sectores Empresariales</li>
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
              <div class="box">
                <div class="box-header">
                  <div class="col-sm-12" style="margin-bottom:10px; border:solid 0.5px lightgrey;">
                    <i class="fa fa-eye-slash fa-1x"></i> / <i class="fa fa-eye fa-1x"></i>
                    <a class="toggle-vis btn" data-column="0">Código</a> -
                    <a class="toggle-vis btn" data-column="1">Nombre</a> -
                    <a class="toggle-vis btn" data-column="2">Acciones</a> -
                  </div>
                </div>
	            </div>
            </div>
            <div class="col-lg-12">
              <a href="#modalAddActEmpresarial" id="btnModalAddBtn" class="btn modalAddBtn" title="Agregar Act. Empresarial" data-toggle="modal"
                style="margin-bottom:20px;background-color:#001f3f;color:#fff;">Crear sector empresarial</span>
              </a>              
              <div class="table-responsive">
                <table id="sectoresEmpresariales" class="table table-striped table-bordered" style="width:100%">
                  <thead style="background-color:#001f3f; color:#fff;">
                        <tr>
                            <th style="font-size:0.8em !important;">Codigo/th>
                            <th style="font-size:0.8em !important;">Nombre</th>
                            <th style="font-size:0.8em !important;">Acciones</th>
                        </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($datos['sectores'] as $asector) : ?>
                        <tr>
                            <td style="font-size:0.9em !important;"><?php echo $asector->CODSECTOR; ?></td>
                            <td style="font-size:0.9em !important;"><?php echo $asector->SECTOR; ?></td>
                            <td style="font-size:0.9em !important;">
                <?php                                
                      echo "
                        <div class='row'>
                          <div class='text-center'>
                            <a class='btn btn-info btn-sm updateActEmpresariales' data-id=".$asector->CODSECTOR." href='' title='Editar Colaborador'><i class='fas fa-pencil-alt'></i></a>
                          </div>
                          <div class='text-center'>
                            <a class='btn btn-danger btn-sm deleteColaborador' data-id=".$asector->CODSECTOR." href='' title='Eliminar Colaborador'><i class='fa fa-trash' class='text-white'></i></a>
                          </div>
                        </div>";
                ?> 
                            </td>
                    <?php endforeach; ?>
                  </tbody>
                  <tfoot style="background-color:#001f3f; color:#fff;">
                        <tr>
                          <th style="font-size:0.8em !important;">Codigo CNAE</th>
                          <th style="font-size:0.8em !important;">Descripción</th>                          
                          <th style="font-size:0.8em !important;">Acciones</th>                         
                        </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>


    <!--Modal para agregar colaborador-->
    <div class="modal fade" id="modalAddActEmpresarial" tabindex="-1" role="dialog" aria-labelledby="Act. Empresarial" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">                
                <!--<form method="POST" action="agregarAgente">-->
                <form method="POST" action="<?php echo RUTA_URL; ?>/datatable/agregarColaborador">              
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-7">
                              <div class="form-group">                               
                                <label for="" class="col-form-label">Tipo de Colaborador</label>
                                <select class="form-control" name="codTipoCol" id="codTipoCol" required>
                                  <option value="">Seleccione un tipo</option>
                                  
      <?php
        $tipoColaborador = ['Agente Informa', 'Profesor', 'Asesor', 'Proveedor', 'Cliente'/*, 'CentroFormación'*/];
        foreach ($tipoColaborador as $key => $val) {
          echo"<option value='".$key."'>".$val."</option>";
        }
      ?>
                                </select>                                
                              </div> 
                            </div>
                            <div class="col-lg-5">
                              <div class="form-group">
                                <label for="" class="col-form-label">Colaborador</label>
                                <input type="text" class="form-control" name="NifColaborador" id="NifColaborador" required>                               
                              </div>               
                            </div>                           
                        </div>
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="form-group" style="display: none;">
                                  <label for="" class="col-form-label">Empresa vinculada</label>
                                  <select class="form-control" name="idEmpresa" id="idEmpresa" required>
                                    <option value="">Seleccione una empresa</option>
                                    <?php
                                        foreach ($datos['clientes'] as $cliente) {
                                          echo"
                                          <option value='".$cliente->idEMPRESA."'>".$cliente->NOMBREJURIDICO."</option>";
                                        }
                                    ?>
                                  </select>                                  
                                </div>
                            </div>    
                            <div class="col-lg-6">
                              <div class="form-group">
                                <label for="" class="col-form-label">Margen Comercial</label>
                                <input type="text" class="form-control" name="margencomercial" id="margencomercial" required>
                              </div>
                            </div>    
                        </div>                        
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Nombre Comercial</label>
                                  <input type="text" class="form-control" name="NombreComercial" id="NombreComercial" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Razón Social</label>
                                  <input type="text" class="form-control" name="RazonSocial" id="RazonSocial" required>
                                </div>
                            </div>                                                 
                        </div>
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Dirección</label>
                                  <input type="text" class="form-control" name="Direccion" id="Direccion">
                                </div>
                            </div>  
                            <div class="col-lg-3">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Código postal</label>
                                  <input type="text" class="form-control" name="codigopostal" id="codigopostal">
                                </div>
                            </div>                                                 
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Localidad</label>
                                  <input type="text" class="form-control" name="Localidad" id="Localidad">
                                </div>
                            </div>  
                            <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Provincia</label>
                                  <input type="text" class="form-control" name="provincia" id="provincia">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Numero Cuenta</label>
                                  <input type="text" class="form-control" name="numcuenta" id="numcuenta">
                                </div>
                            </div>  
                        </div>                        
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Contacto</label>
                                  <input type="text" class="form-control" name="Contactocolaborador" id="Contactocolaborador">
                                </div>
                            </div>  
                            <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Teléfono</label>
                                  <input type="text" class="form-control" name="telefonocolaborador" id="telefonocolaborador">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Móvil</label>
                                  <input type="text" class="form-control" name="movilcolaborador" id="movilcolaborador">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Email</label>
                                  <input type="text" class="form-control" name="emailcolaborador" id="emailcolaborador">
                                </div>
                            </div>  
                            <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Web</label>
                                  <input type="text" class="form-control" name="webcolaborador" id="webcolaborador">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Observaciones</label>
                                  <textarea type="text" class="form-control" name="observaciones" id="observaciones"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnGuardar" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Modal para editar agente-->
    <div class="modal fade" id="ModalUpdateColaborador" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <center>
                      <h4 class="modal-title" id="myModalLabel">Editar Colaborador</h4>
                  </center>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <form method="POST"  action="<?php echo RUTA_URL; ?>/datatable/actualizarColaborador">
                  <input type="hidden" name="idColaborador" id="idColaborador">
                  <input type="hidden" name="codColaborador" id="codColaborador"> 
                  <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-7">
                              <div class="form-group">                               
                                <label for="" class="col-form-label">Tipo de Colaborador</label>
                                <select class="form-control" name="codTipoColEdit" id="codTipoColEdit" required>                                  
                                  
      <?php
        $tipoColaborador = ['Agente Informa', 'Profesor', 'Asesor', 'Proveedor', 'Cliente'/*, 'CentroFormación'*/];
        foreach ($tipoColaborador as $key => $val) {
          echo"<option value='".$key."'>".$val."</option>";
        }
      ?>
                                </select>                                
                              </div> 
                            </div>
                            <div class="col-lg-5">
                              <div class="form-group">
                                <label for="" class="col-form-label">Colaborador</label>
                                <input type="text" class="form-control" name="NifColaboradorEdit" id="NifColaboradorEdit" required>                               
                              </div>               
                            </div>                           
                        </div>
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Empresa vinculada</label>
                                  <select class="form-control select2" name="idEmpresaEdit" id="idEmpresaEdit"  required>
                                    
                                    <?php
                                        foreach ($datos['clientes'] as $cliente) {
                                          echo"
                                          <option value='".$cliente->idEMPRESA."'>".$cliente->NOMBREJURIDICO."</option>";
                                        }
                                    ?>
                                  </select>                                  
                                </div>
                            </div>    
                            <div class="col-lg-5">
                              <div class="form-group">
                                <label for="" class="col-form-label">Margen Comercial</label>
                                <input type="text" class="form-control" name="margencomercialEdit" id="margencomercialEdit" required>
                              </div>
                            </div>    
                        </div>                        
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Nombre Comercial</label>
                                  <input type="text" class="form-control" name="NombreComercialEdit" id="NombreComercialEdit" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Razón Social</label>
                                  <input type="text" class="form-control" name="RazonSocialEdit" id="RazonSocialEdit" required>
                                </div>
                            </div>                                                 
                        </div>
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Dirección</label>
                                  <input type="text" class="form-control" name="DireccionEdit" id="DireccionEdit">
                                </div>
                            </div>  
                            <div class="col-lg-3">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Código postal</label>
                                  <input type="text" class="form-control" name="codigopostalEdit" id="codigopostalEdit">
                                </div>
                            </div>                                                 
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Localidad</label>
                                  <input type="text" class="form-control" name="LocalidadEdit" id="LocalidadEdit">
                                </div>
                            </div>  
                            <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Provincia</label>
                                  <input type="text" class="form-control" name="provinciaEdit" id="provinciaEdit">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Numero Cuenta</label>
                                  <input type="text" class="form-control" name="numcuentaEdit" id="numcuentaEdit">
                                </div>
                            </div>  
                        </div>                        
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Contacto</label>
                                  <input type="text" class="form-control" name="ContactocolaboradorEdit" id="ContactocolaboradorEdit">
                                </div>
                            </div>  
                            <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Teléfono</label>
                                  <input type="text" class="form-control" name="telefonocolaboradorEdit" id="telefonocolaboradorEdit">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Móvil</label>
                                  <input type="text" class="form-control" name="movilcolaboradorEdit" id="movilcolaboradorEdit">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Email</label>
                                  <input type="text" class="form-control" name="emailcolaboradorEdit" id="emailcolaboradorEdit">
                                </div>
                            </div>  
                            <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Web</label>
                                  <input type="text" class="form-control" name="webcolaboradorEdit" id="webcolaboradorEdit">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Observaciones</label>
                                  <textarea type="text" class="form-control" name="observacionesEdit" id="observacionesEdit"></textarea>
                                </div>
                            </div>
                        </div>
                  </div>
                  <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span>
                            Cancelar</button>
                        <button type="submit" name="editAgente" class="btn btn-primary"><span class="fa fa-check"></span>
                            Actualizar</button>
                  </div>
              </form>
          </div>
      </div>
    </div>

    <!--Modal para vincular colaborador-->
    <div class="modal fade" id="modalVincularColaborador" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Vincular colaborador</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="<?php echo RUTA_URL; ?>/datatable/vincularColaboradorEmpresa">              
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                              <div class="form-group">                               
                                <label for="" class="col-form-label">Colaborador</label>
                                <select class="form-control" name="idColaboradorVin" id="idColaboradorVin" required>
                                  <option value="">Seleccione un colaborador</option>
                                  <?php
                                        foreach ($datos['colabSelect'] as $colaborador) {
                                          echo"
                                          <option value='".$colaborador->codColaborador."'>".$colaborador->RazonSocial."</option>";
                                        }
                                    ?>                                                             
                                </select>
                              </div> 
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Empresa</label>
                                  <select class="form-control" name="idEmpresa" id="idEmpresa" required>
                                    <option value="">Seleccione una empresa</option>
                                    <?php
                                        foreach ($datos['clientes'] as $cliente) {
                                          echo"
                                          <option value='".$cliente->idEMPRESA."'>".$cliente->NOMBREJURIDICO."</option>";
                                        }
                                    ?>
                                  </select>                                  
                                </div>
                            </div>                                 
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnGuardar" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
      
    <!--Modal para eliminar agente-->
    <div class="modal fade" id="ModalDeleteColaborador" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <center>
                                <h4 class="modal-title" id="myModalLabel">Borrar Colaborador</h4>
                            </center>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <form method="POST" action="<?php echo RUTA_URL; ?>/datatable/borrarColaborador">
                            <input type="hidden" id="id" name="id">                                         
                            <div class="modal-body">
                                <p class="text-center">¿Estas seguro de eliminar este registro?</p>
                                <div id="" style="text-align: center;">
                                  
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-warning" data-dismiss="modal" title="Cerrar ventana"><i
                                        class="far fa-window-close"></i></button>
                                <button type="submit" class="btn btn-danger" id="submitButton"
                                    title="Eliminar colaborador"><i class="fa fa-trash"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
    </div>




    
<?php require(RUTA_APP . '/views/includes/footer2.php'); ?>
