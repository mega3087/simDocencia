<div class="row">
	<div class="col-md-3"></div>	
	<div class="col-md-7">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Cambiar contrase&ntilde;a</h5>
			</div>
			<div class="ibox-content">
				<form method="post" class="form-horizontal" 
				id="forma" name="forma"
				role="form" action="<?php echo base_url("usuario/enviar_instrucciones/adm"); ?>">
					<?php muestra_mensaje(); ?>
					<div class="form-group">
						<label class="col-md-3 control-label">Correo electr&oacute;nico: <em>*</em></label>
						<div class="col-md-9">
							<input type="email" class="form-control" required name="UCorreo_electronico" value ="<?php echo nvl($CSPUSUARIO); ?>" />
							<span class="help-block">A este correo se enviar&aacute; las instrucciones para el cambio de la contraseña</span>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-md-offset-3 col-md-9">
							<button class="btn btn-primary" type="submit">
								<i class="fa fa-paper-plane"></i> Enviar
							</button>&nbsp;&nbsp;&nbsp;
							<a class="btn btn-default" href="<?php echo base_url('login/logout'); ?>">
								<i class="fa fa-times"></i> Cancelar
							</a>                            
						</div>
					</div>                   
				</form>
			</div>
		</div>
	</div>
</div>