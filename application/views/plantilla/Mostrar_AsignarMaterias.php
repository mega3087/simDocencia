<div class="row">	
    <div class="text-center">
        <h2><b>DOCENTE: <?php echo mb_strtoupper($docentes[0]['UApellido_pat']." ".$docentes[0]['UApellido_mat']." ".$docentes[0]['UNombre']); ?></b></h2>
    </div>
</div>

<div class="form-group">
    <label class="col-lg-2 control-label" for="">Tipos de Nombramiento: <em>*</em></label>
    <div class="col-lg-9">
        <select name="idPUDatos" id="nombramiento" class="form-control">
                <?php foreach($nombramientos as $nom => $listNom) { ?>
                <option value="<?= $listNom['UDClave']; ?>"><?=$listNom['TPNombre']?> (<?=$listNom['HorasTot']?> H/S/M)</option>
            <?php  } ?>
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-lg-2 control-label" for="">Estudios: <em>*</em></label>
    <div class="col-lg-9">
        <select name="pidLicenciatura" id="licenciatura" class="form-control">
                <?php foreach($estudios as $est => $listEst) { ?>
                <option value="<?= $listEst['IdLicenciatura']; ?>"><?php echo $listEst['LGradoEstudio'].' en '.$listEst['Licenciatura']; ?></option>
            <?php  } ?>
        </select>
    </div>
</div>


