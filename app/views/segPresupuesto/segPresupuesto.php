<?php require(RUTA_APP . '/views/includes/header2.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Seguimiento Acciones</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Seguimiento Presupuestos</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <div class="content">
        <div class="container">

            <form id="criterios">
                <!-- inicio de los campos de busqueda del formulario -->

                <div class="form-group">
                    <div class="row">
                    <div class="col-xs-12 col-md-3">
                      
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <select class="form-control form-control-sm boxing"  name="periodo" id="periodo">
                                <option>Seleccionar</option>
                                <option value="presupuestados">Cursos Presupuestados</option>
                                <option value="desestimados">Cursos Desestimados</option>
                                <option value="proyectados">Cursos Proyectados</option>
                                <option value="ejecucion">Cursos en Ejecución</option>
                                <option value="finalizados">Cursos Finalizados</option>
                            </select>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <a class="btn btn-secondary" data-toggle="collapse" href="#collapseExample" role="button"
                                aria-expanded="false" aria-controls="collapseExample">
                                <i class="fas fa-filter"></i> Filtros
                            </a>
                            <button class="btn btn-warning btn-md" id="btnBuscadorClientes">Buscar</button>
                        </div>
                    </div>
                </div>
                <div class="collapse" id="collapseExample">
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-xs-12 col-md-3">
                                <label for="exampleFormControlSelect1">Servicio</label>
                                <select class="form-control form-control-sm boxing servicio" id="servicio"
                                    name="servicio[]" multiple>
                                    <?php foreach ($datos['servicio'] as $servicio) : ?>
                                    <option value="<?php echo $servicio->id; ?>">
                                    <?php echo $servicio->nombreS; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>                            
                            <div class="col-xs-12 col-md-3">
                                <label for="exampleFormControlSelect1">Tipo</label>
                                <select class="form-control form-control-sm tipo boxing" id="tipo"
                                    name="tipo[]" multiple>
                                    <?php foreach ($datos['tipologia'] as $tipologia) : ?>
                                                <option value="<?php echo $tipologia->id; ?>">
                                                    <?php echo $tipologia->tipologia; ?></option>
                                                <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-xs-12 col-md-3">
                                <label for="">Grupo</label>
                                <select class="form-control form-control-sm boxing grupo" id="grupo"
                                    name="grupo[]" multiple>
                                    <?php foreach ($datos['grupos'] as $grupos) : ?>
                                    <option value="<?php echo $grupos->id; ?>">
                                        <?php echo $grupos->nombreG; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-xs-12 col-md-3">
                                <label for="">Empresa</label>
                                <select class="form-control form-control-sm select2grande empresa " id="empresa" 
                                    name="empresa[]" multiple>
                                    <?php foreach ($datos['clientes'] as $clientes) : ?>
                                    <option value="<?php echo $clientes->id; ?>">
                                        <?php echo $clientes->NOMBREJURIDICO; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>                            

                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-xs-12 col-md-3">
                                <label for="exampleFormControlSelect1">Fecha Inicio</label>
                                <input type="text" onfocus="(this.type = 'date')" class="form-control " name="desde"
                                    id="desde" placeholder="Desde">
                            </div>
                            <div class="col-xs-12 col-md-3">
                                <label for="exampleFormControlSelect2">Fecha Fin</label>
                                <input type="text" onfocus="(this.type = 'date')" class="form-control " name="hasta"
                                    id="hasta" placeholder="Hasta">
                            </div>
                            <div class="col-xs-12 col-md-3">
                                <label for="exampleFormControlSelect3">Importe </label>
                                <input type="number" step="0.01" class="form-control " name="importe>" id="importeMin"
                                    placeholder="Min">
                            </div>
                            <div class="col-xs-12 col-md-3">
                                <label for="exampleFormControlSelect3">Importe </label>
                                <input type="number" step="0.01" class="form-control " name="importe<" id="importeMax"
                                    placeholder="Max">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12 col-md-3">
                                <label for="exampleFormControlSelect3">Colaborador</label>
                                <select class="form-control form-control-sm todos" id="colaborador"
                                    name="colaborador[]" multiple>
                                    <option value="" disabled></option>
                                    <?php foreach ($datos['colaboradores'] as $colaborador) : ?>
                                    <option value="<?php echo $colaborador->id; ?>">
                                    <?php echo ucwords($colaborador->nombreColaborador) ;?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-xs-12 col-md-3">
                                <label for="exampleFormControlSelect2">Accion</label>
                                <select class="form-control form-control-sm select2grande accion" id="accion"
                                    name="accion[]" multiple>
                                    <?php foreach ($datos['acciones'] as $accion) : ?>
                                    <option value="<?php echo $accion->idACCION; ?>">
                                    <?php echo $accion->NOMBREACCION; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="col-xs-12 col-md-3">
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
                </div>
                <!-- fin de los campos de busqueda del formulario -->
            </form>
        </div> <!-- end of div class container -->
        <div class="clearfix"></div>
        <!-- line que divide el search de la zone de view result of search -->
       


    </div>
</div>
 <div class="container-fluid">
            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
            <div id="respuesta"></div>
        </div>
</div>
<?php require(RUTA_APP . '/views/includes/footer2.php'); ?>