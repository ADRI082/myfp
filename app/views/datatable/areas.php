<?php require(RUTA_APP . '/views/includes/header2.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Areas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Areas</li>
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
						<a class="toggle-vis btn" data-column="0">Codigo</a> -
						<a class="toggle-vis btn" data-column="1">Descripci&oacute;n</a> -
						<a class="toggle-vis btn" data-column="2">Observaciones</a> -

					</div>
				</div>
	</div>

<div class="container">
<div class="row">
<div class="col-lg-12">
<div class="table-responsive">
<table id="example" class="table table-striped table-bordered" style="width:100%">
<thead style="background-color:#001f3f; color:#fff;">
            <tr>
                <th style="font-size:0.8em !important;">Codigo</th>
                <th style="font-size:0.8em !important;">Descripci&oacute;n</th>
                <th style="font-size:0.8em !important;">Observaciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($datos['areas'] as $acciones) : ?>

            <tr>
                <td style="font-size:0.9em !important;"><?php echo $acciones->codigo; ?></td>
                <td style="font-size:0.9em !important;"><?php echo $acciones->descripcion; ?></td>
                <td style="font-size:0.9em !important;"><?php echo $acciones->observaciones; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot style="background-color:#001f3f; color:#fff;">
            <tr>
            <th style="font-size:0.8em !important;">Codigo</th>
                <th style="font-size:0.8em !important;">Descripci&oacute;n</th>
                <th style="font-size:0.8em !important;">Observaciones</th>
            </tr>
        </tfoot>
</table>

</div>

</div>

</div>

</div>




<?php require(RUTA_APP . '/views/includes/footer2.php'); ?>
