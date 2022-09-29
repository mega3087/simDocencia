<br><h2 class="text-center">
    <?php echo "FORMATO DE NÚMERO DE GRUPOS"; ?>
</h2>
<?php echo form_open('grupos/saveCapAlumnos', array('name' => 'FormCap', 'id' => 'FormCap', 'role' => 'form', 'class' => 'form-horizontal panel-body')); ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover dataTables-example dataTable" >
        <thead>
            <tr>
                <th class="text-center" rowspan="2">SEMESTRE</th>
                <th class="text-center" rowspan="2">No. DE GRUPOS</th>
                <th class="text-center" colspan="2">TURNO</th>
                <th class="text-center" rowspan="2" width="380px">CAPACITACIÓN</th>
                <th class="text-center" rowspan="2">No. DE ALUMNOS POR GRUPO</th>
                <?php if( is_permitido(null,'grupos','delete') ){ ?>
                <th class="text-center" rowspan="2">ACCIÓN</th>
                <?php } ?> 
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
                    <?php foreach ($list['grupos'] as $keys => $listG) { 
                        $idGrupo = $this->encrypt->encode($listG['GRClave']); 
                        $borrar = "<button type='button' value=".$this->encrypt->encode($listG['GRClave'])." class='btn btn-sm btn-danger quitarGrupo' title='Borrar' ><i class='fa fa-trash'></i></button>";
                        ?>
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
                            <td class="text-center"><input type="number" min="0" max="50" value="<?php echo nvl($listG['GRCupo']); ?>" name="<?= $listG['GRClave']; ?>[]" id="GRCupo" class="form-group" required></td>
                            <?php if( is_permitido(null,'grupos','delete') ){ ?> <td class="text-center"><?= $borrar; ?></td> <?php } ?>
                        </tr>                                
                    <?php } ?>
                        <!--<tr>
                            <td class="text-center" rowspan="<?= $list['noGrupos'] +1 ?>"><b><?= $list['noGrupos']; ?></b></td> 
                        </tr>-->
            <?php } ?>
        </tbody>
    </table>
</div>
<div class="form-group">
    <div class='loadingCap'></div>
    <div class='msgCap'></div>
    <div id='errorCap'></div>
</div>

<div class="modal-footer">
    <?php if( is_permitido(null,'grupos','saveCapAlumnos') ){ ?>
        <button type="button" class="btn btn-primary pull-right saveCap"> <i class="fa fa-save"></i> Guardar</button>
    <?php } ?>
</div>
<?php form_close(); ?>

<script src="<?php echo base_url('assets/inspinia/js/plugins/bootbox.all.min.js'); ?>"></script>
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
                var data = data.split("::");
                
                if(data[1]=='OK'){
                    $(".msgCap").empty();
                    $(".msgCap").append(data[0]);
                    $('#FormCap')[0].reset();
                    $(".loadingCap").html("");
                    abrirReporte();
                } else {
                    $("#errorCap").empty();
                    $("#errorCap").append(data);   
                    $(".loadingCap").html(""); 
                }
                
            }
        });
    });

    //Borrar Grupo
	$(".quitarGrupo").click(function(e) {
		var GRClave = $(this).val();
        var idPlantel = document.getElementById("PlantelId").value;
        var periodo = $(".SemestrePeriodo option:selected").val();

		bootbox.confirm({
			message: "<div class='text-center'>¿Realmente desea Borrar el Grupo del Plantel?</div>",
			size: 'small',
			buttons: {
				confirm: {
					label: 'Si',
					className: 'btn-primary'
				},
				cancel: {
					label: 'No',
					className: 'btn-danger'
				}
			},
			callback: function (result) {
				if (result == true) {
					$.ajax({
						type: "POST",
						url: "<?php echo base_url("grupos/delete"); ?>",
						data: {GRClave: GRClave, idPlantel : idPlantel, periodo : periodo},
						dataType: "html",
						beforeSend: function(){
							//carga spinner
							$(".loading").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
						},
						success: function(data){
							$(".msgGrupos").empty();
							$(".resultGrupos").empty();
							$(".resultGrupos").append(data);
							$(".loadingGrupos").empty();
						}
					});
				}
			}
		});
	});
});//----->fin
</script>