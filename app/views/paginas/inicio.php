<?php require(RUTA_APP . '/views/includes/header2.php'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Usuarios</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Usuarios</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container">

      <div><a href="<?php echo RUTA_URL; ?>/paginas/agregar"><i class="fas fa-plus-square" style="font-size:28px;color:blue;"></i></a></div>
      <div class="col-lg-12">
        <div class="table-responsive">
    <table id="agentes" class="table table-striped table-bordered display" style="width: 100%;">

            <thead style="background-color:#001f3f; color:#fff;">
              <!-- <table class="table">
        <thead> -->
              <tr>
                <th style="font-size:0.8em !important;" >Id</th>
                <th style="font-size:0.8em !important;">Nombre</th>
                <th style="font-size:0.8em !important;">Mail</th>
                <th style="font-size:0.8em !important;">telefono</th>
                <th style="font-size:0.8em !important;">Password</th>
                <th style="font-size:0.8em !important;">Rol</th>
                <th style="font-size:0.8em !important;">Acciones</th>
              </tr>
            </thead>

            <tbody>
              <?php foreach ($datos['usuarios'] as $usuario) : ?>
                <tr>
                  <td style="font-size:0.9em !important;"><?php echo $usuario->id_usuario; ?></td>
                  <td style="font-size:0.9em !important;"><?php echo $usuario->nombre; ?></td>
                  <td style="font-size:0.9em !important;"><?php echo $usuario->mail; ?></td>
                  <td style="font-size:0.9em !important;"><?php echo $usuario->telefono; ?></td>
                  <td style="font-size:0.9em !important;"><?php echo $usuario->password; ?></td>
                  <td style="font-size:0.9em !important;"><?php echo $usuario->rol; ?></td>

                  <td class="project-actions text-right">

                    <a class="btn btn-info btn-sm" href="<?php echo RUTA_URL; ?>/paginas/editar/<?php echo $usuario->id_usuario; ?>">
                      <i class="fas fa-pencil-alt">
                      </i>
                    </a>
                    <a class="btn btn-danger btn-sm" href="<?php echo RUTA_URL; ?>/paginas/borrar/<?php echo $usuario->id_usuario; ?>">
                      <i class="fas fa-trash">
                      </i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>


            </tbody>
            <tfoot style="background-color:#001f3f; color:#fff;">
              <!-- <table class="table">
        <thead> -->
              <tr>
              <th style="font-size:0.8em !important;" >Id</th>
                <th style="font-size:0.8em !important;">Nombre</th>
                <th style="font-size:0.8em !important;">Mail</th>
                <th style="font-size:0.8em !important;">telefono</th>
                <th style="font-size:0.8em !important;">Password</th>
                <th style="font-size:0.8em !important;">Rol</th>
                <th style="font-size:0.8em !important;">Acciones</th>
              </tr>
            </tfoot>

          </table>

        </div>

        <div class="clearfix"></div>
        </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->


        <?php require(RUTA_APP . '/views/includes/footer2.php'); ?>
