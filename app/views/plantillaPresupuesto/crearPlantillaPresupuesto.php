<?php require(RUTA_APP . '/views/includes/header2.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Plantillas Presupuesto</h1>
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

    <!-- Main content -->
    <section class="content">        
        <div class="container" >
            <a id="nuevaPlantilla" class="btn btn-primary btnNuevaPlantilla my-3">Nueva Plantilla</a>
            <div id='editorPlantilla' class="contenedoresPlantillas" style='display:none'>
                <form method="POST" action="CrearPlantillaPresupuesto/agregarPlantilla">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <h3>Diseño Plantillas Presupuestos</h3>
                            <br>
                        </div>
                    </div>
                    <!-- <div class="row"> -->
                    <!-- <div class="col-xs-12 col-sm-12 col-md-12"> -->
                    <div class="form-group">
                        <label for="nombreProyecto">Tipo Presupuesto</label>
                        <input class="form-control  form-control-sm "
                            name="tipoPesupuesto" required>

                    </div>
                    <textarea name="templatesPresupuesto" id="templatesPresupuesto" cols="60" rows="40"></textarea><br>
                
                    <button class="btn btn-primary">AÑADIR</button>
            
                </form>
            </div>
        </div>

    </section>

            <!-- /.content -->
    <section class="content">
        <div class="container contenedoresPlantillas">
            <div class="row">
                <div class="col-lg-12">
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
    </section>


</div>

    <?php require(RUTA_APP . '/views/includes/footer2.php'); ?>