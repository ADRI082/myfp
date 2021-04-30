<?php require(RUTA_APP . '/views/includes/header2.php'); ?>
<?php
  $cuentasContables = $datos['cuentasContables'];

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Cuentas Contables</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Cuentas Contables</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    
      <div class="container">
        <div class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <div class="col-sm-12" style="margin-bottom:10px; border:solid 0.5px lightgrey;">
                    <i class="fa fa-eye-slash fa-1x"></i> / <i class="fa fa-eye fa-1x"></i>
                    <a class="toggle-vis btn" data-column="0">Nº</a>
                    <a class="toggle-vis btn" data-column="1">Descripcion</a>   
                    <a class="toggle-vis btn" data-column="2">Cuenta Contable</a>                             
                    <a class="toggle-vis btn" data-column="3">Acciones</a>
                  </div>
                </div>
	            </div>
            </div>
            <div class="col-lg-12">
              <a href="#modalAddCuenta" title="Agregar Cuenta Contable" data-toggle="modal" id="btnModalAddBtn" class="btn modalAddBtn" 
                style="margin-bottom:20px;"><i class="far fa-plus-square"></i>&nbsp; Nuevo</span>
              </a>   
                          
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
                <table id="tablaGastosGenerales" class="table table-striped table-bordered" style="width:100%">
                  <thead style="background-color:#001f3f; color:#fff;">
                        <tr>                          
                            <th class="text-center" style="font-size:0.8em !important;">Nº</th>
                            <th class="text-center" style="font-size:0.8em !important;">Descripción</th>   
                            <th class="text-center" style="font-size:0.8em !important;">Cuenta Contable</th>                                                                       
                            <th class="text-center" style="font-size:0.8em !important;">Acciones</th>
                        </tr>
                  </thead>
                  <tbody>
                    <?php 
                      if ($cuentasContables) {                                            
                      foreach ($cuentasContables as $cuenta) : ?>
                        <tr>
                            <td class="text-center" style="font-size:0.9em !important;"><?php echo $cuenta->id; ?></td>                            
                            <td class="text-center" style="font-size:0.9em !important;"><?php echo $cuenta->descripcion; ?></td>
                            <td class="text-center" style="font-size:0.9em !important;"><?php echo $cuenta->cuentacontable; ?></td>                                                                         
                    <?php                                
                      echo "
                      <td style='font-size:0.9em !important;'> 
                        <div class='row justify-content-center'>
                          <div class='text-center'>
                            <a class='btn btn-info btn-sm btnUpdateCtaContable' data-ctacontable='".$cuenta->id."' title='Editar Cta. Contable'><i class='fas fa-pencil-alt text-white'></i></a>
                          </div>
                          <div class='text-center'>
                            <a class='btn btn-danger btn-sm btnDeleteCtaContable' title='Eliminar Cta. Contable' data-ctacontable='".$cuenta->cuentacontable."' data-idctacontable='".$cuenta->id."'><i class='fa fa-trash text-white'></i></a>
                          </div>
                        </div>
                      </td></tr>";
                    ?> 
                    <?php endforeach;
                          }
                    ?>
                  </tbody>
                  <tfoot style="background-color:#001f3f; color:#fff;">
                        <tr>
                          <th style="font-size:0.8em !important;">Nº</th>
                          <th style="font-size:0.8em !important;">Descripción</th>   
                          <th style="font-size:0.8em !important;">Cuenta Contable</th>                    
                          <th style="font-size:0.8em !important;">Acciones</th>
                        </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

    <!--Modal para agregar cuenta contable-->
    <div class="modal fade" id="modalAddCuenta" tabindex="-1" role="dialog" aria-labelledby="Gastos Generales" aria-hidden="true"
        data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">                
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Agregar Cuenta Contable</h4>
                    <button type="button" class="close cerrarModalCtaCtble" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="formCrearCuentaContable" action="<?php echo RUTA_URL; ?>/GastosGenerales/agregarCuentaContable">
                      <input type="hidden" name="idGasto" id="idGasto">

                      <div class="modal-body modalCliente">
                        <h5 class="titleClienteDatos" >Datos de la Cuenta Contable</h5>
                        <div class="form-row">

                            <div class="form-group col-lg-6">
                              <label for="numFactura">Descripción</label>
                              <input type="text" class="form-control form-control-sm obligatorio actualizadorInput"  data-tabla="cuentascontables"
                                data-idtabla="id" data-campo="descripcion" required name="descripcion" id="descripcion">
                            </div>

                            <div class="form-group col-lg-6">
                              <label for="numFactura">Cuenta Contable</label>
                              <input type="text" class="form-control form-control-sm obligatorio actualizadorInput"  data-tabla="cuentascontables"
                                data-idtabla="id" data-campo="cuentacontable" required name="cuentacontable" id="cuentacontable">
                            </div>

                        </div>
   
                      <div class="modal-footer">
                          <button type="button" class="btn btn-light cerrarModalCtaCtble" data-dismiss="modal">Cancelar</button>
                          <button type="submit" id="btnGuardarCuenta" name="guardar" class="btn btn-success">Guardar</button>
                      </div>

                </form>
            </div>
        </div>
    </div>


    
<?php require(RUTA_APP . '/views/includes/footer2.php'); ?>
