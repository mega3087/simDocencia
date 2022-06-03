<?php 
	//http://www.gestiweb.com/?q=content/problemas-html-acentos-y-e%C3%B1es-charset-utf-8-iso-8859-1  
	header('Content-Type: text/html; charset=UTF-8'); 
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="SIM" content="SIM, Sistema Integral de Movimientos, FUMP, COBAEM, cobaem">
		<meta name="keywords" content="SIM, Sistema Integral de Movimientos, FUMP, COBAEM, cobaem">
		<title><?php echo NOMBRE_SISTEMA; ?></title>
		
		<link rel="icon" type="image/png" href="<?php echo base_url('assets/img/icon.png'); ?>" />
		
		<link href="<?php echo base_url('assets/inspinia/css/bootstrap.min.css');?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/inspinia/font-awesome/css/font-awesome.css');?>" rel="stylesheet">
		
		<link href="<?php echo base_url('assets/inspinia/css/animate.css');?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/inspinia/css/style.css');?>" rel="stylesheet">
		
		<link href="<?php echo base_url('assets/style.css'); ?>" rel="stylesheet">
		<!-- Mainly scripts -->
		<script src="<?php echo base_url('assets/inspinia/js/jquery-2.1.1.js'); ?>"></script>
	</head>
	
	<body class="">
	<div class="row navy-bg menu">
		<div class="col-lg-8 col-sm-8 col-xs-4">
			<img src="<?=base_url('assets/img/h1_cobaem.png')?>" width="265px" class="hidden-sm hidden-xs" />
			<h2><b>&nbsp;SIM</b> <span class="hidden-xs">- <?php echo NOMBRE_SISTEMA; ?></span></h2>
		</div>
		<div class="col-lg-2 col-sm-2 col-xs-4"><br />
			<button 
			id="acceso"
			class="btn btn-primary open"
			data-target="#modal_personal" 
			data-toggle="modal"
			data-unci_usuario_skip=""
			data-uplantel="<?php echo get_session('UPlantel'); ?>" >
				<i class="fa fa-user"> </i> Acceso
			</button>
		</div>
		<div class="col-lg-2 col-sm-2 col-xs-4"><br />
			<div class="btn-group">
			  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Menú <span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu">
					<li><a href="<?php echo base_url('./documentacion/Manual de Usuario.pdf'); ?>" target='_blank'><i class="fa fa-book"></i> Manual de Usuario</a></li>
					<li class="divider"></li>
					<li><a href="<?php echo base_url('usuario/recuperar_contrasena'); ?>"><i class="fa fa-key"></i> &iquest;Olvidaste la Contrase&ntilde;a?</a></li>
				</ul>
			</div>
		</div>
	</div>
	
		<div class="fondosplash-">
			<br /><br /><br /><br /><br /><br /><br />
			<div class="text-left animated fadeIn">
					<?php
						$mes = date('m');
						$total_imagenes = count(glob("assets/img/fondo/$mes/{*.jpg,*.gif,*.png}",GLOB_BRACE));
						$imagen = rand(1,$total_imagenes);
						$image_properties = array
						(
						"src"   => "assets/img/fondo/$mes/$imagen.png",
						"class" => "login-logo img-responsive",
						"width" => "400px",
						"style" => "display: inline !important; margin-left: 100px;"
						);
						echo img($image_properties);
					?>
			</div>
		</div>


		<!-- Form -->
		<div class="fondosplash- modal inmodal" id="modal_personal" tabindex="-1" role="dialog" aria-hidden="true">
			<br /><br /><br /><br /><br />
			<div class="loginscreen text-center animated fadeIn">
				<h1 class="text-white"><b>¡Bienvenido!</b></h1>
				<?php
					echo form_open('login/validar', array('id' => 'forma', 'role' => 'form'));
					muestra_mensaje();
				?>
				<script type="text/javascript">
				$(document).ready(function(){
					if ( check_Version() == '11' ){
						$(".explorer").removeClass("hidden");
						//$(".otros").addClass("hidden");
					}else{
						//$(".explorer").addClass("hidden");
						$(".otros").removeClass("hidden");
					}
				});
				function check_Version(){
					var rv = -1; // Return value assumes failure.

					if (navigator.appName == 'Microsoft Internet Explorer'){

					   var ua = navigator.userAgent,
						   re  = new RegExp("MSIE ([0-9]{1,}[\\.0-9]{0,})");

					   if (re.exec(ua) !== null){
						 rv = parseFloat( RegExp.$1 );
					   }
					}
					else if(navigator.appName == "Netscape"){                       
					   /// in IE 11 the navigator.appVersion says 'trident'
					   /// in Edge the navigator.appVersion does not say trident
					   if(navigator.appVersion.indexOf('Trident') === -1) rv = 12;
					   else rv = 11;
					}
					return rv;          
				}
				</script>
				<div class="form-group explorer hidden">
					<span class="text-white">Este navegador no es compatible con la aplicación, favor de usar Microsoft Edge, Firefox, Opera o Chrome. </span><br /><br />
					<label class="col-lg-4 control-label" for="">
						<a href="https://www.mozilla.org/es-MX/firefox/new/" target="_blank" ><img src="./assets/img/firefox.png" style="width:80px;" alt="" /></a>
					</label>
					<label class="col-lg-4 control-label" for="">
						<a href="https://www.opera.com/es/download" target="_blank" ><img src="./assets/img/opera.png" style="width:80px;" alt="" /></a>
					</label>
					<label class="col-lg-4 control-label" for="">
						<a href="https://www.google.com.mx/intl/es-419/chrome/" target="_blank" ><img src="./assets/img/chrome.png" style="width:80px;" alt="" /></a>
					</label>
				</div>
				<div class="form-group otros hidden">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon"><i class="fa fa-user"></i></div>
							<input type="text" name = "UCorreo_electronico"
							placeholder="Correo electr&oacute;nico o teléfono" class="form-control" required
							value="">
						</div>
					</div>
					
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon"><i class="fa fa-key"></i></div>
							<input type="password" name = "UContrasena"
							placeholder="Contrase&ntilde;a" class="form-control" required
							value="">
						</div>
					</div>
					
					<div class="form-group">
						<button type="submit" class="btn btn-primary m-b btn-rounded btn-block">
							<i class="fa fa-sign-in"></i> Ingresar
						</button>
					</div>
				</div>
				&nbsp;
				<?php echo form_close(); ?>
			</div>
			
		</div>
		
		<?php $this->load->view('footer_view'); ?>
		
		<!-- Mainly scripts -->
		<script src="<?php echo base_url('assets/inspinia/js/bootstrap.min.js');?>"></script>
		
		<!-- Custom and plugin javascript -->
		<script src="<?php echo base_url('assets/inspinia/js/inspinia.js');?>"></script>
		<script src="<?php echo base_url('assets/inspinia/js/plugins/pace/pace.min.js');?>"></script>
	
	<!-- jQuery UI -->
	<script src="<?php echo base_url('assets/inspinia/js/plugins/jquery-ui/jquery-ui.min.js');?>"></script>
	</body>
</html>
<script type="text/javascript">
<?php if(get_session('error')){ set_session('error',null); ?>
$("#acceso").click();
<?php } ?>
</script>
<style type="text/css">
.control-label em {
	color:red;
}
.menu img{
	background-color: white;
	float: inline-start;
}
body{
	background-image: url("./assets/img/Fondo_login.jpg");
}
.loginscreen{
	background-color: rgba(37, 106, 21, 1);
	border-radius: 30px;
}
.dropdown-menu{
	background-color: #b10325 ;
}
.navy-bg, .btn-primary {
    background-color: #b10325;
	border: #b10325 ;
}
.btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .open .dropdown-toggle.btn-primary, .btn-primary:active:focus, .btn-primary:active:hover, .btn-primary.active:hover, .btn-primary.active:focus {
    background-color: #b10325  !important;
	border: #b10325 ;
}
</style>