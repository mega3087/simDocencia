<?php
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');

	class Plantillabitacora_model extends My_Model
	{
		protected $_table = 'noplantillabitacora';
		protected $primary_key = 'idPBitacora';

		function __construct()
		{
		  parent::__construct();
		}

	}// fin del modelo Plantillabitacora_model_model
