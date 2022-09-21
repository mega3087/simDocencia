<link href="<?php echo base_url('assets/inspinia/css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">
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
                    <li class="nav-border nav-border-top-danger">
                        <a href="#agregar-materias" data-toggle="tab">
                            <i class="fa fa-pencil fg-danger"></i>
                            <div>
                                <span class="text-strong">Asignar Materias</span>
                            </div>
                        </a>
                    </li>
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
                                        <button class="btn btn-outline btn-primary" id="UDTipo_Usycamm" onclick='tablaUsycamm()' value="3" type="button"> <i class="fa fa-users"></i> Docentes USICAMM</button>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <button class="btn btn-outline btn-primary" id="UDTipo_Externo" onclick='tablaExterno()' value="4" type="button"> <i class="fa fa-users"></i> Docentes EXTERNOS</button>
                                        </li>
                                    </ol>
                                    <br><br>
                                    <input type="hidden" name="cicloEsc" id="cicloEsc" value="<?= substr($periodos[0]['CPEPeriodo'],3,1); ?>"> 
                                    <div class="table-responsive mostrarTabla"></div>
                                    <div class="loading"></div>
                            </div>
                                <div class="tab-pane fade form-horizontal" id="agregar-materias">
                                    <form name='Formsave' id='Formsave' action="<?=base_url("GenerarPlantilla/save")?>" method="POST" class='form-horizontal'>
                                    <input type="hidden" name="idPPlantel" id="plantelId" value="<?= $plantel; ?>"> 
                                    <div class="form-group">    
                                        <div class="loadingasignar"></div>    
                                        <div class="mostrarAsignarMaterias"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label" for="">Periodo Escolar: <em>*</em></label>
                                        <div class="col-lg-9">
                                            <select name="pperiodo" id="periodo" class="form-control periodo disabled">
                                                <?php foreach ($periodos as $key => $listPer) { ?>
                                                    <option value="<?php echo $listPer['CPEPeriodo']; ?>">
                                                            <?=substr($listPer['CPEPeriodo'],0,2)?>-<?=substr($listPer['CPEPeriodo'],3,1)==1?'A (Febrero-Julio)':'B (Agosto-Enero)'?>
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
                                        <div class="col-lg-1"></div>
                                        <div class="col-lg-10">
                                            <input type="hidden" name="idPUsuario" id="idUsuario" value="">   
                                            <button class="btn btn-primary save  pull-right" type="button"> <i class="fa fa-save"></i> Guardar</button>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-1"></div>
                                            <div class="col-lg-10">
                                            <div class="loadingSave"></div>
                                            <div id="error"></div>
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


<script>
$(document).on('change','input[type="checkbox"]' ,function(e) {
    var plantel = document.getElementById('plantelId').value;
    var periodo = document.getElementById('periodo').value;
    var licenciatura = document.getElementById('licenciatura').value;

    if(this.id=="primero") {
        //var semestre = $('input:checkbox[name=psemestre[]]:checked').val();
        if (document.getElementById('primero').checked) {
            var semestre = 1;
        } else {
            var semestre = '';
        }
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("GenerarPlantilla/mostrarMaterias"); ?>",
            data: {plantel : plantel, periodo : periodo, licenciatura: licenciatura, semestre : semestre},
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
            url: "<?php echo base_url("GenerarPlantilla/mostrarMaterias"); ?>",
            data: {plantel : plantel, periodo : periodo, licenciatura: licenciatura, semestre : semestre},
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
            url: "<?php echo base_url("GenerarPlantilla/mostrarMaterias"); ?>",
            data: {plantel : plantel, periodo : periodo, licenciatura: licenciatura, semestre : semestre},
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
            url: "<?php echo base_url("GenerarPlantilla/mostrarMaterias"); ?>",
            data: {plantel : plantel, periodo : periodo, licenciatura: licenciatura, semestre : semestre},
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
            url: "<?php echo base_url("GenerarPlantilla/mostrarMaterias"); ?>",
            data: {plantel : plantel, periodo : periodo, licenciatura: licenciatura, semestre : semestre},
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
            url: "<?php echo base_url("GenerarPlantilla/mostrarMaterias"); ?>",
            data: {plantel : plantel, periodo : periodo, licenciatura: licenciatura, semestre : semestre},
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
            url: "<?php echo base_url("GenerarPlantilla/mostrarTablas"); ?>",
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

    function tablaUsycamm(){
        var plantel = document.getElementById('plantelId').value;
        var UDTipo_Docente = document.getElementById('UDTipo_Usycamm').value;
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("GenerarPlantilla/mostrarTablas"); ?>",
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
            url: "<?php echo base_url("GenerarPlantilla/mostrarTablas"); ?>",
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
            url: "<?php echo base_url("GenerarPlantilla/mostrarTablas"); ?>",
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
            data: $(this.form).serialize(),
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loadingSave").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data){
                var data = data.split("::");
                if(data[1]=='OK') {
                    $(".mostrarDatos").empty();
                    $(".mostrarDatos").append(data[0]);
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
                }             
            }
        });
    });//----->fin

    function uncheckAll() {
        document.querySelectorAll('#Formsave input[type=checkbox]').forEach(function(checkElement) {
            checkElement.checked = false;
        });
    }

    function datosPlantilla(idPUsuario){
        
		$.ajax({
			type: "POST",
			url: "<?php echo base_url("GenerarPlantilla/datosPlantilla"); ?>",
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
			url: "<?php echo base_url("GenerarPlantilla/ver_plantilla"); ?>",
			data: {idPlantel : idPlantel}, 
			dataType: "html",
			beforeSend: function(){
				//carga spinner
				$(".loadingPlantilla").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
			},
			success: function(data){
				$(".plantilla").empty();
				$(".plantilla").append(data);  
				$(".loadingPlantilla").html("");
			}
		});
    }

</script>