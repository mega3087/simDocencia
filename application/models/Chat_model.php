<?php
	class Chat_model extends My_Model 
	{
		protected $_table = 'nochat'; 
		protected $primary_key ='CHClave';
		
		function Chat_model() 
		{
			parent::__construct();
		}
		
	} // fin de Rol_model