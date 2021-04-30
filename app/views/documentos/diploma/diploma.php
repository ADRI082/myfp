<!DOCTYPE HTML">
<html lang="es">
    <head>

        <meta charset="utf-8">
        <link rel="stylesheet" href="estilos.css" />
        <style>
            .conceptos {
                border-collapse: collapse;

            }
            .conceptos, .nombre, .apellidos, .edad {
                border: 1px solid black;    
            }
            th {
                background-color: burlywood;
            }
            th, td {
                padding: 5px;
                text-align: left;
            }
            td {
                height: 5px;
                vertical-align: bottom;
            }
            .nombre {
                width: 150px;  
            }
            .apellidos {
                width: 150px;  
            }
            .edad {
                width: 50px;  
            }
            .conceptos {
                margin-left: 50px;
                margin-top:30px;
            }
            .factura {
                width: 500px;
                font-size: 40px;
                font-weight: bold;
                
            }


        </style>



    </head>
    <body>
        <p>ENTIDAD ORGANIZADORA: INFORMA CONSULTORÍA Y FORMACIÓN, S.L. CIF: B-92744465</p>
        <p>CÓDIGO DE AGRUPACIÓN: 00000 <?php
           
        ?></p>
        <table>
            <tr>
                <td>CONTROL DE ASISTENCIA</td>
                <td><p>Fecha:  <?php echo date('d-m-Y'); ?></p></td>
            </tr>
        </table>
        
            <table>

        </table>
     
        <br><br><br>
        <table class="conceptos">
            <thead>
                <tr>
                    <th class="nombre">Nombre</th>
                    <th class="apellidos">Apellidos</th>
                    <th class="edad">NIE</th>
                </tr>
            </thead>
            <tbody>
                <?php
              
                
                foreach($datos as $participante){
                    echo "<tr>";
                    echo "<td class='nombre'>" . $participante->Nombre . "</td>";
                    echo "<td class='apellidos'>" . $participante->Apellido1. "</td>";
                    echo "<td class='edad'>" . $participante->DocIdentidad. "</td>";
                    echo "</tr>";
                }
                
                ?>
               
            </tbody>


        </table>

    </body>
</html>