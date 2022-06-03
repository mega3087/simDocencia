<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Reportes extends CI_Controller {
		function __construct() {
			parent::__construct();
			
			if ( ! is_login() )
				redirect('login');
			
			if ( ! is_permitido())
				redirect('usuario/negar_acceso'); // Verificamos que el usuario tenga el permiso
		}
		
		public function rep_fump($periodo = null){
			
			if(!$periodo){
				$select = array("CPEPeriodo","CONCAT(CPEAnioInicio,'-',CPEMesInicio,'-',CPEDiaInicio) as CPEFecha_inicio","CONCAT(CPEAnioFin,'-',CPEMesFin,'-',CPEDiaFin) as CPEFecha_fin");
				$this->db->where("CURDATE() BETWEEN CONCAT(CPEAnioInicio,'-',CPEMesInicio,'-',CPEDiaInicio) AND CONCAT(CPEAnioFin,'-',CPEMesFin,'-',CPEDiaFin)");
				$where = array('CPEStatus' => 1);
				$data_p = $this->periodos_model->find($where,$select);
			}else{
				$select = array("CPEPeriodo","CONCAT(CPEAnioInicio,'-',CPEMesInicio,'-',CPEDiaInicio) as CPEFecha_inicio","CONCAT(CPEAnioFin,'-',CPEMesFin,'-',CPEDiaFin) as CPEFecha_fin");
				$where = array('CPEStatus' => 1, 'CPEPeriodo' => $periodo);
				$data_p = $this->periodos_model->find($where,$select);
			}
			
			if(!$data_p) exit("<h3><br />¡El periodo no ha sifo creado!</h3>");
			
			$data['periodo'] = $data_p['CPEPeriodo'];
			
			$data['periodos'] = $this->periodos_model->find_all("CPEStatus = '1'",null,"CPEPeriodo DESC");
			
			$where = "(acceptTerms = 'on' OR FAutorizo_1 IS NOT NULL )";
			$this->db->like( "FActivo", 1);
			$this->db->where('FFecha_inicio >=', $data_p['CPEFecha_inicio']);
			$this->db->where('FFecha_termino <=', $data_p['CPEFecha_fin']);
			$data['fump'] = $this->fump_model->find_all($where);
			
			$select = "
			SUM( CASE WHEN acceptTerms = 'on' OR FAutorizo_1 IS NOT NULL THEN 1 ELSE 0 END ) Recibidos, 
			SUM( CASE WHEN acceptTerms = 'on' AND FNivel_autorizacion = 1 THEN 1 ELSE 0 END ) Espera, 
			SUM( CASE WHEN acceptTerms = 'on' AND FNivel_autorizacion BETWEEN 2 AND 6 THEN 1 ELSE 0 END ) Proceso, 
			SUM( CASE WHEN acceptTerms = 'on' AND FNivel_autorizacion >= 7 THEN 1 ELSE 0 END ) Atendidos,
			SUM( CASE WHEN acceptTerms IS NULL THEN 1 ELSE 0 END ) Rechazados  
			";
			$this->db->where('FFecha_inicio >=', $data_p['CPEFecha_inicio']);
			$this->db->where('FFecha_termino <=', $data_p['CPEFecha_fin']);
			$this->db->like( "FActivo", 1);
			$data['fump_graf'] = $this->fump_model->find($where,$select);
			
			$data['titulo'] = "REPORTE DE FUMP";
			$data['modulo'] = $this->router->fetch_method();
			$data['subvista'] = 'reportes/Rep_fump';
			$this->load->view('plantilla_general', $data);
		}
		
	}