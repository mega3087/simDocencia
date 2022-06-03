<div class="row">
  <div class="col-lg-6 col-lg-offset-3">
    <div class="ibox float-e-margins">

      <div class="ibox-title">
      <h5>Activar cuenta</h5>
      </div>

      <div class="ibox-content">
        <form method="post" 
                      class="form-horizontal" 
                      id="forma" 
                      name="forma"
                      role="form" 
                      action="<?php echo base_url("usuario/registrar_activacion"); ?>">
        <?php muestra_mensaje(); ?>

        <div class="form-group">
        <label class="col-md-3 control-label"> Código de activación: <em>*</em></label>
        <div class="col-md-9">
        <input type="text" class="form-control" required id="UCodigo_activacion" 
               name="UCodigo_activacion" value ="<?php echo nvl($UCodigo_activacion); ?>" 
               maxlength = "10" />
        </div>
        </div>
                  
        <div class="form-group">
        <div class="col-lg-offset-3 col-lg-9">
        <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> Activar</button>&nbsp;&nbsp;&nbsp;
        <a class="btn btn-default" href="<?php echo base_url(); ?>"><i class="fa fa-times"></i> Cancelar</a>                            
        </div>
        </div>

        <?php
        echo form_hidden('usuario_skip', nvl($usuario_skip));    
        echo form_hidden('correo_skip', nvl($correo_skip));
        echo form_hidden('codigo_skip', nvl($codigo_skip));
        ?>
        </form>
      </div>
    </div>
  </div>
</div>