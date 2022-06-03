<?php
	class Plantel_model extends My_Model 
	{
		protected $_table = 'noplanteles'; 
		protected $primary_key ='CPLClave';
		
		function Plantel_model()  
		{
			parent::__construct();
		}
		
	} // fin de Plantel_model