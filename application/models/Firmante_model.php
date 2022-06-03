<?php
	class Firmante_model extends My_Model 
	{
		protected $_table = 'nofirmante'; 
		protected $primary_key ='FIClave';
		
		function Firmante_model() 
		{
			parent::__construct();
		}
		
	} // fin de Firmante_model