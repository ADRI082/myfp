 <!-- Sidebar -->
 <div class="sidebar">
     <!-- Sidebar user panel (optional) -->
     <div class="user-panel mt-3 pb-3 mb-3 d-flex">
         <div class="image">
             <!-- <img src="<?php //echo RUTA_URL 
                            ?>/img/<?php //echo $_SESSION['nombre']; 
                                ?>.png" class="img-circle elevation-2" alt="User Image"> -->
         </div>
         <div class="info">
             <a href="#" class="d-block"><?php echo $_SESSION['nombre'] . " " . $_SESSION['apellidos']; ?></a>
         </div>
     </div>

     <!-- Sidebar Menu -->
     <nav class="mt-2">
         <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
             <?php

                if ($_SESSION['rol'] == '1' || $_SESSION['rol'] == '3') {
                    $permisos = [
                        'Seguimiento Acciones', 'Ingresos/Gastos', 'Registro Personal', 'Varios', 'Ficha Clientes', 'Calendario',
                        'Eventos', 'Presupuestos', 'Proyectos', 'Agentes Informa', 'Colaboradores', 'Oportunidades', 'Clientes', 'Acciones',
                        'Profesores y C.F.', 'Proveedores', 'Asesores', 'Gastos Generales', 'Act. Empresariales', 'Areas formativas', 'Contactos', 'Cuentas Bancarias', 'Cuentas Contables',
                        'Tipos Gastos Generales', 'Materiales', 'Modalidades', 'Plantillas', 'Roles', 'Sectores', 'Tipos de Acción', 'Vídeos', 'Mi perfil','Cursos','Mis Asignaturas'
                    ];
                } else {
                    $permisos = ['Ingresos/Gastos'];
                }


                ?>

             <!-- =======VIDEOS DE TEST====== -->
             <?php

                ?>

             <li class="nav-item has-treeview">
                 <a href="#" class="nav-link active">
                     <i class="nav-icon fas fa-user"></i>
                     <p>
                         Perfil
                         <i class="right fas fa-angle-left"></i>
                     </p>
                 </a>
                 <ul class="nav nav-treeview">
                     <?php
                        $videos = array(
                            array('nombre' => 'Mi perfil', 'url' => 'Perfil', 'icon' => 'fas fa-user')

                        );

                        foreach ($videos as $opcion) {
                            if (in_array($opcion['nombre'], $permisos)) {
                                echo "
                                            <li class='nav-item'>
                                                <a href='" . RUTA_URL . "/" . $opcion['url'] . "' class='nav-link'>
                                                    <i class='" . $opcion['icon'] . " nav-icon'></i>
                                                    <p>" . $opcion['nombre'] . "</p>
                                                </a>
                                            </li>";
                            }
                        }
                        ?>

                 </ul>
             </li>

             <li class="nav-item has-treeview">
                 <a href="#" class="nav-link active">
                     <i class="nav-icon fas fa-book"></i>
                     <p>
                         Cursos
                         <i class="right fas fa-angle-left"></i>
                     </p>
                 </a>
                 <ul class="nav nav-treeview">
                     <?php
                        $videos = array(
                            array('nombre' => 'Cursos', 'url' => 'Cursos', 'icon' => 'fas fa-book')

                        );

                        foreach ($videos as $opcion) {
                            if (in_array($opcion['nombre'], $permisos)) {
                                echo "
                                            <li class='nav-item'>
                                                <a href='" . RUTA_URL . "/" . $opcion['url'] . "' class='nav-link'>
                                                    <i class='" . $opcion['icon'] . " nav-icon'></i>
                                                    <p>" . $opcion['nombre'] . "</p>
                                                </a>
                                            </li>";
                            }
                        }
                        ?>

                 </ul>

                 
             </li>
             <li class="nav-item has-treeview">
                 <a href="#" class="nav-link active">
                     <i class="nav-icon fas fa-book-open"></i>
                     <p>
                         Asignaturas
                         <i class="right fas fa-angle-left"></i>
                     </p>
                 </a>
                 <ul class="nav nav-treeview">
                     <?php
                        $videos = array(
                            array('nombre' => 'Mis Asignaturas', 'url' => 'AsignaturasUsuario', 'icon' => 'fas fa-book-open')

                        );

                        foreach ($videos as $opcion) {
                            if (in_array($opcion['nombre'], $permisos)) {
                                echo "
                                            <li class='nav-item'>
                                                <a href='" . RUTA_URL . "/" . $opcion['url'] . "' class='nav-link'>
                                                    <i class='" . $opcion['icon'] . " nav-icon'></i>
                                                    <p>" . $opcion['nombre'] . "</p>
                                                </a>
                                            </li>";
                            }
                        }
                        ?>

                 </ul>
             </li>
         </ul>
     </nav>
 </div>