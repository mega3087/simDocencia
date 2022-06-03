<?php
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');

	class Archivo_model extends My_Model
	{
		protected $_table = 'noarchivo';
		protected $primary_key = 'AClave';

		function __construct()
		{
		  parent::__construct();
		}

	}// fin del modelo Archivo_model
