<link href="<?php echo base_url('assets/inspinia/css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">
<!--color boox-->
<script type="text/javascript" src="<?php echo base_url("assets/colorbox/jquery.colorbox-min.js") ?>"></script>
<link media="screen" rel="stylesheet" href="<?php echo base_url("assets/colorbox/colorbox.css") ?>" />
<div class="row">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
			<h3>FUMP => <?php echo $usuario['UNombre']." ".$usuario['UApellido_pat']." ".$usuario['UApellido_mat']; ?></h3>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<?php muestra_mensaje(); ?>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<div class="pull-right">
				<?php if( is_permitido(null,'fump','agregar') ){ ?>
				<?php if( (get_session('URol')==12 and $plantel['CPLTipo']==37) or get_session('URol')!=12 ){ ?>
					<a href='<?php echo base_url('fump/agregar/'.$UNCI_usuario_skip); ?>' class="btn btn-primary agregar" >
						<i class="fa fa-file-text"></i> Generar FUMP
					</a>
					<div class="agregar_text hidden text-danger"> <h3>¡¡No puedes generar más FUMP, <br />tienes trámites pendientes o rechazados!!</h3></div>
				<?php $dir = 1; } ?>
				<?php } ?>
				</div>
				<h3>&nbsp;</h3>
			</div> 
			<div class="ibox-content">
				
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTables-example dataTable" >
						<thead>
							<tr>
								<th>Folio</th>
								<th>Clave Servidor</th>
								<th>Nombre</th>								
								<th>Plantel</th>								
								<th>Periodo</th>								
								<th>Vigencia</th>								
								<th>Tramite</th>								
								<th>Estatus</th>								
								<th width="130px">Acción</th> 
							</tr>	
						</thead>
						<tbody>
							<?php 
								$agregar = 0;
								$rechazado = 0;
								foreach($fump as $key => $list){
									$FClave_skip = $this->encrypt->encode($list['FClave']);						
								?>
								<tr>
									<td class="text-left"><?php echo folio($list['FClave']); ?></td> 
									<td class="text-left"><?php echo $list['FClave_servidor']; ?></td>								
									<td class="text-left"><?php echo $list['FNombre']." ".$list['FApellido_pat']." ".$list['FApellido_mat']; ?></td>
									<td class="text-left"><?php echo $list['FPlantel']; ?></td>
									<td class="text-left"><?php echo $list['FPeriodo']; ?></td>
									<td class="text-left"><?php echo fecha_format($list['FFecha_inicio']); ?>-<?php echo fecha_format($list['FFecha_termino']); ?></td>
									<td class="text-left">&#8226; <?php echo str_replace(";","<br />&#8226; ",$list['FTramite']); ?></td>
									<td>
									<?php 
									if($list['FNivel_autorizacion'] == 8 ){
										echo '<b class="text-info"><i class="fa fa-check"></i> Finalizado</b>';
									}elseif($list['FNivel_autorizacion'] == 7 ){
										echo '<b class="text-info"><i class="fa fa-check"></i> Alta Nomina</b>';
									}elseif($list['FNivel_autorizacion'] == 6 ){
										echo '<b class="text-warning"><i class="fa fa-check"></i> Pendiente Documentar</b>';
										$agregar+= 1;
									}elseif($list['acceptTerms'] == 'on'){
										echo '<b class="text-success"><i class="fa fa-clock-o"></i> Validando..</b>';
										$agregar+= 1;
									}elseif($list['FNivel_autorizacion'] <= 1 and $list['FAutorizo_1'] ){
										echo '<b class="text-danger"><i class="fa fa-times"></i> Rechazado</b>';
										$agregar+= 1;
										$rechazado+= 1;
									}else{
										echo '<b class="text-warning"><i class="fa fa-exclamation-triangle"></i> Pendiente</b>';
										$agregar+= 1;
									}
									?>
									</td>
									<td>
										<a href="<?php echo base_url("fump/ver/$FClave_skip"); ?>"  class="btn btn-default btn-sm"><i class="fa fa-eye"></i> Ver</a>
										<?php if( is_permitido(null,'fump','editar') and !$list['acceptTerms'] and @$dir){ ?>
										<a href="<?php echo base_url("fump/agregar/$UNCI_usuario_skip/$FClave_skip"); ?>"  class="btn btn-default btn-sm"><i class="fa fa-pencil"></i> Editar</a>
										<?php } ?>
										<?php if( is_permitido(null,'fump','delete') and !$list['FAutorizo_1'] and !$list['acceptTerms'] ){ ?>
											<a href="<?php echo base_url("fump/delete/$FClave_skip"); ?>" class="btn btn-default btn-sm" confirm="¿Está seguro de eliminar esté FUMP?" ><i class="fa fa-times"></i> Borrar</a>
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

<div class="modal inmodal" id="modal_fump" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" >
		<div class="modal-content animated flipInY">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
				<h6 class="modal-title"><i class="fa fa-file"></i>&nbsp;&nbsp; FUMP</h6><div class="border-bottom"><br /></div>
				<?php echo form_open('personal/save', array('name' => 'FormPersonal', 'id' => 'FormPersonal', 'role' => 'form', 'class' => 'form-horizontal panel-body')); ?>	
				<div class="form-group">
					<label class="col-lg-6 control-label" for="">Número de movimientos para este servidor público: <em>*</em></label>
					<div class="col-lg-6">
						<select id="UFump" name="UFump" value="" class="form-control">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select>
					</div>
				</div>
				<div id="error"></div>
				<div class="loading"></div>
				<div class="form-group">
					<div class="col-lg-offset-3 col-lg-9">
						<input type="hidden" id="UNCI_usuario_skip" name="UNCI_usuario_skip" value='<?php echo $this->encrypt->encode($usuario['UNCI_usuario']); ?>' />
						<button type="button" class="btn btn-primary pull-right save"> <i class="fa fa-save"></i> Guardar</button>
					</div>
				</div>
				<?php echo form_close(); ?>
				
			</div>
		</div>
	</div>
</div>


<script src="<?php echo base_url('assets/inspinia/js/plugins/dataTables/datatables.min.js'); ?>"></script>

<script type="text/javascript">
	$(document).ready(function() {
		
		/* Page-Level Scripts */
		$('.dataTables-example').DataTable({
			"language": {
				"url": "<?php echo base_url("assets/datatables_es.json"); ?>"
			},
			"order": [[ 0, "desc" ]],
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
		
		$(".save").click(function() {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url("fump/numero"); ?>",
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
		
		<?php if($agregar >= $config['COLimite_fump'] or $rechazado >= 1){ ?>
		$(".agregar").addClass("hidden");
		$(".agregar_text").removeClass("hidden");
		<?php } ?>
		
	});
</script>