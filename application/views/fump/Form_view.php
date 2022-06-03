<link href="<?php echo base_url('assets/inspinia/css/plugins/steps/jquery.steps.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/iCheck/custom.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/chosen/chosen.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/datapicker/datepicker3.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/inspinia/css/plugins/clockpicker/clockpicker.css'); ?>" rel="stylesheet" />	
<div class="row">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
			<h3><?php echo $titulo; ?> (<span class="text-danger">F<b id="FTexto"><?=folio(@$fump['FClave'])?></b></span>)</h3> 
			<h3><?=$datos['UNombre']." ".$datos['UApellido_pat']." ".$datos['UApellido_mat']?></h3> 
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
									<h3>FORMATO ÚNICO DE MOVIMIENTOS DE PERSONAL (FUMP)</h3>
								</div>
								<div class="ibox-content">
								<form action="<?php echo base_url("fump/save"); ?>" name="form" id="form" role="form" method="POST" class="wizard-big form-horizontal">
								<h1>ADSCRIPCIÓN</h1>
								<input type="hidden" name="FClave_skip" id="FClave_skip" value="<?=$FClave_skip?>" />
								<fieldset>
									<h2>ADSCRIPCIÓN</h2>
									<div class="row">
										<div class="col-lg-8">
											<?php if(@$fump['FAutorizo_1'] and !@$seguimiento[0]['SEAdscripcion']) echo'<div class="sombra"></div>'; ?>
											<div class="form-group">
												<label>DIRECCIÓN DE ÁREA / PLANTEL / EMSAD: <em>*</em></label>
												<?php 
												$plantel = get_session("UPlantel");
												if(nvl($fump)){
													$plantel = $fump['FPlantel'];
													$plantel = str_replace('CENTRO ','',$plantel);
													$plantel = str_replace('PLANTEL ','',$plantel);
													$depto = $plantel;
													if($fump['FDepartamento']){
														$depto = $fump['FDepartamento'];
													}
												}
												?>
												<select name="FPlantel" id="FPlantel" class="form-control required chosen-select" data-placeholder="Seleccionar plantel">
													<?php foreach($planteles as $key => $list){ ?>
													<option <?php if( $plantel == $list['CPLClave'] or $plantel == $list['CPLNombre'] ) echo "selected"; ?> value="<?php echo $list['direccion']; ?>"><?php echo $list['direccion']; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="form-group">
												<label>DEPARTAMENTO: <em>*</em></label>
												<select name="FDepartamento" id="FDepartamento" class="form-control required">
													<option value=""></option>
													<?php foreach($departamentos as $key => $list){ ?>
													<option <?php if( $plantel == $list['CPLClave'] or nvl($depto) == $list['CPLNombre'] ){ $CPLCorreo_electronico=$list['CPLCorreo_electronico']; $CPLTipo=$list['CPLTipo']; $UNombre=$list['CPLDirector']; $CPLCoordinacion=$list['CPLCoordinacion']; echo "selected";} ?> value="<?php echo $list['CPLNombre']; ?>"><?php echo $list['CPLNombre']; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="form-group">
												<label>E-MAIL: <em>*</em></label>
												<input id="FCorreo_electronico_plantel" name="FCorreo_electronico_plantel" type="text" value="<?php echo nvl($CPLCorreo_electronico); ?>" class="form-control required email disabled">
												<input type="hidden" id="Tipo_plantel_skip" name="Tipo_plantel_skip" value="<?php echo nvl($CPLTipo); ?>" />
												<input type="hidden" id="CPLCoordinacion_skip" name="CPLCoordinacion_skip" value="<?php echo nvl($CPLCoordinacion); ?>" />
												<input type="hidden" id="FDirector" name="FDirector" value="<?=nvl($UNombre)?>" />
											</div>
										</div>
										<div class="col-lg-4">
											<div class="text-center">
												<div style="margin-top: 20px">
													<?php
													$correciones = "";
													foreach($seguimiento as $key_s => $list_s){
														$nombre = $list_s['UNombre']." ".$list_s['UApellido_pat']." ".$list_s['UApellido_mat'];
														$fecha = fecha_format($list_s['SEFecha_registro']);
														$texto = $list_s['SEAdscripcion'];
														if($texto){
															$SEfecha_correcion = fecha_format($list_s['SEfecha_correcion']);
															$correciones.= "<b>$nombre</b> <br />";
															$correciones.= "<b><small>$fecha</small></b>";
															if($SEfecha_correcion){
															$correciones.= "<p class='text-info'>$texto<br />";
															$correciones.= "<small>$SEfecha_correcion</small> <i class='fa fa-check'></i>";
															$correciones.= "</p>";
															}else{
															$correciones.= "<p class='text-danger'>$texto";
															$correciones.= "</p>";
															}
														}
													}
													if($correciones){
													?>
													<div class="alert alert-warning">
														<h3 class="text-center">CORRECCIONES</h3>
														<div width="100%" class="text-justify">
															<?=$correciones?>
														</div>
													</div>
													<?php }else{ ?>
													<i class="fa fa-sign-in" style="font-size: 180px;color: #e5e5e5 "></i>
													<?php }?>
												</div>
											</div>
										</div>
									</div>
								</fieldset>
								<h1>DATOS GENERALES</h1>
								<fieldset>
									<h2>DATOS GENERALES DEL SERVIDOR PUBLICO</h2>
									<div class="row">
										<div class="col-lg-8">
											<?php if(@$fump['FAutorizo_1'] and !@$seguimiento[0]['SEDatos_generales']) echo'<div class="sombra"></div>'; ?>
											<div class="form-group">
												<label>NOMBRE(S) / PATERNO / MATERNO: <em>*</em></label>
												<div class="row">
													<div class="col-lg-4">
														<input id="FNombre" name="FNombre" value="<?php echo nvl($usuario['UNombre']); ?><?php echo nvl($fump['FNombre']); ?>" type="text" class="form-control required">
													</div>
													<div class="col-lg-4">
														<input id="FApellido_pat" name="FApellido_pat" value="<?php echo nvl($usuario['UApellido_pat']); ?><?php echo nvl($fump['FApellido_pat']); ?>" type="text" class="form-control required">
													</div>
													<div class="col-lg-4">
														<input id="FApellido_mat" name="FApellido_mat" value="<?php echo nvl($usuario['UApellido_mat']); ?><?php echo nvl($fump['FApellido_mat']); ?>" type="text" class="form-control required">
													</div>
												</div>
											</div>
											<div class="form-group">
												<label>CLAVE ISSEMYM: </label>
												<input id="FISSEMYM" name="FISSEMYM" value="<?php echo nvl($usuario['UISSEMYM']); ?><?php echo nvl($fump['FISSEMYM']); ?>" type="text" class="form-control" minlength="1">
											</div>
											<div class="form-group">
												<label>FECHA DE NACIMIENTO: <em>*</em></label>
												<input id="FFecha_nacimiento" name="FFecha_nacimiento" value="<?php echo fecha_format(nvl($usuario['UFecha_nacimiento'])); ?><?php echo fecha_format(nvl($fump['FFecha_nacimiento'])); ?>" type="text" class="form-control required fecha" minlength="10" maxlength="10" />
											</div>
											<div class="form-group">
												<label>R.F.C.: <em>*</em></label>
												<input id="FRFC" name="FRFC" value="<?php echo nvl($usuario['URFC']); ?><?php echo nvl($fump['FRFC']); ?>" type="text" class="form-control required"  minlength="13" maxlength="13" />
											</div>
											<div class="form-group">
												<label>CURP.: <em>*</em></label>
												<input id="FCURP" name="FCURP" value="<?php echo nvl($usuario['UCURP']); ?><?php echo nvl($fump['FCURP']); ?>" type="text" class="form-control required"  minlength="18" maxlength="18" />
											</div>
											<div class="form-group">
												<label>DOMICILIO: <em>*</em></label>
												<input id="FDomicilio" name="FDomicilio" value="<?php echo nvl($usuario['UDomicilio']); ?><?php echo nvl($fump['FDomicilio']); ?>" type="text" class="form-control required" minlength="3" />
											</div>
											<div class="form-group">
												<label>COLONIA: <em>*</em></label>
												<input id="FColonia" name="FColonia" value="<?php echo nvl($usuario['UColonia']); ?><?php echo nvl($fump['FColonia']); ?>" type="text" class="form-control required" minlength="3" />
											</div>
											<div class="form-group">
												<label>MUNICIPIO: <em>*</em></label>
												<input id="FMunicipio" name="FMunicipio" value="<?php echo nvl($usuario['UMunicipio']); ?><?php echo nvl($fump['FMunicipio']); ?>" type="text" class="form-control required" minlength="3" />
											</div>
											<div class="form-group">
												<label>C.P: <em>*</em></label>
												<input id="FCP" name="FCP" value="<?php echo nvl($usuario['UCP']); ?><?php echo nvl($fump['FCP']); ?>" type="text" class="form-control required" minlength="5" maxlength="5" />
											</div>
											<div class="form-group">
												<label>TEL. MOVIL: <em>*</em></label>
												<input id="FTelefono_movil" name="FTelefono_movil" value="<?php echo nvl($usuario['UTelefono_movil']); ?><?php echo nvl($fump['FTelefono_movil']); ?>" type="text" class="form-control required" minlength="5">
											</div>
											<div class="form-group">
												<label>TEL. CASA: <em>*</em></label>
												<input id="FTelefono_casa" name="FTelefono_casa" value="<?php echo nvl($usuario['UTelefono_casa']); ?><?php echo nvl($fump['FTelefono_casa']); ?>" type="text" class="form-control required" minlength="5">
											</div>
											<div class="form-group">
												<label>LUGAR DE NACIMIENTO: <em>*</em></label>
												<input id="FLugar_nacimiento" name="FLugar_nacimiento" value="<?php echo nvl($usuario['ULugar_nacimiento']); ?><?php echo nvl($fump['FLugar_nacimiento']); ?>" type="text" class="form-control required" minlength="3" maxlength="254">
											</div>
											<div class="form-group">
												<label>ESTADO CIVIL: <em>*</em></label>
												<select id="FEstado_civil" name="FEstado_civil" class="form-control required">
													<option value=""></option>
													<?php foreach($estado_civil as $key => $list){ ?>
													<option <?php if( $list['ECNombre'] == nvl($usuario['UEstado_civil']) or $list['ECNombre'] == nvl($fump['FEstado_civil']) ) echo"selected"; ?> value="<?=$list['ECNombre'];?>"><?=$list['ECNombre'];?></option>
													<?php } ?>
												</select>
											</div>
											<div class="form-group">
												<label>ESCOLARIDAD: <em>*</em></label>
												<input id="FEscolaridad" name="FEscolaridad" value="<?php echo nvl($usuario['UEscolaridad']); ?><?php echo nvl($fump['FEscolaridad']); ?>" type="text" class="form-control required" minlength="3" maxlength="254">
											</div>
											<div class="form-group">
												<label>E-MAIL: <em>*</em></label>
												<input id="FCorreo_electronico_servidor" name="FCorreo_electronico_servidor" value="<?php echo nvl($usuario['UCorreo_electronico']); ?><?php echo nvl($fump['FCorreo_electronico_servidor']); ?>" type="text" class="form-control required email">
											</div>
										</div>
										<div class="col-lg-4">
											<div class="text-center">
												<div style="margin-top: 20px">
													<?php
													$correciones = "";
													foreach($seguimiento as $key_s => $list_s){
														$nombre = $list_s['UNombre']." ".$list_s['UApellido_pat']." ".$list_s['UApellido_mat'];
														$fecha = fecha_format($list_s['SEFecha_registro']);
														$texto = $list_s['SEDatos_generales'];
														if($texto){
															$SEfecha_correcion = fecha_format($list_s['SEfecha_correcion']);
															$correciones.= "<b>$nombre</b> <br />";
															$correciones.= "<b><small>$fecha</small></b>";
															if($SEfecha_correcion){
															$correciones.= "<p class='text-info'>$texto<br />";
															$correciones.= "<small>$SEfecha_correcion</small> <i class='fa fa-check'></i>";
															$correciones.= "</p>";
															}else{
															$correciones.= "<p class='text-danger'>$texto";
															$correciones.= "</p>";
															}
														}
													}
													if($correciones){
													?>
													<div class="alert alert-warning">
														<h3 class="text-center">CORRECCIONES</h3>
														<div width="100%" class="text-justify">
															<?=$correciones?>
														</div>
													</div>
													<?php }else{ ?>
													<i class="fa fa-sign-in" style="font-size: 180px;color: #e5e5e5 "></i>
													<?php }?>
												</div>
											</div>
										</div>
									</div>
								</fieldset>								
								<h1>TRÁMITE</h1>
								<fieldset>
									<h2>TRÁMITE</h2>
									<?php $FTramite = explode(";",nvl($fump['FTramite'])); ?>
									<div class="row">
										<div class="col-lg-8">
											<?php if(@$fump['FAutorizo_1'] and !@$seguimiento[0]['SETramite']) echo'<div class="sombra"></div>'; ?>
											<div class="row">
												<div class="col-lg-4">
													<div class="i-checks"><label> <input type="checkbox" <?php if( in_array("ALTA", $FTramite) ) echo"checked"; ?> class="form-control required FTramite" name="FTramite[]" id="FTramite" value="ALTA" /> ALTA </label></div>
													<!--div class="i-checks"><label> &nbsp; </label></div-->
													<div class="i-checks"><label> <input type="checkbox" <?php if( in_array("BAJA", $FTramite) ) echo"checked"; ?> class="form-control required FTramite" name="FTramite[]" id="FTramite" value="BAJA" /> BAJA </label></div>
													<div class="i-checks"><label> <input type="checkbox" <?php if( in_array("RENUNCIA A GRATIFICACIÓN BUROCRATICA", $FTramite) ) echo"checked"; ?> class="form-control required FTramite" name="FTramite[]" id="FTramite" value="RENUNCIA A GRATIFICACIÓN BUROCRATICA" /> RENUNCIA A GRATIFICACIÓN BUROCRATICA </label></div>
												</div>
												<div class="col-lg-4">
													<div class="i-checks"><label> <input type="checkbox" <?php if( in_array("INTERINATO", $FTramite) ) echo"checked"; ?> class="form-control FTramite FTramite_i" name="FTramite[]" id="FTramite" value="INTERINATO" /> INTERINATO </label></div>
													<div class="i-checks"><label> <input type="checkbox" <?php if( in_array("LICENCIA SIN GOCE DE SUELDO", $FTramite) ) echo"checked"; ?> class="form-control required FTramite" name="FTramite[]" id="FTramite" value="LICENCIA SIN GOCE DE SUELDO" /> LICENCIA SIN GOCE DE SUELDO </label></div>
													<div class="i-checks"><label> <input type="checkbox" <?php if( in_array("CAMBIO DE PLAZA", $FTramite) ) echo"checked"; ?> class="form-control required FTramite" name="FTramite[]" id="FTramite" value="CAMBIO DE PLAZA" /> CAMBIO DE PLAZA </label></div>
												</div>
												<div class="col-lg-4">
													<div class="i-checks"><label> <input type="checkbox" <?php if( in_array("INCREMENTO/DISMINUCIÓN DE HRS. CLASE", $FTramite) ) echo"checked"; ?> class="form-control required FTramite" name="FTramite[]" id="FTramite" value="INCREMENTO/DISMINUCIÓN DE HRS. CLASE" /> INCREMENTO/DISMINUCIÓN DE HRS. CLASE </label></div>
													<div class="i-checks"><label> <input type="checkbox" <?php if( in_array("CAMBIO DE ADSCRIPCIÓN", $FTramite) ) echo"checked"; ?> class="form-control required FTramite" name="FTramite[]" id="FTramite" value="CAMBIO DE ADSCRIPCIÓN" /> CAMBIO DE ADSCRIPCIÓN </label></div>
													<div class="i-checks"><label> <input type="checkbox" <?php if( in_array("OTRO", $FTramite) ) echo"checked"; ?> class="form-control required FTramite" name="FTramite[]" id="FTramite" value="OTRO" /> OTRO </label>
														<?php $FTramite_otro = nvl($fump['FTramite_otro']); ?>
														<select id="FTramite_otro" name="FTramite_otro" class="form-control" >
															<option value="<?=$FTramite_otro?>"><?=$FTramite_otro?></option>
														</select>
													</div>
												</div>
											</div>
											<div class="row ISSEMYM14">
												<div class="col-lg-12">
												<br />
												<h2>INFORMACIÓN COMPLEMENTARIA</h2>
												<div class="i-checks"><label for=""><input type="checkbox" class="form-control" name="FISSEMYM14" id="FISSEMYM14" <?php if(nvl($fump['FISSEMYM14'])) echo "checked"; ?> /> Cobro ISSEMYM %1.4 (5542)</label></div>
												<?php echo forma_archivo("FISSEMYM_file", nvl($fump['FISSEMYM_file']), "Adjuntar documeto comprobatorio ",'btn-primary pull-left'); ?>
											</div>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="text-center">
												<div style="margin-top: 20px">
													<?php
													$correciones = "";
													foreach($seguimiento as $key_s => $list_s){
														$nombre = $list_s['UNombre']." ".$list_s['UApellido_pat']." ".$list_s['UApellido_mat'];
														$fecha = fecha_format($list_s['SEFecha_registro']);
														$texto = $list_s['SETramite'];
														if($texto){
															$SEfecha_correcion = fecha_format($list_s['SEfecha_correcion']);
															$correciones.= "<b>$nombre</b> <br />";
															$correciones.= "<b><small>$fecha</small></b>";
															if($SEfecha_correcion){
															$correciones.= "<p class='text-info'>$texto<br />";
															$correciones.= "<small>$SEfecha_correcion</small> <i class='fa fa-check'></i>";
															$correciones.= "</p>";
															}else{
															$correciones.= "<p class='text-danger'>$texto";
															$correciones.= "</p>";
															}
														}
													}
													if($correciones){
													?>
													<div class="alert alert-warning">
														<h3 class="text-center">CORRECCIONES</h3>
														<div width="100%" class="text-justify">
															<?=$correciones?>
														</div>
													</div>
													<?php }else{ ?>
													<i class="fa fa-sign-in" style="font-size: 180px;color: #e5e5e5 "></i>
													<?php } ?>
												</div>
											</div>
										</div>
									</div>
								</fieldset>
								<h1>DATOS DE LA PLAZA</h1>
								<fieldset>
									<h2>DATOS DE LA PLAZA</h2>
									<div class="row">
									<div class="col-lg-8">
									<?php if(@$fump['FAutorizo_1'] and !@$seguimiento[0]['SEDatos_plaza']) echo'<div class="sombra"></div>'; ?>
										<div class="form-group">
											<label>CLAVE DE EMPLEADO: <em>*</em></label>
											<input id="FClave_servidor" name="FClave_servidor" value="<?php echo nvl($usuario["UClave_servidor"]); ?><?php echo nvl($fump["FClave_servidor"]); ?>" type="text" class="form-control plantel hidden <?php if($fump["FClave_servidor"]) echo"disabled"; ?>" <?php if($fump["FClave_servidor"]) echo"disabled"; ?> required />
											<input id="FClave_servidor" name="FClave_servidor" value="<?php echo nvl($usuario["UClave_servidor_centro"]); ?><?php echo nvl($fump["FClave_servidor"]); ?>" type="text" class="form-control centro hidden <?php if($fump["FClave_servidor"]) echo"disabled"; ?>" <?php if($fump["FClave_servidor"]) echo"disabled"; ?> required />
										</div>
										<div class="row">
											<div class="col-lg-4">
												<div class="form-group">
													<label>TIPO DE PLAZA: <em>*</em></label>
													<div class="i-checks"><input type="radio" class="form-control required" <?php if(nvl($fump['FTipo_plaza'])== "ADMINSTRATIVO") echo"checked"; ?> name="FTipo_plaza" id="FTipo_plaza" value="ADMINSTRATIVO" /> ADMINSTRATIVO </div>
													<div class="i-checks"><input type="radio" class="form-control required" <?php if(nvl($fump['FTipo_plaza'])== "ACADÉMICO") echo"checked"; ?> name="FTipo_plaza" id="FTipo_plaza" value="ACADÉMICO" /> ACADÉMICO </div>
													<div class="i-checks"><input type="radio" class="form-control required" <?php if(nvl($fump['FTipo_plaza'])== "DIRECTIVO O CONFIANZA") echo"checked"; ?> name="FTipo_plaza" id="FTipo_plaza" value="DIRECTIVO O CONFIANZA" /> DIRECTIVO O CONFIANZA </div>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="form-group">
													<label>TIPO DE HORAS CLASE: <em>*</em></label>
													<div class="i-checks"><input type="radio" class="form-control hp disabled required" <?php if(nvl($fump['FTipo_horas_clase'])== "PROFE CB-I") echo"checked"; ?> disabled name="FTipo_horas_clase" id="FTipo_horas_clase" value="PROFE CB-I" /> PROFE CB-I </div>
													<div class="i-checks"><input type="radio" class="form-control ht disabled required" <?php if(nvl($fump['FTipo_horas_clase'])== "TÉCNICO CB-I") echo"checked"; ?> disabled name="FTipo_horas_clase" id="FTipo_horas_clase" value="TÉCNICO CB-I" /> TÉCNICO CB-I </div>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="form-group">
													<label>TIPO DE ASIGNATURA: <em>*</em></label>
													<div class="i-checks"><input type="radio" class="form-control tipo required disabled" <?php if(nvl($fump['FTipo_asignatura'])== "CURRICULARES") echo"checked"; ?> disabled name="FTipo_asignatura" id="FTipo_asignatura" value="CURRICULARES" /> CURRICULARES </div>
													<div class="i-checks"><input type="radio" class="form-control tipo required disabled" <?php if(nvl($fump['FTipo_asignatura'])== "COCURRICULARES") echo"checked"; ?> disabled name="FTipo_asignatura" id="FTipo_asignatura" value="COCURRICULARES" /> COCURRICULARES </div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-4">
												<div class="form-group">
													<label>NO. DE HRS. QUE INCREMENTA: </label>
													<input id="FHoras_incrementa" name="FHoras_incrementa" value="<?php echo nvl($fump['FHoras_incrementa']); if(!$fump['FHoras_incrementa']) echo"0"; ?>" type="text" class="form-control disabled horas" disabled>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="form-group">
													<label>NO. DE HRS. QUE DISMINUYE: </label>
													<input id="FHoras_disminuye" name="FHoras_disminuye" value="<?php echo nvl($fump['FHoras_disminuye']); if(!$fump['FHoras_disminuye']) echo"0"; ?>" type="text" class="form-control disabled horas" disabled>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="form-group">
													<label>NO. DE HORAS-CLASE TOTALES: <em>*</em></label>
													<input id="FHoras_clase_totales" name="FHoras_clase_totales" value="<?php echo nvl($fump['FHoras_clase_totales']); if(!$fump['FHoras_clase_totales']) echo"0"; ?>" type="text" min="0" max="40" class="form-control horas_t required">
												</div>
											</div>
										</div>
										<div class="form-group"><label>TIPO DE JORNADA: <em>*</em></label></div>
										<div class="row">
											<div class="col-lg-3">
												<div class="form-group">
													<div class="i-checks"><input type="radio" class="form-control jornada disabled" <?php if(nvl($fump['FTipo_jornada'])== "JORNADA 1/2 TIEMPO") echo"checked"; ?> disabled name="FTipo_jornada" id="FTipo_jornada" value="JORNADA 1/2 TIEMPO" /> JORNADA 1/2 TIEMPO </div>
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group">
													<div class="i-checks"><input type="radio" class="form-control jornada disabled" <?php if(nvl($fump['FTipo_jornada'])== "JORNADA 3/4 DE TIEMPO") echo"checked"; ?> disabled name="FTipo_jornada" id="FTipo_jornada" value="JORNADA 3/4 DE TIEMPO" /> JORNADA 3/4 DE TIEMPO </div>
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group">
													<div class="i-checks"><input type="radio" class="form-control jornada disabled" <?php if(nvl($fump['FTipo_jornada'])== "JORNADA TIEMPO COMP.") echo"checked"; ?> disabled name="FTipo_jornada" id="FTipo_jornada" value="JORNADA TIEMPO COMP." /> JORNADA TIEMPO COMP. </div>
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group">
													<div class="i-checks"><input type="radio" class="form-control jornada disabled" disabled name="FTipo_jornada" id="FTipo_jornada" value="" /> NINGUNA </div>
												</div>
											</div>
										</div>
										<div class="form-group"><label>NÚM. DE HRS. EXTRAS: <em>*</em></label></div>
										<div class="row">
											<div class="col-lg-3">
												<div class="form-group">
													TÉCNICO CB-I: <input id="FExtra_tecnico_cbi" name="FExtra_tecnico_cbi" value="<?php echo nvl($fump['FExtra_tecnico_cbi']); ?>" type="text" class="form-control disabled tecnico" />
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group">
													PROFE CB-I: <input id="FExtra_profe_cbi" name="FExtra_profe_cbi" value="<?php echo nvl($fump['FExtra_profe_cbi']); ?>" type="text" class="form-control disabled profesor" />
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group">
													PROFE CB-II: <input id="FExtra_profe_cbii" name="FExtra_profe_cbii" value="<?php echo nvl($fump['FExtra_profe_cbii']); ?>" type="text" class="form-control disabled profesor" />
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group">
													PROFE CB-III: <input id="FExtra_profe_cbiii" name="FExtra_profe_cbiii" value="<?php echo nvl($fump['FExtra_profe_cbiii']); ?>" type="text" class="form-control disabled profesor" />
												</div>
											</div>
										</div>
										<div class="form-group"><label>NÚM. DE HRS. POR RECATEGORIZACIÓN A: <em>*</em></label></div>
										<div class="row">
											<div class="col-lg-3">
												<div class="form-group">
													TÉCNICO CB-II: <input id="FRecate_tecnico_cbii" name="FRecate_tecnico_cbii" value="<?php echo nvl($fump['FRecate_tecnico_cbii']); ?>" type="text" class="form-control disabled tecnico" />
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group">
													PROFE CB-II: <input id="FRecate_profe_cbii" name="FRecate_profe_cbii" value="<?php echo nvl($fump['FRecate_profe_cbii']); ?>" type="text" class="form-control disabled profesor" />
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group">
													PROFE CB-III: <input id="FRecate_profe_cbiii" name="FRecate_profe_cbiii" value="<?php echo nvl($fump['FRecate_profe_cbiii']); ?>" type="text" class="form-control disabled profesor" />
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6">
												<div class="form-group">
													<label>VIGENCIA: <em>*</em></label>
													<?php
													$fecha = nvl($ufumpf['FFecha_termino']);
													$nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
													$nuevafecha = date ( 'd/m/Y' , $nuevafecha );
													?>
													<div class="input-daterange input-group" id="datepicker">
														<span class="input-group-addon">DEL:</span>
														<input type="text" name="FFecha_inicio" id="FFecha_inicio" value="<?php if(nvl($fump['FFecha_inicio'])) echo fecha_format($fump['FFecha_inicio']); ?>" class="form-control vigencia required fecha">
														<span class="input-group-addon">AL:</span>
														<input type="text" name="FFecha_termino" id="FFecha_termino" value="<?php echo fecha_format(nvl($fump['FFecha_termino'])); ?>" class="form-control vigencia fecha">
													</div>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group">
													<label>NOMBRE DE LA PLAZA: <em>*</em></label>
													<select name="FNombre_plaza" id="FNombre_plaza" class="form-control required plaza disabled">
														<option value='<?php echo nvl($fump['FNombre_plaza']); ?>'><?php echo nvl($fump['FNombre_plaza']); ?></option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-4">
											<div class="text-center">
												<div style="margin-top: 20px">
													<?php
													$correciones = "";
													foreach($seguimiento as $key_s => $list_s){
														$nombre = $list_s['UNombre']." ".$list_s['UApellido_pat']." ".$list_s['UApellido_mat'];
														$fecha = fecha_format($list_s['SEFecha_registro']);
														$texto = $list_s['SEDatos_plaza'];
														if($texto){
															$SEfecha_correcion = fecha_format($list_s['SEfecha_correcion']);
															$correciones.= "<b>$nombre</b> <br />";
															$correciones.= "<b><small>$fecha</small></b>";
															if($SEfecha_correcion){
															$correciones.= "<p class='text-info'>$texto<br />";
															$correciones.= "<small>$SEfecha_correcion</small> <i class='fa fa-check'></i>";
															$correciones.= "</p>";
															}else{
															$correciones.= "<p class='text-danger'>$texto";
															$correciones.= "</p>";
															}
														}
													}
													if($correciones){
													?>
													<div class="alert alert-warning">
														<h3 class="text-center">CORRECCIONES</h3>
														<div width="100%" class="text-justify">
															<?=$correciones?>
														</div>
													</div>
													<?php }else{ ?>
													<i class="fa fa-sign-in" style="font-size: 180px;color: #e5e5e5 "></i>
													<?php }?>
												</div>
											</div>
										</div>
								</div>
								</fieldset>
								<h1>PERCEPCIONES / DEDUCCIONES</h1>
								<fieldset>
									<div class="row">
										<div class="col-lg-8">
											<div id="ver_tabla"></div>
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

								<h1>DATOS LABORALES</h1>
								<fieldset>
									<h2>DATOS LABORALES DEL SERVIDOR PUBLICO</h2>
									<div class="row">
										<div class="col-lg-8">
										<?php if(@$fump['FAutorizo_1'] and !@$seguimiento[0]['SEDatos_laborales']) echo'<div id="cambio" class="sombra"></div>'; ?>
											<div class="form-group">
												<label>FECHA DE INGRESO AL COBAEM: <em>*</em></label>
												<input id="FFecha_ingreso_cobaem" name="FFecha_ingreso_cobaem" value="<?php if( nvl($fump['FFecha_ingreso_cobaem']) ) echo fecha_format($fump['FFecha_ingreso_cobaem']); else echo fecha_format(nvl($ufump['FFecha_ingreso_cobaem'])); ?>" type="text" class="form-control fecha required <?php if(fecha_format(nvl($ufump['FFecha_ingreso_cobaem']))) //echo"disabled"; ?>">
											</div>
											<div class="form-group">
												<label>FECHA DE ÚLTIMA PROMOCIÓN: </label>
												<input id="FFecha_ultima_promocion" name="FFecha_ultima_promocion" value="<?php echo fecha_format(nvl($fump['FFecha_ultima_promocion'])); ?>" type="text" class="form-control fecha">
											</div>
											<div class="form-group">
												<label>ANTIGÜEDAD EFECTIVA: </label>
												<?php 
												if(nvl($fump['FAntiguedad_efectiva']))
													@$anio = @explode(" ", nvl($fump['FAntiguedad_efectiva']));
												else{
													$fecha = nvl($ufump['FFecha_termino']);
													$nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
													$nuevafecha = date ( 'd/m/Y' , $nuevafecha );
													
													@$anio = @explode(" ",nvl($ufump['FAntiguedad_efectiva']));
													$tiempo = nicetime( nvl($ufump['FFecha_inicio']), $nuevafecha );
													//calcular y sumar el tiempo en años y meses
													$anios = intval($tiempo/12);
													@$anio[0]+=$anios;
													$meses = ($tiempo % 12);
													@$anio[2]+=$meses;
													
													if($anio[2]>=12){
														$anios = intval($anio[2]/12);
														$anio[0]+=$anios;
														$meses = ($anio[2] % 12);
														$anio[2]=$meses;
													}
													
												}
												?>
												<div class="input-daterange input-group">
													<input type="text" name="FAntiguedad_efectiva_a_skip" id="FAntiguedad_efectiva_a_skip" max="<?=date('Y')?>" value="<?php echo @$anio[0]; ?>" class="form-control <?php if(fecha_format(nvl($ufump['FFecha_ingreso_cobaem']))) echo"disabled-"; ?>">
													<span class="input-group-addon">AÑO(S)</span>
													<input type="text" name="FAntiguedad_efectiva_m_skip" id="FAntiguedad_efectiva_m_skip" min="0" max="11" value="<?php echo @$anio[2]; ?>" class="form-control <?php if(fecha_format(nvl($ufump['FFecha_ingreso_cobaem']))) echo"disabled-"; ?>">
													<span class="input-group-addon">MESE(S)</span>
												</div>
											</div>
											<div class="form-group">
												<label>SINDICALIZADO (A): <em>*</em></label>
												<select id="FSindicalizado" name="FSindicalizado" value="" type="text" class="form-control required">
													<option value=""></option>
													<option <?php if(nvl($fump['FSindicalizado'])=='SI') echo "selected"; ?> value="SI">SI</option>
													<option <?php if(nvl($fump['FSindicalizado'])=='NO') echo "selected"; ?> value="NO">NO</option>
												</select>
											</div>
											<div class="form-group horario_academico">
												<label>HORARIO DE TRABAJO: <em>*</em></label>
												<select id="FHorario_trabajo" name="FHorario_trabajo" value="" type="text" class="form-control required">
													<option value="" autocomplete="off"></option>
													<option <?php if(nvl($fump['FHorario_trabajo'])=='CONTINUO') echo "selected"; ?> value="CONTINUO">CONTINUO</option>
													<option <?php if(nvl($fump['FHorario_trabajo'])=='DISCONTINUO') echo "selected"; ?> value="DISCONTINUO">DISCONTINUO</option>
												</select>
											</div>
											<div class="form-group horario_administrativo">
												<label>HORARIO DE TRABAJO: <em>*</em></label>
												<?php @$horario = @explode(" ",nvl($fump['FHorario_trabajo'])); ?>
												<div class="input-daterange input-group">
													<input type="text" name="Horario_trabajo_i_skip" id="Horario_trabajo_i_skip" value="<?php echo @$horario[0]; ?>" class="form-control clockpicker required" data-autoclose="true" autocomplete="off" >
													<span class="input-group-addon">A</span>
													<input type="text" name="Horario_trabajo_f_skip" id="Horario_trabajo_f_skip" value="<?php echo @$horario[2]; ?>" class="form-control clockpicker required" data-autoclose="true" autocomplete="off" >
													<span class="input-group-addon">HRS.</span>
												</div>
											</div>
											<div class="form-group">
												<label>RELACIÓN DE TRABAJO: <em>*</em></label>
											</div>
											<div class="col-lg-3">
												<div class="form-group">
													<label>INDETERMINADO:</label>
													<div class="i-checks-">
														<input id="FRelacion_trabajo" name="FRelacion_trabajo" <?php if(nvl($fump['FRelacion_trabajo'])== "INDETERMINADO") echo"checked"; ?> value="INDETERMINADO" type="radio" class="form-control relacioni required">
													</div>
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group">
													<label>DETERMINADO:</label>
													<div class="i-checks-">
														<input id="FRelacion_trabajo" name="FRelacion_trabajo" <?php if(nvl($fump['FRelacion_trabajo'])== "DETERMINADO") echo"checked"; ?> value="DETERMINADO" type="radio" class="form-control relaciond required">
													</div>
												</div>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="text-center">
												<div style="margin-top: 20px">
													<?php
													$correciones = "";
													foreach($seguimiento as $key_s => $list_s){
														$nombre = $list_s['UNombre']." ".$list_s['UApellido_pat']." ".$list_s['UApellido_mat'];
														$fecha = fecha_format($list_s['SEFecha_registro']);
														$texto = $list_s['SEDatos_laborales'];
														if($texto){
															$SEfecha_correcion = fecha_format($list_s['SEfecha_correcion']);
															$correciones.= "<b>$nombre</b> <br />";
															$correciones.= "<b><small>$fecha</small></b>";
															if($SEfecha_correcion){
															$correciones.= "<p class='text-info'>$texto<br />";
															$correciones.= "<small>$SEfecha_correcion</small> <i class='fa fa-check'></i>";
															$correciones.= "</p>";
															}else{
															$correciones.= "<p class='text-danger'>$texto";
															$correciones.= "</p>";
															}
														}
													}
													if($correciones){
													?>
													<div class="alert alert-warning">
														<h3 class="text-center">CORRECCIONES</h3>
														<div width="100%" class="text-justify">
															<?=$correciones?>
														</div>
													</div>
													<?php }else{ ?>
													<i class="fa fa-sign-in" style="font-size: 180px;color: #e5e5e5 "></i>
													<?php }?>
												</div>
											</div>
										</div>
									</div>
								</fieldset>
								<h1>DATOS DEL CAMBIO</h1>
								<fieldset>
									<h2>DATOS DEL CAMBIO</h2>
									<div class="row">
										<div class="col-lg-8 datos_cambio">
										<?php if(@$fump['FAutorizo_1'] and !@$seguimiento[0]['SEDatos_cambio']) echo'<div class="sombra"></div>'; ?>
											<div class="row">
												<div class="col-lg-3">
													<div class="form-group">
														<div class="i-checks"><label> <input type="radio" class="form-control required" name="FCambio" id="FCambio" <?php if(nvl($fump['FCambio'])== "PROMOCIÓN") echo"checked"; ?> value="PROMOCIÓN" /> PROMOCIÓN </label></div>
														<div class="i-checks"><label> <input type="radio" class="form-control required" name="FCambio" id="FCambio" <?php if(nvl($fump['FCambio'])== "INDEFINIDO") echo"checked"; ?> value="INDEFINIDO" /> INDEFINIDO </label></div>
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<div class="i-checks"><label> <input type="radio" class="form-control required" name="FCambio" id="FCambio" <?php if(nvl($fump['FCambio'])== "TRANSFERENCIA") echo"checked"; ?> value="TRANSFERENCIA" /> TRANSFERENCIA </label></div>
														<div class="i-checks"><label> <input type="radio" class="form-control required" name="FCambio" id="FCambio" <?php if(nvl($fump['FCambio'])== "TEMPORAL") echo"checked"; ?> value="TEMPORAL" /> TEMPORAL </label></div>
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<div class="i-checks"><label> <input type="radio" class="form-control required" name="FCambio" id="FCambio" <?php if(nvl($fump['FCambio'])== "RETABULACIÓN") echo"checked"; ?> value="RETABULACIÓN" /> RETABULACIÓN </label></div>
														<div class="i-checks"><label> <input type="radio" class="form-control required" name="FCambio" id="FCambio" <?php if(nvl($fump['FCambio'])== "OTRO") echo"checked"; ?> value="OTRO" /> OTRO </label></div>
													</div>
												</div>
												<div class="col-lg-3">
													<div class="i-checks"><label> <input type="radio" class="form-control  required" name="FCambio" id="FCambio" <?php if(nvl($fump['FCambio'])== "PERMUTA") echo"checked"; ?> value="PERMUTA" /> PERMUTA </label></div>
													<div class="i-checks"> <input type="text" id="FCambio_otro" name="FCambio_otro" value="<?php echo nvl($fump['FCambio_otro']); ?>" class="form-control" /><label>&nbsp;</label></div>
												</div>
											</div>
											<div class="form-group">
												<label>CAMBIO DE ADSCRIPCIÓN:</label>
												<div class="input-daterange input-group">
													<span class="input-group-addon">DE:</span>
													<input id="FCambio_adscripcion_de" name="FCambio_adscripcion_de" value="<?php echo nvl($fump['FCambio_adscripcion_de']); ?>" type="text" class="form-control required">
													<span class="input-group-addon">A:</span>
													<input id="FCambio_adscripcion_a" name="FCambio_adscripcion_a" value="<?php echo nvl($fump['FCambio_adscripcion_a']); ?>" type="text" class="form-control required">
												</div>
											</div>
											<div class="form-group">
												<label>PLAZA ANTERIOR:</label>
												<input id="FPlaza_anterior" name="FPlaza_anterior" value="<?php echo nvl($fump['FPlaza_anterior']); ?>" type="text" class="form-control required">
											</div>
											<div class="form-group">
												<label>PLAZA ACTUAL:</label>
												<input id="FPlaza_actual" name="FPlaza_actual" value="<?php echo nvl($fump['FPlaza_actual']); ?>" type="text" class="form-control disabled required">
											</div>
											<div class="form-group">
												<button type="button" onclick="limpiar('datos_cambio');" class="btn btn-info"><i class="fa fa-eraser"></i> LIMPIAR</button>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="text-center">
												<div style="margin-top: 20px">
													<?php
													$correciones = "";
													foreach($seguimiento as $key_s => $list_s){
														$nombre = $list_s['UNombre']." ".$list_s['UApellido_pat']." ".$list_s['UApellido_mat'];
														$fecha = fecha_format($list_s['SEFecha_registro']);
														$texto = $list_s['SEDatos_cambio'];
														if($texto){
															$SEfecha_correcion = fecha_format($list_s['SEfecha_correcion']);
															$correciones.= "<b>$nombre</b> <br />";
															$correciones.= "<b><small>$fecha</small></b>";
															if($SEfecha_correcion){
															$correciones.= "<p class='text-info'>$texto<br />";
															$correciones.= "<small>$SEfecha_correcion</small> <i class='fa fa-check'></i>";
															$correciones.= "</p>";
															}else{
															$correciones.= "<p class='text-danger'>$texto";
															$correciones.= "</p>";
															}
														}
													}
													if($correciones){
													?>
													<div class="alert alert-warning">
														<h3 class="text-center">CORRECCIONES</h3>
														<div width="100%" class="text-justify">
															<?=$correciones?>
														</div>
													</div>
													<?php }else{ ?>
													<i class="fa fa-sign-in" style="font-size: 180px;color: #e5e5e5 "></i>
													<?php }?>
												</div>
											</div>
										</div>
									</div>
								</fieldset>
								<h1>DATOS DE LA BAJA</h1>
								<fieldset>
									<h2>DATOS DE LA BAJA (MOTIVO)</h2>
									<div class="row">
										<div class="col-lg-8">
										<?php if(@$fump['FAutorizo_1'] and !@$seguimiento[0]['SEDatos_baja']) echo'<div class="sombra"></div>'; ?>
											<div class="row">
												<div class="col-lg-3">
													<div class="form-group">
														<div class="i-checks"><label> <input type="radio" class="form-control FDatos_baja required" name="FDatos_baja" id="FDatos_baja" <?php if(nvl($fump['FDatos_baja'])== "RENUNCIA") echo"checked"; ?> value="RENUNCIA" /> RENUNCIA </label></div>
														<div class="i-checks"><label> <input type="radio" class="form-control FDatos_baja required" name="FDatos_baja" id="FDatos_baja" <?php if(nvl($fump['FDatos_baja'])== "RESCISIÓN") echo"checked"; ?> value="RESCISIÓN" /> RESCISIÓN </label></div>
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<div class="i-checks"><label> <input type="radio" class="form-control FDatos_baja required" name="FDatos_baja" id="FDatos_baja" <?php if(nvl($fump['FDatos_baja'])== "INHABILITACIÓN MÉDICA") echo"checked"; ?> value="INHABILITACIÓN MÉDICA" /> INHABILITACIÓN MÉDICA </label></div>
														<div class="i-checks"><label> <input type="radio" class="form-control FDatos_baja required" name="FDatos_baja" id="FDatos_baja" <?php if(nvl($fump['FDatos_baja'])== "JUBILACIÓN") echo"checked"; ?> value="JUBILACIÓN" /> JUBILACIÓN </label></div>
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<div class="i-checks"><label> <input type="radio" class="form-control FDatos_baja required" name="FDatos_baja" id="FDatos_baja" <?php if(nvl($fump['FDatos_baja'])== "FALLECIMIENTO") echo"checked"; ?> value="FALLECIMIENTO" /> FALLECIMIENTO </label></div>
														<div class="i-checks"><label> <input type="radio" class="form-control FDatos_baja required" name="FDatos_baja" id="FDatos_baja" <?php if(nvl($fump['FDatos_baja'])== "OTRO") echo"checked"; ?> value="OTRO" /> OTRO </label></div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="text-center">
												<div style="margin-top: 20px">
													<?php
													$correciones = "";
													foreach($seguimiento as $key_s => $list_s){
														$nombre = $list_s['UNombre']." ".$list_s['UApellido_pat']." ".$list_s['UApellido_mat'];
														$fecha = fecha_format($list_s['SEFecha_registro']);
														$texto = $list_s['SEDatos_baja'];
														if($texto){
															$SEfecha_correcion = fecha_format($list_s['SEfecha_correcion']);
															$correciones.= "<b>$nombre</b> <br />";
															$correciones.= "<b><small>$fecha</small></b>";
															if($SEfecha_correcion){
															$correciones.= "<p class='text-info'>$texto<br />";
															$correciones.= "<small>$SEfecha_correcion</small> <i class='fa fa-check'></i>";
															$correciones.= "</p>";
															}else{
															$correciones.= "<p class='text-danger'>$texto";
															$correciones.= "</p>";
															}
														}
													}
													if($correciones){
													?>
													<div class="alert alert-warning">
														<h3 class="text-center">CORRECCIONES</h3>
														<div width="100%" class="text-justify">
															<?=$correciones?>
														</div>
													</div>
													<?php }else{ ?>
													<i class="fa fa-sign-in" style="font-size: 180px;color: #e5e5e5 "></i>
													<?php }?>
												</div>
											</div>
										</div>
									</div>
								</fieldset>
								
								<h1>OBSERVACIONES</h1>
								<fieldset>
									<h2>OBSERVACIONES</h2>
									<div class="row">
										<div class="col-lg-8">
											<?php if(@$fump['FAutorizo_1'] and !@$seguimiento[0]['SEObservaciones']) echo'<div class="sombra"></div>'; ?>
											<div class="form-group">
												<label>&nbsp;</label>
												<textarea id="FObservaciones" name="FObservaciones" class="form-control textarea"><?php echo nvl($fump['FObservaciones']); ?></textarea>
											</div>
											<br />
											<div class="form-group">
												<span>DECLARO BAJO PROTESTA DECIR VERDAD QUE 
												<select name="FProtesta" id="FProtesta" class="required" required>
													<option value=""></option>
													<option <?php if( nvl($fump['FProtesta']) == 'SI') echo "selected"; ?> value="SI">SI</option>
													<option <?php if( nvl($fump['FProtesta']) == 'NO') echo "selected"; ?> value="NO">NO</option>
												</select>
												ME ENCUENTRO DESEMPEÑANDO OTRO EMPLEO O COMISIÓN EN OTRA ÁREA DE LA ADMINISTRACIÓN PÚBLICA, ESTATAL O MUNICIPAL Y/O SECTOR PRIVADO (ANEXAR DOCUMENTO OFICIAL QUE AMPARE ESTA RELACION LABORAL) </span>
											</div>
											<br />
											<div class="form-group Propuesta <?php if($fump['FProtesta']!='SI') echo 'hidden'; ?>">
												<label class="col-lg-5 control-label" for="">ANEXAR DOCUMENTO OFICIAL: <em>*</em></label>
												<div class="col-lg-7">
													<?php echo forma_archivo("FProtesta_file", nvl($fump['FProtesta_file']),"Seleccionar archivo",'btn-primary','pdf_jpg_jpeg_png'); ?>
												</div>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="text-center">
												<div style="margin-top: 20px">
													<?php
													$correciones = "";
													foreach($seguimiento as $key_s => $list_s){
														$nombre = $list_s['UNombre']." ".$list_s['UApellido_pat']." ".$list_s['UApellido_mat'];
														$fecha = fecha_format($list_s['SEFecha_registro']);
														$texto = $list_s['SEObservaciones'];
														if($texto){
															$SEfecha_correcion = fecha_format($list_s['SEfecha_correcion']);
															$correciones.= "<b>$nombre</b> <br />";
															$correciones.= "<b><small>$fecha</small></b>";
															if($SEfecha_correcion){
															$correciones.= "<p class='text-info'>$texto<br />";
															$correciones.= "<small>$SEfecha_correcion</small> <i class='fa fa-check'></i>";
															$correciones.= "</p>";
															}else{
															$correciones.= "<p class='text-danger'>$texto";
															$correciones.= "</p>";
															}
														}
													}
													if($correciones){
													?>
													<div class="alert alert-warning">
														<h3 class="text-center">CORRECCIONES</h3>
														<div width="100%" class="text-justify">
															<?=$correciones?>
														</div>
													</div>
													<?php }else{ ?>
													<i class="fa fa-sign-in" style="font-size: 180px;color: #e5e5e5 "></i>
													<?php }?>
												</div>
											</div>
										</div>
									</div>
								</fieldset>
								<h1>DOCUMENTAR</h1>
								<fieldset>
									<h2>DOCUMENTOS DEL SERVIDOR PUBLICO</h2>
									<div class="col-lg-8">
										<input type="hidden" id="documentos_skip" name="documentos_skip" value="10" />
										<?php if(@$fump['FAutorizo_1'] and !@$seguimiento[0]['SEDocumentar']) echo'<div class="sombra"></div>'; ?>
										<div class="alta hidden">
											<div class="form-group">
												<label class="col-lg-5 control-label" for="">NOMBRAMIENTO/OFICIO DE ASIGNACIÓN Y/O CARGA HORARIA: </label>
												<div class="col-lg-7">
													<?php echo forma_archivo("FNombramiento_file", nvl($fump['FNombramiento_file']),"Seleccionar archivo",'btn-primary','pdf_jpg_jpeg_png'); ?>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-5 control-label" for="">CONSTANCIA DE NO INHABILITACIÓN: <em>*</em></label>
												<div class="col-lg-7">
													<?php echo forma_archivo("FConstancia_inhabilitacion_file", nvl($fump['FConstancia_inhabilitacion_file']),"Seleccionar archivo",'btn-primary','pdf_jpg_jpeg_png'); ?>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-5 control-label" for="">CERTIFICADO DE ANTECEDENTES NO PENALES:<em>*</em></label>
												<div class="col-lg-7">
													<?php echo forma_archivo("FAntecedentes_penales_file", nvl($fump['FAntecedentes_penales_file']),"Seleccionar archivo",'btn-primary','pdf_jpg_jpeg_png'); ?>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-5 control-label" for="">RFC:<em>*</em></label>
												<div class="col-lg-7">
													<?php echo forma_archivo("DPRFC", nvl($personal['DPRFC']),"Seleccionar archivo",'btn-primary','pdf_jpg_jpeg_png'); ?>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-5 control-label" for="">CURP:<em>*</em></label>
												<div class="col-lg-7">
													<?php echo forma_archivo("DPCURP", nvl($personal['DPCURP']),"Seleccionar archivo",'btn-primary','pdf_jpg_jpeg_png'); ?>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-5 control-label" for="">CREDENCIAL DE ELECTOR:<em>*</em></label>
												<div class="col-lg-7">
													<?php echo forma_archivo("DPCredencial_elector", nvl($personal['DPCredencial_elector']),"Seleccionar archivo",'btn-primary','pdf_jpg_jpeg_png'); ?>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-5 control-label" for="">CERTIFICADO DEL ÚLTIMO NIVEL DE ESTUDIOS Y/O TÍTULO Y/O CÉDULA PROFESIONAL:<em>*</em></label>
												<div class="col-lg-7">
													<?php echo forma_archivo("DPCertificado_estudios", nvl($personal['DPCertificado_estudios']),"Seleccionar archivo",'btn-primary','pdf_jpg_jpeg_png'); ?>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-5 control-label" for="">ÚLTIMO MOVIMIENTO DE ISSEMYM:<br /><small>Sólo en caso de haber laborado previamente en gobierno</small></label>
												<div class="col-lg-7">
													<?php echo forma_archivo("DPMov_ISSEMYM", nvl($personal['DPMov_ISSEMYM']),"Seleccionar archivo",'btn-primary','pdf_jpg_jpeg_png'); ?>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-5 control-label" for="">CUENTA BANCARIA: </label>
												<div class="col-lg-7">
													<?php echo forma_archivo("DPCuenta", nvl($fump['DPCuenta']),"Seleccionar archivo",'btn-primary','pdf_jpg_jpeg_png'); ?>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-5 control-label" for="">FORMATO DEL EMPLEO ANTERIOR:<em>*</em></label>
												<div class="col-lg-7">
													<?php echo forma_archivo("FEmpleo_anterior_file", nvl($fump['FEmpleo_anterior_file']),"Seleccionar archivo",'btn-primary','pdf_jpg_jpeg_png'); ?>
												</div>
											</div>
										</div>
										<div class="baja hidden">
											DOCUMENTO OFICIAL QUE ACREDITE LA BAJA
											<div class="form-group renuncia">
												<label class="col-lg-5 control-label" for="">RENUNCIA:<em>*</em></label>
												<div class="col-lg-7">
													<?php echo forma_archivo("FRenuncia_file", nvl($fump['FRenuncia_file']),"Seleccionar archivo",'btn-primary','pdf_jpg_jpeg_png'); ?>
												</div>
											</div>
											<div class="form-group fallecimiento">
												<label class="col-lg-5 control-label" for="">ACTA DE DEFUNCIÓN:<em>*</em></label>
												<div class="col-lg-7">
													<?php echo forma_archivo("FActa_defuncion_file", nvl($fump['FActa_defuncion_file']),"Seleccionar archivo",'btn-primary','pdf_jpg_jpeg_png'); ?>
												</div>
											</div>
											<div class="form-group rescison">
												<label class="col-lg-5 control-label" for="">DOCUMENTO EMITIDO POR LA UNIDAD JURÍDICA MEDIANTE EL CUAL ESPECIFICA LOS DATOS POR LA RESCISIÓN LABORAL:<em>*</em></label>
												<div class="col-lg-7">
													<?php echo forma_archivo("FRescision_file", nvl($fump['FRescision_file']),"Seleccionar archivo",'btn-primary','pdf_jpg_jpeg_png'); ?>
												</div>
											</div>
											<div class="form-group otro">
												<label class="col-lg-5 control-label" for="">DOCUMENTO PROBATORIO:<em>*</em></label>
												<div class="col-lg-7">
													<?php echo forma_archivo("FResolucion_file", nvl($fump['FResolucion_file']),"Seleccionar archivo",'btn-primary','pdf_jpg_jpeg_png'); ?>
												</div>
											</div>
											<div class="form-group inhabilitacion">
												<label class="col-lg-5 control-label" for="">DICTAMEN DE INHABILITACIÓN MEDICA EXPEDIDO POR ISSEMYM:<em>*</em></label>
												<div class="col-lg-7">
													<?php echo forma_archivo("FInhabilitacion_file", nvl($fump['FInhabilitacion_file']),"Seleccionar archivo",'btn-primary','pdf_jpg_jpeg_png'); ?>
												</div>
											</div>
											<div class="form-group jubilacion">
												<label class="col-lg-5 control-label" for="">DICTAMEN DE JUBILACIÓN EXPEDIDO POR ISSEMYM:<em>*</em></label>
												<div class="col-lg-7">
													<?php echo forma_archivo("FJubilacion_file", nvl($fump['FJubilacion_file']),"Seleccionar archivo",'btn-primary','pdf_jpg_jpeg_png'); ?>
												</div>
											</div>
										</div>
										<div class="licencia hidden">
											<div class="form-group">
												<label class="col-lg-5 control-label" for="">OFICIO DE AUTORIZACIÓN:<em>*</em><br /><small>Licencia sin goce de sueldo</small></label>
												<div class="col-lg-7">
													<?php echo forma_archivo("FAutorizacion_licencia_file", nvl($fump['FAutorizacion_licencia_file']),"Seleccionar archivo",'btn-primary','pdf_jpg_jpeg_png'); ?>
												</div>
											</div>
										</div>
										<div class="incremento hidden">
											<div class="form-group">
												<label class="col-lg-5 control-label" for="">OFICIO DE AUTORIZACIÓN:<em>*</em><br /><small>Incremento de Hrs. clase</small></label>
												<div class="col-lg-7">
													<?php echo forma_archivo("FAutorizacion_incremento_file", nvl($fump['FAutorizacion_incremento_file']),"Seleccionar archivo",'btn-primary','pdf_jpg_jpeg_png'); ?>
												</div>
											</div>
										</div>
										<div class="otro_t hidden">
											<div class="form-group">
												<label class="col-lg-5 control-label" for="">OFICIO:<em>*</em></label>
												<div class="col-lg-7">
													<?php echo forma_archivo("FOtro_file", nvl($fump['FOtro_file']),"Seleccionar archivo",'btn-primary','pdf_jpg_jpeg_png'); ?>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-4">
											<div class="text-center">
												<div style="margin-top: 20px">
													<?php
													$correciones = "";
													foreach($seguimiento as $key_s => $list_s){
														$nombre = $list_s['UNombre']." ".$list_s['UApellido_pat']." ".$list_s['UApellido_mat'];
														$fecha = fecha_format($list_s['SEFecha_registro']);
														$texto = $list_s['SEDocumentar'];
														if($texto){
															$SEfecha_correcion = fecha_format($list_s['SEfecha_correcion']);
															$correciones.= "<b>$nombre</b> <br />";
															$correciones.= "<b><small>$fecha</small></b>";
															if($SEfecha_correcion){
															$correciones.= "<p class='text-info'>$texto<br />";
															$correciones.= "<small>$SEfecha_correcion</small> <i class='fa fa-check'></i>";
															$correciones.= "</p>";
															}else{
															$correciones.= "<p class='text-danger'>$texto";
															$correciones.= "</p>";
															}
														}
													}
													if($correciones){
													?>
													<div class="alert alert-warning">
														<h3 class="text-center">CORRECCIONES</h3>
														<div width="100%" class="text-justify">
															<?=$correciones?>
														</div>
													</div>
													<?php }else{ ?>
													<i class="fa fa-sign-in" style="font-size: 180px;color: #e5e5e5 "></i>
													<?php }?>
												</div>
											</div>
										</div>
								</fieldset>
								<h1>FINALIZAR</h1>
								<fieldset>
									<div class="i-checks">
										<input type="hidden" name="UNCI_usuario_skip" id="UNCI_usuario_skip" value="<?php echo $UNCI_usuario_skip; ?>" />
										<input id="acceptTerms" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms">Estoy de acuerdo que los datos capturados son correctos.</label>
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
<!-- Steps -->
<script src="<?php echo base_url('assets/inspinia/js/plugins/staps/jquery.steps.min.js'); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url('assets/inspinia/js/plugins/validate/jquery.validate.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/messages_es.js'); ?>"></script>
<script src="<?php echo base_url('assets/inspinia/js/plugins/iCheck/icheck.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/inspinia/js/plugins/chosen/chosen.jquery.js'); ?>"></script>
<script type="text/javascript">
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
					
					if(newIndex == '2'){
						issemym14();
						tramite_otro();
					}
					if(newIndex == '3'){
						tipo_plantel();
						datos_incremento();
					}
					if(newIndex == '4'){
						load_table(form);
					}
					if(newIndex == '5'){
						relacion_trabajo();
						//plaza_sindicato();
						datos_baja();
						datos_licencia();
					}
					if(newIndex == '6'){
						datos_cambio();
					}
					if(newIndex == '7'){
						datos_baja();
					}
					if(newIndex == '9'){
						documetos();
					}
					if(newIndex == '10'){
						$('#documentos_skip').val('');
					}
					
				}

				// Disable validation on fields that are disabled or hidden.
				form.validate().settings.ignore = ":disabled,:hidden";
				
				if( form.valid() ){
					save(form);
				}

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
				// Submit , save form input
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
						window.location.href = "<?=base_url("fump/index/$UNCI_usuario_skip")?>";
					}
						
				});
			}
		}).validate({
			errorPlacement: function (error, element)
			{
				element.before(error);
			}
		});
		
		$('.i-checks').iCheck({
			checkboxClass: 'icheckbox_square-green',
			radioClass: 'iradio_square-green',
		});
		
		$("#FPlantel").change(function() {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url("fump/departamento"); ?>",
				data: $(this.form).serialize(),
				dataType: "html",
				beforeSend: function(){
					//carga spinner
					$(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
				},
				success: function(data){
					var data = data.split("::");
					$("#FDepartamento").html(data[0]);
					$("#FCorreo_electronico_plantel").val(data[1]);
					$(".loading").html('');
				}
			});
		});//----->fin
		
		$("#FDepartamento").change(function() {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url("fump/correo_depto"); ?>",
				data: $(this.form).serialize(),
				dataType: "html",
				beforeSend: function(){
					//carga spinner
					$(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
				},
				success: function(data){
					var data = data.split("::");
					$("#FCorreo_electronico_plantel").val(data[1]);
					$("#Tipo_plantel_skip").val(data[2]);
					$("#FDirector").val(data[3]);
					$("#CPLCoordinacion_skip").val(data[4]);
					$(".loading").html('');
				}
			});
		});//----->fin
		
		$('#FTipo_plaza, #nose').on("ifChecked",function(){
			tipo_plaza();
		});
		
		$('#FTipo_asignatura, #nose').on("ifChecked",function(){
			$('.ht, .hp').iCheck('uncheck');
		});
		$('#FTipo_asignatura, #FTipo_horas_clase').on("ifChecked",function(){
			tipo_clases();
		});
		
		$('#FHoras_clase_totales').on("keyup",function(){
			if( $(this).val() > 0 ){
				$('.jornada').addClass("disabled").attr("disabled", true).iCheck('uncheck');
				$('.tecnico, .profesor').addClass("disabled").iCheck('uncheck').val("");
			}else{
				var horas = $('#FTipo_horas_clase:checked').val();
				if(horas == 'PROFE CB-I'){
					$('.profesor,.jornada').removeClass("disabled").attr("disabled", false);
					$('.tecnico').addClass("disabled").attr("disabled", true).val("");
				}else{
					$('.tecnico,.jornada').removeClass("disabled").attr("disabled", false);
					$('.profesor').addClass("disabled").attr("disabled", true).val("");
				}
			}
		});
		
		$('#FTipo_jornada, .tecnico, .profesor').on("keyup change ifChecked",function(){
			
			var jornada = $('#FTipo_jornada:checked').val();
			if(jornada == "JORNADA 1/2 TIEMPO"){
				jornada = 20;
			}else if(jornada == "JORNADA 3/4 DE TIEMPO"){
				jornada = 30;
			}else if(jornada == "JORNADA TIEMPO COMP."){
				jornada = 40;
			}else{
				jornada = 0;
			}
		
			var total = jornada*1;
			var num = 0;
			$(".tecnico, .profesor").each(function(){
				total+= $(this).val()*1;
				if( $(this).val() > 0 ){
					num = num + 1;
				}
			});
			
			if(jornada == 0 && num < 2){
				total = 0;
			}
			
			if(total > 0 || num == 1){
				$('#FHoras_clase_totales').addClass("disabled");
			}else{
				$('#FHoras_clase_totales').removeClass("disabled").attr("disabled", false);
			}
			
			$('#FHoras_clase_totales').val(total);
		});
		
		$('#FTipo_plaza, #FTipo_jornada, #FTipo_asignatura, #FTipo_horas_clase').on('ifChecked', function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url("fump/ver_plaza"); ?>",
				data: $(this.form).serialize(),
				dataType: "html",
				beforeSend: function(){
					//carga spinner
					$(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
				},
				success: function(data){
					var data = data.split("::");
					$("#FNombre_plaza").html(data[0]);
					$(".loading").html('');
				}
			});
		});//----->fin
		
		$('#FISSEMYM').change(function(){
			issemym14();
		});
		
		$('#FNombre_plaza').change(function(){
			$('#FPlaza_actual').val( $('#FNombre_plaza').val() );
			$('#cambio').removeClass('sombra');
			plaza_sindicato();
		});
		
		$('.chosen-select').chosen();
		
		//subir archivos .pdf
		$(".upload_file").colorbox({width:"600px", height:"430px", scrolling:false, iframe:true, overlayClose:false});
		
		$('.clockpicker').clockpicker();
		
		$('.FTramite, #nose').on("ifChanged",function(){
			var tramite_click = $(this);
			if( tramite_click.val() == "ALTA" ){
				$('.FTramite').each(function(e){
					var tramite = $(this).val();
					if( tramite == "BAJA" || tramite == "INCREMENTO/DISMINUCIÓN DE HRS. CLASE" || tramite == "CAMBIO DE PLAZA" || tramite == "CAMBIO DE ADSCRIPCIÓN" || tramite == "LICENCIA SIN GOCE DE SUELDO" || tramite == "OTRO" ){
						if(tramite_click.is(':checked')){
							$(this).addClass("disabled").attr("disabled", true).iCheck('uncheck');
						}else{
							$(this).removeClass("disabled").attr("disabled", false).iCheck('uncheck');
						}
					}
				});
			}
			
			if( tramite_click.val() == "BAJA" ){
				$('.FTramite').each(function(e){
					var tramite = $(this).val();
					if( tramite == "ALTA" || tramite == "INCREMENTO/DISMINUCIÓN DE HRS. CLASE" || tramite == "CAMBIO DE PLAZA" || tramite == "CAMBIO DE ADSCRIPCIÓN" || tramite == "LICENCIA SIN GOCE DE SUELDO" || tramite == "OTRO" ){
						if(tramite_click.is(':checked')){
							$(this).addClass("disabled").attr("disabled", true).iCheck('uncheck');
						}else{
							$(this).removeClass("disabled").attr("disabled", false).iCheck('uncheck');
						}
					}
				});
			}
			
			if( tramite_click.val() == "INTERINATO" ){
				$('.FTramite').each(function(e){
					var tramite = $(this).val();
					if( tramite == "INCREMENTO/DISMINUCIÓN DE HRS. CLASE" || tramite == "CAMBIO DE PLAZA" || tramite == "CAMBIO DE ADSCRIPCIÓN" || tramite == "LICENCIA SIN GOCE DE SUELDO" || tramite == "OTRO" ){
						if(tramite_click.is(':checked')){
							$(this).addClass("disabled").attr("disabled", true).iCheck('uncheck');
						}else{
							$(this).removeClass("disabled").attr("disabled", false).iCheck('uncheck');
						}
					}
				});
			}
			
			if( tramite_click.val() == "LICENCIA SIN GOCE DE SUELDO" ){
				$('.FTramite').each(function(e){
					var tramite = $(this).val();
					if( tramite == "ALTA" || tramite == "BAJA" || tramite == "INTERINATO" || tramite == "INCREMENTO/DISMINUCIÓN DE HRS. CLASE" || tramite == "CAMBIO DE PLAZA" || tramite == "CAMBIO DE ADSCRIPCIÓN" || tramite == "OTRO" ){
						if(tramite_click.is(':checked')){
							$(this).addClass("disabled").attr("disabled", true).iCheck('uncheck');
						}else{
							$(this).removeClass("disabled").attr("disabled", false).iCheck('uncheck');
						}
					}
				});
			}
			
			if( tramite_click.val() == "INCREMENTO/DISMINUCIÓN DE HRS. CLASE" ){
				$('.FTramite').each(function(e){
					var tramite = $(this).val();
					if( tramite == "ALTA" || tramite == "BAJA" || tramite == "INTERINATO" || tramite == "LICENCIA SIN GOCE DE SUELDO" || tramite == "CAMBIO DE PLAZA" || tramite == "CAMBIO DE ADSCRIPCIÓN" || tramite == "OTRO" ){
						if(tramite_click.is(':checked')){ //si es Checkeado
							$(this).addClass("disabled").attr("disabled", true).iCheck('uncheck');
						}else{
							$(this).removeClass("disabled").attr("disabled", false).iCheck('uncheck');
						}
					}
				});
			}
			
			if( tramite_click.val() == "CAMBIO DE PLAZA" || tramite_click.val() == "CAMBIO DE ADSCRIPCIÓN" || tramite_click.val() == "OTRO" ){
				$('.FTramite').each(function(e){
					var tramite = $(this).val();
					if( tramite == "ALTA" || tramite == "BAJA" || tramite == "INTERINATO" || tramite == "LICENCIA SIN GOCE DE SUELDO" || tramite == "INCREMENTO/DISMINUCIÓN DE HRS. CLASE" ){
						if(tramite_click.is(':checked')){
							$(this).addClass("disabled").attr("disabled", true).iCheck('uncheck');
						}else{
							$(this).removeClass("disabled").attr("disabled", false).iCheck('uncheck');
						}
					}
				});
			}
			
			tramite_otro();
			
		});
		
		$("#FFecha_inicio-").change(function(){
			fecha_ingreso = '<?=fecha_format(nvl($ufump['FFecha_ingreso_cobaem']))?>';
			nuevafecha = '<?=$nuevafecha?>';
			if($("#FFecha_inicio").val()!= nuevafecha){
				$("#FFecha_ingreso_cobaem").val( $(this).val() );
				$("#FAntiguedad_efectiva_a_skip").val('0');
				$("#FAntiguedad_efectiva_m_skip").val('0');
			}else{
				$("#FFecha_ingreso_cobaem").val('<?=fecha_format(nvl($ufump['FFecha_ingreso_cobaem']))?>');
				$("#FAntiguedad_efectiva_a_skip").val('<?php echo @$anio[0]; ?>');
				$("#FAntiguedad_efectiva_m_skip").val('<?php echo @$anio[2]; ?>');
			}
		});
		
		$("#FProtesta").change(function(){
			if($(this).val()=='SI'){
				$(".Propuesta").removeClass("hidden");
			}else{
				$(".Propuesta").addClass("hidden");
			}
		});
		
		tipo_plaza();
		tipo_clases();
   });
   
	function issemym14(){
		var issemym = $("#FISSEMYM").val();
		if(issemym >= 1 && issemym <= 620000){
			$('.ISSEMYM14').attr("style","display: block;");
		}else{
			$('.ISSEMYM14').attr("style","display: none;");
			$('#FISSEMYM14').iCheck('uncheck');
		}
	}
	
	function tramite_otro(){
		//Para activar la casilla otro
		$('.FTramite:checked').each(function(e){
			var tramite = $(this).val();
			var select= '<option value=""></option>';
			if(tramite == "OTRO"){
				select+= '<option <?php if($FTramite_otro=="CAMBIO DE HORARIO") echo"selected"; ?> value="CAMBIO DE HORARIO">CAMBIO DE HORARIO</option>';
				select+= '<option <?php if($FTramite_otro=="INCORPORACIÓN DE LA SUSPENCIÓN LABORAL") echo"selected"; ?> value="INCORPORACIÓN DE LA SUSPENCIÓN LABORAL">INCORPORACIÓN DE LA SUSPENCIÓN LABORAL</option>';
				select+= '<option <?php if($FTramite_otro=="INCORPORACIÓN DE LICENCIA SINDICAL") echo"selected"; ?> value="INCORPORACIÓN DE LICENCIA SINDICAL">INCORPORACIÓN DE LICENCIA SINDICAL</option>';
				select+= '<option <?php if($FTramite_otro=="INCORPORACIÓN LICENCIA S/GOCE DE SUELDO") echo"selected"; ?> value="INCORPORACIÓN LICENCIA S/GOCE DE SUELDO">INCORPORACIÓN LICENCIA S/GOCE DE SUELDO</option>';
				select+= '<option <?php if($FTramite_otro=="LICENCIA SINDICAL") echo"selected"; ?> value="LICENCIA SINDICAL" disabled>LICENCIA SINDICAL</option>';
				//select+= '<option <?php if($FTramite_otro=="RENUNCIA A GRATIFICACIÓN BUROCRATICA") echo"selected"; ?> value="RENUNCIA A GRATIFICACIÓN BUROCRATICA">RENUNCIA A GRATIFICACIÓN BUROCRATICA</option>';
				select+= '<option <?php if($FTramite_otro=="SUSPENCIÓN LABORAL") echo"selected"; ?> value="SUSPENCIÓN LABORAL">SUSPENCIÓN LABORAL</option>';
				$("#FTramite_otro").html( select );
			}else if(tramite == "LICENCIA SIN GOCE DE SUELDO"){
				select+= '<option <?php if($FTramite_otro=="LICENCIA ADMINISTRATIVA") echo"selected"; ?> value="LICENCIA ADMINISTRATIVA">LICENCIA ADMINISTRATIVA</option>';
				select+= '<option <?php if($FTramite_otro=="LICENCIA PERSONAL") echo"selected"; ?> value="LICENCIA PERSONAL">LICENCIA PERSONAL</option>';
				select+= '<option <?php if($FTramite_otro=="ESTUDIOS DE POSGRADO") echo"selected"; ?> value="ESTUDIOS DE POSGRADO">ESTUDIOS DE POSGRADO</option>';
				$("#FTramite_otro").html( select );
			}else{
				$("#FTramite_otro").html( select );
			}
		});
	}
   
   function tipo_plaza(){
		var tipo = $('#FTipo_plaza:checked').val();
		if(tipo == 'ACADÉMICO'){
			$('.tipo').removeClass("disabled").attr("disabled", false);
			$('.iradio_square-green').removeClass("disabled");
			$('.plaza').addClass("disabled").attr("disabled", true);
		}else{
			$('.plaza').removeClass("disabled").attr("disabled", false);
			$('.tipo, .hp, .ht, .horas, .horas_t, .jornada, .tecnico, .profesor').addClass("disabled").attr("disabled", true).iCheck('uncheck');
			$('.horas, .horas_t, .tecnico, .profesor').val("");
			$('.horas_t').val("0");
		}
		$('.vigencia').removeClass("disabled").attr("disabled", false);
	}
	
	function plaza_sindicato(){
		$.ajax({
			type: "POST",
			url: "<?php echo base_url("fump/plaza_sindicato"); ?>",
			data: $(this.form).serialize(),
			dataType: "html",
			beforeSend: function(){
				//carga spinner
				$(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
			},
			success: function(data){
				var data = data.split("::");
				if(data[0]==' NO')
					//$("#FSindicalizado").val( 'NO' ).addClass('disabled');
					$("#FSindicalizado").val( 'NO' );
				else{
					$("#FSindicalizado").val('').removeClass('disabled','false');
					$('#cambio').removeClass('sombra');
				}
				$(".loading").html('');
			}
		});
	}
   
	function tipo_clases(){
		var tipo = $('#FTipo_asignatura:checked').val();
			var horas = $('#FTipo_horas_clase:checked').val();
			
			if(tipo == 'CURRICULARES'){
				$('.profesor, .hp').removeClass("disabled").attr("disabled", false);
				$('.tecnico').addClass("disabled").attr("disabled", true).val("");
				$('.ht').addClass("disabled").attr("disabled", true).iCheck('uncheck');
			}else if(tipo == 'COCURRICULARES'){
				if(horas == 'PROFE CB-I'){
					$('.profesor, .ht, .hp').removeClass("disabled").attr("disabled", false);
					$('.tecnico').addClass("disabled").attr("disabled", true).val("");
				}else{
					$('.tecnico, .ht, .hp').removeClass("disabled").attr("disabled", false);
					$('.profesor').addClass("disabled").attr("disabled", true).val("");
				}
			}
			$('.horas, .jornada, .plaza').removeClass("disabled").attr("disabled", false);
			$('.horas_t').attr("disabled", false);
			$('#FHoras_clase_totales').removeClass("disabled").attr("disabled", false);
	}
   
	function load_table(form) {
		$.ajax({
			type: "POST",
			url: "<?php echo base_url("fump/ver_tabla"); ?>",
			data: form.serialize(),
			dataType: "html",
			beforeSend: function(){
				//carga spinner
				$(".ver_tabla").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
			},
			success: function(data){
				$("#ver_tabla").html(data);
			}
		});
	};//----->fin
	
	function tipo_plantel(){
		var tipo_plantel = $('#Tipo_plantel_skip').val();
		if(tipo_plantel == 36){
			$('.centro').attr("disabled", false).removeClass("hidden");
			$('.plantel').attr("disabled", true).addClass("hidden");
		}else{
			$('.plantel').attr("disabled", false).removeClass("hidden");
			$('.centro').attr("disabled", true).addClass("hidden");;
		}
	}
	
	function relacion_trabajo(){
		
		var tipo = $('#FTipo_plaza:checked').val();
		if(tipo == "ACADÉMICO"){
			$('.horario_academico').attr("style","display: block;");
			$('.horario_administrativo').attr("style","display: none;");
			$('#FHorario_trabajo').attr("disabled",false);
			$('#Horario_trabajo_i_skip').val("").attr("disabled",true);
			$('#Horario_trabajo_f_skip').val("").attr("disabled",true);
		}else{
			$('.horario_administrativo').attr("style","display: block;");
			$('.horario_academico').attr("style","display: none;");
			$('#FHorario_trabajo').val("").attr("disabled",true);
			$('#Horario_trabajo_i_skip').attr("disabled",false);
			$('#Horario_trabajo_f_skip').attr("disabled",false);
		}
		
		$('.FTramite').each(function(){
			if( $(this).is(':checked') ){
				if( $(this).val() == "BAJA" ){
					return false;
				}else{
					var termino = $("#FFecha_termino").val();
					if ( termino == "" || termino == false || termino == 'undefined' ){
						$('.relacioni').prop("checked", true).attr("disabled",false).iCheck('check');
						$('.relaciond').prop("checked", false).attr("disabled",true).iCheck('uncheck');
					}else{			
						$('.relaciond').prop("checked", true).attr("disabled",false).iCheck('check');
						$('.relacioni').prop("checked", false).attr("disabled",true).iCheck('uncheck');
					}
				}
			}
		});
		
	}
	
	function datos_cambio(){
		var tipo = 0;
		$('.FTramite').each(function(){
			if( $(this).is(':checked') ){		
				if( $(this).val() == "CAMBIO DE PLAZA"){
					tipo = tipo + 1;
				}else if( $(this).val() == "CAMBIO DE ADSCRIPCIÓN"){
					tipo = tipo + 2;
				}
			}
		});
		if(tipo == 1){
			$('.datos_cambio input').removeClass("disabled").attr("disabled", false);
			$('#FCambio_adscripcion_de, #FCambio_adscripcion_a').addClass("disabled").attr("disabled", true);
		}else if(tipo == 2){
			$('.datos_cambio input').removeClass("disabled").attr("disabled", false);
			$('#FPlaza_anterior, #FPlaza_actual').addClass("disabled").attr("disabled", true);
		}else if(tipo == 3){
			$('.datos_cambio input').removeClass("disabled").attr("disabled", false);
		}else{
			$('.datos_cambio input').addClass("disabled").attr("disabled", true).iCheck('uncheck');
		}
	}
	
	function datos_baja(){
		$('.FTramite').each(function(){
			if( $(this).is(':checked') ){
				if( $(this).val() == "BAJA" ){
					$('.FDatos_baja').removeClass("disabled").attr("disabled", false);
					$('.relacioni, .relaciond').attr("disabled",false);
					return false;
				}else{
					$('.FDatos_baja').addClass("disabled").attr("disabled", true).iCheck('uncheck');
				}
			}
		});
	}
	
	function datos_licencia(){
		$('.FTramite').each(function(){
			if( $(this).is(':checked') ){
				if( $(this).val() == "LICENCIA SIN GOCE DE SUELDO" ){
					$('.relacioni, .relaciond').attr("disabled",false);
					return false;
				}else{
					//otras acciones
				}
			}
		});
	}
	
	function datos_incremento(){
		$('.FTramite').each(function(){
			if( $(this).is(':checked') ){
				if( $(this).val() == "INCREMENTO/DISMINUCIÓN DE HRS. CLASE" ){
					$("#FHoras_incrementa").addClass("required").removeClass('disabled');
					$("#FHoras_disminuye").addClass("required").removeClass('disabled');
					return false;
				}else{
					$("#FHoras_incrementa").removeClass("required").addClass('disabled');
					$("#FHoras_disminuye").removeClass("required").addClass('disabled');
				}
			}
		});
	}
	
	function documetos(){
		$('.FTramite').each(function(e){
			if( $(this).is(':checked') ){
				var tramite = $(this).val();
				if(tramite == "ALTA"){
					$('.alta').removeClass("hidden");
					$('.baja, .licencia, .incremento, .otro_t').addClass("hidden");
					return false;
				}
				else if(tramite == "BAJA"){
					$('.baja').removeClass("hidden");
					$('.alta, .licencia, .incremento, .otro_t').addClass("hidden");
					var FDatos_baja = $('#FDatos_baja:checked').val();
					if( FDatos_baja == "RENUNCIA" ){
						$('.renuncia').removeClass("hidden");
						$('.rescison, .inhabilitacion, .jubilacion, .fallecimiento, .otro').addClass("hidden");
					}else if( FDatos_baja == "RESCISIÓN" ){
						$('.rescison').removeClass("hidden");
						$('.renuncia, .inhabilitacion, .jubilacion, .fallecimiento, .otro').addClass("hidden");
					}else if( FDatos_baja == "INHABILITACIÓN MÉDICA" ){
						$('.inhabilitacion').removeClass("hidden");
						$('.renuncia, .rescison, .jubilacion, .fallecimiento, .otro').addClass("hidden");
					}else if( FDatos_baja == "JUBILACIÓN" ){
						$('.jubilacion').removeClass("hidden");
						$('.renuncia, .rescison, .inhabilitacion, .fallecimiento, .otro').addClass("hidden");
					}else if( FDatos_baja == "FALLECIMIENTO" ){
						$('.fallecimiento').removeClass("hidden");
						$('.renuncia, .rescison, .inhabilitacion, .jubilacion, .otro').addClass("hidden");
					}else if( FDatos_baja == "OTRO" ){
						$('.otro').removeClass("hidden");
						$('.renuncia, .rescison, .inhabilitacion, .jubilacion, .fallecimiento').addClass("hidden");
					}
					return false;
				}
				else if(tramite == "LICENCIA SIN GOCE DE SUELDO"){
					$('.licencia').removeClass("hidden");
					$('.alta, .baja, .incremento, .otro_t').addClass("hidden");
					return false;
				}
				else if(tramite == "INCREMENTO/DISMINUCIÓN DE HRS. CLASE"){
					$('.incremento').removeClass("hidden");
					$('.alta, .baja, .licencia, .otro_t').addClass("hidden");
					return false;
				}
				else if(tramite == "OTRO" || tramite == "CAMBIO DE PLAZA" || tramite == "CAMBIO DE ADSCRIPCIÓN"){
					$('.otro_t').removeClass("hidden");
					$('.alta, .baja, .licencia, .incremento').addClass("hidden");
					return false;
				}
				else{
					$('.alta, .baja, .licencia, .incremento, .otro_t').addClass("hidden");
				}
			}
		});
	}
   
	function save(form,finish){
		$.ajax({
			type: "POST",
			url: "<?php echo base_url("fump/save"); ?>",
			data: form.serialize(),
			dataType: "html",
			beforeSend: function(){
				//carga spinner
				$(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
			},
			success: function(data){
				var data = data.split("::");
				$("#FClave_skip").val(data[1]);
				$("#FTexto").html(data[2]);
				$("#result").html(data[0]);
				$(".loading").html('');
				if(finish && data[3]=="OK"){
					location.href ='<?php echo base_url("fump/index/$UNCI_usuario_skip"); ?>';
				}
			}
		});
	}
</script>
<script src="<?php echo base_url('assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('assets/date_picker_es.js'); ?>"></script>
<script src="<?php echo base_url('assets/inspinia/js/plugins/clockpicker/clockpicker.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/colorbox/jquery.colorbox-min.js") ?>"></script>
<link media="screen" rel="stylesheet" href="<?php echo base_url("assets/colorbox/colorbox.css") ?>" />
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
</style>