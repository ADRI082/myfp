<div class="modal fade bd-example-modal-lg" id="addProveedores" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <center>
                                <h4 class="modal-title" id="myModalLabel">Proveedores y Material</h4>
                            </center>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="formAddProveedor">
                            <div class="modal-body modalCliente">
                                <h5 class="titleClienteDatos" >Datos de identificación</h5>
                                <div class="row form-group align-items-center">
                                    <div class="col-sm-1">
                                        <label class="control-label" style="position:relative;">Id Proveedor</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type='text' id="idProveedor"  class="form-control form-control-sm" name="idProveedor" readonly>
                                    </div> 
                                    <div class="col-sm-1">
                                        <label class="control-label" style="position:relative;">Nombre Comercial</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type='text' id="nombreComercial"  class="form-control form-control-sm" name="nombreComercial">
                                    </div>             
                                    <div>
                                        <label class="control-label" style="position:relative;">Cif</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type='text' regexp="[a-zA-Z0-9]{0,9}" class="form-control form-control-sm obligatorio" name="cif" required>
                                    </div>                   
                                    <div class="col-sm-1">
                                        <label class="control-label" style="position:relative;">Razón Social</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control form-control-sm obligatorio" name="razonSocial" required>
                                    </div>                                                                     
                                </div>
                                <div class="row form-group align-items-center">
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative;">Persona Contacto 1</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="text" id="personaContacto1" class="form-control form-control-sm" name="personaContacto1">
                                    </div>  
                                    
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative;">Persona Contacto 2</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="text" id="personaContacto2" class="form-control form-control-sm" name="personaContacto2">
                                    </div>      
                                </div>
                            </div>
                            <div class="modal-body modalCliente">
                                <h5 class="titleClienteDatos" >Datos de localización</h5>
                                <div class="row form-group">
                                    <div class="col-sm-1">
                                        <label class="control-label" style="position:relative;">Dirección</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" id="direccionProveedor" class="form-control form-control-sm" name="direccion">
                                    </div>                                    
                                    <div class="col-sm-1">
                                        <label class="control-label"
                                            style="position:relative;">Poblacion</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" id="poblacionProveedor" class="form-control form-control-sm " name="poblacion" >
                                    </div>                                    
                                    <div >
                                        <label class="control-label"
                                            style="position:relative;">Provincia</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" id="provinciaProveedor" class="form-control form-control-sm " name="provincia" >
                                    </div>
                                    <div>
                                        <label class="control-label"
                                          >CP</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="text" regexp="[0-9]{0,5}" id="codPostalProveedor" class="form-control form-control-sm " name="codPostal" >
                                    </div>
                                </div>
                                <div class="row form-group"> 
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">Telef. fijo 1</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type='text' id="telefonoFijoProveedor" regexp="[0-9]{0,9}" class="form-control form-control-sm " name="telefonofijo1" >
                                    </div>
                                    <div>
                                        <label class="control-label" style="position:relative;">
                                            Móvil</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type='text' id="movilProveedor" regexp="[0-9]{0,9}" class="form-control form-control-sm" name="movil">
                                    </div> 
                                    <div>
                                        <label class="control-label" style="position:relative;">
                                            FAX</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type='text' id="faxProveedor" regexp="[0-9]{0,9}" class="form-control form-control-sm" name="fax">
                                    </div>        
                                    <div>
                                        <label class="control-label" style="position:relative;">Email</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="email" class="form-control form-control-sm " name="email" >
                                    </div>                                
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">WEB</label>
                                    </div>
                                    <div class="col-lg-5">
                                        <input type="text" id="webProveedor" class="form-control form-control-sm" name="web">
                                    </div>                              
                                </div>
                            </div>
                            <div class="modal-body modalCliente">
                                <h5 class="titleClienteDatos" >Características</h5>
                                <div class="row form-group">
                                    <div>
                                        <label class="control-label" style="position:relative;">N de Cuenta Corriente</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type='text' id="numCuentaCorrienteProveedor" regexp="[0-9]{0,12}" class="form-control form-control-sm" name="ncc">
                                    </div>
                                    <div>
                                        <label class="control-label"
                                            style="position:relative;">Tipo de Proveedor
                                        </label>
                                    </div>
                                    <div class="col-sm-2" >
                                        <select id="tipoProveedor" class="form-control select2" name="tipoProveedor">
                                            <option selected disabled>Seleccionar...</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="control-label"
                                            style="position:relative;">Plazo de Pago
                                        </label>
                                    </div>
                                    <div class="col-sm-2" >
                                        <select id="plazoPagoProveedor" class="form-control form-control-sm select2" name="plazosPago">
                                            <option selected disabled>Seleccionar...</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="control-label" style="position:relative;">Enlace</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type='text' id="enlaceProveedor" regexp="[0-9]{0,24}" class="form-control form-control-sm" name="ctacte">
                                    </div>
                                </div>                        
                                <div class="row form-group">
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative;">
                                            Observaciones</label>
                                    </div>
                                    <div class="col-lg-10">
                                        <textarea name="observaciones" rows="2" class="form-control form-control-sm"></textarea>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-warning" data-dismiss="modal" title="Cerrar Modal"><i
                                        class="far fa-window-close"></i></button>
                                <button type="button" data-modal="addProveedores" class="btn btn-primary" id="btnAddProveedor"
                                    title="Añadir empresa"><i class="fa fa-plus"></i></button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>