<table class="table table-striped table-bordered table-hover dataTables-example" >
    <thead>
        <tr>
            <th>#</th>
            <th>Docente</th>
            <th>Correo Electrónico</th>
            <th>RFC</th>
            <th>CURP</th>
            <th width="130px">Seleccionar</th>
        </tr>	
    </thead>
    <tbody>
    <?php 
        $i = 1;
        foreach($docentes as $key => $list){
        //$borrar = "<button type='button' value=".$UNCI_usuario_skip." class='btn btn-sm btn-danger quitarDocente'><i class='fa fa-trash'></i> Quitar</button>"; ?>
            <tr>
                <td class="text-center"><?php echo $i; ?></td> 
                <td class="text-left"><?php echo mb_strtoupper($list['UNombre']." ".$list['UApellido_pat']." ".$list['UApellido_mat'],'utf-8'); ?></td>
                <td class="text-left"><?php echo $list['UCorreo_electronico']; ?></td>
                <td class="text-left"><?php echo $list['URFC']; ?></td>
                <td class="text-left"><?php echo $list['UCURP']; ?></td>
                <td class="text-center">
                <?php if ($list['UDValidado'] == '1' &&  is_permitido(null,'generarplantilla','save')) { ?>
                    <button class="btn btn-primary btn-xs" type="button" onclick="asignar('<?php echo $list['UNCI_usuario'];?>', '<?php echo $list['UDTipo_Nombramiento'];?>')" name="idUsuario" id="idUsuario<?php echo $list['UNCI_usuario'];?>" value="<?php echo $list['UNCI_usuario'];?>">
                    <i class="fa fa-pencil"></i> Asignar Materias</button>
                <?php } if ($list['UDValidado'] == '1' && is_permitido(null,'generarplantilla','validar')) { ?>
                    <b class="text-success"><i class="fa fa-clock-o"></i> Asignando Materias</b>
                <?php } if ($list['UDValidado'] == '2') { ?>
                    <b class="text-info"><i class="fa fa-check"></i> Materias Asignadas</b>
                <?php } if ($list['UDValidado'] == '3') { ?>
                    <b class="text-warning"><i class="fa fa-clock-o"></i> Pendiente por Revisar</b>
                <?php } elseif ($list['UDValidado'] == '4') { ?>
                    <button class="btn btn-danger btn-xs" type="button" onclick="asignar('<?php echo $list['UNCI_usuario'];?>', '<?php echo $list['UDTipo_Nombramiento'];?>')" name="idUsuario" id="idUsuario<?php echo $list['UNCI_usuario'];?>" value="<?php echo $list['UNCI_usuario'];?>">
                    <i class="fa fa-pencil"></i> Editar</button>
                <?php } elseif ($list['UDValidado'] == '5') { ?>
                    <b class="text-success"><i class="fa fa-check"></i> Aprobado</b>
                <?php } ?>
                </td>
            </tr>
    <?php $i++; } ?>
    </tbody>
</table>

<script src="<?php echo base_url('assets/inspinia/js/plugins/dataTables/datatables.min.js'); ?>"></script>

<script type="text/javascript">
	$(document).ready(function() {
		/* Page-Level Scripts */
		$('.dataTables-example').DataTable({
			"language": {
				"url": "<?php echo base_url("assets/datatables_es.json"); ?>"
			},
			dom: '<"html5buttons"B>lTfgitp',
			"lengthMenu": [ [20,50,100, -1], [20,50,100, "Todos"] ],
			buttons: []
		});	

        //The class name can vary
        let Checked = null;
        for (let CheckBox of document.getElementsByClassName('only-one')){
            CheckBox.onclick = function(){
                if(Checked != null) {
                Checked.checked = false;
                Checked = CheckBox;
                }
                Checked = CheckBox;
            }
        }

	});

    function asignar(idUser, UDTipo_Docente){ 
        var plantel = document.getElementById('plantelId').value;
        document.getElementById("idUsuario").value = idUser;
        var cicloEsc = document.getElementById('cicloEsc').value;
        
        if (cicloEsc == 2) {
            $(".mostrarMatPrimero").show();
            $(".mostrarMatTercero").show();
            $(".mostrarMatQuinto").show();
        } else {
            $(".mostrarMatSegundo").show();
            $(".mostrarMatCuarto").show();
            $(".mostrarMatSexto").show();
        }
        datosPlantilla(idUser);
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("GenerarPlantilla/asignarMaterias"); ?>",
            data: {idUser : idUser, plantel : plantel, UDTipo_Docente : UDTipo_Docente},
            dataType: "html",
            beforeSend: function(){
                //carga spinner
                $(".loadingasignar").html("<div class=\"spiner-example\"><div class=\"sk-spinner sk-spinner-three-bounce\"><div class=\"sk-bounce1\"></div><div class=\"sk-bounce2\"></div><div class=\"sk-bounce3\"></div></div></div>");
            },
            success: function(data){
                $(".mostrarAsignarMaterias").empty();
                $(".mostrarAsignarMaterias").append(data);  
                $(".loadingasignar").html("");
                $('.nav-tabs a[href="#agregar-materias"]').tab('show');
            }
        });

    }
</script>