<br><h2 class="text-center">
    <?php echo "FORMATO DE NÚMERO DE GRUPOS"; ?>
</h2>
<?php echo form_open('grupos/saveCap', array('name' => 'FormCap', 'id' => 'FormCap', 'role' => 'form', 'class' => 'form-horizontal panel-body')); ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover dataTables-example dataTable" >
        <thead>
            <tr>
                <th class="text-center" rowspan="2">SEMESTRE</th>
                <th class="text-center" rowspan="2">No. DE GRUPOS</th>
                <th class="text-center" colspan="2">TURNO</th>
                <th class="text-center" rowspan="2" width="380px">CAPACITACIÓN</th>
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
                            <?php } if ($list['GRSemestre'] == '1' || $list['GRSemestre'] == '2' ) { ?>
                            <td class="text-left">
                                <input type="hidden" name="<?= $listG['GRClave']; ?>[]" value="" /> 
                            </td>
                            <?php } else { ?>
                                <td class="text-left">

                                <select name="<?= $listG['GRClave']; ?>[]" id="GRCClave" class="form-control">
                                <option value="">- Seleccionar Capacitación -</option>
                                <?php foreach ($capacitaciones as $c => $cap) { ?>
                                    <option <?php if( $cap['CCAClave'] == nvl($listG['GRCClave'])) echo"selected"; ?> value="<?=$cap['CCAClave'];?>"><?= $cap['CCANombre']; ?></option>
                                <?php } ?>
                            </select>
                                </td>
                            <?php } ?>
                            <td class="text-center"><input type="number" min="0" max="99" value="<?php echo nvl($listG['GRCupo']); ?>" name="<?= $listG['GRClave']; ?>[]" id="GRCupo" class="form-group <?php if (nvl($listG['GRCupo'])) echo "disabled";?>" required></td>
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
    <?php if( is_permitido(null,'grupos','saveCapAlumnos') ){ ?>
        <button type="button" class="btn btn-primary pull-right saveCap"> <i class="fa fa-save"></i> Guardar</button>
    <?php } ?>
</div>
<?php form_close(); ?>
<script type="text/javascript">
$(document).ready(function() {
    $(".saveCap").click(function() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("grupos/saveCapAlumnos"); ?>",
            data: $(this.form).serialize(),
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loadingCap").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data){
                var data = data.split(";");
                if(data[0]==' OK'){
                    $(".msgCap").empty();
                    $(".msgCap").append(data[1]);
                    $('#FormCap')[0].reset();
                    $(".loadingCap").html("");
                } else {
                    $("#errorCap").empty();
                    $("#errorCap").append(data);   
                    $(".loadingCap").html(""); 
                }
                
            }
        });
    });
});//----->fin
</script>