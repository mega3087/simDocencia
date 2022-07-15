<p class="text-left" style="font-size: 10px; color: #333;"><b>PLANTEL Y/O CEMSAD: <?= $plantel[0]['CPLNombre']; ?></b></p>
<p class="text-center" style="font-size: 10px; color: #333;"><b>FORMATO DE NÚMERO DE GRUPOS</b></p>

<table width="100%">
    <tr>
        <th class="text-center" rowspan="2">SEMESTRE</th>
        <th class="text-center" rowspan="2">NÚMERO DE GRUPOS</th>
        <th class="text-center" colspan="2">TURNO</th>
        <th class="text-center" rowspan="2">CAPACITACIÓN</th>
        <th class="text-center" rowspan="2">NÚMERO DE ALUMNOS POR GRUPO</th>
    </tr>   
    <tr>
        <th class="text-center">MATUTINO</th>
        <th class="text-center">VESPERTINO</th>
        
    </tr>
    	<?php for ($x=0; $x < count($total); $x++) { ?>
    	<tr>
    		<th><?= $total[$x]['GRSemestre'] ?>° SEMESTRE</th>
    		<td>
    			<table style="width:100%;" class="no-border-bottom no-border-top no-border-left no-border-right">
    				<?php for ($i=0; $i < count($total[$x]['grupos']); $i++) { ?>
    					<tr><td class="text-center"><?= $total[$x]['grupos'][$i]['GRGrupo']; ?></td></tr>
		    		<?php } ?>
    			</table>
    		</td>
    		<td>
    			<table style="width:100%;" class="no-border-bottom no-border-top no-border-left no-border-right">
    				<?php for ($m=0; $m < count($total[$x]['grupos']); $m++) { ?>
    					<tr><td class="text-center">
    					<?php if ($total[$x]['grupos'][$m]['GRTurno'] == 1) { ?>
    						1
    					<?php } else { ?>
    						&nbsp;
    					<?php } ?>
    					</td></tr>
		    		<?php } ?>
    			</table>
    		</td>

    		<td>
    			<table style="width:100%;" class="no-border-bottom no-border-top no-border-left no-border-right">
    				<?php for ($v=0; $v < count($total[$x]['grupos']); $v++) { ?>
    					<tr><td class="text-center">
    					<?php if ($total[$x]['grupos'][$v]['GRTurno'] == 2) { ?>
    						1
    					<?php } else { ?>
    						&nbsp;
    					<?php } ?>
    					</td></tr>
		    		<?php } ?>
    			</table>
    		</td>
    		
    		<td>
    			<table style="width:100%;" class="no-border-bottom no-border-top no-border-left no-border-right">
    				<?php for ($n=0; $n < count($total[$x]['grupos']); $n++) { ?>
    					<tr><td class="text-left" width="150px">
    					<?php if ($total[$x]['grupos'][$n]['CCANombre'] != '') { ?>
    							<?= $total[$x]['grupos'][$n]['CCANombre']; ?>
    					<?php } else { ?>
    						&nbsp;
    					<?php } ?>
    					</td></tr>
		    		<?php } ?>
    			</table>
    		</td>
    		<td>
    			<table style="width:100%;" class="no-border-bottom no-border-top no-border-left no-border-right">
    				<?php for ($c=0; $c < count($total[$x]['grupos']); $c++) { ?>
    					<tr>
							<?php if ($total[$x]['grupos'][$c]['GRCupo'] != ''){ ?>
							<td class="text-center"><?= $total[$x]['grupos'][$c]['GRCupo']; ?></td>
							<?php } else { ?>
								<td class="text-center">0</td>
							<?php } ?>
						</tr>
		    		<?php } ?>
    			</table>
    		</td>
    	</tr>
    	<?php } ?>
</table>
<style type="text/css">
  table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  color: #333;

}

.no-border { 
    border:none !important; 
     
}

.border-bottom { border-bottom: 1px solid black; border-collapse: collapse;}
.border-top { border-top: 1px solid black; border-collapse: collapse;}

.no-border-left     { border-left: hidden !important; }
.no-border-right    { border-right: hidden !important; }
.no-border-top      { border-top: hidden !important; }
.no-border-bottom   { border-bottom: hidden !important; }

</style>