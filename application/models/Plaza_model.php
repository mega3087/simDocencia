<?php
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');

	class Plaza_model extends My_Model
	{
		protected $_table = 'noplaza';
		protected $primary_key = 'PLClave';

		function __construct()
		{
		  parent::__construct();
		}

	}// fin del modelo Plaza_model
