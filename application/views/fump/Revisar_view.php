<link href="<?php echo base_url('assets/inspinia/css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">
<div class="row">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
			<h3>FUMP => REVISIÓN FUMP</h3>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<?php muestra_mensaje(); ?>
		<div class="form-horizontal">
				<div class="form-group">
					<label class="col-lg-1 control-label">Plantel:</label>
					<div class="col-lg-2">
						<select name="plantel" id="plantel" class="form-control <?php if(!$nivel)echo"disabled"; ?>">
							<?php if( $nivel>=2 ){ ?>
							<option <?php if($filtro=="0") echo"selected"; ?> value="0">TODOS</option>
							<?php } ?>
							<?php foreach($planteles as $key => $list){ ?>
							<option value="<?=$this->encrypt->encode($list['CPLClave'])?>" <?php if($list['CPLClave']==$CPLClave) echo"selected"; ?> ><?=$list['CPLNombre']?></option>
							<?php } ?>
						</select>
					</div>
					<label class="col-lg-1 control-label">Estatus:</label>
					<div class="col-lg-2">
						<select name="filtro" id="filtro" class="form-control">
							<option <?php if($filtro=="Pendientes") echo"selected"; ?> value="0">Pendientes</option>
							<option <?php if($filtro=="Autorizados") echo"selected"; ?> value="Autorizados">Autorizados</option>
							<option <?php if($filtro=="Rechazados") echo"selected"; ?> value="Rechazados">Rechazados</option>
							<option <?php if($filtro=="Todos") echo"selected"; ?> value="Todos">Todos</option>
						</select>
					</div>
					<label class="col-lg-1 control-label">Periodo:</label>
					<div class="col-lg-2">
						<select name="periodo" id="periodo" class="form-control">
							<?php foreach($periodos as $key_p => $list_p){ ?>
							<option <?php if($periodo==$list_p['CPEPeriodo']) echo"selected"; ?> value="<?=$list_p['CPEPeriodo']?>"><?=substr($list_p['CPEPeriodo'],0,2)?>-<?=substr($list_p['CPEPeriodo'],3,1)==1?'A':'B'?></option>
							<?php } ?>
						</select>
					</div>
					<label class="col-lg-1 control-label">Tramite:</label>
					<div class="col-lg-2">
						<select name="tramite" id="tramite" class="form-control">
							<option <?php if($tramite=="ALTA") echo"selected"; ?> value="ALTA">ALTA</option>
							<option <?php if($tramite=="BAJA") echo"selected"; ?> value="BAJA">BAJA</option>
							<option <?php if($tramite=="INTERINATO") echo"selected"; ?> value="INTERINATO">INTERINATO</option>
							<option <?php if($tramite=="LICENCIA") echo"selected"; ?> value="LICENCIA">LICENCIA SIN GOCE DE SUELDO</option>
							<option <?php if($tramite=="PLAZA") echo"selected"; ?> value="PLAZA">CAMBIO DE PLAZA</option>
							<option <?php if($tramite=="INCREMENTO") echo"selected"; ?> value="INCREMENTO">INCREMENTO/DISMINUCIÓN DE HRS. CLASE</option>
							<option <?php if($tramite=="ADSCRIPCION") echo"selected"; ?> value="ADSCRIPCION">CAMBIO DE ADSCRIPCIÓN</option>
							<option <?php if($tramite=="OTRO") echo"selected"; ?> value="OTRO">OTRO</option>
							<option <?php if($tramite=="") echo"selected"; ?> value="">TODOS</option>
						</select>
					</div>
				</div>
			<script type="text/javascript">
				$("#filtro, #plantel, #periodo, #tramite").on("change", function(){
					filtro = $("#filtro").val();
					plantel = $("#plantel").val();
					periodo = $("#periodo").val();
					tramite = $("#tramite").val();
					location.href ="<?=base_url('fump/revisar')?>/"+filtro+"/"+plantel+"/"+periodo+"/"+tramite;
				});
			</script>
			</form>
		</div>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<div class="pull-right"></div>
				<h3>&nbsp;</h3>
			</div> 
			<div class="ibox-content">
				
				<div class="table-responsive">
					<form action="<?=base_url('fump/validar')?>" name="form_alidar" id="form_alidar" method="POST">
					<table class="table table-striped table-bordered table-hover dataTables-example dataTable" >
						<thead>
							<tr>
								<th>Folio</th>
								<th>Clave Servidor</th>
								<th>Nombre</th>								
								<th>Plantel </th>								
								<th>Vigencia</th>								
								<th>Tramite</th>
								<?php if(is_permitido(null,"fump","revizar_plaza")){ ?><th>Plaza</th><?php } ?>
								<th>Estatus</th>
								<th width="130px">Acción</th> 
							</tr>	
						</thead>
						<tbody>
							<?php 
								$nivel_skip = $this->encrypt->encode($nivel);
								foreach($fump as $key => $list){
									$FClave_skip = $this->encrypt->encode($list['FClave']);						
								?>
								<tr>
									<td class="text-left"><?php echo folio($list['FClave']); ?></td> 
									<td class="text-left"><?php echo $list['FClave_servidor']; ?></td>								
									<td class="text-left"><?php echo $list['FNombre']." ".$list['FApellido_pat']." ".$list['FApellido_mat']; ?></td>
									<td class="text-left"><?php echo $list['FPlantel']; ?></td>
									<td class="text-left"><?php echo fecha_format($list['FFecha_inicio']); ?>-<?php echo fecha_format($list['FFecha_termino']); ?></td>
									<td class="text-center"><?php echo $list['FTramite']; ?></td>
									<?php if(is_permitido(null,"fump","revizar_plaza")){ ?><td class="text-left"><?php echo $list['FNombre_plaza']; ?></td><?php } ?>
									<td class="<?php if($list['FNivel_autorizacion']<$nivel) echo"text-danger"; elseif($list['FNivel_autorizacion']==$nivel)echo"text-warning";else echo"text-success"; ?>">
									<?php 
									if($list['FNivel_autorizacion'] >= 1 and $list['FNivel_autorizacion'] != 6 and $list['FNivel_autorizacion'] != 7 and !$nivel and $list['acceptTerms']=='on')
										echo '<b class="text-success"><i class="fa fa-clock-o"></i> Validando..</b>';
									elseif($list['FNivel_autorizacion'] == 8)
										echo '<b class="text-info"><i class="fa fa-check"></i> Finalizado</b>';
									elseif($list['FNivel_autorizacion'] == 7)
										echo '<b class="text-info"><i class="fa fa-check"></i> Alta Nomina</b>';
									elseif($list['FNivel_autorizacion'] == 6)
										echo '<b class="text-warning"><i class="fa fa-clock-o"></i> Pendiente Documentar</b>';
									elseif($list['FNivel_autorizacion'] == 5)
										echo 'Pendiente Autorizar <br /> <b>Dir. Gen</b>';
									elseif($list['FNivel_autorizacion'] == 4)
										echo 'Pendiente Autorizar <br /> <b>Dir. Adm. Finz.</b>';
									elseif($list['FNivel_autorizacion'] == 3)
										echo 'Pendiente Autorizar <br /> <b>R.H</b>';
										elseif($list['FNivel_autorizacion'] == 2)
										echo 'Pendiente Autorizar <br /> <b>COORD.</b>';
									elseif($list['FNivel_autorizacion'] == 1 and $list['acceptTerms'])
										echo 'Pendiente Autorizar <br /> <b>Enlace</b>';
									else{
										echo'<b class="text-danger"><i class="fa fa-times"></i> Rechazados</b>';
									}
									?>
									</td>
									<td>
										<a href="<?php echo base_url("fump/ver/$FClave_skip/null/$nivel_skip"); ?>"  class="btn btn-default btn-sm"><i class="fa fa-check"></i> Revisar</a>
										<?php if($nivel and $list['FNivel_autorizacion']>=1 and $list['FNivel_autorizacion']<=5 and $list['acceptTerms'] and is_permitido(null,"fump","nivel_".$list['FNivel_autorizacion']) ){ ?>
										<input type="checkbox" name="<?=$list['FClave']?>" value="<?=$list['FNivel_autorizacion']?>" />
										<?php } ?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
						<tfoot>
							<?php if($nivel){ ?>
							<tr><td colspan="8"> <button class="btn btn-primary btn-sm pull-right" onclick="this.style.display = 'none';"><i class="fa fa-check"></i> Aprobar seleccionados</button></td></tr>
							<?php } ?>
						</tfoot>
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
			"language": { search: 'Buscar en los resultados:'},
			"order": [[ 6, "desc" ]],
			"paging": false,
			"info": false,
		});		
		
	});
</script>