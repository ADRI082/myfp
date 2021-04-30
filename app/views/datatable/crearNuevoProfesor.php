<?php require(RUTA_APP . '/views/includes/header2.php'); ?>

<!-- start contenido de la pagina -->
<div class="container">

    <!--Modal para agregar profesor-->
    <div class="modal probando" id="modalAddProfesor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <?php

                        $profesor = $datos['profesor'];
                        if ($datos['accion'] == 'Crear') {
                            $titulo = 'Agregar Profesor';
                            $metodo = 'agregarProfesor';                            
                        }else if ($datos['accion'] == 'Editar') {
                            $titulo = 'Editar Profesor';
                            $metodo = 'actualizarProfesor';
                        }
                        echo"<h4 class='modal-title' id='exampleModalLabel'>".$titulo."</h4>";
                    ?>
                    <a href = "<?php echo RUTA_URL ?>/datatable/profesores" class="close"><span aria-hidden="true">&times;</span></a>
                </div>
                <?php
                  echo"
                  <form method='POST' id='formProfesores' action='".RUTA_URL."/datatable/".$metodo."' enctype='multipart/form-data'>  
                                                       
                    <div class='modal-body'>
                        <h5 class='titleClienteDatos' >Datos de identificación</h5>
                        <div class='row'> 
                            <div class='col-lg-2'>
                              <div class='form-group'>
                                <label class='col-form-label'>Id Profesor</label>              
                                <input type='text' class='form-control' name='idProfesor' id='idProfesor' 
                                              value='".$profesor->idPROFESOR."' readonly>
                              </div>               
                            </div>
                            <div class='col-lg-2'>
                              <div class='form-group'>
                                <label class='col-form-label'>NIF</label>                                 
                                <input type='text' regexp='[a-zA-Z0-9]{0,9}' class='form-control obligatorio' name='nifProfesor'  maxlength='9' id='nifProfesor' 
                                    value='".$profesor->nifdniprofesor."' required>                                  
                              </div>               
                            </div>
                            <div class='col-lg-8'>
                                <div class='form-group'>
                                  <label for='nombreComercial' class='col-form-label'>Nombre Comercial</label>
                                  <input type='text' class='form-control obligatorio' name='nombreComercial' id='nombreComercial' 
                                    value='".$profesor->NOMBRECOMERCIAL."' required>
                                </div>
                            </div>                            
                        </div>
                        <div class='row'>
                            <div class='col-lg-6'>
                                <div class='form-group'>
                                  <label for='razonSocial' class='col-form-label'>Razón Social</label>
                                  <input type='text' class='form-control' name='razonSocial' id='razonSocial' value='".$profesor->RAZONSOCIAL."'>
                                </div>
                            </div>
                            <div class='col-lg-4'>
                                <div class='form-group'>
                                  <label for='contacto' class='col-form-label'>Contacto</label>
                                  <input value='".$profesor->contactoProfesor."' type='text' class='form-control' name='contacto' id='contacto'>
                                </div>
                            </div>
                            <div class='col-lg-2'>
                              <div class='form-group'>
                                <label for='' class='col-form-label'>Márgen(%)</label>
                                <input type='number' step='0.01' class='form-control' name='margencomercial' id='margencomercial' 
                                  value='".$profesor->MARGEN."'>
                              </div>
                            </div>                                                            
                        </div>
                    </div>                    
                    <div class='modal-body'>
                        <h5 class='titleClienteDatos' >Datos de localización</h5>
                        <div class='row'>
                            <div class='col-lg-6'>
                                <div class='form-group'>
                                  <label for='direccion' class='col-form-label'>Dirección</label>
                                  <input type='text' class='form-control' name='direccion' id='direccion' value='".$profesor->DIRECCION."'>
                                </div>
                            </div> 
                            <div class='col-lg-3'>
                                <div class='form-group'>
                                  <label for='poblacion' class='col-form-label'>Población</label>
                                  <input type='text' class='form-control' name='poblacion' id='poblacion' value='".$profesor->POBLACION."'>
                                </div>
                            </div>                          
                            <div class='col-lg-3'>
                                <div class='form-group'>
                                  <label for='' class='col-form-label'>Provincia</label>
                                  <input type='text' class='form-control' name='provincia' id='provincia' value='".$profesor->PROVINCIA."'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-lg-2'>
                                <div class='form-group'>
                                  <label for='' class='col-form-label'>Código postal</label>
                                  <input type='text' regexp='[0-9]{0,5}' class='form-control' name='codigopostal' id='codigopostal' value='".$profesor->CODPOSTAL."'>
                                </div>
                            </div>
                            <div class='col-lg-3'>
                                <div class='form-group'>
                                  <label for='TELEFONOFIJO' class='col-form-label'>Teléfono</label>
                                  <input type='text' regexp='[0-9]{0,9}' class='form-control' name='TELEFONOFIJO' id='TELEFONOFIJO'
                                    value='".$profesor->TELEFONOFIJO."'>
                                </div>
                            </div>
                            <div class='col-lg-3'>
                                <div class='form-group'>
                                  <label for='TELEFONOMOVIL' class='col-form-label'>Móvil</label>
                                  <input type='text' regexp='[0-9]{0,9}' class='form-control' name='TELEFONOMOVIL' id='TELEFONOMOVIL' value='".$profesor->TELEFONOMOVIL."'>
                                </div>
                            </div>
                            <div class='col-lg-4'>
                              <div class='form-group'>                              
                                  <label for='email' class='col-form-label'>Email</label>
                                  <input type='text' class='form-control' name='email' id='email' value='".$profesor->MAIL."'>                                                                                                                             
                              </div> 
                            </div>
                        </div>
                        <div class='row'>                            
                            <div class='col-lg-5'>
                                <div class='form-group'>
                                  <label for='webprofesor' class='col-form-label'>Web</label>
                                  <input type='text' class='form-control' name='webprofesor' id='webprofesor' value='".$profesor->webprofesor."'>
                                </div>
                            </div>
                            <div class='col-lg-4'>
                                <div class='form-group'>
                                  <label for='ccc' class='col-form-label'>Cód. Cuenta Corriente</label>
                                  <input type='text' regexp='[0-9]{0,24}' class='form-control' name='ccc' id='ccc' value='".$profesor->CCC."'>
                                </div>
                            </div>
                            <div class='col-lg-3'>
                                <div class='form-group'>
                                  <label for='numSegSocial' class='col-form-label'>NISS</label>
                                  <input type='text' regexp='[0-9]{0,12}' class='form-control' name='numSegSocial' id='numSegSocial' value='".$profesor->NSSPROFESOR."'>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <div class='modal-body'>
                        <h5 class='titleClienteDatos' >Currículum Vitae</h5>
                        <div class='row'>
                            <div class='col-lg-6'>
                                <div class='form-group'>
                                  <label for='formacionReglada' class='col-form-label'>Formación Reglada</label>
                                  <input type='text' class='form-control' name='formacionReglada' id='formacionReglada' value='".$profesor->FORMACIONREGLADA."'>
                                </div>
                            </div>
                            <div class='col-lg-6'>
                                <div class='form-group'>
                                  <label for='formacionNoReglada' class='col-form-label'>Formación No Reglada</label>
                                  <input type='text' class='form-control' name='formacionNoReglada' id='formacionNoReglada' value='".$profesor->FORMACIONNOREGLADA."'>
                                </div>
                            </div>
                            <div class='col-lg-3'>
                                <div class='form-group'>
                                  <label for='contrato' class='col-form-label'>Contrato</label>                                  
                                  <select class='form-control' name='contrato' id='contrato'>
                                    <option value='' disabled selected>Seleccionar</option>";
                                    $eval = ['Laboral','Freelance','Acuerdo Colaboración','Otros'];
                                    foreach ($eval as $key) {
                                      echo"
                                        <option value='".$key."' ".(($key == $profesor->CONTRATO)? 'selected': '').">".$key."</option>
                                      ";
                                    }
                                    echo"                                  
                                </select>
                                </div>
                            </div>
                            <div class='col-lg-3'>
                              <label for='evaluacionGlobal' class='col-form-label'>Evaluación Global</label>
                              <select class='form-control' name='evaluacionGlobal' id='evaluacionGlobal'>
                                  <option value='' disabled selected>Seleccionar un tipo</option>";
                                  $eval = ['Medio','Alto','Bajo'];
                                  foreach ($eval as $key) {
                                    echo"
                                      <option value='".$key."' ".(($key == $profesor->EVALUACIONGLOBAL)? 'selected': '').">".$key."</option>
                                    ";
                                  }
                                  echo"                                  
                              </select> 
                            </div>
                            <div class='col-lg-3'>
                              <div class='form-group'>
                                <label for='experienciaLaboral' class='col-form-label'>Experiencia Laboral</label>                               
                                <select class='form-control' name='experienciaLaboral' id='experienciaLaboral'>
                                    <option value='' disabled selected>Seleccionar un tipo</option>";                                    
                                    $expLab = ['menosdedos'=>'De 0 a 2 años','dedosacuartro'=>'De 2 a 4 años',
                                              'decuatroaseis'=>'De 4 a 6 años', 'masdeseis'=>'Más de 6 años'];
                                    
                                    foreach ($expLab as $key => $value) {
                                      echo"
                                        <option value='".$key."' ".(($key == $profesor->EXLABORAL)? 'selected': '').">".$value."</option>
                                      ";
                                    }
                                    echo"                                   
                                </select> 
                              </div>
                            </div>                            
                            <div class='col-lg-3'>
                                <div class='form-group'>
                                  <label for='experienciaFormador' class='col-form-label'>Experiencia Formador</label>                                 
                                  <select class='form-control'name='experienciaFormador' id='experienciaFormador' value=''>
                                    <option value='' disabled selected>Seleccionar un tipo</option>";                                    
                                    $expForm = ['menosdedos'=>'De 0 a 2 años','dedosacuartro'=>'De 2 a 4 años',
                                              'decuatroaseis'=>'De 4 a 6 años', 'masdeseis'=>'Más de 6 años'];
                                    
                                    foreach ($expForm as $key => $value) {
                                      echo"
                                        <option value='".$key."' ".(($key == $profesor->EXFORMADOR)? 'selected': '').">".$value."</option>
                                      ";
                                    }
                                    echo"                                    
                                </select> 
                                </div>
                            </div>
                            <div class='col-lg-3'>
                                <div class='form-group'>
                                  <label for='perfilFormador' class='col-form-label'>Perfil del Formador</label>                                  
                                  <select class='form-control selectorAuto' name='perfilFormador' id='perfilFormador' data-campoadd='perfil' data-campo='perfilFormador'>
                                    <option value='' disabled selected>Seleccionar</option>";
                                    $eval = ['Informática','Idiomas','HabiHabilidades Técnicas','Habilidades Sociales', 'Medioambiente',
                                              'Calidad','P.R.L.','Educación Social','Experiencial','habilidades de gestión'
                                    ];
                                    foreach ($eval as $key) {
                                      echo"
                                        <option value='".$key."' ".(($key == $profesor->perfil)? 'selected': '').">".$key."</option>
                                      ";
                                    }
                                    echo"                                  
                                </select>
                                <div class='row rowTablaProfesores'>
                                <table id='tabla_perfilFormador'>";

                                  if ($profesor->perfil) {                                                                          
                                    $perfiles = json_decode($profesor->perfil);
                                    foreach ($perfiles as $perfil) {
                                      echo"
                                      <tr><td>".$perfil."</td>
                                      <td><i class='fa fa-trash eliminar_perfilFormador' style='color:red; font-size:0.8rem;'></i></td></tr>";
                                    }
                                  }
                                 echo"
                                </table>
                              </div>
                                </div>
                            </div>                                                          
                            <div class='col-lg-3'>
                                <div class='form-group'>                               
                                    <label for='permisoConducir' class='col-form-label'>Permiso de conducir</label>
                                    <select class='form-control selectorAuto' id='permisoConducir' data-campoadd='PERMISODECONDUCIR' data-campo='permisoConducir'>
                                        <option value='' disabled selected>Seleccionar un tipo</option>                                        
                                        <option value='A'>A</option>
                                        <option value='A1'>A1</option>
                                        <option value='A2'>A2</option>
                                        <option value='AM'>AM</option>
                                        <option value='B'>B</option>
                                        <option value='B + E'>B + E</option>
                                        <option value='C'>C</option>
                                        <option value='C + E'>C + E</option>
                                        <option value='C1'>C1</option>
                                        <option value='C1 + E'>C1 + E</option>
                                        <option value='D'>D</option>
                                        <option value='D + E'>D + E</option>
                                        <option value='D1'>D1</option>
                                        <option value='D1 + E'>D1 + E</option>
                                    </select>
                                    <div class='row rowTablaProfesores'>
                                      <table id='tabla_permisoConducir'>";

                                        if ($profesor->PERMISODECONDUCIR) {                                                                          
                                          $tipos = json_decode($profesor->PERMISODECONDUCIR);
                                          foreach ($tipos as $tipo) {
                                            echo"
                                            <tr><td>".$tipo."</td>
                                            <td><i class='fa fa-trash eliminar_permisoConducir' style='color:red; font-size:0.8rem;'></i></td></tr>";
                                          }
                                        }
                                       echo"
                                      </table>
                                    </div>                             
                                </div>                            
                            </div>
                            <div class='col-lg-3'>
                              <div class='form-group'>
                                <label for='vehiculoPropio' class='col-form-label'>Vehículo Propio</label>
                                <select class='form-control' name='vehiculoPropio' id='vehiculoPropio'>
                                  <option value='' disabled selected>Seleccionar</option>";                                  
                                  $arr = [0=> 'No', 1=>'Sí'];
                                  foreach ($arr as $key => $value) {
                                    echo"<option value='".$key."' ".(($profesor->VEHICULOPROPIO==$key)? 'selected': '').">".$value."</option>";
                                  }
                                  echo"                                                          
                                </select>
                              </div>
                            </div>                            
                            <div class='col-lg-3'>
                              <div class='form-group'>
                                <label for='disponibilidad' class='col-form-label'>Disponibilidad</label>
                                <select class='form-control selectorAuto' id='disponibilidad' data-campoadd='DISPONIBILIDAD' data-campo='disponibilidad'>
                                  <option value='' disabled selected>Seleccionar</option>
                                  <option value='Mañana'>Mañana</option>
                                  <option value='Tarde'>Tarde</option>
                                  <option value='Todo el día'>Todo el día</option>
                                  <option value='Todo el día (preaviso)'>Todo el día (preaviso)</option>
                                  <option value='Jornada completa'>Jornada completa</option>
                                  <option value='Media jornada'>Media jornada</option>
                                  <option value='Incorporación inmediata'>Incorporación inmediata</option>
                                  <option value='Solo fines de semana'>Solo fines de semana</option>
                                </select>
                                <div class='row rowTablaProfesores'>
                                  <table id='tabla_disponibilidad'>";
                                    if ($profesor->DISPONIBILIDAD) {                                                                          
                                      $disponibilidad = json_decode($profesor->DISPONIBILIDAD);
                                      foreach ($disponibilidad as $tipo) {
                                        echo"
                                        <tr><td>".$tipo."</td>
                                        <td><i class='fa fa-trash eliminar_disponibilidad' style='color:red; font-size:0.8rem;'></i></td></tr>";
                                      }
                                    }
                                    echo"
                                  </table>                                
                                </div>
                              </div>
                            </div>  
                            <div class='col-lg-2'>
                                <div class='form-group'>
                                  <label for='precioHora' class='col-form-label'>Precio(€)/Hora</label>
                                  <input type='number' step='0.01' class='form-control' name='precioHora' id='precioHora' value='".$profesor->PRECIOHORA."'>
                                </div>
                            </div>  
                            <div class='col-lg-4'>
                              <div class='form-group'>
                                <label for='idiomas' class='col-form-label'>Idiomas</label>
                                <select class='form-control selectorAuto' name='idiomas' id='idiomas' data-campoadd='IDIOMAS' data-campo='idiomas'>
                                  <option value='' disabled selected>Seleccionar</option>
                                  <option value='Español'>Español</option>
                                  <option value='Inglés'>Inglés</option>
                                  <option value='Francés'>Francés</option>
                                  <option value='Alemán'>Alemán</option>
                                  <option value='Italiano'>Italiano</option>
                                  <option value='Ruso'>Ruso</option>                                  
                                </select>
                                <div class='row rowTablaProfesores'>                                
                                  <table id='tabla_idiomas'>";
                                    if ($profesor->IDIOMAS) {                                                                          
                                      $idiomas = json_decode($profesor->IDIOMAS);
                                      foreach ($idiomas as $idioma) {
                                        echo"
                                        <tr><td>".$idioma."</td>
                                        <td><i class='fa fa-trash eliminar_idiomas' style='color:red; font-size:0.8rem;'></i></td></tr>";
                                      }
                                    }
                                    echo"
                                  </table>                                
                                </div>
                              </div>
                            </div>  
                            <div class='col-lg-6'>
                              <div class='form-group'>
                                <label for='informatica' class='col-form-label'>Informática</label>
                                <select class='form-control selectorAuto' name='informatica' id='informatica' data-campoadd='INFORMATICA' data-campo='informatica'>
                                  <option value='' disabled selected>Seleccionar</option>
                                  <option value='Sistemas'>Sistemas</option>
                                  <option value='Ofimática'>Ofimática</option>
                                  <option value='Programación'>Programación</option>                                  
                                </select>
                                <div class='row rowTablaProfesores'>
                                  <table id='tabla_informatica'>";
                                    if ($profesor->INFORMATICA) {                                  
                                      $informatica = json_decode($profesor->INFORMATICA);
                                      foreach ($informatica as $option) {
                                        echo"
                                        <tr><td>".$option."</td>
                                        <td><i class='fa fa-trash eliminar_informatica' style='color:red; font-size:0.8rem;'></i></td></tr>";
                                      }
                                    }
                                    echo"
                                  </table>                               
                                </div>
                              </div>
                            </div>                         
                        </div>
                        <div class='row'>
                          <div class='col-lg-12'>
                            <div class='form-group'>
                              <label for='documentacion' class='col-form-label'>Documentación</label>

                              <div class='col-lg-12 my-1' id='formularioSubirFichero'>
                                  <input type='text' class='form-control' name='descripcionFichero' id='descripcionFichero' style='width:45%;' placeholder='Descripción fichero'>
                                  <input type='file' class='form-control-file my-1' style='width: 50%;' name='ficheroCurriculum' id='ficheroCurriculum' placeholder='Adjunte fichero'>
                              </div>
                              <div>";
                             
                                  if ($profesor->CURRICULUM) {
                                    $infoCV = json_decode($profesor->CURRICULUM);
                                    $tmp = [];
                                    $arr = [];          
                                    foreach ($infoCV as $key => $value) {                                      
                                        $tmp[$key] = $value;
                                        $arr[] = $tmp;
                                    }
                                                                    

                                      echo"
                                      <table class='table mt-3' id='tablaFicherosProfesor'>
                                          <thead>
                                              <tr>                                                                               
                                                  <th scope='col'>Fichero</th>
                                              </tr>
                                          </thead>
                                          <tbody>";                                              
                                                  echo"
                                                  <tr>                                                    
                                                      <td><div><a href='".RUTA_URL."/datatable/descargarFichero/".$profesor->idPROFESOR."' target='_BLANK'>".$arr[0]['nombre']."</a></div></td>                                                      
                                                  </tr>";                                                                                        
                                          echo"
                                          </tbody>
                                      </table>";
                                  }
                                echo"                          
                              </div>
                            </div>                         
                          </div>
                        </div>
                        <div class='row'>
                            <div class='col-lg-12'>
                                <div class='form-group'>
                                  <label for=' class='col-form-label'>Observaciones</label>
                                  <textarea type='text' class='form-control' name='observaciones' id='observaciones'>".$profesor->OBSPROFESOR."</textarea>
                                </div>
                            </div>
                        </div>
                    </div>        
                    
                    <div class='modal-footer'>
                        <a href = '".RUTA_URL."/datatable/profesores' class='btn btn-light'><span aria-hidden='true'>Cancelar</span></a>                        
                        <button type='submit' id='btnGuardar' name='agregar' class='btn btn-success'>Guardar</button>
                        
                    </div>";
                ?>
                </form>
            </div>
        </div>
    </div>



</div>
<!-- end contenido de la pagina -->



<?php require(RUTA_APP . '/views/includes/footer2.php'); ?>