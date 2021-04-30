<?php require(RUTA_APP . '/views/includes/header2.php'); ?>
<?php
  $tiposGastosGenerales = $datos['tiposGastosGenerales'];
  $ctasContables = $datos['ctasContables'];

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Tipos de Gastos Generales</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Tipos de Gastos Generales</li>
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
              <a href="#modalAddTipoGasto" title="Agregar Tipo de Gasto" data-toggle="modal" id="btnModalAddBtn" class="btn modalAddBtn" 
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
                      if ($tiposGastosGenerales) {                                            
                      foreach ($tiposGastosGenerales as $tipo) : ?>
                        <tr>
                            <td class="text-center" style="font-size:0.9em !important;"><?php echo $tipo->idgasto; ?></td>                            
                            <td class="text-center" style="font-size:0.9em !important;"><?php echo $tipo->descripcion; ?></td>
                            <td class="text-center" style="font-size:0.9em !important;"><?php echo $tipo->nomCuentaContable." - ".$tipo->idCuentaContable; ?></td>                                                                         
                    <?php                                
                      echo "
                      <td style='font-size:0.9em !important;'> 
                        <div class='row justify-content-center'>
                          <div class='text-center'>
                            <a class='btn btn-info btn-sm btnUpdateTipoGasto' data-tipogasto='".$tipo->idgasto."' 
                              title='Editar'><i class='fas fa-pencil-alt text-white'></i></a>
                          </div>
                          <div class='text-center'>
                            <a class='btn btn-danger btn-sm btnDeleteTipoGasto' title='Eliminar' 
                              data-tipogasto='".$tipo->descripcion."' data-idtipogasto='".$tipo->idgasto."'><i class='fa fa-trash text-white'></i></a>
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
    <div class="modal fade" id="modalAddTipoGasto" tabindex="-1" role="dialog" aria-labelledby="Gastos Generales" aria-hidden="true"
        data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">                
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Agregar Tipo de Gastos Generales</h4>
                    <button type="button" class="close cerrarModalTipoGasto" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="formCrearTipoGasto" action="<?php echo RUTA_URL; ?>/GastosGenerales/agregarTipoGasto">
                      <input type="hidden" name="idGasto" id="idGasto">

                      <div class="modal-body modalCliente">
                        <h5 class="titleClienteDatos" >Datos del tipo de gasto</h5>
                        <div class="mb-3" >

                            <div class="form-group col-lg-12">
                              <label for="numFactura">Descripción</label>
                              <input type="text" class="form-control form-control-sm obligatorio actualizadorInput"  data-tabla="tipogastosgenerales"
                                data-idtabla="idgasto" data-campo="descripcion" required name="descripcion" id="descripcion">
                            </div>

                            <div class="form-group col-lg-12 selPres actividad">
                              <label for="numFactura">Cuenta Contable</label>

                              <select class="form-control form-control-sm select2 inputChange actualizadorInputChangeGastos" data-tabla="tipogastosgenerales"
                                data-idtabla="idgasto" data-campo="cuentacontable" name="cuentacontable" id="cuentacontable">
                                    <option selected disabled>&nbsp;</option>
                                    <?php foreach ($ctasContables as $cuenta) : ?>
                                    <option value="<?php echo $cuenta->id; ?>">
                                        <?php echo $cuenta->descripcion ." - ". $cuenta->cuentacontable ; ?></option>
                                    <?php endforeach; ?>
                              </select>                                   
                            </div>

                        </div>
   
                      <div class="modal-footer">
                          <button type="button" class="btn btn-light cerrarModalTipoGasto" data-dismiss="modal">Cancelar</button>
                          <button type="submit" id="btnGuardarTipoGasto" name="guardar" class="btn btn-success">Guardar</button>
                      </div>

                </form>
            </div>
        </div>
    </div>


    
<?php require(RUTA_APP . '/views/includes/footer2.php'); ?>
