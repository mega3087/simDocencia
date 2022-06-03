<br />
<div class="row">
	<form action="<?php echo base_url("fump/comentarios"); ?>" name="form_comen" id="form_comen" method="POST" class="wizard-big form-horizontal">
		<div class="col-lg-offset-2 col-lg-8">
			<?php 
			if(($nivel != $FNivel_autorizacion and $nivel<$FNivel_autorizacion) or $FNivel_autorizacion>= 6 or !$acceptTerms){ $nivel=null; } 
			$FClave_skip = $this->encrypt->encode($FClave);
			$nivel_skip = $this->encrypt->encode($FNivel_autorizacion);
			muestra_mensaje(); 
			?>
			<input type="hidden" name="SEFump_skip" value="<?php echo $FClave_skip ?>" />
			<input type="hidden" name="SENivel" value="<?php echo $FNivel_autorizacion; ?>" />
			<table>
				<tr>
					<td rowspan="2" class="no-border text-left"><img src="<?=base_url("assets/img/logo_edomex.png")?>" width="100px" alt="" /></td>
					<td class="no-border text-center">&nbsp;</td>
					<td rowspan="2" width="150px" class="no-border text-right"><img src="<?=base_url("assets/img/$FLogo_cobaemex")?>" width="100%" alt="" /></td>
				</tr>
				<tr>
					<td width="145px" height="10px;" class="text-center" style="line-height: 1.2;">
						VIGENCIA <br />
						<b><?=fecha_format(nvl($FFecha_inicio))?></b> - <b class="text-danger">F<?=folio($FClave)?></b>
					</td>
				</tr>
				<tr>
					<th class="text-center titulo1" colspan="3">FORMATO ÚNICO DE MOVIMIENTOS DE PERSONAL (FUMP)</th>
				</tr>
			</table>
			<table>
				<tr>
					<td class="no-border">&nbsp;</td>
				</tr>
				<tr>
					<th width="110px" rowspan="2" class="text-center titulo2">
						<?php if($nivel){ ?>
						<button title="ADSCRIPCIÓN" class="btn btn-warning btn-circle pull-left no-imprimir" nombre="SEAdscripcion" value="" type="button" data-toggle="popover" data-placement="auto left" data-content="--------------------------------------"><i class="fa fa-comment"></i></button>
						<?php } ?>
                        ADSCRIPCIÓN
					</th>
					<td width="10px" rowspan="2"></td>
					<td width="170px" >DIRECCIÓN DE ÁREA/ PLANTEL/ EMSAD:</td>
					<th><?=nvl($FPlantel)?></th>
					<td>E-MAIL:</td>
					<th><?=nvl($FCorreo_electronico_plantel)?></th>
				</tr>
				<tr>
					<td>DEPARTAMENTO:</td>
					<th colspan="3"><?=nvl($FDepartamento)?></th>
				</tr>
			</table>
			<table>
				<tr>
					<td class="no-border">&nbsp;</td>
				</tr>
				<tr>
					<th width="110px" rowspan="6" class="text-center titulo2">
						<?php if($nivel){ ?>
						<button title="DATOS GENERALES" class="btn btn-warning btn-circle pull-left no-imprimir" nombre="SEDatos_generales" value="" type="button" data-toggle="popover" data-placement="auto left" data-content="--------------------------------------"><i class="fa fa-comment"></i></button>
						<?php } ?>
						DATOS GENERALES DEL SERVIDOR PÚBLICO
					</th>
					<td width="10px" rowspan="6"></td>
					<td width="210px" colspan="2">NOMBRE/ PATERNO/ MATERNO:</td>
					<th colspan="3"><?=nvl($FNombre)?> <?=nvl($FApellido_pat)?> <?=nvl($FApellido_mat)?></th>
					<td>CLAVE ISSEMYM:</td>
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
			<table>
				<tr>
					<td class="no-border">&nbsp;<?php $FTramite = explode(";",nvl($FTramite)); ?></td>
				</tr>
				<tr>
					<th width="110px" rowspan="3" class="text-center titulo2">
						<?php if($nivel){ ?>
						<button title="TRÁMITE" class="btn btn-warning btn-circle pull-left no-imprimir" nombre="SETramite" value="" type="button" data-toggle="popover" data-placement="auto left" data-content="--------------------------------------"><i class="fa fa-comment"></i></button>
						<?php } ?>
						TRÁMITE
					</th>
					<td width="10px" rowspan="3"></td>
					<th width="30px" class="text-center"><?php if( in_array("ALTA", $FTramite) ) echo"x"; ?></th>
					<td width="90px">ALTA</td>
					<th width="30px" class="text-center"><?php if( in_array("INTERINATO", $FTramite) ) echo"x"; ?></th>
					<td width="260">INTERINATO</td>
					<th width="30px" class="text-center"><?php if( in_array("INCREMENTO/DISMINUCIÓN DE HRS. CLASE", $FTramite) ) echo"x"; ?></th>
					<td colspan="2">INCREMENTO/DISMINUCIÓN DE HRS. CLASE</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td></td>
					<th width="30px" class="text-center"><?php if( in_array("LICENCIA SIN GOCE DE SUELDO", $FTramite) ) echo"x"; ?></th>
					<td>LICENCIA SIN GOCE DE SUELDO</td>
					<th width="30px" class="text-center"><?php if( in_array("CAMBIO DE ADSCRIPCIÓN", $FTramite) ) echo"x"; ?></th>
					<td colspan="2">CAMBIO DE ADSCRIPCIÓN</td>
				</tr>
				<tr>
					<th width="30px" class="text-center"><?php if( in_array("BAJA", $FTramite) ) echo"x"; ?></th>
					<td>BAJA</td>
					<th width="30px" class="text-center"><?php if( in_array("CAMBIO DE PLAZA", $FTramite) ) echo"x"; ?></th>
					<td>CAMBIO DE PLAZA</td>
					<th width="30px" class="text-center"><?php if( in_array("OTRO", $FTramite) or in_array("RENUNCIA A GRATIFICACIÓN BUROCRATICA", $FTramite) ) echo"x"; ?></th>
					<td width="50px" class="text-center">OTRO</td>
					<th><?=nvl($FTramite_otro)?><?php if( $FTramite_otro and in_array("RENUNCIA A GRATIFICACIÓN BUROCRATICA", $FTramite) ) echo " - "; if( in_array("RENUNCIA A GRATIFICACIÓN BUROCRATICA", $FTramite) ) echo"RENUNCIA A GRATIFICACIÓN BUROCRATICA"; ?></th>
				</tr>
			</table>
			<table>
				<tr>
					<td class="no-border">&nbsp;
					</td>
				</tr>
				<tr>
					<th width="110px" rowspan="9" class="text-center titulo2">
						<?php if($nivel){ ?>
						<button title="DATOS DE LA PLAZA" class="btn btn-warning btn-circle pull-left no-imprimir" nombre="SEDatos_plaza" value="" type="button" data-toggle="popover" data-placement="auto left" data-content="--------------------------------------"><i class="fa fa-comment"></i></button>
						<?php }?>
						DATOS DE LA PLAZA
					</th>
					<td width="10px" rowspan="9"></td>
					<td colspan="2" class="text-center">CLAVE DE EMPLEADO:</td>
					<th colspan="2" class="text-center"><?=nvl($FClave_servidor)?></th>
					<td width="15px;" rowspan="4"></td>
					<td colspan="2">TIPO DE HORAS-CLASE:</td>
					<td class="text-right">PROFE CB-I</td>
					<th width="30px" class="text-center"><?php if( nvl($FTipo_horas_clase) == "PROFE CB-I" ) echo"x"; ?></th>
					<td class="text-right">TÉCNICO CB-I</td>
					<th width="30px" class="text-center"><?php if( nvl($FTipo_horas_clase) == "TÉCNICO CB-I" ) echo"x"; ?></th>
				</tr>
				<tr>
					<td  colspan="2" rowspan="3">TIPO DE PLAZA:</td>
					<td>ADMINISTRATIVO</td>
					<th width="30px" class="text-center"><?php if( nvl($FTipo_plaza) == "ADMINSTRATIVO" ) echo"x"; ?></th>
					<td colspan="2">TIPO DE ASIGNATURA:</td>
					<td class="text-right">CURRICULARES</td>
					<th width="30px" class="text-center"><?php if( nvl($FTipo_asignatura) == "CURRICULARES" ) echo"x"; ?></th>
					<td class="text-right">COCURRICULARES</td>
					<th width="30px" class="text-center"><?php if( nvl($FTipo_asignatura) == "COCURRICULARES" ) echo"x"; ?></th>
				</tr>
				<tr>
					<td>ACADÉMICO</td>
					<th width="30px" class="text-center"><?php if( $FTipo_plaza == "ACADÉMICO" ) echo"x"; ?></th>
					<td colspan="3">No. DE HRS. QUE INCREMENTA:</td>
					<th class="text-center"><?=nvl($FHoras_incrementa)?></th>
					<td class="text-right">No. DE HRS. QUE DISMINUYE:</td>
					<th class="text-center"><?=nvl($FHoras_disminuye)?></th>
				</tr>
				<tr>
					<td>DIRECTIVO O CONFIANZA</td>
					<th width="30px" class="text-center"><?php if( $FTipo_plaza == "DIRECTIVO O CONFIANZA" ) echo"x"; ?></th>
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
					<th class="text-center"><?php if(nvl($FTipo_jornada) == "JORNADA 1/2 TIEMPO") echo"x"; ?></th>
					<td colspan="4" class="text-right">JORNADA 3/4 DE TIEMPO</td>
					<th class="text-center"><?php if($FTipo_jornada == "JORNADA 3/4 DE TIEMPO") echo"x"; ?></th>
					<td class="text-right">JORNADA TIEMPO COMP.</td>
					<th class="text-center"><?php if($FTipo_jornada == "JORNADA TIEMPO COMP.") echo"x"; ?></th>
				</tr>
				<tr>
					<td colspan="2">NÚM. DE HRS. EXTRAS:</td>
					<td>TÉCNICO CB-I</td>
					<th class="text-center"><?=nvl($FExtra_tecnico_cbi)?></th>
					<td colspan="2">PROFE CB-I</td>
					<th width="30px" class="text-center"><?=nvl($FExtra_profe_cbi)?></th>
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
			<table>
				<tr>
				<td colspan="8" class="no-border">&nbsp;</td>
				</tr>
				<tr>
					<th colspan="3" class="text-center titulo2" width="50%">PERCEPCIONES</th>
					<th colspan="5" class="text-center titulo2" width="50%">DEDUCCIONES</th>
				</tr>
				<tr>
					<td colspan="2" class="text-right"><b>ADMVO</b></td>
					<th class="text-center" width="30px"><?php if(nvl($FTipo_plaza) != "ACADÉMICO") echo"x"; ?></th>
					<td class="text-right"><b>JORNADA</b></td>
					<th class="text-center" width="30px"><?php if(nvl($FTipo_jornada)) echo"x"; ?></th>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td class="text-center" width="35%">CONCEPTO</td>
					<td colspan="2" width="15%"></td>
					<td colspan="2" class="text-center" width="25%">CONCEPTO</td>
					<td class="text-center" width="10%">CLAVE</td>
					<td colspan="2"  width="15%">IMPORTE</td>
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
					<td>MATERIAL DIDÁCTICO</td>
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
					<td colspan="2"><b>$ <div class="pull-right"><?php if ($FTotal_bruto_adm > 0) echo number_format($FTotal_bruto_adm,2); else echo "-"; ?></div></b></td>
					<td colspan="3" class="text-right"><b>SUBTOTAL</b></td>
					<td colspan="2"><b>$ <div class="pull-right"><?php if ($issemim1 > 0) echo number_format($issemim1,2); else echo "-"; ?></div></b></td>
				</tr>
				<tr><td colspan="8" class="no-content">&nbsp;</td></tr>
				<tr>
					<td colspan="2" class="text-right"><b>PROFE CB-III</b></td>
					<th class="text-center" width="30px"><?php if($FExtra_profe_cbiii or $FRecate_profe_cbiii) echo "x"; ?></th>
					<td class="text-right"><b>PROFE CB-II</b></td>
					<th class="text-center" width="30px"><?php if($FExtra_profe_cbii or $FRecate_profe_cbii) echo "x"; ?></th>
					<td colspan="2" class="text-right"><b>TECNI CB-II</b></td>
					<th class="text-center" width="30px"><?php if($FRecate_tecnico_cbii) echo "x"; ?></th>
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
					<td>MATERIAL DIDÁCTICO</td>
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
					<td colspan="2"><b>$ <div class="pull-right"><?php if ($FTotal_bruto2 > 0) echo number_format($FTotal_bruto2,2); else echo "-"; ?></div></b></td>
					<td colspan="3" class="text-right"><b>SUBTOTAL</b></td>
					<td colspan="2"><b>$ <div class="pull-right"><?php if ($issemim2 > 0) echo number_format($issemim2,2); else echo "-"; ?></div></b></td>
				</tr>
				<tr><td colspan="8" class="no-content">&nbsp;</td></tr>
				<tr>
					<td colspan="2" class="text-right"><b>PROFE CB-I</b></td>
					<th class="text-center"><?php if($FExtra_profe_cbi) echo "x"; ?></th>
					<td class="text-right"><b>TECNI CB-I</b></td>
					<th class="text-center"><?php if($FExtra_tecnico_cbi) echo "x"; ?></th>
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
					<td>MATERIAL DIDÁCTICO</td>
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
					<td colspan="2"><b>$ <div class="pull-right"><?php if ($FTotal_bruto3 > 0) echo number_format($FTotal_bruto3,2); else echo "-"; ?></div></b></td>
					<td colspan="3" class="text-right"><b>SUBTOTAL</b></td>
					<td colspan="2"><b>$ <div class="pull-right"><?php if ($issemim3 > 0) echo number_format($issemim3,2); else echo "-"; ?></div></b></td>
				</tr>
				<tr>
					<td class="text-right"><b>TOTAL DE PERCEPCIONES</b></td>
					<td colspan="2"><b>$ <div class="pull-right"><?=number_format($FTotal_bruto_adm + $FTotal_bruto2 + $FTotal_bruto3,2)?></div></b></td>
					<td colspan="3" class="text-right"><b>TOTAL DE DEDUCCIONES</b></td>
					<td colspan="2"><b>$ <div class="pull-right"><?=number_format($issemim1 + $issemim2 + $issemim3,2)?></div></b></td>
				</tr>
			</table>
			<table>
				<tr>
					<td class="no-border">&nbsp;</td>
				</tr>
				<tr>
					<th width="110px" rowspan="3" class="text-center titulo2">
						<?php if($nivel){ ?>
						<button title="DATOS LABORALES" class="btn btn-warning btn-circle pull-left no-imprimir" nombre="SEDatos_laborales" value="" type="button" data-toggle="popover" data-placement="auto left" data-content="--------------------------------------"><i class="fa fa-comment"></i></button>
						<?php } ?>
						DATOS LABORALES DEL SERVIDOR PÚBLICO
					</th>
					<td width="10px" rowspan="3"></td>
					<td width="190px">FECHA DE INGRESO AL COBAEM:</td>
					<th class="text-center"><?=fecha_format(nvl($FFecha_ingreso_cobaem))?></th>
					<td colspan="2">FECHA DE ÚLTIMA PROMOCIÓN:</td>
					<th colspan="3" class="text-center"><?=fecha_format(nvl($FFecha_ultima_promocion))?></th>
				</tr>
				<tr>
					<td>ANTIGÜEDAD EFECTIVA:</td>
					<th class="text-center"><?=@$FAntiguedad_efectiva?></th>
					<td colspan="2">SINDICALIZADO (A):</td>
					<th class="text-center"><?=nvl($FSindicalizado)?></th>
					<td>HORARIO DE TRABAJO:</td>
					<th class="text-center"><?=nvl($FHorario_trabajo)?></th>
				</tr>
				<tr>
					<td>RELACIÓN DE TRABAJO:</td>
					<td class="text-right">INDETERMINADO:</td>
					<th width="30px" class="text-center"><?php if(nvl($FRelacion_trabajo) == "INDETERMINADO") echo "x"; ?></th>
					<td class="text-right">DETERMINADO:</td>
					<th width="30px" class="text-center"><?php if(nvl($FRelacion_trabajo) == "DETERMINADO") echo "x"; ?></th>
					<td colspan="2">&nbsp;</td>
				</tr>
			</table>
			<table>
				<tr>
					<td class="no-border">&nbsp;</td>
				</tr>
				<tr>
					<th width="110px" rowspan="4" class="text-center titulo2">
						<?php if($nivel){ ?>
						<button title="DATOS DEL CAMBIO" class="btn btn-warning btn-circle pull-left no-imprimir" nombre="SEDatos_cambio" value="" type="button" data-toggle="popover" data-placement="auto left" data-content="--------------------------------------"><i class="fa fa-comment"></i></button>
						<?php } ?>
						DATOS DEL CAMBIO
					</th>
					<td width="10px" rowspan="4"></td>
					<th width="30px" class="text-center"><?php if(nvl($FCambio) == "PROMOCIÓN") echo "x"; ?></th>
					<td>PROMOCIÓN</td>
					<th width="30px" class="text-center"><?php if(nvl($FCambio) == "TRANSFERENCIA") echo "x"; ?></th>
					<td>TRANSFERENCIA</td>
					<th width="30px" class="text-center"><?php if(nvl($FCambio) == "RETABULACIÓN") echo "x"; ?></th>
					<td>RETABULACIÓN</td>
					<th width="30px" class="text-center"><?php if(nvl($FCambio) == "PERMUTA") echo "x"; ?></th>
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
			<table>
				<tr>
					<td class="no-border">&nbsp;</td>
				</tr>
				<tr>
					<th width="110px" rowspan="2" class="text-center titulo2">
						<?php if($nivel){ ?>
						<button title="DATOS DE LA BAJA" class="btn btn-warning btn-circle pull-left no-imprimir" nombre="SEDatos_baja" value="" type="button" data-toggle="popover" data-placement="auto left" data-content="--------------------------------------"><i class="fa fa-comment"></i></button>
						<?php } ?>
						DATOS DE LA BAJA (MOTIVO)
					</th>
					<td width="10px" rowspan="2"></td>
					<th width="30px" class="text-center"><?php if(nvl($FDatos_baja) == "RENUNCIA") echo "x"; ?></th>
					<td>RENUNCIA</td>
					<th width="30px" class="text-center"><?php if(nvl($FDatos_baja) == "INHABILITACIÓN MÉDICA") echo "x"; ?></th>
					<td>INHABILITACIÓN MÉDICA</td>
					<th width="30px" class="text-center"><?php if(nvl($FDatos_baja) == "FALLECIMIENTO") echo "x"; ?></th>
					<td>FALLECIMIENTO</td>
				</tr>
				<tr>
					<th width="30px" class="text-center"><?php if(nvl($FDatos_baja) == "RESCISIÓN") echo "x"; ?></th>
					<td>RESCISIÓN</td>
					<th width="30px" class="text-center"><?php if(nvl($FDatos_baja) == "JUBILACIÓN") echo "x"; ?></th>
					<td>JUBILACIÓN</td>
					<th width="30px" class="text-center"><?php if(nvl($FDatos_baja) == "OTRO") echo "x"; ?></th>
					<td>OTRO <?php if(nvl($FDatos_baja) == "OTRO") echo "($FDatos_baja_otro)"; ?></td>
				</tr>
			</table>
			<table>
				<tr>
					<td class="no-border">&nbsp;</td>
				</tr>
				<tr>
					<th width="110px" class="text-center titulo2">
						<?php if($nivel){ ?>
						<button title="OBSERVACIONES" class="btn btn-warning btn-circle pull-left no-imprimir" nombre="SEObservaciones" value="" type="button" data-toggle="popover" data-placement="auto left" data-content="--------------------------------------"><i class="fa fa-comment"></i></button>
						<?php } ?>
						OBSERVACIONES
					</th>
					<td width="10px"></td>
					<th><?=nvl($FObservaciones)?></th>
				</tr>
			</table>
			<table class="texto">
				<tr>
					<td class="no-border">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="5">
						ACEPTO QUE EL COLEGIO DE BACHILLERES DEL ESTADO DE MÉXICO POR NECESIDADES DEL SERVICIO PODRÁ REALIZAR EL CAMBIO DE MI LUGAR DE ADSCRIPCIÓN.  
					</td>
				</tr>
				<tr>
					<td class="no-border">&nbsp;</td>
				</tr>
				<tr>
					<td width="200px"><b>DECLARO</b> BAJO PROTESTA DECIR VERDAD QUE</td>
					<th width="30px" class="text-center"><?=$FProtesta?></th>
					<td colspan="3" class="text-justify">
						ME ENCUENTRO DESEMPEÑANDO OTRO EMPLEO O COMISIÓN EN OTRA ÁREA DE LA ADMINISTRACIÓN PÚBLICA, ESTATAL O MUNICIPAL Y/O SECTOR PRIVADO (ANEXAR DOCUMENTO OFICIAL QUE AMPARE ESTA RELACION LABORAL)
					</td>
				</tr>
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
					<td colspan="3" class="no-border">&nbsp;</td>
					<td class="text-right">FECHA DE ELABORACIÓN:</td>
					<th class="text-center"><?=fecha_format($FFecha_registro)?></th>
				</tr>
			</table>
			<table>
				<tr>
					<td colspan="4" class="text-center firmas" style="border: none;">
						<?php if( $FNivel_autorizacion >=7 ){ ?>
						<b class="firma_a">Firmado</b> <br />
						<?php if(is_permitido(null,"fump","fecha_firma")){ ?>
						<center><?=fecha_format($FFecha_6)?>&nbsp;</center>
						<?php } ?>
						<?php } ?> 
						<b><?=$FNombre?> <?=$FApellido_pat?> <?=$FApellido_mat?></b> <br />
						______________________________________________________________<br />
						NOMBRE Y FIRMA DEL SERVIDOR PÚBLICO
					</td>
				</tr>
				<tr>
					<th width="110px" rowspan="2" class="text-center titulo2">
						SELLO
					</th>
					<td width="10px" rowspan="2"></td>
					<?php if($FDirector){ ?>
						<td class="text-center firmas" style="border-bottom: hidden; border-right: hidden;">
						<?php if( ($FNivel_autorizacion >=3 and $FAutorizo_2) or $FNivel_autorizacion >=7 ){ ?>
							<b class="firma_a">Autorizado</b> <br />
							<?php if(is_permitido(null,"fump","fecha_firma")){ ?>
								<?php if($FAutorizo_2){ ?>
									<center><?=fecha_format($FFecha_2)?>&nbsp;</center>
								<?php }else{ ?>
									<center><?=fecha_format($FFecha_6)?>&nbsp;</center>
								<?php } ?>
							<?php } ?>
						<?php } ?> 
							______________________________________________________________ <br />
							<b><?=$FDirector?></b>
						</td>
					<?php } ?>
					<td <?php if(!$FDirector) echo'colspan="2"'; ?> class="text-center firmas" style="border-bottom: hidden;">
						<?php if ($FNivel_autorizacion>=5){ ?>
							<b class="firma_a">Autorizado</b> <br />
							<?php if(is_permitido(null,"fump","fecha_firma")){ ?>
								<center><?=fecha_format($FFecha_4)?>&nbsp;</center>
							<?php } ?>
						<?php } ?>
						______________________________________________________________ <br />
						<b><?=$FDirector_finanzas?></b>
					</td>
				</tr>
				<tr>
					<td class="text-center firmas" style="border-right: hidden;">
						<?php if ($FNivel_autorizacion>=4){ ?>
							<b class="firma_a">Autorizado</b> <br />
							<?php if(is_permitido(null,"fump","fecha_firma")){ ?>
								<center><?=fecha_format($FFecha_3)?>&nbsp;</center>
							<?php } ?>
						<?php } ?>
						______________________________________________________________ <br />
						<b><?=$FRecursos_humanos?></b>
					</td>
					<td class="text-center firmas">
						<?php if ($FNivel_autorizacion>=6){ ?>
							<b class="firma_a">Autorizado</b> <br />
							<?php if(is_permitido(null,"fump","fecha_firma")){ ?>
								<center><?=fecha_format($FFecha_5)?>&nbsp;</center>
							<?php } ?>
						<?php } ?>
						______________________________________________________________ <br />
						<b><?=$FDirector_general?></b>
					</td>
				</tr>
			</table>
		</div>
		<div class="col-lg-2">
			<div class="no-imprimir">
				<br /><br />
				<?php if($nivel){ ?>
					<button title="DOCUMENTACIÓN" class="btn btn-warning btn-circle pull-left no-imprimir" nombre="SEDocumentar" value="" type="button" data-toggle="popover" data-placement="auto left" data-content="--------------------------------------"><i class="fa fa-comment"></i></button>
				<?php } ?>
				<h3><b>DOCUMENTACIÓN</b></h3>
				<?php if( in_array("ALTA", $FTramite) ){ ?>
				<?php if($FNombramiento_file){ ?><a href="<?=base_url("files/get_file/".$this->encrypt->encode($FNombramiento_file))?>" class="upload_file_" target="_blank">=> Nombramiento</a><br /><?php } ?>
				<?php if($FConstancia_inhabilitacion_file){ ?><a href="<?=base_url("files/get_file/".$this->encrypt->encode($FConstancia_inhabilitacion_file))?>" class="upload_file_" target="_blank">=> Constancia de inhabilitación</a><br /><?php } ?>
				<?php if($FAntecedentes_penales_file){ ?><a href="<?=base_url("files/get_file/".$this->encrypt->encode($FAntecedentes_penales_file))?>" class="upload_file_" target="_blank">=> Antecedentes no penales</a><br /><?php } ?>
				<?php if($DPRFC){ ?><a href="<?=base_url("files/get_file/".$this->encrypt->encode($DPRFC))?>" class="upload_file_" target="_blank">=> RFC </a><br /><?php } ?>
				<?php if($DPCURP){ ?><a href="<?=base_url("files/get_file/".$this->encrypt->encode($DPCURP))?>" class="upload_file_" target="_blank">=> CURP</a><br /><?php } ?>
				<?php if($DPCredencial_elector){ ?><a href="<?=base_url("files/get_file/".$this->encrypt->encode($DPCredencial_elector))?>" class="upload_file_" target="_blank">=> Credencial de elector</a><br /><?php } ?>
				<?php if($DPCertificado_estudios){ ?><a href="<?=base_url("files/get_file/".$this->encrypt->encode($DPCertificado_estudios))?>" class="upload_file_" target="_blank">=> Certificado de estudios</a><br /><?php } ?>
				<?php if($DPMov_ISSEMYM){ ?><a href="<?=base_url("files/get_file/".$this->encrypt->encode($DPMov_ISSEMYM))?>" class="upload_file_" target="_blank">=> Movimiento de ISSEMYM</a><br /><?php } ?>
				<?php if($DPCuenta){ ?><a href="<?=base_url("files/get_file/".$this->encrypt->encode($DPCuenta))?>" class="upload_file_" target="_blank">=> Cuenta Bancaria</a><br /><?php } ?>
				<?php if($FEmpleo_anterior_file){ ?><a href="<?=base_url("files/get_file/".$this->encrypt->encode($FEmpleo_anterior_file))?>" class="upload_file_" target="_blank">=> Formato del empleo anterior </a><br /><?php } ?>
				<?php } ?>
				<?php if( in_array("BAJA", $FTramite) ){ ?>
				<?php if($FRenuncia_file){ ?><a href="<?=base_url("files/get_file/".$this->encrypt->encode($FRenuncia_file))?>" class="upload_file_" target="_blank">=> Renuncia </a><br /><?php } ?>
				<?php if($FActa_defuncion_file){ ?><a href="<?=base_url("files/get_file/".$this->encrypt->encode($FActa_defuncion_file))?>" class="upload_file_" target="_blank">=> Acta de defunción</a><br /><?php } ?>
				<?php if($FRescision_file){ ?><a href="<?=base_url("files/get_file/".$this->encrypt->encode($FRescision_file))?>" class="upload_file_" target="_blank">=> Rescisión laboral</a><br /><?php } ?>
				<?php if($FResolucion_file){ ?><a href="<?=base_url("files/get_file/".$this->encrypt->encode($FResolucion_file))?>" class="upload_file_" target="_blank">=> Documento Probatorio</a><br /><?php } ?>
				<?php if($FInhabilitacion_file){ ?><a href="<?=base_url("files/get_file/".$this->encrypt->encode($FInhabilitacion_file))?>" class="upload_file_" target="_blank">=> Inhabilitación medica Por ISSEMYM</a><br /><?php } ?>
				<?php if($FJubilacion_file){ ?><a href="<?=base_url("files/get_file/".$this->encrypt->encode($FJubilacion_file))?>" class="upload_file_" target="_blank">=> Jubilación  por ISSEMYM</a><br /><?php } ?>
				<?php } ?>
				<?php if( in_array("LICENCIA SIN GOCE DE SUELDO", $FTramite) ){ ?>
				<?php if($FAutorizacion_licencia_file){ ?><a href="<?=base_url("files/get_file/".$this->encrypt->encode($FAutorizacion_licencia_file))?>" class="upload_file_" target="_blank">=> Licencia sin goce de sueldo</a><br /><?php } ?>
				<?php } ?>
				<?php if( in_array("INCREMENTO/DISMINUCIÓN DE HRS. CLASE", $FTramite) ){ ?>
				<?php if($FAutorizacion_incremento_file){ ?><a href="<?=base_url("files/get_file/".$this->encrypt->encode($FAutorizacion_incremento_file))?>" class="upload_file_" target="_blank">=> Incremento de Hrs. clase</a><br /><?php } ?>
				<?php } ?>
				<?php if( in_array("CAMBIO DE PLAZA", $FTramite) or in_array("CAMBIO DE PLAZA", $FTramite) or in_array("CAMBIO DE ADSCRIPCIÓN", $FTramite) or in_array("OTRO", $FTramite) ){ ?>
				<?php if($FOtro_file){ ?><a href="<?=base_url("files/get_file/".$this->encrypt->encode($FOtro_file))?>" class="upload_file_" target="_blank">=> Oficio</a><br /><?php } ?>
				<?php } ?>
				<?php if($FFinal){ ?><a href="<?=base_url("files/get_file/".$this->encrypt->encode($FFinal))?>" class="upload_file_" target="_blank">=> FUMP Firmado</a>  <?php } ?>
				<?php if($FFinal and $FNivel_autorizacion == 7 and is_permitido(null,"fump","rechazar") ){ ?><!--a href='<?=base_url("fump/rechazar/$FClave_skip")?>' confirm="¿Está seguro de rechazar esté FUMP?<br />¡ Regresara al plantel !" class="btn btn-danger btn-xs" title="Rechazar FUMP"><i class="fa fa-times"></i></a--><?php } ?>
			</div>
		</div>
	</form>
	<div class="col-lg-offset-2 col-lg-8 no-imprimir">
		<table>
			<tr>
				<td class="no-border no-imprimir text-center" style="font-size:12px;">
				<br /><br />
					<?php if($FFinal and $FNivel_autorizacion >= 7 ){ ?>
						<a href="<?=base_url("files/get_file/".$this->encrypt->encode($FFinal))?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> FUMP Firmado</a>
						<?php if($FNivel_autorizacion == 7 and is_permitido(null,"fump","rechazar") ){ ?><a href='<?=base_url("fump/rechazar/$FClave_skip")?>' confirm="¿Está seguro de rechazar esté FUMP?<br />¡ Regresara al plantel !" class="btn btn-danger btn-sm" title="Rechazar FUMP"><i class="fa fa-times"></i> Rechazar FUMP</a><?php } ?>
					<?php }else{ ?>
						<a href="<?php echo base_url("fump/ver/$FClave_skip/pdf"); ?>" target="_blank" type="button" class="btn btn-success btn-sm"><i class="fa fa-file-pdf-o"></i> Formato para Imprimir</a>
					<?php }?>
					<?php if($nivel and $FNivel_autorizacion != 6){ ?>
						<button type="button"  onclick="fump_comen();" class="btn btn-warning btn-sm pull-left"><i class="fa fa-times"></i> Rechazar y enviar comentarios</button>	
					<?php } ?>
					<?php if( is_permitido(null,"fump","fump") and $FNivel_autorizacion == 6){ ?>
					<button type="button" onclick="fump_valida();" class="btn btn-primary btn-sm pull-right"><i class="fa fa-file"></i> Enviar</button>
					<?php echo forma_archivo("FFinal", nvl($FFinal),"Subir FUMP",'btn-primary btn-sm','pdf_jpg_jpeg_png'); ?>
					<?php if($FFinal and $FNivel_autorizacion == 6) echo '<br /><h4 class="text-danger">! El FUMP anexado no es correcto, favor de corregir ¡</h4>'; ?>
					<?php }else if($nivel){ ?>
					<a href="<?php echo base_url("fump/validar/$FClave_skip/$nivel_skip"); ?>" class="btn btn-primary btn-sm pull-right" onclick="this.style.display = 'none';"><i class="fa fa-check-square-o"></i> Aprobar</a>
					<?php }else if($FNivel_autorizacion == 7 and is_permitido(null,"fump","open")){ ?>
					<div class="form-horizontal">
						<label for="" class="col-lg-8 text-right">Clave OPEN: <em>*</em></label>
						<div class="col-lg-2">
							<input type="text" id="open_skip" value="<?=$UOpen?>" class="form-control" />
						</div>
						<div class="col-lg-2">
							<button type="button" onclick="fump_open();" class="btn btn-primary btn-sm pull-right"><i class="fa fa-save"></i> Guardar</button>
						</div>
					</div>
					<?php } ?>
				</td>
			</tr>
		</table>
	</div>
	<form action="<?php echo base_url("fump/fump"); ?>" name="form_valida" method="POST" >
		<input type="hidden" name="FClave_skip" value="<?=$FClave_skip?>"/>
		<input type="hidden" name="FFinal" value="<?=$FFinal?>"/>
	</form>
	<form action="<?php echo base_url("fump/open"); ?>" name="form_open" method="POST" >
		<input type="hidden" name="FClave_skip" value="<?=$FClave_skip?>"/>
		<input type="hidden" name="FUsuario" value="<?=$FUsuario?>"/>
		<input type="hidden" name="FOpen" id="FOpen" value="<?=$UOpen?>"/>
	</form>
	
	<div class="col-lg-offset-2 col-lg-8 no-imprimir">
		<br />
		<table>
			<tr>
				<th class="text-right" colspan="6">Fecha de registro:</th><td colspan="2"><?=fecha_format($FFecha_registro)?></td>
				<th class="text-right" colspan="2">Fecha ultima modificación:</th><td colspan="2"><?=fecha_format($FFecha_modificacion)?></td>
			</tr>
			<?php if(is_permitido(null,"fump","fecha_firma")){ ?>
			<tr><th class="text-right" colspan="10">Ultima revisión por enlace:</th><td colspan="2"><?=fecha_format($FFecha_1)?></td></tr>
			<?php } ?>
			<?php if(nvl($seguimiento)){ ?>
			<tr>
				<th>Personal</th>
				<th>Adscripcion</th>
				<th>Datos generales</th>
				<th>Tramite</th>
				<th>Datos de la plaza</th>
				<th>Datos laborales</th>
				<th>Datos de cambio</th>
				<th>Datos de la baja</th>
				<th>Observaciones</th>
				<th>Documentación</th>
				<th>Fecha Rechazo</th>
				<th>Fecha Corrección</th>
			</tr>
			<?php 
			foreach($seguimiento as $key => $list){ 
			$SEClave_skip = $this->encrypt->encode($list['SEClave']);
			$SEPermitido = is_permitido(null,'fump','seguimiento')?1:0;
			?>
			<tr>
				<td style="vertical-align:top;"><?=$list['UNombre']?> <?=$list['UApellido_pat']?> <?=$list['UApellido_mat']?></td>
				<td style="vertical-align:top;"><?php if(!$list['SEfecha_correcion'] and $SEPermitido and !$list['SEAdscripcion'] ) echo "<a href='".base_url("FUMP/seguimiento/$SEClave_skip/SEAdscripcion")."' confirm='Estas seguro de habilitar?' class='btn btn-default btn-sm'><i class='fa fa-stack-exchange'></i></a>"; else echo str_replace("\n","<br />",$list['SEAdscripcion']);?></td>
				<td style="vertical-align:top;"><?php if(!$list['SEfecha_correcion'] and $SEPermitido and !$list['SEDatos_generales'] ) echo "<a href='".base_url("FUMP/seguimiento/$SEClave_skip/SEDatos_generales")."' confirm='Estas seguro de habilitar?' class='btn btn-default btn-sm'><i class='fa fa-stack-exchange'></i></a>"; else echo str_replace("\n","<br />",$list['SEDatos_generales']);?></td>
				<td style="vertical-align:top;"><?php if(!$list['SEfecha_correcion'] and $SEPermitido and !$list['SETramite'] ) echo "<a href='".base_url("FUMP/seguimiento/$SEClave_skip/SETramite")."' confirm='Estas seguro de habilitar?' class='btn btn-default btn-sm'><i class='fa fa-stack-exchange'></i></a>"; else echo str_replace("\n","<br />",$list['SETramite']);?></td>
				<td style="vertical-align:top;"><?php if(!$list['SEfecha_correcion'] and $SEPermitido and !$list['SEDatos_plaza'] ) echo "<a href='".base_url("FUMP/seguimiento/$SEClave_skip/SEDatos_plaza")."' confirm='Estas seguro de habilitar?' class='btn btn-default btn-sm'><i class='fa fa-stack-exchange'></i></a>"; else echo str_replace("\n","<br />",$list['SEDatos_plaza']);?></td>
				<td style="vertical-align:top;"><?php if(!$list['SEfecha_correcion'] and $SEPermitido and !$list['SEDatos_laborales'] ) echo "<a href='".base_url("FUMP/seguimiento/$SEClave_skip/SEDatos_laborales")."' confirm='Estas seguro de habilitar?' class='btn btn-default btn-sm'><i class='fa fa-stack-exchange'></i></a>"; else echo str_replace("\n","<br />",$list['SEDatos_laborales']);?></td>
				<td style="vertical-align:top;"><?php if(!$list['SEfecha_correcion'] and $SEPermitido and !$list['SEDatos_cambio'] ) echo "<a href='".base_url("FUMP/seguimiento/$SEClave_skip/SEDatos_cambio")."' confirm='Estas seguro de habilitar?' class='btn btn-default btn-sm'><i class='fa fa-stack-exchange'></i></a>"; else echo str_replace("\n","<br />",$list['SEDatos_cambio']);?></td>
				<td style="vertical-align:top;"><?php if(!$list['SEfecha_correcion'] and $SEPermitido and !$list['SEDatos_baja'] ) echo "<a href='".base_url("FUMP/seguimiento/$SEClave_skip/SEDatos_baja")."' confirm='Estas seguro de habilitar?' class='btn btn-default btn-sm'><i class='fa fa-stack-exchange'></i></a>"; else echo str_replace("\n","<br />",$list['SEDatos_baja']);?></td>
				<td style="vertical-align:top;"><?php if(!$list['SEfecha_correcion'] and $SEPermitido and !$list['SEObservaciones'] ) echo "<a href='".base_url("FUMP/seguimiento/$SEClave_skip/SEObservaciones")."' confirm='Estas seguro de habilitar?' class='btn btn-default btn-sm'><i class='fa fa-stack-exchange'></i></a>"; else echo str_replace("\n","<br />",$list['SEObservaciones']);?></td>
				<td style="vertical-align:top;"><?php if(!$list['SEfecha_correcion'] and $SEPermitido and !$list['SEDocumentar'] ) echo "<a href='".base_url("FUMP/seguimiento/$SEClave_skip/SEDocumentar")."' confirm='Estas seguro de habilitar?' class='btn btn-default btn-sm'><i class='fa fa-stack-exchange'></i></a>"; else echo str_replace("\n","<br />",$list['SEDocumentar']);?></td>
				<td style="vertical-align:top;"><?=fecha_format($list['SEFecha_registro'])?></td>
				<td style="vertical-align:top;">
				<?php 
					if($list['SEfecha_correcion'])
						echo fecha_format($list['SEfecha_correcion']); 
					elseif( is_permitido(null,'fump','editar') and !$acceptTerms ){
					$UNCI_usuario_skip = $this->encrypt->encode($FUsuario);
					?>
					<a href="<?php echo base_url("fump/agregar/$UNCI_usuario_skip/$FClave_skip"); ?>" class="btn btn-default btn-sm"><i class="fa fa-pencil"></i> Editar</a>	
					<?php } ?>
				</td>
			</tr>
			<?php } ?>
			<?php } ?>
		</table>
		<br />
	</div>
</div>
<div class="marca_agua">
<?php 
	if ($FNivel_autorizacion >= 7){
		echo "Documentado";
	}
	elseif ($FNivel_autorizacion >= 1 and $acceptTerms == 'on'){
		echo "Validando";
	}
	elseif ($FNivel_autorizacion <= 1){
		echo "Pendiente";
	}
?>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("[data-toggle]").click(function() {
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
});
function fump_comen(){
	form_comen.submit();
}
function fump_valida(){
	form_valida.submit();
}
function fump_open(){
	$("#FOpen").val($("#open_skip").val());
	form_open.submit();
}
</script>
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