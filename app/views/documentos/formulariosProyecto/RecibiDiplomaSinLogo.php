<!DOCTYPE HTML">
<html lang="es">
    <head>

        <meta charset="utf-8">
        <link rel="stylesheet" href="estilos.css" />
        <style>           
            .conceptos {
                border-collapse: collapse;

            }
            .conceptos, .nombre, .apellidos, .edad, .observaciones {
                border: 1px solid black;    
            }
            th {
                background-color: #dee2e6;
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
            .observaciones {
                width: 120px;
                font-size: 10px;
            }
            /*.conceptos {
                margin-left: 50px;
                margin-top:30px;
            }*/
            .factura {
                width: 650px;
                /*font-size: 40px;*/
                /*font-weight: bold;*/
            }
            
            .pie{
                font-size: 8px;
            }

        </style>



    </head>
    <body>
        <div class="factura">
            <span><img src="<?php echo RUTA_URL; ?>/img/logoInforma.jpg" width="200" style="float: left;"></span>        
        </div>
        <div style="text-align: center;"><h3>RELACIÓN RECIBÍ DE DIPLOMAS</h3></div>

        <div class="factura">
            <p style="color: #0618ef;">ENTIDAD ORGANIZADORA: INFORMA CONSULTORÍA Y FORMACIÓN, S.L. CIF: B-92744465</p>
            <p style="color: #0618ef;">CÓDIGO DE AGRUPACIÓN N° <?php echo $datos['cabecera']->idProyecto; ?></p>
            <p style="color: #0618ef;">DENOMINACIÓN DE LA ACCIÓN FORMATIVA: <?php echo $datos['cabecera']->NOMBREACCION; ?></p>

            <p style="color: #0618ef;">
                <span>Nº: <?php echo $datos['cabecera']->accionformativa; ?> </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span>GRUPO: <?php echo $datos['cabecera']->idProyecto; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span>FECHA INICIO: <?php echo date('d/m/Y',strtotime($datos['cabecera']->fechaInicio)); ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span>FECHA FIN: <?php echo date('d/m/Y',strtotime($datos['cabecera']->fechaFin)); ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </p>
            <p style="color: #0618ef;">FORMADOR/RES. DE FORMACIÓN: <?php echo $datos['cabecera']->profesor; ?></p>
        </div>

        <p style="color: #0618ef;">Firmado:
        (Formado/Res. Formación)</p>
        <br>
        <table class="conceptos">
            <thead>
                <tr>
                    <th class="nombre">Nombre</th>
                    <th class="apellidos">Apellidos</th>
                    <th class="edad">NIF</th>
                    <th class="edad">Firma</th>
                    <th class="observaciones">Recibí el diploma correspondiente a la acción formativa arriba descrita</th>
                </tr>
            </thead>
            <tbody>
                <?php
              
                
                foreach($datos['detalles'] as $participante){
                    echo "<tr>";
                    echo "<td class='nombre'>" . $participante->Nombre . "</td>";
                    echo "<td class='apellidos'>".$participante->Apellido1." ".$participante->Apellido2."</td>";
                    echo "<td class='edad'>" . $participante->DocIdentidad. "</td>";
                    echo "<td class='edad'></td>";
                    echo "<td class='observaciones'></td>";
                    echo "</tr>";
                }
                for ($i=0; $i < 8; $i++) { 
                    echo"
                    <tr><td class='nombre'></td>
                    <td class='apellidos'></td>
                    <td class='edad'></td>
                    <td class='edad'></td>
                    <td class='observaciones'></td>
                </tr>";
                }
                ?>               
            </tbody>
        </table>
        <div class="factura">
            <p>Observaciones:</p>
            <br><br><br>
        </div>
        <div class="factura">
            <p class="pie">Responsable: Identidad: D. JESUS MOLINA GÓMEZ con NIF 25690631E como representante legal de la empresa INFORMA CONSULTORÍA Y FORMACIÓN, S.L. – CIF: B92744465. Dir. Postal: ESTEBAN SALAZAR CHAPELA, 29 2º IZDA 29004 MALAGA. Teléfono: 952309774. Correo electrónico: info@myfp.com. “En nombre de la empresa tratamos la información que nos facilita con el fin de prestarles el servicio solicitado, realizar la facturación del mismo. Los datos proporcionados se conservarán mientras se mantenga la relación comercial o durante los años necesarios para cumplir con las obligaciones legales. Los datos no se cederán a terceros salvo en los casos en que exista una obligación legal. Usted tiene derecho a obtener confirmación sobre si en INFORMA CONSULTORÍA Y FORMACIÓN, S.L. estamos tratando sus datos personales por tanto tiene derecho a acceder a sus datos personales, rectificar los datos inexactos o solicitar su supresión cuando los datos ya no sean necesarios. Autorizo la utilización de mi imagen en los medios de comunicación de INFORMA CONSULTORÍA Y FORMACIÓN, S.L.</p>
        </div>
    </body>
</html>