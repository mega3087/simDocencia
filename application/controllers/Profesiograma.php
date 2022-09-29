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
        $data['plantel'] = $this->plantel_model->get(get_session('UPlantel'));
        $data['CPLTipo'] = $data['plantel']['CPLTipo'];

        $selectGrado = 'id_gradoestudios, grado_estudios';
        $this->db->where('activo','1');
        $data['GradoEstudio'] = $this->gradoestudios_model->find_all(null, $selectGrado);;
        
        
        
        $this->db->join('nogradoestudios','id_gradoestudios = LIdentificador');
        $this->db->order_by('LIdentificador','ASC');
        $this->db->order_by('Licenciatura','ASC');
        $data['lics'] = $this->licenciaturas_model->find_all();
        
        foreach ($data['lics'] as $l => $listLic) {
            $selectMat = 'id_materia, materia, modulo, semmat, plan_estudio, activo';
            if ($data['plantel']['CPLTipo'] == '35') {
                $CPLTipo = '1';
                $this->db->where('plan_estudio', $CPLTipo);
            } elseif ($data['plantel']['CPLTipo'] == '36') {
                $CPLTipo = '2';
                $this->db->where('plan_estudio', $CPLTipo);
            }
            //$idmaterias = explode(',',$listLic['LIdmateria']);
            $this->db->where_in('id_materia',$listLic['LIdmateria'],false);
            $this->db->where('activo','1');
            $this->db->order_by('plan_estudio','ASC');
            $this->db->order_by('semmat','ASC');
            $data['lics'][$l]['materias'] =$this->materias_model->find_all(null, $selectMat);

        }
      
        $data['modulo'] = $this->router->fetch_class();
        $data['subvista'] = 'profesiograma/Mostrar_view';

        $this->load->view('plantilla_general', $data);        
    }

    public function mostrarBusqueda_skip() {
        $data = array();
        $plantel = $_POST['plantel'];
        $sem = $_POST['sem'];
        $materia = $_POST['materia'];
        
        $this->db->join('nogradoestudios','id_gradoestudios = LIdentificador');
        if ($materia != ''){
            $this->db->where("FIND_IN_SET('".$materia."',LIdmateria) != ''");
        } 
        $this->db->order_by('LIdentificador','ASC');
        $this->db->order_by('Licenciatura','ASC');
        $data['lics'] = $this->licenciaturas_model->find_all();

        foreach ($data['lics'] as $l => $listLic) {

            $selectMat = 'id_materia, materia, modulo, semmat, plan_estudio, activo';
            if ($sem != ''){
                $this->db->where('semmat', $sem);
            } 
            if ($materia != ''){
                $this->db->where_in('id_materia',$materia,false);
            } else {
                $this->db->where_in('id_materia',$listLic['LIdmateria'],false);
            }
            if ($plantel == '35') {
                $CPLTipo  = '1';
                $this->db->where('plan_estudio', $CPLTipo);
            } elseif ($plantel == '36') {
                $CPLTipo = '2';
                $this->db->where('plan_estudio', $CPLTipo);
            }        
 
            $this->db->where('activo','1');
            $this->db->order_by('plan_estudio','ASC');
            $this->db->order_by('semmat','ASC');
            $data['lics'][$l]['materias'] =$this->materias_model->find_all(null, $selectMat);

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

        $data['plantel'] = $this->plantel_model->get(get_session('UPlantel'));
        
        $data['materias'] = array();        
        
        $selectMat = 'id_materia, materia, modulo, semmat, plan_estudio, activo';
        if ($data['plantel']['CPLTipo'] == '35') {
            $CPLTipo = '1';
            $this->db->where('plan_estudio', $CPLTipo);
        } elseif ($data['plantel']['CPLTipo'] == '36') {
            $CPLTipo = '2';
            $this->db->where('plan_estudio', $CPLTipo);
        }

        if($planEstudio != '0'){
            $this->db->where('plan_estudio',$planEstudio);
        }
        
        if (count($GPSemestre) > 0) {
            $this->db->where_in('semmat', $GPSemestre);
        } 

        $this->db->where('activo','1');
        $this->db->order_by('semmat','ASC');
        $data['materias'] = $this->materias_model->find_all(null, $selectMat); 

        ?>
        <label class="col-lg-3 control-label" for="">Materias:<em>*</em></label>
        <div class="col-lg-9" id="UIdMaterias">
            <select name="UIdMateria[]" id="UIdMateria" class="form-control chosen-select" multiple="" data-placeholder="Seleccionar Materias">
                <?php foreach($data['materias'] as $key_p => $listMat) { 
                    if($listMat['plan_estudio'] == '1') { $plantel = 'Plantel'; } else { $plantel = 'CEMSAD'; } 
                ?>
                <option value="<?=$listMat['id_materia']?>"><?=$listMat['materia'].'-'.$plantel; ?></option>
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

    public function materias_skip () {
        $IdLicenciatura =  $this->input->post('IIdLicenciatura');
        $GPSemestre =  $this->input->post('semestre');
        $planEstudio = $this->input->post('planEstudio');

        $data['plantel'] = $this->plantel_model->get(get_session('UPlantel'));

        $data['materias'] = array();        

        $this->db->where('IdLicenciatura',$IdLicenciatura);
        $ids = $this->licenciaturas_model->find();
        
        $selectMat = 'id_materia, materia, modulo, semmat, plan_estudio, activo';
        if ($data['plantel']['CPLTipo'] == '35') {
            $CPLTipo = '1';
            $this->db->where('plan_estudio', $CPLTipo);
        } elseif ($data['plantel']['CPLTipo'] == '36') {
            $CPLTipo = '2';
            $this->db->where('plan_estudio', $CPLTipo);
        }

        if($planEstudio != '0'){
            $this->db->where('plan_estudio',$planEstudio);
        }
        
        if (count($GPSemestre) > 0) {
            $this->db->where_in('semmat', $GPSemestre);
        }

        $this->db->where_not_in('id_materia', $ids['LIdmateria'], false);
        $this->db->where('activo','1');
        $this->db->order_by('semmat','ASC');
        $data['materias'] = $this->materias_model->find_all(null, $selectMat); 

        ?>
        <label class="col-lg-3 control-label" for="">Materias:<em>*</em></label>
        <div class="col-lg-9" id="UIdMaterias">
            <select name="UIdMateria[]" id="UIdMateria" class="form-control chosen-select" multiple="" data-placeholder="Seleccionar Materias">
                <?php foreach($data['materias'] as $key_p => $listMat) { 
                    if($listMat['plan_estudio'] == '1') { $plantel = 'Plantel'; } else { $plantel = 'CEMSAD'; } 
                ?>
                <option value="<?=$listMat['id_materia']?>"><?=$listMat['materia'].'-'.$plantel; ?></option>
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
            } elseif ($data['UGradoEstudio'] == '6') {
                $datos['LGradoEstudio'] = 'Técnico';
            } elseif ($data['UGradoEstudio'] == '7') {
                $datos['LGradoEstudio'] = 'Maestría';
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
            } elseif ($data['UGradoEstudio'] == '6') {
                $datos['LGradoEstudio'] = 'Técnico';
            } elseif ($data['UGradoEstudio'] == '7') {
                $datos['LGradoEstudio'] = 'Maestría';
            } 
            $datos['LIdentificador'] = $data['UGradoEstudio'];
            $datos['Licenciatura'] = $data['ULicenciatura_'];      

            $this->licenciaturas_model->update($data['IIdLicenciatura'],$datos);

            set_mensaje("Los datos se guardaron correctamente",'success::');
            echo "OK::";
            muestra_mensaje();
        }
    }

    public function delete() {
        $idLic = $this->input->post('idLic');
        $idMateria = $this->input->post('idMateria');

        $this->db->where('idLicenciatura',$idLic);
        $datos = $this->licenciaturas_model->find();

        $ids = explode(',', $datos['LIdmateria']);
        if (count($ids) == 1 ) {
            echo "aqui";
            $data['LIdmateria'] = '';
            } else {
            foreach ($ids as $k => $listMat) {
                if ($listMat != $idMateria) {
                    $result[$k] = $listMat;
                    $results = implode(',', $result);
                    $data['LIdmateria'] = $results;
                }
            }
        }
            
        $this->licenciaturas_model->update($idLic, $data);

        set_mensaje("Los materia se elimino correctamente.");
        muestra_mensaje();
        echo "::OK";
    }

    function save_materias_skip() {
        $data = array();    $datos = array(); 

        $data= post_to_array('_skip');

        if ($data['UGradoEstudio'] == '' || $data['ULicenciatura_'] == ''|| $data['UPlanEstudio'] == '' || nvl($data['SemestreMat']) == '' || nvl($data['UIdMateria']) == '' ) {
            set_mensaje("Favor de ingresar todos los datos requeridos.");
            muestra_mensaje();
        } else {

            $this->db->where('IdLicenciatura',$data['IIdLicenciatura']);
            $ids = $this->licenciaturas_model->find();

            $materias = implode(',', $data['UIdMateria']);
            $datos['LIdmateria'] = $ids['LIdmateria'].','.$materias;
            
            $this->licenciaturas_model->update($data['IIdLicenciatura'],$datos);

            set_mensaje("Los datos se guardaron correctamente",'success::');
            muestra_mensaje();
            echo "::OK";
        }
    }
}
?>