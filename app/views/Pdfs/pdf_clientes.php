

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Pdf</title>
</head>
<body>
<style>
 td, tr{
width:200px;
}
</style>
<div style="margin-left:10%;margin-right:10%">
<img src='https://myfp.com/wp-content/uploads/2013/10/LogoNormal.png'  alt='logo' style='font-size:20%; margin-left:33%; margin-top:50px'>
       <h3 style="text-align:center">Observaciones del cliente: <?php echo $observaciones[0]->NOMBREJURIDICO ?></h3>
       <h4><?php echo date("d/m/Y", strtotime($observaciones[0]->fecha)) . " - " . $observaciones[0]->titulo; ?></h4>
       <h4><strong>Autor:<?php echo  $observaciones[0]->agente; ?> </strong></h4>
       <p style=" font-size:15px"><?php echo $observaciones[0]->contenido; ?></p>
       </div>
</body>
</html>
