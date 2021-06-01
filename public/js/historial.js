if (window.location.pathname.includes('/Historial')) {


    $(document).on('change', '#selectHistorial', function () {


        tipoHistorial = $(this).val();

        console.log(tipoHistorial);

        $('#tablaHistorial').dataTable().fnDestroy();


        $('#tablaHistorial').DataTable({
            "processing": true,
            "serverSide": false,
            "ajax": {
                "url": "http://localhost/myfp/Historial/getHistorial"+tipoHistorial,
                "type": "POST",
                dataSrc: "",
            },
            columns: [
                { data: "idAsignatura" },
                { data: "asignatura" },
                { data: "bloque" },
                { data: "fecha" },
                { data: "archivo" },
                {"defaultContent": "<a class='btn btn-primary btn-xs descargar'> <i class='fas fa-download'></i></a"},
            ],
            columnDefs: [
                {
                    className: 'dt-center',
                    "targets": "_all"
                }
            ]
        });


        $('#tablaHistorial').show();

    });


    $(document).on('click', '.descargar', function (e) {

        e.preventDefault();

        filaDocProyecto = $(this).closest("tr");
        idAsignatura = filaDocProyecto.find('td:eq(0)').text(); 
        nombreFichero = filaDocProyecto.find('td:eq(4)').text();
        window.open("public/documentos/ficheros/" + idAsignatura + "_" + nombreFichero);
    });



}
