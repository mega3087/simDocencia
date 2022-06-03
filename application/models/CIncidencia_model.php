<?php
	class CIncidencia_model extends My_Model 
	{
		protected $_table = 'nocincidencia'; 
		protected $primary_key ='CIClave';
		
		function CIncidencia_model() 
		{
			parent::__construct();
		}
		
	} // fin de CIncidencia_model