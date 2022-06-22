<?php
    class Grupos_model extends My_Model 
    {
        protected $_table = 'nogrupos'; 
        protected $primary_key ='GRClave';
        
        function Grupos_model() 
        {
            parent::__construct();
        }
        
    } // fin de Accion_model