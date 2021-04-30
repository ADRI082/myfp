$(document).ready(function(){

    $('.datos').on('change', function() {
     
        var id = $('.datos option:selected').val();      
            $.ajax({
                type: "POST",
                cache: false,
                url: 'FichaClientes/buscadorCliente',
                data: {"id":id},
                beforeSend: function(){
                    $("#ficha").html("Cargando.....");
                    },
                    success: function(response) {
                        console.log(response);
                        $("#ficha").html(response);
                        // cargamos CKeditor desde la respuesta Ajax, ya que si lo hacemos directamente en
                        // el footer2 no lo carga al rellenar la ficha cliente a traves de Ajax
                             CKEDITOR.replace('editor1',{
                                toolbar:
                                [
                                    ['Source','-','Save','NewPage','Preview','-','Templates'],
                                    ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
                                    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
                                    ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],'/',
                                    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
                                    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
                                    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
                                    ['Link','Unlink','Anchor'],
                                    ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],'/',
                                    ['Styles','Format','Font','FontSize'],
                                    ['TextColor','BGColor'],
                                    ['Maximize', 'ShowBlocks','-','About']

                                ] 
                        }); 
             
                        
                        // desde aqui recogemoe el evento del boton del ckeditor para 
                        // guardar a la base de datos y ver en el panel debajo del ckeditor
                       
                        // $('#incluirtexto').on('click', function() {
                            $('#docker').on('click',"#incluirtexto", function() {
                            var documento = CKEDITOR.instances['editor1'].getData()
                            var id = $('.datos option:selected').val();
                            var fecha = $('#fechaObservacion').val();
                            var agente = $('#agenteObservacion').val();
                            var titulo = $('#tituloObservacion').val();
                           // console.log(fecha);
                            $.ajax({
                                type: "POST",
                                url: 'FichaClientes/buscadorCliente',
                                data : {"id":id, "fecha":fecha, "agente":agente, "titulo":titulo, "documento":documento},
                                    beforeSend: function(){
                                    $("#ficha").html("Cargando.....");
                                    },
                                    success: function(response) {

                                        $("#ficha").html(response);
                                        // volvemos a cargar ckeditor
                                         CKEDITOR.replace('editor1',{
                                            toolbar:
                                            [
                                                ['Source','-','Save','NewPage','Preview','-','Templates'],
                                                ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
                                                ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
                                                ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],'/',
                                                ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
                                                ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
                                                ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
                                                ['Link','Unlink','Anchor'],
                                                ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],'/',
                                                ['Styles','Format','Font','FontSize'],
                                                ['TextColor','BGColor'],
                                                ['Maximize', 'ShowBlocks','-','About']
            
                                            ]
                                    }); // fin de la carga del CKEditor

                                } // fin del success
                             }); // fin del ajax
                        
                        $('.datos').change();
                            }); // fin el click
                            CKEDITOR.replace('editor2',{
                                toolbar:
                                [
                                    ['Source','-','Save','NewPage','Preview','-','Templates'],
                                    ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
                                    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
                                    ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],'/',
                                    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
                                    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
                                    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
                                    ['Link','Unlink','Anchor'],
                                    ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],'/',
                                    ['Styles','Format','Font','FontSize'],
                                    ['TextColor','BGColor'],
                                    ['Maximize', 'ShowBlocks','-','About']

                                ]
                        });
                        $('.detalle').on('click', function(){
                              var id =  $(this).attr("id");
                              $.ajax({
                                type: 'POST',
                                url: 'FichaClientes/getDetalleEmail',
                                data: { 'id': id }
                              }).done(function (data) {                               
                                data = JSON.parse(data);
                                data = data;
                                $('#asunto').html(' ASUNTO:&nbsp;&nbsp; '+data["subject"]); 
                                $('#contEmail').html(data["contenido"]); 
                                $('#remitente').html('REMITENTE:&nbsp;&nbsp;'+ data["desde"]+' <span class="mailbox-read-time float-right">'+data["fechaa"]+'</span>');
                                emails = data['emails'];
                                console.log(emails);
                                cadena = '';
                                for (let index = 0; index < emails.length; index++) {
                                    if (index != emails.length -1 ) {
                                        cadena += emails[index]+'; ';    
                                    }else{
                                        cadena += emails[index];
                                    }          
                                }

                                $('#destinatarios').html('DESTINATARIOS:&nbsp;&nbsp;'+ cadena); 
                                if(!data["fail"]){
                                    $("#fattachment").hide();
                                }else{
                                    $("#fattachment").show();
                                }
                                $('.attach').html('<i class="fas fa-paperclip"></i> '+data["fail"]); 
                                $('.attach').attr("href", "public/files/"+data['fail']);
                              }).fail(function () {
                                console.log('Hubo un error al cargar los datos del email.');
                              });
                             })
                    } // fin del success , aqui es donde hay poner todo lo que ocurre en la vista editarFichaCliente que ha sido cargada con Ajax
            }); // fin incluir texto click
       
    }); // fin datos change

});


