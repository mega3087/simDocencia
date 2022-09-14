<?php

class Profesiograma extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        if (!is_login()) // Verificamos que el usuario este logeado
            redirect('login');

        if (!is_permitido()) //  Verificamos que el usuario tenga permisos
            redirect('usuario/negar_acceso');
    }//fin del constructor

    function index() {
               
        $data['idMat'] = '';//$_POST['materia'];
        $data['CPLTipo'] = get_session('CPLTipo');
        
        $selectGrado = 'id_gradoestudios, grado_estudios';
        $this->db->where('activo','1');
        $data['GradoEstudio'] = $this->gradoestudios_model->find_all(null, $selectGrado);;
        
        $selectMat = 'id_materia, materia, modulo, semmat, plan_estudio, activo';
        if (get_session('CPLTipo') == '35') {
            $CPLTipo = '1';
            $this->db->where('plan_estudio', $CPLTipo);
        } elseif (get_session('CPLTipo') == '36') {
            $CPLTipo = '2';
            $this->db->where('plan_estudio', $CPLTipo);
        }
        
        $this->db->where('activo','1');
        $this->db->order_by('semmat','ASC');
        $data['materias'] = $this->materias_model->find_all(null, $selectMat); 
        
        foreach ($data['materias'] as $m => $mat) {            
            $selectLic = '*';
            $this->db->join('nogradoestudios','id_gradoestudios = LIdentificador');
            $this->db->where("FIND_IN_SET('".$mat["id_materia"]."',LIdmateria)!=''");
            $data['materias'][$m]['lics'] = $this->licenciaturas_model->find_all(null, $selectLic);
        }

        /*$selectLic = '*';
        $this->db->where("LIdmateria != ''");
        $data['lics'] = $this->licenciaturas_model->find_all(null, $selectLic);
        foreach ($data['lics'] as $l => $lics) {   
            for ($i=0; $i <= count($lics['LIdmateria']); $i++) { 
                $idMat = explode(',',$lics['LIdmateria']);
                
                $selectMat = 'id_materia, materia, modulo, semmat, plan_estudio, activo';
                $this->db->where('id_materia',$idMat[$i]);
                $this->db->where('activo','1');
                $this->db->order_by('semmat','ASC');
                $data['lics'][$l]['materias'][$i] = $this->materias_model->find_all(null, $selectMat);
            }

        }*/
        $data['modulo'] = $this->router->fetch_class();
        $data['subvista'] = 'profesiograma/Mostrar_view';

        $this->load->view('plantilla_general', $data);        
    }

    public function mostrarBusqueda_skip() {
        $data = array();
        $plantel = $_POST['plantel'];
        $sem = $_POST['sem'];
        $materia = $_POST['materia'];

        $selectMat = 'id_materia, materia, modulo, semmat, plan_estudio, activo';
        if ($sem != ''){
            $this->db->where('semmat', $sem);
        } 
        if ($materia != ''){
            $this->db->where('id_materia', $materia);
        } 
        if ($plantel == '35') {
            $CPLTipo  = '1';
            $this->db->where('plan_estudio', $CPLTipo);
        } elseif ($plantel == '36') {
            $CPLTipo = '2';
            $this->db->where('plan_estudio', $CPLTipo);
        }        
        $this->db->where('activo','1');
        $this->db->order_by('semmat','ASC');
        
        $data['materias'] = $this->materias_model->find_all(null, $selectMat);
               
        foreach ($data['materias'] as $m => $mat) {
            $selectLic = '*';
            $this->db->where("FIND_IN_SET('".$mat["id_materia"]."',LIdmateria) != ''");
            $data['materias'][$m]['lics'] = $this->licenciaturas_model->find_all(null, $selectLic);
        }
        
        $this->load->view('profesiograma/Mostrar_Materias', $data);      
    }

    public function mostrarMat_skip () {
        $sem = $this->input->post('sem');
        $plantel = $_POST['plantel'];

        $materias = array();
        $selectMat = 'id_materia, materia, modulo, semmat, plan_estudio, activo';
        if ( $plantel == '35') {
            $CPLTipo = '1';
            $this->db->where('plan_estudio', $CPLTipo);
        } elseif ($plantel == '36') {
            $CPLTipo = '2';
            $this->db->where('plan_estudio', $CPLTipo);
        }        
        $this->db->where('semmat', $sem);
        $this->db->where('activo','1');
        $this->db->order_by('semmat','ASC');
        $materias = $this->materias_model->find_all(null, $selectMat);
        
        ?>
        <select name="materia" id="idMateria" class="form-control">
            <option selected value="">Todos</option>
            <?php foreach($materias as $key => $listMat){ ?>
            <option value="<?php echo $listMat['id_materia']; ?>"><?=$listMat['materia']?></option>
            <?php  } ?>
        </select>
        <?php

    }

    //Agregar Profesión Nueva
    public function mostrarMaterias_skip () {
        $GPSemestre =  $this->input->post('semestre');
        $planEstudio = $this->input->post('planEstudio');
        
        $data['materias'] = array();
        
        $selectMat = 'id_materia, materia, modulo, semmat, plan_estudio, activo';
        if (get_session('CPLTipo') == '35') {
            $CPLTipo = '1';
            $this->db->where('plan_estudio', $CPLTipo);
        } elseif (get_session('CPLTipo') == '36') {
            $CPLTipo = '2';
            $this->db->where('plan_estudio', $CPLTipo);
        }
        
        if (count($GPSemestre) > 0) {
            $this->db->where_in('semmat', $GPSemestre);
        } 

        $this->db->where('activo','1');
        $this->db->where('plan_estudio',$planEstudio);
        $this->db->order_by('semmat','ASC');
        $data['materias'] = $this->materias_model->find_all(null, $selectMat); 

        ?>
        <label class="col-lg-3 control-label" for="">Materias:<em>*</em></label>
        <div class="col-lg-9" id="UIdMaterias">
            <select name="UIdMateria[]" id="UIdMateria" class="form-control chosen-select" multiple="" data-placeholder="Seleccionar Materias">
                <?php foreach($data['materias'] as $key_p => $listMat){ ?>
                <option value="<?=$listMat['id_materia']?>"><?=$listMat['materia'].' '.$listMat['modulo']; ?></option>
                <?php } ?>
            </select>
        </div>
        
        <script type="text/javascript">
	    $(document).ready(function() {
            $('.chosen-select').chosen();            
        });
        </script>
        <?php
    }

    function save() {
        $data = array();    $datos = array(); 

        $data= post_to_array('_skip');

        if ($data['UGradoEstudio'] == '' || $data['ULicenciatura_'] == ''|| $data['UPlanEstudio'] == '' || $data['SemestreMat'] == '' || $data['UIdMateria'] == '' ) {
            set_mensaje("Favor de ingresar todos los datos requeridos.");
            muestra_mensaje();
        } else {
            $datos['Licenciatura'] = $data['ULicenciatura_'];
                        
            if ($data['UGradoEstudio'] == '1') {
                $datos['LGradoEstudio'] = 'Licenciatura';
            } elseif ($data['UGradoEstudio'] == '2') {
                $datos['LGradoEstudio'] = 'Ingeniería';
            } elseif ($data['UGradoEstudio'] == '3') {
                $datos['LGradoEstudio'] = 'Certificaciones';
            } elseif ($data['UGradoEstudio'] == '4') {
                $datos['LGradoEstudio'] = 'Posgrado';
            } elseif ($data['UGradoEstudio'] == '5') {
                $datos['LGradoEstudio'] = 'Perfil';
            }
            $datos['LIdentificador'] = $data['UGradoEstudio'];
            $datos['LIdmateria'] = implode(',', $data['UIdMateria']);

            $this->licenciaturas_model->insert($datos);

            set_mensaje("Los datos se guardaron correctamente",'success::');
            echo "OK::";
            muestra_mensaje();
        }
    }

    public function update() {
        $data = array();    $datos = array();
        $data= post_to_array('_skip'); 
        
        if ($data['UGradoEstudio'] == '' || $data['ULicenciatura_'] == '') {
            set_mensaje("Favor de ingresar todos los datos requeridos.");
            muestra_mensaje();
        } else {
            
            if ($data['UGradoEstudio'] == '1') {
                $datos['LGradoEstudio'] = 'Licenciatura';
            } elseif ($data['UGradoEstudio'] == '2') {
                $datos['LGradoEstudio'] = 'Ingeniería';
            } elseif ($data['UGradoEstudio'] == '3') {
                $datos['LGradoEstudio'] = 'Certificaciones';
            } elseif ($data['UGradoEstudio'] == '4') {
                $datos['LGradoEstudio'] = 'Posgrado';
            } elseif ($data['UGradoEstudio'] == '5') {
                $datos['LGradoEstudio'] = 'Perfil';
            }
            $datos['LIdentificador'] = $data['UGradoEstudio'];
            $datos['Licenciatura'] = $data['ULicenciatura_'];      

            $this->licenciaturas_model->update($data['IIdLicenciatura'],$datos);

            set_mensaje("Los datos se guardaron correctamente",'success::');
            echo "OK::";
            muestra_mensaje();
        }
    }
}
?>