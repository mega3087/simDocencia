<?php // jQuery Password Strength Plugin http://asgaard.co.uk/misc/jquery/index.php?show=password     ?>
<script src="<?php echo base_url('assets/pstrength/jquery.pstrength1.5.js'); ?>" type="text/javascript"></script>

<?php // Show password https://github.com/wenzhixin/bootstrap-show-password  ?>
<script src="<?php echo base_url('assets/show-password/password.js'); ?>"></script>

<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Cambiar contrase&ntilde;a</h5>
			</div>
			<div class="ibox-content">
				<form method="post" class="form-horizontal" id="forma" name="forma"
				role="form" action="<?php echo base_url("usuario/nueva_contrasena");?>">
					<?php muestra_mensaje(); ?>
					
					<div class="form-group">
						<label class="col-md-3 control-label">Nueva contraseña: <em>*</em></label>
						<div class="col-md-9">
							<input type="password" class="form-control" 
							title="Digite 8 o m&aacute;s caracteres, conteniendo al menos una may&uacute;scula, una min&uacute;scula y un n&uacute;mero o signo especial"
							id="UContrasena" name="UContrasena" value ="<?php echo nvl($UContrasena); ?>" 
							data-message="Mostrar / ocultar contrase&ntilde;a" 
							pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
							data-indicator="pwindicator" maxlength = "20" required />
						</div>
					</div>    
					
					<div class="form-group">
						<div class="col-md-offset-3 col-md-9">
							<button class="btn btn-primary" type="submit">
							<i class="fa fa-paper-plane"></i> Cambiar</button>&nbsp;&nbsp;&nbsp;
							<a class="btn btn-w-m btn-default" href="<?php echo base_url(); ?>">
								<i class="fa fa-times"></i> Cancelar
							</a>                            
						</div>
					</div>
					
					<?php
						echo form_hidden('usuario_skip', nvl( $usuario_skip ) );
						echo form_hidden('correo_electronico_skip', nvl( $correo_electronico_skip ) );
					?>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$("#UContrasena").parent().removeClass().addClass('col-lg-4');
		$('#UContrasena').pstrength();
		$('#UContrasena').password();
	});
</script>