<link href="<?php echo base_url('assets/inspinia/css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Grupos</h2>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-tab panel-tab-double shadow">
            <!-- Start tabs heading -->
            <div class="panel-heading no-padding">
                <ul class="nav nav-tabs">
                    <li class="active nav-border nav-border-top-danger">
                        <a href="#asignarAlumnos" data-toggle="tab">
                            <i class="fa fa-users fg-danger"></i>
                            <div>
                                <span class="text-strong">Asignar Alumnos</span>                                
                            </div>
                        </a>
                    </li>
                    <li class="nav-border nav-border-top-danger">
                        <a href="#ver_reportes" data-toggle="tab">
                            <i class="fa fa-pencil fg-danger"></i>
                            <div>
                                <span class="text-strong">Ver Reportes</span>
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
                            <div class="tab-pane fade in active" id="asignarAlumnos">
                                <input type="hidden" name="plantelId" id="plantelId" value="<?= $idPlantel; ?>">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="">Periodo Escolar: <em>*</em></label>
                                    <div class="col-lg-6">
                                        <select name="SemestrePeriodo" id="SemestrePeriodo" class="form-control SemestrePeriodo">
                                            
                                            <?php foreach ($periodos as $key => $listPer) { ?>
                                                <option value="<?php echo $listPer['CPEPeriodo']; ?>">
                                                        <?=substr($listPer['CPEPeriodo'],0,2)?>-<?=substr($listPer['CPEPeriodo'],3,1)==1?'A (Febrero-Julio)':'B (Agosto-Enero)'?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="loadingGrup"></div>
                                    <div class="msgGrup"></div>
                                    <div class="resultGrup"></div>                        
                                </div>
                            </div>

                            <div class="tab-pane fade form-horizontal" id="ver_reportes">
                            <input type="hidden" name="PlantelRep" id="PlantelRep" value="<?= $idPlantel; ?>">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="">Periodo Escolar: <em>*</em></label>
                                    <div class="col-lg-6">
                                        <select name="semReportes" id="semReportes" class="form-control semReportes disabled">
                                            <?php foreach ($periodos as $key => $listPer) { ?>
                                                <option value="<?php echo $listPer['CPEPeriodo']; ?>">
                                                    <?=substr($listPer['CPEPeriodo'],0,2)?>-<?=substr($listPer['CPEPeriodo'],3,1)==1?'A (Febrero-Julio)':'B (Agosto-Enero)'?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <br><br><br>
                                <div class="col-lg-2"></div>               
                                <div class="form-group col-lg-10">
                                    <div class="col-lg-4 center" >
                                        <button class="btn btn-info btn-sm grupoAlumno"><i class="fa fa-eye"></i> Ver Grupos-Alumnos</button>
                                    </div>
                                    <div class="col-lg-4">
                                        <button class="btn btn-info btn-sm verHorarios"><i class="fa fa-eye"></i> Ver Horarios</button>
                                    </div>
                                    <div class="col-lg-4">
                                        <button class="btn btn-info btn-sm verReporte"><i class="fa fa-eye"></i> Ver Reporte</button>
                                    </div>
                                </div>
                                <div class="col-lg-1"></div>  
                                <div class="form-group col-lg-10">
                                    <div class="loadingReportes"></div>
                                    <div class="msgReportes"></div>
                                    <div class="resultReportes"></div>
                                </div>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    var valor = $(".SemestrePeriodo option:selected").val();
    abrirReporte();
});

function abrirReporte() {
    var valor = $(".SemestrePeriodo option:selected").val();
    var plantelId = document.getElementById("plantelId").value;

    $.ajax({
        type: "POST",
        url: "<?php echo base_url("grupos/listaGrupos_skip"); ?>",
        data: {idPlantel: plantelId, periodo: valor},
        dataType: "html",
        beforeSend: function(){
            //carga spinner
            $(".loadingGrup").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
        },
        success: function(data){
            $(".msgGrup").empty();
            $(".resultGrup").empty();
            $(".resultGrup").append(data);
            $(".loadingGrup").empty();
        }
    });
}

$(document).on("click", ".grupoAlumno", function () {
        var periodo = $(".semReportes option:selected").val();
        var PlantelId = document.getElementById("plantelId").value;
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("grupos/listaGruposRep_skip"); ?>",
            data: {idPlantel: PlantelId, periodo: periodo},
            dataType: "html",
            success: function(data){
                $(".msgReportes").empty();
                $(".resultReportes").empty();
                $(".resultReportes").append(data);
                $(".loadingReportes").empty();
            }
        });
    });

    $(document).on("click", ".verHorarios", function () {
        var periodo = $(".semReportes option:selected").val();
        var PlantelId = document.getElementById("plantelId").value;
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("HorasClase/listaHoras_skip"); ?>",
            data: {idPlantel: PlantelId, periodo: periodo},
            dataType: "html",
            success: function(data){
                $(".msgReportes").empty();
                $(".resultReportes").empty();
                $(".resultReportes").append(data);
                $(".loadingReportes").empty();
            }
        });
    });

    $(document).on("click", ".verReporte", function () {
        var periodo = $(".semReportes option:selected").val();
        var PlantelId = document.getElementById("plantelId").value;
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("HorasClase/verReporte_skip"); ?>",
            data: {idPlantel: PlantelId, periodo: periodo},
            dataType: "html",
            success: function(data){
                $(".msgReportes").empty();
                $(".resultReportes").empty();
                $(".resultReportes").append(data);
                $(".loadingReportes").empty();
            }
        });
    });
</script>