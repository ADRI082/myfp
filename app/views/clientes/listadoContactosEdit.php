<?php
    $registros = $datos['registros'];  
?>
                                        <div class="col-lg-2 mb-2">
                                            <button id="agregarContactoEdit" class="btn btn-success">Agregar Contacto</button>
                                        </div>                                
                                        <div class="col-lg-12">
                                            <table class="table table-sm" id="tablaContactosClienteEdit">
                                                <thead >
                                                <div>
                                                    <th>#</th>
                                                    <th>Nombre</th>
                                                    <th>Área</th>
                                                    <th>Tel. Fijo</th>
                                                    <th>Móvil</th>
                                                    <th>Email</th>                                                
                                                    <th>&nbsp;</th>                                   
                                                </div>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach ($registros as $registro) {
                                                    echo"
                                                    <tr>
                                                        <td>".$registro->idContacto."</td>
                                                        <td><input class='form-control' name='nombreContactoEdit[]' value='".$registro->nombreC."' /></td>
                                                        <td><input class='form-control' name='areaContactoEdit[]' value='".$registro->areaDpto."' /></td>
                                                        <td><input class='form-control' type='text' regexp='[0-9]{0,9}' name='telFijoContactoEdit[]' value='".$registro->telefonoFijo."' /></td>
                                                        <td><input class='form-control' type='text' regexp='[0-9]{0,9}' name='movilContactoEdit[]' value='".$registro->movil."' /></td>
                                                        <td><input class='form-control' name='emailContactoEdit[]' value='".$registro->mail."' /></td>                                                
                                                        <td class='d-flex'>                                                       
                                                            <a class='btn btn-danger eliminarContactoEdit' title='Quitar' style='color:white;'>
                                                                <i class='fas fa-trash'></i>
                                                            </a>
                                                        </td>
                                                    </tr>";
                                                }
                                                
                                                
                                                ?>
                                                </tbody>                    
                                            </table>
                                        </div>                        
