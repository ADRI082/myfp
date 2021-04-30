<?php require(RUTA_APP . '/views/includes/header2.php'); 

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Plantillas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Plantillas</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- /.content -->
    <div class="row">
        <div class="col-lg-10" style="margin: 0 auto">
            <div class="table-responsive">
                <table id="table_plantilla" class="table table-striped table-bordered" style="width:100%">
                    <thead style="background-color:#001f3f; color:#fff;">
                        <tr>
                            <th>Número</th>
                            <th>Tipo</th>                      
                            <th>Versión</th>                                                   
                            <th>Fecha Creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>

<?php require(RUTA_APP . '/views/includes/footer2.php'); ?>