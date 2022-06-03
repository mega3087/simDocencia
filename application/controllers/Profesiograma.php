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
        
        
        $selectGrado = 'LGradoEstudio';
        $this->db->group_by('LGradoEstudio');
        $data['GradoEstudio'] = $this->licenciaturas_model->find_all(null, $selectGrado);;

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
            $this->db->where("FIND_IN_SET('".$mat["id_materia"]."',LIdmateria) != ''");
            $data['materias'][$m]['lics'] = $this->licenciaturas_model->find_all(null, $selectLic);
            
        }
        $data['modulo'] = $this->router->fetch_class();
        $data['subvista'] = 'profesiograma/Mostrar_view';

        $this->load->view('plantilla_general', $data);        
    }

    public function mostrarBusqueda() {
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

    public function mostrarMat () {
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
    public function mostrarMaterias () {
        $GPSemestre =  $this->input->post('sem');
        $data['materias'] = array();
        
        $selectMat = 'id_materia, materia, modulo, semmat, plan_estudio, activo';
        if (get_session('CPLTipo') == '35') {
            $CPLTipo = '1';
            $this->db->where('plan_estudio', $CPLTipo);
        } elseif (get_session('CPLTipo') == '36') {
            $CPLTipo = '2';
            $this->db->where('plan_estudio', $CPLTipo);
        }
        if ($GPSemestre != '') {
        $this->db->where('semmat',$GPSemestre);
        }            
        $this->db->where('activo','1');
        $this->db->order_by('semmat','ASC');
        $data['materias'] = $this->materias_model->find_all(null, $selectMat); 

        ?>
        <select name="PMateria" id="Materia" class="resultMaterias form-control">
            <option value="">- Seleccionar Materia -</option>
            <?php foreach ($data['materias']  as $k => $listMat) { ?>
                <option value="<?= $listMat['id_materia']; ?>"><?= $listMat['materia']; ?></option>
            <?php } ?>
        </select>                       
        <?php
    }

    public function guardarProfesion() {
        $data = array();    $datos = array();   $materias = array();   $profesiones = array();
            
        $data= post_to_array('_skip');

        if ($data['PMateria'] != '') {
            $selectMat = 'materia';
            $this->db->where('id_materia', $data['PMateria']);
            $PMateria = $this->materias_model->find_all(null, $selectMat);
        }
        

        $datos['PMateria'] = $PMateria[0]['materia'];
        $datos['Licenciatura'] = $data['Licenciatura'];
        $datos['PTipo'] = $data['PLTipo'];
        $datos['LIdentificador'] = $data['PMateria'];
        $datos['PActivo'] = '1';
        
        if ($data['PLTipo'] == '' || $data['Licenciatura'] == ''|| $data['GPSemestre'] == '' || $data['PMateria'] == '' ) {
            set_mensaje("Favor de ingresar todos los datos requeridos.");
            muestra_mensaje();
        } else {
            $id = $this->licenciaturas_model->insert($datos);

            $selectMat = '*';
            $this->db->where('idMateria', $data['PMateria']);
            $materias = $this->profesionmateria_model->find_all(null, $selectMat);

            foreach ($materias as $x => $mat) {
                if ($mat['idProfesion'] == '') {
                    $profesiones['idProfesion'] =  $id;
                    $profesiones['mat_identificador'] =  $data['PMateria'];
                    $this->profesionmateria_model->update($mat['idProMat'],$profesiones);
                } else {
                    $profesiones['idProfesion'] =  $materias[0]['idProfesion'].','.$id;
                    $profesiones['mat_identificador'] =  $data['PMateria'];
                    $this->profesionmateria_model->update($mat['idProMat'],$profesiones);
                }
            }
            set_mensaje("Los datos se guardaron correctamente",'success::');
            echo "OK;";
            muestra_mensaje();
        }
        echo ";".$data['PMateria'];
    }
}
?>