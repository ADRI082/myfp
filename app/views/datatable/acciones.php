<?php require(RUTA_APP . '/views/includes/header2.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Acciones</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Acciones</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container">


      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-12">

            <!-- ///////////////////////////////////////////////////// -->
            <!-- /// Referencias para visibilidad/ocultar columnas/// -->
            <!-- /////////////////////////////////////////////////// -->
            <div class="box">
              <div class="box-header">
                <div class="col-sm-12" style="margin-bottom:10px; border:solid 0.5px lightgrey;">
                  <i class="fa fa-eye-slash fa-1x"></i> / <i class="fa fa-eye fa-1x"></i>
                  <a class="toggle-vis btn" data-column="0">Tipo</a> -
                  <a class="toggle-vis btn" data-column="1">Area</a> -
                  <a class="toggle-vis btn" data-column="2">Modalidadddd</a> -
                  <a class="toggle-vis btn" data-column="3">Acci&oacute;n</a> -
                  <a class="toggle-vis btn" data-column="4">Descripci&oacute;n</a>-
                  <a class="toggle-vis btn" data-column="5">Servicio</a> -
                  <a class="toggle-vis btn" data-column="6">P.Presencial</a> -
                  <a class="toggle-vis btn" data-column="7">P.TFormacion</a> -
                  <a class="toggle-vis btn" data-column="8">objetivo Previsto</a> -
                  <a class="toggle-vis btn" data-column="9">Link.Contenido</a> -
                  <a class="toggle-vis btn" data-column="10">Contenido Previso</a> -
                  <a class="toggle-vis btn" data-column="11">Metodologia Prevista</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-md-12">
            <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead style="background-color:#001f3f; color:#fff;">
                  <tr>
                    <th style="font-size:0.8em !important;">Tipo</th>
                    <th style="font-size:0.8em !important;">Area</th>
                    <th style="font-size:0.8em !important;">Modalidad</th>
                    <th style="font-size:0.8em !important;">Acci&oacute;n</th>
                    <th style="font-size:0.8em !important;">Descripci&oacute;n</th>
                    <th style="font-size:0.8em !important;">Servicio</th>
                    <th style="font-size:0.8em !important;">P.Presencial</th>
                    <th style="font-size:0.8em !important;">P.TFormacion</th>
                    <th style="font-size:0.8em !important;">objetivo Previsto</th>
                    <th style="font-size:0.8em !important;">Link.Contenido</th>
                    <th style="font-size:0.8em !important;">Contenido Previso</th>
                    <th style="font-size:0.8em !important;">Metodologia Prevista</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($datos['acciones'] as $acciones) : ?>

                    <tr>
                      <td style="font-size:0.9em !important;"><?php echo $acciones->tipo; ?></td>
                      <td style="font-size:0.9em !important;"><?php echo $acciones->area; ?></td>
                      <td style="font-size:0.9em !important;"><?php echo $acciones->modalidad; ?></td>
                      <td style="font-size:0.9em !important;"><?php echo $acciones->nombre; ?></td>
                      <td style="font-size:0.9em !important;"><?php echo $acciones->descripcion; ?></td>
                      <td style="font-size:0.9em !important;"><?php echo $acciones->servicio; ?></td>
                      <td style="font-size:0.9em !important;"><?php echo $acciones->presencial; ?></td>
                      <td style="font-size:0.9em !important;"><?php echo $acciones->teleformacion; ?></td>
                      <td style="font-size:0.9em !important;"><?php echo $acciones->objetivoP; ?></td>
                      <td style="font-size:0.9em !important;"><?php echo $acciones->contenido; ?></td>
                      <td style="font-size:0.9em !important;"><?php echo $acciones->medotologiaP; ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
                <tfoot style="background-color:#001f3f; color:#fff;">
                  <tr>
                    <th style="font-size:0.8em !important;">Tipo</th>
                    <th style="font-size:0.8em !important;">Area</th>
                    <th style="font-size:0.8em !important;">Modalidad</th>
                    <th style="font-size:0.8em !important;">Acci&oacute;n</th>
                    <th style="font-size:0.8em !important;">Descripci&oacute;n</th>
                    <th style="font-size:0.8em !important;">Servicio</th>
                    <th style="font-size:0.8em !important;">P.Presencial</th>
                    <th style="font-size:0.8em !important;">P.TFormacion</th>
                    <th style="font-size:0.8em !important;">objetivo Previsto</th>
                    <th style="font-size:0.8em !important;">Link.Contenido</th>
                    <th style="font-size:0.8em !important;">Contenido Previso</th>
                    <th style="font-size:0.8em !important;">Metodologia Prevista</th>
                  </tr>
                </tfoot>
              </table>

            </div>

          </div>

        </div> <!-- fin del row -->

      </div> <!-- fin del content -->




      <?php require(RUTA_APP . '/views/includes/footer2.php'); ?>