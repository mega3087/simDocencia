<div class="row">
	<form action="<?php echo base_url("fump/comentarios"); ?>" name="form_comen" id="form_comen" method="POST" class="wizard-big form-vertical">
		<div class="col-lg-12">
			<table>
				<tr>
					<td rowspan="2" class="no-border text-left"><img src="<?=base_url("assets/img/logo_edomex.png")?>" width="100px" alt="" /></td>
					<td class="no-border text-center">&nbsp;</td>
					<td rowspan="2" width="150px" class="no-border text-right"><img src="<?=base_url("assets/img/$FLogo_cobaemex")?>" width="100%" alt="" /></td>
				</tr>
				
			</table>
			<table>
				<tr>
					<td rowspan="2" class="no-border text-left" style="font-size: 10px">
						COLEGIO DE BACHILLERES DEL ESTADO DE MÉXICO<br>
						DIRECCIÓN ACADÉMICA<br>
						DEPARTAMENTO DE DOCENCIA Y ORIENTACIÓN EDUCATIVA<br>
						PLANTILLA DE PERSONAL DOCENTE<br>
						PLANTEL Y/O CENTRO EMSAD: <b><?php echo $plantel[0]['CPLNombre']; ?></b> <br>
						SEMESTRE: 20<?= substr($periodos[0]['CPEPeriodo'],0,2); ?>-<?= substr($periodos[0]['CPEPeriodo'],3,1) == 1? 'A (Febrero-Julio)' : 'B (Agosto-Enero)'?><br>
						FECHA: <?php echo date('d/m/Y'); ?> <br>
					</td>
				</tr>
			</table><br>

			<table>
				<thead>
                <tr>
                    <th rowspan ="2" style="text-align: center;">No</th>
                    <th rowspan ="2" style="text-align: center;">
                        NOMBRE DEL DOCENTE<br>
                        R.F.C. CON HOMOCLAVE
                    </th>
                    <th rowspan ="2" style="text-align: center;">CEDULA PROFESIONAL<br>
                        FECHA DE INGRESO<br>
                        TIPO NOMBRAMIENTO<br>
                    </th>
                    <th rowspan ="2" style="text-align: center;">
                        SITUACION ACTUAL<br>
						ESTUDIO DE LICENCIATURA<br>
                        ESTUDIOS COMPLEMENTARIOS<br>
                        (PROFORDEMS, CERTIDEMS, ECODEMS)
                    </th>	
                    <th rowspan ="2" style="text-align: center;">ASIGNATURAS</th>								
                    <th rowspan ="2" style="text-align: center;">HORAS POR <br>ASIG.</th>
                    <th colspan="2" style="text-align: center;">NO. DE GRUPOS </th>
                    <th colspan="3" style="text-align: center;">H/S/M POR SEM. </th>
                    <th rowspan ="2" style="text-align: center;">TOTAL<br> HRS.<br> POR<br> ASIG.</th>
                    <th rowspan ="2" style="text-align: center;">HRS<br> COMPLE-<br>MENTO</th>
                    <th rowspan ="2" style="text-align: center;">HORAS FRENTE<br> A GRUPO<br> HOMOLOGADAS/<br> RECATEGORIZADAS</th>
                    <th rowspan ="2" style="text-align: center;">HORAS DE <br> APOYO A LA<br> DOCENCIA</th>
					<th rowspan ="2" style="text-align: center;">HORAS <br> CB-I<br> Y/O <br> TECNICO CB-I</th>
					<th rowspan ="2" style="text-align: center;">TOTAL<br>HORAS<br>DOCENTE</th>
                </tr>
                <tr>
                    <th style="text-align: center;">MAT.</th>
                    <th style="text-align: center;">VESP.</th>
                    <th style="text-align: center;"><?php if (substr($periodos[0]['CPEPeriodo'],3,1) == '2') { echo '1'; } else { echo '2';} ?></th>
                    <th style="text-align: center;"><?php if (substr($periodos[0]['CPEPeriodo'],3,1) == '2') { echo '3'; } else { echo '4';} ?></th>
                    <th style="text-align: center;"><?php if (substr($periodos[0]['CPEPeriodo'],3,1) == '2') { echo '5'; } else { echo '6';} ?></th>
                </tr>
            </thead>
                <?php 
                $i = 1;
                foreach ($docentes as $d => $listDoc) { ?>
					<tr>
						<td class="text-left"><b><?= $i; ?></b></td> 
						<td class="text-left"> 
							<table style="border:0px" >
								<tr style="border:0px"><td style="border:0px">
									<?= mb_strtoupper($listDoc['UApellido_pat'],'utf-8').' '.mb_strtoupper($listDoc['UApellido_mat'],'utf-8').' '.mb_strtoupper($listDoc['UNombre'],'utf-8');  ?>
								</td></tr>
								<tr style="border:0px"><td style="border:0px">
                            		<?= $listDoc['URFC']; ?>
								</td></tr>
							</table>
                        </td>
						<td class="text-left">
							<table style="border:0px" >
								<tr style="border:0px"><td style="border:0px"><?= nvl($listDoc['estudios'][0]['ULCedulaProf']); ?></td></tr>
								<?php foreach ($listDoc['plazas'] as $p => $listP) { 
									$fechaAnio = explode('-',$listP['UDFecha_ingreso']);
									?>
									<?php if($listP['UDTipo_Nombramiento'] == '4') {
										echo '<tr style="border:0px"><td style="border:0px">'.fecha_format($listP['UDFecha_inicio']).' al '.fecha_format($listP['UDFecha_final']).'</td></tr>'; 
									} elseif($listP['UDTipo_Nombramiento'] == '2') {
										echo '<tr style="border:0px"><td style="border:0px">'.fecha_format($listP['UDFecha_ingreso']).'</td></tr>'; 
									} elseif($listP['UDTipo_Nombramiento'] == '5' || $listP['UDTipo_Nombramiento'] == '8') {
										echo '<tr style="border:0px"><td style="border:0px"></td></tr>'; 
									}
									?>
									<tr style="border:0px"><td style="border:0px"><b>
									<?php if($listP['UDTipo_Nombramiento'] == '2' || $listP['UDTipo_Nombramiento'] == '3') { 
										echo $listP['TPNombre'].' '.$fechaAnio[0]; 
										} elseif ($listP['UDTipo_Nombramiento'] == '1' || $listP['UDTipo_Nombramiento'] == '4') {
										echo $listP['TPNombre']; }?></b>
										</td>
									</tr>
									<tr style="border:0px"><td style="border:0px">
										<?php if ($listP['UDTipo_Nombramiento'] == '5') { 
											echo '<b>'.$listP['UDHoras_CB'].' <b>'.$listP['TPNombre'].'</b> autorizadas del '.fecha_format($listP['UDFecha_inicio']).' al '.fecha_format($listP['UDFecha_final']).' Folio: '.$listP['UDNumOficio'].'</b>';
										} elseif ($listP['UDTipo_Nombramiento'] == '8') {
											echo '<b>'.$listP['UDHoras_CB'].' <b>'.$listP['TPNombre'].'</b> por promoción '.fecha_format($listP['UDFecha_ingreso']).'</b>';
										} else { ?>
										<?= $listP['nomplaza']; ?>
										<?php if ($listP['TotalHoras'] != '0') { 
											echo '('.$listP['TotalHoras'].' Horas)'; 
											if($listP['UDHoras_CB'] != '0' ) { echo ' y '.$listP['UDHoras_CB'].' horas/semana/mes como CB I'; } 
										} else { 
											echo 'con '.$listP['UDHoras_CB'].'  horas/semana/mes'; 
										} }?>
										</td>
									</tr>
								<?php } ?>
							</table>
                        </td> 
						<td>
							<table style="border:0px">
								<tr style="border:0px"><td style="border:0px"><b><?= $listDoc['estudios'][0]['ULTitulado']; ?></b></td></tr>
								<?php foreach ($listDoc['estudios'] as $e => $listEst) { ?>
									<tr style="border:0px"><td style="border:0px"><?= $listEst['ULNivel_estudio'].' en '.$listEst['Licenciatura']; ?></td></tr>
								<?php } ?>
								<tr style="border:0px"><td style="border:0px"><?= nvl($listDoc['plazas'][0]['UDObservaciones']); ?></td></tr>
							</table>
						</td>
						<td class="text-left">
						<table style="border:0px">
							<?php foreach ($listDoc['materias'] as $m => $listMat) { ?>
								<tr style="border:0px"><td style="border:0px"><?= $listMat['materia']; ?></td></tr>
							<?php } ?>
						</table>
						</td>
						<td>
						<table style="border:0px">
							<?php foreach ($listDoc['materias'] as $m => $listMat) { ?>
								<tr style="border:0px"><td style="border:0px; text-align: center;"><?= $listMat['hsm']; ?></td></tr>
							<?php } ?>
						</table>
						</td>
						<td>
						<table style="border:0px">
							<?php foreach ($listDoc['materias'] as $m => $listMat) { ?>
								<tr style="border:0px"><td style="border:0px; text-align: center;"><?= $listMat['pnogrupoMatutino']; ?></td></tr>
							<?php } ?>
						</table>
						</td>
						<td>
						<table style="border:0px">
							<?php foreach ($listDoc['materias'] as $m => $listMat) { ?>
								<tr style="border:0px"><td style="border:0px; text-align: center;"><?= $listMat['pnogrupoVespertino']; ?></td></tr>
							<?php } ?>
						</table>
						</td>
                        <td>
						<table style="border:0px">
							<?php foreach ($listDoc['materias'] as $m => $listMat) { 
								if ($listMat['psemestre'] == '1' || $listMat['psemestre'] == '2') { ?>
								<tr style="border:0px"><td style="border:0px; text-align: center;"><?= $listMat['ptotalHoras']; ?></td></tr>
								<?php } else { ?>
								<tr style="border:0px"><td style="border:0px">&nbsp;</td></tr>
							<?php } } ?>
						</table>
						</td>
                        <td>
						<table style="border:0px">
							<?php foreach ($listDoc['materias'] as $m => $listMat) { 
								if ($listMat['psemestre'] == '3' || $listMat['psemestre'] == '4') { ?>
								<tr style="border:0px"><td style="border:0px; text-align: center;"><?= $listMat['ptotalHoras']; ?></td></tr>
							<?php } else { ?>
								<tr style="border:0px"><td style="border:0px">&nbsp;</td></tr>
							<?php } } ?>
						</table>
						</td>
                        <td>
						<table style="border:0px">
							<?php foreach ($listDoc['materias'] as $m => $listMat) { 
								if ($listMat['psemestre'] == '5' || $listMat['psemestre'] == '6') { ?>
								<tr style="border:0px"><td style="border:0px; text-align: center;"><?= $listMat['ptotalHoras']; ?></td></tr>
								<?php } else { ?>
								<tr style="border:0px"><td style="border:0px">&nbsp;</td></tr>
							<?php } } ?>
						</table>
						</td>
						<td>
						<table style="border:0px">
							<?php foreach ($listDoc['materias'] as $m => $listMat) { ?>
								<tr style="border:0px"><td style="border:0px; text-align: center;"><?= $listMat['ptotalHoras']; ?></td></tr>
							<?php } ?>
						</table>
						</td>
						<td>
						<table style="border:0px">

						</table>
						</td>
						<td>
						<table style="border:0px">
							<?php foreach ($listDoc['horas'] as $h => $listHor) { ?>
								<tr style="border:0px"><td style="border:0px; text-align: center;"><?= $listHor['UDHoras_grupo']; ?></td></tr>								
							<?php } ?>					
						</table>
						</td>
						<td>
						<table style="border:0px">
							<?php foreach ($listDoc['horas'] as $h => $listHor) { ?>
								<tr style="border:0px"><td style="border:0px; text-align: center;"><?= $listHor['UDHoras_apoyo']; ?></td></tr>								
							<?php } ?>	
						</table>
						</td>
						<td>
						<table style="border:0px">
							<?php foreach ($listDoc['horas'] as $h => $listHor) { 
								$totalCB = 0;
								$totalCB = $listHor['UDHoras_CB'] + $listHor['UDHoras_provicionales'];
								} ?>	
								<tr style="border:0px"><td style="border:0px; text-align: center;"><?= $totalCB; ?></td></tr>
						</table>
						</td>
						<td>
						<table style="border:0px">
								<tr style="border:0px"><td style="border:0px; text-align: center;"><?= $listHor['UDHoras_grupo'] + $listHor['UDHoras_apoyo'] + $totalCB; ?></td></tr>
						</table>
						</td>
					</tr>
                <?php $i++; } ?>
			</table>
		</div>
	</form>
</div>

<style type="text/css" media="print,screen">
table{
	width : 100%;
	color: #000;
	font-size:11px;
	font-family: "Ebrima";
}
th, td{
    border:1pt solid #9c9c9c;
    -border-collapse:collapse;
    padding: 0px 3px;
}
.no-border{
	border:none;
	font-size:3px;
}

.no-content{
	font-size:3px;
}

.text-left{
    text-align: left;
}
.text-center{
    text-align: center;
}

.text-right{
    text-align: right;
}

.text-justify {
    text-align: justify;
}

.firmas{
	line-height: 1.2;
	height:80px;
	vertical-align: bottom;
	padding: 3px 3px;
}

.firma_c, .firma_h, .firma_f, .firma_d {
	width: 35mm;
    position: absolute;
}

.firma_c{
	margin: -45px -55px;
}

.firma_h{
	margin: -30px -65px;
}

.firma_f{
	margin: -175px -55px;
}

.firma_d{
	margin: -25px -55px;
}

.firma_a{
	font-size: 16px;
	color: green;
}


.texto{
	font-size: 7px;
}

.titulo1{
	font-size: 16px;
	background: #c2c2c2;
}
.titulo2{
	font-size: 11px;
	background: #c2c2c2;
}
th{
	background: #eaeaea;
}

@media print {
	.titulo1{
		background: #c2c2c2 !important;
	}
	.titulo2{
		background: #c2c2c2 !important;
	}
	th{
		background: #eaeaea !important;
	}
}

</style>