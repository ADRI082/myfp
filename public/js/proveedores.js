$(document).ready(function () {

    var urlCompleta = "http://localhost/myfp";


    $('#addProveedor').on('click', function () {

        let modal = $(this).data('modal');

        if (modal != '') {
            $('#' + modal).modal('toggle');
        }

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "http://localhost/myfp/Proveedores/obtenerDatosSelects",
            success: function (datos) {

                for (let index = 0; index < datos['proveedores'].length; index++) {

                    let opciones = {
                        id: datos['proveedores'][index]['idTipo'],
                        text: datos['proveedores'][index]['tipo']
                    };
                    let newOption = new Option(opciones.text, opciones.id, true, true);
                    $('#tipoProveedor').append(newOption).trigger('change');
                }

                for (let index = 0; index < datos['plazos'].length; index++) {

                    let opciones = {
                        id: datos['plazos'][index]['CODFORMAPAGO'],
                        text: datos['plazos'][index]['DESFORMAPAGO']
                    };
                    let newOption = new Option(opciones.text, opciones.id, true, true);
                    $('#plazoPagoProveedor').append(newOption).trigger('change');
                }
            }
        });

    })

    $('#btnAddProveedor').on('click', function () {

        let modal = $(this).data('modal');


        form = $('#formAddProveedor').serializeArray();

        for (let index = 2; index <= 3; index++) {
      
            if(form[index]["value"] == ""){
              alert("Campo " + form[index]["name"] + " no puede estar vacio" );
              return;
            }
        }

        $.ajax({
            type: "POST",
            dataType: "json",
            url: urlCompleta + "/Proveedores/addProveedor",
            data: { form: form },
            success: function (datos) {
                Swal.fire({
                    text: 'Se ha guardado corréctamente el proveedor',
                    icon: 'success',
                    confirmButtonText: 'Ok'
                });

                $('#' + modal).modal('toggle');

                window.location.reload();
            }
        });

    })


    $('.editarProveedores').on('click', function () {

        let modal = $(this).data('modal');

        if (modal != '') {
            $('#' + modal).modal('toggle');
        }

        filaProveedor = $(this).closest("tr");
        idProveedor = parseInt(filaProveedor.find('td:eq(0)').text());

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "http://localhost/myfp/Proveedores/cargarDatosProveedorById",
            data: { idProveedor },
            success: function (datos) {

                for (let index = 0; index < datos['proveedores'].length; index++) {

                    let opciones = {
                        id: datos['proveedores'][index]['idTipo'],
                        text: datos['proveedores'][index]['tipo']
                    };

                    if (opciones.id == datos['proveedor'].TIPODEPROVEEDOR) {
                        let newOption = new Option(opciones.text, opciones.id, true, true);
                        $('#tipoProveedorEdit').append(newOption).trigger('change');
                    } else {
                        let newOption = new Option(opciones.text, opciones.id, false, false);
                        $('#tipoProveedorEdit').append(newOption).trigger('change');
                    }

                }

                for (let index = 0; index < datos['plazos'].length; index++) {

                    let opciones = {
                        id: datos['plazos'][index]['CODFORMAPAGO'],
                        text: datos['plazos'][index]['DESFORMAPAGO']
                    };

                    if (opciones.id == datos['proveedor'].CODFORMAPAGO) {
                        let newOption = new Option(opciones.text, opciones.id, true, true);
                        $('#plazoPagoProveedorEdit').append(newOption).trigger('change');
                    } else {
                        let newOption = new Option(opciones.text, opciones.id, false, false);
                        $('#plazoPagoProveedorEdit').append(newOption).trigger('change');
                    }

                }

                $('#idProveedorEdit').val(datos['proveedor'].idPROVEEDOR);
                $('#nombreComercialEdit').val(datos['proveedor'].NOMBRECOMERCIAL);
                $('#cifProveedorEdit').val(datos['proveedor'].CIFPROVEEDOR);
                $('#razonSocialEdit').val(datos['proveedor'].PERSONAJURIDICA);
                $('#personaContacto1Edit').val(datos['proveedor'].PERSONACONTACTO1);
                $('#personaContacto2Edit').val(datos['proveedor'].PERSONACONTACTO2);
                $('#direccionProveedorEdit').val(datos['proveedor'].DIRECCION);
                $('#poblacionProveedorEdit').val(datos['proveedor'].POBLACION);
                $('#provinciaProveedorEdit').val(datos['proveedor'].PROVINCIA);
                $('#codPostalProveedorEdit').val(datos['proveedor'].CODPOSTAL);
                $('#telefonoFijoProveedorEdit').val(datos['proveedor'].TELEFONOFIJO);
                $('#movilProveedorEdit').val(datos['proveedor'].TELEFONOMOVIL);
                $('#faxProveedorEdit').val(datos['proveedor'].FAX);
                $('#emailProveedorEdit').val(datos['proveedor'].EMAIL);
                $('#webProveedorEdit').val(datos['proveedor'].WEB);
                $('#numCuentaCorrienteProveedorEdit').val(datos['proveedor'].NUMCUENTA);
                $('#enlaceProveedorEdit').val(datos['proveedor'].enlace);
                $('#observacionesProveedoresEdit').val(datos['proveedor'].OBSERVACIONES);

            }
        });

    })

    $(document).on('focusout', '.campotabla', function () {

        let idProveedor = $('#idProveedorEdit').val();

        let tabla = $(this).data('tabla');
        let campo = $(this).attr('name');
        let pk = $(this).data('pk');
        let valor = $(this).val();

        $.ajax({
            url: urlCompleta + '/Proveedores/editarProveedor',
            type: "POST",
            data: { idProveedor: idProveedor, tabla: tabla, campo: campo, valor: valor, pk: pk },
            success: function (respuesta) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: 'Actualizado Correctamente!'
                })
            },

            error: function () {
                console.log("No se ha podido actualizar el dato, intente de nuevo");
            }
        });

    });


$(document).on('change', '.selectEdit', function () {

        let idProveedor = $('#idProveedorEdit').val();

        let tabla = $(this).data('tabla');
        let campo = $(this).attr('name');
        let pk = $(this).data('pk');
        let valor = $(this).val();

        $.ajax({
            url: urlCompleta + '/Proveedores/editarProveedor',
            type: "POST",
            data: { idProveedor: idProveedor, tabla: tabla, campo: campo, valor: valor, pk: pk },
            success: function (respuesta) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: 'Actualizado Correctamente!'
                })
            },

            error: function () {
                console.log("No se ha podido actualizar el dato, intente de nuevo");
            }
        });

    });


    $(document).on('click', '.deleteProveedor ', function () {

        filaProveedor = $(this).closest("tr");
        idProveedor = parseInt(filaProveedor.find('td:eq(0)').text());

        Swal.fire({
            title: 'Estás seguro?',
            text: "Una vez que lo elimines, no podrás revertir el cambio!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: urlCompleta + '/Proveedores/deleteProveedor',
                    type: "POST",
                    data: {idProveedor},
                    success: function (respuesta) {
                        Swal.fire({
                            text: 'Se ha eliminado corréctamente el proveedor',
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
                Swal.fire(
                    'Borrado!',
                    'Tu proveedor ha sido eliminado correctamete.',
                    'success'
                )
            }
            window.location.reload();
        })


        

    });






});