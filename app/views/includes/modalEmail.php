<!--modal configuracion de envio factura-->                    
<div class="modal fade" id="modalEnvioFactura" tabindex="-1" role="dialog" aria-labelledby="modalEnvioFactura" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-size: 1.02rem;" id="modalEnvioFactura"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            
        <form id="formEnvioFactura">          
            <input id='numFacturaEmail' type='hidden' name='numFacturaEmail'>
            <input id='idProyectoEmail' type='hidden' name='idProyectoEmail'>
            <input id='tipoFolioPdf' type='hidden' name='tipoFolioPdf'>
            <div class="modal-body">
              <div id="contenidoModalEnvioFactura">
                <div class="form-group mb-2">
                  <label for="docIdentidad" class="col-form-label">Seleccione los destinatarios</label>
                </div>

                <div class="row mb-3" >
                  <div class="col-10" id="selectContactos" >
                  
                  </div>
                  <div class="col-2 mb-3">
                    <button id="btnElegirEmail" class="btn btn-success btn-sm">Agregar más</button>
                  </div>   
                </div>
              </div>
              <div class="form-group mb-2">
                  <label for="docIdentidad" class="col-form-label">Destinatarios seleccionados</label>
              </div>
              <div class="form-group">
                  <table class="table table-light" id="tablaEmailsEnvioFactura" style="width: 70%;">                    
                    </thead>
                    <tbody>                    
                    </tbody>                    
                  </table>
              </div>

              <div>
                <div class="form-group mb-2">
                  <label for="asunto" class="col-form-label">Asunto:</label>
                </div>
                <div class="form-group mb-3" >                  
                  <input class="asunto form-control" name="asunto" id="asunto">
                </div>
              </div>

              <div>
                <div class="form-group mb-2">
                  <label for="docIdentidad" class="col-form-label">Mensaje:</label>
                </div>
                <div class="form-group mb-3" >                  
                  <textarea class="msgEMailFactura form-control" name="msgEMailFactura" id="msgEmailFactura" rows="3"></textarea>                  
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                <a id="btnEnviarEmail" class="btn btn-danger" style="color:white">Enviar</a>
            </div>
        </form>    
        </div>
    </div>
</div>