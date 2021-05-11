if (window.location.pathname.includes('/Signup')) {


    $(document).on('click', '#registrar', function (e) {

        e.preventDefault();

        form = $('#formularioRegistro').serializeArray();



        if (form[4]['value'] === form[5]['value']) {

            $.ajax({
                type: "POST",
                data: {
                    form: form
                },
                dataType: 'json',
                url: "http://localhost/myfp/Signup/insertarUsuario",
                success: function (respuesta) {


                    swal({
                        title: "Informacion!",
                        text: respuesta.salida,
                        type: "success"
                    }).then(function() {
                        if(salida.booleano){
                            window.location.href = "http://localhost/myfp/login";
                        }
                       
                    });
                }
            });



           


        } else {
            alert('Las contraseñas no coinciden');
        }


    })



}