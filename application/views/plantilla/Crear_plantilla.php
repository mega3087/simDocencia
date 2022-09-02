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
                        <a href="#agregar-materias" data-toggle="tab" onclick="asignar()">
                            <i class="fa fa-pencil fg-danger"></i>
                            <div>
                                <span class="text-strong">Asignar Materias</span>
                            </div>
                        </a>
                    </li>
                    <li class="nav-border nav-border-top-danger">
                        <a href="#ver-plantilla" data-toggle="tab">
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
                                <form name='Formsave' id='Formsave' action="<?=base_url("GenerarPlantilla/save")?>" method="POST" class='form-horizontal'>
                                <input type="hidden" name="plantelId" id="plantelId" value="<?= $plantel; ?>">    
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <button class="btn btn-outline btn-primary" id="UDTipo_Base" onclick='tablaBase()' value="1"  type="button"> <i class="fa fa-users"></i> Docentes BASE</button>
                                        </li>
                                        <li class="breadcrumb-item">
                                        <button class="btn btn-outline btn-primary" id="UDTipo_Idoneo" onclick='tablaIdoneo()' value="2" type="button"> <i class="fa fa-users"></i> Docentes IDONEOS</button>    
                                        </li>
                                        <li class="breadcrumb-item">
                                        <button class="btn btn-outline btn-primary" id="UDTipo_Usycamm" onclick='tablaUsycamm()' value="4" type="button"> <i class="fa fa-users"></i> Docentes USICAMM</button>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <button class="btn btn-outline btn-primary" id="UDTipo_Externo" onclick='tablaExterno()' value="3" type="button"> <i class="fa fa-users"></i> Docentes EXTERNOS</button>
                                        </li>
                                    </ol>
                                    <br><br>
                                    <div class="table-responsive mostrarTabla">
                                        <div class="loading"></div>
                                        
                                    </div>
                            </div>
                                <div class="tab-pane fade form-horizontal" id="agregar-materias">
                                    <div class="form-group">    
                                        <div class="loadingasignar"></div>    
                                        <div class="mostrarAsignarMaterias"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label" for="">No de Grupos Matutino:<em>*</em></label>
                                        <div class="col-lg-2">
                                            <input type="number" id="nogrupoMatutino" name="nogrupoMatutino" maxlength='2' class="form-control"/>
                                        </div>
                                        <label class="col-lg-2 control-label" for="">No de Grupos Vespertino:<em>*</em></label>
                                        <div class="col-lg-2">
                                            <input type="number" id="nogrupoVespertino" name="nogrupoVespertino" maxlength='2' class="form-control"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for=""></label>
                                        <div class="col-lg-7">
                                            <input type="hidden" name="idUsuario" id="idUsuario" value="">   
                                            <button class="btn btn-primary save" type="button"> <i class="fa fa-save"></i> Guardar</button>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="mostrarDatos"></div>
                                        <div class="loadingSave"></div>
                                    </div>
                                </div>

                                <div class="tab-pane fade form-horizontal" id="ver-plantilla">
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

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

    function asignar(){ 
        var idUser = $('input:checkbox[name=idUsuario]:checked').val();
        var plantel = document.getElementById('plantelId').value;

        document.getElementById('idUsuario').value = idUser;

        $.ajax({
            type: "POST",
            url: "<?php echo base_url("GenerarPlantilla/asignarMaterias"); ?>",
            data: {idUser : idUser, plantel : plantel},
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loadingasignar").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data){
                $(".mostrarAsignarMaterias").empty();
                $(".mostrarAsignarMaterias").append(data);  
                $(".loadingasignar").html("");
            }
        });

    }
</script>
<script>
    //$("input[name=semestre]:radio").click(function() {
    $('#semestre').on('click', function() {
        var plantel = document.getElementById('plantelId').value;
        var periodo = document.getElementById('periodo').value;
        var licenciatura = document.getElementById('licenciatura').value;
        var sem = $("[name=semestre]:checked").val();
        
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
                $("#mostrarMaterias").empty();
                $("#mostrarMaterias").append(data);  
                $(".loadingMat").html("");
            }
        });
    });

    $(".save").click(function() {
        var plantelId = document.getElementById('plantelId').value;
        var idUsuario = document.getElementById('idUsuario').value;
        var nombramiento = document.getElementById('nombramiento').value;
        var licenciatura = document.getElementById('licenciatura').value;
        var periodo = document.getElementById('periodo').value;
        var semestre = document.getElementById('semestre').value;
        var id_materia = document.getElementById('id_materia').value;
        var nogrupoMatutino = document.getElementById('nogrupoMatutino').value;
        var nogrupoVespertino = document.getElementById('nogrupoVespertino').value;

		$.ajax({
			type: "POST",
			url: "<?php echo base_url("GenerarPlantilla/save"); ?>",
			data: {idPPlantel : plantelId, idPUsuario : idUsuario, pidnombramiento: nombramiento, pidLicenciatura : licenciatura, pperiodo : periodo, psemestre : semestre, 
                pidMateria : id_materia, nogrupoMatutino : nogrupoMatutino, nogrupoVespertino : nogrupoVespertino},
			dataType: "html",
			beforeSend: function(){
				//carga spinner
				$(".loadingSave").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
			},
			success: function(data){
                var data = data.split("::");
                
                if(data[1]=='OK'){
                    $(".mostrarDatos").empty();
                    $(".mostrarDatos").append(data[0]);
                    datosPlantilla(data[2]);
                    Formsave.nombramiento.value = "";
                    Formsave.licenciatura.value = "";
                    Formsave.UDTipo_materia.value = "";
                    Formsave.semestre.value = "";
                    Formsave.id_materia.value = "";
                    Formsave.nogrupoMatutino.value = "";
                    Formsave.nogrupoVespertino.value = "";
                    $(".loadingSave").html("");
                }
			}
		});
	});//----->fin

    function datosPlantilla(idPlantilla){
		var idPlantilla = idPlantilla;
		var idPlantel = document.getElementById("plantelId").value;
		$.ajax({
			type: "POST",
			url: "<?php echo base_url("GenerarPlantilla/datosPlantilla"); ?>",
			data: {idPlantilla : idPlantilla, idPlantel : idPlantel}, 
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
</script>