<?php require(RUTA_APP . '/views/includes/header2.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Colaboradores</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Colaboradores</li>
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
<div class="col-xs-12">

<!-- ///////////////////////////////////////////////////// -->
  <!-- /// Referencias para visibilidad/ocultar columnas/// -->
  <!-- /////////////////////////////////////////////////// -->
  <div class="box">
				<div class="box-header">
					<div class="col-sm-12" style="margin-bottom:10px; border:solid 0.5px lightgrey;">
						<i class="fa fa-eye-slash fa-1x"></i> / <i class="fa fa-eye fa-1x"></i>
						<a class="toggle-vis btn" data-column="0">Codigo</a> -
						<a class="toggle-vis btn" data-column="1">Nif</a> -
						<a class="toggle-vis btn" data-column="2">Nombre Comercial</a> -
						<a class="toggle-vis btn" data-column="3">Raz&oacute;n Social</a> -
						<a class="toggle-vis btn" data-column="4">Direcci&oacute;n</a>  -
						<a class="toggle-vis btn" data-column="5">C. Postal</a>  -
						<a class="toggle-vis btn" data-column="6">Contacto</a>  -
						<a class="toggle-vis btn" data-column="7">Tel&eacute;fono</a>  -
						<a class="toggle-vis btn" data-column="8">M&oacute;vil</a>  -
						<a class="toggle-vis btn" data-column="9">Mail</a>  -
						<a class="toggle-vis btn" data-column="10">Web</a>  -
						<a class="toggle-vis btn" data-column="11">Margen Comercial</a>   -
						<a class="toggle-vis btn" data-column="12">Observaciones</a>   -
						<a class="toggle-vis btn" data-column="13">Localidad</a>   -
						<a class="toggle-vis btn" data-column="14">Provincia</a>   -
						<a class="toggle-vis btn" data-column="15">Tipo Colaborador</a>   -
						<a class="toggle-vis btn" data-column="16">N. Cuenta</a> 
					</div>
				</div>
	</div>
</div>
<div class="col-lg-12">
<div class="table-responsive">
<table id="colaboradores" class="table table-striped table-bordered" style="width:100%">
<thead style="background-color:#001f3f; color:#fff;">
            <tr>
                <th>Codigo</th>
                <th>Nif</th>
                <th>Nombre Comercial</th>
                <th>Raz&oacute;n Social</th>
                <th>Direcci&oacute;n</th>
                <th>C. Postal</th>
                <th>Contacto</th>
                <th>Tel&eacute;fono</th>
                <th>M&oacute;vil</th>
                <th>Mail</th>
                <th>Web</th>
                <th>Margen Comercial</th>
                <th>Observaciones</th>
                <th>Localidad</th>
                <th>Provincia</th>
                <th>Tipo Colaborador</th>
                <th>N. Cuenta</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($datos['colaboradores'] as $tipos) : ?>

            <tr>
                <td><?php echo $tipos->codColaborador; ?></td>
                <td><?php echo $tipos->NifColaborador; ?></td>
                <td><?php echo $tipos->NombreComercial; ?></td>
                <td><?php echo $tipos->RazonSocial; ?></td>
                <td><?php echo $tipos->Direccion; ?></td>
                <td><?php echo $tipos->codigopostal; ?></td>
                <td><?php echo $tipos->Contactocolaborador; ?></td>
                <td><?php echo $tipos->telefonocolaborador; ?></td>
                <td><?php echo $tipos->movilcolaborador; ?></td>
                <td><?php echo $tipos->emailcolaborador; ?></td>
                <td><?php echo $tipos->webcolaborador; ?></td>
                <td><?php echo $tipos->margencomercial; ?></td>
                <td><?php echo $tipos->observaciones; ?></td>
                <td><?php echo $tipos->Localidad; ?></td>
                <td><?php echo $tipos->provincia; ?></td>
                <td><?php echo $tipos->TipoColaborador; ?></td>
                <td><?php echo $tipos->numcuenta; ?></td>


            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot style="background-color:#001f3f; color:#fff;">
            <tr>
            <th>Codigo</th>
                <th>Nif</th>
                <th>Nombre Comercial</th>
                <th>Raz&oacute;n Social</th>
                <th>Direcci&oacute;n</th>
                <th>C. Postal</th>
                <th>Contacto</th>
                <th>Tel&eacute;fono</th>
                <th>M&oacute;vil</th>
                <th>Mail</th>
                <th>Web</th>
                <th>Margen Comercial</th>
                <th>Observaciones</th>
                <th>Localidad</th>
                <th>Provincia</th>
                <th>Tipo Colaborador</th>
                <th>N. Cuenta</th>
            </tr>
        </tfoot>
</table>

</div>

</div>

</div>

</div>




<?php require(RUTA_APP . '/views/includes/footer2.php'); ?>
