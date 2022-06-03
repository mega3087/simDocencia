<?php
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');

	class Usuario_model extends My_Model
	{
		protected $_table = 'nousuario';
		protected $primary_key = 'UNCI_usuario';

		function __construct()
		{
		  parent::__construct();
		}

	}// fin del modelo Usuario_model
