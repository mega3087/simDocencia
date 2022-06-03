<link href="<?php echo base_url('assets/inspinia/css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/chosen/chosen.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/datapicker/datepicker3.css'); ?>" rel="stylesheet" />

<div class="row">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
			<h3>Configurar Sistema</h3>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<?php muestra_mensaje(); ?>
		<div id="result"></div>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<div class="pull-right">
				&nbsp;
				</div>
				<h3>&nbsp;</h3>
			</div> 
			<div class="ibox-content">
				<div class="row">
					<div class="col-lg-offset-3 col-lg-6">
						<div class="table-responsive">
							<?php echo form_open('configurar/save', array('name' => 'FormConfig', 'id' => 'FormConfig', 'role' => 'form', 'class' => 'form-horizontal panel-body')); ?>
							<table class="table table-striped table-bordered table-hover dataTables-example dataTable" >
								<thead>
									<tr><th colspan="2"><center>FUMP</center></th></tr>	
								</thead>
								<tbody>
									<tr>
										<td align="right">
										<label class="control-label" for="">Limite de creación de FUMP: <em>*</em><br />
										<small>Limite de creación de FUMP por personal</small></label>
										</td>
										<td><input type="text" name="COLimite_fump" id="COLimite_fump" class="form-control" value="<?=$COLimite_fump?>" /></td>
									</tr>
									<tr>
										<td align="right">
										<label class="control-label" for="">Rango inicial FUMP: <em>*</em><br />
										<small>Rango para limitar la fecha inicial del FUMP</small></label>
										</td>
										<td><input type="text" name="CORango_fechas_i" id="CORango_fechas_i" class="form-control" value="<?=$CORango_fechas_i?>" /></td>
									</tr>
									<tr>
										<td align="right">
										<label class="control-label" for="">Rango final FUMP: <em>*</em><br />
										<small>Rango para limitar la fecha final del FUMP</small></label>
										</td>
										<td><input type="text" name="CORango_fechas_f" id="CORango_fechas_f" class="form-control" value="<?=$CORango_fechas_f?>" /></td>
									</tr>
									<tr>
										<td align="right">
										<label class="control-label" for="">Validar CURP: <em>*</em><br />
										<small>Usar validación de la CURP por RENAPO</small></label>
										</td>
										<td>
											<select name="COUsarCURP" id="COUsarCURP" class="form-control" />
												<option value="0" <?php if($COUsarCURP==0) echo "selected"; ?>>NO</option>
												<option value="1" <?php if($COUsarCURP==1) echo "selected"; ?>>SI</option>
											</select>
										</td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="2"><button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Guardar</button></td>
									</tr>
								</tfoot>
							</table>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script src="<?php echo base_url('assets/inspinia/js/plugins/dataTables/datatables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/inspinia/js/plugins/chosen/chosen.jquery.js'); ?>"></script>
<script src="<?php echo base_url('assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('assets/date_picker_es.js'); ?>"></script>

<script type="text/javascript">
	$(document).ready(function() {
		
		$("#FormConfig").submit(function(e) {
			e.preventDefault();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url("configurar/save"); ?>",
				data: $(this).serialize(),
				dataType: "html",
				beforeSend: function(){
					//carga spinner
					$(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
				},
				success: function(data){
					if(data==' OK'){
						location.reload();
					}
					else{
						$("#result").empty();
						$("#result").append(data);	
						$(".loading").html("");	
					}
					
				}
			});
		});//----->fin
	});

</script>