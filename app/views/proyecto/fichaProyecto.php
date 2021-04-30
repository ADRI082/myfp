<?php require(RUTA_APP . '/views/includes/header2.php');

require_once '../app/models/ModeloProyecto.php';

$generales = $datos['generales'];
$detalles = $datos['detalles'];
$clientes = $datos['clientes'];
$modalidades = $datos['modalidades'];
$niveles = $datos['niveles'];
$acciones = $datos['acciones'];
$profesores = $datos['profesores'];
$profesoresProy = $datos['profesoresProy'];
$participantes = $datos['participantes'];
$empleados = $datos['empleados'];

$ModelProyecto = new ModeloProyecto;

$datosBalance = $ModelProyecto->generarDatosBalance($generales->idProyecto);



if ($datos['msg'] == 1) {

  echo "
    <div class='alert alert-success alert-dismissible fade show container' role='alert'>
      <strong>Se ha enviado el email con éxito</strong>.
      <a type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </a>
    </div>
      ";
} else if ($datos['msg'] == 2) {
  echo "
    <div class='alert alert-success alert-dismissible fade show container' role='alert'>
      <strong>Se han importado los datos con éxito</strong>.
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>
      ";
}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- <form action="<?php echo RUTA_URL;  ?>/Proyecto/actualizarFichaProyecto" method="POST" enctype="multipart/form-data"> -->
  <input type="hidden" id="ruta" value="<?php echo RUTA_URL;  ?>">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">

          <h1>Ficha Proyecto</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Ficha Proyecto</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">


        <!-- lateral derecha INFORMACION DETALLADA POR CLIENTE -->
        <div class="col-md-12">
          <!-- lateral izquierda INFORMACIÓN DETALLADA -->
          <div class="card card-primary">
            <div class="card-header flex-grow-1">
              <h3 class="card-title">Información General</h3>
              <a href="<?php echo RUTA_URL . "/proyecto/listaProyectos"; ?>" title="Ir a listado" style="float:right"><i class="fas fa-list text-white"></i></a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="text-center mb-4">
                <h3 class="card-title"></h3>
              </div>
              <div class="form-group row">
                <div class='col-md-1'>
                  <label>Grupo Nº</label>
                  <input id='idProyecto' type='text' name='idProyecto' title='Presupuesto Nº <?php echo $generales->idPresupuesto; ?>' class='form-control form-control-sm' value='<?php echo $generales->idProyecto; ?>' readonly>
                  <input id='idPresupuesto' type='hidden' name='idPresupuesto' value='<?php echo $generales->idPresupuesto; ?>'>
                </div>
                <div class='col-md-3'>
                  <label for='nomPresupuesto'>Nombre Grupo/Proyecto</label>
                  <input id='nomPresupuesto' type='text' name='nomPresupuesto' class='form-control form-control-sm inputAuto' value='<?php echo $generales->nombreProyecto;  ?>' data-tabla='proyectos' data-idtabla='idProyecto' data-campo='nombreProyecto' data-valid='nomPresupuesto'>
                </div>

                <div class='col-md-1'>
                  <label for='idAccion'>Acción Nº</label>
                  <input id='idAccion' type='text' name='idAccion' class='form-control form-control-sm' value='<?php echo $generales->accionformativa;  ?>' readonly>
                </div>
                <div class='col-md-3'>
                  <label>Nombre Acción</label>
                  <select id='nombreAccion' class='form-control form-control-sm selectAutoAccion select2' data-valid='nombreAccion'>
                    <option disabled selected></option>
                    <?php
                    foreach ($acciones as $accion) {
                      echo "
                              <option value='" . $accion->idACCION . "' " . (($accion->idACCION == $generales->accionformativa) ? 'selected' : '') . ">" . $accion->idACCION . " - " . $accion->NOMBREACCION . "</option>";
                    }

                    ?>
                  </select>
                </div>

                <div class='col-md-2'>
                  <label>Modalidad</label>
                  <select id="modalidad" class='form-control form-control-sm selectAutoMultiCampo' name="modalidad" data-tabla='acciones_presupuesto' data-idtabla='idAccionPres' data-campo='modalidad' data-valid='modalidad'>
                    <option disabled selected></option>
                    <?php
                    foreach ($modalidades as $modalidad) {
                      echo "
                              <option value='" . $modalidad->CODMODALIDAD . "' " . (($modalidad->CODMODALIDAD == $generales->modalidad) ? 'selected' : '') . ">" . $modalidad->DESMODALIDAD . "</option>";
                    }

                    ?>
                  </select>
                </div>
                <div class='col-md-2'>
                  <label>Tipo formación</label>
                  <input type='text' class='form-control form-control-sm' value='<?php echo $detalles->tipoFormacion;  ?>' readonly>
                </div>
              </div>
              <div class="form-group row">
                <div class='col-md-4'>
                  <label>Area Formativa</label>
                  <input type='text' class='form-control form-control-sm' value='<?php echo $detalles->areaFormativa;  ?>' readonly>
                </div>
                <div class='col-md-2'>
                  <label>Nivel del Curso</label>
                  <select id="nivelCurso" class='form-control form-control-sm selectAutoMultiCampo' name="nivelCurso" data-tabla='acciones_presupuesto' data-idtabla='idAccionPres' data-campo='nivel' data-valid='nivelCurso'>
                    <option disabled selected></option>
                    <?php
                    foreach ($niveles as $nivel) {
                      echo "
                              <option value='" . $nivel->CODNIVELCURSO . "' " . (($nivel->CODNIVELCURSO == $generales->nivel) ? 'selected' : '') . ">" . $nivel->DESCNIVELCURSO . "</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class='col-md-2'>
                  <label>Fecha presupuesto</label>
                  <input id='fechaPres' type='date' name='fechaPres' class='form-control form-control-sm' value='<?php echo $detalles->fecha; ?>' readonly>
                </div>
                <div class='col-md-2'>
                  <label for='servicio'>Servicio</label>
                  <input id='servicio' type='text' name='servicio' class='form-control form-control-sm' value='<?php echo $generales->nombreServicio;  ?>' readonly>
                </div>
                <div class='col-md-2'>
                  <label for='servicio'>Estado</label>
                  <input id='estado' type='text' name='estado' class='form-control form-control-sm' value='<?php
                                                                                                            if ($generales->fechaInicio >= date("Y-m-d")) {
                                                                                                              echo "Proyecto";
                                                                                                            } else if ($generales->fechaInicio < date("Y-m-d")) {
                                                                                                              if ($generales->fechaFin > date("Y-m-d") || $generales->fechaFin == '') {
                                                                                                                echo "En ejecución";
                                                                                                              } else if ($generales->fechaFin < date("Y-m-d") && $generales->fechaFin != '') {
                                                                                                                echo "Terminado";
                                                                                                              }
                                                                                                            }
                                                                                                            ?>' readonly>
                </div>
              </div>
              <div class="form-group row">
                <div class='col-md-2'>
                  <label for='tipologia'>Tipología</label>
                  <select id="tipologia" class='form-control form-control-sm selecteAutoTipologia' name="tipologia" data-valid='tipologia'>
                  </select>
                </div>
                <div class='col-md-2'>
                  <label for='fechaInicio'>Fecha Inicio</label>
                  <input id='fechaIniOriginal' type='hidden' name='fechaIniOriginal' value='<?php echo $generales->fechaInicio; ?>'>
                  <input id='fechaInicio' type='date' name='fechaInicio' class='form-control form-control-sm inputAuto' value='<?php echo $generales->fechaInicio; ?>' data-tabla='proyectos' data-idtabla='idProyecto' data-campo='fechaInicio' data-valid='fechaInicio'>
                </div>
                <div class='col-md-2'>
                  <label for='fechaFin'>Fecha Fin</label>
                  <input id='fechaFin' type='date' name='fechaFin' class='form-control form-control-sm inputAuto' value='<?php echo $generales->fechaFin; ?>' data-tabla='proyectos' data-idtabla='idProyecto' data-campo='fechaFin' data-valid='fechaFin'>
                </div>
                <div class='col-md-2'>
                  <label for='fechaIniFun'>F. Inicio Fundae</label>
                  <input id='fechaIniFun' type='date' name='fechaIniFun' class='form-control form-control-sm inputAuto' value='<?php echo $generales->fechaIniFun; ?>' data-tabla='proyectos' data-idtabla='idProyecto' data-campo='fechaIniFun' data-valid='fechaIniFun'>
                </div>
                <div class='col-md-2'>
                  <label for='fechaFinFun'>F. Fin Fundae</label>
                  <input id='fechaFinFun' type='date' name='fechaFinFun' class='form-control form-control-sm inputAuto' value='<?php echo $generales->fechaFinFun; ?>' data-tabla='proyectos' data-idtabla='idProyecto' data-campo='fechaFinFun' data-valid='fechaFinFun'>
                </div>
                <!--<div class='col-md-2'>
                      <label for='agente'>Agente</label>
                      <input id='nomAgente' type='text' name='nomAgente' class='form-control form-control-sm' value='<?php //echo $generales->agente; 
                                                                                                                      ?>'>
                    </div>-->
                <div class='col-md-2'>
                  <label>Mes Bonificación</label>
                  <select id="mesBonif" class='form-control form-control-sm selectAuto' name="mesBonif" data-tabla='proyectos' data-idtabla='idProyecto' data-campo='mesBonificacion' data-valid='mesBonif'>
                    <option disabled selected>Seleccionar</option>
                    <?php
                    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviemnbre', 'Diciembre'];
                    foreach ($meses as $mes) {
                      echo "
                              <option value='" . $mes . "' " . (($generales->mesBonificacion == $mes) ? 'selected' : '') . " >" . $mes . "</option>
                              ";
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="card card-primary">
                <div class="card-header flex-grow-1">
                  <h3 class="card-title">Información de los clientes</h3>
                </div>
                <div class="card-body">

                  <div class="form-group row mx-0">

                    <div class='col-md-4 pl-0'>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text inputResaltadoFichaProyecto form-control-sm" id="">Cliente</span>
                        </div>
                        <select name="clienteSel" id="clienteSel" class="clienteSel form-control form-control-sm">
                          <option disabled selected></option>
                          <option value="todos">Todos</option>
                          <?php
                          foreach ($clientes as $cliente) {
                            echo "
                                      <option value='" . $cliente->idEMPRESA . "'>" . $cliente->NOMBREJURIDICO . "</option>";
                          }

                          ?>
                        </select>
                      </div>
                    </div>
                    <div class='col-md-3 pl-0' style="display: none;" id="contColaborador">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text inputResaltadoFichaProyecto form-control-sm" id="">Colaborador</span>
                        </div>
                        <input id='colaboradorCli' class='clienteSel form-control  form-control-sm' value=''>
                      </div>
                    </div>
                    <div class='col-md-3 pl-0' style="display: none;" id="contAgente">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text inputResaltadoFichaProyecto form-control-sm" id="">Agente</span>
                        </div>
                        <input id='AgenterCli' class='clienteSel form-control  form-control-sm' value=''>
                      </div>
                    </div>
                    <div class='col-md-2' style="display: none;" id="contImporte">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text inputResaltadoFichaProyecto form-control-sm" id="">Importe</span>
                        </div>
                        <input id='importeAccion' class='clienteSel form-control form-control-sm selectInputImporte' data-valid='importeAccion'>
                      </div>
                    </div>

                  </div>
                </div>
              </div>



            </div>
            <!-- /.card-body -->


            <!-- /.card -->


            <div class="card">

              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#organizacion" data-toggle="tab">Organización</a></li>
                  <li class="nav-item"><a class="nav-link" href="#profesoresAlumnos" data-toggle="tab">Profesores y Alumnos</a></li>
                  <li class="nav-item"><a class="nav-link" href="#ingresosgastos" data-toggle="tab">Ingresos y Gastos</a></li>
                  <li class="nav-item"><a id="btnTablaBalance" class="nav-link" href="#balance" data-toggle="tab">Balance</a></li>
                  <li class="nav-item"><a class="nav-link" href="#calidad" data-toggle="tab">Calidad</a></li>
                  <li class="nav-item"><a class="nav-link" href="#documentos" data-toggle="tab">Documentos</a></li>
                  <li class="nav-item"><a class="nav-link" href="#ficheros" data-toggle="tab">Ficheros</a></li>
                  <li class="nav-item"><a id="btnEmails" class="nav-link" href="#emails" data-toggle="tab">Emails</a></li>

                </ul>
              </div><!-- /.card-header -->

              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="organizacion">
                    <!-- Post -->
                    <div class="post">
                      <div class="user-block">
                        <div class="row">
                          <div class="col-md-4" style="border-right:1px solid rgba(0,0,0,.125); border-radius:0.25rem;">

                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label>Horario mañana</label>
                                <div class="row">
                                  <div class="col-md-6">
                                    <input id='mananaIni' type='time' name='mananaIni' class='form-control form-control-sm' value=''>
                                  </div>
                                  <div class="col-md-6">
                                    <input id='mananaFin' type='time' name='mananaFin' class='form-control form-control-sm' value=''>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group col-md-6">
                                <label>Horario tarde</label>
                                <div class="row">
                                  <div class="col-md-6">
                                    <input id='tardeIni' type='time' name='tardeIni' class='form-control form-control-sm' value=''>
                                  </div>
                                  <div class="col-md-6">
                                    <input id='tardeFin' type='time' name='tardeFin' class='form-control form-control-sm' value=''>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <label for='observacionesHor'>Observaciones del Horario</label>
                              <textarea class="form-control  form-control-sm" name="obsHorario" id="obsHorario" rows="2"></textarea>
                            </div>
                            <div class="form-group">
                              <label for='metodologia'>Metodología</label>
                              <textarea class="form-control  form-control-sm" rows="2" readonly><?php echo $generales->MetodologiaPrevista; ?></textarea>
                            </div>
                            <div class="form-group">
                              <label for='objetivo'>Objetivo</label>
                              <textarea class="form-control  form-control-sm" rows="2" readonly><?php echo $generales->ObjetivoPrevisto; ?></textarea>
                            </div>
                          </div>

                          <div class="col-md-8">
                            <div class="form-group row">
                              <div class='col-md-3'>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text form-control-sm" style="font-size: 0.85rem;">Nº participantes</span>
                                  </div>
                                  <input type="number" class="form-control form-control-sm" id="participantes" name="participantes" data-valid='participantes'>
                                </div>
                              </div>
                            </div>

                            <div class="form-group row">
                              <?php
                              echo "
                                  <div class='col-md-3'>
                                    <div class='input-group'>
                                      <div class='input-group-prepend'>
                                        <span class='input-group-text form-control-sm' style='font-size: 0.85rem;'>H. Presenc.</span>
                                      </div>
                                      <input type='number' step='0.01' class='form-control form-control-sm inputHoras sumarHoras' id='hPresenciales' name='hPresenciales'  
                                        data-valid='hPresenciales' value='" . $generales->hPresenciales . "'>
                                    </div>
                                  </div>

                                  <div class='col-md-3'>
                                    <div class='input-group'>
                                      <div class='input-group-prepend'>
                                        <span class='input-group-text form-control-sm' style='font-size: 0.85rem;'>H. Teleform.</span>
                                      </div>
                                      <input type='number' step='0.01' class='form-control form-control-sm inputHoras sumarHoras' id='hTeleformacion' name='hTeleformacion'  
                                        data-valid='hTeleformacion' value='" . $generales->hTeleformacion . "'>
                                    </div>
                                  </div>                                  

                                  <div class='col-md-3'>
                                    <div class='input-group'>
                                      <div class='input-group-prepend'>
                                        <span class='input-group-text form-control-sm' style='font-size: 0.85rem;'>H. Aula Vir.</span>
                                      </div>
                                      <input type='number' step='0.01' class='form-control form-control-sm inputHoras sumarHoras' id='hAulaVirtual' name='hAulaVirtual'  
                                        data-valid='hAulaVirtual' value='" . $generales->hAulaVirtual . "'>
                                    </div>                              
                                  </div>
                                     
                                  <div class='col-md-3'>
                                    <div class='input-group'>
                                      <div class='input-group-prepend'>
                                        <span class='input-group-text form-control-sm' style='font-size: 0.85rem;'>H. Totales</span>
                                      </div>                                      

                                         <input type='text' class='form-control form-control-sm' id='horas' name='horas' value='" . $generales->horas . "'>                                        
                                        
                                    </div>
                                  </div>";
                              ?>

                            </div>

                            <div class="form-group row">
                              <div class='col-md-12'>
                                <label for='diasImparticion'>Días de Impartición del Curso</label>
                                <div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="lunes" name="dia[]" value="lunes">
                                    <label class="form-check-label" for="lunes">L</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="martes" name="dia[]" value="martes">
                                    <label class="form-check-label" for="martes">M</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="miercoles" name="dia[]" value="miercoles">
                                    <label class="form-check-label" for="miercoles">X</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="jueves" name="dia[]" value="jueves">
                                    <label class="form-check-label" for="jueves">J</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="viernes" name="dia[]" value="viernes">
                                    <label class="form-check-label" for="viernes">V</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="sabado" name="dia[]" value="sabado">
                                    <label class="form-check-label" for="sabado">S</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="domingo" name="dia[]" value="domingo">
                                    <label class="form-check-label" for="domingo">D</label>
                                  </div>
                                </div>
                              </div>
                              <!--<div class='col-md-8'>
                                      <label for='centroImparticion'>Datos del Centro de Impartición</label>
                                      <input id='centroImparticion' type='text' name='centroImparticion' class='form-control form-control-sm' value=''>
                                  </div>-->
                            </div>
                            <div class="form-group row">
                              <div class="col-md-7">
                                <label for='contenidos'>Contenidos</label>
                                <textarea class="form-control form-control-sm" rows="8" readonly><?php echo $generales->ContenidoPrevisto; ?></textarea>
                              </div>

                              <div class="col-md-5">
                                <label for='observacionesFichaProy'>Observaciones</label>
                                <textarea class="form-control  form-control-sm" name="obsFichaProy" id="obsFichaProy" rows="8"><?php echo $generales->observaciones; ?></textarea>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="tab-pane" id="profesoresAlumnos">
                    <div class="post">
                      <div class="user-block">
                        <div class="" id="asignacionProfesor">

                          <a href="#">Asignación de Profesor/Centro de Formación</a>
                          <table class="table" id="tablaProfesores">
                            <thead>
                              <tr>
                                <th width='14%' scope="col">Razon Social</th>
                                <th width='14%' scope="col">CIF Profesor</th>
                                <th width='10%' scope="col">Nom. Comercial</th>
                                <th width='8%' scope="col">Prof. Interno</th>
                                <th width='8%' scope="col">Observaciones</th>
                                <th width='15%' scope="col">Acciones</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php

                              echo "
                                    <tr>
                                      <td>
                                        <select class='form-control razonSocialProfesor' id='razonSocialProfesor' name='razonSocialProfesor' >
                                          <option>&nbsp;</option>";
                              foreach ($profesores as $profesor) {
                                echo "
                                            <option value='" . $profesor->idPROFESOR . "'>" . $profesor->RAZONSOCIAL . "</option>";
                              }
                              echo "  
                                        </select>
                                      </td>                    
                                      <td><div id='cif'></div></td>
                                      <td><div id='nombreComercial'></div></td>
                                      <td><input class='form-control' id='profInterno' name='profInterno'></td>
                                      <td><textarea class='form-control' name='obsProfesor' id='obsProfesor' rows='1'></textarea></td>
                                      <td>
                                        <div class='d-flex'>
                                          <a id='btnAsignaProfesor' class='btn btn-success mr-1 btnAsignaProfesor' name='btnAsignaProfesor' 
                                              title='Asignar' style='float:right'><i class='fas fa-thumbs-up' style='color:white;float:right;'></i>
                                          </a>             
                                        </div>
                                      </td>
                                    </tr>";

                              foreach ($profesoresProy as $prof) {
                                echo "
                                      <tr>
                                        <td><div>" . $prof->RAZONSOCIAL . "</div></td>
                                        <td><div>" . $prof->nifdniprofesor . "</div></td>
                                        <td><div>" . $prof->NOMBRECOMERCIAL . "</div></td>
                                        <td><div>" . $prof->profesorInterno . "</div></td>
                                        <td><div>" . $prof->obsProfesor . "</div></td>";
                                /*
                                        <td>                                         
                                          <<a target='_blank' href='".RUTA_URL."/Proyecto/exportarPdfFactura/".$factura->idfactura."/enviarFactura'
                                                  id='btnEnviarFactura' name='enviarFactura' class='btn btn-warning mr-1' data-idFac='".$factura->idfactura."' title='Enviar factura' style='color:white;'>
                                                  <i class='fas fa-envelope-square'></i>
                                          </a>
                                        </td>*/
                                echo "
                                      </tr>";
                              }

                              ?>
                            </tbody>
                          </table>

                        </div>

                        <div class="" id="asignacionParticipantes">
                          <div class="mb-2">
                            <a href="#">Alumnos participantes</a>

                          </div>

                          <div class="mb-2">
                            <a id="importarPlantilla" class="btn btn-primary text-white"><i class="fas fa-file-excel mr-2"></i>Importar</a>
                            <button id="addFromBD" type="button" class="btn btn-secondary text-white" data-toggle="modal"><i class="fas fa-database mr-2"></i>Añadir BD</button>
                            <button id="btnNuevo" type="button" class="btn btn-info text-white" data-toggle="modal"><i class="fas fa-user-plus mr-2"></i>Nuevo</button>

                            <div class='col-sm-4 my-1' id='formularioSubirFichero' style='display:none;'>
                              <input type="text" class="form-control" name="descripcionFichero" id="descripcionFicheroParticipantes" placeholder="Descripción fichero">
                              <input type="file" class="form-control-file my-1" name="plantillaParticipantes" id="plantillaParticipantes" placeholder="Adjunte fichero excel">
                              <button type="button" name='importPlantilla' id="btnAddFicheroParticipantes" class="btn btn-success ml-0" style="color:#fff;">Importar Alumnos</button>
                            </div>
                          </div>

                          <table class="table" id="tablaParticipantes">
                            <thead>
                              <tr>
                                <th>idparticipante</th>
                                <th>NIF Participante</th>
                                <th>Nombre</th>
                                <th>Apellido 1</th>
                                <th>Apellido 2</th>
                                <th>Empresa</th>
                                <th>Acciones</th>
                              </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
                        </div>

                      </div>
                    </div>
                  </div>
                  <!-- /.tab-pane -->

                  <!--Modal para CRUD participantes-->
                  <div class="modal fade bd-example-modal-lg" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <center>
                            <h5 class="modal-title" id="myModalLabel"></h5>
                          </center>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form id="formularioParticipantes">
                          <div class="modal-body">
                            <div class="row form-group">
                              <div class="col-sm-2">
                                <label class="control-label" style="position:relative; top:7px;">DNI:
                                </label>
                              </div>
                              <div class="col-sm-4">
                                <input type="text" id="dniParticipante" regexp="[a-zA-Z0-9]{0,9}" class="form-control form-control-sm" name="dni" required>
                              </div>
                              <div class="col-sm-2">
                                <label class="control-label" style="position:relative; top:7px;">Nombre:
                                </label>
                              </div>
                              <div class="col-sm-4">
                                <input type="text" id="nombreParticipante" class="form-control form-control-sm" name="nombre">
                              </div>
                            </div>
                            <div class="row form-group">
                              <div class="col-sm-2">
                                <label class="control-label" style="position:relative; top:7px;">Apellido 1:
                                </label>
                              </div>
                              <div class="col-sm-4">
                                <input type="text" id="apellido1Participante" class="form-control form-control-sm" name="apellido1">
                              </div>
                              <div class="col-sm-2">
                                <label class="control-label" style="position:relative; top:7px;">Apellido 2:
                                </label>
                              </div>
                              <div class="col-sm-4">
                                <input type="text" id="apellido2Participante" class="form-control form-control-sm" name="apellido2">
                              </div>
                            </div>
                            <div class="row form-group">
                              <div class="col-sm-2">
                                <label class="control-label" style="position:relative; top:7px;">Fecha Nacimiento:
                                </label>
                              </div>
                              <div class="col-sm-4">
                                <input type="date" id="fechaNacimientoParticipante" class="form-control form-control-sm" name="fechaNacimiento">
                              </div>
                              <div class="col-sm-2">
                                <label class="control-label" style="position:relative; top:7px;">Email:
                                </label>
                              </div>
                              <div class="col-sm-4">
                                <input type="mail" id="emailParticipante" class="form-control form-control-sm" name="email">
                              </div>
                            </div>
                            <div class="row form-group">
                              <div class="col-sm-2">
                                <label class="control-label" style="position:relative; top:7px;">Teléfono:
                                </label>
                              </div>
                              <div class="col-sm-4">
                                <input type="text" id="telefonoParticipante" regexp="[0-9]{0,9}" class="form-control form-control-sm" name="telefono">
                              </div>
                              <div class="col-sm-2">
                                <label class="control-label" style="position:relative; top:7px;">Nº.S.Social:
                                </label>
                              </div>
                              <div class="col-sm-4">
                                <input type="text" id="numSocialParticipante" regexp="[0-9]{0,12}" class="form-control form-control-sm" name="numSocial">
                              </div>
                            </div>
                            <div class="row form-group">
                              <div class="col-sm-2">
                                <label class="control-label" style="position:relative; top:7px;">Sexo:
                                </label>
                              </div>
                              <div class="col-sm-4">
                              <select id="sexoParticipante" class="form-control select2" name="sexo">
                                <option>Masculino</option>
                                <option>Femenino</option>
                              </select>
                              </div>
                              <div class="col-sm-2">
                                <label class="control-label" style="position:relative; top:7px;">Nivel de estudios:
                                </label>
                              </div>
                              <div class="col-sm-4">
                                <!-- <input type="text" id="nivelEstudiosParticipante" class="form-control form-control-sm" name="nivelEstudios"> -->
                                <select id="nivelEstudiosParticipante" class="form-control select2" name="nivelEstudios">
                                </select>
                              </div>
                            </div>
                            <div class="row form-group">
                              <div class="col-sm-2">
                                <label class="control-label" style="position:relative; top:7px;">Categoria profesional:
                                </label>
                              </div>
                              <div class="col-sm-4">
                                <!-- <input type="text" id="catProfesionalParticipante" class="form-control form-control-sm" name="catProfesional"> -->
                                <select id="catProfesionalParticipante" class="form-control select2" name="catProfesional">
                                </select>
                              </div>
                              <div class="col-sm-2">
                                <label class="control-label" style="position:relative; top:7px;">Grupo de cotizacion:
                                </label>
                              </div>
                              <div class="col-sm-4">
                                <!-- <input type="text" id="grupoCotizacionParticipante" class="form-control form-control-sm" name="grupoCotizacion"> -->
                                <select id="grupoCotizacionParticipante" class="form-control select2" name="grupoCotizacion">
                                </select>                                
                              </div>
                            </div>
                            <div class="row form-group">
                              <div class="col-sm-2">
                                <label class="control-label" style="position:relative; top:7px;">Discapacidad:
                                </label>
                              </div>
                              <div class="col-sm-4">
                                <input type="text" id="discapacidadParticipante" class="form-control form-control-sm" name="discapacidad">
                              </div>
                              <div class="col-sm-2">
                                <label class="control-label" style="position:relative; top:7px;">Afectados/ victima terrorismo:
                                </label>
                              </div>
                              <div class="col-sm-4">
                                <input type="text" id="terrorismoParticipante" class="form-control form-control-sm" name="terrorismo">
                              </div>
                            </div>
                            <div class="row form-group">
                              <div class="col-sm-2">
                                <label class="control-label" style="position:relative; top:7px;">Afectados/ victima violencia de genero:
                                </label>
                              </div>
                              <div class="col-sm-4">
                                <input type="text" id="violenciaGeneroParticipante" class="form-control form-control-sm" name="violenciaGenero">
                              </div>
                              <div class="col-sm-2">
                                <label class="control-label" style="position:relative; top:7px;">Fecha alta:
                                </label>
                              </div>
                              <div class="col-sm-4">
                                <input type="date" id="fechaAltaParticipante" class="form-control form-control-sm" name="fechaAlta">
                              </div>
                            </div>
                            <div class="row form-group">
                              <div class="col-sm-2">
                                <label class="control-label" style="position:relative; top:7px;">NºPatronal:
                                </label>
                              </div>
                              <div class="col-sm-4">
                                <input type="text" id="numPatronalParticipante" class="form-control form-control-sm" name="numPatronal">
                              </div>
                            </div>
                            <input type="hidden" id="opcionCRUD" value="1">
                            <input type="hidden" id="idParticipante" value="">
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                            <button type="submit" id="" class="btn btn-dark btnGuardarPart">Guardar</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <!--Modal para añadir participantes desde la BD-->
                  <div class="modal fade" id="modalAddExistente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header participantesBD">
                          <h5 class="modal-title" id="exampleModalLabel2"></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form id="formPersonasExistentes">
                          <div class="modal-body">
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label for="empleado" class="col-form-label">Buscar participante:</label>
                              </div>
                            </div>

                            <div class="form-group contenedorEmpleado">
                              <select id="idEmpleadoBD" class="form-control select2" name="idEmpleadoBD">
                                <option selected>&nbsp;</option>
                              </select>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                            <button type="submit" id="btnAnadirPart" class="btn btn-dark">Agregar</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>


                  <div class="tab-pane" id="ingresosgastos">
                    <div class="post">
                      <div class="user-block">
                        <div id="fichaProyectoDetallada">

                        </div>

                        <div id="contTodosLosClientes" style="display: none;">
                        </div>

                      </div>
                    </div>
                  </div>

                  <div class="tab-pane" id="balance">
                    <div class="post">
                      <div class="user-block" style="width: 45%;">


                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col" class="text-left">Balance</th>
                              <th scope="col" class="text-center">Base imponible</th>
                              <th scope="col" class="text-center">Iva</th>
                              <th scope="col" class="text-center">IRPF</th>
                              <th scope="col" class="text-center">Total</th>
                            </tr>
                          </thead>
                          <tfoot>
                            <tr>
                              <th scope="col">TOTAL</th>
                              <th scope="col"></th>
                              <th scope="col"></th>
                              <th scope="col"></th>
                              <th scope="col" class="text-right"><?php echo number_format(($datosBalance["totalIngresos"] + $datosBalance["totalNegativa"] - $datosBalance["totalGastos"]), 2, ",", ".") ?> €</th>
                            </tr>
                          </tfoot>
                          <tbody>

                            <tr>
                              <th scope="row">Facturas Ingreso</th>
                              <td class="text-right"><?php echo number_format($datosBalance["importeIngresos"], 2, ",", ".") ?> €</td>
                              <td class="text-right"><?php echo number_format($datosBalance["ivaIngresos"], 2, ",", ".") ?> €</td>
                              <td class="text-right">0</td>
                              <td class="text-right"><?php echo number_format($datosBalance["totalIngresos"], 2, ",", ".") ?> €</td>
                            </tr>
                            <tr>
                              <th scope="row">Facturas Abono</th>
                              <td class="text-right"><?php echo number_format($datosBalance["importeNegativa"], 2, ",", ".") ?> €</td>
                              <td class="text-right"><?php echo number_format($datosBalance["ivaNegativa"], 2, ",", ".") ?> €</td>
                              <td class="text-right">0</td>
                              <td class="text-right"><?php echo number_format($datosBalance["totalNegativa"], 2, ",", ".") ?> €</td>
                            </tr>
                            <tr>
                              <th scope="row">Facturas Gasto</th>
                              <td class="text-right"><?php echo number_format($datosBalance["importeGastos"], 2, ",", ".") ?> €</td>
                              <td class="text-right"><?php echo number_format($datosBalance["ivaGastos"], 2, ",", ".") ?> €</td>
                              <td class="text-right"><?php echo number_format($datosBalance["irpf"], 2, ",", ".") ?> €</td>
                              <td class="text-right"><?php echo number_format($datosBalance["totalGastos"], 2, ",", ".") ?> €</td>
                            </tr>
                          </tbody>
                        </table>

                      </div>
                    </div>
                  </div>

                  <div class="tab-pane" id="documentos">
                    <div class="post">
                      <div class="user-block d-flex">
                        <div class="table-responsive" id="fichaProyectoDocumentos">
                          <a href="#">Documentos sin datos</a>
                          <table class="table" id="tablaDocProyectos">
                            <thead class="">
                              <tr>
                                <th>Documento</th>
                                <th class="text-center">Acciones</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $array = ['1' => 'Partes de firmas', '2' => 'Partes de firmas con logo Fundae', '3' => 'Recibí material', '4' => 'Recibí material con logo Fundae', '5' => 'Recibí diploma', '6' => 'Recibí diploma con logo Fundae'];
                              echo "<tr>
                                    <td class='py-0'>
                                      <select class='form-control' name='tipoDocSelect1' id='tipoDocSelect1'>
                                        <option selected></option>";
                              foreach ($array as $row => $val) {
                                echo "
                                        <option value='" . $row . "'>" . $val . "</option>";
                              }
                              echo "
                                      </select>
                                    </td>
                                    <td class='py-0 contBtnsDocs'>
                                      <div class='row justify-content-center'>     
                                        <a id='btnDownloadDoc' class='mx-3'><i class='fas fa-file-download'></i></a>                                        
                                        <a class='mx-3' id='enviarFormulario1' title='enviar'><i class='fas fa-envelope'></i></a>                                        
                                      </div>
                                    </td>
                                  </tr>";
                              ?>
                            </tbody>
                          </table>



                        </div>

                        <div class="table-responsive" id="fichaProyectoDocumentos2">
                          <a href="#">Documentos con datos</a>
                          <table class="table" id="tablaDocProyectos2">
                            <thead class="">
                              <tr>
                                <th>Documento</th>
                                <th class="text-center">Acciones</th>
                              </tr>
                            </thead>
                            <tbody>

                              <?php
                              $array = ['1' => 'Partes de firmas', '2' => 'Partes de firmas con logo Fundae', '3' => 'Recibí material', '4' => 'Recibí material con logo Fundae', '5' => 'Recibí diploma', '6' => 'Recibí diploma con logo Fundae'];
                              echo "<tr>
                                    <td class='py-0'>
                                      <select class='form-control' name='tipoDocSelect2' id='tipoDocSelect2'>
                                        <option selected></option>";
                              foreach ($array as $row => $val) {
                                echo "
                                        <option value='" . $row . "'>" . $val . "</option>";
                              }
                              echo "
                                      </select>
                                    </td>
                                    <td class='py-0 contBtnsDocs'>
                                      <div class='row justify-content-center'>     
                                        <a id='btnGenerarPdf' class='mx-3'><i class='fas fa-file-download'></i></a>                                        
                                        <a class='mx-3' id='enviarFormulario2' title='enviar'><i class='fas fa-envelope'></i></a>                                        
                                      </div>
                                    </td>
                                  </tr>";
                              ?>
                            </tbody>
                          </table>
                        </div>

                      </div>
                    </div>

                  </div>

                  <!--Modal para CRUD documentos-->
                  <div class="modal fade" id="modalDocumentos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel3"></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form id="formPersonas">
                          <div class="modal-body">
                            <div class="form-group">
                              <label for="docIdentidad" class="col-form-label">Doc. Identidad</label>
                              <input type="text" class="form-control" id="docIdentidad">
                            </div>
                            <div class="form-group">
                              <label for="nombre" class="col-form-label">Nombre:</label>
                              <input type="text" class="form-control" id="nombre">
                            </div>
                            <div class="form-group">
                              <label for="apellido1" class="col-form-label">Primer apellido:</label>
                              <input type="text" class="form-control" id="apellido1">
                            </div>
                            <div class="form-group">
                              <label for="apellido2" class="col-form-label">Segundo apellido:</label>
                              <input type="text" class="form-control" id="apellido2">
                            </div>
                            <div class="form-group">
                              <label for="idEmpresa" class="col-form-label">Empresa:</label>
                              <input type="text" class="form-control" id="idEmpresa">
                            </div>
                          </div>
                          <div class="modal-footer">

                            <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                            <button type="submit" id="btnGuardarPartDocumentos" class="btn btn-dark">Guardar</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <?php require(RUTA_APP . '/views/includes/modalEmail.php'); ?>

                  <div class="tab-pane" id="ficheros">
                    <div class="post">
                      <div class="user-block d-flex">
                        <div class="table-responsive">
                          <div class="form-group" style="padding-bottom:15px;">
                            <a id="anadirFicheroProy" class="btn btn-secondary text-white">Añadir fichero</a>
                            <div class='col-sm-4 mt-2 mb-4' id='formularioSubirFicheroProy' style='display:none;'>
                              <input type="text" class="form-control" name="nombreFicheroProy" id="nombreFicheroProy" placeholder="Descripción fichero">
                              <input type="file" class="form-control-file my-1" name="ficheroProyecto" id="ficheroProyecto" placeholder="Adjunte fichero">
                              <button type="submit" id="btnAnadirFichero" class="btn btn-success">Añadir</button>
                            </div>
                            <div class="mt-3">
                              <table class="table table-striped" id="tablaDocumentosproyecto">
                                <thead>
                                  <tr>
                                    <th>idDocumento</th>
                                    <th>idproyecto</th>
                                    <th>tipo</th>
                                    <th>nombre</th>
                                    <th>descripcion</th>
                                    <th>Acciones</th>
                                  </tr>
                                </thead>
                                <tbody>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="emails">
                    <div class="post">
                      <div class="user-block">
                        <div id="contenedorTablaEmails">

                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <!-- MODAL EMAIL DETALLADO -->
                <div class="modal fade" id="Detalle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header" style="margin-top:5px !important;">
                        <h4 id="asunto" class="modal-title" style="margin-top:5px !important;">
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>

                      <div id="modalBody" class="modal-body">
                        <div class="" id="">
                          <div class="mailbox-read-info row">
                            <h6 class="col-md-6" id="remitente">
                            </h6>
                            <span class="col-md-6 float-right" id="date"></span>
                          </div>
                          <div class="mailbox-read-info">
                            <h6 id="destinatarios"></h6>
                          </div>
                          <div class="mailbox-read-message" style="overflow-y:scroll; height:200px">
                            <p id="contEmailDetallado">
                            </p>
                          </div>
                        </div>
                        <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                          <li id="fattachment">
                            <span class="mailbox-attachment-icon"><i class="far fa-file"></i></span>
                            <div class="mailbox-attachment-info">
                              <a href="#" id="enlacePDFEmail" class="mailbox-attachment-name attach"><i class="fas fa-paperclip"></i> Factura PDF </a>

                            </div>
                          </li>
                        </ul>
                      </div>
                      <div class="modal-footer justify-content-center" style="margin:2px !important;">
                        <button class="btn btn-primary cerrarModalEmail" data-dismiss="modal">Cerrar</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.tab-content -->
            </div><!-- /.card-body -->

          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
    </div>
    <!-- /.row -->
  </section>

  <!-- </form> -->






  <?php require(RUTA_APP . '/views/includes/footer2.php'); ?>