<table class="table table-striped table-bordered table-hover dataTables-example dataTable">
	<thead>
		<tr>
			<th>#</th>
			<th>Materia</th>
			<th>Semestre</th>
			<th>Licenciatura(s) </th>
			<th width="130px">Acción</th>
		</tr>	
	</thead>
	<tbody>
		<?php 
			$i = 1;
			foreach ($materias as $y => $mat) { 
			$contar = count($mat['lics']) +1; 
			foreach ($mat['lics'] as $p => $prof) { ?>
				<tr>
					<td class="text-left"><?= $i; ?></td> 
					<td class="text-left"><?= $mat['materia'].' '.$mat['modulo']; ?></td>
					<td class="text-left"><?= $mat['semmat']; ?></td>
					<td class="text-left"><?php echo $prof['LGradoEstudio'].' en '.$prof['Licenciatura']; ?></td>
					<td class="text-center">
						<button class="btn btn-default btn-sm openEditar" 
							data-target="#modal_Editar"
							data-uidmateria="<?php echo $mat['id_materia']; ?>"
							data-gestudio="<?php echo $prof['LGradoEstudio']; ?>"
							data-uidlicenciatura="<?php echo $prof['IdLicenciatura']; ?>"
							data-ulicenciatura="<?php echo $prof['Licenciatura']; ?>"
							data-usemmat="<?php echo $mat['semmat']; ?>"
							data-toggle="modal">
							<i class="fa fa-pencil"></i> Editar
						</button>
					</td>										
				</tr>
				<?php $i++; } ?>
			<?php  } ?>
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
