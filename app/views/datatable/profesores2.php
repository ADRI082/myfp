<?php require(RUTA_APP . '/views/includes/header2.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Profesores</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Profesores</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        
      <div class="box">
				<div class="box-header">
					<div class="col-sm-12" style="margin-bottom:10px; border:solid 0.5px lightgrey;">
						<i class="fa fa-eye-slash fa-1x"></i> / <i class="fa fa-eye fa-1x"></i>
						<a class="toggle-vis btn" data-column="0">Nif</a> -
						<a class="toggle-vis btn" data-column="1">Raz&oacute;n Social</a> -
						<a class="toggle-vis btn" data-column="2">Nombre</a> -
						<a class="toggle-vis btn" data-column="3">Direcci&oacute;n</a> -
            <a class="toggle-vis btn" data-column="4">Poblaci&oacute;n</a> -
            <a class="toggle-vis btn" data-column="5">Provincia</a> -
            <a class="toggle-vis btn" data-column="6">C. Postal</a> -
            <a class="toggle-vis btn" data-column="7">Mail</a> -
            <a class="toggle-vis btn" data-column="8">CCC</a> -
					</div>
				</div>
	</div>


<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <a href = "<?php echo RUTA_URL ?>/Datatable/profesores/nuevo" id="btnModalAddBtn" class="btn modalAddBtn" title="Agregar profesor" 
        style="margin-bottom:20px;background-color:#001f3f;color:#fff;"><span class="fa fa-plus"></span></span>
      </a>      
      <div class="table-responsive">
          <table id="profesores" class="table table-striped table-bordered" style="width:100%">
              <thead style="background-color:#001f3f; color:#fff;">
                  <tr>
                      <th style="font-size:0.8em !important;">Nif</th>
                      <th style="font-size:0.8em !important;">Raz&oacute;n Social</th>
                      <th style="font-size:0.8em !important;"> Nombre</th>
                      <th style="font-size:0.8em !important;">Direcci&oacute;n</th>
                      <th style="font-size:0.8em !important;">Poblaci&oacute;n</th>
                      <th style="font-size:0.8em !important;">Provincia</th>
                      <th style="font-size:0.8em !important;"> C. Postal</th>
                      <th style="font-size:0.8em !important;">Mail</th>
                      <th style="font-size:0.8em !important;">CCC</th>
                      
                  </tr>
              </thead>
              <tbody>
              <?php foreach ($datos['profesores'] as $tipos) : ?>

                  <tr>
                      <td style="font-size:0.9em !important;"><?php echo $tipos->nifdniprofesor; ?></td>
                      <td style="font-size:0.9em !important;"><?php echo $tipos->RAZONSOCIAL; ?></td>
                      <td style="font-size:0.9em !important;"><?php echo $tipos->NOMBRECOMERCIAL; ?></td>
                      <td style="font-size:0.9em !important;"><?php echo $tipos->DIRECCION; ?></td>
                      <td style="font-size:0.9em !important;"><?php echo $tipos->POBLACION; ?></td>
                      <td style="font-size:0.9em !important;"><?php echo $tipos->PROVINCIA; ?></td>
                      <td style="font-size:0.9em !important;"><?php echo $tipos->CODPOSTAL; ?></td>
                      <td style="font-size:0.9em !important;"><?php echo $tipos->MAIL; ?></td>
                      <td style="font-size:0.9em !important;"><?php echo $tipos->CCC; ?></td>

                  </tr>
                  <?php endforeach; ?>
              </tbody>
              <tfoot style="background-color:#001f3f; color:#fff;">
                  <tr>
                  <th>Codigo</th>
                  <th>Nif</th>
                      <th style="font-size:0.8em !important;">Nif</th>
                      <th style="font-size:0.8em !important;">Raz&oacute;n Social</th>
                      <th style="font-size:0.8em !important;">Nombre</th>
                      <th style="font-size:0.8em !important;">Direcci&oacute;n</th>
                      <th style="font-size:0.8em !important;">Poblaci&oacute;n</th>
                      <th style="font-size:0.8em !important;">Provincia</th>
                      <th style="font-size:0.8em !important;">C. Postal</th>
                      <th style="font-size:0.8em !important;">Mail</th>
                      <th style="font-size:0.8em !important;">CCC</th>
                  </tr>
              </tfoot>
          </table>

      </div>

    </div>

  </div>

</div>




<?php require(RUTA_APP . '/views/includes/footer2.php'); ?>
