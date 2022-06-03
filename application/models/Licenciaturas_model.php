<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class Licenciaturas_model extends My_Model
	{
		protected $_table = 'nolicenciaturas';
		protected $primary_key = 'IdLicenciarura';

		function __construct()
		{
		  parent::__construct();
		}

	}// fin del modelo Licenciaturas_model
