<?php for ($i=1;$i<=2;$i++){ ?>
<div class="margen">
	<table>
		<tr>
			<td width="20%" align="left">
				<img src="assets/img/logo-edomex.png" width="90px" />
			</td>
			<td class="text-center">
				<h3>COLEGIO DE BACHILLERES DEL ESTADO DE MÉXICO</h3>
			</td>
			<td width="20%" align="right">
				<img src="assets/img/logo-cobaem.png" width="90px" />
			</td>
		</tr>
	</table>
	<table class="border" cellspacing="0" cellpadding="2">
		<tr>
			<th>COMPROBANTE DE PERCEPCIONES Y DEDUCCIONES</th>
			<td width="200px">Folio <b class="text-red"> No. <?php echo folio($perded['PDClave']); ?></b></td>
		</tr>
	</table>
	<table class="border" cellspacing="0" cellpadding="2">
		<tr>
			<th width="100px">No. Empleado</th>
			<th width="250px">Nombre</th>
			<th>Puesto</th>
			<th width="100px">Cve. ISSEMYM</th>
		</tr>
		<tr>
			<td class="text-right"><?php echo $perded['PDUsuario']; ?></td>
			<td><?php echo $perded['PDNombre']; ?></td>
			<td><?php echo $perded['PDPuesto']; ?></td>
			<td><?php echo $perded['PDISSEMYM']; ?></td>
		</tr>
	</table>
	<table class="border" cellspacing="0" cellpadding="2">
		<tr>
			<th width="100px">Fecha</th>
			<th width="150px">R.F.C.</th>
			<th width="300px">Unidad administrativa</th>
			<th>del:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/al:</th>
		</tr>
		<tr>
			<td class="text-center"><?php echo $perded['PDFecha_f']; ?></td>
			<td><?php echo $perded['PDRFC']; ?></td>
			<td><?php echo $perded['PDDepartamento']; ?></td>
			<td class="text-center"><?php echo $perded['PDFecha_i']." / ".$perded['PDFecha_f']; ?></td>
		</tr>
	</table>
	<table class="border" cellspacing="0" cellpadding="2">
		<tr>
			<th>Clave</th>
			<th>Percepciones</th>
			<th>Monto</th>
			<th>Clave</th>
			<th>Deducciones</th>
			<th>Monto</th>
		</tr>
		<tr>
			<td width="45px" class="text-center" height="160px">			
				<?php if($perded['P562'] != '0.00'){ ?>P562<br /> <?php } ?>
				<?php if($perded['P567'] != '0.00'){ ?>P567<br /> <?php } ?>
				<?php if($perded['P563'] != '0.00'){ ?>P563<br /> <?php } ?>
				<?php if($perded['P571'] != '0.00'){ ?>P571<br /> <?php } ?>
				<?php if($perded['P581'] != '0.00'){ ?>P581<br /> <?php } ?>
				<?php if($perded['P308'] != '0.00'){ ?>P308<br /> <?php } ?>
				<?php if($perded['P309'] != '0.00'){ ?>P309<br /> <?php } ?>
				<?php if($perded['P310'] != '0.00'){ ?>P310<br /> <?php } ?>
				<?php if($perded['P323'] != '0.00'){ ?>P323<br /> <?php } ?>
				<?php if($perded['P324'] != '0.00'){ ?>P324<br /> <?php } ?>
				<?php if($perded['P325'] != '0.00'){ ?>P325<br /> <?php } ?>
				<?php if($perded['P326'] != '0.00'){ ?>P326<br /> <?php } ?>
				<?php if($perded['P501'] != '0.00'){ ?>P501<br /> <?php } ?>
				<?php if($perded['P509'] != '0.00'){ ?>P509<br /> <?php } ?>
				<?php if($perded['P520'] != '0.00'){ ?>P520<br /> <?php } ?>
				<?php if($perded['P521'] != '0.00'){ ?>P521<br /> <?php } ?>
				<?php if($perded['P522'] != '0.00'){ ?>P522<br /> <?php } ?>
				<?php if($perded['P531'] != '0.00'){ ?>P531<br /> <?php } ?>
				<?php if($perded['P533'] != '0.00'){ ?>P533<br /> <?php } ?>			
				<?php if($perded['P570'] != '0.00'){ ?>P570<br /> <?php } ?>			
				<?php if($perded['P589'] != '0.00'){ ?>P589<br /> <?php } ?>			
			</td>
			<td width="200px" class="text-center">
				<?php if($perded['P562'] != '0.00'){ ?>DIA DEL SERVIDOR PUBLICO<br /> <?php } ?>
				<?php if($perded['P567'] != '0.00'){ ?>--<br /> <?php } ?>
				<?php if($perded['P563'] != '0.00'){ ?>PAGO DE AGUINALDO<br /> <?php } ?>
				<?php if($perded['P571'] != '0.00'){ ?>--<br /> <?php } ?>
				<?php if($perded['P581'] != '0.00'){ ?>APARATOS ORTOPEDICOS<br /> <?php } ?>
				<?php if($perded['P308'] != '0.00'){ ?>PREMIO DE PUNTUALIDAD SEMESTRAL<br /> <?php } ?>
				<?php if($perded['P309'] != '0.00'){ ?>PREMIO DE PUNTUALIDAD ANUAL<br /> <?php } ?>
				<?php if($perded['P310'] != '0.00'){ ?>PRIMA VACACIONAL<br /> <?php } ?>
				<?php if($perded['P323'] != '0.00'){ ?>AJUSTE AL CALENDARIO<br /> <?php } ?>
				<?php if($perded['P324'] != '0.00'){ ?>--<br /> <?php } ?>
				<?php if($perded['P325'] != '0.00'){ ?>DIAS DE DESCANSO OBLIGATORIO<br /> <?php } ?>
				<?php if($perded['P326'] != '0.00'){ ?>--<br /> <?php } ?>
				<?php if($perded['P501'] != '0.00'){ ?>PREMIO DE PUNTUALIDAD MENSUAL<br /> <?php } ?>
				<?php if($perded['P509'] != '0.00'){ ?>RETRO PREMIO DE PUNTUALIDAD<br /> <?php } ?>
				<?php if($perded['P520'] != '0.00'){ ?>PRIMA X AÑOS DE SERV BUROCRATA<br /> <?php } ?>
				<?php if($perded['P521'] != '0.00'){ ?>RETRO POR AÑOS DE SERVICIO<br /> <?php } ?>
				<?php if($perded['P522'] != '0.00'){ ?>PAGO DE DIAS ECONOM NO DISFRUT<br /> <?php } ?>
				<?php if($perded['P531'] != '0.00'){ ?>COMPENSACION X DESARROLLO PROF<br /> <?php } ?>
				<?php if($perded['P533'] != '0.00'){ ?>AYUDA ADQUISICION DE LIBROS<br /> <?php } ?>
				<?php if($perded['P570'] != '0.00'){ ?>ESTIMULO 10 AÑOS DE ANTIGÜEDAD<br /> <?php } ?>
				<?php if($perded['P589'] != '0.00'){ ?>ESTIMULO 15 AÑOS DE ANTIGÜEDAD<br /> <?php } ?>
			</td>
			<td width="100px" class="text-right">
				<?php if($perded['P562'] != '0.00'){ echo $perded['P562']."<br />"; } ?>
				<?php if($perded['P567'] != '0.00'){ echo $perded['P567']."<br />"; } ?>
				<?php if($perded['P563'] != '0.00'){ echo $perded['P563']."<br />"; } ?>
				<?php if($perded['P571'] != '0.00'){ echo $perded['P571']."<br />"; } ?>
				<?php if($perded['P581'] != '0.00'){ echo $perded['P581']."<br />"; } ?>
				<?php if($perded['P308'] != '0.00'){ echo $perded['P308']."<br />"; } ?>
				<?php if($perded['P309'] != '0.00'){ echo $perded['P309']."<br />"; } ?>
				<?php if($perded['P310'] != '0.00'){ echo $perded['P310']."<br />"; } ?>
				<?php if($perded['P323'] != '0.00'){ echo $perded['P323']."<br />"; } ?>
				<?php if($perded['P324'] != '0.00'){ echo $perded['P324']."<br />"; } ?>
				<?php if($perded['P325'] != '0.00'){ echo $perded['P325']."<br />"; } ?>
				<?php if($perded['P326'] != '0.00'){ echo $perded['P326']."<br />"; } ?>
				<?php if($perded['P501'] != '0.00'){ echo $perded['P501']."<br />"; } ?>
				<?php if($perded['P509'] != '0.00'){ echo $perded['P509']."<br />"; } ?>
				<?php if($perded['P520'] != '0.00'){ echo $perded['P520']."<br />"; } ?>
				<?php if($perded['P521'] != '0.00'){ echo $perded['P521']."<br />"; } ?>
				<?php if($perded['P522'] != '0.00'){ echo $perded['P522']."<br />"; } ?>
				<?php if($perded['P531'] != '0.00'){ echo $perded['P531']."<br />"; } ?>
				<?php if($perded['P533'] != '0.00'){ echo $perded['P533']."<br />"; } ?>
				<?php if($perded['P570'] != '0.00'){ echo $perded['P570']."<br />"; } ?>
				<?php if($perded['P589'] != '0.00'){ echo $perded['P589']."<br />"; } ?>
			</td>
			<td width="45px" class="text-center">
				<br />
			</td>
			<td width="200px" class="text-center">
				<br />
			</td>
			<td width="100px" class="text-right">
				<br />
			</td>
		</tr>
	</table>
	<table cellspacing="0" cellpadding="2">
		<tr>
			<td class="text-center"><b>Familia COBAEM unidos en la prevención de las adicciones</b></td>
		</tr>
	</table>
	<table class="border" cellspacing="0" cellpadding="2">
		<tr>
			<th width="250px">Total de percepciones</th>
			<th width="250px">Total de deducciones</th>
			<th>Neto a pagar</th>
		</tr>
		<tr>
			<td class="text-right"><?php echo $perded['PDTotal_percepciones']; ?></td>
			<td class="text-right"><?php echo $perded['PDTotal_deducciones']; ?></td>
			<td class="text-right"><?php echo $perded['PDNeto_pagar']; ?></td>
		</tr>
	</table>
</div>
<?php if($i%2){ ?>
<table cellspacing="0" cellpadding="2">
	<tr>
		<td class="text-right">RECIBO EMPLEADO</td>
	</tr>
</table>
<br />
<hr style="border:1px dotted #959190;" />
<br /><br />
<?php }else{ ?>
<table cellspacing="0" cellpadding="2">
	<tr>
		<td class="text-right">RECIBO NOMINA</td>
	</tr>
	<tr>
		<td class="text-center"> <br /><br />
		________________________________________ 
		<br />FIRMA DEL EMPLEADO</td>
	</tr>
</table>
<?php } ?>
<?php } ?>
<style type="text/css">
	.margen {
		border : solid black 2px;
	}
	.text-red{
		color: red;
	}
	table{
		width:100%;
	}
	th{
		background: #f2f3f4;
	}
	.border td,.border  th{
		border : solid #959190 1px;

	}
	html{
		margin:30px 30px;
	}
</style>