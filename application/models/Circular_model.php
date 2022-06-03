<?php
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');

	class Circular_model extends My_Model
	{
		protected $_table = 'nocircular';
		protected $primary_key = 'CIClave';

		function __construct()
		{
		  parent::__construct();
		}

	}// fin del modelo Circular_model
