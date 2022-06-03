<table class="table table-striped table-bordered table-hover dataTables-example dataTable">
	<tr>
		<th colspan="3" class="text-center">PERCEPCIONES</th>
		<th colspan="5" class="text-center">DEDUCCIONES</th>
	</tr>
	<tr>
		<th colspan="2" class="text-right">ADMVO</th>
		<th width="30px" class="text-center"><?php if(nvl($FTipo_plaza) != "ACADÉMICO") echo"x"; ?></th>
		<th class="text-right">JORNADA</th>
		<th width="30px" class="text-center"><?php if(nvl($FTipo_jornada)) echo"x"; ?></th>
		<th colspan="3"></th>
	</tr>
	<tr>
		<td class="text-center">CONCEPTO</td>
		<td colspan="2" width="90px"></td>
		<td colspan="2" class="text-center">CONCEPTO</td>
		<td width="65px" class="text-center">CLAVE</td>
		<td colspan="2" width="120px">IMPORTE</td>
	</tr>
	<tr>
		<td>SUELDO BASE</td>
		<td colspan="2" class="text-right">
			<?=@number_format(nvl($jornada['PLSueldo_base'])+0,2)?>
			<input type="hidden" name="FSueldo_base_adm" value="<?=nvl($jornada['PLSueldo_base'])?>" />
		</td>
		<td colspan="2">I.S.R.</td>
		<td>0001</td>
		<th colspan="2" class="text-center">DE ACUERDO A</th>
	</tr>
	<tr>
		<td>GRATIF. BUROCRATA</td>
		<td colspan="2" class="text-right">
			<?php
			if( in_array("RENUNCIA A GRATIFICACIÓN BUROCRATICA", $FTramite) ){
				$jornada['PLTotal_bruto'] = nvl($jornada['PLTotal_bruto'])-nvl($jornada['PLGratificacion']);
				$jornada['PLGratificacion'] = '0.00';
			}
			?>
			<?=@number_format(nvl($jornada['PLGratificacion'])+0,2)?>
			<input type="hidden" name="FGratificacion_adm" value="<?=nvl($jornada['PLGratificacion'])?>" />
		</td>
		<td colspan="2">SUBSIDIO PARA EL EMPLEO</td>
		<td>0099</td>
		<th colspan="2" class="text-center">LA LEY DE I.S.R.</th>
	</tr>
	<?php 
		$PLTotal_bruto1 = nvl($jornada['PLTotal_bruto']);
		$issemim46 = $PLTotal_bruto1*.04625;
		$issemim61 = $PLTotal_bruto1*.06100;
		$issemim14 = $PLTotal_bruto1*.01400;
		if($FISSEMYM >=1 && $FISSEMYM <=620000 && !nvl($FISSEMYM14)){
			$issemim14 = 0;
		}
		$issemim1  = $issemim46+$issemim61+$issemim14;
	?>
	<tr>
		<td>MATERIAL DIDÁCTICO</td>
		<td colspan="2" class="text-right">
			<?=@number_format(nvl($jornada['PLMaterial_dicactico'])+0,2)?>
			<input type="hidden" name="FMaterial_dicactico_adm" value="<?=nvl($jornada['PLMaterial_dicactico'])?>" />
		</td>
		<td colspan="2">% 4.625 ISSEMYM</td>
		<td>5540</td>
		<th colspan="2" class="text-right"><?=number_format($issemim46,2)?></th>
	</tr>
	<tr>
		<td>DESPENSA</td>
		<td colspan="2" class="text-right">
			<?=@number_format(nvl($jornada['PLDespensa'])+0,2)?>
			<input type="hidden" name="FDespensa_adm" value="<?=nvl($jornada['PLDespensa'])?>" />
		</td>
		<td colspan="2">% 6.1 ISSEMYM</td>
		<td>5541</td>
		<th colspan="2" class="text-right"><?=number_format($issemim61,2)?></th>
	</tr>
	<tr>
		<td>EFICIENCIA EN EL TRABAJO</td>
		<td colspan="2" class="text-right">
			<?=@number_format(nvl($jornada['PLEficiencia'])+0,2)?>
			<input type="hidden" name="FEficiencia_adm" value="<?=nvl($jornada['PLEficiencia'])?>" />
		</td>
		<td colspan="2">% 1.4 ISSEMYM</td>
		<td>5542</td>
		<th colspan="2" class="text-right"><?=number_format($issemim14,2)?></th>
	</tr>
	<tr>
		<th class="text-right">SUBTOTAL</tH>
		<th colspan="2">
			$ <div class="pull-right"><?=@number_format(nvl($jornada['PLTotal_bruto'])+0,2)?></div>
			<input type="hidden" name="FTotal_bruto_adm" value="<?=nvl($jornada['PLTotal_bruto'])?>" />
		</th>
		<th colspan="3" class="text-right">SUBTOTAL</th>
		<th colspan="2">$ <div class="pull-right"><?=number_format($issemim1,2)?></th>
	</tr>
	<tr><td colspan="8">&nbsp;</td></tr>
	<tr>
		<th colspan="2" class="text-right">PROFE CB-III</th>
		<th width="30px" class="text-center"><?php if($FExtra_profe_cbiii or $FRecate_profe_cbiii) echo "x"; ?></th>
		<th class="text-right">PROFE CB-II</th>
		<th width="30px" class="text-center"><?php if($FExtra_profe_cbii or $FRecate_profe_cbii) echo "x"; ?></th>
		<th colspan="2" class="text-right">TECNI CB-II</th>
		<th width="30px" class="text-center"><?php if($FRecate_tecnico_cbii) echo "x"; ?></th>
	</tr>
	<tr>
		<td class="text-center">CONCEPTO</td>
		<td colspan="2" class="text-right"></td>
		<td colspan="2" class="text-center">CONCEPTO</td>
		<td class="text-center">CLAVE</td>
		<td colspan="2">IMPORTE</td>
	</tr>
	<?php 
	$PLSueldo_base2 = ($FExtra_profe_cbiii   * nvl($profe_cbiii['PLSueldo_base']) + 
				  $FRecate_profe_cbiii       * nvl($profe_cbiii['PLSueldo_base']) + 
				  $FExtra_profe_cbii         * nvl($profe_cbii['PLSueldo_base']) + 
				  $FRecate_profe_cbii        * nvl($profe_cbii['PLSueldo_base']) + 
				  $FRecate_tecnico_cbii      * nvl($tecnico_cbii['PLSueldo_base']));

	$PLGratificacion2 = ($FExtra_profe_cbiii  * nvl($profe_cbiii['PLGratificacion']) + 
				  $FRecate_profe_cbiii        * nvl($profe_cbiii['PLGratificacion']) + 
				  $FExtra_profe_cbii          * nvl($profe_cbii['PLGratificacion']) + 
				  $FRecate_profe_cbii         * nvl($profe_cbii['PLGratificacion']) + 
				  $FRecate_tecnico_cbii       * nvl($tecnico_cbii['PLGratificacion']));

	$PLMaterial_dicactico2 = ($FExtra_profe_cbiii * nvl($profe_cbiii['PLMaterial_dicactico']) + 
					  $FRecate_profe_cbiii        * nvl($profe_cbiii['PLMaterial_dicactico']) + 
					  $FExtra_profe_cbii          * nvl($profe_cbii['PLMaterial_dicactico']) + 
					  $FRecate_profe_cbii         * nvl($profe_cbii['PLMaterial_dicactico']) + 
					  $FRecate_tecnico_cbii       * nvl($tecnico_cbii['PLMaterial_dicactico']));
			  
	$PLDespensa2 = ($FExtra_profe_cbiii   * nvl($profe_cbiii['PLDespensa']) + 
			  $FRecate_profe_cbiii        * nvl($profe_cbiii['PLDespensa']) + 
			  $FExtra_profe_cbii          * nvl($profe_cbii['PLDespensa']) + 
			  $FRecate_profe_cbii         * nvl($profe_cbii['PLDespensa']) + 
			  $FRecate_tecnico_cbii       * nvl($tecnico_cbii['PLDespensa']));
			  
	$PLEficiencia2 = ($FExtra_profe_cbiii * nvl($profe_cbiii['PLEficiencia']) + 
			  $FRecate_profe_cbiii        * nvl($profe_cbiii['PLEficiencia']) + 
			  $FExtra_profe_cbii          * nvl($profe_cbii['PLEficiencia']) + 
			  $FRecate_profe_cbii         * nvl($profe_cbii['PLEficiencia']) + 
			  $FRecate_tecnico_cbii       * nvl($tecnico_cbii['PLEficiencia']));
			  
	$PLTotal_bruto2 = ($FExtra_profe_cbiii * nvl($profe_cbiii['PLTotal_bruto']) + 
			  $FRecate_profe_cbiii        * nvl($profe_cbiii['PLTotal_bruto']) + 
			  $FExtra_profe_cbii          * nvl($profe_cbii['PLTotal_bruto']) + 
			  $FRecate_profe_cbii         * nvl($profe_cbii['PLTotal_bruto']) + 
			  $FRecate_tecnico_cbii       * nvl($tecnico_cbii['PLTotal_bruto']));
			  
	$issemim46 = $PLTotal_bruto2*.04625;
	$issemim61 = $PLTotal_bruto2*.06100;
	$issemim14 = $PLTotal_bruto2*.01400;
	if($FISSEMYM >=1 && $FISSEMYM <=620000 && !nvl($FISSEMYM14)){
		$issemim14 = 0;
	}
	$issemim2  = $issemim46+$issemim61+$issemim14;
	
	?>
	<tr>
		<td>SUELDO BASE</td>
		<td colspan="2" class="text-right">
			<?=number_format($PLSueldo_base2,2)?>
			<input type="hidden" name="FSueldo_base2" value="<?=$PLSueldo_base2?>" />
		</td>
		<td colspan="2">I.S.R.</td>
		<td width="65px">0001</td>
		<th colspan="2" class="text-center">DE ACUERDO A</th>
	</tr>
	<tr>
		<td>GRATIF. BUROCRATA</td>
		<td colspan="2" class="text-right">
			<?php 
			if( in_array("RENUNCIA A GRATIFICACIÓN BUROCRATICA", $FTramite) ){
				$PLTotal_bruto2 = $PLTotal_bruto2-$PLGratificacion2;
				$PLGratificacion2 = '0.00';
			}
			?>
			<?=number_format($PLGratificacion2,2)?>
			<input type="hidden" name="FGratificacion2" value="<?=$PLGratificacion2?>" />
		</td>
		<td colspan="2">SUBSIDIO PARA EL EMPLEO</td>
		<td>0099</td>
		<th colspan="2" class="text-center">LA LEY DE I.S.R.</th>
	</tr>
	<tr>
		<td>MATERIAL DIDÁCTICO</td>
		<td colspan="2" class="text-right">
			<?=number_format($PLMaterial_dicactico2,2)?>
			<input type="hidden" name="FMaterial_dicactico2" value="<?=$PLMaterial_dicactico2?>" />
		</td>
		<td colspan="2">% 4.625 ISSEMYM</td>
		<td>5540</td>
		<th colspan="2" class="text-right"><?=number_format($issemim46,2)?></th>
	</tr>
	<tr>
		<td>DESPENSA</td>
		<td colspan="2" class="text-right">
			<?=number_format($PLDespensa2,2)?>
			<input type="hidden" name="FDespensa2" value="<?=$PLDespensa2?>" />
		</td>
		<td colspan="2">% 6.1 ISSEMYM</td>
		<td>5541</td>
		<th colspan="2" class="text-right"><?=number_format($issemim61,2)?></th>
	</tr>
	<tr>
		<td>EFICIENCIA EN EL TRABAJO</td>
		<td colspan="2" class="text-right">
			<?=number_format($PLEficiencia2,2)?>
			<input type="hidden" name="FEficiencia2" value="<?=$PLEficiencia2?>" />
		</td>
		<td colspan="2">% 1.4 ISSEMYM</td>
		<td>5542</td>
		<th colspan="2" class="text-right"><?=number_format($issemim14,2)?></th>
	</tr>
	<tr>
		<th class="text-right">SUBTOTAL</tH>
		<th colspan="2">
			$ <div class="pull-right"><?=number_format($PLTotal_bruto2,2)?></div>
			<input type="hidden" name="FTotal_bruto2" value="<?=$PLTotal_bruto2?>" />
		</th>
		<th colspan="3" class="text-right">SUBTOTAL</th>
		<th colspan="2">$ <div class="pull-right"><?=number_format($issemim2,2)?></div></th>
	</tr>
	<tr><td colspan="8">&nbsp;</td></tr>
	<tr>
		<th colspan="2" class="text-right">PROFE CB-I</th>
		<th width="30px" class="text-center"><?php if($FExtra_profe_cbi) echo "x"; ?></th>
		<th class="text-right">TECNI CB-I</th>
		<th width="30px" class="text-center"><?php if($FExtra_tecnico_cbi) echo "x"; ?></th>
		<th colspan="3"></th>
	</tr>
	<tr>
		<td class="text-center">CONCEPTO</td>
		<td colspan="2" class="text-right"></td>
		<td colspan="2" class="text-center">CONCEPTO</td>
		<td class="text-center">CLAVE</td>
		<td colspan="2">IMPORTE</td>
	</tr>
	<?php 
	$PLSueldo_base3 = ($FExtra_profe_cbi	* nvl($profe_cbi['PLSueldo_base']) + 
					   $FExtra_tecnico_cbi	* nvl($tecnico_cbi['PLSueldo_base']));
					   
	$PLGratificacion3 = ($FExtra_profe_cbi  * nvl($profe_cbi['PLGratificacion']) + 
				  $FExtra_tecnico_cbi       * nvl($tecnico_cbi['PLGratificacion']));

	$PLMaterial_dicactico3 = ($FExtra_profe_cbi  * nvl($profe_cbi['PLMaterial_dicactico']) + 
					  $FExtra_tecnico_cbi        * nvl($tecnico_cbi['PLMaterial_dicactico']));
			  
	$PLDespensa3 = ($FExtra_profe_cbi   * nvl($profe_cbi['PLDespensa']) + 
			  $FExtra_tecnico_cbi       * nvl($tecnico_cbi['PLDespensa']));
			  
	$PLEficiencia3 = ($FExtra_profe_cbi  * nvl($profe_cbi['PLEficiencia']) + 
			  $FExtra_tecnico_cbi        * nvl($tecnico_cbi['PLEficiencia']));
			  
	$PLTotal_bruto3 = ($FExtra_profe_cbi * nvl($profe_cbi['PLTotal_bruto']) + 
			  $FExtra_tecnico_cbi        * nvl($tecnico_cbi['PLTotal_bruto']));
			  
	$issemim46 = $PLTotal_bruto3*.04625;
	$issemim61 = $PLTotal_bruto3*.06100;
	$issemim14 = $PLTotal_bruto3*.01400;
	if($FISSEMYM >=1 && $FISSEMYM <=620000 && !nvl($FISSEMYM14)){
		$issemim14 = 0;
	}
	$issemim3  = $issemim46+$issemim61+$issemim14;
	?>
	<tr>
		<td>SUELDO BASE</td>
		<td colspan="2" class="text-right">
			<?=number_format($PLSueldo_base3,2)?>
			<input type="hidden" name="FSueldo_base3" value="<?=$PLSueldo_base3?>" />
		</td>
		<td colspan="2">I.S.R.</td>
		<td width="65px">0001</td>
		<th colspan="2" class="text-center">DE ACUERDO A</th>
	</tr>
	<tr>
		<td>GRATIF. BUROCRATA</td>
		<td colspan="2" class="text-right">
			<?php 
			if( in_array("RENUNCIA A GRATIFICACIÓN BUROCRATICA", $FTramite) ){
				$PLTotal_bruto3 = $PLTotal_bruto3-$PLGratificacion3;
				$PLGratificacion3 = '0.00';
			}
			?>
			<?=number_format($PLGratificacion3,2)?>
			<input type="hidden" name="FGratificacion3" value="<?=$PLGratificacion3?>" />
		</td>
		<td colspan="2">SUBSIDIO PARA EL EMPLEO</td>
		<td>0099</td>
		<th colspan="2" class="text-center">LA LEY DE I.S.R.</th>
	</tr>
	<tr>
		<td>MATERIAL DIDÁCTICO</td>
		<td colspan="2" class="text-right">
			<?=number_format($PLMaterial_dicactico3,2)?>
			<input type="hidden" name="FMaterial_dicactico3" value="<?=$PLMaterial_dicactico3?>" />
		</td>
		<td colspan="2">% 4.625 ISSEMYM</td>
		<td>5540</td>
		<th colspan="2" class="text-right"><?=number_format($issemim46,2)?></th>
	</tr>
	<tr>
		<td>DESPENSA</td>
		<td colspan="2" class="text-right">
			<?=number_format($PLDespensa3,2)?>
			<input type="hidden" name="FDespensa3" value="<?=$PLDespensa3?>" />
		</td>
		<td colspan="2">% 6.1 ISSEMYM</td>
		<td>5541</td>
		<th colspan="2" class="text-right"><?=number_format($issemim61,2)?></th>
	</tr>
	<tr>
		<td>EFICIENCIA EN EL TRABAJO</td>
		<td colspan="2" class="text-right">
			<?=number_format($PLEficiencia3,2)?>
			<input type="hidden" name="FEficiencia3" value="<?=$PLEficiencia3?>" />
		</td>
		<td colspan="2">% 1.4 ISSEMYM</td>
		<td>5542</td>
		<th colspan="2" class="text-right"><?=number_format($issemim14,2)?></th>
	</tr>
	<tr>
		<th class="text-right">SUBTOTAL</tH>
		<th colspan="2">
			$ <div class="pull-right"><?=number_format($PLTotal_bruto3,2)?></div>
			<input type="hidden" name="FTotal_bruto3" value="<?=$PLTotal_bruto3?>" />
		</th>
		<th colspan="3" class="text-right">SUBTOTAL</th>
		<th colspan="2">$ <div class="pull-right"><?=number_format($issemim3,2)?></div></th>
	</tr>
	<tr>
		<th class="text-right">TOTAL DE PERCEPCIONES</tH>
		<th colspan="2">$ <div class="pull-right"><?=number_format($PLTotal_bruto1 + $PLTotal_bruto2 + $PLTotal_bruto3,2)?></td></th>
		<th colspan="3" class="text-right">TOTAL DE DEDUCCIONES</th>
		<th colspan="2">$ <div class="pull-right"><?=number_format($issemim1 + $issemim2 + $issemim3,2)?></td></th>
	</tr>
</table>