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

    <div class=WordSection1>

<table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0
 style='border-collapse:collapse;border:none;mso-yfti-tbllook:1184;mso-padding-alt:
 0cm 5.4pt 0cm 5.4pt;mso-border-insideh:none;mso-border-insidev:none'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>
  <td width=283 colspan=3 valign=top style='width:212.1pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><span style='mso-fareast-language:ES;mso-no-proof:yes'><!--[if gte vml 1]><v:shapetype
   id="_x0000_t75" coordsize="21600,21600" o:spt="75" o:preferrelative="t"
   path="m@4@5l@4@11@9@11@9@5xe" filled="f" stroked="f">
   <v:stroke joinstyle="miter"/>
   <v:formulas>
    <v:f eqn="if lineDrawn pixelLineWidth 0"/>
    <v:f eqn="sum @0 1 0"/>
    <v:f eqn="sum 0 0 @1"/>
    <v:f eqn="prod @2 1 2"/>
    <v:f eqn="prod @3 21600 pixelWidth"/>
    <v:f eqn="prod @3 21600 pixelHeight"/>
    <v:f eqn="sum @0 0 1"/>
    <v:f eqn="prod @6 1 2"/>
    <v:f eqn="prod @7 21600 pixelWidth"/>
    <v:f eqn="sum @8 21600 0"/>
    <v:f eqn="prod @7 21600 pixelHeight"/>
    <v:f eqn="sum @10 21600 0"/>
   </v:formulas>
   <v:path o:extrusionok="f" gradientshapeok="t" o:connecttype="rect"/>
   <o:lock v:ext="edit" aspectratio="t"/>
  </v:shapetype><v:shape id="_x0030__x0020_Imagen" o:spid="_x0000_i1025"
   type="#_x0000_t75" style='width:185.25pt;height:51pt;visibility:visible;
   mso-wrap-style:square'>
   <v:imagedata src="dip_archivos/image001.png" o:title=""/>
  </v:shape><![endif]-->
  <img src="<?php echo RUTA_URL; ?>/img/logoInforma.jpg" width="300">
</span></p>
  </td>
  <td width=94 valign=top style='width:70.7pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.7pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.7pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.75pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.75pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.75pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.75pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:1'>
  <td width=94 valign=top style='width:70.7pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.7pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.7pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.7pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.7pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.7pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.75pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.75pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.75pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.75pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:2'>
  <td width=94 valign=top style='width:70.7pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'>D./ Dña.</p>
  </td>
  <td width=471 colspan=5 valign=top style='width:353.5pt;border:none;
  border-bottom:solid #00B050 3.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><?php echo
  $datos->Nombre." " .$datos->Apellido1. " ".$datos->Apellido1;
  ?></p>
  </td>
  <td width=94 valign=top style='width:70.75pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'>, con NIF</p>
  </td>
  <td width=283 colspan=3 valign=top style='width:212.25pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:3'>
  <td width=94 valign=top style='width:70.7pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.7pt;border:none;mso-border-top-alt:
  solid #00B050 3.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.7pt;border:none;border-top:solid #00B050 3.0pt;
  padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.7pt;border:none;border-top:solid #00B050 3.0pt;
  padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.7pt;border:none;border-top:solid #00B050 3.0pt;
  padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.7pt;border:none;border-top:solid #00B050 3.0pt;
  padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.75pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.75pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.75pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.75pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:4;mso-yfti-lastrow:yes'>
  <td width=94 valign=top style='width:70.7pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.7pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.7pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.7pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.7pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.7pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.75pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.75pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.75pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
  <td width=94 valign=top style='width:70.75pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'></p>
  </td>
 </tr>
</table>

<p class=MsoNormal></p>

</div>
    </body>
</html>