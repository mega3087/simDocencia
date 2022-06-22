<html>
	<head><meta http-equiv="Content-Type" content="text/html;">
		<title><?php echo NOMBRE_SISTEMA; ?></title>
		<link rel="icon" type="image/png" href="<?php echo base_url('assets/img/icon.png'); ?>" />
	</head>
	<body>
		<div id="header">
			<table width='100%' class="no-border">
				<tr class="no-border">
					<td width='20%' align='left' class="no-border">
						<img src="assets/img/logo_edomex.png" width='100px' />
					</td>
					<td class='text-center no-border' style="font-size: 13px;">
						<?php if(nvl($titulo)){  
							echo $titulo;
						} ?>
					</td>
					<td width='20%' align='right' class="no-border">
						<img src="assets/img/logo_cobaemex.png" width='150px' />
					</td>
				</tr>
			</table>
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

		.no-border { 
		    border:none !important; 
		     
		}
		td{
			vertical-align: text-top;
		}
		
	</style>
</html>