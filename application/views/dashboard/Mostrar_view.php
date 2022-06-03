<div class="row fondo">	
	<div class="wrapper wrapper-content animated fadeInRight">
	<?php muestra_mensaje(); ?>
		<div class="row">	
			<div class="col-lg-3 wind">
				<div class="ibox widget yellow-bg p-lg text-center">
					<div class="ibox-title">&nbsp;</div>	
					<a href="https://tureciboelectronico.com/" target="_blank" class="btn m-b-md">
						<i class="fa fa-file-text-o fa-4x"></i>
						<h2 class="m-xs">Recibos de Nomina</h2>
					</a>
				</div>
			</div>
			
			<div class="col-lg-3 wind"></div>
			<div class="col-lg-3 wind"></div>
			<div class="col-lg-3 wind"></div>
		</div>
		<div class="row">
			<div class="col-lg-3 wind"></div>
			
			<div class="col-lg-3 wind">
				<div class="ibox widget widget-bg lazur-bg p-lg text-center">
					<div class="ibox-title">&nbsp;</div>	
					<a href="http://cobaem.edomex.gob.mx/calendario_escolar" target='_blank' class="btn m-b-md">
						<i class="fa fa-calendar fa-4x"></i>
						<h2 class="m-xs">Calendario Escolar</h2>
					</a>
				</div>
			</div>
			
			<div class="col-lg-3 wind"></div>
			<div class="col-lg-3 wind">
				<div class="ibox widget widget-bg navy-bg p-lg text-center">
					<div class="ibox-title">&nbsp;</div>	
					<a href='<?php echo base_url('circular'); ?>' class="btn m-b-md">
						<i class="fa fa-envelope-o fa-4x"></i>
						<h2 class="m-xs">Circulares <br /></h2>
					</a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3 wind"></div>
			<div class="col-lg-3 wind"></div>
			<div class="col-lg-3 wind">
				<div class="ibox widget widget-bg red-bg p-lg text-center">
					<div class="ibox-title">&nbsp;</div>	
					<a href="https://tureciboelectronico.com/" target="_blank" class="btn m-b-md">
						<i class="fa fa-money fa-4x"></i>
						<h3 class="m-xs">Constancia de <br />Retenciones y Percepciones <br /></h3>
					</a>
				</div>
			</div>
			<div class="col-lg-3 wind"></div>
		</div>
	</div>
</div>
<!-- jquery UI -->
<script src="<?php echo base_url('assets/inspinia/js/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>

<!-- Touch Punch - Touch Event Support for jQuery UI -->

<script>
	$(document).ready(function(){
		<!-- Enable portlets -->
		WinMove();
	});
</script>
<style type="text/css">
	@media (min-width: 1200px) {
		.wind{
			height: 230px;
		}
	}
	.ibox-title {
		background-color: rgba(113, 72, 72, 0.3);
		border-color: rgba(255, 255, 255, 0);
		padding:21px 0px 0px
	}
	.fondo{
		background-image:url(<?php echo base_url(get_session('UFondo')); ?>);
		background-size: 100%;
	}
	.fondo .p-lg {
		padding: 0px;
	}
	.fondo .btn{
		background-color: transparent !important;
		border:0px;
		padding: 20px 20px 20px;
	}
	.fondo .btn, .btn:hover{
		color: aliceblue;
	}
</style>