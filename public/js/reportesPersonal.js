$(document).ready(function () {

  if (window.location.pathname.includes('/reportesPersonal')) {

    $("#btnBuscadorDatosPersonal").on("click", function (e) {
          e.preventDefault();
          var desde = $('#desde').val();
          var hasta = $('#hasta').val();    
          var agente = $('#agente').val();          
          $.ajax({
            type: "POST",
            url: "recibeFiltros",
            data: {              
              desde:desde, hasta:hasta,agente:agente
            },
            success: function (response) {
                $("#respuesta").html(response);              
                $(".clickable-row").on("click",function() {
                  window.open($(this).attr('data-href'), $(this).attr('data-target'));    
                });
          
                let id = $('#table_registroPersonal').DataTable({

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
    
                $('#table_registroPersonal').css('visibility','visible');
      
                $.fn.dataTable.ext.errMode = 'none';
                $('#table_registroPersonal').on( 'error.dt', function ( e, settings, techNote, message ) {
                  console.log( 'An error has been reported by DataTables: ', message );
                }) .DataTable();
                $('#table_registroPersonal').DataTable();
        
            }
          }); // end of ajax
        
    }); // end of click
  
  }

   
}); // end of ready
