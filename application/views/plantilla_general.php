<?php header('Content-Type: text/html; charset=UTF-8'); // http://www.gestiweb.com/?q=content/problemas-html-acentos-y-e%C3%B1es-charset-utf-8-iso-8859-1       ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="SIM" content="SIM, Sistema Integral de Movimientos, FUMP, COBAEM, cobaem">
		<meta name="keywords" content="SIM, Sistema Integral de Movimientos, FUMP, COBAEM, cobaem">
		
		<title><?php echo NOMBRE_SISTEMA; ?></title>
		<link rel="icon" type="image/png" href="<?php echo base_url('assets/img/icon.png'); ?>" />
		
		<link href="<?php echo base_url('assets/inspinia/css/bootstrap.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/inspinia/font-awesome/css/font-awesome.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/inspinia/css/animate.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/inspinia/css/style.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/cobaem.css'); ?>" rel="stylesheet">
		
		<!-- Mainly scripts -->
		<script src="<?php echo base_url('assets/inspinia/js/jquery-2.1.1.js'); ?>"></script>
		<script src="<?php echo base_url('assets/inspinia/js/bootstrap.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/inspinia/js/plugins/metisMenu/jquery.metisMenu.js'); ?>"></script>
		<script src="<?php echo base_url('assets/inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/cobaem.js'); ?>"></script>
		
		<!-- Custom and plugin javascript -->
		<script src="<?php echo base_url('assets/inspinia/js/inspinia.js'); ?>"></script>
		<script src="<?php echo base_url('assets/inspinia/js/plugins/pace/pace.min.js'); ?>"></script>
		
		<!-- alertas chidas -->
		<link href="<?php echo base_url('assets/alertify/themes/alertify.core.css'); ?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/alertify/themes/alertify.default.css'); ?>" rel="stylesheet">
		<script src="<?php echo base_url('assets/alertify/lib/alertify.js'); ?>"></script>
		<!-- formatear numeros -->
		<script src="<?php echo base_url('assets/autoNumeric/autoNumeric-min.js'); ?>"></script>
		<script src='https://cdn.rawgit.com/admsev/jquery-play-sound/master/jquery.playSound.js'></script>

	</head>
	
	<body class='pace-done mini-navbar'> 
		<div id='wrapper'>
			<?php $this->load->view('main_navegation_view'); ?>
			<div id='page-wrapper' class='gray-bg'>
				<?php $this->load->view('header_view'); ?>
				<?php $this->load->view($subvista); chat(); ?>
				<?php $this->load->view('info_view',info()); ?>
				<?php //$this->load->view('footer_view'); ?>
				
				<?php $chat = chat(); ?>
				<div class="small-chat-box fadeInRight animated">
					<div class="heading" draggable="true">
						<small class="chat-date pull-right">
							<?=date('d/m/Y')?>
						</small>
						Chat
						<div id="users"></div>
					</div>
					<div class="content" id="bandeja"></div>
					<form action="<?php echo base_url("chat/send"); ?>" name="Form_chat" id="Form_chat" method="POST">
						<div class="form-chat">
							<div class="input-group input-group-sm">
								<span class="input-group-btn">
									<li class="dropdown emoticons">
										<ul class="dropdown-menu dropdown-messages">
											<li>
												<div class="dropdown-messages-box">
													<div class="media-body">
														<?php $s=0;
														for($i=128512;$i<=128591;$i++){ $s++;
															if($s==23){ echo"<br />"; $s=1; }
														?>
															<button type="button" class="emoticon" value="&#<?=$i?>;" >&#<?=$i?>;</button>
														<?php } ?>
														<br />
														<?php $s=0;
														for($i=128064;$i<=128082;$i++){ $s++; 
															if($s==23){ echo"<br />"; $s=1; }
														?>
															<button type="button" class="emoticon" value="&#<?=$i?>;" >&#<?=$i?>;</button>
														<?php } ?>
														<br />
														<?php $s=0;
														for($i=129296;$i<=129335;$i++){ $s++; 
															if($s==23){ echo"<br />"; $s=1; }
														?>
															<button type="button" class="emoticon" value="&#<?=$i?>;" >&#<?=$i?>;</button>
														<?php } ?>
														<br />
														<?php $s=0;
														for($i=128143;$i<=128159;$i++){ $s++; 
															if($s==23){ echo"<br />"; $s=1; }
														?>
															<button type="button" class="emoticon" value="&#<?=$i?>;" >&#<?=$i?>;</button>
														<?php } ?>
													</div>
												</div>
											</li>
										</ul>
										<a class="btn btn-default dropdown-toggle count-info" type="button" data-toggle="dropdown" aria-expanded="false">&#128578;</a>
									</li>
								</span>
								<input type="text" class="form-control" name="CHMensaje" id="CHMensaje" autocomplete="off" required />
								<span class="input-group-btn">
									<button class="btn btn-primary" type="submit">Enviar</button>
								</span>
							</div>
						</div>
						<input type="hidde" class="form-control" name="CHUsuario_recibe" id="CHUsuario_recibe" value="" />
					</form>
				</div>
				<div id="small-chat">
					<span class="badge badge-warning float-right"><div id="total"><?=$chat['users']?></div></span>
					<a class="open-small-chat" href="#">
						<i class="fa fa-comments"></i>
					</a>
				</div>
				<input type="hidden" name="actual" id="actual" value="<?=$chat['total']?>" class="disable" />
				
			</div>
		</div>
	</body>
	<script type="text/javascript">
		$(document).on("contextmenu",function(e){
		   e.preventDefault();
		});

		$(document).keydown(function(event){
			if(event.keyCode==123){
			return false;
		   }
		else if(event.ctrlKey && event.shiftKey && (event.keyCode==73 || event.keyCode==67)){        
			  return false;  //Prevent from ctrl+shift+i
		   }
		});
		
		$(document).ready(function() {
			
			$("#Form_chat").on("submit",function(e){
				e.preventDefault();
				$.ajax({
					type: "POST",
					url: "<?php echo base_url("chat/send"); ?>",
					data: $(this).serialize(),
					dataType: "html",
					beforeSend: function(){
						//carga spinner
					},
					success: function(data){
						var data = data.split("|");
						$("#CHMensaje").val('');
						if(data[0] == ' OK'){
							$("#bandeja").append( '<div class="right"><div class="author-name">'+data[1]+
							'<small class="chat-date">'+data[2]+'</small>'+
							'</div><div class="chat-message">'+data[3]+'</div></div>' );
						}
					},
					error: function(e){
						//alert("Ocurrio un error interno");
					}
				});
			});
			
			users();
			
			$(".emoticon").click(function(){
				$("#CHMensaje").val( $("#CHMensaje").val()+$(this).val() ).focus();
			});
			
		});
		
		function chat(){
			$.ajax({
				type: "POST",
				url: "<?php echo base_url("chat/index"); ?>",
				dataType: "html",
				beforeSend: function(){
					//carga spinner
				},
				success: function(data){
					$("#bandeja").empty();
					$("#bandeja").append( data );
					$(".slimScrollBar").css("top", "999px");

				},
				error: function(e){
					//alert("Ocurrio un error interno");
				}
			});
		}
		
		function users( usuario ){
			if(! usuario){
				usuario = '';
			}
			$.ajax({
				type: "POST",
				url: "<?php echo base_url("chat/users"); ?>",
				data: 'usuario='+usuario,
				dataType: "html",
				beforeSend: function(){
					//carga spinner
				},
				success: function(data){
					var data = data.split("|");
					$("#users").empty();
					$("#users").html( data[0] );
					$("#CHUsuario_recibe").val( data[1] );
					chat();
				},
				error: function(e){
					//alert("Ocurrio un error interno");
				}
			});
		}
		
		function notificacion() {
			if (Notification) {
				if (Notification.permission !== "granted") {
					Notification.requestPermission();
				}
				var title = "Chat"
				var extra = {
					icon: "<?php echo base_url('assets/img/icon.png'); ?>",
					body: "<?php echo NOMBRE_SISTEMA; ?>"
				}
				var noti = new Notification( title, extra);
				var audio = new Audio('<?php echo base_url('assets/sound/facebook-messenger.mp3'); ?>');
				audio.play();
				
				noti.onclick = function(){
					// Al hacer click
					audio.pause();
				}
				noti.onclose = function(){
					// Al cerrar
					audio.pause();
				}
			}
		}	
		
		function alerta(){
			$.ajax({
				type: "POST",
				url: "<?php echo base_url("chat/noti"); ?>",
				dataType: "html",
				beforeSend: function(){
					//carga spinner
				},
				success: function(data){
					var data = data.split("|");
					var actual = $("#actual").val();
					var nuevo = data[0]*1;
					if( actual < nuevo ){
						users();
						notificacion();
					}else{
						$("#total").empty();
						$("#total").append( data[1] );
					}
					$("#actual").val( nuevo );
				},
				error: function(e){
					//alert("Tu sesión ha expirado");
					//window.location= "login";
				}
			});
		}
		setInterval('alerta()',1500); //1000 = 1segundo
	</script>
	<style type="text/css">
	.small-chat-box{
		width: 70% !important;
	}
	.chat-message, .emoticon{
		font-size: 15px !important;
	}
	.emoticons .dropdown-menu {
		top: -680% !important;
	}
	</style>
</html>
<?php cuenta_psw(); ?>
