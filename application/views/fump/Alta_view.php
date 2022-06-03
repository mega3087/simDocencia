<link href="<?php echo base_url('assets/inspinia/css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">
<!--color boox-->
<script type="text/javascript" src="<?php echo base_url("assets/colorbox/jquery.colorbox-min.js") ?>"></script>
<link media="screen" rel="stylesheet" href="<?php echo base_url("assets/colorbox/colorbox.css") ?>" />
<div class="row">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
			<h3>FUMP => ALTA NOMINA</h3>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<?php muestra_mensaje(); ?>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<div class="row">
					<div class="form-horizontal">
						<label class="col-lg-1 control-label">Periodo:</label>
						<div class="col-lg-2">
							<select name="periodo" id="periodo" class="form-control">
								<?php foreach($periodos as $key_p => $list_p){ ?>
								<option <?php if($periodo==$list_p['CPEPeriodo']) echo"selected"; ?> value="<?=$list_p['CPEPeriodo']?>"><?=substr($list_p['CPEPeriodo'],0,2)?>-<?=substr($list_p['CPEPeriodo'],3,1)==1?'A':'B'?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-lg-9">
						<?php if( is_permitido(null,'fump','alta_excel') ){ ?>
							<button name="excel" id="excel" class="btn btn-primary pull-right" >
								<i class="fa fa-file-excel-o"></i> Descargar Excel
							</button>
						<?php } ?>
						</div>
					</div>
				</div>
				<script type="text/javascript">
					$("#periodo").on("change", function(){
						periodo = $("#periodo").val();
						location.href ="<?=base_url('fump/alta')?>/"+periodo;
					});
					$("#excel").on("click", function(){
						periodo = $("#periodo").val();
						location.href ="<?=base_url('fump/alta')?>/"+periodo+"/true";
					});
				</script>
			</div> 
			<div class="ibox-content">
				
				<div class="table-responsive">
					<form action="<?=base_url('fump/validar');?>" name="form_alidar" id="form_alidar" method="POST">
					<table class="table table-striped table-bordered table-hover dataTables-example dataTable" >
						<thead>
							<tr>
								<th>Folio</th>
								<th>Clave Servidor</th>
								<th>OPEN</th>
								<th>Nombre</th>
								<th>Plantel</th>								
								<th>Vigencia</th>								
								<th>Tramite</th>
								<th>Estatus</th>
								<th width="130px">Acción</th> 
							</tr>	
						</thead>
						<tbody>
							<?php 
								foreach($fump as $key => $list){
									$FClave_skip = $this->encrypt->encode($list['FClave']);						
								?>
								<tr>
									<td class="text-left"><?php echo folio($list['FClave']); ?></td> 
									<td class="text-left"><?php echo $list['FClave_servidor']; ?></td>								
									<td class="text-left"><?php echo $list['UOpen']; ?></td>								
									<td class="text-left"><?php echo $list['FNombre']." ".$list['FApellido_pat']." ".$list['FApellido_mat']; ?></td>
									<td class="text-left"><?php echo $list['FPlantel']; ?></td>
									<td class="text-left"><?php echo fecha_format($list['FFecha_inicio']); ?>-<?php echo fecha_format($list['FFecha_termino']); ?></td>
									<td class="text-center"><?php echo $list['FTramite']; ?></td>
									<?php if( $list['FNivel_autorizacion'] == 7 ){ ?>
									<td class="text-left text-warning"><b><i class="fa fa-exclamation-triangle"></i> Nomina</b></td>
									<?php }else{ ?>
									<td class="text-left text-info"><b><i class="fa fa-check"></i> Finalizado</b></td>
									<?php } ?>
									<td>
										<?php $nivel_skip = $this->encrypt->encode('6'); ?>
										<a href="<?php echo base_url("fump/ver/$FClave_skip/null/$nivel_skip"); ?>" class="btn btn-default btn-sm"><i class="fa fa-check"></i> Revisar</a>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
					</form>
				</div>
				
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url('assets/inspinia/js/plugins/dataTables/datatables.min.js'); ?>"></script>

<script type="text/javascript">
	$(document).ready(function() {
		
		/* Page-Level Scripts */
		
		$('.dataTables-example').DataTable({
			"language": {
				"url": "<?php echo base_url('assets/datatables_es.json'); ?>"
			},
			dom: '<"html5buttons"B>lTfgitp',
			"lengthMenu": [ [20,50,100, -1], [20,50,100, "Todos"] ],
			"order": [[ 7, "desc" ]],
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