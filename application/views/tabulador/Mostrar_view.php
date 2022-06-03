<link href="<?php echo base_url('assets/inspinia/css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/chosen/chosen.css'); ?>" rel="stylesheet">
<!--color boox-->
<script type="text/javascript" src="<?php echo base_url("assets/colorbox/jquery.colorbox-min.js") ?>"></script>
<link media="screen" rel="stylesheet" href="<?php echo base_url("assets/colorbox/colorbox.css") ?>" />
<div class="row">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
			<h3>Tabulador / Plazas</h3>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<?php muestra_mensaje(); ?>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<div class="pull-right">
				<?php if( is_permitido(null,'recibos','save') ){ ?>
					<button 
					class="btn btn-primary open"
					data-target="#modal_tabulador" 
					data-toggle="modal"
					data-unci_usuario_skip=""
					><i class="fa fa-th"></i> Registrar Plaza</button>
				<?php } ?>
				</div>
				<h3>&nbsp;</h3>
			</div> 
			<div class="ibox-content">
				
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTables-example dataTable" >
						<thead>
							<tr>
								<th>#</th>
								<th>Plaza</th>
								<th>CCT</th>
								<th>Correo</th>
								<th>Director</th>
								<th width="130px">Acción</th> 
							</tr>	
						</thead>
						<tbody>
							<?php 
								foreach($plazas as $key => $list){
									$PLClave_skip = $this->encrypt->encode($list['PLClave']);						
								?>
								<tr>
									<td class="text-left"><?php echo $list['PLClave']; ?></td> 
									<td class="text-left"><?php echo $list['PLTipo']; ?></td> 
									<td class="text-left"><?php echo $list['PLTipo_plantel']; ?></td>
									<td class="text-left"><?php echo $list['PLPuesto']; ?></td>
									<td class="text-left">$<?php echo number_format($list['PLTotal_bruto'],2); ?></td>								
									<td>
										<?php if( is_permitido(null,'tabulador','save') ){ ?>
											<button class="btn btn-default btn-sm open"
											data-target="#modal_tabulador" 
											data-toggle="modal"
											data-plclave_skip="<?php echo $PLClave_skip; ?>" 
											data-pltipo="<?php echo $list['PLTipo']; ?>"
											data-pltipo_plantel="<?php echo $list['PLTipo_plantel']; ?>"
											data-pltipo_clase="<?php echo $list['PLTipo_clase']; ?>"
											data-plpuesto="<?php echo htmlspecialchars($list['PLPuesto']); ?>"
											data-pljornada="<?php echo $list['PLJornada']; ?>"
											data-plsindicato="<?php echo $list['PLSindicato']; ?>"
											data-plsueldo_base="<?php echo $list['PLSueldo_base']; ?>"
											data-plgratificacion="<?php echo $list['PLGratificacion']; ?>"
											data-pldespensa="<?php echo $list['PLDespensa']; ?>"
											data-plmaterial_dicactico="<?php echo $list['PLMaterial_dicactico']; ?>"
											data-pleficiencia="<?php echo $list['PLEficiencia']; ?>"
											data-pltotal_bruto="<?php echo $list['PLTotal_bruto']; ?>"
											><i class="fa fa-pencil"></i> Editar</button>
										<?php } ?>
										<?php if( is_permitido(null,'tabulador','delete') ){ ?>
											<a href="<?php echo base_url("tabulador/delete/$PLClave_skip"); ?>" class="btn btn-default btn-sm delete"><i class="fa fa-times"></i> Borrar</a>
										<?php } ?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
	</div>
</div>


<div class="modal inmodal" id="modal_tabulador" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" >
		<div class="modal-content animated flipInY">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
				<h6 class="modal-title"><i class="fa fa-th"></i>&nbsp;&nbsp; Plazas</h6>
			</div>
			<div class="modal-content">
				<?php echo form_open('tabulador/save', array('name' => 'FormPlaza', 'id' => 'FormPlaza', 'role' => 'form', 'class' => 'form-horizontal panel-body')); ?>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Tipo Plaza: <em>*</em></label>
					<div class="col-lg-9">
						<select name="PLTipo" id="PLTipo" class="form-control" required>
							<option value=""></option>
							<option value="Administrativo">Administrativo</option>
							<option value="Docente">Docente</option>
							<option value="Directivo">Directivo o Confianza</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Tipo Plantel: <em>*</em></label>
					<div class="col-lg-9">
						<select name="PLTipo_plantel" id="PLTipo_plantel" class="form-control" required>
							<option value=""></option>
							<option value="Ambos">Ambos</option>
							<option value="Centro">Centro</option>
							<option value="General">General</option>
							<option value="Plantel">Plantel</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Tipo Clase: </label>
					<div class="col-lg-9">
						<select name="PLTipo_clase" id="PLTipo_clase" class="form-control">
							<option value=''></option>
							<option value="Tecnico">Tecnico</option>
							<option value="Profesor">Profesor</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Nombre: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="PLPuesto" name="PLPuesto" value="" maxlength='150' class="form-control uppercase" required />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Jornada: </label>
					<div class="col-lg-9">
						<select name="PLJornada" id="PLJornada" class="form-control">
							<option value=""></option>
							<option value="JORNADA 1/2 TIEMPO">JORNADA 1/2 TIEMPO</option>
							<option value="JORNADA 3/4 DE TIEMPO">JORNADA 3/4 DE TIEMPO</option>
							<option value="JORNADA TIEMPO COMP.">JORNADA TIEMPO COMP.</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Sindicalizable: <em>*</em></label>
					<div class="col-lg-9">
						<select name="PLSindicato" id="PLSindicato" class="form-control" required>
							<option value=""></option>
							<option value="SI">SI</option>
							<option value="NO">NO</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Sueldo base: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="PLSueldo_base" name="PLSueldo_base" value="" maxlength='11' class="form-control lowercase" required />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Gratificación Burocratica: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="PLGratificacion" name="PLGratificacion" value="" maxlength='11' class="form-control lowercase" required />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Despensa: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="PLDespensa" name="PLDespensa" value="" maxlength='11' class="form-control lowercase" required />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">PLMaterial dicactico: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="PLMaterial_dicactico" name="PLMaterial_dicactico" value="" maxlength='11' class="form-control lowercase" required />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Eficiencia en el trabajo: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="PLEficiencia" name="PLEficiencia" value="" maxlength='11' class="form-control lowercase" required />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Total bruto: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="PLTotal_bruto" name="PLTotal_bruto" value="" maxlength='11' class="form-control lowercase" required />
					</div>
				</div>
				<div id="error"></div>
				<div class="loading"></div>
				<div class="form-group">
					<div class="col-lg-offset-3 col-lg-9">
						<?php if( is_permitido(null,'tabulador','save') ){ ?>
						<input type="hidden" id="PLClave_skip" name="PLClave_skip" />
						<button type="submit" class="btn btn-primary pull-right"> <i class="fa fa-save"></i> Guardar</button>
						<?php } ?>
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>


<script src="<?php echo base_url('assets/inspinia/js/plugins/dataTables/datatables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/inspinia/js/plugins/chosen/chosen.jquery.js'); ?>"></script>

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

		$(document).on("click", ".open", function () {
			$(".modal-content #PLClave_skip").val( $(this).data('plclave_skip') );
			$(".modal-content #PLTipo").val( $(this).data('pltipo') );
			$(".modal-content #PLTipo_plantel").val( $(this).data('pltipo_plantel') );
			$(".modal-content #PLTipo_clase").val( $(this).data('pltipo_clase') );
			$(".modal-content #PLPuesto").val( $(this).data('plpuesto') );
			$(".modal-content #PLJornada").val( $(this).data('pljornada') );
			$(".modal-content #PLSindicato").val( $(this).data('plsindicato') );
			$(".modal-content #PLSueldo_base").val( $(this).data('plsueldo_base') );
			$(".modal-content #PLGratificacion").val( $(this).data('plgratificacion') );
			$(".modal-content #PLDespensa").val( $(this).data('pldespensa') );
			$(".modal-content #PLMaterial_dicactico").val( $(this).data('plmaterial_dicactico') );
			$(".modal-content #PLEficiencia").val( $(this).data('pleficiencia') );
			$(".modal-content #PLTotal_bruto").val( $(this).data('pltotal_bruto') );
		});

		$("#FormPlaza").submit(function(e) {
			e.preventDefault();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url("tabulador/save"); ?>",
				data: $(this).serialize(),
				dataType: "html",
				beforeSend: function(){
					$(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
				},
				success: function(data){
					if(data==' OK'){
						//location.href ="<?php echo base_url("dashboard"); ?>";
						location.reload();
					}
					else{
						$("#error").empty();
						$("#error").append(data);
						$(".loading").html("");
					}
					
				}
			});
		});//----->fin		
		
	});
</script>