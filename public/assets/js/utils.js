(function($){
    $.fn.focusTextToEnd = function(){
        this.focus();
        var $thisVal = this.val();
        this.val('').val($thisVal);
        return this;
    }
}(jQuery));
function formatoPrecio (precio){
	return formatoPrecioParametros(precio,2,true);
}
function formatoPrecioParametros (n,c,mon){
		c = isNaN(c = Math.abs(c)) ? 2 : c,
   		d = ".",
		t = ",",
		s = n < 0 ? "-" : "",
    		i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
    		j = (j = i.length) > 3 ? j % 3 : 0;
    		var retorno =  s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
		if(mon){
			retorno+=" €";
		}
		return retorno;

}

function anadirArticuloGeneral(datos){
	switch(ventanaReferenciaAuxiliar){
		case 'autorizacion': anadirArticuloAutorizacion(datos);break;
		case 'pedido': anadirArticuloPedido(datos);break;
	}
	
}
$.datepicker.regional['es'] = {
	closeText: 'Cerrar',
	prevText: '< Ant',
	nextText: 'Sig >',
	currentText: 'Hoy',
	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
	monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
	dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
	dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
	weekHeader: 'Sm',
	dateFormat: 'dd/mm/yy',
	firstDay: 1,
	isRTL: false,
	showMonthAfterYear: false,
	yearSuffix: ''
};
$.datepicker.setDefaults($.datepicker.regional['es']);

function iniciaControlesGenerales(){
	
	$('.dateInput').datepicker();
	jQuery('.enlaceAAutorizacion').click(function(){
                var doc = '#icon_dock_autorizaciones_aux';
                var win = '#window_autorizaciones_aux';
                var content = '#contenido_autorizaciones_aux';

                // Incorporamos barra de carga
                jQuery(content).html("<div class='loagindWrapper'><h3>Cargando...</h3><div class='progress'><div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuenow='100' aria-valuemin='0' alt='Cargando' title='Cargando' aria-valuemax='100' style='width: 100%'><span class='sr-only'>Cargando</span></div></div></div>");

                var num = jQuery(this).attr('data-reference');
                // Asiganmos los títulos a las ventanas
                jQuery(win+' .window_top .etiqueta').html('Editando Autorización '+num);
                jQuery(doc+' .etiqueta').html('Editando Autorización '+num);

                // Show the taskbar button.
                if ($(doc).is(':hidden')) {
                        $(doc).show('fast');
                        $(doc +' a' ).addClass('active');
                }
                // Bring window to front.
                JQD.util.window_flat();
                $(win).addClass('window_stack').show();

                jQuery(content).load('ajaxControlador.php?control=autorizacion&accion=editar&id='+num);


        });
	jQuery('.enlaceAPedido').click(function(){
                var doc = '#icon_dock_pedidos_aux';
                var win = '#window_pedidos_aux';
                var content = '#contenido_pedidos_aux';

                // Incorporamos barra de carga
                jQuery(content).html("<div class='loagindWrapper'><h3>Cargando...</h3><div class='progress'><div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuenow='100' aria-valuemin='0' alt='Cargando' title='Cargando' aria-valuemax='100' style='width: 100%'><span class='sr-only'>Cargando</span></div></div></div>");

                var pedido = jQuery(this).attr('data-reference');
                // Asiganmos los títulos a las ventanas
                jQuery(win+' .window_top .etiqueta').html('Editando Pedido '+pedido);
                jQuery(doc+' .etiqueta').html('Editando Pedido '+pedido);

                // Show the taskbar button.
                if ($(doc).is(':hidden')) {
                        $(doc).show('fast');
                        $(doc +' a' ).addClass('active');
                }
                // Bring window to front.
                JQD.util.window_flat();
                $(win).addClass('window_stack').show();

                jQuery(content).load('ajaxControlador.php?control=pedido&accion=editar&id='+pedido);


        });
	jQuery('.enlaceAFactura').click(function(){
                var doc = '#icon_dock_facturas_aux';
                var win = '#window_facturas_aux';
                var content = '#contenido_facturas_aux';

                // Incorporamos barra de carga
                jQuery(content).html("<div class='loagindWrapper'><h3>Cargando...</h3><div class='progress'><div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuenow='100' aria-valuemin='0' alt='Cargando' title='Cargando' aria-valuemax='100' style='width: 100%'><span class='sr-only'>Cargando</span></div></div></div>");

                var num = jQuery(this).attr('data-reference');
                // Asiganmos los títulos a las ventanas
                jQuery(win+' .window_top .etiqueta').html('Editando Factura '+num);
                jQuery(doc+' .etiqueta').html('Editando Factura '+num);

                // Show the taskbar button.
                if ($(doc).is(':hidden')) {
                        $(doc).show('fast');
                        $(doc +' a' ).addClass('active');
                }
                // Bring window to front.
                JQD.util.window_flat();
                $(win).addClass('window_stack').show();

                jQuery(content).load('ajaxControlador.php?control=factura&accion=editar&id='+num);


        });

	$('input').bind("keypress", function(e) {
                        if (e.keyCode == 13) {
                                e.preventDefault();
                                return false;
                        }
                });

}

function bloquearEnter(){
	 $('input').bind("keypress", function(e) {
                        if (e.keyCode == 13) {
                                e.preventDefault();
                                return false;
                        }
                });

}
