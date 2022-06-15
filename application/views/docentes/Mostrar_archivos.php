<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover dataTables-example dataTable">
		<thead>
			<tr>
				<th>Estudios</th>
				<th>Carrera</th>
				<th>Título Profesional</th>
				<th>Cédula Profesional</th>
				<th>Acción</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($data as $key => $list) { 
			if($UPTitulo_file = $list['UPTitulo_file']) {
				$UPTitulo_file="<a href='".base_url($UPTitulo_file)."' target='_blanck'><button type='button' class='btn btn-sm btn-success' ><i class='fa fa-file-archive-o'></i> Archivo</button></a>";
			}
			if($UPCedula_file = $list['UPCedula_file']) {
				$UPCedula_file="<a href='".base_url($UPCedula_file)."' target='_blanck'><button type='button' class='btn btn-sm btn-success' ><i class='fa fa-file-archive-o'></i> Archivo</button></a>";
			}
			$borrar = "<button type='button' value=".$this->encrypt->encode($list['UPClave'])." class='btn btn-sm btn-danger quitarArchivos' title='Borrar' ><i class='fa fa-trash'></i></button>";?>
			<tr>
				<td><?php echo $list['UPNivel_estudio']; ?></td>
				<td><?php echo $list['Licenciatura']; ?></td>
				<td><?php echo nvl($UPTitulo_file); ?></td>
				<td><?php echo nvl($UPCedula_file); ?></td>
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
	$(".quitarArchivos").click(function(e) {
		UPClave = $(this).val();
		var idUsuario = document.getElementById("UNCI_usuario").value;
		var idPlantel = document.getElementById("CPLClave").value;

		bootbox.confirm({
		    message: "¿Desea eliminar los Estudios del Usuario?",
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
						url: "<?php echo base_url("docente/deleteEstudios"); ?>",
						data: {UPClave: UPClave, idUsuario : idUsuario, idPlantel : idPlantel},
						dataType: "html",
						beforeSend: function(){
							//carga spinner
							$(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
						},
						success: function(data){
							$(".msgArchivos").empty();
							$(".resultArchivos").empty();
							$(".resultArchivos").append(data);
							$(".loadingArchivo").empty();
						}
						
					});
		    	}
		    }
		});
	});
</script>