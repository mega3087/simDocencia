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

<div class="loading"></div>
<div class="msg"></div>

<div class="row">
	<div class="col-lg-12">
		<?php muestra_mensaje(); ?>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<label class="col-lg-1 control-label" style="text-align: right;">Centro Escolar:</label>
				<div class="col-lg-1">
					<select name="plantel" id="plantel" class="form-control" <?php if( $CPLTipo == '35' || $CPLTipo == '36') echo"disabled";?>>
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
						<?php foreach($materias as $key => $listMat) { ?>
						<option value="<?= $listMat['id_materia']; ?>" <?php if($listMat['id_materia'] == $idMat) echo"selected"; ?>><?=$listMat['materia'].' '.$listMat['modulo']?></option>
						<?php  } ?>
					</select>
				</div>
				<div class="col-lg-1">
					<button type="button" class="btn btn-success pull-right buscar"> <i class="fa fa-search"></i> Buscar</button>
				</div>
				<?php if (is_permitido(null,'profesiograma','save')) { ?>
				<div class="pull-right">
					<button 
					class="btn btn-primary open"
					data-target="#modal_Registrar" 
					data-toggle="modal"
					data-ucplclave="<?php echo $CPLTipo; ?>"
					data-unci_usuario_skip=""
					><i class="fa fa-plus"></i> Agregar Licenciatura</button>
				</div>
				<?php } ?>
				<h3>&nbsp;</h3>
			</div> 
			<div id="loadMat"></div>
			<div class="ibox-content">
				<div class="table-responsive" id="mostrarBusqueda">
					<input type="hidden" name="plantelId" id="plantelId" value="<?= $CPLTipo; ?>">
					<table class="table table-striped table-bordered table-hover dataTables-example dataTable">
						<thead>
							<tr>
								<th>#</th>
								<th>Grado de Estudios</th>
								<?php if (is_permitido(null,'profesiograma','save')) { ?>
								<th></th>
								<?php } ?>
								<th>Materia</th>
								<th class="text-center">Semestre</th>
								<th width="130px">Centro Escolar </th>
								<?php if (is_permitido(null,'profesiograma','save')) { ?>
								<th class="text-center" width="130px">Acción</th>
								<th class="text-center" width="130px">Acción</th>
								<?php } ?>
							</tr>	
						</thead>
						<tbody>
							<?php
								$i = 1;
								foreach ($lics as $l => $listLics) { 
								//$contar = count($listLics['lics']) + 1; ?>
									<tr>
										<td class="text-left"><?= $i; ?></td> 
										<td class="text-left"><?php echo $listLics['LGradoEstudio'].' en '.$listLics['Licenciatura']; ?></td>
										<?php if (is_permitido(null,'profesiograma','save')) { ?>
										<td class="text-left">
											<button type="button" class="btn btn-outline btn-info btn-xs openEditar" 
												data-target="#modal_Editar"
												data-uidlicenciatura="<?php echo $listLics['IdLicenciatura']; ?>"
												data-ulgradoestudios="<?php echo $listLics['LIdentificador']; ?>"
												data-ulicenciatura="<?php echo $listLics['Licenciatura']; ?>"
												data-toggle="modal">
												<i class='fa fa-pencil'></i> Editar</button>
										</td>
										<?php } ?>
										<td>
										<table style="border:0px">
											<?php foreach ($listLics['materias'] as $m => $listMat) { ?>
												<tr style="border:0px"><td style="border:0px"><?= $listMat['materia']; ?></td></tr>
											<?php } ?>
										</table>
										</td>
										<td class="text-center">
											<table style="border:0px">
												<?php foreach ($listLics['materias'] as $m => $listMat) { ?>
													<tr style="border:0px"><td style="border:0px"><?= $listMat['semmat']; ?></td></tr>
												<?php } ?>
											</table>
										</td>
										<td>
											<table style="border:0px">
												<?php foreach ($listLics['materias'] as $m => $listMat) { ?>
													<tr style="border:0px"><td style="border:0px"><?php if($listMat['plan_estudio'] == '1') { echo 'Plantel'; } else { echo 'CEMSAD'; } ?></td></tr>
												<?php } ?>
											</table>
										</td>
										<?php if (is_permitido(null,'profesiograma','save')) { ?>
										<td class="text-center">
											<table style="border:0px">
											<?php foreach ($listLics['materias'] as $m => $listMat) { ?>
												<tr style="border:0px"><td style="border:0px">
												<a><span class="badge badge-danger"  onclick="quitarMateria('<?php echo $listLics['IdLicenciatura'];?>','<?php echo $listMat['id_materia'];?>')"><i class='fa fa-trash'></i> Quitar Materia</span></a>
												</td></tr>
												<?php } ?>
											</table>
										</td>
										<td class="text-left">
											<button type="button" class="btn btn-outline btn-primary btn-xs agregarMaterias"
												data-target="#modal_Agregar"
												data-uidlicenciatura="<?php echo $listLics['IdLicenciatura']; ?>"
												data-ulgradoestudios="<?php echo $listLics['LIdentificador']; ?>"
												data-ulicenciatura="<?php echo $listLics['Licenciatura']; ?>"
												data-toggle="modal">
											<i class='fa fa-plus'></i> Agregar Materias</button>
										</td>									
										<?php  } ?>
									</tr>
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
								<?php echo form_open('profesiograma/saveLic', array('name' => 'FormsaveLic', 'id' => 'FormsaveLic', 'role' => 'form', 'class' => 'form-horizontal panel-body')); ?>
								
								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Grado de Estudio: <em>*</em></label>
									<div class="col-lg-9">
										<select name="UGradoEstudio" id="UGradoEstudio" class="form-control">
											<option value="">- Grado Estudio -</option>
											<?php foreach ($GradoEstudio as $g => $listG) { ?>
												<option value="<?= $listG['id_gradoestudios']?>"><?= $listG['grado_estudios']?></option>	
											<?php } ?>s
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
									<label class="col-lg-3 control-label" for="">Centro Escolar: <em>*</em></label>
									<div class="col-lg-9">
									<select name="UPlanEstudio" id="UPlanEstudio" class="form-control">
										<option value="">- Seleccionar -</option>
										<option value="0">Ambos</option>
										<option value="1">Plantel</option>
										<option value="2">CEMSAD</option>
									</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Semestre: <em>*</em></label>
									<div class="col-lg-9">
										<select name="SemestreMat[]" id="SemestreMat" class="form-control MatSem chosen-select" multiple="" data-placeholder="Seleccionar Semestre">
											<option value="1" style="display:block;">1</option>
											<option value="2" style="display:block;">2</option>
											<option value="3" style="display:block;">3</option>
											<option value="4" style="display:block;">4</option>
											<option value="5" style="display:block;">5</option>
											<option value="6" style="display:block;">6</option>
										</select>
									</div>
								</div>

								<div class="form-group resultMaterias">
								</div>

								<div class="form-group">
									<div class="loadingSave"></div>
									<div class="msgSave"></div>
									<div id="errorSave"></div>
								</div>
								
								<div class="modal-footer">
									<a href="#" data-dismiss="modal" class="btn btn-danger cerrar">Cerrar</a>
									<button type="button" class="btn btn-primary pull-right guardarLic"> <i class="fa fa-save"></i> Guardar</button>
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
								<?php echo form_open('profesiograma/update', array('name' => 'FormUpdate', 'id' => 'FormUpdate', 'role' => 'form', 'class' => 'form-horizontal panel-body')); ?>
								<input type="hidden" name="IIdLicenciatura" id="IIdLicenciatura" value="">
 								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Grado de Estudio: <em>*</em></label>
									<div class="col-lg-9">
										<select name="UGradoEstudio" id="UGradoEstudio" class="form-control">
											<option value="">- Grado Estudio -</option>
											<?php foreach ($GradoEstudio as $g => $listG) { ?>
												<option value="<?= $listG['id_gradoestudios']?>"><?= $listG['grado_estudios']?></option>	
											<?php } ?>s
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
									<div class="loadingUpdate"></div>
									<div class="msgUpdate"></div>
									<div id="errorUpdate"></div>
								</div>

								<div class="modal-footer">
									<a href="#" data-dismiss="modal" class="btn btn-danger cerrar">Cerrar</a>
									<button type="button" class="btn btn-primary pull-right editarLic"> <i class="fa fa-save"></i> Guardar</button>
								</div>
								<?php echo form_close(); ?>								
							</div>
						</div>
					</div>
				</div>

				<!--Ventana modal Agregar Materias-->
				<div class="modal inmodal" id="modal_Agregar" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-lg" >
						<div class="modal-content animated flipInY">
							
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
								<h6 class="modal-title"><i class="fa fa-user"></i>&nbsp;&nbsp; Agregar Materias</h6><div class="border-bottom"><br /></div>
								<?php echo form_open('profesiograma/agregarMaterias', array('name' => 'FormAgregarMat', 'id' => 'FormAgregarMat', 'role' => 'form', 'class' => 'form-horizontal panel-body')); ?>
								<input type="hidden" name="IIdLicenciatura" id="IIdLicenciaturas" value="">

								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Grado de Estudio: <em>*</em></label>
									<div class="col-lg-9">
										<select name="UGradoEstudio" id="UGradoEstudios" class="form-control disabled">
											<option value="">- Grado Estudio -</option>
											<?php foreach ($GradoEstudio as $g => $listG) { ?>
												<option value="<?= $listG['id_gradoestudios']?>"><?= $listG['grado_estudios']?></option>	
											<?php } ?>s
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-lg-3 control-label">Licenciatura: <em>*</em></label>
									<div class="col-lg-9">
									<input type="text" id="ULicenciaturas" name="ULicenciatura " value="" maxlength='150' class="form-control disabled" />
									</div>
								</div>

								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Centro Escolar: <em>*</em></label>
									<div class="col-lg-9">
									<select name="UPlanEstudio" id="UPlanEstudios" class="form-control">
										<option value="">- Seleccionar -</option>
										<option value="0">Ambos</option>
										<option value="1">Plantel</option>
										<option value="2">CEMSAD</option>
									</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Semestre: <em>*</em></label>
									<div class="col-lg-9">
										<select name="SemestreMat[]" id="SemestreMats" class="form-control MatSemestre chosen-select" multiple="" data-placeholder="Seleccionar">
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
										</select>
									</div>
								</div>

								<div class="form-group resultMaterias">
								</div>

								<div class="form-group">
									<div class="loadingSaveMat"></div>
									<div class="msgSaveMat"></div>
									<div id="errorSaveMat"></div>
								</div>
								
								<div class="modal-footer">
									<a href="#" data-dismiss="modal" class="btn btn-danger cerrar">Cerrar</a>
									<button type="button" class="btn btn-primary pull-right guardarMaterias"> <i class="fa fa-save"></i> Guardar</button>
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
			$(".modal-header #IIdLicenciatura").val( $(this).data('uidlicenciatura') );
			$(".modal-header #UGradoEstudio").val( $(this).data('ulgradoestudios') );
			$(".modal-header #ULicenciatura").val( $(this).data('ulicenciatura') );
			
		});

		$(document).on("click", ".agregarMaterias", function () {
			$(".modal-header #IIdLicenciaturas").val( $(this).data('uidlicenciatura') );
			$(".modal-header #UGradoEstudios").val( $(this).data('ulgradoestudios') );
			$(".modal-header #ULicenciaturas").val( $(this).data('ulicenciatura') );
			
		});
		
		$('.chosen-select').chosen();  
		
	});
</script>
<script type="text/javascript">

$("#semmat").on("change", function(){
	var sem = document.getElementById("semmat").value;
	var plantel = document.getElementById("plantel").value;
	
	$.ajax({
	    type: "POST",
	    url: "<?php echo base_url("profesiograma/mostrarMat_skip"); ?>",
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
	    url: "<?php echo base_url("profesiograma/mostrarBusqueda_skip"); ?>",
	    data: {plantel : plantel, sem : sem, materia : materia},
	    dataType: "html",
	    beforeSend: function(){
	        //carga spinner
	        $(".loadMat").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
	    },
	    success: function(data){
	        $("#mostrarBusqueda").empty();
	        $("#mostrarBusqueda").append(data);  
	        $("#loadMat").html("");
	    }
	});
});

$(".MatSem").on("change", function(){
	var planEstudio = document.getElementById("UPlanEstudio").value;
	var semestre = document.getElementById('SemestreMat');
	var semestre = [...semestre.selectedOptions].map(option => option.value);
	
	$.ajax({
	    type: "POST",
	    url: "<?php echo base_url("profesiograma/mostrarMaterias_skip"); ?>",
	    data: {semestre : semestre, planEstudio : planEstudio},
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

$(".MatSemestre").on("change", function(){
	var semestre = document.getElementById('SemestreMats');
	var semestre = [...semestre.selectedOptions].map(option => option.value);
	
	$.ajax({
	    type: "POST",
	    url: "<?php echo base_url("profesiograma/materias_skip"); ?>",
	    data: {IIdLicenciatura : document.getElementById("IIdLicenciaturas").value, semestre : semestre, planEstudio : document.getElementById("UPlanEstudios").value},
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

//Guardar nueva Licenciatura
$(".guardarLic").click(function() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("profesiograma/save"); ?>",
            data: $(this.form).serialize(),
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loadingSave").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data){
                var data = data.split("::");
                if(data[0]==' OK'){
                    $(".msgSave").empty();
                    $(".msgSave").append(data[1]);
                    $('#FormsaveLic')[0].reset();
                    $(".loadingSave").html("");
					location.reload();
                } else {
                    $("#errorSave").empty();
                    $("#errorSave").append(data);  
					$('#FormsaveLic')[0].reset(); 
                    $(".loadingSave").html(""); 
                }
                
            }
        });
    });//----->fin

	//Editar Licenciaturas
	$(".editarLic").click(function() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("profesiograma/update"); ?>",
            data: $(this.form).serialize(),
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loadingUpdate").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data){
                var data = data.split("::");
				if(data[0]==' OK'){
					$(".msgUpdate").empty();
                    $(".msgUpdate").append(data[1]);
					$('#FormUpdate')[0].reset();
                    $(".loadingUpdate").html("");
					location.reload();
                } else {
					$("#errorUpdate").empty();
                    $("#errorUpdate").append(data);   
					$('#FormsaveLic')[0].reset();
                    $(".loadingUpdate").html(""); 
                }
                
            }
        });
    });//----->fin

	//Guardar nueva Licenciatura
$(".guardarMaterias").click(function() {
	    $.ajax({
            type: "POST",
            url: "<?php echo base_url("profesiograma/save_materias_skip"); ?>",
            data: $(this.form).serialize(),
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loadingSave").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data){
                var data = data.split("::");
				if(data[1] == 'OK'){
                    $(".msgSaveMat").empty();
                    $(".msgSaveMat").append(data[0]);
					$("#UPlanEstudios").val('');
					$('#SemestreMats').val('').trigger('change');
					$('#SemestreMats').val('').trigger('chosen:updated');
                    $(".loadingSaveMat").html("");
					location.reload();
                } else {
                    $("#errorSaveMat").empty();
                    $("#errorSaveMat").append(data);  
                    $(".loadingSaveMat").html(""); 
                }
                
            }
        });
    });//----->fin

	function quitarMateria(idLic, idMateria) { 
		
		bootbox.confirm({
			message: "<div class='text-center'>¿Realmente desea quitar el Materia?</div>",
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
						url: "<?php echo base_url("profesiograma/delete"); ?>",
						data: {idLic: idLic, idMateria: idMateria},
						dataType: "html",
						beforeSend: function(){
							//carga spinner
							$(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
						},
						success: function(data){
							var data = data.split("::");
							
							if(data[1] == 'OK'){
								$(".msg").empty();
								$(".msg").append(data[0]);  
								$(".loading").html("");
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
	}

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