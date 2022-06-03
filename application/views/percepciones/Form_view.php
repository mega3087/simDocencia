<link href="<?php echo base_url('assets/inspinia/css/plugins/dropzone/basic.css-');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/dropzone/dropzone.css-');?>" rel="stylesheet">

<div class="row">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
			<h3>Recibos</h3>
		</div>
	</div>
</div>
<form action="<?php echo base_url("recibos/save"); ?>" method="post" enctype="multipart/form-data" class="form-horizontal panel-body"> 
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox-content">
				<div class="form-group ">
					<label class="col-lg-3 control-label visible-lg" for="AAnio"><br />Opciones: </label>
					<div class="col-lg-9">
						<div class="row visible-lg">
							<div class="col-lg-4 control-label" for="AAnio">Año</div>
							<div class="col-lg-4 control-label" for="AMes">Mes</div>
							<div class="col-lg-4 control-label" for="AQuincena">Quincena</div>
						</div>
						<div class="row">
							<label class="col-lg-3 control-label hidden-lg" for="AAnio">Año: </label>
							<div class="col-lg-4">
								<select name="AAnio" id="AAnio" class="form-control">
									<option value="">[año]</option>
									<?php for($i=date('Y');$i>='2012';$i--){ ?>
										<option <?php if(nvl($AAnio)==$i) echo"selected"; ?> value="<?=$i?>"><?=$i?></option>
									<?php } ?>
								</select>
							</div>
							<label class="col-lg-3 control-label hidden-lg" for="AMes">Mes: </label>
							<div class="col-lg-4">
								<select name="AMes" id="AMes" class="form-control">
									<option value="">[mes]</option>
									<?php for($i='1';$i<='12';$i++){ ?>
										<option <?php if(nvl($AMes)==$i) echo"selected"; ?> value="<?=$i?>"><?=ver_mes($i)?></option>
									<?php } ?>
								</select>
							</div>
							<label class="col-lg-3 control-label hidden-lg" for="AQuincena"> Quincena:</label>
							<div class="col-lg-4">
								<select name="AQuincena" id="AQuincena" class="form-control">
									<option value="">[quincena]</option>
									<option <?php if(nvl($AQuincena)=='01') echo"selected"; ?> value="01">01</option>
									<option <?php if(nvl($AQuincena)=='02') echo"selected"; ?> value="02">02</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>	
		</div>	
	</div>	
	<div class="row">
		<div class="col-lg-12">
			<?php muestra_mensaje(); ?>
			<div id="loading"></div>
			<div id="result"></div>			
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h3>Subir Archivos</h3>
				</div> 
				<div class="ibox-content">
						<div action="#" class="dropzone" id="dropzoneForm">
							<div class="fallback">
								<input type="file" name="archivos[]" accept="application/pdf,application/zip" multiple />
							</div>
						</div>
						<div class="col-lg-12">
						<center>
							<a href ="<?php echo base_url('recibos/index/i'); ?>" class="btn btn-default" type="button"> <i class="fa fa-repeat"></i> Regresar</a>
							&nbsp;&nbsp;&nbsp;
							<button class="btn btn-primary save" type="submit"> <i class="fa fa-save"></i> Guardar</button>
							</center>
						</div>
					
				</div>
			</div>
		</div>	
	</div>
</form>

<!-- DROPZONE -->
<script src="<?php echo base_url('assets/inspinia/js/plugins/dropzone/dropzone.js-'); ?>"></script>

<script>
$(document).ready(function() {	

	Dropzone.options.dropzoneForm = {
		paramName: "file", // The name that will be used to transfer the file
		maxFilesize: 2, // MB
		dictDefaultMessage: "<strong>Arrastra tus archivos aqui.</strong>",
	};
	
</script>
