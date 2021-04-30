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
                <th scope='col'>Nº Acción</th>
                <th scope='col'>Nombre Acción</th>
                <th scope='col'>Cliente</th>

                <th scope='col'>Ingresos</th>
                <th scope='col'>Gastos</th>
                <th scope='col'>%Gasto</th>
                <th scope='col'>%Beneficio</th>
                <th scope='col'>Beneficio</th>
                <th scope='col'>F. Inicio</th>
                <th scope='col'>F. Fin</th>
                <th scope='col'>F. Ini. Fundae</th>
                <th scope='col'>F. Fin Fundae</th>
                <th scope='col'>Presupuesto</th>

                <th scope='col'>Grupo Empresa</th>
                <th scope='col'>Colaborador</th>
                <th scope='col'>Agente</th>
                <th scope='col'>Profesor</th>                
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
                    <td>".$linea->idACCION."</td>
                    <td>".$linea->NOMBREACCION."</td>
                    <td>".$linea->NOMBREJURIDICO."</td>

                    <td scope='col'>".formatoPrecio($linea->totalingresos)."</td>
                    <td scope='col'>".formatoPrecio($linea->totalgastos)."</td>
                    <td scope='col'>".((isset($linea->totalingresos))? formatoPrecio($linea->totalgastos/$linea->totalingresos * 100) : '' )."</td>
                    <td scope='col'>".((isset($linea->totalingresos))? formatoPrecio(($linea->totalingresos - $linea->totalgastos)/$linea->totalingresos * 100) : '')."</td>
                    <td scope='col'>".formatoPrecio($linea->totalingresos - $linea->totalgastos)."</td>
                    <td scope='col'>".((isset($linea->fechaInicio) && $linea->fechaInicio!=0)? date('d/m/Y',strtotime($linea->fechaInicio)):'' )."</td>
                    <td scope='col'>".((isset($linea->fechaFin) && $linea->fechaFin!=0)? date('d/m/Y',strtotime($linea->fechaFin)):'' )."</td>
                    <td scope='col'>".((isset($linea->fechaIniFun) && $linea->fechaIniFun!=0)? date('d/m/Y',strtotime($linea->fechaIniFun)):'' )."</td>
                    <td scope='col'>".((isset($linea->fechaFinFun) && $linea->fechaFinFun!=0)? date('d/m/Y',strtotime($linea->fechaFinFun)):'' )."</td>
                    <td scope='col'>".$linea->importeactual."</td>
                    <td>".$linea->nombreGrupo."</td>
                    <td>".$linea->nombreColaborador."</td>
                    <td>".$linea->nombreAgente."</td>
                    <td>".$linea->nombreProfesor."</td>                                        
                    <td>".$linea->nombreServicio."</td>
                    <td>".$linea->tipologia."</td>                    
                </tr>";
            }
        ?>
        </tbody>
    </table>
 </div>

</div>

