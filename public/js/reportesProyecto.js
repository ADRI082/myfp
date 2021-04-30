$(document).ready(function () {

  var grupo = $(".grupo");
  $(grupo).on('change',function(){
    let id = $(this).attr('option', 'selected').val();
     $.ajax({
      type: "POST",
      data: {
        id: id
      },
      url: "SegPresupuesto/getClienteSelect",
      success: function (respuesta) {   
       
        $(".empresa").html(respuesta);           
      }
    });
    
  });
  var servicio = $(".servicio");
  $(servicio).on('change',function(){
    let id = $(this).attr('option', 'selected').val();
     $.ajax({
      type: "POST",
      data: {
        id: id
      },
      url: "SegPresupuesto/getAccionSelect",
      success: function (respuesta) {
        $(".accion").html(respuesta);           
      }
    });
    
  });

  // ---------------------------------
  $("#btnBuscadorDatosFacturas").on("click", function (e) {
        e.preventDefault();
        var tipoReporte = $('#tipoReporte').val();
        var periodo = $('#periodo').val();
        var tipo = $('.tipo').val();
        var grupo = $('.grupo').val();
        var estado = $('#estado').val();
        var concepto = $('#concepto').val();
        var empresa = $('.empresa').val();
        var servicio = $('.servicio').val();
        var accion = $('.accion').val();
        var desde = $('#desde').val();
        var hasta = $('#hasta').val();
        var importeMin = $('#importeMin').val();
        var importeMax = $('#importeMax').val();
        var agente = $('#agente').val();
        var colaborador = $('#colaborador').val();
        // enviamos por ajax al controlador segPresupuesto/resultadoBuscador los datos del formulario para la busqueda
        $.ajax({
          type: "POST",
          url: "recibeFiltros",
          data: {
            tipoReporte:tipoReporte,periodo:periodo,tipo:tipo,grupo:grupo,estado:estado,concepto:concepto, empresa:empresa,
            servicio:servicio, accion:accion, desde:desde, hasta:hasta, importeMin:importeMin, importeMax:importeMax,agente:agente, colaborador:colaborador
          },
          success: function (response) {
              $("#respuesta").html(response);
            
              $(".clickable-row").on("click",function() {
                window.open($(this).attr('data-href'), $(this).attr('data-target'));    
              });
        
              let id = $('#table_facturas').DataTable({

                'responsive'  : true,
                "order": [[1, 'desc']],
                'dom'         : 'lBfrtip',
                  /* codigo para ejecutar la busqueda por columna de la tabla */
                "buttons":
                          [
                            /*{
                              /*"extend": 'excelHtml5',
                              "text": '<i class="fas fa-file-excel" style="color:green;"></i>',
                              "titleAttr": 'Exportar a Excel',
                              "className": 'btn btn-success',
                                  format: {
                                    body: function(data, row, column, node) {
                                      data = $('<p>' + data + '</p>').text();
                                      data = data.replace('.', '')
                                      return $.isNumeric(data.replace(',', '.')) ? data.replace(',', '.') : data;
                                    }
                                  }
                            }*/
                          ]
              });
  
              $('#table_facturas').css('visibility','visible');
    
              $.fn.dataTable.ext.errMode = 'none';
              $('#table_facturas').on( 'error.dt', function ( e, settings, techNote, message ) {
                console.log( 'An error has been reported by DataTables: ', message );
              }) .DataTable();
              $('#table_facturas').DataTable();
      
          }
        }); // end of ajax
       
  }); // end of click

   
}); // end of ready
