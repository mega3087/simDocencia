<div class="table-responsive">
	<table class="table table-striped table-bordered ">
		<thead>
			<tr>
				<th>Tipo Nombramiento</th>
				<th>Fecha Ingreso</th>
				<th>Plaza / No Horas</th>
				<th>Tipo Materias</th>
				<?php //if( is_permitido(null,'generarplantilla','save') && (nvl($data[0]['UDValidado']) == '' || nvl($data[0]['UDValidado']) == '1' ) || nvl($data[0]['UDValidado']) == '2' || nvl($data[0]['UDPermanente']) == 'N') { ?>
				<?php if( is_permitido(null,'generarplantilla','save')) { ?>
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
				<td>
					<?php 
					$total = '0';
					$total = nvl($list['UDHoras_grupo']) + nvl($list['UDHoras_apoyo']) + nvl($list['UDHoras_provicionales']);
					if ($list['idPlaza'] == '11' || $list['idPlaza'] == '12' || $list['idPlaza'] == '13' || $list['idPlaza'] == '14' || $list['idPlaza'] == '15') {
						if (empty($list['UDHoras_CB'])) {
							$horas = $list['UDHoras_grupo'];
						} else {
							$horas = $list['UDHoras_CB'];
						}
						echo nvl($list['nomplaza'])."(".$horas. "horas)";
					} else {
						echo nvl($list['nomplaza'])."(".$total." horas)";
						if (nvl($list['UDHoras_CB'])) 
						echo " y ".nvl($list['UDHoras_CB'])." horas/semana/mes como CB-I";
					} ?>
				</td>
				<td><?php echo nvl($list['UDTipo_materia']); ?></td>
				<?php //if( nvl($data[0]['UDPermanente']) == 'N' && is_permitido(null,'generarplantilla','save')) { 
					if( is_permitido(null,'generarplantilla','save')) { ?>
				<td>
				<button type="button" class="btn btn-warning btn-sm" onclick="editarPlaza('<?= $list['UDTipo_Nombramiento'] ?>', '<?= $list['UDPlaza'] ?>','<?= $list['UDFecha_ingreso'] ?>','<?= $list['UDFecha_inicio'] ?>','<?= $list['UDFecha_final'] ?>','<?= $list['UDObservaciones'] ?>','<?= $list['UDNombramiento_file'] ?>','<?= $list['UDHoras_grupo'] ?>','<?= $list['UDHoras_apoyo'] ?>','<?= $list['UDHoras_CB'] ?>','<?= $list['UDTipo_materia'] ?>','<?= $list['UDClave']?>')"><i class="fa fa-pencil"></i> Editar </button>
                    <?php // echo nvl($borrar); ?>
				</td>
				<?php } ?>
			</tr>
		<?php } 
		} else { ?>
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


	function editarPlaza(UDTipo_Nombramiento, UDPlaza, UDFecha_ingreso, UDFecha_inicio, UDFecha_final, UDObservaciones, UDNombramiento_file, UDHoras_grupo, UDHoras_apoyo, UDHoras_CB, UDTipo_materia, UDClave){
		document.getElementById("UDTipo_Nombramiento").value = UDTipo_Nombramiento;
		document.getElementById("UDPlaza").value = UDPlaza;
		document.getElementById("UDFecha_ingreso").value = UDFecha_ingreso;
		document.getElementById("UDFecha_inicio").value = UDFecha_inicio;
		document.getElementById("UDFecha_final").value = UDFecha_final;
		document.getElementById("UDObservaciones").value = UDObservaciones;
		document.getElementById("UDNombramiento_file").value = UDNombramiento_file;
		document.getElementById("UDHorasGrupo").value = UDHoras_grupo;
		document.getElementById("UDHorasApoyo").value = UDHoras_apoyo;
		document.getElementById("UDHoras_CB").value = UDHoras_CB;
		document.getElementById("UDTipo_materia").value = UDTipo_materia;
		document.getElementById("UDClave").value = UDClave;

		if (UDTipo_Nombramiento == 3) {
            $('.mostrarFechaIng').hide();
            $('.mostrarFechaIng2014').hide();            
            $('.mostrarOficio').show();
            $('.mostrarFechaInicio').show();
            $('.mostrarFechaFinal').show();
            $('.mostrarDocNom').show();
            
        } else if (UDTipo_Nombramiento == 4) {
            $('.mostrarFechaIng').hide();
            $('.mostrarFechaIng2014').hide();
            $('.mostrarOficio').show();
            $('.mostrarFechaInicio').show();
            $('.mostrarFechaFinal').show();
            $('.mostrarDocNom').show();
            
        } else if (UDTipo_Nombramiento == 5) {
            $('.mostrarFechaIng').hide();
            $('.mostrarFechaIng2014').hide();
            $('.mostrarOficio').show();
            $('.mostrarFechaInicio').show();
            $('.mostrarFechaFinal').show();
            $('.mostrarDocNom').show();
            
        } else if (UDTipo_Nombramiento == 6) {
            $('.mostrarFechaIng').hide();
            $('.mostrarFechaIng2014').hide();
            $('.mostrarOficio').show();
            $('.mostrarFechaInicio').show();
            $('.mostrarFechaFinal').show();
            $('.mostrarDocNom').show();
            
        } else if (UDTipo_Nombramiento == 7) {
            $('.mostrarFechaIng').hide();
            $('.mostrarFechaIng2014').show();
            $('.mostrarOficio').show();
            $('.mostrarFechaInicio').hide();
            $('.mostrarFechaFinal').hide();
            $('.mostrarDocNom').show();
            
        } else if (UDTipo_Nombramiento == 8) {
            $('.mostrarFechaIng').hide();
            $('.mostrarFechaIng2014').hide();
            $('.mostrarOficio').show();
            $('.mostrarFechaInicio').show();
            $('.mostrarFechaFinal').hide();
            $('.mostrarDocNom').show();
            
        } else {
            $('.mostrarFechaIng').show();
            $('.mostrarFechaIng2014').hide();
            $('.mostrarOficio').hide();
            $('.mostrarFechaInicio').hide();
            $('.mostrarFechaFinal').hide();
            $('.mostrarDocNom').hide();
            
        }
		if(UDHorasGrupo != ''){
			$(".UDHorasGrupo").addClass("disabled").attr("disabled", true);
			$("#UDHoras_CB").val('0');
		} else {
			$(".UDHorasGrupo").removeClass("disabled").attr("disabled", false);
			$("#UDHorasGrupo").val('0');
		}

		if(UDHorasApoyo != ''){
			$(".UDHorasApoyo").addClass("disabled").attr("disabled", true);
			$("#UDHoras_CB").val('0');
		} else {
			$(".UDHorasApoyo").removeClass("disabled").attr("disabled", true);
			$("#UDHorasApoyo").val('0');
		}
		if (idPlaza == '11' || idPlaza == '12' || idPlaza == '13' || idPlaza == '14' || idPlaza == '15') {
			$(".UDHorasGrupo").removeClass("disabled").attr("disabled", false);
			$("#UDHorasGrupo").val('0');
			$(".UDHorasApoyo").addClass("disabled").attr("disabled", true);
			$("#UDHorasApoyo").val('0');
			$(".UDHoras_CB").removeClass("disabled").attr("disabled", false);
			$("#UDHoras_CB").val('0');

			$("#UDHorasGrupo").change(function(){
				if($(this).val() != ''){
					$(".UDHoras_CB").addClass("disabled").attr("disabled", true);
				}
				if ($(this).val() == 0) {
					$(".UDHoras_CB").removeClass("disabled").attr("disabled", false);
				}
			});

			$("#UDHoras_CB").change(function(){
				if($(this).val() != ''){
					$(".UDHorasGrupo").addClass("disabled").attr("disabled", true);
				}
				if($(this).val() == 0){
					$(".UDHorasGrupo").removeClass("disabled").attr("disabled", false);
				}
			});
		} 
	}
</script>