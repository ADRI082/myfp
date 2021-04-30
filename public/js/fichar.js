
$(document).ready(function () {
   
      
        var urlCompleta = $('#ruta').val();

        $('.ficharEntrada').on('click', function () {
            idAgente = $('#idAgente').val();
            
            tipo = 'entrada';

            $.ajax({
                type: "POST",
                data: {
                  'idAgente': idAgente, 'tipo': tipo
                },
                url: urlCompleta+"/RecursosHumanos/fichar",
                success: function (respuesta) {
                  respuesta = JSON.parse(respuesta);            
                  if (respuesta == 'false') {                          
                    alert('No se ha podido realizar el registro. Inténtelo nuevamente.');                                                
                  }else{                      
                    alert('Se ha realizado el registro.');
                  }
                  //cerrar el modal
                  $('#ficharEntradaModal').modal('hide');                  
                }
              });   
        });

        $('.ficharSalida').on('click', function () {
            idAgente = $('#idAgente').val();
            tipo = 'salida';
            
            $.ajax({
                type: "POST",
                data: {
                  'idAgente': idAgente, 'tipo': tipo
                },
                 url: urlCompleta+"/RecursosHumanos/fichar",
                success: function (respuesta) {
                  respuesta = JSON.parse(respuesta);            
                  if (respuesta == 'false') {                          
                    alert('No se ha podido actualizar la factura. Inténtelo nuevamente.');                                                  
                  }else{                      
                    alert('Se ha realizado el registro.');
                  }
                  //cerrar el modal
                  $('#ficharSalidaModal').modal('hide');                                                
                }
              });   
        });




});