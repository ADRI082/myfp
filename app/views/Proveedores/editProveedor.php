<div class="modal fade bd-example-modal-lg" id="editProveedor" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <center>
                                <h4 class="modal-title" id="myModalLabel">Editar Proveedores y Material</h4>
                            </center>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                            <div class="modal-body modalCliente">
                                <h5 class="titleClienteDatos" >Datos de identificación</h5>
                                <div class="row form-group align-items-center">
                                    <div class="col-sm-1">
                                        <label class="control-label" style="position:relative;">Id Proveedor</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type='text' data-tabla="proveedores" data-pk="idPROVEEDOR"  id="idProveedorEdit"  class="form-control form-control-sm campotabla" name="idProveedor" readonly>
                                    </div> 
                                    <div class="col-sm-1">
                                        <label class="control-label" style="position:relative;">Nombre Comercial</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type='text' data-tabla="proveedores" data-pk="idPROVEEDOR"  id="nombreComercialEdit"  class="form-control form-control-sm campotabla" name="NOMBRECOMERCIAL">
                                    </div>             
                                    <div>
                                        <label class="control-label" style="position:relative;">Cif</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type='text' data-tabla="proveedores" data-pk="idPROVEEDOR" regexp="[a-zA-Z0-9]{0,9}" id="cifProveedorEdit" class="form-control form-control-sm obligatorio campotabla" name="CIFPROVEEDOR" required>
                                    </div>                   
                                    <div class="col-sm-1">
                                        <label class="control-label" style="position:relative;">Razón Social</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" data-tabla="proveedores" data-pk="idPROVEEDOR" id="razonSocialEdit" class="form-control form-control-sm obligatorio campotabla" name="PERSONAJURIDICA" required>
                                    </div>                                                                     
                                </div>
                                <div class="row form-group align-items-center">
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative;">Persona Contacto 1</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="text" data-tabla="proveedores" data-pk="idPROVEEDOR" id="personaContacto1Edit" class="form-control form-control-sm campotabla" name="PERSONACONTACTO1">
                                    </div>  
                                    
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative;">Persona Contacto 2</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="text" data-tabla="proveedores" data-pk="idPROVEEDOR" id="personaContacto2Edit" class="form-control form-control-sm campotabla" name="PERSONACONTACTO2">
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
                                        <input type="text" data-tabla="proveedores" data-pk="idPROVEEDOR" id="direccionProveedorEdit" class="form-control form-control-sm campotabla" name="DIRECCION">
                                    </div>                                    
                                    <div class="col-sm-1">
                                        <label class="control-label"
                                            style="position:relative;">Poblacion</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" data-tabla="proveedores" data-pk="idPROVEEDOR" id="poblacionProveedorEdit" class="form-control form-control-sm campotabla " name="POBLACION" >
                                    </div>                                    
                                    <div >
                                        <label class="control-label"
                                            style="position:relative;">Provincia</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" data-tabla="proveedores" data-pk="idPROVEEDOR" id="provinciaProveedorEdit" class="form-control form-control-sm campotabla " name="PROVINCIA" >
                                    </div>
                                    <div>
                                        <label class="control-label"
                                          >CP</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="text" data-tabla="proveedores" data-pk="idPROVEEDOR" regexp="[0-9]{0,5}" id="codPostalProveedorEdit" class="form-control form-control-sm campotabla " name="CODPOSTAL" >
                                    </div>
                                </div>
                                <div class="row form-group"> 
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">Telef. fijo 1</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type='text' data-tabla="proveedores" data-pk="idPROVEEDOR" id="telefonoFijoProveedorEdit" regexp="[0-9]{0,9}" class="form-control form-control-sm campotabla " name="TELEFONOFIJO" >
                                    </div>
                                    <div>
                                        <label class="control-label" style="position:relative;">
                                            Móvil</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type='text' data-tabla="proveedores" data-pk="idPROVEEDOR" id="movilProveedorEdit" regexp="[0-9]{0,9}" class="form-control form-control-sm campotabla" name="TELEFONOMOVIL">
                                    </div> 
                                    <div>
                                        <label class="control-label" style="position:relative;">
                                            FAX</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type='text' data-tabla="proveedores" data-pk="idPROVEEDOR" id="faxProveedorEdit" regexp="[0-9]{0,9}" class="form-control form-control-sm campotabla" name="FAX">
                                    </div>        
                                    <div>
                                        <label class="control-label" style="position:relative;">Email</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="email" data-tabla="proveedores" data-pk="idPROVEEDOR" id="emailProveedorEdit" class="form-control form-control-sm campotabla " name="EMAIL" >
                                    </div>                                
                                    <div class="col-lg-1">
                                        <label class="control-label" style="position:relative;">WEB</label>
                                    </div>
                                    <div class="col-lg-5">
                                        <input type="text" data-tabla="proveedores" data-pk="idPROVEEDOR" id="webProveedorEdit" class="form-control form-control-sm campotabla" name="WEB">
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
                                        <input type='text' data-tabla="proveedores" data-pk="idPROVEEDOR" id="numCuentaCorrienteProveedorEdit" regexp="[0-9]{0,12}" class="form-control form-control-sm campotabla" name="NUMCUENTA">
                                    </div>
                                    <div>
                                        <label class="control-label"
                                            style="position:relative;">Tipo de Proveedor
                                        </label>
                                    </div>
                                    <div class="col-sm-2" >
                                        <select id="tipoProveedorEdit" data-tabla="proveedores" data-pk="idPROVEEDOR" class="form-control select2 selectEdit" name="TIPODEPROVEEDOR">
                                            <option selected disabled>Seleccionar...</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="control-label"
                                            style="position:relative;">Plazo de Pago
                                        </label>
                                    </div>
                                    <div class="col-sm-2" >
                                        <select id="plazoPagoProveedorEdit" data-tabla="proveedores" data-pk="idPROVEEDOR" class="form-control form-control-sm select2 selectEdit" name="CODFORMAPAGO">
                                            <option selected disabled>Seleccionar...</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="control-label" style="position:relative;">Enlace</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type='text' data-tabla="proveedores" data-pk="idPROVEEDOR" id="enlaceProveedorEdit" regexp="[0-9]{0,24}" class="form-control form-control-sm campotabla" name="enlace">
                                    </div>
                                </div>                        
                                <div class="row form-group">
                                    <div class="col-lg-2">
                                        <label class="control-label" style="position:relative;">
                                            Observaciones</label>
                                    </div>
                                    <div class="col-lg-10">
                                        <textarea name="OBSERVACIONES" data-tabla="proveedores" data-pk="idPROVEEDOR" id="observacionesProveedoresEdit" rows="2" class="form-control form-control-sm campotabla"></textarea>                                        
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="modal-footer">
                                <button class="btn btn-warning" data-dismiss="modal" title="Cerrar Modal"><i
                                        class="far fa-window-close"></i></button>
                                <button type="button" class="btn btn-primary" id="btnAddProveedor"
                                    title="Añadir empresa"><i class="fa fa-plus"></i></button>

                            </div> -->
                    </div>
                </div>
            </div>