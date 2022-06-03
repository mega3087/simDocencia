<?php
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');

	class Config_model extends My_Model
	{
		protected $_table = 'noconfig';
		protected $primary_key = 'COClave';

		function __construct()
		{
		  parent::__construct();
		}

	}// fin del modelo Config_model
