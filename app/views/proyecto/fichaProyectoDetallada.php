<div class="form-group d-flex justify-content-between">
  <div class="form-group row">

    <?php

    $registro = $datos['registros'];
    $tipoCostes = $datos['tipoCostes'];
    $costesProy = $datos['costesProy'];
    $facturasProy = $datos['facturasProy'];
    $tipoGastos = $datos['tipoGastos'];
    $gastosProy = $datos['gastosProy'];
    $ctasBancarias = $datos['ctasBancarias'];
    $selectEmails = $datos['selectEmails'];
    $participantesCliente = $datos['participantesCliente']; //aqui viene datos generales y de cada participante por cliente pero falta pintarlos en otro apartado


        //$registro = $datos['registros'];
        $tipoCostes = $datos['tipoCostes'];
        $costesProy = $datos['costesProy'];       
        $facturasProy = $datos['facturasProy'];
        $tipoGastos = $datos['tipoGastos'];
        $gastosProy = $datos['gastosProy'];
        $ctasBancarias = $datos['ctasBancarias'];
        $selectEmails = $datos['selectEmails'];
        $participantesCliente = $datos['participantesCliente']; //aqui viene datos generales y de cada participante por cliente pero falta pintarlos en otro apartado
               
      ?>
    </div>
</div>                      


<!--modal configuracion de envio factura-->
<div class="modal fade" id="modalEnvioFactura" tabindex="-1" role="dialog" aria-labelledby="modalEnvioFactura" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEnvioFactura"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formEnvioFactura" action="<?php echo RUTA_URL;  ?>/Proyecto/enviarEMailYFicheroPfd" method="POST">
        <input id='idFactura' type='hidden' name='idFactura'>
        <input id='idProyectoEmail' type='hidden' name='idProyectoEmail'>
        <div class="modal-body">
          <div id="contenidoModalEnvioFactura">
            <div class="form-group mb-2">
              <label for="docIdentidad" class="col-form-label">Seleccione los destinatarios</label>
            </div>
            <div class="row mb-3">
              <div class="col-10">
                <?php
                echo "
                        <select class='form-control lineaCoste todos' id='mail' name='mail'>
                          <option>Seleccionar</option>";
                foreach ($selectEmails as $dato) {
                  echo "
                            <option value='" . $dato->mail . "'>" . $dato->nombre . " | " . $dato->mail . " | " . $dato->area . "</option>";
                }
                echo "
                          <option value='otroEmail'>Otro</option>
                        </select>";
                ?>
              </div>
              <div class="col-2">
                <button id="btnElegirEmail" class="btn btn-success">Agregar</button>
              </div>
            </div>
          </div>

          <div class="form-group">
            <table class="table table-light" id="tablaEmailsEnvioFactura">
              <thead class="thead-light">
                <tr>
                  <th>#</th>
                  <th>Email</th>
                  <th>Eliminar</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>

          <div>
            <div class="form-group mb-2">
              <label for="docIdentidad" class="col-form-label">Mensaje:</label>
            </div>
            <div class="form-group mb-3">
              <textarea class="msgEMailFactura form-control" name="msgEmailFactura" id="msgEmailFactura" rows="3"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
          <button type="submit" id="btnEnviarEmail" class="btn btn-danger">Enviar</button>
        </div>
      </form>
    </div>
</div>
