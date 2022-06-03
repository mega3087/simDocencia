<?php
	class Modulo_model extends My_Model 
	{
		protected $_table = 'nocmodulo'; 
		protected $primary_key ='CMOClave';
		
		function Modulo_model() 
		{
			parent::__construct();
		}
		
	} // fin de Modulo_model