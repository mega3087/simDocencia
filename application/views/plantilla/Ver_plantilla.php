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
                        NOMBRE DEL DOCENTE<br><br><br>
                        R.F.C. CON HOMOCLAVE
                    </th>
                    <th rowspan ="2" style="text-align: center;">CEDULA PROFESIONAL<br>
                        FECHA DE INGRESO<br>
                        TIPO NOMBRAMIENTO<br>
                    </th>
                    <th rowspan ="2" style="text-align: center;">ESTUDIO DE LICENCIATURA<br>
                        SITUACION ACTUAL<br>
                        ESTUDIOS COMPLEMENTARIOS<br>
                        (PROFORDEMS, CERTIDEMS, ECODEMS)
                    </th>	
                    <th rowspan ="2" style="text-align: center;">ASIGNATURAS</th>								
                    <th rowspan ="2" style="text-align: center;">HORAS POR <br>ASIG.</th>
                    <th colspan="2" style="text-align: center;">NO. DE GRUPOS </th>
                    <th colspan="3" style="text-align: center;">H/S/M POR SEM. </th>
                    <th rowspan ="2" style="text-align: center;">TOTAL<br> HRS.<br> POR<br> ASIG.</th>
                    <th rowspan ="2" style="text-align: center;">HRS<br> COMPLEMENTO</th>
                    <th rowspan ="2" style="text-align: center;">HORAS FRENTE<br> A GRUPO<br> HOMOLOGADAS/<br> RECATEGORIZADAS</th>
                    <th rowspan ="2" style="text-align: center;">HORAS DE <br> APOYO A LA<br> DOCENCIA</th>
					<th rowspan ="2" style="text-align: center;">HORAS <br> CB-I<br> Y/O <br> TECNICO CB-I</th>
					<th rowspan ="2" style="text-align: center;">TOTAL<br>HORAS<br>DOCENTE</th>
                </tr>
                <tr>
                    <th style="text-align: center;">MAT.</th>
                    <th style="text-align: center;">VESP.</th>
                    <th style="text-align: center;"><?php if (substr($periodos[0]['CPEPeriodo'],3,1) == '2') { echo '1 SEM.'; } else { echo '2 SEM.';} ?></th>
                    <th style="text-align: center;"><?php if (substr($periodos[0]['CPEPeriodo'],3,1) == '2') { echo '3 SEM.'; } else { echo '4 SEM.';} ?></th>
                    <th style="text-align: center;"><?php if (substr($periodos[0]['CPEPeriodo'],3,1) == '2') { echo '5 SEM.'; } else { echo '6 SEM.';} ?></th>
                </tr>
            </thead>
                <?php 
                $i = 1;
                foreach ($docentes as $d => $listDoc) { ?>
					<tr>
						<td class="text-left"><b><?= $i; ?></b></td> 
						<td class="text-left"> 
                            <?= $listDoc['UApellido_pat'].' '.$listDoc['UApellido_mat'].' '.$listDoc['UNombre'];  ?><br>
                            <?= $listDoc['URFC']; ?>
                        </td>
						<td class="text-left">
                        <?php foreach ($listDoc['plazas'] as $p => $listP) { ?>
                            <?= $listDoc['ULCedulaProf']; ?><br>
                            <?php if($listDoc['UDTipo_Nombramiento'] == '4'){
                                echo fecha_format($listP['UDFecha_inicio']).' al '.fecha_format($listP['UDFecha_final']); 
                            } else {
                                echo fecha_format($listP['UDFecha_ingreso']); 
                            }
                            ?><br>
                            <b><?= $listP['TPNombre']; ?></b><br>
                            <?= $listP['nomplaza']; ?><?php if ($listP['TotalHoras'] != '0') { 
                                    echo '('.$listP['TotalHoras'].' Horas)'; 
                                } else { 
                                    echo 'con '.$listP['UDHoras_adicionales'].'  horas/semana/mes'; 
                                } ?><br>
                        <?php } ?>
                        </td> 
						<td class="text-left">
                            * Estudios<br>
							<b>TITULADO</b>
							**Mas estudios
						</td>
						<td class="text-left">
						<table>
							materiass<br>
						</table>
						</td>
						<td>
						<table>
							HorasAsignadas<br>
						</table>
						</td>
						<td>
						<table>
							GPGrupoMatutino<br>
						</table>
						</td>
						<td>
						<table>
							GrupoVespertino<br>
						</table>
						</td>
                        <td>
						<table>
                            1<br>
						</table>
						</td>
                        <td>
						<table>
                            2<br>
						</table>
						</td>
                        <td>
						<table>
                            3<br>
						</table>
						</td>
						<td>
						<table>
                            TotalAsignar<br>
						</table>
						</td>
						<td>
						<table>
							Horas complemento
						</table>
						</td>
						<td>
						<table>
						    Horas Frente a Grupo							
						</table>
						</td>
						<td>
						<table>
						    Hora Apoyo
						</table>
						</td>
						<td>
						<table>
						    Horas CB I
						</table>
						</td>
						<td>
						<table>
                            Total Horas
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
	font-size:9px;
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