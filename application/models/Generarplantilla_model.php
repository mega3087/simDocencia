<?php
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');

	class Generarplantilla_model extends My_Model
	{
		protected $_table = 'noplantillafinal';
		protected $primary_key = 'idPlantilla';

		function __construct()
		{
		  parent::__construct();
		}

	}// fin del modelo Generarplantilla_model
