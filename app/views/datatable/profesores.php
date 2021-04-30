<?php require(RUTA_APP . '/views/includes/header2.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Profesores y Centros de Formación</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Profesores y Centros de Formación</li>
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
                    <a class="toggle-vis btn" data-column="0">Id Profesor</a> -
                    <a class="toggle-vis btn" data-column="1">Nif</a> -
                    <a class="toggle-vis btn" data-column="2">Raz&oacute;n Social</a> -
                    <a class="toggle-vis btn" data-column="3">Nombre</a> -
                    <a class="toggle-vis btn" data-column="4">Perfil</a> -                   
                  </div>
                </div>
	            </div>
            </div>
            <div class="col-lg-12">
              <a href = "<?php echo RUTA_URL ?>/datatable/profesores/C" id="btnModalAddBtn" class="btn modalAddBtn" title="Agregar profesor" 
                style="margin-bottom:20px;background-color:#001f3f;color:#fff;"><span class="fa fa-plus"></span></span>
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
                <table id="profesores" class="table table-striped table-bordered" style="width:100%">
                  <thead style="background-color:#001f3f; color:#fff;">
                        <tr>
                          <th style="font-size:0.8em !important;">Id Profesor</th>
                          <th style="font-size:0.8em !important;">Nif</th>
                          <th style="font-size:0.8em !important;">Raz&oacute;n Social</th>
                          <th style="font-size:0.8em !important;">Nombre</th>
                          <th style="font-size:0.8em !important;">Perfil</th>
                          <th style="font-size:0.8em !important;">Acciones</th>                            
                        </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($datos['profesores'] as $tipos) : ?>
                        <tr>
                          <?php
                            $perfiles = json_decode($tipos->perfil);
                            if (count($perfiles) >0 ) {
                              $cadena = '';
                              foreach ($perfiles as $key) {
                                $cadena .= $key." ";
                              }
                            }else{
                              $cadena='';
                            }
                          ?>
                          <td style="font-size:0.9em !important;"><?php echo $tipos->idPROFESOR; ?></td>
                          <td style="font-size:0.9em !important;"><?php echo $tipos->nifdniprofesor; ?></td>
                          <td style="font-size:0.9em !important;"><?php echo $tipos->RAZONSOCIAL; ?></td>
                          <td style="font-size:0.9em !important;"><?php echo $tipos->NOMBRECOMERCIAL; ?></td>
                          <td style="font-size:0.9em !important;"><?php echo $cadena; ?></td>
                          <td style="font-size:0.9em !important;">
                          
                  <?php                                
                      echo "
                        <div class='row'>
                          <div class='text-center'>
                            <a class='btn btn-info btn-sm updateColaborador' href = '".RUTA_URL."/datatable/profesores/E/".$tipos->idPROFESOR."' 
                              title='Editar Colaborador'><i class='fas fa-pencil-alt'></i></a>
                          </div>
                          <div class='text-center'>
                            <a class='btn btn-danger btn-sm deleteProfesor' data-id='".$tipos->idPROFESOR."' data-nombre='".$tipos->NOMBRECOMERCIAL."'
                              href='' title='Eliminar Colaborador'><i class='fa fa-trash' class='text-white'></i></a>
                          </div>
                        </div>";
                  ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                  </tbody>
                  <tfoot style="background-color:#001f3f; color:#fff;">
                        <tr>
                          <th style="font-size:0.8em !important;">Id Profesor</th>
                          <th style="font-size:0.8em !important;">Nif</th>
                          <th style="font-size:0.8em !important;">Raz&oacute;n Social</th>
                          <th style="font-size:0.8em !important;">Nombre</th>
                          <th style="font-size:0.8em !important;">Perfil</th>
                          <th style="font-size:0.8em !important;">Acciones</th>                                                  
                        </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>

      
    <!--Modal para eliminar profesor-->
    <div class="modal fade" id="ModalDeleteProfesor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <center>
                                <h4 class="modal-title" id="myModalLabel">Borrar Colaborador</h4>
                            </center>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <form method="POST" action="<?php echo RUTA_URL; ?>/datatable/borrarProfesor">                                                            
                            <div class="modal-body">
                                <p class="text-center">¿Estás seguro de eliminar este registro?</p>
                                <input type="hidden" id="id" name="id"> 
                                <div id="nombreProfesor" style="text-align: center;">
                                  
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-warning" data-dismiss="modal" title="Cerrar ventana"><i
                                        class="far fa-window-close"></i></button>
                                <button type="submit" class="btn btn-danger" name="borrar"
                                    title="Eliminar colaborador"><i class="fa fa-trash"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
    </div>




    
<?php require(RUTA_APP . '/views/includes/footer2.php'); ?>
