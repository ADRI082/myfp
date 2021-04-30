<?php require(RUTA_APP . '/views/includes/header2.php'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">A&ntilde;adir Usuario</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">A&ntilde;adir Usuario</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">

      <div class="container">
        <div><a class="btn btn-secondary" href="<?php echo RUTA_URL; ?>/paginas"><i class="fa fa-backward"></i> Volver</a></div>
<br>
       
      </div>

 <!-- Main content -->
 <section class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">A&ntilde;adir Usuario</h3>

              </div>
              <div class="card-body">
    <form action="<?php echo RUTA_URL;  ?>/paginas/agregar" method="POST" required>
<div class="form group">
    <label for="nombre">Nombre: <sup>*</sup></label>
    <input type="text" name="nombre" class="form-control from-control-lg" required>
</div>
<div class="form group">
    <label for="mail">Mail: <sup>*</sup></label>
    <input type="email" name="mail" class="form-control from-control-lg" required>
</div>
<div class="form group">
    <label for="nombre">Telefono: <sup>*</sup></label>
    <input type="text" name="telefono" class="form-control from-control-lg" required>
</div>
<div class="form group">
    <label for="nombre">Contrase&ntilde;a: <sup>*</sup></label>
    <input type="text" name="password" class="form-control from-control-lg" required>
</div>
<div class="form group">
    <label for="nombre">Rol: <sup>*</sup></label>
    <input type="text" name="rol" class="form-control from-control-lg" placeholder="poner 0 por defecto" required>
</div>
<input type="submit" class="btn btn-success" value="Agregar Usuario" style="margin-top:1em !important;">
</form>

</div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>


        </div>
    </div>
    <div class="clearfix"></div>

    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->


<?php require(RUTA_APP . '/views/includes/footer2.php'); ?>