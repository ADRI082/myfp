<section id="docker" class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                <div class="card card-primary">
                    <div class="card-header cardFichaCliente">
                        <h3 class="card-title">
                            <?php echo $datos["empresaCliente"]->codEmpresa . " - " . $datos["empresaCliente"]->NOMBREJURIDICO; ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- Date dd/mm/yyyy -->
                        <div class="form-group mt-2">
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-sm"><strong>CIF</strong></span>
                                </div>
                                <input type="text" class="form-control input-sm w-50" value="<?php echo $datos["empresaCliente"]->CIFCLIENTE; ?>">
                                <input type="hidden" id="empresa" value="<?php echo $datos['empresaCliente']->idEMPRESA; ?>">
                                <!-- /.input group -->
                            </div>
                        </div>
                        <!-- /.form group -->
                        <div class="form-group mt-2">
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-sm"><strong>Grupo</strong></span>
                                </div>
                                <input type="text" class="form-control input-sm w-50" value="<?php echo $datos["empresaCliente"]->nombreG; ?>">

                                <!-- /.input group -->
                            </div>
                        </div>
                        <!-- /.form group -->
                        <div class="form-group mt-1">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-sm"><strong>Direcc.</strong></span>
                                </div>
                                <input type="text" class="form-control input-sm" value="<?php echo $datos["empresaCliente"]->DIRECCION; ?>">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->

                        <div class="form-group mt-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-sm"><strong>Loc.</strong></span>
                                </div>
                                <input type="text" class="form-control input-sm" value="<?php echo $datos["empresaCliente"]->LOCALIDAD; ?>">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-sm"><i class="fas fa-mail-bulk"></i></span>
                                </div>
                                <input type="text" class="form-control input-sm" value="<?php echo $datos["empresaCliente"]->CODPOSTAL; ?>">
                            </div>
                            <!-- /.input group -->
                        </div>

                        <div class="form-group mt-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><strong>Prov.</strong></span>
                                </div>
                                <input type="text" class="form-control" value="<?php echo $datos["empresaCliente"]->PROVINCIA; ?>">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->

                        <!-- phone mask -->
                        <div class="form-group mt-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input type="text" class="form-control" value="<?php echo $datos["empresaCliente"]->TELEFONOFIJO1; ?>">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->
                        <!-- phone mask -->
                        <div class="form-group mt-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" value="<?php echo $datos["empresaCliente"]->TELEFONOMOVIL; ?>">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->
                        <!-- phone mask -->
                        <div class="form-group mt-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-at"></i></span>
                                </div>
                                <input type="text" class="form-control" value="<?php echo $datos["empresaCliente"]->EMAIL; ?>">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->
                        <!-- phone mask -->
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fab fa-internet-explorer"></i></span>
                                </div>
                                <input type="text" class="form-control" value="<?php echo $datos["empresaCliente"]->WEB; ?>">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><strong>NSS</strong></span>
                                </div>
                                <input type="text" class="form-control" value="<?php echo $datos["empresaCliente"]->NSSEMPRESA; ?>">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><strong>Actividad</strong></span>
                                </div>
                                <input type="text" class="form-control" value="<?php echo $datos["empresaCliente"]->DESACTIVIDAD; ?>">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><strong>Sector</strong></span>
                                </div>
                                <input type="text" class="form-control" value="<?php echo $datos["empresaCliente"]->SECTOR; ?>">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><strong>RLT</strong></span>
                                </div>
                                <input type="text" class="form-control" value="<?php echo $datos["empresaCliente"]->RLTT; ?>">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><strong> Cliente</strong></span>
                                </div>
                                <input type="text" class="form-control" value="<?php echo $datos["empresaCliente"]->escliente; ?>">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><strong>Trabajadores</strong></span>
                                </div>
                                <input type="text" class="form-control" value="<?php echo $datos["empresaCliente"]->numtrabajadores; ?>">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><strong>Convenio</strong></span>
                                </div>
                                <input type="text" class="form-control" value="<?php echo $datos["empresaCliente"]->CONVENIO; ?>">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><strong>Fecha Conv.</strong></span>
                                </div>
                                <input type="text" class="form-control" value="<?php echo $datos["empresaCliente"]->FechaConvenio; ?>">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->
                    </div>
                    <!-- /.card-body -->
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            Colaborador
                        </h3>
                    </div>
                    <?php foreach ($datos['colaboradores'] as $colaborador) { ?>
                        <div class="card-body">
                            <div class="form-group mt-2">
                                <div class="input-group ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-sm"><strong>NIF</strong></span>
                                    </div>
                                    <input type="text" class="form-control input-sm w-50" value="<?php echo $colaborador->NifColaborador; ?>">
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <div class="input-group ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-sm"><strong>Razón Social</strong></span>
                                    </div>
                                    <input type="text" class="form-control input-sm w-50" value="<?php echo $colaborador->RazonSocial; ?>">
                                </div>
                            </div>
                            <!-- /.form group -->
                            <div class="form-group mt-2">
                                <div class="input-group ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-sm"><strong>Tipo</strong></span>
                                    </div>
                                    <input type="text" class="form-control input-sm w-50" value="<?php echo $colaborador->TipoColaborador; ?>">
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <div class="input-group ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-sm"><strong><i class="fas fa-user-plus"></i></strong></span>
                                    </div>
                                    <input type="text" class="form-control input-sm w-50" value="<?php echo $colaborador->Contactocolaborador; ?>">
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <div class="input-group ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-sm"><strong><i class="fas fa-mobile-alt"></i></strong></span>
                                    </div>
                                    <input type="text" class="form-control input-sm w-50" value="<?php echo $colaborador->movilcolaborador; ?>">
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <div class="input-group ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-sm"><strong><i class="fas fa-at"></i></strong></span>
                                    </div>
                                    <input type="text" class="form-control input-sm w-50" value="<?php echo $colaborador->emailcolaborador; ?>">
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <div class="input-group ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-sm"><strong><i class="fas fa-comments"></i></strong></span>
                                    </div>
                                    <input type="text" class="form-control input-sm w-50" value="<?php echo $colaborador->observaciones; ?>">
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

            </div>
            <!-- /.col (left) -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                <div class="card h-100">
                    <div class="card-header d-flex p-0">
                        <h3 class="card-title p-3">Actividades</h3>
                        <ul class="nav nav-pills ml-auto p-2">
                            <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab"><i class="fas fa-user-edit"></i></a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab"><i class="fas fa-project-diagram"></i></a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab"><i class="fab fa-stack-overflow"></i></a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab_4" data-toggle="tab"><i class="fas fa-search-dollar"></i></a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab_5" data-toggle="tab"><i class="fas fa-calendar-alt"></i></a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab_6" data-toggle="tab"><i class="fas fa-envelope-square"></i></a></li>


                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <!--Inicio Editor para incluir comentarios acerca del cliente -->

                                <div class="form-group">
                                    <input type="date" id="fechaObservacion" class="form-control" placeholder="Fecha" required>
                                </div>
                                <div class="form-group">
                                    <select class="form-control select2 datos" placeholder="Agente" id="agenteObservacion" style="width: 100%;" required>
                                        <option value="" disabled selected>Agente.....</option>
                                        <?php foreach ($datos['agentes'] as $agente) : ?>
                                            <option value="<?php echo $agente->codagente; ?> ">
                                                <?php echo $agente->Nombre . " " . $agente->Apellidos; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" id="tituloObservacion" class="form-control" placeholder="Titulo">
                                </div>
                                <div class="form-group">
                                    <textarea name="editor1" id="editor1" rows="10" cols="80">
                                                Escribe aquí todo lo relacionado con el cliente.                                                
                                                </textarea>
                                    <div class="float-right mt-2">

                                        <button id="incluirtexto" class="btn btn-success">A&ntilde;adir</button>
                                    </div>
                                </div>
                                <!-- Fin Editor para incluir comentarios del cliente -->
                                <!-- Inicio de los items expandibles con las observaciones por fecha -->
                                <div class="clearfix mb-4 listadoObservaciones"><br></div>
                                <?php foreach ($datos['observaciones'] as $observaciones) { ?>
                                    <div class="col-md-12 mt-1">
                                        <div class="card card-light collapsed-card">
                                            <div class="card-header">
                                                <h3 class="card-title" style="font-size: 1em;">
                                                    <!-- <a href="print_pdf?id=<?php //echo $observaciones->titulo. " <br> " .$observaciones->contenido ; 
                                                                                ?>"> -->
                                                    <a href="<?php echo RUTA_URL; ?>/Print_pdf/buscador/<?php echo $observaciones->idObservacion ?>">
                                                        <i class="fas fa-file-pdf" style="color:red;"></i></a>&nbsp;&nbsp;
                                                    <?php echo date("d/m/Y", strtotime($observaciones->fecha)) . " - " . $observaciones->titulo;  ?>
                                                </h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                                <!-- /.card-tools -->
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <h6><?php echo "<strong>Autor: " . $observaciones->agente . " </strong>"; ?>
                                                </h6>
                                                <?php echo $observaciones->contenido; ?>
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                <?php } // fin del foreach 
                                ?>
                                <!-- /.col -->
                                <!-- Fin de los itmes expandibles con las observaciones por fecha -->
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_2">

                                Listado de proyectos de este cliente.

                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_3">
                                Situacion de creditos de formación
                            </div>
                            <!-- /.tab-pane -->
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_4">
                                Relación de ingresos y costes de este cliente
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_5">
                                <div class="row">
                                    <div class="col-xs-12 table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="text-center">
                                                    <td><strong>Inicio</strong></td>
                                                    <td><strong>Fin</strong></td>
                                                    <td><strong>Estado</strong></td>
                                                    <td><strong>Actividad</strong></td>
                                                    <td><strong>Comentarios</strong></td>
                                                    <td><strong>Agente</strong></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($datos['eventos'] as $evento) { ?>
                                                    <?php $fila = $evento->estado == "Terminado" ? "<tr class='table-success '>" : ($evento->estado == "En Proceso" ? "<tr class='table-warning'>" : ($evento->estado == "Pendiente" ? "<tr class='table-danger'>" : "<tr class='table-danger'>"));
                                                    echo $fila;  ?>
                                                    <td><?php echo date("d/m/Y H:i", strtotime($evento->start));  ?></td>
                                                    <td><?php echo date("d/m/Y H:i", strtotime($evento->end));  ?></td>
                                                    <td><?php echo $evento->estado;  ?></td>
                                                    <td><?php echo $evento->actividad;  ?></td>
                                                    <td><?php echo $evento->contenido;  ?></td>
                                                    <td><?php echo $evento->codagente;  ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_6">
                                <div class="col-md-12">
                                    <p>
                                        <!-- ENVIO DE EMAIL -->
                                        <a class="btn btn-primary  enviar" style="margin-left:32vw" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                            Enviar Email
                                        </a>
                                    </p>
                                    <div class="collapse" id="collapseExample">
                                        <div class="card card-primary card-outline ">
                                            <div class="card-header">
                                                <h3 class="card-title">Enviar nuevo mensaje</h3>
                                                <div class="card-tools">
                                                </div>
                                            </div>
                                            <!-- /.card-header -->
                                            <form method="POST" action="FichaClientes/agregarEmail" enctype="multipart/form-data">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <input type="hidden" name="id" value="<?php echo $datos['empresaCliente']->idEMPRESA; ?>">
                                                        <input type="hidden" name="remitente" value="<?php echo $_SESSION['mail']; ?>">
                                                        <input class="form-control" name="email" value="<?php echo $datos['empresaCliente']->EMAIL; ?>" placeholder="To:" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <input class="form-control" name="subject" placeholder="Subject:" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <textarea id="editor2" name="contenido" class="form-control" style="height: 300px" required>
                                                          Escribe aquí el mensaje
                                                   </textarea>
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->
                                                <div class="card-footer">
                                                    <div class="btn btn-default btn-file">
                                                        <i class="fas fa-paperclip"></i> Attachment
                                                        <input name="fichero_usuario" type="file" id="image" value="Upload">
                                                    </div>
                                                    <div class="float-right">
                                                        <button type="submit" class="btn btn-primary det"><i class="far fa-envelope"></i> Enviar</button>
                                                    </div>
                                                </div>
                                                <!-- /.card-footer -->
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>
                                <!-- TABLA DE LOS EMAILS -->
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="font-size:13px"></th>
                                                <th scope="col" style="font-size:13px">Cliente</th>
                                                <th scope="col" style="font-size:13px">Asunto</th>
                                                <th scope="col" style="font-size:13px">Remitente</th>
                                                <th scope="col" style="font-size:13px">Fecha</th>
                                                <th scope="col" style="font-size:13px">Detalle</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($datos['emailCliente'] as $emailCliente) { ?>
                                                <tr>
                                                    <td style="color:grey; font-size:13px"><i class="fas fa-envelope-open-text"></i></td>
                                                    <td style="color:blue; font-size:13px">
                                                        <?php echo $emailCliente->NOMBREJURIDICO; ?></td>
                                                    <td style="font-size:13px"><?php echo $emailCliente->subject; ?></td>
                                                    <td style="font-size:13px"><?php echo $emailCliente->desde; ?></td>
                                                    <td style="font-size:13px">
                                                        <?php echo  date("d/m/Y ", strtotime($emailCliente->fecha));  ?>
                                                    <td style="font-size:13px">
                                                        <a href="#Detalle" class="detalle btn btn-xs btn-primary" id=<?php echo $emailCliente->idEmail; ?> type="button" data-toggle="modal" title="Detalle"><i class="far fa-eye"></i></a>
                                                    </td>
                                                    </td>
                                                </tr>

                                </div>
                            <?php } ?>
                            </tbody>
                            </table>
                            </div>
                            <!-- /.col -->
                            <!-- </div> -->
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- ./card -->
        </div>
        <!-- /.col (center) -->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Contactos</h3>
                </div>
                <div class="card-body">
                    <!-- Date range -->
                    <?php foreach ($datos["representante"] as $representante) { ?>
                        <div class="form-group">
                            <label>Representante:</label>
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-sm"><i class="fas fa-user-check"></i></span>
                                </div>
                                <input type="text" class="form-control input-sm w-50" value="<?php echo $representante->NOMBREREPRESENTANTE; ?>">

                                <!-- /.input group -->
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->
                        <div class="form-group">
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-sm"><strong>NIF</strong></span>
                                </div>
                                <input type="text" class="form-control input-sm w-50" value="<?php echo $representante->NIFREPRESENTANTE; ?>">

                                <!-- /.input group -->
                            </div>
                            <!-- /.input group -->
                        </div>
                    <?php } ?>
                    <!-- /.form group -->

                    <!-- Date and time range -->
                    <?php foreach ($datos["contactos"] as $contactos) { ?>
                        <div class="form-group">
                            <label>Contacto:</label>
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-sm"><i class="fas fa-user-plus"></i></span>
                                </div>
                                <input type="text" class="form-control input-sm w-50" value="<?php echo $contactos->nombreC; ?>">
                                <!-- /.input group -->
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->
                        <div class="form-group mt-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" value="<?php echo $contactos->movil; ?>">
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-users"></i></span>
                                </div>
                                <input type="text" class="form-control" value="<?php echo $contactos->areaDpto; ?>">
                            </div>
                        </div>
                    <?php } ?>
                    <!-- /.form group -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- segundo formulario de la fila de la derecha -->

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Asesor:</h3>
                </div>
                <?php foreach ($datos["asesores"] as $asesores) { ?>
                    <div class="card-body">
                        <!-- Date range -->
                        <!-- /.form group -->
                        <div class="form-group mt-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-handshake" title="Asesoría/Dpto."></i></span>
                                </div>
                                <input type="text" class="form-control" value="<?php echo $asesores->nomasesor; ?>">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group mt-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user-cog" title="contacto"></i></span>
                                </div>
                                <input type="text" class="form-control" value="<?php echo $asesores->contacto; ?>">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->
                        <div class="form-group mt-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input type="text" class="form-control" value="<?php echo $asesores->telefonoFijo; ?>">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->
                        <div class="form-group mt-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" value="<?php echo $asesores->movil; ?>">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->
                        <div class="form-group mt-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-at"></i></span>
                                </div>
                                <input type="text" class="form-control" value="<?php echo $asesores->mail; ?>">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->
                        <div class="form-group mt-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                </div>
                                <input type="text" class="form-control" value="<?php echo $asesores->direccion; ?>">
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                <?php } ?>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!--  END segundo formulario de la fila de la derecha -->
        </div>
        <!-- /.col (right) -->
    </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!----------------------------------- Modal Detalle Email--------------------------------------------------->
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
                    <div class="mailbox-read-info">
                        <h6 id="remitente">
                            <span class="mailbox-read-time float-right" id="date"></span>
                        </h6>
                    </div>
                    <div class="mailbox-read-info">
                        <h6 id="destinatarios">DESTINATARIOS: </h6>
                    </div>
                    <div style='padding: 15px 5px 15px 5px; background-color:lightgrey;'>
                        <img src='public/img/logo/myfp.png' alt='logo' style='height:50%'>

                        <a class="logo" href='https://www.facebook.com/myfp'><img src='public/img/facebook.png' style='float:right; width:25px; height:35px; margin-right:8px; padding-top:13px'></a>
                        <a class="logo" href='https://www.youtube.com/channel/UCYdUMN9I3HN3lFFbAhp9I-Q'><img src='public/img/youtube.png' style='float:right; width:25px; height:35px; margin-right:8px; padding-top:13px'></a>
                        <a class="logo" href='https://twitter.com/informaconsulto'><img src='public/img/twitter.png' style='float:right; width:25px; height:35px; margin-right:8px; padding-top:13px'></a>
                        <a class="logo" href='https://www.linkedin.com/company/informa-consultores'><img src='public/img/linkedin.png' style='float:right; width:25px; height:35px; margin-right:8px; padding-top:13px'></a>
                    </div>
                    <div>
                        <div class="mailbox-read-message" style="overflow-y:scroll; height:200px">
                            <p id="contEmail">
                            </p>
                        </div>
                    </div>
                    <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                        <li id="fattachment">
                            <span class="mailbox-attachment-icon"><i class="far fa-file"></i></span>
                            <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name attach"><i class="fas fa-paperclip"></i> </a>

                            </div>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer justify-content-center" style="margin:2px !important;">
                    <button class="btn btn-primary" data-dismiss="modal" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /.modal-content -->