<link href="<?php echo base_url('assets/inspinia/css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">
<!--color boox-->
<script type="text/javascript" src="<?php echo base_url("assets/colorbox/jquery.colorbox-min.js") ?>"></script>
<link media="screen" rel="stylesheet" href="<?php echo base_url("assets/colorbox/colorbox.css") ?>" />
<div class="row">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
			<h3>NÚMERO DE HORAS CLASE ASIGNADAS POR PLANTEL</h3>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<?php muestra_mensaje(); ?>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<!--<div class="pull-right">
				<?php if( is_permitido(null,'fump','alta_excel') ){ ?>
					<a href='<?php echo base_url('fump/alta_excel/'); ?>' class="btn btn-primary" >
						<i class="fa fa-file-excel-o"></i> Descargar Excel
					</a>
				<?php } ?>
				</div>-->
				<h3>&nbsp;</h3>
			</div> 
			<div class="ibox-content">
				
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTables-example dataTable" >
						<thead>
							<tr>
								<th>#</th>
								<th>Plantel</th>
								<th>CCT</th>
								<th>Correo</th>
                                <th>Director</th>
                                <th width="130px">Acción</th> 
							</tr>	
						</thead>
						<tbody>
							<?php 
								foreach($planteles as $key => $list){
                                    $PClave_skip = $this->encrypt->encode($list['CPLClave']);
                                    $PClave_skips = $this->encrypt->encode($list['CPLClave']);
								?>
								<tr>
									<td class="text-left"><?php echo folio($list['CPLClave']); ?></td> 
									<td class="text-left"><?php echo $list['CPLNombre']; ?></td>								
									<td class="text-left"><?php echo $list['CPLCCT']; ?></td>
									<td class="text-left"><?php echo $list['CPLCorreo_electronico']; ?></td>
									<td class="text-lett"><?php echo $list['CPLDirector']; ?></td>
									<td>
                                    <button class="btn btn-default btn-sm open"
                                        data-target="#modal_horas" 
                                        data-toggle="modal"
                                        data-pclave_encrip="<?php echo $PClave_skip; ?>" 
                                        data-pclave_plantel="<?php echo $list['CPLClave']; ?>" 
                                        data-pnombre_plantel="<?php echo $list['CPLNombre']; ?>" 
                                        ><i class="fa fa-eye"></i> Ver Horarios
                                    </button>
                                    <button class="btn btn-default btn-sm openReporte"
                                        data-target="#modal_reporte" 
                                        data-toggle="modal"
                                        data-pcla_encrip="<?php echo $PClave_skips; ?>" 
                                        data-rclave_plantel="<?php echo $list['CPLClave']; ?>" 
                                        data-rnombre_plantel="<?php echo $list['CPLNombre']; ?>" 
                                        ><i class="fa fa-eye"></i> Ver Reporte
                                    </button>
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

<div class="modal inmodal" id="modal_horas" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" >
		<div class="modal-content animated flipInY">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
				<h4 class="modal-title"><i class="fa fa-building-o"></i>&nbsp;&nbsp; PLANTEL Y/O CEMSAD: <div id="PNombre_plantel"></div> </h4><div class="border-bottom"><br /></div>
                <input type="hidden" name="ClavePlantelEnc" id="ClavePlantelEnc">
                <input type="hidden" name="Clave_plantel" id="Clave_plantel">
                <input type="hidden" name="PlantelId" id="PlantelId">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="">Periodo Escolar: <em>*</em></label>
                        <div class="col-lg-9">
                            <select name="SemestrePeriodo" id="SemestrePeriodo" class="form-control SemestrePeriodo">
                                <?php foreach ($periodos as $key => $listP) { ?>
                                        <option value="<?php echo $listP['CPEPeriodo']; ?>"> 
                                            <?=substr($listP['CPEPeriodo'],0,2)?>-<?=substr($listP['CPEPeriodo'],3,1)==1?'A':'B'?>
                                        </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
				    <div id="msg"></div>
                    <div class="result"></div>
				    <div class="loading"></div>				
			</div>
            <div class="modal-footer">
                <a href="" target="_blank" id="Imprimir" type="button" class="btn btn-success btn-sm"><i class="fa fa-print"></i> Imprimir</a>
            </div>
		</div>
	</div> 
</div>

<div class="modal inmodal" id="modal_reporte" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title"><i class="fa fa-building-o"></i>&nbsp;&nbsp; PLANTEL Y/O CEMSAD: <div id="RNombre_plantel"></div> </h4><div class="border-bottom"><br /></div>
                <input type="hidden" name="RClave_plantel" id="RClave_plantel">
                <input type="hidden" name="ClavePlantelRep" id="ClavePlantelRep">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="">Periodo Escolar: <em>*</em></label>
                        <div class="col-lg-9">
                            <select name="SemestreReporte" id="SemestreReporte" class="form-control SemestreReporte">
                                <?php foreach ($periodos as $key => $listPeriodo) { ?>
                                        <option value="<?php echo $listPeriodo['CPEPeriodo']; ?>">
                                            <?=substr($listPeriodo['CPEPeriodo'],0,2)?>-<?=substr($listPeriodo['CPEPeriodo'],3,1)==1?'A':'B'?>
                                        </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div id="msgReporte"></div>
                    <div class="resultReporte table responsive">"></div>
                    <div class="loadingReporte"></div>

                    <div class="modal-footer">
                        <a href="" target="_blank" id="ImprimirRep" type="button" class="btn btn-success btn-sm"><i class="fa fa-print"></i> Imprimir</a>
                    </div>
            </div>
        </div>
    </div> 
</div>


<script src="<?php echo base_url('assets/inspinia/js/plugins/dataTables/datatables.min.js'); ?>"></script>

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

    /* Ventana modal */
	$(document).on("click", ".open", function () {
        var valor = $(this).data('pnombre_plantel');
        document.getElementById("PNombre_plantel").innerHTML = valor;

        $(".modal-header #ClavePlantelEnc").val( $(this).data('pclave_encrip') );
        $(".modal-header #Clave_plantel").val( $(this).data('pclave_plantel') );
		$(".modal-header #PNombre_plantel").val( $(this).data('pnombre_plantel') );

        $(".result").empty();
        $(".loading").empty();
        abrirHorarios();
	});

    $(document).on("change", ".SemestrePeriodo", function (event) {
        abrirHorarios();
    });

    function abrirHorarios(){ 
        var valor1 = $(".SemestrePeriodo option:selected").val();
        var search = window.btoa(unescape(encodeURIComponent(valor1))).replace("=","").replace("=","");
        var idPlantel = document.getElementById("ClavePlantelEnc").value;

        var valor = $(".SemestrePeriodo option:selected").val();
        var PlantelId = document.getElementById("Clave_plantel").value;
        
        $("#Imprimir").attr("href","<?php echo base_url("HorasClase/imprimirHoras"); ?>/"+idPlantel+"/"+search);

        var sem = valor.split('-')[1];
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("HorasClase/listaHoras_skip"); ?>",
            data: {idPlantel: PlantelId, periodo: valor},
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data){
                $(".msg").empty();
                $(".result").empty();
                $(".result").append(data);
                $(".loading").empty();
            }
        });
    }

    /* Ventana modal */
    $(document).on("click", ".openReporte", function () {
        var valor = $(this).data('rnombre_plantel');
        document.getElementById("RNombre_plantel").innerHTML = valor;

        $(".modal-header #ClavePlantelRep").val( $(this).data('pcla_encrip') );
        $(".modal-header #RClave_plantel").val( $(this).data('rclave_plantel'));
        $(".resultReporte").empty();
        $(".loadingReporte").empty();
        abrirReporte();  

    });

    $(document).on("change", ".SemestreReporte", function (event) {
        abrirReporte();       
    });

    function abrirReporte() {
        var valorSem = $(".SemestreReporte option:selected").val();
        var searchSem = window.btoa(unescape(encodeURIComponent(valorSem))).replace("=","").replace("=","");
        var idPlantelRep = document.getElementById("ClavePlantelRep").value;
        
        var valor = $(".SemestreReporte option:selected").val();
        var PlantelId = document.getElementById("RClave_plantel").value;
        

        $("#ImprimirRep").attr("href","<?php echo base_url("HorasClase/imprimirReporte_skip"); ?>/"+idPlantelRep+"/"+searchSem);

        var sem = valor.split('-')[1];
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("HorasClase/verReporte_skip"); ?>",
            data: {idPlantel: PlantelId, periodo: valor},
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data){
                $(".msgReporte").empty();
                $(".resultReporte").empty();
                $(".resultReporte").append(data);
                $(".loadingReporte").empty();
            }
        });
    }

</script>