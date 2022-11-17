<html>
	<head><meta http-equiv="Content-Type" content="text/html;">
		<title><?php echo NOMBRE_SISTEMA; ?></title>
		<link rel="icon" type="image/png" href="<?php echo base_url('assets/img/icon.png'); ?>" />
	</head>
	<body>
        <div id="header">
			<table width='100%' class="no-border">
				<tr class="no-border">
					<td width='20%' class="no-border left-text">
						<img src="assets/img/logo_edomex.png" width='100px' />
					</td>
					<td class='text-center no-border' style="font-size: 13px;">
						<?php if(nvl($titulo)){  
							echo $titulo;
						} ?>
					</td>
					<td width='20%' class="no-border right-text">
						<img src="assets/img/logo_cobaemex.png" width='150px' />
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td rowspan="2" class="no-border text-left line-height-0-8" style="font-size: 10px">
						COLEGIO DE BACHILLERES DEL ESTADO DE MÉXICO<br>
						DIRECCIÓN ACADÉMICA<br>
						DEPARTAMENTO DE DOCENCIA Y ORIENTACIÓN EDUCATIVA<br>
						PLANTILLA DE PERSONAL DOCENTE<br>
						PLANTEL Y/O CENTRO EMSAD: <b><?php echo $plantel['CPLNombre']; ?></b> <br>
						SEMESTRE:<b> 20<?= substr($periodo['PEPeriodo'],0,2); ?> <?= substr($periodo['PEPeriodo'],3,1) == 1? '(Febrero-Agosto)' : '(Agosto-Febrero)'?></b><br>
						FECHA: <b><?php 
						if ($plantilla['PEstatus'] == 'Pendiente' || $plantilla['PEstatus'] == 'Revisión') {
							$fecha = explode(' ', $plantilla['PFecha_registro']);
							echo fecha_format($fecha[0]);
						} 
						if ($plantilla['PEstatus'] == 'Autorizada') {
							$fecha = explode(' ', $plantilla['PFecha_modificacion']);
							echo fecha_format($fecha[0]);
						}
						?></b> <br>
					</td>
				</tr>
			</table>
		</div>
		<div id="content">
			<?php $this->load->view($subvista); ?>
		</div>
	</body>
	<style type="text/css">
		.line-height-0-7{ line-height: .7em !important;}
		.line-height-0-8{ line-height: .8em !important;}
		.line-height-0-9{ line-height: .9em !important;}
		.line-height-1{ line-height: 1.0em !important;}
		.line-height-1-5{ line-height: 1.5em !important;}
		.line-height-2{ line-height: 2.0em !important;}
	</style>
</html>