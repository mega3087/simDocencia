<link href="<?php echo base_url('assets/inspinia/css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/chosen/chosen.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/datapicker/datepicker3.css'); ?>" rel="stylesheet" />
<!--color boox-->
<script type="text/javascript" src="<?php echo base_url("assets/colorbox/jquery.colorbox-min.js") ?>"></script>
<link media="screen" rel="stylesheet" href="<?php echo base_url("assets/colorbox/colorbox.css") ?>" />
<div class="row">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
			<h3>Profesiograma</h3>
		</div>
	</div>
</div>

<div class="row" id="chat">
	<div class="col-lg-12">
		<?php muestra_mensaje(); ?>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<label class="col-lg-1 control-label" style="text-align: right;">Plantel:</label>
				<div class="col-lg-1">
					<select name="plantel" id="plantel" class="form-control" <?php if( $CPLTipo != '') echo"disabled";?>>
						<option <?php if( $CPLTipo == '37' ) echo"selected";?> value="37">Todos</option>
						<option <?php if( $CPLTipo == '35' ) echo"selected";?> value="35">Plantel</option>
						<option <?php if( $CPLTipo == '36' ) echo"selected";?> value="36">CEMSAD</option>
					</select>
				</div>

				<label class="col-lg-1 control-label" style="text-align: right;">Semestre:</label>
				<div class="col-lg-1">
					<select name="semmat" id="semmat" class="form-control">
						<option selected value="">Todos</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
					</select>
				</div>
				
				<label class="col-lg-1 control-label" style="text-align: right;">Materia:</label>
				<div class="col-lg-3" id="mostrarMaterias">
					<select name="materia" id="idMateria" class="form-control">
						<option selected value="">Todos</option>
						<?php foreach($materias as $key => $listMat){ ?>
						<option value="<?= $listMat['id_materia']; ?>" <?php if($listMat['id_materia'] == $idMat) echo"selected"; ?>><?=$listMat['materia'].' '.$listMat['modulo']?></option>
						<?php  } ?>
					</select>
				</div>
				<div class="col-lg-1">
					<button type="button" class="btn btn-success pull-right buscar"> <i class="fa fa-search"></i> Buscar</button>
				</div>

				<div class="pull-right">
					<button 
					class="btn btn-primary open"
					data-target="#modal_Registrar" 
					data-toggle="modal"
					data-ucplclave="<?php echo $CPLTipo; ?>"
					data-unci_usuario_skip=""
					><i class="fa fa-plus"></i> Agregar Licenciatura</button>
				</div>
				<h3>&nbsp;</h3>
			</div> 
			<div id="loadMat"></div>
			<div class="ibox-content">
				<div class="table-responsive">
					<input type="hidden" name="plantelId" id="plantelId" value="<?= $CPLTipo; ?>">
					<table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="mostrarBusqueda" >
						<thead>
							<tr>
								<th>#</th>
								<th>Materia</th>
								<th>Semestre</th>
								<th>Licenciatura(s) </th>
								<th width="130px">Acción</th>
							</tr>	
						</thead>
						<tbody>
							<?php
								foreach ($materias as $y => $mat) { 
								$contar = count($mat['lics']) + 1; 
								$i = 1;
								foreach ($mat['lics'] as $p => $prof) { ?>								
									<tr>
										<td class="text-left"><?= $i; ?></td> 
										<td class="text-left"><?php echo $mat['materia'].' '.$mat['modulo']; ?></td>
										<td class="text-left"><?= $mat['semmat']; ?></td>
										<td class="text-left"><?php echo $prof['LGradoEstudio'].' en '.$prof['Licenciatura']; ?></td>
										<td class="text-center">
											<button class="btn btn-default btn-sm openEditar" 
												data-target="#modal_Editar"
												data-uidmateria="<?php echo $mat['id_materia']; ?>"
												data-umaterias="<?php echo $mat['materia']; ?>"
												data-gestudio="<?php echo $prof['LGradoEstudio']; ?>"
												data-uidlicenciatura="<?php echo $prof['IdLicenciatura']; ?>"
												data-ulicenciatura="<?php echo $prof['Licenciatura']; ?>"
												data-usemmat="<?php echo $mat['semmat']; ?>"
												data-toggle="modal">
												<i class="fa fa-pencil"></i> Editar
											</button>
										</td>										
									</tr>
								<?php } ?>
							<?php $i++; } ?>
						</tbody>
					</table>
				</div>
			
				<!--Ventana modal Licenciatura Agregar-->
				<div class="modal inmodal" id="modal_Registrar" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-lg" >
						<div class="modal-content animated flipInY">
							
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
								<h6 class="modal-title"><i class="fa fa-user"></i>&nbsp;&nbsp; Registrar Licenciatura</h6><div class="border-bottom"><br /></div>
								<?php echo form_open('profesiograma/Registrar', array('name' => 'FormRegistrarLics', 'id' => 'FormRegistrarLics', 'role' => 'form', 'class' => 'form-horizontal panel-body')); ?>
								
								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Grado de Estudio: <em>*</em></label>
									<div class="col-lg-9">
										<select name="UGradoEstudio" id="UGradoEstudio" class="form-control">
											<option value="">- Grado Estudio -</option>
											<option value="Certificaciones">Certificaciones</option>
											<option value="Ingeniería">Ingeniería</option>
											<option value="Licenciatura">Licenciatura</option>
											<option value="Perfil">Perfil</option>
											<option value="Posgrado">Posgrado</option>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-lg-3 control-label">Licenciatura: <em>*</em></label>
									<div class="col-lg-9">
									<input type="text" id="ULicenciatura" name="ULicenciatura " value="" maxlength='150' class="form-control" />
									</div>
								</div>

								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Semestre: <em>*</em></label>
									<div class="col-lg-9">
										<select name="SemestreMat" id="SemestreMat" class="form-control MatSem">
											<option value="">- Semestre -</option>
											<option value="1" style="display:block;">1</option>
											<option value="2" style="display:block;">2</option>
											<option value="3" style="display:block;">3</option>
											<option value="4" style="display:block;">4</option>
											<option value="5" style="display:block;">5</option>
											<option value="6" style="display:block;">6</option>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Materia: <em>*</em></label>
									<div class="col-lg-9 resultMaterias">
										<select name="materiaSem" id="UIdMateria" class="form-control">
											<option value="">- Seleccionar Materia -</option>
											<<?php foreach($materias as $key => $listMat){ ?>
											<option value="<?= $listMat['id_materia']; ?>" <?php if($listMat['id_materia'] == $idMat) echo"selected"; ?>><?=$listMat['materia'].' '.$listMat['modulo']; ?></option>
											<?php  } ?>
										</select>
									</div>
								</div>

								<div class="msgRegistrar"></div>
								<!--<div class="loadingRegistrar"></div>-->
								
								<div class="modal-footer">
									<a href="#" data-dismiss="modal" class="btn btn-danger cerrar">Cerrar</a>
									<button type="button" class="btn btn-primary pull-right guardar"> <i class="fa fa-save"></i> Agregar</button>
								</div>
								<?php echo form_close(); ?>
							</div>
						</div>
					</div>
				</div>

				<!--Ventana modal Licenciatura Editar-->				
				<div class="modal inmodal" id="modal_Editar" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-lg" >
						<div class="modal-content animated flipInY">
							
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
								<h6 class="modal-title"><i class="fa fa-user"></i>&nbsp;&nbsp; Editar Licenciatura</h6><div class="border-bottom"><br /></div>
								<?php echo form_open('profesiograma/editarLics', array('name' => 'FormeditarLics', 'id' => 'FormeditarLics', 'role' => 'form', 'class' => 'form-horizontal panel-body')); ?>
								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Grado de Estudio: <em>*</em></label>
									<div class="col-lg-9">
										<select name="UGradoEstudio" id="UGradoEstudio" class="form-control">
											<option value="">- Grado Estudio -</option>
											<option value="Certificacines">Certificacines</option>
											<option value="Ingeniería">Ingeniería</option>
											<option value="Licenciatura">Licenciatura</option>
											<option value="Perfil">Perfil</option>
											<option value="Posgrado">Posgrado</option>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-lg-3 control-label">Licenciatura: <em>*</em></label>
									<div class="col-lg-9">
									<input type="text" id="ULicenciatura" name="ULicenciatura " value="" maxlength='150' class="form-control" />
									</div>
								</div>

								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Semestre: <em>*</em></label>
									<div class="col-lg-9">
										<select name="SemestreMat" id="SemestreMat" class="form-control" disabled>
											<option value="">- Semestre -</option>
											<option value="1" style="display:block;">1</option>
											<option value="2" style="display:block;">2</option>
											<option value="3" style="display:block;">3</option>
											<option value="4" style="display:block;">4</option>
											<option value="5" style="display:block;">5</option>
											<option value="6" style="display:block;">6</option>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Materia: <em>*</em></label>
									<div class="col-lg-9 resultMaterias">
										<select name="materiaSem" id="UIdMateria" class="form-control" disabled>
											<option value="">- Seleccionar Materia -</option>
											<<?php foreach($materias as $key => $listMat){ ?>
											<option value="<?= $listMat['id_materia']; ?>" <?php if($listMat['id_materia'] == $idMat) echo"selected"; ?>><?=$listMat['materia'].' '.$listMat['modulo'];?></option>
											<?php  } ?>
										</select>
									</div>
								</div>

								<div class="modal-footer">
									<a href="#" data-dismiss="modal" class="btn btn-danger cerrar">Cerrar</a>
									<button type="button" class="btn btn-primary pull-right guardar"> <i class="fa fa-save"></i> Guardar</button>
								</div>
								<?php echo form_close(); ?>								
							</div>
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

<script src="<?php echo base_url('assets/inspinia/js/plugins/bootbox.all.min.js'); ?>"></script>

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
		
		/* Ventana modal */
		$(document).on("click", ".openEditar", function () {
			var sem = $(this).data('usemmat');
			
			$(".modal-header #UIdMateria").val( $(this).data('uidmateria') );
			$(".modal-header #materiaSem").val( $(this).data('umaterias') );
			$(".modal-header #IIdLicenciatura").val( $(this).data('uidlicenciatura') );
			$(".modal-header #UGradoEstudio").val( $(this).data('gestudio') );
			$(".modal-header #ULicenciatura").val( $(this).data('ulicenciatura') );
			$(".modal-header #SemestreMat").val( $(this).data('usemmat') );
			
		});


	    /*Borrar docente del Plantel o Centro
		$(".quitarDocente").click(function(e) {
			var UNCI_usuario_skip = $(this).val();
			var PlantelId = document.getElementById("plantelId").value;
			bootbox.confirm({
			    message: "<div class='text-center'>¿Realmente desea quitar el Docente del Plantel?</div>",
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
							url: "<?php echo base_url("docente/quitarDocente"); ?>",
							data: {UNCI_usuario_skip: UNCI_usuario_skip, PlantelId: PlantelId},
							dataType: "html",
							beforeSend: function(){
								//carga spinner
								$(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
							},
							success: function(data){
								if(data==' OK'){
									location.reload();
								} else {
									$(".msg").empty();
				                    $(".msg").append(data);  
				                    $(".loading").html("");	
								}
							}
						});
			    	}
			    }
			});
		});
		//Fin Borrar Docente del Plantel o Centro
		
		/*obtenemos la altura del documento Para el chat 
		var altura = $(document).height();
		 
		$("#chat").click(function(){
		    $("html, body").animate({scrollTop:altura+"px"});
		});*/

	});
</script>
<script type="text/javascript">
$("#semmat").on("change", function(){
	var sem = document.getElementById("semmat").value;
	var plantel = document.getElementById("plantel").value;
	
	$.ajax({
	    type: "POST",
	    url: "<?php echo base_url("profesiograma/mostrarMat"); ?>",
	    data: {sem : sem, plantel : plantel},
	    dataType: "html",
	    beforeSend: function(){
	        //carga spinner
	        $(".loadingLic").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
	    },
	    success: function(data){
	        $("#mostrarMaterias").empty();
	        $("#mostrarMaterias").append(data);  
	        $("#loadMat").html("");
	    }
	});
});	

$(".buscar").click(function() {
	var plantel = document.getElementById("plantel").value;
	var sem = document.getElementById("semmat").value;
	var materia = document.getElementById("idMateria").value;
	    	   	
	$.ajax({
	    type: "POST",
	    url: "<?php echo base_url("profesiograma/mostrarBusqueda"); ?>",
	    data: {plantel : plantel, sem : sem, materia : materia},
	    dataType: "html",
	    beforeSend: function(){
	        //carga spinner
	        $(".loadingBusqueda").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
	    },
	    success: function(data){
	        $("#mostrarBusqueda").empty();
	        $("#mostrarBusqueda").append(data);  
	        $("#loadingBusqueda").html("");
	    }
	});
});

$(".MatSem").on("change", function(){
	var sem = document.getElementById("SemestreMat").value;
	
	$.ajax({
	    type: "POST",
	    url: "<?php echo base_url("profesiograma/mostrarMaterias"); ?>",
	    data: {sem : sem},
	    dataType: "html",
	    beforeSend: function(){
	        //carga spinner
	        $(".loadingLic").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
	    },
	    success: function(data){
	        $(".resultMaterias").empty();
	        $(".resultMaterias").append(data);  
	        $(".loadingLic").html("");
	    }
	});
});	

$('#modal_Registrar').on('show.bs.modal', function (event) {
	$("#modal_Registrar input").val("");
	$("#modal_Registrar textarea").val("");
	$("#modal_Registrar select").val("");
	$("#modal_Registrar input[type='checkbox']").prop('checked', false).change();
});

$('#modal_Editar').on('show.bs.modal', function (event) {
	$("#modal_Editar input").val("");
	$("#modal_Editar textarea").val("");
	$("#modal_Editar select").val("");
	$("#modal_Editar input[type='checkbox']").prop('checked', false).change();
});
</script>