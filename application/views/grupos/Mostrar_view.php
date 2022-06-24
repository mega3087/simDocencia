<link href="<?php echo base_url('assets/inspinia/css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">
<!--color boox-->
<script type="text/javascript" src="<?php echo base_url("assets/colorbox/jquery.colorbox-min.js") ?>"></script>
<link media="screen" rel="stylesheet" href="<?php echo base_url("assets/colorbox/colorbox.css") ?>" />
<div class="row">
	<div class="ibox float-e-margins">
		<div class="ibox-content">
			<h3>GRUPOS</h3>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		
		<div class="ibox float-e-margins">
			<!--<div class="ibox-title">
				<div class="pull-right">
				<?php if( is_permitido(null,'grupos','save') ){ ?>
                    <button class="btn btn-primary open"
                        data-target="#modal_grupos" 
                        data-toggle="modal"
                        ><i class="fa fa-plus"></i> Agregar Grupos
                    </button>
                <?php } ?>
				</div>
				<h3>&nbsp;</h3>
			</div>-->
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
								?>
								<tr>
									<td class="text-left"><?php echo folio($list['CPLClave']); ?></td> 
									<td class="text-left"><?php echo $list['CPLNombre']; ?></td>								
									<td class="text-left"><?php echo $list['CPLCCT']; ?></td>
									<td class="text-left"><?php echo $list['CPLCorreo_electronico']; ?></td>
									<td class="text-lett"><?php echo $list['CPLDirector']; ?></td>
									<td>
                                    <?php if( is_permitido(null,'grupos','save') ){ ?>
                                    <button class="btn btn-primary btn-sm open"
                                        data-target="#modal_grupos" 
                                        data-toggle="modal"
                                        data-pclave_plantel="<?php echo $list['CPLClave']; ?>" 
                                        data-pnombre_plantel="<?php echo $list['CPLNombre']; ?>" 
                                        data-pturnos="<?php echo $list['CPLTurnos']; ?>" 
                                        data-ptipo_plantel="<?php echo $list['CPLTipo']; ?>" 
                                        ><i class="fa fa-plus"></i> Agregar Grupos
                                    </button>
                                    <?php } ?>
                                    <button class="btn btn-default btn-sm openGrupos"
                                        data-target="#modal_ver_grupos" 
                                        data-toggle="modal"
                                        data-rclave_plantel="<?php echo $PClave_skip; ?>" 
                                        data-clave_plantel="<?php echo $list['CPLClave']; ?>" 
                                        data-nombre_plantel="<?php echo $list['CPLNombre']; ?>" 
                                        ><i class="fa fa-eye"></i> Ver Grupos
                                    </button>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
	</div>
</div>

<!-- Ventana modal de agregar Grupo Nuevo-->
<div class="modal inmodal" id="modal_grupos" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" >
		<div class="modal-content animated flipInY">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
				<h4 class="modal-title"><i class="fa fa-building-o"></i>&nbsp;&nbsp; PLANTEL Y/O CEMSAD: <div id="PNombre_plantel"></div> </h4><div class="border-bottom"><br /></div><br>
                <?php echo form_open('grupos/save', array('name' => 'FormGrupos', 'id' => 'FormGrupos', 'role' => 'form', 'class' => 'form-horizontal panel-body')); ?>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="">Periodo Escolar: <em>*</em></label>
                    <div class="col-lg-9">
                        <select name="GRPeriodo" id="PeriodoSemestre" class="form-control ValidarPeriodo disabled">
                            <?php foreach ($periodos as $key => $listPeriodo) { ?>
                                <option value="<?=$listPeriodo['CPEPeriodo']?>">
                                    <?=substr($listPeriodo['CPEPeriodo'],0,2)?>-<?=substr($listPeriodo['CPEPeriodo'],3,1)==1?'A':'B'?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <table class="table table-striped table-bordered table-hover dataTable">
                        <thead>
                            <tr>
                                <th>Periodo</th>
                                <th>Semestre</th>
                                <th>Turno</th>
                                <th># de Grupos</th>
                                <?php if( is_permitido(null,'grupos','save') ){ ?>
                                <th >Acción</th>
                                <?php } ?> 
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td rowspan="2">
                                    <?= substr($periodos[0]['CPEPeriodo'],0,2)?>-<?=substr($periodos[0]['CPEPeriodo'],3,1)==1?'A':'B'; echo "  (".substr($periodos[0]['CPEPeriodo'],-1).")"; ?>
                                    <input type="hidden" name="CPEPeriodo" id="CPEPeriodo" value="<?= $periodos[0]['CPEPeriodo']; ?>" />
                                </td>
                                <td rowspan="2">
                                    <?= substr($listPeriodo['CPEPeriodo'],3,1)==1?'1':'2'; ?>
                                    <input type="hidden" name="CPESemestre" id="CPESemestre" value="<?= substr($listPeriodo['CPEPeriodo'],3,1)==1?'1':'2'; ?>" />
                                </td>
                                <td>
                                    Matutino
                                    <input type="hidden" name="CPETurno" id="CPETurno" value="Matutino" />
                                </td>
                                <td>
                                    <input type="number" name="NoGrupos" id="NoGrupos" class="form-group">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-warning pull-center"> <i class="fa fa-pencil"></i> Editar</button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Vespertino
                                    <input type="hidden" name="CPETurno" id="CPETurno" value="Vespertino" />
                                </td>
                                <td>
                                    <input type="number" name="NoGrupos" id="NoGrupos" class="form-group">
                                </td>
                                <td class="text-center"><button type="button" class="btn btn-warning pull-center"> <i class="fa fa-pencil"></i> Editar</button></td>
                            </tr> 
                            
                            <tr>
                                <td rowspan="2">
                                    <?= substr($periodos[0]['CPEPeriodo'],0,2)?>-<?=substr($periodos[0]['CPEPeriodo'],3,1)==1?'A':'B'; echo "  (".substr($periodos[0]['CPEPeriodo'],-1).")"; ?>
                                    <input type="hidden" name="CPEPeriodo" id="CPEPeriodo" value="<?= $periodos[0]['CPEPeriodo']; ?>" />
                                </td>
                                <td rowspan="2">
                                    <?= substr($listPeriodo['CPEPeriodo'],3,1)==1?'3':'4'; ?>
                                    <input type="hidden" name="CPESemestre" id="CPESemestre" value="<?= substr($listPeriodo['CPEPeriodo'],3,1)==1?'3':'4'; ?>" />
                                </td>
                                <td>
                                    Matutino
                                    <input type="hidden" name="CPETurno" id="CPETurno" value="Matutino" />
                                </td>
                                <td><input type="number" name="NoGrupos" id="NoGrupos" class="form-group"></td>
                                <td class="text-center"><button type="button" class="btn btn-warning pull-center"> <i class="fa fa-pencil"></i> Editar</button></td>
                            </tr>
                            <tr>
                                <td>
                                    Vespertino
                                    <input type="hidden" name="CPETurno" id="CPETurno" value="Vespertino" />
                                </td>
                                <td><input type="number" name="NoGrupos" id="NoGrupos" class="form-group"></td>
                                <td class="text-center"><button type="button" class="btn btn-warning pull-center"> <i class="fa fa-pencil"></i> Editar</button></td>
                            </tr> 

                            <tr>
                                <td rowspan="2">
                                    <?= substr($periodos[0]['CPEPeriodo'],0,2)?>-<?=substr($periodos[0]['CPEPeriodo'],3,1)==1?'A':'B'; echo "  (".substr($periodos[0]['CPEPeriodo'],-1).")"; ?>
                                    <input type="hidden" name="CPEPeriodo" id="CPEPeriodo" value="<?= $periodos[0]['CPEPeriodo']; ?>" />
                                </td>
                                <td rowspan="2">
                                    <?= substr($listPeriodo['CPEPeriodo'],3,1)==1?'5':'6'; ?>
                                    <input type="hidden" name="CPESemestre" id="CPESemestre" value="<?= substr($listPeriodo['CPEPeriodo'],3,1)==1?'5':'6'; ?>" />
                                </td>
                                <td>
                                    Matutino
                                    <input type="hidden" name="CPETurno" id="CPETurno" value="Matutino" />
                                </td>
                                <td><input type="number" name="NoGrupos" id="NoGrupos" class="form-group"></td>
                                <td class="text-center"><button type="button" class="btn btn-warning pull-center"> <i class="fa fa-pencil"></i> Editar</button></td>
                            </tr>
                            <tr>
                                <td>
                                    Vespertino
                                    <input type="hidden" name="CPETurno" id="CPETurno" value="Vespertino" />
                                </td>
                                <td><input type="number" name="NoGrupos" id="NoGrupos" class="form-group"></td>
                                <td class="text-center"><button type="button" class="btn btn-warning pull-center"> <i class="fa fa-pencil"></i> Editar</button></td>
                            </tr> 
                        </tbody>
                    </table>
                </div>
                
                <div id="error"></div>
                <div class="loading"></div>
                <br><br><br>
				<div class="form-group">
                    <input type="hidden" name="GRCPlantel" id="idPlantel" value="">
                    <input type="hidden" name="CPLTipo" id="CPLTipo" value="">
					<div class="col-lg-offset-3 col-lg-9">
                        <?php if( is_permitido(null,'grupos','save') ){ ?>
                        <button type="button" class="btn btn-primary pull-right save"> <i class="fa fa-save"></i> Guardar</button>
                        <?php } ?>
					</div>
				</div>

                <div class="form-group">
                    <form action="#" method='POST' name='grupos_datos' id='grupos_datos'>
                        <div class="msg"></div>
                        <div class="result"></div>
                    </form>
                </div>

				<?php form_close(); ?>
			</div>
		</div>
	</div> 
</div>
<!--Fin de ventana modal-->

<!--Ventana modal de ver Grupos-->
<div class="modal inmodal" id="modal_ver_grupos" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content animated flipInY">
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title"><i class="fa fa-building-o"></i>&nbsp;&nbsp; PLANTEL Y/O CEMSAD: <div id="PlantelNombre"></div> </h4><div class="border-bottom"><br /></div>
                <input type="hidden" name="PlantelId" id="PlantelId">
                <input type="hidden" name="ClavePlantelRep" id="ClavePlantelRep">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="">Periodo Escolar: <em>*</em></label>
                        <div class="col-lg-9">
                            <select name="SemestrePeriodo" id="SemestrePeriodo" class="form-control SemestrePeriodo">
                                <?php foreach ($periodos as $key => $listPer) { ?>
                                    <option value="<?php echo $listPer['CPEPeriodo']; ?>">
                                         <?=substr($listPer['CPEPeriodo'],0,2)?>-<?=substr($listPer['CPEPeriodo'],3,1)==1?'A':'B'?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <form action="#" method='POST' name='perido_grupos' id='perido_grupos'>
                            <div class="msgGrupos"></div>
                            <div class="resultGrupos"></div>
                        </form>
                    </div>
                    <div class="loading"></div>
                    <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="" target="_blank" id="ImprimirGrupos" type="button" class="btn btn-success btn-sm"><i class="fa fa-print"></i> Imprimir</a>
                </div>
            </div>
        </div>
    </div> 
</div>
<!--Fin de ventana ver grupos-->


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
		
	});//----->fin

    /* Ventana modal ver grupos*/
    $(document).on("click", ".openGrupos", function () {
        var valor = $(this).data('nombre_plantel');
        document.getElementById("PlantelNombre").innerHTML = valor;

        var idPlantel = $(this).data('clave_plantel');
        $(".modal-header #PlantelId").val( $(this).data('clave_plantel'));

        $(".modal-header #ClavePlantelRep").val( $(this).data('rclave_plantel') );

        $(".resultGrupos").empty(); 
        $(".loading").empty();
        abrirReporte();
    });

    $(document).on("change", ".SemestrePeriodo", function (event) {
        abrirReporte();       
    });

    function abrirReporte() {
        var valorSem = $(".SemestrePeriodo option:selected").val();
        var searchSem = window.btoa(unescape(encodeURIComponent(valorSem))).replace("=","").replace("=","");
        var idPlantelRep = document.getElementById("ClavePlantelRep").value;
        
        var valor = $(".SemestrePeriodo option:selected").val();
        var PlantelId = document.getElementById("PlantelId").value;
        

        $("#ImprimirGrupos").attr("href","<?php echo base_url("grupos/ImprimirGrupos"); ?>/"+idPlantelRep+"/"+searchSem);

        var sem = valor.split('-')[1];
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("grupos/listaGrupos"); ?>",
            data: {idPlantel: PlantelId, periodo: valor},
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data){
                $(".msgGrupos").empty();
                $(".resultGrupos").empty();
                $(".resultGrupos").append(data);
                $(".loading").empty();
            }
        });
    }

</script>