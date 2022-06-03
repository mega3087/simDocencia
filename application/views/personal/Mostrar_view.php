<link href="<?php echo base_url('assets/inspinia/css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/chosen/chosen.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/datapicker/datepicker3.css'); ?>" rel="stylesheet" />

<div class="row">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
			<h3>Personal</h3>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<?php muestra_mensaje(); ?>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<div class="pull-right">
				<?php if( (get_session('URol')==12 and $plantel['CPLTipo']==37) or get_session('URol')!=12 ){ ?>
				<?php if( is_permitido(null,'personal','nuevo_personal') ){ ?>
					<button 
					class="btn btn-primary open"
					data-target="#modal_personal" 
					data-toggle="modal"
					data-unci_usuario_skip=""
					data-uplantel="<?php echo get_session('UPlantel'); ?>" >
						<i class="fa fa-user"></i> Registrar Personal
					</button>
				<?php } ?>
				<?php $dir = 1; } ?>
				</div>
				<h3>&nbsp;</h3>
			</div> 
			<div class="ibox-content">
				<div class="row">
					<div class="col-lg-12">
						<form action="<?php echo base_url("personal/index"); ?>" name="FormSearch" id="FormSearch" method="POST">
							<div class="col-lg-4">
								<div class="input-daterange input-group">
                                    <span class="input-group-addon">Mostrar</span>
									<select name="limit" id="limit" class="form-control">
										<option <?php if($limit == '20') echo"selected"; ?> value="20">20</option>
										<option <?php if($limit == '50') echo"selected"; ?> value="50">50</option>
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
                                    <input type="text" name="search" id="search" value="<?=$search?>" class="form-control" />
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
										<th>#</th>
										<th>Plantel</th>
										<th>Clave</th>
										<th>Nombre</th>
										<th>Correo Electrónico</th>
										<th>Rol</th>
										<th>Estatus</th>
										<th>FUMP</th>
										<th width="130px">Acción</th> 
									</tr>	
								</thead>
								<tbody>
									<?php 
										$start++;
										$next = null;
										foreach($personal as $key => $list){
											$UNCI_usuario_skip = $this->encrypt->encode($list['UNCI_usuario']);
										?>
										<tr>
											<td class="text-left"><?php echo $next = $start+$key; ?></td>
											<td class="text-left"><?php echo str_ireplace(strtoupper($search),"<em>".strtoupper($search)."</em>",$list['CPLNombre']); ?></td>
											<td class="text-left">
											<?php echo str_ireplace($search,"<em>$search</em>",$list['UClave_servidor']); ?>
											<?php echo str_ireplace($search,"<em>$search</em>",$list['UClave_servidor_centro']); ?>
											</td>
											<td class="text-left">
											<?php echo str_ireplace(strtoupper($search),"<em>".strtoupper($search)."</em>",$list['UNombre']); ?>
											<?php echo str_ireplace(strtoupper($search),"<em>".strtoupper($search)."</em>",$list['UApellido_pat']); ?>
											<?php echo str_ireplace(strtoupper($search),"<em>".strtoupper($search)."</em>",$list['UApellido_mat']); ?>
											</td>
											<td class="text-left"><?php echo str_ireplace($search,"<em>$search</em>",$list['UCorreo_electronico']); ?></td>
											<td class="text-left"><?php echo $list['CRODescripcion']; ?></td>
											<td class="text-left"><?php echo $list['UEstado']; ?></td>
											<td class="text-left">
												<a href="<?php echo base_url("fump/index/$UNCI_usuario_skip"); ?>" class="btn btn-default btn-sm"><i class="fa fa-folder-open-o"></i> FUMP</a>
											</td>
											<td>
												<button class="btn btn-default btn-sm open"
												data-target="#modal_personal" 
												data-toggle="modal"
												data-unci_usuario_skip="<?php echo $UNCI_usuario_skip; ?>" 
												data-uclave_servidor="<?php echo $list['UClave_servidor']; ?>"
												data-uclave_servidor_centro="<?php echo $list['UClave_servidor_centro']; ?>"
												data-unombre="<?php echo $list['UNombre']; ?>"
												data-uapellido_pat="<?php echo $list['UApellido_pat']; ?>"
												data-uapellido_mat="<?php echo $list['UApellido_mat']; ?>"
												data-uissemym="<?php echo $list['UISSEMYM']; ?>"
												data-ufecha_nacimiento="<?php echo fecha_format($list['UFecha_nacimiento']); ?>"
												data-urfc="<?php echo $list['URFC']; ?>"
												data-ucurp="<?php echo $list['UCURP']; ?>"
												data-uclave_elector="<?php echo $list['UClave_elector']; ?>"
												data-udomicilio="<?php echo $list['UDomicilio']; ?>"
												data-ucolonia="<?php echo $list['UColonia']; ?>"
												data-umunicipio="<?php echo $list['UMunicipio']; ?>"
												data-ucp="<?php echo $list['UCP']; ?>"
												data-ucorreo_electronico="<?php echo $list['UCorreo_electronico']; ?>"
												data-ured_social="<?php echo $list['URed_social']; ?>"
												data-utelefono_movil="<?php echo $list['UTelefono_movil']; ?>"
												data-utelefono_casa="<?php echo $list['UTelefono_casa']; ?>"
												data-ulugar_nacimiento="<?php echo $list['ULugar_nacimiento']; ?>"
												data-uestado_civil="<?php echo $list['UEstado_civil']; ?>"
												data-usexo="<?php echo $list['USexo']; ?>"
												data-uhijos="<?php echo $list['UHijos']; ?>"
												data-uescolaridad="<?php echo $list['UEscolaridad']; ?>"
												data-urol="<?php echo $list['URol']; ?>"
												data-uestado="<?php echo $list['UEstado']; ?>" 
												data-uplantel="<?php echo $list['UPlantel']; ?>"
												><i class="fa fa-pencil"></i> Editar
												</button>
											<?php if( is_permitido(null,'personal','delete') ){ ?>
												<a href="<?php echo base_url("personal/delete/$UNCI_usuario_skip"); ?>" class="btn btn-default btn-sm delete"><i class="fa fa-times"></i> Borrar</a>
											<?php } ?>
											<?php if( is_permitido(null,'chat','index') ){ ?>
												<button class="btn btn-warning btn-sm" onclick="users('<?=$list["UNCI_usuario"]?>')"><i class="fa fa-comment-o"></i></a>
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



<div class="modal inmodal" id="modal_personal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" >
		<div class="modal-content animated flipInY">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
				<h6 class="modal-title"><i class="fa fa-user"></i>&nbsp;&nbsp; Servidor Publico</h6><div class="border-bottom"><br /></div>
				<?php echo form_open('personal/save', array('name' => 'FormPersonal', 'id' => 'FormPersonal', 'role' => 'form', 'class' => 'form-horizontal panel-body')); ?>
				<?php if( is_permitido(null,'personal','ver_todos') or $plantel['CPLTipo']!='36'){ ?>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Clave Servidor: <em>*</em><br /><small>Plantel</small></label>
					<div class="col-lg-9">
						<input type="text" id="UClave_servidor" name="UClave_servidor" value="" maxlength='150' class="form-control uppercase" />
					</div>
				</div>
				<?php } ?>
				<?php if( is_permitido(null,'personal','ver_todos') or $plantel['CPLTipo']=='36'){ ?>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Clave Servidor: <em>*</em><br /><small>CEMSAD</small></label>
					<div class="col-lg-9">
						<input type="text" id="UClave_servidor_centro" name="UClave_servidor_centro" value="" maxlength='150' class="form-control uppercase" />
					</div>
				</div>
				<?php } ?>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Nombre(s) / Paterno / Materno: <em>*</em></label>
					<div class="col-lg-9">
						<div class="row">
							<div class="col-lg-4">
								<input type="text" placeholder="Nombre(s)" id="UNombre" name="UNombre" value="" maxlength='150' class="form-control uppercase <?php if ($config['COUsarCURP']) echo 'disabled'?> " />
							</div>
							<div class="col-lg-4">
								<input type="text" placeholder="Paterno" id="UApellido_pat" name="UApellido_pat" value="" maxlength='150' class="form-control uppercase <?php if ($config['COUsarCURP']) echo 'disabled'?> " />
							</div>
							<div class="col-lg-4">
								<input type="text" placeholder="Materno" id="UApellido_mat" name="UApellido_mat" value="" maxlength='150' class="form-control uppercase <?php if ($config['COUsarCURP']) echo 'disabled'?> " />
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">CURP: <em>*</em></label>
					<div class="col-lg-9">
						<div class="row">
							<div class="col-xs-8">
								<input type="text" id="UCURP" name="UCURP" value="" maxlength='150' 
								class="form-control uppercase" />
							</div>
							<div class="col-xs-4">
							<?php if($config['COUsarCURP']){ ?>
								<button type="button" class="btn btn-default btn-sm valida_curp"><i class="fa"> Validar CURP</i></button>
								<?php } ?>
							</div>
						</div>
						<div id="result_curp"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Clave ISSEMYM: </label>
					<div class="col-lg-9">
						<input type="text" id="UISSEMYM" name="UISSEMYM" value="" maxlength='150' 
						class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Fecha de nacimiento: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="UFecha_nacimiento" name="UFecha_nacimiento" value="" maxlength='150' 
						class="form-control date" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">RFC: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="URFC" name="URFC" value="" maxlength='150' 
						class="form-control uppercase" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Clave de Elector: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="UClave_elector" name="UClave_elector" value="" maxlength='20' 
						class="form-control uppercase" />
					</div>
				</div>	
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Domicilio: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="UDomicilio" name="UDomicilio" value="" maxlength='150' 
						class="form-control" />
					</div>
				</div>				
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Colonia: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="UColonia" name="UColonia" value="" maxlength='150' 
						class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Municipio: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="UMunicipio" name="UMunicipio" value="" maxlength='150' 
						class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">C.P: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="UCP" name="UCP" value="" maxlength='150' 
						class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Tel. movil: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="UTelefono_movil" name="UTelefono_movil" value="" maxlength='150' 
						class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Tel. casa: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="UTelefono_casa" name="UTelefono_casa" value="" maxlength='150' 
						class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Correo electronico: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="UCorreo_electronico" name="UCorreo_electronico" value="" maxlength='150' 
						class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Red Social: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="URed_social" name="URed_social" value="" maxlength='150' 
						class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Lugar de nacimiento: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="ULugar_nacimiento" name="ULugar_nacimiento" value="" maxlength='150' 
						class="form-control" />
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
					<label class="col-lg-3 control-label" for="">Hijos: <em>*</em></label>
					<div class="col-lg-9">
						<select name="UHijos" id="UHijos" class="form-control">
							<option value=""></option>
							<?php for($i=0;$i<20;$i++){ ?>
							<option value="<?=$i?>"><?=$i?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Escolaridad: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="UEscolaridad" name="UEscolaridad" value="" maxlength='150' 
						class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Plantel:<em>*</em></label>
					<div class="col-lg-9" id="UPlantel">
						<select name="UPlantel[]" id="UPlantel" class="form-control chosen-select" data-placeholder="Seleccionar plantel" multiple="" >
							<?php foreach($planteles as $key_p => $list_p){ ?>
							<option value="<?=$list_p['CPLClave']?>"><?=$list_p['CPLNombre']?></option>
							<?php } ?>
						</select>
					</div>
				</div>		
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Rol: <em>*</em></label>
					<div class="col-lg-9">
						<select id="URol" name="URol" placeholder="ROL" class="form-control" >
							<?php foreach($rol as $rkey => $rlist){ ?>
								<option value="<?php echo $rlist['CROClave']; ?>" <?php if($rlist['CROClave'] != "7" and !is_permitido(null,"personal","delete")) echo "disabled"; ?> ><?php echo $rlist['CRODescripcion']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>			
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Estado: <em>*</em></label>
					<div class="col-lg-9">
						<select id="UEstado" name="UEstado" placeholder="ESTADO" class="form-control" >
							<option value="Activo">ACTIVO</option>
							<option value="Inactivo">INACTIVO</option>
						</select>
					</div>
				</div>
				<div id="error"></div>
				<div class="loading"></div>
				<div class="form-group">
					<div class="col-lg-offset-3 col-lg-9">
						<?php if( is_permitido(null,'personal','save') and @$dir ){ ?>
						<input type="hidden" id="UNCI_usuario_skip" name="UNCI_usuario_skip" />
						<button type="button" class="btn btn-primary pull-right save"> <i class="fa fa-save"></i> Guardar</button>
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
			var UNCI_usuario_skip = $(this).data('unci_usuario_skip');
			var UPlantel = $(this).data('uplantel')+"";
			$(".modal-header #result_curp").empty();
			$(".modal-header #UNCI_usuario_skip").val( UNCI_usuario_skip );
			$(".modal-header #UClave_servidor").val( $(this).data('uclave_servidor') );
			$(".modal-header #UClave_servidor_centro").val( $(this).data('uclave_servidor_centro') );
			$(".modal-header #UNombre").val( $(this).data('unombre') );
			$(".modal-header #UApellido_pat").val( $(this).data('uapellido_pat') );
			$(".modal-header #UApellido_mat").val( $(this).data('uapellido_mat') );
			$(".modal-header #UISSEMYM").val( $(this).data('uissemym') );
			$(".modal-header #UFecha_nacimiento").val( $(this).data('ufecha_nacimiento') );
			$(".modal-header #URFC").val( $(this).data('urfc') );
			$(".modal-header #UCURP").val( $(this).data('ucurp') );
			$(".modal-header #UClave_elector").val( $(this).data('uclave_elector') );
			$(".modal-header #UDomicilio").val( $(this).data('udomicilio') );
			$(".modal-header #UColonia").val( $(this).data('ucolonia') );
			$(".modal-header #UMunicipio").val( $(this).data('umunicipio') );
			$(".modal-header #UCP").val( $(this).data('ucp') );
			$(".modal-header #UTelefono_movil").val( $(this).data('utelefono_movil') );
			$(".modal-header #UTelefono_casa").val( $(this).data('utelefono_casa') );
			$(".modal-header #UCorreo_electronico").val( $(this).data('ucorreo_electronico') );
			$(".modal-header #URed_social").val( $(this).data('ured_social') );
			$(".modal-header #ULugar_nacimiento").val( $(this).data('ulugar_nacimiento') );
			$(".modal-header #UEstado_civil").val( $(this).data('uestado_civil') );
			$(".modal-header #USexo").val( $(this).data('usexo') );
			$(".modal-header #UHijos").val( $(this).data('uhijos') );
			$(".modal-header #UEscolaridad").val( $(this).data('uescolaridad') );
			$(".modal-header #URol").val( $(this).data('urol') );
			$(".modal-header #UEstado").val( $(this).data('uestado') );
			var ver_todos = "<?php echo is_permitido(null,'personal','ver_todos'); ?>";
			var ver_plantel = "<?php echo is_permitido(null,'personal','ver_plantel'); ?>";
			var nuevo_personal = "<?php echo is_permitido(null,'personal','nuevo_personal'); ?>";
			if( ver_todos ){
				$(".modal-header #UPlantel").removeAttr( "disabled", false );
			}else{
				$(".modal-header #UPlantel").attr( "disabled", true );
			}
			if(ver_todos || (nuevo_personal && UNCI_usuario_skip=="") ){
				$(".modal-header #URol").removeClass( "disabled" );
				$(".modal-header #UEstado").removeClass( "disabled" );
			}else{
				$(".modal-header #URol").addClass( "disabled" );
				$(".modal-header #UEstado").addClass( "disabled" );
			}
			$(".modal-header #UPlantel").val( UPlantel.split(',') ).trigger("chosen:updated");
			$(".modal-header #UPlantel").removeAttr( "disabled", false );
		});
		
		$(".save").click(function() {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url("personal/save"); ?>",
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
					$(".modal-header #UApellido_pat").val( data[1] );
					$(".modal-header #UApellido_mat").val( data[2] );
					$(".modal-header #UNombre").val( data[3] );
					$(".modal-header #UFecha_nacimiento").val( data[4] );
					if( data[5]=='H'){
						$(".modal-header #USexo").val( 'Hombre' );
					}else if( data[5]=='M'){
						$(".modal-header #USexo").val( 'Mujer' );
					}
					$("#result_curp").empty();
					$("#result_curp").append(data[0]);
					$(".loading").html("");
				}
			});
		});//----->fin
		
		$("#limit").on("change",function(){
			limit = $("#limit").val();
			start = $("#start").val();
			search = $("#search").val();
			search = window.btoa(unescape(encodeURIComponent(search))).replace("=","").replace("=","").replace("=","");
			location.href ="<?=base_url('personal/index')?>/"+limit+"/"+start+"/"+search;
		});
		
		$(".search").on("click",function(){
			limit = $("#limit").val();
			start = $("#start").val();
			search = $("#search").val();
			search = window.btoa(unescape(encodeURIComponent(search))).replace("=","").replace("=","").replace("=","");
			location.href ="<?=base_url('personal/index')?>/"+limit+"/"+start+"/"+search;
		});
		
		$("#FormSearch").submit(function(e) {
			e.preventDefault();
			limit = $("#limit").val();
			start = $("#start").val();
			search = $("#search").val();
			search = window.btoa(unescape(encodeURIComponent(search))).replace("=","").replace("=","").replace("=","");
			location.href ="<?=base_url('personal/index')?>/"+limit+"/"+start+"/"+search;
		});

		$('.chosen-select').chosen();
		
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
</style>