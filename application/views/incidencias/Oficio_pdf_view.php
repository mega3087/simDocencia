 <div class="content">
	<div class="text-justify">
		<div class="text-right">
		<?php if($incidencia['CITramite']==1){ ?>
			Aviso de comisión
		<?php }else{ ?>
			Solicitud de permiso por <?=mb_strtolower($incidencia['CITipo'])?>
		<?php } ?>
		<br /><br /><br />
		</div>
		Toluca de Lerdo, Méx; a <?=fecha_texto($incidencia['IFecha_creacion'])?>
		<br /><br /><br /><br />
		<div class="titulo1">
			<?php 
			if($incidencia['CITramite']==1){ 
				echo $incidencia['INombre']."<br />".strtoupper($incidencia['IPlaza']);
			}else{
				echo $incidencia['IJefeRH'];
			}
			?>
			<br />
			PRESENTE
		</div>
		<br /><br /><br /><br />
		<?php 
			$texto = $incidencia['CITexto'];
			$texto = str_replace("<nombre>", $incidencia['INombre'], $texto);
			$texto = str_replace("<clave>", $incidencia['UClave_servidor'].$incidencia['UClave_servidor_centro'], $texto);
			$texto = str_replace("<rfc>", $incidencia['URFC'], $texto);
			$texto = str_replace("<fechanacimiento>", fecha_texto($incidencia['UFecha_nacimiento']), $texto);
			$texto = str_replace("<fechainicial>", fecha_texto($incidencia['IFechai']), $texto);
			if($incidencia['IFechai'] != $incidencia['IFechaf']){
				$texto = str_replace("<fechafinal>", " al ".fecha_texto($incidencia['IFechaf']), $texto);
			}
		?>
		<?=$texto?> <?=$incidencia['IComision']?>.
		<br /><br />
		<?php if($incidencia['CITramite']==1){
			if($incidencia['IFechai'] == $incidencia['IFechaf']){
				$fecha = "el dia ".fecha_texto($incidencia['IFechai']);
			}else{
				$fecha = "del día ".fecha_texto($incidencia['IFechai'])." al ".fecha_texto($incidencia['IFechaf']);
			}
		?>		
				
		de <?=$incidencia['IHorai']?> a <?=$incidencia['IHoraf']?> Hrs; <?=$fecha?>.
		<br /><br />
		Por lo cual estará exento de registrar asistencia de <u><?=$incidencia['IExcento']?></u>, lo anterior a fin de que proceda con los tramites correspondientes.
		<?php }else{ ?>
		Sin más por el momento me despido de usted no sin antes enviarle un cordial saludo y mi muy sincero agradecimiento.
		<?php } ?>
		<br /><br /><br /><br />
		<br /><br /><br /><br />
		<div class="titulo1 text-center">ATENTAMENTE</div>
		<br /><br /><br />
		<br /><br /><br />
	</div>
	<table>
		<tr>
			<td class="text-center">
				<?php if($incidencia['CITramite']==1 and $incidencia['INivel_autorizacion'] >= 1 ){ 
				$firma = "./assets/img/firmas/depto/".$incidencia['IUsuario_autorizo'].'.png'; 
				$firma = file_exists($firma)?$firma:"./assets/img/firmas/depto/none.png";
				?>
					<img src="<?=$firma?>" class="firma" />
				<?php } ?> 
				<br />_______________________________________<br />
				<?php 
				if($incidencia['CITramite']==1){ 
					echo $incidencia['IJefeInmediato'];
				}else{
					echo $incidencia['INombre']."<br />".strtoupper($incidencia['IPlaza']);
				}
				?>
			</td>
		</tr>
	</table>
</div>
<div class="marca_agua"><?=$incidencia['IActivo']?"":"Cancelado"?></div>
<style type="text/css">
.content		{
	color: #000; font-size:14px !important;
	font-family: Arial, Helvetica, sans-serif !important;
}

table { 
	width: 720px !important;
	max-width: 720px !important;
	border-collapse:collapse !important;
}

.firma { 
	height:90px !important;
	position: absolute !important;
	padding-top: -45px !important;
	padding-left: 300px !important;
	border: 0px solid red !important;
}

.border-left		{ border-left: hidden !important; }
.border-right	{ border-right: hidden !important; }
.border-top		{ border-top: hidden !important; }
.border-bottom	{ border-bottom: hidden !important; }

.text-left		{ text-align: left !important; }
.text-center	{ text-align: center !important; }
.text-right		{ text-align: right !important; }
.text-justify 	{ text-align: justify !important; }
.text-danger	{ color:red !important; }

.titulo1		{ font-size: 16px !important; font-weight:bold; }
.titulo2		{ font-size: 14px !important; font-weight:bold; }

.marca_agua {
	text-transform: uppercase;
	font-weight: bold;
	color: Black;
	font-size:80px;
	position: absolute;
	z-index: 4;
	left:50%;
    top: 40%;	
	margin: 0 0 0 -300px;
	transform:  rotate(-45deg);
	opacity: 0.2;
    filter: alpha(opacity=10); /* For IE8 and earlier */
}

</style>