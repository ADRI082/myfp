<div class="container-fluid">
<?php

?>
<div class="table-responsive">
    <table id = "table_facturas" class="table" style="visibility:hidden; width:100% !important">
        <thead class="table-header table-active">
            <tr >
                <?php
                echo"
                <th scope='col'>Fecha Fact</th>
                <th scope='col'>CIF</th>
                <th scope='col'>Denominación</th>
                <th scope='col'>Código Postal</th>
                <th scope='col'>Provincia</th>
                <th scope='col'>Base Imponible</th>
                <th scope='col'>Tipo Iva</th>
                <th scope='col'>Cuota Iva</th>
                <th scope='col'>Tipo IRPF</th>
                <th scope='col'>Cuota IRPF </th>
                <th scope='col'>Importe total</th>
                <th scope='col'>Num. Factura</th>
                <th scope='col'>Canal</th>";
                ?>
            </tr>
        </thead>
       
        <tbody >
        <?php 
        function formatoPrecio($num,$dec=2){
            $ret = number_format($num,$dec,',','.');
            return $ret;
        }
            foreach ($datos['salida'] as $linea) {                
                $valorIva = $linea->iva * $linea->importe /100;
                $valorIrpf = $linea->irpf * $linea->importe /100;
               
                echo"
                <tr>
                    <td>".(($linea->fecha)? date('d/m/Y',strtotime($linea->fecha)): '')."</td>
                    <td>".$linea->cif."</td>
                    <td>".$linea->nombreProveedor."</td>
                    <td>".$linea->codPostal."</td>
                    <td>".$linea->provincia."</td>
                    <td>".formatoPrecio($linea->importe)."</td>
                    <td>".formatoPrecio($linea->iva)."</td>
                    <td>".formatoPrecio($valorIva)."</td>
                    <td>".formatoPrecio($linea->irpf)."</td>
                    <td>".formatoPrecio($valorIrpf)."</td>
                    <td>".formatoPrecio($linea->total)."</td>
                    <td>".$linea->numfacgasto."</td>
                    <td>".$linea->nombreServicio."</td>
                </tr>";
            }
        ?>
        </tbody>
    </table>
 </div>

</div>

