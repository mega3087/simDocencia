<br>
<h2>REPORTE DE MATRICULA Y No. DE GRUPOS</h2>
<h3>SEMESTRE 20<?=substr($semestre,0,2)?>-<?=substr($semestre,3,1)==1?'A':'B'?></h3>
<br>
<?php
$noCap = count($Capacitaciones);
?>
<div class="table responsive">
	<table class="table table-striped table-bordered table-hover dataTable dataTables-example">
        <tr>
            <th rowspan ="2" style="text-align:center;">SEMESTRE</th>
            <th colspan ="2" style="text-align:center;">No DE GRUPOS</th>
            <th colspan ="<?= $noCap ?>" style="text-align:center;">No DE GRUPOS POR NÚCLEO DE FORMACIÓN</th>
            <th rowspan ="2"  style="text-align:center;">TOTAL DE GRUPOS</th>
        </tr>
        <tr>
            <th style="text-align:center;">MATUTINO</th>
            <th style="text-align:center;">VESPERTINO</th>
            <?php foreach ($Capacitaciones as $key => $cap) {
                echo "<th style='text-align:center;'>".$cap['CCAAbrev']."</th>";
            }
            ?>
        </tr>
        <?php
        $totalMat = 0; $totalVes = 0; $totalGrupos = 0; $totalCap = array();
        foreach ($datos as $k => $list) {   $totalGrupos += $list['noGrupos']; ?>
            <tr>
                <th style="text-align:center;"><?= $list['GRSemestre'] ?>°</th>
                <?php foreach ($list['turnos'] as $ke => $listG) { 
                    if ($listG['GRTurno'] == 1) {
                        $totalMat += $listG['TotalTurno'];
                    } else {
                        $totalVes += $listG['TotalTurno'];
                    }
                    ?>
                    <td style="text-align:center;"><?= $listG['TotalTurno'] ?></td>
                <?php } 
                    foreach ($list['Capacitaciones'] as $y => $listCap) {
                        if ($list['GRSemestre'] > 2) {
                        echo "<td style='text-align:center;'>";
                            if (count($listCap['totalCap']) != 0) {
                                foreach ($listCap['totalCap'] as $x => $cap) {
                                        echo $cap['totCap'];
                                        @$totalCap[$y] += $cap['totCap'];
                                }
                            } else {
                                $cero = 0;
                                echo $cero;
                            }
                        echo "</td>";
                        } else {
                            echo "<td></td>";
                        } 
                    }?>
                    <td colspan="2"><?= $list['noGrupos'] ?></td>
            </tr>
        <?php } ?>
        <tr>
            <th style="text-align:right;">TOTAL</th>
            <th style="text-align:center;"><?= $totalMat ?></th>
            <th style="text-align:center;"><?= $totalVes ?></th>
            <?php 
                for ($i=0; $i < $noCap; $i++) { 
                    if (nvl($totalCap[$i]) == '') {
                        $total = '0';
                    } else {
                        $total = $totalCap[$i];
                    }
                    echo "<th style='text-align:center;'>".$total."</th>";
                }            
            ?>
            <th style="text-align:center;"><?= $totalGrupos ?></th>
        </tr>
    </table>	
</div>
<div class="modal-footer">
    <a href="" target="_blank" id="ImprimirRep" type="button" class="btn btn-success btn-sm"><i class="fa fa-print"></i> Imprimir</a>
</div>

<script>
$(document).ready(function() {
    var periodo = $(".semReportes option:selected").val();
    var PlantelId = document.getElementById("PlantelRep").value;

    var Plantel = window.btoa(unescape(encodeURIComponent(PlantelId))).replace("=","").replace("=",""); 
    var search = window.btoa(unescape(encodeURIComponent(periodo))).replace("=","").replace("=",""); 
    $("#ImprimirRep").attr("href","<?php echo base_url("HorasClase/imprimirReporte"); ?>/"+Plantel+"/"+search);
});//----->fin
</script>