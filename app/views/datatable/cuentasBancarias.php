<?php require(RUTA_APP . '/views/includes/header2.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Cuentas Bancarias</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Cuentas Bancarias</li>
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
                    <a class="toggle-vis btn" data-column="0">Codigo CNAE</a> -
                    <a class="toggle-vis btn" data-column="1">Descripción</a> -
                    <a class="toggle-vis btn" data-column="2">Referencia web</a> -
                    <a class="toggle-vis btn" data-column="3">Acciones</a>
                  </div>
                </div>
	            </div>
            </div>
            <div class="col-lg-12">
              <a href="#modalAddCuentasBancarias" id="btnModalAddBtn" class="btn modalAddBtn" title="Agregar Act. Empresarial" data-toggle="modal"
                style="margin-bottom:20px;background-color:#001f3f;color:#fff;">Crear actividad empresarial</span>
              </a>              
              <div class="table-responsive">
                <table id="cuentasBancarias" class="table table-striped table-bordered" style="width:100%">
                  <thead style="background-color:#001f3f; color:#fff;">
                        <tr>
                            <th style="font-size:0.8em !important;">Nº</th>
                            <th style="font-size:0.8em !important;">Número de cuenta</th>                            
                            <th style="font-size:0.8em !important;">Acciones</th>
                        </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($datos['cuentasBancarias'] as $cuenta) : ?>
                        <tr>
                            <td style="font-size:0.9em !important;"><?php echo $cuenta->idcuenta; ?></td>
                            <td style="font-size:0.9em !important;"><?php echo $cuenta->iban; ?></td>
                            <td style="font-size:0.9em !important;">
                <?php                                
                      echo "
                        <div class='row'>
                          <div class='text-center'>
                            <a class='btn btn-info btn-sm updateActEmpresariales' data-id=".$cuenta->idcuenta." href='' title='Editar Actividad'><i class='fas fa-pencil-alt'></i></a>
                          </div>
                          <div class='text-center'>
                            <a class='btn btn-danger btn-sm deleteActividad' data-id=".$cuenta->idcuenta." href='' title='Eliminar Actividad'><i class='fa fa-trash' class='text-white'></i></a>
                          </div>
                        </div>";
                ?> 
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>


    <!--Modal para agregar colaborador-->
    <div class="modal fade" id="modalAddCuentasBancarias" tabindex="-1" role="dialog" aria-labelledby="Act. Empresarial" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">                
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Agregar Actividad Empresarial</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="<?php echo RUTA_URL; ?>/datatable/agregarActEmpresarial">              
                    <div class="modal-body">
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="codCnae" class="col-form-label">Código CNAE</label>
                          <input type="text" class="form-control obligatorio" name="codCnae" id="codCnae" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="" class="col-form-label">Descripción</label>
                          <input type="text" class="form-control obligatorio" name="desActividad" id="desActividad" required>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="" class="col-form-label">Observaciones</label>
                          <input type="text" class="form-control" name="observacionesAct" id="observacionesAct">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="" class="col-form-label">Enlace web</label>
                          <input type="text" class="form-control" name="enlaceAct" id="enlaceAct">
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

    <!--Modal para editar ActEmpresarial-->
    <div class="modal fade" id="ModalUpdateActEmpresarial" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <center>
                      <h4 class="modal-title" id="myModalLabel">Editar Actividad Empresarial</h4>
                  </center>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <form method="POST"  action="<?php echo RUTA_URL; ?>/datatable/actualizarActEmpresarial">                
                  <input type="hidden" name="idActividad" id="idActividad">

                  <div class="modal-body">
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="codCnae" class="col-form-label">Código CNAE</label>
                          <input type="text" class="form-control obligatorio" name="codCnaeEdit" id="codCnaeEdit" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="" class="col-form-label">Descripción</label>
                          <input type="text" class="form-control obligatorio" name="desActividadEdit" id="desActividadEdit" required>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="" class="col-form-label">Observaciones</label>
                          <input type="text" class="form-control" name="observacionesActEdit" id="observacionesActEdit">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="" class="col-form-label">Enlace web</label>
                          <input type="text" class="form-control" name="enlaceActEdit" id="enlaceActEdit">
                        </div>
                      </div>                                                                                                                                   
                    </div>
                  <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span>
                            Cancelar</button>
                        <button type="submit" class="btn btn-primary"><span class="fa fa-check"></span>
                            Actualizar</button>
                  </div>
              </form>
          </div>
      </div>
    </div>

     
    <!--Modal para eliminar ActEmpresarial-->
    <div class="modal fade" id="ModalDeleteActividad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <center>
                                <h4 class="modal-title" id="myModalLabel">Borrar Actividad</h4>
                            </center>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <form method="POST" action="<?php echo RUTA_URL; ?>/datatable/borrarActividadEmpresarial">
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
                                    title="Eliminar Actividad"><i class="fa fa-trash"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
    </div>




    
<?php require(RUTA_APP . '/views/includes/footer2.php'); ?>
