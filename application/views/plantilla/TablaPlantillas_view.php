<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" >
		<tr>
			<th>No.</th>
			<th>Semestre</th>
			<th>Fechas Periodo</th>
			<th>h/s/m</th>
			<th>Estatus</th>
			<th>Ver</th>
		</tr>
		<?php 
		$hrsTotalAsig = 0 ;
		foreach ($plantillas as $key => $list){ 
		$periodo = str_replace("-1"," (Febrero-Agosto)",$list['PPeriodo']);
		$periodo = str_replace("-2"," (Agosto-Febrero)",$periodo);
		
		$select = "SUM(ptotalHoras)as horasTotales";
		$where = "idPlantilla = '".$list['PClave']."' AND PActivo = '1'";
		$horasAsignadas = $this->generarplantilla_model->find($where,$select);
		$horasAsignadas = $horasAsignadas['horasTotales'];
		$hrsTotalAsig+= $horasAsignadas;
		
		$horasTotales_d = $horasTotales>0?$horasTotales:1;
		?>
		<tr>
			<td><?php echo($key+1); ?></td>
			<td>20<?php echo $periodo; ?></td>
			<td><?php echo fecha_format($list['PFechaInicial'])." - ".fecha_format($list['PFechaFinal']); ?></td>
			<td><?php echo $horasAsignadas; ?> (<?php echo number_format($horasAsignadas/$horasTotales_d*100,1); ?>%)</td>
			<td><?php echo $list['PEstatus']; ?></td>
			<td>
				<button onclick="verPlantilla(<?php echo$list['PClave']; ?>)" class="btn btn-success btn-xs" ><i class="fa fa-eye"></i> <?php if($list['PEstatus'] == 'Pendiente') { echo "Revisar"; } else {
					echo "Ver";} ?></button>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<th colspan="3" style="text-align:right !important;">Total h/s/m:</th>
			<th><?php echo $hrsTotalAsig; ?> de <?php echo $horasTotales; ?></th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</table>
</div>