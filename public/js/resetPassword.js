if (window.location.pathname.includes('/resetPassword')) {


    $(document).on('click','#resetEmailButton',function(e){

        e.preventDefault();
        email = $('#resetEmail').val();

        $.ajax({
            type: "POST",
            data: {email:email},
            dataType:'json',
            url: "../../myfp/login/resetearPassword",
            success: function (respuesta) {
               
            }
        });


    })






}