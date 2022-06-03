<?php
	class Perded_model extends My_Model 
	{
		protected $_table = 'noperded'; 
		protected $primary_key ='PDClave';
		
		function Perded_model() 
		{
			parent::__construct();
		}
		
	} // fin de Perded_model