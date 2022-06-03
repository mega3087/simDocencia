<?php
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');

	class Plantilla_model extends My_Model
	{
		protected $_table = 'noplantilla';
		protected $primary_key = 'PClave';

		function __construct()
		{
		  parent::__construct();
		}

	}// fin del modelo Plantilla_model
