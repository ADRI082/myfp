$(document).on('focusout', '.campotablaRGPD', function () {

    let id =1;
    let tabla = $(this).data('tabla');
    let campo = $(this).attr('name');
    let pk = $(this).data('pk');
    let valor = $(this).val();

    console.log(tabla);
    console.log(valor);
    console.log(campo);
    console.log(pk);


    $.ajax({
      url: urlCompleta +'/Configuracion/editarRGPD',
      type: "POST",
      data: { id: id, tabla: tabla, campo: campo, valor: valor, pk: pk },
      success: function (respuesta) {
        console.log('respuesta', respuesta);
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