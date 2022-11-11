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
				<h2>Docente: <b> <?php echo nvl($usuario[0]['UApellido_pat']); ?> <?php echo nvl($usuario[0]['UApellido_mat']); ?> <?php echo nvl($usuario[0]['UNombre']); ?></b></h2>
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
                                        <div class="col-lg-1"></div>
                                        <div class="col-lg-10">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <label class="control-label" for="">Clave Servidor: <em>*</em><br /></label>
                                                        <input type="text" id="UClave_servidor" name="UClave_servidor" value="<?php echo nvl($usuario[0]['UClave_servidor']); ?>" maxlength='150' class="form-control uppercase <?php if (nvl($usuario[0]['UClave_servidor'])) echo 'disabled' ?>" />
                                                    </div>
                                                </div>
                                            </div>                                            
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label>CURP.: <em>*</em></label>
                                                        <input id="UCURP" name="UCURP" value="<?php echo nvl($usuario[0]['UCURP']); ?>" type="text" class="form-control <?php if (nvl($usuario[0]['UCURP'])) echo 'disabled'?> required"  minlength="18" maxlength="18"/>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <?php if($config['COUsarCURP']){ ?>
                                                            <button type="button" class="btn btn-default btn-sm valida_curp"><i class="fa"> Validar CURP</i></button>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div id="result_curp"></div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label>Nombre(s): <em>*</em></label>
                                                        <input type="text" placeholder="Nombre(s)" id="UNombre" name="UNombre" value="<?php echo nvl($usuario[0]['UNombre']); ?>" maxlength='150' class="form-control uppercase <?php if ($config['COUsarCURP']) echo "disabled";?> required">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>Apellido Paterno: <em>*</em></label>
                                                        <input type="text" placeholder="Paterno" id="UApellido_pat" name="UApellido_pat" value="<?php echo nvl($usuario[0]['UApellido_pat']); ?>" maxlength='150' class="form-control uppercase <?php if ($config['COUsarCURP']) echo 'disabled'?> required" />
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>Apellido Materno: <em>*</em></label>
                                                        <input type="text" placeholder="Paterno" id="UApellido_mat" name="UApellido_mat" value="<?php echo nvl($usuario[0]['UApellido_mat']); ?>" maxlength='150' class="form-control uppercase <?php if ($config['COUsarCURP']) echo 'disabled'?> required" />
                                                    </div>
                                                </div>
                                            </div>                                            
                                            
                                            <div class="form-group" id="data_2">
                                                <label>Fecha de nacimiento: <em>*</em></label>
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                    <input type="text" class="form-control fecha <?php if (nvl($usuario[0]['UFecha_nacimiento'])) echo "disabled";?>" id="UFecha_nacimiento" name="UFecha_nacimiento" value="<?php echo nvl($usuario[0]['UFecha_nacimiento']); ?>" minlength="10" maxlength="10">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Lugar de nacimiento: <em>*</em></label>
                                                <input type="text" id="ULugar_nacimiento" name="ULugar_nacimiento" value="<?php echo nvl($usuario[0]['ULugar_nacimiento']); ?>" maxlength='150' class="form-control <?php if (nvl($usuario[0]['ULugar_nacimiento'])) echo "disabled";?> required"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Clave ISSEMYM: </label>
                                                    <input type="text" id="UISSEMYM" name="UISSEMYM" value="<?php echo nvl($usuario[0]['UISSEMYM']); ?>" maxlength='150' class="form-control <?php if (nvl($usuario[0]['UISSEMYM'])) echo "disabled";?>" />
                                            </div>
                                            <div class="form-group">
                                                <label>R.F.C.: <em>*</em></label>
                                                <input id="URFC" name="URFC" value="<?php echo nvl($usuario[0]['URFC']); ?>" type="text" class="form-control <?php if (nvl($usuario[0]['URFC'])) echo "disabled";?> required"  minlength="13" maxlength="13" />
                                            </div>
                                            <div class="form-group">
                                                <label>Clave de Elector: <em>*</em></label>
                                                    <input type="text" id="UClave_elector" name="UClave_elector" value="<?php echo nvl($usuario[0]['UClave_elector']); ?>" maxlength='20' class="form-control uppercase <?php if (nvl($usuario[0]['UClave_elector'])) echo "disabled";?> required" />
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
                                                <label>Red Social: <em>*</em></label>
                                                <input type="text" id="URed_social" name="URed_social" value="<?php echo nvl($usuario[0]['URed_social']); ?>" maxlength='150' class="form-control <?php if (nvl($usuario[0]['URed_social'])) echo "disabled";?> required" />
                                            </div>
                                            <div class="form-group">
                                                <label>Sexo: <em>*</em></label>
                                                <select name="USexo" id="USexo" class="form-control <?php if (nvl($usuario[0]['USexo'])) echo "disabled";?> required" >
                                                    <option value="">- Seleccionar Sexo -</option>
                                                    <option <?php if( 'Hombre' == nvl($usuario[0]['USexo'])) echo"selected"; ?> value="Hombre">Hombre</option>
                                                    <option <?php if( 'Mujer' == nvl($usuario[0]['USexo'])) echo"selected"; ?> value="Mujer">Mujer</option>
                                                </select>
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
                                                <label>Hijos: <em>*</em></label>
                                                <select name="UHijos" id="UHijos" class="form-control <?php if (nvl($usuario[0]['UHijos'])) echo "disabled";?> required">
                                                    <option value=""></option>
                                                    <?php for($i=0;$i<20;$i++){ ?>
                                                    <option <?php if( $i == nvl($usuario[0]['UHijos'])) echo"selected"; ?> value="<?=$i?>"><?=$i?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label>Administrativo<em>*</em></label> <input id="UTipoDocente" name="UTipoDocente" type="radio" value="Adm" <?php if( nvl($usuario[0]['UTipoDocente']) == 'Adm') echo"checked"; ?>> 
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>Docente<em>*</em></label> <input id="UTipoDocente" name="UTipoDocente" type="radio" value="Doc" <?php if( nvl($usuario[0]['UTipoDocente']) == 'Doc') echo"checked"; ?>>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>Ambos<em>*</em></label> <input id="UTipoDocente" name="UTipoDocente" type="radio" value="Amb" <?php if( nvl($usuario[0]['UTipoDocente']) == 'Amb') echo"checked"; ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </fieldset>
                                <h1>Datos de la Plaza</h1>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-1"></div>
                                        <div class="col-lg-10">

                                            <div class="form-group">
                                                <label>Tipo Nombramiento: <em>*</em></label>
                                                <select name="UDTipo_Nombramiento" id="UDTipo_Nombramiento" class="form-control datosNombramiento" placeholder="Seleccionar Tipo Docente">
														<div class="form-group">
														<option value="">- Seleccionar Nombramiento -</option>
														<?php foreach($tipoDocente as $key_t => $list_t){ ?>
														<option class="<?php if($list_t['TPClave']>4) echo"nombTod"; ?>" value="<?=$list_t['TPClave'];?>"><?=$list_t['TPNombre'];?></option>
														<?php } ?>
														</div>
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

                                            <div class="form-group mostrarFechaIng2014" style="display:none;">
                                                <label>Fecha de Ingreso: <em>*</em></label>
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                    <input type="text" class="form-control fecha">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-4 mostrarFechaInicio" id="data_2" style="display:none;">
                                                        <label>Fecha de Inicio: <em>*</em></label>
                                                        <div class="input-group date">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                            <input type="text" class="form-control fecha" id="UDFecha_inicio" name="UDFecha_inicio" value="<?php echo fecha_format(nvl($usuario['UDFecha_inicio'])); ?>" minlength="10" maxlength="10">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 mostrarFechaFinal" id="data_2" style="display:none;">
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
                                                        <label>Horas CB: <em>*</em></label>
                                                        <input type="number" class="form-control UDHoras_CB" id="UDHoras_CB" name="UDHoras_CB" value="0" minlength="1" maxlength="2">
                                                    </div>
                                                    <!--<div class="col-lg-3">
                                                        <label>Horas Adicionales / Provicionales: <em>*</em></label>
                                                        <input type="number" class="form-control" id="UDHoras_provicionales" name="UDHoras_provicionales" value="0" minlength="1" maxlength="2">
                                                    </div>-->
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
                                                <label>No. de Oficio / No. de Folio: </label>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" id="UDNumOficio" name="UDNumOficio" value="" minlength="6" maxlength="24">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mostrarObservaciones">
                                                <label>Observaciones: </label>
                                                <div class="row">
                                                    <div class="col-lg-10">
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
                                            
                                            <div class="form-group col-lg-12">
                                                <input type="hidden" name="UDClave" id="UDClave" value="">
                                                <button type='button' class='btn btn-sm btn-success savePlazas pull-right'> Guardar Plazas</button>
                                            </div>
                                                <br><br>
                                            <div class="form-group col-lg-12">
                                                <div class="loadingPlazas"></div>
                                                <div id="errorPlazas"></div>
                                                <div class="msgPlazas"></div><br><br>
                                                <div class="resultPlazas"></div>
                                            </div>
                                            
                                        </div>                                       

                                    </div>
                                </fieldset>
                                
                                <h1>Estudios</h1>
                                <fieldset>
                                <div class="row"> 
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-10">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                <label>Titulado<em>*</em></label> <input id="Titulado" name="Titulado" type="radio" value="Titulado"> 
                                                </div>
                                                <div class="col-lg-4">
                                                <label>Pasante<em>*</em></label> <input id="Pasante" name="Titulado" type="radio" value="Pasante">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Nivel de Estudios: <em>*</em></label>
                                            <select id="ULNivel_estudio" name="ULNivel_estudio" class="form-control" onchange="verEstudios(value);">
                                                <option value="">-Seleccionar-</option>
                                                <?php foreach ($estudios as $e => $listEst) { ?>
                                                    <option class="<?php if($listEst['id_gradoestudios'] == 3 || $listEst['id_gradoestudios'] == 4 || $listEst['id_gradoestudios'] == 6 || $listEst['id_gradoestudios'] == 7) { echo"estudTod"; }  ?>" value="<?=$listEst['id_gradoestudios'];?>"><?=$listEst['grado_estudios'];?></option>
                                                <?php } ?> 
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Especialidad: <em>*</em></label>
                                            <div class="resultCarrera">
                                                <select name="ULLicenciatura" id="ULLicenciatura" class="form-control chosen-select" data-placeholder="Seleccionar">
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                        </div>                                        

                                        <div id="contentPasante">
                                            <div class="form-group" id="documento">
                                                <div class="row">
                                                    <label class="col-lg-3">Documento Título y/o Cédula Profesional: </label>
                                                    <div class="col-lg-6">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <span class="btn btn-primary btn-file"><span class="fileinput-new">Seleccionar Documento</span><span class="fileinput-exists">Cambiar</span><input type="file" name="UPDocTitulo_file" id="UPDocTitulo_file" accept="application/pdf"></span>
                                                        <span class="fileinput-filename"></span>
                                                        <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                                                    </div>
                                                    </div>
                                                    <!--<div class="col-lg-3">
                                                    <button type='button' class='btn btn-sm btn-danger douploadTitulo'> Subir Archivo</button>
                                                    </div>-->
                                                </div>
                                            </div>

                                            <!--<div class="form-group">
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
                                            </div>-->
                                            
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <label>No. de Cédula Profesional: </label>
                                                        <input id="ULCedulaProf" name="ULCedulaProf" value="<?php echo nvl($usuario['ULCedulaProf']); ?>" type="text" class="form-control "  minlength="6" maxlength="10" />
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                        <?php if( is_permitido(null,'generarplantilla','save')) { ?>
                                            <div class="form-group col-lg-12">
                                                <input type="hidden" name="ULClave" id="ULClave" value="">
                                                <button type='button' class='btn btn-sm btn-success saveEstudios pull-right '> Guardar Estudios</button>
                                            </div>
                                        <?php } ?>
                                        <br><br><br>
                                        <div class="form-group col-lg-12">
                                            <div class="loadingEstudios"></div>
                                            <div class="msgEstudios"></div>
                                            <div class="resultEstudios"></div>
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
<script>
    function verEstudios(idEstudios, ULLicenciatura = null) {
        $.ajax({
                type: "POST",
                url: "<?php echo base_url("Docente/mostrarCarreras"); ?>",
                data: {tipo : idEstudios},
                dataType: "html",
                beforeSend: function(){
                    //carga spinner
                    $(".loadingArchivo").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
                },
                success: function(data){
                    $(".resultCarrera").empty();
                    $(".resultCarrera").append(data);  
                    $(".loadingArchivo").html("");
                    if (ULLicenciatura) {
                        $("#ULLicenciatura").val(ULLicenciatura).trigger("chosen:updated");
                    }
                }
            });
        }
    
</script>
<script type="text/javascript">
	$(document).ready(function() {
        //$(".UDHorasGrupo").addClass("disabled").attr("disabled", true);
        //$(".UDHorasApoyo").addClass("disabled").attr("disabled", true);

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
            formData.append("UDHoras_CB", document.getElementById("UDHoras_CB").value);
            //formData.append("UDHoras_provicionales", document.getElementById("UDHoras_provicionales").value);

            formData.append("UDFecha_inicio",  document.getElementById("UDFecha_inicio").value);
            formData.append("UDFecha_final", document.getElementById("UDFecha_final").value);
            formData.append("UDObservaciones", document.getElementById("UDObservaciones").value);

            formData.append("UDNombramiento_file", UDNombramiento_file.files[0]);

            formData.append("UDClave", document.getElementById("UDClave").value);
            
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
//                        $("#tipoNombramiento").val($data[3]);

                        $("#UDTipo_Nombramiento").val('');
                        $("#UDFecha_ingreso").val('');
						$("#UDPlaza").val('');
						$("#UDTipo_materia").val('');
                        $("#UDHorasGrupo").val('');
                        $("#UDHorasApoyo").val('');
                        $("#UDHoras_CB").val('');
                        $("#UDNumOficio").val('');
                        
                        $("#UDFecha_inicio").val('');
                        $("#UDFecha_final").val('');
                        $("#UDObservaciones").val('');

                        $("#UDNombramiento_file").val('');
                        $("#UDClave").val('');
                        
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
            formData.append("ULClave", document.getElementById("ULClave").value);
            formData.append("ULUsuario", document.getElementById("UNCI_usuario").value);
            formData.append("ULPlantel", document.getElementById("UPlantel").value);
            formData.append("ULNivel_estudio", document.getElementById("ULNivel_estudio").value);
            formData.append("ULLicenciatura", document.getElementById("ULLicenciatura").value);
            formData.append("ULTitulo_file", UPDocTitulo_file.files[0]);
            //formData.append("ULCedula_file", UPDocCedula_file.files[0]);
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
                        $('#Titulado').prop('checked', false);
                        $('#Pasante').prop('checked', false);
                        $('#ULNivel_estudio').val('').trigger('change');
                        $('#ULLicenciatura').val('').trigger('chosen:updated');
                        //$("#ULNivel_estudio").val("");
                        $("#ULClave").val("");
                        
                        $("#ULCedulaProf").val("");

	                    $(".loadingEstudios").html("");
	                } else {
	                    $(".msgEstudios").empty();
	                    $(".msgEstudios").append(data[0]);  
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
                        if (!form.length) {
                            save(form);
                        }
                        var idUsuario = document.getElementById("UNCI_usuario").value;
                        datosPlazas(idUsuario);
					}

                    if(newIndex == '2'){
						var idUsuario = document.getElementById("UNCI_usuario").value;
                        datosEstudios(idUsuario);
                        var tiponombramiento = document.getElementById("tipoNombramiento").value;
                        if (tiponombramiento == '1' ) {
                            $('#documento').hide();
                        }
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
                form.validate().settings.ignore = ":disabled";

                // Start validation; Prevent form submission if false
                return form.valid();
            },            
            //onFinished: function (event, currentIndex)
            onFinished: function (event)
            {
                //recogemos la dirección del Proceso PHP
				mensaje = "¿Estás seguro finalizar?";
				//colocamos fondo de pantalla
				$('#wrapper').prop('class','bgtransparent');				
				alertify.confirm(mensaje, function (e) {
					//aqui introducimos lo que haremos tras cerrar la alerta.
					$('#wrapper').prop('class','');
					if (e){
                        window.location.href = "<?= base_url("Docente/ver_docentes/$idPlantel"); ?>";
					}
				});     /*var form = $(this);
                // Submit form input
                //form.submit();
                save(form,true);*/
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
		$.ajax({
			type: "POST",
			url: "<?php echo base_url("Docente/mostrarPlazas_skip"); ?>",
			data: {idUsuario : idUsuario, idPlantel : document.getElementById("UPlantel").value}, 
			dataType: "html",
			beforeSend: function(){
				//carga spinner
				$(".loadingPlazas").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
			},
			success: function(data){
                var data = data.split("::");                
                if (data[0] == 1 || data[0] == 2 || data[0] == 3 || data[0] == 4){
                    $('.nombTod').attr("disabled",false);
                    $(".resultPlazas").empty();
                    $(".resultPlazas").append(data[1]);  
                    $(".loadingPlazas").html("");
                } else {
                    $('.nombTod').attr("disabled",true);
                    $(".resultPlazas").empty();
                    $(".resultPlazas").append(data[1]);  
                    $(".loadingPlazas").html("");
                    
                }
			}
		});
	}

    function datosEstudios(idUsuario){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("docente/mostrarEstudios"); ?>",
            data: {idUsuario : idUsuario, idPlantel : document.getElementById("UPlantel").value}, 
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data){
                var data = data.split("::");
                if (data[0] == 0){
                    $('.estudTod').attr("disabled",true);
                    $(".resultEstudios").empty();
                    $(".resultEstudios").append(data[1]);  
                    $(".loading").html("");
                } else {
                    $('.estudTod').attr("disabled",false);
                    $(".resultEstudios").empty();
                    $(".resultEstudios").append(data[1]);  
                    $(".loading").html("");
                    
                }
            }
        });
    }

    $(document).on("change", ".datosNombramiento", function (event) {
        var idNombramiento = $("#UDTipo_Nombramiento option:selected").val();

        if (idNombramiento == 3) {
            $('.mostrarFechaIng').show();
            $('.mostrarFechaIng2014').hide();            
            $('.mostrarOficio').show();
            $('.mostrarFechaInicio').hide();
            $('.mostrarFechaFinal').hide();
            $('.mostrarDocNom').show();
            
        } else if (idNombramiento == 4) {
            $('.mostrarFechaIng').hide();
            $('.mostrarFechaIng2014').hide();
            $('.mostrarOficio').show();
            $('.mostrarFechaInicio').show();
            $('.mostrarFechaFinal').show();
            $('.mostrarDocNom').show();
            
        } else if (idNombramiento == 5) {
            $('.mostrarFechaIng').hide();
            $('.mostrarFechaIng2014').hide();
            $('.mostrarOficio').show();
            $('.mostrarFechaInicio').show();
            $('.mostrarFechaFinal').show();
            $('.mostrarDocNom').show();
            
        } else if (idNombramiento == 6) {
            $('.mostrarFechaIng').hide();
            $('.mostrarFechaIng2014').hide();
            $('.mostrarOficio').show();
            $('.mostrarFechaInicio').show();
            $('.mostrarFechaFinal').show();
            $('.mostrarDocNom').show();
            
        } else if (idNombramiento == 7) {
            $('.mostrarFechaIng').hide();
            $('.mostrarFechaIng2014').show();
            $('.mostrarOficio').show();
            $('.mostrarFechaInicio').hide();
            $('.mostrarFechaFinal').hide();
            $('.mostrarDocNom').show();
            
        } else if (idNombramiento == 8) {
            $('.mostrarFechaIng').hide();
            $('.mostrarFechaIng2014').hide();
            $('.mostrarOficio').show();
            $('.mostrarFechaInicio').show();
            $('.mostrarFechaFinal').hide();
            $('.mostrarDocNom').show();
            
        } else {
            $('.mostrarFechaIng').show();
            $('.mostrarFechaIng2014').hide();
            $('.mostrarOficio').hide();
            $('.mostrarFechaInicio').hide();
            $('.mostrarFechaFinal').hide();
            $('.mostrarDocNom').hide();
            
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
                    $("#UDHoras_CB").val('0');
                } else {
                    $(".UDHorasGrupo").removeClass("disabled").attr("disabled", false);
                    $("#UDHorasGrupo").val('0');
                }
                $("#UDHorasApoyo").val(data[2]);
                if(data[2] != ''){
                    $(".UDHorasApoyo").addClass("disabled").attr("disabled", true);
                    $("#UDHoras_CB").val('0');
                } else {
                    $(".UDHorasApoyo").removeClass("disabled").attr("disabled", true);
                    $("#UDHorasApoyo").val('0');
                }
                if (idPlaza == '11' || idPlaza == '12' || idPlaza == '13' || idPlaza == '14' || idPlaza == '15') {
                    $(".UDHorasGrupo").removeClass("disabled").attr("disabled", false);
                    $("#UDHorasGrupo").val('0');
                    $(".UDHorasApoyo").addClass("disabled").attr("disabled", true);
                    $("#UDHorasApoyo").val('0');
                    $(".UDHoras_CB").removeClass("disabled").attr("disabled", false);
                    $("#UDHoras_CB").val('0');

                    $("#UDHorasGrupo").change(function(){
                        if($(this).val() != ''){
                            $(".UDHoras_CB").addClass("disabled").attr("disabled", true);
                        }
                        if ($(this).val() == 0) {
                            $(".UDHoras_CB").removeClass("disabled").attr("disabled", false);
                        }
                    });

                    $("#UDHoras_CB").change(function(){
                        if($(this).val() != ''){
                            $(".UDHorasGrupo").addClass("disabled").attr("disabled", true);
                        }
                        if($(this).val() == 0){
                            $(".UDHorasGrupo").removeClass("disabled").attr("disabled", false);
                        }
                    });
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
    
    $('.chosen-select').chosen(); 

    //$(".valida_curp").click(function() {
    $("#UCURP, .valida_curp").on('change click',function() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("personal/ver_curp"); ?>",
            data: $(this.form).serialize(),
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data){
                var data = data.split("|");
                $("#UApellido_pat").val( data[1] );
                $("#UApellido_mat").val( data[2] );
                $("#UNombre").val( data[3] );
                $("#UFecha_nacimiento").val( data[4] );
                if( data[5]=='H'){
                    $("#USexo").val( 'Hombre' );
                }else if( data[5]=='M'){
                    $("#USexo").val( 'Mujer' );
                }
                $("#result_curp").empty();
                $("#result_curp").append(data[0]);
                $(".loading").html("");
            }
        });
    });//----->fin
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