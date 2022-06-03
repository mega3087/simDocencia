<?php
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');

	class Docper_model extends My_Model
	{
		protected $_table = 'nodocper';
		protected $primary_key = 'DPClave';

		function __construct()
		{
		  parent::__construct();
		}

	}// fin del modelo Docper_model
