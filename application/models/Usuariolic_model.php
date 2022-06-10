<?php
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');

	class Usuariolic_model extends My_Model
	{
		protected $_table = 'nousuariolic';
		protected $primary_key = 'ULClave';

		function __construct()
		{
		  parent::__construct();
		}

	}// fin del modelo UsuarioLic_model
