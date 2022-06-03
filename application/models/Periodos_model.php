<?php
	class Periodos_model extends My_Model 
	{
		protected $_table = 'nocperiodos'; 
		protected $primary_key ='CPEClave';
		
		function Periodos_model() 
		{
			parent::__construct();
		}
		
	} // fin de Accion_model