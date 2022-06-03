<?php
	class Permiso_model extends My_Model 
	{
		protected $_table = 'nocpermiso'; 
		protected $primary_key ='CACClave';
		
		function Permiso_model() 
		{
			parent::__construct();
		}
		
		function join()
		{  
			$this->db->join('nocaccion', 'CPEAccion=CACClave');
			$this->db->join('nocmodulo', 'CACModulo=CMOClave');
			
			return $this;
		} //fin de la funcion join    
	} // fin de Permiso_model
