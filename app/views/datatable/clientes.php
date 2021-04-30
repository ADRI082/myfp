<?php require(RUTA_APP . '/views/includes/header2.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Clientes</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Clientes</li>
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
						<a class="toggle-vis btn" data-column="1">Cif</a> -
						<a class="toggle-vis btn" data-column="2">N. Comercial</a> -
						<a class="toggle-vis btn" data-column="3">Raz&oacute;n Social</a> -
						<a class="toggle-vis btn" data-column="4">Representante</a>  -
						<a class="toggle-vis btn" data-column="5">Contacto</a>  -
						<a class="toggle-vis btn" data-column="6">Nif Representante</a>  -
						<a class="toggle-vis btn" data-column="7">Direcci&oacute;n</a>  -
						<a class="toggle-vis btn" data-column="8">Localidad</a>  -
						<a class="toggle-vis btn" data-column="9">Provincia</a>  -
						<a class="toggle-vis btn" data-column="10">C. Postal</a>  -
						<a class="toggle-vis btn" data-column="11">Tel&eacute;fono fijo 1</a>   -
						<a class="toggle-vis btn" data-column="12">Tel&eacute;fono fijo 2</a>   -
						<a class="toggle-vis btn" data-column="13">M&oacute;vil</a>   -
						<a class="toggle-vis btn" data-column="14">Mail</a>   -
						<a class="toggle-vis btn" data-column="15">Web</a>   -
						<a class="toggle-vis btn" data-column="16">NSS Empresa</a> 
					</div>
				</div>
	</div>
</div>
<div class="col-lg-12">
<div class="table-responsive">
<table id="colaboradores" class="table table-striped table-bordered" style="width:100%">
<thead style="background-color:#001f3f; color:#fff;">
            <tr>
                <th style="font-size:0.8em !important;">Codigo</th>
                <th style="font-size:0.8em !important;">Cif</th>
                <th style="font-size:0.8em !important;">N. Comercial</th>
                <th style="font-size:0.8em !important;">Raz&oacute;n Social</th>
                <th style="font-size:0.8em !important;">Representante</th>
                <th style="font-size:0.8em !important;">Contacto</th>
                <th style="font-size:0.8em !important;">Nif Representante</th>
                <th style="font-size:0.8em !important;">Direcci&oacute;n</th>
                <th style="font-size:0.8em !important;">Localidad</th>
                <th style="font-size:0.8em !important;">Provincia</th>
                <th style="font-size:0.8em !important;">C. Postal</th>
                <th style="font-size:0.8em !important;">Tel&eacute;fono fijo 1</th>
                <th style="font-size:0.8em !important;">Tel&eacute;fono fijo 2</th>
                <th style="font-size:0.8em !important;">M&oacute;vil</th>
                <th style="font-size:0.8em !important;">Mail</th>
                <th style="font-size:0.8em !important;">Web</th>
                <th style="font-size:0.8em !important;">NSS Empresa</th>                
            </tr>
        </thead>
        <tbody>
        <?php foreach ($datos['clientes'] as $tipos) : ?>

            <tr>
                <td style="font-size:0.9em !important;"><?php echo $tipos->codEmpresa; ?></td>
                <td style="font-size:0.9em !important;"><?php echo $tipos->CIFCLIENTE; ?></td>
                <td style="font-size:0.9em !important;"><?php echo $tipos->NOMBRE; ?></td>
                <td style="font-size:0.9em !important;"><?php echo $tipos->NOMBREJURIDICO; ?></td>
                <td style="font-size:0.9em !important;"><?php echo $tipos->NOMBREREPRESENTANTE; ?></td>
                <td style="font-size:0.9em !important;"><?php echo $tipos->CONTACTO; ?></td>
                <td style="font-size:0.9em !important;"><?php echo $tipos->NIFREPRESENTANTE; ?></td>
                <td style="font-size:0.9em !important;"><?php echo $tipos->DIRECCION; ?></td>
                <td style="font-size:0.9em !important;"><?php echo $tipos->LOCALIDAD; ?></td>
                <td style="font-size:0.9em !important;"><?php echo $tipos->PROVINCIA; ?></td>
                <td style="font-size:0.9em !important;"><?php echo $tipos->CODPOSTAL; ?></td>
                <td style="font-size:0.9em !important;"><?php echo $tipos->TELEFONOFIJO1; ?></td>
                <td style="font-size:0.9em !important;"><?php echo $tipos->TELEFONOFIJO2; ?></td>
                <td style="font-size:0.9em !important;"><?php echo $tipos->TELEFONOMOVIL; ?></td>
                <td style="font-size:0.9em !important;"><?php echo $tipos->MAIL; ?></td>
                <td style="font-size:0.9em !important;"><?php echo $tipos->WEB; ?></td>
                <td style="font-size:0.9em !important;"><?php echo $tipos->NSSEMPRESA; ?></td>


            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot style="background-color:#001f3f; color:#fff;">
            <tr>
            <th style="font-size:0.8em !important;">Codigo</th>
                <th style="font-size:0.8em !important;">Cif</th>
                <th style="font-size:0.8em !important;">N. Comercial</th>
                <th style="font-size:0.8em !important;">Raz&oacute;n Social</th>
                <th style="font-size:0.8em !important;">Representante</th>
                <th style="font-size:0.8em !important;">Contacto</th>
                <th style="font-size:0.8em !important;">Nif Representante</th>
                <th style="font-size:0.8em !important;">Direcci&oacute;n</th>
                <th style="font-size:0.8em !important;">Localidad</th>
                <th style="font-size:0.8em !important;">Provincia</th>
                <th style="font-size:0.8em !important;">C. Postal</th>
                <th style="font-size:0.8em !important;">Tel&eacute;fono fijo 1</th>
                <th style="font-size:0.8em !important;">Tel&eacute;fono fijo 2</th>
                <th style="font-size:0.8em !important;">M&oacute;vil</th>
                <th style="font-size:0.8em !important;">Mail</th>
                <th style="font-size:0.8em !important;">Web</th>
                <th style="font-size:0.8em !important;">NSS Empresa</th>
            </tr>
        </tfoot>
</table>

</div>

</div>

</div>

</div>




<?php require(RUTA_APP . '/views/includes/footer2.php'); ?>
