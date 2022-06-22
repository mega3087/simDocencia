<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HorasClase extends CI_Controller {
    public function __contruct () {
       parent::__contruct();
       if (!is_login()) // Verificamos que el usuario este logeado
            redirect('login');

        if (!is_permitido()) //  Verificamos que el usuario tenga permisos 
            redirect('usuario/negar_acceso');
    }

    public function index() {
        $data = array();

        if(!is_permitido(null,'docente','ver_planteles')){
            $this->db->where('CPLClave',get_session('UPlantel'));
        }
        
        /*if( is_permitido(null,'horasClase','ver_horarios') ) {
				
        } else if( is_permitido(null,'horasClase','ver_horarios_plantel')) {
            $this->db->join('nousuario', 'UPlantel = CPLClave', 'left');
            $this->db->where('UNCI_usuario',get_session('UNCI_usuario'));
        }*/

        $this->db->where('CPLTipo!= 37');
        $data["planteles"] = $this->plantel_model->find_all();

        foreach ($data['planteles'] as $plantel => $listPlan) {
            $select = 'CPLClave, PCCapacitacion, CCAClave, CCANombre, CCAAbrev';
            $this->db->join('noplancap', 'CPLClave = PCPlantel','left');
            $this->db->join('noccapacitacion', 'PCCapacitacion = CCAClave','left');
            $this->db->where('CPLClave', $listPlan['CPLClave']);
            $data['planteles'][$plantel]['modulos'] = $this->plantel_model->find_all(null,$select);
            
        }

        $this->db->where('CPEStatus','1');
        $data['periodos'] = $this->periodos_model->find_all();
        
        $data['modulo'] = $this->router->fetch_class();
        $data['subvista'] = 'horasClase/Mostrar_view';
        $this->load->view('plantilla_general', $data);
    }

    public function listaHoras () {
        $data = array();
        $idPlantel = $this->input->post('idPlantel');
        $Periodo = $this->input->post('periodo');

        $selectCap = 'GRCPlantel, CCANombre, PCCapacitacion';
        $this->db->join('noplancap','GRCPlantel = PCPlantel');
        $this->db->join('noccapacitacion','PCCapacitacion = CCAClave');
        $this->db->where('PCPlantel', $idPlantel);
        $this->db->where('GRStatus','1');
        $this->db->group_by('PCClave');

        $data['GRPeriodo'] = $this->grupos_model->find_all(null, $selectCap);

        $select = 'COUNT(GRSemestre) noGrupos, GRSemestre';
        $this->db->where('GRCPlantel', $idPlantel);
        $this->db->where('GRPeriodo', $Periodo);
        $this->db->where('GRStatus','1');
        $this->db->group_by('GRSemestre');
        $data['periodo'] = $this->grupos_model->find_all(null, $select);

        foreach ($data['periodo'] as $key => $listPer) {
            foreach ($data['GRPeriodo'] as $y => $cap) {
                $selectG = 'GRCClave, CCANombre, COUNT(GRCClave) noGrup';
                $this->db->join('noccapacitacion','GRCClave = CCAClave');
                $this->db->where('GRCPlantel', $idPlantel);
                $this->db->where('GRSemestre', $listPer['GRSemestre']);
                $this->db->where('GRStatus','1');
                $this->db->where('GRCClave',$cap['PCCapacitacion']);
                
                $data['periodo'][$key]['grupos'][$y] = $this->grupos_model->find_all(null, $selectG);
            }
        }

        $this->load->view('horasClase/Mostrar_horas', $data);
    }

   public function imprimirHoras( $idPlantel = null, $periodo = null) {

        $idPlantel = $this->encrypt->decode($idPlantel);
        $Periodo = base64_decode($periodo);

        $selectNom = "CPLClave, CPLNombre";
        $this->db->where('CPLClave', $idPlantel);
        $data['plantel'] = $this->plantel_model->find_all(null, $selectNom);
        
        $selectCap = 'GRCPlantel, CCANombre, PCCapacitacion';
        $this->db->join('noplancap','GRCPlantel = PCPlantel');
        $this->db->join('noccapacitacion','PCCapacitacion = CCAClave');
        $this->db->where('PCPlantel', $idPlantel);
        $this->db->where('GRStatus','1');
        $this->db->group_by('PCClave');

        $data['GRPeriodo'] = $this->grupos_model->find_all(null, $selectCap);

        $select = 'COUNT(GRSemestre) noGrupos, GRSemestre';
        $this->db->where('GRCPlantel', $idPlantel);
        $this->db->where('GRPeriodo', $Periodo);
        $this->db->where('GRStatus','1');
        $this->db->group_by('GRSemestre');
        $data['periodo'] = $this->grupos_model->find_all(null, $select);

        foreach ($data['periodo'] as $key => $listPer) {
            foreach ($data['GRPeriodo'] as $y => $cap) {
                $selectG = 'GRCClave, CCANombre, COUNT(GRCClave) noGrup';
                $this->db->join('noccapacitacion','GRCClave = CCAClave');
                $this->db->where('GRCPlantel', $idPlantel);
                $this->db->where('GRSemestre', $listPer['GRSemestre']);
                $this->db->where('GRStatus','1');
                $this->db->where('GRCClave',$cap['PCCapacitacion']);
                
                $data['periodo'][$key]['grupos'][$y] = $this->grupos_model->find_all(null, $selectG);
            }
        }
              
        $this->load->library('dpdf');
        $data['subvista'] = 'horasClase/Ver_pdf_view';
        
        $this->dpdf->load_view('horasClase/plantilla_general_pdf', $data);
        $this->dpdf->setPaper('letter', 'landscape');
        $this->dpdf->render();
        $this->dpdf->stream("HorasClase.pdf",array("Attachment"=>false));
    }

    public function verReporte() {
        $data = array();
        $GRPeriodo = $this->input->post('periodo');
        $idPlantel = $this->input->post('idPlantel');
        $data['semestre'] = $this->input->post('periodo');

        $select = 'COUNT(GRSemestre) noGrupos, GRSemestre';
        $this->db->where('GRCPlantel', $idPlantel);
        $this->db->where('GRPeriodo', $GRPeriodo);
        $this->db->where('GRStatus',1);
        $this->db->group_by('GRSemestre');
        $data['datos'] = $this->grupos_model->find_all(null, $select);
            foreach ($data['datos'] as $key => $list) {
                $selectT = 'GRSemestre, GRTurno, COUNT(GRTurno) TotalTurno';
                $this->db->where('GRCPlantel', $idPlantel);
                $this->db->where('GRSemestre', $list['GRSemestre']);
                $this->db->where('GRStatus',1);
                $this->db->group_by('GRTurno');
                $data['datos'][$key]['turnos'] = $this->grupos_model->find_all(null, $selectT); 

                $selectCap = 'GRCPlantel, CCAClave, CCANombre';
                $this->db->join('noplancap','GRCPlantel = PCPlantel');
                $this->db->join('noccapacitacion','PCCapacitacion = CCAClave');
                $this->db->where('PCPlantel', $idPlantel);
                $this->db->group_by('PCClave');

                $data['datos'][$key]['Capacitaciones'] = $this->grupos_model->find_all(null, $selectCap);

                foreach ($data['datos'][$key]['Capacitaciones'] as $k => $cap) {
                $selectG = 'GRCClave, GRSemestre, COUNT(GRSemestre) totCap';
                $this->db->where('GRCClave', $cap['CCAClave']);
                $this->db->where('GRCPlantel', $idPlantel);
                $this->db->where('GRPeriodo', $GRPeriodo);
                $this->db->where('GRSemestre', $list['GRSemestre']);
                $this->db->where('GRStatus',1);
                $this->db->group_by('GRSemestre');
                $data['datos'][$key]['Capacitaciones'][$k]['totalCap'] = $this->grupos_model->find_all(null, $selectG);

            }
        }

        $selectCap = 'GRCPlantel, CCAClave, CCANombre, CCAAbrev';
        $this->db->join('noplancap','GRCPlantel = PCPlantel');
        $this->db->join('noccapacitacion','PCCapacitacion = CCAClave');
        $this->db->where('PCPlantel', $idPlantel);
        $this->db->group_by('PCClave');

        $data['Capacitaciones'] = $this->grupos_model->find_all(null, $selectCap);
        
        $this->load->view('horasClase/Mostrar_reporte', $data);
    }

    public function imprimirReporte($idPlantel = null, $periodo = null) {
        $idPlantel = $this->encrypt->decode($idPlantel);
        $GRPeriodo = base64_decode($periodo);

        $data['semestre'] = $GRPeriodo;

        $select = 'COUNT(GRSemestre) noGrupos, GRSemestre';
        $this->db->where('GRCPlantel', $idPlantel);
        $this->db->where('GRPeriodo', $GRPeriodo);
        $this->db->where('GRStatus',1);
        $this->db->group_by('GRSemestre');
        $data['datos'] = $this->grupos_model->find_all(null, $select);
            foreach ($data['datos'] as $key => $list) {
                $selectT = 'GRSemestre, GRTurno, COUNT(GRTurno) TotalTurno';
                $this->db->where('GRCPlantel', $idPlantel);
                $this->db->where('GRSemestre', $list['GRSemestre']);
                $this->db->where('GRStatus',1);
                $this->db->group_by('GRTurno');
                $data['datos'][$key]['turnos'] = $this->grupos_model->find_all(null, $selectT); 

                $selectCap = 'GRCPlantel, CCAClave, CCANombre';
                $this->db->join('noplancap','GRCPlantel = PCPlantel');
                $this->db->join('noccapacitacion','PCCapacitacion = CCAClave');
                $this->db->where('PCPlantel', $idPlantel);
                $this->db->group_by('PCClave');

                $data['datos'][$key]['Capacitaciones'] = $this->grupos_model->find_all(null, $selectCap);

                foreach ($data['datos'][$key]['Capacitaciones'] as $k => $cap) {
                $selectG = 'GRCClave, GRSemestre, COUNT(GRSemestre) totCap';
                $this->db->where('GRCClave', $cap['CCAClave']);
                $this->db->where('GRCPlantel', $idPlantel);
                $this->db->where('GRPeriodo', $GRPeriodo);
                $this->db->where('GRSemestre', $list['GRSemestre']);
                $this->db->where('GRStatus',1);
                $this->db->group_by('GRSemestre');
                $data['datos'][$key]['Capacitaciones'][$k]['totalCap'] = $this->grupos_model->find_all(null, $selectG);

            }
        }

        $selectCap = 'GRCPlantel, CCAClave, CCANombre, CCAAbrev';
        $this->db->join('noplancap','GRCPlantel = PCPlantel');
        $this->db->join('noccapacitacion','PCCapacitacion = CCAClave');
        $this->db->where('PCPlantel', $idPlantel);
        $this->db->group_by('PCClave');
        $data['Capacitaciones'] = $this->grupos_model->find_all(null, $selectCap);

        $this->db->where('CPLClave', $idPlantel);
        $data['Director'] = $this->plantel_model->find_all();

        $this->load->library('dpdf');
        $data['subvista'] = 'horasClase/Ver_ReportePdf_view';
        $data['titulo'] = "<br><b>COLEGIO DE BACHILLERES DEL ESTADO DE MÉXICO<br>DIRECCIÓN ACADÉMICA<br> DEPARTAMENTO DE DOCENCIA Y ORIENTACIÓN EDUCATIVA<br> PLANTEL: ". $data['Director'][0]['CPLNombre'] ."</b>";

        $this->dpdf->load_view('horasClase/plantilla_general_pdf',$data);
        $this->dpdf->setPaper('letter', 'landscape');
        $this->dpdf->render();
        $this->dpdf->stream("HorasClaseReporte.pdf",array("Attachment"=>false));
    }

}
?>