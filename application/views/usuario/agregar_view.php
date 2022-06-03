<?php // jQuery Password Strength Plugin http://asgaard.co.uk/misc/jquery/index.php?show=password     ?>
<script src="<?php echo base_url('assets/pstrength/jquery.pstrength1.5.js'); ?>" type="text/javascript"></script>

<?php // Show password https://github.com/wenzhixin/bootstrap-show-password ?>
<script src="<?php echo base_url('assets/show-password/password.js'); ?>"></script>

<script src="<?php echo base_url('assets/inspinia/js/plugins/chosen/chosen.jquery.js');?>"></script>
<link href="<?php echo base_url('assets/inspinia/css/plugins/chosen/chosen.css');?>" rel="stylesheet">

<div class="col-lg-6 col-lg-offset-3">
	<div class="ibox float-e-margins">
		
		<div class="ibox-title">                    
			<h5>Creaci&oacute;n de cuenta.</h5>
		</div>
		<div class="ibox-content">
			<form method="post" class="form-horizontal" id="forma" name="forma"
			role="form" action="<?php echo base_url('usuario/insert');?>">
				<?php muestra_mensaje(); ?>
				
				<div class="form-group">
					<label class="col-md-3 col-lg-4 control-label"> Nombre del responsable: <em>*</em></label>
					<div class="col-md-9 col-lg-8">
						<input type="text" class="form-control" required id="UNombre" 
						name="UNombre" value ="<?php echo nvl($UNombre); ?>" maxlength = "100"/>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-3 col-lg-4 control-label">Correo electr&oacute;nico del responsable: <em>*</em></label>
					<div class="col-md-9 col-lg-8">
						<input type="email" class="form-control" required 
						id="UCorreo_electronico" name="UCorreo_electronico" 
						value ="<?php echo nvl($UCorreo_electronico); ?>" 
						maxlength = "60"/>
						<span class="help-block">A este correo se enviar&aacute; el c&oacute;digo de activaci&oacute;n de la cuenta</span>
					</div>
				</div>
				
				<!--div class="form-group">
					<label class="col-md-3 col-lg-4 control-label"> Usuario: <em>*</em></label>
					<div class="col-md-9 col-lg-8">
						<input type="text" class="form-control" required id="UUsuario" 
						name="UUsuario" value ="<?php echo nvl($UUsuario); ?>" 
						maxlength = "50" required />
					</div>
				</div-->
				
				
				<div class="form-group">
					<label class="col-md-3 col-lg-4 control-label"> Teléfono de contacto: <em>*</em></label>
					<div class="col-md-9 col-lg-8">
						<input type="text" class="form-control" required id="UTelefono" 
						name="UTelefono" value ="<?php echo nvl($UTelefono); ?>" 
						maxlength = "60" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-3 col-lg-4 control-label"> Contraseña: <em>*</em></label>
					<div class="col-md-9 col-lg-8">
						<input type="password" class="form-control" 
						id="UContrasena" name="UContrasena" value ="<?php echo nvl($UContrasena); ?>" 
						data-message="Mostrar / ocultar contrase&ntilde;a" 
						pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
						data-indicator="pwindicator" maxlength = "20" 
						oninvalid="setCustomValidity('Utilice el formato solicitado: Digite 8 o m&aacute;s caracteres, conteniendo al menos una may&uacute;scula, una min&uacute;scula y un n&uacute;mero o signo especial')" 
						oninput="setCustomValidity('')" required />
					</div>
				</div>      
				
				<div class="form-group">
					<div class="col-md-offset-3 col-md-9 col-lg-offset-4 col-lg-8">
						<button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i> Crear cuenta</button>&nbsp;&nbsp;&nbsp;
						<a class="btn btn-w-m btn-default" href="<?php echo base_url(); ?>"><i class="fa fa-times"></i> Cancelar</a>                            
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {  
		$('#UContrasena').pstrength();
		$('#UContrasena').password();
		
		var config = {
			'.chosen-select'           : {},
			'.chosen-select-deselect'  : {allow_single_deselect:true},
			'.chosen-select-no-single' : {disable_search_threshold:10},
			'.chosen-select-no-results': {no_results_text:'¡No se encontro!'},
			'.chosen-select-width'     : {width:"100%"}
		}
		for (var selector in config) {
			$(selector).chosen(config[selector]);
		}  
	});
</script>
