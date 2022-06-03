$(document).ready(function(){
	
	//funcion clase para regresar a la página anterior
	$('.back').click(function(){
		parent.history.back();
		return false;
	});
	
	//funcion para confirmar borrar
/* 	$('.delete').click(function(){
		return confirm('¿Esta seguro de borrar PERMANENTEMENTE este registro?');
	}); */
	
	$('.delete').click(function(e){
	
		e.preventDefault();
		//recogemos la dirección del Proceso PHP
		href = $(this).attr('href');

		//colocamos fondo de pantalla
		$('#wrapper').prop('class','bgtransparent');
		
		alertify.confirm("¿Esta seguro de borrar PERMANENTEMENTE este registro?", function (e) {
			//aqui introducimos lo que haremos tras cerrar la alerta.
			$('#wrapper').prop('class','');
			if (e){
				window.location = this.href;
			}
				
		});
		
	});
	
	//funcion para confirmar borrar
	
	$('[confirm]').click(function(e){
	
		e.preventDefault();
		//recogemos la dirección del Proceso PHP
		href = $(this).attr('href');
		mensaje = $(this).attr('confirm');
		if(!mensaje)
			mensaje = "¿Estas seguro de realizar está acción?";

		//colocamos fondo de pantalla
		$('#wrapper').prop('class','bgtransparent');
		
		alertify.confirm(mensaje, function (e) {
			//aqui introducimos lo que haremos tras cerrar la alerta.
			$('#wrapper').prop('class','');
			if (e){
				window.location = this.href;
			}
				
		});
		
	});
	
	//verificar que un Checkbox esta seleccionado
	$(".checkbox").click(function(){
		var box=null;
		$('input[type=checkbox]').each( function() {
			if( $(this).is(':checked') )
			box=1;
		});
		
		if(! box==1){
			
			$('#wrapper').prop('class','bgtransparent');	
			alertify.alert("<b>Seleccione al menos un registro</b>", function () {
				//aqui introducimos lo que haremos tras cerrar la alerta.
				$('#wrapper').prop('class','');	
			});
			
			return false;
			
		}
		
	});
	
	// cambiar texto a mayusculas	
	$('.uppercase').keyup(function(){
		valor = $(this).val().toUpperCase();
		$(this).val( valor );
	});
	
	// cambiar texto a minisculas
	$('.lowercase').keyup(function(){
		valor = $(this).val().toLowerCase();
		$(this).val( valor );
	});
	
	
	//para dar formato con comas a los precios
	jQuery(function($) {
		$('.money').autoNumeric('init');
	});
	
	$('.number').bind("keypress", function(e){
		var code = e.keyCode || e.which;
		 if ((code >= 35 && code <= 57) || code == 8) return true;
		 return false;
	});
	
	/*/Quitar cerrar modal al dar click afuera
	$(".modal").attr('data-backdrop',"static");
	$(".modal").attr('data-keyboard',"false");
	//Fin quitar cerrar modal al dar click afuera //*/
	
	//para quitar la barra de scrol y el auto resize de la clase textarea al cargar
	$('.textarea').each(function(){
		this.setAttribute('style', 'height:auto;overflow-y:hidden;');
		//this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
	}).on('keyup', function(){
		this.style.height = 'auto';
		this.style.height = (this.scrollHeight) + 'px';
	});
	
});

// Para required oninvalid
function invalid(texto){
	$('#wrapper').prop('class','bgtransparent');	
	alertify.alert(texto, function () {
		//aqui introducimos lo que haremos tras cerrar la alerta.
		$('#wrapper').prop('class','');	
	});
};//fin oninvalid


function limpiar(clase){
	if(clase== undefined ) clase = '';
	$('.'+clase+' input[type=text]').val('');
	$('.'+clase+' input[type=password]').val('');
	$('.'+clase+' input[type=color]').val('');
	$('.'+clase+' input[type=date]').val('');
	$('.'+clase+' input[type=email]').val('');
	$('.'+clase+' input[type=number]').val('');
	$('.'+clase+' input[type=range]').val('');
	$('.'+clase+' input[type=url]').val('');
	$('.'+clase+' input[type=textarea]').val('');
	$('.'+clase+' input[type=select]').val('');
	$('.'+clase+' input[type=checkbox]').iCheck('uncheck');
	$('.'+clase+' input[type=radio]').iCheck('uncheck');
}