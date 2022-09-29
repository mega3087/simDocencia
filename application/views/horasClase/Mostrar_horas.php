<?php 
$totalPri = 0; $totalTer = 0; $totalQui = 0; $totalSex = 0; $totalGrupos=0;
if($plantel[0]['CPLTipo'] == '35') {
    $Horas1_2 = 31; $Horas3_4 = 35;   $Horas5 = 30;   $Horas6 = 34;
} else {
    $Horas1_2 = 26; $Horas3_4 = 30;   $Horas5 = 25;   $Horas6 = 29;
}  ?>
<br>
<h2 class="text-center">NÚMERO DE HORAS CLASE ASIGNADAS POR PLANTEL</h2>
<h3 class="text-center">SEMESTRE 20<?=substr($periodos,0,2)?> <?=substr($periodos,3,1)==1?'(Febrero-Agosto)':'(Agosto-Febrero)'?></h3>
<br>
<div class="table responsive">
	<table class="table table-striped table-bordered table-hover dataTable">
        <tr>
            <th class="text-center">SEMESTRE</th>
            <th colspan="2" class="text-center">No DE HORAS EN MAPA CURRICULAR</th>
            <th class="text-center">NÚMERO DE GRUPOS</th>
            <th colspan="2" class="text-center">TOTAL DE HORAS</th>
        </tr>
        <?php foreach ($periodo as $k => $list) { $totalGrupos += $list['noGrupos']; ?>
            <?php if ($list['GRSemestre'] == 1 || $list['GRSemestre'] == 2) { ?>
            <tr>
                <th><?= $list['GRSemestre']; ?> ° SEMESTRE</th>
                <td colspan="2" class="text-center"><?= $Horas1_2; ?></td>
                <td class="text-center"><?= $list['noGrupos']; ?></td>
                <td colspan="2" class="text-center"><?php $totalPri = $Horas1_2 * $list['noGrupos']; echo $totalPri;?></td>
            </tr>
            <?php } elseif ($list['GRSemestre'] == 3  || $list['GRSemestre'] == 4) { ?>
            <tr>
                <th><?= $list['GRSemestre']; ?> ° SEMESTRE</th>
                <td>
                    <table style="width:100%; font-size: 13px;" class="no-border-bottom no-border-top no-border-left no-border-right">
                        <?php foreach ($GRPeriodo as $key => $listCap): ?>
                            <tr><td><?= $listCap['CCANombre']; ?></td></tr>
                        <?php endforeach; ?>                            
                    </table>
                </td>

                <th class="text-center"><?= $Horas3_4; ?></th>

                <td>
                    <table style="width:100%; font-size: 13px;" class="no-border-bottom no-border-top no-border-left no-border-right">
                    <?php for ($a=0; $a < count($list['grupos']); $a++) { ?>
                        <?php for ($y=0; $y < count($list['grupos'][$a]); $y++) { ?>
                        <tr><td class="text-center"><?= $list['grupos'][$a][$y]['noGrup']; ?></td></tr>
                        <?php } ?>    
                    <?php } ?>
                    </table>
                </td>

                <td colspan="2">
                    <table style="width:100%; font-size: 13px;" class="no-border-bottom no-border-top no-border-left no-border-right">
                    <?php for ($b=0; $b < count($list['grupos']); $b++) { ?>
                        <?php for ($z=0; $z < count($list['grupos'][$b]); $z++) { ?>
                        <tr><td class="text-center"><?= $list['grupos'][$b][$z]['noGrup'] * $Horas3_4; ?></td></tr>
                        <?php } ?>    
                    <?php } ?>
                    </table>
                </td>
            </tr>
            <tr>
                <th colspan="3" class="text-center">TOTAL DE GRUPOS: </th>
                <th class="text-center"> <?= $list['noGrupos'] ?> </th>
                <th class="text-center"> TOTAL DEL HORAS: </th>
                <th class="text-center"> <?php $totalTer = $list['noGrupos'] * $Horas3_4; echo $totalTer; ?> </th>
            </tr>
            <?php } elseif ($list['GRSemestre'] == 5 ) { ?>
            <tr>
                <th><?= $list['GRSemestre']; ?> ° SEMESTRE</th>
                <td  class="text-left">
                    <table style="width:100%; font-size: 13px;" class="no-border-bottom no-border-top no-border-left no-border-right">
                        <?php foreach ($GRPeriodo as $key => $listCap): ?>
                            <tr><td><?= $listCap['CCANombre']; ?></td></tr>
                        <?php endforeach; ?>                            
                    </table>
                </td>
                <th class="text-center"><?= $Horas5; ?></th>

                <td>
                    <table style="width:100%; font-size: 13px;" class="no-border-bottom no-border-top no-border-left no-border-right">
                    <?php for ($a=0; $a < count($list['grupos']); $a++) { ?>
                        <?php for ($y=0; $y < count($list['grupos'][$a]); $y++) { ?>
                        <tr><td class="text-center"><?= $list['grupos'][$a][$y]['noGrup']; ?></td></tr>
                        <?php } ?>    
                    <?php } ?>
                    </table>
                </td>

                <td colspan="2">
                    <table style="width:100%; font-size: 13px;" class="no-border-bottom no-border-top no-border-left no-border-right">
                    <?php for ($b=0; $b < count($list['grupos']); $b++) { ?>
                        <?php for ($z=0; $z < count($list['grupos'][$b]); $z++) { ?>
                        <tr><td class="text-center"><?= $list['grupos'][$b][$z]['noGrup'] * $Horas5; ?></td></tr>
                        <?php } ?>    
                    <?php } ?>
                    </table>
                </td>
            </tr>
            <tr>
                <th colspan="3" class="text-center">TOTAL DE GRUPOS: </th>
                <th class="text-center"> <?= $list['noGrupos'] ?> </th>
                <th class="text-center"> TOTAL DEL HORAS: </th>
                <th class="text-center"> <?php $totalQui = $list['noGrupos'] * $Horas5; echo $totalQui; ?> </th>
            </tr>
            <?php } elseif ($list['GRSemestre'] == 6 ) { ?>
            <tr>
                <th><?= $list['GRSemestre']; ?> ° SEMESTRE</th>
                <td>
                    <table style="width:100%; font-size: 13px;" class="no-border-bottom no-border-top no-border-left no-border-right">
                        <?php foreach ($GRPeriodo as $key => $listCap): ?>
                            <tr><td><?= $listCap['CCANombre']; ?></td></tr>
                        <?php endforeach; ?>                            
                    </table>
                </td>
                <th class="text-center"><?= $Horas6; ?></th>

                <td>
                    <table style="width:100%; font-size: 13px;" class="no-border-bottom no-border-top no-border-left no-border-right">
                    <?php for ($a=0; $a < count($list['grupos']); $a++) { ?>
                        <?php for ($y=0; $y < count($list['grupos'][$a]); $y++) { ?>
                        <tr><td class="text-center"><?= $list['grupos'][$a][$y]['noGrup']; ?></td></tr>
                        <?php } ?>    
                    <?php } ?>
                    </table>
                </td>

                <td colspan="2">
                    <table style="width:100%; font-size: 13px;" class="no-border-bottom no-border-top no-border-left no-border-right">
                    <?php for ($b=0; $b < count($list['grupos']); $b++) { ?>
                        <?php for ($z=0; $z < count($list['grupos'][$b]); $z++) { ?>
                        <tr><td class="text-center"><?= $list['grupos'][$b][$z]['noGrup'] * $Horas6; ?></td></tr>
                        <?php } ?>    
                    <?php } ?>
                    </table>
                </td>
            </tr>
            <tr>
                <th colspan="3" class="text-center">TOTAL DE GRUPOS: </th>
                <th class="text-center"> <?= $list['noGrupos'] ?> </th>
                <th class="text-center"> TOTAL DEL HORAS: </th>
                <th class="text-center"> <?php $totalSex = $list['noGrupos'] * $Horas6; echo $totalSex; ?> </th>
            </tr>
            <?php } ?>
        <?php } ?>  
        <tr>
            <th colspan="3" class="text-center">TOTAL</th>
            <th class="text-center"><?= $totalGrupos ?></th>
            <th colspan="2" class="text-center"><?= $totalPri + $totalTer + $totalQui + $totalSex ?></th>
        </tr>
    </table>	
</div>

<div class="modal-footer">
    <a href="" target="_blank" id="ImpromirHoras" type="button" class="btn btn-success btn-sm"><i class="fa fa-print"></i> Imprimir</a>
</div>
<script>
$(document).ready(function() {
    var periodo = $(".semReportes option:selected").val();
    var PlantelId = document.getElementById("PlantelRep").value;

    var Plantel = window.btoa(unescape(encodeURIComponent(PlantelId))).replace("=","").replace("=",""); 
    var search = window.btoa(unescape(encodeURIComponent(periodo))).replace("=","").replace("=",""); 
    $("#ImpromirHoras").attr("href","<?php echo base_url("HorasClase/imprimirHoras_skip"); ?>/"+Plantel+"/"+search);
});//----->fin
</script>