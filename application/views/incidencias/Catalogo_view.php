<link href="<?php echo base_url('assets/inspinia/css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/chosen/chosen.css'); ?>" rel="stylesheet">
<!--color boox-->
<script type="text/javascript" src="<?php echo base_url("assets/colorbox/jquery.colorbox-min.js") ?>"></script>
<link media="screen" rel="stylesheet" href="<?php echo base_url("assets/colorbox/colorbox.css") ?>" />
<div class="row">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
			<h3>Planteles</h3>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<?php muestra_mensaje(); ?>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<div class="pull-right">
				<?php if( is_permitido(null,'incidencias','csave') ){ ?>
					<button 
					class="btn btn-primary open"
					data-target="#modal_incidencia" 
					data-toggle="modal"
					data-unci_usuario_skip=""
					><i class="fa fa-building-o"></i> Registrar Incidencia</button>
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
								<th>Tipo</th>
								<th>Requisito</th>
								<th>Estatus</th>
								<th width="130px">Acción</th> 
							</tr>	
						</thead>
						<tbody>
							<?php 
								foreach($incidencias as $key => $list){
									$CIClave_skip = $this->encrypt->encode($list['CIClave']);						
								?>
								<tr>
									<td class="text-left"><?=$list['CIClave']?></td> 
									<td class="text-left"><?=$list['CITipo']?></td>
									<td class="text-left"><?=$list['CIRequisito']?></td>
									<td class="text-left"><?=$list['CIActivo']?'Activo':'Inactivo'?></td>								
									<td>
										<?php if( is_permitido(null,'plantel','save') ){ ?>
											<button class="btn btn-default btn-sm open"
											data-target="#modal_incidencia" 
											data-toggle="modal"
											data-ciclave_skip="<?=$CIClave_skip?>" 
											data-citipo="<?=$list['CITipo']?>"
											data-cirequisito="<?=$list['CIRequisito']?>"
											data-citexto="<?=$list['CITexto']?>"
											data-citramite="<?=$list['CITramite']?>"
											data-ciactivo="<?=$list['CIActivo']?>"
											><i class="fa fa-pencil"></i> Editar</button>
										<?php } ?>
										<?php if( is_permitido(null,'plantel','delete') ){ ?>
											<a href="<?php echo base_url("plantel/delete/$CIClave_skip"); ?>" class="btn btn-default btn-sm delete"><i class="fa fa-times"></i> Borrar</a>
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


<div class="modal inmodal" id="modal_incidencia" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" >
		<div class="modal-content animated flipInY">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
				<h6 class="modal-title"><i class="fa fa-building-o"></i>&nbsp;&nbsp; Incidencia</h6>
			</div>
			<div class="modal-content">
				<?php echo form_open('incidencias/csave', array('name' => 'FormIncidencia', 'id' => 'FormIncidencia', 'role' => 'form', 'class' => 'form-horizontal panel-body')); ?>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Tipo: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="CITipo" name="CITipo" value="" maxlength='150' class="form-control" required />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Requisito: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="CIRequisito" name="CIRequisito" value="" maxlength='150' class="form-control" required />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Texto: </label>
					<div class="col-lg-9">
						<textarea id="CITexto" name="CITexto" maxlength='150' class="form-control textarea" ></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Tipo de oficio: <em>*</em></label>
					<div class="col-lg-9">
						<select name="CITramite" id="CITramite" class="form-control" required>
							<option value="0">Ninguno</option>
							<option value="1">Comisión</option>
							<option value="2">Propio</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Estatus: <em>*</em></label>
					<div class="col-lg-9">
						<select name="CIActivo" id="CIActivo" class="form-control" required>
							<option value="1">Activo</option>
							<option value="0">Inactivo</option>
						</select>
					</div>
				</div>
				<div id="error"></div>
				<div class="loading"></div>
				<div class="form-group">
					<div class="col-lg-offset-3 col-lg-9">
						<?php if( is_permitido(null,'incidencias','csave') ){ ?>
						<input type="hidden" id="CIClave_skip" name="CIClave_skip" />
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
			$(".modal-content #CIClave_skip").val( $(this).data('ciclave_skip') );
			$(".modal-content #CITipo").val( $(this).data('citipo') );
			$(".modal-content #CIRequisito").val( $(this).data('cirequisito') );
			$(".modal-content #CITexto").val( $(this).data('citexto') );
			$(".modal-content #CITramite").val( $(this).data('citramite') );
			$(".modal-content #CIActivo").val( $(this).data('ciactivo') );
		});

		$("#FormIncidencia").submit(function(e) {
			e.preventDefault();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url("incidencias/csave"); ?>",
				data: $(this).serialize(),
				dataType: "html",
				beforeSend: function(){
					$(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
				},
				success: function(data){
					if(data==' OK'){
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