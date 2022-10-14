<div class="table-responsive">
	<table class="table table-striped table-bordered ">
		<thead>
			<tr>
				<th>Tipo Nombramiento</th>
				<th>Fecha Ingreso</th>
				<th>Plaza</th>
				<th>Tipo Materias</th>
				<th>No. de Horas</th>
				<?php //if(nvl($data[0]['UDTipo_Nombramiento']) == '4') { ?>
				<!--<th>No. de Oficio</th>
				<th>Documentos</th>-->
				<?php //} ?>
				<?php if( is_permitido(null,'generarplantilla','save') && (nvl($data[0]['UDValidado']) == '' || nvl($data[0]['UDValidado']) == '1' ) || nvl($data[0]['UDValidado']) == '2') { ?>
				<th>Acción</th>
				<?php } ?>
			</tr>
		</thead>
		<tbody>
		<?php
		if ($contar != '0') { 
			foreach($data as $key => $list) { 
			if($UDNombramiento_file = nvl($list['UDNombramiento_file'])) {
				$UDNombramiento_file="<a href='".base_url($UDNombramiento_file)."' target='_blanck'><button type='button' class='btn btn-sm btn-success' ><i class='fa fa-file-archive-o'></i> Ver Nombramiento</button></a>";
			}
			$borrar = "<button type='button' value=".$this->encrypt->encode(nvl($list['UDClave']))." class='btn btn-sm btn-danger quitarPlaza' title='Borrar' ><i class='fa fa-trash'></i></button>";?>
			<tr>
				<td>
					<input type="hidden" name="tipoNombramiento" id="tipoNombramiento" value="<?php echo nvl($list['UDTipo_Nombramiento']); ?>">
					<?php echo nvl($list['TPNombre']); ?>
				</td>
				<td>
					<?php if( nvl($list['UDFecha_ingreso']) != '0000-00-00') { 
						echo fecha_format(nvl($list['UDFecha_ingreso']));
					} else {
						echo fecha_format(nvl($list['UDFecha_inicio'])).' al '.fecha_format(nvl($list['UDFecha_final']));
					}
					?>
				</td>
				<td><?php echo nvl($list['nomplaza']); ?></td>
				<td><?php echo nvl($list['UDTipo_materia']); ?></td>
				<td>
					<?php $total = '0';
					$total = nvl($list['UDHoras_grupo']) + nvl($list['UDHoras_apoyo']) + nvl($list['UDHoras_CB']) + nvl($list['UDHoras_provicionales']);
					echo $total;
					?>
				</td>
				<?php //if(nvl($list['UDTipo_Nombramiento']) == '4') { ?>
				<!--<td><?php echo nvl($list['UDNumOficio']); ?></td>
				<td><?php echo nvl($UDNombramiento_file);?></td>-->
				<?php // } else { ?>
					<!--<td></td>
					<td></td>-->
				<?php // } ?>
				<?php if( is_permitido(null,'generarplantilla','save') && (nvl($data[0]['UDValidado']) == '' || nvl($data[0]['UDValidado']) == '1' ) || nvl($data[0]['UDValidado']) == '2') { ?>
				<td>
                    <?php echo nvl($borrar); ?>
				</td>
				<?php } ?>
			</tr>
		<?php } 
		} else { ?>
		<input type="hidden" name="tipoNombramiento" id="tipoNombramiento" value="">
		<tr><td class="text-center" colspan="6">Sin Datos</td></tr>
		<?php } ?>
		</tbody>
	</table>
</div>

<script src="<?php echo base_url('assets/inspinia/js/plugins/bootbox.all.min.js'); ?>"></script>
<script type="text/javascript">
	$(".quitarPlaza").click(function(e) {
		UDClave = $(this).val();
		var idUsuario = document.getElementById("UNCI_usuario").value;
		var idPlantel = document.getElementById("UPlantel").value;

		bootbox.confirm({
		    message: "¿Desea eliminar la Plaza del Docente?",
		    size: 'small',
		    buttons: {
		        confirm: {
		            label: 'Si',
		            className: 'btn-primary'
		        },
		        cancel: {
		            label: 'No',
		            className: 'btn-danger'
		        }
		    },
		    callback: function (result) {
		    	if (result == true) {
		    		$.ajax({
						type: "POST",
						url: "<?php echo base_url("Docente/deletePlazas"); ?>",
						data: {UDClave: UDClave, idUsuario : idUsuario, idPlantel : idPlantel},
						dataType: "html",
						beforeSend: function(){
							//carga spinner
							$(".loadingPlazas").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
						},
						success: function(data){
							$(".msgPlazas").empty();
							$(".resultPlazas").empty();
							$(".resultPlazas").append(data);
							$(".loadingPlazas").empty();
						}
						
					});
		    	}
		    }
		});
	});
</script>