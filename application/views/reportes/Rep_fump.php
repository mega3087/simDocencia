<link href="<?php echo base_url('assets/inspinia/css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">
<!--color boox-->
<script type="text/javascript" src="<?php echo base_url("assets/colorbox/jquery.colorbox-min.js") ?>"></script>
<link media="screen" rel="stylesheet" href="<?php echo base_url("assets/colorbox/colorbox.css") ?>" />
<div class="row">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
			<h3><?=$titulo?> / PERIODO 
			<select name="periodo" id="periodo">
				<?php foreach($periodos as $key_p => $list_p){ ?>
				<option <?php if($periodo==$list_p['CPEPeriodo']) echo"selected"; ?> value="<?=$list_p['CPEPeriodo']?>"><?=substr($list_p['CPEPeriodo'],0,2)?>-<?=substr($list_p['CPEPeriodo'],3,1)==1?'A':'B'?></option>
				<?php } ?>
			</select>
			</h3>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<?php muestra_mensaje(); ?>
		<div class="row">
			<div class="col-lg-6">
				<div class="ibox-content text-center">
					<div class="row">
						<div class="col-lg-6">
							<div class="widget style1">
								<div class="row">
									<div class="col-4 text-center">
										<i class="fa fa-bell-o fa-5x"></i>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="widget gray-bg no-padding">
								<div class="p-m">
									<h1 class="m-xs"><?=$fump_graf['Recibidos']?></h1>
									<h3 class="font-bold no-margins">
										Recibidos
									</h3>
									<small>Total de FUMP.</small>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-3">
							<div class="widget yellow-bg p-lg text-center">
								<div class="m-b-md">
									<i class="fa fa-clock-o fa-4x"></i>
									<h1 class="m-xs"><?=$fump_graf['Espera']?></h1>
									<h3 class="font-bold no-margins">
										Espera
									</h3>
								</div>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="widget success-bg p-lg text-center">
								<div class="m-b-md">
									<i class="fa fa-cogs fa-4x"></i>
									<h1 class="m-xs"><?=$fump_graf['Proceso']?></h1>
									<h3 class="font-bold no-margins">
										Proceso
									</h3>
								</div>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="widget navy-bg p-lg text-center">
								<div class="m-b-md">
									<i class="fa fa-thumbs-o-up fa-4x"></i>
									<h1 class="m-xs"><?=$fump_graf['Atendidos']?></h1>
									<h3 class="font-bold no-margins">
										Atendidos
									</h3>
								</div>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="widget red-bg p-lg text-center">
								<div class="m-b-md">
									<i class="fa fa-thumbs-o-down fa-4x"></i>
									<h1 class="m-xs"><?=$fump_graf['Rechazados']?></h1>
									<h3 class="font-bold no-margins">
										Rechazados
									</h3>
								</div>
							</div>
						</div>
					</div>
				</div>			
			</div>			
			<div class="col-lg-6">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Porcentajes en relación a los FUMP</h5>
					</div>
					<div class="ibox-content">
						<div>
							<div id="pie"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<div class="pull-right">
					&nbsp;
				</div>
				<h3>&nbsp;</h3>
			</div>
			<div class="ibox-content">
				
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTables-example dataTable" >
						<thead>
							<tr>
								<th>Folio</th>
								<th>Plantel</th>
								<th>Nombre</th>							
								<th>Plaza</th>								
								<th>Vigencia</th>								
								<th>Tramite</th>								
								<th>Estatus</th>
							</tr>	
						</thead>
						<tbody>
							<?php 
							foreach($fump as $key => $list){
								$FClave_skip = $this->encrypt->encode($list['FClave']);						
							?>
							<tr>
								<th class="text-center"><?=folio($list['FClave'])?></th>
								<td><?=$list['FPlantel']?></td>
								<td><?=$list['FNombre']." ".$list['FApellido_pat']." ".$list['FApellido_mat']?></td>
								<td><?=$list['FNombre_plaza']?></td>
								<td><?php echo fecha_format($list['FFecha_inicio']); ?>-<?php echo fecha_format($list['FFecha_termino']); ?></td>
								<td class="text-center"><?=$list['FTramite']?></td>
								<td style="color:gray;">
									<?php 
										if($list['acceptTerms'] and $list['FNivel_autorizacion'] == 1 )
											$nivel = 1;
										elseif($list['acceptTerms'] and $list['FNivel_autorizacion'] == 2 )
											$nivel = 2;
										elseif($list['acceptTerms'] and $list['FNivel_autorizacion'] == 3 )
											$nivel = 3;
										elseif($list['acceptTerms'] and $list['FNivel_autorizacion'] == 4 )
											$nivel = 4;
										elseif($list['acceptTerms'] and $list['FNivel_autorizacion'] == 5 )
											$nivel = 5;
										elseif($list['acceptTerms'] and $list['FNivel_autorizacion'] == 6 )
											$nivel = 6;
										elseif($list['acceptTerms'] and $list['FNivel_autorizacion'] == 7)
											$nivel = 7;
										elseif(!$list['acceptTerms'] and ($list['FNivel_autorizacion'] == 0 or $list['FNivel_autorizacion'] == 1) )
											$nivel = 9;
										else 
											$nivel = 0;
									?>
									<i class="fa fa-circle <?php if($nivel==1) echo'text-warning'; ?>"></i> Enlace <br />
									<i class="fa fa-circle <?php if($nivel==2) echo'text-success'; ?>"></i> R.H <br />
									<i class="fa fa-circle <?php if($nivel==3) echo'text-success'; ?>"></i> Admin. Finzanzas <br />
									<i class="fa fa-circle <?php if($nivel==4) echo'text-success'; ?>"></i> Dir. General <br />
									<i class="fa fa-circle <?php if($nivel==5) echo'text-success'; elseif($nivel==9) echo'text-danger'; ?>"></i> Plantel <br />
									<i class="fa fa-circle <?php if($nivel==6) echo'text-success'; elseif($nivel==7) echo'text-navy';  ?>"></i> Nomina <br />
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
<!-- d3 and c3 charts -->
<script src="<?php echo base_url('assets/inspinia/js/plugins/d3/d3.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/inspinia/js/plugins/c3/c3.min.js'); ?>"></script>
<style type="text/css">
.success-bg {
    background-color: #1c84c6;
    color: #fff;
}
</style>
<script type="text/javascript">
	$("#periodo").on("change", function(){
		periodo = $("#periodo").val();
		location.href ="<?=base_url('reportes/rep_fump')?>/"+periodo;
	});

	$(document).ready(function() {
		
		/* Page-Level Scripts */
		
		$('.dataTables-example').DataTable({
			"language": {
				"url": "<?php echo base_url("assets/datatables_es.json"); ?>"
			},
			"order": [[ 0, "desc" ]],
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
		
		c3.generate({
			bindto: '#pie',
			data:{
				columns: [
					['Espera', <?=$fump_graf['Espera']?>],
					['Proceso', <?=$fump_graf['Proceso']?>],
					['Atendidos', <?=$fump_graf['Atendidos']?>],
					['Rechazados', <?=$fump_graf['Rechazados']?>]
				],
				colors:{
					Espera: '#f7a54a',
					Proceso: '#1c84c6',
					Atendidos: '#18a689',
					Rechazados: '#ed5565'
				},
				type : 'pie'
			}
		});
		
	});
</script>