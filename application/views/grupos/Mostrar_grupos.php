<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover dataTables-example dataTable">
		<thead>
			<tr>
				<th>Periodo</th>
				<th>Semestre</th>
				<th>Grupo</th>
				<th>Turno</th>
				<th>Alumnos</th>
				<th>Acción</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($data as $key => $list) { 
			echo "<input type='hidden' name='plantel' id='plantel' value='".$list['GRCPlantel']."'>";
			$borrar = "<button type='button' value=".$this->encrypt->encode($list['GRClave'])." class='btn btn-sm btn-danger borrarGrupo' title='Borrar' ><i class='fa fa-trash'></i></button>";			?>
			<tr>
				<td><?=substr($list['GRPeriodo'],0,2)?>-<?=substr($list['GRPeriodo'],3,1)==1?'A':'B'?></td>
				<td><?php echo $list['GRSemestre']."°"; ?></td>
				<td><?php echo $list['GRGrupo']; ?></td>
				<td>
					<?php if ($list['GRTurno'] == 1) {
						echo "MATUTINO";
					} else {
						echo "VESPERTINO";
					} ?>
				</td>
				<td><?php echo $list['GRCupo']; ?></td>
				<td>
					<?php if( is_permitido(null,'grupos','delete') ) {
					echo nvl($borrar); 
					} ?>
					<!--<button type="button" class="btn btn-sm btn-success editarGrupo" data-bb-example-key="custom-dialog-init" title="Editar"><i class='fa fa-pencil'></i></button>-->
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>

<script src="<?php echo base_url('assets/inspinia/js/plugins/bootbox.all.min.js'); ?>"></script>
<script type="text/javascript">
	$(".borrarGrupo").click(function(e) {
		GRClave = $(this).val();
		var PlantelId = document.getElementById("plantel").value;
		bootbox.confirm({
		    message: "¿Desea eliminar el grupo?",
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
						url: "<?php echo base_url("grupos/delete"); ?>",
						data: {GRClave: GRClave, PlantelId: PlantelId},
						dataType: "html",
						beforeSend: function(){
							//carga spinner
							$(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
						},
						success: function(data){
							$(".msg").empty();
							$(".result").empty();
							$(".result").append(data);
							$(".loading").empty();
						}
						
					});
		    	}
		    }
		});
	});
</script>