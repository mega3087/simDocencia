<?php
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');

	class TipoPersonal_model extends My_Model
	{
		protected $_table = 'noctipopersonal';
		protected $primary_key = 'TPClave';

		function __construct()
		{
		  parent::__construct();
		}

	}// fin del modelo TipoPersonal_models
