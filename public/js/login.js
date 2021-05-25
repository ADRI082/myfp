
    $(document).on('click','#logeo',function(e){

        e.preventDefault();

        mail = $('#userEmail').val();
        password = $('#password').val();


        $.ajax({
            type: "POST",
            data: {mail:mail,password:password},
            dataType:'json',
            url: "../../myfp/login/comprobar",
            success: function (respuesta) {
                if(respuesta === false){
                   $('#error').show();
                }else{
                    window.location.replace("http://localhost/myfp/datatable");
                }
            }
        });

    })

