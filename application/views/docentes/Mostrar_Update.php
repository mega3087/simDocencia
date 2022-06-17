<link href="<?php echo base_url('assets/inspinia/css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/chosen/chosen.css'); ?>" rel="stylesheet">

<link href="<?php echo base_url('assets/inspinia/css/plugins/steps/jquery.steps.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/animate.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/style.css'); ?>" rel="stylesheet">

<link href="<?php echo base_url('assets/inspinia/css/plugins/dropzone/basic.css'); ?>" rel="stylesheet">

<link href="<?php echo base_url('assets/inspinia/css/plugins/jasny/jasny-bootstrap.min.css'); ?>" rel="stylesheet">

<link href="<?php echo base_url('assets/inspinia/css/plugins/select2/select2.min.css'); ?>" rel="stylesheet">
<!--color boox-->
<script type="text/javascript" src="<?php echo base_url("assets/colorbox/jquery.colorbox-min.js") ?>"></script>
<link media="screen" rel="stylesheet" href="<?php echo base_url("assets/colorbox/colorbox.css") ?>" />

<div class="row">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
			<h3>Docentes</h3>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<?php muestra_mensaje(); ?>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h2>Editar Docente</h2>
			</div> 
			<div class="ibox-content">
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                            
                            <form id="form" action="#" class="wizard-big">
                                <input type="hidden" id="idPlantel" name="idPlantel" value="<?php echo nvl($plantel[0]['CPLClave']); ?>" />
                                <input type="hidden" id="idUser" name="idUser" value="<?php echo nvl($usuario['UNCI_usuario']); ?>" />
                                <h1>Información Personal</h1>
                                <fieldset>
                                    <!--<h2>Account Information</h2>-->
                                    <div class="row">
                                        <div class="col-lg-8">

                                            <div class="form-group">
                                                <label>CURP.: <em>*</em></label>
                                                <input id="UCURP" name="UCURP" value="<?php echo nvl($usuario['UCURP']); ?>" type="text" class="form-control <?php if (nvl($usuario['UCURP'])) echo "disabled";?>"  minlength="18" maxlength="18"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Nombre(s) / Apellido Paterno / Apellido Materno: <em>*</em></label>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <input id="UNombre" name="UNombre" value="<?php echo nvl($usuario['UNombre']); ?>" type="text" class="form-control <?php if (nvl($usuario['UNombre'])) echo "disabled";?>">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input id="UApellido_pat" name="UApellido_pat" value="<?php echo nvl($usuario['UApellido_pat']); ?>" type="text" class="form-control <?php if (nvl($usuario['UApellido_pat'])) echo "disabled";?>">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input id="UApellido_mat" name="UApellido_mat" value="<?php echo nvl($usuario['UApellido_mat']); ?>" type="text" class="form-control <?php if (nvl($usuario['UApellido_mat'])) echo "disabled";?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Fecha de nacimiento: <em>*</em></label>
                                                <input type="text" id="UFecha_nacimiento" placeholder="yyyy-mm-dd" name="UFecha_nacimiento" value="<?php echo nvl($usuario['UFecha_nacimiento']); ?>" class="form-control date <?php if (nvl($usuario['UFecha_nacimiento'])) echo "disabled";?>" minlength="10" maxlength="10"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Lugar de nacimiento: <em>*</em></label>
                                                <input type="text" id="ULugar_nacimiento" name="ULugar_nacimiento" value="<?php echo nvl($usuario['ULugar_nacimiento']); ?>" maxlength='150' class="form-control <?php if (nvl($usuario['ULugar_nacimiento'])) echo "disabled";?>"/>
                                            </div>
                                            <div class="form-group">
                                                <label>R.F.C.: <em>*</em></label>
                                                <input id="URFC" name="URFC" value="<?php echo nvl($usuario['URFC']); ?>" type="text" class="form-control <?php if (nvl($usuario['URFC'])) echo "disabled";?>"  minlength="13" maxlength="13" />
                                            </div>
                                            <div class="form-group">
                                                <label>Domicilio: <em>*</em></label>
                                                <input type="text" id="UDomicilio" name="UDomicilio" value="<?php echo nvl($usuario['UDomicilio']); ?>" maxlength='150' class="form-control <?php if (nvl($usuario['UDomicilio'])) echo "disabled";?>" />
                                            </div>				
                                            <div class="form-group">
                                                <label>Colonia: <em>*</em></label>
                                                <input type="text" id="UColonia" name="UColonia" value="<?php echo nvl($usuario['UColonia']); ?>" maxlength='150' class="form-control <?php if (nvl($usuario['UColonia'])) echo "disabled";?>" />
                                            </div>
                                            <div class="form-group">
                                                <label>Municipio: <em>*</em></label>
                                                <input type="text" id="UMunicipio" name="UMunicipio" value="<?php echo nvl($usuario['UMunicipio']); ?>" maxlength='150' class="form-control <?php if (nvl($usuario['UMunicipio'])) echo "disabled";?>" />
                                            </div>
                                            <div class="form-group">
                                                <label>C.P: <em>*</em></label>
                                                <input type="text" id="UCP" name="UCP" value="<?php echo nvl($usuario['UCP']); ?>" maxlength='150' class="form-control <?php if (nvl($usuario['UCP'])) echo "disabled";?>" />
                                            </div>
                                            <div class="form-group">
                                                <label>Tel. movil: <em>*</em></label>
                                                <input type="text" id="UTelefono_movil" name="UTelefono_movil" value="<?php echo nvl($usuario['UTelefono_movil']); ?>" maxlength='150' class="form-control <?php if (nvl($usuario['UTelefono_movil'])) echo "disabled";?>"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Tel. casa: <em>*</em></label>
                                                <input type="text" id="UTelefono_casa" name="UTelefono_casa" value="<?php echo nvl($usuario['UTelefono_casa']); ?>" maxlength='150' class="form-control <?php if (nvl($usuario['UTelefono_casa'])) echo "disabled";?>" />
                                            </div>
                                            <div class="form-group">
                                                <label>Correo Electronico: <em>*</em></label>
                                                <input type="text" id="UCorreo_electronico" name="UCorreo_electronico" value="<?php echo nvl($usuario['UCorreo_electronico']); ?>" maxlength='150' class="form-control email <?php if (nvl($usuario['UCorreo_electronico'])) echo "disabled";?>" />
                                            </div>
                                            <div class="form-group">
                                                <label>Estado civil: <em>*</em></label>
                                                <select name="UEstado_civil" id="UEstado_civil" class="form-control <?php if (nvl($usuario['UEstado_civil'])) echo "disabled";?>" >
                                                    <option value=""></option>
                                                    <?php foreach($estado_civil as $key => $list){ ?>
                                                    <option <?php if( $list['ECNombre'] == nvl($usuario['UEstado_civil'])) echo"selected"; ?> value="<?=$list['ECNombre'];?>"><?=$list['ECNombre'];?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Sexo: <em>*</em></label>
                                                <select name="USexo" id="USexo" class="form-control <?php if (nvl($usuario['USexo'])) echo "disabled";?>" >
                                                    <option value=""></option>
                                                    <option <?php if( 'Hombre' == nvl($usuario['USexo'])) echo"selected"; ?> value="Hombre">Hombre</option>
                                                    <option <?php if( 'Mujer' == nvl($usuario['USexo'])) echo"selected"; ?> value="Mujer">Mujer</option>
                                                </select>
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
                                <h1>Datos de Nombramiento</h1>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <label>Fecha de Ingreso: <em>*</em></label>
                                                <input type="text" placeholder="yyyy-mm-dd" class="form-control date <?php if (nvl($usuario['UFecha_ingreso']) != '0000-00-00') echo "disabled";?>" id="UFecha_ingreso" name="UFecha_ingreso" value="<?php echo nvl($usuario['UFecha_ingreso']); ?>" minlength="10" maxlength="10">
                                            </div>
                                            <div class="form-group">
                                                <label>Tipo:<em>*</em></label>
                                                <select name="UDTipo_Docente" id="UDTipo_Docente" class="form-control" data-placeholder="Seleccionar Tipo Docente" >
                                                    <option></option>
                                                    <?php foreach($tipoDocente as $key_t => $list_t){ ?>
                                                    <option value="<?=$list_t['TPClave']?>"><?=$list_t['TPNombre']?></option>
                                                    <?php } ?>
                                                </select>                                                
                                            </div>

                                            <div class="form-group">
                                                <label>Nombramiento:<em>*</em></label>
                                                <select name="UDNombramiento" id="UDNombramiento" class="form-control" data-placeholder="Seleccionar Tipo Docente" >
                                                    <option></option>
                                                    <?php foreach($nombramiento as $key_n => $list_n){ ?>
                                                    <option value="<?=$list_n['PLClave']?>"><?=$list_n['PLPuesto']?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Documento Nombramiento: </label>
                                                    <div class="col-lg-6">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <span class="btn btn-primary btn-file"><span class="fileinput-new">Seleccionar Nombramiento</span><span class="fileinput-exists">Cambiar</span><input type="file" name="UDNombramiento_file" id="UDNombramiento_file" accept="application/pdf"></span>
                                                            <span class="fileinput-filename"></span>
                                                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                    <button type='button' class='btn btn-sm btn-danger douploadNombramiento'> Subir Nombramiento</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <h4 class="modal-title"><i class="fa fa-folder"></i>&nbsp;&nbsp; OFICIOS DE SOLICITUD </h4><div class="border-bottom"></div><br/>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Documento Oficio de Petición: </label>
                                                    <div class="col-lg-6">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <span class="btn btn-primary btn-file"><span class="fileinput-new">Seleccionar Oficio de Petición</span><span class="fileinput-exists">Cambiar</span><input type="file" name="UDOficio_file" id="UDOficio_file" accept="application/pdf"></span>
                                                            <span class="fileinput-filename"></span>
                                                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                    <button type='button' class='btn btn-sm btn-danger douploadOficio'> Subir Oficio</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Documento Curriculum: </label>
                                                    <div class="col-lg-6">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <span class="btn btn-primary btn-file"><span class="fileinput-new">Seleccionar Curriculum</span><span class="fileinput-exists">Cambiar</span><input type="file" name="UDCurriculum_file" id="UDCurriculum_file" accept="application/pdf"></span>
                                                            <span class="fileinput-filename"></span>
                                                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                    <button type='button' class='btn btn-sm btn-danger douploadCurriculum'> Subir Curriculum</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Documento CURP: </label>
                                                    <div class="col-lg-6">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <span class="btn btn-primary btn-file"><span class="fileinput-new">Seleccionar CURP</span><span class="fileinput-exists">Cambiar</span><input type="file" name="UDCURP_file" id="UDCURP_file" accept="application/pdf"></span>
                                                            <span class="fileinput-filename"></span>
                                                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                    <button type='button' class='btn btn-sm btn-danger douploadCURP'> Subir CURP</button>
                                                    </div>
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

                                <h1>Estudios</h1>
                                <fieldset>
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
                                                <option value=""></option>
                                                    <?php foreach ($carreras as $k => $listCar) { ?>
                                                        <option value="<?php echo $listCar['IdLicenciatura']; ?>"><?php echo $listCar['Licenciatura']; ?></option>    
                                                    <?php } ?>
                                            </select>
                                        </div>                                                    

                                        <div id="contentPasante">
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-lg-3">Documento Título Profesional: </label>
                                                <div class="col-lg-6">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <span class="btn btn-primary btn-file"><span class="fileinput-new">Seleccionar Título</span><span class="fileinput-exists">Cambiar</span><input type="file" name="UPDocTitulo_file" id="UPDocTitulo_file" accept="application/pdf"></span>
                                                    <span class="fileinput-filename"></span>
                                                    <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                                                </div>
                                                </div>
                                                <div class="col-lg-3">
                                                <button type='button' class='btn btn-sm btn-danger douploadTitulo'> Subir Archivo</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-lg-3">Documento Cédula Profesional: </label>
                                                <div class="col-lg-6">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <span class="btn btn-primary btn-file"><span class="fileinput-new">Seleccionar Cédula</span><span class="fileinput-exists">Cambiar</span><input type="file" name="UPDocCedula_file" id="UPDocCedula_file" accept="application/pdf"></span>
                                                        <span class="fileinput-filename"></span>
                                                        <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
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
                                        <br>
                                        <button type='button' class='btn btn-sm btn-success saveEstudios'> Guardar Estudios</button>
                                        </div>

                                        <div class="form-group">
                                            <form action="#" method='POST' name='estudios_form' id='estudios_form'>
                                                <div class="msgEstudios"></div>
                                                <div class="resultEstudios"></div>
                                            </form>
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

                            </form>                            
                        </div>
                    </div>
			    </div>
		    </div>
	    </div>
    </div>
</div>

<script src="<?php echo base_url('assets/inspinia/js/plugins/dataTables/datatables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/inspinia/js/plugins/chosen/chosen.jquery.js'); ?>"></script>
<!-- Steps -->
<script src="<?php echo base_url('assets/inspinia/js/plugins/staps/jquery.steps.min.js'); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url('assets/inspinia/js/plugins/validate/jquery.validate.min.js'); ?>"></script>
<!-- Jasny -->
<script src="<?php echo base_url('assets/inspinia/js/plugins/jasny/jasny-bootstrap.min.js'); ?>"></script>
<!-- Select2 -->
<script src="<?php echo base_url('assets/inspinia/js/plugins/select2/select2.full.min.js'); ?>"></script>

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

	});
</script>
<script type="text/javascript">
	$(document).ready(function() {
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


        //Subir Archivo Nombramiento
        $(document).on("click", ".douploadNombramiento", function () {
                var idPlantel = document.getElementById("idPlantel").value;
                var idUser = document.getElementById("idUser").value;

                let formData = new FormData(); 
                    formData.append("file", UDNombramiento_file.files[0]);
                    formData.append("idUsuario", idUser);
                    formData.append("idPlantel", idPlantel);
                    formData.append("tipoDoc", 'Nombramiento');
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


        //Subir Archivo Oficio
        $(document).on("click", ".douploadOficio", function () {
            var idPlantel = document.getElementById("idPlantel").value;
            var idUser = document.getElementById("idUser").value;

            let formData = new FormData(); 
                formData.append("file", UDOficio_file.files[0]);
                formData.append("idUsuario", idUser);
                formData.append("idPlantel", idPlantel);
                formData.append("tipoDoc", 'OficioPeticion');
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

        //Subir Archivo Curriculum
        $(document).on("click", ".douploadCurriculum", function () {
            var idPlantel = document.getElementById("idPlantel").value;
            var idUser = document.getElementById("idUser").value;

            let formData = new FormData(); 
                formData.append("file", UDCurriculum_file.files[0]);
                formData.append("idUsuario", idUser);
                formData.append("idPlantel", idPlantel);
                formData.append("tipoDoc", 'Curriculum');
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

        //Subir Archivo CURP
        $(document).on("click", ".douploadCURP", function () {
            var idPlantel = document.getElementById("idPlantel").value;
            var idUser = document.getElementById("idUser").value;

            let formData = new FormData(); 
                formData.append("file", UDCURP_file.files[0]);
                formData.append("idUsuario", idUser);
                formData.append("idPlantel", idPlantel);
                formData.append("tipoDoc", 'CURP');
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

        //Subir Archivo Titulo
        $(document).on("click", ".douploadTitulo", function () {
            var idPlantel = document.getElementById("idPlantel").value;
            var idUser = document.getElementById("idUser").value;

            let formData = new FormData(); 
                formData.append("file", UPDocTitulo_file.files[0]);
                formData.append("idUsuario", idUser);
                formData.append("idPlantel", idPlantel);
                formData.append("tipoDoc", 'Titulo');
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

        //Subir Archivo Cedula
        $(document).on("click", ".douploadCedula", function () {
            var idPlantel = document.getElementById("idPlantel").value;
            var idUser = document.getElementById("idUser").value;

            let formData = new FormData(); 
                formData.append("file", UPDocCedula_file.files[0]);
                formData.append("idUsuario", idUser);
                formData.append("idPlantel", idPlantel);
                formData.append("tipoDoc", 'Cedula');
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

        //Guardar Estudios del Docente 
		$(document).on("click", ".saveEstudios", function () {
            var idUser = document.getElementById("idUser").value;
            var idPlantel = document.getElementById("idPlantel").value;
            var Titulado = document.getElementById("Titulado").value;
            var ULNivel_estudio = document.getElementById("ULNivel_estudio").value;
            var ULLicenciatura = document.getElementById("ULLicenciatura").value;
            var ULCedulaProf = document.getElementById("ULCedulaProf").value;
                        
            let formData = new FormData(); 
            formData.append("ULUsuario", idUser);
            formData.append("ULPlantel", idPlantel);
            formData.append("ULNivel_estudio", ULNivel_estudio);
            formData.append("ULLicenciatura", ULLicenciatura);
            formData.append("ULTitulo_file", UPDocTitulo_file.files[0]);
            formData.append("ULCedula_file", UPDocCedula_file.files[0]);
            formData.append("ULCedulaProf", ULCedulaProf);
            formData.append("ULTitulado", Titulado);

            $.ajax({
                type: "POST",
                url: "<?php echo base_url("docente/saveEstudios"); ?>",
                data: formData,
                dataType: "html",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data){
	                var data = data.split(";");
	                if(data[0]==' OK'){
	                    $(".msgArchivo").empty();
	                    $(".msgArchivo").append(data[1]);
	                    datosArchivos( data[2]);
	                    FormArchivo.UPNivel_estudio.value = "";
						FormArchivo.UPCarrera.value = "";
						FormArchivo.UPDocTitulo_file.value = "";
						FormArchivo.UPDocCedula_file.value = "";
	                    $(".loadingArchivo").html("");
	                } else {
	                    $(".msgEstudios").empty();
	                    $(".msgEstudios").append(data[0]);  
	                    datosArchivos( data[1]);
	                    $(".loadingArchivo").html(""); 
	                }
	                
	            } 
            }); 
            
		});//----->fin

        function datosArchivos(idUsuario){
			var idUsuario = idUsuario;
			var idPlantel = document.getElementById("idPlantel").value;
			$.ajax({
	            type: "POST",
	            url: "<?php echo base_url("docente/mostrarEstudios"); ?>",
	            data: {idUsuario : idUsuario, idPlantel : idPlantel}, 
	            dataType: "html",
	            beforeSend: function(){
	                //carga spinner
	                $(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
	            },
	            success: function(data){
	                $(".resultEstudios").empty();
	                $(".resultEstudios").append(data);  
	                $(".loading").html("");
	            }
	        });
	    }

    });
</script>
<script>

</script>
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
            onStepChanging: function (event, currentIndex, newIndex)
            {
                // Always allow going backward even if the current step contains invalid fields!
                if (currentIndex > newIndex)
                {
                    return true;
                }

                // Forbid suppressing "Warning" step if the user is to young
                if (newIndex === 3 && Number($("#age").val()) < 18)
                {
                    return false;
                }

                var form = $(this);

                // Clean up if user went backward before
                if (currentIndex < newIndex)
                {
                    // To remove error styles
                    $(".body:eq(" + newIndex + ") label.error", form).remove();
                    $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                }

                // Disable validation on fields that are disabled or hidden.
                form.validate().settings.ignore = ":disabled,:hidden";

                // Start validation; Prevent going forward if false
                return form.valid();
            },
            onStepChanged: function (event, currentIndex, priorIndex)
            {
                // Suppress (skip) "Warning" step if the user is old enough.
                if (currentIndex === 2 && Number($("#age").val()) >= 18)
                {
                    $(this).steps("next");
                }

                // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
                if (currentIndex === 2 && priorIndex === 3)
                {
                    $(this).steps("previous");
                }
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
                form.submit();
            }
        }).validate({
                    errorPlacement: function (error, element)
                    {
                        element.before(error);
                    },
                    rules: {
                        confirm: {
                            equalTo: "#password"
                        }
                    }
                });
    });
</script>
<style>
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
<script>
$(document).ready(function(){
    $(".select2_demo_1").select2();
    $(".select2_demo_2").select2();
    $(".select2_demo_3").select2({
        placeholder: "Seleccionar",
        allowClear: true
    });

    $("input[value='Titulado']").change(function() {
        $('#contentPasante').show();
    });
    $("input[value='Pasante']").change(function() {
        $('#contentPasante').hide();
    });
});
</script>
