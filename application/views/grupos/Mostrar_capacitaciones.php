<?php 
if ($valorGrupo == "3" || $valorGrupo == "4" || $valorGrupo == "5" || $valorGrupo == "6") { ?>
        <label class="col-lg-3 control-label" for="">Capacitación: <em>*</em></label>
        <?php foreach ($capacitaciones as $key => $listCap) { ?>
            <div class='col-lg-12 form-group'>
                <input type="radio" name="claves" id="CCAClave" value="<?= $listCap['CCAClave'] ?>" required> <?= $listCap['CCANombre'] ?>
            </div>
        <?php } 
    } else { ?>
            <input type="hidden" id="CCAClave" name="claves" value="" class="form-group">
<?php }  ?>