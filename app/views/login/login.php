<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- favicon -->
    <link rel="shortcut icon" href="<?php echo RUTA_URL; ?>/public/img/logo/favicon.ico" type="image/x-icon">
  <title><?php echo NOMBRE_SITIO; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo RUTA_URL ?>/public/css/all.min.css"> 
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
<!--  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css"> -->
  <link rel="stylesheet" href="<?php echo RUTA_URL ?>/public/css/icheck-bootstrap.min.css"> 
  <!-- Theme style -->
<link rel="stylesheet" href="<?php echo RUTA_URL ?>/public/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img src="<?php echo RUTA_URL ?>/img/logo/logo_largo_nuevo_login.png">
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg"></p>

      <form action="<?php echo RUTA_URL ?>/login/comprobar" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="mail" placeholder="Email" required="">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" required="">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
            <a href="<?php echo RUTA_URL ?>/login">¿Has olvidado tu contrase&ntildea?</a>          
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-warning btn-block">Acceder</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1">
        
      </p>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?php echo RUTA_URL ?>/public/js/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo RUTA_URL ?>/public/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo RUTA_URL ?>/public/js/adminlte.min.js"></script>

</body>
</html>
