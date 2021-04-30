<?php


$datosAcc = [
    "cliente1",
    "accion1",
    "importe1",
    "horas1",
    "participantes1",
];

$cambioAcc = [
    $presupuesto2[0]->NOMBREJURIDICO,
    $presupuesto2[0]->NOMBREACCION,
    $presupuesto2[0]->importeacc,
    $presupuesto2[0]->horas,
    $presupuesto2[0]->participantes
]

?>
<?php
$html = str_replace( $datosAcc, $cambioAcc, $presupuesto2[0]->htmlPresupuesto);  
echo $html;
?>
