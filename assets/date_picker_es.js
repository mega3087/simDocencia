$(document).ready(function(){
	/*inicio date picker */
	$.fn.datepicker.dates['es'] = {
		days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"],
		daysShort: ["Dom", "Lun", "Mart", "Miérc", "Juev", "Vier", "Sáb", "Dom"],
		daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
		months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
		monthsShort: ["En", "Febr", "Mzo", "Apr", "My", "Jun", "Jul", "Ag", "Sept", "Oct", "Nov", "Dic"],
		today: "Hoy",
		clear: "Limpiar"
	};
	
	$('.date, .fecha').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		autoclose: true,
		format: "dd/mm/yyyy",
		language: 'es'
	}); /*fin date picker */
});