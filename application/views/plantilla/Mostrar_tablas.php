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
                <td class="text-left"><?php echo $list['UNombre']." ".$list['UApellido_pat']." ".$list['UApellido_mat']; ?></td>
                <td class="text-left"><?php echo $list['UCorreo_electronico']; ?></td>
                <td class="text-left"><?php echo $list['URFC']; ?></td>
                <td class="text-left"><?php echo $list['UCURP']; ?></td>								
                <td class="text-center"><input type="checkbox" name="idUsuario" id="idUsuario<?php echo $list['UNCI_usuario'];?>" value="<?php echo $list['UNCI_usuario'];?>" class="only-one"></td>
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
</script>