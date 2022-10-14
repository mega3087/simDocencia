<?php if($opcion == 'materias') { ?>
<div class="form-group">
    <div class="col-lg-12">
        <table class="table table-striped table-bordered table-hover" >
            <thead>
                <th>Materia</th>
                <th>Horas</th>
                <th>No. Grupos Matutino</th>
                <th>No. Grupos Vespertino</th>
                <th>Total Horas</th>
            </thead>
            <tbody>
            <?php foreach($arrayMaterias as $ar => $listM){ ?>
                <tr>
                    <td style="width: 400px;"><input type="checkbox" name="pidMateria[]" id="id_materia" value="<?= $listM[0]['id_materia']; ?>"> <?php echo $listM[0]['materia']; ?></td>
                    <td><input name="multiplo[]" id="multipo<?= $listM[0]['id_materia']; ?>" class="form-control disabled" value="<?= $listM[0]['hsm']; ?>"></td>
                    <td>
                        <input type="text" id="nogrupoMatutino<?= $listM[0]['id_materia']; ?>" name="nogrupoMatutino[]" placeholder="0" value="" maxlength='2' class="form-control" onkeyup="sumar<?= $listM[0]['id_materia']; ?>();"/> 
                    </td>
                    <td>
                        <input type="text" id="nogrupoVespertino<?= $listM[0]['id_materia']; ?>" name="nogrupoVespertino[]" placeholder="0" value="" maxlength='2' class="form-control" onkeyup="sumar<?= $listM[0]['id_materia']; ?>();"/>
                    </td>
                    <td class="text-center"><input type="text" id="spTotal<?= $listM[0]['id_materia']; ?>" name="spTotal[]" class="form-control disabled"></td>
                </tr>
                <script>
                function sumar<?= $listM[0]['id_materia']; ?>() {
                    var total = 0;
                    var multiplo = document.getElementById("multipo<?= $listM[0]['id_materia']; ?>").value;
                    var matutino = document.getElementById("nogrupoMatutino<?= $listM[0]['id_materia']; ?>").value;
                    var vespertino = document.getElementById("nogrupoVespertino<?= $listM[0]['id_materia']; ?>").value;
                    
                    totalMat = multiplo * matutino;
                    totalVesp = multiplo * vespertino;
                    total = totalMat + totalVesp;
                    
                    document.getElementById('spTotal<?= $listM[0]['id_materia']; ?>').value = total;
                }
            </script>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php } elseif($opcion == 'plantilla') { ?>

<div class="form-group">
    <div class="col-lg-11">
        <table class="table table-striped table-bordered table-hover" >
            <thead>
                <tr>
                    <th rowspan ="2" style="text-align: center;">ASIGNATURAS</th>								
                    <th rowspan ="2" style="text-align: center;">HORAS POR <br>ASIG.</th>
                    <th colspan="2" style="text-align: center;">NO. DE GRUPOS </th>
                    <th colspan="3" style="text-align: center;">H/S/M POR SEM. </th>
                    <th rowspan ="2" style="text-align: center;">TOTAL<br> HRS.<br> POR<br> ASIG.</th>
                </tr>
                <tr>
                    <th style="text-align: center;">MAT.</th>
                    <th style="text-align: center;">VESP.</th>
                    <th style="text-align: center;"><?php if (substr($periodos,3,1) == '2') { echo '1'; } else { echo '2';} ?></th>
                    <th style="text-align: center;"><?php if (substr($periodos,3,1) == '2') { echo '3'; } else { echo '4';} ?></th>
                    <th style="text-align: center;"><?php if (substr($periodos,3,1) == '2') { echo '5'; } else { echo '6';} ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($datos as $x => $listDatos) {
                    $contar = count($listDatos['plantilla']) +1;
                        foreach($listDatos['plantilla'] as $y => $listPlan) { ?>
                <tr>
                    <td class="text-center"><?= $listPlan['materia']; ?></td>
                    <td class="text-center"><?= $listPlan['hsm']; ?></td>
                    <td class="text-center"><?= $listPlan['pnogrupoMatutino']; ?></td>
                    <td class="text-center"><?= $listPlan['pnogrupoVespertino']; ?></td>
                    <td class="text-center"><?php if ($listPlan['psemestre'] == '1' || $listPlan['psemestre'] == '2') { echo $listPlan['ptotalHoras']; } ?></td>
                    <td class="text-center"><?php if ($listPlan['psemestre'] == '3' || $listPlan['psemestre'] == '4') { echo $listPlan['ptotalHoras']; } ?></td>
                    <td class="text-center"><?php if ($listPlan['psemestre'] == '5' || $listPlan['psemestre'] == '6') { echo $listPlan['ptotalHoras']; } ?></td>
                    <td class="text-center"><?= $listPlan['ptotalHoras']; ?></td>
                </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php } ?>
