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
					<a href="<?= base_url('Docente/Update/'.$idPlantel); ?>" ><button class="btn btn-primary"><i class="fa fa-pencil"></i> Registrar Docente</button></a>
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
                                <th width="200px">Acción</th>
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
											<td class="text-center">
											<a href="<?= base_url('Docente/Update/'.$idPlantel.'/'.$UNCI_usuario_skip); ?>" ><button class="btn btn-primary"><i class="fa fa-pencil"></i> Editar</button></a>
											<?php echo $borrar; ?>
											</td>
										</tr>
								<?php $i++; } ?>
						</tbody>
					</table>
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
							url: "<?php echo base_url("Docente/quitarDocente"); ?>",
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