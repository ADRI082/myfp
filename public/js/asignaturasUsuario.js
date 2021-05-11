if (window.location.pathname.includes('/Asignaturas')) {


    $(document).ready(function () {

        idUsuario = $('#id').val()

        cargarDataTable(idUsuario);

        $('#tablaAsignaturas').show();

    });

    $(document).on('click', '.ver', function (e) {

        e.preventDefault();

        fila = $(this).closest("tr");
        idAsignatura = parseInt(fila.find('td:eq(0)').text());


        window.location.replace('http://localhost/myfp/Asignaturas?id='+idAsignatura);
    });

    function cargarDataTable(idUsuario) {

        $('#tablaAsignaturas').DataTable({
            "processing": true,
            "serverSide": false,
            "ajax": {
                "url": "http://localhost/myfp/AsignaturasUsuario/getAsignaturasFavoritas",
                "type": "POST",
                dataSrc: "",
                "data": {
                    idUsuario: idUsuario
                }
            },
            columns: [
                { data: "idAsignatura" },
                { data: "nombre" },
                { data: "abreviatura" },
                {"defaultContent": "<a class='btn btn-primary btn-xs ver'> <i class='fas fa-eye'></i></a"},
            ],
            columnDefs: [
                {
                    className: 'dt-center',
                    "targets": "_all"
                }
            ]
        });


    }


}