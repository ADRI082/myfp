<?php require(RUTA_APP . '/views/includes/header2.php'); ?>
<?php
  $tipoGastos = $datos['tipoGastos'];
  $proveedores = $datos['proveedores'];
  $cuentas = $datos['iban'];
  $gastos = $datos['gastosGenerales'];
  $tiposIva = $datos['tiposIva'];


?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Gastos Generales</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Gastos Generales</li>
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
                    <a class="toggle-vis btn" data-column="0">Id Gasto</a>
                    <a class="toggle-vis btn" data-column="1">Fecha Factura</a>   
                    <a class="toggle-vis btn" data-column="2">Nº Factura</a>        
                    <a class="toggle-vis btn" data-column="3">Tipo gasto</a>     
                    <a class="toggle-vis btn" data-column="4">Tipo proveedor</a>      
                    <a class="toggle-vis btn" data-column="5">Proveedor</a>     
                    <a class="toggle-vis btn" data-column="6">Valor</a>   
                    <a class="toggle-vis btn" data-column="7">Fecha pago</a>            
                    <a class="toggle-vis btn" data-column="8">Acciones</a>
                  </div>
                </div>
	            </div>
            </div>
            <div class="col-lg-12">
              <a href="#modalAddGasto" title="Agregar factura de gasto" data-toggle="modal" id="btnModalAddBtn" class="btn modalAddBtn" 
                style="margin-bottom:20px;"><span class="fa fa-plus"></span>
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
                            <th class="text-center" style="font-size:0.8em !important;">Id Gasto</th>
                            <th class="text-center" style="font-size:0.8em !important;">Fecha Factura</th>   
                            <th class="text-center" style="font-size:0.8em !important;">Nº Factura</th>        
                            <th class="text-center" style="font-size:0.8em !important;">Tipo gasto</th>     
                            <th class="text-center" style="font-size:0.8em !important;">Tipo proveedor</th>      
                            <th class="text-center" style="font-size:0.8em !important;">Proveedor</th>     
                            <th class="text-center" style="font-size:0.8em !important;">Valor</th>   
                            <th class="text-center" style="font-size:0.8em !important;">Fecha pago</th>            
                            <th class="text-center" style="font-size:0.8em !important;">Acciones</th>
                        </tr>
                  </thead>
                  <tbody>
                    <?php 
                      if ($gastos) {                                            
                      foreach ($gastos as $gasto) : ?>
                        <tr>
                            <td class="text-center" style="font-size:0.9em !important;"><?php echo $gasto['todos']->idgasto; ?></td>
                            <td class="text-center" style="font-size:0.9em !important;"><?php echo date('d-m-Y',strtotime($gasto['todos']->fecha)); ?></td>
                            <td class="text-center" style="font-size:0.9em !important;"><?php echo $gasto['todos']->numfacgasto; ?></td>
                            <td class="text-center" style="font-size:0.9em !important;"><?php echo $gasto['todos']->descTipGasto; ?></td>
                            <td class="text-center" style="font-size:0.9em !important;"><?php echo $gasto['todos']->tipoProveedor; ?></td>
                            <td class="text-center" style="font-size:0.9em !important;">
                              <?php echo $gasto['datosProveedor']->razonSocial; ?>
                              <span style="display: none;"><?php echo $gasto['datosProveedor']->nomComercial; ?></span>                                                          
                            </td>
                            <td class="text-right" style="font-size:0.9em !important;"><?php echo number_format($gasto['todos']->total,2,',','.'); ?></td>
                            <td class="text-center" style="font-size:0.9em !important;"><?php echo date('d-m-Y',strtotime($gasto['todos']->fechapago)); ?></td>                                                       
                    <?php                                
                      echo "
                      <td style='font-size:0.9em !important;'> 
                        <div class='row'>
                          <div class='text-center'>
                            <a class='btn btn-info btn-sm btnUpdateGastos' data-idfactura='".$gasto['todos']->idgasto."' title='Editar Factura'><i class='fas fa-pencil-alt text-white'></i></a>
                          </div>
                          <div class='text-center'>
                            <a class='btn btn-danger btn-sm btnDeleteGastos title='Eliminar Factura' data-idfactura=".$gasto['todos']->idgasto."><i class='fa fa-trash text-white'></i></a>
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
                          <th style="font-size:0.8em !important;">Id Gasto</th>
                          <th style="font-size:0.8em !important;">Fecha Factura</th>   
                          <th style="font-size:0.8em !important;">Nº Factura</th>        
                          <th style="font-size:0.8em !important;">Tipo gasto</th>     
                          <th style="font-size:0.8em !important;">Tipo proveedor</th>      
                          <th style="font-size:0.8em !important;">Proveedor</th>     
                          <th style="font-size:0.8em !important;">Valor</th>   
                          <th style="font-size:0.8em !important;">Fecha pago</th>            
                          <th style="font-size:0.8em !important;">Acciones</th>
                        </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

    <!--Modal para agregar gasto-->
    <div class="modal fade" id="modalAddGasto" tabindex="-1" role="dialog" aria-labelledby="Gastos Generales" aria-hidden="true"
        data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">                
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Agregar Factura de Gasto</h4>
                    <button type="button" class="close cerrar" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="formCrear" action="<?php echo RUTA_URL; ?>/GastosGenerales/agregarGastosGenerales">
                      <!--<input type="hidden" name="idGasto" id="idGasto">-->

                      <div class="modal-body modalCliente">
                        <h5 class="titleClienteDatos" >Datos de la Factura</h5>
                        <div class="form-row">


                          <div class="form-group col-lg-1 selPres actividad">
                            <label for="idGasto">Id Gasto</label>
                            <input type="text" class="form-control form-control-sm actualizadorInput"
                              name="idGasto" id="idGasto" readonly>
                          </div>
                          <div class="form-group col-lg-5 selPres actividad">
                            <label for="tipoGasto">Tipo de gasto</label>
                            <select type="text" class="form-control form-control-sm select2 obligatorio actualizadorInputChange" data-tabla="gastosaccionproy"
                              data-idtabla="idgasto" data-campo="tipoGasto" required name="tipoGasto">
                                  <option selected disabled>Seleccionar...</option>
                                  <?php foreach ($tipoGastos as $tipo) : ?>
                                  <option value="<?php echo $tipo->idgasto; ?>">
                                      <?php echo $tipo->descripcion; ?></option>
                                  <?php endforeach; ?>
                            </select>
                          </div>
                          <div class="form-group col-lg-6 selPres actividad">
                            <label for="proveedor">Proveedor</label>
                            <select type="text" class="form-control form-control-sm select2 obligatorio actualizadorInputChange" data-tabla="gastosaccionproy"
                              data-idtabla="idgasto" data-campo="tipoProveedor" required name="proveedor">
                                  <option selected disabled>Seleccionar...</option>
                                  <?php foreach ($proveedores as $proveedor) : ?>
                                  <option value="<?php echo $proveedor->tipo."-".$proveedor->id; ?>">
                                      <?php echo $proveedor->tipo." - ".$proveedor->nomComercial." - ".$proveedor->denominacion." - ".$proveedor->cif; ?></option>
                                  <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                        
                        <div class="form-row">
                          <div class="form-group col-lg-2">
                            <label for="numFactura">Número factura</label>
                            <input type="text" class="form-control form-control-sm obligatorio actualizadorInput"  data-tabla="gastosaccionproy"
                              data-idtabla="idgasto" data-campo="numfacgasto" required name="numFactura" id="numFactura">
                          </div>
                          <div class="form-group col-lg-2">
                            <label for="fechaFactura">Fecha factura</label>
                            <input type="date" class="form-control form-control-sm obligatorio actualizadorInput"  data-tabla="gastosaccionproy"
                              data-idtabla="idgasto" data-campo="fecha" required name="fechaFactura" id="fechaFactura">
                          </div>
                          <div class="form-group col-lg-2">
                            <label for="cantidad">Cantidad</label>
                            <input type="number" value="1" class="form-control form-control-sm obligatorio inputChange actualizadorInput"  data-tabla="gastosaccionproy"
                                    data-idtabla="idgasto" data-campo="cantidad" required name="cantidad" id="cantidad">
                          </div>                          
                          <div class="form-group col-lg-2">
                            <label for="baseImponible">Base Imponible(€)</label>
                            <input type="text" value="0" class="form-control form-control-sm obligatorio inputChange actualizadorInput"  data-tabla="gastosaccionproy"
                                    data-idtabla="idgasto" data-campo="importe" required name="baseImponible" id="baseImponible">
                          </div>
                          <div class="form-group col-lg-1">
                            <label for="irpf">IRPF(%)</label>
                            <input type="text" value="0" class="form-control form-control-sm inputChange actualizadorInput"  data-tabla="gastosaccionproy"
                              data-idtabla="idgasto" data-campo="irpf" name="irpf" id="irpf">
                          </div>
                          <div class="form-group col-lg-1">
                            <label for="iva">IVA(%)</label>
                            <select class="form-control form-control-sm inputChange actualizadorInputChange" data-tabla="gastosaccionproy"
                              data-idtabla="idgasto" data-campo="iva" data-tabla="gastosaccionproy" name="iva" id="iva">
                                  <option selected disabled>&nbsp;</option>
                                  <?php foreach ($tiposIva as $tipoIva) : ?>
                                  <option value="<?php echo $tipoIva->id; ?>">
                                      <?php echo $tipoIva->iva; ?></option>
                                  <?php endforeach; ?>
                            </select>
                          </div>                          
                          <div class="form-group col-lg-2">
                            <label for="totalGasto">Total a pagar(€)</label>
                            <input type="text" value="0" class="form-control form-control-sm actualizadorInput"  data-tabla="gastosaccionproy"
                              data-idtabla="idgasto" data-campo="total" readonly required name="totalGasto" id="totalGasto">
                          </div>                          
                        </div>

                        <div class="form-row">
                          <div class="form-group col-lg-8">
                            <label for="descripcion">Descripción / Concepto</label>
                            <input type="text" class="form-control form-control-sm actualizadorInput"  data-tabla="gastosaccionproy"
                              data-idtabla="idgasto" data-campo="descripcion" name="descripcion" id="descripcion">
                          </div>
                          <div class="form-group col-lg-2">
                            <label for="fechaPago">Fecha de pago</label>
                            <input type="date" class="form-control form-control-sm obligatorio actualizadorInput"  data-tabla="gastosaccionproy"
                              data-idtabla="idgasto" data-campo="fechapago" name="fechaPago" id="fechaPago">
                          </div>
                          <div class="form-group col-lg-2">
                            <label for="iban">IBAN</label>
                            <select class="form-control form-control-sm actualizadorInputChange" data-tabla="gastosaccionproy"
                              data-idtabla="idgasto" data-campo="iban" name="iban" id="iban">
                            <option selected disabled>Seleccionar...</option>
                              <?php
                                foreach ($cuentas as $cuenta) {
                                  echo"<option value='".$cuenta->idcuenta."'>".$cuenta->iban."</option>";
                                }                                
                              ?>
                              </select>                            
                          </div>                         
                        </div>                        
                                                                                       
                      </div>

                      <div class="modal-body modalCliente">
                        <h5 class="titleClienteDatos" >Asignación de gastos</h5>

                          <div class="row form-group">
                            <div class="col-lg-2">
                                <label class="control-label" style="position:relative;">Asignar gasto:</label>
                            </div>
                            <div class="col-lg-10 d-flex justify-content-around">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="asignacion" id="noRepatir" value="noRepatir">
                                    <label class="form-check-label" for="estado1">No repartir</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="asignacion" id="area" value="area">
                                    <label class="form-check-label" for="estado2">A un área</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="asignacion" id="areaProyecto" value="areaProyecto">
                                    <label class="form-check-label" for="estado3">A un área y un proyecto</label>
                                </div>
                            </div>
                          </div>

                          <div>
                            <div id="asignacionCostos1" class="form-row">                                  
                            </div>                                  
                          </div>

                      </div>

                      <div class="modal-footer">
                          <button type="button" class="btn btn-light cerrar" data-dismiss="modal">Cancelar</button>
                          <button type="submit" id="btnGuardar" name="guardar" class="btn btn-success">Guardar</button>
                      </div>

                </form>
            </div>
        </div>
    </div>


    
<?php require(RUTA_APP . '/views/includes/footer2.php'); ?>
