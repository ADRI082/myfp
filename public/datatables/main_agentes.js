$(document).ready(function() {

    if (window.location.pathname.includes('/datatable/agentes')) {

        /* Añdir cajas de busqueda a las cabeceras */
        $('#agentes thead th').each(function() {
            var title = $(this).text();
            $(this).html(title+'</br><input type="text" class="col-search-input" style="margin-top:10px;" placeholder="" />');
        });

        let agentes = $('#agentes').DataTable({
            "responsive": true ,
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

            ],
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
        });
   
        //Hide-show datatable columns
        $('a.toggle-vis').on( 'click', function (e) {
            e.preventDefault();
            // Get the column API object
            var column = agentes.column( $(this).attr('data-column') );
                    // Toggle the visibility
            column.visible( ! column.visible() );
        } );
        $.fn.dataTable.ext.errMode = 'none';
        $('#agentes').on( 'error.dt', function ( e, settings, techNote, message ) {
            console.log( 'An error has been reported by DataTables: ', message );
        } ) .DataTable();
        $('#agentes').DataTable();

                //-----
        //Editar
        var fila;    
        $(document).on("click", ".btnEditar", function(e){        
            e.preventDefault();
            fila = $(this).closest("tr");	        
            codagente = parseInt(fila.find('td:eq(0)').text()); //capturo el codagente            
            DNIAgente = fila.find('td:eq(1)').text();
            Nombre = fila.find('td:eq(2)').text();
            Apellidos = fila.find('td:eq(3)').text();
            Direccion = fila.find('td:eq(4)').text();
            Localidad = fila.find('td:eq(5)').text();
            movil = fila.find('td:eq(6)').text();
            puesto = fila.find('td:eq(7)').text();
            rol = fila.find('td:eq(8)').text();
            password = fila.find('td:eq(9)').text();
            //muestro los datos en el modal para edición
            $("#codagente").html(codagente);
            $("#DNIAgente").val(DNIAgente);
            $("#Nombre").val(Nombre);
            $("#Apellidos").val(Apellidos);
            $("#Direccion").val(Direccion);
            $("#Localidad").val(Localidad);
            $("#movil").val(movil);
            $("#puesto").val(puesto);
            //$("#rol option[value=" + rol + "]").attr("selected", true);
            $("#rol > option[value='"+ rol +"']").attr("selected", "selected");
            $("#rol2").val(rol);
            $("#password").val(password);
            //$(".modal-header").css("color", "white" );
            $(".modal-title").text("Editar Agente");		
            $('#modalCRUD').modal('show');
            //alert(movil);
        });

        //----- 

        //tileselect para vincular agentes a un cliente
        tail.select('#cliente',{
            search: true,
            locale: "es",
            multiSelectAll: true,
            searchMinLength: 0,
            multiContainer: false,
        });

        $(".deleteAgente").on("click", function(e){
            e.preventDefault();        
            var id = $(this).data('id');
            //alert(id);
            $('[name="id"]').val(id);
            $('#ModalDeleteAgente').modal('show');
        });

        $(".updateAgente").on("click", function(e){
            e.preventDefault();
            //$('#clienteEdit').empty(); 
            var id = $(this).data('id');
            $('[name="codagente"]').val(id);           
            //
            $.ajax({
                type: 'POST',
                url: '../Datatable/getAgenteUpdate',
                data: { 'id': id },
                dataType: "JSON" 
            }).done(function (data) {
                //data = JSON.parse(data);      
                //data = data[0];
                let data1 = data['agente'][0];
                let data2 = data['clientes'];
                
                $('#idAgente').val(data1["codagente"]);
                $('#DNIAgenteEdit').val(data1["DNIAgente"]);
                $('#NombreEdit').val(data1["Nombre"]);
                $('#ApellidosEdit').val(data1["Apellidos"]);
                $('#numcuentadEdit').val(data1["numcuenta"]);
                $('#DireccionEdit').val(data1["Direccion"]);
                $('#LocalidadEdit').val(data1["Localidad"]);
                $('#provinciaEdit').val(data1["provincia"]);
                $('#codigopostalEdit').val(data1["codigopostal"]);
                $('#telefonoEdit').val(data1["telefono"]);
                $('#movilEdit').val(data1["movil"]);
                $('#rolEdit').val(data1["idRol"]);
                $('#puestoEdit').val(data1["puesto"]);
                $('#departamentoEdit').val(data1["codfuncional"]);
                $('#emaildEdit').val(data1["mail"]);
                $('#passwordEdit').val(data1["password"]);
                $('#observacionesEdit').val(data1["observaciones"]);
                $('#regimenEdit').val(data1["regimen"]);
                $('#fechaInicioEdit').val(data1["fechaInicio"]);
                $('#fechaFinEdit').val(data1["fechaFin"]);


                for (let index = 0; index < data2.length; index++) {
                    $('#clienteEdit').append('<option value="' + data2[index]['idEMPRESA'] + '">' + data2[index]['NOMBREJURIDICO'] + '</option>');
                }                     
            }).fail(function (xhr,errorText,err) {
                //console.log(errorText,err);
                console.log('Hubo un error al cargar los datos del cliente.');
            });
            //
            $('#ModalUpdateAgente').modal('show');   
        });    
    
    }
        

});
