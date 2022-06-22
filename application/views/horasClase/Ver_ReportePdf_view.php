<h2 class="text-center" style="color: #333;">REPORTE DE MATRICULA Y No. DE GRUPOS</h2>
<h2 class="text-center" style="color: #333;">SEMESTRE 20<?=substr($semestre,0,2)?>-<?=substr($semestre,3,1)==1?'A':'B'?></h2>
<br>
<?php
$noCap = count($Capacitaciones);
?>
<div class="row">
    <table style="width:100%">
        <tr>
            <th rowspan ="2" class="text-center">SEMESTRE</th>
            <th colspan ="2" class="text-center" style='background: #B9B9B9;' height="30px">No DE GRUPOS</th>
            <th colspan ="<?= $noCap ?>" class="text-center" style='background: #B9B9B9;' height="30px">No DE GRUPOS POR NÚCLEO DE FORMACIÓN</th>
            <th rowspan ="2" class="text-center" height="30px">TOTAL DE GRUPOS</th><td rowspan ="2" class="no-border-left"></td>
        </tr>
        <tr>
            <th height="30px">MATUTINO</th>
            <th height="30px">VESPERTINO</th>
            <?php foreach ($Capacitaciones as $key => $cap) {
                echo "<th class='text-center'>".$cap['CCANombre']."</th>";
            }
            ?>
        </tr>
        <?php
        $totalMat = 0; $totalVes = 0; $totalGrupos = 0; $totalCap = array();
        foreach ($datos as $k => $list) {   $totalGrupos += $list['noGrupos']; ?>
            <tr>
                <th class="text-center" height="30px"><?= $list['GRSemestre'] ?>°</th>
                <?php foreach ($list['turnos'] as $ke => $listG) { 
                    if ($listG['GRTurno'] == 1) {
                        $totalMat += $listG['TotalTurno'];
                    } else {
                        $totalVes += $listG['TotalTurno'];
                    }
                    ?>
                    <td class="text-center" height="30px"><?= $listG['TotalTurno'] ?></td>
                <?php } 
                    foreach ($list['Capacitaciones'] as $y => $listCap) {
                        if ($list['GRSemestre'] > 2) {
                        echo "<th class='text-center'>";
                            if (count($listCap['totalCap']) != 0) {
                                foreach ($listCap['totalCap'] as $x => $cap) {
                                        echo $cap['totCap'];
                                        @$totalCap[$y] += $cap['totCap'];
                                }
                            } else {
                                $cero = 0;
                                echo $cero;
                            }
                        echo "</th>";
                        } else {
                            echo "<td class='text-center' style='background: #B9B9B9;' height='30px'></td>";
                        } 
                    }?>
                    <td colspan="2" class="text-center" height="30px"><?= $list['noGrupos'] ?></td>
            </tr>
        <?php } ?>
        <tr>
            <th class="text-center" height="30px">TOTAL </th>
            <th class="text-center" height="30px"><?= $totalMat ?></th>
            <th class="text-center" height="30px"><?= $totalVes ?></th>
            <?php 
                for ($i=0; $i < $noCap; $i++) { 
                    if (nvl($totalCap[$i]) == '') {
                        $total = '0';
                    } else {
                        $total = $totalCap[$i];
                    }
                    echo "<th class='text-center' height='30px'>".$total."</th>";
                }            
            ?>
            <th class="text-center border-right " height="30px"><?= $totalGrupos ?></td><td class="no-border-left"></th>
        </tr>
    </table>
    <br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br>

    <table width="100%" class="no-border">
        <tr>
            <td class="text-center no-border" style="line-height: 1.5px; font-size: 13px;">
                <br><br>
                _____________________________________________________ <br />
                <p><?= $Director[0]['CPLDirector']; ?></p>
                <b>NOMBRE Y FIRMA DIRECTOR DE PLANTEL</b>
            </td>
            
            <td class="text-center no-border" style="line-height: 1.5px; font-size: 13px;">
                <br><br>                
                _________________________ <br />
                <p><?= date("d").'-'.ver_mes(date("m")).'-'.date("Y");?></p>
                <b>Fecha</b>
            </td>
            <td class="text-center no-border" style="line-height: 1.5px; font-size: 13px;">
                <br><br>
                ____________________________________________ <br />
                <p>&nbsp;</p>
                <p><b>SELLO DEL PLANTEL</b></p>
                
            </td>
        </tr>
    </table>
</div>
<style type="text/css">
    table, th, td {
  border: 1px solid black;
  border-collapse:collapse !important;
  color: #333;
  font-size: 13px;
}

r {
    text-decoration: underline;
}
.no-border { 
    border:none !important; 
}
.border-top { border-top: 1px solid black !important; }

.border-right { border-right: 1px solid black !important; }

.no-border-left     { border-left: hidden !important; }
.no-border-right    { border-right: hidden !important; }
.no-border-top      { border-top: hidden !important; }
.no-border-bottom   { border-bottom: hidden !important; }

</style>