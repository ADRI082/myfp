<?php require(RUTA_APP . '/views/includes/header2.php'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Agentes Informa</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Agentes Informa</li>
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
                      <a class="toggle-vis btn" data-column="0">Id Agente</a> -
                      <a class="toggle-vis btn" data-column="1">DNI</a> -
                      <a class="toggle-vis btn" data-column="2">Nombre</a> -
                      <a class="toggle-vis btn" data-column="3">Apellidos</a> -                                                             
                      <a class="toggle-vis btn" data-column="4">Puesto</a> -                    
                      <a class="toggle-vis btn" data-column="5">Rol</a> -
                      <a class="toggle-vis btn" data-column="6">Email</a> -                      
                      <a class="toggle-vis btn" data-column="7">Acciones</a>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-lg-12">
              <a href="#modalAddAgente" class="btn modalAddBtn" title="Agregar agente" data-toggle="modal"
                style="margin-bottom:20px;background-color:#001f3f;color:#fff;"><span class="fa fa-plus"></span>
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
                <table id="agentes" class="table table-striped table-bordered" style="width:100%">
                  <thead style="background-color:#001f3f; color:#fff;">
                    <tr>
                      <th style="font-size:0.8em !important;">Id Agente</th>
                      <th style="font-size:0.8em !important;">DNI</th>
                      <th style="font-size:0.8em !important;">Nombre</th>
                      <th style="font-size:0.8em !important;">Apellidos</th>                  
                      <th style="font-size:0.8em !important;">Puesto</th>                      
                      <th style="font-size:0.8em !important;">Rol</th>
                      <th style="font-size:0.8em !important;">Email</th>                      
                      <th style="font-size:0.8em !important;">Acciones</th>                                
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($datos['agentes'] as $agente) : ?>
                    <tr>
                      <td style="font-size:0.9em !important;"><?php echo $agente->codagente; ?></td>
                      <td style="font-size:0.9em !important;"><?php echo $agente->DNIAgente; ?></td>
                      <td style="font-size:0.9em !important;"><?php echo $agente->Nombre; ?></td>
                      <td style="font-size:0.9em !important;"><?php echo $agente->Apellidos; ?></td>
                      <td style="font-size:0.9em !important;"><?php echo $agente->descripcion; ?></td>                      
                      <td style="font-size:0.9em !important;"><?php echo $agente->rol; ?></td>
                      <td style="font-size:0.9em !important;"><?php echo $agente->mail; ?></td>                      
                      <td style="font-size:0.9em !important;">
                  <?php                                
                      echo "
                        <div class='row'>
                          <div class='text-center'>
                            <a class='btn btn-info btn-sm updateAgente' data-id=".$agente->codagente." href='' title='Editar Agente'><i class='fas fa-pencil-alt'></i></a>
                          </div>
                          <div class='text-center'>
                            <a class='btn btn-danger btn-sm deleteAgente' data-id=".$agente->codagente." data-nombre=".$agente->Nombre." href='' title='Eliminar Agente'><i class='fa fa-trash'></i></a>
                          </div>
                        </div>";
                ?>                              
                      </td>
                    </tr>
                <?php endforeach; ?>
                  </tbody>
                  <tfoot style="background-color:#001f3f; color:#fff;">
                    <tr>
                      <th style="font-size:0.8em !important;">Id Agente</th>
                      <th style="font-size:0.8em !important;">DNI</th>
                      <th style="font-size:0.8em !important;">Nombre</th>
                      <th style="font-size:0.8em !important;">Apellidos</th>
                      <th style="font-size:0.8em !important;">Puesto</th>                      
                      <th style="font-size:0.8em !important;">Rol</th>
                      <th style="font-size:0.8em !important;">Email</th>                      
                      <th style="font-size:0.8em !important;">Acciones</th>     
                    </tr>
                  </tfoot>
                </table>
            </div>
          </div>
        </div>

    
    <!--Modal para agregar agente-->
    <div class="modal fade" id="modalAddAgente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Agregar agente</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!--<form method="POST" action="agregarAgente">-->
                <form method="POST" id="formAgregarAgenteInforma" action="<?php echo RUTA_URL; ?>/datatable/agregarAgente">              
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-3">
                              <div class="form-group">
                                <label for="" class="col-form-label">DNI</label>
                                <input type='text' regexp="[a-zA-Z0-9]{0,9}" class="form-control obligatorio" name="DNIAgente" id="DNIAgente" required>
                              </div> 
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group">
                                <label for="" class="col-form-label">Nombre</label>
                                <input type="text" class="form-control obligatorio" name="Nombre" id="Nombre" required>
                              </div>               
                            </div>
                            <div class="col-lg-5">
                              <div class="form-group">
                                <label for="" class="col-form-label">Apellidos</label>
                                <input type="text" class="form-control obligatorio" name="Apellidos" id="Apellidos" required>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Nº Cuenta Corriente</label>
                                  <input type='text' regexp="[0-9]{0,24}" class="form-control" name="numcuenta" id="numcuenta">
                                </div>
                            </div>                          
                            <div class="col-lg-6">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Dirección</label>
                                  <input type="text" class="form-control" name="Direccion" id="Direccion">
                                </div>
                            </div>    
                            <div class="col-lg-2">
                              <div class="form-group">
                                <label for="" class="col-form-label">Localidad</label>
                                <input type="text" class="form-control" name="Localidad" id="Localidad">
                              </div>
                            </div>    
                        </div>
                        <div class="row">
                          <div class="col-lg-4">
                              <div class="form-group">
                                <label for="" class="col-form-label">Provincia</label>
                                <input type="text" class="form-control" name="provincia" id="provincia">
                              </div>
                          </div>    
                          <div class="col-lg-4">    
                              <div class="form-group">
                                <label for="" class="col-form-label">Código postal</label>
                                <input type='text' regexp="[0-9]{0,5}" class="form-control" id="codigopostal" name="codigopostal">
                              </div>
                          </div>
                          <div class="col-lg-4">
                              <div class="form-group">
                                <label for="" class="col-form-label">Teléfono</label>
                                <input type='text' regexp="[0-9]{0,9}" class="form-control" id="telefono" name="telefono">
                                </select>                              
                              </div>
                          </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Móvil</label>
                                  <input type='text' regexp="[0-9]{0,9}" class="form-control" name="movil" id="movil">
                                </div>
                            </div>    
                            <div class="col-lg-4">    
                                <div class="form-group">
                                  <label for="" class="col-form-label">Puesto</label>
                                  <select class="form-control" name="puesto" id="puesto">
                                    <option disabled selected>Seleccione un puesto</option>
                                    <?php
                                    if ($datos['puestos']) {
                                        foreach ($datos['puestos'] as $key) {
                                            echo"
                                              <option value='".$key->idpuesto."' >".$key->descripcion."</option>";
                                        }
                                    }
                                    ?>
                                  </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="" class="col-form-label">Rol</label>
                                  <select class="form-control" name="idRol" id="idrol">
                                  <option value="">Seleccione un rol</option>
                                    <?php
                                    if ($datos['roles']) {
                                        foreach ($datos['roles'] as $key) {
                                            echo"
                                              <option value='".$key->idRol."' >".$key->rol."</option>";
                                        }
                                    }
                                    ?>
                                  </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                  <label for=regimen" class="col-form-label">Régimen</label>
                                  <select class="form-control" name="regimen" id="regimen">
                                    <option disabled selected>Seleccione un régimen</option>
                                    <?php
                                      $regimenes = ['Autónomo', 'Reg. General', 'Beca'];                                    
                                        foreach ($regimenes as $key) {
                                            echo"
                                              <option value='".$key."' >".$key."</option>";
                                        }                                    
                                    ?>
                                  </select>
                                  
                                </div>
                            </div>    
                            <div class="col-lg-4">    
                                <div class="form-group">
                                  <label for="fechaInicio" class="col-form-label">Fecha Inicio</label>
                                  <input type='date' class="form-control" name="fechaInicio" id="fechaInicio">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="fechaFin" class="col-form-label">Fecha Fin</label>
                                  <input type='date' class="form-control" name="fechaFin" id="fechaFin">
                                </div>
                            </div>
                        </div>
                        <div class="row">                         
                            <div class="col-lg-4">    
                                <div class="form-group">
                                  <label for="" class="col-form-label">email</label>
                                  <input type="text" class="form-control" name="email" id="email">
                                </div>
                            </div>
                            <div class="col-lg-4">    
                                <div class="form-group">
                                  <label for="" class="col-form-label">Password</label>
                                  <input type="text" class="form-control" name="password" id="password">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-12">    
                            <div class="form-group">
                              <label for="" class="col-form-label">Observaciones</label>
                              <textarea class="form-control" name="observaciones" id="observaciones"></textarea>                          
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
    <div class="modal fade" id="ModalUpdateAgente" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <center>
                      <h4 class="modal-title" id="myModalLabel">Editar Agente</h4>
                  </center>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <form method="POST" id="formEditarAgenteInforma"  action="<?php echo RUTA_URL; ?>/datatable/actualizarAgente">
                  
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-lg-2">
                        <div class="form-group">
                          <label for="" class="col-form-label">Id Agente</label>
                          <input type="text" class="form-control" name="codagente" id="codagente" readonly>
                        </div> 
                      </div>
                      <div class="col-lg-2">
                        <div class="form-group">
                          <label for="" class="col-form-label">DNI</label>
                          <input type='text' regexp="[a-zA-Z0-9]{0,9}" class="form-control obligatorio" name="DNIAgenteEdit" id="DNIAgenteEdit" required>
                        </div> 
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label for="" class="col-form-label">Nombre</label>
                          <input type="text" class="form-control obligatorio" name="NombreEdit" id="NombreEdit" required>
                        </div>               
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label for="" class="col-form-label">Apellidos</label>
                          <input type="text" class="form-control obligatorio" name="ApellidosEdit" id="ApellidosEdit" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-4">    
                        <div class="form-group">
                          <label for="" class="col-form-label">Nº Cuenta Corriente</label>
                          <input type='text' regexp="[0-9]{0,24}" class="form-control" name="numcuentadEdit" id="numcuentadEdit">
                        </div>
                      </div>                      
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="" class="col-form-label">Dirección</label>
                          <input type="text" class="form-control" name="DireccionEdit" id="DireccionEdit">
                        </div>
                      </div>    
                      <div class="col-lg-2">
                        <div class="form-group">
                          <label for="" class="col-form-label">Localidad</label>
                          <input type="text" class="form-control" name="LocalidadEdit" id="LocalidadEdit">
                        </div>
                      </div>    
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                              <label for="" class="col-form-label">Provincia</label>
                              <input type="text" class="form-control" name="provinciaEdit" id="provinciaEdit">
                            </div>
                        </div>    
                        <div class="col-lg-4">    
                            <div class="form-group">
                              <label for="" class="col-form-label">Código postal</label>
                              <input type='text' regexp="[0-9]{0,5}" class="form-control" id="codigopostalEdit" name="codigopostalEdit">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                              <label for="" class="col-form-label">Teléfono</label>
                              <input type='text' regexp="[0-9]{0,9}" class="form-control" id="telefonoEdit" name="telefonoEdit">
                              </select>                              
                            </div>
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                              <label for="" class="col-form-label">Móvil</label>
                              <input type='text' regexp="[0-9]{0,9}" class="form-control" name="movilEdit" id="movilEdit">
                            </div>
                        </div>    
                        <div class="col-lg-4">    
                            <div class="form-group">
                              <label for="" class="col-form-label">Puesto</label>
                              <select type="text" class="form-control" id="puestoEdit" name="puestoEdit">  
                                <option disabled selected>Seleccione un puesto</option>                              
                                <?php foreach ($datos['puestos'] as $puesto) : ?>
                                <option value="<?php echo $puesto->idpuesto; ?>">
                                    <?php echo $puesto->descripcion; ?></option>
                                <?php endforeach; ?>
                              </select>                              
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                              <label for="" class="col-form-label">Rol</label>                              
                              <select type="text" class="form-control" id="rolEdit" name="rolEdit">                                
                                <?php foreach ($datos['roles'] as $rol) : ?>
                                <option value="<?php echo $rol->idRol; ?>">
                                    <?php echo $rol->rol; ?></option>
                                <?php endforeach; ?>
                              </select>                              
                            </div>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                  <label for=regimen" class="col-form-label">Régimen</label>
                                  <select class="form-control" name="regimenEdit" id="regimenEdit">
                                    <option disabled selected>Seleccione un régimen</option>
                                    <?php
                                      $regimenes = ['Autónomo', 'Reg. General', 'Beca'];                                    
                                        foreach ($regimenes as $key) {
                                            echo"
                                              <option value='".$key."' >".$key."</option>";
                                        }                                    
                                    ?>
                                  </select>
                                  
                                </div>
                            </div>    
                            <div class="col-lg-4">    
                                <div class="form-group">
                                  <label for="fechaInicio" class="col-form-label">Fecha Inicio</label>
                                  <input type='date' class="form-control" name="fechaInicioEdit" id="fechaInicioEdit">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="fechaFin" class="col-form-label">Fecha Fin</label>
                                  <input type='date' class="form-control" name="fechaFinEdit" id="fechaFinEdit">
                                </div>
                            </div>
                        </div>
                    <div class="row">                    
                        <div class="col-lg-5">    
                          <div class="form-group">
                            <label for="" class="col-form-label">email</label>
                            <input type="text" class="form-control" name="emaildEdit" id="emaildEdit">
                          </div>
                        </div>
                        <div class="col-lg-4">    
                          <div class="form-group">
                            <label for="" class="col-form-label">Password</label>
                            <input type="password" class="form-control" name="passwordEdit" id="passwordEdit">
                          </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12">    
                        <div class="form-group">
                          <label for="" class="col-form-label">Observaciones</label>
                          <textarea class="form-control" name="observacionesEdit" id="observacionesEdit"></textarea>                          
                        </div>
                      </div>
                    </div>                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span>
                            Cancelar</button>
                        <button type="submit" name="editAgente" class="btn btn-primary"><span class="fa fa-check"></span>
                            Actualizar</button>
                    </div>
                  </div>
              </form>
          </div>
      </div>
    </div>
      
    <!--Modal para eliminar agente-->
    <div class="modal fade" id="ModalDeleteAgente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <center>
                        <h4 class="modal-title" id="myModalLabel2">Borrar Agente</h4>
                    </center>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <form method="POST" action="<?php echo RUTA_URL; ?>/datatable/borrarAgente">
                    <input type="hidden" id="id" name="id">
                    <div class="modal-body">
                      <p class="text-center">¿Estas seguro de eliminar el agente?</p>
                      <div id="" style="text-align: center;">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-warning" data-dismiss="modal" title="Cerrar ventana"><i class="far fa-window-close"></i></button>
                      <button type="submit" class="btn btn-danger" id="submitButton"
                          title="Eliminar agente"><i class="fa fa-trash"></i></button>
                    </div>
                </form>
            </div>
        </div>
     </div>




<?php require(RUTA_APP . '/views/includes/footer2.php'); ?>
