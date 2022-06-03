<?php header('Content-Type: text/html; charset=UTF-8'); // http://www.gestiweb.com/?q=content/problemas-html-acentos-y-e%C3%B1es-charset-utf-8-iso-8859-1  ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?php echo NOMBRE_SISTEMA; ?></title>
		
		<link rel="icon" type="image/png" href="<?php echo base_url('assets/img/icon.png'); ?>" />
		
		<link href="<?php echo base_url('assets/inspinia/css/bootstrap.min.css');?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/inspinia/font-awesome/css/font-awesome.css');?>" rel="stylesheet">
		
		<link href="<?php echo base_url('assets/inspinia/css/animate.css');?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/inspinia/css/style.css');?>" rel="stylesheet">
		
		<link href="<?php echo base_url('assets/style.css'); ?>" rel="stylesheet">
		<!-- Mainly scripts -->
		<script src="<?php echo base_url('assets/inspinia/js/jquery-2.1.1.js'); ?>"></script>
		<style>
			.control-label em {
			color:red;
			}
		</style>
		
	</head>
	
	<body>
		<?php 
			$this->load->view('usuario/header_view');
			
			$this->load->view($subvista); 
		?>
	
	<!-- Mainly scripts -->
	<script src="<?php echo base_url('assets/inspinia/js/bootstrap.min.js');?>"></script>
	
	<!-- Custom and plugin javascript -->
	<script src="<?php echo base_url('assets/inspinia/js/inspinia.js');?>"></script>
	<script src="<?php echo base_url('assets/inspinia/js/plugins/pace/pace.min.js');?>"></script>
	
	<!-- jQuery UI -->
	<script src="<?php echo base_url('assets/inspinia/js/plugins/jquery-ui/jquery-ui.min.js');?>"></script>
	</body>
	</html>
		