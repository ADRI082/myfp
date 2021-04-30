<div class="container-fluid">

<div class="table-responsive">
    <table id = "table_id" class="table" style="visibility:hidden; width:100% !important">
        <thead class="table-header table-active">
            <tr >
                <th scope="col">Num</th>
                <th scope="col">G.Empresa</th>
                <th scope="col">Empresa</th>
                <th scope="col">T.Presupuesto</th>
                <th scope="col">Fecha</th>
                <th scope="col">Concepto</th>
                <th scope="col">Importe</th>
                <th scope="col">Iva</th>
                <th scope="col">Servicio</th>
                <th scope="col">Accion</th>
                <th scope="col">Estado</th>
            </tr>
        </thead>
       
        <tbody >
        <?php foreach ($datos['salida'] as $evento) { ?>
        <!-- <tbody> -->           
            <td  class='clickable-row'  data-href="<?php echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo $evento->idPresupuesto;  ?></td>
            <td  class='clickable-row'  data-href="<?php echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo $evento->nombreG;  ?></td>
            <td  class='clickable-row'  data-href="<?php echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo $evento->NOMBREJURIDICO;  ?></td>
            <td  class='clickable-row'  data-href="<?php echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo $evento->tipoPlantilla;  ?></td>
            <td  class='clickable-row'  data-href="<?php echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo date("d/m/Y", strtotime($evento->fecha)) ?></td>
            <td  class='clickable-row'  data-href="<?php echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo $evento->concepto;  ?></td>
            <td  class='clickable-row'  data-href="<?php echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo $evento->importe;  ?></td>
            <td  class='clickable-row'  data-href="<?php echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo $evento->iva;  ?></td>
            <td  class='clickable-row'  data-href="<?php echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo $evento->nombreS;  ?></td>
            <td  class='clickable-row'  data-href="<?php echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo $evento->NOMBREACCION;  ?></td>
            <td  class='clickable-row'  data-href="<?php echo RUTA_URL; ?>/PdfPresupuesto/buscadorpresupuesto?id=<?php echo $evento->idPresupuesto;  ?>"><?php echo $evento->estado;  ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
 </div>

</div>

