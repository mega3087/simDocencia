<link href="<?php echo base_url('assets/inspinia/css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/chosen/chosen.css'); ?>" rel="stylesheet">
<!--color boox-->
<script type="text/javascript" src="<?php echo base_url("assets/colorbox/jquery.colorbox-min.js") ?>"></script>
<link media="screen" rel="stylesheet" href="<?php echo base_url("assets/colorbox/colorbox.css") ?>" />
<div class="row">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
			<h3>Percepciones no grabables</h3>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox-content">
			<form action="<?php echo base_url("percepciones/index"); ?>" method="post" enctype="multipart/form-data" class="form-horizontal panel-body"> 
				<div class="form-group ">
					<label class="col-lg-3 control-label visible-lg" for="AAnio"><br />Buscar: </label>
					<div class="col-lg-9">
						<div class="row visible-lg">
							<div class="col-lg-4 control-label" for="AAnio">Año</div>
							<div class="col-lg-4 control-label" for="AMes">Mes</div>
							<div class="col-lg-4 control-label" for="AQuincena">Quincena</div>
						</div>
						<div class="row">
							<label class="col-lg-3 control-label hidden-lg" for="AAnio">Año: </label>
							<div class="col-lg-4">
								<select name="AAnio" id="AAnio" class="form-control">
									<option value="">[año]</option>
									<?php for($i=date('Y');$i>='2012';$i--){ ?>
										<option <?php if(nvl($AAnio)==$i) echo"selected"; ?> value="<?=$i?>"><?=$i?></option>
									<?php } ?>
								</select>
							</div>
							<label class="col-lg-3 control-label hidden-lg" for="AMes">Mes: </label>
							<div class="col-lg-4">
								<select name="AMes" id="AMes" class="form-control">
									<option value="">[mes]</option>
									<?php for($i='1';$i<='12';$i++){ ?>
										<option <?php if(nvl($AMes)==$i) echo"selected"; ?> value="<?=$i?>"><?=ver_mes($i)?></option>
									<?php } ?>
								</select>
							</div>
							<label class="col-lg-3 control-label hidden-lg" for="AQuincena"> Quincena:</label>
							<div class="col-lg-4">
								<select name="AQuincena" id="AQuincena" class="form-control">
									<option value="">[quincena]</option>
									<option <?php if(nvl($AQuincena)=='01') echo"selected"; ?> value="01">01</option>
									<option <?php if(nvl($AQuincena)=='02') echo"selected"; ?> value="02">02</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="ANombre"> Clave Servidor:</label>
					<div class="col-lg-3">
						<?php if( is_permitido(null,'recibos','save') ){ ?>
						<input type="text" name="ANombre" id="ANombre" class="form-control" value='<?=nvl($ANombre)?>' />
						<?php }else{ ?>
						<input type="text" name="ANombres" id="ANombres" class="form-control disabled" value='<?=nvl($ANombre)?>' />
						<?php } ?>
					</div>
					<div class="col-lg-offset-3 col-lg-3">
						<button class="btn btn-primary pull-right" type="submit"> <i class="fa fa-search"></i> Buscar</button>
					</div>
				</div>
			</form>
		</div>	
	</div>	
</div>	
<div class="row">
	<div class="col-lg-12">
		<?php muestra_mensaje(); ?>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<div class="pull-right">
				<?php if( is_permitido(null,'PERCEPCIONES','IMPORT') ){ ?>
					<a href="<?php echo base_url('Documentacion/formato_no_grabables.csv'); ?>">Descargar Plantilla&nbsp;&nbsp;&nbsp;</a>
					<button	class="btn btn-primary" 
						data-target="#modal_cargar" data-toggle="modal">
						<i class="fa fa-file-excel-o"></i> Cargar Archivo 
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
								<th>Folio</th>
								<th>Servidor</th>
								<th>Departamento</th>
								<th>Fecha</th>
								<th>No. Descargas</th>
								<th>Estatus</th>
								<th width="130px">Acción</th> 
							</tr>	
						</thead>
						<tbody>
							<?php 
								foreach($percepciones as $key => $list){
									$PDClave_skip = $this->encrypt->encode($list['PDClave']);						
								?>
								<tr>
									<td class="text-left"><?php echo folio($list['PDClave']); ?></td> 
									<td class="text-left"><?php echo $list['PDNombre']; ?></td>
									<td class="text-left"><?php echo $list['PDDepartamento']; ?></td>
									<td class="text-left"><?php echo $list['PDFecha_i']." al ".$list['PDFecha_f']; ?></td>
									<td class="text-left"><?php echo $list['PDDownload']; ?></td>	
									<td class="text-left text-center">
										<?php if($list['PDNotificacion']){ ?>
										<span class='text-info' title='Visto'><i class="fa fa-eye fa-2x"></i></span>
										<?php }else{ ?>
										<span class='text-danger' title='No Visto'><i class="fa fa-eye-slash  fa-2x"></i></span>
										<?php } ?>
									</td>
									<td>
										<?php if( is_permitido(null,'percepciones','download') ){ ?>
											<a href="<?php echo base_url("percepciones/download/$PDClave_skip"); ?>" target="_blanck" class="btn btn-default btn-sm"><i class="fa fa-download"></i> Descargar</a>
										<?php } ?>										
										<?php if( is_permitido(null,'percepciones','delete') ){ ?>
											<a href="<?php echo base_url("percepciones/delete/$PDClave_skip"); ?>" class="btn btn-default btn-sm delete"><i class="fa fa-times"></i> Borrar</a>
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



<div class="modal inmodal" id="modal_cargar" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" >
		<div class="modal-content animated flipInY">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
				<h6 class="modal-title"><i class="fa fa-dollar"></i>&nbsp;&nbsp;CARGAR ARCHIVO CSV</h6><div class="border-bottom"><br /></div>
				
				<div id="error"></div>
				
				<form action="<?php echo base_url('percepciones/import'); ?>" method="post" name="upload_excel" enctype="multipart/form-data">
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Archivo: <em>*</em></label>
					<div class="col-lg-9">
						<input type="file" name="file" id="file" accept=".csv">
					</div>
				</div>				
				<div class="loading"></div>
				<div class="form-group">
					<div class="col-lg-offset-3 col-lg-9">
						<button type="submit" name="import" class="btn btn-primary pull-right"> <i class="fa fa-save"></i> Guardar</button>
					</div>
				</div>
				</form>
				
			</div>
		</div>
	</div>
</div>
<div class="modal inmodal" id="modal_archivo" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" >
		<div class="modal-content animated flipInY">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
				<h6 class="modal-title">&nbsp;&nbsp;ATENDER SOLICITUD</h6><div class="border-bottom"><br /></div>
				
				<div id="error"></div>
				
				<?php echo form_open('percepciones/update', array('name' => 'FormUsuarios', 'id' => 'FormUsuarios', 'role' => 'form', 'class' => 'form-horizontal panel-body')); ?>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Clave Servidor: </label>
					<div class="col-lg-9">
						<input type="text" id='PEUsuario' value="" maxlength='150' 
						class="form-control uppercase disabled" />
					</div>
				</div>	
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Solicitud: </label>
					<div class="col-lg-9">
						<textarea id='PESolicitud' class='form-control disabled'></textarea>
					</div>
				</div>	
				<div class="form-group">
					<label class="col-lg-3 control-label" for=""></label>
					<div class="col-lg-9">
						<?php echo forma_archivo('PERuta', nvl($PERuta), 'Cargar PDF');  ?>
					</div>
				</div>	
				
				<div class="loading"></div>
				<div class="form-group">
					<div class="col-lg-offset-3 col-lg-9">
						<input type="hidden" name='PEClave_skip' id='PEClave_skip' />
						<button type="submit" class="btn btn-primary pull-right save"> <i class="fa fa-save"></i> Guardar</button>
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
	
		/* Ventana modal */
		$(document).on("click", ".open", function () {
			var PEClave_skip = $(this).data('peclave_skip');
			var PESolicitud = $(this).data('pesolicitud');
			var PEUsuario = $(this).data('peusuario');
			$(".modal-header #PEClave_skip").val( PEClave_skip );
			$(".modal-header #PESolicitud").val( PESolicitud );
			$(".modal-header #PEUsuario").val( PEUsuario );
		});
		
		//Mostrar popup para cargar archivos al servidor
		$('.upload_file').colorbox({width:'600px', height:'430px', scrolling:false, iframe:true, overlayClose:false});
		
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
					$(win.document.body).find('table')
					.addClass('compact')
					.css('font-size', 'inherit');
				}
			}
			]
		});		
		
	});
</script>