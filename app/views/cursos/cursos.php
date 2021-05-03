<?php require(RUTA_APP . '/views/includes/header2.php'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Cursos</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Cursos</li>
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
                        <label for="clienteProyecto">Buscar Curso:</label>
                        <select class="form-control select2" name="cursoFP" id="selectCursos" style="width: 100%;" required>
                            <option disable>Seleccionar.....</option>
                            <?php foreach ($datos['cursos'] as $cursos) : ?>
                                <option value="<?php echo $cursos->idGrado; ?> "><?php echo $cursos->nombre; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
            <hr>

            <table id="tablaAsignaturas" class="table table-striped table-bordered" style="display: none;" width="100%">
                <thead>
                    <tr>
                        <th>idAsignatura</th>
                        <th>Nombre</th>
                        <th>Abreviatura</th>
                        <th>Acción</th>

                    </tr>
                </thead>
                <tbody> </tbody>

                <tfoot>
                    <tr>
                        <th>idAsignatura</th>
                        <th>Nombre</th>
                        <th>Abreviatura</th>
                        <th>Acción</th>
                </tfoot>

            </table>

        </div>

    </div>
</div>


<?php require(RUTA_APP . '/views/includes/footer2.php'); ?>