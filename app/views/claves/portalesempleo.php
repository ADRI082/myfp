<?php require(RUTA_APP . '/views/includes/header2.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Claves Portales Empleo</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Claves Portales Empleo</li>
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
      <div><a href="<?php echo RUTA_URL; ?>/claves/agregarPortalesempleo"><i class="fas fa-plus-square" style="font-size:28px;color:blue;"></i></a></div>
				<div class="box-header">
					<div class="col-sm-12" style="margin-bottom:10px; border:solid 0.5px lightgrey;">
						<i class="fa fa-eye-slash fa-1x"></i> / <i class="fa fa-eye fa-1x"></i>
						<a class="toggle-vis btn" data-column="0">Nombre</a> -
						<a class="toggle-vis btn" data-column="1">Usuario</a> -
                        <a class="toggle-vis btn" data-column="2">Clave</a> -
                        <a class="toggle-vis btn" data-column="3">Recurso</a> -
                        <a class="toggle-vis btn" data-column="4">Actualizado</a> -
                        <a class="toggle-vis btn" data-column="5">Observaciones</a> -
                        <a class="toggle-vis btn" data-column="6">Acciones</a>
					</div>
				</div>
	</div>

<div class="container">
<div class="row">
<div class="col-lg-12">
<div class="table-responsive">
<table id="claves_portales" class="table table-striped table-bordered" style="width:100%">
<thead style="background-color:#001f3f; color:#fff;">
            <tr>
                <th style="font-size:0.8em !important;">Nombre</th>
                <th style="font-size:0.8em !important;">Usuario</th>
                <th style="font-size:0.8em !important;">Clave</th>
                <th style="font-size:0.8em !important;">Recurso</th>
                <th style="font-size:0.8em !important;">Actualizado</th>
                <th style="font-size:0.8em !important;">Observaciones</th>
                <th style="font-size:0.8em !important;">Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($datos['registros'] as $acciones) : ?>

            <tr>
                <td style="font-size:0.9em !important;"><?php echo $acciones->nombre; ?></td>
                <td style="font-size:0.9em !important;"><?php echo $acciones->usuario; ?></td>
                <td style="font-size:0.9em !important;"><?php echo $acciones->clave; ?></td>
                <td style="font-size:0.9em !important;"><?php echo $acciones->pagina_web; ?></td>
                <td style="font-size:0.9em !important;"><?php echo $acciones->fecha_actualizacion; ?></td>
                <td style="font-size:0.9em !important;"><?php echo $acciones->observaciones; ?></td>
                <td class="project-actions text-right">

                    <a class="btn btn-info btn-sm" href="<?php echo RUTA_URL; ?>/claves/editarPortalesEmpleo/<?php echo $acciones->idClave; ?>">
                      <i class="fas fa-pencil-alt">
                      </i>
                    </a>
                    <a class="btn btn-danger btn-sm" href="<?php echo RUTA_URL; ?>/claves/borrarPortalesEmpleo/<?php echo $acciones->idClave; ?>">
                      <i class="fas fa-trash">
                      </i>
                    </a>
                  </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot style="background-color:#001f3f; color:#fff;">
            <tr>
                <th style="font-size:0.8em !important;">Nombre</th>
                <th style="font-size:0.8em !important;">Usuario</th>
                <th style="font-size:0.8em !important;">Clave</th>
                <th style="font-size:0.8em !important;">Recurso</th>
                <th style="font-size:0.8em !important;">Actualizado</th>
                <th style="font-size:0.8em !important;">Observaciones</th>
                <th style="font-size:0.8em !important;">Acciones</th>
            </tr>
        </tfoot>
</table>

</div>

</div>

</div>

</div>

<?php require(RUTA_APP . '/views/includes/footer2.php'); ?>