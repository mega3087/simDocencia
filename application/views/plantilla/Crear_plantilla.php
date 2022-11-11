<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Crear Plantilla</h2>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-tab panel-tab-double shadow">
            <!-- Start tabs heading -->
            <div class="panel-heading no-padding">
                <ul class="nav nav-tabs">
                    <li class="<?php if($plantillas) echo"active"; ?>" nav-border nav-border-top-danger>
                        <a href="#plantillas" data-toggle="tab" onclick="js:tablaPlantillas();">
                            <i class="fa fa-list-alt fg-danger"></i>
                            <div>
                                <span class="text-strong">Plantillas</span>                                
                            </div>
                        </a>
                    </li>
					<li class="<?php if(!$plantillas) echo"in active"; ?>" nav-border nav-border-top-danger>
                        <a href="#docentes" data-toggle="tab">
                            <i class="fa fa-users fg-danger"></i>
                            <div>
                                <span class="text-strong">Docentes</span>                                
                            </div>
                        </a>
                    </li>
                    <?php if (is_permitido(null,'generarplantilla','save')) { ?>
                    <li class="nav-border nav-border-top-danger">
                        <a href="#agregar-materias" data-toggle="tab" onclick="limpiarFormulario()">
                            <i class="fa fa-pencil fg-danger"></i>
                            <div>
                                <span class="text-strong">Asignar Materias</span>
                            </div>
                        </a>
                    </li>
                    <?php } ?>
                    <li class="nav-border nav-border-top-danger">
                        <a href="#ver-plantilla" data-toggle="tab" onclick="verPlantilla('<?php echo $this->plantilla_model->plantilla_actual($plantel); ?>')">
                            <i class="fa fa-eye fg-danger"></i>
                            
                            <div>
                                <span class="text-strong">Ver Plantilla</span>
                            </div>
                        </a>
                    </li>
                    
                </ul>
            </div>
            <!--/ End tabs heading -->
            
            <!-- Start tabs content -->							
            <div class="panel-body no-padding">
                <div class="panel panel-default shadow no-margin">
                    <div class="panel-body">
                        <div class="tab-content">
							<div class="tab-pane fade <?php if($plantillas) echo"in active"; ?>" id="plantillas">
								&nbsp;
                            </div>
                            <div class="tab-pane fade <?php if(!$plantillas) echo"in active"; ?>" id="docentes">
								<ol class="breadcrumb">
									<li class="breadcrumb-item">
										<button class="btn btn-outline btn-primary" id="UDTipo_Base" onclick='tablaBase()' value="1"  type="button"> <i class="fa fa-users"></i> Docentes BASE</button>
									</li>
									<li class="breadcrumb-item">
									<button class="btn btn-outline btn-primary" id="UDTipo_Idoneo" onclick='tablaIdoneo()' value="2" type="button"> <i class="fa fa-users"></i> Docentes IDONEOS</button>    
									</li>
									<li class="breadcrumb-item">
									<button class="btn btn-outline btn-primary" id="UDTipo_Usicamm" onclick='tablaUsicamm()' value="3" type="button"> <i class="fa fa-users"></i> Docentes USICAMM</button>
									</li>
									<li class="breadcrumb-item">
										<button class="btn btn-outline btn-primary" id="UDTipo_Externo" onclick='tablaExterno()' value="4" type="button"> <i class="fa fa-users"></i> Docentes EXTERNOS</button>
									</li>
								</ol>
								<br><br>
								<input type="hidden" name="cicloEsc" id="cicloEsc" value="<?= substr($periodos[0]['CPEPeriodo'],3,1); ?>"> 
								<div class="loading"></div>
								<div class="table-responsive mostrarTabla"></div>
                            </div>
                            <div class="tab-pane fade form-horizontal" id="agregar-materias">
                                <form action="<?php echo base_url("generarplantilla/save"); ?>" name="formGuardar" id="formGuardar" method="POST" class="wizard-big form-vertical">
                                    <input type="hidden" name="idPPlantel" id="plantelId" value="<?= $plantel; ?>"> 
                                    <input type="hidden" name="idPUsuario" id="idUsuario" value="">
                                    <div class="form-group">    
                                        <div class="mostrarAsignarMaterias">
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="">Tipos de Nombramiento: <em>*</em></label>
                                                <div class="col-lg-9">
                                                    <select name="idPUDatos" id="nombramiento" class="form-control">
                                                            <option value="">Seleccionar</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="">Estudios: <em>*</em></label>
                                                <div class="col-lg-9">
                                                    <select name="pidLicenciatura" id="licenciatura" class="form-control">
                                                            <option value="">Seleccionar</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label" for="">Periodo Escolar: <em>*</em></label>
                                        <div class="col-lg-9">
                                            <select name="pperiodo" id="periodo" class="form-control periodo disabled">
                                                <?php foreach ($periodos as $key => $listPer) { ?>
                                                    <option value="<?php echo $listPer['CPEPeriodo']; ?>">
                                                            <?='20'.substr($listPer['CPEPeriodo'],0,2)?> <?=substr($listPer['CPEPeriodo'],3,1)==1?'(Febrero-Agosto)':'(Agosto-Febrero)'?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-9">
                                            <?php if (substr($periodos[0]['CPEPeriodo'],3,1) == '2'){?>
                                                <div class="col-lg-4"><input type="checkbox" name="psemestre[]" id="1" class="sem1 semestre" value="1"><label class="control-label">&nbsp;1 Semestre <em>*</em></label></div>
                                            <?php } else { ?>
                                                <div class="col-lg-4"><input type="checkbox" name="psemestre[]" id="2" class="sem2 semestre" value="2"><label class="control-label">&nbsp;2 Semestre <em>*</em></label></div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-9">
                                            <div class="mostrarMat1">&nbsp;</div>
                                            <div class="mostrarMat2">&nbsp;</div>
                                        </div>
                                    </div>                                    

                                    <div class="form-group">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-9">
                                            <?php if (substr($periodos[0]['CPEPeriodo'],3,1) == '2'){?>
                                                <div class="col-lg-4"><input type="checkbox" name="psemestre[]" id="3" class="sem3" value="3"><label class="control-label">&nbsp;3 Semestre <em>*</em></label></div>
                                            <?php } else { ?>
                                                <div class="col-lg-4"><input type="checkbox" name="psemestre[]" id="4" class="sem4" value="4"><label class="control-label">&nbsp;4 Semestre <em>*</em></label></div><div class="col-lg-4"><input type="checkbox" name="psemestre[]" id="sexto" value="6"><label class="control-label">&nbsp;6 Semestre <em>*</em></label></div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-2">&nbsp;</div>
                                        <div class="col-lg-9">
                                            <div class="mostrarMat3">&nbsp;</div>
                                            <div class="mostrarMat4">&nbsp;</div>
                                        </div>
                                    </div>  

                                    <div class="form-group">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-9">
                                            <?php if (substr($periodos[0]['CPEPeriodo'],3,1) == '2'){?>
                                                <div class="col-lg-4"><input type="checkbox" name="psemestre[]" id="5" class="sem5" value="5"><label class="control-label">&nbsp;5 Semestre <em>*</em></label></div>
                                            <?php } else { ?>
                                                <div class="col-lg-4"><input type="checkbox" name="psemestre[]" id="6" class="sem6" value="6"><label class="control-label">&nbsp;6 Semestre <em>*</em></label></div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-9">
                                            <div class="mostrarMat5">&nbsp;</div>
                                            <div class="mostrarMat6">&nbsp;</div>
                                        </div>
                                    </div> 
                                    <div class="loadingMat"></div>
                                    <div class="form-group">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-11">
                                            <input type="hidden" name="idPlanDetalle" id="idPlanDetalle" value="" >
                                            <button class="btn btn-primary save  pull-right" type="button"> <i class="fa fa-save"></i> Guardar</button>
                                        </div>
                                    </div>                                    
                                </form>
                                <div class="form-group">
                                        <div class="col-lg-2"></div>
                                            <div class="col-lg-9">
                                            <div class="loadingSave"></div>
                                            <div id="error"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-2"></div>
                                            <div class="col-lg-10">
                                            <div class="mostrarDatos"></div>
                                        </div>
                                    </div>
                            </div>
							<div class="tab-pane fade form-horizontal" id="ver-plantilla">
								<div class="form-group">
									<div class="loadingPlantilla"></div>
									<div class="plantilla"></div>
								</div>
							</div>
                        </div>
                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Jquery Validate -->
<script type="text/javascript">

	$(document).on('change','input[type="checkbox"]' ,function(e) {
	//$(".semestre").click(function(e){
		var semestre = this.id;
		var divsemestre = semestre;
		if ($(this).prop('checked')==false) {
			semestre = '';
		}
		var idPlanDetalle = document.getElementById('idPlanDetalle').value;
		$.ajax({
			type: "POST",
			url: "<?php echo base_url("generarplantilla/mostrarMaterias_skip"); ?>",
			data: {plantel : document.getElementById('plantelId').value, periodo : document.getElementById('periodo').value, licenciatura: document.getElementById('licenciatura').value, UDClave : document.getElementById('nombramiento').value, semestre : semestre, idPlanDetalle : idPlanDetalle},
			dataType: "html",
			beforeSend: function(){
				//carga spinner
				$(".loadingMat").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
			},
			success: function(data){
				$(".mostrarMat"+divsemestre).empty();
				$(".mostrarMat"+divsemestre).append(data);  
				$(".loadingMat").html("");
			}
		});

	});
	
	tablaPlantillas();
	function tablaPlantillas(){
		$('#plantillas').load('<?php echo base_url("generarplantilla/tablaPlantillas_skip"); ?>',{"plantel":$("#plantelId").val()});
	}

    function tablaBase() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("generarplantilla/mostrarTablas_skip"); ?>",
            data: {plantel : document.getElementById('plantelId').value, UDTipo_Docente : document.getElementById('UDTipo_Base').value},
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data){
                $(".mostrarTabla").empty();
                $(".mostrarTabla").append(data);  
                $(".loading").html("");
            }
        });
    }

    function tablaUsicamm() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("generarplantilla/mostrarTablas_skip"); ?>",
            data: {plantel : document.getElementById('plantelId').value, UDTipo_Docente : document.getElementById('UDTipo_Usicamm').value},
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data){
                $(".mostrarTabla").empty();
                $(".mostrarTabla").append(data);  
                $(".loading").html("");
            } 
        });
    }

    function tablaIdoneo() {
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("generarplantilla/mostrarTablas_skip"); ?>",
            data: {plantel : document.getElementById('plantelId').value, UDTipo_Docente : document.getElementById('UDTipo_Idoneo').value},
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data){
                $(".mostrarTabla").empty();
                $(".mostrarTabla").append(data);  
                $(".loading").html("");
            }
        });
    }

    function tablaExterno() {
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("generarplantilla/mostrarTablas_skip"); ?>",
            data: {plantel : document.getElementById('plantelId').value, UDTipo_Docente : document.getElementById('UDTipo_Externo').value},
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data){
                $(".mostrarTabla").empty();
                $(".mostrarTabla").append(data);  
                $(".loading").html("");
            }
        });
    }

    $(".save").click(function() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("generarplantilla/save"); ?>",
            data: $('#formGuardar').serialize(),
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loadingSave").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data){
                var data = data.split("::");
                
                if(data[1]=='OK') {
                    $("#error").empty();
                    $("#error").append(data[0]);
                    datosPlantilla(data[2],data[3]);
                    uncheckAll();
                    $(".mostrarMat1").html("");
                    $(".mostrarMat2").html("");
                    $(".mostrarMat3").html("");
                    $(".mostrarMat4").html("");
                    $(".mostrarMat5").html("");
                    $(".mostrarMat6").html("");
                    $(".loadingSave").html("");
                } else {
                    $("#error").empty();
                    $("#error").append(data);   
                    $(".loadingSave").html(""); 
                    //datosPlantilla(data[2]);
                }             
            }
        });
    });//----->fin
    
    function limpiarFormulario() {
        //$("#nombramiento").empty();
        //$("#licenciatura").empty();
        $("#nombramiento").val('');
        $("#licenciatura").val('');
        uncheckAll();
        $(".mostrarMat1").html("");
        $(".mostrarMat2").html("");
        $(".mostrarMat3").html("");
        $(".mostrarMat4").html("");
        $(".mostrarMat5").html("");
        $(".mostrarMat6").html("");
        $(".mostrarDatos").html("");
    }

    function uncheckAll() {
		$("#formGuardar input[type=checkbox]").each(function(){
			$(this).attr('checked',false);
		});
    }

    function datosPlantilla(idPUsuario, UDTipo_Docente){
		$.ajax({
			type: "POST",
			url: "<?php echo base_url("generarplantilla/datosPlantilla_skip"); ?>",
			data: {idPUsuario : idPUsuario, idPlantel : document.getElementById("plantelId").value, periodo : document.getElementById('periodo').value, UDTipo_Docente : UDTipo_Docente}, 
			dataType: "html",
			beforeSend: function(){
				//carga spinner
				$(".loadingSave").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
			},
			success: function(data){
				$(".mostrarDatos").empty();
				$(".mostrarDatos").append(data);  
				$(".loadingSave").html("");
			}
		});
	}

    function verPlantilla(idPlantilla) {
        $.ajax({
			type: "POST",
			url: "<?php echo base_url("generarplantilla/verplantilla"); ?>",
			data: {idPlantilla : idPlantilla}, 
			dataType: "html",
			success: function(data){
				$(".plantilla").empty();
				$(".plantilla").append(data); 
				$('.nav-tabs a[href="#ver-plantilla"]').tab('show');
			}
		});
    }
</script>