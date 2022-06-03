 <div class="content rounded">
	<div class="text-center titulo1">AVISO DE JUSTIFICACIÓN DE INCIDENCIAS DE PUNTUALIDAD Y ASISTENCIA</div>
	<?=br(2)?>
	<div class="text-right">Folio: <b class="text-danger"><?=folio($incidencia['IClave'])?></b>&nbsp;</div>
	<br />
	<hr />
	<br />
	<table>
		<tr>
			<td class="text-right">NOMBRE DEL SERVIDOR PUBLICO&nbsp;</td>
			<td colspan="3" class="border" width="520px"><?=$incidencia['INombre']?></td>
		</tr>
		<tr><td colspan="4">&nbsp;</td></tr>
		<tr>
			<td class="text-right">CLAVE DE EMPLEADO&nbsp;</td>
			<td class="border"><?=$incidencia['IClave_servidor']?></td>
			<td class="text-right">FECHA&nbsp;</td>
			<td class="border"><?=fecha_format($incidencia['IFecha_creacion'],'%d / %m / %Y')?></td>
		</tr>
		<tr><td colspan="4">&nbsp;</td></tr>
		<tr>
			<td class="text-right">NOMBRE DEL LA PLAZA&nbsp;</td>
			<td class="border"><?=$incidencia['IPlaza']?></td>
			<td class="text-right">CLAVE DE ISSEMYM&nbsp;</td>
			<td class="border"><?=$incidencia['IISSEMYM']?></td>
		</tr>
	</table>
	<br />
	<hr />
	<br />
	<table>
		<tr>
			<td class="text-right">HORARIO DE PERMISO DE:&nbsp;</td>
			<td width="520px">
				<?=$incidencia['IHorai']?> a <?=$incidencia['IHoraf']?> HORAS
				<br />
				Del <?=fecha_texto($incidencia['IFechai'])?> al <?=fecha_texto($incidencia['IFechaf'])?>.
			</td>
		</tr>
	</table>
	<br />
	<hr />
	<br />
	<div><?=nbs(7)?>POR ESTE CONDUCTO SE NOTIFICA QUE EL SERVIDOR PÚBLICO ESTA AUTORIZADO A:</div>
	<?=br(2)?>
	<table align="center" class="incidencia">
		<tr>
			<?php 
			foreach($cincidencia as $key => $list){
				if($list['CIClave'] == $incidencia['ITipo']) $tipo = "X"; else $tipo="&nbsp;";
			?>
				<td width="20px">&nbsp;</td>
				<td width="22px" height="22px" class="text-center text-middle border"><?=$tipo?></td>
				<td class="text-middle">&nbsp;<?=$list['CITipo']?><br />&nbsp;<?=$list['CIRequisito']?></td>
			<?php 
				if( ($key+1)%3==0) echo '</tr><tr><td colspan="9">&nbsp;</td></tr><tr>';
			} ?>
		</tr>
	</table>
	<?=br(2)?>
	<hr />
	<?=br(2)?>
	<hr />
	<table>
		<tr>
			<td class="text-center"><b>ELABORA</b></td>
			<td class="text-center"><b>AUTORIZA</b></td>
			<td class="text-center"><b>Vo. Bo</b></td>
		</tr>
		<tr>
			<td class="text-center"><?=br(6)?>
				<?php if($incidencia['INivel_autorizacion'] >= 2 ){ ?>
					Firmado <br /><?=fecha_format($incidencia['IFecha_creacion'],'%d / %m / %Y')?>
				<?php }else{
					echo br(2);
				} ?>
			</td>
			<td class="text-center">
				<?php if($incidencia['INivel_autorizacion'] >= 1 ){ 
				$firma = "./assets/img/firmas/depto/".$incidencia['IUsuario_autorizo'].'.png'; 
				$firma = file_exists($firma)?$firma:"./assets/img/firmas/depto/none.png";
				?>
					<img src="<?=$firma?>" class="firma" />
				<?php } ?>
			</td>
			<td class="text-center">
				<?php if($incidencia['INivel_autorizacion'] >= 3 ){ ?>
					<!--img src="./assets/img/firmas/rh.png" class="firma" /-->
					<?=br(6)?>Firmado <br /><?=fecha_format($incidencia['IFecha_registro'],'%d / %m / %Y')?>
				<?php } ?>
			</td>
		</tr>
		<tr>
			<td class="text-center">_______________________________________<br /><?=$incidencia['INombre']?></td>
			<td class="text-center">_______________________________________<br /><?=$incidencia['IJefeInmediato']?></td>
			<td class="text-center">_______________________________________<br /><?=$incidencia['IJefeRH']?></td>
		</tr>
	</table>
</div>
<?=br(2)?>
<div colspan="3" CLASS="titulo2 text-center">EL PLAZO PARA ENTREGAR LA INCIDENCIA ES DE 3 DÍAS HÁBILES DESPUES DE LA MISMA</div>

<div class="marca_agua"><?=$incidencia['IActivo']?"":"Cancelado"?></div>

<style type="text/css">
.content{
	color: #000; font-size:10px !important;
	font-family: Arial, Helvetica, sans-serif !important;
}

.incidencia{
	font-size:9px !important;
}

.rounded { border:1px solid black; border-radius:0px; }

hr { border:0.2px solid black !important; }

.firma { 
	height:90px !important;
	position: absolute !important;
	padding-top: 30px !important;
	padding-left: 40px !important;
	border: 0px solid red !important;
}

table { 
	width: 720px !important;
	max-width: 720px !important;
	border-collapse:collapse !important;
}

.text-middle{
	vertical-align: middle  !important;
}

.border { border: 1px solid black; };

.border-left	{ border-left: hidden !important; }
.border-right	{ border-right: hidden !important; }
.border-top		{ border-top: hidden !important; }
.border-bottom	{ border-bottom: hidden !important; }

.text-left		{ text-align: left !important; }
.text-center	{ text-align: center !important; }
.text-right		{ text-align: right !important; }
.text-justify 	{ text-align: justify !important; }
.text-danger	{ color:red !important; }


.titulo1		{ font-size: 14px !important; background: #c2c2c2 !important;  font-weight:bold;}
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