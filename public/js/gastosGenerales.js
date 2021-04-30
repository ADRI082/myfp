$(document).ready(function(){

  if (window.location.pathname.includes('/gastosGenerales')) {

    var urlCompleta = $('#ruta').val();

    $('#noRepatir').on("click", function(){
      $('#asignacionCostos1').html('');      
    });
    
    //1-ASIGNACIÓN DE COSTOS POR ÁRES
    $('#area').on("click", function(){      
      $('#asignacionCostos1').html('');
      agregarAreaParaAsignacionPorArea();
    });

    function agregarAreaParaAsignacionPorArea() {
      var contenido = '<div class="form-group col-lg-4"></div><div class="form-group col-lg-4 mb-2 selPres actividad">'+
                        '<select type="text" class="form-control form-control-sm" required name="selectArea" id="selectArea">'+
                        '<option selected disabled>Seleccionar Área</option>'+                                                      
                      '</select>'+
                      '</div><div class="form-group col-lg-4"></div>'+
                      '<div class="form-group col-lg-2"></div><div class="form-group col-lg-8">'+
                      '<table class="table table-bordered table-hover" id="tablaAreas">'+
                        '<tr>'+
                            '<th width="10%" class="text-center">Nº</th>'+
                            '<th width="60%" class="text-center">Área</th>'+
                            '<th width="20%" class="text-center">Asignación(€)</th>'+
                            '<th width="10%" class="text-center">Eliminar</th>'+
                        '</tr>'+
                      '</table>'+
                      '</div><div class="form-group col-lg-2"></div>';
      $('#asignacionCostos1').append(contenido);      
            
      //traigo las áreas informa:
      $.ajax({
        type: "POST",        
        url: "GastosGenerales/obtenerAreasInforma",
        success: function (respuesta) {
          respuesta = JSON.parse(respuesta);          
          for (let index = 0; index < respuesta.length; index++) {            
            var opciones = '<option value="'+respuesta[index].id+'">'+respuesta[index].area+'</option>';            
            $('#selectArea').append(opciones);
          }         
        }
      });
      

    }

    //1.1-agrega área en la creación de la factura de gasto
    $(document).on('change', '#selectArea', function () {
      area = $('#selectArea').attr('option', 'selected').val();
      nomArea = $("#selectArea option:selected").text();
      var fila =  '<tr>'+
                    '<td class="fila">'+                      
                        '<input name="idArea[]" type="text" class="form-control form-control-sm readonlyblanco text-center" readonly value="'+area+'">'+                      
                    '</td>'+                    
                    '<td class="fila">'+                    
                      '<input type="text" class="form-control form-control-sm readonlyblanco" style="width:100%" readonly value="'+nomArea+'">'+                  
                    '</td>'+
                    '<td class="fila tdInputObligatorio">'+
                      '<input name="montoAsignado[]" type="text" class="inputSinBordeEditable" id="montoAsignado'+area+'" placeholder="Ingrese valor" required style="width:100%">'+                  
                    '</td>'+
                    '<td class="text-center fila"><a class="eliminarArea"><i class="fas fa-trash" style="color:#ce0b0b;"></i></a></td>'+
                  '</tr>';
      $('#tablaAreas').append(fila);      
      $('#selectArea').val('Seleccionar Área');
    });
    
    //1.2-Eliminación de área en la creación de la factura de gasto
    $(document).on("click",".eliminarArea", function(e){
         
          var filaArea = $(this).closest('tr');          
          idGasto = $('#idGasto').val();
          idArea = $(this).data('idgasto');
          
          if (idGasto != '' && idGasto >0) {
              $.ajax({
                  url: "GastosGenerales/eliminarAsignacionArea",
                  type: "POST",
                  dataType: "json",   
                  data: {idArea:idArea, idGasto:idGasto},    
                  success: function(data){
                    if (data == true) {
                      filaArea.remove();                      
                    }                     
                  }
              });
          }else{
              filaArea.remove();
          }        
    });    

    //2-ASIGNACIÓN DE COSTOS POR ÁREA Y PROYECTO
    $('#areaProyecto').on("click", function(){      
      $('#asignacionCostos1').html(''); 
      agregarAreasYProyectos();       
    });

    function agregarAreasYProyectos() {

      var contenido = '<div class="form-group col-lg-3 mb-2 selPres actividad">'+
                          '<select type="text" class="form-control form-control-sm" name="selectArea2" id="selectArea2">'+                              
                          '</select>'+
                      '</div>'+
                      '<div class="form-group col-lg-9 mb-2 selPres actividad">'+
                          '<select type="text" class="form-control form-control-sm select2" name="selectProyecto" id="selectProyecto">'+                                   
                          '</select>'+
                      '</div>'+                                            
                      '<div class="form-group col-lg-12">'+
                      '<table class="table table-bordered table-hover" id="tablaAreasProyecto">'+
                        '<tr>'+
                            '<th width="3%" class="text-center">Nº</th>'+
                            '<th width="10%" class="text-center">Área</th>'+
                            '<th width="74%" class="text-center">Proyecto</th>'+
                            '<th width="10%" class="text-center">Asignación(€)</th>'+
                            '<th width="3%" class="text-center"></th>'+
                        '</tr>'+
                      '</table>'+
                      '</div>';
      $('#asignacionCostos1').append(contenido);
                  
      //traigo las áreas informa desde una funcion:      
      obtenerAreas();      

      //reinicio el select de proyecto cada vez que cambia el select de áreas
      $("#selectArea2").on("change", function(){        
        var idArea = $(this).children('option:selected').val();
        $('#selectProyecto').html('');
        obtenerProyectos(idArea);
        $('.select2').select2({
          theme: 'bootstrap4'
        });       
      });        
            
    }

    //2.1-agrega área en la creación de la factura de gasto
    $(document).on('change', '#selectProyecto', function () {
      area = $('#selectArea2').attr('option', 'selected').val();
      nomArea = $("#selectArea2 option:selected").text();
      idAccionProy = $('#selectProyecto').attr('option', 'selected').val();
      nomProyecto = $("#selectProyecto option:selected").text();      
      var fila =  '<tr>'+
                    '<td class="fila">'+                      
                        '<input type="text" class="inputSinBordeNoeditable" name="idAreaProyecto[]" readonly value="'+idAccionProy+'">'+                      
                    '</td>'+                    
                    '<td class="fila">'+nomArea+                               
                    '</td>'+
                    '<td class="fila">'+nomProyecto+                                        
                    '</td>'+                    
                    '<td class="fila tdInputObligatorio">'+                    
                      '<input type="text" class="inputSinBordeEditable" name="asignacionProy[]" placeholder="Ingrese valor" required style="width:100%">'+                  
                    '</td>'+
                    '<td class="text-center fila"><a class="eliminarAreaProy"><i class="fas fa-trash" style="color:#ce0b0b;vertical-align: middle;"></i></a></td>'+
                  '</tr>';
      $('#tablaAreasProyecto').append(fila);
      
      $('#selectArea2').html('');
      $('#selectProyecto').html('');
      obtenerAreas();      
      
    });

    function obtenerAreas() {
      $.ajax({
        type: "POST",        
        url: "GastosGenerales/obtenerAreasInforma",
        success: function (respuesta) {
          respuesta = JSON.parse(respuesta);
          
          var opciones = '<option selected disabled>Seleccionar Área</option>';
          for (let index = 0; index < respuesta.length; index++) {            
            opciones += '<option value="'+respuesta[index].id+'">'+respuesta[index].area+'</option>';                               
          }
          $('#selectArea2').append(opciones);      
        }
      });
      
    }

    function obtenerProyectos(idArea) {
      $.ajax({
        type: "POST",
        data: {
          'idArea': idArea
        },
        url: "GastosGenerales/obtenerProyectosPorServicio",
        success: function (respuesta) {
          respuesta = JSON.parse(respuesta);
          var opciones = '<option selected disabled>Seleccionar Proyecto</option>';     
          for (let index = 0; index < respuesta.length; index++) {            
            opciones += '<option value="'+respuesta[index].idAccion+'">Grupo: '+respuesta[index].grupo+' - Acción '+respuesta[index].idAccionFormativa+
                          ': '+respuesta[index].nombreAccion+
                          ' - Cliente: '+respuesta[index].denominacion+
                          ' - N.Comercial: '+respuesta[index].nomComercial+' </option>';                        
          }
          $('#selectProyecto').append(opciones);
        }
      });
      
    }

    //2.2-Eliminación de área en la creación de la factura de gasto
    $(document).on("click",".eliminarAreaProy", function(e){
      
          var filaArea = $(this).closest('tr');
          idGasto = $('#idGasto').val();
          idaccionproy = $(this).data('idaccionproy');      
          
          if (idGasto != '' && idGasto >0) {

              $.ajax({
                  url: "GastosGenerales/eliminarAsignacionAreaYProyecto",
                  type: "POST",
                  dataType: "json",   
                  data: {idGasto:idGasto, idaccionproy:idaccionproy},        
                  success: function(data){
                    if (data == true) {
                      filaArea.remove();
                    }                      
                  }
              });
          }else{
              filaArea.remove();
          }        
    });

    $(document).on('keyup', '.inputChange', function () {      
      calcularTotal();
    });

    $(document).on('change', '.inputChange', function () {      
      calcularTotal();
    });

    //3- CALCULA EL TOTAL A PAGAR CADA VEZ QUE CAMBIEN LOS VALORES DE LOS INPUTS
    function calcularTotal() {
      var baseImponible = $('#baseImponible').val();
      
      var cantidad = $('#cantidad').val();
      //var tipoiva  = $('#iva').attr('option', 'selected').val();
      var iva  = $('#iva').attr('option', 'selected').val();
      if(iva == 1 || iva ==''){
        porcIva = 0;
      }else if(iva == 2){
        porcIva = 4;
      }else if(iva == 3){
        porcIva = 10;
      }else if(iva == 4){
        porcIva = 21;
      }

      var irpf = $('#irpf').val();

      var resultadoPrevio = parseFloat(baseImponible) * parseFloat(cantidad);
      //if (iva > 0 && iva != '') {
        importeIva= resultadoPrevio * (porcIva/100);
      /*}else{
        importeIva = 0;
      }*/
      if (irpf > 0) {
        importeirpf= resultadoPrevio * (irpf/100);
      }else{
        importeirpf = 0;
      }

      var resultado = parseFloat(resultadoPrevio + importeIva - importeirpf).toFixed(2);
      $('#totalGasto').val(resultado);

    }

    //4- AL CERRAR EL MODAL, RESETEO LOS INPUTS DEL FORMULARIO
    $(document).on('click','.cerrar',function(e) {
      $("#formCrear").trigger('reset');
      $('#asignacionCostos1').html('');
      $('.select2-selection__rendered').text('Seleccionar...');     
      $('#btnGuardar').css("display", "block");
    });

    //5- CODIGO PARA DATATABLE
    $('#tablaGastosGenerales thead th').each(function() {
        var title = $(this).text();
        $(this).html(title+'</br><input type="text" class="col-search-input" style="margin-top:10px;" placeholder="" />');
    });

    let tablaGastosGenerales = $('#tablaGastosGenerales').DataTable( {
        "responsive": true,
        "autoWidth": true,
        "dom": 'lBfrtip',
        'ordering': true,
        "aaSorting": [[ 0, "desc" ]],
        "language": {
            "url": "../public/datatables/Languages/Spanish.json"
        },
        "buttons": [
        {
            "extend": 'excelHtml5',
            "text": '<i class="fas fa-file-excel" style="color:green;"></i>',
            "titleAttr": 'Exportar a Excel',
            "className": 'btn btn-success'
        },
        {
            "extend": 'pdfHtml5',
            "text": '<i class="fas fa-file-pdf" style="color:red;"></i>',
            "titleAttr": 'Exportar a PDF',
            "className": 'btn btn-danger'
        },
        {
            "extend": 'print',
            "text": '<i class="fas fa-print" style="color:blue;"></i>',
            "titleAttr": 'Imprimir',
            "className": 'btn btn-info'
        },
        {
            "extend": 'copy',
            "text": '<i class="fas fa-copy" style="color:black;"></i>',
            "titleAttr" : 'Copiar filas'
        }

    ] ,
    /* codigo para ejecutar la busqueda por columna de la tabla */

    initComplete: function() {
            var api = this.api();
            // Apply the search
            api.columns().every(function() {
            var that = this;
            $('input', this.header()).on('keyup change', function() {
                if (that.search() !== this.value) {
                that
                    .search(this.value)
                    .draw();
                }
            });
            }); }

    } );

    $('a.toggle-vis').on( 'click', function (e) {
        e.preventDefault();
        // Get the column API object
        var column = tablaGastosGenerales.column( $(this).attr('data-column') );
                // Toggle the visibility
        column.visible( ! column.visible() );
    } );
    $.fn.dataTable.ext.errMode = 'none';
    $('#tablaGastosGenerales').on( 'error.dt', function ( e, settings, techNote, message ) {
        console.log( 'An error has been reported by DataTables: ', message );
    } ) .DataTable();
    $('#tablaGastosGenerales').DataTable();

    //FIN CÓDIGO DATATABLE

    //6- MODAL PARA VER/EDITAR DE FACTURA DE GASTO
    $(document).on('click','.btnUpdateGastos',function(e) {
      
      idFactura = $(this).attr('data-idfactura');
      $('#idGasto').val(idFactura);
      if (idFactura >0 && idFactura !='') {
        $('#btnGuardar').css("display", "none");
      }

      $.ajax({
        url: "GastosGenerales/obtenerFacturaGastoDetallada",
        type: "POST",
        dataType: "json",
        data: {idFactura:idFactura},
        success: function(data){

          $('select[name="tipoGasto"]').val(data['tipoGasto']);
          $('select[name="proveedor"]').val(data['tipoProveedor']+'-'+data['datosProveedor']['idProveedor']);          
          $('input[name=numFactura]').val(data['numfacgasto']);
          $('input[name=fechaFactura]').val(data['fecha']);
          $('input[name=cantidad]').val(data['cantidad']);
          $('input[name=baseImponible]').val(new Intl.NumberFormat("de-DE").format(data['importe']));
          $('input[name=irpf]').val(new Intl.NumberFormat("de-DE").format(data['irpf']));
          $('select[name="iva"]').val(new Intl.NumberFormat("de-DE").format(data['iva']));
          $('input[name=totalGasto]').val(new Intl.NumberFormat("de-DE").format(data['total']));
          $('input[name=descripcion]').val(data['descripcion']);          
          $('input[name=fechaPago]').val(data['fechapago']);          
          $('select[name="iban"]').val(data['iban']);
          $('input[name=descripcion]').val(data['descripcion']);
          if (data["asignacion"] == 'noRepatir') {
            $('#noRepatir').prop('checked',true);
          }else if (data["asignacion"] == 'area') {
            $('#area').prop('checked',true);
          }else if (data["asignacion"] == 'areaProyecto') {
            $('#areaProyecto').prop('checked',true);
          }
          $('.select2').select2({
            theme: 'bootstrap4'
          });
          
          //SI TIENE ASIGNACIÓN A UN ÁREA Y/O ÁREA PROYECTO

          if (data['asignacion'] == 'area') {
            
            //agregar tabla con datos de asignación
            agregarAreaParaAsignacionPorArea();
            montos = data['montosAsignados'];
            if (data['montosAsignados']) {
              for (let index = 0; index < montos.length; index++) {              
                var tablaAsig =  '<tr>'+
                              '<td class="fila">'+                      
                                  '<input name="idArea[]" type="text" class="form-control form-control-sm readonlyblanco" readonly value="'+montos[index].idArea+'">'+                      
                              '</td>'+                    
                              '<td class="fila">'+                    
                                '<input type="text" class="form-control form-control-sm readonlyblanco" style="width:100%" readonly value="'+montos[index].area+'">'+                  
                              '</td>'+
                              '<td class="fila tdInputObligatorio">'+
                                '<input name="montoAsignado[]" type="text" class="inputSinBordeEditable" id="montoAsignado'+montos[index].idArea+'" value="'+montos[index].monto+'" placeholder="Ingrese valor" required style="width:100%">'+                  
                              '</td>'+
                              '<td class="text-center fila"><a class="eliminarArea" data-idgasto="'+montos[index].idArea+'" ><i class="fas fa-trash" style="color:#ce0b0b;"></i></a></td>'+
                            '</tr>';

                $('#tablaAreas').append(tablaAsig);
              }
            }


          }else if (data['asignacion'] == 'areaProyecto') {
            //agregar tabla con datos de asignación
            
            agregarAreasYProyectos();
            montos = data['montosAsignados'];
            if (data['montosAsignados']) {
              for (let index = 0; index < montos.length; index++) {              

                var fila =  '<tr>'+
                  '<td class="fila">'+                      
                      '<input type="text" class="inputSinBordeNoeditable" name="idAreaProyecto[]" readonly value="'+montos[index].idArea+'">'+
                  '</td>'+                    
                  '<td class="fila">'+montos[index].area+                        
                  '</td>'+
                  '<td class="fila">Grupo:'+montos[index].grupo+' - Acción'+montos[index].idAccion+':'+montos[index].nomAccion+' - '+
                      'Cliente:'+montos[index].razonSocial+' - N.Comercial:'+montos[index].nomComercial+
                  '</td>'+                    
                  '<td class="fila tdInputObligatorio">'+                    
                    '<input type="text" class="inputSinBordeEditable" name="asignacionProy[]" value="'+montos[index].monto+'"  placeholder="Ingrese valor" required style="width:100%">'+                  
                  '</td>'+  
                  '<td class="text-center fila"><a class="eliminarAreaProy" data-idaccionproy="'+montos[index].idAccionProy+'"><i class="fas fa-trash" style="color:#ce0b0b;vertical-align: middle;"></i></a></td>'+
                '</tr>';
                $('#tablaAreasProyecto').append(fila);



              }
            }
          }

        }       

      });

      $("#modalAddGasto").modal("show");
      $(".modal-title").text("Ver/Editar Factura de Gasto"); 
    });

    //7- ACTUALIZADOR DE CAMPOS
    $('.actualizadorInput').on("focusout", function () {

      var id = $('#idGasto').val();
      if (id != '' && id >0) {
          var tabla = $(this).data("tabla");
          var campo = $(this).data("campo");
          var idtabla = $(this).data("idtabla");
          var contenido = $(this).val();
  
          $.ajax({
            url: urlCompleta+"/GastosGenerales/updateDatosFacturaGasto",
            data: { "tabla": tabla, "campo": campo, "contenido": contenido, "idtabla": idtabla, "id": id },
            type: "POST",
            dataType: "json",
            success: function (result) {
        
                if (result == 1) {
                $('#' + campo).addClass('is-valid');
                setTimeout(function() {
            $('#' + campo).removeClass('is-valid');
                },2000);
                } else {
            Swal.fire({
                title: 'Error',
                text: 'No se han actualizado los datos, comprueba tu conexión',
                icon: 'error',
                confirmButtonText: 'Ok'
            })
            }
        
  
        }
          });        
      }
    });

    $('.actualizadorInputChange').on("change", function () {

      var id = $('#idGasto').val();
      
      if (id != '' && id >0) {
        var tabla = $(this).data("tabla");
        var campo = $(this).data("campo");
        var idtabla = $(this).data("idtabla");        
        var contenido = $('#iban').attr('option', 'selected').val();

        $.ajax({
            url: urlCompleta+"/GastosGenerales/updateDatosFacturaGasto",
            data: { "tabla": tabla, "campo": campo, "contenido": contenido, "idtabla": idtabla, "id": id },
            type: "POST",
            dataType: "json",
            success: function (result) {
        
                if (result == true) {
                $('#' + campo).addClass('is-valid');
                setTimeout(function() {
                  $('#' + campo).removeClass('is-valid');
                },2000);
                } else {
                  Swal.fire({
                      title: 'Error',
                      text: 'No se han actualizado los datos, comprueba tu conexión',
                      icon: 'error',
                      confirmButtonText: 'Ok'
                  })
                }
            
      
            }
        });        
      }
    });

    //8 ELIMINAR TODA LA FACTURA DE GASTO Y SUS ASIGNACIONES
    $(document).on('click','.btnDeleteGastos',function(e) {                 
      var idGasto = $(this).data('idfactura');
      var filaFactura = $(this).closest('tr');
      var bool=confirm("¿Seguro de eliminar el gasto Nº" +idGasto+ "  ?");
      if(bool){  
        $.ajax({
          url: "GastosGenerales/eliminarGasto",
          type: "POST",
          dataType: "json",   
          data: {idGasto:idGasto},        
          success: function(data){                  
            
            if (data == true) {
              filaFactura.remove();
              icon = 'success';
              title = 'Bien!';
              mensaje = 'El registro se ha eliminado corréctamente';
            }else{
              icon = 'error';
              title = 'Hubo un error';
              mensaje = 'No se ha eliminado el registro.';
            }
            Swal.fire({
              title: title,
              icon: icon,
              text: mensaje,
            });
          }
        });
      }
    });


    //9 VER/ EDITAR CUENTAS CONTABLES      
        $(document).on('click','.btnUpdateCtaContable',function(e) {
      
          idCuenta = $(this).attr('data-ctacontable');
          $('#idGasto').val(idCuenta);
          if (idCuenta >0 && idCuenta !='') {
            $('#btnGuardarCuenta').css("display", "none");
          }
    
          $.ajax({
            url: "../GastosGenerales/obtenerCuentaContable",
            type: "POST",
            dataType: "json",
            data: {idCuenta:idCuenta},
            success: function(data){           
              $('input[name=descripcion]').val(data['descripcion']);
              $('input[name=cuentacontable]').val(data['cuentacontable']);             
    
            }       
    
          });
    
          $("#modalAddCuenta").modal("show");
          $(".modal-title").text("Ver/Editar Cuenta Contable"); 
        });

    //10- AL CERRAR EL MODAL, RESETEO LOS INPUTS DEL FORMULARIO DE CTAS CONTABLES
        $(document).on('click','.cerrarModalCtaCtble',function(e) {
          $("#formCrearCuentaContable").trigger('reset');          
          $('#btnGuardarCuenta').css("display", "block");        
        });
    
    //11 ELIMINAR CUENTA CONTABLE
    $(document).on('click','.btnDeleteCtaContable',function(e) {                 
      var idCuenta = $(this).data('idctacontable');
      var cuenta = $(this).data('ctacontable');
      var filaCtaCtble = $(this).closest('tr');
      var bool=confirm("¿Seguro de eliminar la cuenta contable Nº" +cuenta+ "  ?");
      if(bool){  
        $.ajax({
          url: urlCompleta+"/GastosGenerales/eliminarCuentaContable",
          type: "POST",
          dataType: "json",   
          data: {idCuenta:idCuenta, cuenta:cuenta},        
          success: function(data){                  
            
            if (data == true) {
              filaCtaCtble.remove();
              icon = 'success';
              title = 'Bien!';
              mensaje = 'El registro se ha eliminado corréctamente';
            }else{
              icon = 'error';
              title = 'Hubo un error';
              mensaje = 'No se ha eliminado el registro.';
            }
            Swal.fire({
              title: title,
              icon: icon,
              text: mensaje,
            });
          }
        });
      }
    });



    //12 VER/ EDITAR TIPOS DE GASTOS GENERALES      
    $(document).on('click','.btnUpdateTipoGasto',function(e) {      
      idTipo = $(this).attr('data-tipogasto');
      $('#idGasto').val(idTipo);
      if (idTipo >0 && idTipo !='') {
        $('#btnGuardarTipoGasto').css("display", "none");
      }

      $.ajax({
        url: "../GastosGenerales/obtenerTipoGasto",
        type: "POST",
        dataType: "json",
        data: {idTipo:idTipo},
        success: function(data){           
          $('input[name=descripcion]').val(data['descripcion']);
          $('select[name="cuentacontable"]').val(data['cuentacontable']);
          $('.select2').select2({
            theme: 'bootstrap4'
          });
        }       

      });

      $("#modalAddTipoGasto").modal("show");
      $(".modal-title").text("Ver/Editar Tipo de Gasto"); 
    });

    //13- AL CERRAR EL MODAL, RESETEO LOS INPUTS DEL FORMULARIO DE TIPOS DE GASTO
        $(document).on('click','.cerrarModalTipoGasto',function(e) {          
          $("#formCrearTipoGasto").trigger('reset');
          $('#btnGuardarTipoGasto').css("display", "block");  
          $('.select2-selection__rendered').text('Seleccionar...');
          
        });

    //14 ACTUALIZAR AUTOMÁTICAMENTE TIPO DE GASTOS
    $('.actualizadorInputChangeGastos').on("change", function () {

      var id = $('#idGasto').val();
      
      if (id != '' && id >0) {
        var tabla = $(this).data("tabla");
        var campo = $(this).data("campo");
        var idtabla = $(this).data("idtabla");        
        var contenido = $('#cuentacontable').attr('option', 'selected').val();

        $.ajax({
            url: urlCompleta+"/GastosGenerales/updateDatosFacturaGasto",
            data: { "tabla": tabla, "campo": campo, "contenido": contenido, "idtabla": idtabla, "id": id },
            type: "POST",
            dataType: "json",
            success: function (result) {
        
                if (result == true) {
                $('#' + campo).addClass('is-valid');
                setTimeout(function() {
                  $('#' + campo).removeClass('is-valid');
                },2000);
                } else {
                  Swal.fire({
                      title: 'Error',
                      text: 'No se han actualizado los datos, comprueba tu conexión',
                      icon: 'error',
                      confirmButtonText: 'Ok'
                  })
                }
            
      
            }
        });        
      }
    });


    //15 ELIMINAR TIPO DE GASTO
    $(document).on('click','.btnDeleteTipoGasto',function(e) {                 
      var idTipo = $(this).data('idtipogasto');
      var tipo = $(this).data('tipogasto');
      var filaTipoGasto = $(this).closest('tr');
      var bool=confirm("¿Seguro de eliminar el tipo de Gasto: " +tipo+ "  ?");
      if(bool){  
        $.ajax({
          url: urlCompleta+"/GastosGenerales/eliminarTipoGasto",
          type: "POST",
          dataType: "json",   
          data: {idTipo:idTipo, tipo:tipo},        
          success: function(data){                  
            
            if (data == true) {
              filaTipoGasto.remove();
              icon = 'success';
              title = 'Bien!';
              mensaje = 'El registro se ha eliminado corréctamente';
            }else{
              icon = 'error';
              title = 'Hubo un error';
              mensaje = 'No se ha eliminado el registro.';
            }
            Swal.fire({
              title: title,
              icon: icon,
              text: mensaje,
            });
          }
        });
      }
    });




  }

})