$(document).ready(function() {

    if (window.location.pathname.includes('/datatable/colaboradores')) {
        /* Añdir cajas de busqueda a las cabeceras */    
        $('#colaboradores thead th').each(function() {
            var title = $(this).text();
            $(this).html(title+'</br><input type="text" class="col-search-input" style="margin-top:10px;" placeholder="" />');
        });


        let colaboradores = $('#colaboradores').DataTable( {
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
            var column = colaboradores.column( $(this).attr('data-column') );
                    // Toggle the visibility
            column.visible( ! column.visible() );
        } );
        $.fn.dataTable.ext.errMode = 'none';
        $('#colaboradores').on( 'error.dt', function ( e, settings, techNote, message ) {
            console.log( 'An error has been reported by DataTables: ', message );
        } ) .DataTable();
        $('#colaboradores').DataTable();


        //------------- 

        $(".updateColaborador").on("click", function(e){
            e.preventDefault();
            //$('#idEmpresaEdit').empty(); 
            var id = $(this).data('id');
            
            $('[name="codColaborador"]').val(id);   
        
            $.ajax({
                type: 'POST',
                url: '../Datatable/getColaboradorUpdate',
                data: { 'id': id },
                dataType: "JSON" 
            }).done(function (data) {
                //data = JSON.parse(data);      
                //data = data[0];
                let data1 = data['colaborador'][0];
                let data2 = data['clientes'][0];
            
                $('#idColaborador').val(data1["idColaborador"]);
                $('#codTipoColEdit').val(data1["codTipoCol"]);
                $('#NifColaboradorEdit').val(data1["NifColaborador"]);
                $('#idEmpresaEdit').val(data2["idEMPRESA"]);
                $('#margencomercialEdit').val(data1["margencomercial"]);
                $('#NombreComercialEdit').val(data1["NombreComercial"]);
                $('#RazonSocialEdit').val(data1["RazonSocial"]);
                $('#DireccionEdit').val(data1["Direccion"]);
                $('#codigopostalEdit').val(data1["codigopostal"]);
                $('#LocalidadEdit').val(data1["Localidad"]);
                $('#provinciaEdit').val(data1["provincia"]);
                $('#numcuentaEdit').val(data1["numcuenta"]);
                $('#ContactocolaboradorEdit').val(data1["Contactocolaborador"]);
                $('#telefonocolaboradorEdit').val(data1["telefonocolaborador"]);
                $('#movilcolaboradorEdit').val(data1["movilcolaborador"]);
                $('#emailcolaboradorEdit').val(data1["emailcolaborador"]);
                $('#webcolaboradorEdit').val(data1["webcolaborador"]);
                $('#observacionesEdit').val(data1["observaciones"]);
                $('.select2').select2({
                    theme: 'bootstrap4'
                });
            }).fail(function (xhr,errorText,err) {
                //console.log(errorText,err);
                console.log('Hubo un error al cargar los datos del cliente.');
            });
            //
            $('#ModalUpdateColaborador').modal('show');   
        });

        $("#btnModalVinBtn").on("click", function(){
            $('#modalVincularColaborador').modal('show');

        });

        $(document).on("click", ".deleteColaborador", function(e){
            e.preventDefault();
            var id = $(this).data('id');
            $('[name="id"]').val(id);
            $('#ModalDeleteColaborador').modal('show');        
        });

        /*$(document).on('change',"#codTipoCol", function () {
                    
            var idTipo = $(this).attr('option', 'selected').val();
            var metodo = '';
            if (idTipo == 0) {
                metodo = "Agentes" ;
            }else if (idTipo == 1) {
                metodo = "Profesores";
            }else if (idTipo == 2) {
                metodo = "Asesores";
            }else if (idTipo == 3) {
                metodo = "Proveedores";
            }else if (idTipo == 4) {
                metodo = "Clientes";
            }else if (idTipo == 5) {
                metodo = "CentroFormacion"; //falta para este, no tengo tabla
            }*/

            /*$.ajax({
                type: "POST",
                //url: "Presupuesto/getAccionSelect",
                url: "../Datatable/getDatosSelect",
                data: { 'tipo': metodo },
                dataType: "JSON",           
            }).done(function (data) {
                var tipoRpta = data[0];
                var contentRpta = data[1];
                $('#idColaborador').empty();           

                for (let index = 0; index < data[1].length; index++) {
                    
                    if (tipoRpta == 'agentes') {
                        $('#idColaborador').append('<option value="' + contentRpta[index]['codagente'] + '">' + contentRpta[index]['Nombre'] + ' ' + contentRpta[index]['Apellidos'] + '</option>');
                    }else if (tipoRpta == 'profesores') {
                        $('#idColaborador').append('<option value="' + contentRpta[index]['idPROFESOR'] + '">' + contentRpta[index]['NOMBRECOMERCIAL'] + '</option>');                    
                    }else if (tipoRpta == 'asesores') {
                        $('#idColaborador').append('<option value="' + contentRpta[index]['idAsesor'] + '">' + contentRpta[index]['nomasesor'] + '</option>');                    
                    }else if (tipoRpta == 'proveedores') {
                        $('#idColaborador').append('<option value="' + contentRpta[index]['idPROVEEDOR'] + '">' + contentRpta[index]['NOMBRECOMERCIAL'] + '</option>');                    
                    }else if (tipoRpta == 'clientes') {
                        $('#idColaborador').append('<option value="' + contentRpta[index]['idEMPRESA'] + '">' + contentRpta[index]['NOMBREJURIDICO'] + '</option>');                    
                    }
                    
                }
            }).fail(function (xhr,errorText,err) {
                //console.log(errorText,err);
                console.log('Hubo un error al cargar los datos del cliente.');
            });

        });*/

    }

} );
