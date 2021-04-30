<?php require(RUTA_APP . '/views/includes/header2.php'); ?>

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Crear Proyecto</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Crear Proyecto</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-warning">
            <div class="card-header">
              <h3 class="card-title">Datos Generales</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
            <form action="<?php echo RUTA_URL;  ?>/proyecto/agregarProyecto" method="POST">
              <div class="form-group">
                <label for="nombreProyecto">Nombre Proyecto</label>
                <input type="text" id="nombreProyecto" name="nombreProyecto" class="form-control" required="">
              </div>
              <div class="form-group">
                <label for="tipoProyecto">Tipo de Proyecto</label>
                <select class="form-control custom-select" name="tipoProyecto" required>
                  <option selected disabled>Seleccionar.....</option>
                  <option value="0">Formaci&oacute;n</option>
                  <option value="1">Consultoria</option>
                  <option value="2">Selecci&oacute;n</option>
                </select>
              </div>
              <div class="form-group">
                <label for="descripcion">Descripción Proyecto</label>
                <textarea id="inputDescription" class="form-control" name="descripcion" rows="6" required></textarea>
              </div>
              <div class="form-group">
                <label for="estadoProyecto">Estado</label>
                <select class="form-control custom-select" name="estadoProyecto" required>
                  <option selected disabled>Seleccionar.....</option>
                  <option value="0">Presupuesto</option>
                  <option value="1">Activo</option>
                  <option value="2">Terminado</option>
                </select>
              </div>
              <div class="form-group">
                <label for="clienteProyecto">Clientes</label>
                <select class="form-control select2" name="clienteProyecto" style="width: 100%;" required>
                  <option selected disabled>Seleccionar.....</option>
                  <?php foreach ($datos['clientes'] as $clientes) : ?>
                  <option value="<?php echo $clientes->codEmpresa; ?>"><?php echo $clientes->Nombre; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
              <label for="profesor">Profesores</label>
               <select class="form-control select2" name="profesor" style="width: 100%;" required>
                  <option selected disabled>Seleccionar.....</option>
                  <?php foreach ($datos['profesores'] as $profesores) : ?>
                  <option value="<?php echo $profesores->idProfesor; ?>"><?php echo $profesores->nombrecomercial; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="colaborador">Colaboradores</label>
                <select class="form-control select2" name="colaborador" style="width: 100%;" required>
                  <option selected disabled>Seleccionar.....</option>
                  <?php foreach ($datos['colaboradores'] as $colaboradores) : ?>
                  <option value="<?php echo $colaboradores->codColaborador; ?>"><?php echo $colaboradores->NombreComercial; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
              <label for="observacionesGenerales">Observaciones Generales</label>
                <textarea id="inputDescription" class="form-control" name="observacionesGenerales" rows="4"></textarea>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6">
          <div class="card card-warning">
            <div class="card-header">
              <h3 class="card-title">Contenido</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="accionFormativa">Accion Formativa</label>
                <select class="form-control select2"  name="accionFormativa" style="width: 100%;" required>
                  <option selected disabled>Seleccionar.....</option>
                  <?php foreach ($datos['acciones'] as $acciones) : ?>
                  <option value="<?php echo $acciones->idACCION; ?>"><?php echo $acciones->NOMBREACCION; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="tipoAccionFormativa">Tipo de Accion</label>
                <select class="form-control select2" name="tipoAccionFormativa" style="width: 100%;" required>
                  <option selected disabled>Seleccionar.....</option>
                  <?php foreach ($datos['tipos'] as $tipos) : ?>
                  <option value="<?php echo $tipos->codtipoformacion; ?>"><?php echo $tipos->destipoformacion; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="areaFormativa">Area Formativa</label>
                <select class="form-control select2" name="areaFormativa" style="width: 100%;" required>
                  <option selected disabled>Seleccionar.....</option>
                  <?php foreach ($datos['areas'] as $areas) : ?>
                  <option value="<?php echo $areas->codarea; ?>"><?php echo $areas->desarea; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="modalidadFormativa">Modalidad</label>
                <select class="form-control select2" name="modalidadFormativa" style="width: 100%;" required>
                  <option selected disabled>Seleccionar.....</option>
                  <?php foreach ($datos['modalidades'] as $modalidades) : ?>
                  <option value="<?php echo $modalidades->CODMODALIDAD; ?>"><?php echo $modalidades->DESMODALIDAD; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            
            <div class="form-group">
                <label for="objetivo">Objetivo</label>
                <textarea id="inputDescription" name="objetivo" class="form-control" rows="4"></textarea>
              </div>
              <div class="form-group">
                <label for="contenido">Contenido</label>
                <textarea id="inputDescription" name="contenido" class="form-control" rows="5" required></textarea>
              </div>
              <div class="form-group">
                <label for="metodologia">Metodolog&iacute;a</label>
                <textarea id="inputDescription" name="metodologia" class="form-control" rows="4" required></textarea>
              </div>
              <div class="form-group">
                <label for="observacionesAccion">Observaciones</label>
                <textarea id="inputDescription" name="observacionesAccion" class="form-control" rows="3"></textarea>
              </div>
              <input type="submit" value="A&ntilde;adir" class="btn btn-success">
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          
        </div>
      </div>
      <div class="clearfix"></div>
     
                  </form>
                  
    </section>
    <!-- /.content -->
 
  </div>
  <!-- /.content-wrapper -->
 

<?php require(RUTA_APP . '/views/includes/footer2.php'); ?>