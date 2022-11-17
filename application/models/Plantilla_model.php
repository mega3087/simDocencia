<?php
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');

	class Plantilla_model extends My_Model
	{
		protected $_table = 'noplantilla';
		protected $primary_key = 'PClave';

		function __construct()
		{
		  parent::__construct();
		}
		
		/**
		* Consulta y genera la plantilla del periodo actual
		*
		* @param int $idPlantel
		* @return varchar
		*/		
		function plantilla_actual($idPlantel = null){
			//var
			$periodo = periodo();
			
			if(!$idPlantel) return false;
			
			$where = array(
				"PPeriodo" => $periodo['PEPeriodo'],
				"PPlantel" => $idPlantel
			);
			$this->db->where("PEstatus IN('Pendiente','Revisión')");
			$this->db->where("PActivo","1");
			$this->db->order_by('PClave', 'DESC');
			$plantilla = $this->plantilla_model->find($where);
			
			if(!$plantilla){
				$dataPlantilla = array(
					"PPeriodo" => $periodo['PEPeriodo'],
					"PPlantel" => $idPlantel,
					"PFechaInicial" => $periodo['PEFecha_inicial'],
					"PFechaFinal" => $periodo['PEFecha_final'],
					"PUsuario_registro" => get_session('UNCI_usuario')
				);
				$idPlantilla = $this->plantilla_model->insert($dataPlantilla);
			}else{
				$idPlantilla = $plantilla['PClave'];
			}
			
			return $idPlantilla;
		}

	}// fin del modelo Plantilla_model
