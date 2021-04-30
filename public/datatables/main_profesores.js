$(document).ready(function() {

    if (window.location.pathname.includes('/datatable/profesores')) {

        var urlCompleta = $('#ruta').val();

        /* Añdir cajas de busqueda a las cabeceras */    
        $('#profesores thead th').each(function() {
            var title = $(this).text();
            $(this).html(title+'</br><input type="text" class="col-search-input" style="margin-top:10px;" placeholder="" />');
        });


        let profesores = $('#profesores').DataTable( {
            "responsive": true,
            "autoWidth": true,
            "dom": 'lBfrtip',
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
                });
            }

        }); //fin datatables

        //Hide-show datatable columns
        $('a.toggle-vis').on( 'click', function (e) {
            e.preventDefault();
            // Get the column API object
            var column = profesores.column( $(this).attr('data-column') );
                    // Toggle the visibility
            column.visible( ! column.visible() );
        } );
        $.fn.dataTable.ext.errMode = 'none';
        $('#profesores').on( 'error.dt', function ( e, settings, techNote, message ) {
            console.log( 'An error has been reported by DataTables: ', message );
        } ) .DataTable();
        $('#profesores').DataTable();


        
        $(".selectorAuto").on("change", function(e){
            idProfesor = $('#idProfesor').val();            
            campo = $(this).data('campo');                   
            opcion = $('#'+campo).attr('option', 'selected').val();    
            campoadd = $(this).data('campoadd');

            var fila = "<tr><td><input class='inputSinBorde' name='"+campo+"[]' value='"+opcion+"'></td>"+
                        "<td><i class='fa fa-trash eliminar_"+campo+"' style='color:red; font-size:0.8rem;'></i></td></tr>";            

            if (!idProfesor) {
                $('#tabla_'+campo).append(fila);
                $('.selectorAuto').val('Seleccionar');
            }else{                
                $.ajax({
                    url: urlCompleta+"/Datatable/addAjaxProfesores",
                    type: "POST",
                    dataType: "json",   
                    data: {idProfesor:idProfesor, opcion:opcion, campoadd:campoadd},    
                    success: function(data){
                      if (data == true) {
                        $('#tabla_'+campo).append(fila);
                        $('.selectorAuto').val('Seleccionar');         
                      }                     
                    }
                });
            }

        });

        $(document).on("click", ".eliminar_permisoConducir", function(e){     
            var filaDel = $(this).closest('tr');   
            idProfesor = $('#idProfesor').val();
            permiso = filaDel.find('td:eq(0)').text(); 
            campoUpd = 'PERMISODECONDUCIR';             
            if (!idProfesor) {                               
                filaDel.remove();
            }else{                
                $.ajax({
                    url:  urlCompleta+"/Datatable/removeAjaxProfesores",
                    type: "POST",
                    dataType: "json",   
                    data: {idProfesor:idProfesor, permiso:permiso, campoUpd:campoUpd},    
                    success: function(data){
                      if (data == true) {
                        filaDel.remove();              
                      }                     
                    }
                });                                         
            }
        });
        $(document).on("click", ".eliminar_disponibilidad", function(e){            
            var filaDel = $(this).closest('tr');
            campoUpd = 'DISPONIBILIDAD';  
            idProfesor = $('#idProfesor').val();           
            permiso = filaDel.find('td:eq(0)').text();
            if (!idProfesor) {             
                filaDel.remove();
            }else{
                $.ajax({
                    url:  urlCompleta+"/Datatable/removeAjaxProfesores",
                    type: "POST",
                    dataType: "json",   
                    data: {idProfesor:idProfesor, permiso:permiso, campoUpd:campoUpd},    
                    success: function(data){
                      if (data == true) {
                        filaDel.remove();              
                      }                     
                    }
                });                
            }
        });
        $(document).on("click", ".eliminar_idiomas", function(e){            
            idProfesor = $('#idProfesor').val();           
            var filaDel = $(this).closest('tr');  
            permiso = filaDel.find('td:eq(0)').text();
            campoUpd = 'IDIOMAS';     
            if (!idProfesor) {             
                filaDel.remove();
            }else{
                $.ajax({
                    url:  urlCompleta+"/Datatable/removeAjaxProfesores",
                    type: "POST",
                    dataType: "json",   
                    data: {idProfesor:idProfesor, permiso:permiso, campoUpd:campoUpd},    
                    success: function(data){
                      if (data == true) {
                        filaDel.remove();              
                      }                     
                    }
                }); 
            }
        });
        $(document).on("click", ".eliminar_informatica", function(e){            
            idProfesor = $('#idProfesor').val();           
            var filaDel = $(this).closest('tr');   
            permiso = filaDel.find('td:eq(0)').text();
            campoUpd = 'INFORMATICA';   
            if (!idProfesor) {             
                filaDel.remove();
            }else{
                $.ajax({
                    url:  urlCompleta+"/Datatable/removeAjaxProfesores",
                    type: "POST",
                    dataType: "json",   
                    data: {idProfesor:idProfesor, permiso:permiso, campoUpd:campoUpd},    
                    success: function(data){
                      if (data == true) {
                        filaDel.remove();              
                      }                     
                    }
                }); 
            }
        });
        $(document).on("click", ".eliminar_perfilFormador", function(e){            
            idProfesor = $('#idProfesor').val();           
            var filaDel = $(this).closest('tr');   
            permiso = filaDel.find('td:eq(0)').text();
            campoUpd = 'perfil';   
            if (!idProfesor) {             
                filaDel.remove();
            }else{
                $.ajax({
                    url:  urlCompleta+"/Datatable/removeAjaxProfesores",
                    type: "POST",
                    dataType: "json",   
                    data: {idProfesor:idProfesor, permiso:permiso, campoUpd:campoUpd},    
                    success: function(data){
                      if (data == true) {
                        filaDel.remove();              
                      }                     
                    }
                }); 
            }
        });

        $(document).on("click", ".deleteProfesor", function(e){
            e.preventDefault();
            var id = $(this).data('id');
            var nombre = $(this).data('nombre');
            $('[name="id"]').val(id);
            $('#nombreProfesor').text(id+" - " +nombre);
            $('#ModalDeleteProfesor').modal('show');        
        });

    }

} );
