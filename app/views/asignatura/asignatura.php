<?php require(RUTA_APP . '/views/includes/header2.php'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Asignatura</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Asignatura</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">
        <div class="container-fluid">

            <div class="form-group">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <H3><?php echo $datos->nombre ?></H3>
                        <input type="hidden" id="idAsignatura" value="<?php echo $datos->idAsignatura ?>">
                    </div>
                    <div class="col-md-3">
                        <button type="button" data-toggle="modal" data-target="#modalSubidaFichero" id="addFichero" class="btn btn-success">Subir Archivo</button>
                    </div>
                </div>
            </div>
            <hr>

            <table id="tablaDocumentos" class="table table-striped table-bordered" style="display: none;" width="100%">
                <thead>
                    <tr>
                        <th>idArchivo</th>
                        <th>Nombre</th>
                        <th>Bloque</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody> </tbody>

                <tfoot>
                    <tr>
                        <th>idArchivo</th>
                        <th>Nombre</th>
                        <th>Bloque</th>
                        <th>Acción</th>
                </tfoot>

            </table>

        </div>

    </div>
</div>


<?php require(RUTA_APP . '/views/includes/footer2.php');
require(RUTA_APP . '/views/asignatura/modalSubirFichero.php')
?>