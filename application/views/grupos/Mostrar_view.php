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
                        <select name="GRPeriodo" id="PeriodoSemestre" class="form-control ValidarPeriodo">
                            <?php foreach ($periodos as $key => $listPeriodo) { ?>
                                <option value="<?=$listPeriodo['CPEPeriodo']?>">
                                    <?=substr($listPeriodo['CPEPeriodo'],0,2)?>-<?=substr($listPeriodo['CPEPeriodo'],3,1)==1?'A':'B'?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="">Semestre: <em>*</em></label>
                    <div class="col-lg-9">
                        <select name="GRSemestre" id="Semestre" class="form-control">
                            <option value="">- Semestre -</option>
                            <option value="1" style="display:none;">1</option>
                            <option value="2" style="display:none;">2</option>
                            <option value="3" style="display:none;">3</option>
                            <option value="4" style="display:none;">4</option>
                            <option value="5" style="display:none;">5</option>
                            <option value="6" style="display:none;">6</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label" for="">Grupo: <em>*</em></label>
                    <div class="col-lg-9">
                        <input type="text" id="GRGrupo" name="GRGrupo" value="" maxlength='3' class="form-control ValidarGrupo" />
                    </div>
                </div>  
                <div id="error1"></div>
                <div class="loading1"></div>

                <div class="form-group" id="Resultado"></div>

                <div class="form-group" id="Turnos" >
                    <label class="col-lg-3 control-label" for="">Turno: <em>*</em></label>
                    <div class="col-lg-3">
                        <select name="GRTurno" id="GRTurno"  class="form-control">
                            <option value="">- Turno -</option>
                            <option value="1">Matutino</option>
                            <option value="2">Vespertino</option>
                        </select>
                    </div>
                    <label class="col-lg-3 control-label" for="">No. Alumnos: <em>*</em></label>
                    <div class="col-lg-3">
                        <input type="int" name="GRCupo" id="GRAlumnos" value="" class="form-control"  maxlength="2">
                    </div>
                </div>
                
                <div id="error"></div>
                <div class="loading"></div>
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

    /* Ventana modal */
	$(document).on("click", ".open", function () {
        //$('#FormGrupos')[0].reset();
        $(this).removeData('modal');s

        var idPlantel = $(this).data('pclave_plantel');
        $(".modal-header #idPlantel").val( $(this).data('pclave_plantel') );

        var tipoPlantel = $(this).data('ptipo_plantel');
        $(".modal-header #CPLTipo").val( $(this).data('ptipo_plantel') );

        var valor = $(this).data('pnombre_plantel');
        document.getElementById("PNombre_plantel").innerHTML = valor;
        var NoGrupos = $(this).data('pturnos');

        if (NoGrupos == '1') {
            $("#GRTurno").val(1).addClass('disabled');
        } else {
            $("#GRTurno").val('').removeClass('disabled');
        }

        $(document).on("change", ".ValidarGrupo", function () {
        var valor = document.getElementById("GRGrupo").value;
        var grup = valor.slice(0, 1)
        
            $.ajax({
                type: "POST",
                url: "<?php echo base_url("grupos/selectCap"); ?>",
                data: {idPlantel: idPlantel, valorGrupo: grup, tipoPlantel: tipoPlantel},
                dataType: "html",
                beforeSend: function(){
                    //carga spinner
                    $(".loading1").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
                },
                success: function(data){
                    if(data =='OK'){
                        $("#Resultado").show('slow');
                    } else {
                        $("#error1").empty();
                        $("#error1").append(data);   
                        $(".loading1").html(""); 
                    }
                    
                }
            });
        });//----->fin

        $(".msg").empty();
        datosGrupos(idPlantel);

        var valor = $("#PeriodoSemestre option:selected").val();  
        abrirPeriodos(valor);

    });//----->fin

    function datosGrupos(idPlantel){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("grupos/selectGrupos"); ?>",
            data: "GRCPlantel=" + idPlantel,
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data){
                $(".result").empty();
                $(".result").append(data);  
                $(".loading").html("");
            }
        });
    }//----->fin

    $(".save").click(function() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("grupos/save"); ?>",
            data: $(this.form).serialize(),
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data){
                var data = data.split(";");
                if(data[0]==' OK'){
                    $(".msg").empty();
                    $(".msg").append(data[1]);
                    datosGrupos( data[2] );
                    $('#FormGrupos')[0].reset();
                    $(".loading").html("");
                }
                else{
                    $(".msg").empty();
                    $(".msg").append(data[0]);  
                    datosGrupos( data[1] );
                    $(".loading").html(""); 
                }
                
            }
        });
    });//----->fin

    $(document).on("change", ".ValidarPeriodo", function (event) {
        var valor = $("#PeriodoSemestre option:selected").val();  
        abrirPeriodos(valor);       
    });

    function abrirPeriodos(valor) {
        var sem = valor.split('-')[1];
        if (sem == 2) {
            document.FormGrupos.Semestre.options[1].style.display = 'block';
            document.FormGrupos.Semestre.options[2].style.display = 'none';
            document.FormGrupos.Semestre.options[3].style.display = 'block';
            document.FormGrupos.Semestre.options[4].style.display = 'none';
            document.FormGrupos.Semestre.options[5].style.display = 'block';
            document.FormGrupos.Semestre.options[6].style.display = 'none';
        } if (sem == 1) {
            document.FormGrupos.Semestre.options[1].style.display = 'none';
            document.FormGrupos.Semestre.options[2].style.display = 'block';
            document.FormGrupos.Semestre.options[3].style.display = 'none';
            document.FormGrupos.Semestre.options[4].style.display = 'block';
            document.FormGrupos.Semestre.options[5].style.display = 'none';
            document.FormGrupos.Semestre.options[6].style.display = 'block';
        }
        
    }

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