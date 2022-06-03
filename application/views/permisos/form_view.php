<link href="<?php echo base_url('assets/inspinia/css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/iCheck/custom.css');?>" rel="stylesheet">



<div class="row">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
			<h3>Permisos de sistema</h3>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<?php muestra_mensaje(); ?>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<div class="pull-right">
					</div>
				<div class="ibox-tools">
					<?php if( is_permitido(null,'permisos','save_modulo') ){ ?>
					<a type="button" class="btn btn-primary open"
					data-toggle="modal"
					data-target="#modal_modulo"
					>
						<i class="fa fa-plus"></i> Nuevo Módulo
					</a>
					<?php } ?>
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
				</div>
			</div>
			<form method="post" class="form-horizontal" id="forma" name="forma" role="form" action="<?php echo base_url('permisos/update');?>">
				<div class="ibox-content">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" >
							<!--thead>
								<tr>
									<th>Descripción</th>
									<th>Módulo</th>
									<th>Acción</th>
									<?php foreach($rol as $key => $des){ ?>
										<th class="text-center"><?php echo $des['CRODescripcion']; ?></th>
									<?php } ?>
								</tr>
							</thead-->
							<tbody>
								<?php 
								foreach($permisos as $key => $list){ 
								$CMOClave_skip = $this->encrypt->encode( $list['CMOClave'] );
								$CACClave_skip = $this->encrypt->encode( $list['CACClave'] );
								?>
								<?php if($key%10 == 0){ ?>
									<tr>
										<th>Descripción</th>
										<th>Módulo</th>
										<th>Acción</th>
										<?php foreach($rol as $key => $des){ ?>
											<th class="text-center"><?php echo $des['CRODescripcion']; ?></th>
										<?php } ?>
									</tr>
								<?php } ?>
									<tr <?php echo nvl($bgcolor); ?>">
										<td><?php echo $list['CACDetalle']; ?></td>
										<td>
											<?php if( is_permitido(null,'permisos','save_accion') ){ ?>
											<div class="pull-right">
												<a type="button" class="btn btn-sm btn-primary btn-circle btn-outline open"
												data-toggle="modal"
												data-target="#modal_accion"
												data-cmoclave_skip="<?php echo $CMOClave_skip; ?>" 
												data-cmodescripcion="<?php echo $list['CMODescripcion']; ?>" 
												>
													<i class="fa fa-plus"></i>
												</a>
											</div>
											<?php } ?>
											<?php echo $list['CMODescripcion']; ?>
										</td>
										<td>
											<?php if( is_permitido(null,'permisos','delete_accion') ){ ?>
											<div class="pull-right">
												<a href="<?php echo base_url("permisos/delete_accion/$CACClave_skip"); ?>" type="button" class="btn btn-sm btn-danger btn-circle btn-outline" confirm="¿Está seguro de borrar la acción, ya no se podra recuperar?">
													<i class="fa fa-times"></i>
												</a>
											</div>
											<?php } ?>
											<?php echo $list['CACDescripcion']; ?>
										</td>
										<?php 
											foreach($rol as $key => $des){
												$where=array('CPEAccion' => $list['CACClave'], 'CPERol' => $des['CROClave']);
												$data=$this->permiso_model->find($where,'CPERol');
											?>
											<td class="text-center">
												<div class="i-checks">
													<input type="checkbox" <?php if($data) echo'checked'; ?> name='<?php echo $list['CPEAccion']; ?>[]' value="<?php echo $des['CROClave']; ?>" />
												</div>
											</td>
										<?php } ?>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					<div class="form-group">
						<div class="col-lg-12">
							<?php if( is_permitido(null,'permisos','update') ){ ?>
							<button class="btn btn-primary pull-right" type="submit"="this.disabled=true;"><i class="fa fa-save"></i> Guardar</button>
							<?php } ?>
							<a class="btn btn-default" href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-times"></i> Cancelar</a>                            
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal inmodal" id="modal_modulo" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" >
		<div class="modal-content animated flipInY">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
				<h6 class="modal-title"><i class="fa fa-cubes"></i>&nbsp;&nbsp; Módulo</h6><div class="border-bottom"><br /></div>
				
				<?php echo form_open('permisos/save_modulo', array('name' => 'FormModulo', 'id' => 'FormModulo', 'role' => 'form', 'class' => 'form-horizontal panel-body')); ?>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Módulo: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="CMODescripcion" name="CMODescripcion" value="" maxlength='150' class="form-control uppercase" />
					</div>
				</div>
				
				<div class="loading"></div>
				<div class="form-group">
					<div class="col-lg-offset-3 col-lg-9">
						<button type="submit" class="btn btn-primary pull-right"="this.disabled=true;"> <i class="fa fa-save"></i> Guardar</button>
					</div>
				</div>
				<?php echo form_close(); ?>
				
			</div>
		</div>
	</div>
</div>

<div class="modal inmodal" id="modal_accion" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" >
		<div class="modal-content animated flipInY">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
				<h6 class="modal-title"><i class="fa fa-cube"></i>&nbsp;&nbsp; Acción</h6><div class="border-bottom"><br /></div>
				
				<?php echo form_open('permisos/save_accion', array('name' => 'FormAccion', 'id' => 'FormAccion', 'role' => 'form', 'class' => 'form-horizontal panel-body')); ?>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Modulo:</label>
					<div class="col-lg-9">
						<input type="text" id="CMODescripcion" name="" value="" maxlength='150' class="form-control uppercase disabled" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Acción: <em>*</em></label>
					<div class="col-lg-9">
						<input type="text" id="CACDescripcion" name="CACDescripcion" value="" maxlength='150' class="form-control uppercase" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label" for="">Descripción: <em>*</em></label>
					<div class="col-lg-9">
						<textarea type="text" id="CACDetalle" name="CACDetalle" maxlength='255' class="form-control textarea" ></textarea>
					</div>
				</div>	
				
				<div class="loading"></div>
				<div class="form-group">
					<div class="col-lg-offset-3 col-lg-9">
						<input type="hidden" id="CMOClave_skip" name="CMOClave_skip" />
						<button type="submit" class="btn btn-primary pull-right"="this.disabled=true;"> <i class="fa fa-save"></i> Guardar</button>
					</div>
				</div>
				<?php echo form_close(); ?>
				
			</div>
		</div>
	</div>
</div>


<script src="<?php echo base_url('assets/inspinia/js/plugins/dataTables/datatables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/inspinia/js/plugins/iCheck/icheck.min.js'); ?>"></script>

<!-- Page-Level Scripts -->
<script>
	$(document).ready(function(){
		
		$('.i-checks').iCheck({
			checkboxClass: 'icheckbox_square-green',
			radioClass: 'iradio_square-green',
		});
		
		/* Ventana modal */
		$(document).on("click", ".open", function () {
			$(".modal-header #CMOClave_skip").val( $(this).data('cmoclave_skip') );
			$(".modal-header #CMODescripcion").val( $(this).data('cmodescripcion') );
		});
		
	});
</script>
