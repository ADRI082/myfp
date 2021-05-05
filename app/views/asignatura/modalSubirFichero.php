<!--modal configuracion de envio factura-->
<div class="modal fade" id="modalSubidaFichero" tabindex="-1" role="dialog" aria-labelledby="modalSubidaFichero" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-size: 1.02rem;" id="modalFichero">Subir Ficheros</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="formSubidaFichero">
                <!-- <input id='numFacturaEmail' type='hidden' name='numFacturaEmail'>
            <input id='idProyectoEmail' type='hidden' name='idProyectoEmail'>
            <input id='tipoFolioPdf' type='hidden' name='tipoFolioPdf'> -->
                <div class="modal-body">
                    <div id="contenidoModalSubidaFichero">
                        <div class="form-group mb-2">
                            <label for="docIdentidad" class="col-form-label">Selecciona el fichero</label>
                        </div>
                    </div>
                    <div class="col-10 mb-3">
                            <input type="file" class="form-control-file" id="ficheroSubida">
                    </div>

                    <div class="col-10 mt-3">
                    <select class="form-control select2" name="bloqueAsignatura" id="selectBloque" style="width: 100%;" required>
                            <option disable>Seleccionar.....</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <a id="btnGuardarFichero" class="btn btn-danger" style="color:white">Guardar</a>
                </div>
            </form>
        </div>
    </div>
</div>