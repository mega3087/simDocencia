<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

	class UsuarioDatos_model extends My_Model
	{
		protected $_table = 'nousuariodatos';
		protected $primary_key = 'UDClave';

		function __construct()
		{
		  parent::__construct();
		}
		
		/**
		* Consulta de docentes para asignar materias a la plantilla del periodo actual
		* Solo docentes con Nombramientos Permanente
		*
		* @param int $idPlantel
		* @param int $idTipoNombramiento
		* @param char $permanente Y/T
		* @return array
		*/		
		function nombramientos($idPlantel = null, $idTipoNombramiento = null, $permanente = 'T'){
			//var
			$periodo = periodo();
			$result = array();
			$idPlantilla = $this->plantilla_model->plantilla_actual($idPlantel);
			
			
			$select = "
				UNCI_usuario, UClave_servidor, UApellido_pat, UNombre, UApellido_mat, 
				UFecha_nacimiento, UCorreo_electronico, URFC, UCURP, UClave_elector, 
				UDomicilio, UColonia, UMunicipio, UCP, UTelefono_movil, UTelefono_casa, 
				ULugar_nacimiento, UEstado_civil, USexo, UEscolaridad, UPlantel, 
				UEstado, UDClave, UDUsuario, UDPlantel, UDTipo_Nombramiento, UDValidado,
				SUM(IF(UDTipo_Nombramiento IN (1,2,3,4), 1, 0)) AS num,
				SUM(UDHoras_grupo)+SUM(UDHoras_apoyo)+SUM(UDHoras_CB)+SUM(UDHoras_provicionales) AS HorasTot,
				(SELECT SUM(ptotalHoras) FROM noplantilladetalle WHERE idPUsuario = UDUsuario) AS HorasAsig
			";
			if($permanente=='Y'){
				$this->db->where("UDPermanente","Y");
			}else{
				$this->db->where(" (UDPermanente = 'Y' OR (UDPermanente != 'Y' AND UDPlantilla=$idPlantilla)) ");
			}
			
			if($idTipoNombramiento){
				$this->db->where("UDTipo_Nombramiento IN($idTipoNombramiento,5,6,7,8)"); 
			}
			
			$this->db->where("UDPlantel", $idPlantel);
			$this->db->where("FIND_IN_SET ('$idPlantel',UPlantel)");
			$this->db->join("nousuariodatos", "UNCI_usuario = UDUsuario", "INNER");
			$this->db->group_by("UDUsuario", "DESC");
			$this->db->having("num > 0");
			$this->db->order_by("UApellido_pat ASC, UApellido_mat, UApellido_mat");
			$result = $this->usuario_model->find_all(null,$select);
			
			return $result;
		}

	}// fin del modelo UsuarioDatos_models
?>