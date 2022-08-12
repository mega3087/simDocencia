<br><h2 class="text-center">
    <?php echo "FORMATO DE NÚMERO DE GRUPOS"; ?>
</h2>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover dataTables-example dataTable" >
        <thead>
            <tr>
                <th class="text-center" rowspan="2">SEMESTRE</th>
                <th class="text-center" rowspan="2">No. DE GRUPOS</th>
                <th class="text-center" colspan="2">TURNO</th>
                <th class="text-center" rowspan="2">CAPACITACIÓN</th>
                <th class="text-center" rowspan="2">No. DE ALUMNOS POR GRUPO</th>
                <!--<th class="text-center" rowspan="2">TOTAL</th>-->
            </tr>   
            <tr>
                <th class="text-center">MATUTINO</th>
                <th class="text-center">VESPERTINO</th>
                
            </tr>
        </thead>
        <tbody>
            <?php foreach($total as $key => $list){ ?>
                <tr>
                    <td class="text-center" rowspan="<?= $list['noGrupos'] + 1 ?>"><b><?php echo $list['GRSemestre']; ?>° SEMESTRE</b></td> 
                </tr>
                    <?php foreach ($list['grupos'] as $keys => $listG) { ?>
                        <tr>
                            <td class="text-center"><?php echo $listG['GRGrupo']; ?></td>
                            <?php if ($listG['GRTurno'] == '1') { ?>
                                <td class="text-center">1</td><td></td>
                            <?php } else { ?>
                                <td></td><td class="text-center">1</td>
                            <?php } 
                            if ($listG['CCANombre'] != '') {
                            ?>
                            <td class="text-left">
                                <?php 
                                echo $listG['CCANombre'];
                                ?>
                            </td>
                            <?php } else { ?>
                                <td class="text-center"></td>
                            <?php } ?>
                            <?php if ($listG['GRCupo'] != '') { ?>
                                <td class="text-center"><?php echo $listG['GRCupo']; ?></td>
                            <?php } else { ?>
                                <td class="text-center">0</td>
                            <?php } ?>
                        </tr>                                
                    <?php } ?>
                        <!--<tr>
                            <td class="text-center" rowspan="<?= $list['noGrupos'] +1 ?>"><b><?= $list['noGrupos']; ?></b></td> 
                        </tr>-->
            <?php } ?>
        </tbody>
    </table>
</div>
<div class="modal-footer">
    <a href="" target="_blank" id="ImprimirGrupos" type="button" class="btn btn-success btn-sm"><i class="fa fa-print"></i> Imprimir</a>
</div>
<script>
$(document).ready(function() {
    var periodo = $(".semReportes option:selected").val();
    var PlantelId = document.getElementById("PlantelRep").value;

    var Plantel = window.btoa(unescape(encodeURIComponent(PlantelId))).replace("=","").replace("=",""); 
    var search = window.btoa(unescape(encodeURIComponent(periodo))).replace("=","").replace("=",""); 
    $("#ImprimirGrupos").attr("href","<?php echo base_url("grupos/ImprimirGrupos_skip"); ?>/"+Plantel+"/"+search);
});//----->fin
</script>