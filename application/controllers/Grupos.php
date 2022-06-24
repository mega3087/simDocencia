<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grupos extends CI_Controller {
    public function __construct () {
        parent::__construct();
        if (!is_login()) // Verificamos que el usuario este logeado
            redirect('login');

        /*if (!is_permitido()) //  Verificamos que el usuario tenga permisos
            redirect('usuario/negar_acceso');*/
    }

    public function index() {
        $data = array();
        
        if( is_permitido(null,'grupos','ver_grupos')) {
            $this->db->where('CPLTipo', '35');
            $this->db->or_where('CPLTipo', '36');            
        } elseif( is_permitido(null,'grupos','ver_grupos_plantel')) { 
            $this->db->join('nousuario', 'UPlantel = CPLClave', 'left');
            $this->db->where('UNCI_usuario',get_session('UNCI_usuario'));
        }
        
        $data["planteles"] = $this->plantel_model->find_all();

        foreach ($data['planteles'] as $key => $listP) {
            $select = 'PCCapacitacion, CCAClave, CCANombre, CCAAbrev';
            $this->db->join('noplancap', 'CPLClave = PCPlantel','left');
            $this->db->join('noccapacitacion', 'PCCapacitacion = CCAClave','left');
            $this->db->where('PCPlantel',$listP['CPLClave']);
            $data['planteles'][$key]['capacitaciones'] = $this->plantel_model->find_all(null,$select);
        }
        
        $this->db->where('CPEStatus','1');

        $this->db->where('CPEStatus','1');
        $this->db->order_by('CPEPeriodo','DESC');
        $this->db->limit('10');
        $data['periodos'] = $this->periodos_model->find_all();
        
        $data['modulo'] = $this->router->fetch_class();
        $data['subvista'] = 'grupos/Mostrar_view';

        $this->load->view('plantilla_general', $data);
    }

    public function selectCap() {
        $data = array();
        $idPlantel = $this->input->post('idPlantel');
        $data['valorGrupo'] = $this->input->post('valorGrupo');
        
        $select = 'PCCapacitacion, CCAClave, CCANombre, CCAAbrev';
        $this->db->join('noplancap', 'CPLClave = PCPlantel','left');
        $this->db->join('noccapacitacion', 'PCCapacitacion = CCAClave','left');
        $this->db->where('PCPlantel',$idPlantel);
        
        $data['capacitaciones'] = $this->plantel_model->find_all(null,$select);

        $this->load->view('grupos/Mostrar_capacitaciones', $data);

    }

    public function save() {
        if(! $_POST)
            redirect( $this->router->fetch_class() );
                
        $data= post_to_array('_skip');
        
        //$this->_set_rules(); //validamos los datos
        $this->form_validation->set_rules('GRPeriodo', 'Periodo Escolar', "trim|required|min_length[4]|max_length[4]");
        $this->form_validation->set_rules('GRSemestre', 'Semestre', "trim|required|min_length[1]|max_length[1]");
        $this->form_validation->set_rules('GRGrupo', 'Grupo', "trim|required|min_length[3]|max_length[3]");
        $this->form_validation->set_rules('GRTurno', 'Turno', "trim|required|min_length[1]|max_length[1]");
        $this->form_validation->set_rules('GRCupo', 'No. de Alumnos', "trim|required|min_length[1]|max_length[2]");
        
        if ($data['GRSemestre'] > 2) {
            $this->form_validation->set_rules('claves', 'Capacitación', "trim|required|min_length[1]|max_length[1]");  
        }
        if($this->form_validation->run() === FALSE) {
            set_mensaje(validation_errors());
            muestra_mensaje();
        } else {
            $result = array();
            $grupos = array();
            if (substr($data['GRPeriodo'], -1) == 2) {
                if ($data['GRSemestre'] == 1 || $data['GRSemestre'] == 3 || $data['GRSemestre'] == 5) {
                    if ($data['GRSemestre'] == $data['GRGrupo'][0]) {
                            $insert['GRCClave'] = $data['claves'];
                        
                        if ($data['CPLTipo'] == '35') {
                            $insert['GRPMat'] = '7';
                        } elseif ($data['CPLTipo'] == '36') {
                            $insert['GRPMat'] = '9';
                        }
                        
                        $insert['GRPeriodo'] = $data['GRPeriodo'];
                        $insert['GRSemestre'] = $data['GRSemestre'];
                        $insert['GRGrupo'] = $data['GRGrupo'];                        
                        $insert['GRTurno'] = $data['GRTurno'];
                        $insert['GRCupo'] = $data['GRCupo'];
                        $insert['GRCPlantel'] = $data['GRCPlantel'];
                        $insert['GRStatus'] = "1";
                        $insert['GRFechaRegistro'] = date('Y-m-d H:i:s');
                        $insert['GRUsuarioRegistro'] = get_session('UNCI_usuario');
                        
                        $this->grupos_model->insert($insert);

                        set_mensaje("El nuevo grupo se agrego con correctamente",'success::');
                        echo "OK;";
                        muestra_mensaje();
                    } else {
                        set_mensaje("El grupo no es correcto al semestre.");
                        muestra_mensaje(); 
                    }
                } else {
                    set_mensaje("El semestre no corresponde al periodo correcto.");
                    muestra_mensaje(); 
                }
            } 
            if (substr($data['GRPeriodo'], -1) == 1) {
                if ($data['GRSemestre'] == 2 || $data['GRSemestre'] == 4 || $data['GRSemestre'] == 6) {
                    if ($data['GRSemestre'] == $data['GRGrupo'][0]) {
                            $insert['GRCClave'] = $data['claves'];
                        
                        if ($data['CPLTipo'] == '35') {
                            $insert['GRPMat'] = '7';
                        } elseif ($data['CPLTipo'] == '36') {
                            $insert['GRPMat'] = '9';
                        }

                        $insert['GRPeriodo'] = $data['GRPeriodo'];
                        $insert['GRSemestre'] = $data['GRSemestre'];
                        $insert['GRGrupo'] = $data['GRGrupo'];                        
                        $insert['GRTurno'] = $data['GRTurno'];
                        $insert['GRCupo'] = $data['GRCupo'];
                        $insert['GRCPlantel'] = $data['GRCPlantel'];
                        $insert['GRStatus'] = "1";
                        $insert['GRFechaRegistro'] = date('Y-m-d H:i:s');
                        $insert['GRUsuarioRegistro'] = get_session('UNCI_usuario');
                        
                        $id = $this->grupos_model->insert($insert);
                        set_mensaje("El nuevo grupo se agrego con correctamente",'success::');
                        echo "OK;";
                        muestra_mensaje();
                    } else {
                        set_mensaje("El grupo no es correcto al semestre.");
                        muestra_mensaje(); 
                    }
                } else {
                    set_mensaje("El semestre no corresponde al periodo correcto.");
                    muestra_mensaje(); 
                }
            }
        }
        echo ";".$data['GRCPlantel'];
    }

    public function selectGrupos() {
        $GRCPlantel = $this->input->post('GRCPlantel');
        $this->db->where('GRCPlantel',$GRCPlantel);
        $this->db->where('GRStatus','1');
        
        $data['data'] = $this->grupos_model->find_all();
        $this->load->view('grupos/Mostrar_grupos', $data);
    }

    public function deleteGrupo() {
        $GRClave = $this->encrypt->decode($this->input->post('GRClave'));
        $data = array(
            'GRStatus' => '0',
            'GRFechaInactivo' => date('Y-m-d H:i:s'),
            'GRUsuarioModificacion' => get_session('UNCI_usuario')
        );
        $this->grupos_model->update($GRClave,$data);
        set_mensaje("EL grupo se elimino con éxito",'success::');
        muestra_mensaje();
        
        $GRCPlantel = $this->input->post('PlantelId');
        $this->db->where('GRCPlantel',$GRCPlantel);
        $this->db->where('GRStatus','1');
        $data['data'] = $this->grupos_model->find_all();            
        $this->load->view('grupos/Mostrar_grupos', $data);

    }

    public function listaGrupos() {
        $data = array();
        $GRCPlantel = $this->input->post('idPlantel');
        $GRPeriodo = $this->input->post('periodo');
        
        
        $select = 'COUNT(GRSemestre) noGrupos, GRSemestre';
        $this->db->where('GRCPlantel', $GRCPlantel);
        $this->db->where('GRPeriodo', $GRPeriodo);
        $this->db->group_by('GRSemestre');
        $data['total'] = $this->grupos_model->find_all(null, $select);
        
        foreach ($data['total'] as $key => $listTot) {
            $select = "GRClave, GRGrupo, GRSemestre, CCANombre, CCAAbrev, GRCClave, GRCupo, GRTurno";
            $this->db->join('noccapacitacion', 'CCAClave = GRCClave','left');
            //$this->db->join('nomaterias', 'CCAAbrev = MATAbrev','left');
            if($listTot['GRSemestre'] > 2) {
                $this->db->where('GRSemestre', $listTot['GRSemestre']);
            } 
            $this->db->where('GRPeriodo', $GRPeriodo);
            $this->db->where('GRSemestre', $listTot['GRSemestre']);
            $this->db->where('GRCPlantel', $GRCPlantel);
            $this->db->group_by('GRClave');
            $data['total'][$key]['grupos'] = $this->grupos_model->find_all(null, $select);
        }
        
        $this->load->view('grupos/Mostrar_periodo_grupos', $data);
    }

    public function ImprimirGrupos($idPlantel = null, $periodo = null) {
        $GRCPlantel = $this->encrypt->decode($idPlantel);
        $GRPeriodo = base64_decode($periodo);
        
        $selectNom = "CPLClave, CPLNombre";
        $this->db->where('CPLClave', $GRCPlantel);
        $data['plantel'] = $this->plantel_model->find_all(null, $selectNom);

        $select = 'COUNT(GRSemestre) noGrupos, GRSemestre';
        $this->db->where('GRCPlantel', $GRCPlantel);
        $this->db->where('GRPeriodo', $GRPeriodo);
        $this->db->group_by('GRSemestre');
        $data['total'] = $this->grupos_model->find_all(null, $select);
        
        foreach ($data['total'] as $key => $listTot) {
            //$select = "GRClave, GRGrupo, GRSemestre, GRCClave, MATSemmat, MATNombre, GRCupo, GRTurno";
            $select = "GRClave, GRGrupo, GRSemestre, CCANombre, CCAAbrev, GRCClave, GRCupo, GRTurno";
            $this->db->join('noccapacitacion', 'CCAClave = GRCClave','left');
            //$this->db->join('nomaterias', 'CCAAbrev = MATAbrev','left');
            if($listTot['GRSemestre'] > 2) {
                $this->db->where('GRSemestre', $listTot['GRSemestre']);
                //$this->db->where('MATSemmat', $listTot['GRSemestre']);
            }
            $this->db->where('GRPeriodo', $GRPeriodo); 
            $this->db->where('GRSemestre', $listTot['GRSemestre']);
            $this->db->where('GRCPlantel', $GRCPlantel);
            $this->db->group_by('GRClave');
            $data['total'][$key]['grupos'] = $this->grupos_model->find_all(null, $select);
        }

        /*echo "<pre align='left'>";
        print_r($data);
        echo "</pre>";
        exit();*/
        
        $this->load->library('Dpdf');
        $data['subvista'] = 'grupos/Ver_pdf_view';
        $data['titulo'] = "<p style='font-size:10px;'><br>COLEGIO DE BACHILLERES DEL ESTADO DE MÉXICO<br><b>DIRECCIÓN ACADÉMICA</b><br> DEPARTAMENTO DE DOCENCIA Y ORIENTACIÓN EDUCATIVA</p>";

        $this->dpdf->load_view('grupos/plantilla_general_pdf',$data);
        $this->dpdf->setPaper('letter', 'portrait');
        $this->dpdf->render();
        $this->dpdf->stream("Grupos.pdf",array("Attachment"=>false));
    }

    public function _set_rules() {
        $this->form_validation->set_rules('GRPeriodo', 'Periodo Escolar', "trim|required|min_length[4]|max_length[4]");
        $this->form_validation->set_rules('GRSemestre', 'Semestre', "trim|required|min_length[1]|max_length[1]");
        $this->form_validation->set_rules('GRGrupo', 'Grupo', "trim|required|min_length[3]|max_length[3]");
        $this->form_validation->set_rules('GRTurno', 'Turno', "trim|required|min_length[1]|max_length[1]");
        $this->form_validation->set_rules('GRCupo', 'No. de Alumnos', "trim|required|min_length[1]|max_length[2]");
    }
}
?>