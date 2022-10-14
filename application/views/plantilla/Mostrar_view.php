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
				<?php if( is_permitido(null,'plantilla','load-') ){ ?>
					<button 
					class="btn btn-primary open"
					data-target="#modal_plantilla" 
					data-toggle="modal"
					data-unci_usuario_skip=""
					><i class="fa fa-building-o"></i> Cargar Plantilla</button>
				<?php } ?>
				</div>
				<h3>&nbsp;</h3>
			</div> 
			<div class="ibox-content">
				
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTables-example dataTable" >
						<thead>
							<tr>
								<th>Periodo</th>
								<th>Plantel</th>
								<th>Fecha</th>
								<th>Plantilla</th>
								<th width="130px">Acción</th> 
							</tr>	
						</thead>
						<tbody>
							<?php 
								foreach($plantilla as $key => $list){
									$PClave_skip = $this->encrypt->encode($list['PClave']);						
									$PPlantilla_skip = base_url("files/get_file/".$this->encrypt->encode($list['PPlantilla'])."");	
									$PPeriodo = str_replace('-1','-A',$list['PPeriodo']);
									$PPeriodo = str_replace('-2','-B',$PPeriodo);
								?>
								<tr>
									<td class="text-left"><?php echo $PPeriodo; ?></td>
									<td class="text-left"><?php echo $list['CPLNombre']; ?></td>
									<td class="text-left"><?php echo fecha_format($list['PFecha_modificacion']); ?></td>
									<td class="text-left"><a href='<?=$PPlantilla_skip?>' target='_blank'>Ver</a></td>							
									<td>
										<?php if( is_permitido(null,'plantilla','update') ){ ?>
											<button class="btn btn-default btn-sm open"
											data-target="#modal_plantilla" 
											data-toggle="modal"
											data-pclave_skip="<?php echo $PClave_skip; ?>" 
											data-pperiodo="<?php echo $PPeriodo; ?>"
											data-pplantel="<?php echo $list['PPlantel']; ?>"
											data-pplantilla="<?php echo $list['PPlantilla']; ?>"
											data-pplantilla_skip="<?php echo $PPlantilla_skip; ?>"
											><i class="fa fa-pencil"></i> Editar</button>
										<?php } ?>
										<?php if( is_permitido(null,'plantilla','delete') ){ ?>
											<a href="<?php echo base_url("plantilla/delete/$PClave_skip"); ?>" class="btn btn-default btn-sm delete"><i class="fa fa-times"></i> Borrar</a>
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


<div class="modal inmodal" id="modal_plantilla" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" >
		<div class="modal-content animated flipInY">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
				<h6 class="modal-title"><i class="fa fa-building-o"></i>&nbsp;&nbsp; Plantilla</h6>
			</div>
			<div class="modal-content">
				<?php echo form_open('plantilla/load', array('name' => 'FormPlantilla', 'id' => 'FormPlantilla', 'role' => 'form', 'class' => 'form-horizontal panel-body')); ?>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Periodo: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="PPeriodo" name="PPeriodo" value="" maxlength='150' class="form-control uppercase disabled" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Plantel: <em>*</em></label>
					<div class="col-lg-9">
						<select name="PPlantel" id="PPlantel" class="form-control disabled" disabled >
							<?php if( $nivel>=2 ){ ?>
							<option <?php if($filtro=="0") echo"selected"; ?> value="">TODOS</option>
							<?php } ?>
							<?php foreach($planteles as $key => $list){ ?>
							<option value="<?=$list['CPLClave']?>" ><?=$list['CPLNombre']?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Plantilla: <em>*</em></label>
					<div class="col-lg-9">
						<?php echo forma_archivo("PPlantilla", null, "Adjuntar plantilla",'btn-primary pull-left'); ?>
					</div>
				</div>
				<div id="error"></div>
				<div class="loading"></div>
				<div class="form-group">
					<div class="col-lg-offset-3 col-lg-9">
						<?php if( is_permitido(null,'plantilla','load') ){ ?>
						<input type="hidden" id="PClave_skip" name="PClave_skip" />
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
				"url": "<?php echo base_url('assets/datatables_es.json'); ?>"
			},
			"order":[ 2, 'desc' ],
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
			$(".modal-content #PClave_skip").val( $(this).data('pclave_skip') );
			$(".modal-content #PPeriodo").val( $(this).data('pperiodo') );
			$(".modal-content #PPlantel").val( $(this).data('pplantel') );
			$(".modal-content #PPlantilla").val( $(this).data('pplantilla') );
			if( $(this).data('pplantilla') ){
				$("#ver_archivo_PPlantilla").attr( "href", $(this).data('pplantilla_skip') ).attr("display" , 'block').attr("style",'display:block');
			}else{
				$("#ver_archivo_PPlantilla").attr( "href",'#' ).attr("display" , 'none').attr("style",'display:none');
			}
		});

		$("#FormPlantilla").submit(function(e) {
			e.preventDefault();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('plantilla/load'); ?>",
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