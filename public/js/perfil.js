if (window.location.pathname.includes('/Perfil')) {

    $(document).on('click', '#editUsuario', function (e) {

        pass = prompt("Introduce tu contraseña actual para modificar todo tu perfil:", "");

        if (pass == $('#passwordEdit').val()) {

            e.preventDefault();

            form = $('#formEditUsuario').serializeArray();

            $.ajax({
                type: "POST",
                data: { form: form },
                dataType: 'json',
                url: "../../myfp/Perfil/editarUsuario",
                success: function (respuesta) {

                    if(respuesta){
                        Swal.fire({
                            text: 'Edición hecha correctamente',
                            icon: 'success',
                            confirmButtonText: 'Ok'
                          });
                    }
                }
            });
        }else{
            Swal.fire({
                title: 'Error',
                text: 'La contraseña introducida no es la correcta',
                icon: 'error',
                confirmButtonText: 'Ok'
              });
        }

    })


}