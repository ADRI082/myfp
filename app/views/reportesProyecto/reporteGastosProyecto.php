<div class="container-fluid">
<?php

?>
<div class="table-responsive">
    <table id = "table_facturas" class="table" style="visibility:hidden; width:100% !important">
        <thead class="table-header table-active">
            <tr >
                <?php
                echo"
                <th scope='col'>Nº Fact. Cliente</th>
                <th scope='col'>Cliente</th>
                <th scope='col'>Grupo Empresa</th>
                <th scope='col'>Nº Proyecto</th>                
                <th scope='col'>Nº Acción</th>
                <th scope='col'>Nombre Acción</th>
                <th scope='col'>Tipo Prov.</th>
                <th scope='col'>Proveedor</th>
                <th scope='col'>Nº Fact. Prov.</th>
                <th scope='col'>F. Fact Prov.</th>
                <th scope='col'>Descripción</th>
                <th scope='col'>Precio Total</th>
                <th scope='col'>IRPF(%)</th>
                <th scope='col'>Total IRPF</th>
                <th scope='col'>IVA(%)</th>
                <th scope='col'>Total IVA</th>
                <th scope='col'>Gasto Total</th>
                <th scope='col'>F. Pago</th>
                <th scope='col'>Servicio</th>
                <th scope='col'>Tipología</th>
                <th scope='col'>Profesor</th>
                <th scope='col'>Colaborador</th>
                <th scope='col'>Agente</th>";
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
                //$valorIva = round(($linea->iva * $linea->total /100),2);
                echo"
                <tr>
                    <td scope='col'>".$linea->numFactura."</td>
                    <td scope='col'>".$linea->nombreCliente."</1td>
                    <td scope='col'>".$linea->nombreGrupo."</td>
                    <td scope='col'>".$linea->idProyecto."</td>                    
                    <td scope='col'>".$linea->idACCION."</td>
                    <td scope='col'>".$linea->NOMBREACCION."</td>
                    <td scope='col'>".$linea->tipoProveedor."</td>
                    <td scope='col'>".$linea->nombreProveedor."</td>
                    <td scope='col'>".$linea->numfacgasto."</td>
                    <td scope='col'>".date('d/m/Y',strtotime($linea->fecha))."</td>
                    <td scope='col'>".$linea->descripcion."</td>
                    <td scope='col'>".$linea->importe."</td>
                    <td scope='col'>".formatoPrecio($linea->irpf)."</td>";
                    $valorIrpf = $linea->importe * $linea->irpf /100;
                    echo"
                    <td scope='col'>".formatoPrecio($valorIrpf)."</td>
                    <td scope='col'>".formatoPrecio($linea->iva)."</td>";
                    $valorIva = $linea->importe * $linea->iva /100;
                    echo"
                    <td scope='col'>".formatoPrecio($valorIva)."</td>
                    <td scope='col'>".formatoPrecio($linea->total)."</td>
                    <td scope='col'>".((isset($linea->fechapago) && $linea->fechapago !=0)? date('d/m/Y',strtotime($linea->fechapago)): '')."</td>
                    <td scope='col'>".$linea->nombreServicio."</td>
                    <td scope='col'>".$linea->tipologia."</td>
                    <td scope='col'>".$linea->nombreProfesor."</td>
                    <td scope='col'>".$linea->nombreColaborador."</td>
                    <td scope='col'>".$linea->nombreAgente."</td>
                </tr>";
            }
        ?>
        </tbody>
    </table>
 </div>

</div>

