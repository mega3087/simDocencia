<table class="table table-striped table-bordered table-hover dataTables-example dataTable">
	<thead>
		<tr>
			<th>#</th>
			<th>Grado de Estudios</th>
			<th></th>
			<th>Materia</th>
			<th class="text-center">Semestre</th>
			<th width="130px">Centro Escolar </th>
			<?php if (is_permitido(null,'profesiograma','save')) { ?>
			<th class="text-center" width="130px">Acción</th>
			<th class="text-center" width="130px">Acción</th>
			<?php } ?>
		</tr>	
	</thead>
	<tbody>
		<?php
			$i = 1;
			foreach ($lics as $l => $listLics) { 
			//$contar = count($listLics['lics']) + 1; ?>
				<tr>
					<td class="text-left"><?= $i; ?></td> 
					<td class="text-left"><?php echo $listLics['LGradoEstudio'].' en '.$listLics['Licenciatura']; ?></td>
					<td class="text-left">
						<button type="button" class="btn btn-outline btn-info btn-xs openEditar" 
							data-target="#modal_Editar"
							data-uidlicenciatura="<?php echo $listLics['IdLicenciatura']; ?>"
							data-ulgradoestudios="<?php echo $listLics['LIdentificador']; ?>"
							data-ulicenciatura="<?php echo $listLics['Licenciatura']; ?>"
							data-toggle="modal">
							<i class='fa fa-pencil'></i> Editar</button>
					</td>
					<td>
					<table style="border:0px">
						<?php foreach ($listLics['materias'] as $m => $listMat) { ?>
							<tr style="border:0px"><td style="border:0px"><?= $listMat['materia']; ?></td></tr>
						<?php } ?>
					</table>
					</td>
					<td class="text-center">
						<table style="border:0px">
							<?php foreach ($listLics['materias'] as $m => $listMat) { ?>
								<tr style="border:0px"><td style="border:0px"><?= $listMat['semmat']; ?></td></tr>
							<?php } ?>
						</table>
					</td>
					<td>
						<table style="border:0px">
							<?php foreach ($listLics['materias'] as $m => $listMat) { ?>
								<tr style="border:0px"><td style="border:0px"><?php if($listMat['plan_estudio'] == '1') { echo 'Plantel'; } else { echo 'CEMSAD'; } ?></td></tr>
							<?php } ?>
						</table>
					</td>
					<?php if (is_permitido(null,'profesiograma','save')) { ?>
					<td class="text-center">
						<table style="border:0px">
						<?php foreach ($listLics['materias'] as $m => $listMat) { ?>
							<tr style="border:0px"><td style="border:0px">
							<a><span class="badge badge-danger"  onclick="quitarMateria('<?php echo $listLics['IdLicenciatura'];?>','<?php echo $listMat['id_materia'];?>')"><i class='fa fa-trash'></i> Quitar Materia</span></a>
							</td></tr>
							<?php } ?>
						</table>
					</td>
					<td class="text-left">
						<button type="button" class="btn btn-outline btn-primary btn-xs agregarMaterias"
							data-target="#modal_Agregar"
							data-uidlicenciatura="<?php echo $listLics['IdLicenciatura']; ?>"
							data-ulgradoestudios="<?php echo $listLics['LIdentificador']; ?>"
							data-ulicenciatura="<?php echo $listLics['Licenciatura']; ?>"
							data-toggle="modal">
						<i class='fa fa-plus'></i> Agregar Materias</button>
					</td>									
					<?php  } ?>
				</tr>
			<?php $i++; } ?>
	</tbody>
</table>

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
