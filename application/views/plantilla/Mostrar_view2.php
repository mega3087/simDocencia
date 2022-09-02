<link href="<?php echo base_url('assets/inspinia/css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/chosen/chosen.css'); ?>" rel="stylesheet">
<!--color boox-->
<script type="text/javascript" src="<?php echo base_url("assets/colorbox/jquery.colorbox-min.js") ?>"></script>
<link media="screen" rel="stylesheet" href="<?php echo base_url("assets/colorbox/colorbox.css") ?>" />
<div class="row">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
			<h3>Generar Plantilla</h3>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<?php muestra_mensaje(); ?>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h3>&nbsp;</h3>
			</div> 
			<div class="ibox-content">				
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTables-example dataTable" >
						<thead>
							<tr>
								<th>#</th>
								<th>Plantel</th>
								<th>CCT</th>
								<th>Acción</th>
								<th width="130px">Plantilla</th> 
							</tr>	
						</thead>
						<tbody>
							<?php 
							$i = 1;
							foreach ($planteles as $key => $list) {
								$PClave_skip = $this->encrypt->encode($list['CPLClave']);	
                                $urlCrear = base_url("GenerarPlantilla/crear/".$this->encrypt->encode($list['CPLClave'])."");
							?>
								<tr>
								<td class="text-left"><?php echo $i; ?></td>
									<td class="text-left"><?php echo $list['CPLNombre']; ?></td>
									<td class="text-left"><?php echo $list['CPLCCT']; ?></td>
									<td class="text-left"><a href='<?=$urlCrear?>' target='_blank'>Crear Plantilla</a></td>							
									<td>
										<?php if( is_permitido(null,'GenerarPlantilla','verPlantilla') ){ ?>
											<a href="<?php echo base_url("GenerarPlantilla/ver/$PClave_skip"); ?>" class="btn btn-default btn-sm eye"><i class="fa fa-times"></i> Ver Plantilla</a>
										<?php } ?>
									</td>
								</tr>
							<?php $i ++; } ?>
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
					$(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
				}
			}
			]
		});	

	});
</script>