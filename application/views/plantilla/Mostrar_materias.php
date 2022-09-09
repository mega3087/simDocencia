<div class="form-group">
    <div class="col-lg-12">
        <table class="table table-striped table-bordered table-hover dataTables-example" >
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
                    <td style="width: 400px;"><input type="checkbox" name="pidMateria[]" id="id_materia" value="<?= $listM[0]['id_materia']; ?>"> <?php echo $listM[0]['id_materia'].'::'.$listM[0]['modulo'].' '.$listM[0]['materia']; ?></td>
                    <td><input name="multiplo[]" id="multipo<?= $listM[0]['id_materia']; ?>" class="form-control disabled" value="<?= $listM[0]['hsm']; ?>"></td>
                    <td>
                        <input type="number" id="nogrupoMatutino<?= $listM[0]['id_materia']; ?>" name="nogrupoMatutino[]" value="0" min="0" max="10" maxlength='2' class="form-control" onkeyup="sumar<?= $listM[0]['id_materia']; ?>();"/> 
                    </td>
                    <td>
                        <input type="number" id="nogrupoVespertino<?= $listM[0]['id_materia']; ?>" name="nogrupoVespertino[]" value="0" min="0" max="10" maxlength='2' class="form-control" onkeyup="sumar<?= $listM[0]['id_materia']; ?>();"/>
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

