<div class="container-fluid">
<?php

$tipos = ['proyectados','ejecucion','finalizados'];
$cond = $datos['tipoInforme'];

?>
<div class="table-responsive">
    <table id = "table_id" class="table" style="visibility:hidden; width:100% !important">
        <thead class="table-header table-active">
            <tr >
                <?php
                echo"
                <th scope='col'>Nº Acción</th>
                <th scope='col'>Nombre Curso</th>
                <th scope='col'>Razón Social</th>
                <th scope='col'>Grupo</th>
                <th scope='col'>Colaborador</th>
                <th scope='col'>Agente</th>
                <th scope='col'>Tipo Curso</th>
                <th scope='col'>Modalidad</th>
                <th scope='col'>Servicio</th>
                <th scope='col'>Nº Participantes</th>
                <th scope='col'>Fecha presupuesto</th>
                <th scope='col'>Presupuesto</th>
                <th scope='col'>Observaciones</th>";
                if ($cond == 'desestimados') {
                    echo "
                <th scope='col'>Fecha Fin</th>";
                }
                if (in_array($cond, $tipos)) {
                    echo "
                <th scope='col'>Fecha Inicio</th>
                <th scope='col'>Fecha Finaliz.</th>
                <th scope='col'>F. Ini. Fundae</th>
                <th scope='col'>F. Fin. Fundae</th>";
                }
                ?>
            </tr>
        </thead>
       
        <tbody >
        <?php foreach ($datos['salida'] as $evento) { ?>
        <!-- <tbody> -->           
            <td  class='clickable-row'  data-href="<?php //echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo $evento->idACCION;  ?></td>
            <td  class='clickable-row'  data-href="<?php //echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo $evento->NOMBREACCION;  ?></td>
            <td  class='clickable-row'  data-href="<?php //echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo $evento->NOMBREJURIDICO;  ?></td>
            <td  class='clickable-row'  data-href="<?php //echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo $evento->nombreG;  ?></td>
            <td  class='clickable-row'  data-href="<?php //echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo $evento->nombreColaborador;  ?></td>
            <td  class='clickable-row'  data-href="<?php //echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo $evento->nombreAgente;  ?></td>
            <td  class='clickable-row'  data-href="<?php //echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo $evento->tipologia; ?></td>
            <td  class='clickable-row'  data-href="<?php //echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo $evento->modalidad;  ?></td>
            <td  class='clickable-row'  data-href="<?php //echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo $evento->nombreServicio;  ?></td>
            <td  class='clickable-row'  data-href="<?php //echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo $evento->participantes;  ?></td>
            <td  class='clickable-row'  data-href="<?php //echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo date("d/m/Y", strtotime($evento->fecha)); ?></td>
            <td  class='clickable-row'  data-href="<?php //echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo $evento->importe;  ?></td>
            <td  class='clickable-row'  data-href="<?php //echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo $evento->observaciones;  ?></td>
            <?php if ($cond == 'desestimados') { ;?>            
            <td  class='clickable-row'  data-href="<?php //echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo date("d/m/Y", strtotime($evento->fechaRechazo)); ?></td>
            <?php } ;?>            
            <?php if (in_array($cond, $tipos)) { ;?>
            <td  class='clickable-row'  data-href="<?php //echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo date("d/m/Y", strtotime($evento->fechaInicio)); ?></td>
            <td  class='clickable-row'  data-href="<?php //echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo date("d/m/Y", strtotime($evento->fechaFin)); ?></td>
            <td  class='clickable-row'  data-href="<?php //echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo (($evento->fechaIniFun == null)? '':date("d/m/Y", strtotime($evento->fechaIniFun)) ); ?></td>
            <td  class='clickable-row'  data-href="<?php //echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo (($evento->fechaFinFun==null)? '':date("d/m/Y", strtotime($evento->fechaFinFun)) ); ?></td>
            <?php } ;?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
 </div>

</div>

