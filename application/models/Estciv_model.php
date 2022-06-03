<?php
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');

	class Estciv_model extends My_Model
	{
		protected $_table = 'noestciv';
		protected $primary_key = 'ECClave';

		function __construct()
		{
		  parent::__construct();
		}

	}// fin del modelo Estciv_model
