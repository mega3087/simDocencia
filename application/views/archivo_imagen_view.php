<?php header('Content-Type: text/html; charset=UTF-8'); // http://www.gestiweb.com/?q=content/problemas-html-acentos-y-e%C3%B1es-charset-utf-8-iso-8859-1       ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo NOMBRE_SISTEMA; ?></title>
		
        <link href="<?php echo base_url('assets/inspinia/css/bootstrap.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/inspinia/font-awesome/css/font-awesome.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/inspinia/css/animate.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/inspinia/css/style.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/style.css'); ?>" rel="stylesheet">
		
        <!-- Mainly scripts -->
        <script src="<?php echo base_url('assets/inspinia/js/jquery-2.1.1.js'); ?>"></script>
        <script src="<?php echo base_url('assets/inspinia/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/inspinia/js/plugins/metisMenu/jquery.metisMenu.js'); ?>"></script>
        <script src="<?php echo base_url('assets/inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>
		
        <!-- Custom and plugin javascript -->
        <script src="<?php echo base_url('assets/inspinia/js/inspinia.js'); ?>"></script>
        <script src="<?php echo base_url('assets/inspinia/js/plugins/pace/pace.min.js'); ?>"></script>
	</head>
    <body>
        <div id="wrapper">
            <div id="page-wrapper" class="gray-bg">
				<div class="row"><br />
					<div class="col-lg-12">
						<div class="panel panel-primary">
							
							<div class="panel-heading">
								<h3><?php echo $titulo; ?></h3>
							</div>	
							
							<div class="panel-body">
								<?php
									echo form_open_multipart("archivo_imagen/index/$nombre_campo", 'id="upload" class="upload"');
									
									echo '<label title="Subir imagen" for="userfile" class="btn btn-primary">
									<input type="file" accept="image/*" name="userfile" id="userfile" class="hide">
									Seleccionar imagen
									</label>';
									echo '<label><input class="disabled" disabled id="archivo_nombre" size="38%"></label>'. br('2');
									
									echo "<input type='submit' class='button btn btn-primary' id='submit' value='Subir imagen'>" . nbs(5);
									echo '<span id="loader" style="display:none;">';
									echo img('assets/img/loader.gif') . nbs() . 'Subiendo imagen, espere por favor';
									echo '</span>';
									echo br(2);
									
									muestra_mensaje();
									
									if (isset($datos_archivo['file_name'])) {
										echo '<div><strong>imagen subida:</strong>'.nbs(2);
										echo '<span id="archivo_subido">';
										echo anchor(base_url($datos_archivo['file_name']), "Ver imagen" , 'class="iconiza" TARGET=_blank');
										echo form_hidden('file_name', $datos_archivo['file_name'] );
										echo '</span></div>' . br();
									}
									echo '<em>Sólo se permiten imagenes con formato gif|jpg|jpeg|png|ico <br /> <i class="fa fa-file-pdf-o"></i> con tamaño máximo de 2MB.</em>';
									echo form_close();
								?>		
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>

<script type="text/javascript">
	$(document).ready(function(){
		var file_name = $('input[name=file_name]').val();
		
		if (file_name) {
			parent.$("#ver_archivo_<?php echo $nombre_campo; ?>").attr({href:"<?php echo base_url('/'); ?>".concat(file_name), style:"display:show"});
			parent.$("input[name='<?php echo $nombre_campo; ?>']").val(file_name);
		}
		
		$("input[type=submit]").click(function(){
			if ($("input[type=file]").val() != "") { // Existe un valor en el campo userfile
				$("#loader").show();
			}
		});
	});
	
	
	/*Para mostrar el nombre del archivo a cargar*/
	elExplo=document.getElementById("userfile");
	elExplo_caja=document.getElementById("archivo_nombre");
	elExplo.onchange=function() {
		elExplo.click();
		elExplo_caja.value=elExplo.value;
	}
</script>
<style type="text/css">
#archivo_nombre{
	cursor: default;
    background-color: #FFF;
    border: none;
}	
</style>
