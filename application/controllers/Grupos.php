<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grupos extends CI_Controller {
    public function __construct () {
        parent::__construct();
        if (!is_login()) // Verificamos que el usuario este logeado
            redirect('login');

        if (!is_permitido()) //  Verificamos que el usuario tenga permisos
            redirect('usuario/negar_acceso');
    }

    public function index() {
        $data = array();
        
        $this->db->where('CPLTipo',35);
        $this->db->or_where('CPLTipo',36);
        $this->db->where('CPLActivo',1);
        $this->db->order_by('CPLClave','ASC');
        
        $data["planteles"] = $this->plantel_model->find_all();

        $this->db->where('CPEStatus','1');
        $this->db->order_by('CPEPeriodo','DESC');
        $this->db->limit('10');
        $data['periodos'] = $this->periodos_model->find_all();


        foreach ($data['planteles'] as $key => $listP) {
            $select = 'PCPlantel, PCCapacitacion, CCAClave, CCANombre, CCAAbrev';
            $this->db->join('noplancap', 'CPLClave = PCPlantel','left');
            $this->db->join('noccapacitacion', 'PCCapacitacion = CCAClave','left');
            $this->db->where('PCPlantel',$listP['CPLClave']);
            $data["plan"][$key]['capacitaciones'] = $this->plantel_model->find_all(null,$select);

        }

        $data['modulo'] = $this->router->fetch_class();
        $data['subvista'] = 'grupos/Mostrar_view';

        $this->load->view('plantilla_general', $data);
    }

    public function listaGruposRep() {
        if ( is_permitido(null,'grupos','listaGruposRep') )
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
            $this->db->order_by('GRTurno','ASC');
            $this->db->order_by('GRGrupo','ASC');

            $data['total'][$key]['grupos'] = $this->grupos_model->find_all(null, $select);
        }
        
        $this->load->view('grupos/Mostrar_capacitaciones', $data);

    }

    public function save() {
        if(! $_POST)
            redirect( $this->router->fetch_class() );
                
        $data= post_to_array('_skip');
        
        if ($data['CPESemestre1'] == 1 || $data['CPESemestre1'] == 2) {
            //Grupos Matutino
            if ($data['NoGruposMat1'] != '0') {
                $this->db->where('GRCPlantel',$data['GRCPlantel']);
                $this->db->where('GRPeriodo',$data['CPEPeriodo']);
                $this->db->where('GRTurno',1);
                $this->db->where('GRSemestre',$data['CPESemestre1']);
                $this->db->where('GRStatus',1);
                $contar = $this->grupos_model->find_all();
                                
                for ($i = 1; $i <= $data['NoGruposMat1']; $i++) {
                    $datos['GRCPlantel'] = $data['GRCPlantel'];
                    if ($data['CPLTipo'] == '35') {
                        $datos['GRPMat'] = '7';
                    } elseif ($data['CPLTipo'] == '36') {
                        $datos['GRPMat'] = '9';
                    }

                    $datos['GRPeriodo'] = $data['CPEPeriodo'];
                    $datos['GRSemestre'] = $data['CPESemestre1'];
                    if (count($contar) > '0'){
                        if (count($contar)  >= 10) {
                            $datos['GRGrupo'] = $data['CPESemestre1'].count($contar) + $i; 
                        } else {
                            $datos['GRGrupo'] = $data['CPESemestre1'].'0'.count($contar) + $i; 
                        }
                    } else {
                        if ($i >= 10) {
                            $datos['GRGrupo'] = $data['CPESemestre1'].$i; 
                        } else {
                            $datos['GRGrupo'] = $data['CPESemestre1'].'0'.$i; 
                        }
                    }     

                    $datos['GRTurno'] = '1';
                    $datos['GRStatus'] = "1";
                    $datos['GRFechaRegistro'] = date('Y-m-d H:i:s');
                    $datos['GRUsuarioRegistro'] = get_session('UNCI_usuario');
                        
                    $this->grupos_model->insert($datos);
                }
            }

            //Grupos Vespertino
            if ($data['NoGruposVes1'] != '0') {
                $this->db->where('GRCPlantel',$data['GRCPlantel']);
                $this->db->where('GRPeriodo',$data['CPEPeriodo']);
                $this->db->where('GRTurno',2);
                $this->db->where('GRSemestre',$data['CPESemestre1']);
                $this->db->where('GRStatus',1);
                $contarv = $this->grupos_model->find_all();

                for ($v = 1; $v <= $data['NoGruposVes1']; $v++) {
                    $datos['GRCPlantel'] = $data['GRCPlantel'];
                    if ($data['CPLTipo'] == '35') {
                        $datos['GRPMat'] = '7';
                    } elseif ($data['CPLTipo'] == '36') {
                        $datos['GRPMat'] = '9';
                    }   
    
                    $datos['GRPeriodo'] = $data['CPEPeriodo'];
                    $datos['GRSemestre'] = $data['CPESemestre1'];
                    if (count($contarv) > '0'){
                        if (count($contarv)  >= 10) {
                            $datos['GRGrupo'] = $data['CPESemestre1'].count($contarv) + $v; 
                        } else {
                            $datos['GRGrupo'] = $data['CPESemestre1'].'0'.count($contarv) + $v; 
                        }
                    } else {
                        if ($v >= 10) {
                            $datos['GRGrupo'] = $data['CPESemestre1'].$v; 
                        } else {
                            $datos['GRGrupo'] = $data['CPESemestre1'].'0'.$v; 
                        }
                    }         
                    $datos['GRTurno'] = '2';
                    $datos['GRStatus'] = "1";
                    $datos['GRFechaRegistro'] = date('Y-m-d H:i:s');
                    $datos['GRUsuarioRegistro'] = get_session('UNCI_usuario');
                    
                    $this->grupos_model->insert($datos);  
                }
            }
            
        } 
        
        if ($data['CPESemestre2'] == 3 || $data['CPESemestre2'] == 4) {
            //Grupos Matutino
            if ($data['NoGruposMat2'] != '0') {      
                $this->db->where('GRCPlantel',$data['GRCPlantel']);          
                $this->db->where('GRPeriodo',$data['CPEPeriodo']);
                $this->db->where('GRTurno',1);
                $this->db->where('GRSemestre',$data['CPESemestre2']);
                $this->db->where('GRStatus',1);
                $contar = $this->grupos_model->find_all();
                for ($i = 1; $i <= $data['NoGruposMat2']; $i++) {
                    $datos['GRCPlantel'] = $data['GRCPlantel'];
                    if ($data['CPLTipo'] == '35') {
                        $datos['GRPMat'] = '7';
                    } elseif ($data['CPLTipo'] == '36') {
                        $datos['GRPMat'] = '9';
                    }   

                    $datos['GRPeriodo'] = $data['CPEPeriodo'];
                    $datos['GRSemestre'] = $data['CPESemestre2'];
                    if (count($contar) > '0') {
                        if (count($contar) >= 10) {
                            $datos['GRGrupo'] = $data['CPESemestre2'].count($contar) + $i; 
                        } else {
                            $datos['GRGrupo'] = $data['CPESemestre2'].'0'.count($contar) + $i; 
                        }
                    } else {
                        if ($i >= 10) {
                            $datos['GRGrupo'] = $data['CPESemestre2'].$i; 
                        } else {
                            $datos['GRGrupo'] = $data['CPESemestre2'].'0'.$i; 
                        }
                    } 
                    $datos['GRTurno'] = '1';
                    $datos['GRStatus'] = "1";
                    $datos['GRFechaRegistro'] = date('Y-m-d H:i:s');
                    $datos['GRUsuarioRegistro'] = get_session('UNCI_usuario');                
                    
                    $this->grupos_model->insert($datos);  
                }
            }

            //Grupos Vespertino
            if ($data['NoGruposVes2'] != '0') {
                $this->db->where('GRCPlantel',$data['GRCPlantel']);
                $this->db->where('GRPeriodo',$data['CPEPeriodo']);
                $this->db->where('GRTurno',2);
                $this->db->where('GRSemestre',$data['CPESemestre2']);
                $this->db->where('GRStatus',1);
                $contarv = $this->grupos_model->find_all();
                for ($v = 1; $v <= $data['NoGruposVes2']; $v++) {
                    $datos['GRCPlantel'] = $data['GRCPlantel'];
                    if ($data['CPLTipo'] == '35') {
                        $datos['GRPMat'] = '7';
                    } elseif ($data['CPLTipo'] == '36') {
                        $datos['GRPMat'] = '9';
                    }   
    
                    $datos['GRPeriodo'] = $data['CPEPeriodo'];
                    $datos['GRSemestre'] = $data['CPESemestre2'];
                    if (count($contarv) > '0'){
                        if (count($contarv)  >= 10) {
                            $datos['GRGrupo'] = $data['CPESemestre2'].count($contarv) + $v; 
                        } else {
                            $datos['GRGrupo'] = $data['CPESemestre2'].'0'.count($contarv) + $v; 
                        }
                    } else {
                        if ($v >= 10) {
                            $datos['GRGrupo'] = $data['CPESemestre2'].$v; 
                        } else {
                            $datos['GRGrupo'] = $data['CPESemestre2'].'0'.$v; 
                        }
                    }
                    $datos['GRTurno'] = '2';
                    $datos['GRStatus'] = "1";
                    $datos['GRFechaRegistro'] = date('Y-m-d H:i:s');
                    $datos['GRUsuarioRegistro'] = get_session('UNCI_usuario');

                    $this->grupos_model->insert($datos);  
                }
            }
        } 

        if ($data['CPESemestre3'] == 5 || $data['CPESemestre3'] == 6) {
            //Grupos Matutino
            if ($data['NoGruposMat3'] != '0') {
                $this->db->where('GRCPlantel',$data['GRCPlantel']);
                $this->db->where('GRPeriodo',$data['CPEPeriodo']);
                $this->db->where('GRTurno',1);
                $this->db->where('GRSemestre',$data['CPESemestre3']);
                $this->db->where('GRStatus',1);
                $contar = $this->grupos_model->find_all();
                
                for ($i = 1; $i <= $data['NoGruposMat3']; $i++) {
                    $datos['GRCPlantel'] = $data['GRCPlantel'];
                    if ($data['CPLTipo'] == '35') {
                        $datos['GRPMat'] = '7';
                    } elseif ($data['CPLTipo'] == '36') {
                        $datos['GRPMat'] = '9';
                    }   
    
                    $datos['GRPeriodo'] = $data['CPEPeriodo'];
                    $datos['GRSemestre'] = $data['CPESemestre3'];
                    if (count($contar) > '0') {
                        if (count($contar)  >= 10) {
                            $datos['GRGrupo'] = $data['CPESemestre3'].count($contar) + $i; 
                        } else {
                            $datos['GRGrupo'] = $data['CPESemestre3'].'0'.count($contar) + $i; 
                        }
                    } else {
                        if ($i >= 10) {
                            $datos['GRGrupo'] = $data['CPESemestre3'].$i; 
                        } else {
                            $datos['GRGrupo'] = $data['CPESemestre3'].'0'.$i; 
                        }
                    }           
                    $datos['GRTurno'] = '1';
                    $datos['GRStatus'] = "1";
                    $datos['GRFechaRegistro'] = date('Y-m-d H:i:s');
                    $datos['GRUsuarioRegistro'] = get_session('UNCI_usuario');   
                    
                    $this->grupos_model->insert($datos);  
                }
            }

            //Grupos Vespertino
            if ($data['NoGruposVes3'] != '0') { 
                
                $this->db->where('GRPeriodo',$data['CPEPeriodo']);
                $this->db->where('GRTurno',2);
                $this->db->where('GRSemestre',$data['CPESemestre3']);
                $this->db->where('GRStatus',1);
                $contarv = $this->grupos_model->find_all();

                for ($v = 1; $v <= $data['NoGruposVes3']; $v++) {
                    $datos['GRCPlantel'] = $data['GRCPlantel'];
                    if ($data['CPLTipo'] == '35') {
                        $datos['GRPMat'] = '7';
                    } elseif ($data['CPLTipo'] == '36') {
                        $datos['GRPMat'] = '9';
                    }   
    
                    $datos['GRPeriodo'] = $data['CPEPeriodo'];
                    $datos['GRSemestre'] = $data['CPESemestre3'];
                    if (count($contarv) > '0'){
                        if (count($contarv)  >= 10) {
                            $datos['GRGrupo'] = $data['CPESemestre3'].count($contarv) + $v; 
                        } else {
                            $datos['GRGrupo'] = $data['CPESemestre3'].'0'.count($contarv) + $v; 
                        }
                    } else {
                        if ($v >= 10) {
                            $datos['GRGrupo'] = $data['CPESemestre3'].$v; 
                        } else {
                            $datos['GRGrupo'] = $data['CPESemestre3'].'0'.$v; 
                        }
                    }           
                    $datos['GRTurno'] = '2';
                    $datos['GRStatus'] = "1";
                    $datos['GRFechaRegistro'] = date('Y-m-d H:i:s');
                    $datos['GRUsuarioRegistro'] = get_session('UNCI_usuario');

                    $this->grupos_model->insert($datos);  
                }
            }            

            set_mensaje("Los Grupos se Agregar??n Correctamente",'success::');
            echo "OK;";
            muestra_mensaje();
        }
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
        set_mensaje("EL grupo se elimino con ??xito",'success::');
        muestra_mensaje();
        
        $GRCPlantel = $this->input->post('PlantelId');
        $this->db->where('GRCPlantel',$GRCPlantel);
        $this->db->where('GRStatus','1');
        $data['data'] = $this->grupos_model->find_all();            
        $this->load->view('grupos/Mostrar_grupos', $data);

    }

    public function listaGrupos() {
        $data = array();
        if ( is_permitido(null,'grupos','listaGrupos') )

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
            $this->db->order_by('GRTurno','ASC');
            $this->db->order_by('GRGrupo','ASC');
            $data['total'][$key]['grupos'] = $this->grupos_model->find_all(null, $select);
        }

        $select = 'PCPlantel, PCCapacitacion, CCAClave, CCANombre, CCAAbrev';
        $this->db->join('noplancap', 'CPLClave = PCPlantel','left');
        $this->db->join('noccapacitacion', 'PCCapacitacion = CCAClave','left');
        $this->db->where('PCPlantel',$GRCPlantel);
        $data['capacitaciones'] = $this->plantel_model->find_all(null,$select);
        
        $this->load->view('grupos/Mostrar_periodo_grupos', $data);
    }

    public function saveCapAlumnos() {
        $data= post_to_array('_skip');
        foreach($data as $k  => $val){
            $datos = array( 
                'GRCClave' => $val[0],
                'GRCupo' => $val[1],
            );
            $this->grupos_model->update($k,$datos);
        }
        
        set_mensaje("Los Grupos se Agregar??n Correctamente",'success::');
        echo "OK;";
        muestra_mensaje();
    }

    public function ImprimirGrupos($idPlantel = null, $periodo = null) {
        $idPlantel = base64_decode($idPlantel);
        $GRPeriodo = base64_decode($periodo);
        //$GRCPlantel = $this->encrypt->decode($idPlantel);
        
        $selectNom = "CPLClave, CPLNombre";
        $this->db->where('CPLClave', $idPlantel);
        $data['plantel'] = $this->plantel_model->find_all(null, $selectNom);

        $select = 'COUNT(GRSemestre) noGrupos, GRSemestre';
        $this->db->where('GRCPlantel', $idPlantel);
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
            $this->db->where('GRCPlantel', $idPlantel);
            $this->db->order_by('GRTurno','ASC');
            $this->db->order_by('GRGrupo','ASC');
            $data['total'][$key]['grupos'] = $this->grupos_model->find_all(null, $select);
        }

        $this->load->library('Dpdf');
        $data['subvista'] = 'grupos/Ver_pdf_view';
        $data['titulo'] = "<p style='font-size:10px;'><br>COLEGIO DE BACHILLERES DEL ESTADO DE M??XICO<br><b>DIRECCI??N ACAD??MICA</b><br> DEPARTAMENTO DE DOCENCIA Y ORIENTACI??N EDUCATIVA</p>";

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