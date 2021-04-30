<?php require(RUTA_APP . '/views/includes/header2.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Registro personal</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Registro de personal</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <div class="content">
        <div class="container">

            <form id="criterios" action="<?php echo RUTA_URL;?>/reportesPersonal/recibeFiltros" method="POST">
                    <!-- inicio de los campos de busqueda del formulario -->

                    <div class="form-group">
                        <div class="row">
                        <div class="col-xs-12 col-md-3">
                        
                            </div>                       
                            <div class="col-xs-12 col-md-12">

                                <button class="btn btn-warning btn-md" id="btnBuscadorDatosPersonal">Buscar</button>                            
                                <button type="submit" name="export" class="btn btn-success" title="Exportar excel" value="Export"><i class="fas fa-file-excel"></i></button>
                            </div>
                        </div>
                    </div>
                   

                        <div class="form-group ">
                            <div class="row">
                                <div class="col-xs-12 col-md-4">
                                    <label for="exampleFormControlSelect1">Fecha Inicio</label>
                                    <input type="text" onfocus="(this.type = 'date')" class="form-control " name="desde"
                                        id="desde" placeholder="Desde">
                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <label for="exampleFormControlSelect2">Fecha Fin</label>
                                    <input type="text" onfocus="(this.type = 'date')" class="form-control " name="hasta"
                                        id="hasta" placeholder="Hasta">
                                </div>                
                                <div class="col-xs-12 col-md-4 d-flex flex-column">
                                    <label for="agente">Agente</label>
                                    <select class="form-control form-control-sm estado" 
                                            id="agente" name="agente[]" multiple>
                                        <option value="" disabled></option>
                                        <?php foreach ($datos['agentes'] as $agentes) : ?>
                                        <option value="<?php echo $agentes->codagente; ?>">
                                        <?php echo ucwords($agentes->agente); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    
                    <!-- fin de los campos de busqueda del formulario -->
            </form>
        </div> <!-- end of div class container -->
        <div class="clearfix"></div>
        <!-- line que divide el search de la zone de view result of search -->
    </div>

    <div class="container-fluid">
        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
        <div id="respuesta"></div>
    </div>


</div>


<?php require(RUTA_APP . '/views/includes/footer2.php'); ?>