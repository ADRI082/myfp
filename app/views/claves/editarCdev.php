<?php require(RUTA_APP . '/views/includes/header2.php'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Editar Usuario CDEV</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Editar Usuario CDEV</li>
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
        <div><a class="btn btn-secondary" href="<?php echo RUTA_URL; ?>/claves/cdev"><i class="fa fa-backward"></i> Volver</a></div>
<br>
       
      </div>


      <!-- =============================================== -->



      <!-- Main content -->
      <section class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Editar Usuario CDEV</h3>

              </div>
              <div class="card-body">
                <form action="<?php echo RUTA_URL;  ?>/claves/editarCdev/<?php echo $datos['idClave']; ?>" method="POST">
                <div class="form group">
                    <label for="pagina_web">Recurso: <sup>*</sup></label>
                    <input type="text" name="pagina_web" class="form-control from-control-lg" value="<?php echo $datos['pagina_web'];  ?>">
                  </div>
                <div class="form group">
                    <label for="nombre">Nombre: <sup>*</sup></label>
                    <input type="text" name="nombre" class="form-control from-control-lg" value="<?php echo $datos['nombre'];  ?>">
                  </div>
                  <div class="form group">
                    <label for="Usuario">Usuario: <sup>*</sup></label>
                    <input type="text" name="usuario" class="form-control from-control-lg" value="<?php echo $datos['usuario'];  ?>">
                  </div>
                  <div class="form group">
                    <label for="clave">Clave: <sup>*</sup></label>
                    <input type="text" name="clave" class="form-control from-control-lg" value="<?php echo $datos['clave'];  ?>">
                  </div>
                  <div class="form group">
                    <label for="observaciones">Observaciones: <sup>*</sup></label>
                    <input type="text" name="observaciones" class="form-control from-control-lg" value="<?php echo $datos['observaciones'];  ?>">
                  </div>
                  <input type="submit" class="btn btn-success" value="Editar Usuario" style="margin-top:1em !important;">
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