<link href="<?php echo base_url('assets/inspinia/css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/chosen/chosen.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/datapicker/datepicker3.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/inspinia/css/plugins/clockpicker/clockpicker.css'); ?>" rel="stylesheet" />

<div class="row">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
			<h3><?=strtoupper($title)?></h3>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<?php muestra_mensaje(); ?>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<div class="form-group">
					<label class="col-lg-1 control-label">Estatus:</label>
					<div class="col-lg-2">
						<select name="filtro" id="filtro" class="form-control">
							<option <?php if($filtro=="Pendientes") echo"selected"; ?> value="Pendientes">Pendientes</option>
							<option <?php if($filtro=="Autorizados") echo"selected"; ?> value="Autorizados">Autorizados</option>
							<option <?php if($filtro=="Recibidos") echo"selected"; ?> value="Recibidos">Recibidos</option>
							<option <?php if($filtro=="Registrados") echo"selected"; ?> value="Registrados">Registrados</option>
							<option <?php if($filtro=="Cancelados") echo"selected"; ?> value="Cancelados">Cancelados</option>
							<option <?php if($filtro=="Todos") echo"selected"; ?> value="Todos">Todos</option>
						</select>
					</div>
				</div>
				<div class="pull-right">
				<?php if( is_permitido(null,'incidencias','save') and $nivel == 0 ){ ?>
					<button 
					class="btn btn-primary open"
					data-target="#modal_incidencias" 
					data-toggle="modal"
					data-iclave_skip=""
					data-iclave_servidor="<?=$usuario["UClave_servidor"]?>"
					data-iissemym="<?=$usuario["UISSEMYM"]?>"
					data-inombre="<?=$usuario["UNombre"]." ".$usuario["UApellido_pat"]." ".$usuario["UApellido_mat"]?>"
					data-iplaza="<?=htmlspecialchars(@$incidencias[0]['IPlaza'])?>"
					>
						<i class="fa fa-file-text"></i> Nueva incidencia
					</button>
				<?php } ?>
				</div>
				<h3>&nbsp;</h3>
			</div> 
			<div class="ibox-content">
				<div class="row">
					<div class="col-lg-12">
						<form action="<?php echo base_url("incidencias/$modulo"); ?>" name="FormSearch" id="FormSearch" method="POST">
							<div class="col-lg-4">
								<div class="input-daterange input-group">
                                    <span class="input-group-addon">Mostrar</span>
									<select name="limit" id="limit" class="form-control">
										<option <?php if($limit == '20' ) echo"selected"; ?> value="20">20</option>
										<option <?php if($limit == '50' ) echo"selected"; ?> value="50">50</option>
										<option <?php if($limit == '100') echo"selected"; ?> value="100">100</option>
										<option <?php if($limit == '500') echo"selected"; ?> value="500">500</option>
									</select>
                                    <span class="input-group-addon">
										de <?php echo $total; ?> resultado(s) encontrado(s)
									</span>
									<input type="hidden" name="start" id="start" value="<?php echo $start; ?>" readonly />
                                </div>
							</div>
							<div class="col-lg-4 text-center">
								<i><b><?=$search?></b></i>
							</div>
							<div class="col-lg-4">
								<div class="input-daterange input-group pull-right">
                                    <input type="text" name="search" id="search" placeholder="<?=$search?>" class="form-control" />
                                    <span class="input-group-addon">
										<button type="button" class="btn btn-primary btn-sm search"><i class="fa fa-search"></i> Buscar</button>
									</span>
                                </div>
							</div>
						</form>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover dataTables-example dataTable" >
								<thead>
									<tr>
										<th>Folio</th>
										<th>Nombre</th>
										<th>Incidencia</th>
										<th width="100px">Oficio de Comisión</th> 
										<th width="100px">Aviso de Justificación</th> 
										<th width="140px">Estatus</th> 
										<th width="140px">Acción</th> 
									</tr>	
								</thead>
								<tbody>
									<?php 
										$start++;
										$next = null;
										foreach($incidencias as $key => $list){
											$IClave_skip = $this->encrypt->encode($list['IClave']);
											$next = $start+$key;
										?>
										<tr>
											<td class="text-left"><?php echo str_ireplace($search,"<em>".$search."</em>",folio($list['IClave'])); ?></td>
											<td class="text-left"><?php echo str_ireplace($search,"<em>".$search."</em>",$list['INombre']); ?></td>
											<td class="text-left"><?php echo str_ireplace($search,"<em>".$search."</em>",$list['CITipo']); ?></td>
											<td class="text-center">
												<?php if( $list['CITramite'] ){ ?>
													<a href="<?=base_url("incidencias/oficio/$IClave_skip/pdf")?>" target="_blank"><?php if($list['CIRequisito']){ ?><i class="fa fa-file-pdf-o fa-2x text-danger"><?php } ?></i></a>
												<?php }else{ ?>
													N/A
												<?php }?>
											</td>
											<td class="text-center">
												<?php if( $list['INivel_autorizacion'] >= 1 or $nivel==1 ){ ?>
													<a href="<?=base_url("incidencias/aviso/$IClave_skip/pdf")?>" target="_blank"><i class="fa fa-file-pdf-o fa-2x text-danger"></i></a>
												<?php }else{ ?>
													<div class="text-warning"><i class="fa fa-clock-o fa-1x"> </i> En espera...</div> 
												<?php }?>
											</td>
											<td class="text-left">
											<?php if(!$list['IActivo']){ ?>
												<em>Cancelado</em>
											<?php }elseif($list['INivel_autorizacion']==0){ ?>
												<div class="text-success">Pendiente de Autorizar</div>
											<?php }elseif($list['INivel_autorizacion']==1){ ?>
												<div class="text-danger">Pendiente de Entregar</div>
											<?php }elseif($list['INivel_autorizacion']==2){ ?>
												<div class="text-warning">Pendiente de Registrar</div>
											<?php }elseif($list['INivel_autorizacion']==3){ ?>
											<div class="text-info">Registrado</div>
											<?php } ?>
											</td>
											<td>
											<?php if($list['IActivo']) { ?>
												<?php if( $nivel == 0 and $list['INivel_autorizacion'] == 0){ ?>
													<button class="btn btn-default btn-sm open"
													data-target="#modal_incidencias" 
													data-toggle="modal"
													data-iclave_skip="<?php echo $IClave_skip; ?>" 
													data-iclave_servidor="<?php echo $list['IClave_servidor']; ?>"
													data-iissemym="<?php echo $list['IISSEMYM']; ?>"
													data-inombre="<?php echo $list['INombre']; ?>"
													data-iplaza="<?php echo htmlspecialchars($list['IPlaza']); ?>"
													data-iplantel="<?php echo $list['IPlantel']; ?>"
													data-ihorai="<?php echo $list['IHorai']; ?>"
													data-ihoraf="<?php echo $list['IHoraf']; ?>"
													data-iexcento="<?php echo $list['IExcento']; ?>"
													data-ifechai="<?php echo fecha_format($list['IFechai']); ?>"
													data-ifechaf="<?php echo fecha_format($list['IFechaf']); ?>"
													data-itipo="<?php echo $list['ITipo']; ?>"
													data-icomision="<?php echo $list['IComision']; ?>"
													><i class="fa fa-pencil"></i> Editar
													</button>
													<?php if( is_permitido(null,'incidencias','delete') ){ ?>
													<a href="<?php echo base_url("incidencias/delete/$IClave_skip"); ?>" class="btn btn-default btn-sm" confirm="¿Estás seguro de cancelar esté registro?"><i class="fa fa-times"></i> Cancelar</a>
													<?php } ?>
												<?php }elseif($nivel == 1 and $list['INivel_autorizacion'] == 0){ ?>
													<a href="<?=base_url("incidencias/nivel/1/$IClave_skip")?>" class="btn btn-default btn-sm open">
														<i class="fa fa-check"></i> Autorizar
													</a>
												<?php }elseif($nivel == 2 and $list['INivel_autorizacion'] == 1){ ?>
													<a href="<?=base_url("incidencias/nivel/2/$IClave_skip")?>" class="btn btn-default btn-sm open">
														<i class="fa fa-folder"></i> Recibir
													</a>
												<?php }elseif($nivel == 2 and $list['INivel_autorizacion'] == 2){ ?>
													<a href="<?=base_url("incidencias/nivel/3/$IClave_skip")?>" class="btn btn-default btn-sm open">
														<i class="fa fa-edit"></i> Registrar
													</a>
												<?php } ?>
											<?php } ?>
											</td>
										</tr>
									<?php } ?>
								</tbody>
								<tfoot>
								<tr>
									<td colspan="9" align="center">
									<?php 
										$previous = $start-1-$limit;
										if($previous >= 0){
									?>
										<button type="button" onclick="submit('<?php echo $previous; ?>');" class="btn btn-outline btn-success btn-sm">Anterior</button>
									<?php } ?>
									<?php if($next < $total ){ ?>
										<button type="button" onclick="submit('<?php echo $next; ?>')" class="btn btn-outline btn-success btn-sm">Siguiente</button>
									<?php } ?>
									</td>
								</tr>
								</tfoot>
							</table>				
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<div class="modal inmodal" id="modal_incidencias" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" >
		<div class="modal-content animated flipInY">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
				<h6 class="modal-title"><i class="fa fa-user"></i>&nbsp;&nbsp; Incidencia</h6><div class="border-bottom"><br /></div>
				<?php echo form_open('incidencias/save', array('name' => 'FormIncidencia', 'id' => 'FormIncidencia', 'role' => 'form', 'class' => 'form-horizontal panel-body')); ?>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Clave Servidor: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="IClave_servidor" name="IClave_servidor" value="" maxlength='11' class="form-control" readonly />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Nombre del servidor público: </label>
					<div class="col-lg-9">
						<input type="text" id="INombre" name="INombre" value="" maxlength='150' class="form-control" readonly />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Clave ISSEMYM: </label>
					<div class="col-lg-9">
						<input type="text" id="IISSEMYM" name="IISSEMYM" value="" maxlength='150' class="form-control" readonly />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Nombre de la plaza: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="IPlaza" name="IPlaza" value="" maxlength='150' class="form-control" autocomplete="off" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Departamento: <em>*</em></label>
					<div class="col-lg-9">
						<select name="IPlantel" id="IPlantel" class="form-control">
							<?php foreach($planteles as $key => $list){ ?>
							<option value="<?=$list['CPLClave'];?>"><?=$list['CPLNombre'];?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Fecha de permiso: <em>*</em></label>
					<div class="col-lg-9">
						<div class="row">
							<div class="col-lg-6">
								<input type="text" placeholder="Fecha inicial" id="IFechai" name="IFechai" value="" maxlength='10' class="form-control date" autocomplete="off" />
							</div>
							<div class="col-lg-6">
								<input type="text" placeholder="Fecha final" id="IFechaf" name="IFechaf" value="" maxlength='10' class="form-control date" autocomplete="off" />
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Horario de permiso: <em>*</em></label>
					<div class="col-lg-9">
						<div class="row">
							<div class="col-lg-6">
								<input type="text" placeholder="Hora inicial" id="IHorai" name="IHorai" value="" maxlength='10' class="form-control clock" autocomplete="off" />
							</div>
							<div class="col-lg-6">
								<input type="text" placeholder="Hora final" id="IHoraf" name="IHoraf" value="" maxlength='10' class="form-control clock" autocomplete="off" />
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Exento de registrar asistencia de: <em>*</em></label>
					<div class="col-lg-9">
						<select name="IExcento" id="IExcento" class="form-control">
							<option value="N/A">---</option>
							<option value="Entrada y Salida">Entrada y Salida</option>
							<option value="Entrada">Entrada</option>
							<option value="Salida">Salida</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Tipo de incidencia: <em>*</em></label>
					<div class="col-lg-9">
						<select name="ITipo" id="ITipo" class="form-control">
							<option value=""></option>
							<?php foreach($cincidencia as $key => $list){ ?>
							<option value="<?=$list['CIClave'];?>"><?=$list['CITipo'];?> <?=$list['CIRequisito'];?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Comisión: <em>*</em></label>
					<div class="col-lg-9 text-left">
					<div id="comision"></div>
						<textarea type="text" id="IComision" name="IComision" value="" maxlength='150' class="form-control" disabled ></textarea>
					</div>
				</div>
				<div id="error"></div>
				<div class="loading"></div>
				<div class="form-group">
					<div class="col-lg-offset-3 col-lg-9">
						<?php if( is_permitido(null,'incidencias','save') ){ ?>
						<input type="hidden" id="IClave_skip" name="IClave_skip" />
						<button type="submit" class="btn btn-primary pull-right save"> <i class="fa fa-save"></i> Guardar</button>
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
<script src="<?php echo base_url('assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('assets/date_picker_es.js'); ?>"></script>
<script src="<?php echo base_url('assets/inspinia/js/plugins/clockpicker/clockpicker.js'); ?>"></script>

<script type="text/javascript">
	$(document).ready(function() {
		
		/* Page-Level Scripts */
		
		$('.dataTables-example').DataTable({
			"language": {
				"url": "<?php echo base_url('assets/datatables_es.json'); ?>"
			},
			"order": [[ 0, "asc" ]],
			"paging": false,
			"info": false,
			"searching": false,
		});
		
		/* Ventana modal */
		$(document).on("click", ".open", function () {
			$(".modal-header #IClave_skip").val( $(this).data('iclave_skip') );
			$(".modal-header #IClave_servidor").val( $(this).data('iclave_servidor') );
			$(".modal-header #IISSEMYM").val( $(this).data('iissemym') );
			$(".modal-header #INombre").val( $(this).data('inombre') );
			$(".modal-header #IPlaza").val( $(this).data('iplaza') );
			$(".modal-header #IPlantel").val( $(this).data('iplantel') );
			$(".modal-header #IFechai").val( $(this).data('ifechai') );
			$(".modal-header #IFechaf").val( $(this).data('ifechaf') );
			$(".modal-header #IHorai").val( $(this).data('ihorai') );
			$(".modal-header #IHoraf").val( $(this).data('ihoraf') );
			$(".modal-header #IExcento").val( $(this).data('iexcento') );
			$(".modal-header #ITipo").val( $(this).data('itipo') );
			$(".modal-header #IComision").val( $(this).data('icomision') );
			ITipo();
		});
		
		$("#ITipo").change(function(){
			ITipo();
		});//----->fin
		
		function ITipo(){
			$.ajax({
				type: "POST",
				url: "<?php echo base_url("incidencias/textocomision_skip"); ?>",
				data: $("#FormIncidencia").serialize(),
				dataType: "html",
				beforeSend: function(){
					//carga spinner
					$(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
				},
				success: function(data){
					$("#comision").empty();
					$("#comision").append(data);	
					$(".loading").html("");
					if(data==' <em>No se necesita texto adicional.</em>'){
						$(".modal-header #IComision").attr('disabled', true);
					}else{
						$(".modal-header #IComision").attr('disabled', false);
					}
				}
			});
		};//----->fin
		
		$(".save").click(function(e){
			e.preventDefault();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url("incidencias/save"); ?>",
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
		
		$("#limit").on("change",function(){
			limit = $("#limit").val();
			start = $("#start").val();
			search = $("#search").val()?$("#search").val():' ';
			filtro = $("#filtro").val();
			search = window.btoa(unescape(encodeURIComponent(search))).replace("=","").replace("=","").replace("=","");
			location.href ="<?=base_url("incidencias/$modulo")?>/"+limit+"/"+start+"/"+search+"/"+filtro;
		});
		
		$(".search").on("click",function(){
			limit = $("#limit").val();
			start = $("#start").val();
			search = $("#search").val()?$("#search").val():' ';
			filtro = $("#filtro").val();
			search = window.btoa(unescape(encodeURIComponent(search))).replace("=","").replace("=","").replace("=","");
			location.href ="<?=base_url("incidencias/$modulo")?>/"+limit+"/"+start+"/"+search+"/"+filtro;
		});
		
		$("#FormSearch").submit(function(e){
			e.preventDefault();
			limit = $("#limit").val();
			start = $("#start").val();
			search = $("#search").val()?$("#search").val():' ';
			filtro = $("#filtro").val();
			search = window.btoa(unescape(encodeURIComponent(search))).replace("=","").replace("=","").replace("=","");
			location.href ="<?=base_url("incidencias/$modulo")?>/"+limit+"/"+start+"/"+search+"/"+filtro;
		});
		
		$("#filtro").on("change", function(){
			limit = 20;
			start = 0;
			search = ' ';
			filtro = $("#filtro").val();
			search = window.btoa(unescape(encodeURIComponent(search))).replace("=","").replace("=","").replace("=","");
			location.href ="<?=base_url("incidencias/$modulo")?>/"+limit+"/"+start+"/"+search+"/"+filtro;
		});
		
		$('.clock').clockpicker({
			autoclose: true
		});
	
	});
	function submit(start){
		if(start== undefined ) start = null;
		$("#start").val(start);
		$("#FormSearch").submit();
	}
</script>
<style>
	.input-group-addon{
		background-color: white !important;
		border: 1px solid #fff !important;
	}
	.clockpicker-popover{
		z-index: 2210;
	}
</style>