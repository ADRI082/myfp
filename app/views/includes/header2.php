<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <!-- favicon -->
  <link rel="shortcut icon" href="<?php echo RUTA_URL; ?>/public/img/logo/favicon.ico" type="image/x-icon">

  <title><?php echo NOMBRE_SITIO; ?></title>

  <!-- Font Awesome Icons -->
<link rel="stylesheet" href="<?php echo RUTA_URL ?>/public/css/all.min.css">

<link rel="stylesheet" href="<?php echo RUTA_URL; ?>/public/datatables/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo RUTA_URL; ?>/public/datatables/responsive.bootstrap4.min.css">
<!-- datatable buttons -->
<link rel="stylesheet" href="<?php echo RUTA_URL; ?>/public/datatables/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo RUTA_URL ?>/public/css/select2.css">
  <link rel="stylesheet" href="<?php echo RUTA_URL ?>/public/css/select2-bootstrap4.min.css">

<!-- Theme style -->
<link rel="stylesheet" href="<?php echo RUTA_URL ?>/public/css/adminlte.min.css">

  <!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
 <link rel="stylesheet" type="text/css" href="<?php echo RUTA_URL; ?>/public/css/estilos.css?v=<?php echo(rand()); ?>"> 
<!-- FULLCALENDAR -->
<!-- <link rel="stylesheet" href="<?php echo RUTA_URL ?>/public/librerias/components/fullcalendar/fullcalendar-built.css" /> -->
<link href='<?php echo RUTA_URL ?>/public/librerias/fullcalendar/packages/core/main.css' rel='stylesheet' />
<link href='<?php echo RUTA_URL ?>/public/librerias/fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
<link href='<?php echo RUTA_URL ?>/public/librerias/fullcalendar/packages/timegrid/main.css' rel='stylesheet' />
<link href='<?php echo RUTA_URL ?>/public/librerias/fullcalendar/packages/list/main.css' rel='stylesheet' />

<!-- tail.select -->
<link href='<?php echo RUTA_URL ?>/public/librerias/tailSelect/css/bootstrap4/tail.select-default.css' rel='stylesheet' />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
<div class="wrapper">

  <!-- Navbar -->
  <?php include("navBar.php"); ?>
  <!-- end navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-warning elevation-4">
    <!-- Brand Logo -->
    <?php include("brandLogo.php"); ?>
    <!-- end Brand Logo -->
  <!-- Sidebar -->
   <?php
   switch ($_SESSION['rol']) {
    case 0:
      include("sideBar1.php");
      break;
    case 1:
      include("sideBar.php");
        break;
    /*case 2:
      include("sideBar2.php");
        break;
    case 3:
      include("sideBar3.php");
        break;*/
    default:
      include("sideBar.php");
  }
   ?>
   <!-- end Sidebar -->
  </aside>
