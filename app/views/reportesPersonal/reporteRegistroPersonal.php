<div class="container-fluid">
<?php

?>
<div class="table-responsive">
    <table id = "table_registroPersonal" class="table" style="visibility:hidden; width:100% !important">
        <thead class="table-header table-active">
            <tr >
                <?php
                echo"
                <th scope='col'>Agente</th>
                <th scope='col'>Fecha</th>
                <th scope='col'>Registro</th>";
                ?>
            </tr>
        </thead>
       
        <tbody >
        <?php        
            foreach ($datos['salida'] as $linea) {               
                echo"
                <tr>
                    <td>".$linea->nombreAgente."</td> 
                    <td>".(($linea->fecharegistro)? date('d/m/Y H:i:s',strtotime($linea->fecharegistro)): '')."</td>
                    <td>".$linea->tipo."</td>                  
                </tr>";
            }
        ?>
        </tbody>
    </table>
 </div>

</div>

