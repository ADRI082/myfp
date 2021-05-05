if (window.location.pathname.includes('/Cursos')) {


    $(document).on('change', '#selectCursos', function () {


        idCurso = $(this).val();

        $('#tablaAsignaturas').dataTable().fnDestroy();


        $('#tablaAsignaturas').DataTable({
            "processing": true,
            "serverSide": false,
            "ajax": {
                "url": "http://localhost/myfp/Asignaturas/getAsignaturaByIdCurso",
                "type": "POST",
                dataSrc: "",
                "data": {
                    idCurso: idCurso
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


        $('#tablaAsignaturas').show();



    });


    $(document).on('click', '.ver', function (e) {

        e.preventDefault();

        fila = $(this).closest("tr");
        idAsignatura = parseInt(fila.find('td:eq(0)').text());


        window.location.replace('http://localhost/myfp/Asignaturas?id='+idAsignatura);
    });


    
}




