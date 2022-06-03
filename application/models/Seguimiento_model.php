<?php
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');

	class Seguimiento_model extends My_Model
	{
		protected $_table = 'noseguimiento';
		protected $primary_key = 'SEClave';

		function __construct()
		{
		  parent::__construct();
		}

	}// fin del modelo Seguimiento_model
