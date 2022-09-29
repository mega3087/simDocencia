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
                    <li class="active nav-border nav-border-top-danger">
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
                        <a href="#ver-plantilla" data-toggle="tab" onclick="verPlantilla('<?php echo $plantel; ?>')">
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
                            <div class="tab-pane fade in active" id="docentes">
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
                                        <div class="loadingasignar"></div>    
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
                                                <div class="col-lg-4"><input type="checkbox" name="psemestre[]" id="primero" value="1"><label class="control-label">&nbsp;1 Semestre <em>*</em></label></div>
                                            <?php } else { ?>
                                                <div class="col-lg-4"><input type="checkbox" name="psemestre[]" id="segundo" value="2"><label class="control-label">&nbsp;2 Semestre <em>*</em></label></div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-9">
                                            <div class="mostrarMatPrimero" style="display: none;">
                                                <table class="table table-striped table-bordered table-hover" >
                                                    <thead>
                                                        <th>Materia</th>
                                                        <th>Horas</th>
                                                        <th>No. Grupos Matutino</th>
                                                        <th>No. Grupos Vespertino</th>
                                                        <th>Total Horas</th>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="mostrarMatSegundo" style="display: none;">
                                                <table class="table table-striped table-bordered table-hover" >
                                                    <thead>
                                                        <th>Materia</th>
                                                        <th>Horas</th>
                                                        <th>No. Grupos Matutino</th>
                                                        <th>No. Grupos Vespertino</th>
                                                        <th>Total Horas</th>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>                                    

                                    <div class="form-group">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-9">
                                            <?php if (substr($periodos[0]['CPEPeriodo'],3,1) == '2'){?>
                                                <div class="col-lg-4"><input type="checkbox" name="psemestre[]" id="tercero" value="3"><label class="control-label">&nbsp;3 Semestre <em>*</em></label></div>
                                            <?php } else { ?>
                                                <div class="col-lg-4"><input type="checkbox" name="psemestre[]" id="cuarto" value="4"><label class="control-label">&nbsp;4 Semestre <em>*</em></label></div><div class="col-lg-4"><input type="checkbox" name="psemestre[]" id="sexto" value="6"><label class="control-label">&nbsp;6 Semestre <em>*</em></label></div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-9">
                                            <div class="mostrarMatTercero" style="display: none;">
                                                <table class="table table-striped table-bordered table-hover" >
                                                    <thead>
                                                        <th>Materia</th>
                                                        <th>Horas</th>
                                                        <th>No. Grupos Matutino</th>
                                                        <th>No. Grupos Vespertino</th>
                                                        <th>Total Horas</th>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="mostrarMatCuarto" style="display: none;">
                                                <table class="table table-striped table-bordered table-hover" >
                                                    <thead>
                                                        <th>Materia</th>
                                                        <th>Horas</th>
                                                        <th>No. Grupos Matutino</th>
                                                        <th>No. Grupos Vespertino</th>
                                                        <th>Total Horas</th>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="form-group">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-9">
                                            <?php if (substr($periodos[0]['CPEPeriodo'],3,1) == '2'){?>
                                                <div class="col-lg-4"><input type="checkbox" name="psemestre[]" id="quinto" value="5"><label class="control-label">&nbsp;5 Semestre <em>*</em></label></div>
                                            <?php } else { ?>
                                                <div class="col-lg-4"><input type="checkbox" name="psemestre[]" id="sexto" value="6"><label class="control-label">&nbsp;6 Semestre <em>*</em></label></div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-9">
                                            <div class="mostrarMatQuinto" style="display: none;">
                                                <table class="table table-striped table-bordered table-hover" >
                                                    <thead>
                                                        <th>Materia</th>
                                                        <th>Horas</th>
                                                        <th>No. Grupos Matutino</th>
                                                        <th>No. Grupos Vespertino</th>
                                                        <th>Total Horas</th>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="mostrarMatSexto" style="display: none;">
                                                <table class="table table-striped table-bordered table-hover" >
                                                    <thead>
                                                        <th>Materia</th>
                                                        <th>Horas</th>
                                                        <th>No. Grupos Matutino</th>
                                                        <th>No. Grupos Vespertino</th>
                                                        <th>Total Horas</th>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="loadingMat"></div>
                                    <div class="form-group">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-11">
                                            <button class="btn btn-primary save  pull-right" type="button"> <i class="fa fa-save"></i> Guardar</button>
                                        </div>
                                    </div>

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
                                </form>
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
</div>

<!-- Jquery Validate -->
<script>
$(document).on('change','input[type="checkbox"]' ,function(e) {
    $("[data-toggle]").click(function() {
		var nombre = $(this).attr('nombre');
		
		var i = 0;
		var y = 0;
		var texto = '';
		$('input[name='+nombre+']').each(function(){
			i = 1;
		});
		if(i == 0){
			$(this).parent().append('<input type="hidden" name="'+nombre+'" value="" />');
		}else{
			texto = $('input[name='+nombre+']').val();
		}
		
		$('#'+$(this).attr('aria-describedby')+' .popover-content').html('<textarea id="'+nombre+'" class="form-control textarea" >'+texto+'</textarea>');
		
		$('.textarea').keyup(function(){
			nombre = $(this).attr('id');
			$('input[name='+nombre+']').val( $(this).val() );
		});
	});
    
    if(this.id=="primero") {
        //var semestre = $('input:checkbox[name=psemestre[]]:checked').val();
        if (document.getElementById('primero').checked) {
            var semestre = 1;
        } else {
            var semestre = '';
        }
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("GenerarPlantilla/mostrarMaterias_skip"); ?>",
            data: {plantel : document.getElementById('plantelId').value, periodo : document.getElementById('periodo').value, licenciatura: document.getElementById('licenciatura').value, UDClave : document.getElementById('nombramiento').value, semestre : semestre},
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loadingMat").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data){
                $(".mostrarMatPrimero").empty();
                $(".mostrarMatPrimero").append(data);  
                $(".loadingMat").html("");
            }
        });
    } 

    if(this.id=="segundo") {
        //var semestre = $('input:checkbox[name=segundo]:checked').val();
        if (document.getElementById('segundo').checked) {
            var semestre = 2;
        } else {
            var semestre = '';
        }
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("GenerarPlantilla/mostrarMaterias_skip"); ?>",
            data: {plantel : document.getElementById('plantelId').value, periodo : document.getElementById('periodo').value, licenciatura: document.getElementById('licenciatura').value, UDClave : document.getElementById('nombramiento').value, semestre : semestre},
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loadingMat").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data){
                $(".mostrarMatSegundo").empty();
                $(".mostrarMatSegundo").append(data);  
                $(".loadingMat").html("");
            }
        });
    }

    if(this.id=="tercero") {
        //var semestre = $('input:checkbox[name=tercero]:checked').val();
        if (document.getElementById('tercero').checked) {
            var semestre = 3;
        } else {
            var semestre = '';
        }
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("GenerarPlantilla/mostrarMaterias_skip"); ?>",
            data: {plantel : document.getElementById('plantelId').value, periodo : document.getElementById('periodo').value, licenciatura: document.getElementById('licenciatura').value, UDClave : document.getElementById('nombramiento').value, semestre : semestre},
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loadingMat").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data){
                $(".mostrarMatTercero").empty();
                $(".mostrarMatTercero").append(data);  
                $(".loadingMat").html("");
            }
        });
    }

    if(this.id=="cuarto") {
        //var semestre = $('input:checkbox[name=cuarto]:checked').val();
        if (document.getElementById('cuarto').checked) {
            var semestre = 4;
        } else {
            var semestre = '';
        }
        var semestre = 4;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("GenerarPlantilla/mostrarMaterias_skip"); ?>",
            data: {plantel : document.getElementById('plantelId').value, periodo : document.getElementById('periodo').value, licenciatura: document.getElementById('licenciatura').value, UDClave : document.getElementById('nombramiento').value, semestre : semestre},
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loadingMat").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data){
                $(".mostrarMatCuarto").empty();
                $(".mostrarMatCuarto").append(data);  
                $(".loadingMat").html("");
            }
        });
    } 

    if(this.id=="quinto") {
        //var semestre = $('input:checkbox[name=quinto]:checked').val();
        if (document.getElementById('quinto').checked) {
            var semestre = 5;
        } else {
            var semestre = '';
        }
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("GenerarPlantilla/mostrarMaterias_skip"); ?>",
            data: {plantel : document.getElementById('plantelId').value, periodo : document.getElementById('periodo').value, licenciatura: document.getElementById('licenciatura').value, UDClave : document.getElementById('nombramiento').value, semestre : semestre},
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loadingMat").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data){
                $(".mostrarMatQuinto").empty();
                $(".mostrarMatQuinto").append(data);  
                $(".loadingMat").html("");
            }
        });
    }


    if(this.id=="sexto") {
        //var semestre = $('input:checkbox[name=sexto]:checked').val();
        if (document.getElementById('sexto').checked) {
            var semestre = 6;
        } else {
            var semestre = '';
        }
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("GenerarPlantilla/mostrarMaterias_skip"); ?>",
            data: {plantel : document.getElementById('plantelId').value, periodo : document.getElementById('periodo').value, licenciatura: document.getElementById('licenciatura').value, UDClave : document.getElementById('nombramiento').value, semestre : semestre},
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loadingMat").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data){
                $(".mostrarMatSexto").empty();
                $(".mostrarMatSexto").append(data);  
                $(".loadingMat").html("");
            }
        });
    }
});
</script>

<script type="text/javascript">
    function tablaBase(){
        var plantel = document.getElementById('plantelId').value;
        var UDTipo_Docente = document.getElementById('UDTipo_Base').value;
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("GenerarPlantilla/mostrarTablas_skip"); ?>",
            data: {plantel : plantel, UDTipo_Docente : UDTipo_Docente},
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

    function tablaUsicamm(){
        var plantel = document.getElementById('plantelId').value;
        var UDTipo_Docente = document.getElementById('UDTipo_Usicamm').value;
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("GenerarPlantilla/mostrarTablas_skip"); ?>",
            data: {plantel : plantel, UDTipo_Docente : UDTipo_Docente},
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

    function tablaIdoneo(){
        var plantel = document.getElementById('plantelId').value;
        var UDTipo_Docente = document.getElementById('UDTipo_Idoneo').value;
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("GenerarPlantilla/mostrarTablas_skip"); ?>",
            data: {plantel : plantel, UDTipo_Docente : UDTipo_Docente},
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

    function tablaExterno(){
        var plantel = document.getElementById('plantelId').value;
        var UDTipo_Docente = document.getElementById('UDTipo_Externo').value;
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("GenerarPlantilla/mostrarTablas_skip"); ?>",
            data: {plantel : plantel, UDTipo_Docente : UDTipo_Docente},
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

</script>
<script>
    $(".save").click(function() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("GenerarPlantilla/save"); ?>",
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
                    datosPlantilla(data[2]);
                    uncheckAll();
                    $(".mostrarMatPrimero").html("");
                    $(".mostrarMatSegundo").html("");
                    $(".mostrarMatTercero").html("");
                    $(".mostrarMatCuarto").html("");
                    $(".mostrarMatQuinto").html("");
                    $(".mostrarMatSexto").html("");
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
        uncheckAll();
        $(".mostrarMatPrimero").html("");
        $(".mostrarMatSegundo").html("");
        $(".mostrarMatTercero").html("");
        $(".mostrarMatCuarto").html("");
        $(".mostrarMatQuinto").html("");
        $(".mostrarMatSexto").html("");
    }

    function uncheckAll() {
        document.querySelectorAll('#form input[type=checkbox]').forEach(function(checkElement) {
            checkElement.checked = false;
        });
    }

    function datosPlantilla(idPUsuario){   
        
		$.ajax({
			type: "POST",
			url: "<?php echo base_url("GenerarPlantilla/datosPlantilla_skip"); ?>",
			data: {idPUsuario : idPUsuario, idPlantel : document.getElementById("plantelId").value, periodo : document.getElementById('periodo').value}, 
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

    function verPlantilla(idPlantel) {
        $.ajax({
			type: "POST",
			url: "<?php echo base_url("GenerarPlantilla/verplantilla"); ?>",
			data: {idPlantel : idPlantel}, 
			dataType: "html",
			success: function(data){
				$(".plantilla").empty();
				$(".plantilla").append(data);  
				//$(".loadingPlantilla").html("");
			}
		});
    }

</script>