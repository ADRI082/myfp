<?php require(RUTA_APP . '/views/includes/header2.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">RGPD</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">RGPD</li>
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
                <div class="border border-light p-3 mb-4">

                    <div class="d-flex align-items-center justify-content-center" style="height: 500px">
                        <label class="labelCampoPres"><h1>RGPD : </h1></label>
                        <div class="col-md-7 col-sm-12 h-10 mt-2 mb-4" id="">
                            <textarea data-pk="id" data-tabla="config" id="rgpd" name="descripcion" rows="4" cols="10" class="form-control campotablaRGPD"><?php echo $datos->descripcion ?></textarea>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>


<?php require(RUTA_APP . '/views/includes/footer2.php'); ?>