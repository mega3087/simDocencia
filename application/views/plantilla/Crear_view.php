<link href="<?php echo base_url('assets/inspinia/css/plugins/steps/jquery.steps.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/iCheck/custom.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/chosen/chosen.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/datapicker/datepicker3.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/inspinia/css/plugins/clockpicker/clockpicker.css'); ?>" rel="stylesheet" />	

<link href="<?php echo base_url('assets/inspinia/css/bootstrap.min.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/font-awesome/css/font-awesome.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/animate.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/jasny/jasny-bootstrap.min.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/codemirror/codemirror.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/style.css');?>" rel="stylesheet">

<link href="<?php echo base_url('assets/inspinia/css/plugins/dropzone/basic.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/dropzone/dropzone.css'); ?>" rel="stylesheet">

<link href="<?php echo base_url('assets/inspinia/css/plugins/select2/select2.min.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/css/plugins/chosen/bootstrap-chosen.css'); ?>" rel="stylesheet">
<div class="row">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
			<h3><?php echo $titulo; $PClave_skip = $this->encrypt->encode($planteles[0]['CPLClave']);?></h3> 
			<h3><?php if ($planteles[0]['CPLTipo'] == '35') { echo "PLANTEL: "; } else { echo "CEMSAD: "; }  ?><?= $planteles[0]['CPLNombre']; ?></h3> 
		</div>
	</div>
</div>
	<div class="row">
		<div class="col-lg-12">
			<?php muestra_mensaje(); ?>
			<div id="loading"></div>
			<div id="result"></div>			
			    <div class="ibox float-e-margins">
               		<div class="row">
						<div class="col-lg-12">
							<div class="ibox">
								<div class="ibox-title">
									<h2>GENERAR PLANTILLA</h2>
								</div>
								<div class="ibox-content">
                                <form action="<?php echo base_url("NuevaPlantilla/save"); ?>" name="form" id="form" method="POST" class="wizard-big form-horizontal" enctype="multipart/form-data" >
                                <input type="hidden" name="plantel" id="plantel" value="<?= $plantel; ?>" />    
                                <input type="hidden" name="FClave_skip" id="FClave_skip" value="<?= nvl($usuario); ?>"/>
                                <h1>USUARIOS</h1>
                                    <fieldset>
                                    <div class="col-lg-6"><h2>Usuarios del <?php if ($planteles[0]['CPLTipo'] == '35') { echo "Plantel"; } else { echo "CEMSAD"; }  ?></h2></div>
                                    <div class="col-lg-6">
                                    <div class="col-lg-3 text-left"><label>Usuario Nuevo: </label> <!--<input type="radio" name="nuevo" id="nuevo" value="Si">--></div>
                                    <div class="col-lg-1"><input type="radio" id="usernew" name="usernew" value="Si"><label>Si</label></div>
                                    <div class="col-lg-1"><input type="radio" id="usernew" name="usernew" value="No" checked><label>No</label></div>
                                    </div>
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover dataTables-example dataTable" >
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Docente</th>
                                                            <th>Correo Electrónico</th>
                                                            <th>RFC</th>
                                                            <th>CURP</th>
                                                            <th width="130px">Seleccionar</th>
                                                        </tr>	
                                                    </thead>
                                                    <tbody>
                                                    <?php 
                                                        $i = 1;
                                                        foreach($docentes as $key => $list){
                                                        
                                                        //$borrar = "<button type='button' value=".$UNCI_usuario_skip." class='btn btn-sm btn-danger quitarDocente'><i class='fa fa-trash'></i> Quitar</button>"; ?>
                                                            <tr>
                                                                <td class="text-center"><?php echo $i; ?></td> 
                                                                <td class="text-left"><?php echo $list['UNombre']." ".$list['UApellido_pat']." ".$list['UApellido_mat']; ?></td>
                                                                <td class="text-left"><?php echo $list['UCorreo_electronico']; ?></td>
                                                                <td class="text-left"><?php echo $list['URFC']; ?></td>
                                                                <td class="text-left"><?php echo $list['UCURP']; ?></td>								
                                                                <td class="text-center"><input type="checkbox" name="idUsuario" id="idUsuario<?php echo $list['UNCI_usuario'];?>" value="<?php echo $list['UNCI_usuario'];?>" class="only-one"></td>
                                                            </tr>
                                                    <?php $i++; } ?>
                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="text-center">
                                                    <div style="margin-top: 20px">
                                                        <i class="fa fa-sign-in" style="font-size: 180px;color: #e5e5e5 "></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>    
                                
                                <h1>DATOS DEL USUARIO</h1>
                                    <fieldset>
                                        <h2>Información del Usuario</h2>
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label>CURP.: <em>*</em></label>
                                                    <input id="UCURP" name="UCURP" value="<?php echo nvl($usuario['UCURP']); ?><?php echo nvl($fump['FCURP']); ?>" type="text" class="form-control "  minlength="18" maxlength="18" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Nombre(s) / Apellido Paterno / Apellido Materno: <em>*</em></label>
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <input id="UNombre" name="UNombre" value="" type="text" class="form-control ">
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <input id="UApellido_pat" name="UApellido_pat" value="" type="text" class="form-control ">
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <input id="UApellido_mat" name="UApellido_mat" value="" type="text" class="form-control ">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>R.F.C.: <em>*</em></label>
                                                    <input id="URFC" name="URFC" value="<?php echo nvl($usuario['URFC']); ?><?php echo nvl($fump['URFC']); ?>" type="text" class="form-control "  minlength="13" maxlength="13" />
                                                </div>
                                                <div class="form-group" id="data_2">
                                                    <label>Fecha de Ingreso: <em>*</em></label>
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        <input type="text" class="form-control fecha" id="UFecha_ingreso" name="UFecha_ingreso" value="<?php echo fecha_format(nvl($usuario['UFecha_registro'])); ?><?php echo fecha_format(nvl($fump['UFecha_registro'])); ?>" minlength="10" maxlength="10">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="text-center">
                                                    <div style="margin-top: 20px">
                                                        <i class="fa fa-sign-in" style="font-size: 180px;color: #e5e5e5 "></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </fieldset>
                                        <h1>ESTUDIOS</h1>
                                        <fieldset>
                                            <h2>Grado de Estudios</h2>
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                            <label>Titulado<em>*</em></label> <input id="Titulado" name="Titulado" type="radio" value="Titulado" checked> 
                                                            </div>
                                                            <div class="col-lg-4">
                                                            <label>Pasante<em>*</em></label> <input id="Titulado" name="Titulado" type="radio" value="Pasante">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label>Nivel de Estudios: <em>*</em></label>
                                                        <select id="ULNivel_estudio" name="ULNivel_estudio" class="form-control MostrarCarreras required" >
                                                            <option value="">-Seleccionar-</option>
                                                            <?php foreach ($estudios as $e => $listEst) { ?>
                                                                <option value="<?= $listEst['LGradoEstudio'] ?>"><?= $listEst['LGradoEstudio'] ?></option>
                                                            <?php } ?> 
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label>Especialidad: <em>*</em></label>
                                                        <select class="select2_demo_3 form-control resultCarrera select2" name="ULLicenciatura" id="ULLicenciatura" style="width:100%">
                                                            <option value="">-Seleccionar-</option>
                                                            <option value=""></option>
                                                                <?php foreach ($carreras as $k => $listCar) { ?>
                                                                    <option value="<?php echo $listCar['IdLicenciatura']; ?>"><?php echo $listCar['Licenciatura']; ?></option>    
                                                                <?php } ?>
                                                        </select>
                                                    </div>                                                    

                                                    <div id="contentPasante">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                            <label>Documento Título Profesional: </label>
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                <span class="btn btn-primary btn-file"><span class="fileinput-new">Seleccionar Título</span><span class="fileinput-exists">Cambiar</span><input type="file" name="UPDocTitulo_file" id="UPDocTitulo_file" accept="application/pdf"></span>
                                                                <span class="fileinput-filename"></span>
                                                                <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                                                            </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                            <button type='button' class='btn btn-sm btn-danger douploadTitulo'> Subir Archivo</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                            <label>Documento Cédula Profesional: </label>
                                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                    <span class="btn btn-primary btn-file"><span class="fileinput-new">Seleccionar Cédula</span><span class="fileinput-exists">Cambiar</span><input type="file" name="UPDocCedula_file" id="UPDocCedula_file" accept="application/pdf"></span>
                                                                    <span class="fileinput-filename"></span>
                                                                    <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                            <button type='button' class='btn btn-sm btn-danger douploadCedula'> Subir Archivo</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <label>No. de Cédula Profesional: <em>*</em></label>
                                                                <input id="ULCedulaProf" name="ULCedulaProf" value="<?php echo nvl($usuario['ULCedulaProf']); ?><?php echo nvl($fump['UPCedulaProf']); ?>" type="text" class="form-control "  minlength="10" maxlength="10" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Tipo Nombramiento: <em>*</em></label>
                                                        <select name="ULNombramiento" id="ULNombramiento" class="form-control">
                                                            <option value="">- Nombramiento -</option>
                                                            <?php foreach($nombramiento as $key_n => $list_n){ ?>
                                                            <option value="<?=$list_n['PLClave']?>"><?=$list_n['PLPuesto']?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="loadingArchivo"></div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="text-center">
                                                        <div style="margin-top: 20px">
                                                            <i class="fa fa-sign-in" style="font-size: 180px;color: #e5e5e5 "></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        
                                        <h1>MATERIAS</h1>
                                        <fieldset>
                                            <h2>ASIGNACIÓN DE MATERIAS</h2>
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <div class="form-group">
                                                        <label>Semestre: <em>*</em></label>
                                                        <select name="GRSemestre" id="GRSemestre" class="form-control semLic">
                                                            <option value="">- Semestre -</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <h1>Finish</h1>
                                        <fieldset>
                                            <h2>Terms and Conditions</h2>
                                            <input id="acceptTerms" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms">I agree with the Terms and Conditions.</label>
                                        </fieldset>
                                    </form>                                    
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>	
	</div>
<!-- Steps -->
<script src="<?php echo base_url('assets/inspinia/js/plugins/staps/jquery.steps.min.js'); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url('assets/inspinia/js/plugins/validate/jquery.validate.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/messages_es.js'); ?>"></script>
<script src="<?php echo base_url('assets/inspinia/js/plugins/iCheck/icheck.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/inspinia/js/plugins/chosen/chosen.jquery.js'); ?>"></script>

<!-- DROPZONE -->
<script src="<?php echo base_url('assets/inspinia/js/plugins/dropzone/dropzone.js'); ?>"></script>

<script src="<?php echo base_url('assets/inspinia/js/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/inspinia/js/bootstrap.js'); ?>"></script>
<script src="<?php echo base_url('assets/inspinia/js/plugins/metisMenu/jquery.metisMenu.js'); ?>"></script>
<script src="<?php echo base_url('assets/inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url('assets/inspinia/js/inspinia.js'); ?>"></script>
<script src="<?php echo base_url('assets/inspinia/js/plugins/pace/pace.min.js'); ?>"></script>

<!-- Jasny -->
<script src="<?php echo base_url('assets/inspinia/js/plugins/jasny/jasny-bootstrap.min.js'); ?>"></script>

<!-- CodeMirror -->
<script src="<?php echo base_url('assets/inspinia/js/plugins/codemirror/codemirror.js'); ?>"></script>
<script src="<?php echo base_url('assets/inspinia/js/plugins/codemirror/mode/xml/xml.js'); ?>"></script>
<script src="<?php echo base_url('assets/inspinia/js/plugins/bootbox.all.min.js'); ?>"></script>
<!-- Select2 -->
<script src="<?php echo base_url('assets/inspinia/js/plugins/select2/select2.full.min.js'); ?>"></script>
<!-- Data picker -->
<script src="<?php echo base_url('assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js'); ?> "></script>

    
<script>
    $(document).ready(function(){
        
        $("#form").steps({
            bodyTag: "fieldset",
            /* Labels */
            labels: {
				cancel: "Cancelar",
				current: "Vista actual:",
				pagination: "Paginación",
				finish: "Finalizar",
				next: "Siguiente",
				previous: "Anterior",
				loading: "Cargando ..."
			},
            /* Behaviour */
			enableCancelButton: true,
			startIndex: 0,
			/* Events */
            onStepChanging: function (event, currentIndex, newIndex)
            {
                // Always allow going backward even if the current step contains invalid fields!
                if (currentIndex > newIndex)
                {
                    return true;
                }

                var form = $(this);

                // Clean up if user went backward before
                if (currentIndex < newIndex)
                {
                    // To remove error styles
                    $(".body:eq(" + newIndex + ") label.error", form).remove();
                    $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                    
                    if(newIndex == '1'){
						nuevoUsuario();
					}

                    if(newIndex == '2'){
						save(form);
					}

                    if(newIndex == '3'){
						save(form);
					}
                }

                // Disable validation on fields that are disabled or hidden.
                form.validate().settings.ignore = ":disabled,:hidden";
                
                /*if( form.valid() ){
					save(form);
				}*/
                // Start validation; Prevent going forward if false
                return form.valid();
            },
            onFinishing: function (event, currentIndex)
            {
                var form = $(this);

                // Disable validation on fields that are disabled.
                // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                form.validate().settings.ignore = ":disabled";

                // Start validation; Prevent form submission if false
                return form.valid();
            },
            onFinished: function (event, currentIndex)
            {
                var form = $(this);
                // Submit form input
                //form.submit();
				save(form,true);
            },
            onCanceled: function (event)
			{
                //recogemos la dirección del Proceso PHP
				mensaje = "¿Estás seguro de cancelar?,<br /> ¡El proceso seguira pendiente!";
				//colocamos fondo de pantalla
				$('#wrapper').prop('class','bgtransparent');				
				alertify.confirm(mensaje, function (e) {
					//aqui introducimos lo que haremos tras cerrar la alerta.
					$('#wrapper').prop('class','');
					if (e){
                        window.location.href = "<?= base_url("NuevaPlantilla/crear/$PClave_skip"); ?>";
					}
				});     					
			}
        }).validate({
            errorPlacement: function (error, element)
            {
                element.before(error);
            },
            rules: {
                confirm: {
                    equalTo: "#password",
                    
                }
            }
        });

        $('.chosen-select').chosen({width: "100%"});
        $(".select2_demo_1").select2();
        $(".select2_demo_3").select2({
            placeholder: "Seleccionar Especialidad",
            allowClear: true
        });
        
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        $('#data_2 .input-group.date').datepicker({
                startView: 1,
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "yyyy-mm-dd"
            });

        //The class name can vary
        let Checked = null;
        for (let CheckBox of document.getElementsByClassName('only-one')){
            CheckBox.onclick = function(){
                if(Checked != null) {
                Checked.checked = false;
                Checked = CheckBox;
                }
                Checked = CheckBox;
            }
        }

        // Disable checkbox
        $("input[value='Si']").change(function() {
            $("input[name='idUsuario']").prop('disabled', true);
            
        });

        // Enable checkbox
        $("input[value='No']").change(function() {
            $("input[name='idUsuario']").prop('disabled', false);
        });

        $("input[value='Titulado']").change(function() {
            $('#contentPasante').show();
        });
        $("input[value='Pasante']").change(function() {
            $('#contentPasante').hide();
        });

        $(".douploadTitulo").click(function(e) {
            var idPlantel = document.getElementById("plantel").value;
            var idUser = $('input:checkbox[name=idUsuario]:checked').val();

            let formData = new FormData(); 
                formData.append("file", UPDocTitulo_file.files[0]);
                formData.append("idUsuario", idUser);
                formData.append("idPlantel", idPlantel);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url("NuevaPlantilla/uploads"); ?>",
                data: formData,
                dataType: "html",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data){
                    var data = data.split("::");
                    alert(data[1]);
                }
            });

        });

        $(".douploadCedula").click(function(e) {
            var idPlantel = document.getElementById("plantel").value;
            var idUser = $('input:checkbox[name=idUsuario]:checked').val();

            let formData = new FormData(); 
                formData.append("file", UPDocCedula_file.files[0]);
                formData.append("idUsuario", idUser);
                formData.append("idPlantel", idPlantel);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url("NuevaPlantilla/uploads"); ?>",
                data: formData,
                dataType: "html",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data){
                    var data = data.split("::");
                    alert(data[1]);
                }
            });  
        });

        /*$(".semLic").click(function(e) {
            var idPlantel = document.getElementById("GRSemestre").value;

            let formData = new FormData(); 
                formData.append("file", UPDocCedula_file.files[0]);
                formData.append("idUsuario", idUsuario);
                formData.append("idPlantel", idPlantel);
            $.ajax({
                type: "POST",
                url: "",
                data: formData,
                dataType: "html",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data){
                    var data = data.split("::");
                    alert(data[1]);
                    $(".loading").html('');
                }
            });  
        });*/
        
        function nuevoUsuario(){
            var idUser = $('input:checkbox[name=idUsuario]:checked').val();
                if (idUser !='') {
                    $.ajax({
                    type: "POST",
                    url: "<?php echo base_url("NuevaPlantilla/MostrarCarreras"); ?>",
                    data: {tipo : idUser},
                    dataType: "html",
                    beforeSend: function(){
                        //carga spinner
                        $(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
                    },
                    success: function(data){
                        var data = data.split("::");
                        $("#UCURP").val(data[1]);
                        $("#UNombre").val(data[2]);
                        $("#UApellido_pat").val(data[3]);
                        $("#UApellido_mat").val(data[4]);
                        $("#URFC").val(data[5]);
                        $("#UFecha_ingreso").val(data[6]);
                        $(".loading").html('');
                    }
                });
            }
        }

        function save(form,finish){
		$.ajax({
			type: "POST",
			url: "<?php echo base_url("NuevaPlantilla/save"); ?>",
			data: form.serialize(),
			dataType: "html",
			beforeSend: function(){
				//carga spinner
				$(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
			},
			success: function(data){
				var data = data.split("::");
                alert(data);
                $("#FClave_skip").val(data[1]);
				$("#result").html(data[0]);
				$(".loading").html('');
				if(finish && data[3]=="OK"){
					location.href ='<?php echo base_url("NuevaPlantilla/crear/$PClave_skip"); ?>';
				}
			}
		});
	}

    });
</script>
<script>
    $(document).ready(function(){
        //Mostrar las carreras correspondientes al nivel de estudios
        $(document).on("change", ".MostrarCarreras", function () {
        	var selectNivel = ($(this).val());
            
        	$.ajax({
	            type: "POST",
	            url: "<?php echo base_url("NuevaPlantilla/MostrarCarreras"); ?>",
	            data: {tipo : selectNivel},
	            dataType: "html",
	            beforeSend: function(){
	                //carga spinner
	                $(".loadingArchivo").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
	            },
	            success: function(data){
	                $(".resultCarrera").empty();
	                $(".resultCarrera").append(data);  
	                $(".loadingArchivo").html("");
	            }
	        });
		});
    })
</script>
<style type="text/css">
.wizard .content .body {
    position: relative;
}
.sombra{
	z-index: 256;
	background-color: #eee6;
	position: absolute;
	width: 100%;
	height: 100%;
	padding: 8em;
	margin-left: -15px;
}
.wizard > .content > .body label.error {
    margin-left: 75px !important;
}

.select2 {
    background-color: #FFFFFF;
    background-image: none;
    border: 1px solid #e5e6e7;
    border-radius: 1px;
    color: inherit;
    display: block;
    padding: 6px 12px;
    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
    width: 100%;
    font-size: 14px;
}
</style>