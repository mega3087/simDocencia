<div class="form-group">
    <label class="col-lg-2 control-label" for="">Tipo de Nombramiento: <em>*</em></label>
    <div class="col-lg-9">
        <select name="nombramiento" id="nombramiento" class="form-control">
            <option selected value="">Todos</option>
                <?php foreach($nombramientos as $nom => $listNom) { ?>
                <option value="<?= $listNom['TPClave']; ?>"><?=$listNom['TPNombre']?></option>
            <?php  } ?>
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-lg-2 control-label" for="">Estudios: <em>*</em></label>
    <div class="col-lg-9">
        <select name="licenciatura" id="licenciatura" class="form-control">
            <option selected value="">Todos</option>
                <?php foreach($estudios as $est => $listEst) { ?>
                <option value="<?= $listEst['IdLicenciatura']; ?>"><?php echo $listEst['LGradoEstudio'].' en '.$listEst['Licenciatura']; ?></option>
            <?php  } ?>
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-lg-2 control-label" for="">Periodo Escolar: <em>*</em></label>
    <div class="col-lg-9">
        <select name="periodo" id="periodo" class="form-control periodo disabled">
            <?php foreach ($periodos as $key => $listPer) { ?>
                <option value="<?php echo $listPer['CPEPeriodo']; ?>">
                        <?=substr($listPer['CPEPeriodo'],0,2)?>-<?=substr($listPer['CPEPeriodo'],3,1)==1?'A (Febrero-Julio)':'B (Agosto-Enero)'?>
                </option>
            <?php } ?>
        </select>
    </div>
</div>

<div class="form-group">
    <div class="col-lg-2"></div>
    <div class="col-lg-9">
        <?php if (substr($periodos[0]['CPEPeriodo'],3,1) == '2'){?>
            <div class="col-lg-4"><input type="radio" name="semestre" id="semestre" value="1"><label class="control-label">&nbsp;1 Semestre <em>*</em></label></div>
            <div class="col-lg-4"><input type="radio" name="semestre" id="semestre" value="3"><label class="control-label">&nbsp;3 Semestre <em>*</em></label></div>
            <div class="col-lg-4"><input type="radio" name="semestre" id="semestre" value="5"><label class="control-label">&nbsp;5 Semestre <em>*</em></label></div>
        <?php } else { ?>
            <div class="col-lg-4"><input type="radio" name="semestre" id="semestre" value="2"><label class="control-label">&nbsp;2 Semestre <em>*</em></label></div>
            <div class="col-lg-4"><input type="radio" name="semestre" id="semestre" value="4"><label class="control-label">&nbsp;4 Semestre <em>*</em></label></div>
            <div class="col-lg-4"><input type="radio" name="semestre" id="semestre" value="6"><label class="control-label">&nbsp;6 Semestre <em>*</em></label></div>
        <?php } ?>
    </div>
</div>

<div class="form-group">
    <div class="col-lg-2"></div>
    <div class="col-lg-9">
        <div class="mostrarMaterias"></div>
        <div class="loadingMat"></div>
    </div>
</div>

<script>
$(document).ready(function () {                            
    $("input[name=semestre]:radio").click(function() {
        var plantel = document.getElementById('plantelId').value;
        var periodo = document.getElementById('periodo').value;
        var licenciatura = document.getElementById('licenciatura').value;
        var semestre = $("[name=semestre]:checked").val();
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("GenerarPlantilla/mostrarMaterias"); ?>",
            data: {plantel : plantel, periodo : periodo, licenciatura: licenciatura, semestre : semestre},
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loadingMat").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data){
                $(".mostrarMaterias").empty();
                $(".mostrarMaterias").append(data);  
                $(".loadingMat").html("");
            }
        });
    });     
});
</script>