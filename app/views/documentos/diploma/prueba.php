<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejemplo html2pdf</title>
        <style type="text/Css">
            <?php include '../../../../dist/lib/bootstrap/css/bootstrap.css';?>
            <?php include '../../../../dist/css/bootstrap-responsive.css'; ?>

        </style>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <style type="text/css">

            
            #datosEmpresas, #numFactura, #contenido  {            
                border-collapse: collapse;
                width: 100%;
            }
            #datosEmpresas td, #numFactura td, #contenido td {
                border: 1px solid #ddd;
                padding: 8px;
            }
            #numFactura th, #datosEmpresas th, #contenido th {
                border: 1px solid #ddd;
                padding: 8px;
                background-color: #c8d0c8;   
            }
            .titulo{
                font-size: 18px;
                font-weight: 1000;
            }
            .principal{
                margin-bottom: 20px;                                
                border: solid 3px goldenrod;
                max-width: 768px;
                /*margin: 60px auto;*/
                position: relative;
                height: auto;
                padding: 15px;
                
            }

            .contenedor{
                margin: 20px;                                
               
                /*margin: 60px auto;*/
                position: relative;
                height: auto;
                
            }

            span {
                width: 100px;
                display:block;
                color:#000066;
               
                }

            .underline {
                border-bottom: solid 2px #000066;
            }

            p{
                margin-bottom: 0px;
            }
            
        </style>
    </head>
    <body>

        
        <p></p>
        <div class="principal">
            <?php 

                echo"
                    <table>           
                        <tr>
                            <td colspan=3 width=305 valign=top style='width:240.2pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                                normal'>
                                <img src='".RUTA_URL."/img/logoInforma.jpg' width='200'>
                                </p>
                            </td>                                
                            <td colspan=3 width=305 valign=top style='width:240.2pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                                normal'>
                                
                                </p>
                            </td>
                            <td colspan=5 width=305 valign=top style='width:240.2pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                                normal'>
                                
                                </p>
                            </td>
                        </tr>

                        <tr>
                            <td colspan=11 width=320 valign=top style='width:69.2pt;border:none;border-bottom:solid #002060 4.5pt;
                            padding:0cm 5.4pt 0cm 5.4pt'>
                            <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                            normal'><b style='mso-bidi-font-weight:normal'></b></p>
                            </td>                           
                        </tr>

                        <tr>
                            <td width=93 colspan=1 valign=top style='width:69.9pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                                normal'><b style='mso-bidi-font-weight:normal'><span style='color:#002060'>D./
                                Dña.</span></b></p>
                            </td>
                            
                            <td colspan=5 style='border-bottom:solid #002060 2.25pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
                                text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:14.0pt;mso-bidi-font-size:11.0pt; color:black'>
                                ".$datos->Nombre." " .$datos->Apellido1. " ".$datos->Apellido2."
                                </span></b></p>
                            </td>
                            <td width=93 colspan=2 valign=top style='width:69.9pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                                normal'><b style='mso-bidi-font-weight:normal'><span style='color:#002060'>
                                , con NIF
                                </span></b></p>
                            </td>
                            
                            <td colspan=3 style='border-bottom:solid #002060 2.25pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
                                text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:14.0pt;mso-bidi-font-size:11.0pt; color:black'>
                                ".$datos->DocIdentidad."
                                </span></b></p>
                            </td>                            
                        </tr>

                        <tr>
                            <td colspan=3 valign=top style='padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                                normal'><b style='mso-bidi-font-weight:normal'><span style='color:#002060'>que
                                presta sus servicios en la Empresa</span></b></p>
                            </td>
                            
                            <td colspan=3 style='border-bottom:solid #002060 2.25pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
                                text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:14.0pt;mso-bidi-font-size:11.0pt; color:black'>
                                ".$datos->NOMBREJURIDICO."
                                </span></b></p>
                            </td>
                            <td width=93 colspan=2 valign=top style='width:69.9pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                                normal'><b style='mso-bidi-font-weight:normal'><span style='color:#002060'>
                                , con NIF
                                </span></b></p>
                            </td>
                            
                            <td colspan=3 style='border-bottom:solid #002060 2.25pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
                                text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:14.0pt;mso-bidi-font-size:11.0pt; color:black'>
                                ".$datos->DocIdentidad."
                                </span></b></p>
                            </td>
                        </tr>

                        <tr>
                            <td colspan=3 valign=top style='padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                                normal'><b style='mso-bidi-font-weight:normal'><span style='color:#002060'>Ha
                                realizado la Acción Formativa</span></b></p>
                            </td>
                            
                            <td colspan=8 style='border-bottom:solid #002060 2.25pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
                                text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:14.0pt;mso-bidi-font-size:11.0pt; color:black'>
                                ".$datos->NOMBREACCION."
                                </span></b></p>
                            </td>                           
                        </tr>

                        <tr>
                            <td colspan=1 valign=top style='padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                                normal'><b style='mso-bidi-font-weight:normal'><span style='color:#002060'>Código
                                AF/Grupo</span></b></p>
                            </td>
                            
                            <td colspan=2 style='border-bottom:solid #002060 2.25pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
                                text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:14.0pt;mso-bidi-font-size:11.0pt; color:black'>
                                ".$datos->accionformativa." / ".$datos->IDPROYECTO."
                                </span></b></p>
                            </td>                           
                        </tr>

                        <tr>
                            <td colspan=1 valign=top style='padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                                normal'><b style='mso-bidi-font-weight:normal'><span style='color:#002060'>
                                Durante los días</span></b></p>
                            </td>
                            <td colspan=1 style='border-bottom:solid #002060 2.25pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
                                text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:14.0pt;mso-bidi-font-size:11.0pt; color:black'>
                                ".date('d/m/Y',strtotime($datos->fechaInicio))."
                                </span></b></p>
                            </td>         
                            <td colspan=1 valign=top style='padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                                normal'><b style='mso-bidi-font-weight:normal'><span style='color:#002060'>
                                al</span></b></p>
                            </td>
                            <td colspan=1 style='border-bottom:solid #002060 2.25pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
                                text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:14.0pt;mso-bidi-font-size:11.0pt; color:black'>
                                ".date('d/m/Y',strtotime($datos->fechaFin))."
                                </span></b></p>
                            </td>
                            <td colspan=2 valign=top style='padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                                normal'><b style='mso-bidi-font-weight:normal'><span style='color:#002060'>
                                con una duración total de </span></b></p>
                            </td>
                            <td colspan=1 style='border-bottom:solid #002060 2.25pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
                                text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:14.0pt;mso-bidi-font-size:11.0pt; color:black'>
                                ".$datos->horas."
                                </span></b></p>
                            </td>
                            <td colspan=1 valign=top style='padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                                normal'><b style='mso-bidi-font-weight:normal'><span style='color:#002060'>
                                horas. </span></b></p>
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan=1 valign=top style='padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                                normal'><b style='mso-bidi-font-weight:normal'><span style='color:#002060'>
                                En a Modalidad formativa </span></b></p>
                            </td>                            
                            <td colspan=10 style='border-bottom:solid #002060 2.25pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;
                                line-height:normal'><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:14.0pt;mso-bidi-font-size:11.0pt; color:black'>&nbsp;&nbsp;&nbsp;
                                ".$datos->nombreModalidad."
                                </span></b></p>
                            </td>                           
                        </tr>

                        


                    </table>
                ";
            
                /*
                echo"
                        <div class='contenedor'>
                            <div>
                                <img src='".RUTA_URL."/img/logoInforma.jpg' width='200'>
                            </div>
                                         
                            <div>
                                <img src='".RUTA_URL."/img/logoFundae.jpg' width='100'>
                            </div>
                        </div>";
                    */
                    ?>                                  
                             
        </div>

    </body>
</html>