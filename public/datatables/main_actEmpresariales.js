$(document).ready(function() {

    if (window.location.pathname.includes('/cuentasBancarias')) {
        //solo he codificado el listar cuentas falta el resto del CRUD

        $('#cuentasBancarias thead th').each(function() {
            var title = $(this).text();
            $(this).html(title+'</br><input type="text" class="col-search-input" style="margin-top:10px;" placeholder="" />');
        });

        let actEmpresariales = $('#cuentasBancarias').DataTable( {
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
                }); }

        } );

        //Hide-show datatable columns
        $('a.toggle-vis').on( 'click', function (e) {
            e.preventDefault();
            // Get the column API object
            var column = actEmpresariales.column( $(this).attr('data-column') );
                    // Toggle the visibility
            column.visible( ! column.visible() );
        } );
        $.fn.dataTable.ext.errMode = 'none';
        $('#cuentasBancarias').on( 'error.dt', function ( e, settings, techNote, message ) {
            console.log( 'An error has been reported by DataTables: ', message );
        } ) .DataTable();
        $('#cuentasBancarias').DataTable();


        //------------- 

        $(".updateActEmpresariales").on("click", function(e){
            e.preventDefault();
            //$('#idEmpresaEdit').empty(); 
            var id = $(this).data('id');
            $('[name="idActividad"]').val(id);
        
            $.ajax({
                type: 'POST',
                url: '../Datatable/getActEmpresarialUpdate',
                data: { 'id': id },
                dataType: "JSON" 
            }).done(function (data) {                      
                $('#codCnaeEdit').val(data["CODCNAE"]);
                $('#desActividadEdit').val(data["DESACTIVIDAD"]);
                $('#observacionesActEdit').val(data["OBSACTIVIDAD"]);
                $('#enlaceActEdit').val(data["ENLACEWEB"]);           
            }).fail(function (xhr,errorText,err) {
                //console.log(errorText,err);
                console.log('Hubo un error al cargar los datos del cliente.');
            });
            //
            $('#ModalUpdateActEmpresarial').modal('show');   
        });

        $(document).on("click", ".deleteActividad", function(e){
            e.preventDefault();
            var id = $(this).data('id');
            $('[name="id"]').val(id);
            $('#ModalDeleteActividad').modal('show');        
        });

    }

} );
