
<?php $Horas1_2 = 31; $Horas3_4 = 35;   $Horas5 = 30;   $Horas6 = 34;  $totalPri = 0; $totalTer = 0; $totalQui = 0; $totalSex = 0; $totalGrupos=0; ?>
<table width="100%" class="no-border-left no-border-right no-border-top">
    <tr>
        <th><h2 class="text-left">PLANTEL Y/O CEMSAD: <?= $plantel[0]['CPLNombre']; ?></h2></th>
    </tr><br>
</table>
<h2 class="text-center" style="color: #333;">NÚMERO DE HORAS CLASE ASIGNADAS POR PLANTEL</h2>
<div class="row" >
    <table style="width:100%; font-size: 13px;">
        <tr>
            <th class="text-center" style="background: #B9B9B9;" height="35px">SEMESTRE</th>
            <th colspan="2" class="text-center" style="background: #B9B9B9; " height="35px">No DE HORAS EN MAPA CURRICULAR</th>
            <th class="text-center" style="background: #B9B9B9; " height="35px">NÚMERO DE GRUPOS</th>
            <th colspan="2" class="text-center" style="background: #B9B9B9; " height="35px">TOTAL DE HORAS</th>
        </tr>
        <?php foreach ($periodo as $k => $list) { $totalGrupos += $list['noGrupos']; ?>
            <?php if ($list['GRSemestre'] == 1 || $list['GRSemestre'] == 2) { ?>
            <tr>
                <th height="30px"><?= $list['GRSemestre']; ?> ° SEMESTRE</th>
                <th colspan="2" class="text-center" height="30px"><?= $Horas1_2; ?></th>
                <th class="text-center" height="30px"><?= $list['noGrupos']; ?></th>
                <th colspan="2" class="text-center" height="30px"><?php $totalPri = $Horas1_2 * $list['noGrupos']; echo $totalPri;?></th>
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
                <th colspan="3" class="text-center" height="30px">TOTAL DE GRUPOS: </th>
                <th class="text-center" style="background: #B9B9B9; " height="30px"> <?= $list['noGrupos'] ?> </th>
                <th class="text-center" style="background: #B9B9B9; " height="30px"> TOTAL DEL HORAS: </th>
                <th class="text-center" style="background: #B9B9B9; " height="30px"> <?php $totalTer = $list['noGrupos'] * $Horas3_4; echo $totalTer; ?> </th>
            </tr>
            <?php } elseif ($list['GRSemestre'] == 5 ) { ?>
            <tr>
                <th><?= $list['GRSemestre']; ?> ° SEMESTRE</th>
                <td>
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
                <th colspan="3" class="text-center" height="30px">TOTAL DE GRUPOS: </th>
                <th class="text-center" style="background: #B9B9B9; " height="30px"> <?= $list['noGrupos'] ?> </th>
                <th class="text-center" style="background: #B9B9B9; " height="30px"> TOTAL DEL HORAS: </th>
                <th class="text-center" style="background: #B9B9B9; " height="30px"> <?php $totalQui = $list['noGrupos'] * $Horas5; echo $totalQui; ?> </th>
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
                <th colspan="3" class="text-center" height="30px">TOTAL DE GRUPOS: </th>
                <th class="text-center" style="background: #B9B9B9; " height="30px"> <?= $list['noGrupos'] ?> </th>
                <th class="text-center" style="background: #B9B9B9; " height="30px"> TOTAL DEL HORAS: </th>
                <th class="text-center" style="background: #B9B9B9; " height="30px"> <?php $totalSex = $list['noGrupos'] * $Horas6; echo $totalSex; ?> </th>
            </tr>
            <?php } ?>
        <?php } ?> 
        <tr>
            <th colspan="3" class="text-center" style="background: #B9B9B9; " height="30px">TOTAL</th>
            <th class="text-center" style="background: #B9B9B9; " height="30px"><?= $totalGrupos ?></th>
            <th colspan="2" class="text-center" style="background: #B9B9B9; " height="30px"><?= $totalPri + $totalTer + $totalQui + $totalSex ?></th>
        </tr>       
    </table>
</div>
<style type="text/css">
    table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  color: #333;

}

.no-border { 
    border:none !important; 
     
}
.border-bottom { border-bottom: 1px solid black; border-collapse: collapse;}
.border-top { border-top: 1px solid black; border-collapse: collapse;}

.no-border-left     { border-left: hidden !important; }
.no-border-right    { border-right: hidden !important; }
.no-border-top      { border-top: hidden !important; }
.no-border-bottom   { border-bottom: hidden !important; }

</style>