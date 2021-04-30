<?php 
$datos = [
  
    "[fecha]",
    "[iva]",
    "[importe]",
    "[concepto]",
    "[grupo empresas]",
    "[tipo]",
  
  
];
$cambio = [

    $presupuesto[0]->fecha,
    $presupuesto[0]->iva,
    $presupuesto[0]->importe,
    $presupuesto[0]->concepto,
    $presupuesto[0]->nombreG,
    $presupuesto[0]->tipoPlantilla,
 
  

]
?>
<?php
$html = str_replace( $datos, $cambio, $presupuesto[0]->htmlPresupuesto);  
echo $html;
?>
