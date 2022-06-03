<link href="<?php echo base_url('assets/inspinia/css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/inspinia/css/plugins/datapicker/datepicker3.css'); ?>" rel="stylesheet" />
<!--color boox-->
<script type="text/javascript" src="<?php echo base_url("assets/colorbox/jquery.colorbox-min.js") ?>"></script>
<link media="screen" rel="stylesheet" href="<?php echo base_url("assets/colorbox/colorbox.css") ?>" />
<div class="row">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
			<h3>PERIDOS</h3>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<div class="pull-right">
				<?php if( is_permitido(null,'periodos','save') ){ ?>
					<button class="btn btn-primary open"
                        data-target="#modal_periodos"
						data-pclave_skip="" 
                        data-toggle="modal"
                        ><i class="fa fa-plus"></i> Agregar Periodo
                    </button>
				<?php } ?>
				</div>
				<h3>&nbsp;</h3>
			</div> 
			<div class="ibox-content">
				
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTables-example dataTable" >
						<thead>
							<tr>
								<th>#</th>
								<th>Periodo</th>
								<th>Fecha Inicio</th>
								<th>Fecha Fin</th>
                                <?php if( is_permitido(null,'periodos','delete') || is_permitido(null,'periodos','save') ) { ?>
                                    <th>Acción</th>
                                <?php } ?>
							</tr>	
						</thead>
						<tbody>
							<?php 
                            $cont = 1;
								foreach($editar as $key => $list){
                                    $PClave_skip = $this->encrypt->encode($list['CPEClave']);
                                    $StatusInactivo = $this->encrypt->encode('0');
								?>
								<tr>
									<td class="text-left"><?php echo folio($cont); ?></td> 
									<td class="text-left"><?php echo $list['CPEPeriodo'].'-'.$list['CPEPeriodoSem']; ?></td>								
									<td class="text-left"><?php echo $list['InicioPeriodo']; ?></td>
									<td class="text-left"><?php echo $list['FinPeriodo']; ?></td>
                                    <td class="text-center">
                                        <?php if( is_permitido(null,'periodos','save')) { ?>
                                        <button 
                                            class="btn btn-default btn-sm editar"
                                            data-target="#modal_periodos" 
                                            data-toggle="modal"
                                            data-pclave_skip="<?php echo $PClave_skip; ?>" 
                                            data-cpeclave="<?php echo $list['CPEClave']; ?>"
                                            data-cpeperiodo="<?php echo $list['CPEPeriodo']; ?>"
                                            data-cpeperiodosem="<?php echo $list['CPEPeriodoSem']; ?>"
                                            data-periodoinicio="<?php echo $list['InicioPeriodo']; ?>"
                                            data-periodofin="<?php echo $list['FinPeriodo']; ?>"
                                            ><i class="fa fa-pencil"></i> Editar
                                        </button>
                                    <?php } if( is_permitido(null,'periodos','delete')) { ?>
                                        <a href="<?php echo base_url("periodos/delete/$PClave_skip/$StatusInactivo"); ?>" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i> Borrar</a>
                                    <?php  $cont ++; } ?>
                                    </td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
					</form>
				</div>
				
			</div>
		</div>
	</div>
</div>

<div class="modal inmodal" id="modal_periodos" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" >
		<div class="modal-content animated flipInY">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
				<h4 class="modal-title"><i class="fa fa-building-o"></i>&nbsp;&nbsp; PERIODOS </h4><div class="border-bottom"><br /></div>

                <?php echo form_open('periodos/save', array('name' => 'FormPeriodo', 'id' => 'FormPeriodo', 'role' => 'form', 'class' => 'form-horizontal panel-body')); ?>
                <input type="hidden" name="CPEClave" id="CPEClave" value="">
                <div class="form-group">
                    <label class="col-lg-2 control-label" for="">Periodo: <em>*</em></label>
                    <div class="col-lg-5" id="CPEPeriodo">
                        <select name="CPEPeriodo" id="CPEPeriodo" class="form-control">
                            <option value="">-Periodo-</option>
                            <?php for($i = date('y') + 1; $i >=(date('y') - 14); $i--){ ?>
                                <option value="<?= setDia($i) ?>"><?= setDia($i) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-5" id="CPEPeriodoSem">
                        <select name="CPEPeriodoSem" id="CPEPeriodoSem" class="form-control">
                            <option value="">-Semestre-</option>
                            <?php for($i='1';$i<='2';$i++){ ?>
                                <option value="<?=$i?>"><?= $i ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <br>

                <div class="form-group">
                    <label class="col-lg-4 control-label" for="">Inicio de Periodo: <em>*</em></label>
                    <div class="col-lg-8">
                        <input type="text" id="InicioPeriodo" name="InicioPeriodo" value="" maxlength='150' 
                        class="form-control date" autocomplete="off"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 control-label" for="">Fin de Periodo: <em>*</em></label>
                    <div class="col-lg-8">
                        <input type="text" id="FinPeriodo" name="FinPeriodo" value="" maxlength='150' 
                        class="form-control date" autocomplete="off"/>
                    </div>
                </div>                <div id="error"></div>
                <div class="loading"></div>
                <?php muestra_mensaje(); ?>
                <br>
                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <?php if( is_permitido(null,'periodos','save') ){ ?>
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
<script src="<?php echo base_url('assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('assets/date_picker_es.js'); ?>"></script>

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
					$(win.document.body).find('table')
					.addClass('compact')
					.css('font-size', 'inherit');
				}
			}
			]
		});		
		
	});

    /* Ventana modal Editar*/
        $(document).on("click", ".editar", function () {
            $(".modal-header #PClave_skip").val( $(this).data('pclave_skip') );
            $(".modal-header #CPEClave").val( $(this).data('cpeclave') );
            $(".modal-header #CPEPeriodo").val( $(this).data('cpeperiodo') );
            $(".modal-header #CPEPeriodoSem").val( $(this).data('cpeperiodosem') );
            $(".modal-header #InicioPeriodo").val( $(this).data('periodoinicio') );
            $(".modal-header #FinPeriodo").val( $(this).data('periodofin') );
        });

    $(".save").click(function() {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url("periodos/save"); ?>",
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
</script>