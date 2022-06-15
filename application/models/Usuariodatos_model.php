<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

	class UsuarioDatos_model extends My_Model
	{
		protected $_table = 'nousuariodatos';
		protected $primary_key = 'UDClave';

		function __construct()
		{
		  parent::__construct();
		}

	}// fin del modelo UsuarioDatos_models
?>