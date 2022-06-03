<?php
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');

	class Fump_model extends My_Model
	{
		protected $_table = 'nofump';
		protected $primary_key = 'FClave';

		function __construct()
		{
		  parent::__construct();
		}

	}// fin del modelo Fump_model
