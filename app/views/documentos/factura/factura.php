<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Factura</title>
    <style type="text/css">
        #datosEmpresas,
        #numFactura,
        #contenido {
            border-collapse: collapse;
            width: 100%;
        }

        .pie {
            background-color: #053669;
            margin-top: 20px;
            height: 50px;
        }

        #datosEmpresas td,
        #numFactura td,
        #contenido td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #numFactura th,
        #datosEmpresas th,
        #contenido th {
            border: 1px solid #ddd;
            padding: 8px;
            background-color: #c1daef;
        }

        .titulo {
            font-size: 18px;
            font-weight: 1000;
        }

        .contenedor {
            margin-bottom: 20px;
        }

        .izquierda {
            text-align: right;
        }

        td.informa {
            width: 250px;
            text-align: left;
        }

        td.cliente {
            width: 290px;
            text-align: left;
        }

        td.subtitulo,
        th.subtitulo {
            width: 150px;
            font-size: 14px;
        }

        th.vacio {
            width: 75px;
        }

        .imagen {
            width: 320px;
        }

        th.conceptoCol,
        td.conceptoCol {
            width: 600px;
        }

        th.importeCol,
        td.importeCol {
            width: 70px;
        }

        .rgpd {
            font-size: 10px;
            margin-left: 40px;
            margin-right: 40px;
            color: #606060;
            margin-top: 5px;
            margin-bottom: 5px;
            text-align: justify;
        }

        .subrayado {
            border-bottom: solid 3px blue;
        }

        .principal {
            margin-left: 24px;
        }

        .contLogo {
            margin-left: 20px;
        }

        .divisor {
            width: 735px;
            margin-left: 26px;
            border: 2px solid #053669;
        }
    </style>
</head>

<body>

    <style type="text/css">
    </style>
    <page style="font-family: Courier;" backimg="<?php echo RUTA_URL; ?>/img/<?php echo $datos->tipofolio ?>.png" footer='page'>

        <p></p>
        <page_footer>
            <div class="rgpd"><?php echo $datos->descripcionRPGD ?></div>
            <div>&nbsp;</div>
        </page_footer>

        <table class="contLogo">
            <tr>
                <td rowspan='11' class='imagen'></td>
                <?php
                $tipoFactura = '';
                if ($datos->total < 0) {
                    $tipoFactura = 'RECTIFICATIVA';
                }
                echo "<td class='titulo'><b>FACTURA " . $tipoFactura . "</b></td>";
                ?>

                <td class='titulo'></td>
            </tr>
            <?php
            echo "
                <tr>
                    <td class='subtitulo'><b>Nº Factura</b></td>
                    <td class='subtitulo'>" . $datos->numfactura . "</td>       
                </tr>
                <tr>
                    <td class='subtitulo'><b>Fecha Factura</b></td>
                    <td class='subtitulo'>" . date('d-m-Y', strtotime($datos->fechafactura)) . "</td>
                </tr>";
            ?>
        </table>

        <div class="divisor"></div>
        <div class="principal">
            <?php
            echo "

                    
                        <div class='contenedor'>             
                        
                            <div style='margin-left:430px;'><b>FACTURADO A:</b></div>
                        
                            <table id='datosEmpresas'>
                                
                                <tbody>
                                    <tr>
                                        <th scope='row'>EMPRESA</th>
                                        <td class='informa'>Informa Consultoría y Formación S.L.</td>
                                        <td class='cliente'>" . $datos->NOMBREJURIDICO . "</td>
                                    </tr>
                                    <tr>
                                        <th scope='row'>CIF</th>
                                        <td>B-92744465</td>
                                        <td>" . $datos->CIFCLIENTE . "</td>
                                    </tr>
                                    <tr>
                                        <th scope='row'>DIRECCION</th>
                                        <td>C/ Esteban Salazar Chapela</td>
                                        <td>" . $datos->DIRECCION . "</td>
                                    </tr>
                                    <tr>
                                        <th scope='row'>CP Y LOCALIDAD</th>
                                        <td>29004 Málaga</td>
                                        <td>" . $datos->CODPOSTAL . " - " . $datos->LOCALIDAD . "</td>
                                    </tr>
                                    <tr>
                                        <th scope='row'>PROVINCIA</th>
                                        <td>Málaga</td>
                                        <td>" . $datos->PROVINCIA . "</td>
                                    </tr>                                            
                                </tbody>
                            </table>
                        </div>                       
                       
                        <div class='contenedor'>
                            <table id='contenido'>
                                <thead>
                                    <tr>
                                    <th scope='col' class='subtitulo conceptoCol'>CONCEPTO</th>
                                    <th scope='col' class='subtitulo importeCol'>IMPORTE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>";
            if ($datos->concepto == '' || $datos->concepto == null) {
                echo "
                                        <td class='conceptoCol'>
                                            <p>SERVICIOS DE FORMACION: según los siguientes datos:</p>
                                            <p>DURACION:  " . $datos->horas . " horas</p>
                                            <p>ACCION NUMERO:  " . $datos->idACCION . "</p>
                                            <p>DENOMINACIÓN CURSO:  " . $datos->NOMBREACCION . "</p>
                                            <p>FECHA DE INICIO:  " . $datos->fechaInicio . "</p>
                                            <p>FECHA DE FINAL:  " . $datos->fechaFin . "</p>

                                            <p>NÚMERO DE ALUMNOS: " . $datos->participantes . " </p>         
                                        </td>
                                        <td></td>";
            } else {
                echo "
                                        <td class='conceptoCol'>" . $datos->concepto . "</td>
                                        <td></td>";
            }
            echo "
                                    </tr>
                                    <tr>
                                        <td class='conceptoCol subtitulo'><b>BASE IMPONIBLE</b></td>
                                        <td class='izquierda'>" . number_format($datos->importe, '2', ',', '.') . "</td>
                                    </tr>";

            $exento = '';
            if (!$datos->iva || $datos->iva == 0 || $datos->iva == '') {
                $exento = '(sujeto, pero exento Según Art.20.Uno. Nueve de la
                                        Ley 37/1992 de 28 de diciembre el IVA)';
            }
            echo "
                                    <tr>
                                        <td class='conceptoCol'>Concepto de IVA " . $exento . "</td>
                                        <td class='izquierda'>" . number_format($datos->iva, '2', ',', '.') . "</td>
                                    </tr>                        
                                    <tr>
                                        <td class='conceptoCol subtitulo total' style='background-color:#c8d0c8; color:#053669;'><b>TOTAL INGRESOS EN EUROS</b></td>
                                        <td class='izquierda total' style='background-color:#c8d0c8; color:#053669;'><b>" . number_format($datos->total, '2', ',', '.') . "</b></td>
                                    </tr>  
                                </tbody>
                            </table>
                        </div>
                        
                
                          <div>Forma de Pago: Se abonará la factura en la siguiente Cuenta Corriente IBAN: " . $datos->numCuenta . " </div>";
            ?>
        </div>
    </page>

</body>

</html>