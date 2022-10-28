<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HorasClase extends CI_Controller {
    public function __construct () {
       parent::__construct();
       if (!is_login()) // Verificamos que el usuario este logeado
            redirect('login');

        if (!is_permitido()) //  Verificamos que el usuario tenga permisos 
            redirect('usuario/negar_acceso');
    }

    public function listaHoras_skip () {
        $data = array();
        $idPlantel = $this->input->post('idPlantel');
        $Periodo = $this->input->post('periodo');

        $data['periodos'] = $Periodo;
        
        $this->db->where('CPLClave',$idPlantel);
        $data['plantel'] = $this->plantel_model->find();
        
        if ($data['plantel']['CPLTipo'] == '35') {
            $GRPlanEst = '1';
        } elseif ($data['plantel']['CPLTipo'] == '36') {
            $GRPlanEst = '2';
        }

        if($data['plantel']['CPLCapDif'] == 'Y') {
            $capdif = 'SUM(hsmDif)';
        } else {
            $capdif = 'SUM(hsm)';
        }
        
        $selectCap = 'GRCPlantel, CCANombre, PCCapacitacion';
        $this->db->join('noplancap','GRCPlantel = PCPlantel');
        $this->db->join('noccapacitacion','PCCapacitacion = CCAClave');
        $this->db->where('PCPlantel', $idPlantel);
        $this->db->where('GRStatus','1');
        $this->db->group_by('PCClave');

        $data['GRPeriodo'] = $this->grupos_model->find_all(null, $selectCap);

        $this->db->select("*,(SELECT $capdif FROM nomaterias WHERE plan_estudio = $GRPlanEst AND semmat = GRSemestre AND (tipo = CCAAbrev  OR tipo ='BAS') )AS thghsm");
        $this->db->from("(SELECT GRSemestre,GRCClave, COUNT(*) AS noGrupos FROM nogrupos WHERE GRCPlantel = $idPlantel AND GRPeriodo = '$Periodo' AND GRStatus = 1 GROUP BY GRSemestre) AS tb1");
        $this->db->join("(SELECT CCAClave, CCAAbrev FROM noplancap INNER JOIN noccapacitacion ON CCAClave = PCCapacitacion WHERE PCPlantel = $idPlantel) AS tb2", "CCAClave = GRCClave", "LEFT");

        $query = $this->db->get();
        $data['periodo'] = $query->result_array();

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

   public function imprimirHoras_skip( $idPlantel = null, $periodo = null) {
        $idPlantel = base64_decode($idPlantel);
        $Periodo = base64_decode($periodo);
        //$idPlantel = $this->encrypt->decode($idPlantel);
        
        $this->db->where('CPLClave',$idPlantel);
        $data['plantel'] = $this->plantel_model->find();

        if ($data['plantel']['CPLTipo'] == '35') {
            $GRPlanEst = '1';
        } elseif ($data['plantel']['CPLTipo'] == '36') {
            $GRPlanEst = '2';
        }
        
        $selectCap = 'GRCPlantel, CCANombre, PCCapacitacion';
        $this->db->join('noplancap','GRCPlantel = PCPlantel');
        $this->db->join('noccapacitacion','PCCapacitacion = CCAClave');
        $this->db->where('PCPlantel', $idPlantel);
        $this->db->where('GRStatus','1');
        $this->db->group_by('PCClave');

        $data['GRPeriodo'] = $this->grupos_model->find_all(null, $selectCap);

        $this->db->select("*,(SELECT SUM(hsm) FROM nomaterias WHERE plan_estudio = $GRPlanEst AND semmat = GRSemestre AND (tipo = CCAAbrev  OR tipo ='BAS') )AS thghsm");
        $this->db->from("(SELECT GRSemestre,GRCClave, COUNT(*) AS noGrupos FROM nogrupos WHERE GRCPlantel = $idPlantel AND GRPeriodo = '$Periodo' AND GRStatus = 1 GROUP BY GRSemestre) AS tb1");
        $this->db->join("(SELECT CCAClave, CCAAbrev FROM noplancap INNER JOIN noccapacitacion ON CCAClave = PCCapacitacion WHERE PCPlantel = $idPlantel) AS tb2", "CCAClave = GRCClave", "LEFT");

        $query = $this->db->get();
        $data['periodo'] = $query->result_array();

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

        $this->db->where('CPLClave', $idPlantel);
        $data['Director'] = $this->plantel_model->find_all();
        $ciclo = "SEMESTRE 20".substr($Periodo,0,2)." ";
        $anio = substr($Periodo,3,1)==1?'(Febrero-Agosto)':'(Agosto-Febrero)';
              
        $this->load->library('Dpdf');
        $data['subvista'] = 'horasClase/Ver_pdf_view';
        $data['titulo'] = "<p style='font-size:11px;'>COLEGIO DE BACHILLERES DEL ESTADO DE MÉXICO<br><b>DIRECCIÓN ACADÉMICA</b><br> DEPARTAMENTO DE DOCENCIA Y ORIENTACIÓN EDUCATIVA<br> <b>PLANTEL Y/O CEMSAD: ". $data['Director'][0]['CPLNombre']."</b><br>".$ciclo.$anio."</p>";        
        
        $this->dpdf->load_view('horasClase/plantilla_general_pdf', $data);
        $this->dpdf->setPaper('letter', 'landscape');
        $this->dpdf->render();
        $this->dpdf->stream("HorasClase.pdf",array("Attachment"=>false));        
    }

    public function verReporte_skip() {
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
                $selectMat = 'GRSemestre, GRTurno, COUNT(GRTurno) TotalTurno';
                $this->db->where('GRCPlantel', $idPlantel);
                $this->db->where('GRSemestre', $list['GRSemestre']);
                $this->db->where('GRTurno', 1);
                $this->db->where('GRStatus',1);
                $this->db->group_by('GRTurno');
                $data['datos'][$key]['turnoMat'] = $this->grupos_model->find_all(null, $selectMat); 
                
                $selectVes = 'GRSemestre, GRTurno, COUNT(GRTurno) TotalTurno';
                $this->db->where('GRCPlantel', $idPlantel);
                $this->db->where('GRSemestre', $list['GRSemestre']);
                $this->db->where('GRTurno', 2);
                $this->db->where('GRStatus',1);
                $this->db->group_by('GRTurno');
                $data['datos'][$key]['turnoVes'] = $this->grupos_model->find_all(null, $selectVes); 

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

    public function imprimirReporte_skip($idPlantel = null, $periodo = null) {
        $idPlantel = base64_decode($idPlantel);
        $GRPeriodo = base64_decode($periodo);
        //$idPlantel = $this->encrypt->decode($idPlantel);

        $data['semestre'] = $GRPeriodo;

        $select = 'COUNT(GRSemestre) noGrupos, GRSemestre';
        $this->db->where('GRCPlantel', $idPlantel);
        $this->db->where('GRPeriodo', $GRPeriodo);
        $this->db->where('GRStatus',1);
        $this->db->group_by('GRSemestre');
        $data['datos'] = $this->grupos_model->find_all(null, $select);
            foreach ($data['datos'] as $key => $list) {
                $selectMat = 'GRSemestre, GRTurno, COUNT(GRTurno) TotalTurno';
                $this->db->where('GRCPlantel', $idPlantel);
                $this->db->where('GRSemestre', $list['GRSemestre']);
                $this->db->where('GRTurno', 1);
                $this->db->where('GRStatus',1);
                $this->db->group_by('GRTurno');
                $data['datos'][$key]['turnoMat'] = $this->grupos_model->find_all(null, $selectMat); 
                
                $selectVes = 'GRSemestre, GRTurno, COUNT(GRTurno) TotalTurno';
                $this->db->where('GRCPlantel', $idPlantel);
                $this->db->where('GRSemestre', $list['GRSemestre']);
                $this->db->where('GRTurno', 2);
                $this->db->where('GRStatus',1);
                $this->db->group_by('GRTurno');
                $data['datos'][$key]['turnoVes'] = $this->grupos_model->find_all(null, $selectVes); 

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
        $ciclo = "SEMESTRE 20".substr($GRPeriodo,0,2)." ";
        $anio = substr($GRPeriodo,3,1)==1?'(Febrero-Agosto)':'(Agosto-Febrero)';

        $this->load->library('Dpdf');
        $data['subvista'] = 'horasClase/Ver_ReportePdf_view';
        $data['titulo'] = "<p style='font-size:11px;'>COLEGIO DE BACHILLERES DEL ESTADO DE MÉXICO<br><b>DIRECCIÓN ACADÉMICA</b><br> DEPARTAMENTO DE DOCENCIA Y ORIENTACIÓN EDUCATIVA<br> <b>PLANTEL Y/O CEMSAD: ". $data['Director'][0]['CPLNombre']."</b><br>".$ciclo.$anio."</p>";

        $this->dpdf->load_view('horasClase/plantilla_general_pdf',$data);
        $this->dpdf->setPaper('letter', 'landscape');
        $this->dpdf->render();
        $this->dpdf->stream("HorasClaseReporte.pdf",array("Attachment"=>false));
    }

}
?>