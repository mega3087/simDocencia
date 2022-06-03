<link href="<?php echo base_url('assets/inspinia/css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/chosen/chosen.css'); ?>" rel="stylesheet">
<div class="row">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
			<h3>Circulares</h3>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<?php muestra_mensaje(); ?>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<div class="pull-right">
				<?php if( is_permitido(null,'circular','save') ){ ?>
					<button 
					class="btn btn-primary open"
					data-target="#modal_circular" 
					data-toggle="modal">
						<i class="fa fa-envelope"></i> Agregar Circular
					</button>
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
								<th>Archivo</th>
								<th>Descripción</th>
								<th>Estatus</th>
								<th width="130px">Acción</th> 
							</tr>	
						</thead>
						<tbody>
							<?php 
								foreach($archivos as $key => $list){
									$CIClave_skip = $this->encrypt->encode($list['CIClave']);						
								?>
								<tr>
									<td class="text-left"><?php echo folio($list['CIClave']); ?></td> 
									<td class="text-left">
										<a href="<?php echo base_url($list['CIRuta']); ?>" target='_blank' data-pdf-="" type='application/pdf' >
											<?php echo $list['CIArchivo']; ?>
										</a>
									</td> 
									<td class="text-left"><?php echo $list['CIDescripcion']; echo "<br />Fecha de publicación: ".fecha_format($list['CIFecha_registro']);?></td>
									<td class="text-left"><?php if($list['CIEstatus']) echo '<span class="text-navy">Activo</span>'; else echo '<span class="text-danger">Inactivo</span>'; ?></td>									
									<td>
										<?php 
										if( is_permitido(null,'circular','status') ){
											
											if($list['CIEstatus']){?>
												<a href="<?php echo base_url("circular/status/$CIClave_skip"); ?>" class="btn btn-default btn-sm"><i class="fa fa-thumbs-down"></i> Desactivar</a>
											<?php }else{ ?>
												<a href="<?php echo base_url("circular/status/$CIClave_skip/1"); ?>" class="btn btn-default btn-sm"><i class="fa fa-thumbs-up"></i> Activar</a>
											<?php }  ?>
										<?php } ?>
											
										<?php if( is_permitido(null,'circular','save') ){ ?>
											<button class="btn btn-default btn-sm open"
											data-target="#modal_circular" 
											data-toggle="modal"
											data-ciclave_skip="<?php echo $CIClave_skip; ?>" 
											data-ciruta="<?php echo $list['CIRuta']; ?>"
											data-cidescripcion="<?php echo $list['CIDescripcion']; ?>"
											><i class="fa fa-pencil"></i> Editar
											</button>
										<?php } ?>
										
										<?php if( is_permitido(null,'circular','delete') ){ ?>
											<a href="<?php echo base_url("circular/delete/$CIClave_skip"); ?>" class="btn btn-default btn-sm delete"><i class="fa fa-times"></i> Borrar</a>
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

<div class="modal inmodal" id="modal_circular" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" >
		<div class="modal-content animated flipInY">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
				<h6 class="modal-title"><i class="fa fa-envelope"></i>&nbsp;&nbsp; Circular</h6><div class="border-bottom"><br /></div>
				
				<div id="error"></div>
				
				<?php echo form_open('circular/save', array('name' => 'FormCircular', 'id' => 'FormCircular', 'role' => 'form', 'class' => 'form-horizontal panel-body')); ?>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Archivo: <em>*</em></label>
					<div class="col-lg-9">
						<?php forma_archivo('CIRuta',null,'Subir Circular','btn-primary pull-left'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Descripción: <em>*</em></label>
					<div class="col-lg-9">
						<textarea type="text" id="CIDescripcion" name="CIDescripcion"class="form-control uppercase textarea" ></textarea>
					</div>
				</div>
				
				<div class="loading"></div>
				<div class="form-group">
					<div class="col-lg-offset-3 col-lg-9">
						<input type="hidden" id='CIClave_skip' name='CIClave_skip' />
						<button type="button" class="btn btn-primary pull-right save"> <i class="fa fa-save"></i> Guardar</button>
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
			"order":[ 1, 'desc' ],
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
					$(win.document.body).find('table')
					.addClass('compact')
					.css('font-size', 'inherit');
				}
			}
			]
		});		
		
		/* Ventana modal */
		$(document).on("click", ".open", function () {
			var CIClave_skip = $(this).data('ciclave_skip');
			var CIRuta = $(this).data('ciruta');
			var CIDescripcion = $(this).data('cidescripcion');
			$(".modal-header #CIClave_skip").val( CIClave_skip );
			$(".modal-header #CIRuta").val( CIRuta );
			$(".modal-header #CIDescripcion").val( CIDescripcion );
		});
		
		$(".save").click(function() {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url("circular/save"); ?>",
				data: $(this.form).serialize(),
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
						$("#error").empty();
						$("#error").append(data);	
						$(".loading").html("");	
					}
					
				}
			});
		});//----->fin
		
	});
</script>