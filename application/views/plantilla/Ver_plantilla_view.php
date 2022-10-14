<div class="table-responsive">
	<form action="<?php echo base_url("generarplantilla/validar"); ?>" name="formValidar" id="formValidar" method="POST" class="wizard-big form-vertical">
		<div class="col-lg-12">
			<input type="hidden" name="idPlantel" id="idPlantel" value="<?php echo $plantel[0]['CPLClave']; ?>">
			<!--<table>
				<tr>
					<td rowspan="2" class="no-border text-left"><img src="<?=base_url("assets/img/logo_edomex.png")?>" width="100px" alt="" /></td>
					<td class="no-border text-center">&nbsp;</td>
					<td rowspan="2" width="150px" class="no-border text-right"><img src="<?=base_url("assets/img/$FLogo_cobaemex")?>" width="100%" alt="" /></td>
				</tr>
			</table>-->
			<table>
				<tr>
					<td rowspan="2" class="no-border text-left" style="font-size: 12px">
						COLEGIO DE BACHILLERES DEL ESTADO DE MÉXICO<br>
						DIRECCIÓN ACADÉMICA<br>
						DEPARTAMENTO DE DOCENCIA Y ORIENTACIÓN EDUCATIVA<br>
						PLANTILLA DE PERSONAL DOCENTE<br>
						PLANTEL Y/O CENTRO EMSAD: <b><?php echo $plantel[0]['CPLNombre']; ?></b> <br>
						SEMESTRE:<b> 20<?= substr($periodos['CPEPeriodo'],0,2); ?> <?= substr($periodos['CPEPeriodo'],3,1) == 1? '(Febrero-Agosto)' : '(Agosto-Febrero)'?></b><br>
						FECHA: <b><?php echo date('d/m/Y'); ?></b> <br>
					</td>
				</tr>
			</table><br>

			<table class="table table-striped table-bordered table-hover dataTables-example" id="Exportar_a_Excel">
				<thead>
                <tr>
                    <th rowspan ="2" style="text-align: center; vertical-align: middle;">No</th>
                    <th rowspan ="2" style="text-align: center; vertical-align: middle;">
                        NOMBRE DEL DOCENTE<br>
                        R.F.C. CON HOMOCLAVE
                    </th>
                    <th rowspan ="2" style="text-align: center; vertical-align: middle;">CEDULA PROFESIONAL<br>
                        FECHA DE INGRESO<br>
                        TIPO NOMBRAMIENTO<br>
                    </th>
                    <th rowspan ="2" style="text-align: center; vertical-align: middle;">
                        SITUACION ACTUAL<br>
						ESTUDIO DE LICENCIATURA<br>
                        ESTUDIOS COMPLEMENTARIOS<br>
                        (PROFORDEMS, CERTIDEMS, ECODEMS)
                    </th>	
                    <th rowspan ="2" style="text-align: center; vertical-align: middle;">ASIGNATURAS</th>								
                    <th rowspan ="2" style="text-align: center; vertical-align: middle;">HORAS POR <br>ASIG.</th>
                    <th colspan="2" style="text-align: center; vertical-align: middle;">NO. DE GRUPOS </th>
                    <th colspan="3" style="text-align: center; vertical-align: middle;">H/S/M POR SEM. </th>
                    <th rowspan ="2" style="text-align: center; vertical-align: middle;">TOTAL<br> HRS.<br> POR<br> ASIG.</th>
                    <th rowspan ="2" style="text-align: center; vertical-align: middle;">HRS<br> COMPLE-<br>MENTO</th>
                    <th rowspan ="2" style="text-align: center; vertical-align: middle;">HORAS FRENTE<br> A GRUPO<br> HOMOLOGADAS/<br> RECATEGORIZADAS</th>
                    <th rowspan ="2" style="text-align: center; vertical-align: middle;">HORAS DE <br> APOYO A LA<br> DOCENCIA</th>
					<th rowspan ="2" style="text-align: center; vertical-align: middle;">HORAS <br> CB-I<br> Y/O <br> TECNICO CB-I</th>
					<th rowspan ="2" style="text-align: center; vertical-align: middle;">TOTAL<br>HORAS<br>DOCENTE</th>
					<?php if( is_permitido(null,'generarplantilla','validar') ) { ?>
					<th rowspan ="2" style="text-align: center; vertical-align: middle;">OBSERVACIONES</th>
					<?php } ?>
					<?php if( is_permitido(null,'generarplantilla','revisarPlantilla') ) { ?>
					<th rowspan ="2" style="text-align: center; vertical-align: middle;"><label><input type="checkbox" class="opcion" id="selectall" value=""/>Todos</label> </th>
					<?php } ?>

                </tr>
                <tr>
                    <th style="text-align: center;">MAT.</th>
                    <th style="text-align: center;">VESP.</th>
                    <th style="text-align: center;"><?php if (substr($periodos['CPEPeriodo'],3,1) == '2') { echo '1'; } else { echo '2';} ?></th>
                    <th style="text-align: center;"><?php if (substr($periodos['CPEPeriodo'],3,1) == '2') { echo '3'; } else { echo '4';} ?></th>
                    <th style="text-align: center;"><?php if (substr($periodos['CPEPeriodo'],3,1) == '2') { echo '5'; } else { echo '6';} ?></th>
                </tr>
            	</thead>
                <?php 
                $i = 1;
                foreach ($docentes as $d => $listDoc) { 
				$idPlantel = $this->encrypt->encode($listDoc['UDPlantel']); ?>
				
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
								<tr style="border:0px"><td style="border:0px"><b><?= nvl($listDoc['estudios'][0]['ULTitulado']); ?></b></td></tr>
								<?php foreach ($listDoc['estudios'] as $e => $listEst) { ?>
									<tr style="border:0px"><td style="border:0px"><?= nvl($listEst['ULNivel_estudio']).' en '.nvl($listEst['Licenciatura']); ?></td></tr>
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
						<td class="text-center">
						<table style="border:0px">
								<tr style="border:0px"><td style="border:0px; text-align: center;"><?= $listHor['UDHoras_grupo'] + $listHor['UDHoras_apoyo'] + $totalCB; ?></td></tr>
						</table>
						</td>
						<?php if( is_permitido(null,'generarplantilla','validar') ) { ?>
						<td>
							<table style="border:0px">
							<tr style="border:0px">
								<td style="border:0px; text-align: center;" >
								<input type="checkbox" class="checkshow<?= $listDoc['UDClave']; ?>" name="idUDClave[]" value="<?= $listDoc['UDClave']; ?>">
								<div class="div_a_mostrar<?= $listDoc['UDClave']; ?>">
									<textarea name="pObservaciones[]" id="pObservaciones<?= $listDoc['UDClave']; ?>" rows="5" cols="30" ></textarea>
								</div>
								</td>
							</tr>								
							</table>
						</td>
						<?php } ?>
						<?php if( is_permitido(null,'generarplantilla','save') ) { ?>
						<td>
							<table style="border:0px">
								<tr style="border:0px"><td style="border:0px; text-align: center;" >
									<input type="checkbox" class="opcion" name="opcion[]" value="<?= $listDoc['UDClave']; ?>" />
									<!--<input type="checkbox" class="opcion" name="idPlantilla[]" id="idPlantilla" >-->					
								</td></tr>								
							</table>
						</td>
						<?php } ?>
					</tr>
					<script>
						$(function() {
						// obtener campos ocultar div
						var checkbox = $(".checkshow<?= $listDoc['UDClave']; ?>");
						var hidden = $(".div_a_mostrar<?= $listDoc['UDClave']; ?>");
						//var populate = $("#populate");
							
						hidden.hide();
							checkbox.change(function() {
								if (checkbox.is(':checked')) {
								//hidden.show();
									$(".div_a_mostrar<?= $listDoc['UDClave']; ?>").fadeIn("200")
								} else {
									//hidden.hide();
									$(".div_a_mostrar<?= $listDoc['UDClave']; ?>").fadeOut("200")
									$("#pObservaciones<?= $listDoc['UDClave']; ?>").val(""); // limpia los valores de lols input al ser ocultado
									//$('input[type=checkbox]').prop('checked',false);// limpia los valores de checkbox al ser ocultado
									
							}
						});
						});
					</script>
					<?php $i++; } ?>
					<tr>
						<td colspan="5" class="text-center">
							TOTALDE HORAS POR ASIGNATURA, GRUPOS, H/S/M POR SEMESTRE Y HORAS TOTALES
						</td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
					</tr>
			</table>
		</div>
	</form>
</div>

<div class="loadingRevision"></div>
<div id="resultRevision"></div>
<div id="errorRevision"></div>

<br><br>

<?php if (is_permitido(null,'generarplantilla','revisarPlantilla')) { ?>
<div class="form-group">
	<div class="col-lg-1"></div>
	<div class="col-lg-10">
		<button class="btn btn-primary btn-rounded btn-block revision pull-center" type="button"> <i class="fa fa-eye"></i> Mandar a Revisón</button>
	</div>
</div>
<?php } ?>

<?php if( is_permitido(null,'generarplantilla','validar') ) { ?>
	<div class="form-group">
	<div class="col-lg-1"></div>
	<div class="col-lg-10">
		<button class="btn btn-primary btn-rounded btn-block save_rechazar pull-center enviarCorrecciones" type="button"> <i class="fa fa-exchange"></i> Enviar Correcciones</button>
	</div>
</div>
<?php } ?>

<!--<form action="<?= base_url("generarplantilla/exportarExcel")?>" method="post" target="_blank" id="FormularioExportacion">
<button class="btn btn-primary btn-rounded btn-block botonExcel pull-center" type="button"> <i class="fa fa-save"></i> Exportar Excel</button>
	<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>-->

<script>
$(document).ready(function() {

	$(".revision").click(function() {
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
						$("#resultRevision").empty();
						$("#resultRevision").html(data[0]);
						$(".loadingRevision").html('');
						$("#errorRevision").html('');
						verPlantilla(data[2]);
						//location.href ='<?php echo base_url("generarplantilla/crear/$idPlantel"); ?>';
					} else {
						$("#errorRevision").empty();
                   		$("#errorRevision").append(data);
                    	$(".loadingRevision").html("");
				}
			}
		});
	});

	$(".enviarCorrecciones").click(function() {
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
						$("#resultRevision").empty();
						$("#resultRevision").html(data[0]);
						$(".loadingRevision").html('');
						verPlantilla(data[2]);
						//location.href ='<?php echo base_url("generarplantilla/crear/$idPlantel"); ?>';
					} else {
						$("#errorRevision").empty();
                   		$("#errorRevision").append(data);
                    	$(".loadingRevision").html("");
				}
			}
		});
	});

	$(".botonExcel").click(function(event) {
		$("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
		$("#FormularioExportacion").submit();
	});
});

	$("#selectall").on("click", function() {
        $(".opcion").prop("checked", this.checked);
    });

    // if all checkbox are selected, check the selectall checkbox and viceversa
    $(".opcion").on("click", function() {
    if ($(".opcion").length == $(".opcion:checked").length) {
        $("#selectall").prop("checked", true);
    } else {
        $("#selectall").prop("checked", false);
    }
    });
</script>

<!--small chat box-->