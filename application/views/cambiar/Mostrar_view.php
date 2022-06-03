<div class="row">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
			<h3>Cambiar de Usuario</h3>
		</div>
	</div>
</div>
<div class="row">
	<div class=" col-lg-offset-3 col-lg-5">
		<?php muestra_mensaje(); ?>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<div class="pull-right">
				</div>
				<h3>&nbsp;</h3>
			</div> 
			<div class="ibox-content">
				<div id="ajax"></div>
				<?php if( is_permitido(get_session('OldRol'),'cambiar','save_clave') ){ ?>
				<div class="table-responsive">
					<form action="<?php echo base_url("cambiar/save_clave"); ?>" role="form_c" name="form_c" id="form_c" method="POST" class="form-horizontal panel-body">
						<div class="form-group">
							<label class="col-lg-3 control-label">Clave Servidor: <em>*</em></label>
							<div class="col-lg-9">
								<input type="text" id="UClave_servidor" name="UClave_servidor" maxlength="5" class="form-control" required />
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-9">
								<button type="submit" class="btn btn-primary pull-right"> <i class="fa fa-save"></i> Cambiar</button>
							</div>
						</div>
					</form>
				</div>
				<br />
				<?php } ?>
				<?php if( is_permitido(null,'cambiar','save_plantel') ){ ?>
				<div class="table-responsive">
					<form action="<?php echo base_url("cambiar/save_plantel"); ?>" role="form_p" name="form_p" id="form_p" method="POST" class="form-horizontal panel-body">
						<div class="form-group">
							<label class="col-lg-3 control-label">Plantel: <em>*</em></label>
							<div class="col-lg-9">
								<select type="text" id="UPlantel" name="UPlantel" maxlength="5" class="form-control" required >
									<option value=""></option>
									<?php foreach($planteles as $kep => $list){ ?>
									<option <?php if(get_session('UPlantel')== $list['CPLClave']) echo"selected"; ?> value="<?php echo $list['CPLClave']; ?>"><?php echo $list['CPLNombre']; ?></option>
									<?php } echo get_session('UPlantel');?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-9">
								<button type="submit" class="btn btn-primary pull-right"> <i class="fa fa-save"></i> Cambiar</button>
							</div>
						</div>
					</form>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
	
		$("#form_c").submit(function(e) {
			e.preventDefault();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url("cambiar/save_clave"); ?>",
				data: $(this).serialize(),
				dataType: "html",
				beforeSend: function(){
					$("#ajax").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
				},
				success: function(data){
					if(data==' OK'){
						location.href ="<?php echo base_url("dashboard"); ?>";
					}
					else{
						$("#ajax").empty();
						$("#ajax").append(data);
					}
					
				}
			});
		});//----->fin
		
		$("#form_p").submit(function(e) {
			e.preventDefault();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url("cambiar/save_plantel"); ?>",
				data: $(this).serialize(),
				dataType: "html",
				beforeSend: function(){
					$("#ajax").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
				},
				success: function(data){
					if(data==' OK'){
						location.href ="<?php echo base_url("dashboard"); ?>";
					}
					else{
						$("#ajax").empty();
						$("#ajax").append(data);
					}
					
				}
			});
		});//----->fin
		
	});//----->fin
</script>	