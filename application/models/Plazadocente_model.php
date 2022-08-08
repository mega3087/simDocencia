<?php
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');

	class Plazadocente_model extends My_Model
	{
		protected $_table = 'noplazadocente';
		protected $primary_key = 'idplaza';

		function __construct()
		{
		  parent::__construct();
		}

	}// fin del modelo PlazaDocente_model

