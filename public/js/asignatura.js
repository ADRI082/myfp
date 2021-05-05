if (window.location.pathname.includes('/Asignaturas')) {



    $(document).on('click', '#addFichero', function () {

        idAsignatura = $('#idAsignatura').val();


        $.ajax({
            type: "POST",
            data: {
                'idAsignatura': idAsignatura
            },
            dataType: 'json',
            url: "../../myfp/Asignaturas/obtenerBloquesAsignatura",
            success: function (respuesta) {

                console.log(respuesta);


                for (let index = 0; index < respuesta.length; index++) {
                    // tail.select('#idEmpleadoBD').options.add("'" + data[index]['Id'] + "'", data[index]['informacion'], "", false, false, false, true);

                    let opciones = {
                        id: respuesta[index]['idBloques'],
                        text: respuesta[index]['nombre']
                    };

                    let newOption = new Option(opciones.text, opciones.id, false, false);
                    $('#selectBloque').append(newOption);
                }

            }
        });



    })


    $(document).on('click', '#btnGuardarFichero', function (e) {

        e.preventDefault();

        idAsignatura = $('#idAsignatura').val();

        idBloque = $('#selectBloque').val();

        fd = new FormData();
        fd.append('fichero', $('#ficheroSubida')[0].files[0]);
        fd.append('idAsignatura', idAsignatura);
        fd.append('idBloque', idBloque);



        $.ajax({
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data:fd,
            url: "../../myfp/Asignaturas/guardarFichero",
            success: function (respuesta) {

            }
        });



    });



}