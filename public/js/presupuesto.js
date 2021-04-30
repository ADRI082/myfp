$(document).ready(function(){
        
  //if (window.location.pathname.includes("/presupuesto")) {
    let loop = 0;
    CKEDITOR.replace( 'editor3');
    CKEDITOR.replace( 'editor4');

    urlCompleta = $('#ruta').val();

    //-----Envío del formulario formularioEdicionPresupuesto con diferentes botones
    $("#btnCrearProyecto").on("click", function () {
      if ($("#estadoEdit").val() == 'pendiente') {
        alert("El presupuesto se encuentra en estado pendiente, verifique antes de continuar.");
      }else{
        $("#crearProyecto").val(2);
        $("#formularioEdicionPresupuesto").submit();
      }
    });
    $("#Guardar").on("click", function () {
      $("#actualizarProyecto").val(1);
      $("#formularioEdicionPresupuesto").submit();
    });
    $("#Guardar2").on("click", function () {
      $("#actualizarProyecto").val(1);
      $("#formularioEdicionPresupuesto").submit();
    });  
    $("#btnExportFila").on("click", function () {
      $("#visualizarProyecto").val(1);
      /*$("#formularioEdicionPresupuesto").submit();*/
    });

    jQuery('#botonEjemplo').click(function(){
      if(jQuery('#collapseExample').is(':visible')){
          jQuery('#collapseExample').slideUp(500);
          jQuery(this).html('<i class="fa fa-plus"></i> Nuevo Presupuesto');
      }else{ //si no está visible
          if ($(".edPres").is(':visible')){
            //ocultarlo
            $(".edPres").slideUp(500);
          }
          jQuery('#collapseExample').slideDown(500);
          jQuery(this).html('Cerrar');
      }
    });
    
    $(document).on('change', '.variables',  function () {
          $(".newvar").remove();
          var newVar = $(".variables");
          for (var i = 0; i < newVar.length; i++) {             
            var texto = $(newVar[i]).children('option:selected').text();
            var id = $(newVar[i]).children('option:selected').val();

            if(texto.length > 0 && !texto.includes("Seleccionar") && $("#variables").find('option[value*="'+texto+'"]').length == 0 ){
              $(".variablesSelect").append("<option class = 'newvar' value = '"+texto+"'>"+$(newVar[i]).attr('attr-id')+"</option>");
            }
          
          }

          var newBarInput = $("input.variables");
          //console.log(newBarInput.length);
          for (var j = 0; j < newBarInput.length; j++) {
            var inputTexto = $(newBarInput[j]).val();
            //console.log(inputTexto);
            if(inputTexto.length > 0 ){
              $(".variablesSelect").append("<option class = 'newvar' value = '"+inputTexto+"'>"+$(newBarInput[j]).attr('attr-id')+"</option>");
            }
          }
                        
    });
  

    // SELECIONAR CLIENTES 
    $('#grupo').on('change', function () {
      let idGrupo = $(this).attr('option', 'selected').val();
      $.ajax({
        type: "POST",
        data: {
          idGrupo: idGrupo
        },
        url: "Presupuesto/getClienteSelect",
        success: function (respuesta) {
          $(".cliente").html(respuesta);   
        }
      });
    });     
    
    // SELECIONAR PLANTILLA
    //Esta opción la deshabilito, hasta validar el proceso de exportación del documento con la plantilla
    /*
    $('#tipoPresupuesto').on('change', function () {
      //limpiar el html de la selección anterior
      CKEDITOR.instances.editor3.setData('');
      let idPlantilla = $(this).attr('option', 'selected').val();
      $.ajax({
        type: "POST",
        data: {
          idPlantilla: idPlantilla
        },
        url: "Presupuesto/getPlantillaSelect",
        success: function (respuesta) {
          // alert(respuesta)
          CKEDITOR.instances.editor3.insertHtml(respuesta)
       
        }
      });
    });
    */


        // SELECIONAR PLANTILLA UPDATE
        $('#tipoEdit').on('change', function () {
          let idPlantilla = $(this).attr('option', 'selected').val();
          $.ajax({
            type: "POST",
            data: {
              idPlantilla: idPlantilla
            },
            url: "Presupuesto/getPlantillaSelect",
            success: function (respuesta) {
              // alert(respuesta)
              CKEDITOR.instances.editor4.insertHtml(respuesta)
           
            }
          });
        });

    // SELECCIONAR CLIENET EN EL EDITAR
    $('#grupoEdit').on('change', function () {
      let idGrupo = $(this).attr('option', 'selected').val();
      $.ajax({
        type: "POST",
        data: {
          idGrupo: idGrupo
        },
        url: "Presupuesto/getClienteSelect",
        success: function (respuesta) {
          $(".clienteEdit").html(respuesta);
        }
      });
    });

    // SELECIONAR ACCION
    $(".servicioS").on('change', function () {
      let idServicio = $(this).attr('option', 'selected').val();
      $.ajax({
        type: "POST",
        data: {
          idServicio: idServicio
        },
        url: "Presupuesto/getAccionSelect",
        success: function (respuesta) {
          $(".accionS").html(respuesta);
        }
      });
    });


    //ACCIONES NUEVO PRESUPUESTO

  //Inicio de acciones boton nuevo y boton quitar fila a la tabla:
    $(".add_fila").on("click", function () {

      idPresupuesto = $('#idEdit').val();      
      if (idPresupuesto && idPresupuesto>0) {
        servicio = $('#servicios').data('idservicio'); //capturo el servicio en la edición        
      }else{
        servicio = $('#servicios').attr('option', 'selected').val(); //capturo el servicio en la creación
      }
      
      if (servicio && servicio>0) {       
        agregar(servicio,idPresupuesto); 
      }else{       
        $( "#msgValidacion" ).text( "Debe seleccionar un servicio" ).show().fadeOut( 1500 );        
      }
    });

    /*
    $(".del_fila").on("click", function () {
      eliminar(id_fila_selected);
    });
    */
    
    var cont = 0;
    var id_fila_selected;

    function agregar(idServicio,idPresupuesto) {
      cont++;
      //console.log(cont);
      if (cont % 2 == 0){
        estilo = 'estiloFilaPar';
      }else{
        estilo = 'estiloFilaImpar';
      }

      
      //verifico si el presupuesto ya existe:
      if (idPresupuesto && idPresupuesto>0) {
        prueba = '<div class="col-md-2 col-sm-2"> '+
                  '  <label class="labelCampoPres">F. Inicio</label> '+
                  '  <input type="date" name="fechaInicioNuevo[]" id="fechaInicioNuevo'+cont+'" '+
                  '     class="form-control mr-1"> '+
                  '</div> '+
                  '<div class="col-md-1 col-sm-2"> '+
                  '    <label class="labelCampoPres">Situación</label> '+
                  '    <input id="estatusN'+cont+'" class="form-control form-control-sm" '+
                  '      value="Pendiente" readonly name="estatusNuevo[]"> '+
                  '</div> '+
                  '<div class="col-md-2 col-sm-2"> '+
                  '  <label class="labelCampoPres">Acciones</label> '+
                  '  <div class="d-lg-flex mb-1"> '+
                  '    <input class="form-check-input marcaraccion" type="checkbox" data-idaccion="'+cont+'" '+
                  '       id="checkAccionNuevo'+cont+'" name="checkAccionNuevo[]" value="'+cont+'"> '+
                  '    <a id="btnAprobarFila'+cont+'" class="btn btn-success mr-1 btnAprobarFilaNueva" '+
                  '       data-btnaccion="'+cont+'" data-idaccion="" name="btnAprobarFila" title="Aprobar" style="float:right"> '+
                  '       <i class="fas fa-thumbs-up" style="color:white;float:right;"></i> '+
                  '    </a> '+
                  '    <a class="btn btn-danger btn-sm btnEliminarLineaNueva" data-indice="'+cont+'"> '+
                  '      <i class="fa fa-trash" style="color:white"></i> '+
                  '    </a> '+
                  '  </div> '+
                  '</div> ';
      }else{
        prueba = '<div class="col-md-1 col-sm-2 text-center align-self-center">'+                       
                    '<a class="btn btn-danger btn-sm btnEliminarLineaNueva" data-indice="'+cont+'"><i class="fa fa-trash" style="color:white"></i></a>'+
                  '</div>';
      }

      var fila = '<div class="row '+estilo+'" id="lineaPresupuestoNueva_'+cont+'">'+
                    '<div class="form-group row col-md-12 mb-0">'+
                      '<div class="col-md-3 col-sm-8">'+
                        '<label class="labelCampoPres">Cliente</label>'+
                        '<select class="clientesPres'+cont+' form-control inputTipoModalidad cliente clienteS select2" data-linea="'+cont+'" id="clienteNuevo'+cont+'" name="clienteNuevo[]" required></select>'+
                      '</div>'+
                      '<div class="col-md-2 col-sm-4">'+
                        '<label class="labelCampoPres">Tipología</label>'+
                        '<select data-fila="'+cont+'" class="serviciosPres'+cont+' form-control inputTipoModalidad servicioS accionesT" id="servicioNuevo'+cont+'" name="servicioNuevo[]" ></select>'+
                      '</div>'+
                      '<div class="col-md-3 col-sm-8">'+
                        '<label class="labelCampoPres">Acción</label>'+
                        '<select class="accionesPres'+cont+' form-control inputTipoModalidad accionClaseNueva select2" id="accionNuevo'+cont+'" name="accionNuevo[]" data-indice="'+cont+'"></select>'+
                        '<a data-toggle="modal" data-target="#modalAccion"></a>'+
                      '</div>'+
                      '<div class="col-md-2 col-sm-4">'+
                        '<label class="labelCampoPres">Modalidad</label>'+
                        '<select data-fila="'+cont+'" class="modalidad'+cont+' form-control inputTipoModalidad" id="modalidadNuevo'+cont+'" name="modalidadNuevo[]" required></select>'+
                      '</div>'+
                      '<div class="col-md-2 col-sm-3">'+
                        '<label class="labelCampoPres">Nivel</label>'+
                        '<select data-fila="'+cont+'" class="nivel'+cont+' form-control inputTipoModalidad" id="nivelNuevo'+cont+'" name="nivelNuevo[]" required>'+
                        '<option selected disabled></option><option value="1">Básico</option><option value="2">Medio Superior</option></select>'+
                      '</div>'+
                    '</div>'+
                    '<div class="form-group row col-md-12 mb-2 d-flex">'+  
                      '<div class="col-md-1 col-sm-2">'+
                        '<label class="labelCampoPres">Importe</label>'+
                        '<input type="number" step="0.01" class="importePres'+cont+' form-control inputTipoModalidad"  name="importeNuevo[]" id="importeNuevo'+cont+'">'+
                      '</div>'+

                      '<div class="col-md-1 col-sm-2">'+
                        '<label class="labelCampoPres">H. Presen.</label>'+
                        '<input type="number" step="0.01" value="0" class="horasPres'+cont+' form-control inputTipoModalidad sumaHoras" data-indicenuevo='+cont+' name="hPresencialesNuevo[]" id="hPresencialesNuevo'+cont+'">'+
                      '</div>'+
                      '<div class="col-md-1 col-sm-2">'+
                        '<label class="labelCampoPres">H. Teleform.</label>'+
                        '<input type="number" step="0.01" value="0" class="horasPres'+cont+' form-control inputTipoModalidad sumaHoras" data-indicenuevo='+cont+' name="hTeleformacionNuevo[]" id="hTeleformacionNuevo'+cont+'">'+
                      '</div>'+
                      '<div class="col-md-1 col-sm-2">'+
                        '<label class="labelCampoPres">H. Aula Virt</label>'+
                        '<input type="number" step="0.01" value="0" class="horasPres'+cont+' form-control inputTipoModalidad sumaHoras" data-indicenuevo='+cont+' name="hAulaVirtualNuevo[]" id="hAulaVirtualNuevo'+cont+'">'+
                      '</div>'+                                                                  
                      '<div class="col-md-1 col-sm-2">'+
                        '<label class="labelCampoPres">H. Totales</label>'+
                        '<input type="number" step="0.01" value="0" class="horasPres'+cont+' form-control inputTipoModalidad"  name="horasNuevo[]" id="horasNuevo'+cont+'" readonly>'+
                      '</div>'+

                      '<div class="col-md-1 col-sm-2">'+
                        '<label class="labelCampoPres">Participantes</label>'+
                        '<input type="number" class="numParticip'+cont+' form-control inputTipoModalidad"  name="participantesNuevo[]" id="participantesNuevo'+cont+'">'+
                      '</div>'+prueba
                      /*'<div class="col-md-2 col-sm-3">'+
                        '<label class="labelCampoPres">Colaborador</label>'+
                        '<input type="number" class="nomColaborador'+cont+' form-control inputTipoModalidad" readonly id="colaboradores'+cont+'">'+
                      '</div>'+*///vertificar por que no carga este campo
                      
                    '</div>'+
                  '</div>'
                  '<hr>';
      //que se llene el select clientesPres con todos los clientes
      
      //let idServicio = $('#servicios').val(); 
      $.ajax({
        type: "POST",
        //url: "Presupuesto/getClienteSelect2",
        url: urlCompleta+"/Presupuesto/getClienteSelect2",
        dataType: "json",
        data: {
          idServicio: idServicio
        },
        success: function (respuesta) {
          clientes = respuesta['clientes'];
          tipologias = respuesta['tipologias'];
          acciones = respuesta['acciones'];   
          //modalidades = respuesta['modalidades'];       
          //console.log(modalidades);
          $('#lineasPresupuesto').append(fila);
          $('.select2').select2({
            theme: 'bootstrap4'
          });
          $(".clientesPres"+cont).html(clientes);
          $(".serviciosPres"+cont).html(tipologias);
          $('.accionesPres'+cont).html(acciones);
          //$('.modalidad'+cont).html(modalidades);

        }
      });
     

    }
    

    //AUTO SUMA DE LOS CAMPOS HORAS EN LA CREACIÓN DE UN PRESUPUESTO
    $(document).on('keyup', '.sumaHoras',function () {      
      linea = $(this).data('indicenuevo');
      sumarTodasLasHoras(linea);
    });
         
    function sumarTodasLasHoras(linea){
      presenciales = $('#hPresencialesNuevo'+linea).val();      
      if (!presenciales || presenciales == null || presenciales =='') {
        presenciales = 0;
      }
      teleformacion = $('#hTeleformacionNuevo'+linea).val();
      if (!teleformacion || teleformacion == null || teleformacion =='') {
        teleformacion = 0;
      }
      aulaVirtual = $('#hAulaVirtualNuevo'+linea).val();
      if (!aulaVirtual || aulaVirtual == null || aulaVirtual =='') {
        aulaVirtual = 0;
      }

      total = parseFloat(presenciales) + parseFloat(teleformacion) + parseFloat(aulaVirtual);
      $('#horasNuevo'+linea).val(total);
    }
    
    ///AUTO SUMA DE LOS CAMPOS HORAS EN LA EDICIÓN DE UN PRESUPUESTO GUARDADO    
    $(document).on('keyup', '.sumarHorasGuardadas',function () {            
      linea = $(this).data('indice');      
      sumarLasHorasGuardadas(linea);
    });

    function sumarLasHorasGuardadas(linea){
      presenciales = $('#hPresenciales'+linea).val();      
      if (!presenciales || presenciales == null || presenciales =='') {
        presenciales = 0;
      }
      teleformacion = $('#hTeleformacion'+linea).val();
      if (!teleformacion || teleformacion == null || teleformacion =='') {
        teleformacion = 0;
      }
      aulaVirtual = $('#hAulaVirtual'+linea).val();
      if (!aulaVirtual || aulaVirtual == null || aulaVirtual =='') {
        aulaVirtual = 0;
      }

      total = parseFloat(presenciales) + parseFloat(teleformacion) + parseFloat(aulaVirtual);
      $('#horas'+linea).val(total);
    }

    //ELIMINAR LINEA DE PRESUPUESTO NUEVA
    $(document).on('click', '.btnEliminarLineaNueva',function () {    
      indice = $(this).data('indice');
      console.log(indice); 
      del = $('#lineaPresupuestoNueva_'+indice);           
      $(del).remove();      
    });

    //marco y desmarco la fila y la pinto para eliminar
    $('#tablaAcciones').on('click', '.selected', function () {
      if ($(this).hasClass('seleccionada')) {
        $(this).removeClass('seleccionada');
      }else{
        $(this).addClass('seleccionada');
      }
      id_fila_selected = $(this);
      //console.log(id_fila_selected);
    });

    /*
    function eliminar(fila) {
      $(fila).remove();
    }*/

    //en el evento on change de select servicio, si se modifica que reinicie todos lo select de acciones
    $('#servicios').on('change', function () {      
      let servicio = $(this).attr('option', 'selected').val();
      $('#lineasPresupuesto').html('');
     
      //reinicio la variable global cont
      cont = 0;
     
    });

    //en el evento on change de la acción que muestre las modalidades para lineas guardadas
    $('.accionClase').on('change', function () {      
      let accion = $(this).attr('option', 'selected').val();
      indice = $(this).data('indice');
    
      $.ajax({
        type: "POST",
        data: {
          'accion': accion
        },
        url: urlCompleta+"/Presupuesto/getModalidadAccionSelect",
        success: function (respuesta) {          
          $("#modalidad"+indice).html(respuesta); 
          $('.select2').select2({
            theme: 'bootstrap4'
          });
        }
      });
    });   
        
    //en el evento on change de la acción que muestre las modalidades para lineas nuevas
    $(document).on('change','.accionClaseNueva',  function () {
      let accion = $(this).attr('option', 'selected').val();
      indice = $(this).data('indice');    
      $.ajax({
        type: "POST",
        data: {
          'accion': accion
        },
        url: urlCompleta+"/Presupuesto/getModalidadAccionSelect",
        success: function (respuesta) {         
          $("#modalidadNuevo"+indice).html(respuesta);
        }
      });
    });
    
    //mostrar apartado para subida de fichero
    $('#anadirFichero').click(function(e){
      e.preventDefault();
      if($('#formularioSubirFichero').is(':visible')){
              $('#formularioSubirFichero').slideUp(300);
      }else{
          $('#formularioSubirFichero').slideDown(300);
      }
    });

    //ACCIONES PARA FORMULARIO EDICION PRESUPUESTO     

    //cuando la fila ya está guardada
    $('.btnAprobarFila').on('click', function (e) {        
      var idaccionPres = $(this).attr('data-btnaccion');
      var idaccion = $(this).attr('data-idaccion');      
      var idpres = $('#idEdit').val();
      var nombrePres = $('#nombrePresEdit').val();
      var fechaInicio = $('#fechaInicio'+idaccionPres).val();      
      var horas = $('#horas'+idaccionPres).val();
      var hAulaVirtual = $('#hAulaVirtual'+idaccionPres).val();
      var hTeleformacion = $('#hTeleformacion'+idaccionPres).val();
      var hPresenciales = $('#hPresenciales'+idaccionPres).val();      
      var modalidad = $('#modalidad'+idaccionPres).val();
      var nivel = $('#nivel'+idaccionPres).val();
      
      var participantes = $('#participantes'+idaccionPres).val();
      var importe = $('#importe'+idaccionPres).val();

      if (fechaInicio == '') {
        alert('Debe ingresar la fecha de inicio');
        e.preventDefault();        
      }else if (importe == '') {
        alert('Debe ingresar un importe');
        e.preventDefault();        
      }else if (horas == '') {
        alert('Debe ingresar las horas');
        e.preventDefault();        
      }else if (participantes == '') {
        alert('Debe ingresar los participantes');
        e.preventDefault();        
      }else{
        var bool=confirm("¿Seguro de aprobar el presupuesto?");
        if(bool){
          $.ajax({
            type: "POST",
            data: {
              'idaccionPres': idaccionPres, 'idpres': idpres, 'fechaInicio': fechaInicio, 'idaccion': idaccion, 'horas':horas,
              'modalidad':modalidad, 'nivel':nivel, 'nombrePres':nombrePres, 
              'hAulaVirtual':hAulaVirtual, 'hTeleformacion': hTeleformacion, 'hPresenciales':hPresenciales
            },
            url: urlCompleta+"/Presupuesto/aprobarPresupuesto",
            success: function (respuesta) {            
              console.log(respuesta);
              if (respuesta == 'true') {
                $("#estatus"+idaccionPres).val('Aprobado');
                //además que oculte ambas manitas
                $('#btnAprobarFila'+idaccionPres).css("display", "none");
                Swal.fire({
                  title: 'Guarde todos los cambios realizados en el documento antes de salir',
                  text: 'Haz click en el botón guardar',
                  icon: 'success',
                  confirmButtonText: 'Ok'
                });                   
              }
            }
          });
        }
        
      }
    });

    //cuando la fila es nueva y ha sido agregada en la edición
    $(document).on('click', '.btnAprobarFilaNueva', function (e) {        
      var idaccionPres = $(this).attr('data-btnaccion');

      var cliente = $('#clienteNuevo'+idaccionPres).val();  
      var servicio = $('#servicioNuevo'+idaccionPres).val();      
      var accion = $('#accionNuevo'+idaccionPres).val();
      var modalidad = $('#modalidadNuevo'+idaccionPres).val();
      var nivel = $('#nivelNuevo'+idaccionPres).val();
      var fechaInicio = $('#fechaInicioNuevo'+idaccionPres).val();
      var importe = $('#importeNuevo'+idaccionPres).val();
      var horas = $('#horasNuevo'+idaccionPres).val();
      var participantes = $('#participantesNuevo'+idaccionPres).val();
      
      if (cliente == '' || cliente == null) {
        alert('Debe seleccionar un cliente');       
      }else if (servicio == '' || servicio == null) {
        alert('Debe seleccionar la tipología');       
      }else if (accion == '' || accion == null) {
        alert('Debe seleccionar una acción');       
      }else if (modalidad == '' || modalidad == null) {
        alert('Debe seleccionar una modalidad');       
      }else if (nivel == '' || nivel == null) {
        alert('Debe seleccionar un nivel');       
      }else if (fechaInicio == '' || fechaInicio == null) {
        alert('Debe ingresar la fecha de inicio');       
      }else if (importe == '' || importe == null) {
        alert('Debe ingresar un importe');       
      /*}else if (horas == '' || horas == null) {
        alert('Debe ingresar las horas');*/       
      }else if (participantes == '' || participantes == null) {
        alert('Debe ingresar los participantes');
      }else{
        
        var bool=confirm("¿Seguro de aprobar el presupuesto?");
        if(bool){         
                $("#estatusN"+idaccionPres).val('Aprobado');
                //además que oculte ambas manitas
                $('#btnAprobarFila'+idaccionPres).css("display", "none");
                Swal.fire({
                  title: 'Guarde todos los cambios realizados en el documento antes de salir',
                  text: 'Haz click en el botón guardar',
                  icon: 'success',
                  confirmButtonText: 'Ok'
                });                
        }
         
      }
    });

    $('.btnRechazarFila').on('click', function (e) {        
      var idaccion = $(this).attr('data-btnaccion');
      var idpres = $('#idEdit').val();
      var fechaRechazo = $('#fechaInicio'+idaccion).val();

      if (fechaRechazo == '') {
        alert('Debe ingresar la fecha de rechazo');
        e.preventDefault();        
      }else{
        var bool=confirm("¿Seguro de rechazar el presupuesto?");
        if(bool){
          $.ajax({
            type: "POST",
            data: {
              'idaccion': idaccion, 'idpres': idpres, 'fechaRechazo': fechaRechazo
            },
            url: urlCompleta+"/Presupuesto/rechazarPresupuesto",
            success: function (respuesta) {            
              if (respuesta == 'true') {
                $("#estatus"+idaccion).val('Rechazado');
                //además que oculte ambas manitas
                $('#btnAprobarFila'+idaccion).css("display", "none");
                $('#btnRechazarFila'+idaccion).css("display", "none");
              }
            }
          });
        }
      }
    });
 

})