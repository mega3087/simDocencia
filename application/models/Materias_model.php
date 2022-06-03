<?php
	class Materias_model extends My_Model 
	{
		protected $_table = 'nomaterias'; 
		protected $primary_key ='MATClave';
		
		function Materias_model() 
		{
			parent::__construct();
		}
		
	} // fin de Materias_model