$(document).ready(function () {

  validatorInputKeyPress();

  urlCompleta = $('#ruta').val();


  // CODIGO PARA DATATABLE
  $('#tabla_proyectos thead th').each(function () {
    var title = $(this).text();
    $(this).html(title + '</br><input type="text" class="col-search-input" style="margin-top:10px;" placeholder="" />');
  });

  let tabla_proyectos = $('#tabla_proyectos').DataTable({
    "responsive": true,
    "autoWidth": true,
    "dom": 'lBfrtip',
    'ordering': true,
    "aaSorting": [[0, "desc"]],
    "language": {
      "url": "../public/datatables/Languages/Spanish.json"
    },
    "buttons": [
      {
        "extend": 'excelHtml5',
        "text": '<i class="fas fa-file-excel" style="color:green;"></i>',
        "titleAttr": 'Exportar a Excel',
        "className": 'btn btn-success'
      },
      {
        "extend": 'pdfHtml5',
        "text": '<i class="fas fa-file-pdf" style="color:red;"></i>',
        "titleAttr": 'Exportar a PDF',
        "className": 'btn btn-danger'
      },
      {
        "extend": 'print',
        "text": '<i class="fas fa-print" style="color:blue;"></i>',
        "titleAttr": 'Imprimir',
        "className": 'btn btn-info'
      },
      {
        "extend": 'copy',
        "text": '<i class="fas fa-copy" style="color:black;"></i>',
        "titleAttr": 'Copiar filas'
      }

    ],
    /* codigo para ejecutar la busqueda por columna de la tabla */

    initComplete: function () {
      var api = this.api();
      // Apply the search
      api.columns().every(function () {
        var that = this;
        $('input', this.header()).on('keyup change', function () {
          if (that.search() !== this.value) {
            that
              .search(this.value)
              .draw();
          }
        });
      });
    }

  });

  $('a.toggle-vis').on('click', function (e) {
    e.preventDefault();
    // Get the column API object
    var column = tabla_proyectos.column($(this).attr('data-column'));
    // Toggle the visibility
    column.visible(!column.visible());
  });
  $.fn.dataTable.ext.errMode = 'none';
  $('#tabla_proyectos').on('error.dt', function (e, settings, techNote, message) {
    console.log('An error has been reported by DataTables: ', message);
  }).DataTable();
  $('#tabla_proyectos').DataTable();



  $('#editor5').summernote({
    toolbar: [
      ['style', ['bold', 'italic', 'underline', 'clear']],
      ['font', ['strikethrough', 'superscript', 'subscript']],
      ['fontsize', ['fontsize']],
      ['color'],
      ['insert', ['picture']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['height', ['height']],
      ['style', ['style']],
      ['fontname', ['fontname']],
      ['table', ['table']],
      ['view', ['fullscreen', 'codeview', 'help']],
      ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
      ['float', ['floatLeft', 'floatRight', 'floatNone']],
      ['remove', ['removeMedia']]
      ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
      ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
    ],

  });
  //Aquí se carga los detalles de la factura por cada cliente seleccionado
  $("#clienteSel").on("change", function () {
    var idCliente = $(this).children('option:selected').val();
    var idPresupuesto = $('#idPresupuesto').val();
    var idAccion = $('#idAccion').val();
    var fechaInicio = $('#fechaInicio').val();
    var idAccionProy = $('#idAccionProy').val();
    var idProyecto = $('#idProyecto').val();

    $("#tipologia").html('');

    if (idCliente == 'todos') {

      $("#fichaProyectoDetallada").html("");
      $("#contColaborador").css("display", "none");
      $("#contAgente").css("display", "none");
      $("#contImporte").css("display", "none");
      //alert('es todos');
      //traer html de todos los clientes          
      $.ajax({
        type: "POST",
        cache: false,
        url: urlCompleta + "/Proyecto/buscarDatosDeTodosLosClientes",
        data: {
          'idProyecto': idProyecto
        },
        beforeSend: function () {
          $("#contTodosLosClientes").html("Cargando...");
        },
        success: function (response) {
          //console.log(response);
          dataJSON = JSON.parse(response)
          console.log(dataJSON);
          $("#contTodosLosClientes").html(dataJSON.html);
          $('#contenedorLineasGastos').append(dataJSON.htmlGastos);
          $('#contenedorTablaEmails').html(dataJSON.htmlemails);
          $("#contTodosLosClientes").css("display", "block");
        }

      });

      $.ajax({
        type: "POST",
        data: {
          'idProyecto': idProyecto
        },
        url: "../../Proyecto/obtenerNumeroTotalDeParticipantes",
        success: function (respuesta) {
          respuesta = JSON.parse(respuesta);
          $("#participantes").val(respuesta);
        }
      });


    } else {
      $("#contColaborador").css("display", "block");
      $("#contAgente").css("display", "block");
      $("#contImporte").css("display", "block");
      $("#contTodosLosClientes").css("display", "none");
      $.ajax({
        type: "POST",
        // cache: false,  
        data: {
          'idCliente': idCliente, 'idPresupuesto': idPresupuesto, 'idAccion': idAccion, 'fechaInicio': fechaInicio,
          'idAccionProy': idAccionProy, 'idProyecto': idProyecto
        },
        url: urlCompleta + "/Proyecto/buscarAccionesProyectoPorClientes",
        beforeSend: function () {
          $("#fichaProyectoDetallada").html("Cargando...");
        },
        success: function (datos) {
          datosJSON = JSON.parse(datos);
          $("#fichaProyectoDetallada").html(datosJSON.html);
          $('#contenedorLineasGastos').append(datosJSON.htmlGastos);
          $('#contenedorLineasGastosComunes').append(datosJSON.htmlGastosComunes);
          $('#contenedorTablaEmails').html(datosJSON.htmlEmails);

          let tailGenerico = tail.select('.todos', {
            search: true,
            locale: "es",
            multiSelectAll: false,
            searchMinLength: 0,
            multiContainer: false,
          });

          for (let index = 0; index < tailGenerico.length; index++) {
            const element = tailGenerico[index];
            listenerSelect(element);
          }

        }

      });

      $.ajax({
        type: "POST",
        data: {
          'idCliente': idCliente, 'idProyecto': idProyecto
        },
        url: "../../Proyecto/obtenerColaboradorPorCliente",
        success: function (respuesta) {
          respuesta = JSON.parse(respuesta);
          //console.log(respuesta);
          $("#colaboradorCli").val(respuesta['colaborador']);
          $("#AgenterCli").val(respuesta['agente']);
          $("#tipologia").append(respuesta['tipologia']);
          //$("#nivelCurso").append(respuesta['nivel']);
          //$("#modalidad").append(respuesta['modalidad']);
          $("#participantes").val(respuesta['participantes']);
          $("#importeAccion").val(respuesta['importe']);
          //$("#horas").val(respuesta['horas']);                              
        }
      });

      function listenerSelect(tail) {

        tail.on("change", function (item, state) {
          var valor;
          const elemento = $(this.e);

          if (elemento.data('concepto') == 1) {

            var bool = confirm("¿Seguro de que quiere cambiar el tipo de Concepto?");
            if (bool) {

              valor = elemento.val();
              console.log('entra');

              let idfactura = elemento.data('idfactura');

              let tabla = elemento.data('tabla');
              url = "../core/model/Editar/app/controller/controladorEditar.php";
              let campo = elemento.attr('name');
              let pk = elemento.data('pk');
              // console.log('pk', pk);
              // console.log('idFactura', idfactura);
              // console.log('campo', campo);
              // console.log('tabla', tabla);
              // console.log('valor', valor);

              //AQUI EDITAMOS EL VALOR ELEGIDO DEL TAIL SELECT

              $.ajax({
                url: '../../Proyecto/editarFactura',
                type: "POST",
                data: { idfactura: idfactura, tabla: tabla, campo: campo, valor: valor, pk: pk },
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
                  if (campo == 'codigo' || campo == 'cp') {
                    $('#localidad').focusout();
                    $('#provincia').focusout();
                  }
                },

                error: function () {
                  console.log("No se ha podido actualizar el dato, intente de nuevo");
                }
              });

              indice = $(elemento).data('indice');
              nueva = '';

              if ($(elemento).data('nueva') == 1) {
                nueva = 'Nueva';
              }

              tipoConcepto = $('#tipoConcepto' + nueva + indice).attr('option', 'selected').val();
              idAccionProy = $('#idAccionProy').val();
              idAccionPres = $('#idAccionPres').val();


              //AQUI OBTENEMOS EL TIPO DE CONCEPTO QUE ES Y LO PINTAMOS EN EL EDITOR

              $.ajax({
                type: "POST",
                data: {
                  'tipoConcepto': tipoConcepto, 'idAccionProy': idAccionProy, 'idAccionPres': idAccionPres
                },
                url: "../../Proyecto/obtenerTipoConceptoFacturaIngreso",
                success: function (respuesta) {
                  $('#editor' + nueva + indice).summernote({
                    toolbar: [
                      ['style', ['bold', 'italic', 'underline', 'clear']],
                      ['font', ['strikethrough', 'superscript', 'subscript']],
                      ['fontsize', ['fontsize']],
                      ['color']
                    ]
                  });
                  $('#editor' + nueva + indice).summernote('code', '');
                  $('#editor' + nueva + indice).summernote('code', respuesta);

                  $.ajax({
                    type: "POST",
                    url: urlCompleta + "/Proyecto/actualizarConcepto",
                    dataType: "json",
                    data: {
                      concepto: respuesta, idFactura: idfactura
                    },
                    success: function (respuesta) {

                    }
                  });
                }
              });

              $('#contEditorConcepto' + nueva + indice).slideDown(500);
              $('#editarConcepto' + indice).html('Cerrar edición <i class="fas fa-chevron-up"></i>');



            }

          } else {
            valor = elemento.val();


            let idfactura = elemento.data('idfactura');

            let tabla = elemento.data('tabla');
            url = "../core/model/Editar/app/controller/controladorEditar.php";
            let campo = elemento.attr('name');
            let pk = elemento.data('pk');
            console.log('pk', pk);
            console.log('idFactura', idfactura);
            console.log('campo', campo);
            console.log('tabla', tabla);
            console.log('valor', valor);

            $.ajax({
              url: '../../Proyecto/editarFactura',
              type: "POST",
              data: { idfactura: idfactura, tabla: tabla, campo: campo, valor: valor, pk: pk },
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
                if (campo == 'codigo' || campo == 'cp') {
                  $('#localidad').focusout();
                  $('#provincia').focusout();
                }
              },

              error: function () {
                console.log("No se ha podido actualizar el dato, intente de nuevo");
              }
            });

          }

          //AQUI EDITAMOS EL CONCEPTO



        })

      }
    }

  });

  //inhabilitar IRPF y tipo de coste cuando es factura.
  $(document).on('change', '#clasificacion', function () {
    clasificacion = $(this).val();
    $('#irpfF').val('');
    $('#iva').val('');
    $('select[name="tipoCoste"]').val('');
    $('select[name="iban"]').val('');
    //alert(clasificacion);
    if (clasificacion == 'facturaIngreso') {
      $('#tipoCoste').prop('disabled', 'true');
      $('#irpfF').prop('disabled', 'true');
      $('#numFactura').prop('readonly', 'true');
      $('#iban').removeAttr('disabled');
    } else {
      $('#tipoCoste').removeAttr('disabled');
      $('#irpfF').removeAttr('disabled');
      $('#numFactura').removeAttr('readonly');
      $('#iban').prop('disabled', 'true');
    }
  });


  //Actualizar factura    
  $(document).on('click', '.actualizarFactura', function () {
    idFactura = $(this).attr('data-idFac');
    importeFactura = $('#importe' + idFactura).val();
    cantidad = $('#cantidad' + idFactura).val();
    iva = $('#iva' + idFactura).val();
    total = $('#total' + idFactura).val();
    fecha = $('#fechafactura' + idFactura).val();
    fechaCobro = $('#fechacobro' + idFactura).val();
    iban = $('#iban' + idFactura).val();
    concepto = $('#conceptoFactura' + idFactura).val();

    //valida que vengan valores mayores a cero:
    if (importeFactura == 0 || importeFactura == '') {
      alert('Debe ingresar un valor mayor a cero en el importe factura.');
    } else if (cantidad == 0 || cantidad == '') {
      alert('Debe ingresar un valor mayor a cero en cantidad.');
    } else if (total == 0 || total == '') {
      alert('El total de la factura no puede ser cero.');
    } else if (fecha == 0 || fecha == '' || fecha == null) {
      alert('Ingrese la fecha de emisión de la factura.');
    } else {
      var bool = confirm("¿Seguro de actualizar los datos de la factura?");
      if (bool) {
        $.ajax({
          type: "POST",
          data: {
            'idFactura': idFactura, 'importeFactura': importeFactura, 'cantidad': cantidad, 'iva': iva,
            'total': total, 'fecha': fecha, 'fechaCobro': fechaCobro, 'iban': iban, 'concepto': concepto
          },
          url: "../../Proyecto/actualizarFactura",
          success: function (respuesta) {
            respuesta = JSON.parse(respuesta);
            console.log(respuesta);
            if (respuesta == 'false') {
              alert('No se ha podido actualizar la factura. Inténtelo nuevamente.');
            } else {
              $('#importe' + idFactura).val(parseFloat(respuesta['importe']).toFixed(2));
              $('#cantidad' + idFactura).val(parseFloat(respuesta['cantidad']).toFixed(2));
              $('#iva' + idFactura).val(parseFloat(respuesta['iva']).toFixed(2));
              $('#total' + idFactura).val(parseFloat(respuesta['total']).toFixed(2));
              $('#fechafactura' + idFactura).val(respuesta['fechafactura']);
              $('#fechacobro' + idFactura).val(respuesta['fechacobro']);
              if (respuesta['iban'] == '' || respuesta['iban'] == null) {
                var numIban = '';
              } else {
                var numIban = respuesta['iban'];
              }
              $('#iban' + idFactura).val(numIban);
              $('#conceptoFactura' + idFactura).val(respuesta['concepto']);
              alert('Los cambios se han actualizado con éxito.');
            }
          }
        });
      }
    }
  });


  $(document).on('click', '#btnGuardarFila', function (e) {

    precioFinal = $('#importe').val();
    idAccionProy = $('#idAccionProy').val();
    tipoCoste = $('#tipoCoste').attr('option', 'selected').val();
    tipoCosteNom = $('select[name="tipoCoste"] option:selected').text();
    importeFactura = $('input[name=importeFactura]').val();
    cantidad = $('input[name=cantidad]').val();
    iva = $('input[name=iva]').val();
    total = $('input[name=total]').val();
    fecha = $('input[name=fechaFactura]').val();
    fechaCobro = $('#fechaCobro').val();
    irpf = $('#irpfF').val();
    numFacCoste = $('#numFactura').val();
    clasificacion = $('#clasificacion').attr('option', 'selected').val();
    clasificacionNom = $('select[name="clasificacion"] option:selected').text();

    if (precioFinal == 0 || precioFinal == '') {
      alert('El precio final es igual a cero. Debe ingresar y guardar el precio final.');
    } else {
      if (clasificacion == 'facturaIngreso') {
        alert('Esta opción solo está habilitada para guardar costes de proyecto.');
        e.preventDefault();
      } else if (clasificacion == 'coste') {
        //valida que vengan valores mayores a cero:
        if (tipoCoste == '' || tipoCoste == null) {
          alert('Debe ingresar un tipo de coste.');
        } else if (importeFactura == 0 || importeFactura == '') {
          alert('Debe ingresar un valor mayor a cero en el importe factura.');
        } else if (cantidad == 0 || cantidad == '') {
          alert('Debe ingresar un valor mayor a cero en cantidad.');
        } else if (total == 0 || total == '') {
          alert('El total de la factura no puede ser cero.');
        } else {
          var bool = confirm("¿Seguro de añadir este coste al proyecto?");
          if (bool) {
            $.ajax({
              type: "POST",
              data: {
                'idAccionProy': idAccionProy, 'clasificacion': clasificacion, 'tipoCoste': tipoCoste,
                'importeFactura': importeFactura, 'cantidad': cantidad, 'iva': iva, 'total': total, 'fecha': fecha,
                'fechaCobro': fechaCobro, 'irpf': irpf, 'numFacCoste': numFacCoste
              },
              url: "../../Proyecto/agregarCosteAcccionProyecto",
              success: function (data) {
                data = JSON.parse(data);

                var fila = '<tr>' +
                  '<td>' +
                  '<input class="form-control lineaCoste" value="' + clasificacionNom + '" readonly></input>' +
                  '</td>' +
                  '<td>' +
                  '<input class="form-control lineaCoste" value="' + tipoCosteNom + '" readonly></input>' +
                  '</td>' +
                  '<td><input class="form-control lineaCoste importeFactura" value="' + parseFloat(importeFactura).toFixed(2) + '" readonly></input></td>' +
                  '<td><input class="form-control lineaCoste cantidad" value="' + parseFloat(cantidad).toFixed(2) + '" readonly></input></td>' +
                  '<td><input class="form-control lineaCoste iva" value="' + parseFloat(iva).toFixed(2) + '" readonly></input></td>' +
                  '<td><input class="form-control lineaCoste" value="' + parseFloat(irpf).toFixed(2) + '" readonly></input></td>' +
                  '<td><input type="number" class="form-control lineaCoste total" value="' + parseFloat(data).toFixed(2) + '" readonly></input></td>' +
                  '<td><input class="form-control lineaCoste" value="' + fecha + '" type="date" readonly></input></td>' +
                  '<td><input class="form-control lineaCoste" value="' + numFacCoste + '" readonly></input></td>' +
                  '<td><input class="form-control lineaCoste" value="' + fechaCobro + '" type="date" readonly></input></td>' +
                  '<td><input class="form-control lineaCoste" readonly></input></td>' +
                  '<td><input class="form-control lineaCoste" readonly></input></td>' +
                  '</tr>';
                $('#tablaFacturasProy').append(fila);
                //limpiar los input para ingresar nuevos datos                                           
                $('input[name=importeFactura]').val('');
                $('input[name=cantidad]').val('');
                $('input[name=iva]').val('');
                $('input[name=total]').val('');
                $('input[name=fechaFactura]').val('');
                //para limpiar select                  
                $('select[name="tipoCoste"]').val('');
                $('select[name="clasificacion"]').val('');
              }
            });
          }
        }
      } else {
        alert('Debe seleccionar una clasificación.');
      }
    }
  });


  $(document).on('click', '#btnPrecioFinal', function () {

    precioFinal = $('#importe').val();
    idAccionProy = $('#idAccionProy').val();

    $.ajax({
      type: "POST",
      data: {
        'precioFinal': precioFinal, 'idAccionProy': idAccionProy
      },
      url: "../../Proyecto/confirmarPrecioFinal",
      success: function (data) {
        console.log(data);
        if (data == precioFinal) {
          $("#importe").val(data);
        }
      }
    });

  })

  $(document).on('change', ".tipoProveedor", function () {

    //capturo el servicio
    tipoProveedor = '';
    fila = $(this).data('fila');

    if ($(this).data('nueva') == 1) {


      if ($(this).data('comun') == 1) {

        tipoProveedor = $('#proveedorComunNueva' + fila).val();


        console.log(tipoProveedor);

        if (tipoProveedor == 'proveedor') {//
          metodo = 'getProveedoresSelect';
        } else if (tipoProveedor == 'profesor') {//
          metodo = 'getProfesoresSelect';
        } else if (tipoProveedor == 'colaborador') {//
          metodo = 'getColaboradoresSelect';
        }

        $.ajax({
          type: "POST",
          url: "../../Proyecto/" + metodo,
          success: function (respuesta) {
            // $('.razonSocial', document).remove();

            $('#razonSocialComunNueva' + fila).html(respuesta);

            let tailRazon = tail.select('#razonSocialComunNueva' + fila, {
              search: true,
              locale: "es",
              multiSelectAll: false,
              searchMinLength: 0,
              multiContainer: false,
            });

            tailRazon.reload();


          }
        });

      } else {



        tipoProveedor = $('#proveedorNueva' + fila).val();


        console.log(tipoProveedor);

        if (tipoProveedor == 'proveedor') {//
          metodo = 'getProveedoresSelect';
        } else if (tipoProveedor == 'profesor') {//
          metodo = 'getProfesoresSelect';
        } else if (tipoProveedor == 'colaborador') {//
          metodo = 'getColaboradoresSelect';
        }

        $.ajax({
          type: "POST",
          url: "../../Proyecto/" + metodo,
          success: function (respuesta) {
            // $('.razonSocial', document).remove();

            $('#razonSocialNueva' + fila).html(respuesta);

            let tailRazon = tail.select('#razonSocialNueva' + fila, {
              search: true,
              locale: "es",
              multiSelectAll: false,
              searchMinLength: 0,
              multiContainer: false,
            });

            tailRazon.reload();


          }
        });
      }

    } else {
      factura = $(this).data('idfactura');
      tipoProveedor = $('#proveedor' + factura).val();

      console.log(tipoProveedor);

      if (tipoProveedor == 'proveedor') {//
        metodo = 'getProveedoresSelect';
      } else if (tipoProveedor == 'profesor') {//
        metodo = 'getProfesoresSelect';
      } else if (tipoProveedor == 'colaborador') {//
        metodo = 'getColaboradoresSelect';
      }

      $.ajax({
        type: "POST",
        url: "../../Proyecto/" + metodo,
        success: function (respuesta) {
          // $('.razonSocial', document).remove();

          $('#razonSocial' + factura).html(respuesta);

          let tailRazon = tail.select('#razonSocial' + factura, {
            search: true,
            locale: "es",
            multiSelectAll: false,
            searchMinLength: 0,
            multiContainer: false,
          });

          tailRazon.reload();


        }
      });

    }
  });

  $(document).on('change', ".tipoFolio", function () {

    let indice = $(this).data('fila');

    $('#tipoFolioSeleccionado'+indice).val(this.value);

  });

  $(document).on('click', '.btnGuardarGasto', function (e) {

    fila = $(this).data('indice');

    tipoGasto = $('#gastoNueva' + fila).attr('option', 'selected').val();
    nomTipoGasto = $('select[name="gasto"] option:selected').text();
    tipoProveedor = $('#proveedorNueva' + fila).attr('option', 'selected').val();
    razonSocial = $('#razonSocialNueva' + fila).attr('option', 'selected').val();
    nomRazonSocial = $('select[name="razon"] option:selected').text();
    importeGasto = $('input[name=importeGasto]').val();
    numFacGasto = $('#numFacturaNueva' + fila).val();
    cantidadGasto = $('#cantidadGastoNueva' + fila).val();
    ivaGasto = $('#ivaGastoNueva' + fila).val();
    irpf = $('#irpfNueva' + fila).val();
    idAccionProy = $('#idAccionProy').val();
    totalGasto = $('#totalGastoNueva' + fila).val();
    fechaGasto = $('#fechaFacturaNueva' + fila).val();
    concepto = $('#editorNueva' + fila).val();
    fechaPago = $('#fechaCobroNueva' + fila).val();
    iban = $('#ibanGastoNueva' + fila).attr('option', 'selected').val();
    comun = 0;



    // console.log(tipoGasto);
    // console.log(nomTipoGasto);
    // console.log(tipoProveedor);
    // console.log(razonSocial);
    // console.log(nomRazonSocial);
    // console.log(importeGasto);
    // console.log(numFacGasto);
    // console.log(cantidadGasto);
    // console.log(ivaGasto);
    // console.log(irpf);
    // console.log(idAccionProy);
    // console.log(totalGasto);
    // console.log(fechaGasto);
    // console.log(concepto);
    // console.log(fechaPago);
    console.log(iban);




    if (tipoGasto == '' || tipoGasto == null) {
      alert('Debe ingresar un tipo de gasto.');
    } else if (tipoProveedor == '' || tipoProveedor == null) {
      alert('Debe ingresar un tipo de proveedor.');
    } else if (razonSocial == '' || razonSocial == null) {
      alert('Debe ingresar la razón social.');
    } else if (importeGasto == 0 || importeGasto == '') {
      alert('Debe ingresar un valor mayor a cero en el importe de gasto.');
    } else if (cantidadGasto == 0 || cantidadGasto == '') {
      alert('Debe ingresar un valor mayor a cero en cantidad.');
    } else if (totalGasto == 0 || totalGasto == '') {
      alert('El total de la factura no puede ser cero.');
    } else {
      var bool = confirm("¿Seguro de añadir este gasto al proyecto?");
      if (bool) {
        $.ajax({
          type: "POST",
          data: {
            'idAccionProy': idAccionProy, 'tipoGasto': tipoGasto, 'tipoProveedor': tipoProveedor,
            'razonSocial': razonSocial, 'importeGasto': importeGasto, 'cantidadGasto': cantidadGasto,
            'ivaGasto': ivaGasto, 'irpf': irpf, 'totalGasto': totalGasto, 'fechaGasto': fechaGasto,
            'numFacGasto': numFacGasto, 'descripcion': concepto, 'fechaPago': fechaPago, 'iban': iban,
            'comun': comun

          },
          url: "../../Proyecto/agregarGastoAcccionProyecto",
          success: function (data) {

            if (data != 0 && data != '') {

              $('#btnGuardarGasto' + fila).css("display", "none");
              Swal.fire({
                text: 'Se ha guardado corréctamente la factura de gasto',
                icon: 'success',
                confirmButtonText: 'Ok'
              });
              recargarPagina();
              //$( ".mensajevalidacionFactura" ).text( "" ).show().fadeOut( 1500 );
            } else {
              Swal.fire({
                title: 'Error',
                text: 'No se han guardado los datos, comprueba tu conexión',
                icon: 'error',
                confirmButtonText: 'Ok'
              });
            }

          }
        });
      }
    }
  });


  $(document).on('click', '.btnGuardarGastoComun', function (e) {

    fila = $(this).data('indice');

    tipoGasto = $('#gastoComunNueva' + fila).attr('option', 'selected').val();
    nomTipoGasto = $('select[name="gasto"] option:selected').text();
    tipoProveedor = $('#proveedorComunNueva' + fila).attr('option', 'selected').val();
    razonSocial = $('#razonSocialComunNueva' + fila).attr('option', 'selected').val();
    nomRazonSocial = $('select[name="razon"] option:selected').text();
    importeGasto = $('input[name=importeGasto]').val();
    numFacGasto = $('#numFacturaComunNueva' + fila).val();
    cantidadGasto = $('#cantidadGastoComunNueva' + fila).val();
    ivaGasto = $('#ivaGastoComunNueva' + fila).val();
    irpf = $('#irpfComunNueva' + fila).val();
    idAccionProy = $('#idAccionProy').val();
    totalGasto = $('#totalGastoComunNueva' + fila).val();
    fechaGasto = $('#fechaFacturaComunNueva' + fila).val();
    concepto = $('#editorComunNueva' + fila).val();
    fechaPago = $('#fechaCobroComunNueva' + fila).val();
    iban = null;
    comun = 1;
    form = $("#addClientesGastos" + fila).serializeArray();



    // console.log(tipoGasto);
    // console.log(nomTipoGasto);
    // console.log(tipoProveedor);
    // console.log(razonSocial);
    // console.log(nomRazonSocial);
    // console.log(importeGasto);
    // console.log(numFacGasto);
    // console.log(cantidadGasto);
    // console.log(ivaGasto);
    // console.log(irpf);
    // console.log(idAccionProy);
    // console.log(totalGasto);
    // console.log(fechaGasto);
    // console.log(concepto);
    // console.log(fechaPago);
    // console.log(iban);
    // console.log(form);




    if (tipoGasto == '' || tipoGasto == null) {
      alert('Debe ingresar un tipo de gasto.');
    } else if (tipoProveedor == '' || tipoProveedor == null) {
      alert('Debe ingresar un tipo de proveedor.');
    } else if (razonSocial == '' || razonSocial == null) {
      alert('Debe ingresar la razón social.');
    } else if (importeGasto == 0 || importeGasto == '') {
      alert('Debe ingresar un valor mayor a cero en el importe de gasto.');
    } else if (cantidadGasto == 0 || cantidadGasto == '') {
      alert('Debe ingresar un valor mayor a cero en cantidad.');
    } else if (totalGasto == 0 || totalGasto == '') {
      alert('El total de la factura no puede ser cero.');
    } else {
      var bool = confirm("¿Seguro de añadir este gasto al proyecto?");
      if (bool) {
        $.ajax({
          type: "POST",
          data: {
            'idAccionProy': idAccionProy, 'tipoGasto': tipoGasto, 'tipoProveedor': tipoProveedor,
            'razonSocial': razonSocial, 'importeGasto': importeGasto, 'cantidadGasto': cantidadGasto,
            'ivaGasto': ivaGasto, 'irpf': irpf, 'totalGasto': totalGasto, 'fechaGasto': fechaGasto,
            'numFacGasto': numFacGasto, 'descripcion': concepto, 'fechaPago': fechaPago, 'iban': iban, 'comun': comun,
            'form': form
          },
          url: "../../Proyecto/agregarGastoAcccionProyecto",
          success: function (data) {

            if (data != 0 && data != '') {

              $('#btnGuardarGastoComun' + fila).css("display", "none");
              Swal.fire({
                text: 'Se ha guardado corréctamente la factura de gasto',
                icon: 'success',
                confirmButtonText: 'Ok'
              });
              $('#checkGastosComunes').val(0);
              recargarPagina();
              //$( ".mensajevalidacionFactura" ).text( "" ).show().fadeOut( 1500 );
            } else {
              Swal.fire({
                title: 'Error',
                text: 'No se han guardado los datos, comprueba tu conexión',
                icon: 'error',
                confirmButtonText: 'Ok'
              });
            }

          }
        });
      }
    }
  });


  //Calculo del total de la factura modificando si se modifican los input importe, iva y cantidad
  //ojo que debe ser cuando cambia el valor pero solo hace cuando quito el foco del campo y ha cambiado, corregir
  function calcularTotalGasto(fila, nueva, comun) {
    var importeGasto = $('#importeGasto' + comun + nueva + fila).val();
    var cantidadGasto = $('#cantidadGasto' + comun + nueva + fila).val();
    var iva = $('#ivaGasto' + comun + nueva + fila).val();
    var irpf = $('#irpf' + comun + nueva + fila).val();

    var resultadoPrevio = parseFloat(importeGasto) * parseFloat(cantidadGasto);
    if (iva) {
      importeIva = resultadoPrevio * (iva / 100);
    } else {
      importeIva = 0;
    }
    if (irpf) {
      importeirpf = resultadoPrevio * (irpf / 100);
    } else {
      importeirpf = 0;
    }
    var resultado = parseFloat(resultadoPrevio + importeIva - importeirpf).toFixed(2);
    $('#totalGasto' + comun + nueva + fila).val(resultado);

    if (comun != '') {
      $('#importeRestante' + fila).val(importeGasto * (-1));
    }


  }

  $(document).on('keyup', '.importeGasto', function () {
    fila = $(this).data('fila');
    nueva = '';
    comun = '';

    if ($(this).data('nueva') == 1) {
      nueva = 'Nueva';
    }

    if ($(this).data('comun') == 1) {
      comun = 'Comun';
    }

    calcularTotalGasto(fila, nueva, comun);
    //alert(fila);
  });

  $(document).on('keyup', '.cantidadGasto', function () {
    fila = $(this).data('fila');
    nueva = '';
    comun = '';

    if ($(this).data('comun') == 1) {
      comun = 'Comun';
    }

    if ($(this).data('nueva') == 1) {
      nueva = 'Nueva';
    }
    calcularTotalGasto(fila, nueva, comun);
    //alert(fila);
  });

  $(document).on('keyup', '.irpf', function () {
    fila = $(this).data('fila');
    nueva = '';
    comun = '';

    if ($(this).data('comun') == 1) {
      comun = 'Comun';
    }

    if ($(this).data('nueva') == 1) {
      nueva = 'Nueva';
    }
    calcularTotalGasto(fila, nueva, comun);
    //alert(fila);
  });

  $(document).on('keyup', '.ivaGasto', function () {
    fila = $(this).data('fila');
    nueva = '';
    comun = '';

    if ($(this).data('comun') == 1) {
      comun = 'Comun';
    }

    if ($(this).data('nueva') == 1) {
      nueva = 'Nueva';
    }
    calcularTotalGasto(fila, nueva, comun);
    //alert(fila);
  });

  $(document).on('focusout', '.importeClienteNueva', function () {
    fila = $(this).data('fila');
    posicion = $(this).data('posicion');

    calcularTotalGastoComun(fila, posicion);
    //alert(fila);
  });

  function calcularTotalGastoComun(fila, posicion) {

    let total = 0;

    let importe = $('#importeGastoComunNueva' + posicion).val();

    $(".importeClienteNueva").each(function () {
      total += parseFloat($(this).val());
    });

    let resta = total - importe;
    $('#importeRestante' + posicion).val(resta);
  }


  //ASIGNACION DE PROFESOR
  $("#razonSocialProfesor").on("change", function () {
    //capturo el idPROFESOR
    profesor = $(this).attr('option', 'selected').val();

    $.ajax({
      type: "POST",
      url: "../../Proyecto/getProfesores",
      data: {
        'profesor': profesor
      },
      success: function (respuesta) {
        respuesta = JSON.parse(respuesta);
        $('#cif').text(respuesta['nifdniprofesor']);
        $('#nombreComercial').text(respuesta['NOMBRECOMERCIAL']);
      }
    });
  });

  $(document).on('click', '#btnAsignaProfesor', function (e) {

    idProfesor = $('#razonSocialProfesor').attr('option', 'selected').val();
    idProyecto = $('#idProyecto').val();
    profInterno = $('#profInterno').val();
    obsProfesor = $('#obsProfesor').val();

    nombreProfesor = $('select[name="razonSocialProfesor"] option:selected').text();
    cif = $('#cif').text();
    nombreComercial = $('#nombreComercial').text();

    if (idProfesor == '') {
      alert('Seleccione un profesor.'); //no funciona
    } else {
      var bool = confirm("¿Seguro de asignar el profesor al proyecto?");
      if (bool) {
        $.ajax({
          type: "POST",
          data: {
            'idProfesor': idProfesor, 'idProyecto': idProyecto, 'profInterno': profInterno, 'obsProfesor': obsProfesor
          },
          url: "../../Proyecto/asignarProfesorProyecto",
          success: function (data) {
            data = JSON.parse(data);
            //console.log(data);                  
            var fila = '<tr>' +
              '<td><input class="form-control" value="' + nombreProfesor + '" readonly></input></td>' +
              '<td><input class="form-control" value="' + cif + '" readonly></input></td>' +
              '<td><input class="form-control importeFactura" value="' + nombreComercial + '" readonly></input></td>' +
              '<td><input class="form-control cantidad" value="' + profInterno + '" readonly></input></td>' +
              '<td><input class="form-control iva" value="' + obsProfesor + '" readonly></input></td>' +
              '<td></td>' +
              '</tr>';
            $('#tablaProfesores').append(fila);
            //limpiar los input para ingresar nuevos datos                                        
            $('input[name=profInterno]').val('');
            $('input[name=obsProfesor]').val('');
            $('#cif').text('');
            $('#nombreComercial').text('');
          }
        });
      }
    }
  });

  //PARTICIPANTES
  //mostrar apartado para subida de fichero    
  $('#importarPlantilla').click(function (e) {
    e.preventDefault();
    if ($('#formularioSubirFichero').is(':visible')) {
      $('#formularioSubirFichero').slideUp(300);
    } else {
      $('#formularioSubirFichero').slideDown(300);
    }
  });

  var alumno_id, opcion;
  opcion = 4;
  if ($('#idProyecto').val()) {
    var idProy = $('#idProyecto').val();
  }

  tablaPersonas = $('#tablaParticipantes').DataTable({
    "ajax": {
      //"url": "bd/crud.php",
      "url": "../../Proyecto/crudParticipantes",
      "method": 'POST', //usamos el metodo POST
      "data": { opcion: opcion, idProyecto: idProy }, //enviamos opcion 4 para que haga un SELECT
      "dataSrc": ""
    },
    "columns": [
      { "data": "IDPARTICIPANTE" },
      { "data": "DocIdentidad" },
      { "data": "Nombre" },
      { "data": "Apellido1" },
      { "data": "Apellido2" },
      { "data": "idEmpresa" },
      { "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btn-sm btnEditar'>Editar</button><button class='btn btn-danger btn-sm btnBorrar'>Borrar</button><a class='btn btn-success btn-sm btnPdfDiploma' style='color:white'>Diploma</a></div></div>" }
    ]
  });


  var filaParticipante; //capturar la fila para editar o borrar el registro

  //agregar el nuevo participante
  $(document).on("click", ".btnGuardarPart", function (e) {

    e.preventDefault();

    form = $('#formularioParticipantes').serializeArray();
    idProyecto = idProy;
    opcion = $('#opcionCRUD').val();
    idParticipante = $('#idParticipante').val();

    for (let index = 0; index < 4; index++) {
      
        if(form[index]["value"] == ""){
          alert("Campo " + form[index]["name"] + " no puede estar vacio" );
          return;
        }
    }

    $.ajax({
      url: "../../Proyecto/crudParticipantes",
      type: "POST",
      dataType: "json",
      data: {form:form,idProyecto:idProyecto, opcion:opcion, idParticipante: idParticipante},
      success: function (data) {
        console.log(data);
        tablaPersonas.ajax.reload(null, false);
        $('#modalCRUD').modal('hide');
      }
    });
    
  });

  // modal nuevo participante
  $("#btnNuevo").click(function () {
    opcion = 1; //alta           
    alumno_id = null;
    $('#opcionCRUD').val(1);
    $("#formularioParticipantes").trigger("reset");
    //limpiar campos
  
    $(".modal-header").css("background-color", "#001f3f");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Nuevo participante");
    $("#modalCRUD").modal("show");

    $.ajax({
      url: "../../Proyecto/obtenerDatosSelects",
      type: "POST",
      dataType: "json", 
      success: function (data) {

        for (let index = 0; index < data['Estudios'].length; index++) {
          // tail.select('#idEmpleadoBD').options.add("'" + data[index]['Id'] + "'", data[index]['informacion'], "", false, false, false, true);

          let opciones = {
            id:data['Estudios'][index]['CODNIVEL'],
            text:data['Estudios'][index]['DESNIVEL']
          };
  
          let newOption = new Option(opciones.text, opciones.id, false, false);
          $('#nivelEstudiosParticipante').append(newOption).trigger('change');
        }


        for (let index = 0; index < data['Categoria'].length; index++) {
          // tail.select('#idEmpleadoBD').options.add("'" + data[index]['Id'] + "'", data[index]['informacion'], "", false, false, false, true);

          let opciones = {
            id:Number(data['Categoria'][index]['CODCATEGORIA']),
            text:data['Categoria'][index]['DESCATEGORIA']
          };
  
          let newOption = new Option(opciones.text, opciones.id, false, false);
          $('#catProfesionalParticipante').append(newOption).trigger('change');
        }

      
        for (let index = 0; index < data['Grupo'].length; index++) {
          // tail.select('#idEmpleadoBD').options.add("'" + data[index]['Id'] + "'", data[index]['informacion'], "", false, false, false, true);

          let opciones = {
            id:Number(data['Grupo'][index]['CODCOTIZACION']),
            text:data['Grupo'][index]['DESCOTIZACION']
          };
  
          let newOption = new Option(opciones.text, opciones.id, false, false);
          $('#grupoCotizacionParticipante').append(newOption).trigger('change');
        }

      }
    });

  });

  // modal para editar participante
  $(document).on("click", ".btnEditar", function () {
    opcion = 2; //editar
    filaParticipante = $(this).closest("tr");
    alumno_id = parseInt(filaParticipante.find('td:eq(0)').text()); //capturo el id

    $('#opcionCRUD').val(2); 
    $('#idParticipante').val(alumno_id); 

    $("#nivelEstudiosParticipante").empty().trigger('change');
    $("#catProfesionalParticipante").empty().trigger('change');
    $("#grupoCotizacionParticipante").empty().trigger('change');


    $.ajax({
      url: "../../Proyecto/obtenerDatosParticipante",
      type: "POST",
      dataType: "json", 
      data:{idParticipante:alumno_id},
      success: function (datos) {

        for (let index = 0; index < datos['datosSelect']['Estudios'].length; index++) {


          let opciones = {
            id:datos['datosSelect']['Estudios'][index]['CODNIVEL'],
            text:datos['datosSelect']['Estudios'][index]['DESNIVEL']
          };

          if(opciones.id == datos['datosParticipante']['NivelEstudios']){
            let newOption = new Option(opciones.text, opciones.id, true, true);
            $('#nivelEstudiosParticipante').append(newOption).trigger('change');
          }else{
            let newOption = new Option(opciones.text, opciones.id, true, false);
            $('#nivelEstudiosParticipante').append(newOption).trigger('change');
          }
        }


        for (let index = 0; index < datos['datosSelect']['Categoria'].length; index++) {


          let opciones = {
            id:Number(datos['datosSelect']['Categoria'][index]['CODCATEGORIA']),
            text:datos['datosSelect']['Categoria'][index]['DESCATEGORIA']
          };


          if(opciones.id == datos['datosParticipante']['Categoria']){
            let newOption = new Option(opciones.text, opciones.id, true, true);
            $('#catProfesionalParticipante').append(newOption).trigger('change');
          }else{
            let newOption = new Option(opciones.text, opciones.id, true, false);
            $('#catProfesionalParticipante').append(newOption).trigger('change');
          }
        }

      
        for (let index = 0; index < datos['datosSelect']['Grupo'].length; index++) {


          let opciones = {
            id:Number(datos['datosSelect']['Grupo'][index]['CODCOTIZACION']),
            text:datos['datosSelect']['Grupo'][index]['DESCOTIZACION']
          };
  
          if(opciones.id == datos['datosParticipante']['grupoCotizacion']){
            let newOption = new Option(opciones.text, opciones.id, true, true);
            $('#grupoCotizacionParticipante').append(newOption).trigger('change');
          }else{
            let newOption = new Option(opciones.text, opciones.id, true, false);
            $('#grupoCotizacionParticipante').append(newOption).trigger('change');
          }

        }
        
        $('#dniParticipante').val(datos['datosParticipante'].DocIdentidad);
        $('#nombreParticipante').val(datos['datosParticipante'].Nombre);
        $('#apellido1Participante').val(datos['datosParticipante'].Apellido1);
        $('#apellido2Participante').val(datos['datosParticipante'].Apellido2);
        $('#fechaNacimientoParticipante').val(datos['datosParticipante'].FechaNacimiento);
        $('#emailParticipante').val(datos['datosParticipante'].Correo);
        $('#telefonoParticipante').val(datos['datosParticipante'].Telefono);
        $('#numSocialParticipante').val(datos['datosParticipante'].NumSegSocial);
        $('#sexoParticipante').val(datos['datosParticipante'].Sexo).trigger('change');
        $('#discapacidadParticipante').val(datos['datosParticipante'].Discapacidad);
        $('#terrorismoParticipante').val(datos['datosParticipante'].terrorismo);
        $('#violenciaGeneroParticipante').val(datos['datosParticipante'].violenciaGenero);
        $('#fechaAltaParticipante').val(datos['datosParticipante'].fechaAlta);
        $('#numPatronalParticipante').val(datos['datosParticipante'].numPatronal);

      }
    });

    $(".modal-header").css("background-color", "#007bff");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Editar participante");
    $("#modalCRUD").modal("show");

  });

  $(document).on('click', '.btnPdfDiploma', function () {
    filaParticipante = $(this).closest("tr");
    alumno_id = parseInt(filaParticipante.find('td:eq(0)').text()); //capturo el id
    //alert(alumno_id);
    window.open(urlCompleta + "/documentosPdf/exportarDiploma/" + alumno_id);
  });


  //Borrar
  $(document).on("click", ".btnBorrar", function (e) {
    //filaParticipante = $(this);
    e.preventDefault();
    filaParticipante = $(this).closest("tr");
    filaParticipante2 = $(this);
    alumno_id = parseInt($(this).closest('tr').find('td:eq(0)').text());
    nombre = filaParticipante.find('td:eq(2)').text();
    apellido1 = filaParticipante.find('td:eq(3)').text();
    apellido2 = filaParticipante.find('td:eq(4)').text();
    opcion = 3; //eliminar

    var respuesta = confirm("¿Está seguro de borrar el registro " + nombre + " " + apellido1 + " " + apellido2 + " ?");
    if (respuesta) {
      $.ajax({
        url: "../../Proyecto/crudParticipantes",
        type: "POST",
        datatype: "json",
        data: { opcion: opcion, alumno_id: alumno_id },
        success: function () {
          tablaPersonas.row(filaParticipante2.parents('tr')).remove().draw();
        }
      });
    } else {

    }
  });


  // modal nuevo para agregar participante desde la BD
  $("#addFromBD").click(function () {
    opcion = 5;
    alumno_id = null;
    //limpiar campos
    $("#empleadoBD").val('');

    //$(".participantesBD").css("background-color", "#4e555b;");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Agregar participante desde la base de Datos");
    $("#modalAddExistente").modal("show");

    $.ajax({
      url: "../../Proyecto/cargarEmpleados",
      type: "POST",
      dataType: "json",
      data: {
      },
      success: function (data) {

        console.log(data);
        
        for (let index = 0; index <= data.length; index++) {
          // tail.select('#idEmpleadoBD').options.add("'" + data[index]['Id'] + "'", data[index]['informacion'], "", false, false, false, true);
          let opciones = {
            id:Number(data[index]['Id']),
            text:data[index]['informacion']
          };
  
          let newOption = new Option(opciones.text, opciones.id, false, false);
          $('#idEmpleadoBD').append(newOption).trigger('change');
        }

      }
    });

  });

  //agregar el nuevo participante
  $(document).on("click", "#btnAnadirPart", function (e) {
    e.preventDefault();

    idEmpleado = $('select[name="idEmpleadoBD"] option:selected').val();
    idProyecto = idProy;

    $.ajax({
      url: "../../Proyecto/crudParticipantes",
      type: "POST",
      dataType: "json",
      data: {
        opcion: opcion, idProyecto: idProyecto, idEmpleado: idEmpleado
      },
      success: function (data) {
        console.log(data);
        tablaPersonas.ajax.reload(null, false);
      }
    });
    $("#modalAddExistente").modal("hide");
  });


  $(document).on("click", "#enviarFormulario1", function () {
    //alert ('desea enviar el documento');
    var mensaje = confirm("¿Está seguro de enviar el documento sin datos a  ... ?");
    if (mensaje) {
      alert('Se ha enviado el email con éxito');
    }
  });

  $(document).on("click", "#enviarFormulario2", function () {
    //alert ('desea enviar el documento');
    var mensaje = confirm("¿Está seguro de enviar el documento con datos a  ... ?");
    if (mensaje) {
      alert('Se ha enviado el email con éxito');
    }
  });

  $(document).on("click", ".btnPDFFacturar", function () {

    let tipoFolio = $('#tipoFolioSeleccionado').val();

    let id = $(this).data('indice');

    window.open(urlCompleta + "/Proyecto/exportarPdfFactura1/" + id + "/" + tipoFolio);

 });
  

  $(document).on("click", "#btnGenerarPdf", function () {
    tipoDocSelect2 = $('#tipoDocSelect2').val();
    idProyecto = $("#idProyecto").val();
    //tipoDoc = $(this).data('id');
    idEmpresa = $('#clienteSel').attr('option', 'selected').val();
    if (idEmpresa == '' || idEmpresa <= 0) {
      alert('Debe seleccionar un cliente');
    } else if (tipoDocSelect2 == '' || tipoDocSelect2 <= 0) {
      alert('Debe seleccionar un documento');
    } else {
      window.open(urlCompleta + "/documentosPdf/exportarDocProyecto/" + idProyecto + "/" + tipoDocSelect2 + "/" + idEmpresa);
    }
  });

  $(document).on("click", "#btnDownloadDoc", function () {
    tipoDocSelect1 = $('#tipoDocSelect1').val();
    idProyecto = $("#idProyecto").val();
    //tipoDoc = $(this).data('id');
    idEmpresa = $('#clienteSel').attr('option', 'selected').val();
    if (idEmpresa == '' || idEmpresa <= 0) {
      alert('Debe seleccionar un cliente');
    } else if (tipoDocSelect1 == '' || tipoDocSelect1 <= 0) {
      alert('Debe seleccionar un documento');
    } else {
      window.open(urlCompleta + "/documentosPdf/exportarDocProyecto/" + idProyecto + "/" + tipoDocSelect1 + "/" + idEmpresa);
    }
  });


  //limpia el contenido del concepto
  $(document).on('click', '#btnLimpiarConcepto', function () {
    $('#editor5').summernote('code', '');
  });

  // modal para editar concepto    
  $(document).on("click", ".btnEditarConcepto", function () {

    $(".modal-header").css("background-color", "#e9ecef");
    $(".modal-header").css("color", "black");
    $(".modal-title").text("Editar concepto");
    $("#modalConcepto").modal("show");

    CKEDITOR.replace('editor5');
    CKEDITOR.instances.editor5.setData('');

    idFact = $(this).attr('data-idFac');

    $.ajax({
      type: 'POST',
      url: '../../Proyecto/obtenerConcepto',
      data: { 'idFact': idFact },
      dataType: "JSON"
    }).done(function (data) {
      console.log(data);
      //let data = data;				
      CKEDITOR.instances.editor5.insertHtml(data);
    })

  });

  //Crud para subir fichero proyecto por ajax --------------------cambiar el opcion se repite en participantes
  //mostrar apartado para subida de fichero
  $('#anadirFicheroProy').click(function (e) {
    e.preventDefault();
    if ($('#formularioSubirFicheroProy').is(':visible')) {
      $('#formularioSubirFicheroProy').slideUp(300);
    } else {
      $('#formularioSubirFicheroProy').slideDown(300);
    }
  });

  var docProy_id, opcion;
  opcion = 4;
  /*if ($('#idProyecto').val()) {
    var idProy = $('#idProyecto').val();
  }*/

  tablaDocProy = $('#tablaDocumentosproyecto').DataTable({
    "ajax": {
      //"url": "bd/crud.php",
      "url": "../../Proyecto/crudFicherosProyecto",
      "method": 'POST', //usamos el metodo POST
      "data": { 'opcion': opcion, 'idProyecto': idProy }, //enviamos opcion 4 para que haga un SELECT
      "dataSrc": ""
    },
    "columns": [
      { "data": "idDocumento" },
      { "data": "idProyecto" },
      { "data": "tipo" },
      { "data": "nombre" },
      { "data": "descripcion" },
      { "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-danger btn-sm btnBorrarFicheroProy'>Borrar</button><a class='btn btn-success btn-sm btnDownloadFicherProy' style='color:white'>Descargar</a></div></div>" }
    ]
  });


  var filaDocProyecto; //capturar la fila para editar o borrar el registro

  //agregar el nuevo participante
  $(document).on("click", "#btnAnadirFichero", function (e) {
    e.preventDefault();

    var paqueteDeDatos = new FormData();

    paqueteDeDatos.append('archivo', $('#ficheroProyecto')[0].files[0]);
    paqueteDeDatos.append('nombre', $('#nombreFicheroProy').prop('value'));
    paqueteDeDatos.append('opcion', 1);
    paqueteDeDatos.append('idProyecto', idProy);

    //var destino = "recibir.php"; // El script que va a recibir los campos de formulario.

    /* Se envia el paquete de datos por ajax. */
    $.ajax({

      url: "../../Proyecto/crudFicherosProyecto",
      type: 'POST', // Siempre que se envíen ficheros, por POST, no por GET.
      contentType: false,
      data: paqueteDeDatos, // Al atributo data se le asigna el objeto FormData.
      processData: false,
      cache: false,
      success: function (resultado) { // En caso de que todo salga bien.
        console.log(resultado);
        tablaDocProy.ajax.reload(null, false);
      },

      error: function () { // Si hay algún error.
        alert("Algo ha fallado.");
      }

    });
  });

  $(document).on("click", "#btnAddFicheroParticipantes", function () {
  
    var paqueteDeDatos = new FormData();

    paqueteDeDatos.append('archivo', $('#plantillaParticipantes')[0].files[0]);
    paqueteDeDatos.append('nombre', $('#descripcionFicheroParticipantes').prop('value'));
    paqueteDeDatos.append('opcion', 1);
    paqueteDeDatos.append('idProyecto', idProy);

    
    $.ajax({
      processData: false,
      cache: false,
      contentType: false,
      url: urlCompleta+"/Proyecto/subirImportarPlantillaParticipantes",
      type: 'POST', 
      data:paqueteDeDatos,
      dataType: "JSON",  
      success: function (resultado) { 
      }
    });
  });

  $(document).on('click', '.btnDownloadFicherProy', function () {
    filaDocProyecto = $(this).closest("tr");
    docProy_id = parseInt(filaDocProyecto.find('td:eq(0)').text()); //capturo el id
    nombreFichero = filaDocProyecto.find('td:eq(3)').text();
    //alert(alumno_id);
    window.open(urlCompleta + "/proyecto/descargarFicherosProyecto/" + nombreFichero);
  });

  //Borrar Fichero
  $(document).on("click", ".btnBorrarFicheroProy", function (e) {
    //filaDocProyecto = $(this);
    e.preventDefault();
    filaDocProyecto = $(this).closest("tr");
    filaDocProyecto2 = $(this);
    docProy_id = parseInt($(this).closest('tr').find('td:eq(0)').text());
    nombreFichero = filaDocProyecto.find('td:eq(3)').text();
    opcion = 3; //eliminar

    var respuesta = confirm("¿Está seguro de borrar el documento seleccionado " + nombreFichero + " ?");
    if (respuesta) {
      $.ajax({
        url: "../../Proyecto/crudFicherosProyecto",
        type: "POST",
        datatype: "json",
        data: { 'opcion': opcion, 'docProy_id': docProy_id },
        success: function (resultado) {
          if (resultado == 'true') {
            tablaDocProy.row(filaDocProyecto2.parents('tr')).remove().draw();
          }
        }
      });
    } else {

    }
  });

  //ACTUALIZAR CAMPOS CON FOCUSOUT Y CHANGE EN FICHA DE PROYECTO

  //Actualizar campos input de ficha de proyecto
  $('.inputAuto').on("focusout", function () {
    tabla = $(this).data('tabla');
    idtabla = $(this).data('idtabla');
    campo = $(this).data('campo');
    valid = $(this).data('valid');
    if (tabla == 'presupuesto') {
      id = $('#idPresupuesto').val();
    } else if (tabla == 'proyectos') {
      id = $('#idProyecto').val();
    }

    contenido = $(this).val();

    $.ajax({
      url: urlCompleta + "/Presupuesto/actualizarCampoPresupuesto",
      data: { "tabla": tabla, "campo": campo, "contenido": contenido, "idtabla": idtabla, "id": id },
      type: "POST",
      dataType: "json",
      success: function (result) {

        if (result == 1) {
          $('#' + valid).addClass('is-valid');
          setTimeout(function () {
            $('#' + valid).removeClass('is-valid');
          }, 2000);
        } else {
          Swal.fire({
            title: 'Error',
            text: 'No se han actualizado los datos, comprueba tu conexión',
            icon: 'error',
            confirmButtonText: 'Ok'
          });
        }
      }
    });
  });

  //Actualizar campos select de ficha de proyecto
  $('.selectAuto').on("change", function () {
    tabla = $(this).data('tabla');
    idtabla = $(this).data('idtabla');
    campo = $(this).data('campo');
    valid = $(this).data('valid');
    if (tabla == 'presupuesto') {
      id = $('#idPresupuesto').val();
    } else if (tabla == 'proyectos') {
      id = $('#idProyecto').val();
    } else if (tabla == 'acciones_presupuesto') {
      id = $('#idAccionPres').val();
    }

    contenido = $(this).attr('option', 'selected').val();

    $.ajax({
      url: urlCompleta + "/Presupuesto/actualizarCampoPresupuesto",
      data: { "tabla": tabla, "campo": campo, "contenido": contenido, "idtabla": idtabla, "id": id },
      type: "POST",
      dataType: "json",
      success: function (result) {

        if (result == 1) {
          $('#' + valid).addClass('is-valid');
          setTimeout(function () {
            $('#' + valid).removeClass('is-valid');
          }, 2000);
        } else {
          Swal.fire({
            title: 'Error',
            text: 'No se han actualizado los datos, comprueba tu conexión',
            icon: 'error',
            confirmButtonText: 'Ok'
          });
        }
      }
    });
  });

  //Actualizar campos select de tipologías
  $('.selecteAutoTipologia').on("change", function () {
    valid = $(this).data('valid');
    idAccionPres = $('#idAccionPres').val();
    idAccionProy = $('#idAccionProy').val();
    contenido = $(this).attr('option', 'selected').val();

    $.ajax({
      url: urlCompleta + "/Presupuesto/actualizarTipologiasPresupuestoYProyecto",
      data: { "idAccionPres": idAccionPres, 'idAccionProy': idAccionProy, 'contenido': contenido },
      type: "POST",
      dataType: "json",
      success: function (result) {

        if (result == 1) {
          $('#' + valid).addClass('is-valid');
          setTimeout(function () {
            $('#' + valid).removeClass('is-valid');
          }, 2000);
        } else {
          Swal.fire({
            title: 'Error',
            text: 'No se han actualizado los datos, comprueba tu conexión',
            icon: 'error',
            confirmButtonText: 'Ok'
          });
        }
      }
    });
  });

  //Actualizar campos select de acciones
  $('.selectAutoAccion').on("change", function () {
    idAccion = $(this).attr('id');
    idProyecto = $('#idProyecto').val();
    contenido = $(this).attr('option', 'selected').val();

    $.ajax({
      url: urlCompleta + "/Presupuesto/actualizarAccionEnPresupuestoYProyecto",
      data: { 'idProyecto': idProyecto, 'contenido': contenido },
      type: "POST",
      dataType: "json",
      success: function (result) {

        if (result == 1) {
          $('#' + idAccion).addClass('is-valid');
          $('#idAccion').val(contenido);
          setTimeout(function () {
            $('#' + idAccion).removeClass('is-valid');
          }, 2000);
        } else {
          Swal.fire({
            title: 'Error',
            text: 'No se han actualizado los datos, comprueba tu conexión',
            icon: 'error',
            confirmButtonText: 'Ok'
          });
        }
      }
    });
  });

  //Actualizar modalidad y nivel en acciones_presupuesto y proyectos
  $('.selectAutoMultiCampo').on("change", function () {
    idAccion = $(this).attr('id');
    idProyecto = $('#idProyecto').val();
    contenido = $(this).attr('option', 'selected').val();
    campo = $(this).data('campo');

    $.ajax({
      url: urlCompleta + "/Presupuesto/actualizarDiferentesCamposEnPresupuestoYProyecto",
      data: { 'idProyecto': idProyecto, 'contenido': contenido, 'campo': campo },
      type: "POST",
      dataType: "json",
      success: function (result) {

        if (result == 1) {
          $('#' + idAccion).addClass('is-valid');
          setTimeout(function () {
            $('#' + idAccion).removeClass('is-valid');
          }, 2000);
        } else {
          Swal.fire({
            title: 'Error',
            text: 'No se han actualizado los datos, comprueba tu conexión',
            icon: 'error',
            confirmButtonText: 'Ok'
          });
        }
      }
    });
  });

  //Actualizar input importe desde proyecto por cada cliente:
  $('.selectInputImporte').on("focusout", function () {
    importe = $('#importeAccion').val();
    valid = $(this).data('valid');
    idAccionProy = $('#idAccionProy').val();
    idAccionPres = $('#idAccionPres').val();
    idPresupuesto = $('#idPresupuesto').val();

    $.ajax({
      url: urlCompleta + "/Presupuesto/actualizarImporteEnPresupuestoYProyecto",
      data: { 'importe': importe, 'idAccionProy': idAccionProy, 'idAccionPres': idAccionPres, 'idPresupuesto': idPresupuesto },
      type: "POST",
      dataType: "json",
      success: function (result) {

        if (result == 1) {
          $('#' + valid).addClass('is-valid');
          setTimeout(function () {
            $('#' + valid).removeClass('is-valid');
          }, 2000);
        } else {
          Swal.fire({
            title: 'Error',
            text: 'No se han actualizado los datos, comprueba tu conexión',
            icon: 'error',
            confirmButtonText: 'Ok'
          });
        }
      }
    });
  });


  //Actualizar inputs horas proyecto en proyecto y acciones_presupuesto
  $('.inputHoras').on("focusout", function () {

    valid = $(this).data('valid');
    campo = valid;
    idProyecto = $('#idProyecto').val();

    presenciales = $('#hPresenciales').val();
    teleformacion = $('#hTeleformacion').val();
    aulaVirtual = $('#hAulaVirtual').val();
    horas = $('#horas').val();

    $.ajax({
      url: urlCompleta + "/Proyecto/actualizarHorasEnPresupuestoYProyecto",
      data: { 'idProyecto': idProyecto, 'presenciales': presenciales, 'teleformacion': teleformacion, 'aulaVirtual': aulaVirtual, 'horas': horas },
      type: "POST",
      dataType: "json",
      success: function (result) {

        if (result == 1) {
          $('#' + valid).addClass('is-valid');
          setTimeout(function () {
            $('#' + valid).removeClass('is-valid');
          }, 2000);
        } else {
          Swal.fire({
            title: 'Error',
            text: 'No se han actualizado los datos, comprueba tu conexión',
            icon: 'error',
            confirmButtonText: 'Ok'
          });
        }
      }
    });

  });

  //autosuma de campo horas totales:
  $(document).on('keyup', '.sumarHoras', function () {

    presenciales = $('#hPresenciales').val();
    if (!presenciales || presenciales == null || presenciales == '') {
      presenciales = 0;
    }
    teleformacion = $('#hTeleformacion').val();
    if (!teleformacion || teleformacion == null || teleformacion == '') {
      teleformacion = 0;
    }
    aulaVirtual = $('#hAulaVirtual').val();
    if (!aulaVirtual || aulaVirtual == null || aulaVirtual == '') {
      aulaVirtual = 0;
    }
    total = parseFloat(presenciales) + parseFloat(teleformacion) + parseFloat(aulaVirtual);
    $('#horas').val(total);

  });

  //actualizar participantes por cliente desde proyecto

  $('#participantes').on("focusout", function () {
    numero = $('#clienteSel').val();
    valid = $(this).data('valid');
    participantes = $(this).val();

    if (numero && numero > 0 && numero != '' && numero != 'todos') {
      idAccionPres = $('#idAccionPres').val();

      $.ajax({
        url: urlCompleta + "/Proyecto/actualizarParticipantesEnPresupuesto",
        data: { 'idAccionPres': idAccionPres, 'participantes': participantes },
        type: "POST",
        dataType: "json",
        success: function (result) {

          if (result == 1) {
            $('#' + valid).addClass('is-valid');
            setTimeout(function () {
              $('#' + valid).removeClass('is-valid');
            }, 2000);
          } else {
            Swal.fire({
              title: 'Error',
              text: 'No se han actualizado los datos, comprueba tu conexión',
              icon: 'error',
              confirmButtonText: 'Ok'
            });
          }
        }
      });

    }
  });

  //agregar Líneas de factura de ingreso en IngresosGastos
  $(document).on("click", "#addLineaIngreso", function () {

    //cuento los divs que existentes dentro de <div id="lineasFacturas">      
    var totalInp = $('.lineas');
    var total = 0;

    totalInp.each(function () {
      total += 1;
    });

    idAccionProy = $('#idAccionProy').val();

    if (idAccionProy && idAccionProy > 0) {
      agregarLineaFactura(total, idAccionProy);
    } else {
      $("#msgValidacion").text("Debe seleccionar un cliente").show().fadeOut(1500);
    }

  });

  function agregarLineaFactura(total, idAccionProy) {
    //aqui me quedé. est funcion debe traer por ajax todo el html para añadir la factura     
    let negativo = 0;
    $.ajax({
      type: "POST",
      url: urlCompleta + "/Proyecto/agregarLineaFactura",
      //dataType: "json",
      data: {
        total: total, idAccionProy: idAccionProy, negativo: negativo
      },
      success: function (respuesta) {
        $('#lineasFacturas').append(respuesta);
        $('.select2').select2({
          theme: 'bootstrap4'
        });
      }
    });
  }

  $(document).on("click", ".facturaNegativa", function () {

    let indice = $(this).data('indice');

    let cantidad = $("#cantidad" + indice).val();
    let importe = $("#importeFactura" + indice).val() * (-1);
    let iva = $("#iva" + indice).val();
    let totalIngreso = $("#total" + indice).val() * (-1);
    let fecha = $("#fechaFactura" + indice).val();
    let iban = $('#iban' + indice).attr('option', 'selected').val();
    let fechaCobro = $("#fechaCobro" + indice).val();
    let concepto = $('#editor' + indice).summernote('code');
    let numFactura = $("#numFactura" + indice).val();
    let negativo = 1;

    //cuento los divs que existentes dentro de <div id="lineasFacturas">      
    var totalInp = $('.lineas');
    var total = 0;

    totalInp.each(function () {
      total += 1;
    });

    idAccionProy = $('#idAccionProy').val();

    if (idAccionProy && idAccionProy > 0) {

      $.ajax({
        type: "POST",
        url: urlCompleta + "/Proyecto/agregarLineaFactura",
        //dataType: "json",
        data: {
          total: total, idAccionProy: idAccionProy, cantidad: cantidad, importe: importe, iva: iva, totalIngreso: totalIngreso,
          fecha: fecha, iban: iban, fechaCobro: fechaCobro, concepto: concepto, numFactura: numFactura, negativo: negativo
        },
        success: function (respuesta) {
          $('#lineasFacturas').append(respuesta);
          $('.select2').select2({
            theme: 'bootstrap4'
          });
        }
      });


    } else {
      $("#msgValidacion").text("Debe seleccionar un cliente").show().fadeOut(1500);
    }

  });

  //Emisión de la factura
  $(document).on('click', '.btnFacturarFila', function () {
    indice = $(this).data('indice');
    precioFinal = $('#importeAccion').val();
    importeFactura = $('#importeFacturaNueva' + indice).val();
    cantidad = $('#cantidadNueva' + indice).val();
    importeBI = importeFactura * cantidad;

    if (importeBI == 0 || importeBI == '') {
      alert('El importe de la factura debe ser mayor a cero.');
    } else {
      idAccionProy = $('#idAccionProy').val();

      iva = $('#ivaNueva' + indice).val();
      total = $('#totalNueva' + indice).val();
      fecha = $('#fechaFacturaNueva' + indice).val();
      iban = $('#ibanNueva' + indice).attr('option', 'selected').val();
      tipoConcepto = $('#tipoConceptoNueva' + indice).attr('option', 'selected').val();
      fechaCobro = $('#fechaCobroNueva' + indice).val();
      hmtlConcepto = $('#editorNueva' + indice).summernote('code');
      idEmpresa = $('#clienteSel').attr('option', 'selected').val();
      idPresupuesto = $('#idPresupuesto').val();
      tipoFolio = $('#tipoFolioNueva' + indice).attr('option', 'selected').val();


      if ($('#checkPredefinidoNueva' + indice).is(":checked")) {
        valorPredefinido = 1;
      } else {
        valorPredefinido = $('#checkPredefinidoNueva' + indice).val();
      }


      //valida que vengan valores mayores a cero:
      if (importeFactura == 0 || importeFactura == '') {
        alert('El importe factura no es válido.');
      } else if (cantidad == 0 || cantidad == '') {
        alert('La cantidad no es válida.');
      } else if (fecha == 0 || fecha == '' || fecha == null) {
        alert('Ingrese la fecha de emisión de la factura.');
      } else if (iban == 0 || iban == '' || iban == null) {
        alert('No ha seleccionado la cuenta corriente.');
      } else {
        var bool = confirm("¿Seguro de generar la factura?");
        if (bool) {
          $.ajax({
            type: "POST",
            data: {
              'idAccionProy': idAccionProy, 'importeFactura': importeFactura,
              'cantidad': cantidad, 'iva': iva, 'total': total, 'fecha': fecha, 'idEmpresa': idEmpresa, 'idPresupuesto': idPresupuesto,
              'fechaCobro': fechaCobro, 'iban': iban, 'hmtlConcepto': hmtlConcepto, 'predefinido': valorPredefinido, 'tipoConcepto': tipoConcepto, 'tipoFolio':tipoFolio
            },
            url: "../../Proyecto/generarFactura",
            success: function (respuesta) {
              //respuesta = JSON.parse(respuesta);
              if (respuesta != 0 && respuesta != '') {
                $('#numFacturaNueva' + indice).val(respuesta);
                //ocultar el botón "Emitir Factura"
                $('#btnFacturarFila' + indice).css("display", "none");
                Swal.fire({
                  title: 'Factura emitida Nº ' + respuesta,
                  text: 'Se ha emitido corréctamente la factura',
                  icon: 'success',
                  confirmButtonText: 'Ok'
                });
                recargarPagina();
                //$( ".mensajevalidacionFactura" ).text( "" ).show().fadeOut( 1500 );
              } else {
                Swal.fire({
                  title: 'Error',
                  text: 'No se han actualizado los datos, comprueba tu conexión',
                  icon: 'error',
                  confirmButtonText: 'Ok'
                });
              }
            }
          });
        }
      }

    }
  });

  // modal para enviar email Factura
  $(document).on('click', '.enviarFactura', function () {
    let indice = $(this).data('indice');

    
    let tipoFolio = $('#tipoFolioSeleccionado'+indice).val();
    numFactura = $('#numFactura' + indice).val();
    $('#numFacturaEmail').val(numFactura);
    if (numFactura == '' || !numFactura) {
      alert('No existe ninguna factura para enviar');
    } else {
      idProyecto = $('#idProyecto').val();
      idCliente = $('#clienteSel').val();
      $('#tipoFolioPdf').val(tipoFolio);
      $('#idProyectoEmail').val(idProyecto);
      $(".modal-header").css("background-color", "#001f3f");
      $(".modal-header").css("color", "white");
      $(".modal-title").text("Configurar envío de factura");

      $('#msgEmailFactura').summernote({
        toolbar: [
          ['style', ['bold', 'italic', 'underline', 'clear']],
          ['font', ['strikethrough', 'superscript', 'subscript']],
          ['fontsize', ['fontsize']],
          ['color']


        ]
      });
      $("#modalEnvioFactura").modal("show");

      cargarSelectContactos(indice);

      cargarFirmaEditorEmail();


    }
  });

  //envio de email
  $(document).on('click', '#btnElegirEmail', function (e) {
    e.preventDefault();

    let lineaEmail = 0;

    $('#tablaEmailsEnvioFactura tr').each(function () {
      lineaEmail += 1;
    })


    mail = $('#mail').attr('option', 'selected').val();

    if (mail != '') {
      if (mail != 'otroEmail') {
        var filaEmail = '<tr>' +
          '<td><input class="form-control destinatario" style="font-size:0.85rem;" name="email[]" value="" /></td>' +
          '<td>' +
          '        <i class="fas fa-trash eliminarEmail"></i>' +
          '</td>' +
          '</tr>';
        $('#tablaEmailsEnvioFactura').append(filaEmail);
      } else if (mail == 'otroEmail') {
        var filaEmail2 = '<tr>' +
          '<td><input class="form-control destinatario" style="font-size:0.85rem;" name="email[]" /></td>' +
          '<td>' +
          '        <i class="fas fa-trash eliminarEmail"></i>' +
          '</td>' +
          '</tr>';
        $('#tablaEmailsEnvioFactura').append(filaEmail2);
      }
    }


  });

  $(document).on("click", '.eliminarEmail', function () {

    var filaEMail = $(this).closest('tr');
    filaEMail.remove();

  });


  $(document).on('click', '#btnEnviarEmail', function () {

    numFactura = $('#numFacturaEmail').val();
    tipoFolio = $('#tipoFolioPdf').val();
    //obtengo los destinatarios:
    var destinatarios = [];
    $('input.destinatario').each(function () {
      if ($(this).val() != '') {
        destinatarios.push($(this).val());
      }
    });

    asunto = $('#asunto').val();
    mensaje = $('#msgEmailFactura').summernote('code');

    $.ajax({
      type: "POST",
      url: "../../Proyecto/enviarEMailYFicheroPfd",
      data: {
        'emails': destinatarios,
        'numFactura': numFactura,
        'asunto': asunto,
        'mensaje': mensaje,
        'tipoFolio' : tipoFolio
      },


      beforeSend: function () {

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
          title: 'Enviando Factura...!'
        })

        // Swal.fire({
        //   title: 'Envío de Factura',
        //   text: 'Enviando Factura...',
        // });

      },

      success: function (data) {

        if (data == 1) {
          Swal.fire({
            title: 'Envío de Factura',
            text: 'Se ha enviado corréctamente la factura',
            icon: 'success',
            confirmButtonText: 'Ok'
          });
          $("#modalEnvioFactura").modal("hide");

        } else {
          Swal.fire({
            title: 'Error',
            text: 'No se ha podido enviar el email a los destinatarios',
            icon: 'error',
            confirmButtonText: 'Ok'
          });
        }
      }
    });



  });

  $(document).on('click', '#btnEmails', function () {


  });

  //enviar a PDF una factura después de crearla
  $(document).on('click', '.btnPDFFacturaNew', function () {
    indice = $(this).data('indice');
    numFactura = $('#numFactura' + indice).val();
    if (numFactura == '' || !numFactura) {
      alert('No existe ninguna factura para exportar');
    } else {
      window.open(urlCompleta + "/Proyecto/exportarFacturaPorNumFactura/" + numFactura);
    }
  });


  // editar concepto al crear nueva factura -----
  $(document).on('click', '.editarConcepto', function () {
    indice = $(this).data('indice');
    //convierte el textarea en editor  summernote
    $('#editor' + indice).summernote({
      toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color']
      ]
    });
    //$('#contEditorConcepto'+indice).css('display', 'block');      
    if ($('#contEditorConcepto' + indice).is(':visible')) {
      $('#contEditorConcepto' + indice).slideUp(500);
      $(this).html('Editar concepto <i class="fas fa-chevron-down"></i>');
    } else { //si no está visible   
      $('#contEditorConcepto' + indice).slideDown(500);
      $(this).html('Guardar edición <i class="fas fa-chevron-up"></i>');
    }
  });


  $(document).on('click', '.crearConcepto', function () {
    indice = $(this).data('indice');
    //convierte el textarea en editor  summernote
    $('#editorNueva' + indice).summernote({
      toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color']
      ]
    });
    //$('#contEditorConcepto'+indice).css('display', 'block');      
    if ($('#contEditorConceptoNueva' + indice).is(':visible')) {
      $('#contEditorConceptoNueva' + indice).slideUp(500);
      $(this).html('Editar concepto <i class="fas fa-chevron-down"></i>');
    } else { //si no está visible   
      $('#contEditorConceptoNueva' + indice).slideDown(500);
      $(this).html('Cerrar edición <i class="fas fa-chevron-up"></i>');
    }
  });

  $(document).on('click', '.repartirGastos', function () {
    indice = $(this).data('indice');
    if ($('#contRepartirGastos' + indice).is(':visible')) {
      $('#contRepartirGastos' + indice).slideUp(500);
      $(this).html('Editar repartición <i class="fas fa-chevron-down"></i>');
    } else { //si no está visible   
      $('#contRepartirGastos' + indice).slideDown(500);
      $(this).html('Cerrar repartición <i class="fas fa-chevron-up"></i>');
    }
  });

  //En la creación de la factura de ingreso
  //Al seleccionar el tipo concepto que envíe por ajax el tipo de concepto y devuelva html del concepto predefinido
  $(document).on('change', '.tipoConcepto', function () {

    indice = $(this).data('indice');
    nueva = '';

    if ($(this).data('nueva') == 1) {
      nueva = 'Nueva';
    }

    tipoConcepto = $('#tipoConcepto' + nueva + indice).attr('option', 'selected').val();
    idAccionProy = $('#idAccionProy').val();
    idAccionPres = $('#idAccionPres').val();

    $.ajax({
      type: "POST",
      data: {
        'tipoConcepto': tipoConcepto, 'idAccionProy': idAccionProy, 'idAccionPres': idAccionPres
      },
      url: "../../Proyecto/obtenerTipoConceptoFacturaIngreso",
      success: function (respuesta) {
        $('#editor' + nueva + indice).summernote({
          toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color']
          ]
        });
        $('#editor' + nueva + indice).summernote('code', '');
        $('#editor' + nueva + indice).summernote('code', respuesta);
      }
    });

    $('#contEditorConcepto' + nueva + indice).slideDown(500);
    $('#crearConcepto' + nueva + indice).html('Cerrar edición <i class="fas fa-chevron-up"></i>');

  });

  $(document).on("click", "#addLineaGasto", function () {

    var totalInp = $('.lineasGasto');
    var total = 0;

    totalInp.each(function () {
      total += 1;
    });

    idAccionProy = $('#idAccionProy').val();


    if (idAccionProy && idAccionProy > 0) {
      agregarLineaGasto(total, idAccionProy);
    } else {
      $("#msgValidacion").text("Debe seleccionar un cliente").show().fadeOut(1500);
    }

  });

  function agregarLineaGasto(total, idAccionProy) {

    $.ajax({
      type: "POST",
      url: urlCompleta + "/Proyecto/agregarLineaGasto",
      dataType: "json",
      data: {
        total: total, idAccionProy: idAccionProy
      },
      success: function (respuesta) {
        $('#contenedorLineasGastos').append(respuesta.html);

        tail.select('.tipoGasto', {
          search: true,
          locale: "es",
          multiSelectAll: false,
          searchMinLength: 0,
          multiContainer: false,
        });

      }
    });
  }

  $(document).on("click", "#addLineaGastoComun", function () {


    if ($('#checkGastosComunes').val() != 1) {


      var totalInp = $('.lineasGastoComun');
      var total = 0;
      var idProyecto = $("#idProyecto").val();

      totalInp.each(function () {
        total += 1;
      });

      idAccionProy = $('#idAccionProy').val();


      if (idAccionProy && idAccionProy > 0) {
        agregarLineaGastoComun(total, idAccionProy, idProyecto);
      } else {
        $("#msgValidacion").text("Debe seleccionar un cliente").show().fadeOut(1500);
      }

      $('#checkGastosComunes').val(1);
    }

  });

  function agregarLineaGastoComun(total, idAccionProy, idProyecto) {

    $.ajax({
      type: "POST",
      url: urlCompleta + "/Proyecto/agregarLineaGastoComun",
      dataType: "json",
      data: {
        total: total, idAccionProy: idAccionProy, idProyecto: idProyecto
      },
      success: function (respuesta) {
        $('#contenedorLineasGastosComunes').append(respuesta.html);

        tail.select('.tipoGasto', {
          search: true,
          locale: "es",
          multiSelectAll: false,
          searchMinLength: 0,
          multiContainer: false,
        });

      }
    });
  }


  //Cálculo del total de la factura modificando si se modifican los input importe, iva y cantidad
  //ojo que debe ser cuando cambia el valor pero solo hace cuando quito el foco del campo y ha cambiado, corregir

  function calcularTotal(fila, nueva) {
    var importeFact = $('#importeFactura' + nueva + fila).val();
    var cantidad = $('#cantidad' + nueva + fila).val();
    var iva = $('#iva' + nueva + fila).val();
    var irpf = $('#irpfF' + nueva + fila).val();

    console.log(importeFact);
    console.log(cantidad);
    console.log(iva);
    console.log(irpf);

    var resultadoPrevio = parseFloat(importeFact) * parseFloat(cantidad);
    if (iva) {
      importeIva = resultadoPrevio * (iva / 100);
    } else {
      importeIva = 0;
    }
    if (irpf) {
      importeirpf = resultadoPrevio * (irpf / 100);
    } else {
      importeirpf = 0;
    }
    var resultado = parseFloat(resultadoPrevio + importeIva - importeirpf).toFixed(2);
    $('#total' + nueva + fila).val(resultado);

  }

  $(document).on('keyup', '.inputRecalculo', function () {
    fila = $(this).data('fila');
    nueva = '';
    if ($(this).data('nueva') == 1) {
      nueva = 'Nueva';
    }
    console.log(nueva);
    calcularTotal(fila, nueva);

  });

  $(document).on('focusout', '.campotabla', function () {

    var valor;

    if (this.checked) {
      valor = 1;
    } else {
      valor = $(this).val();
    }

    let idfactura = $(this).data('idfactura');

    let tabla = $(this).data('tabla');
    url = "../core/model/Editar/app/controller/controladorEditar.php";
    let campo = $(this).attr('name');
    let pk = $(this).data('pk');

    if (tabla == 'facturascabecera') {
      total = "total" + idfactura;
    } else {
      total = "totalGasto" + idfactura;
    }

    console.log(tabla);
    console.log(valor);
    console.log(campo);
    console.log(pk);


    $.ajax({
      url: '../../Proyecto/editarFactura',
      type: "POST",
      data: { idfactura: idfactura, tabla: tabla, campo: campo, valor: valor, pk: pk },
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
        if (campo == 'codigo' || campo == 'cp') {
          $('#localidad').focusout();
          $('#provincia').focusout();
        }
      },

      error: function () {
        console.log("No se ha podido actualizar el dato, intente de nuevo");
      }
    });

    if (campo == "cantidad" || campo == "importe" || campo == "iva" || campo == "irpf") {

      let valortotal = $("#" + total).val();
      let campoTotal = "total"
      $.ajax({
        url: '../../Proyecto/editarFactura',
        type: "POST",
        data: { idfactura: idfactura, tabla: tabla, campo: campoTotal, valor: valortotal, pk: pk },
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
        }
      });
    }

  });

  //



  $(document).on('click', '.btnEliminarFila', function () {

    let posicion = $(this).data("indice");
    let diferencia = $(this).data("gastos");
    let comun = $(this).data("gastoscomun");

    if (diferencia == 1) {
      $("#lineaGastoNueva_" + posicion, document).remove();
    } else if (comun == 1) {
      $("#lineaGastoComunNueva_" + posicion, document).remove();
    } else {
      $("#lineaFacturaNueva_" + posicion, document).remove();
    }

  });

  $(document).on('click', '#btnTablaBalance', function () {
    $("#balance").load(location.href + " #balance");
  });

  $(document).on('click', '.detalleEmail', function () {

   
   
    let idEmail = $(this).data('id');

    $.ajax({
      url: '../../Proyecto/obtenerDatosEmailFactura',
      type: "POST",
      data: { idEmail: idEmail},
      success: function (respuesta) {
        datosJson = JSON.parse(respuesta);
        
        let fecha = new Date(datosJson.fecha);

        let fechaFormateada = fecha.getDate() + "-" + (fecha.getMonth() + 1) + "-" + fecha.getFullYear();

        $('#remitente').html("Remitente : " + datosJson.desde);
        $('#date').html(fechaFormateada);
        $('#destinatarios').html("Destinatarios : " + JSON.parse(datosJson.email));
        $('#contEmailDetallado').html(datosJson.contenido);
        $('#enlacePDFEmail').attr('href',"http://localhost/myfp/Proyecto/exportarPdfFactura1/"+datosJson.numeroprocedimiento);
      }
    });
  });

  
  $(document).on('click', '.btnEliminarGasto', function () {

    let idgasto = $(this).data("idgasto");
    let comun = ($(this).data('comun') == 1 ? 'Comun' : '');

    $("#lineaGasto" + comun + "_" + idgasto, document).remove();

    $.ajax({
      url: '../../Proyecto/eliminarGasto',
      type: "POST",
      data: { idgasto: idgasto },
      success: function (respuesta) {
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
          title: 'Eliminado Correctamente!'
        })
      }
    });

  });

  function recargarPagina() {

    var idCliente = $("#clienteSel").val();
    var idPresupuesto = $('#idPresupuesto').val();
    var idAccion = $('#idAccion').val();
    var fechaInicio = $('#fechaInicio').val();
    var idAccionProy = $('#idAccionProy').val();
    var idProyecto = $('#idProyecto').val();

    console.log(idCliente);
    console.log(idPresupuesto);
    console.log(idAccion);
    console.log(fechaInicio);
    console.log(idAccionProy);
    console.log(idProyecto);


    $("#contColaborador").css("display", "block");
    $("#contAgente").css("display", "block");
    $("#contImporte").css("display", "block");
    $("#contTodosLosClientes").css("display", "none");
    $.ajax({
      type: "POST",
      // cache: false,  
      data: {
        'idCliente': idCliente, 'idPresupuesto': idPresupuesto, 'idAccion': idAccion, 'fechaInicio': fechaInicio,
        'idAccionProy': idAccionProy, 'idProyecto': idProyecto
      },
      url: urlCompleta + "/Proyecto/buscarAccionesProyectoPorClientes",
      beforeSend: function () {
        $("#fichaProyectoDetallada").html("Cargando...");
      },
      success: function (datos) {
        datosJSON = JSON.parse(datos);
        $("#fichaProyectoDetallada").html(datosJSON.html);
        $('#contenedorLineasGastos').append(datosJSON.htmlGastos)
        $('#contenedorLineasGastosComunes').append(datosJSON.htmlGastosComunes)

        let tailGenerico = tail.select('.todos', {
          search: true,
          locale: "es",
          multiSelectAll: false,
          searchMinLength: 0,
          multiContainer: false,
          height: "200px",
        });

        for (let index = 0; index < tailGenerico.length; index++) {
          const element = tailGenerico[index];
          listenerSelect(element);
        }

      }

    });

    $.ajax({
      type: "POST",
      data: {
        'idCliente': idCliente, 'idProyecto': idProyecto
      },
      url: "../../Proyecto/obtenerColaboradorPorCliente",
      success: function (respuesta) {
        respuesta = JSON.parse(respuesta);
        //console.log(respuesta);
        $("#colaboradorCli").val(respuesta['colaborador']);
        $("#AgenterCli").val(respuesta['agente']);
        $("#tipologia").append(respuesta['tipologia']);
        //$("#nivelCurso").append(respuesta['nivel']);
        //$("#modalidad").append(respuesta['modalidad']);
        $("#participantes").val(respuesta['participantes']);
        $("#importeAccion").val(respuesta['importe']);
        //$("#horas").val(respuesta['horas']);                              
      }
    });



  }



  function cargarSelectContactos(numfactura) {



    $.ajax({
      type: "POST",
      data: {
        numFactura: numfactura
      },
      url: "../../Proyecto/cargarContactos",
      success: function (respuesta) {

        $("#selectContactos").html(respuesta);

        tailContactos = tail.select('.mailClienteEnviar', {
          search: true,
          locale: "es",
          multiSelectAll: false,
          searchMinLength: 0,
          multiContainer: false,
        });

        iniciarOnChangeContactos(tailContactos);

      }



    });

  }

  function iniciarOnChangeContactos(tailContactos) {

    tailContactos.on('change', function (item, state) {

      if (item.value != "Seleccionar") {

        var filaEmail = '<tr>' +
          '<td><input class="form-control destinatario" name="email[]" style="font-size:0.85rem;" value="' + item.value + '" /></td>' +
          '<td>' +
          '        <i class="fas fa-trash eliminarEmail"></i>' +
          '</td>' +
          '</tr>';

        $('#tablaEmailsEnvioFactura').append(filaEmail);
      }

    });


  }

  function cargarFirmaEditorEmail() {

    $.ajax({
      type: "POST",
      data: {
      },
      url: "../../Proyecto/cargarFirmaEditorEmail",
      success: function (respuesta) {
        $("#msgEmailFactura").summernote('code', respuesta);
      }
    });

  }

  function validatorInputKeyPress() {					
    //Validaciones de los campos del fomulario de creación/edición				
    var UXAPP = UXAPP || {};

    // paquete de validaciones
    UXAPP.validador = {};

    // método que inicia el validador con restriccion de caracteres
    UXAPP.validador.init = function () {
      // busca los elementos que contengan el atributo regexp definido
      $("input[regexp]").each(function(){
        // por cada elemento encontrado setea un listener del keypress
        $(this).keypress(function(event){
          // extrae la cadena que define la expresión regular y creo un objeto RegExp 
          // mas info en https://goo.gl/JEQTcK
          var regexp = new RegExp( "^" + $(this).attr("regexp") + "$" , "g");
          // evalua si el contenido del campo se ajusta al patrón REGEXP
          if ( ! regexp.test( $(this).val() + String.fromCharCode(event.which) ) )
            event.preventDefault();		
        });
      });	
    }

    // Arranca el validador al término de la carga del DOM
    $(document).ready( UXAPP.validador.init );

  }

});