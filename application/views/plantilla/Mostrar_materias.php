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
                    <td style="width: 400px;">
                    <input class="id_materia<?= $listM[0]['id_materia']; ?>" type="checkbox" name="pidMateria[]" id="id_materia" value="<?= $listM[0]['id_materia']; ?>" <?php if(nvl($datosPlantilla['pidMateria']) == $listM[0]['id_materia']) { echo "checked";} ?> ><?php echo $listM[0]['id_materia']?> :: <?php echo $listM[0]['materia']; ?></td>
                    <td><input name="multiplo[]" id="multipo<?= $listM[0]['id_materia']; ?>" class="form-control disabled" value="<?= $listM[0]['hsm']; ?>"></td>
                    <td>
                        <input class="numeros" type="text" id="nogrupoMatutino<?= $listM[0]['id_materia']; ?>" min="1" max="5" name="nogrupoMatutino[]" placeholder="0" value="<?= nvl($datosPlantilla['pnogrupoMatutino'])?>" maxlength='2' class="form-control" onkeyup="sumar<?= $listM[0]['id_materia']; ?>();"/> 
                    </td>
                    <td>
                        <input class="numeros" type="number" id="nogrupoVespertino<?= $listM[0]['id_materia']; ?>" min="1" max="5" name="nogrupoVespertino[]" placeholder="0" value="<?= nvl($datosPlantilla['pnogrupoVespertino'])?>" maxlength='2' class="form-control" onkeyup="sumar<?= $listM[0]['id_materia']; ?>();"/>
                    </td>
                    <td class="text-center"><input type="text" id="spTotal<?= $listM[0]['id_materia']; ?>" name="spTotal[]" placeholder="0" value="<?= nvl($datosPlantilla['ptotalHoras'])?>" class="form-control disabled"></td>
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
            <script>
                jQuery(document).ready(function(){
                    // Listen for the input event.
                    jQuery(".numeros").on('input', function (evt) {
                        // Allow only numbers.
                        jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
                    });
                });
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
                    <th rowspan ="2" style="text-align: center; vertical-align:middle ">ASIGNATURAS</th>								
                    <th rowspan ="2" style="text-align: center; vertical-align:middle">HORAS POR <br>ASIG.</th>
                    <th colspan="2" style="text-align: center; vertical-align:middle">NO. DE GRUPOS </th>
                    <th colspan="3" style="text-align: center; vertical-align:middle">H/S/M POR SEM. </th>
                    <th rowspan ="2" style="text-align: center; vertical-align:middle">TOTAL<br> HRS.<br> POR<br> ASIG.</th>
                    <th rowspan ="2" colspan="2" style="text-align: center; vertical-align:middle">
                    <?php if ($datosPlantilla['PEstatus'] == 'Pendiente') { ?>ACCIÓN <?php } 
                    if ($datosPlantilla['PEstatus'] == 'Revisión')  { ?>OBSERVACIONES<?php } ?></th>
                </tr>
                <tr>
                    <th style="text-align: center; vertical-align:middle">MAT.</th>
                    <th style="text-align: center; vertical-align:middle">VESP.</th>
                    <th style="text-align: center; vertical-align:middle"><?php if (substr($periodos,3,1) == '2') { echo '1'; } else { echo '2';} ?></th>
                    <th style="text-align: center; vertical-align:middle"><?php if (substr($periodos,3,1) == '2') { echo '3'; } else { echo '4';} ?></th>
                    <th style="text-align: center; vertical-align:middle"><?php if (substr($periodos,3,1) == '2') { echo '5'; } else { echo '6';} ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($datos as $x => $listDatos) {
                    $contar = count($listDatos['plantilla']) +1;
                    foreach($listDatos['plantilla'] as $y => $listPlan) { 
                    if ($listPlan['idPBitacora'] != '' && $listPlan['pbObservaciones'] != '' && $listPlan['PEstatus'] == 'Revisión') { ?>
                    <tr>
                        <td class="text-center"><?= $listPlan['materia']; ?></td>
                        <td class="text-center"><?= $listPlan['hsm']; ?></td>
                        <td class="text-center"><?= $listPlan['pnogrupoMatutino']; ?></td>
                        <td class="text-center"><?= $listPlan['pnogrupoVespertino']; ?></td>
                        <td class="text-center"><?php $listPlan['psemestre'] ;  if ($listPlan['psemestre'] == '1' || $listPlan['psemestre'] == '2') { echo $listPlan['ptotalHoras']; } ?></td>
                        <td class="text-center"><?php $listPlan['psemestre'] ; if ($listPlan['psemestre'] == '3' || $listPlan['psemestre'] == '4') { echo $listPlan['ptotalHoras']; } ?></td>
                        <td class="text-center"><?php $listPlan['psemestre'] ; if ($listPlan['psemestre'] == '5' || $listPlan['psemestre'] == '6') { echo $listPlan['ptotalHoras']; } ?></td>
                        <td class="text-center"><?= $listPlan['ptotalHoras']; ?></td>
                        <td class="text-center"><?= $listPlan['pbObservaciones']; ?></td>
                        <td class="text-center" colspan="2">
                            <button class="btn btn-danger btn-sm" onclick="js:asignar('<?=$listPlan['idPUsuario']?>','<?= $UDTipo_Nombramientos ?>','<?= $listPlan['idPlanDetalle'] ?>'); cargarDatos('<?= $listPlan['psemestre']?>','<?= $listPlan['idPlanDetalle'] ?>')"><i class="fa fa-pencil"></i> Corregir
                            </button>
                        </td>
                    </tr>
                    <?php } else if ($datosPlantilla['PEstatus'] == 'Pendiente')  { ?>
                    <tr>
                        <td class="text-center"><?= $listPlan['materia']; ?></td>
                        <td class="text-center"><?= $listPlan['hsm']; ?></td>
                        <td class="text-center"><?= $listPlan['pnogrupoMatutino']; ?></td>
                        <td class="text-center"><?= $listPlan['pnogrupoVespertino']; ?></td>
                        <td class="text-center"><?php $listPlan['psemestre'] ;  if ($listPlan['psemestre'] == '1' || $listPlan['psemestre'] == '2') { echo $listPlan['ptotalHoras']; } ?></td>
                        <td class="text-center"><?php $listPlan['psemestre'] ; if ($listPlan['psemestre'] == '3' || $listPlan['psemestre'] == '4') { echo $listPlan['ptotalHoras']; } ?></td>
                        <td class="text-center"><?php $listPlan['psemestre'] ; if ($listPlan['psemestre'] == '5' || $listPlan['psemestre'] == '6') { echo $listPlan['ptotalHoras']; } ?></td>
                        <td class="text-center"><?= $listPlan['ptotalHoras']; ?></td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm" onclick="js:asignar('<?=$listPlan['idPUsuario']?>','<?= $UDTipo_Nombramientos ?>','<?= $listPlan['idPlanDetalle'] ?>'); cargarDatos('<?= $listPlan['psemestre']?>','<?= $listPlan['idPlanDetalle'] ?>')"><i class="fa fa-pencil"></i> Editar
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            <?php } 
            }   ?>
            </tbody>
        </table>
    </div>
</div>

<?php } ?>

<script>
    function cargarDatos(psemestre, idPlanDetalle){
        var semestre = $('.sem'+psemestre);
        document.getElementById("idPlanDetalle").value = idPlanDetalle;
        if (semestre.attr('checked') ) {
            semestre.dblclick();
        } else {
            semestre.click();
        }
    }
</script>