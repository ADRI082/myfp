if (window.location.pathname.includes('/Asignaturas')) {

    $(document).ready(function () {

        idAsignatura = $('#idAsignatura').val();

        $.ajax({
            type: "POST",
            data: {idAsignatura:idAsignatura},
            dataType:'json',
            url: "../../myfp/Asignaturas/comprobarFavorito",
            success: function (respuesta) {

                console.log(respuesta);

                if(respuesta){
                    $("#addFavorito").html('Eliminar de favoritos <i class="fas fa-heart-broken"></i>');
                    $('#favorito').val(1);
                }
            }
        });

        cargarDataTable(idAsignatura);

        $('#tablaDocumentos').show();

    })



    $(document).on('click', '#addFichero', function () {

        idAsignatura = $('#idAsignatura').val();

        $("#selectBloque").empty().trigger('change')


        $.ajax({
            type: "POST",
            data: {
                'idAsignatura': idAsignatura
            },
            dataType: 'json',
            url: "../../myfp/Asignaturas/obtenerBloquesAsignatura",
            success: function (respuesta) {    

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
            data: fd,
            url: "../../myfp/Asignaturas/guardarFichero",
            success: function (respuesta) {

            }
        });

        $('#modalSubidaFichero').modal('hide');

        $('#tablaDocumentos').dataTable().fnDestroy();

        cargarDataTable(idAsignatura);

        $('#tablaDocumentos').show();


    });

    $(document).on('click', '.descargar', function (e) {

        e.preventDefault();

        filaDocProyecto = $(this).closest("tr");
        idAsignatura = $('#idAsignatura').val(); //capturo el id
        idArchivo =  filaDocProyecto.find('td:eq(0)').text();
        nombreFichero = filaDocProyecto.find('td:eq(1)').text();

        $.ajax({
            type: "POST",
            data: {idArchivo:idArchivo},
            url: "../../myfp/Asignaturas/insertarDescarga",
            success: function () {
            }
        });
        
        //window.open("dist/documentosficherosFactura/" + idfactura + "_" + nombreFichero);
        window.open("public/documentos/ficheros/" + idAsignatura + "_" + nombreFichero);
    });

    function cargarDataTable(idAsignatura) {

        $('#tablaDocumentos').DataTable({
            "processing": true,
            "serverSide": false,
            "ajax": {
                "url": "http://localhost/myfp/Asignaturas/getDocumentosByIdAsignatura",
                "type": "POST",
                dataSrc: "",
                "data": {
                    idAsignatura: idAsignatura
                }
            },
            columns: [
                { data: "idArchivos" },
                { data: "nombre" },
                { data: "fechaSubida" },
                { data: "bloque" },
                { "defaultContent": "<a class='btn btn-success btn-xs descargar'> <i class='fas fa-download'></i></a" },
            ],
            columnDefs: [
                {
                    className: 'dt-center',
                    "targets": "_all"
                }
            ]
        });


    }

    $(document).on('click', '#addFavorito', function (e) {

        e.preventDefault();

        if($('#favorito').val()==0){
            $("#addFavorito").html('Eliminar de favoritos <i class="fas fa-heart-broken"></i>');
            $('#favorito').val(1);
        }else{
            $("#addFavorito").html('A??adir a favoritos <i class="fas fa-heart"></i>');
            $('#favorito').val(0);
        }

        favorito = $('#favorito').val();
        idAsignatura = $('#idAsignatura').val();


        $.ajax({
            type: "POST",
            data: {favorito:favorito,idAsignatura:idAsignatura},
            url: "../../myfp/Asignaturas/addFavorito",
            success: function (respuesta) {

            }
        });
       
    });



}