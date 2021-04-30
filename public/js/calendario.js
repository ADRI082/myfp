$(document).ready(function () {
 
  if (window.location.pathname.includes("/calendario")) {
 
  
      var calendarEl = document.getElementById('calendar');
     
      var calendar = new FullCalendar.Calendar(calendarEl, {
       
        locale: 'es',
        slotDuration: '00:30',
        firstDay: 1,
        allDaySlot: false,
        longPressDelay: 0,
        plugins: ['interaction', 'dayGrid', 'timeGrid', 'list'],
        customButtons: {
          buttonanio: {
            text: 'Año',
            click: function () {
              calendar.changeView('listYear');
            }
          }
        },
        header: {
          //left: 'prevYear,prev,next,nextYear today',
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth,buttonanio'
        },
        columnHeaderFormat: {
          weekday: 'long',
          color: 'white',
        },
        columnFormat: {
          month: 'dddd',
        },
        displayEventTime: false,
        navLinks: true, // can click day/week names to navigate views
  
        selectable: true,
        eventLimit: 3, // allow "more" link when too many events
        events: "Calendario/getAcciones",

        select: function (info) {
          $('#createEventModal').modal('show');
  
        }, 
        eventClick: function (info) {
          $('#calendarModalEdit').modal('show');
          var id = info.event.id;
          $.ajax({
            type: 'POST',
            url: 'Calendario/getAccionUpdate',
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
            $('#idDelete').val(id);
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
        }
       
      });
       calendar.render();
      $(".select_option").on("change", function(){   
        empresa = $(".empresa").val();
        agente = $(".agente").val();
        estado = $(".estado").val()
           
        $.ajax({
          type: "POST",
          url: "Calendario/getAcciones",
          data: {
           empresa:empresa,
           agente:agente,
           estado:estado     
          }
        }).done(function (data) {

          data = JSON.parse(data);      
          eventSources = calendar.getEventSources();
          eventSources[0].remove();
          calendar.addEventSource(data);
          calendar.refetchEvents();
    
        });
      })
     
    
      $(".historico").on("click", function (info) {
        $.ajax({
          url: "Calendario/getHistorico",
          data: {},
          type: "POST",
          success: function (data) {
            $("#timeLineBody").html(data);
          }
        });
      });
  } 
 
})