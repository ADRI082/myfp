<?php require(RUTA_APP . '/views/includes/header2.php'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Vídeos para test</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container">
<?php
    $info = $datos['info'][0];

?>
            <div class="content">
                <form method="POST" action="Videos/guardarObservaciones" id="agregarObservaciones">
                    <button type="submit" class="btn btn-success mb-2">Guardar</button>
                <div class="card">
                    <div class="row">
                        <div class="col-md-6 px-4 py-2">
                            <p style="color: blue; text-align:center">Creación de Oportunidad y Colaborador- 27/10/2020</p>
                            <iframe style='margin: 0em auto;' width='100%' height='240' src='https://www.youtube.com/embed/eJwiKW8Lyew' 
                                frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' 
                                allowfullscreen></iframe>
                            <?php
                                echo"<textarea name='oportunidad' id='oportunidad' rows='2' placeholder='observaciones' style='width:100%'>".$info->oportunidad."</textarea>";
                            ?>                            
                        </div>
                        <div class="col-md-6 px-4 py-2">
                            <p style="color: blue; text-align:center">Creación de Agentes- 27/10/2020</p>
                            <iframe style='margin: 0em auto;' width='100%' height='240' src='https://www.youtube.com/embed/oDgPGkhChOg' 
                                frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' 
                                allowfullscreen></iframe>
                            <?php
                                echo"<textarea name='agentes' id='agentes' rows='2' placeholder='observaciones' style='width:100%'>".$info->agentes."</textarea>";
                            ?>
                        </div>                   
                    </div>                    
                    <div class="row">
                        <div class="col-md-6 px-4 py-2">
                            <p style="color: blue; text-align:center">Creación de Clientes- 05/10/2020</p>
                            <iframe style='margin: 0em auto;' width='100%' height='240' src='https://www.youtube.com/embed/6lCcJWRQqD0' 
                                frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' 
                                allowfullscreen></iframe>
                            <?php
                                echo"<textarea name='clientes' id='clientes' rows='2' placeholder='observaciones' style='width:100%'>".$info->clientes."</textarea>";
                            ?>
                        </div>  
                        <div class="col-md-6 px-4 py-2">
                            <p style="color: blue; text-align:center">Creación de Acciones- 05/10/2020</p>                            
                            <iframe style='margin: 0em auto;' width='100%' height='240' src='https://www.youtube.com/embed/AuqYCjJIZzw' 
                                frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' 
                                allowfullscreen></iframe>
                            <?php
                                echo"<textarea name='acciones' id='acciones' rows='2' placeholder='observaciones' style='width:100%'>".$info->acciones."</textarea>";
                            ?>
                        </div>
                        <div class="col-md-6 px-4 py-2">                            
                        </div>                   
                    </div>
                </div>
                </form>


            </div>







            <?php require(RUTA_APP . '/views/includes/footer2.php'); ?>