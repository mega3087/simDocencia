<form action="<?php echo base_url("generarplantilla/validar"); ?>" name="formValidar" id="formValidar" method="POST" class="wizard-big form-vertical">
	<input type="hidden" name="idPlantel" id="idPlantel" value="<?php echo $plantel['CPLClave']; ?>">
	<input type="hidden" name="idPlantilla" id="idPlantilla" value="<?php echo $plantilla['PClave']; ?>">
	<div class="col-lg-12" id="Exportar_a_Excel">
		<table>
			<tr>
				<td rowspan="2" class="no-border text-left" style="font-size: 12px">
					COLEGIO DE BACHILLERES DEL ESTADO DE MÉXICO<br>
					DIRECCIÓN ACADÉMICA<br>
					DEPARTAMENTO DE DOCENCIA Y ORIENTACIÓN EDUCATIVA<br>
					PLANTILLA DE PERSONAL DOCENTE<br>
					PLANTEL Y/O CENTRO EMSAD: <b><?php echo $plantel['CPLNombre']; ?></b> <br>
					SEMESTRE:<b> 20<?= substr($periodo['PEPeriodo'],0,2); ?> <?= substr($periodo['PEPeriodo'],3,1) == 1? '(Febrero-Agosto)' : '(Agosto-Febrero)'?></b><br>
					FECHA: <b><?php echo date('d/m/Y'); ?></b> <br>
				</td>
			</tr>
		</table><br>
		<div class="wrapper" >
		<div class="one" style="text-align:center"><br><br><br><p>#</p></div>
		<div class="one"><br><br>
			<p>NOMBRE DEL DOCENTE</p>
			<p>R.F.C. CON HOMOCLAVE</p></div>
		<div class="one"><br>
			<p>CEDULA PROFESIONAL</p>
			<p>FECHA DE INGRESO</p>
			<p>TIPO NOMBRAMIENTO</p>
		</div>
		<div class="one">
			<p>SITUACION ACTUAL</p>
			<p>ESTUDIO DE LICENCIATURA</p>
			<p>ESTUDIOS COMPLEMENTARIOS</p>
			<p>(PROFORDEMS, CERTIDEMS, ECODEMS)</p>
		</div>
		<div class="one"><br><br><br><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ASIGNATURAS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p></div>
		<div class="one"><br><br><p>HORAS POR </p><p>ASIG.</p></div>
		<div class="two"><br><br><p>NO. DE GRUPOS</p></div>
		<div class="three"><br><p>H/S/M </p><p>POR SEM.</p></div>
		<div class="one"><p>TOTAL</p> <p>HRS.</p> <p>POR</p> <p>ASIG.</p></div>
		<?php if( is_permitido(null,'generarplantilla','validar') && $plantilla['PEstatus'] == 'Revisión' ) { ?> <div class="one"><br><br><br><p>OBSERVACIONES</p></div> <?php } ?>

		<div class="one"><br><br><p>HRS</p> <p>COMPLEMENTO</p></div>
		<div class="one"><p>HORAS FRENTE</p> <p>A GRUPO</p> <p>HOMOLOGADAS/</p> <p>RECATEGORIZADAS</p></div>
		<div class="one"><p>HORAS DE </p> <p>APOYO A LA</p> <p>DOCENCIA</p></div>
		<div class="one"><p>HORAS </p> <p>CB-I</p> <p>Y/O </p> <p>TECNICO CB-I</p></div>
		<div class="one"><p>TOTAL</p><p>HORAS</p><p>DOCENTE</p></div>

		<div class="_4"><b>MAT</b></div>
		<div class="_5"><b>VESP</b></div>
		<div class="_6"><b><?php if (substr($periodo['PEPeriodo'],3,1) == '2') { echo '1'; } else { echo '2';} ?></b></div>
		<div class="_7"><b><?php if (substr($periodo['PEPeriodo'],3,1) == '2') { echo '3'; } else { echo '4';} ?></b></div>
		<div class="_8"><b><?php if (substr($periodo['PEPeriodo'],3,1) == '2') { echo '5'; } else { echo '6';} ?></b></div>

		<?php 
		$i = 1;
		$sumhsm = 0;
		$sumMat = 0;
		$sumVesp = 0;
		$sum1 = 0;
		$sum2 = 0;
		$sum3 = 0;
		$sumtotal = 0;
		$sumcompl = 0;
		$sumfrente = 0;
		$sumapoyo = 0;
		$sumcb = 0;
		$sumhoras = 0;
		foreach ($docentes as $d => $listDoc) { 
		$idPlantel = $this->encrypt->encode($listDoc['UDPlantel']); ?>
			<div class="cuerpo" style="text-align:center"><input type="hidden" id="UDClave" name="UDClave[]" value="<?= $listDoc['UDClave']; ?>" /><b><?= $i; ?></b></div>
			<div class="cuerpo">
				<p><?= mb_strtoupper($listDoc['UApellido_pat'],'utf-8').' '.mb_strtoupper($listDoc['UApellido_mat'],'utf-8').' '.mb_strtoupper($listDoc['UNombre'],'utf-8');  ?></p>
				<p><?= $listDoc['URFC']; ?></p>
			</div>
			<div class="cuerpo">
				<p><?= $listDoc['estudios'][0]['ULCedulaProf'] ?><br>
				<?php foreach ($listDoc['plazas'] as $p => $listP) { 
					$fechaAnio = explode('-',$listP['UDFecha_ingreso']);
					
					if($listP['UDTipo_Nombramiento'] == '1') { 
						echo fecha_format($listP['UDFecha_ingreso']).'</p>';
						echo '<p><b>'.$listP['TPNombre'].'</b><br>';
						echo $listP['nomplaza']; 
						if ($listP['TotalHoras'] != '0') { 
							echo '('.$listP['TotalHoras'].' Horas) '; 
							if ($listP['UDHoras_CB'] != '0' ) { 
								echo ' y '.$listP['UDHoras_CB'].' horas/semana/mes como CB-I</p>'; } 
						} else { 
							echo 'con '.$listP['UDHoras_CB'].'  horas/semana/mes</p>'; 
						}
					} elseif($listP['UDTipo_Nombramiento'] == '2' ) { 
						echo fecha_format($listP['UDFecha_ingreso']).'</p>';
						echo '<p><b>'.$listP['TPNombre'].' '.$fechaAnio[0].'</b><br>';
						echo $listP['nomplaza']; 
						if ($listP['TotalHoras'] != '0') { 
							echo '('.$listP['TotalHoras'].' Horas) '; 
							if ($listP['UDHoras_CB'] != '0' ) { 
								echo ' y '.$listP['UDHoras_CB'].' horas/semana/mes como CB-I</p>'; } 
						} else { 
							echo 'con '.$listP['UDHoras_CB'].'  horas/semana/mes</p>'; 
						}
					} elseif($listP['UDTipo_Nombramiento'] == '3' || $listP['UDTipo_Nombramiento'] == '4') {
						echo fecha_format($listP['UDFecha_inicio']).' al '.fecha_format($listP['UDFecha_final']).'</p>'; 
						echo '<p><b>'.$listP['TPNombre'].'</b></p>';
						echo '<p>'.$listP['nomplaza'].'</p>';
						if ($listP['TotalHoras'] != '0') { 
							echo '('.$listP['TotalHoras'].' Horas)'; 
							if ($listP['UDHoras_CB'] != '0' ) { 
								echo ' y '.$listP['UDHoras_CB'].' horas/semana/mes como CB-I'; } 
						} else { 
							echo 'con '.$listP['UDHoras_CB'].'  horas/semana/mes'; 
						}
					} elseif ($listP['UDTipo_Nombramiento'] == '5') { 
						echo '<p><b>'.$listP['UDHoras_CB'].' <b>'.$listP['TPNombre'].'</b> autorizadas del '.fecha_format($listP['UDFecha_inicio']).' al '.fecha_format($listP['UDFecha_final']).' Oficio / Folio: '.$listP['UDNumOficio'].'</b></p>';
					} elseif ($listP['UDTipo_Nombramiento'] == '6') { 
						echo '<p><b>'.$listP['UDHoras_CB'].' <b>'.$listP['TPNombre'].'</b> autorizadas del '.fecha_format($listP['UDFecha_inicio']).' al '.fecha_format($listP['UDFecha_final']).' Oficio / Folio: '.$listP['UDNumOficio'].'</b></p>';
						//echo '<p><b>'.$listP['UDHoras_CB'].' <b> hrs.  Provisional Of. '.$listP['UDNumOficio'].'</b> por '.$listP['TPNombre'].'</b></p>';
					} elseif ($listP['UDTipo_Nombramiento'] == '7') { 
						echo '<p><b>'.$listP['UDHoras_CB'].' <b></b> Horas Provisionales, Folio: '.$listP['TPNombre'].'</b></p>';
					} elseif ($listP['UDTipo_Nombramiento'] == '8') {
						echo '<p><b>'.$listP['UDHoras_CB'].' <b>'.$listP['TPNombre'].'</b> por promoción '.fecha_format($listP['UDFecha_ingreso']).'</b></p>';
					}?>

					<div style="background-color: #e7eaec;"><?= nvl($listP['UDObservaciones']); ?></div>
				<?php } ?>
			</div>
			<div class="cuerpo">
				<p><b><?= nvl($listDoc['estudios'][0]['ULTitulado']); ?></b></p>
				<?php foreach ($listDoc['estudios'] as $e => $listEst) { ?>
					<p><?= nvl($listEst['LGradoEstudio']).' en '.nvl($listEst['Licenciatura']); ?></p>
				<?php } ?>
			</div>
			<div class="cuerpo">
				<?php foreach ($listDoc['materias'] as $m => $listMat) { ?>
					<p><?= $listMat['materia']; ?><?php if ($listMat['UDTipo_Nombramiento'] == 8) { echo " <b>(Adicionales)</b>";} elseif ($listMat['UDTipo_Nombramiento'] == 5) { echo " <b>(Provisionales)</b>";} ?></p>
				<?php } ?>
			</div>
			<div class="cuerpo" style="text-align: center;">
				<?php foreach ($listDoc['materias'] as $m => $listMat) { 
					$sumhsm = $sumhsm + $listMat['hsm'];
					?>
					<p><?= $listMat['hsm']; ?></p>
				<?php } ?>
			</div>
			<div class="cuerpo" style="text-align: center;">
				<?php foreach ($listDoc['materias'] as $m => $listMat) { 
					$sumMat = $sumMat + $listMat['pnogrupoMatutino'];?>
					<p><?= $listMat['pnogrupoMatutino']; ?></p>
				<?php } ?>
			</div>
			<div class="cuerpo" style="text-align: center;">
				<?php foreach ($listDoc['materias'] as $m => $listMat) { 
					$sumVesp = $sumVesp + $listMat['pnogrupoVespertino'];?>
					<p><?= $listMat['pnogrupoVespertino']; ?></p>
				<?php } ?>
			</div>
			<div class="cuerpo" style="text-align: center;">
				<?php foreach ($listDoc['materias'] as $m => $listMat) { ?>
					<?php if ($listMat['psemestre'] == '1' || $listMat['psemestre'] == '2') { 
						$sum1 = $sum1 + $listMat['ptotalHoras'];?>
						<p><?= $listMat['ptotalHoras']; ?></p>
					<?php } else { ?>
						<p>&nbsp;</p>
					<?php } ?>
				<?php } ?>
			</div>
			<div class="cuerpo" style="text-align: center;">
				<?php foreach ($listDoc['materias'] as $m => $listMat) { ?>
					<?php if ($listMat['psemestre'] == '3' || $listMat['psemestre'] == '4') { 
						$sum2 = $sum2 + $listMat['ptotalHoras'];?>
						<p><?= $listMat['ptotalHoras']; ?></p>
					<?php } else { ?>
						<p>&nbsp;</p>
					<?php } ?>
				<?php } ?>
			</div>
			<div class="cuerpo" style="text-align: center;">
				<?php foreach ($listDoc['materias'] as $m => $listMat) { ?>
					<?php if ($listMat['psemestre'] == '5' || $listMat['psemestre'] == '6') { 
						$sum3 = $sum3 + $listMat['ptotalHoras'];?>
						<p><?= $listMat['ptotalHoras']; ?></p>
					<?php } else { ?>
						<p>&nbsp;</p>
					<?php } ?>
				<?php } ?>
			</div>
			<div class="cuerpo" style="text-align: center;">
				<?php foreach ($listDoc['materias'] as $m => $listMat) { 
					$sumtotal = $sumtotal + $listMat['ptotalHoras'];?>
				<p><?= $listMat['ptotalHoras']; ?></p>
				<?php } ?>
			</div>
			<?php if( is_permitido(null,'generarplantilla','validar') && $plantilla['PEstatus'] == 'Revisión' ) { ?>
			<div class="cuerpo" style="text-align: center;">
			<?php foreach ($listDoc['materias'] as $m => $listMat) { ?>
				<input type="hidden" name="idPlanDetalle[]" value="<?= $listMat['idPlanDetalle']?>">
				<p><button title="OBSERVACIONES" class="btn btn-warning btn-circle pull-left no-imprimir" nombre="<?= $listMat['idPlanDetalle'] ?>" value="" type="button" data-toggle="popover" data-placement="auto right" data-content="--------------------------------------"><i class="fa fa-comment"></i></button><br><br></p>
			<?php } ?>
			</div>
			<?php } ?>
			<div class="cuerpo" style="text-align: center;"></div>
			<?php foreach ($listDoc['horas'] as $h => $listHor) { 
				$sumfrente = $sumfrente + $listHor['UDHoras_grupo'];
				$sumapoyo = $sumapoyo + $listHor['UDHoras_apoyo'];
				if ($listHor["totalHoras"] > $listHor['UDHoras_grupo']) { $horasCB = $listHor['UDHoras_CB']; } else { $horasCB = "0"; }
				$sumcb = $sumcb + $horasCB;
				$sumhoras = $sumfrente + $sumapoyo + $sumcb;?>				
			<div class="cuerpo" style="text-align: center;"><p> <?= $listHor['UDHoras_grupo']; ?></p></div>
			<div class="cuerpo" style="text-align: center;"><p> <?= $listHor['UDHoras_apoyo']; ?></p></div>
			<div class="cuerpo" style="text-align: center;"><p> <?php if ($listHor["totalHoras"] > $listHor['UDHoras_grupo']) { echo $listHor['UDHoras_CB']; } else { echo "0"; } ?></p></div>
			<div class="cuerpo" style="text-align: center;"><?= $listHor['UDHoras_grupo'] + $listHor['UDHoras_apoyo'] + $horasCB; ?></div>
			<?php } ?>			
		<?php $i++; } ?>
			<div class="totales" style="text-align: center;">TOTALES</div>
			<div class="cuerpo" style="text-align: center;"><?= $sumhsm ?></div>
			<div class="cuerpo" style="text-align: center;"><?= $sumMat ?></div>
			<div class="cuerpo" style="text-align: center;"><?= $sumVesp ?></div>
			<div class="cuerpo" style="text-align: center;"><?= $sum1 ?></div>
			<div class="cuerpo" style="text-align: center;"><?= $sum2 ?></div>
			<div class="cuerpo" style="text-align: center;"><?= $sum3 ?></div>
			<div class="cuerpo" style="text-align: center;"><?= $sumtotal ?></div>
			<?php if( is_permitido(null,'generarplantilla','validar') && $plantilla['PEstatus'] == 'Revisión' ) { ?>
			<div class="cuerpo" style="text-align: center;"></div>
			<?php } ?>
			<div class="cuerpo" style="text-align: center;"><?= $sumcompl ?></div>
			<div class="cuerpo" style="text-align: center;"><?= $sumfrente ?></div>
			<div class="cuerpo" style="text-align: center;"><?= $sumapoyo ?></div>
			<div class="cuerpo" style="text-align: center;"><?= $sumcb ?></div>
			<div class="cuerpo" style="text-align: center;"><?= $sumhoras ?></div>
		</div>
	</div>
	<div class="form-group">
	<div class="loadingRevision"></div>
</div>
</form>

<br><br>

<?php if (is_permitido(null,'generarplantilla','revisarPlantilla') ) { ?>
<div class="form-group">
	<div class="col-lg-1"></div>
	<div class="col-lg-10"><br><br>
	<?php if ($contarDoc != $DocPlan)  { ?>
		<button class="btn btn-primary btn-rounded btn-block revision pull-center" type="button" <?php if($plantilla['PEstatus'] == 'Revisión'){ echo "disabled"; }?>>
			<i class="fa fa-eye"></i> <?php if ($plantilla['PEstatus'] == 'Revisión') { 
				echo "Plantilla en Revisión"; 
				} else {
				echo "Mandar a Revisón"; } ?>
		</button>
	<?php } ?>
	</div>
</div>
<?php } ?>
<br><br>
<?php if( is_permitido(null,'generarplantilla','validar') && $plantilla['PEstatus'] == 'Revisión' ) { ?>
	<div class="form-group">
	<div class="col-lg-1"></div>
	<div class="col-lg-10"><br><br>
		<button class="btn btn-primary btn-rounded btn-block save_rechazar pull-center enviarCorrecciones" type="button"> <i class="fa fa-exchange"></i> Enviar Correcciones</button>
	</div>
</div>
<?php } ?>

<!--<form action="<?= base_url("generarplantilla/exportarExcel_skip")?>" method="post" target="_blank" id="FormularioExportacion">
<button class="btn btn-primary btn-rounded btn-block botonExcel pull-center" type="button"> <i class="fa fa-save"></i> Exportar Excel</button>
	<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>-->
<script src="<?php echo base_url('assets/inspinia/js/plugins/bootbox.all.min.js'); ?>"></script>
<script>
$(document).ready(function() {
	$(".revision").click(function() {
		bootbox.confirm({
			message: "<div class='text-center'>¿Seguro de enviar la Plantilla a Revisión?</div>",
			size: 'small',
			buttons: {
				confirm: {
					label: 'Si',
					className: 'btn-primary'
				},
				cancel: {
					label: 'No',
					className: 'btn-danger'
				}
			},
			callback: function (result) {
				if (result == true) {
					var idPlantel = document.getElementById('plantelId').value;
					$.ajax({
						type: "POST",
						url: "<?php echo base_url("generarplantilla/revisarPlantilla"); ?>",
						data: $('#formValidar').serialize(),
						dataType: "html",
						beforeSend: function(){
							//carga spinner
							$(".loadingRevision").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
						},
						success: function(data) {
						var data = data.split("::");
							if(data[1]=='OK'){	
								$(".loadingRevision").html('');
								verPlantilla(data[2]);
								//location.href ='<?php echo base_url("generarplantilla/crear/$idPlantel"); ?>';
							}
						}
					});
				}
			}
		});		
	});

	$(".enviarCorrecciones").click(function() {
		var idPlantel = document.getElementById('plantelId').value;
		$.ajax({
			type: "POST",
			url: "<?php echo base_url("generarplantilla/enviarCorrecciones_skip"); ?>",
			data: $('#formValidar').serialize(),
			dataType: "html",
			beforeSend: function(){
				//carga spinner
				$(".loadingRevision").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
			},
			success: function(data) {
				var data = data.split("::");
				if(data[1]=='OK'){	
					$(".loadingRevision").html('');
					verPlantilla(data[2]);
					//location.href ='<?php echo base_url("generarplantilla/crear/$idPlantel"); ?>';
				} 
			}
		});
	});

	$(".botonExcel").click(function(event) {
		$("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
		$("#FormularioExportacion").submit();
	});
});

	
	$(document).ready(function(){
		$('button[data-toggle="popover"]').popover();   
	});

	$("button[data-toggle]").click(function() {
		var nombre = $(this).attr('nombre');
		var i = 0;
		var y = 0;
		var texto = '';
		$('input[name='+nombre+']').each(function(){
			i = 1;
		});
		if(i == 0){
			$(this).parent().append('<input type="hidden" name="'+nombre+'" value="" />');
		}else{
			texto = $('input[name='+nombre+']').val();
		}
		
		$('#'+$(this).attr('aria-describedby')+' .popover-content').html('<textarea id="'+nombre+'" class="form-control textarea" >'+texto+'</textarea>');
		
		$('.textarea').keyup(function(){
			nombre = $(this).attr('id');
			$('input[name='+nombre+']').val( $(this).val() );
		});
	});

</script>

<style>
.wrapper {
  display: grid;
  -grid-template-columns: repeat(3, 1fr);
  -grid-auto-rows: minmax(100px, auto);
  border: 1px solid rgba(0, 0, 0, 0);
  font-size: 12px;
}
.one {
	grid-row-start: 1;
	grid-row-end: 3;
	border: 1px solid rgba(0, 0, 0, 0.8);
	text-align: center;
	background-color: #e7eaec;
}
.two {
	grid-row-start: 1;
	grid-row-end: 3;
	grid-column-start: 7;
	grid-column-end: 9;
	border: 1px solid rgba(0, 0, 0, .8);
	text-align: center;
	background-color: #e7eaec;
}
.three {
	grid-column-start: 9;
	grid-column-end: 12;
	grid-row: 1/ 3;
	border: 1px solid rgba(0, 0, 0, .8);
	text-align: center;
	background-color: #e7eaec;
}
._4 {
	grid-column-start: 7;
	grid-row-start: 2;
	grid-row-end: 2;
	border: 1px solid rgba(0, 0, 0, .8);
	text-align: center;
	
}
._5 {
	grid-column-start: 8 ;
	grid-row-start: 2;
	grid-row-end: 2;
	border: 1px solid rgba(0, 0, 0, .8);
	text-align: center;
}
._6 {
	grid-column-start: 9;
	grid-row-start: 2;
	grid-row-end: 2;
	border: 1px solid rgba(0, 0, 0, .8);
	text-align: center;
}
._7 {
	grid-column-start: 10;
	grid-row-start: 2;
	grid-row-end: 2;
	border: 1px solid rgba(0, 0, 0, .8);
	text-align: center;
}
._8 {
	grid-column-start: 11;
	grid-row-start: 2;
	grid-row-end: 2;
	border: 1px solid rgba(0, 0, 0, .8);
	text-align: center;
}
.cuerpo {
	border: 1px solid rgba(0, 0, 0, 0.8);
	text-align: left;
}

.totales {
	grid-column-start: 1;
	grid-column-end: 6;
	border: 1px solid rgba(0, 0, 0, .8);
	text-align: center;
}
</style>