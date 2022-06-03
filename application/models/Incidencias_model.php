<?php
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');

	class Incidencias_model extends My_Model
	{
		protected $_table = 'noincidencias';
		protected $primary_key = 'IClave';

		function __construct()
		{
		  parent::__construct();
		}

	}// fin del modelo Incidencias_model
