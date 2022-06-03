 <div class="content rounded-">
	<table class="texto">
		<tr>
			<td rowspan="2" class="no-border text-left"><img src="./assets/img/logo_edomex.png"" width="100px" alt="" /></td>
			<td class="no-border text-center">&nbsp;</td>
			<td rowspan="2" width="150px" class="no-border text-right"><img src="./assets/img/<?=$FLogo_cobaemex?>" width="100%" alt="" /></td>
		</tr>
		<tr>
			<td width="145px" height="10px;" class="text-center" style="line-height: 1.2;">
				VIGENCIA <br />
				<b><?=fecha_format(nvl($FFecha_inicio))?> - <b class="text-danger">F<?=folio($FClave)?></b>
			</td>
		</tr>
		<tr>
			<th class="text-center titulo1" colspan="3">FORMATO ÚNICO DE MOVIMIENTOS DE PERSONAL (FUMP)</th>
		</tr>
	</table>
	<table class="texto">
		<tr>
			<td class="no-border">&nbsp;</td>
		</tr>
		<tr>
			<th width="110px" rowspan="2" class="text-center titulo2">
				ADSCRIPCIÓN
			</th>
			<td width="10px" rowspan="2"></td>
			<td width="170px" >DIRECCIÓN DE ÁREA / PLANTEL / EMSAD:</td>
			<th><?=nvl($FPlantel)?></th>
			<td>E-MAIL:</td>
			<th><?=nvl($FCorreo_electronico_plantel)?></th>
		</tr>
		<tr>
			<td>DEPARTAMENTO:</td>
			<th colspan="3"><?=nvl($FDepartamento)?></th>
		</tr>
	</table>
	<table class="texto">
		<tr>
			<td class="no-border">&nbsp;</td>
		</tr>
		<tr>
			<th width="110px" rowspan="6" class="text-center titulo2">
				DATOS GENERALES DEL SERVIDOR PÚBLICO
			</th>
			<td width="10px" rowspan="6"></td>
			<td width="210px" colspan="2">NOMBRE(S) / PATERNO / MATERNO:</td>
			<th colspan="3" class="text-left"><?=nvl($FNombre)?> <?=nvl($FApellido_pat)?> <?=nvl($FApellido_mat)?></th>
			<td width="80px">CLAVE ISSEMYM:</td>
			<th colspan="2" class="text-center"><?=nvl($FISSEMYM)?></th>
		</tr>
		<tr>
			<td>FECHA DE NACIMIENTO:</td>
			<th class="text-center"><?=fecha_format(nvl($FFecha_nacimiento))?></th>
			<td class="text-center">R.F.C.:</td>
			<th class="text-center"><?=nvl($FRFC)?></th>
			<td>CURP.:</td>
			<th colspan="3" class="text-center"><?=nvl($FCURP)?></th>
		</tr>
		<tr>
			<td>DOMICILIO:</td>
			<th colspan="3"><?=nvl($FDomicilio)?></th>
			<td>COLONIA:</td>
			<th colspan="3"><?=nvl($FColonia)?></th>
		</tr>
		<tr>
			<td>MUNICIPIO:</td>
			<th><?=nvl($FMunicipio)?></th>
			<td>C.P:</td>
			<th><?=nvl($FCP)?></th>
			<td>TEL. MOVIL:</td>
			<th><?=nvl($FTelefono_movil)?></th>
			<td>TEL. CASA:</td>
			<th><?=nvl($FTelefono_casa)?></th>
		</tr>
		<tr>
			<td>LUGAR DE NACIMIENTO:</td>
			<th colspan="4"><?=nvl($FLugar_nacimiento)?></th>
			<td>ESTADO CIVIL:</td>
			<th colspan="2"><?=nvl($FEstado_civil)?></th>
		</tr>
		<tr>
			<td>ESCOLARIDAD:</td>
			<th colspan="4"><?=nvl($FEscolaridad)?></th>
			<td class="text-center">E-MAIL:</td>
			<th colspan="2"><?=nvl($FCorreo_electronico_servidor)?></th>
		</tr>
	</table>
	<table class="texto">
		<tr>
			<td class="no-border">&nbsp;<?php $FTramite = explode(";",nvl($FTramite)); ?></td>
		</tr>
		<tr>
			<th width="110px" rowspan="3" class="text-center titulo2">
				TRÁMITE
			</th>
			<td width="10px" rowspan="3"></td>
			<th width="20px" class="text-center"><?php if( in_array("ALTA", $FTramite) ) echo"x"; else echo"&nbsp;"; ?></th>
			<td width="40px">ALTA</td>
			<th width="20px" class="text-center"><?php if( in_array("INTERINATO", $FTramite) ) echo"x"; else echo"&nbsp;"; ?></th>
			<td width="200px">INTERINATO</td>
			<th width="20px" class="text-center"><?php if( in_array("INCREMENTO/DISMINUCIÓN DE HRS. CLASE", $FTramite) ) echo"x"; else echo"&nbsp;"; ?></th>
			<td width="265px" colspan="2">INCREMENTO/DISMINUCIÓN DE HRS. CLASE</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td></td>
			<th class="text-center"><?php if( in_array("LICENCIA SIN GOCE DE SUELDO", $FTramite) ) echo"x"; else echo"&nbsp;"; ?></th>
			<td>LICENCIA SIN GOCE DE SUELDO</td>
			<th class="text-center"><?php if( in_array("CAMBIO DE ADSCRIPCIÓN", $FTramite) ) echo"x"; else echo"&nbsp;"; ?></th>
			<td colspan="2">CAMBIO DE ADSCRIPCIÓN</td>
		</tr>
		<tr>
			<th class="text-center"><?php if( in_array("BAJA", $FTramite) ) echo"x"; else echo"&nbsp;"; ?></th>
			<td>BAJA</td>
			<th class="text-center"><?php if( in_array("CAMBIO DE PLAZA", $FTramite) ) echo"x"; else echo"&nbsp;"; ?></th>
			<td>CAMBIO DE PLAZA</td>
			<th class="text-center"><?php if( in_array("OTRO", $FTramite) or in_array("RENUNCIA A GRATIFICACIÓN BUROCRATICA", $FTramite) ) echo"x"; else echo"&nbsp;"; ?></th>
			<td width="65" class="text-center">OTRO</td>
			<th width="200px" class="salto"><?=nvl($FTramite_otro)?><?php if( $FTramite_otro and in_array("RENUNCIA A GRATIFICACIÓN BUROCRATICA", $FTramite) ) echo " - "; if( in_array("RENUNCIA A GRATIFICACIÓN BUROCRATICA", $FTramite) ) echo"RENUNCIA A GRATIFICACIÓN BUROCRATICA"; ?></th>
		</tr>
	</table>
	<table class="texto">
		<tr>
			<td class="no-border">&nbsp;
			</td>
		</tr>
		<tr>
			<th width="110px" rowspan="9" class="text-center titulo2">
				DATOS DE LA PLAZA
			</th>
			<td width="10px" rowspan="9"></td>
			<td width="98px" colspan="2" class="text-center">CLAVE DE EMPLEADO:</td>
			<th colspan="2" class="text-center"><?=nvl($FClave_servidor)?></th>
			<td width="10px" rowspan="4">&nbsp;</td>
			<td width="90px" colspan="2">TIPO DE HORAS-CLASE:</td>
			<td width="65px" class="text-right">PROFE CB-I</td>
			<th width="20px" class="text-center"><?php if( nvl($FTipo_horas_clase) == "PROFE CB-I" ) echo"x"; else echo"&nbsp;"; ?></th>
			<td width="120px" class="text-right">TÉCNICO CB-I</td>
			<th width="20px" class="text-center"><?php if( nvl($FTipo_horas_clase) == "TÉCNICO CB-I" ) echo"x"; else echo"&nbsp;"; ?></th>
		</tr>
		<tr>
			<td colspan="2" rowspan="3">TIPO DE PLAZA:</td>
			<td width="100px">ADMINSTRATIVO</td>
			<th width="20px" class="text-center"><?php if( nvl($FTipo_plaza) == "ADMINSTRATIVO" ) echo"x"; else echo"&nbsp;"; ?></th>
			<td colspan="2">TIPO DE ASIGNATURA:</td>
			<td class="text-right">CURRICULARES</td>
			<th width="20px" class="text-center"><?php if( nvl($FTipo_asignatura) == "CURRICULARES" ) echo"x"; else echo"&nbsp;"; ?></th>
			<td class="text-right">COCURRICULARES</td>
			<th width="20px" class="text-center"><?php if( nvl($FTipo_asignatura) == "COCURRICULARES" ) echo"x"; else echo"&nbsp;"; ?></th>
		</tr>
		<tr>
			<td>ACADÉMICO</td>
			<th width="20px" class="text-center"><?php if( $FTipo_plaza == "ACADÉMICO" ) echo"x"; else echo"&nbsp;"; ?></th>
			<td colspan="3">No. DE HRS. QUE INCREMENTA:</td>
			<th class="text-center"><?=nvl($FHoras_incrementa)?></th>
			<td class="text-right">No. DE HRS. QUE DISMINUYE:</td>
			<th class="text-center"><?=nvl($FHoras_disminuye)?></th>
		</tr>
		<tr>
			<td>DIRECTIVO O CONFIANZA</td>
			<th width="20px" class="text-center"><?php if( $FTipo_plaza == "DIRECTIVO O CONFIANZA" ) echo"x"; else echo"&nbsp;"; ?></th>
			<td colspan="3">No. HORAS-CLASE TOTALES:</td>
			<th class="text-center"><?=nvl($FHoras_clase_totales)?></th>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td colspan="11">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">TIPO DE PLAZA:</td>
			<td class="text-right">JORNADA 1/2 TIEMPO</td>
			<th class="text-center"><?php if(nvl($FTipo_jornada) == "JORNADA 1/2 TIEMPO") echo"x"; else echo"&nbsp;"; ?></th>
			<td colspan="4" class="text-right">JORNADA 3/4 DE TIEMPO</td>
			<th class="text-center"><?php if($FTipo_jornada == "JORNADA 3/4 DE TIEMPO") echo"x"; else echo"&nbsp;"; ?></th>
			<td class="text-right">JORNADA TIEMPO COMP.</td>
			<th class="text-center"><?php if($FTipo_jornada == "JORNADA TIEMPO COMP.") echo"x"; else echo"&nbsp;"; ?></th>
		</tr>
		<tr>
			<td colspan="2">NÚM. DE HRS. EXTRAS:</td>
			<td>TÉCNICO CB-I</td>
			<th class="text-center"><?=nvl($FExtra_tecnico_cbi)?></th>
			<td width="60px" colspan="2">PROFE CB-I</td>
			<th class="text-center"><?=nvl($FExtra_profe_cbi)?></th>
			<td>PROFE CB-II</td>
			<th class="text-center"><?=nvl($FExtra_profe_cbii)?></th>
			<td>PROFE CB-III</td>
			<th class="text-center"><?=nvl($FExtra_profe_cbiii)?></th>
		</tr>
		<tr>
			<td colspan="4">NÚM. DE HRS. POR RECATEGORIZACIÓN A:</td>
			<td colspan="2">TÉCNICO CB-II</td>
			<th class="text-center"><?=nvl($FRecate_tecnico_cbii)?></th>
			<td>PROFE CB-II</td>
			<th class="text-center"><?=nvl($FRecate_profe_cbii)?></th>
			<td>PROFE CB-III</td>
			<th class="text-center"><?=nvl($FRecate_profe_cbiii)?></th>
		</tr>
		<tr>
			<td><b>VIGENCIA:</b></td>
			<td><b>DEL:</b></td>
			<th class="text-center"><?=fecha_format(nvl($FFecha_inicio))?></th>
			<td class="text-center"><b>AL:</b></td>
			<th class="text-center" colspan="3"><?=fecha_format(nvl($FFecha_termino))?></th>
			<td><b>NOMBRE DE LA PLAZA:</b></td>
			<th class="text-center" colspan="3"><?=nvl($FNombre_plaza)?></th>
		</tr>
	</table>
	<table class="texto">
		<tr>
		<td colspan="8" class="no-border">&nbsp;</td>
		</tr>
		<tr>
			<th colspan="3" class="text-center titulo2" width="300px">PERCEPCIONES</th>
			<th colspan="5" class="text-center titulo2" width="300px">DEDUCCIONES</th>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="text-right"><b>ADMVO</b></td>
			<th class="text-center" width="20px"><?php if(nvl($FTipo_plaza) != "ACADÉMICO") echo"x"; else echo"&nbsp;"; ?></th>
			<td class="text-right"><b>JORNADA</b></td>
			<th class="text-center" width="20px"><?php if(nvl($FTipo_jornada)) echo"x"; else echo"&nbsp;"; ?></th>
			<td colspan="3"></td>
		</tr>
		<tr>
			<td class="text-center" width="150px">CONCEPTO</td>
			<td colspan="2" width="120px"></td>
			<td colspan="2" class="text-center" width="150px">CONCEPTO</td>
			<td class="text-center" width="60px">CLAVE</td>
			<td colspan="2"  width="120px">IMPORTE</td>
		</tr>
		<tr>
			<td>SUELDO BASE</td>
			<th colspan="2" class="text-right"><?php if($FSueldo_base_adm > 0) echo number_format($FSueldo_base_adm,2); ?></th>
			<td colspan="2">I.S.R.</td>
			<td>0001</td>
			<th colspan="2" class="text-center">DE ACUERDO A</th>
		</tr>
		<tr>
			<td>GRATIF. BUROCRATA</td>
			<th colspan="2" class="text-right"><?php if($FGratificacion_adm > 0) echo number_format($FGratificacion_adm,2); ?></th>
			<td colspan="2">SUBSIDIO PARA EL EMPLEO</td>
			<td>0099</td>
			<th colspan="2" class="text-center">LA LEY DE I.S.R.</th>
		</tr>
		<?php
			$issemim46 = nvl($FTotal_bruto_adm)*.04625;
			$issemim61 = $FTotal_bruto_adm*.06100;
			$issemim14 = $FTotal_bruto_adm*.01400;
			if($FISSEMYM >=1 && $FISSEMYM <=600000 && !nvl($FISSEMYM14)){
				$issemim14 = 0;
			}
			$issemim1  = $issemim46+$issemim61+$issemim14;
			
			if(!$FTotal_bruto_adm and !$FTotal_bruto3 ){
				if($FTipo_horas_clase=="PROFE CB-I"){
					$FExtra_profe_cbii = "x";
				}
			}
		?>
		<tr>
			<td>MATERIAL DIDÁCTITO</td>
			<th colspan="2" class="text-right"><?php if($FMaterial_dicactico_adm > 0) echo number_format($FMaterial_dicactico_adm,2); ?></th>
			<td colspan="2">% 4.625 ISSEMYM</td>
			<td>5540</td>
			<th colspan="2" class="text-right"><?=@number_format($issemim46,2)?></th>
		</tr>
		<tr>
			<td>DESPENSA</td>
			<th colspan="2" class="text-right"><?php if($FDespensa_adm > 0) echo number_format($FDespensa_adm,2); ?></th>
			<td colspan="2">% 6.1 ISSEMYM</td>
			<td>5541</td>
			<th colspan="2" class="text-right"><?=@number_format($issemim61,2)?></th>
		</tr>
		<tr>
			<td>EFICIENCIA EN EL TRABAJO</td>
			<th colspan="2" class="text-right"><?php if($FEficiencia_adm > 0) echo number_format($FEficiencia_adm,2); ?></th>
			<td colspan="2">% 1.4 ISSEMYM</td>
			<td>5542</td>
			<th colspan="2" class="text-right"><?=@number_format($issemim14,2)?></th>
		</tr>
		<tr>
			<td class="text-right"><b>SUBTOTAL</b></td>
			<td colspan="2"><b><div class="pull-right">$ <?php if ($FTotal_bruto_adm > 0) echo number_format($FTotal_bruto_adm,2); else echo "-"; ?></div></b></td>
			<td colspan="3" class="text-right"><b>SUBTOTAL</b></td>
			<td colspan="2"><b><div class="pull-right">$ <?php if ($issemim1 > 0) echo number_format($issemim1,2); else echo "-"; ?></div></b></td>
		</tr>
		<tr><td colspan="8" class="no-content">&nbsp;</td></tr>
		<tr>
			<td>&nbsp;</td>
			<td class="text-right"><b>PROFE CB-III</b></td>
			<th class="text-center" width="20px"><?php if($FExtra_profe_cbiii or $FRecate_profe_cbiii) echo "x"; else echo"&nbsp;"; ?></th>
			<td class="text-right"><b>PROFE CB-II</b></td>
			<th class="text-center" width="20px"><?php if($FExtra_profe_cbii or $FRecate_profe_cbii) echo "x"; else echo"&nbsp;"; ?></th>
			<td colspan="2" class="text-right"><b>TECNI CB-II</b></td>
			<th class="text-center" width="20px"><?php if($FRecate_tecnico_cbii) echo "x"; else echo"&nbsp;"; ?></th>
		</tr>
		<tr>
			<td class="text-center">CONCEPTO</td>
			<td colspan="2" class="text-right"></td>
			<td colspan="2" class="text-center">CONCEPTO</td>
			<td class="text-center">CLAVE</td>
			<td colspan="2">IMPORTE</td>
		</tr>
		<?php
			$issemim46 = nvl($FTotal_bruto2)*.04625;
			$issemim61 = $FTotal_bruto2*.06100;
			$issemim14 = $FTotal_bruto2*.01400;
			if($FISSEMYM >=1 && $FISSEMYM <=600000 && !nvl($FISSEMYM14)){
				$issemim14 = 0;
			}
			$issemim2  = $issemim46+$issemim61+$issemim14;
			
			if(!$FTotal_bruto_adm and !$FTotal_bruto2 ){
				if($FTipo_horas_clase=="PROFE CB-I"){
					$FExtra_profe_cbi = "x";
				}elseif($FTipo_horas_clase=="TÉCNICO CB-I"){
					$FExtra_tecnico_cbi = "x";
				}
			}
		?>
		<tr>
			<td>SUELDO BASE</td>
			<th colspan="2" class="text-right"><?php if($FSueldo_base2 > 0) echo number_format($FSueldo_base2,2); ?></th>
			<td colspan="2">I.S.R.</td>
			<td >0001</td>
			<th colspan="2" class="text-center">DE ACUERDO A</th>
		</tr>
		<tr>
			<td>GRATIF. BUROCRATA</td>
			<th colspan="2" class="text-right"><?php if($FGratificacion2 > 0) echo number_format($FGratificacion2,2); ?></th>
			<td colspan="2">SUBSIDIO PARA EL EMPLEO</td>
			<td>0099</td>
			<th colspan="2" class="text-center">LA LEY DE I.S.R.</th>
		</tr>
		<tr>
			<td>MATERIAL DIDÁCTITO</td>
			<th colspan="2" class="text-right"><?php if($FMaterial_dicactico2 > 0) echo number_format($FMaterial_dicactico2,2); ?></th>
			<td colspan="2">% 4.625 ISSEMYM</td>
			<td>5540</td>
			<th colspan="2" class="text-right"><?=number_format($issemim46,2)?></th>
		</tr>
		<tr>
			<td>DESPENSA</td>
			<th colspan="2" class="text-right"><?php if($FDespensa2 > 0) echo number_format($FDespensa2,2); ?></th>
			<td colspan="2">% 6.1 ISSEMYM</td>
			<td>5541</td>
			<th colspan="2" class="text-right"><?=number_format($issemim61,2)?></th>
		</tr>
		<tr>
			<td>EFICIENCIA EN EL TRABAJO</td>
			<th colspan="2" class="text-right"><?php if($FEficiencia2 > 0) echo number_format($FEficiencia2,2); ?></th>
			<td colspan="2">% 1.4 ISSEMYM</td>
			<td>5542</td>
			<th colspan="2" class="text-right"><?=number_format($issemim14,2)?></th>
		</tr>
		<tr>
			<td class="text-right"><b>SUBTOTAL</b></td>
			<td colspan="2"><b><div class="pull-right">$ <?php if ($FTotal_bruto2 > 0) echo number_format($FTotal_bruto2,2); else echo "-"; ?></div></b></td>
			<td colspan="3" class="text-right"><b>SUBTOTAL</b></td>
			<td colspan="2"><b><div class="pull-right">$ <?php if ($issemim2 > 0) echo number_format($issemim2,2); else echo "-"; ?></div></b></td>
		</tr>
		<tr><td colspan="8" class="no-content">&nbsp;</td></tr>
		<tr>
			<td>&nbsp;</td>
			<td class="text-right"><b>PROFE CB-I</b></td>
			<th class="text-center"><?php if($FExtra_profe_cbi) echo "x"; else echo"&nbsp;"; ?></th>
			<td class="text-right"><b>TECNI CB-I</b></td>
			<th class="text-center"><?php if($FExtra_tecnico_cbi) echo "x"; else echo"&nbsp;"; ?></th>
			<td colspan="3"></td>
		</tr>
		<tr>
			<td class="text-center">CONCEPTO</td>
			<td colspan="2" class="text-right"></td>
			<td colspan="2" class="text-center">CONCEPTO</td>
			<td class="text-center">CLAVE</td>
			<td colspan="2">IMPORTE</td>
		</tr>
		<?php
			$issemim46 = nvl($FTotal_bruto3)*.04625;
			$issemim61 = $FTotal_bruto3*.06100;
			$issemim14 = $FTotal_bruto3*.01400;
			if($FISSEMYM >=1 && $FISSEMYM <=600000 && !nvl($FISSEMYM14)){
				$issemim14 = 0;
			}
			$issemim3  = $issemim46+$issemim61+$issemim14;
		?>
		<tr>
			<td>SUELDO BASE</td>
			<th colspan="2" class="text-right"><?php if($FSueldo_base3 > 0) echo number_format($FSueldo_base3,2); ?></th>
			<td colspan="2">I.S.R.</td>
			<td >0001</td>
			<th colspan="2" class="text-center">DE ACUERDO A</th>
		</tr>
		<tr>
			<td>GRATIF. BUROCRATA</td>
			<th colspan="2" class="text-right"><?php if($FGratificacion3 > 0) echo number_format($FGratificacion3,2); ?></th>
			<td colspan="2">SUBSIDIO PARA EL EMPLEO</td>
			<td>0099</td>
			<th colspan="2" class="text-center">LA LEY DE I.S.R.</th>
		</tr>
		<tr>
			<td>MATERIAL DIDÁCTITO</td>
			<th colspan="2" class="text-right"><?php if($FMaterial_dicactico3 > 0) echo number_format($FMaterial_dicactico3,2); ?></th>
			<td colspan="2">% 4.625 ISSEMYM</td>
			<td>5540</td>
			<th colspan="2" class="text-right"><?=number_format($issemim46,2)?></th>
		</tr>
		<tr>
			<td>DESPENSA</td>
			<th colspan="2" class="text-right"><?php if($FDespensa3 > 0) echo number_format($FDespensa3,2); ?></th>
			<td colspan="2">% 6.1 ISSEMYM</td>
			<td>5541</td>
			<th colspan="2" class="text-right"><?=number_format($issemim61,2)?></th>
		</tr>
		<tr>
			<td>EFICIENCIA EN EL TRABAJO</td>
			<th colspan="2" class="text-right"><?php if($FEficiencia3 > 0) echo number_format($FEficiencia3,2); ?></th>
			<td colspan="2">% 1.4 ISSEMYM</td>
			<td>5542</td>
			<th colspan="2" class="text-right"><?=number_format($issemim14,2)?></th>
		</tr>
		<tr>
			<td class="text-right"><b>SUBTOTAL</b></td>
			<td colspan="2"><b><div class="pull-right">$ <?php if ($FTotal_bruto3 > 0) echo number_format($FTotal_bruto3,2); else echo "-"; ?></div></b></td>
			<td colspan="3" class="text-right"><b>SUBTOTAL</b></td>
			<td colspan="2"><b><div class="pull-right">$ <?php if ($issemim3 > 0) echo number_format($issemim3,2); else echo "-"; ?></div></b></td>
		</tr>
		<tr>
			<td class="text-right"><b>TOTAL DE PERCEPCIONES</b></td>
			<td colspan="2"><b><div class="pull-right">$ <?=number_format($FTotal_bruto_adm + $FTotal_bruto2 + $FTotal_bruto3,2)?></div></td></b></td>
			<td colspan="3" class="text-right"><b>TOTAL DE DEDUCCIONES</b></td>
			<td colspan="2"><b><div class="pull-right">$ <?=number_format($issemim1 + $issemim2 + $issemim3,2)?></div></td></b></td>
		</tr>
	</table>
	<table class="texto">
		<tr>
			<td class="no-border">&nbsp;</td>
		</tr>
		<tr>
			<th width="110px" rowspan="3" class="text-center titulo2">
				DATOS LABORALES DEL SERVIDOR PÚBLICO
			</th>
			<td width="10px" rowspan="3"></td>
			<td width="135px">FECHA DE INGRESO AL COBAEM:</td>
			<th width="90px" class="text-center"><?=fecha_format(nvl($FFecha_ingreso_cobaem))?></th>
			<td colspan="2">FECHA DE ÚLTIMA PROMOCIÓN:</td>
			<th colspan="3" class="text-center"><?=fecha_format(nvl($FFecha_ultima_promocion))?></th>
		</tr>
		<tr>
			<td>ANTIGÜEDAD EFECTIVA:</td>
			<th class="text-center"><?=nvl($FAntiguedad_efectiva)?></th>
			<td colspan="2">SINDICALIZADO (A):</td>
			<th class="text-center"><?=nvl($FSindicalizado)?></th>
			<td width="95px">HORARIO DE TRABAJO:</td>
			<th width="97px" class="text-center"><?=nvl($FHorario_trabajo)?></th>
		</tr>
		<tr>
			<td>RELACIÓN DE TRABAJO:</td>
			<td class="text-right">INDETERMINADO:</td>
			<th width="20px" class="text-center"><?php if(nvl($FRelacion_trabajo) == "INDETERMINADO") echo "x"; else echo"&nbsp;"; ?></th>
			<td width="95px" class="text-right">DETERMINADO:</td>
			<th width="20px" class="text-center"><?php if(nvl($FRelacion_trabajo) == "DETERMINADO") echo "x"; else echo"&nbsp;"; ?></th>
			<td colspan="2">&nbsp;</td>
		</tr>
	</table>
	<table class="texto">
		<tr>
			<td class="no-border">&nbsp;</td>
		</tr>
		<tr>
			<th width="110px" rowspan="4" class="text-center titulo2">
				DATOS DEL CAMBIO
			</th>
			<td width="10px" rowspan="4"></td>
			<th width="20px" class="text-center"><?php if(nvl($FCambio) == "PROMOCIÓN") echo "x"; else echo"&nbsp;"; ?></th>
			<td>PROMOCIÓN</td>
			<th width="20px" class="text-center"><?php if(nvl($FCambio) == "TRANSFERENCIA") echo "x"; else echo"&nbsp;"; ?></th>
			<td>TRANSFERENCIA</td>
			<th width="20px" class="text-center"><?php if(nvl($FCambio) == "RETABULACIÓN") echo "x"; else echo"&nbsp;"; ?></th>
			<td>RETABULACIÓN</td>
			<th width="20px" class="text-center"><?php if(nvl($FCambio) == "PERMUTA") echo "x"; else echo"&nbsp;"; ?></th>
			<td>PERMUTA</td>
		</tr>
		<tr>
			<th class="text-center"><?php if(nvl($FCambio) == "INDEFINIDO") echo "x"; ?></th>
			<td>INDEFINIDO</td>
			<th class="text-center"><?php if(nvl($FCambio) == "TEMPORAL") echo "x"; ?></th>
			<td>TEMPORAL</td>
			<th class="text-center"><?php if(nvl($FCambio) == "OTRO") echo "x"; ?></th>
			<td colspan="3">OTRO    <?php if(nvl($FCambio) == "OTRO") echo "($FCambio_otro)"; ?></td>
		</tr>
		<tr>
			<td colspan="2" class="text-center">CAMBIO DE ADSCRIPCIÓN</td>
			<td class="text-center"><b>DE:</b></td>
			<th class="text-center"><?=nvl($FCambio_adscripcion_de)?></th>
			<td class="text-center"><b>A:</b></td>
			<th colspan="3" class="text-center"><?=nvl($FCambio_adscripcion_a)?></th>
		</tr>
		<tr>
			<td colspan="2" class="text-center">PLAZA ANTERIOR</td>
			<th colspan="2" class="text-center"><?=nvl($FPlaza_anterior)?></th>
			<td colspan="2" class="text-center">PLAZA ACTUAL</td>
			<th colspan="2" class="text-center"><?php if($FCambio) echo nvl($FPlaza_actual); ?></th>
		</tr>
	</table>
	<table class="texto">
		<tr>
			<td class="no-border">&nbsp;</td>
		</tr>
		<tr>
			<th width="110px" rowspan="2" class="text-center titulo2">
				DATOS DE LA BAJA (MOTIVO)
			</th>
			<td width="10px" rowspan="2"></td>
			<th width="20px" class="text-center"><?php if(nvl($FDatos_baja) == "RENUNCIA") echo "x"; ?></th>
			<td>RENUNCIA</td>
			<th width="20px" class="text-center"><?php if(nvl($FDatos_baja) == "INHABILITACIÓN MÉDICA") echo "x"; ?></th>
			<td>INHABILITACIÓN MÉDICA</td>
			<th width="20px" class="text-center"><?php if(nvl($FDatos_baja) == "FALLECIMIENTO") echo "x"; ?></th>
			<td>FALLECIMIENTO</td>
		</tr>
		<tr>
			<th width="20px" class="text-center"><?php if(nvl($FDatos_baja) == "RESCISIÓN") echo "x"; ?></th>
			<td>RESCISIÓN</td>
			<th width="20px" class="text-center"><?php if(nvl($FDatos_baja) == "JUBILACIÓN") echo "x"; ?></th>
			<td>JUBILACIÓN</td>
			<th width="20px" class="text-center"><?php if(nvl($FDatos_baja) == "OTRO") echo "x"; ?></th>
			<td>OTRO <?php if(nvl($FDatos_baja) == "OTRO") echo "($FDatos_baja_otro)"; ?></td>
		</tr>
	</table>
	<table class="texto">
		<tr>
			<td class="no-border">&nbsp;</td>
		</tr>
		<tr>
			<th width="110px" class="text-center titulo2">
				OBSERVACIONES
			</th>
			<td width="10px"></td>
			<th class="uppercase text-justify"><?=nvl($FObservaciones)?></th>
		</tr>
	</table>
	<table class="texto text-m">
		<tr>
			<td class="no-border">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="5">
				ACEPTO QUE EL COLEGIO DE BACHILLERES DEL ESTADO DE MÉXICO POR NECESIDADES DEL SERVICIO PODRÁ REALIZAR EL CAMBIO DE MI LUGAR DE ADSCRIPCIÓN.  
			</td>
		</tr>
	</table>
	<table class="texto text-m">
		<tr>
			<td class="no-border">&nbsp;</td>
		</tr>
		<tr>
			<td width="200px"><b>DECLARO</b> BAJO PROTESTA DECIR VERDAD QUE</td>
			<th width="20px" class="text-center"><?=$FProtesta?></th>
			<td colspan="3" class="text-justify">
				ME ENCUENTRO DESEMPEÑANDO OTRO EMPLEO O COMISIÓN EN OTRA ÁREA DE LA ADMINISTRACIÓN PÚBLICA, ESTATAL O MUNICIPAL Y/O SECTOR PRIVADO (ANEXAR DOCUMENTO OFICIAL QUE AMPARE ESTA RELACION LABORAL)
			</td>
		</tr>
	</table>
	<table class="texto text-m">
		<tr>
			<td class="no-border">&nbsp;</td>
		</tr>
		<tr>
			<td>NOMBRAMIENTO:</td>
			<td width="300px" colspan="2"><b><?=$FNombre_plaza?></b></td>
			<td>VIGENTE A PARTIR DE:</td>
			<td width="200px" class="text-center"><b><?=fecha_format($FFecha_inicio)?></b></td>
		</tr>
		<tr>
			<td colspan="5" class="text-justify">
				PROTESTO GUARDAR Y HACER GUARDAR LA CONSTITUCIÓN FEDERAL DE LOS ESTADOS UNIDOS MEXICANOS, LA CONSTITUCIÓN PARTICULAR DEL ESTADO, LAS LEYES QUE DE UNA O DE OTRA EMANEN Y CUMPLIR FIEL Y PATRIOTICAMENTE CON LOS DEBERES ENCARGADOS, EN EL PUESTO DESIGNADO.
			</td>
		</tr>
		<tr>
			<td class="no-border">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="5" class="text-justify">
				<b>AVISO DE PRIVACIDAD:</b> LOS DATOS PERSONALES RECABADOS POR EL COLEGIO DE BACHILLERES DEL ESTADO DE MÉXICO A TRAVÉS DE LAS ÁREAS ADMINISTRATIVAS, PARA OTORGAR LAS PRESTACIONES  ECONÓMICAS, LABORALES Y DE SEGURIDAD SOCIAL, PREVISTAS EN LA LEY Y NORMATIVIDAD VIGENTE A LAS QUE TIENE DERECHO EL TRABAJADOR, ESTÁN PROTEGIDOS POR LA LEY DE PROTECCIÓN DE DATOS PERSONALES DEL ESTADO DE MÉXICO. EL ACCESO A LA INFORMACIÓN PERSONAL ESTÁ LIMITADO A UNIDADES ADMINISTRATIVAS, SINDICATO O INSTITUCIONES QUE REQUIERAN DE ESTOS DATOS POR LA RELACIÓN QUE TENGAN CON ESTE ORGANISMO. <br /> 
				EL AVISO COMPLETO DE PRIVACIDAD PODRÁ SER CONSULTADO EN LA PÁGINA <b>http://cobaem.edomex.gob.mx/</b> 
			</td>
		</tr>
		<tr>
			<td colspan="2" class="no-border">&nbsp;</td>
			<td colspan="2" class="text-right">FECHA DE ELABORACIÓN:</td>
			<th class="text-center"><?=fecha_format($FFecha_registro)?></th>
		</tr>
	</table>
	<table class="texto">
		<tr>
			<td colspan="4" class="text-center firmas" style="border: none !important;">
				<b><?=$FNombre?> <?=$FApellido_pat?> <?=$FApellido_mat?></b> <br />
				______________________________________________________________<br />
				NOMBRE Y FIRMA DEL SERVIDOR PÚBLICO
			</td>
		</tr>
	</table>
	<table class="texto">
		<tr>
			<th width="110px" rowspan="2" class="text-center titulo2">
				SELLO
			</th>
			<td width="10px" rowspan="2"></td>
			<?php if($FNivel_autorizacion >=3 and $FAutorizo_2){ ?>
				<?php if($FCoordinacion=='T'){ ?>
					<img src="./assets/img/firmas/cor_t.png" class="firma_c" /><br />
				<?php }elseif($FCoordinacion=='M'){ ?> 
					<img src="./assets/img/firmas/cor_m.png" class="firma_c" /><br />
				<?php } ?> 
			<?php } ?> 
			<?php if($FDirector){ ?>
			<td class="text-center firmas no-border-right no-border-bottom">
				<br />
				______________________________________________________________ <br />
				<b><?=$FDirector?></b>
			</td>
			<?php } ?>
			<td <?php if(!$FDirector) echo'colspan="2"'; ?> class="text-center firmas  <?php if($FDirector) echo'no-border-left'; ?> no-border-bottom">
				<?php if ($FNivel_autorizacion>=5){ ?>
				<img src="./assets/img/firmas/dir_fin.png" class="firma <?php if($FDirector) echo'dir_fin'; else echo'dir_fin_d'; ?>" /> <br />
				<?php } ?>
				______________________________________________________________ <br />
				<b><?=$FDirector_finanzas?></b>
			</td>
		</tr>
		<tr>
			<td class="text-center firmas no-border-right no-border-top">
				<?php if ($FNivel_autorizacion>=4){ ?>
				<img src="./assets/img/firmas/rh.png" class="firma rh" /> <br />
				<?php } ?>
				______________________________________________________________ <br />
				<b><?=$FRecursos_humanos?></b>
			</td>
			<td class="text-center firmas no-border-left no-border-top">
				<?php if ($FNivel_autorizacion>=6){ ?>
				<img src="<?=$FFirma_dir_gen?>" class="firma dir_gen" /> <br />
				<?php } ?>
				______________________________________________________________ <br />
				<b><?=$FDirector_general?></b>
			</td>
		</tr>
	</table>
</div>
<div class="marca_agua">
<?php 
	if ($FNivel_autorizacion >= 6){
		//echo "Copia&nbsp;sistema";
	}
	elseif ($FNivel_autorizacion >= 1 and $acceptTerms == 'on'){
		echo "Validando";
	}
	elseif ($FNivel_autorizacion <= 1){
		echo "Pendiente";
	}
?>
</div>
<style type="text/css">
@page { 
	margin: 10mm !important;
}
.content		{
	color: #000; font-size:8px !important;
	font-family: Arial, Helvetica, sans-serif !important;
}
.text-m { font-size:7px !important; }
.rounded		{ border:solid 1px; border-radius:0px; }
table { 
	width: 735px !important;
	max-width: 735px !important;
	border-collapse:collapse !important;
}
th, td	{
	border:1pt solid #9c9c9c !important; 
	padding: 0px 3px !important; 
	vertical-align:middle !important; 
	width: auto;
}

th	{ background: #eaeaea !important; }

.salto {
    word-wrap: break-word !important;         /* All browsers since IE 5.5+ */
    overflow-wrap: break-word !important;     /* Renamed property in CSS3 draft spec */
	white-space: pre-wrap !important;      /* CSS3 */   
	white-space: -moz-pre-wrap !important; /* Firefox */    
	white-space: -pre-wrap !important;     /* Opera menor 7 */   
	white-space: -o-pre-wrap !important;   /* Opera 7 */ 
	width: 130px !important;
	word-break: break-all !important;
	text-align: left;
}

.no-border		{ 
	border:none !important; 
	font-size:3px !important; 
}
.no-border-left		{ border-left: hidden !important; }
.no-border-right	{ border-right: hidden !important; }
.no-border-top		{ border-top: hidden !important; }
.no-border-bottom	{ border-bottom: hidden !important; }

.no-content		{ font-size:6px !important; }
.text-left		{ text-align: left !important; }
.text-center	{ text-align: center !important; }
.text-right		{ text-align: right !important; }
.text-justify 	{ text-align: justify !important; }
.text-danger	{ color:red !important; }
.texto-sello 	{ color: blue !important; font-size: 8px !important;}
.firmas			{ 
	line-height: 1.2 !important; 
	height:80px !important; 
	vertical-align: bottom !important; 
	padding: 3px 3px !important; 
}
.titulo1		{ font-size: 14px !important; background: #c2c2c2 !important;}
.titulo2		{ font-size: 10px !important; background: #c2c2c2 !important;}
.dir_fin,.dir_fin_d, .rh, .dir_gen, .firma_c { position:absolute; }
.dir_fin 		{ width:130px !important; left:520px !important; padding-top: -140px !important;}
.dir_fin_d 		{ width:130px !important; left:380px !important; padding-top: -120px !important;}
.rh 			{ left:200px !important; }
.dir_gen 		{ left:500px !important; }
.firma_c 		{ width:130px !important; left:220px !important; padding-top: -170px !important;}
.uppercase 	{ text-transform:uppercase !important;}

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