<?php require(RUTA_APP . '/views/includes/header2.php'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Proveedores</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Proveedores</li>
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
                    <div class="col-xs-12 xol-md-12">

                        <!-- ///////////////////////////////////////////////////// -->
                        <!-- /// Referencias para visibilidad/ocultar columnas/// -->
                        <!-- /////////////////////////////////////////////////// -->
                        <div class="box">
                            <div class="box-header">
                                <div class="col-sm-12" style="margin-bottom:10px; border:solid 0.5px lightgrey;">
                                    <i class="fa fa-eye-slash fa-1x"></i> / <i class="fa fa-eye fa-1x"></i>
                                    <a class="toggle-vis btn" data-column="0">Id Proveedor</a> -
                                    <a class="toggle-vis btn" data-column="1">CIF</a> -
                                    <a class="toggle-vis btn" data-column="2">N. Comercial</a> -
                                    <a class="toggle-vis btn" data-column="3">Tipo</a> -
                                    <a class="toggle-vis btn" data-column="4">Acciones</a> -
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xs-12 col-md-12">



                        <a id="addProveedor" data-modal="addProveedores" class="btn mb-0" title="Agregar proveedor" style="margin-bottom:20px;background-color:#001f3f;color:#fff;"><span class="fa fa-plus"></span></span>
                        </a>


                        <?php
                        //control de mensajes de error o éxito:
                        if (isset($_SESSION['message'])) {
                            if (strpos($_SESSION['message'], 'corréctamente') != false) {
                        ?>
                                <div class="alert alert-dismissible alert-success" style="margin-top:20px;">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <?php echo $_SESSION['message']; ?>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="alert alert-dismissible alert-danger" style="margin-top:20px;">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <?php echo $_SESSION['message']; ?>
                                </div>
                        <?php
                            }
                            unset($_SESSION['message']);
                        }
                        ?>




                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead style="background-color:#001f3f; color:#fff;" class="text-center">
                                    <tr>
                                        <th style="font-size:0.8em !important;">Id Proveedor</th>
                                        <th style="font-size:0.8em !important;">CIF</th>
                                        <th style="font-size:0.8em !important;">N. Comercial</th>
                                        <th style="font-size:0.8em !important;">Tipo</th>
                                        <th style="font-size:0.8em !important;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($datos['proveedores'] as $proveedor) : ?>

                                        <tr>
                                            <td style="font-size:0.9em !important;"><?php echo $proveedor->idPROVEEDOR; ?></td>
                                            <td style="font-size:0.9em !important;"><?php echo $proveedor->CIFPROVEEDOR; ?></td>
                                            <td style="font-size:0.9em !important;"><?php echo $proveedor->NOMBRECOMERCIAL; ?></td>
                                            <td style="font-size:0.9em !important;"><?php echo $proveedor->tipo; ?></td>
                                            <td>
                                                <?php
                                                echo "
                                                <div class='row'>
                                                    <div class='text-center'>
                                                    <button class='btn btn-info btn-sm editarProveedores' data-modal='editProveedor'                                                     
                                                        title='Editar Colaborador'><i class='fas fa-pencil-alt text-white' ></i></a>
                                                    </div>
                                                    <div class='text-center'>
                                                    <button class='btn btn-danger btn-sm deleteProveedor'
                                                        href='' title='Eliminar Proveedor'><i class='fa fa-trash text-white'></i></a>
                                                    </div>
                                                </div>";
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot style="background-color:#001f3f; color:#fff;" class="text-center">
                                    <tr>
                                        <th style="font-size:0.8em !important;">Id Proveedor</th>
                                        <th style="font-size:0.8em !important;">CIF</th>
                                        <th style="font-size:0.8em !important;">N. Comercial</th>
                                        <th style="font-size:0.8em !important;">Tipo</th>
                                        <th style="font-size:0.8em !important;">Acciones</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <?php include_once(RUTA_APP . '/views/Proveedores/addProveedor.php');
                        include_once(RUTA_APP . '/views/Proveedores/editProveedor.php');
                    ?>

                </div> <!-- fin del row -->
            </div> <!-- fin del content -->







            <?php require(RUTA_APP . '/views/includes/footer2.php');


            ?>