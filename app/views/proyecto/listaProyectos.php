<?php require(RUTA_APP . '/views/includes/header2.php');

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
<?php
if ($datos['msg'] == 1) {
  echo"
    <div class='alert alert-danger alert-dismissible fade show container' role='alert'>
      <strong>No ha ingreso un correo válido y no se ha enviado el mensaje.</strong>.
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>
      ";
}
?>    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Proyectos</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Proyectos</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">


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
						<a class="toggle-vis btn" data-column="0">Id Grupo</a> -
						<a class="toggle-vis btn" data-column="1">Nombre Grupo/Proyecto</a> -
            <a class="toggle-vis btn" data-column="2">Servicio</a> -
            <a class="toggle-vis btn" data-column="3">Id Accion</a> -						
            <a class="toggle-vis btn" data-column="4">Acción</a> -												
            <a class="toggle-vis btn" data-column="5">F. Inicio</a> -						
            <a class="toggle-vis btn" data-column="6">F. Fin</a> -						
						<a class="toggle-vis btn" data-column="7">Estado</a> -
						<a class="toggle-vis btn" data-column="8">Acciones</a> -
					</div>
				</div>
			</div>
    </div>


<div class="col-lg-12">
<div class="table-responsive">
<table id="tabla_proyectos" class="table table-striped table-bordered" style="width:100%">
<thead style="background-color:#001f3f; color:#fff;">
            <tr>
                
                <th style="font-size:0.8em !important;">Id Grupo</th>
                <th style="font-size:0.8em !important;">Nombre Grupo/Proyecto</th>
                <th style="font-size:0.8em !important;">Servicio</th>
                <th style="font-size:0.8em !important;">Id Accion</th>   
                <th style="font-size:0.8em !important;">Acción</th>                
                <th style="font-size:0.8em !important;">F. Inicio</th>                
                <th style="font-size:0.8em !important;">F. Fin</th>                
                <th style="font-size:0.8em !important;">Estado</th>
                <th style="font-size:0.8em !important;">Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php
          foreach ($datos['listado'] as $listado) {
            echo"
              <tr>
                  
                  <td style='font-size:0.9em !important;'>".$listado->idProyecto."</td>
                  <td style='font-size:0.9em !important;'>".$listado->nombreProyecto."</td>
                  <td style='font-size:0.9em !important;'>".$listado->nombreServicio."</td>
                  <td style='font-size:0.9em !important;'>".$listado->accionformativa."</td>
                  <td style='font-size:0.9em !important;'>".$listado->NOMBREACCION."</td>
                  <td style='font-size:0.9em !important;'>".$listado->fechaInicio."</td>
                  <td style='font-size:0.9em !important;'>".$listado->fechaFin."</td>
                  <td style='font-size:0.9em !important;'>";
                    if ( $listado->fechaInicio >= date("Y-m-d") ) {
                      echo"Proyecto";
                    }else if ( $listado->fechaInicio < date("Y-m-d") ) {
                      if ( $listado->fechaFin > date("Y-m-d") || $listado->fechaFin =='') {
                        echo"En ejecución";
                      }else if ( $listado->fechaFin < date("Y-m-d") && $listado->fechaFin !='' ) {
                        echo"Terminado";
                      }
                    }
                  echo"
                  </td>
                  <td class='project-actions text-left'>
                      <a class='btn btn-primary btn-sm' href='".RUTA_URL."/proyecto/fichaProyecto/".$listado->idProyecto."'>
                        <i class='fas fa-eye'></i>
                      </a>";
                      /*<a class='btn btn-info btn-sm' href='#'>
                          <i class='fas fa-pencil-alt'></i>
                      </a>
                      <a class='btn btn-danger btn-sm' href='#'>
                        <i class='fas fa-trash'></i>
                      </a>*/
                  echo"
                  </td>
              </tr>";
          }
        ?>
        </tbody>
        <tfoot style="background-color:#001f3f; color:#fff;">
            <tr>
                <th>Id Grupo</th>
                <th style="font-size:0.8em !important;">Nombre Grupo/Proyecto</th>
                <th style="font-size:0.8em !important;">Servicio</th>
                <th style="font-size:0.8em !important;">Id Acción</th>
                <th style="font-size:0.8em !important;">Acción</th>                
                <th style="font-size:0.8em !important;">Estado</th>
                <th style="font-size:0.8em !important;">F. Inicio</th>                
                <th style="font-size:0.8em !important;">F. Fin</th>                                
                <th style="font-size:0.8em !important;">Acciones</th>
            </tr>
        </tfoot>
</table>

</div>

</div>

</div>

</div>






<?php require(RUTA_APP . '/views/includes/footer2.php'); ?>
