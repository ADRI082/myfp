if (window.location.pathname.includes('/Cursos')) {


    $(document).on('change', '#selectCursos', function () {


        idCurso = $(this).val();


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
                {"defaultContent": "<a href='' data-toggle='modal' data-target='#emit' class='btn btn-primary btn-xs ver'> <i class='fas fa-eye'></i></a"},
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





}



