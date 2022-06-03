<link href="<?php echo base_url('assets/inspinia/css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/chosen/chosen.css'); ?>" rel="stylesheet">
<!--color boox-->
<script type="text/javascript" src="<?php echo base_url("assets/colorbox/jquery.colorbox-min.js") ?>"></script>
<link media="screen" rel="stylesheet" href="<?php echo base_url("assets/colorbox/colorbox.css") ?>" />
<div class="row">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
			<h3>Recibos</h3>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox-content">
			<form action="<?php echo base_url("recibos/index"); ?>" method="post" enctype="multipart/form-data" class="form-horizontal panel-body"> 
				<div class="form-group ">
					<label class="col-lg-3 control-label visible-lg" for="AAnio"><br />Buscar: </label>
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
				<div class="form-group">
					<label class="col-lg-3 control-label" for="ANombre"> Clave Servidor:</label>
					<div class="col-lg-3">
						<?php if( is_permitido(null,'recibos','save') ){ ?>
						<input type="text" name="ANombre" id="ANombre" class="form-control" value='<?=nvl($ANombre)?>' />
						<?php }else{ ?>
						<input type="text" name="ANombres" id="ANombres" class="form-control disabled" value='<?=nvl($ANombre)?>' />
						<?php } ?>
					</div>
					<div class="col-lg-offset-3 col-lg-3">
						<button class="btn btn-primary pull-right" type="submit"> <i class="fa fa-search"></i> Buscar</button>
					</div>
				</div>
			</form>
		</div>	
	</div>	
</div>	
<div class="row">
	<div class="col-lg-12">
		<?php muestra_mensaje(); ?>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<div class="pull-right">
				<?php if( is_permitido(null,'recibos','save') ){ ?>
					<a href='<?php echo base_url('recibos/agregar'); ?>' class="btn btn-primary">
						<i class="fa fa-file-text"></i> Agregar Recibos
					</a>
				<?php } ?>
				</div>
				<h3>&nbsp;</h3>
			</div> 
			<div class="ibox-content">
				
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTables-example dataTable" >
						<thead>
							<tr>
								<th>#</th>
								<th>Nombre</th>
								<th>Año</th>
								<th>Mes</th>
								<th>Quincena</th>
								<th>No. Descargas</th>
								<th>Estatus</th>
								<th width="130px">Acción</th> 
							</tr>	
						</thead>
						<tbody>
							<?php 
								foreach($archivos as $key => $list){
									$AClave_skip = $this->encrypt->encode($list['AClave']);						
								?>
								<tr>
									<td class="text-left"><?php echo $key+1; ?></td> 
									<td class="text-left">
										<a href='<?php echo base_url("recibos/download/$AClave_skip"); ?>' target='_blank'>
											<?php echo $list['ANombre']; ?>
										</a>
									</td>
									<td class="text-left"><?php echo $list['AAnio']; ?></td>
									<td class="text-left"><?php echo ver_mes($list['AMes']); ?></td>
									<td class="text-left"><?php echo $list['AQuincena']; ?></td>	
									<td class="text-left"><?php echo $list['ADownload']; ?></td>	
									<td class="text-left text-center">
										<?php if($list['ANotificacion']){ ?>
										<span class='text-info' title='Visto'><i class="fa fa-eye fa-2x"></i></span>
										<?php }else{ ?>
										<span class='text-danger' title='No Visto'><i class="fa fa-eye-slash  fa-2x"></i></span>
										<?php } ?>
									</td>									
									<td>
										<?php if( is_permitido(null,'recibos','delete') ){ ?>
											<a href="<?php echo base_url("recibos/delete/$AClave_skip"); ?>" class="btn btn-default btn-sm delete"><i class="fa fa-times"></i> Borrar</a>
										<?php } ?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url('assets/inspinia/js/plugins/dataTables/datatables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/inspinia/js/plugins/chosen/chosen.jquery.js'); ?>"></script>

<script type="text/javascript">
	$(document).ready(function() {
		
		/* Page-Level Scripts */
		
		$('.dataTables-example').DataTable({
			"language": {
				"url": "<?php echo base_url("assets/datatables_es.json"); ?>"
			},
			dom: '<"html5buttons"B>lTfgitp',
			"lengthMenu": [ [20,50,100, -1], [20,50,100, "Todos"] ],
			buttons: [
			{extend: 'copy'},
			{extend: 'csv'},
			{extend: 'pdf'},
			{extend: 'print',
				customize: function (win){
					$(win.document.body).addClass('white-bg');
					$(win.document.body).css('font-size', '10px');
					$(win.document.body).find('table')
					.addClass('compact')
					.css('font-size', 'inherit');
				}
			}
			]
		});		
		
	});
</script>