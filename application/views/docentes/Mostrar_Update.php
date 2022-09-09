<link href="<?php echo base_url('assets/inspinia/css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/chosen/chosen.css'); ?>" rel="stylesheet">

<link href="<?php echo base_url('assets/inspinia/css/plugins/steps/jquery.steps.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/animate.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/style.css'); ?>" rel="stylesheet">

<link href="<?php echo base_url('assets/inspinia/css/plugins/dropzone/basic.css'); ?>" rel="stylesheet">

<link href="<?php echo base_url('assets/inspinia/css/plugins/jasny/jasny-bootstrap.min.css'); ?>" rel="stylesheet">

<link href="<?php echo base_url('assets/inspinia/css/plugins/select2/select2.min.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/datapicker/datepicker3.css'); ?>" rel="stylesheet" />
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
				<h2>Docente<b> <?php echo nvl($usuario[0]['UNombre']); ?> <?php echo nvl($usuario[0]['UApellido_pat']); ?> <?php echo nvl($usuario[0]['UApellido_mat']); ?></b></h2>
			</div> 
			<div class="ibox-content">
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                            
                        <?php echo form_open('Docente/Registrar', array('name' => 'FormRegistrar', 'id' => 'form', 'role' => 'form', 'class' => 'wizard-big', 'enctype' => 'multipart/form-data')); ?>
                            <?php 
                            $idPlantel = $this->encrypt->encode($plantel[0]['CPLClave']); 
                            ?>
                                <input type="hidden" id="UPlantel" name="UPlantel" value="<?php echo nvl($plantel[0]['CPLClave']); ?>" />
                                <input type="hidden" id="UNCI_usuario" name="UNCI_usuario" value="<?php echo nvl($usuario[0]['UNCI_usuario']); ?>" />
                                <h1>Información Personal</h1>
                                <fieldset>
                                    <!--<h2>Account Information</h2>-->
                                    <div class="row">
                                        <div class="col-lg-10">

                                            <div class="form-group">
                                                <label>CURP.: <em>*</em></label>
                                                <input id="UCURP" name="UCURP" value="<?php echo nvl($usuario[0]['UCURP']); ?>" type="text" class="form-control <?php if (nvl($usuario[0]['UCURP'])) echo "disabled";?> required"  minlength="18" maxlength="18"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Nombre(s) / Apellido Paterno / Apellido Materno: <em>*</em></label>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <input id="UNombre" name="UNombre" value="<?php echo nvl($usuario[0]['UNombre']); ?>" type="text" class="form-control <?php if (nvl($usuario[0]['UNombre'])) echo "disabled";?> required">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input id="UApellido_pat" name="UApellido_pat" value="<?php echo nvl($usuario[0]['UApellido_pat']); ?>" type="text" class="form-control <?php if (nvl($usuario[0]['UApellido_pat'])) echo "disabled";?> required">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input id="UApellido_mat" name="UApellido_mat" value="<?php echo nvl($usuario[0]['UApellido_mat']); ?>" type="text" class="form-control <?php if (nvl($usuario[0]['UApellido_mat'])) echo "disabled";?> required">
                                                    </div>
                                                </div>
                                            </div>                                            
                                            <div class="form-group" id="data_2">
                                                <label>Fecha de nacimiento: <em>*</em></label>
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                    <input type="text" class="form-control fecha" id="UFecha_nacimiento" name="UFecha_nacimiento" value="<?php echo fecha_format(nvl($usuario['UFecha_nacimiento'])); ?>" minlength="10" maxlength="10">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Lugar de nacimiento: <em>*</em></label>
                                                <input type="text" id="ULugar_nacimiento" name="ULugar_nacimiento" value="<?php echo nvl($usuario[0]['ULugar_nacimiento']); ?>" maxlength='150' class="form-control <?php if (nvl($usuario[0]['ULugar_nacimiento'])) echo "disabled";?> required"/>
                                            </div>
                                            <div class="form-group">
                                                <label>R.F.C.: <em>*</em></label>
                                                <input id="URFC" name="URFC" value="<?php echo nvl($usuario[0]['URFC']); ?>" type="text" class="form-control <?php if (nvl($usuario[0]['URFC'])) echo "disabled";?> required"  minlength="13" maxlength="13" />
                                            </div>
                                            <div class="form-group">
                                                <label>Domicilio: <em>*</em></label>
                                                <input type="text" id="UDomicilio" name="UDomicilio" value="<?php echo nvl($usuario[0]['UDomicilio']); ?>" maxlength='150' class="form-control <?php if (nvl($usuario[0]['UDomicilio'])) echo "disabled";?> required" />
                                            </div>				
                                            <div class="form-group">
                                                <label>Colonia: <em>*</em></label>
                                                <input type="text" id="UColonia" name="UColonia" value="<?php echo nvl($usuario[0]['UColonia']); ?>" maxlength='150' class="form-control <?php if (nvl($usuario[0]['UColonia'])) echo "disabled";?> required" />
                                            </div>
                                            <div class="form-group">
                                                <label>Municipio: <em>*</em></label>
                                                <input type="text" id="UMunicipio" name="UMunicipio" value="<?php echo nvl($usuario[0]['UMunicipio']); ?>" maxlength='150' class="form-control <?php if (nvl($usuario[0]['UMunicipio'])) echo "disabled";?> required" />
                                            </div>
                                            <div class="form-group">
                                                <label>C.P: <em>*</em></label>
                                                <input type="text" id="UCP" name="UCP" value="<?php echo nvl($usuario[0]['UCP']); ?>" maxlength='150' class="form-control <?php if (nvl($usuario[0]['UCP'])) echo "disabled";?> required" />
                                            </div>
                                            <div class="form-group">
                                                <label>Tel. movil: <em>*</em></label>
                                                <input type="text" id="UTelefono_movil" name="UTelefono_movil" value="<?php echo nvl($usuario[0]['UTelefono_movil']); ?>" maxlength='150' class="form-control <?php if (nvl($usuario[0]['UTelefono_movil'])) echo "disabled";?> required"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Tel. casa: <em>*</em></label>
                                                <input type="text" id="UTelefono_casa" name="UTelefono_casa" value="<?php echo nvl($usuario[0]['UTelefono_casa']); ?>" maxlength='150' class="form-control <?php if (nvl($usuario[0]['UTelefono_casa'])) echo "disabled";?> required" />
                                            </div>
                                            <div class="form-group">
                                                <label>Correo Electronico: <em>*</em></label>
                                                <input type="text" id="UCorreo_electronico" name="UCorreo_electronico" value="<?php echo nvl($usuario[0]['UCorreo_electronico']); ?>" maxlength='150' class="form-control email <?php if (nvl($usuario[0]['UCorreo_electronico'])) echo "disabled";?> required" />
                                            </div>
                                            <div class="form-group">
                                                <label>Estado civil: <em>*</em></label>
                                                <select name="UEstado_civil" id="UEstado_civil" class="form-control <?php if (nvl($usuario[0]['UEstado_civil'])) echo "disabled";?> required" >
                                                    <option value="">- Seleccionar Estado Civil -</option>
                                                    <?php foreach($estado_civil as $key => $list){ ?>
                                                    <option <?php if( $list['ECNombre'] == nvl($usuario[0]['UEstado_civil'])) echo"selected"; ?> value="<?=$list['ECNombre'];?>"><?=$list['ECNombre'];?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Sexo: <em>*</em></label>
                                                <select name="USexo" id="USexo" class="form-control <?php if (nvl($usuario[0]['USexo'])) echo "disabled";?> required" >
                                                    <option value="">- Seleccionar Sexo -</option>
                                                    <option <?php if( 'Hombre' == nvl($usuario[0]['USexo'])) echo"selected"; ?> value="Hombre">Hombre</option>
                                                    <option <?php if( 'Mujer' == nvl($usuario[0]['USexo'])) echo"selected"; ?> value="Mujer">Mujer</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="text-center">
                                                <div style="margin-top: 20px">
                                                    <i class="fa fa-sign-in" style="font-size: 180px;color: #e5e5e5 "></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </fieldset>
                                <h1>Datos de la Plaza</h1>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-10">
                                            
                                            <div class="form-group">
                                                <label>Tipo Nombramiento:</label>
                                                <select name="UDTipo_Nombramiento" id="UDTipo_Nombramiento" class="form-control datosNombramiento" placeholder="Seleccionar Tipo Docente" onchange="tipoNombramiento()">
                                                    <option value="">- Seleccionar Nombramiento -</option>
                                                    <?php foreach($tipoDocente as $key_t => $list_t){ ?>
                                                    <option  value="<?=$list_t['TPClave'];?>"><?=$list_t['TPNombre'];?></option>
                                                    <?php } ?>
                                                </select>                                                
                                            </div>

                                            <div class="form-group">
                                                <label>Plaza:<em>*</em></label>
                                                <select name="UDPlaza" id="UDPlaza" class="form-control datosPlaza">
                                                    <option value="">- Seleccionar Plaza -</option>
                                                    <?php foreach($plazas as $key_p => $list_p){ ?>
                                                    <option value="<?=$list_p['idPlaza'];?>"><?=$list_p['nomplaza'];?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="form-group mostrarFechaIng" id="data_2" style="display:show;">
                                                <label>Fecha de Ingreso: <em>*</em></label>
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                    <input type="text" class="form-control fecha" id="UDFecha_ingreso" name="UDFecha_ingreso" value="<?php echo fecha_format(nvl($usuario['UDFecha_ingreso'])); ?>" minlength="10" maxlength="10">
                                                </div>
                                            </div>
                                            <div class="form-group mostrarFechasNom" style="display:none;">
                                                <div class="row">
                                                    <div class="col-lg-4" id="data_2">
                                                        <label>Fecha de Inicio: <em>*</em></label>
                                                        <div class="input-group date">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                            <input type="text" class="form-control fecha" id="UDFecha_inicio" name="UDFecha_inicio" value="<?php echo fecha_format(nvl($usuario['UDFecha_inicio'])); ?>" minlength="10" maxlength="10">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4" id="data_2">
                                                        <label>Fecha de Final: <em>*</em></label>
                                                        <div class="input-group date">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                            <input type="text" class="form-control fecha" id="UDFecha_final" name="UDFecha_final" value="<?php echo fecha_format(nvl($usuario['UDFecha_final'])); ?>" minlength="10" maxlength="10">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label>Horas Frente Grupo: <em>*</em></label>
                                                        <input type="number" id="UDHorasGrupo" name="UDHorasGrupo" class="form-control UDHorasGrupo" value="0" minlength="1" maxlength="2">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>Horas Apoyo Docencia : <em>*</em></label>
                                                        <input type="number" id="UDHorasApoyo" name="UDHorasApoyo" class="form-control UDHorasApoyo" value="0" minlength="1" maxlength="2">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>Horas Adicionales / CB-I: <em>*</em></label>
                                                        <input type="number" class="form-control" id="UDHorasAdicionales" name="UDHorasAdicionales" value="0" minlength="1" maxlength="2">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Tipo de Materias: <em>*</em></label>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control disabled" id="UDTipo_materia" name="UDTipo_materia" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <div class="form-group mostrarOficio" style="display:none;">
                                                <label>No. de Oficio / No. de Folio: <em>*</em></label>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" id="UDNumOficio" name="UDNumOficio" value="" minlength="6" maxlength="24">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mostrarObservaciones" style="display:none;">
                                                <label>Observaciones: <em>*</em></label>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" id="UDObservaciones" name="UDObservaciones" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <br><br>
                                            <div class="form-group mostrarDocNom" style="display:none;">
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
                                                    <?php if (nvl($usuario[0]['UDNombramiento_file'])) { ?>
                                                    <a href='<?= base_url($usuario[0]['UDNombramiento_file']); ?>' target='_blanck'><button type='button' class='btn btn-sm btn-success' ><i class='fa fa-file-archive-o'></i> Ver Archivo</button></a>
                                                    <!--<button type='button' class='btn btn-sm btn-danger douploadNombramiento'> Subir Nombramiento</button>-->
                                                    <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            

                                            <button type='button' class='btn btn-sm btn-success savePlazas pull-right'> Guardar Plazas</button>

                                            <div class="form-group col-lg-12">
                                                <div class="loadingPlazas"></div>
                                                <div id="errorPlazas"></div>
                                                <div class="msgPlazas"></div>
                                                <div class="resultPlazas"></div>
                                            </div>
                                            
                                        </div>                                       

                                        <div class="col-lg-2">
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
                                    <div class="col-lg-10">
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
                                            <select id="ULNivel_estudio" name="ULNivel_estudio" class="form-control MostrarCarreras" >
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
                                                    <!--<div class="col-lg-3">
                                                    <button type='button' class='btn btn-sm btn-danger douploadTitulo'> Subir Archivo</button>
                                                    </div>-->
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
                                                    <!--<div class="col-lg-3">
                                                    <button type='button' class='btn btn-sm btn-danger douploadCedula'> Subir Archivo</button>
                                                    </div>-->
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <label>No. de Cédula Profesional: <em>*</em></label>
                                                        <input id="ULCedulaProf" name="ULCedulaProf" value="<?php echo nvl($usuario['ULCedulaProf']); ?>" type="text" class="form-control "  minlength="6" maxlength="10" />
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                        <button type='button' class='btn btn-sm btn-success saveEstudios pull-right '> Guardar Estudios</button>

                                        <div class="form-group col-lg-12">
                                                <div class="loadingEstudios"></div>
                                                <div class="msgEstudios"></div>
                                                <div class="resultEstudios"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="text-center">
                                            <div style="margin-top: 20px">
                                                <i class="fa fa-sign-in" style="font-size: 180px;color: #e5e5e5 "></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </fieldset>

                        <?php echo form_close(); ?>                           
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

<script src="<?php echo base_url('assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js'); ?>"></script>

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
	            url: "<?php echo base_url("Docente/mostrarCarreras"); ?>",
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

        //Guardar Plaza del Docente 
		$(document).on("click", ".savePlazas", function () {
            
            let formData = new FormData(); 
            formData.append("UDUsuario", document.getElementById("UNCI_usuario").value);
            formData.append("UDPlantel", document.getElementById("UPlantel").value);

            formData.append("UDFecha_ingreso", document.getElementById("UDFecha_ingreso").value);
            formData.append("UDTipo_Nombramiento", document.getElementById("UDTipo_Nombramiento").value);
            formData.append("UDPlaza", document.getElementById("UDPlaza").value);
            formData.append("UDTipo_materia", document.getElementById("UDTipo_materia").value);
            formData.append("UDNumOficio", document.getElementById("UDNumOficio").value);
            formData.append("UDHoras_grupo", document.getElementById("UDHorasGrupo").value);
            formData.append("UDHoras_apoyo", document.getElementById("UDHorasApoyo").value);
            formData.append("UDHoras_adicionales", document.getElementById("UDHorasAdicionales").value);

            formData.append("UDFecha_inicio",  document.getElementById("UDFecha_inicio").value);
            formData.append("UDFecha_final", document.getElementById("UDFecha_final").value);
            formData.append("UDObservaciones", document.getElementById("UDObservaciones").value);

            formData.append("UDNombramiento_file", UDNombramiento_file.files[0]);
            
            $.ajax({
                type: "POST",
                url: "<?php echo base_url("Docente/savePlazas"); ?>",
                data: formData,
                dataType: "html",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data){
	                var data = data.split("::");
                    if(data[1]=='OK'){
	                    $(".msgPlazas").empty();
	                    $(".msgPlazas").append(data[0]);
	                    datosPlazas(data[2]);
	                    FormRegistrar.UDFecha_ingreso.value = "";
						FormRegistrar.UDPlaza.value = "";
						FormRegistrar.UDTipo_materia.value = "";
						FormRegistrar.UDNumOficio.value = "";
                        FormRegistrar.UDHorasGrupo.value = "";
                        FormRegistrar.UDHorasApoyo.value = "";
                        FormRegistrar.UDHorasAdicionales.value = "";
                        FormRegistrar.UDFecha_inicio.value = "";
                        FormRegistrar.UDFecha_final.value = "";
                        FormRegistrar.UDObservaciones.value = "";

                        FormRegistrar.UDNombramiento_file.value = "";
	                    $(".loadingPlazas").html("");
	                } else {
                        $("#errorPlazas").empty();
                        $("#errorPlazas").append(data);   
                        $(".loadingPlazas").html(""); 
                    }
	            } 
            }); 
            
		});//----->fin

        //Guardar Estudios del Docente 
		$(document).on("click", ".saveEstudios", function () {
                        
            let formData = new FormData(); 
            formData.append("ULUsuario", document.getElementById("UNCI_usuario").value);
            formData.append("ULPlantel", document.getElementById("UPlantel").value);
            formData.append("ULNivel_estudio", document.getElementById("ULNivel_estudio").value);
            formData.append("ULLicenciatura", document.getElementById("ULLicenciatura").value);
            formData.append("ULTitulo_file", UPDocTitulo_file.files[0]);
            formData.append("ULCedula_file", UPDocCedula_file.files[0]);
            formData.append("ULCedulaProf", document.getElementById("ULCedulaProf").value);
            formData.append("ULTitulado", $("input[type=radio][name=Titulado]:checked").val());

            $.ajax({
                type: "POST",
                url: "<?php echo base_url("Docente/saveEstudios"); ?>",
                data: formData,
                dataType: "html",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data){
	                var data = data.split("::");
                    if(data[1]=='OK'){
	                    $(".msgEstudios").empty();
	                    $(".msgEstudios").append(data[0]);
	                    datosEstudios(data[2]);
                        $("#ULNivel_estudio").val("");
                        //$("#ULLicenciatura").val("");
                        FormRegistrar.ULLicenciatura.value = "";
                        $("#ULCedulaProf").val("");
	                    $(".loadingEstudios").html("");
	                } else {
	                    $(".msgEstudios").empty();
	                    $(".msgEstudios").append(data[0]);  
	                    datosEstudios(data[2]);
	                    $(".loadingEstudios").html(""); 
	                }
	                
	            } 
            }); 
            
		});//----->fin

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
						save(form);
                        var idUsuario = document.getElementById("UNCI_usuario").value;
                        datosPlazas(idUsuario);
					}

                    if(newIndex == '2'){
						var idUsuario = document.getElementById("UNCI_usuario").value;
                        datosEstudios(idUsuario);
					}

                }

                // Disable validation on fields that are disabled or hidden.
                form.validate().settings.ignore = ":disabled,:hidden";

                // Start validation; Prevent going forward if false
                return form.valid();
            },
            onFinishing: function (event, currentIndex)
            {
                var form = $(this);

                // Disable validation on fields that are disabled.
                // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                //form.validate().settings.ignore = ":disabled";

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
				mensaje = "¿Estás seguro de cancelar?";
				//colocamos fondo de pantalla
				$('#wrapper').prop('class','bgtransparent');				
				alertify.confirm(mensaje, function (e) {
					//aqui introducimos lo que haremos tras cerrar la alerta.
					$('#wrapper').prop('class','');
					if (e){
                        window.location.href = "<?= base_url("Docente/ver_docentes/$idPlantel"); ?>";
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
                    equalTo: "#password"
                }
            }
        });

    function save(form,finish){
		$.ajax({
			type: "POST",
			url: "<?php echo base_url("Docente/Save"); ?>",
			data: form.serialize(),
			dataType: "html",
			beforeSend: function(){
				//carga spinner
				$(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
			},
			success: function(data){
				var data = data.split("::");
                $("#UNCI_usuario").val(data[1]);
				$("#result").html(data[0]);
				$(".loading").html('');
				if(finish && data[2]=="OK"){
					location.href ='<?php echo base_url("Docente/ver_docentes/$idPlantel"); ?>';
				}
			}
		});
	}
	

	function datosPlazas(idUsuario){
		
		var idPlantel = document.getElementById("UPlantel").value;
		$.ajax({
			type: "POST",
			url: "<?php echo base_url("Docente/mostrarPlazas"); ?>",
			data: {idUsuario : idUsuario, idPlantel : idPlantel}, 
			dataType: "html",
			beforeSend: function(){
				//carga spinner
				$(".loadingPlazas").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
			},
			success: function(data){
				$(".resultPlazas").empty();
				$(".resultPlazas").append(data);  
				$(".loadingPlazas").html("");
			}
		});
	}

    function datosEstudios(idUsuario){
        
        var idPlantel = document.getElementById("UPlantel").value;
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

    $(document).on("change", ".datosNombramiento", function (event) {
        var idNombramiento = $("#UDTipo_Nombramiento option:selected").val();

        if (idNombramiento == 4) {
            $('.mostrarFechaIng').hide();
            $('.mostrarOficio').show();
            $('.mostrarFechasNom').show();
            $('.mostrarDocNom').show();
            $('.mostrarObservaciones').show();
        } else if (idNombramiento == 5) {
            $('.mostrarFechaIng').hide();
            $('.mostrarOficio').show();
            $('.mostrarFechasNom').show();
            $('.mostrarDocNom').show();
            $('.mostrarObservaciones').hide();
        } else if (idNombramiento == 6) {
            $('.mostrarFechaIng').show();
            $('.mostrarOficio').show();
            $('.mostrarFechasNom').hide();
            $('.mostrarDocNom').hide();
            $('.mostrarObservaciones').hide();
        } else if (idNombramiento == 7) {
            $('.mostrarFechaIng').show();
            $('.mostrarOficio').show();
            $('.mostrarFechasNom').hide();
            $('.mostrarDocNom').show();
            $('.mostrarObservaciones').hide();
        } else if (idNombramiento == 8) {
            $('.mostrarFechaIng').show();
            $('.mostrarOficio').show();
            $('.mostrarFechasNom').hide();
            $('.mostrarDocNom').show();
            $('.mostrarObservaciones').hide();
        } else {
            $('.mostrarFechaIng').show();
            $('.mostrarOficio').hide();
            $('.mostrarFechasNom').hide();
            $('.mostrarDocNom').hide();
            $('.mostrarObservaciones').hide();
        }

    });

    $(document).on("change", ".datosPlaza", function (event) {
        var idPlaza = $("#UDPlaza option:selected").val();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url("docente/datosPlaza_skip"); ?>",
            data: {idPlaza: idPlaza},
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data) {
                var data = data.split("::");
                $("#UDHorasGrupo").val(data[1]);
                if(data[1] != ''){
                    $(".UDHorasGrupo").addClass("disabled").attr("disabled", true);
                } else {
                    $(".UDHorasGrupo").removeClass("disabled").attr("disabled", false);
                    $("#UDHorasGrupo").val('0');
                }
                $("#UDHorasApoyo").val(data[2]);
                if(data[2] != ''){
                    $(".UDHorasApoyo").addClass("disabled").attr("disabled", true);
                } else {
                    $(".UDHorasApoyo").removeClass("disabled").attr("disabled", false);
                    $("#UDHorasApoyo").val('0');
                }
                $("#UDTipo_materia").val(data[3]);

            }
        });
    });

    $('#data_2 .input-group.date').datepicker({
        startView: 1,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "yyyy-mm-dd"
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