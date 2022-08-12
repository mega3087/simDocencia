<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover dataTables-example dataTable">
		<thead>
			<tr>
				<th>Tipo Docente</th>
				<th>Fecha Ingreso</th>
				<th>Plaza</th>
				<th>Tipo Materias</th>
				<th>No. de Oficio</th>
				<th>Documentos</th>
				<th>Acción</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($data as $key => $list) { 
			if($UDPlaza_file = $list['UDPlaza_file']) {
				$UDPlaza_file="<a href='".base_url($UDPlaza_file)."' target='_blanck'><button type='button' class='btn btn-sm btn-success' ><i class='fa fa-file-archive-o'></i> Ver Nombramiento</button></a>";
			}
			if($UDOficio_file = $list['UDOficio_file']) {
				$UDOficio_file="<a href='".base_url($UDOficio_file)."' target='_blanck'><button type='button' class='btn btn-sm btn-success' ><i class='fa fa-file-archive-o'></i> Ver Oficio</button></a>";
			}
            if($UDCurriculum_file = $list['UDCurriculum_file']) {
				$UDCurriculum_file="<a href='".base_url($UDCurriculum_file)."' target='_blanck'><button type='button' class='btn btn-sm btn-success' ><i class='fa fa-file-archive-o'></i> Ver Curriculum</button></a>";
			}
            if($UDCURP_file = $list['UDCURP_file']) {
				$UDCURP_file="<a href='".base_url($UDCURP_file)."' target='_blanck'><button type='button' class='btn btn-sm btn-success' ><i class='fa fa-file-archive-o'></i> Ver CURP</button></a>";
			}
			$borrar = "<button type='button' value=".$this->encrypt->encode($list['UDClave'])." class='btn btn-sm btn-danger quitarPlaza' title='Borrar' ><i class='fa fa-trash'></i></button>";?>
			<tr>
				<td><?php echo $list['TPNombre']; ?></td>
				<td><?php echo $list['UDFecha_ingreso']; ?></td>
				<td><?php echo $list['nomplaza']; ?></td>
				<td><?php echo $list['UDTipo_materia']; ?></td>
				<td><?php echo $list['UDNumOficio']; ?></td>
				<td>
                    <?php echo nvl($UDPlaza_file);?>
                    <?php echo nvl($UDOficio_file);?>
                    <?php echo nvl($UDCurriculum_file);?>
                    <?php echo nvl($UDCURP_file);?>
                </td>
				<td>
                    <?php echo nvl($borrar); ?>
				</td>
			</tr>
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