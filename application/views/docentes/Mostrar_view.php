<link href="<?php echo base_url('assets/inspinia/css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/chosen/chosen.css'); ?>" rel="stylesheet">
<!--color boox-->
<script type="text/javascript" src="<?php echo base_url("assets/colorbox/jquery.colorbox-min.js") ?>"></script>
<link media="screen" rel="stylesheet" href="<?php echo base_url("assets/colorbox/colorbox.css") ?>" />
<div class="row">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
			<h3>Docentes</h3>
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
								<th>Correo</th>
								<th width="130px">Acción</th> 
							</tr>	
						</thead>
						<tbody>
							<?php 
							foreach ($planteles as $key => $list) {
								$CPLClave_skip = $this->encrypt->encode($list['CPLClave']);
								$base = $this->encrypt->encode('1');
								$idoneo = $this->encrypt->encode('2');
								$externo = $this->encrypt->encode('3');
							?>
								<tr>
									<td class="text-left"><?php echo $list['CPLClave']; ?></td> 
									<td class="text-left"><?php echo $list['CPLNombre']; ?></td>
									<td class="text-left"><?php echo $list['CPLCCT']; ?></td>
									<td class="text-left"><?php echo $list['CPLCorreo_electronico']; ?></td>
									<td>
									<a href="<?= base_url()?>Docente/ver_planteles/<?=$CPLClave_skip?>/<?= $base?>">
										<button class="btn btn-default btn-sm"><i class="fa fa-eye"></i> Ver Docentes Base</button>
									</a>
									<a href="<?= base_url()?>Docente/ver_planteles/<?=$CPLClave_skip?>/<?= $idoneo?>">
										<button class="btn btn-default btn-sm"><i class="fa fa-eye"></i> Ver Docentes Idoneos</button>
									</a>
									<a href="<?= base_url()?>Docente/ver_planteles/<?=$CPLClave_skip?>/<?= $externo?>">
										<button class="btn btn-default btn-sm"><i class="fa fa-eye"></i> Ver Docentes Externos</button>
									</a>
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
					$(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
				}
			}
			]
		});	

	});
</script>