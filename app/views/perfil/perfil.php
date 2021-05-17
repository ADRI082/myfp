<?php require(RUTA_APP . '/views/includes/header2.php'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Editar Usuario</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Editar Usuario</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">


            <!-- <div class="container">
        <div><a class="btn btn-secondary" href="<?php echo RUTA_URL; ?>/paginas"><i class="fa fa-backward"></i> Volver</a></div>
<br>
       
      </div> -->


            <!-- =============================================== -->



            <!-- Main content -->
            <section class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Editar Usuario</h3>

                            </div>
                            <div class="card-body">
                                <form method="POST" id="formEditUsuario">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="" class="col-form-label">Nickname</label>
                                                <input type="text" class="form-control obligatorio" name="nickNameEdit" id="nickNameEdit" value="<?php echo $datos->nickname; ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="" class="col-form-label">Nombre</label>
                                                <input type="text" class="form-control obligatorio" name="NombreEdit" id="NombreEdit" value="<?php echo $datos->nombre; ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="" class="col-form-label">Apellidos</label>
                                                <input type="text" class="form-control obligatorio" name="ApellidosEdit" id="ApellidosEdit" value="<?php echo $datos->apellido; ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="" class="col-form-label">Email</label>
                                                <input type="text" class="form-control " name="emailEdit" id="emailEdit" value="<?php echo $datos->email; ?>" >
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="" class="col-form-label">Contraseña</label>
                                                <input type="password" class="form-control " name="passwordEdit" id="passwordEdit" value="<?php echo $datos->password; ?>" >
                                            </div>
                                        </div>
                                    </div>
                                    <input type="button" id="editUsuario" class="btn btn-success" value="Editar Usuario" style="margin-top:1em !important;">
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