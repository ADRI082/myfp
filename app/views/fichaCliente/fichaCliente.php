<?php require(RUTA_APP . '/views/includes/header2.php'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Ficha cliente</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Ficha cliente</li>
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
                    <label for="clienteProyecto">Buscar Cliente:</label>
                    <select class="form-control select2 datos" name="clienteProyecto" id="probando"  style="width: 100%;" required>
                        <option disable>Seleccionar.....</option>
                        <?php foreach ($datos['clientes'] as $clientes) : ?>
                            <option   value="<?php echo $clientes->idEmpresa; ?> " ><?php echo $clientes->nombre; ?></option>
                        <?php endforeach; ?>
                    </select>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
            <hr>
            <div id="ficha"></div>

        </div>
    </div>


    <?php require(RUTA_APP . '/views/includes/footer2.php'); ?>