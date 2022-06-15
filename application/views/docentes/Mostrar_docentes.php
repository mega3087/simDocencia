<link href="<?php echo base_url('assets/inspinia/css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/chosen/chosen.css'); ?>" rel="stylesheet">
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

<div class="row" id="chat">
	<div class="col-lg-12">
		<?php muestra_mensaje(); ?>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<div class="pull-right">
				<?php if( is_permitido(null,'docente','save') )
				$idPlantel = $this->encrypt->encode($plantel[0]['CPLClave']); 
				{ ?>
					<a href="<?= base_url('docente/Update/'.$idPlantel); ?>" ><button class="btn btn-primary"><i class="fa fa-pencil"></i> Registrar Docente</button></a>

					<button 
					class="btn btn-primary open"
					data-target="#modal_Registrar" 
					data-toggle="modal"
					data-ucplclave="<?php echo $plantel[0]['CPLClave']; ?>"
					data-unci_usuario_skip=""
					><i class="fa fa-building-o"></i> Registrar Docente</button>
				<?php } ?>
				</div>
				<h3>&nbsp;</h3>
			</div> 
			<div class="ibox-content">
				
				<div class="table-responsive">
					<input type="hidden" name="plantelId" id="plantelId" value="<?= $plantel[0]['CPLClave']?>">
					<table class="table table-striped table-bordered table-hover dataTables-example dataTable" >
						<thead>
							<tr>
								<th>#</th>
								<th>Docente</th>
								<th>Correo Electrónico</th>
								<th>RFC</th>
                                <th>CURP</th>
                                <th width="130px">Acción</th>
							</tr>	
						</thead>
						<tbody>
							<?php 
								$i = 1;
								foreach($docentes as $key => $list){
									$UNCI_usuario_skip = $this->encrypt->encode($list['UNCI_usuario']); 
									$borrar = "<button type='button' value=".$UNCI_usuario_skip." class='btn btn-sm btn-danger quitarDocente'><i class='fa fa-trash'></i> Quitar</button>"; ?>
										<tr>
											<td class="text-left"><?php echo $i; ?></td> 
											<td class="text-left"><?php echo $list['UNombre']." ".$list['UApellido_pat']." ".$list['UApellido_mat']; ?></td>
											<td class="text-left"><?php echo $list['UCorreo_electronico']; ?></td>
											<td class="text-left"><?php echo $list['URFC']; ?></td>
											<td class="text-left"><?php echo $list['UCURP']; ?></td>								
											<td>
											<a href="<?= base_url('docente/Update/'.$idPlantel.'/'.$UNCI_usuario_skip); ?>" ><button class="btn btn-primary"><i class="fa fa-pencil"></i> Editar</button></a>
											<!--<button class="btn btn-primary btn-sm open" 
		                                        data-target="#modal_Registrar" 
		                                        data-ucplclave="<?php echo $plantel[0]['CPLClave']; ?>"
		                                        data-unci_usuario="<?php echo $list['UNCI_usuario']; ?>"
		                                        data-unombre="<?php echo $list['UNombre']; ?>"
												data-uapellido_pat="<?php echo $list['UApellido_pat']; ?>"
												data-uapellido_mat="<?php echo $list['UApellido_mat']; ?>"
												data-ufecha_nacimiento="<?php echo fecha_format($list['UFecha_nacimiento']); ?>"
												data-ucorreo_electronico="<?php echo $list['UCorreo_electronico']; ?>"
												data-urfc="<?php echo $list['URFC']; ?>"
												data-uclave_elector="<?php echo $list['UClave_elector']; ?>"
												data-ucurp="<?php echo $list['UCURP']; ?>"
												data-udomicilio="<?php echo $list['UDomicilio']; ?>"
												data-ucolonia="<?php echo $list['UColonia']; ?>"
												data-umunicipio="<?php echo $list['UMunicipio']; ?>"
												data-ucp="<?php echo $list['UCP']; ?>"
												data-utelefono_movil="<?php echo $list['UTelefono_movil']; ?>"
												data-utelefono_casa="<?php echo $list['UTelefono_casa']; ?>"
												data-ulugar_nacimiento="<?php echo $list['ULugar_nacimiento']; ?>"
												data-uestado_civil="<?php echo $list['UEstado_civil']; ?>"
												data-usexo="<?php echo $list['USexo']; ?>"
												data-uescolaridad="<?php echo $list['UEscolaridad']; ?>"
												data-ufechaingreso="<?php echo fecha_format($list['UFecha_registro']); ?>"

												data-toggle="modal">
		                                        <i class="fa fa-pencil"></i> Editar
		                                    </button>-->
											<!--data-utipodocente="<?php echo $list['UDTipo_Docente']; ?>"
											
											data-uplaza="<?php echo $list['UDPlaza']; ?>"
											data-unombramiento_file="<?php echo $list['UDNombramiento_file']; ?>"
											data-uoficio_file="<?php echo $list['UDOficio_file']; ?>"
											data-ucurriculum_file="<?php echo $list['UDCurriculum_file']; ?>"
											data-ucurp_file="<?php echo $list['UDCURP_file']; ?>"-->

		                                    <button class="btn btn-default btn-sm open" 
		                                        data-target="#modal_Estudios" 
		                                        data-ucplclave="<?php echo $plantel[0]['CPLClave']; ?>"
		                                        data-unci_usuario="<?php echo $list['UNCI_usuario']; ?>"
		                                        data-unombre="<?php echo $list['UNombre']; ?>"
												data-uapellido_pat="<?php echo $list['UApellido_pat']; ?>"
												data-uapellido_mat="<?php echo $list['UApellido_mat']; ?>"
												data-ufecha_nacimiento="<?php echo fecha_format($list['UFecha_nacimiento']); ?>"
												data-ucorreo_electronico="<?php echo $list['UCorreo_electronico']; ?>"
												data-urfc="<?php echo $list['URFC']; ?>"
												data-uclave_elector="<?php echo $list['UClave_elector']; ?>"
												data-ucurp="<?php echo $list['UCURP']; ?>"
												data-udomicilio="<?php echo $list['UDomicilio']; ?>"
												data-ucolonia="<?php echo $list['UColonia']; ?>"
												data-umunicipio="<?php echo $list['UMunicipio']; ?>"
												data-ucp="<?php echo $list['UCP']; ?>"
												data-utelefono_movil="<?php echo $list['UTelefono_movil']; ?>"
												data-utelefono_casa="<?php echo $list['UTelefono_casa']; ?>"
												data-ulugar_nacimiento="<?php echo $list['ULugar_nacimiento']; ?>"
												data-uestado_civil="<?php echo $list['UEstado_civil']; ?>"
												data-usexo="<?php echo $list['USexo']; ?>"
												data-uescolaridad="<?php echo $list['UEscolaridad']; ?>"
												data-ufechaingreso="<?php echo fecha_format($list['UFecha_registro']); ?>"
												
		                                        data-toggle="modal">
		                                        <i class="fa fa-pencil"></i> Estudios
		                                    </button>
											<!--data-utipodocente="<?php echo $list['UDTipo_Docente']; ?>"
												data-uplaza="<?php echo $list['UDPlaza']; ?>"
												data-unombramiento_file="<?php echo $list['UDNombramiento_file']; ?>"
												data-uoficio_file="<?php echo $list['UDOficio_file']; ?>"
												data-ucurriculum_file="<?php echo $list['UDCurriculum_file']; ?>"
												data-ucurp_file="<?php echo $list['UDCURP_file']; ?>"-->
		                                    <?php echo $borrar; ?>
											</td>
										</tr>
								<?php $i++; } ?>
						</tbody>
					</table>
				</div>
				

				<!--Ventana modal Docente Editar-->
				<div class="modal inmodal" id="modal_Registrar" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-lg" >
						<div class="modal-content animated flipInY">
							
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
								<h6 class="modal-title"><i class="fa fa-user"></i>&nbsp;&nbsp; Docente</h6><div class="border-bottom"><br /></div>
								<?php echo form_open('docente/Registrar', array('name' => 'FormRegistrarDocente', 'id' => 'FormRegistrarDocente', 'role' => 'form', 'class' => 'form-horizontal panel-body')); ?>
								
								<div class="form-group">
									<label class="col-lg-3 control-label" for="">CURP: <em>*</em></label>
									<div class="col-lg-9">
										<div class="row">
											<div class="col-xs-8">
												<input type="text" id="UCURP" name="UCURP" value="" maxlength='150' class="form-control uppercase" />
											</div>
											<div class="col-xs-4">
												<button type="button" class="btn btn-default btn-sm valida_curp"><i class="fa"> Validar CURP</i></button>
											</div>
										</div>
										<div id="result_curp"></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Nombre(s) / Paterno / Materno: <em>*</em></label>
									<div class="col-lg-9">
										<div class="row">
											<div class="col-lg-4">
												<input type="text" placeholder="Nombre(s)" id="UNombre" name="UNombre" value="" maxlength='150' class="form-control uppercase" />
											</div>
											<div class="col-lg-4">
												<input type="text" placeholder="Paterno" id="UApellido_pat" name="UApellido_pat" value="" maxlength='150' class="form-control uppercase" />
											</div>
											<div class="col-lg-4">
												<input type="text" placeholder="Materno" id="UApellido_mat" name="UApellido_mat" value="" maxlength='150' class="form-control uppercase" />
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Fecha de nacimiento: <em>*</em></label>
									<div class="col-lg-9">
										<input type="text" id="UFecha_nacimiento" name="UFecha_nacimiento" value="" maxlength='150' class="form-control date" autocomplete="off" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Lugar de nacimiento: <em>*</em></label>
									<div class="col-lg-9">
										<input type="text" id="ULugar_nacimiento" name="ULugar_nacimiento" value="" maxlength='150' class="form-control" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label" for="">RFC: <em>*</em></label>
									<div class="col-lg-9">
										<input type="text" id="URFC" name="URFC" value="" maxlength='150' class="form-control uppercase" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Domicilio: <em>*</em></label>
									<div class="col-lg-9">
										<input type="text" id="UDomicilio" name="UDomicilio" value="" maxlength='150' class="form-control" />
									</div>
								</div>				
								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Colonia: <em>*</em></label>
									<div class="col-lg-9">
										<input type="text" id="UColonia" name="UColonia" value="" maxlength='150' class="form-control" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Municipio: <em>*</em></label>
									<div class="col-lg-9">
										<input type="text" id="UMunicipio" name="UMunicipio" value="" maxlength='150' class="form-control" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label" for="">C.P: <em>*</em></label>
									<div class="col-lg-9">
										<input type="text" id="UCP" name="UCP" value="" maxlength='150' class="form-control" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Tel. movil: <em>*</em></label>
									<div class="col-lg-9">
										<input type="text" id="UTelefono_movil" name="UTelefono_movil" value="" maxlength='150' class="form-control" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Tel. casa: <em>*</em></label>
									<div class="col-lg-9">
										<input type="text" id="UTelefono_casa" name="UTelefono_casa" value="" maxlength='150' class="form-control" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Correo Electronico: <em>*</em></label>
									<div class="col-lg-9">
										<input type="text" id="UCorreo_electronico" name="UCorreo_electronico" value="" maxlength='150' class="form-control" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Estado civil: <em>*</em></label>
									<div class="col-lg-9">
										<select name="UEstado_civil" id="UEstado_civil" class="form-control">
											<option value=""></option>
											<?php foreach($estado_civil as $key => $list){ ?>
											<option <?php if( $list['ECNombre'] == nvl($usuario['UEstado_civil']) or $list['ECNombre'] == nvl($fump['FEstado_civil']) ) echo"selected"; ?> value="<?=$list['ECNombre'];?>"><?=$list['ECNombre'];?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Sexo: <em>*</em></label>
									<div class="col-lg-9">
										<select name="USexo" id="USexo" class="form-control">
											<option value=""></option>
											<option value="Hombre">Hombre</option>
											<option value="Mujer">Mujer</option>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Fecha de Ingreso: <em>*</em></label>
									<div class="col-lg-9">
										<input type="text" id="UDFecha_ingreso" name="UDFecha_ingreso" value="" maxlength='150' class="form-control date" autocomplete="off" />
									</div>
								</div>

								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Tipo:<em>*</em></label>
									<div class="col-lg-9" id="UDTipo_Docente">
										<select name="UDTipo_Docente" id="UDTipo_Docente" class="form-control" data-placeholder="Seleccionar Tipo Docente" >
											<option></option>
											<?php foreach($tipoDocente as $key_t => $list_t){ ?>
											<option value="<?=$list_t['TPClave']?>"><?=$list_t['TPNombre']?></option>
											<?php } ?>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Nombramiento:<em>*</em></label>
									<div class="col-lg-9" id="UDNombramiento">
										<select name="UDNombramiento" id="UDNombramiento" class="form-control" data-placeholder="Seleccionar Tipo Docente" >
											<option></option>
											<?php foreach($nombramiento as $key_n => $list_n){ ?>
											<option value="<?=$list_n['PLClave']?>"><?=$list_n['PLPuesto']?></option>
											<?php } ?>
										</select>
									</div>
								</div>

								<div class="form-group">
						            <label class="col-lg-3 control-label" for="">Archivo: <em>*</em></label>
						            <div class="col-lg-9">
						                <?php forma_archivo('UDNombramiento_file',null,'Subir Nombramiento','btn-primary pull-left'); ?>
						                <a href='#' id='ver_nombramiento' target='_blank' style="visibility:hidden">Ver Archivo</a>
						            </div>
						        </div>
								
								<br><h4 class="modal-title"><i class="fa fa-folder"></i>&nbsp;&nbsp; OFICIOS DE SOLICITUD </h4><div class="border-bottom"></div><br/>
						        <div class="form-group">
						            <label class="col-lg-4 control-label" for="">Oficio de Petición: <em>*</em></label>
						            <div class="col-lg-6">
						                <?php echo forma_archivo('UDOficio_file',null,'Subir Oficio','btn-primary pull-left'); ?>
						                <a href='#' id='ver_oficio' target='_blank' style="visibility:hidden">Ver Archivo</a>
						            </div>
						        </div>
						        <div class="form-group">
						            <label class="col-lg-4 control-label" for="">Curriculum: <em>*</em></label>
						            <div class="col-lg-6">
						                <?php forma_archivo('UDCurriculum_file',null,'Subir Curriculum','btn-primary pull-left');?>
						                <a href='#' id='ver_curriculum' target='_blank' style="visibility:hidden">Ver Archivo</a>
						            </div>
						        </div>
						        <div class="form-group">
						            <label class="col-lg-4 control-label" for="">CURP: <em>*</em></label>
						            <div class="col-lg-6">
						                <?php forma_archivo('UDCURP_file',null,'Subir CURP','btn-primary pull-left'); ?>
						                <a href='#' id='ver_curp' target='_blank' style="visibility:hidden">Ver Archivo</a>
						            </div>
						        </div>

								<div class="msgRegistrar"></div>
								<!--<div class="loadingRegistrar"></div>-->
								<div class="form-group">
									<div class="col-lg-offset-3 col-lg-9">
										<input type="hidden" id="CPLClave" name="UDCPLantel" />
										<input type="hidden" id="UNCI_usuario" name="UNCI_usuario" />
										<button type="button" class="btn btn-primary pull-right registrar"> <i class="fa fa-save"></i> Guardar</button>
									</div>
								</div>
								<?php echo form_close(); ?>
								
							</div>
						</div>
					</div>
				</div>

				<!--Ventana modal Docente-->
				<div class="modal inmodal" id="modal_Estudios" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-lg" >
						<div class="modal-content animated flipInY">
							
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
								<h6 class="modal-title"><i class="fa fa-user"></i>&nbsp;&nbsp; Docente</h6><div class="border-bottom"><br /></div>
								<?php echo form_open('docente/saveArchivos', array('name' => 'FormArchivo', 'id' => 'FormArchivo', 'role' => 'form', 'class' => 'form-horizontal panel-body')); ?>
								
								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Nombre(s) / Paterno / Materno: <em>*</em></label>
									<div class="col-lg-9">
										<div class="row">
											<div class="col-lg-4">
												<input type="text" placeholder="Nombre(s)" id="UNombre" maxlength='150' class="form-control uppercase disabled" />
											</div>
											<div class="col-lg-4">
												<input type="text" placeholder="Paterno" id="UApellido_pat" maxlength='150' class="form-control uppercase disabled" />
											</div>
											<div class="col-lg-4">
												<input type="text" placeholder="Materno" id="UApellido_mat" maxlength='150' class="form-control uppercase disabled" />
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label" for="">CURP: <em>*</em></label>
									<div class="col-lg-9">
										<input type="text" id="UCURP" maxlength='150' class="form-control uppercase disabled" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Fecha de nacimiento: <em>*</em></label>
									<div class="col-lg-9">
										<input type="text" id="UFecha_nacimiento" maxlength='150' class="form-control date disabled" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label" for="">RFC: <em>*</em></label>
									<div class="col-lg-9">
										<input type="text" id="URFC" maxlength='150' class="form-control uppercase disabled" />
									</div>
								</div>	

								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Tipo:<em>*</em></label>
									<div class="col-lg-9" id="UDTipo_Docente">
										<select id="UDTipo_Docente" class="form-control disabled" data-placeholder="Seleccionar Tipo Docente" >
											<?php foreach($tipoDocente as $key_t => $list_t){ ?>
											<option value="<?=$list_t['TPClave']?>"><?=$list_t['TPNombre']?></option>
											<?php } ?>
										</select>
									</div>
								</div>

								<h4 class="modal-title"><i class="fa fa-folder"></i>&nbsp;&nbsp; OFICIOS DE SOLICITUD </h4><div class="border-bottom"></div>
								<br/>

								<div class="form-group">
									<label class="col-lg-3 control-label">Nivel de Estudios: <em>*</em></label>
									<div class="col-lg-9" id="UPNivel_estudio">
										<select name="UPNivel_estudio" id="UPNivel_estudio" class="form-control carrerasMostrar">
											<option value="">-Seleccionar-</option>
											<?php foreach ($estudios as $e => $listEst) { ?>
												<option value="<?= $listEst['LGradoEstudio'] ?>"><?= $listEst['LGradoEstudio'] ?></option>
											<?php } ?> 
										</select>
									</div>
								</div>
								<div id="resultCarrera"></div>
								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Título Profesional: <em>*</em></label>
								    <div class="col-lg-9">
										<?php forma_archivo('UPTitulo_file',null,'Subir Título','btn-primary pull-left'); ?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-lg-3 control-label" for="">Cédula Profesional: <em>*</em></label>
								    <div class="col-lg-9">
										<?php forma_archivo('UPCedula_file',null,'Subir Cédula','btn-primary pull-left'); ?>
									</div>
								</div>
								
                                <div class="msgArchivo"></div>
                                <div class="loadingArchivo"></div>
								<div class="form-group">
									<div class="col-lg-offset-3 col-lg-9">
										<input type="hidden" id="UNCI_usuario" name="UPUClave" />
										<input type="hidden" id="CPLClave" name="UPPClave" />			
										<button type="button" class="btn btn-primary pull-right saveArchivos"> <i class="fa fa-save"></i> Guardar Documentos</button>
									</div>
								</div>
								<div class="form-group">
									<form action="#" method='POST' name='archivos_form' id='archivos_form'>
				                        <div class="msgArchivos"></div>
				                        <div class="resultArchivos"></div>
				                    </form>
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
		$(document).on("click", ".open", function () {
			
			$(".modal-header #result_curp").empty();
			$(".modal-header #UNCI_usuario").val( $(this).data('unci_usuario') );
			$(".modal-header #CPLClave").val( $(this).data('ucplclave') );
			$(".modal-header #UCURP").val( $(this).data('ucurp') );
			$(".modal-header #UNombre").val( $(this).data('unombre') );
			$(".modal-header #UApellido_pat").val( $(this).data('uapellido_pat') );
			$(".modal-header #UApellido_mat").val( $(this).data('uapellido_mat') );
			$(".modal-header #UFecha_nacimiento").val( $(this).data('ufecha_nacimiento') );
			$(".modal-header #ULugar_nacimiento").val( $(this).data('ulugar_nacimiento') );
			$(".modal-header #URFC").val( $(this).data('urfc') );
			$(".modal-header #UDomicilio").val( $(this).data('udomicilio') );
			$(".modal-header #UColonia").val( $(this).data('ucolonia') );
			$(".modal-header #UMunicipio").val( $(this).data('umunicipio') );
			$(".modal-header #UCP").val( $(this).data('ucp') );
			$(".modal-header #UTelefono_movil").val( $(this).data('utelefono_movil') );
			$(".modal-header #UTelefono_casa").val( $(this).data('utelefono_casa') );
			$(".modal-header #UCorreo_electronico").val( $(this).data('ucorreo_electronico') );
			$(".modal-header #UEstado_civil").val( $(this).data('uestado_civil') );
			$(".modal-header #USexo").val( $(this).data('usexo') );
			$(".modal-header #UDTipo_Docente").val( $(this).data('utipodocente') );
			$(".modal-header #UDFecha_ingreso").val( $(this).data('ufechaingreso') );
			$(".modal-header #UDNombramiento").val( $(this).data('uplaza') );

			$(".modal-header #UDNombramiento_file").val( $(this).data('unombramiento_file') );
			$(".modal-header #UDOficio_file").val( $(this).data('uoficio_file') );
			$(".modal-header #UDCurriculum_file").val( $(this).data('ucurriculum_file') );
			$(".modal-header #UDCURP_file").val( $(this).data('ucurp_file') );
						
			var idUsuario = document.getElementById("UNCI_usuario").value;

			$(".msgArchivos").empty();
        	datosArchivos(idUsuario);

        	var url = '<?php echo base_url(); ?>';

        	if ( $(this).data('unombramiento_file') ) {
				$("#ver_nombramiento").attr('href', url + $(this).data('unombramiento_file') );
				$("#ver_nombramiento").attr("style", "visibility: auto");
			} else {
				$("#ver_nombramiento").attr("style", "visibility: hidden");
			}
        	if ( $(this).data('uoficio_file') ) {
				$("#ver_oficio").attr('href', url + $(this).data('uoficio_file') );
				$("#ver_oficio").attr("style", "visibility: auto");
			} else {
				$("#ver_oficio").attr("style", "visibility: hidden");
			}
			if ( $(this).data('ucurriculum_file') ) {
				$("#ver_curriculum").attr('href', url + $(this).data('ucurriculum_file') );
				$("#ver_curriculum").attr("style", "visibility: auto");
			} else {
				$("#ver_curriculum").attr("style", "visibility: hidden");
			}
			if ( $(this).data('ucurp_file') ) {
				$("#ver_curp").attr('href', url + $(this).data('ucurp_file') );
				$("#ver_curp").attr("style", "visibility: auto");
			} else {
				$("#ver_curp").attr("style", "visibility: hidden");
			}
			
		});

		//Guardar Plaza del nuevo docente
		$(".registrar").click(function() {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url("docente/Registrar"); ?>",
				data: $(this.form).serialize(),
				dataType: "html",
				beforeSend: function(){
					//carga spinner
					$(".loadingRegistrar").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
				},
				success: function(data){
					if(data==' OK'){
						location.reload();
					} else {
						$(".msgRegistrar").empty();
	                    $(".msgRegistrar").append(data);  
	                    $(".loadingRegistrar").html("");
					}
				}
			});
		});//----->fin
		//Fin Guadar Plaza del Docente

		//Mostrar las carreras correspondientes al nivel de estudios
        $(document).on("change", ".carrerasMostrar", function () {
        	var selectNivel = ($(this).val());
        	$.ajax({
	            type: "POST",
	            url: "<?php echo base_url("docente/mostrarCarreras"); ?>",
	            data: {tipo : selectNivel},
	            dataType: "html",
	            beforeSend: function(){
	                //carga spinner
	                $(".loadingArchivo").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
	            },
	            success: function(data){
	                $("#resultCarrera").empty();
	                $("#resultCarrera").append(data);  
	                $(".loadingArchivo").html("");
	            }
	        });
		});

		//Guardar Plaza del Docente
		$(".saveArchivos").click(function() {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url("docente/saveArchivo"); ?>",
				data: $(this.form).serialize(),
				dataType: "html",	
				beforeSend: function(){
					//carga spinner
					$(".loadingArchivo").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
				},
				success: function(data){
	                var data = data.split(";");
	                if(data[0]==' OK'){
	                    $(".msgArchivo").empty();
	                    $(".msgArchivo").append(data[1]);
	                    datosArchivos( data[2]);
	                    FormArchivo.UPNivel_estudio.value = "";
						FormArchivo.UPCarrera.value = "";
						FormArchivo.UPTitulo_file.value = "";
						FormArchivo.UPCedula_file.value = "";
	                    $(".loadingArchivo").html("");
	                } else {
	                    $(".msgArchivo").empty();
	                    $(".msgArchivo").append(data[0]);  
	                    datosArchivos( data[1]);
	                    $(".loadingArchivo").html(""); 
	                }
	                
	            } 
			});
		});//----->fin

		function datosArchivos(idUsuario){
			var idUsuario = idUsuario;
			var idPlantel = document.getElementById("CPLClave").value;
			$.ajax({
	            type: "POST",
	            url: "<?php echo base_url("docente/mostrarArchivos"); ?>",
	            data: {idUsuario : idUsuario, idPlantel : idPlantel}, 
	            dataType: "html",
	            beforeSend: function(){
	                //carga spinner
	                $(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
	            },
	            success: function(data){
	                $(".resultArchivos").empty();
	                $(".resultArchivos").append(data);  
	                $(".loading").html("");
	            }
	        });
	    }

	    //Borrar docente del Plantel o Centro
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