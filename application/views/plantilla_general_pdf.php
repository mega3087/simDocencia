<html>
	<head><meta http-equiv="Content-Type" content="text/html;">
		<title><?php echo NOMBRE_SISTEMA; ?></title>
		<link rel="icon" type="image/png" href="<?php echo base_url('assets/img/icon.png'); ?>" />
	</head>
	<body>
		<div id="header">
			<?php if(nvl($titulo)){ ?>
			<table width='100%'>
				<tr>
					<td width='20%' align='left'>
						<img src="assets/img/logo_edomex.png" width='100px' />
					</td>
					<td class='text-center'>
						<?php  echo nvl($titulo); ?>
					</td>
					<td width='20%' align='right'>
						<img src="assets/img/logo_cobaemex.png" width='150px' />
					</td>
				</tr>
			</table>
			<?php } ?>
		</div>
		<div id="footer">
			<?php if(nvl($pie_pagina)){ ?>
			<div class='text-right firma'>
			<?php echo nvl($firma_pie); ?>
			</div>
			<div class="gris">
			<!--img src="assets/img/logo_g.png" alt="" class='logo_pie' /-->
			<?php echo nvl($pie_pagina); ?>
			<br />Página <page />
			</div>
			<?php } ?>
		</div>
		<div id="content">
			<?php $this->load->view($subvista); ?>
		</div>
	</body>
	<style>
		@page { 
			margin: 130px 50px 80px 40px; 
			font-family: "open sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
			font-size: 9px;
			color: #676a6c;
		}
		#header { 
			position: fixed; 
			left: 0px; 
			top: -100px; 
			right: 0px; 
			height: 60px; 
			background-color: none; 
			text-align: center;
		}
		#footer {
			position: fixed; 
			left: -2px; 
			bottom: -50px; 
			right: -2px; 
			height: 50px;			
			font-size: 9px;
		}
		
		#footer page:after { 
			content: counter(page);
		}
		
		#footer .gris { 
			background-color: #656464; 
			color : #FFF;
			text-align: center;
		}
		
		#footer .firma { 
			width:100%;
		}
		
		.logo_pie{
			width:140px;
			position: fixed; 
			left: -2px; 
			bottom: 152px;
			z-index: -5000;
		}
		
		.salto-pagina{
			page-break-before:always;
		}
		
		.salto-pagina{
			page-break-before:always;
		}
		
		.text-left{
			text-align:left;
		}
		.text-right{
			text-align:right;
		}
		
		.text-justify{
			text-align:justify;
		}
		
		.text-center{
			text-align:center;
		}
		
		.texto{
			font-size: 12px;
		}
		.firma{
			width: 150px;
		}
		
		td{
			vertical-align: text-top;
		}
		
	</style>
</html>