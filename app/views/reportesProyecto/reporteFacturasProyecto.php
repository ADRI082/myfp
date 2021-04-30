<div class="container-fluid">
<?php

?>
<div class="table-responsive">
    <table id = "table_facturas" class="table" style="visibility:hidden; width:100% !important">
        <thead class="table-header table-active">
            <tr >
                <?php
                echo"
                <th scope='col'>Nº Proyecto</th>
                <th scope='col'>Nº Fact.</th>
                <th scope='col'>Nº Acción</th>
                <th scope='col'>Nombre Acción</th>
                <th scope='col'>Cliente</th>
                <th scope='col'>Grupo Empresa</th>
                <th scope='col'>Colaborador</th>
                <th scope='col'>Agente</th>
                <th scope='col'>Profesor</th>
                <th scope='col'>Precio</th>
                <th scope='col'>IVA(%)</th>
                <th scope='col'>Total IVA</th>
                <th scope='col'>Total Factura</th>
                <th scope='col'>F. Fact</th>
                <th scope='col'>F. Cobro</th>
                <th scope='col'>Servicio</th>
                <th scope='col'>Tipología</th>";
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
                $valorIva =$linea->iva * $linea->importe /100;
                echo"
                <tr>
                    <td>".$linea->idProyecto."</td>
                    <td>".$linea->numfactura."</td>
                    <td>".$linea->idACCION."</td>
                    <td>".$linea->NOMBREACCION."</td>
                    <td>".$linea->NOMBREJURIDICO."</td>
                    <td>".$linea->nombreGrupo."</td>
                    <td>".$linea->nombreColaborador."</td>
                    <td>".$linea->nombreAgente."</td>
                    <td>".$linea->nombreProfesor."</td>                    
                    <td>".formatoPrecio($linea->importe)."</td>
                    <td>".formatoPrecio($linea->iva)."</td>
                    <td>".formatoPrecio($valorIva)."</td>
                    <td>".formatoPrecio($linea->total)."</td>
                    <td>".(($linea->fechafactura)? date('d/m/Y',strtotime($linea->fechafactura)): '')."</td>
                    <td>".(($linea->fechacobro && $linea->fechacobro!=0)? date('d/m/Y',strtotime($linea->fechacobro)): '')."</td>
                    <td>".$linea->nombreServicio."</td>
                    <td>".$linea->tipologia."</td>                    
                </tr>";
            }
        ?>
        </tbody>
    </table>
 </div>

</div>

