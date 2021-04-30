// (function ($) {
//   "use strict";

$(document).ready(function () {


	function validatorInputKeyPressGeneral() {					
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

	validatorInputKeyPressGeneral();
	//mostrar apartado para subida de fichero
	
	$('a.toggle-vis').on('click', function () {
		if ($(this).attr('data-click-state') == 1) {
			$(this).attr('data-click-state', 0);
			$(this).css('color', 'black')
		}
		else {
			$(this).attr('data-click-state', 1);
			$(this).css('color', 'red')
		}
	});

	//  $.fn.dataTable.moment( "DD-MM-YYYY" );
	//$.fn.modal.Constructor.prototype.enforceFocus = $.noop;

	$('#ModalEdit').on('hidden.bs.modal', function () {
		$('#delete').trigger("reset");
		$('#edit').trigger("reset");
		$('#add').trigger("reset");
	});

	$('#ModalDelete').on('hidden.bs.modal', function () {
		$('#delete').trigger("reset");
		$('#edit').trigger("reset");
		$('#add').trigger("reset");
	});

	$('#ModalAdd').on('hidden.bs.modal', function () {
		$('#delete').trigger("reset");
		$('#edit').trigger("reset");
		$('#add').trigger("reset");
	});

	$('#ModalAdd').on('shown.bs.modal', function () {
		$('#add').trigger("reset");
	});
	
	// ACCIONES
	if (window.location.pathname.includes('/acciones')) {
      
		/* Añdir cajas de busqueda a las cabeceras */
		$('#table_acciones thead th').each(function () {
			var title = $(this).text();
			$(this).html(title + '</br><input type="text" class="col-search-input" style="margin-top:10px;" placeholder="" />');
		});
		var variable = 0;
		let acciones = $('#table_acciones').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": "../Datatabless/getAcciones",
			"info": true,
			"language": {
				"url": "datatables/Languages/Spanish.json"
			},
			"columnDefs": [
				{ className: "dt-center", targets: ["_all"] },
				{
					targets: [7, 8, 9, 10, 11],
					"bVisible": false,					
				    render: function(data, type, row, meta){
						if (data) {
							let enlace = (data.length > 40)?data.substring(0, 40)+'<a href="" data-toggle="modal" data-target="#vermas" class="ver" data-id = "' + data + '" >...ver</a>':data;
							return enlace;
						} else {	
							return '';
						}												
					}
					

				}
			],
			'responsive': true,
			'dom': 'lBfrtip',
		
			/* codigo para ejecutar la busqueda por columna de la tabla */
			'initComplete': function () {
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
			},

			//con esto muestro los botenes edit y delete de la tabla
			rowCallback: function(row, data, index) {
				 	$(row).find('td').each(function(){
						if ($(this).html() == 'btnEdit') {
							//console.log($(this).html());
							//console.log(data)	;
							let edit = '<a href="" data-toggle="modal" data-target="#ModalEdit"  class="btn btn-info btn-sm edit"' +
							' data-id="' + data['DT_RowId'] + '" data-rol="' + data[1] + '"> <i class="fas fa-pencil-alt"></i></a>';
							let deleteRow = '<a href="" data-toggle="modal" data-target="#ModalDelete"  class="btn btn-danger btn-sm delete"' +
							' data-id="' + data['DT_RowId'] + '" data-nombre="' + data[3] + '" ><span class="fa fa-trash"></span></a>';							
							$(this).html(edit + deleteRow);						
						}
					});					
			  },			

			"buttons": [
				{
					"extend": 'excelHtml5',
					"text": '<i class="fas fa-file-excel" style="color:green;"></i>',
					"titleAttr": 'Exportar a Excel',
					"className": 'btn btn-success',
					format: {
						body: function (data, row, column, node) {
							data = $('<p>' + data + '</p>').text();
							data = data.replace('.', '')
							return $.isNumeric(data.replace(',', '.')) ? data.replace(',', '.') : data;
						}
					}
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
			]

		});


		$('#table_acciones').css('visibility', 'visible');

		//Hide-show datatable columns
		$('a.toggle-vis').on('click', function (e) {
			e.preventDefault();
			// Get the column API object
			var column = acciones.column($(this).attr('data-column'));
			// Toggle the visibility
			column.visible(!column.visible());
		});
		$('a.toggle-viss').on('click', function (e) {
			e.preventDefault();
			// Get the column API object
			var column = acciones.column($(this).attr('data-column'));
			// Toggle the visibility
			column.visible(!column.visible());
		});


		$('a.roj').on('click', function () {
			if ($(this).attr('data-click-state') == 1) {
				$(this).attr('data-click-state', 0);
				$(this).css('color', 'red')
			}
			else {
				$(this).attr('data-click-state', 1);
				$(this).css('color', 'black')
			}
		});

		$.fn.dataTable.ext.errMode = 'none';
		$('#table_acciones').on('error.dt', function (e, settings, techNote, message) {
			console.log('An error has been reported by DataTables: ', message);
		}).DataTable();
		$('#table_acciones').DataTable();
        
		$('#table_acciones').on('click', '.ver', function () {
			let data = $(this).data("id");
		    $(".leer").html(data);
		});

		$('#table_acciones').on('click', '.edit', function () {			
			var id = $(this).data('id');
			$.ajax({
				type: 'POST',
				url: 'getAccionesUpdate',
				data: { 'id': id },
				dataType: "JSON"
			}).done(function (data) {
				let data1 = data['datos'];
				let data2 = data['ficheros'];
				/*console.log(data1);
				console.log(data2);*/
				$('#idEdit').val(data1["idACCION"]);
				$('#idAccionEdit').val(data1["idACCION"]);
				$('#nombreAccionEdit').val(data1["NOMBREACCION"]);
				$('#servicioEdit').val(data1["idServicio"]);
				$('#tipoAccionEdit').val(data1["CODTIPO"]);
				$('#modalidadEdit').val(data1["CODMODALIDAD"]);
				$('#areaFormativaEdit').val(data1["CODAREA"]);
				$('#objetivoAccionEdit').val(data1["ObjetivoPrevisto"]);
				$('#metodologiaEdit').val(data1["MetodologiaPrevista"]);
				$('#contenidoEdit').val(data1["ContenidoPrevisto"]);
				$('#observacionesAccionEdit').val(data1["observaciones"]);
				$('#tabla_ficherosEdit').empty();
				var ruta = 'descargarFichero/'
				for (let index = 0; index < data2.length; index++) {
					var fila = '<tr><td>'+ data2[index]['nombre']+'</td><td><a href="'+ruta+data2[index]['idDocAccion']+'" target="_blank">'+ data2[index]['descripcion']+'</a></td></tr>';
					$('#tabla_ficherosEdit').append(fila);					
				}
				$('.select2').select2({
					theme: 'bootstrap4'
				});
			}).fail(function () {
				console.log('Hubo un error al cargar los datos del cliente.');
			});
	
	
		});

		$('#table_acciones').on('click', '.delete', function () {
			var id = $(this).data('id');
			var nombre = $(this).data('nombre');
	
			$('[name="id"]').val(id);
			$('[name="nombre"]').val(nombre);
	
		});

		$('#anadirFicheroAcc').on('click', function(e){			
				e.preventDefault();
				if($('#formularioSubirFicheroAccion').is(':visible')){
						$('#formularioSubirFicheroAccion').slideUp(300);
				}else{
					$('#formularioSubirFicheroAccion').slideDown(300);
				}
		});
		$('#anadirFicheroAccEdit').on('click', function(e){			
			e.preventDefault();
			if($('#formularioSubirFicheroAccionEdit').is(':visible')){
					$('#formularioSubirFicheroAccionEdit').slideUp(300);
			}else{
				$('#formularioSubirFicheroAccionEdit').slideDown(300);
			}
	});			

	}
	// END ACCIONES
	// EVENTOS CALENDARIO
	else if (window.location.pathname.includes('/eventosCalendario')) {

		/* Añdir cajas de busqueda a las cabeceras */
		$('#table_eventos thead th').each(function () {
			var title = $(this).text();
			$(this).html(title + '</br><input type="text" class="col-search-input" style="margin-top:10px;" placeholder="" />');
		});

		let eventos = $('#table_eventos').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": "EventosCalendario/getAcciones",
			"info": true,
			"language": {
				"url": "datatables/Languages/Spanish.json"
			},
			"columnDefs": [
				{
					targets: 8,
					render: function (data, type, row, meta) {
						let edit = '<a href="" data-toggle="modal" data-target="#calendarModalEdit"  class="btn btn-info btn-sm edit"' +
							' data-id="' + row['DT_RowId'] + '" data-rol="' + row[1] + '"> <i class="fas fa-pencil-alt"></i></a>';
						let deleteRow = '<a href="" data-toggle="modal" data-target="#delete"  class="btn btn-danger btn-sm delete"' +
							' data-id="' + row['DT_RowId'] + '" data-nombre="' + row[3] + '" ><span class="fa fa-trash"></span></a>';

						// if( row[0] != 1 && row[0] != 2 ){
						return edit + " " + deleteRow;
						// }
					}

				},
				{ className: "dt-center", targets: ["_all"] },
			],
			'responsive': true,
			"order": [[6, 'desc']],
			'dom': 'lBfrtip',
			/* codigo para ejecutar la busqueda por columna de la tabla */
			'initComplete': function () {
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
			},
			"buttons": [
				{
					"extend": 'excelHtml5',
					"text": '<i class="fas fa-file-excel" style="color:green;"></i>',
					"titleAttr": 'Exportar a Excel',
					"className": 'btn btn-success',
					format: {
						body: function (data, row, column, node) {
							data = $('<p>' + data + '</p>').text();
							data = data.replace('.', '')
							return $.isNumeric(data.replace(',', '.')) ? data.replace(',', '.') : data;
						}
					}
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
			]

		});


		$('#table_eventos').css('visibility', 'visible');

		//Hide-show datatable columns
		$('a.toggle-vis').on('click', function (e) {
			e.preventDefault();
			// Get the column API object
			var column = eventos.column($(this).attr('data-column'));
			// Toggle the visibility
			column.visible(!column.visible());
		});

		$.fn.dataTable.ext.errMode = 'none';
		$('#table_eventos').on('error.dt', function (e, settings, techNote, message) {
			console.log('An error has been reported by DataTables: ', message);
		}).DataTable();
		$('#table_eventos').DataTable();

		$('#table_eventos').on('click', '.edit', function () {
			var id = $(this).data('id');
			$.ajax({
				type: 'POST',
				url: 'EventosCalendario/getAccionUpdate',
				data: { 'id': id }
			}).done(function (data) {
				data = JSON.parse(data);
				data = data[0];
				console.log(data);
				var start = data["start"].split(" ");
				var startDate = start[0];
				var startTime = start[1].substr(0, 5);
				var end = data["end"].split(" ");
				var endDate = end[0];
				var endTime = end[1].substr(0, 5);
				$('#idEdit').val(id);
				$('#actividadEdit').val(data["actividad"]);
				$('#idClienteEdit').val(data["idEMPRESA"]);
				$('#agenteEdit').val(data["codagente"]);
				$('#estadoEdit').val(data["estado"]);
				$('#contenidoEdit').val(data["contenido"]);
				$('#canalEdit').val(data["canalComunicacion"]);
				$('#inicioEdit').val(startDate);
				$('#iniciotimeEdit').val(startTime);
				$('#finEdit').val(endDate);
				$('#fintimeEdit').val(endTime);
			}).fail(function () {
				console.log('Hubo un error al cargar los datos del cliente.');
			});

		})
		$('#table_eventos').on('click', '.delete', function () {
			var id = $(this).data('id');
			$('#idDelete').val(id);
		})

	}

	// END EVENTOS CALENDARIO
	// ROLES
	else if (window.location.pathname.includes('/roles')) {

		/* Añdir cajas de busqueda a las cabeceras */
		console.log('BUSCAMOS ROLES');
		$('#table_roles thead th').each(function () {
			var title = $(this).text();
			$(this).html(title + '</br><input type="text" class="col-search-input" style="margin-top:10px;" placeholder="" />');
		});

		let roles = $('#table_roles').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": "roles/getRoles",  // ../Controlador/funcion
			"info": false,
			"language": {
				"url": "datatables/Languages/Spanish.json"
			},
			"columnDefs": [{

				targets: [0],
				"bVisible": false
			},
			{
				targets: 2,
				render: function (data, type, row, meta) {
					let edit = '<a href="" data-toggle="modal" data-target="#ModalEdit"  class="btn btn-info btn-sm edit"' +
						' data-id="' + row[0] + '" data-rol="' + row[1] + '"> <i class="fas fa-pencil-alt"></i></a>';
					let deleteRow = '<a href="" data-toggle="modal" data-target="#ModalDelete"  class="btn btn-danger btn-sm delete"' +
						' data-id="' + row[0] + '" data-rol="' + row[1] + '" ><span class="fa fa-trash"></span></a>';

					// if( row[0] != 1 && row[0] != 2 ){
					return edit + " " + deleteRow;
					// }
				}

			},
			{ className: "dt-center", targets: ["_all"] }
			],
			'responsive': true,
			'dom': 'lBfrtip',
			/* codigo para ejecutar la busqueda por columna de la tabla */
			'initComplete': function () {
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
			},
			"buttons": [
				{
					"extend": 'excelHtml5',
					"text": '<i class="fas fa-file-excel" style="color:green;"></i>',
					"titleAttr": 'Exportar a Excel',
					"className": 'btn btn-success',
					format: {
						body: function (data, row, column, node) {
							data = $('<p>' + data + '</p>').text();
							data = data.replace('.', '')
							return $.isNumeric(data.replace(',', '.')) ? data.replace(',', '.') : data;
						}
					}
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
			]

		});


		$('#table_roles').css('visibility', 'visible');

		//Hide-show datatable columns
		$('a.toggle-vis').on('click', function (e) {
			e.preventDefault();
			// Get the column API object
			var column = roles.column($(this).attr('data-column'));
			// Toggle the visibility
			column.visible(!column.visible());
		});
		$.fn.dataTable.ext.errMode = 'none';
		$('#table_roles').on('error.dt', function (e, settings, techNote, message) {
			console.log('An error has been reported by DataTables: ', message);
		}).DataTable();
		$('#table_roles').DataTable();
		$('#table_roles').on('click', '.edit', function () {


			var id = $(this).data('id');
			var rol = $(this).data('rol');
			$('[name="id"]').val(id);
			$('[name="rol"]').val(rol);

		});
		$('#table_roles').on('click', '.delete', function () {
			var id = $(this).data('id');
			var rol = $(this).data('rol');

			$('[name="id"]').val(id);
			$('[name="rol"]').val(rol);

		});

	}
	// END ROLES
	// REPRESENTANTE
	else if (window.location.pathname.includes('/representante')) {
		/* Añdir cajas de busqueda a las cabeceras */
		$('#table_representante thead th').each(function () {
			var title = $(this).text();
			$(this).html(title + '</br><input type="text" class="col-search-input" style="margin-top:10px;" placeholder="" />');
		});

		let roles = $('#table_representante').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": "Representante/getRepresentante",  // ../Controlador/funcion
			"info": false,
			"language": {
				"url": "datatables/Languages/Spanish.json"
			},
			"columnDefs": [{

				targets: [],
				"bVisible": false
			},
			{
				targets: 6,
				render: function (data, type, row, meta) {
					let edit = '<a href="" data-toggle="modal" data-target="#ModalEdit"  class="btn btn-info btn-sm edit"' +
						' data-id="' +  row['DT_RowId'] + '" data-representante="' + row[1] + '"> <i class="fas fa-pencil-alt"></i></a>';
					let deleteRow = '<a href="" data-toggle="modal" data-target="#ModalDelete"  class="btn btn-danger btn-sm delete"' +
						' data-id="' +  row['DT_RowId']+ '" data-representante="' + row[1] + '" ><span class="fa fa-trash"></span></a>';

				
					return edit + " " + deleteRow;
				
				}

			},
			{ className: "dt-center", targets: ["_all"] }
			],
			'responsive': true,
			'dom': 'lBfrtip',
			/* codigo para ejecutar la busqueda por columna de la tabla */
			'initComplete': function () {
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
			},
			"buttons": [
				{
					"extend": 'excelHtml5',
					"text": '<i class="fas fa-file-excel" style="color:green;"></i>',
					"titleAttr": 'Exportar a Excel',
					"className": 'btn btn-success',
					format: {
						body: function (data, row, column, node) {
							data = $('<p>' + data + '</p>').text();
							data = data.replace('.', '')
							return $.isNumeric(data.replace(',', '.')) ? data.replace(',', '.') : data;
						}
					}
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
			]

		});


		$('#table_representante').css('visibility', 'visible');

		//Hide-show datatable columns
		$('a.toggle-vis').on('click', function (e) {
			e.preventDefault();
			// Get the column API object
			var column = roles.column($(this).attr('data-column'));
			// Toggle the visibility
			column.visible(!column.visible());
		});
		$.fn.dataTable.ext.errMode = 'none';
		$('#table_representante').on('error.dt', function (e, settings, techNote, message) {
			console.log('An error has been reported by DataTables: ', message);
		}).DataTable();
		$('#table_representante').DataTable();

		$('#table_representante').on('click', '.delete', function () {

			var id = $(this).data('id');
			$('[name="id"]').val(id);
		
		});
		$('#table_representante').on('click', '.edit', function () {
			var id = $(this).data('id');
			$.ajax({
				type: 'POST',
				url: 'Representante/getRepresentanteUpdate',
				data: { 'id': id }
			}).done(function (data) {
				data = JSON.parse(data);
				data = data[0];
			
				$('#id').val(data["idRepresentante"]);
				$('#empresaEdit').val(data["idEMPRESA"]);
				$('#nifEdit').val(data["NIFREPRESENTANTE"]);
				$('#nombreEdit').val(data["NOMBREREPRESENTANTE"]);
				$('#telefonoEdit').val(data["telefono"]);
				$('#movilEdit').val(data["movil"]);
				$('#emailEdit').val(data["email"]);

			}).fail(function () {
				console.log('Hubo un error al cargar los datos del cliente.');
			});
		

		});

	}
	// END REPRESENTANTE
	// ASESOR
	else if (window.location.pathname.includes('/asesores')) {

		/* Añdir cajas de busqueda a las cabeceras */
		$('#table_asesor thead th').each(function () {
			var title = $(this).text();
			$(this).html(title + '</br><input type="text" class="col-search-input" style="margin-top:10px;" placeholder="" />');
		});

		let roles = $('#table_asesor').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": "Asesores/getAsesor",  // ../Controlador/funcion
			"info": false,
			"language": {
				"url": "datatables/Languages/Spanish.json"
			},
			"columnDefs": [{

				targets: [],
				"bVisible": false
			},
			{
				targets: 3,
				render: function (data, type, row, meta) {
					let edit = '<a href="" data-toggle="modal" data-target="#ModalEdit"  class="btn btn-info btn-sm edit"' +
						' data-id="' +  row['DT_RowId'] + '" data-representante="' + row[1] + '"> <i class="fas fa-pencil-alt"></i></a>';
					let deleteRow = '<a href="" data-toggle="modal" data-target="#ModalDelete"  class="btn btn-danger btn-sm delete"' +
						' data-id="' +  row['DT_RowId']+ '" data-representante="' + row[1] + '" ><span class="fa fa-trash"></span></a>';

				
					return edit + " " + deleteRow;
				
				}

			},
			{ className: "dt-center", targets: ["_all"] }
			],
			'responsive': true,
			'dom': 'lBfrtip',
			/* codigo para ejecutar la busqueda por columna de la tabla */
			'initComplete': function () {
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
			},
			"buttons": [
				{
					"extend": 'excelHtml5',
					"text": '<i class="fas fa-file-excel" style="color:green;"></i>',
					"titleAttr": 'Exportar a Excel',
					"className": 'btn btn-success',
					format: {
						body: function (data, row, column, node) {
							data = $('<p>' + data + '</p>').text();
							data = data.replace('.', '')
							return $.isNumeric(data.replace(',', '.')) ? data.replace(',', '.') : data;
						}
					}
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
			]

		});


		$('#table_asesor').css('visibility', 'visible');

		//Hide-show datatable columns
		$('a.toggle-vis').on('click', function (e) {
			e.preventDefault();
			// Get the column API object
			var column = roles.column($(this).attr('data-column'));
			// Toggle the visibility
			column.visible(!column.visible());
		});
		$.fn.dataTable.ext.errMode = 'none';
		$('#table_asesor').on('error.dt', function (e, settings, techNote, message) {
			console.log('An error has been reported by DataTables: ', message);
		}).DataTable();
		$('#table_asesor').DataTable();

		$('#table_asesor').on('click', '.delete', function () {

			var id = $(this).data('id');
			$('[name="id"]').val(id);
		
		});
		$('#table_asesor').on('click', '.edit', function () {
			var id = $(this).data('id');
			$.ajax({
				type: 'POST',
				url: 'Asesores/getAsesorUpdate',
				data: { 'id': id }
			}).done(function (data) {
				data = JSON.parse(data);
				data = data[0];
				$('#id').val(data["idAsesor"]);
				$('#contactoEdit').val(data["contacto"]);
				$('#direccionEdit').val(data["direccion"]);
				$('#nombreEdit').val(data["nomasesor"]);
				$('#telefonoEdit').val(data["telefonoFijo"]);
				$('#movilEdit').val(data["movil"]);
				$('#emailEdit').val(data["mail"]);

			}).fail(function () {
				console.log('Hubo un error al cargar los datos del cliente.');
			});
		

		});

	}
	// END ASESOR
	// CONTACTOS
	else if (window.location.pathname.includes('/contactos')) {

		/* Añdir cajas de busqueda a las cabeceras */
		$('#table_contactos thead th').each(function () {
			var title = $(this).text();
			$(this).html(title + '</br><input type="text" class="col-search-input" style="margin-top:10px;" placeholder="" />');
		});

		let roles = $('#table_contactos').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": "Contactos/getContacto",  // ../Controlador/funcion
			"info": false,
			"language": {
				"url": "datatables/Languages/Spanish.json"
			},
			"columnDefs": [{

				targets: [],
				"bVisible": false
			},
			{
				targets: 6,
				render: function (data, type, row, meta) {
					let edit = '<a href="" data-toggle="modal" data-target="#ModalEdit"  class="btn btn-info btn-sm edit"' +
						' data-id="' +  row['DT_RowId'] + '" data-representante="' + row[1] + '"> <i class="fas fa-pencil-alt"></i></a>';
					let deleteRow = '<a href="" data-toggle="modal" data-target="#ModalDelete"  class="btn btn-danger btn-sm delete"' +
						' data-id="' +  row['DT_RowId']+ '" data-representante="' + row[1] + '" ><span class="fa fa-trash"></span></a>';

				
					return edit + " " + deleteRow;
				
				}

			},
			{ className: "dt-center", targets: ["_all"] }
			],
			'responsive': true,
			'dom': 'lBfrtip',
			/* codigo para ejecutar la busqueda por columna de la tabla */
			'initComplete': function () {
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
			},
			"buttons": [
				{
					"extend": 'excelHtml5',
					"text": '<i class="fas fa-file-excel" style="color:green;"></i>',
					"titleAttr": 'Exportar a Excel',
					"className": 'btn btn-success',
					format: {
						body: function (data, row, column, node) {
							data = $('<p>' + data + '</p>').text();
							data = data.replace('.', '')
							return $.isNumeric(data.replace(',', '.')) ? data.replace(',', '.') : data;
						}
					}
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
			]

		});
		$('#table_contactos').css('visibility', 'visible');

		//Hide-show datatable columns
		$('a.toggle-vis').on('click', function (e) {
			e.preventDefault();
			// Get the column API object
			var column = roles.column($(this).attr('data-column'));
			// Toggle the visibility
			column.visible(!column.visible());
		});
		$.fn.dataTable.ext.errMode = 'none';
		$('#table_contactos').on('error.dt', function (e, settings, techNote, message) {
			console.log('An error has been reported by DataTables: ', message);
		}).DataTable();
		$('#table_contactos').DataTable();

		$('#table_contactos').on('click', '.delete', function () {

			var id = $(this).data('id');
			$('[name="id"]').val(id);
		
		});
		$('#table_contactos').on('click', '.edit', function () {
			var id = $(this).data('id');
			$.ajax({
				type: 'POST',
				url: 'Contactos/getContactoUpdate',
				data: { 'id': id }
			}).done(function (data) {
				data = JSON.parse(data);
				data = data[0];
				//alert(data)
				$('#id').val(data["idContacto"]);
				$('#empresaEdit').val(data["idEMPRESA"]);
				$('#direccionEdit').val(data["direccion"]);
				$('#nombreEdit').val(data["nombreC"]);
				$('#telefonoEdit').val(data["telefonoFijo"]);
				$('#movilEdit').val(data["movil"]);
				$('#emailEdit').val(data["mail"]);

			}).fail(function () {
				console.log('Hubo un error al cargar los datos del cliente.');
			});
		

		});

	}
	// END CONTACTOS
	// PRESUPUESTO
	else if (window.location.pathname.includes('/presupuesto')) {

		/* Añdir cajas de busqueda a las cabeceras */

		$('#table_presupuesto thead th').each(function () {
			var title = $(this).text();
			$(this).html(title + '</br><input type="text" class="col-search-input" style="margin-top:10px;" placeholder="" />');
		});

		let presupuesto = $('#table_presupuesto').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": "Presupuesto/getPresupuesto",  // ../Controlador/funcion
			"info": false,
			"language": {
				"url": "datatables/Languages/Spanish.json"
			},
			"columnDefs": [
				{
					targets: [],
					"bVisible": false
				},
				{
					targets: 5,
					render: function (data, type, row, meta) {											
						let pdf = '<a href="" data-toggle="modal" data-target="#emit" data-id="' + row[0] + '"  class="btn btn-danger btn-xs emit"><i class="fas fa-file-pdf"></i></a> ';
						/*let edit = '<a href="" data-toggle="modal" data-target="#ModalEdit"  class="btn btn-info btn-xs edit"' +
							' data-id="' + row[0] + '" > <i class="fas fa-pencil-alt"></i></a> ';*/
						let edit = '<a href="presupuesto/verPresupuestoEditar/' + row[0] + '" class="btn btn-info btn-xs" > <i class="fas fa-pencil-alt"></i></a>';
						let deleteRow = '<a href="" data-toggle="modal" data-target="#ModalDelete"  class="btn btn-danger btn-xs delete"' +
							' data-id="' + row[0] + '" ><span class="fa fa-trash"></span></a> ';
						return pdf + " "+ edit + " " + deleteRow;
					}
				},			
				{ className: "dt-center", targets: ["_all"] }
			],
			'responsive': true,
			"order": [[0, 'desc']],
			'dom': 'lBfrtip',
			/* codigo para ejecutar la busqueda por columna de la tabla */
			'initComplete': function () {
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
			},
			"buttons": [
				{
					"extend": 'excelHtml5',
					"text": '<i class="fas fa-file-excel" style="color:green;"></i>',
					"titleAttr": 'Exportar a Excel',
					"className": 'btn btn-success',
					format: {
						body: function (data, row, column, node) {
							data = $('<p>' + data + '</p>').text();
							data = data.replace('.', '')
							return $.isNumeric(data.replace(',', '.')) ? data.replace(',', '.') : data;
						}
					}
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
			]

		});
		
		$('#table_presupuesto').css('visibility', 'visible');

		//Hide-show datatable columns
		$('a.toggle-vis').on('click', function (e) {
			e.preventDefault();
			// Get the column API object
			var column = roles.column($(this).attr('data-column'));
			// Toggle the visibility
			column.visible(!column.visible());
		});
		$.fn.dataTable.ext.errMode = 'none';
		$('#table_presupuesto').on('error.dt', function (e, settings, techNote, message) {
			console.log('An error has been reported by DataTables: ', message);
		}).DataTable();
		$('#table_presupuesto').DataTable();
		$('#table_presupuesto').on('click', '.emit', function () {
			var id = $(this).data('id');

			$('[name="idpresupuesto"]').val(id);
		});

		$('#table_presupuesto').on('click', '.edit', function () {
			//para llevar el scroll arriba del todo
			$('body, html').animate({
				scrollTop: '0px'
			}, 300);
			//si la ventana de nuevo presupuesto está abierta visible que la oculte			
			if ( $('#collapseExample').is(':visible') ) {
				$('#collapseExample').slideUp(300);
				$('#botonEjemplo').html('<i class="fa fa-plus"></i> Nuevo Presupuesto');
			}
			//show ventana de editar
			$(".edPres").show();

			//limpiar el html delç la selección anterior
			CKEDITOR.instances.editor4.setData('');

			var id = $(this).data('id');

			$.ajax({
				type: 'POST',
				url: 'Presupuesto/getPresupuestoUpdate',
				data: { 'id': id },
				dataType: "JSON"
			}).done(function (data) {
				//data = JSON.parse(data);
				//data = data[0];
				//console.log(data);
				let data1 = data['cabecera'][0];
				let data2 = data['detalle'];				
				CKEDITOR.instances.editor4.insertHtml(data1["htmlPresupuesto"]);
				$('#idEdit').val(data1["idPresupuesto"]);
				$('#grupoEdit').val(data1["idGrupo"]);
				$('#estadoEdit').val(data1["estado"]);
				//$('#tipoEdit').val(data1["idPlantilla"]);
				$('#tipoEdit').text(data1["tipoPlantilla"]);
				$('#nombrePresEdit').val(data1['nombrePres']);
				$('#fechaIniEdit').val(data1['fechaIni']);
				$('#fechaFinEdit').val(data1['fechaFin']);
				$('#fechaIniFunEdit').val(data1['fechaIniFun']);
				$('#fechaFinFunEdit').val(data1['fechaFinFun']);
				$('#mesBonifEdit').val(data1['mesBonif']);
				$('#conceptoEdit').val(data1["concepto"]);
				$('#ivaEdit').val(data1["iva"]);
				$('#fechaEdit').val(data1["fecha"]);
				$('#observacionesEdit').val(data1["observaciones"]);
				$('#emailEdit').val(data1["emailEnvio"]);
				$('#tipoPresServEdit').val(data1["nombreS"]);				
				if ($('#estadoEdit').val() =='aprobado') {
					$('#btnCrearProyecto').css("display", "none");
					$('#btnActualizar').css("display", "none");
					$('#btnActualizar2').css("display", "none");
				}else{
					$('#btnCrearProyecto').css("display", "block");
					$('#btnActualizar').css("display", "block");
					$('#btnActualizar2').css("display", "block");
				}
								
				//incluir en una funcion
				$('.select2').select2({
					theme: 'bootstrap4'
				});
			}).fail(function () {
				console.log('Hubo un error al cargar los datos del cliente.');
			});

			//llena los detalles del presupuesto
			$.ajax({
				type: "POST",
				data: {
					id: id
				},
				url: "Presupuesto/getSelectPlusUpdate",
				success: function (respuesta) {
					$(".concepto5").html(respuesta);
					$("#accionEdit1").change();
			
					//BOTONES PARA APROBAR O DESAPROBAR UNA LÍNEA DE PRESUPUESTO
					$('.btnAprobarFila').on('click', function () {        
						var idaccion = $(this).attr('data-btnaccion');
						var idpres = $('#idEdit').val();
						var bool=confirm("¿Seguro de aprobar el presupuesto?");
						if(bool){
						$.ajax({
							type: "POST",
							data: {
							'idaccion': idaccion, 'idpres': idpres
							},
							url: "Presupuesto/aprobarPresupuesto",
							success: function (respuesta) {
							if (respuesta == 'true') {
								$("#estatus"+idaccion).val('Aprobado');
								//además que oculte ambas manitas
								$('#btnAprobarFila'+idaccion).css("display", "none");
								$('#btnRechazarFila'+idaccion).css("display", "none");
							}
							}
						});
						}
					});

					$('.btnRechazarFila').on('click', function () {        
						var idaccion = $(this).attr('data-btnaccion');
						var idpres = $('#idEdit').val();
						var bool=confirm("¿Seguro de aprobar el presupuesto?");
						if(bool){
						  $.ajax({
							type: "POST",
							data: {
							  'idaccion': idaccion, 'idpres': idpres
							},
							url: "../Presupuesto/rechazarPresupuesto",
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
					});					

				}
			});

			


			//cuando cambia el servicio se agregan las acciones en los campos que se agregan con el botón plus
			$(document).on('change',".servicioEdit", function () {
			
				var idServicio = $(this).attr('option', 'selected').val();
				var idloop = $(this).attr('id');
				let numero = idloop.match(/\d+/)[0];
				var accionSelect = $("#accionEdit"+numero);
			
				$.ajax({
					type: "POST",
					data: {
						idServicio: idServicio
					},
					url: "Presupuesto/getAccionSelect",
					success: function (respuesta) {
						$(accionSelect).html(respuesta);
					}

				});
			});

		
		});

		$(".cancelEdit").on("click", function () {
			$(".edPres").hide();
		})
		$('#table_presupuesto').on('click', '.delete', function () {
			var id = $(this).data('id');
			$('[name="id"]').val(id);
		});		

	}
	// END PRESUPUESTO

	// INICIO PLANTILLA
	else if (window.location.pathname.includes('/crearPlantillaPresupuesto')) {
		
		$('#nuevaPlantilla').click(function(e){
			e.preventDefault();
			if(jQuery('#editorPlantilla').is(':visible')){
				jQuery('#editorPlantilla').slideUp(300);
			}else{
				jQuery('#editorPlantilla').slideDown(300);
			}
		});
		tablaPlantillas = $('#table_plantilla').DataTable({
			"ajax": {
				"url": "CrearPlantillaPresupuesto/getPlantillas",
				"dataSrc": ""
			},
			"columns":[
				{"data": "idPlantilla"},
				{"data": "tipoPlantilla"},
				{"data": "version"},
				{"data": "fechaCreacion"},
				{"defaultContent": "<a href='' data-toggle='modal' data-target='#emit' class='btn btn-danger btn-xs emit'> <i class='fas fa-file-pdf'></i></a><a href='' data-toggle='modal' data-target='#ModalEdit'  class='btn btn-info btn-xs edit' data-id=''> <i class='fas fa-pencil-alt'></i></a> <a href='' data-toggle='modal' data-target='#ModalDelete'  class='btn btn-danger btn-xs btnBorrar' data-id=''> <i class='fa fa-trash'></i></a>"},
			],
			"language": {
				"url": "datatables/Languages/Spanish.json"
			},

			'responsive': true,
			"order": [[0, 'desc']],
			'dom': 'lBfrtip',
			'initComplete': function () {
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
			},			
			"buttons": [
				{
					"extend": 'excelHtml5',
					"text": '<i class="fas fa-file-excel" style="color:green;"></i>',
					"titleAttr": 'Exportar a Excel',
					"className": 'btn btn-success',
					format: {
						body: function (data, row, column, node) {
							data = $('<p>' + data + '</p>').text();
							data = data.replace('.', '')
							return $.isNumeric(data.replace(',', '.')) ? data.replace(',', '.') : data;
						}
					}
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
				},
				
			],
			
		});

		//Borrar una plantilla
		$(document).on("click", ".btnBorrar", function(){
			fila = $(this);           
			idPlantilla = parseInt($(this).closest('tr').find('td:eq(0)').text()) ;		
			//opcion = 3; //eliminar
			var respuesta = confirm("¿Está seguro de borrar la plantilla "+idPlantilla+"?");                
			if (respuesta) {            
				$.ajax({
				url: "CrearPlantillaPresupuesto/deletePlantillas",
				type: "POST",			
				data:  {idPlantilla:idPlantilla},    
				success: function() {
					tablaPlantillas.row(fila.parents('tr')).remove().draw();                  
				}
				});	
			}
		});		
	}
	// END PLANTILLAS

	/// CLIENTES
	if (window.location.pathname.includes('/clientes')) {
		validatorInputKeyPress();
		/* Añdir cajas de busqueda a las cabeceras */
		$('#table_clientes thead th').each(function () {
			var title = $(this).text();
			$(this).html(title + '</br><input type="text" class="col-search-input" style="margin-top:10px;" placeholder="" />');
		});

		let clientes = $('#table_clientes').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": "Clientes/getClientes",
			"info": true,
			"language": {
				"url": "datatables/Languages/Spanish.json"
			},
			"columnDefs": [
				{
					targets: 6,
					render: function (data, type, row, meta) {
						let edit = '<a href="" data-toggle="modal" data-target="#ModalEdit"  class="btn btn-info btn-sm edit"' +
							' data-id="' + row['DT_RowId'] + '" data-rol="' + row[1] + '"> <i class="fas fa-pencil-alt"></i></a>';
						let deleteRow = '<a href="" data-toggle="modal" data-target="#ModalDelete"  class="btn btn-danger btn-sm delete"' +
							' data-id="' + row['DT_RowId'] + '" data-nombre="' + row[3] + '" ><span class="fa fa-trash"></span></a>';
						return edit + " " + deleteRow;
					}

				},
				{ className: "dt-center", targets: ["_all"] }
			],
			'responsive': true,
			'dom': 'lBfrtip',
			/* codigo para ejecutar la busqueda por columna de la tabla */
			'initComplete': function () {
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
			},
			"buttons": [
				{
					"extend": 'excelHtml5',
					"text": '<i class="fas fa-file-excel" style="color:green;"></i>',
					"titleAttr": 'Exportar a Excel',
					"className": 'btn btn-success',
					format: {
						body: function (data, row, column, node) {
							data = $('<p>' + data + '</p>').text();
							data = data.replace('.', '')
							return $.isNumeric(data.replace(',', '.')) ? data.replace(',', '.') : data;
						}
					}
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
			]

		});

		$('#table_clientes').css('visibility', 'visible');

		//Hide-show datatable columns
		$('a.toggle-vis').on('click', function (e) {
			e.preventDefault();
			// Get the column API object
			var column = clientes.column($(this).attr('data-column'));
			// Toggle the visibility
			column.visible(!column.visible());
		});

		$.fn.dataTable.ext.errMode = 'none';
		$('#table_clientes').on('error.dt', function (e, settings, techNote, message) {
			console.log('An error has been reported by DataTables: ', message);
		}).DataTable();
		$('#table_clientes').DataTable();

	}
		$('#table_clientes').on('click', '.delete', function () {
			var id = $(this).data('id');
			var nombre = $(this).data('nombre');

			$('[name="id"]').val(id);
			$('[name="nombre"]').val(nombre);

		});
		$('#table_clientes').on('click', '.edit', function () {
			//    show ventana de editar
			var id = $(this).data('id');
			$.ajax({
				type: 'POST',
				url: 'Clientes/getClientesUpdate',
				data: { 'id': id },
				dataType: "JSON"
			}).done(function (data) {
				//data = JSON.parse(data);			
				//data = data[0];
				let data1 = data['clientes'];
				let data2 = data['agentes'];
				let data3 = data['colaboradores'];
				let data4 = data['asesores'];			
				//console.log(data['clientes'][0]);
				
				$('#idEdit').val(data1["idEMPRESA"]);
				$('#codigoEdit').val(data1["codEmpresa"]);
				$('#cifEdit').val(data1["CIFCLIENTE"]);
				$('#nombreEdit').val(data1["NOMBREJURIDICO"]);
				$('#observacionesEdit').val(data1["observaciones"]);			
				$('#nombreComercialEdit').val(data1["NOMBRECOMERCIAL"]);
				$('#direccionEdit').val(data1["DIRECCION"]);
				$('#poblacionEdit').val(data1["LOCALIDAD"]);
				$('#provinciaEdit').val(data1["PROVINCIA"]);
				$('#codigoPostalEdit').val(data1["CODPOSTAL"]);
				$('#telefonofijo1Edit').val(data1["TELEFONOFIJO1"]);
				$('#telefonofijo2Edit').val(data1["TELEFONOFIJO2"]);
				$('#movilEdit').val(data1["TELEFONOMOVIL"]);
				$('#emailEdit').val(data1["EMAIL"]);
				$('#webEdit').val(data1["WEB"]);
				$('#nssEdit').val(data1["NSSEMPRESA"]);
				$('#grupoEdit').val(data1["idGrupo"]);
				$('#actividadEdit').val(data1["CODACTIVIDAD"]);
				$('#sectorEdit').val(data1["CODSECTOR"]);
				if (data1["Convenio"] == 1) {
					$('#convenio1Edit').prop('checked',true);				
				}else if (data1["Convenio"] == 0) {
					$('#convenio2Edit').prop('checked',true);				
				}
				
				$('#fechaConvenioEdit').val(data1["FechaConvenio"]);
				if (data1["RLT"] == 1) {
					$('#rlt1Edit').prop('checked',true);
				}else if (data1["RLT"] == 0) {
					$('#rlt2Edit').prop('checked',true);
				}
				//$('#rltEdit').val(data1["RLT"]);
				$('#trabajadoresEdit').val(data1["numtrabajadores"]);

				if (data1["escliente"] == 'Sí') {
					$('#estado1Edit').prop('checked',true);
				}else if (data1["escliente"] == "No") {
					$('#estado2Edit').prop('checked',true);
				}else if (data1["escliente"] == "Inactivo") {
					$('#estado3Edit').prop('checked',true);
				}
								
				$('#nifRepresentanteEdit').val(data1["NIFREPRESENTANTE"]);
				$('#representanteEdit').val(data1["NOMBREREPRESENTANTE"]);
				$('#contactoPrincipalEdit').val(data1["CONTACTO"]);				
				$('#colaboradorEdit').val(data3["idColaborador"]);
				$('#agenteEdit').val(data2["idAgente"]);
				$('#creditoFormativoEdit').val(data1["credito"]);
				$('#ctacteEdit').val(data1["numcuenta"]);
				$('#formadepagoEdit').val(data1["formadepago"]);

				//pinto los asesores
				if (data1['asesorTipo'] == 'interno') {
					$('#asesor1Edit').prop('checked',true);
					$('.asesorInterno').slideDown(300);
					
					$('#contactoAsesorIntEdit').val(data1['nomasesor']);				
					$('#telefAsesorIntEdit').val(data1['telefonocontacto1']);
					$('#movfAsesorIntEdit').val(data1['movilcontacto']);
					$('#dirAsesorIntEdit').val(data1['direccioncontacto']);
					$('#locAsesorIntEdit').val(data1['localidadcontacto']);
					$('#provAsesorIntEdit').val(data1['provinciacontacto']);
					$('#codPosAsesorIntEdit').val(data1['codpostalcontacto']);
					$('#mailAsesorIntEdit').val(data1['mailcontacto']);
				
				}else if (data1['asesorTipo'] == 'externo') {
					$('#asesor2Edit').prop('checked',true);
					$('#selAsesor2Edit').prop('checked',true);					
					$('.asesorExterno').slideDown(300);
					$('.asesorExtExiste').slideDown(300);
					$('#selNomAsesorExtEdit').val(data4['idAsesor']);
				}			
				
				$('.select2').select2({
					theme: 'bootstrap4'
				});				
			}).fail(function () {
				console.log('Hubo un error al cargar los datos del cliente.');
			});

			//para llenar la tabla contactos del modal edicion de cliente
			$.ajax({
				type: "POST",
				cache: false,       
				url: 'Clientes/buscarContactosPorClientes',
				data: { 'id': id },
				beforeSend: function(){
					$("#listadoContactosEdit").html("Cargando");
				},
				success: function(response) {				
					$("#listadoContactosEdit").html(response);				
				}
				
			});
		});
		
		//=============================================================================
		
		//para mostrar/dejar de mostrar apartado asesor interno/externo en la creación
		$('#asesor1').on('click', function(){		
			$('input:radio[name=selAsesorExt]').prop('checked',false);
			if($('.asesorExterno').is(':visible') ){				
				$('.asesorExterno').slideUp(300);
			}
			if($('.asesorExtNuevo').is(':visible') ){				
				$('.asesorExtNuevo').slideUp(300);
				//limpie los inputs de asesorExtNuevo y les quite required
				$('.asesorExtNuevo input').val('');
				$('.asesorExtNuevo input.obligatorio').prop("required", false);
			}
			if($('.asesorExtExiste').is(':visible') ){				
				$('.asesorExtExiste').slideUp(300);
				//limpie los inputs de asesorExtExiste y les quite required
				//$('.asesorExtExiste select').val('');
				//$('.asesorExtExiste select').val([]);
				$('.asesorExtExiste span.select2-selection__rendered').html('Seleccionar.....');
				$('.asesorExtExiste select[name=selNomAsesorExt]').prop("required", false);
			}
			$('.asesorInterno').slideDown(300);
			//q me ponga required a los campos obligatorios
			$('.asesorInterno input.obligatorio').prop("required", true);
			
			
		});
		$('#asesor2').on('click', function(){		
			$('input:radio[name=selAsesorExt]').attr('checked',false);
			//que limpie todos los inputs de asesor interno y les quite required
			if($('.asesorInterno').is(':visible') ){
				$('.asesorInterno input').val('');
				$('.asesorInterno input.obligatorio').prop("required", false);	
				$('.asesorInterno').slideUp(300);
			}
			$('.asesorExterno').slideDown(300);
			//$('#asesor1').prop('disabled', true);
		});

		//Para seleccionar asesor nuevo
		$('#selAsesor1').on('click', function(){
			if($('.asesorExtExiste').is(':visible') ){				
				$('.asesorExtExiste').slideUp(300);
				//limpie los inputs de asesorExtExiste y les quite required
				//$('.asesorExtExiste select').val('');
				//$('.asesorExtExiste select').val([]);
				$('.asesorExtExiste span.select2-selection__rendered').html('Seleccionar.....');
				$('.asesorExtExiste select[name=selNomAsesorExt]').prop("required", false);			
			}
			$('.asesorExtNuevo').slideDown(300);
			//que agregue required a los campos clase obligatorio, ojo q aqui a lo mejor no sirve
			$('.asesorExtNuevo input.obligatorio').prop("required", true);
		});
		//Para seleccionar asesor existente
		$('#selAsesor2').on('click', function(){
			if($('.asesorExtNuevo').is(':visible') ){				
				$('.asesorExtNuevo').slideUp(300);
				//limpie los inputs de asesorExtNuevo y les quite required
				$('.asesorExtNuevo input').val('');
				$('.asesorExtNuevo input.obligatorio').prop("required", false);			
			}
			$('.asesorExtExiste').slideDown(300);
			//que agregue required a los campos clase obligatorio
			$('.asesorExtExiste span.select2-selection').css("background-color", "#dfe9f3");
			$('.asesorExtExiste select[name=selNomAsesorExt]').prop("required", true);
		});
		
		//=============================================================================
		//para mostrar/dejar de mostrar apartado asesor interno/externo en la edición
		$('#asesor1Edit').on('click', function(){		
			$('input:radio[name=selAsesorExt]').prop('checked',false);
			if($('.asesorExterno').is(':visible') ){				
				$('.asesorExterno').slideUp(300);
			}
			if($('.asesorExtNuevo').is(':visible') ){				
				$('.asesorExtNuevo').slideUp(300);
				//limpie los inputs de asesorExtNuevo y les quite required
				//$('.asesorExtNuevo input').val('');
				//$('.asesorExtNuevo input.obligatorio').prop("required", false);
			}
			if($('.asesorExtExiste').is(':visible') ){				
				$('.asesorExtExiste').slideUp(300);
				//limpie los inputs de asesorExtExiste y les quite required
				//$('.asesorExtExiste select').val('');
				//$('.asesorExtExiste select').val([]);
				$('.asesorExtExiste span.select2-selection__rendered').html('Seleccionar.....');
				//$('.asesorExtExiste select[name=selNomAsesorExt]').prop("required", false);
			}
			$('.asesorInterno').slideDown(300);
			//q me ponga required a los campos obligatorios
			//$('.asesorInterno input.obligatorio').prop("required", true);
			
			
		});
		$('#asesor2Edit').on('click', function(){					
			var idAsesorExt = $('#selNomAsesorExtEdit').attr('option', 'selected').val();	
			$('input:radio[name=selAsesorExt]').attr('checked',false);
			//que limpie todos los inputs de asesor interno y les quite required
			if($('.asesorInterno').is(':visible') ){
				//$('.asesorInterno input').val('');
				//$('.asesorInterno input.obligatorio').prop("required", false);	
				$('.asesorInterno').slideUp(300);
			}
			$('.asesorExterno').slideDown(300);			
			$('.asesorExtExiste').slideDown(300);
			$('.selNomAsesorExtEdit').val(idAsesorExt);
			$('.select2').select2({
				theme: 'bootstrap4'
			});
			
			
			//$('#asesor1').prop('disabled', true);
		});
		//Para seleccionar asesor nuevo
		$('#selAsesor1Edit').on('click', function(){
			if($('.asesorExtExiste').is(':visible') ){
				$('.asesorExtExiste').slideUp(300);
				//limpie los inputs de asesorExtExiste y les quite required
				//$('.asesorExtExiste select').val('');
				//$('.asesorExtExiste select').val([]);
				//$('.asesorExtExiste span.select2-selection__rendered').html('Seleccionar.....');
				//$('.asesorExtExiste select[name=selNomAsesorExt]').prop("required", false);			
			}
			$('.asesorExtNuevo').slideDown(300);
			//que agregue required a los campos clase obligatorio, ojo q aqui a lo mejor no sirve
			//$('.asesorExtNuevo input.obligatorio').prop("required", true);
		});
		//Para seleccionar asesor existente
		$('#selAsesor2Edit').on('click', function(){
			if($('.asesorExtNuevo').is(':visible') ){		
				$('.asesorExtNuevo').slideUp(300);
				//limpie los inputs de asesorExtNuevo y les quite required
				//$('.asesorExtNuevo input').val('');
				//$('.asesorExtNuevo input.obligatorio').prop("required", false);			
			}
			$('.asesorExtExiste').slideDown(300);
			//que agregue required a los campos clase obligatorio
			$('.asesorExtExiste span.select2-selection').css("background-color", "#dfe9f3");
			//$('.asesorExtExiste select[name=selNomAsesorExt]').prop("required", true);
		});

		//=============================================================================


		$('#formAgregarCliente').submit(function(){			
				var sectorText = $('select[name=sector] option:selected').text();
				var actText = $('select[name=actividad] option:selected').text();
				var colText = $('select[name=colaborador] option:selected').text();
				var ageText = $('select[name=agente] option:selected').text();
				var aseExtText = $('select[name=aseExtText] option:selected').text();

				/*if (sectorText == 'Seleccionar...' || actText == 'Seleccionar...' || colText == 'Seleccionar...' || ageText == 'Seleccionar...') {
					alert('los campos en celeste son obligatorios');
					event.preventDefault();
				}*/
				
				/*if ( $('#asesor1').is(':not(:checked)') && $('#asesor2').is(':not(:checked)')  ) {
					alert('debe ingresar un asesor');
					event.preventDefault();
				}*/
				if ($('#asesor2').is(':checked')) {
					if ( $('#selAsesor1').is(':not(:checked)') && $('#selAsesor2').is(':not(:checked)')  ) {
						alert('debe ingresar un asesor externo');
						event.preventDefault();					
					//esta parte no funciona
					}else if ( $('#selAsesor2').is(':checked') && aseExtText == 'Seleccionar...' ) {
						alert('debe seleccionar un asesor externo');
						event.preventDefault();					
					}
				}
		});
		
		$('#the-basics .typeahead').typeahead(
			
			{
				hint: true,
				highlight: true,
				//minLength: 1
			},
			{
				name: 'datos',
				limit: 10,
				source: function(query,sync,async){
					$.getJSON("Clientes/getGrupos",{query},
						function(data){
							async(data);
						}
					);
				},
				display: function(item){
					return item.idGrupo +' | '+ item.nombreG;
				}
			}
		);
		$('#the-basics .typeahead').on('typeahead:selected', function(e, dato){
			$('#grupoId').val(dato.idGrupo);
		});

		//Agregar contactos en modal nuevo cliente ....
		$('#mostrarContactos').click(function(e){
			e.preventDefault();
			if($('#listadoContactos').is(':visible')){
				$('#listadoContactos').slideUp(500);
				$(this).html('Mostrar &nbsp;&nbsp;<i class="fas fa-chevron-down" style="color: white;"></i>');
			}else{ //si no está visible
				$('#listadoContactos').slideDown(500);
				$(this).html('Cerrar &nbsp;&nbsp;<i class="fas fa-chevron-up" style="color: white;"></i>');
			}
		});

		var lineaContacto = 0;

		$(document).on('click', '#agregarContacto', function (e) {
			e.preventDefault();

			lineaContacto++;
			var filaEmail2 ='<tr>'+
								'<td>'+lineaContacto+'</td>'+
								'<td><input class="form-control" name="nombreContacto[]" /></td>'+ 
								'<td><input class="form-control" name="areaContacto[]" /></td>'+  
								'<td><input class="form-control" type="text" regexp="[0-9]{0,9}" name="telFijoContacto[]" /></td>'+ 
								'<td><input class="form-control" type="text" regexp="[0-9]{0,9}" name="movilContacto[]" /></td>'+                
								'<td><input class="form-control" name="emailContacto[]" /></td>'+							
								'<td>'+
									'<a class="btn btn-danger eliminarContacto" title="Quitar" style="color:white;">'+
									'        <i class="fas fa-trash"></i>'+
									'</a>'+
								'</td>'+
								
							'</tr>';
			$('#tablaContactosCliente').append(filaEmail2);  
			validatorInputKeyPress();
               
		});    
		
		$(document).on("click", '.eliminarContacto', function(){	
			var filaContacto = $(this).closest('tr');     
			filaContacto.remove(); 
		});
		

		//Editar contactos en modal Edición Cliente ....en construccion
		$('#mostrarContactosEdit').click(function(e){
			e.preventDefault();
			if($('#listadoContactosEdit').is(':visible')){
				$('#listadoContactosEdit').slideUp(500);
				$(this).html('Mostrar &nbsp;&nbsp;<i class="fas fa-chevron-down" style="color: white;"></i>');
			}else{ //si no está visible
				$('#listadoContactosEdit').slideDown(500);
				$(this).html('Cerrar &nbsp;&nbsp;<i class="fas fa-chevron-up" style="color: white;"></i>');
			}
		});

		var lineaContactoEdit = 0;

		$(document).on('click', '#agregarContactoEdit', function (e) {
			e.preventDefault();

			lineaContactoEdit++;
			var filaEmail2 ='<tr>'+
								'<td>'+lineaContactoEdit+'</td>'+
								'<td><input class="form-control" name="nombreContactoEdit[]" /></td>'+ 
								'<td><input class="form-control" name="areaContactoEdit[]" /></td>'+  
								'<td><input class="form-control" type="text" regexp="[0-9]{0,9}" name="telFijoContactoEdit[]" /></td>'+ 
								'<td><input class="form-control" type="text" regexp="[0-9]{0,9}" name="movilContactoEdit[]" /></td>'+                
								'<td><input class="form-control" name="emailContactoEdit[]" /></td>'+
								'<td class="d-flex">'+
									'<a class="btn btn-danger eliminarContactoEdit" title="Quitar" style="color:white;">'+
									'        <i class="fas fa-trash"></i>'+
									'</a>'+
								'</td>'+        
							'</tr>';
			$('#tablaContactosClienteEdit').append(filaEmail2);
			validatorInputKeyPress();
		});    
		
		$(document).on("click", '.eliminarContactoEdit', function(){			
			var filaContacto = $(this).closest('tr');     
            filaContacto.remove();  
		});	
		
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
		
		
	/// END CLIENTES

	/// INICIO OPORTUNIDADES
	if (window.location.pathname.includes('/clientes/oportunidades')) {

		/* Añdir cajas de busqueda a las cabeceras */
		$('#table_oportunidades thead th').each(function () {
			var title = $(this).text();
			$(this).html(title + '</br><input type="text" class="col-search-input" style="margin-top:10px;" placeholder="" />');
		});

		let clientes = $('#table_oportunidades').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": "getOportunidades",
			"info": true,
			"language": {
				"url": "datatables/Languages/Spanish.json"
			},
			"columnDefs": [
				{
					targets: 6,
					render: function (data, type, row, meta) {
						let edit = '<a href="" data-toggle="modal" data-target="#ModalEdit"  class="btn btn-info btn-sm edit"' +
							' data-id="' + row['DT_RowId'] + '" data-rol="' + row[1] + '"> <i class="fas fa-pencil-alt"></i></a>';
						let deleteRow = '<a href="" data-toggle="modal" data-target="#ModalDelete"  class="btn btn-danger btn-sm delete"' +
							' data-id="' + row['DT_RowId'] + '" data-nombre="' + row[3] + '" ><span class="fa fa-trash"></span></a>';
						return edit + " " + deleteRow;
					}

				},
				{ className: "dt-center", targets: ["_all"] }
			],
			'responsive': true,
			'dom': 'lBfrtip',
			/* codigo para ejecutar la busqueda por columna de la tabla */
			'initComplete': function () {
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
			},
			"buttons": [
				{
					"extend": 'excelHtml5',
					"text": '<i class="fas fa-file-excel" style="color:green;"></i>',
					"titleAttr": 'Exportar a Excel',
					"className": 'btn btn-success',
					format: {
						body: function (data, row, column, node) {
							data = $('<p>' + data + '</p>').text();
							data = data.replace('.', '')
							return $.isNumeric(data.replace(',', '.')) ? data.replace(',', '.') : data;
						}
					}
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
			]

		});

		$('#table_oportunidades').css('visibility', 'visible');

		//Hide-show datatable columns
		$('a.toggle-vis').on('click', function (e) {
			e.preventDefault();
			// Get the column API object
			var column = clientes.column($(this).attr('data-column'));
			// Toggle the visibility
			column.visible(!column.visible());
		});

		$.fn.dataTable.ext.errMode = 'none';
		$('#table_oportunidades').on('error.dt', function (e, settings, techNote, message) {
			console.log('An error has been reported by DataTables: ', message);
		}).DataTable();
		$('#table_oportunidades').DataTable();


	
	}
		$('#table_oportunidades').on('click', '.delete', function () {
			var id = $(this).data('id');
			var nombre = $(this).data('nombre');

			$('[name="id"]').val(id);
			$('[name="nombre"]').val(nombre);

		});
		$('#table_oportunidades').on('click', '.edit', function () {
			//    show ventana de editar

			var id = $(this).data('id');
			$.ajax({
				type: 'POST',
				url: 'getOportunidadesUpdate',
				data: { 'id': id },
				dataType: "JSON"
			}).done(function (data) {
				//data = JSON.parse(data);			
				//data = data[0];
				let data1 = data['clientes'][0];
				//let data2 = data['colaboradores'][0];
				//console.log(data['clientes']);
				
				
				$('#idEdit').val(data1["idEMPRESA"]);			
				$('#nombreComercialEdit').val(data1["NOMBREJURIDICO"]);
				$('#direccionEdit').val(data1["DIRECCION"]);			
				$('#poblacionEdit').val(data1["LOCALIDAD"]);
				$('#provinciaEdit').val(data1["PROVINCIA"]);			
				$('#codigoPostalEdit').val(data1["CODPOSTAL"]);
				$('#telefonofijo1Edit').val(data1["TELEFONOFIJO1"]);			
				$('#movilEdit').val(data1["TELEFONOMOVIL"]);
				$('#estadoOpEdit').val(data1["estadooportunidad"]);
				$('#emailEdit').val(data1["EMAIL"]);			
				//$('#fechaEdit').val(data1["fechaOportunidad"]);			
				$('#trabajadoresEdit').val(data1["numtrabajadores"]);			
				$('#contactoPrincipalEdit').val(data1["CONTACTO"]);
				$('#sectorEdit').val(data1["CODSECTOR"]);
				$('#colaboradorEdit').val(data1["idColaborador"]);
	/*
				for (let index = 0; index < data2.length; index++) {
					$('#colaboradorEdit').append('<option value="' + data2[index]['codColaborador'] + '">' + data2[index]['RazonSocial'] + '</option>');
				}*/
						//incluir en una funcion
				$('.select2').select2({
					theme: 'bootstrap4'
				});
			}).fail(function () {
				console.log('Hubo un error al cargar los datos del cliente.');
			});


		});
	
		$('#btnaAddOportunidad').on('click', function(e){
			e.preventDefault();
			$('#identificadorOp').val('agregarOportunidad');
			$("#formAgregarOportunidad").submit();
		})
		//---------------------	
		/// FIN OPORTUNIDADES


	// CLAVES GENERAL
if (window.location.pathname.includes('/general')) {

		$(document).ready(function () {
			/* Añdir cajas de busqueda a las cabeceras */
			$('#claves_general thead th').each(function () {
				var title = $(this).text();
				$(this).html(title + '</br><input type="text" class="col-search-input" style="margin-top:10px;" placeholder="" />');
			});


			let claves_general = $('#claves_general').DataTable({
				"responsive": true,
				"autoWidth": true,
				"dom": 'lBfrtip',
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

			//Hide-show datatable columns
			$('a.toggle-vis').on('click', function (e) {
				e.preventDefault();
				// Get the column API object
				var column = claves_general.column($(this).attr('data-column'));
				// Toggle the visibility
				column.visible(!column.visible());
			});

			$.fn.dataTable.ext.errMode = 'none';
			$('#claves_general').on('error.dt', function (e, settings, techNote, message) {
				console.log('An error has been reported by DataTables: ', message);
			}).DataTable();
			$('#claves_general').DataTable();
		});

	}

	// END CLAVES GENERAL

	// CLAVES PLATAFORMA

	if (window.location.pathname.includes('/plataforma')) {

		$(document).ready(function () {
			/* Añdir cajas de busqueda a las cabeceras */
			$('#claves_plataforma thead th').each(function () {
				var title = $(this).text();
				$(this).html(title + '</br><input type="text" class="col-search-input" style="margin-top:10px;" placeholder="" />');
			});


			let claves_plataforma = $('#claves_plataforma').DataTable({
				"responsive": true,
				"autoWidth": true,
				"dom": 'lBfrtip',
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

			//Hide-show datatable columns
			$('a.toggle-vis').on('click', function (e) {
				e.preventDefault();
				// Get the column API object
				var column = claves_plataforma.column($(this).attr('data-column'));
				// Toggle the visibility
				column.visible(!column.visible());
			});

			$.fn.dataTable.ext.errMode = 'none';
			$('#claves_plataforma').on('error.dt', function (e, settings, techNote, message) {
				console.log('An error has been reported by DataTables: ', message);
			}).DataTable();
			$('#claves_plataforma').DataTable();
		});


	}

	// CLAVES PLATAFORMA

	// CLAVES CDEV
	if (window.location.pathname.includes('/cdev')) {

		$(document).ready(function () {
			/* Añdir cajas de busqueda a las cabeceras */
			$('#claves_cdev thead th').each(function () {
				var title = $(this).text();
				$(this).html(title + '</br><input type="text" class="col-search-input" style="margin-top:10px;" placeholder="" />');
			});


			let claves_cdev = $('#claves_cdev').DataTable({
				"responsive": true,
				"autoWidth": true,
				"dom": 'lBfrtip',
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

			//Hide-show datatable columns
			$('a.toggle-vis').on('click', function (e) {
				e.preventDefault();
				// Get the column API object
				var column = claves_cdev.column($(this).attr('data-column'));
				// Toggle the visibility
				column.visible(!column.visible());
			});

			$.fn.dataTable.ext.errMode = 'none';
			$('#claves_cdev').on('error.dt', function (e, settings, techNote, message) {
				console.log('An error has been reported by DataTables: ', message);
			}).DataTable();
			$('#claves_cdev').DataTable();
		});



	}
	// END CLAVES CDEV

	// CLAVES REDES

	if (window.location.pathname.includes('/redessociales')) {

		$(document).ready(function () {
			/* Añdir cajas de busqueda a las cabeceras */
			$('#claves_redes thead th').each(function () {
				var title = $(this).text();
				$(this).html(title + '</br><input type="text" class="col-search-input" style="margin-top:10px;" placeholder="" />');
			});


			let claves_redes = $('#claves_redes').DataTable({
				"responsive": true,
				"autoWidth": true,
				"dom": 'lBfrtip',
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

			//Hide-show datatable columns
			$('a.toggle-vis').on('click', function (e) {
				e.preventDefault();
				// Get the column API object
				var column = claves_redes.column($(this).attr('data-column'));
				// Toggle the visibility
				column.visible(!column.visible());
			});
			$.fn.dataTable.ext.errMode = 'none';
			$('#claves_redes').on('error.dt', function (e, settings, techNote, message) {
				console.log('An error has been reported by DataTables: ', message);
			}).DataTable();
			$('#claves_redes').DataTable();
		});



	}
	//END CLAVES REDES

	// CLAVES PORTALES
	if (window.location.pathname.includes('/portalesempleo')) {

		$(document).ready(function () {
			/* Añdir cajas de busqueda a las cabeceras */
			$('#claves_portales thead th').each(function () {
				var title = $(this).text();
				$(this).html(title + '</br><input type="text" class="col-search-input" style="margin-top:10px;" placeholder="" />');
			});


			let claves_portales = $('#claves_portales').DataTable({
				"responsive": true,
				"autoWidth": true,
				"dom": 'lBfrtip',
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

			//Hide-show datatable columns
			$('a.toggle-vis').on('click', function (e) {
				e.preventDefault();
				// Get the column API object
				var column = claves_portales.column($(this).attr('data-column'));
				// Toggle the visibility
				column.visible(!column.visible());
			});
			$.fn.dataTable.ext.errMode = 'none';
			$('#claves_portales').on('error.dt', function (e, settings, techNote, message) {
				console.log('An error has been reported by DataTables: ', message);
			}).DataTable();
			$('#claves_portales').DataTable();
		});



	}
	// END CLAVES PORTALES

	// CLAVES USUARIOS PC

	if (window.location.pathname.includes('/usuariospc')) {

		$(document).ready(function () {
			/* Añdir cajas de busqueda a las cabeceras */
			$('#claves_pc thead th').each(function () {
				var title = $(this).text();
				$(this).html(title + '</br><input type="text" class="col-search-input" style="margin-top:10px;" placeholder="" />');
			});


			let claves_pc = $('#claves_pc').DataTable({
				"responsive": true,
				"autoWidth": true,
				"dom": 'lBfrtip',
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

			//Hide-show datatable columns
			$('a.toggle-vis').on('click', function (e) {
				e.preventDefault();
				// Get the column API object
				var column = claves_pc.column($(this).attr('data-column'));
				// Toggle the visibility
				column.visible(!column.visible());
			});
			$.fn.dataTable.ext.errMode = 'none';
			$('#claves_pc').on('error.dt', function (e, settings, techNote, message) {
				console.log('An error has been reported by DataTables: ', message);
			}).DataTable();
			$('#claves_pc').DataTable();
		});



	}

	// END CLAVES USUARIOS PC


});
// }) ;
